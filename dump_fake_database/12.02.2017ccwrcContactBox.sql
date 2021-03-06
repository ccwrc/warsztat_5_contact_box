-- phpMyAdmin SQL Dump
-- version 4.6.5.2deb1+deb.cihar.com~xenial.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 12, 2017 at 02:45 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccwrcContactBox`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `houseNumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `flatNumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `person_id`, `city`, `street`, `houseNumber`, `flatNumber`) VALUES
(1, 1, 'warsaw po edycji', 'zwykły street po edycji', '22 po edycji', '2 po edycji'),
(2, 1, 'katowicce', 'street katowice', '1l;l;l;ll;', '234'),
(7, 13, 'Agencja', 'Universs', 'Denebola', 'DB4'),
(8, 15, '33', '33', '33', '33'),
(9, 15, '33', '33', '33', '33'),
(10, 18, 'warsaw po edycjiwww000', 'www000', 'www000', 'wwwww0000');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `person_id`, `address`, `type`) VALUES
(1, 1, 'www@w.pl', 'praca'),
(2, 13, 'stellar@fox.com', 'praca'),
(3, 13, 'letsparty@onibiza.elo', 'prywatny'),
(4, 15, '33@33.33', '33'),
(5, 15, '33@33.33', '33'),
(6, 13, 'zarejestruj@funky.com', 'spamowy'),
(7, 18, '3333@0000000000w.pl', 'www000');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `name`, `surname`, `description`, `photo`) VALUES
(1, 'Jan edycja', 'Kovalski edycja', 'opis jana edycji', ''),
(3, 'funky', 'koval', 'opis kovala', ''),
(4, 'funky', 'koval4', 'opis kovala4dsfgfg', ''),
(5, 'nowe imie', 'nowe nazwisko', 'nowy opis', NULL),
(8, 'z imie edit1111', 'z editt1111', 'z opis edit1111', NULL),
(10, 'valid name', 'valid surname', 'valid opis', NULL),
(13, 'Funky', 'Koval', 'Hulaka. Pijak. Awanturnik. Licencja gwiezdnego detektywa. Spoko gość, można iść na piwo.', NULL),
(15, 'imie grupa', 'nazwisko grupa', 'opis grupa', NULL),
(16, 'szukajka', 'FUNKY', 'qqqq', NULL),
(17, 'wewewwe', 'wewewe', 'wewewewe', NULL),
(18, 'Jan00000', 'Kowalski0000000', 'from Poland0000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `persons_groups`
--

CREATE TABLE `persons_groups` (
  `person_id` int(11) NOT NULL,
  `person_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `persons_groups`
--

INSERT INTO `persons_groups` (`person_id`, `person_group_id`) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 6),
(3, 1),
(4, 6),
(8, 1),
(8, 3),
(8, 5),
(13, 1),
(13, 3),
(13, 8),
(16, 6),
(18, 1),
(18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `person_group`
--

CREATE TABLE `person_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `person_group`
--

INSERT INTO `person_group` (`id`, `name`) VALUES
(1, 'Znajomi'),
(3, 'Zawodowcy'),
(5, 'test grupa'),
(6, 'Całkowicie nowa grupa po edycji'),
(8, 'Na piwo'),
(10, 'grupa dla jana00000');

-- --------------------------------------------------------

--
-- Table structure for table `phone`
--

CREATE TABLE `phone` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phone`
--

INSERT INTO `phone` (`id`, `person_id`, `number`, `type`) VALUES
(1, 1, '999', 'dom99'),
(2, 13, '123456789', 'praca'),
(3, 13, '987654321', 'priv'),
(8, 15, '33', '33'),
(9, 15, '33', '33'),
(10, 18, '111111100', '3e00000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81217BBB47` (`person_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E7927C74217BBB47` (`person_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `persons_groups`
--
ALTER TABLE `persons_groups`
  ADD PRIMARY KEY (`person_id`,`person_group_id`),
  ADD KEY `IDX_85191A63217BBB47` (`person_id`),
  ADD KEY `IDX_85191A636A127C70` (`person_group_id`);

--
-- Indexes for table `person_group`
--
ALTER TABLE `person_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_444F97DD217BBB47` (`person_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `person_group`
--
ALTER TABLE `person_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `phone`
--
ALTER TABLE `phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `FK_E7927C74217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `persons_groups`
--
ALTER TABLE `persons_groups`
  ADD CONSTRAINT `FK_85191A63217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_85191A636A127C70` FOREIGN KEY (`person_group_id`) REFERENCES `person_group` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `FK_444F97DD217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
