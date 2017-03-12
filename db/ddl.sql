-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema food-finder
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `food-finder` ;

-- -----------------------------------------------------
-- Schema food-finder
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `food-finder` DEFAULT CHARACTER SET utf8 ;
USE `food-finder` ;

-- -----------------------------------------------------
-- Table `food-finder`.`postcode`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`postcode` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`postcode` (
  `postcode` VARCHAR(10) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `county` VARCHAR(45) NOT NULL,
  `adr_secondline` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`postcode`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`restaurant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`restaurant` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`restaurant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `is_active` TINYINT(1) NOT NULL,
  `lat` DECIMAL(18,16) NOT NULL,
  `lng` DECIMAL(19,16) NOT NULL,
  `postcode` VARCHAR(10) NOT NULL,
  `adr_firstline` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(14) NULL,
  `website` VARCHAR(45) NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_restaurant_postcode1_idx` (`postcode` ASC),
  CONSTRAINT `fk_restaurant_postcode1`
    FOREIGN KEY (`postcode`)
    REFERENCES `food-finder`.`postcode` (`postcode`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`language`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`language` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`language` (
  `code` VARCHAR(3) NOT NULL COMMENT 'ISO 639-2',
  `eng_name` VARCHAR(45) NOT NULL,
  `native_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE INDEX `eng_name_UNIQUE` (`eng_name` ASC),
  UNIQUE INDEX `native_name_UNIQUE` (`native_name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`weekday_names`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`weekday_names` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`weekday_names` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `language_code` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`id`, `language_code`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `fk_weekday_names_language1_idx` (`language_code` ASC),
  CONSTRAINT `fk_weekday_names_language1`
    FOREIGN KEY (`language_code`)
    REFERENCES `food-finder`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`restaurant_schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`restaurant_schedule` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`restaurant_schedule` (
  `time_from` TIME NOT NULL,
  `time_to` TIME NULL,
  `restaurant_id` INT NOT NULL,
  `weekday_names_id` INT NOT NULL,
  PRIMARY KEY (`restaurant_id`, `weekday_names_id`),
  INDEX `fk_restaurant_schedule_restaurant1_idx` (`restaurant_id` ASC),
  INDEX `fk_restaurant_schedule_weekday_names1_idx` (`weekday_names_id` ASC),
  CONSTRAINT `fk_restaurant_schedule_restaurant1`
    FOREIGN KEY (`restaurant_id`)
    REFERENCES `food-finder`.`restaurant` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_schedule_weekday_names1`
    FOREIGN KEY (`weekday_names_id`)
    REFERENCES `food-finder`.`weekday_names` (`id`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`food` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`food` (
  `path` VARCHAR(50) NOT NULL,
  `isfood` TINYINT(1) NOT NULL,
  PRIMARY KEY (`path`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`restaurant_has_food`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`restaurant_has_food` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`restaurant_has_food` (
  `restaurant_id` INT NOT NULL,
  `food_path` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`restaurant_id`, `food_path`),
  INDEX `fk_restaurant_has_food_food1_idx` (`food_path` ASC),
  INDEX `fk_restaurant_has_food_restaurant1_idx` (`restaurant_id` ASC),
  CONSTRAINT `fk_restaurant_has_food_restaurant1`
    FOREIGN KEY (`restaurant_id`)
    REFERENCES `food-finder`.`restaurant` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_has_food_food1`
    FOREIGN KEY (`food_path`)
    REFERENCES `food-finder`.`food` (`path`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`restaurant_transl`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`restaurant_transl` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`restaurant_transl` (
  `restaurant_id` INT NOT NULL,
  `language_code` VARCHAR(3) NOT NULL,
  `description` VARCHAR(1000) NULL,
  `schedule_change` VARCHAR(200) NULL,
  PRIMARY KEY (`restaurant_id`, `language_code`),
  INDEX `fk_restaurant_transl_language1_idx` (`language_code` ASC),
  CONSTRAINT `fk_restaurant_transl_restaurant1`
    FOREIGN KEY (`restaurant_id`)
    REFERENCES `food-finder`.`restaurant` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restaurant_transl_language1`
    FOREIGN KEY (`language_code`)
    REFERENCES `food-finder`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `food-finder`.`food_transl`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `food-finder`.`food_transl` ;

CREATE TABLE IF NOT EXISTS `food-finder`.`food_transl` (
  `food_path` VARCHAR(50) NOT NULL,
  `language_code` VARCHAR(3) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`food_path`, `language_code`),
  INDEX `fk_food_transl_language1_idx` (`language_code` ASC),
  CONSTRAINT `fk_food_transl_food1`
    FOREIGN KEY (`food_path`)
    REFERENCES `food-finder`.`food` (`path`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_food_transl_language1`
    FOREIGN KEY (`language_code`)
    REFERENCES `food-finder`.`language` (`code`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE = '';
GRANT USAGE ON *.* TO php_ro;
 DROP USER php_ro;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'php_ro' IDENTIFIED BY 'php_ro';

GRANT SELECT ON TABLE `food-finder`.`food` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`postcode` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`restaurant_schedule` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`restaurant_has_food` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`food_transl` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`restaurant_transl` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`weekday_names` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`language` TO 'php_ro';
GRANT SELECT ON TABLE `food-finder`.`restaurant` TO 'php_ro';

-- -----------------------------------------------------
-- Data for table `food-finder`.`postcode`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`postcode` (`postcode`, `city`, `county`, `adr_secondline`) VALUES ('NG1 1HN', 'Nottingham', 'Nottinghamshire', 'High Pavement');
INSERT INTO `food-finder`.`postcode` (`postcode`, `city`, `county`, `adr_secondline`) VALUES ('NG1 5JT', 'Nottingham', 'Nottinghamshire', 'Goldsmith St');

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`restaurant`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`restaurant` (`id`, `is_active`, `lat`, `lng`, `postcode`, `adr_firstline`, `phone`, `website`, `name`) VALUES (1, 1, 52.9561578, -1.1528738, 'NG1 5JT', '17', '0115 924 3730', 'www.hih.co.uk', 'Horn in Hand');
INSERT INTO `food-finder`.`restaurant` (`id`, `is_active`, `lat`, `lng`, `postcode`, `adr_firstline`, `phone`, `website`, `name`) VALUES (2, 1, 52.950938, -1.1452939, 'NG1 1HN', 'The Unitarian Church', '0115 958 6081', 'www.pnp.co.uk', 'Pitcher & Piano');

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`language`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`language` (`code`, `eng_name`, `native_name`) VALUES ('eng', 'English', 'English');
INSERT INTO `food-finder`.`language` (`code`, `eng_name`, `native_name`) VALUES ('rus', 'Russian', 'Русский');

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`weekday_names`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (1, 'Mon', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (2, 'Tue', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (3, 'Wen', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (4, 'Thu', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (5, 'Fri', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (6, 'Sat', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (0, 'Sun', 'eng');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (1, 'Пн', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (2, 'Вт', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (3, 'Ср', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (4, 'Чт', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (5, 'Пт', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (6, 'Сб', 'rus');
INSERT INTO `food-finder`.`weekday_names` (`id`, `name`, `language_code`) VALUES (0, 'Вс', 'rus');

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`restaurant_schedule`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '19:00', 1, 1);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '23:00', 1, 2);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '23:00', 1, 3);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '23:00', 1, 4);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '23:30', 1, 5);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('10:00', '23:30', 1, 6);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '23:00', 1, 0);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '18:00', 2, 1);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '22:00', 2, 2);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '22:00', 2, 3);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '22:00', 2, 4);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '23:00', 2, 5);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '23:00', 2, 6);
INSERT INTO `food-finder`.`restaurant_schedule` (`time_from`, `time_to`, `restaurant_id`, `weekday_names_id`) VALUES ('12:00', '23:00', 2, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`food`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/1', 0);
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/1/1', 1);
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/1/2', 1);
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/2', 0);
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/2/1', 1);
INSERT INTO `food-finder`.`food` (`path`, `isfood`) VALUES ('/2/2', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`restaurant_has_food`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`restaurant_has_food` (`restaurant_id`, `food_path`) VALUES (1, '/1/1');
INSERT INTO `food-finder`.`restaurant_has_food` (`restaurant_id`, `food_path`) VALUES (1, '/1/2');
INSERT INTO `food-finder`.`restaurant_has_food` (`restaurant_id`, `food_path`) VALUES (1, '/2/1');
INSERT INTO `food-finder`.`restaurant_has_food` (`restaurant_id`, `food_path`) VALUES (2, '/2/2');
INSERT INTO `food-finder`.`restaurant_has_food` (`restaurant_id`, `food_path`) VALUES (2, '/1/2');

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`restaurant_transl`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`restaurant_transl` (`restaurant_id`, `language_code`, `description`, `schedule_change`) VALUES (2, 'rus', 'Описание кувишна и пианино', NULL);
INSERT INTO `food-finder`.`restaurant_transl` (`restaurant_id`, `language_code`, `description`, `schedule_change`) VALUES (2, 'eng', 'Modern chain bar serving beer, wine and cocktails, plus a menu of grazing plates and pub classics.', NULL);
INSERT INTO `food-finder`.`restaurant_transl` (`restaurant_id`, `language_code`, `description`, `schedule_change`) VALUES (1, 'eng', 'Buzzy pub with an extensive menu of burgers, steaks and nachos, plus TV sports and craft beers.', NULL);
INSERT INTO `food-finder`.`restaurant_transl` (`restaurant_id`, `language_code`, `description`, `schedule_change`) VALUES (1, 'rus', 'Описание Хорн ин Хэнд', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `food-finder`.`food_transl`
-- -----------------------------------------------------
START TRANSACTION;
USE `food-finder`;
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2', 'eng', 'Beer');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2', 'rus', 'Пиво');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1', 'eng', 'Main dishes');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1', 'rus', 'Основныe блюда');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1/1', 'rus', 'Пастуший пирог');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1/1', 'eng', 'Shepard pie');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1/2', 'rus', 'Мясной пирог');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/1/2', 'eng', 'Meat pie');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2/1', 'eng', 'Guiness');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2/1', 'rus', 'Гинесс');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2/2', 'eng', 'Brahma');
INSERT INTO `food-finder`.`food_transl` (`food_path`, `language_code`, `name`) VALUES ('/2/2', 'rus', 'Brahma');

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
