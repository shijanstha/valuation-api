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
  `img_id` INT NOT NULL,
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