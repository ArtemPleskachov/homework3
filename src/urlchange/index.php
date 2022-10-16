<?php

use PhpPro\urlchange\action\ValidatorUrl;

require_once './src/autoload.php';


//1. Перевіряєм URL на валідність


$url = 'https://www.w3schools.com';
$validator = new ValidatorUrl();
$validator->validet($url);
var_dump($validator);