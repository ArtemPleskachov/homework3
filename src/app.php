<?php
namespace Pleskachov\PhpPro;

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

//use Pleskachov\PhpPro\Programa\FileRepository;
//use Pleskachov\PhpPro\Programa\UrlConverter;
//use Pleskachov\PhpPro\Programa\Utility\SingletonLogger;
//use Pleskachov\PhpPro\Programa\Utility\UrlValidator;

use Pleskachov\PhpPro\Programa\ {
    FileRepository,
    UrlConverter,
};
use Pleskachov\PhpPro\Core\ConfigHandler;
use Pleskachov\PhpPro\Programa\Utility\ {
    SingletonLogger,
    UrlValidator,
};



require_once 'vendor/autoload.php';

$configs = require_once __DIR__ . '/../parameters/config.php';
$configHandler = ConfigHandler::getInstance()->addConfigs($configs);

//$config = [
//    'dbFile' => __DIR__ . '/../storage/db.json',
//    'LogFile' => [
//        'error' => __DIR__ . '/../logs/error.log',
//        'info' => __DIR__ . '/../logs/info.log',
//    ],
//    'codeLength' => 10
//];


$singletonLogger = SingletonLogger::getInstance(new Logger($configHandler->get('monolog.channel')));
$singletonLogger = pushHandler(new StreamHandler($configHandler->get('monolog.level.error'), Level::Error))
    ->pushHandler(new StreamHandler($configHandler->get('monolog.level.info'), Level::Info));



//$t = serialize($singletonLogger);
//unserialize($t);

$fileRepository = new FileRepository($configHandler->get('dbFile'));
$urlValidator = new UrlValidator(new Client());
$converter = new UrlConverter(
    $fileRepository,
    $urlValidator,
    $configHandler->get('urlConverter.codeLength')
);


$url = 'https://google.com/';
$code = $converter->encode($url);// Видасть '07yLDz31eC'
$url = $converter->decode($code);
$res = ConfigHandler::getInstance()->get('a.b.c');

exit;
