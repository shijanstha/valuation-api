---- real estate table---
CREATE TABLE `real_estate` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `re_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `cost` varchar(45) DEFAULT NULL,
  `contact_no` varchar(30) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`re_id`)
);

-----------------------

-------EMPLOYEE TABLE-----------
CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(255) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
);

-------------------------------

----------journal table---------
CREATE TABLE `journal` (
  `journal_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `summary` VARCHAR(2000) NULL,
  `description` VARCHAR(6000) NULL,
  `img_path` VARCHAR(255) NULL,
  PRIMARY KEY (`journal_id`));

------------------------------

------Gallery table----------
CREATE TABLE `gallery` (
  `img_id` INT NOT NULL AUTO_INCREMENT,
  `img_desc` VARCHAR(255) NULL,
  `img_path` VARCHAR(255) NULL,
  PRIMARY KEY (`img_id`));

-------------------------------

--------project table--------------
CREATE TABLE `project` (
  `project_id` INT NOT NULL AUTO_INCREMENT,
  `project_title` VARCHAR(255) NULL,
  `project_desc` VARCHAR(1000) NULL,
  `img_path` VARCHAR(255) NULL,
  PRIMARY KEY (`project_id`));

----------------------------------

----------vacancy table-----------
CREATE TABLE `vacancy` (
  `vacancy_id` int(11) NOT NULL AUTO_INCREMENT,
  `vacancy_title` varchar(255) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `opening` int(11) DEFAULT NULL,
  `experience` varchar(45) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `created_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_dt` date DEFAULT NULL,
  PRIMARY KEY (`vacancy_id`)
);

---------------------------------

-----------slider image---------------
CREATE TABLE `slider_image` (
  `slider_id` INT NOT NULL AUTO_INCREMENT,
  `slider_desc` VARCHAR(500) NULL,
  `img_path` VARCHAR(255) NULL,
  PRIMARY KEY (`slider_id`));
-------------------------------


ALTER TABLE `journal` 
ADD COLUMN `desc_2` VARCHAR(1500) NULL DEFAULT NULL AFTER `desc_1`,
ADD COLUMN `desc_3` VARCHAR(1500) NULL DEFAULT NULL AFTER `desc_2`,
ADD COLUMN `desc_4` VARCHAR(1500) NULL DEFAULT NULL AFTER `desc_3`,
CHANGE COLUMN `description` `desc_1` VARCHAR(1500) NULL DEFAULT NULL ;


ALTER TABLE `vacancy` 
ADD COLUMN `vacancy_desc` VARCHAR(2000) NULL AFTER `service_type`;


create table contact_us (
	  id integer primary key auto_increment,
    name varchar(50),
    email varchar(60),
    contact_no varchar(15),
    message varchar(1000)
);

CREATE TABLE `testimonial` (
  `tes_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `paragraph` varchar(2000) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`tes_id`)
);

CREATE TABLE `admin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `real_estate` 
DROP COLUMN `contact_no`,
DROP COLUMN `re_name`;

CREATE TABLE `emp_type` (
  `emp_type_id` INT NOT NULL AUTO_INCREMENT,
  `emp_type_name` VARCHAR(255) NULL,
  PRIMARY KEY (`emp_type_id`));

INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('1', 'Construction');
INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('2', 'Valuation');
INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('3', 'Planning');
INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('4', 'Interior Design');
INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('5', '3D Modelling');
INSERT INTO `valuation`.`emp_type` (`emp_type_id`, `emp_type_name`) VALUES ('6', 'Cost and Estimation');


ALTER TABLE `employee` 
ADD COLUMN `fb_link` VARCHAR(500) NULL AFTER `img_path`,
DROP INDEX `email_UNIQUE` ;

ALTER TABLE `employee` 
CHANGE COLUMN `type` `emp_type_id` INT NOT NULL ;

ALTER TABLE `project` 
ADD COLUMN `client` VARCHAR(160) NULL AFTER `project_title`,
ADD COLUMN `address` VARCHAR(60) NULL AFTER `client`,
ADD COLUMN `project_cost` VARCHAR(45) NULL AFTER `project_desc`;

ALTER TABLE `real_estate` 
DROP COLUMN `cost`,
ADD COLUMN `frontage` VARCHAR(45) NULL AFTER `re_id`,
ADD COLUMN `area_of_property` VARCHAR(45) NULL AFTER `frontage`,
ADD COLUMN `geo_location` VARCHAR(45) NULL AFTER `address`,
ADD COLUMN `contact` VARCHAR(45) NULL AFTER `geo_location`,
ADD COLUMN `base_rate` VARCHAR(45) NULL AFTER `contact`;


CREATE TABLE `estimation` (
  `key` VARCHAR(45) NOT NULL,
  `value` INT NULL,
  PRIMARY KEY (`key`));

INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_attached_bathroom_rate',91200);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_bedroom_rate',312000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_common_bathroom_rate',114000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_floor_rate',1600);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_kitchen_rate',117760);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_modular_kitchen_rate',300000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('basic_sitting_room_rate',312000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_attached_bathroom_rate',107200);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_bedroom_rate',468000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_common_bathroom_rate',134000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_floor_rate',1650);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_kitchen_rate',147200);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_modular_kitchen_rate',450000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('deluxe_sitting_room_rate',468000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_attached_bathroom_rate',114800);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_bedroom_rate',702000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_common_bathroom_rate',164000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_floor_rate',1800);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_kitchen_rate',184000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_modular_kitchen_rate',600000);
INSERT INTO `estimation` (`key`,`value`) VALUES ('premium_sitting_room_rate',345600);


CREATE TABLE `client_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `contact_no` VARCHAR(45) NULL,
  `email` VARCHAR(60) NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `employee` 
ADD COLUMN `emp_desc` VARCHAR(500) NULL AFTER `fb_link`;

UPDATE `estimation` SET `value` = '702000' WHERE (`name` = 'premium_sitting_room_rate');
