<?php
namespace Pleskachov\PhpPro;



use MailCheker\MailChecker;

require_once 'vendor/autoload.php';

//include __DIR__."/MailChecker/platform/php/MailChecker.php";
//
//include __DIR__ . "/../MailChecker/platform/php/MailChecker.php";

//if(!MailChecker::isValid('myemail@yopmail.com')){
//    die('O RLY !');
//}
//
//if(!MailChecker::isValid('myemail.com')){
//    die('O RLY !');
//}

$email = 'pleskachov@icloud.com';

if(!MailChecker::isValid($email)) {
    echo 'Is email not valid' . PHP_EOL;
} else {
    echo 'Is email valid' . PHP_EOL;
}
