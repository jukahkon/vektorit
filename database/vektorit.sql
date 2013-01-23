-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Palvelin: localhost
-- Luontiaika: 23.01.2013 klo 11:18
-- Palvelimen versio: 5.5.29
-- PHP:n versio: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tietokanta: `vektorit`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `step` (`step`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `route`
--

CREATE TABLE IF NOT EXISTS `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `length` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `step`
--

CREATE TABLE IF NOT EXISTS `step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `distance` double NOT NULL,
  `heading` int(11) NOT NULL,
  `route` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `route` (`route`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=620 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `trip`
--

CREATE TABLE IF NOT EXISTS `trip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `distance` float(5,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_swedish_ci NOT NULL,
  `team` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `team` (`team`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci AUTO_INCREMENT=43 ;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`step`) REFERENCES `step` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Rajoitteet taululle `step`
--
ALTER TABLE `step`
  ADD CONSTRAINT `step_ibfk_1` FOREIGN KEY (`route`) REFERENCES `route` (`id`) ON UPDATE CASCADE;

--
-- Rajoitteet taululle `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Rajoitteet taululle `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`team`) REFERENCES `team` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
