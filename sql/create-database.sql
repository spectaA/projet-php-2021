/* Database */
SET
    storage_engine = INNODB;

CREATE DATABASE IF NOT EXISTS vaccin_reservation;

USE vaccin_reservation;

/* Table Users */
CREATE TABLE IF NOT EXISTS `users` (
    `id` varchar(36) DEFAULT (UUID()),
    `firstname` varchar(100) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `birthday` date NOT NULL,
    `phone` int(10) unsigned NOT NULL,
    `email` varchar(320) NOT NULL,
    `role` enum('user', 'admin') NOT NULL,
    `password` varchar(255) NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

/* Table vaccination_centers */
CREATE TABLE IF NOT EXISTS `vaccination_centers` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(45) NOT NULL,
    `city` varchar(45) NOT NULL,
    `postalCode` int(4) unsigned zerofill NOT NULL,
    `address` varchar(100) NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

/* Table availabilities */
CREATE TABLE IF NOT EXISTS `availabilities` (
    `id` varchar(36) DEFAULT (UUID()),
    `user_id` varchar(36) NOT NULL,
    `center_id` int unsigned NOT NULL,
    `date` datetime NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE (`center_id`, `date`, `user_id`),
    KEY `fk_idx_availabilities_user_id` (`user_id`),
    CONSTRAINT `fk_availabilities_user_id` FOREIGN KEY `fk_idx_availabilities_user_id` (`user_id`) REFERENCES `users` (`id`),
    KEY `fk_idx_availabilities_center_id` (`center_id`),
    CONSTRAINT `fk_availabilities_center_id` FOREIGN KEY `fk_idx_availabilities_center_id` (`center_id`) REFERENCES `vaccination_centers` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;