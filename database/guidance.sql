-- Create the database
CREATE DATABASE IF NOT EXISTS guidance_db;
USE guidance_db;

-- Table for Admin User (unchanged)
CREATE TABLE AdminUser (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nickname VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY username_unique (username)
) ENGINE=InnoDB;

-- Default Admin
INSERT INTO AdminUser (nickname, username, password) VALUES ('admin', 'admin', 'admin123');

-- Table for strands 
CREATE TABLE `strands` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique` (`name`)
) ENGINE=InnoDB;

-- Table for courses 
CREATE TABLE `courses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `nickname` VARCHAR(10) NOT NULL, -- Added nickname field
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique` (`name`)
) ENGINE=InnoDB;

-- Table for test terms (unchanged)
CREATE TABLE `application_term` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `academic_year` VARCHAR(9) NOT NULL,  -- e.g., '2023-2024'
  `semester` ENUM('1st semester', '2nd semester') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_unique` (`academic_year`, `semester`)
) ENGINE=InnoDB;

-- Table for applicants (reverted to use strand_id)
CREATE TABLE `applicants` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `applicant_no` VARCHAR(20) NOT NULL,
  `application_term_id` INT UNSIGNED NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `firstname` VARCHAR(50) NOT NULL,
  `middlename` VARCHAR(50) DEFAULT NULL,
  `suffix` VARCHAR(10) DEFAULT NULL, 
  `sex` ENUM('Male', 'Female', 'Other') NOT NULL,
  `strand_id` INT UNSIGNED NOT NULL,

  `course_1_id` INT UNSIGNED NOT NULL,
  `course_2_id` INT UNSIGNED DEFAULT NULL,
  `course_3_id` INT UNSIGNED DEFAULT NULL, 

  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_term_unique` (`applicant_no`, `application_term_id`),

  FOREIGN KEY (`application_term_id`) REFERENCES `application_term`(`id`),
  FOREIGN KEY (`strand_id`) REFERENCES `strands`(`id`),

  FOREIGN KEY (`course_1_id`) REFERENCES `courses`(`id`),
  FOREIGN KEY (`course_2_id`) REFERENCES `courses`(`id`),
  FOREIGN KEY (`course_3_id`) REFERENCES `courses`(`id`)
) ENGINE=InnoDB;

-- Table for test results (unchanged)
CREATE TABLE `test_results` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `applicant_id` INT UNSIGNED NOT NULL,
  `general_ability` TINYINT UNSIGNED NOT NULL,
  `verbal_aptitude` TINYINT UNSIGNED NOT NULL,
  `numerical_aptitude` TINYINT UNSIGNED NOT NULL,
  `spatial_aptitude` TINYINT UNSIGNED NOT NULL,
  `perceptual_aptitude` TINYINT UNSIGNED NOT NULL,
  `manual_dexterity` TINYINT UNSIGNED NOT NULL,
  `date_taken` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`applicant_id`) REFERENCES `applicants`(`id`) ON DELETE CASCADE,
  INDEX `idx_date_taken` (`date_taken`)
) ENGINE=InnoDB;