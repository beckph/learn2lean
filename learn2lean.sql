-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 12. Mai 2020 um 18:33
-- Server-Version: 10.1.35-MariaDB
-- PHP-Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `learn2lean`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anleitungs_endproduktimage`
--

CREATE TABLE `anleitungs_endproduktimage` (
  `AnleitungsEndProduktID` int(11) NOT NULL,
  `EndProduktID` int(11) NOT NULL,
  `EndProduktImage` varchar(100) NOT NULL,
  `MontageSchritt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `anleitungs_endproduktimage`
--

INSERT INTO `anleitungs_endproduktimage` (`AnleitungsEndProduktID`, `EndProduktID`, `EndProduktImage`, `MontageSchritt`) VALUES
(1, 1, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_1.png', 1),
(2, 1, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_2.png', 2),
(3, 1, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_3_Weiss.png', 3),
(4, 1, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_4_Weiss.png', 4),
(5, 2, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_1.png', 1),
(6, 2, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_2.png', 2),
(7, 2, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_3_Weiss.png', 3),
(8, 2, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_4_Weiss.png', 4),
(9, 3, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_1.png', 1),
(10, 3, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_2.png', 2),
(11, 3, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_3_Weiss.png', 3),
(12, 3, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_4_Weiss.png', 4),
(13, 4, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_1.png', 1),
(14, 4, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_2.png', 2),
(15, 4, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_3_Weiss.png', 3),
(16, 4, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_4_Weiss.png', 4),
(17, 5, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_1.png', 1),
(18, 5, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_2.png', 2),
(19, 5, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_3_Weiss.png', 3),
(20, 5, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_4_Weiss.png', 4),
(21, 6, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_1.png', 1),
(22, 6, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_2.png', 2),
(23, 6, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_3_Weiss.png', 3),
(24, 6, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_4_Weiss.png', 4),
(25, 7, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_1.png', 1),
(26, 7, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_2.png', 2),
(27, 7, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_3_Schwarz.png', 3),
(28, 7, 'Images/LegoBricks/Anleitungen/5_Station/Blau/Schritt_4_Schwarz.png', 4),
(29, 8, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_1.png', 1),
(30, 8, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_2.png', 2),
(31, 8, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_3_Schwarz.png', 3),
(32, 8, 'Images/LegoBricks/Anleitungen/5_Station/Gelb/Schritt_4_Schwarz.png', 4),
(33, 9, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_1.png', 1),
(34, 9, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_2.png', 2),
(35, 9, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_3_Schwarz.png', 3),
(36, 9, 'Images/LegoBricks/Anleitungen/5_Station/Gruen/Schritt_4_Schwarz.png', 4),
(37, 10, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_1.png', 1),
(38, 10, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_2.png', 2),
(39, 10, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_3_Schwarz.png', 3),
(40, 10, 'Images/LegoBricks/Anleitungen/5_Station/Rot/Schritt_4_Schwarz.png', 4),
(41, 11, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_1.png', 1),
(42, 11, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_2.png', 2),
(43, 11, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_3_Schwarz.png', 3),
(44, 11, 'Images/LegoBricks/Anleitungen/5_Station/Lila/Schritt_4_Schwarz.png', 4),
(45, 12, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_1.png', 1),
(46, 12, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_2.png', 2),
(47, 12, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_3_Schwarz.png', 3),
(48, 12, 'Images/LegoBricks/Anleitungen/5_Station/Orange/Schritt_4_Schwarz.png', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anleitungs_teilproduktimage`
--

CREATE TABLE `anleitungs_teilproduktimage` (
  `AnleitungsTeilProduktID` int(11) NOT NULL,
  `TeilProduktID` int(50) NOT NULL,
  `TeilProduktImage` varchar(100) NOT NULL,
  `MontageSchritt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `anleitungs_teilproduktimage`
--

INSERT INTO `anleitungs_teilproduktimage` (`AnleitungsTeilProduktID`, `TeilProduktID`, `TeilProduktImage`, `MontageSchritt`) VALUES
(1, 1, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_1_Weiss.png', 1),
(2, 1, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Weiss.png', 2),
(3, 2, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_3.png', 3),
(4, 4, 'Images/LegoBricks/Anleitungen/2_Station/Weiss/Schritt_1.png', 1),
(5, 4, 'Images/LegoBricks/Anleitungen/2_Station/Weiss/Schritt_2.png', 2),
(6, 7, 'Images/LegoBricks/Anleitungen/2_Station/Gelb/Schritt_1.png', 1),
(7, 7, 'Images/LegoBricks/Anleitungen/2_Station/Gelb/Schritt_2.png', 2),
(8, 3, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGelb\\Schritt_1.png', 1),
(9, 3, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGelb\\Schritt_2.png', 2),
(10, 3, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGelb\\Schritt_3.png', 3),
(11, 3, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGelb\\Schritt_4.png', 4),
(16, 6, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGrauRot\\Schritt_1.png', 1),
(17, 6, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGrauRot\\Schritt_2.png', 2),
(18, 6, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGrauRot\\Schritt_3.png', 3),
(19, 6, 'Images\\LegoBricks\\Anleitungen\\3_Station\\SchwarzGrauRot\\Schritt_4.png', 4),
(20, 5, 'Images\\LegoBricks\\Anleitungen\\4_Station\\SchwarzGelbRot\\Schritt_1.png', 1),
(21, 5, 'Images\\LegoBricks\\Anleitungen\\4_Station\\SchwarzGelbRot\\Schritt_2.png', 2),
(22, 8, 'Images\\LegoBricks\\Anleitungen\\4_Station\\SchwarzGrauRot\\Schritt_1.png', 1),
(23, 8, 'Images\\LegoBricks\\Anleitungen\\4_Station\\SchwarzGrauRot\\Schritt_2.png', 2),
(24, 9, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_1_Schwarz.jpg', 1),
(25, 9, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Schwarz.jpg', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anlieferungen`
--

CREATE TABLE `anlieferungen` (
  `AnlieferungsID` int(11) NOT NULL,
  `SteinID` int(11) NOT NULL,
  `StationsID` int(11) NOT NULL,
  `AnzahlSteine` int(11) NOT NULL,
  `StatusAnlieferung` int(11) NOT NULL,
  `BoxID` int(11) DEFAULT NULL,
  `SpielID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `BestellungsID` int(11) NOT NULL,
  `EndProduktID` int(11) NOT NULL,
  `BestellStartzeit` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `BestellEndzeit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `StatusProduktionsleiter` int(2) NOT NULL DEFAULT '0',
  `Produktionsleiter_timestamp` timestamp NULL DEFAULT NULL,
  `ProduktionsReihenfolge` int(11) NOT NULL,
  `Takt` int(5) NOT NULL,
  `StatusStation1` int(11) NOT NULL DEFAULT '0',
  `Station1_timestamp` timestamp NULL DEFAULT NULL,
  `StatusStation2` int(11) NOT NULL DEFAULT '0',
  `Station2_timestamp` timestamp NULL DEFAULT NULL,
  `StatusStation3` int(11) NOT NULL DEFAULT '0',
  `Station3_timestamp` timestamp NULL DEFAULT NULL,
  `StatusStation4` int(11) NOT NULL DEFAULT '0',
  `Station4_timestamp` timestamp NULL DEFAULT NULL,
  `StatusStation5` int(11) NOT NULL DEFAULT '0',
  `Station5_timestamp` timestamp NULL DEFAULT NULL,
  `StatusQuality` int(11) NOT NULL DEFAULT '0',
  `Quality_timestamp` timestamp NULL DEFAULT NULL,
  `AnzahlRetoureQuality` int(5) NOT NULL DEFAULT '0',
  `StatusKunde` int(11) NOT NULL DEFAULT '0',
  `Kunde_timestamp` timestamp NULL DEFAULT NULL,
  `AnzahlRetoureKunde` int(5) NOT NULL DEFAULT '0',
  `SpielID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `endprodukt`
--

CREATE TABLE `endprodukt` (
  `EndProduktID` int(11) NOT NULL,
  `EndProduktBezeichnung` varchar(30) NOT NULL,
  `Station` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `EndProduktImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `endprodukt`
--

INSERT INTO `endprodukt` (`EndProduktID`, `EndProduktBezeichnung`, `Station`, `Status`, `EndProduktImage`) VALUES
(1, 'Produkt Blau I', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Blau.png'),
(2, 'Produkt Gelb I', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Gelb.png'),
(3, 'Produkt Gruen I', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Gruen.png'),
(4, 'Produkt Rot I', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Rot.png'),
(5, 'Produkt Lila I', 5, 0, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Lila.png'),
(6, 'Produkt Orange I', 5, 0, 'Images/LegoBricks/FertigeProdukte/WA_Weiss/Produkt_Orange.png'),
(7, 'Produkt Blau II', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Blau.png'),
(8, 'Produkt Gelb II', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Gelb.png'),
(9, 'Produkt Gruen II', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Gruen.png'),
(10, 'Produkt Rot II', 5, 1, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Rot.png'),
(11, 'Produkt Lila II', 5, 0, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Lila.png'),
(12, 'Produkt Orange II', 5, 0, 'Images/LegoBricks/FertigeProdukte/WA_Schwarz/Produkt_Orange.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `endprodukt_teilprodukt`
--

CREATE TABLE `endprodukt_teilprodukt` (
  `EndProduktID` int(11) NOT NULL,
  `TeilProduktID` int(11) NOT NULL,
  `StationsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `endprodukt_teilprodukt`
--

INSERT INTO `endprodukt_teilprodukt` (`EndProduktID`, `TeilProduktID`, `StationsID`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 1, 1),
(2, 2, 1),
(3, 1, 1),
(3, 2, 1),
(4, 1, 1),
(4, 2, 1),
(5, 1, 1),
(5, 2, 1),
(6, 1, 1),
(6, 2, 1),
(7, 2, 1),
(7, 9, 1),
(8, 2, 1),
(8, 9, 1),
(9, 2, 1),
(9, 9, 1),
(10, 2, 1),
(10, 9, 1),
(11, 2, 1),
(11, 9, 1),
(12, 2, 1),
(12, 9, 1),
(1, 4, 2),
(2, 7, 2),
(3, 7, 2),
(4, 4, 2),
(5, 4, 2),
(6, 7, 2),
(7, 4, 2),
(8, 7, 2),
(9, 7, 2),
(10, 4, 2),
(11, 4, 2),
(12, 7, 2),
(1, 3, 3),
(2, 3, 3),
(3, 6, 3),
(4, 6, 3),
(5, 3, 3),
(6, 3, 3),
(7, 3, 3),
(8, 3, 3),
(9, 6, 3),
(10, 6, 3),
(11, 3, 3),
(12, 3, 3),
(1, 5, 4),
(2, 5, 4),
(3, 8, 4),
(4, 8, 4),
(5, 8, 4),
(6, 8, 4),
(7, 5, 4),
(8, 5, 4),
(9, 8, 4),
(10, 8, 4),
(11, 8, 4),
(12, 8, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logistik`
--

CREATE TABLE `logistik` (
  `LogistikID` int(10) NOT NULL,
  `SteinID` int(11) NOT NULL,
  `StationsID` int(11) NOT NULL,
  `AutobestellungGrenze` int(11) NOT NULL,
  `EmpfohleneLieferMenge` int(11) NOT NULL,
  `MaximaleGrenze` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Daten für Tabelle `logistik`
--

INSERT INTO `logistik` (`LogistikID`, `SteinID`, `StationsID`, `AutobestellungGrenze`, `EmpfohleneLieferMenge`, `MaximaleGrenze`) VALUES
(1, 1, 1, 50, 50, 50),
(2, 2, 1, 20, 50, 50),
(3, 3, 1, 20, 50, 60),
(4, 4, 1, 10, 50, 30),
(5, 5, 1, 0, 50, 0),
(6, 6, 1, 0, 50, 0),
(7, 7, 1, 10, 50, 30),
(8, 8, 1, 0, 50, 0),
(9, 9, 1, 0, 50, 0),
(10, 10, 1, 0, 50, 0),
(11, 1, 2, 0, 50, 0),
(12, 2, 2, 0, 50, 0),
(13, 3, 2, 0, 50, 0),
(14, 4, 2, 40, 50, 80),
(15, 5, 2, 0, 50, 0),
(16, 6, 2, 40, 50, 80),
(17, 7, 2, 0, 50, 0),
(18, 8, 2, 0, 50, 0),
(19, 9, 2, 0, 50, 0),
(20, 10, 2, 0, 50, 0),
(21, 1, 3, 0, 50, 0),
(22, 2, 3, 0, 50, 0),
(23, 3, 3, 0, 50, 0),
(24, 4, 3, 0, 50, 0),
(25, 5, 3, 30, 50, 40),
(26, 6, 3, 40, 50, 60),
(27, 7, 3, 20, 50, 30),
(28, 8, 3, 0, 50, 0),
(29, 9, 3, 40, 50, 60),
(30, 10, 3, 30, 50, 40),
(31, 1, 4, 0, 50, 0),
(32, 2, 4, 0, 50, 0),
(33, 3, 4, 0, 50, 0),
(34, 4, 4, 0, 50, 0),
(35, 5, 4, 0, 50, 0),
(36, 6, 4, 0, 50, 0),
(37, 7, 4, 0, 50, 0),
(38, 8, 4, 50, 50, 80),
(39, 9, 4, 0, 50, 0),
(40, 10, 4, 50, 50, 80);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiel`
--

CREATE TABLE `spiel` (
  `SpielID` int(11) NOT NULL,
  `Bezeichnung` text NOT NULL,
  `Status` int(11) NOT NULL,
  `SpielModusBestellungen` int(11) NOT NULL,
  `SpielStartzeit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SpielEndzeit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Takt` int(10) NOT NULL,
  `AnzahlHilfeStation1` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeStation2` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeStation3` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeStation4` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeStation5` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeQuality` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeLogistik` int(5) NOT NULL DEFAULT '0',
  `AnzahlHilfeMeister` int(5) NOT NULL DEFAULT '0',
  `AnalyticsSpielID1` int(10) NOT NULL DEFAULT '0',
  `AnalyticsSpielID2` int(10) NOT NULL DEFAULT '0',
  `AnalyticsSpielID3` int(10) NOT NULL DEFAULT '0',
  `MaterialstandUebernahme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `spiel`
--

INSERT INTO `spiel` (`SpielID`, `Bezeichnung`, `Status`, `SpielModusBestellungen`, `SpielStartzeit`, `SpielEndzeit`, `Takt`, `AnzahlHilfeStation1`, `AnzahlHilfeStation2`, `AnzahlHilfeStation3`, `AnzahlHilfeStation4`, `AnzahlHilfeStation5`, `AnzahlHilfeQuality`, `AnzahlHilfeLogistik`, `AnzahlHilfeMeister`, `AnalyticsSpielID1`, `AnalyticsSpielID2`, `AnalyticsSpielID3`, `MaterialstandUebernahme`) VALUES
(1, 'Psydo Resetspiel', 3, 2, '2020-05-12 18:32:26', '0000-00-00 00:00:00', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stationen`
--

CREATE TABLE `stationen` (
  `StationsID` int(11) NOT NULL,
  `StationsBezeichnung` varchar(30) NOT NULL,
  `StatusHilfe` int(11) NOT NULL,
  `AkkustandMaterialstation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `stationen`
--

INSERT INTO `stationen` (`StationsID`, `StationsBezeichnung`, `StatusHilfe`, `AkkustandMaterialstation`) VALUES
(1, 'Station 1 - Werkzeugaufnahme', 0, 100),
(2, 'Station 2 - Dach', 0, 100),
(3, 'Station 3 - Tischfuss', 0, 100),
(4, 'Station 4 - Tischplatte', 0, 100),
(5, 'Station 5 - Endmontage', 0, 100),
(6, 'Station 6 - Qualitaetskontroll', 0, 100),
(7, 'Station 7 - Logistik', 0, 100),
(8, 'Station 8 - Meister', 0, 100);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `steine`
--

CREATE TABLE `steine` (
  `SteinID` int(11) NOT NULL,
  `SteinBezeichnung` varchar(50) NOT NULL,
  `SteinImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `steine`
--

INSERT INTO `steine` (`SteinID`, `SteinBezeichnung`, `SteinImage`) VALUES
(1, '2x2 Blau', 'Images/LegoBricks/Bausteine/Blau/2x2.png'),
(2, '2x4 Blau', 'Images/LegoBricks/Bausteine/Blau/2x4.png'),
(3, '1x4 Weiss', 'Images/LegoBricks/Bausteine/Weiss/1x4.png'),
(4, '2x4 Weiss', 'Images/LegoBricks/Bausteine/Weiss/2x4.png'),
(5, '2x2 Gelb', 'Images/LegoBricks/Bausteine/Gelb/2x2.png'),
(6, '2x4 Gelb', 'Images/LegoBricks/Bausteine/Gelb/2x4.png'),
(7, '2x4 Schwarz', 'Images/LegoBricks/Bausteine/Schwarz/2x4.png'),
(8, '2x2 Grau', 'Images/LegoBricks/Bausteine/Grau/2x2.png'),
(9, '2x4 Grau', 'Images/LegoBricks/Bausteine/Grau/2x4.png'),
(10, '2x2 Rot', 'Images/LegoBricks/Bausteine/Rot/2x2.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilprodukt`
--

CREATE TABLE `teilprodukt` (
  `TeilProduktID` int(11) NOT NULL,
  `TeilProduktBezeichnung` varchar(50) NOT NULL,
  `Station` int(11) NOT NULL,
  `Status` int(10) NOT NULL,
  `TeilProduktImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teilprodukt`
--

INSERT INTO `teilprodukt` (`TeilProduktID`, `TeilProduktBezeichnung`, `Station`, `Status`, `TeilProduktImage`) VALUES
(1, 'Werkzeugaufnahme_Weiss', 1, 1, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Weiss.png'),
(2, 'Rückwand_Weiss', 1, 1, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_3.png'),
(3, 'Tischfuss_Gelb', 3, 1, 'Images/LegoBricks/Anleitungen/3_Station/SchwarzGelb/Schritt_4.png'),
(4, 'Dach_Weiss', 2, 1, 'Images/LegoBricks/Anleitungen/2_Station/Weiss/Schritt_1.png'),
(5, 'Tischplatte_Rot', 4, 1, 'Images/LegoBricks/Anleitungen/4_Station/SchwarzGelbRot/Schritt_1.png'),
(6, 'Tischfuss_Grau', 3, 1, 'Images/LegoBricks/Anleitungen/3_Station/SchwarzGrauRot/Schritt_4.png'),
(7, 'Dach_Gelb', 2, 1, 'Images/LegoBricks/Anleitungen/2_Station/Gelb/Schritt_1.png'),
(8, 'Tischplatte_Grau', 4, 1, 'Images/LegoBricks/Anleitungen/4_Station/SchwarzGrauRot/Schritt_1.png'),
(9, 'Werkzeugaufnahme_Schwarz', 1, 0, 'Images/LegoBricks/Anleitungen/1_Station/Schritt_2_Schwarz.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teilprodukt_steine`
--

CREATE TABLE `teilprodukt_steine` (
  `TeilProduktID` int(11) NOT NULL,
  `SteinID` int(11) NOT NULL,
  `AnzahlSteine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teilprodukt_steine`
--

INSERT INTO `teilprodukt_steine` (`TeilProduktID`, `SteinID`, `AnzahlSteine`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 4, 1),
(2, 3, 4),
(3, 5, 4),
(3, 6, 8),
(3, 7, 2),
(4, 4, 8),
(5, 10, 12),
(6, 7, 2),
(6, 9, 8),
(6, 10, 4),
(7, 6, 8),
(8, 8, 12),
(9, 1, 2),
(9, 2, 2),
(9, 7, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `anleitungs_endproduktimage`
--
ALTER TABLE `anleitungs_endproduktimage`
  ADD PRIMARY KEY (`AnleitungsEndProduktID`),
  ADD KEY `EndProduktID-Verknüpfung` (`EndProduktID`);

--
-- Indizes für die Tabelle `anleitungs_teilproduktimage`
--
ALTER TABLE `anleitungs_teilproduktimage`
  ADD PRIMARY KEY (`AnleitungsTeilProduktID`),
  ADD KEY `TeilProduktID-Verknüpfung` (`TeilProduktID`);

--
-- Indizes für die Tabelle `anlieferungen`
--
ALTER TABLE `anlieferungen`
  ADD PRIMARY KEY (`AnlieferungsID`),
  ADD KEY `StationsID` (`StationsID`),
  ADD KEY `SteinID` (`SteinID`),
  ADD KEY `SpielID` (`SpielID`);

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`BestellungsID`),
  ADD KEY `EndProduktID` (`EndProduktID`),
  ADD KEY `SpielID` (`SpielID`);

--
-- Indizes für die Tabelle `endprodukt`
--
ALTER TABLE `endprodukt`
  ADD PRIMARY KEY (`EndProduktID`);

--
-- Indizes für die Tabelle `endprodukt_teilprodukt`
--
ALTER TABLE `endprodukt_teilprodukt`
  ADD PRIMARY KEY (`EndProduktID`,`TeilProduktID`),
  ADD KEY `TeilProduktID` (`TeilProduktID`),
  ADD KEY `StationsID_Stationen` (`StationsID`);

--
-- Indizes für die Tabelle `logistik`
--
ALTER TABLE `logistik`
  ADD PRIMARY KEY (`LogistikID`),
  ADD KEY `StationsID` (`StationsID`),
  ADD KEY `SteinID` (`SteinID`);

--
-- Indizes für die Tabelle `spiel`
--
ALTER TABLE `spiel`
  ADD PRIMARY KEY (`SpielID`);

--
-- Indizes für die Tabelle `stationen`
--
ALTER TABLE `stationen`
  ADD PRIMARY KEY (`StationsID`);

--
-- Indizes für die Tabelle `steine`
--
ALTER TABLE `steine`
  ADD PRIMARY KEY (`SteinID`);

--
-- Indizes für die Tabelle `teilprodukt`
--
ALTER TABLE `teilprodukt`
  ADD PRIMARY KEY (`TeilProduktID`);

--
-- Indizes für die Tabelle `teilprodukt_steine`
--
ALTER TABLE `teilprodukt_steine`
  ADD PRIMARY KEY (`TeilProduktID`,`SteinID`),
  ADD KEY `SteinID` (`SteinID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `anleitungs_endproduktimage`
--
ALTER TABLE `anleitungs_endproduktimage`
  MODIFY `AnleitungsEndProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `anleitungs_teilproduktimage`
--
ALTER TABLE `anleitungs_teilproduktimage`
  MODIFY `AnleitungsTeilProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT für Tabelle `anlieferungen`
--
ALTER TABLE `anlieferungen`
  MODIFY `AnlieferungsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `BestellungsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `endprodukt`
--
ALTER TABLE `endprodukt`
  MODIFY `EndProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `logistik`
--
ALTER TABLE `logistik`
  MODIFY `LogistikID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT für Tabelle `spiel`
--
ALTER TABLE `spiel`
  MODIFY `SpielID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `stationen`
--
ALTER TABLE `stationen`
  MODIFY `StationsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `steine`
--
ALTER TABLE `steine`
  MODIFY `SteinID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `teilprodukt`
--
ALTER TABLE `teilprodukt`
  MODIFY `TeilProduktID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `anleitungs_endproduktimage`
--
ALTER TABLE `anleitungs_endproduktimage`
  ADD CONSTRAINT `EndProduktID-Verknüpfung` FOREIGN KEY (`EndProduktID`) REFERENCES `endprodukt` (`EndProduktID`);

--
-- Constraints der Tabelle `anleitungs_teilproduktimage`
--
ALTER TABLE `anleitungs_teilproduktimage`
  ADD CONSTRAINT `TeilProduktID-Verknüpfung` FOREIGN KEY (`TeilProduktID`) REFERENCES `teilprodukt` (`TeilProduktID`);

--
-- Constraints der Tabelle `anlieferungen`
--
ALTER TABLE `anlieferungen`
  ADD CONSTRAINT `anlieferungen_ibfk_1` FOREIGN KEY (`StationsID`) REFERENCES `stationen` (`StationsID`),
  ADD CONSTRAINT `anlieferungen_ibfk_2` FOREIGN KEY (`SteinID`) REFERENCES `steine` (`SteinID`),
  ADD CONSTRAINT `anlieferungen_ibfk_3` FOREIGN KEY (`SpielID`) REFERENCES `spiel` (`SpielID`);

--
-- Constraints der Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD CONSTRAINT `Bestellungen_ibfk_1` FOREIGN KEY (`EndProduktID`) REFERENCES `endprodukt` (`EndProduktID`),
  ADD CONSTRAINT `Bestellungen_ibfk_2` FOREIGN KEY (`SpielID`) REFERENCES `spiel` (`SpielID`);

--
-- Constraints der Tabelle `endprodukt_teilprodukt`
--
ALTER TABLE `endprodukt_teilprodukt`
  ADD CONSTRAINT `EndProdukt_TeilProdukt_ibfk_1` FOREIGN KEY (`EndProduktID`) REFERENCES `endprodukt` (`EndProduktID`),
  ADD CONSTRAINT `EndProdukt_TeilProdukt_ibfk_2` FOREIGN KEY (`TeilProduktID`) REFERENCES `teilprodukt` (`TeilProduktID`),
  ADD CONSTRAINT `StationsID_Stationen` FOREIGN KEY (`StationsID`) REFERENCES `stationen` (`StationsID`);

--
-- Constraints der Tabelle `logistik`
--
ALTER TABLE `logistik`
  ADD CONSTRAINT `logistik_ibfk_1` FOREIGN KEY (`StationsID`) REFERENCES `stationen` (`StationsID`),
  ADD CONSTRAINT `logistik_ibfk_2` FOREIGN KEY (`SteinID`) REFERENCES `steine` (`SteinID`);

--
-- Constraints der Tabelle `teilprodukt_steine`
--
ALTER TABLE `teilprodukt_steine`
  ADD CONSTRAINT `TeilProdukt_Steine_ibfk_1` FOREIGN KEY (`SteinID`) REFERENCES `steine` (`SteinID`),
  ADD CONSTRAINT `TeilProdukt_Steine_ibfk_2` FOREIGN KEY (`TeilProduktID`) REFERENCES `teilprodukt` (`TeilProduktID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
