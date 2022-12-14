/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

DROP DATABASE IF EXISTS `shine`;
CREATE DATABASE `shine`;
USE `shine`;

# athlete
CREATE TABLE `athlete`
(
    `id`                  INT          NOT NULL AUTO_INCREMENT,
    `fiscal_code`         VARCHAR(255) NOT NULL,
    `surname`             VARCHAR(255) NOT NULL,
    `name`                VARCHAR(255) NOT NULL,
    `birthdate`           DATE         NOT NULL,
    `address`             VARCHAR(255) NOT NULL,
    `city`                VARCHAR(255) NOT NULL,
    `cap`                 VARCHAR(255) NOT NULL,
    `province`            VARCHAR(255) NOT NULL,
    `phone`               VARCHAR(255),
    `email`               VARCHAR(255),
    `medical_certificate` DATE    DEFAULT NULL,
    `auto_certificate`    BOOLEAN DEFAULT FALSE,
    `course_id`           INT     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# tutor (for underage athletes)
CREATE TABLE `tutor`
(
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `fiscal_code` VARCHAR(10),
    `name`        VARCHAR(255) NOT NULL,
    `surname`     VARCHAR(255) NOT NULL,
    `email`       VARCHAR(255),
    `phone`       VARCHAR(14)  NOT NULL,
    `address`     VARCHAR(255) NOT NULL,
    `city`        VARCHAR(255) NOT NULL,
    `cap`         VARCHAR(255) NOT NULL,
    `province`    VARCHAR(255) NOT NULL,
    `birthdate`   DATE         NOT NULL,
    `athlete_id`  INT          NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`athlete_id`) REFERENCES `athlete` (`id`)
) ENGINE = InnoDB;

# course
CREATE TABLE `course`
(
    `id`                 INT           NOT NULL AUTO_INCREMENT,
    `name`               VARCHAR(32)   NOT NULL,
    `year`               VARCHAR(4)    NOT NULL, # year when the course is started
    `default_start_time` TIME          NOT NULL, # default start time for the course
    `default_duration`   DECIMAL(4, 2) NOT NULL, # default duration for lessons in the course
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# admin role for the team
CREATE TABLE `role`
(
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(32)  NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# members of team shine
CREATE TABLE `team`
(
    `id`      INT,
    `role_id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`id`) REFERENCES `athlete` (`id`),
    FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE = InnoDB;

# type_of_task
CREATE TABLE `type_of_task_in_lesson`
(
    `id`        INT           NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(32)   NOT NULL,
    `pay_per_h` DECIMAL(5, 2) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

# lesson
CREATE TABLE `lesson`
(
    `id`        INT           NOT NULL AUTO_INCREMENT,
    `course_id` INT           NOT NULL,
    `duration`  DECIMAL(2, 1) NOT NULL,
    `date`      DATE          NOT NULL,
    `place`     VARCHAR(255)  NOT NULL,
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
    FOREIGN KEY (`type_of_task_id`) REFERENCES `type_of_task_in_lesson` (`id`)
) ENGINE = InnoDB;

# TODO tabella presenze

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

INSERT INTO `role` (`id`, `name`, `description`)
VALUES (1, 'Presidente', 'presidente della associazione'),
       (2, 'Vide-presidente', 'vice presidente della associazione'),
       (3, 'Tesoriere', 'colui che gestisce le entrate e le uscite della associazione'),
       (4, 'Consigliere', 'aiuta nelle decisioni'),
       (5, '_', 'fa parte del team Shine ma non ha nessun ruolo nel consiglio direttivo');

INSERT INTO `type_of_task_in_lesson` (`id`, `name`, `pay_per_h`)
VALUES (1, 'learning', 0.00),
       (2, 'assistant', 7.00),
       (3, 'coaching', 12.00);

INSERT INTO `course` (`id`, `name`, `year`, `default_start_time`, `default_duration`)
VALUES (1, '4-5', '2021', '18:00', 1),
       (2, '6-7', '2021', '18:00', 1),
       (3, '8-9', '2021', '18:00', 1.30),
       (4, '10-11', '2021', '19:30', 1.30),
       (5, '12-13', '2021', '18:00', 2),
       (6, '14+', '2021', '19:00', 2),
       (7, 'Adults', '2021', '20:00', 1.30),
       (8, 'Adults', '2020', '20:00', 1.30),
       (9, 'Adults', '2022', '20:00', 1.30);

INSERT INTO `athlete` (`surname`, `name`, `fiscal_code`, `birthdate`, `address`, `city`, `cap`, `province`, `phone`,
                       `email`,
                       `medical_certificate`, `auto_certificate`, `course_id`)
VALUES ('Giacchini', 'Valerio', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, NULL),
       ('Biagi', 'Giacomo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Pierantoni', 'Lorenzo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Biagi', 'Giacomo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Pierantoni', 'Lorenzo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Biagi', 'Giacomo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Pierantoni', 'Lorenzo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Biagi', 'Giacomo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Pierantoni', 'Lorenzo', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 5),
       ('Gianmattina', 'Mattia', 'GCCVLR03TTTTTTTT', '2003-10-20', 'Via G. Morgagni 49', 'Classe', '48124', 'RA',
        '3347251873',
        'portasfiga1099@gmail.com', '2022-10-15', TRUE, 4);

INSERT INTO `team` (`id`, `role_id`)
VALUES (1, 4);

INSERT INTO `users` (`username`, `password`, `team`)
VALUES ('Valerio', '$2y$10$iz6wL4GZKyc6uSUgZ0Qkp.lRreQUJYgPC.tmsqyl9SllT2tj9I6L6', 1);