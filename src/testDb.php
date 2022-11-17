<?php


$dbh = new PDO("mysql:host=db_mysql;dbname=firstdb", "artist", "qwerty");

$dbh->prepare("insert into `table`(status, name, password) values (?, ?, ?)")
    ->execute([
        '2',
        'стілець', //не зрозумів чому не бажає зберігати так, як вказую
        '341'
    ]);


$allNames = $dbh->query("select * from `table`")->fetchAll(PDO::FETCH_ASSOC);
$status = $dbh->query('select * from `table` where status = 1');






