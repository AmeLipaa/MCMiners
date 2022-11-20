-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Lis 2022, 20:54
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_prod`
--

CREATE TABLE `kategorie_prod` (
  `id_kategorii` int(11) UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `opis` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) UNSIGNED NOT NULL,
  `nick` varchar(48) NOT NULL,
  `email` varchar(64) NOT NULL,
  `haslo` varchar(256) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `nick`, `email`, `haslo`, `admin`) VALUES
(1, 'ABEE555', 'abe5@gmail.com', 'fb864e34f555914f98b39f3fc3f475e7ca59440e941dcc5d889907748a6d853ee62e2328dd5ddec59041c40ae1ee4fdadefd8c4af607c5dcdeb18abd62d7c0c7', 1),
(2, 'Saturri', 'saturri@gmail.com', '7d37ee22feaeac55976b81eb879930b9eb92c0b5d7e84558ff6c1d34c7c488553f0327120fc8042bbd916fd37e3b2d9b5c5830100c25bdf07f60745694aa6d53', 0),
(3, 'smolgayplant', 'sgplant@gmail.com', '477f1571924e3b6ea4e9111ae2d749ada8a6e11842bcb1ad92e1cafdcda7ea0f81cc950504b24967972342d2d67c27ff29956daebe6f1ef6731db93115b44da6', 1),
(4, 'Herobrine', 'NULL', 'NULL', 0),
(5, 'Flixanoa', 'feffington@gmail.com', '6dcbe3b1e13a9749e1fe9627cedb881a7844536608d78b973df2b364583bd11b7379e131c0f88eb155ed6dd17b3f9253cdfdc6dd709901d0c6c60f0ac0cf2755', 0),
(6, 'celaakpl', 'celaak@gmail.com', '5e55a1bc2cb5c0cd879509f42c201f11377db3e62b0dd93cb505549c17a8fad084d42a4c4872839cceb6d4fc29b3c54f2d056e31440fa5bb4097c2a0b2c3e641', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int(11) UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `cena` double UNSIGNED NOT NULL,
  `opis` varchar(64) NOT NULL,
  `dostepnosc` tinyint(1) NOT NULL COMMENT 'link do obrazu produktu',
  `obraz` varchar(64) DEFAULT NULL,
  `id_kategorii` int(16) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `id_promocji` int(11) UNSIGNED NOT NULL,
  `id_szczegolow_p` int(11) UNSIGNED NOT NULL,
  `od_kiedy` date NOT NULL,
  `do_kiedy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_promocji`
--

CREATE TABLE `szczegoly_promocji` (
  `id_szczegolow_p` int(11) UNSIGNED NOT NULL,
  `id_produktu` int(11) UNSIGNED NOT NULL,
  `obnizka` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_transakcji`
--

CREATE TABLE `szczegoly_transakcji` (
  `id_szczegolow` int(11) UNSIGNED NOT NULL,
  `id_transakcji` int(11) UNSIGNED NOT NULL,
  `id_produktu` int(11) UNSIGNED NOT NULL,
  `ilosc` int(11) UNSIGNED NOT NULL,
  `cena` double UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja`
--

CREATE TABLE `transakcja` (
  `id_transakcji` int(11) UNSIGNED NOT NULL,
  `id_klienta` int(11) UNSIGNED NOT NULL,
  `id_szczegolow` int(11) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `realizacja` tinyint(1) NOT NULL COMMENT 'czy zrealizowane'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wpisy`
--

CREATE TABLE `wpisy` (
  `id_wpisu` int(11) UNSIGNED NOT NULL,
  `id_klienta` int(11) UNSIGNED NOT NULL,
  `tytul` varchar(64) NOT NULL,
  `tresc` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wpisy`
--

INSERT INTO `wpisy` (`id_wpisu`, `id_klienta`, `tytul`, `tresc`, `data`) VALUES
(1, 1, 'tytul1', 'tresc123', '0000-00-00'),
(2, 1, 'Znowu mam bana wpis', 'Gdy wkraczam na serwer, wszystko odkrywa się, węgiel, redstone i End, no i diamenty też. Już biorę w ręce kilof, przed siebie przedzieram się. Nic mi nie umknie, o nie, czeka diaxowy set. Jeden, dwa i trzy diamenty, jeszcze jeden dla zachęty, ale będzie szpanu, weź adminie mnie nie banuj! Znowu mam bana! No ja nie mogę! Trzymaj te diaxy, bo ja wychodzę! Idę gdzie indziej, na inny serwer, dostałem bana, więc nie pisz więcej! Znowu mam bana! No ja nie mogę! Trzymaj te diaxy, bo ja wychodzę! I walcie wszyscy się, wy głupie ścierwa, bo idę na lepszego serwa.', '2022-11-20');

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
  ADD PRIMARY KEY (`id_promocji`),
  ADD KEY `id_szczegolow_p` (`id_szczegolow_p`);

--
-- Indeksy dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  ADD PRIMARY KEY (`id_szczegolow_p`),
  ADD KEY `id_produktu` (`id_produktu`);

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
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `id_szczegolow` (`id_szczegolow`);

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
  MODIFY `id_kategorii` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `promocje`
--
ALTER TABLE `promocje`
  MODIFY `id_promocji` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  MODIFY `id_szczegolow_p` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  MODIFY `id_szczegolow` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  MODIFY `id_transakcji` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  MODIFY `id_wpisu` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie_prod` (`id_kategorii`);

--
-- Ograniczenia dla tabeli `promocje`
--
ALTER TABLE `promocje`
  ADD CONSTRAINT `promocje_ibfk_1` FOREIGN KEY (`id_szczegolow_p`) REFERENCES `szczegoly_promocji` (`id_szczegolow_p`);

--
-- Ograniczenia dla tabeli `szczegoly_promocji`
--
ALTER TABLE `szczegoly_promocji`
  ADD CONSTRAINT `szczegoly_promocji_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`);

--
-- Ograniczenia dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  ADD CONSTRAINT `szczegoly_transakcji_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`),
  ADD CONSTRAINT `szczegoly_transakcji_ibfk_2` FOREIGN KEY (`id_transakcji`) REFERENCES `transakcja` (`id_transakcji`);

--
-- Ograniczenia dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  ADD CONSTRAINT `transakcja_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`),
  ADD CONSTRAINT `transakcja_ibfk_2` FOREIGN KEY (`id_szczegolow`) REFERENCES `szczegoly_transakcji` (`id_szczegolow`);

--
-- Ograniczenia dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  ADD CONSTRAINT `wpisy_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
