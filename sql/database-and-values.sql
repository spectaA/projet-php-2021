/* Database */
CREATE DATABASE IF NOT EXISTS `vaccin_reservation`;

USE `vaccin_reservation`;

/* Table Users */
CREATE TABLE IF NOT EXISTS `users` (
    `id` varchar(36) DEFAULT (UUID()),
    `firstname` varchar(100) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `birthday` date NOT NULL,
    `phone` int(10) unsigned ZEROFILL NOT NULL,
    `email` varchar(320) NOT NULL,
    `role` enum('user', 'admin') NOT NULL,
    `password` varchar(255) NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE (`email`)
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
    CONSTRAINT `fk_availabilities_user_id`
        FOREIGN KEY `fk_idx_availabilities_user_id` (`user_id`)
        REFERENCES `users` (`id`)
        ON DELETE CASCADE,
    KEY `fk_idx_availabilities_center_id` (`center_id`),
    CONSTRAINT `fk_availabilities_center_id`
        FOREIGN KEY `fk_idx_availabilities_center_id` (`center_id`)
        REFERENCES `vaccination_centers` (`id`)
        ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

/* ========================= DEFAULT VALUES ==================== */

/* Users */
INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `phone`, `email`, `role`, `password`) VALUES
	('00e5c034-c3bb-11eb-bdac-c8d9d27b08b0', 'Admin', 'User', '2000-01-01', 411223344, 'admin@example.org', 'admin', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.'),
	('6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 'Jon', 'Doe', '1965-03-15', 422334455, 'jon.doe@example.org', 'user', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.'),
	('4f45179c-ab17-40f6-9032-21a671fe1bdc', 'Jane', 'Jackson', '1952-09-12', 433445566, 'jane.jackson@example.org', 'user', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.'),
	('9444366d-8a42-43cd-bdc6-0b972932999e', 'Miley', 'Reed', '2000-12-25', 455667788, 'miley.reed@example.org', 'user', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.');

/* Centers */
INSERT INTO `vaccination_centers` (`id`, `name`, `city`, `postalCode`, `address`) VALUES
	(1, 'Lotto Mons Expo', 'Mons', 7000, 'Avenue Thomas Edison 2'),
	(2, 'LOUVEXPO', 'La Louvière', 7100, 'Rue Arthur Delaby 7'),
	(3, 'Kursaal de Binche', 'Binche', 7130, 'Avenue Wanderpepen, 30');

/* Availabilities */
INSERT INTO `availabilities` (`id`, `user_id`, `center_id`, `date`) VALUES
	/* User: Jon Doe */
	('38b4688f-c3ff-11eb-bdac-c8d9d27b08b0', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 1, '2021-06-20 09:00:00'),
	('e50ddc8a-f2f4-4341-a64e-375e75d8f1cd', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 2, '2021-06-20 09:00:00'),
	('2f95e590-c3ff-11eb-bdac-c8d9d27b08b0', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 1, '2021-06-20 10:00:00'),
	('577f6953-6ffa-4459-b177-1be1727dc57f', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 2, '2021-06-20 10:00:00'),
	('0df47b54-c452-11eb-bdac-c8d9d27b08b0', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 1, '2021-06-21 15:00:00'),
	('eca9580d-3e1e-4bdd-baf1-64e218ee34ef', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 2, '2021-06-21 15:00:00'),
	('1362ee38-c452-11eb-bdac-c8d9d27b08b0', '6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 1, '2021-06-22 19:00:00'),
	/* User: Jane Jackson */
	('dca26682-ad19-474c-8396-25e666515090', '4f45179c-ab17-40f6-9032-21a671fe1bdc', 3, '2021-06-22 07:00:00'),
	('38715296-54fa-4650-922f-c082592d30ed', '4f45179c-ab17-40f6-9032-21a671fe1bdc', 3, '2021-06-22 08:00:00'),
	('db0e21c3-e708-4d46-bb95-52b2fb97c64d', '4f45179c-ab17-40f6-9032-21a671fe1bdc', 3, '2021-06-22 09:00:00'),
	('af4bb867-99c8-42d3-be7e-11e398edd7be', '4f45179c-ab17-40f6-9032-21a671fe1bdc', 3, '2021-06-22 13:00:00'),
	/* User: Miley Reed */
	('9f56035a-71e6-4ec0-8fd5-e6a5f15f3b61', '9444366d-8a42-43cd-bdc6-0b972932999e', 1, '2021-06-22 13:00:00'),
	('cbe18fd9-b958-450f-b4ec-15fa17a8297a', '9444366d-8a42-43cd-bdc6-0b972932999e', 1, '2021-06-22 14:00:00'),
	('b8d9fcd9-bf31-49f7-8ce1-1011362549c4', '9444366d-8a42-43cd-bdc6-0b972932999e', 2, '2021-06-22 13:00:00'),
	('8d354e75-527a-4006-b063-81ceb7fd3097', '9444366d-8a42-43cd-bdc6-0b972932999e', 2, '2021-06-22 14:00:00'),
	('622ac2af-124b-4b0a-af77-3172145b721e', '9444366d-8a42-43cd-bdc6-0b972932999e', 3, '2021-06-22 08:00:00');
