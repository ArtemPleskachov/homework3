<?php

require_once 'vendor/autoload.php';


use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


$paths = [__DIR__ . '/DataMapper/Entity'];
$isDevMode = true;

// the connection configuration
$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'artist',
    'password' => 'qwerty',
    'dbname'   => 'firstdb',
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, true);
$connection = DriverManager::getConnection($dbParams, $config);
$em = new EntityManager($connection, $config);


