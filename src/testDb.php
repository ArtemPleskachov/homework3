<?php

try {
$dbh = new PDO("mysql:host=db_mysql;dbname=firstdb", "artist", "qwerty");
}
catch (PDOException $e) {
    echo 'Підключення не вдалося';
}

try {
    $dbh->prepare("insert into `table`(status, name, password) values (?, ?, ?)")
        ->execute([
            '2',
            'стілець', //не зрозумів чому не бажає зберігати так, як вказую
            '341'
        ]);
}
catch (PDOException $e) {
    echo 'Збереження не вдалося' . PHP_EOL;
}


$allNames = $dbh->query("select * from `table`")->fetchAll(PDO::FETCH_ASSOC);
$status = $dbh->query('select * from `table` where status = 1');






