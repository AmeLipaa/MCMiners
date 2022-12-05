-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: mysql.ct8.pl
-- Czas generowania: 01 Gru 2022, 14:17
-- Wersja serwera: 8.0.30
-- Wersja PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_prod`
--

CREATE TABLE `kategorie_prod` (
  `id_kategorii` int UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `kategorie_prod`
--

INSERT INTO `kategorie_prod` (`id_kategorii`, `nazwa`) VALUES
(1, 'Uprawnienia'),
(2, 'Efekty AFK');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int UNSIGNED NOT NULL,
  `nick` varchar(48) NOT NULL,
  `email` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `haslo` varchar(256) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `nick`, `email`, `haslo`, `admin`) VALUES
(1, 'ABEE555', 'abe5@gmail.com', 'fb864e34f555914f98b39f3fc3f475e7ca59440e941dcc5d889907748a6d853ee62e2328dd5ddec59041c40ae1ee4fdadefd8c4af607c5dcdeb18abd62d7c0c7', 1),
(2, 'Saturri', 'saturri@gmail.com', '7d37ee22feaeac55976b81eb879930b9eb92c0b5d7e84558ff6c1d34c7c488553f0327120fc8042bbd916fd37e3b2d9b5c5830100c25bdf07f60745694aa6d53', 0),
(3, 'smolgayplant', 'sgplant@gmail.com', '477f1571924e3b6ea4e9111ae2d749ada8a6e11842bcb1ad92e1cafdcda7ea0f81cc950504b24967972342d2d67c27ff29956daebe6f1ef6731db93115b44da6', 1),
(4, 'Herobrine', 'NULL', 'NULL', 0),
(5, 'Flixanoa', 'feffington@gmail.com', '6dcbe3b1e13a9749e1fe9627cedb881a7844536608d78b973df2b364583bd11b7379e131c0f88eb155ed6dd17b3f9253cdfdc6dd709901d0c6c60f0ac0cf2755', 0),
(6, 'celaakpl', 'celaak@gmail.com', '5e55a1bc2cb5c0cd879509f42c201f11377db3e62b0dd93cb505549c17a8fad084d42a4c4872839cceb6d4fc29b3c54f2d056e31440fa5bb4097c2a0b2c3e641', 1),
(7, 'Jacob_Kappowicz', 'kosa@gej.pl', 'dc0793c5691dfa0cdff8c87ecfed4918a98470f8b2a1730ebd820923d385f5e3bfbf79ca1fbaef34a3f7a108be6a2eb1679e2981c4666f886dbcb296a717811f', 0),
(8, 'Vertez', 'vertez@o2.pl', 'a9f2d69ee719344ceb9abacbb92482152f1fef5bcc7c5272fe2406929cdf55b782036891e25ab23f34302c616d8529bf893a6d41fcaae45f230fb46e1934b705', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `cena` double NOT NULL,
  `opis` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dostepnosc` tinyint(1) NOT NULL,
  `obraz` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'link do obrazu',
  `id_kategorii` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `produkty`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `id_promocji` int UNSIGNED NOT NULL,
  `nazwa` varchar(64) DEFAULT NULL,
  `od_kiedy` date NOT NULL,
  `do_kiedy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_promocji`
--

CREATE TABLE `szczegoly_promocji` (
  `id_szczeg_prom` int UNSIGNED NOT NULL,
  `id_promocji` int UNSIGNED NOT NULL,
  `id_produktu` int UNSIGNED NOT NULL,
  `obnizka` int UNSIGNED NOT NULL COMMENT 'Podawane w procentach'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_transakcji`
--

CREATE TABLE `szczegoly_transakcji` (
  `id_szczegolow` int UNSIGNED NOT NULL,
  `id_transakcji` int UNSIGNED NOT NULL,
  `id_produktu` int UNSIGNED NOT NULL,
  `ilosc` int NOT NULL,
  `cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `szczegoly_transakcji`
--

INSERT INTO `szczegoly_transakcji` (`id_szczegolow`, `id_transakcji`, `id_produktu`, `ilosc`, `cena`) VALUES
(1, 1, 2, 1, 1.99);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja`
--

CREATE TABLE `transakcja` (
  `id_transakcji` int UNSIGNED NOT NULL,
  `id_klienta` int UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `realizacja` tinyint(1) NOT NULL COMMENT 'czy zrealizowane'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `transakcja`
--

INSERT INTO `transakcja` (`id_transakcji`, `id_klienta`, `data`, `realizacja`) VALUES
(1, 1, '2022-12-12', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wpisy`
--

CREATE TABLE `wpisy` (
  `id_wpisu` int UNSIGNED NOT NULL,
  `id_klienta` int UNSIGNED NOT NULL,
  `tytul` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tresc` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `wpisy`
--

INSERT INTO `wpisy` (`id_wpisu`, `id_klienta`, `tytul`, `tresc`, `data`) VALUES
(1, 1, 'Otwarcie nowej edycji serwera MinersMC!', 'Zapraszamy na otwarcie nowej, a zarazem pierwszej edycji serwera MinersMC już w tą sobotę 3 grudnia o godzinie 19:00. Wersja gry - \'1.16\'.', '2022-11-27');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie_prod`
--
ALTER TABLE `kategorie_prod`
  ADD PRIMARY KEY (`id_kategorii`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produktu`),
  ADD KEY `id_kategorii` (`id_kategorii`);

--
-- Indeksy dla tabeli `promocje`
--
ALTER TABLE `promocje`
  ADD PRIMARY KEY (`id_promocji`);

--
-- Indeksy dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  ADD PRIMARY KEY (`id_szczeg_prom`),
  ADD KEY `id_produktu` (`id_produktu`),
  ADD KEY `id_promocji` (`id_promocji`);

--
-- Indeksy dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  ADD PRIMARY KEY (`id_szczegolow`),
  ADD KEY `id_produktu` (`id_produktu`),
  ADD KEY `szczegoly_transakcji_ibfk_2` (`id_transakcji`);

--
-- Indeksy dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  ADD PRIMARY KEY (`id_transakcji`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  ADD PRIMARY KEY (`id_wpisu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `kategorie_prod`
--
ALTER TABLE `kategorie_prod`
  MODIFY `id_kategorii` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `promocje`
--
ALTER TABLE `promocje`
  MODIFY `id_promocji` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  MODIFY `id_szczeg_prom` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  MODIFY `id_szczegolow` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  MODIFY `id_transakcji` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  MODIFY `id_wpisu` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie_prod` (`id_kategorii`);

--
-- Ograniczenia dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  ADD CONSTRAINT `szczegoly_promocji_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`),
  ADD CONSTRAINT `szczegoly_promocji_ibfk_2` FOREIGN KEY (`id_promocji`) REFERENCES `promocje` (`id_promocji`);

--
-- Ograniczenia dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  ADD CONSTRAINT `szczegoly_transakcji_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`),
  ADD CONSTRAINT `szczegoly_transakcji_ibfk_2` FOREIGN KEY (`id_transakcji`) REFERENCES `transakcja` (`id_transakcji`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  ADD CONSTRAINT `transakcja_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  ADD CONSTRAINT `wpisy_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;