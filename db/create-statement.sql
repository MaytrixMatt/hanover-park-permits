DROP DATABASE IF EXISTS `parkpermit`;
CREATE SCHEMA `parkpermit`;
USE `parkpermit`;

CREATE TABLE `fields` (
  `fld_id` int NOT NULL AUTO_INCREMENT,
  `fld_loc_id` int NOT NULL,
  `fld_name` varchar(45) NOT NULL,
  `fld_reserved` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fld_id`),
  UNIQUE KEY `fld_id_UNIQUE` (`fld_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `location` (
  `loc_id` int NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(100) NOT NULL,
  PRIMARY KEY (`loc_id`),
  UNIQUE KEY `cus_id_UNIQUE` (`loc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `applications` (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `app_cus_first_name` varchar(45) DEFAULT NULL,
  `app_cus_last_name` varchar(45) DEFAULT NULL,
  `app_tier` INT NOT NULL,
  `app_afl_id` varchar(45) NOT NULL,
  `app_date_req` VARCHAR(45) NOT NULL,
  `app_description` VARCHAR(200) NULL,
  `app_estimated_people` INT NOT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `app_id_UNIQUE` (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `application_fields` (
  `afl_id` int NOT NULL AUTO_INCREMENT,
  `afl_loc_id` varchar(45) DEFAULT NULL,
  `afl_fld_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`afl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- CREATE TABLE `customers` (
--   `cus_id` INT NOT NULL AUTO_INCREMENT,
--   `cus_first_name` VARCHAR(45) NOT NULL,
--   `cus_last_name` VARCHAR(45) NOT NULL,
--   `cus_organization_name` VARCHAR(100) NOT NULL,
--   `cus_address` VARCHAR(100) NOT NULL,
--   `cus_phone` VARCHAR(45) NOT NULL,
--   `cus_email` VARCHAR(100) NOT NULL,
--   `cus_tier` INT NOT NULL,
--   PRIMARY KEY (`cus_id`),
--   UNIQUE INDEX `cus_id_UNIQUE` (`cus_id` ASC) VISIBLE);
  