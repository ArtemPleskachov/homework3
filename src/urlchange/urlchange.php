<?php
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

    /**
     * @param Validator $validator
     * @param string $filePathStorage
     */
    public function __construct(Validator $validator, string $filePathStorage)
    {
        $this->validator = $validator; //підключення класу Validator для валідації файлу.
        $this->filePathStorage = $filePathStorage; //файл з шляхом до файлу нашої так званної  БД
        $this->getDataStorageFromFile(); // функуцію яку повиині виконати для розкодування нашого коду
    }


    protected function getDataStorageFromFile()
    {
        // отримання і декодування json в $dataStorage
        // просто розкодовуємо json_decode($jsonobj, true)) щось типу таке зробити
    }

    public function decode(string $code): string
    {
        return $this->dataStorage[$code]; //умова контратку, не змінюється. Ми повертаємо масив з ключом $code
    }

    /**
     * @param string $url
     * @return string
     */
    public function encode(string $url): string
    {
        $this->validator->validate($url);
        $code = array_search($url, $this->dataStorage);
        if ($code == false) {
            $code = $this->generateCode($url);
        }
        return $code;
    }

    protected function generateCode(string $url): string
    {
        $code = rand(1000000, 9999999); // інший алгоритм скорочення
        $this->dataStorage[$code] = $url; // вирішив поки розібратись з Json та __DIR__ та й з ООП в цілому. Що як куди передається і т.д.
        return $code; //дуже багато часу втратив з цим дз, тепер треба повторити все включаюи autoload та composer
    }

    protected function saveStorageInFile(string $filePathStorage)
    {
        $file = fopen($this->filePathStorage, 'W+');
        fwrite($file, $filePathStorage);
        fclose($file);
        // реалізувати логіку збереження $this->dataStorage
        // $this->dataStorage потрібно перетворити в JSON
    }

    public function __destruct()
    {
        $this->saveStorageInFile(json_encode($this->$filePathStorage));
    }
}

$filePathStorage = __DIR__ . '/../../storage/db.json';

$validator = new Validator();
$converter = new Converter($validator, '$filePathStorage');



$url = 'https://google.com/';
$code = $converter->encode($url);
$code2 = $converter->encode('https://github.com/ArtemPleskachov/homework3');
$code3 = $converter->encode('https://www.w3schools.com/php/filter_validate_url.asp');

$url2 = $converter->decode($code);



exit;