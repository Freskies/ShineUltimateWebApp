/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

DROP DATABASE IF EXISTS `shine`;
CREATE DATABASE `shine`;
USE `shine`;

# tutor (for underage athletes)
CREATE TABLE `tutor`
(
    `id`        INT          NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(255) NOT NULL,
    `surname`   VARCHAR(255) NOT NULL,
    `email`     VARCHAR(255) NOT NULL,
    `phone`     VARCHAR(14)  NOT NULL,
    `address`   VARCHAR(255) NOT NULL,
    `city`      VARCHAR(255) NOT NULL,
    `cap`       VARCHAR(255) NOT NULL,
    `province`  VARCHAR(255) NOT NULL,
    `birthdate` DATE         NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# athlete
CREATE TABLE `athlete`
(
    `id`                  INT          NOT NULL AUTO_INCREMENT,
    `surname`             VARCHAR(255) NOT NULL,
    `name`                VARCHAR(255) NOT NULL,
    `birthdate`           DATE         NOT NULL,
    `address`             VARCHAR(255) NOT NULL,
    `city`                VARCHAR(255) NOT NULL,
    `cap`                 VARCHAR(255) NOT NULL,
    `province`            VARCHAR(255) NOT NULL,
    `phone`               VARCHAR(255),
    `email`               VARCHAR(255),
    `medical_certificate` DATE DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# athlete_tutor (for underage athletes)
CREATE TABLE `athlete_tutor`
(
    `athlete_id` INT NOT NULL,
    `tutor_id`   INT NOT NULL,
    PRIMARY KEY (`athlete_id`, `tutor_id`),
    FOREIGN KEY (`athlete_id`) REFERENCES `athlete` (`id`),
    FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`)
) ENGINE = InnoDB;

# course
CREATE TABLE `course`
(
    `id`        INT         NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(32) NOT NULL,
    `year`      INT         NOT NULL, # year when the course is started
    `is_active` BOOLEAN     NOT NULL DEFAULT TRUE,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# members of team shine
CREATE TABLE `team`
(
    `id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id`) REFERENCES `athlete` (`id`)
) ENGINE = InnoDB;

# type_of_task
CREATE TABLE `type_of_task`
(
    `id`        INT           NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(32)   NOT NULL,
    `pay_per_h` DECIMAL(5, 2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# every other task that isn't a coaching session in a course
CREATE TABLE `task`
(
    `id`          INT           NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(32)   NOT NULL,
    `description` VARCHAR(512)  NOT NULL,
    # is active if the task is available in the future to be reassigned
    `is_active`   BOOLEAN       NOT NULL DEFAULT TRUE,
    `team_id`     INT           NOT NULL,
    `payment`     DECIMAL(6, 2) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`team_id`) REFERENCES `team` (`id`)
) ENGINE = InnoDB;

# lesson
CREATE TABLE `lesson`
(
    `id`        INT           NOT NULL AUTO_INCREMENT,
    `course_id` INT           NOT NULL,
    `duration`  DECIMAL(2, 1) NOT NULL,
    `date`      DATE          NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`course_id`) REFERENCES `course` (`id`)
) ENGINE = InnoDB;

# lesson_team (person of team who is teaching)
CREATE TABLE `lesson_team`
(
    `lesson_id`       INT NOT NULL,
    `team_id`         INT NOT NULL,
    `type_of_task_id` INT NOT NULL,
    PRIMARY KEY (`lesson_id`, `team_id`),
    FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`),
    FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
    FOREIGN KEY (`type_of_task_id`) REFERENCES `type_of_task` (`id`)
) ENGINE = InnoDB;

# this is only for the app
CREATE TABLE `users`
(
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(16)  NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `team`     INT          NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`team`) REFERENCES `team` (`id`)
) ENGINE = InnoDB;

INSERT INTO `type_of_task` (`name`, `pay_per_h`)
VALUES ('learning', 0.00),
       ('assistant', 7.00),
       ('coaching', 12.00);

INSERT INTO `course` (`name`, `year`, `is_active`)
VALUES ('4-5 2021-2022', 2021, FALSE),
       ('6-7 2021-2022', 2021, FALSE),
       ('8-9 2021-2022', 2021, FALSE),
       ('10-11 2021-2022', 2021, FALSE),
       ('12-13 2021-2022', 2021, TRUE),
       ('14+ 2021-2022', 2021, FALSE),
       ('Adults 2021-2022', 2021, FALSE);

INSERT INTO `athlete` (`surname`, `name`, `birthdate`, `address`, `city`, `cap`, `province`, `phone`, `email`)
VALUES ('Giacchini', 'Valerio', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA', '3347251873',
        'portasfiga1099@gmail.com');

INSERT INTO `team` (`id`)
VALUES (1);

INSERT INTO `users` (`username`, `password`, `team`)
VALUES ('Valerio', '$2y$10$iz6wL4GZKyc6uSUgZ0Qkp.lRreQUJYgPC.tmsqyl9SllT2tj9I6L6', 1);