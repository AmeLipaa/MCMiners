-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Lis 2022, 23:06
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
-- Baza danych: `mcminers`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_prod`
--

CREATE TABLE `kategorie_prod` (
  `id_kategorii` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorie_prod`
--

INSERT INTO `kategorie_prod` (`id_kategorii`, `nazwa`) VALUES
(1, 'kategoria1'),
(2, 'kategoria2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(10) UNSIGNED NOT NULL,
  `nick` varchar(48) NOT NULL,
  `email` varchar(75) NOT NULL,
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
(6, 'celaakpl', 'celaak@gmail.com', '5e55a1bc2cb5c0cd879509f42c201f11377db3e62b0dd93cb505549c17a8fad084d42a4c4872839cceb6d4fc29b3c54f2d056e31440fa5bb4097c2a0b2c3e641', 1),
(7, 'Jacob_Kappowicz', 'kosa@gej.pl', 'dc0793c5691dfa0cdff8c87ecfed4918a98470f8b2a1730ebd820923d385f5e3bfbf79ca1fbaef34a3f7a108be6a2eb1679e2981c4666f886dbcb296a717811f', 0),
(0, '_PanSmietanka_', 'scelaa85@poczta.fm', '9e70b032f8a3c6eb3174da2e4d14d611ef22a1fc1e01233fd50c358c985efd2826a20d0287cc29807fc568bc0040d4859a27008558c4c595a119990dd91ed5e2', 0),
(0, 'adolf123', 'haniatoja05.12@gmail.com', 'fd9d94340dbd72c11b37ebb0d2a19b4d05e00fd78e4e2ce8923b9ea3a54e900df181cfb112a8a73228d1f3551680e2ad9701a4fcfb248fa7fa77b95180628bb2', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `cena` double NOT NULL,
  `opis` tinytext NOT NULL,
  `czy_promocyjny` tinyint(1) NOT NULL,
  `obraz` varchar(128) DEFAULT NULL COMMENT 'link do obrazu',
  `id_kategorii` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `nazwa`, `cena`, `opis`, `czy_promocyjny`, `obraz`, `id_kategorii`) VALUES
(0, 'skin premium', 34, 'opisskinaa', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `id_promocji` int(10) UNSIGNED NOT NULL,
  `id_szczegolow_p` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(64) DEFAULT NULL,
  `od_kiedy` date NOT NULL,
  `do_kiedy` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_promocji`
--

CREATE TABLE `szczegoly_promocji` (
  `id_szczegolow_p` int(10) UNSIGNED NOT NULL,
  `id_produktu` int(10) UNSIGNED NOT NULL,
  `obnizka` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegoly_transakcji`
--

CREATE TABLE `szczegoly_transakcji` (
  `id_szczegolow` int(10) UNSIGNED NOT NULL,
  `id_transakcji` int(10) UNSIGNED NOT NULL,
  `id_produktu` int(10) UNSIGNED NOT NULL,
  `ilosc` int(11) NOT NULL,
  `cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja`
--

CREATE TABLE `transakcja` (
  `id_transakcji` int(10) UNSIGNED NOT NULL,
  `id_klienta` int(10) UNSIGNED NOT NULL,
  `id_szczegolow` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `realizacja` tinyint(1) NOT NULL COMMENT 'czy zrealizowane'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
