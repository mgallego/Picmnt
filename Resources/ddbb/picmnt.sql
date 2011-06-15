SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `Picmnt_Dev` ;
CREATE SCHEMA IF NOT EXISTS `Picmnt_Dev` DEFAULT CHARACTER SET latin1 ;
SHOW WARNINGS;
USE `Picmnt_Dev` ;

-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `User` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(255) NOT NULL ,
  `username_canonical` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `email_canonical` VARCHAR(255) NOT NULL ,
  `enabled` TINYINT(1) NOT NULL ,
  `algorithm` VARCHAR(255) NOT NULL ,
  `salt` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  `last_login` DATETIME NULL DEFAULT NULL ,
  `locked` TINYINT(1) NOT NULL ,
  `expired` TINYINT(1) NOT NULL ,
  `expires_at` DATETIME NULL DEFAULT NULL ,
  `confirmation_token` VARCHAR(255) NULL DEFAULT NULL ,
  `password_requested_at` DATETIME NULL DEFAULT NULL ,
  `roles` LONGTEXT NOT NULL ,
  `credentials_expired` TINYINT(1) NOT NULL ,
  `credentials_expire_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;
CREATE UNIQUE INDEX `UNIQ_2DA1797792FC23A8` ON `User` (`username_canonical` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `UNIQ_2DA17977A0D96FBF` ON `User` (`email_canonical` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `User_Info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User_Info` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `User_Info` (
  `user_id` INT(11) NOT NULL ,
  `name` VARCHAR(45) NOT NULL COMMENT 'User name' ,
  `last_name` VARCHAR(45) NOT NULL COMMENT 'User Last Name\n' ,
  `avatar` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1, 
COMMENT = 'Detailed information about the Users' ;

SHOW WARNINGS;
CREATE INDEX `fk_User_Info_User` ON `User_Info` (`user_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Image` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `Image` (
  `id_image` INT(11) NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(255) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `description` VARCHAR(500) NULL DEFAULT NULL ,
  `category` INT(11) NULL DEFAULT NULL ,
  `tags` VARCHAR(255) NULL DEFAULT NULL ,
  `votes` INT(11) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id_image`) )
ENGINE = InnoDB
AUTO_INCREMENT = 184
DEFAULT CHARACTER SET = latin1
COMMENT = 'user Image tables\n' ;

SHOW WARNINGS;
CREATE INDEX `IDX_Usuario` ON `Image` (`user_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `User_Vote`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User_Vote` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `User_Vote` (
  `id_vote` INT NOT NULL AUTO_INCREMENT COMMENT 'Vote Id' ,
  `id_image` INT(11) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id_vote`) )
ENGINE = InnoDB;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
