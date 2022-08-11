/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

DROP DATABASE IF EXISTS `shine`;
CREATE DATABASE `shine`;
USE `shine`;

CREATE TABLE `shine`.`team`
(
    `id`          INT         NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    `image`       VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `shine`.`users`
(
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(16)  NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `team`     int          NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`team`) REFERENCES `team`(`id`)
);

INSERT INTO `shine`.`team` (`name`, `description`, `image`) VALUES
('Valerio', 'a', 'a');

INSERT INTO `shine`.`users` (`username`, `password`, `team`) VALUES
('Valerio', '$2y$10$iz6wL4GZKyc6uSUgZ0Qkp.lRreQUJYgPC.tmsqyl9SllT2tj9I6L6', 1);