
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;

-- Видаляємо таблиці, якщо вони вже були створені
DROP TABLE IF EXISTS `c_p_nova_posta`;
DROP TABLE IF EXISTS `c_p_ukrpost`;
DROP TABLE IF EXISTS `c_p_justin`;
DROP TABLE IF EXISTS `new_catalog_city`;
DROP TABLE IF EXISTS `c_region`;
DROP TABLE IF EXISTS `c_area`;


-- Створимо копію основної таблиці і будемо працювати з нею
CREATE TABLE `new_catalog_city` LIKE `catalog_city`;
INSERT INTO `new_catalog_city` SELECT * FROM `catalog_city`;
ALTER TABLE `new_catalog_city`
    ADD INDEX `id` (`id` ASC) VISIBLE;
;

-- Створюємо таблицю областей
CREATE TABLE `c_area` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `area_name_uk` VARCHAR(45) NULL DEFAULT NULL,
                          `area_name_ru` VARCHAR(45) NULL DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE
);

-- Створюємо таблицю регіонів
CREATE TABLE `c_region` (
                            `id` INT NOT NULL AUTO_INCREMENT,
                            `area_id` INT NOT NULL,
                            `region_name_uk` VARCHAR(45) NULL DEFAULT NULL,
                            `region_name_ru` VARCHAR(45) NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
                            INDEX `area_id` (`area_id` ASC) VISIBLE,
                            CONSTRAINT `area_id`
                                FOREIGN KEY (`area_id`)
                                    REFERENCES `c_area` (`id`)
                                    ON DELETE CASCADE
                                    ON UPDATE CASCADE);

-- Копіюємо дані з основної таблиці в нові
INSERT INTO `c_area` (`area_name_uk`, `area_name_ru`)
SELECT DISTINCT(`area_name_uk`), `area_name_ru`
FROM `new_catalog_city`
;
INSERT INTO `c_region` (`region_name_uk`, `region_name_ru`, `area_id`)
SELECT distinct(`cc`.`region_name_uk`), `cc`.`region_name_ru`, `ca`.`id`
FROM `new_catalog_city` as `cc`
         LEFT JOIN `c_area` as `ca` ON `ca`.`area_name_uk` = `cc`.`area_name_uk`
;

-- Додаєм в основну таблицю колонку звʼязок з регіоном
ALTER TABLE `new_catalog_city`
    ADD COLUMN `region_id` INT NOT NULL AFTER `slug`,
    ADD INDEX `region_id` (`region_id` ASC) VISIBLE;

-- Заповнюємо нову колонку
UPDATE `new_catalog_city` as `cc`
    INNER JOIN `c_region` as `cr` ON `cr`.`region_name_uk` = `cc`.`region_name_uk`
SET `cc`.`region_id` = `cr`.`id`;

-- робимо звʼязок
ALTER TABLE `new_catalog_city`
    ADD CONSTRAINT `region_id`
        FOREIGN KEY (`region_id`)
            REFERENCES `c_region` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
;

-- Видаляємо непотрібні колонки
ALTER TABLE `new_catalog_city`
    DROP COLUMN `area_name_ru`,
    DROP COLUMN `region_name_ru`,
    DROP COLUMN `area_name_uk`,
    DROP COLUMN `region_name_uk`;


-- Створюємо таблиці для провайдерів доставок і заповнюємо даними
CREATE TABLE `c_p_ukrpost` (
                               `id` INT NOT NULL,
                               `city_id` INT NOT NULL,
                               PRIMARY KEY (`id`),
                               UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
                               INDEX `city_id_post` (`city_id` ASC),
                               CONSTRAINT `city_id_post`
                                   FOREIGN KEY (`city_id`)
                                       REFERENCES `new_catalog_city` (`id`)
                                       ON DELETE CASCADE
                                       ON UPDATE CASCADE);

INSERT INTO `c_p_ukrpost` (`id`, `city_id`)
SELECT `ukr_poshta_city_id`, `id`
FROM `new_catalog_city`
where `ukr_poshta_city_id` is not null
;

CREATE TABLE `c_p_justin` (
                              `id` INT NOT NULL,
                              `city_id` INT NOT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
                              INDEX `city_id_justin` (`city_id` ASC) ,
                              CONSTRAINT `city_id_justin`
                                  FOREIGN KEY (`city_id`)
                                      REFERENCES `new_catalog_city` (`id`)
                                      ON DELETE CASCADE
                                      ON UPDATE CASCADE);

INSERT INTO `c_p_justin` (`id`, `city_id`)
SELECT `justin_city_id`, `id`
FROM `new_catalog_city`
where `justin_city_id` is not null
;

CREATE TABLE `c_p_nova_posta` (
                                  `id`  VARCHAR(32) NOT NULL,
                                  `city_id` INT NOT NULL,
                                  PRIMARY KEY (`id`),
                                  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
                                  INDEX `city_id_nova_post` (`city_id` ASC) ,
                                  CONSTRAINT `city_id_nova_post`
                                      FOREIGN KEY (`city_id`)
                                          REFERENCES `new_catalog_city` (`id`)
                                          ON DELETE CASCADE
                                          ON UPDATE CASCADE);

INSERT INTO `c_p_nova_posta` (`id`, `city_id`)
SELECT `new_post_city_id`, `id`
FROM `new_catalog_city`
where `new_post_city_id` is not null
;

-- Видаляємо непотрібні колонки з основної таблиці
ALTER TABLE `new_catalog_city`
    DROP COLUMN `new_post_city_id`,
    DROP COLUMN `justin_city_id`,
    DROP COLUMN `ukr_poshta_city_id`;

-- Тепер можна переіменувати дублікат таблиці і видалити стару
ALTER TABLE `catalog_city` RENAME TO  `catalog_city_backup` ;
ALTER TABLE `new_catalog_city` RENAME TO  `catalog_city` ;
DROP TABLE `catalog_city_backup`;