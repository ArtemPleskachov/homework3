<?php

use Training\urlchange\interfaces\IUrlDecoder;
use Training\urlchange\interfaces\IUrlEncoder;

require_once 'src/urlchange/interfaces/IUrlDecoder.php';
require_once 'src/urlchange/interfaces/IUrlEncoder.php';

class Validator
{
    public function validate(string $url): bool
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)
            || false === $this->checkRealAddress($url)) {
            throw new \InvalidArgumentException('Url is Broke');
        }
        return true;
    }

    protected function checkRealAddress(string $url): bool
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($response === 200 || $response === 301);
    }
}
class Converter implements IUrlEncoder, IUrlDecoder
{
    protected array $dataStorage = [];
    protected Validator $validator;
    protected string $filePathStorage;
    protected array $db = [];




    public function __construct(Validator $validator, string $filePathStorage)
    {
        $this->validator = $validator;
        $this->filePathStorage = $filePathStorage;
        $this->getDataStorageFromFile();

    }


    protected function getDataStorageFromFile()
    {
        // отримання і декодування json в $dataStorage
    }

    public function decode(string $code): string
    {
        return $this->dataStorage[$code];
    }

    public function encode(string $url): string
    {
        $this->validator->validate($url); //запам'ятати як ми звертаємось до іншого класу
        $code = array_search($url, $this->dataStorage);
        if ($code == false) {
            $code = $this->generateCode($url);
        }
        return $code;
    }

    protected function generateCode(string $url) : string
    {
        $code = rand(1000000, 9999999); // інший алгоритм скорочення - реалізую після того як розберусь с JSON
        $this->dataStorage[$code] = $url; // створення масиву для зберігання данних
        return $code;
    }

    protected function saveStorageInFile($code)
    {

        $this->dataStorage = json_encode($code);
        // реалізувати логіку збереження $this->dataStorage
        // $this->dataStorage потрібно перетворити в JSON
    }

    public function __destruct()
    {
        $this->saveStorageInFile();
    }
}

$validator = new Validator(); // Створюю об'єкт Валідатор
$converter = new \Training\urlchange\Converter($validator, ''); //Свтроюєм об'єкт Конвектор і в нього погружаємо об'єкт Валідатор


$code = $converter->encode('https://google.com/'); //За допомогою -> передаємо у метод encode наш URL
$code2 = $converter->encode('https://github.com/ArtemPleskachov/homework3');
$code3 = $converter->encode('https://www.w3schools.com/php/filter_validate_url.asp');

$url2 = $converter->decode($code); //це для розкудування.







exit;