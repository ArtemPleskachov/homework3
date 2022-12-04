<?php


/**
 *Description Підключення бази даних
 */
try {
    $dbh = new PDO("mysql:host=db_mysql;dbname=firstdb", "artist", "qwerty");
}
catch (PDOException $e) {
    echo 'Підключення не вдалося';
}