<?php
namespace Pleskachov\PhpPro;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Pleskachov\PhpPro\Programa\FileRepository;
use Pleskachov\PhpPro\Programa\UrlConverter;
use Pleskachov\PhpPro\Programa\Utility\UrlValidator;



require_once 'vendor/autoload.php';

$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'LogFile' => [
        'error' => __DIR__ . '/../logs/error.log',
        'info' => __DIR__ . '/../logs/info.log',
    ],
    'codeLength' => 10
];

//$logger = new Monolog\Logger('general'); - так не працює у мене (пише що треба створити клас Monolog\Logger
$logger = new Logger('general'); // - все одно працює по такому запису, а не Monolog\Logger (general - назва каналу)
$logger->pushHandler(new StreamHandler($config['LogFile']['error'], level::Error));
$logger->pushHandler(new StreamHandler($config['LogFile']['info'], Level::Info));



$urlValidator = new UrlValidator();
$repo = new FileRepository($config['dbFile']);
$converter = new UrlConverter(
    $repo,
    $urlValidator,
    $logger,
    $config['codeLength']
);


$url = 'https://google2.com/';
$code = $converter->encode($url);// Видасть '07yLDz31eC'
$url = $converter->decode($code);


$a = 1;

