/* Users */
INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `phone`, `email`, `role`, `password`) VALUES
	('00e5c034-c3bb-11eb-bdac-c8d9d27b08b0', 'Admin', 'User', '2000-01-01', 411223344, 'admin@example.org', 'admin', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.'),
	('6e531678-c3bb-11eb-bdac-c8d9d27b08b0', 'Jon', 'Doe', '1965-03-15', 422334455, 'jon.doe@example.org', 'user', '$2y$10$N6uKSSojsqLm6gBeR.AiSeK.IdT/.xrJRVAhHC66vxHl.rwGQZ4l.');

/* Centers */
INSERT INTO `vaccination_centers` (`id`, `name`, `city`, `postalCode`, `address`) VALUES
	(1, 'Lotto Mons Expo', 'Mons', 7000, 'Avenue Thomas Edison 2'),
	(2, 'LOUVEXPO', 'La Louvière', 7100, 'Rue Arthur Delaby 7'),
	(3, 'Kursaal de Binche', 'Binche', 7130, 'Avenue Wanderpepen, 30');