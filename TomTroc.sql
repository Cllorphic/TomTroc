-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 15 fév. 2026 à 21:33
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `TomTroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `image`, `is_available`, `created_at`) VALUES
(23, 7, 'Esther', 'Alabaster', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sollicitudin hendrerit massa, sed mattis mauris vulputate eu. Maecenas vestibulum eu odio ultrices lacinia. Maecenas vulputate, mauris sed aliquet ornare, metus velit commodo elit, a lobortis mi nulla in erat. Aliquam sit amet neque quis mauris cursus blandit in sed ante. Integer gravida consequat diam nec scelerisque. Fusce bibendum et arcu ac scelerisque. Ut porta ante ac erat mollis, in consequat nulla mollis.', 'public/uploads/books/book_1769776560_f5169192.jpg', 1, '2026-01-30 13:36:00'),
(24, 7, 'The Kinfolk Table', 'Nathan Williams', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sollicitudin hendrerit massa, sed mattis mauris vulputate eu. Maecenas vestibulum eu odio ultrices lacinia. Maecenas vulputate, mauris sed aliquet ornare, metus velit commodo elit, a lobortis mi nulla in erat. Aliquam sit amet neque quis mauris cursus blandit in sed ante. Integer gravida consequat diam nec scelerisque. Fusce bibendum et arcu ac scelerisque. Ut porta ante ac erat mollis, in consequat nulla mollis.', 'public/uploads/books/book_1769776627_12e0497c.jpg', 1, '2026-01-30 13:37:07'),
(25, 7, 'Wabi Sabi', 'Beth Kempton', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769794985_c472d81f.jpg', 1, '2026-01-30 18:43:05'),
(26, 7, 'Milk and Honey', 'Rupi Kaur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795027_73e94673.jpg', 1, '2026-01-30 18:43:47'),
(27, 7, 'Delight!', 'Justin Rossow', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795128_4edf0ee8.jpg', 0, '2026-01-30 18:45:28'),
(28, 7, 'Milwaukee Mission', 'Elder Cooper Low', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795206_63cbf6c4.jpg', 1, '2026-01-30 18:46:46'),
(29, 7, 'Minimalist Graphics', 'Julia Schonlon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795373_62dfdf7e.jpg', 1, '2026-01-30 18:49:33'),
(30, 7, 'Hygge', 'Meik Wiking', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795447_6480b942.jpg', 1, '2026-01-30 18:50:47'),
(31, 7, 'How Innovation Works', 'Matt Ridley', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795583_1921433e.jpg', 1, '2026-01-30 18:53:03'),
(32, 7, 'Psalms', 'Alabaster', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795619_4727b698.jpg', 1, '2026-01-30 18:53:39'),
(33, 7, 'Thinking, Fast and Slow', 'Daniel Kahneman', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795667_bfaaebd3.jpg', 1, '2026-01-30 18:54:27'),
(34, 7, 'A Book Full Of Hope', 'Rupi Kaur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi euismod enim metus, non blandit ante fringilla molestie. Nam lacus neque, convallis at erat auctor, pulvinar sodales justo. Curabitur sodales nisi in luctus fermentum. Aenean ac rutrum tellus. Nulla pretium sagittis leo. Phasellus id sem dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget ornare lectus. Nulla commodo turpis ornare magna vestibulum, at cursus justo commodo. Nullam hendrerit laoreet feugiat. Aenean quis tellus non risus vulputate fermentum. Maecenas laoreet ac neque a dictum. Ut scelerisque tristique felis sit amet commodo. Sed luctus fringilla quam vel facilisis.', 'public/uploads/books/book_1769795722_4f3f1d3f.jpg', 1, '2026-01-30 18:55:22'),
(35, 8, 'The Subtle Art Of Not Giving A Fuck', 'Mark Manson', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pretium mi consectetur risus vulputate malesuada. Quisque aliquam feugiat sem, eu lacinia lorem scelerisque vitae. Phasellus laoreet, elit at fermentum egestas, odio justo tincidunt felis, eget cursus ante enim vel massa. Duis sollicitudin ipsum non purus tempor, quis blandit nibh lacinia. Ut nisl magna, rhoncus quis arcu eu, interdum laoreet metus. Morbi vitae nisi a erat consectetur semper nec sed libero. Quisque ultrices arcu non feugiat scelerisque. Aenean id justo sed lacus scelerisque bibendum eget et ex. Fusce ut tortor ac metus euismod suscipit. Curabitur ut ultricies nibh. Vestibulum ullamcorper viverra ullamcorper. Maecenas id ex nec nunc ullamcorper venenatis maximus sed sem. Donec eget vestibulum velit. Donec ligula nisl, molestie et porttitor eget, maximus non orci. Sed tempus mi ut nisi lobortis commodo.', 'public/uploads/books/book_1770135845_edd42ea0.jpg', 1, '2026-02-03 17:24:05');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_one_id` int(11) NOT NULL,
  `user_two_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pair_key` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `user_one_id`, `user_two_id`, `created_at`, `updated_at`, `pair_key`) VALUES
(1, 7, 8, '2026-02-08 17:17:37', '2026-02-13 15:08:58', '7_8');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `body`, `created_at`, `is_read`) VALUES
(1, 1, 7, 'Salut !', '2026-02-08 17:44:09', 1),
(2, 1, 8, 'Salut !', '2026-02-08 17:45:38', 1),
(3, 1, 7, 'Je suis intéressé par votre livre, est-il toujours disponible ?', '2026-02-08 17:54:31', 1),
(4, 1, 8, 'Oui', '2026-02-08 18:07:22', 1),
(5, 1, 7, 'Bonjour !', '2026-02-13 15:08:58', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `avatar`) VALUES
(7, 'Admin', 'admin12@gmail.com', '$2y$10$GGgdMwbrOh.crtNa4Qi4V.KiSZ25Deg5jHGtIQkqDV.eYVacqh0de', '2026-01-29 23:15:51', 'public/uploads/avatars/avatar_u7_1769725052.jpg'),
(8, 'Jean Dupont', 'jeandupont@gmail.com', '$2y$10$9JfLv.TKhbZ8TBFLKcmMje5o3oekp57jMXLNlanXQQmEB4auzV1W.', '2026-02-03 17:20:58', 'public/uploads/avatars/avatar_u8_1770135735.webp');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_user` (`user_id`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_pair` (`pair_key`),
  ADD KEY `user_one_id` (`user_one_id`),
  ADD KEY `user_two_id` (`user_two_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `idx_conv_date` (`conversation_id`,`created_at`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_ibfk_2` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
