<?php
use PhpPro\Programa\FileRepository;
use PhpPro\Programa\UrlConverter;

require_once 'autoload.php';

//Створюємо конфігуратор, для вказання шляху збереження
//та завдаємо параметри для кодування
$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'codeLength' => 10,
];



$repo = new FileRepository($config['dbFile']);
$converter = new UrlConverter($repo, $config['codeLength'] );


$url = 'https://google.com/';
$code = $converter->encode($url);// Видасть 'C4n3WSZ8be'
$url = $converter->decode('C4n3WSZ8be');


$a = 1;

// Тут створити об'єкти для роботи
// Якщо все вийде, то винести валідацію в окремий об'єкт


//тут будемо виклаикати програму
