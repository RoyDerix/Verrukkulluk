-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 21 jan 2021 om 10:29
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verrukkulluk`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `titel_artikel` varchar(30) NOT NULL,
  `artikelbeschrijving` text NOT NULL,
  `artikelfoto` text DEFAULT NULL,
  `calorieen_per_artikel` int(11) NOT NULL,
  `prijs_per_artikel` double NOT NULL,
  `hoeveelheid` double NOT NULL,
  `verpakking` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `titel_artikel`, `artikelbeschrijving`, `artikelfoto`, `calorieen_per_artikel`, `prijs_per_artikel`, `hoeveelheid`, `verpakking`) VALUES
(1, 'Naanbrood', '2 naanbroden', NULL, 700, 1.9, 2, 'stuk'),
(2, 'Courgette', 'Courgette', NULL, 10, 0.9, 1, 'stuk'),
(3, 'Paprika', 'Paprika', NULL, 10, 1.5, 1, 'stuk'),
(4, 'Mozzarella', '1 bol Italiaanse kaas', NULL, 263, 1.55, 1, 'stuk'),
(5, 'Passata', 'Tomaten passata', NULL, 210, 1.68, 680, 'gram'),
(6, 'Ui', 'Ui', NULL, 3, 0.12, 1, 'stuk'),
(7, 'Groentebouillon blokje', 'Groentebouillon blokje', NULL, 8, 1.35, 6, 'stuk'),
(8, 'Dille', 'Dille is een kruid met een heel verfijnde, anijsachtige smaak.', NULL, 1, 1.69, 20, 'stuk'),
(9, 'Coquilles', 'Ook bekend als Sint Jacobsschelp.', NULL, 500, 7.45, 4, 'stuk'),
(10, 'Spaghetti', 'Italiaanse pastasoort', NULL, 1734, 1.35, 500, 'gram'),
(11, 'Kipgehakt', 'Gehakt van kip.', NULL, 335, 4.24, 250, 'gram'),
(12, 'Spinazie', 'Spinazie', NULL, 5, 1.79, 400, 'gram'),
(13, 'Kookroom', 'Room om mee te koken.', NULL, 504, 0.64, 250, 'ml'),
(14, 'Groene pesto', 'Italiaanse saus', NULL, 364, 1.99, 45, 'gram'),
(15, 'Kipfilet', 'Kipfilet', NULL, 748, 4.95, 500, 'gram'),
(16, 'Zwarte bonen', 'Bonen die zwart zijn', NULL, 334, 1.15, 400, 'gram'),
(17, 'Wraps', 'Dunne pannenkoek', NULL, 1257, 1.8, 6, 'stuk'),
(18, 'Geraspte kaas', 'Geraspte jonge kaas', NULL, 680, 2.19, 175, 'gram');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `id` int(11) NOT NULL,
  `gebruiker_naam` varchar(40) NOT NULL,
  `wachtwoord` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `gebruiker_foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`id`, `gebruiker_naam`, `wachtwoord`, `email`, `gebruiker_foto`) VALUES
