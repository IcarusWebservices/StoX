-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 aug 2020 om 20:54
-- Serverversie: 10.4.13-MariaDB
-- PHP-versie: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stocks`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `collections`
--

INSERT INTO `collections` (`id`, `name`) VALUES
(1, 'Componenten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `name` text NOT NULL,
  `collection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `items`
--

INSERT INTO `items` (`id`, `stock`, `name`, `collection`) VALUES
(4, 3, 'SN74LS86', 1),
(5, 2, 'CD74HCT541', 1),
(6, 1, 'MC14510B', 1),
(7, 1, 'HCF4511BE', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `meta`
--

CREATE TABLE `meta` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `meta_value` text NOT NULL,
  `metaschema_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `metaschema`
--

CREATE TABLE `metaschema` (
  `id` int(11) NOT NULL,
  `collection` int(11) NOT NULL,
  `meta_key` varchar(256) NOT NULL,
  `query_me` tinyint(1) NOT NULL,
  `is_enum` tinyint(1) NOT NULL,
  `enum_vals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `metaschema`
--

INSERT INTO `metaschema` (`id`, `collection`, `meta_key`, `query_me`, `is_enum`, `enum_vals`) VALUES
(2, 1, 'description', 1, 0, NULL),
(5, 1, 'Test', 1, 0, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `metaschema`
--
ALTER TABLE `metaschema`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `meta`
--
ALTER TABLE `meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `metaschema`
--
ALTER TABLE `metaschema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
