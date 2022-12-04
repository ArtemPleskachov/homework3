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

/*
1) Для преведення таблиці до 1НФ, перевірив всі рядки на надмірність - все ок. Кожна ячейка зберігає тільки одни
   вид даних, потім присвоїв первичний ключ до ID

ALTER TABLE `firstdb`.`catalog_city`
ADD PRIMARY KEY (`id`);
;

2) Створив таблицю id_post_city_all яка буде збирати в себе всі ID поштових служб,
та матиме зовнішній ключ id_all_post_city
CREATE TABLE `firstdb`.`id_post_city_all` (
  `id_all_post_city` INT NOT NULL,
  `new_post_city_id` VARCHAR(45) NULL,
  `justin_city_id` VARCHAR(45) NULL,
  `ukr_poshta_city_id` INT NULL DEFAULT NULL,
  INDEX `catalog_city_idx` (`id_all_post_city` ASC) VISIBLE,
  CONSTRAINT `catalog_city`
    FOREIGN KEY (`id_all_post_city`)
    REFERENCES `firstdb`.`catalog_city` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

3) Створив нову таблицю щоб, розвантажити методи запису населених пунктів і прив’язав по методу один к багатьмо область
   і населенні пунки.
CREATE TABLE `firstdb`.`city_region_id` (
  `area_name_uk` VARCHAR(255) NOT NULL,
  `name_uk` VARCHAR(255) NOT NULL,
  `name_ru` VARCHAR(255) NOT NULL,
  `region_name_uk` VARCHAR(255) NOT NULL,
  `region_name_ru` VARCHAR(255) NOT NULL);

4) Видаляємо area_name_ru так як вона нам не потрібна, всі населені пункти та районі підв’язані до area_name_uk
ALTER TABLE `firstdb`.`catalog_city`
DROP COLUMN `area_name_ru`;

5)








 */



