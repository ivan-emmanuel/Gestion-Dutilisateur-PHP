
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('admin','user') NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `password_confirmations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `password_confirmations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




INSERT INTO `users` (`id`, `login`, `email`, `password`, `name`, `type`, `confirmed_at`, `created_at`, `updated_at`) VALUES
	(1, 'tester1', 'tester1@gmail.com', '$2y$10$0oojpHoHWASs2J48vHs0x.8LgYs6l5vtI6BxYw3euc2EOvH7UiSYa', 'First tester', 'user', '2021-03-25 15:35:13', '2021-03-25 16:35:14', NULL),
	(2, 'tester2', 'tester2@gmail.com', '$2y$10$o/fXa17/WsuGB0xkeFAdKOESzCKfmPLT5OBXSukDf45jO8qCO7Xfa', 'Second tester', 'user', '2021-03-25 15:35:13', '2021-03-25 16:35:14', NULL),
	(3, 'tester3', 'tester3@gmail.com', '$2y$10$TW4vvECB/wiYrt6iAwwds./rxV1cPxXECxja4Dhjo4U82OSwHoLZ2', 'Third  tester', 'user', '2021-03-25 15:35:13', '2021-03-25 16:35:14', NULL),
	(4, 'tester4', 'tester4@gmail.com', '$2y$10$ef0EAtzv946.5qDLazEU2ONW41D8gQ2CWhbSJ3ZIwXdjlZd0LzW/e', 'fourth  tester', 'user', '2021-03-25 15:35:14', '2021-03-25 16:35:14', NULL);
