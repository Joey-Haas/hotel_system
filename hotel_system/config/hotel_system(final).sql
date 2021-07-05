-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 jun 2021 om 16:34
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_system`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `available_rooms`
--

CREATE TABLE `available_rooms` (
  `idAvailability` int(11) NOT NULL,
  `available` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = available, 1 = occupied'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `available_rooms`
--

INSERT INTO `available_rooms` (`idAvailability`, `available`) VALUES
(1, 0),
(2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `available_rooms_has_hotel_rooms`
--

CREATE TABLE `available_rooms_has_hotel_rooms` (
  `available_rooms_idAvailability` int(11) NOT NULL DEFAULT 1,
  `hotel_rooms_idRoom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `available_rooms_has_hotel_rooms`
--

INSERT INTO `available_rooms_has_hotel_rooms` (`available_rooms_idAvailability`, `hotel_rooms_idRoom`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `checked_in`
--

CREATE TABLE `checked_in` (
  `idGuest` int(11) NOT NULL,
  `sFirstname` varchar(60) NOT NULL,
  `sLastname` varchar(60) NOT NULL,
  `sAddress` varchar(110) NOT NULL,
  `sMail` varchar(255) NOT NULL,
  `sPhone` varchar(40) NOT NULL,
  `dCheck_in` date NOT NULL,
  `dCheck_out` date NOT NULL,
  `hotel_rooms_idRoom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employees`
--

CREATE TABLE `employees` (
  `idEmployee` int(11) NOT NULL,
  `sFirstname` varchar(60) NOT NULL,
  `sLastname` varchar(60) NOT NULL,
  `sUsername` varchar(80) NOT NULL,
  `sPassword` varchar(255) NOT NULL,
  `sMail` varchar(255) NOT NULL,
  `dRegistered` datetime NOT NULL DEFAULT current_timestamp(),
  `employee_type_idEmployeetype` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `employees`
--

INSERT INTO `employees` (`idEmployee`, `sFirstname`, `sLastname`, `sUsername`, `sPassword`, `sMail`, `dRegistered`, `employee_type_idEmployeetype`) VALUES
(1, 'Joey', 'Haas', 'joey_admin', '$2y$10$WlG0V9qtGIpdqkxSYA/e8Omj4GcbS8q9FtY9mAGjfTd3gsEy.QjXK', 'jhaas.developer@gmail.com', '2021-06-08 13:59:58', 1),
(2, 'Justin', 'Hermans', 'justin_reception', '$2y$10$YAIFQSA/DwP2LOSeynX9p.w9L2vn0PC/Gezfya1m7l2xmuZh0pFTK', 'justinhermans@live.nl', '2021-06-08 14:57:30', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employee_type`
--

CREATE TABLE `employee_type` (
  `idEmployeetype` int(11) NOT NULL,
  `sType` varchar(20) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `employee_type`
--

INSERT INTO `employee_type` (`idEmployeetype`, `sType`) VALUES
(1, 'admin'),
(2, 'reception');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `hotel_rooms`
--

CREATE TABLE `hotel_rooms` (
  `idRoom` int(11) NOT NULL,
  `iRoomnumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `hotel_rooms`
--

INSERT INTO `hotel_rooms` (`idRoom`, `iRoomnumber`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `available_rooms`
--
ALTER TABLE `available_rooms`
  ADD PRIMARY KEY (`idAvailability`);

--
-- Indexen voor tabel `available_rooms_has_hotel_rooms`
--
ALTER TABLE `available_rooms_has_hotel_rooms`
  ADD PRIMARY KEY (`available_rooms_idAvailability`,`hotel_rooms_idRoom`),
  ADD KEY `fk_available_rooms_has_hotel_rooms_hotel_rooms1_idx` (`hotel_rooms_idRoom`),
  ADD KEY `fk_available_rooms_has_hotel_rooms_available_rooms1_idx` (`available_rooms_idAvailability`);

--
-- Indexen voor tabel `checked_in`
--
ALTER TABLE `checked_in`
  ADD PRIMARY KEY (`idGuest`),
  ADD KEY `fk_checked_in_hotel_rooms1_idx` (`hotel_rooms_idRoom`);

--
-- Indexen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`idEmployee`),
  ADD KEY `fk_employees_employee_type_idx` (`employee_type_idEmployeetype`);

--
-- Indexen voor tabel `employee_type`
--
ALTER TABLE `employee_type`
  ADD PRIMARY KEY (`idEmployeetype`);

--
-- Indexen voor tabel `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  ADD PRIMARY KEY (`idRoom`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `available_rooms`
--
ALTER TABLE `available_rooms`
  MODIFY `idAvailability` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `checked_in`
--
ALTER TABLE `checked_in`
  MODIFY `idGuest` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `idEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `employee_type`
--
ALTER TABLE `employee_type`
  MODIFY `idEmployeetype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `hotel_rooms`
--
ALTER TABLE `hotel_rooms`
  MODIFY `idRoom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `available_rooms_has_hotel_rooms`
--
ALTER TABLE `available_rooms_has_hotel_rooms`
  ADD CONSTRAINT `fk_available_rooms_has_hotel_rooms_available_rooms1` FOREIGN KEY (`available_rooms_idAvailability`) REFERENCES `available_rooms` (`idAvailability`),
  ADD CONSTRAINT `fk_available_rooms_has_hotel_rooms_hotel_rooms1` FOREIGN KEY (`hotel_rooms_idRoom`) REFERENCES `hotel_rooms` (`idRoom`);

--
-- Beperkingen voor tabel `checked_in`
--
ALTER TABLE `checked_in`
  ADD CONSTRAINT `fk_checked_in_hotel_rooms1` FOREIGN KEY (`hotel_rooms_idRoom`) REFERENCES `hotel_rooms` (`idRoom`);

--
-- Beperkingen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_employee_type` FOREIGN KEY (`employee_type_idEmployeetype`) REFERENCES `employee_type` (`idEmployeetype`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
