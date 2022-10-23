<?php
namespace Pleskachov\PhpPro;

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Pleskachov\PhpPro\Programa\FileRepository;
use Pleskachov\PhpPro\Programa\UrlConverter;
use Pleskachov\PhpPro\Programa\Utility\SingletonLogger;
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


$singletonLogger = SingletonLogger::getInstance(new Logger('general'));
$singletonLogger->pushHandler(new StreamHandler($config['LogFile']['error'], level::Error))
    ->pushHandler(new StreamHandler($config['LogFile']['info'], Level::Info));

//$t = serialize($singletonLogger);
//unserialize($t);

$repo = new FileRepository($config['dbFile']);
$urlValidator = new UrlValidator(new Client());
$converter = new UrlConverter(
    $repo,
    $urlValidator,
    $config['codeLength']
);


$url = 'https://google.com/';
$code = $converter->encode($url);// Видасть '07yLDz31eC'
$url = $converter->decode($code);


$a = 1;


