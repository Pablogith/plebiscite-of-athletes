-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 15 Cze 2021, 19:14
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ranking-sbd`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Athletes`
--

CREATE TABLE `Athletes` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Gender` enum('men','woman') NOT NULL,
  `Status` enum('active','passive') NOT NULL,
  `Trophies` int(255) NOT NULL DEFAULT 0,
  `DyscyplineId` int(11) NOT NULL,
  `Coach` varchar(255) DEFAULT NULL,
  `Comments` text DEFAULT NULL,
  `CountOfPositiveRates` int(11) NOT NULL DEFAULT 0,
  `CountOfNegativeRates` int(11) NOT NULL DEFAULT 0,
  `Img` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `Athletes`
--

INSERT INTO `Athletes` (`Id`, `FirstName`, `LastName`, `Gender`, `Status`, `Trophies`, `DyscyplineId`, `Coach`, `Comments`, `CountOfPositiveRates`, `CountOfNegativeRates`, `Img`) VALUES
(26, 'Mariola', 'Tynkiewicz', 'woman', 'passive', 2, 5, 'Brak', NULL, 4, 1, ''),
(33, 'Natalia', 'Sienkiewicz', 'woman', 'active', 0, 5, NULL, NULL, 3, 0, ''),
(36, 'Rafał', 'Kozowski', 'men', 'active', 0, 2, NULL, NULL, 1, 4, ''),
(68, 'Anastazja', 'Koństanczyk', 'woman', 'passive', 0, 12, NULL, NULL, 7, 2, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Disciplines`
--

CREATE TABLE `Disciplines` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Season` enum('all_ year_round','summer','winter') NOT NULL,
  `NumberOfAthletes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `Disciplines`
--

INSERT INTO `Disciplines` (`Id`, `Name`, `Season`, `NumberOfAthletes`) VALUES
(1, 'Piłka nożna', 'summer', 0),
(2, 'Siatkówka', 'all_ year_round', 1),
(5, 'Łyżwy', 'winter', 2),
(12, 'Tenis', 'all_ year_round', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE `Messages` (
  `Id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `Athletes`
--
ALTER TABLE `Athletes`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `Disciplines`
--
ALTER TABLE `Disciplines`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Athletes`
--
ALTER TABLE `Athletes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT dla tabeli `Disciplines`
--
ALTER TABLE `Disciplines`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `Messages`
--
ALTER TABLE `Messages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
