<?php

use Pleskachov\PhpPro\ORM\DataMapper\Entity\User;
use Doctrine\ORM\EntityManager;



//require_once 'vendor/autoload.php';
require_once __DIR__ . '/ORM/bootstrap.php';

try {
    /**
     * @var EntityManager $em
     */

    $users = new User();

    $users->setEmail('new@email.com');
    $users->setName('Artem');

    var_dump($users);

    $em->persist($users);
    $em->flush();

} catch (Exception $e) {
    echo $e->getCode() .': ' . $e->getMessage() . ' ('.$e->getLine().')' . PHP_EOL;
}

exit;



