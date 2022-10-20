<?php
use Pleskachov\PhpPro\Programa\FileRepository;
use Pleskachov\PhpPro\Programa\UrlConverter;
use Pleskachov\PhpPro\Programa\Utility\UrlValidator;


require_once 'vendor/autoload.php';

$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'codeLength' => 10,
];


$urlValidator = new UrlValidator();
$repo = new FileRepository($config['dbFile']);
$converter = new UrlConverter($repo, $urlValidator, $config['codeLength'] );


$url = 'https://google.com/';
$code = $converter->encode($url);// Видасть 'C4n3WSZ8be'
$url = $converter->decode('C4n3WSZ8be');


$a = 1;