(1, 'Roy Derix', 'hallo1234', 'rderix@home.nl', NULL),
(2, 'Terri Tait', 'qwerty', 'terri@hotmail.com', NULL),
(3, 'Willem Walters', '123456', 'willemwalters@gmail.com', NULL),
(4, 'Nick Nichols', 'wachtwoord', 'n.nichols@kpn.nl', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `recept_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `ingredienthoeveelheid` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ingredient`
--

INSERT INTO `ingredient` (`id`, `recept_id`, `artikel_id`, `ingredienthoeveelheid`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 1, 3, 2),
(4, 1, 4, 2),
(5, 1, 5, 75),
(6, 2, 6, 1),
(7, 2, 7, 2),
(8, 2, 2, 1.5),
(9, 2, 8, 5),
(10, 2, 9, 8),
(11, 3, 10, 150),
(12, 3, 11, 250),
(13, 3, 12, 400),
(14, 3, 13, 150),
(15, 3, 14, 15),
(16, 4, 15, 300),
(17, 4, 5, 500),
(18, 4, 16, 200),
(19, 4, 17, 4),
(20, 4, 18, 100);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `keuken_type`
--

CREATE TABLE `keuken_type` (
  `id` int(11) NOT NULL,
  `record_type` varchar(1) NOT NULL,
  `omschrijving` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `keuken_type`
--

INSERT INTO `keuken_type` (`id`, `record_type`, `omschrijving`) VALUES
(1, 'K', 'Azië'),
(2, 'T', 'Vegetarisch'),
(4, 'T', 'Soep'),
(5, 'K', 'Frankrijk'),
(6, 'K', 'Italië'),
(7, 'T', 'Pasta'),
(8, 'K', 'Mexico'),
(9, 'T', 'Wraps');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recept`
--

CREATE TABLE `recept` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `keuken_id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `titel_recept` varchar(50) NOT NULL,
  `receptbeschrijving` text NOT NULL,
  `samenvatting_beschrijving` varchar(500) NOT NULL,
  `receptfoto` text DEFAULT NULL,
  `datum_toegevoegd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `recept`
--

INSERT INTO `recept` (`id`, `type_id`, `keuken_id`, `gebruiker_id`, `titel_recept`, `receptbeschrijving`, `samenvatting_beschrijving`, `receptfoto`, `datum_toegevoegd`) VALUES
(1, 2, 1, 1, 'Naanbroodpizza met gegrilde groenten', 'Met een naanbrood kun je zo veel meer dan alleen dippen! Neem nou deze naanbroodpizza met gegrilde groenten: een heerlijk zachte bodem en knapperige groenten bovenop. De romige mozzarella maakt het helemaal af! Ook kun je deze pizza natuurlijk anders beleggen, zoals met salami of andere soorten kaas.', 'Met een naanbrood kun je zo veel meer dan alleen dippen! Neem nou deze naanbroodpizza met gegrilde groenten: een heerlijk zachte bodem en knapperige groenten bovenop.', NULL, '2021-01-18'),
(2, 2, 5, 4, 'Courgettesoep met coquilles', 'Deze courgettesoep met dille en coquille is perfect om het (kerst)diner mee te beginnen. De courgettesoep is lekker romig, maar ook kruidig door het toevoegen van de dille. Dit maakt de soep net even anders dan je gewend bent. De couquille zorgt voor een lekkere bite. De soep is lekker als voor- of tussengerecht en kun je heel goed één of twee dagen van te voren maken. Bak kort voor het serveren de coquilles aan en genieten maar. ', 'Deze courgettesoep met dille en coquille is perfect om het (kerst)diner mee te beginnen. De courgettesoep is lekker romig, maar ook kruidig door het toevoegen van de dille.', NULL, '2021-01-05'),
(3, 7, 6, 3, 'Spaghetti met kipgehaktballetjes', 'In deze 5 or less hebben we een basisrecept voor een spaghetti met kipgehaktballetjes, spinazie en een romige saus van kookroom en pesto. Simpel en lekker!\r\n\r\nWe hebben natuurlijk het liefst zo min mogelijk ingrediënten, maar om deze pasta nóg lekkerder te maken, kun je wat Parmezaanse kaas toevoegen aan de kipgehaktballetjes en bij het serveren van de pasta ook nog wat kaas on top! Hoe meer kaas, hoe beter toch? ', 'In deze 5 or less hebben we een basisrecept voor een spaghetti met kipgehaktballetjes, spinazie en een romige saus van kookroom en pesto. Simpel en lekker!\r\n', NULL, '2021-01-01'),
(4, 8, 9, 2, 'Enchiladas met pulled chicken', 'Met deze easy enchiladas met pulled chicken scoor je makkelijk punten bij familie of vrienden. In slechts 30 minuten maak jij gevulde wraps met pulled chicken, gekruide passata, zwarte bonen en oude kaas eroverheen. Met een boodschappenlijst van niet meer dan 5 items duik jij de supermarkt in (en uit). Wat blijven die 5 or less recepten heerlijk, al zeggen we het zelf.', 'Met deze easy enchiladas met pulled chicken scoor je makkelijk punten bij familie of vrienden. In slechts 30 minuten maak jij gevulde wraps met pulled chicken, gekruide passata, zwarte bonen en oude kaas eroverheen.', NULL, '2021-01-19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `recept_info`
--

CREATE TABLE `recept_info` (
  `id` int(11) NOT NULL,
  `recept_id` int(11) NOT NULL,
  `gebruiker_id` int(11) DEFAULT NULL,
  `record_type` varchar(1) NOT NULL,
  `datum` date DEFAULT NULL,
  `nummeriekveld` int(11) DEFAULT NULL,
  `tekstveld` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `recept_info`
--

INSERT INTO `recept_info` (`id`, `recept_id`, `gebruiker_id`, `record_type`, `datum`, `nummeriekveld`, `tekstveld`) VALUES
(1, 1, NULL, 'S', '2021-01-18', 4, NULL),
(2, 1, NULL, 'S', '2021-01-18', 3, NULL),
(4, 1, NULL, 'S', '2021-01-14', 2, NULL),
(5, 1, NULL, 'S', '2021-01-15', 4, NULL),
(6, 1, 1, 'F', '2021-01-13', NULL, NULL),
(7, 1, 3, 'F', '2021-01-13', NULL, NULL),
(8, 1, 1, 'O', '2021-01-18', NULL, 'Lekker!'),
(9, 1, 2, 'O', '2021-01-18', NULL, 'Niet zo lekker... Jammer!'),
(10, 1, NULL, 'B', '2021-01-18', 1, 'Verwarm de oven voor op 180 graden.'),
(11, 1, NULL, 'B', '2021-01-18', 2, 'Maak de passata op smaak met peper en zout en verdeel over de naanbroden.'),
(12, 1, NULL, 'B', '2021-01-18', 3, 'Verwarm een grill- of koekenpan en voeg een scheutje olie toe. Snijd de courgette in plakjes en de paprika in reepjes. Grill alles circa 7 minuten in de pan.'),
(13, 1, NULL, 'B', '2021-01-18', 4, 'Verdeel de paprika en courgette over de naanbroden.'),
(14, 1, NULL, 'B', '2021-01-18', 5, 'Snijd de mozzarella in plakjes en verdeel over de naanpizza\'s.'),
(15, 1, NULL, 'B', '2021-01-18', 6, 'Bak de naanbroodpizza\'s in 8 minuten in de oven.'),
(16, 2, NULL, 'S', '2021-01-13', 3, NULL),
(17, 2, NULL, 'S', '2021-01-18', 5, NULL),
(18, 2, 2, 'F', '2021-01-16', NULL, NULL),
(19, 2, 3, 'F', '2021-01-16', NULL, NULL),
(20, 2, 4, 'O', '2021-01-17', NULL, 'Lekker soepje!'),
(21, 2, 1, 'O', '2021-01-12', NULL, 'Ik houd niet zo van zeevruchten.'),
(22, 2, NULL, 'B', '2021-01-05', 1, 'Pel en snipper de ui en snijd de courgette in blokjes.'),
(23, 2, NULL, 'B', '2021-01-05', 2, 'Verhit een scheutje olie in een soeppan en fruit hierin de ui zo’n 2 minuten.'),
(24, 2, NULL, 'B', '2021-01-05', 3, 'Voeg vervolgens de courgette toe en laat dit nog 4 minuten meebakken.'),
(25, 2, NULL, 'B', '2021-01-05', 4, 'Voeg de bouillonblokjes en  1 liter kokend water toe en laat dit 20 minuten op zacht vuur koken.'),
(26, 2, NULL, 'B', '2021-01-05', 5, 'Dep ondertussen de coquilles droog.'),
(27, 2, NULL, 'B', '2021-01-05', 6, 'Zet een koekenpan op hoog vuur en doe hier een scheut olie in.'),
(28, 2, NULL, 'B', '2021-01-05', 7, 'Als de olie begint te roken, gooi je de olie in de gootsteen en voeg een beetje nieuwe olie toe.'),
(29, 2, NULL, 'B', '2021-01-05', 8, 'Schroei de coquilles in 1-2 minuten aan beide kanten dicht.'),
(30, 2, NULL, 'B', '2021-01-05', 9, 'Voeg de dille toe aan de soep (niet alles, houd ook nog wat apart als topping) en pureer het geheel met een staafmixer tot een gladde soep.'),
(31, 2, NULL, 'B', '2021-01-05', 10, 'Schenk de soep in twee soepkommen, rijg twee coquilles op een prikker en leg bovenop elk kommetje.'),
(33, 3, NULL, 'S', '2021-01-06', 1, NULL),
(34, 3, NULL, 'S', '2021-01-12', 4, NULL),
(35, 3, 1, 'F', '2021-01-05', NULL, NULL),
(36, 3, 3, 'F', '2021-01-09', NULL, NULL),
(37, 3, 2, 'O', '2021-01-02', NULL, 'Lekkere pasta!'),
(38, 3, 4, 'O', '2021-01-02', NULL, 'Ik heb het met vegetarisch gehakt gemaakt.'),
(39, 3, NULL, 'B', '2021-01-01', 1, 'Bereid de spaghetti volgens de aanwijzingen op de verpakking.'),
(40, 3, NULL, 'B', '2021-01-01', 2, 'Maak nu 10 balletjes van het kipgehakt.'),
(41, 3, NULL, 'B', '2021-01-01', 3, 'Verhit een scheut olie in een pan en bak de kipgehaktballetjes gaar in 10 minuten.'),
(42, 3, NULL, 'B', '2021-01-01', 4, 'Voeg vervolgens de spinazie beetje bij beetje toe. Bak dit mee tot het geheel is geslonken.'),
(43, 3, NULL, 'B', '2021-01-01', 5, 'Doe dan ook de pesto en kookroom in de pan. Breng op smaak met peper en zout.'),
(44, 3, NULL, 'B', '2021-01-01', 6, 'Breng het geheel aan de kook en laat nog zo\'n 5 minuten pruttelen.'),
(45, 3, NULL, 'B', '2021-01-01', 7, 'Roer de spaghetti door de saus en verdeel over de borden.\r\n'),
(46, 4, 2, 'S', '2021-01-19', 4, NULL),
(47, 4, 3, 'S', '2021-01-19', 5, NULL),
(48, 4, 1, 'S', '2021-01-19', 5, NULL),
(49, 4, 4, 'S', '2021-01-19', 3, NULL),
(50, 4, 1, 'F', NULL, NULL, NULL),
(51, 4, 4, 'F', NULL, NULL, NULL),
(52, 4, 1, 'O', '2021-01-19', NULL, 'Lekker met nog wat blokjes rode paprika.'),
(53, 4, 2, 'O', '2021-01-19', NULL, 'Ik heb wel eens betere gehad.'),
(54, 4, 3, 'O', '2021-01-19', NULL, 'Gemakkelijk te maken.'),
(55, 4, 4, 'O', '2021-01-20', NULL, 'Moeilijk hoor!'),
(56, 4, NULL, 'B', NULL, 1, 'Breng een pan water aan de kook en kook de kip zo\'n 20 minuten tot ie helemaal wit en gaar is.'),
(57, 4, NULL, 'B', NULL, 2, 'Verwarm ondertussen de oven voor op 180 graden en vet een ovenschaal in met wat olie.'),
(58, 4, NULL, 'B', NULL, 3, 'Verhit een koekenpan en verwarm hierin de passata en zwarte bonen gedurende 5 minuten. Breng op smaak met een flinke snuf peper en zout.'),
(59, 4, NULL, 'B', NULL, 4, 'Haal de kipfilets uit het water en maak er met een handmixer (of met twee vorken) pulled chicken van.'),
(60, 4, NULL, 'B', NULL, 5, 'Voeg vervolgens de pulled chicken toe aan het bonenmengsel en verwarm nog 2 minuten mee.'),
(61, 4, NULL, 'B', NULL, 6, 'Beleg nu één voor één de tortilla\'s met het kipmengsel (houd nog ongeveer 2 flinke lepels apart voor over de tortilla\'s), rol de tortilla\'s op en leg ze naast elkaar in de ovenschaal.'),
(62, 4, NULL, 'B', NULL, 7, 'Verdeel het overige kipmengsel over de tortilla\'s, bestrooi met de kaas en bak in 10 minuten goudbruin in de oven.');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recept_id` (`recept_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `recept`
--
ALTER TABLE `recept`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `keuken_id` (`keuken_id`),
  ADD KEY `gebruiker_id` (`gebruiker_id`);

--
-- Indexen voor tabel `recept_info`
--
ALTER TABLE `recept_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recept_id` (`recept_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `keuken_type`
--
ALTER TABLE `keuken_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `recept`
--
ALTER TABLE `recept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `recept_info`
--
ALTER TABLE `recept_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`),
  ADD CONSTRAINT `ingredient_ibfk_2` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`);

--
-- Beperkingen voor tabel `recept`
--
ALTER TABLE `recept`
  ADD CONSTRAINT `recept_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `recept_ibfk_2` FOREIGN KEY (`keuken_id`) REFERENCES `keuken_type` (`id`),
  ADD CONSTRAINT `recept_ibfk_3` FOREIGN KEY (`gebruiker_id`) REFERENCES `gebruiker` (`id`);

--
-- Beperkingen voor tabel `recept_info`
--
ALTER TABLE `recept_info`
  ADD CONSTRAINT `recept_info_ibfk_1` FOREIGN KEY (`recept_id`) REFERENCES `recept` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
