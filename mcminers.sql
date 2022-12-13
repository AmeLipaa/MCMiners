--
-- Baza danych: `mcminers`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie_prod`
--

CREATE TABLE `kategorie_prod` (
  `id_kategorii` int UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `typ` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `kategorie_prod`
--

INSERT INTO `kategorie_prod` (`id_kategorii`, `nazwa`, `typ`) VALUES
(1, 'Uprawnienia', 1),
(2, 'Efekty AFK', 1),
(3, 'Rangi', 2),
(4, 'Przedmioty/waluta w grze', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int UNSIGNED NOT NULL,
  `nick` varchar(48) NOT NULL,
  `email` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `haslo` varchar(256) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `nick`, `email`, `haslo`, `admin`) VALUES
(1, 'ABEE555', 'abe5@gmail.com', 'e2491bff2d8d461a2584bcfcecbf3de1e5c9df48583503416a95e332e00355648285e86a19b732201e542bce322b35f98e8b46012024f69c391b5ba7487b0d1b', 1),
(2, 'Saturri', 'saturri@gmail.com', '7d37ee22feaeac55976b81eb879930b9eb92c0b5d7e84558ff6c1d34c7c488553f0327120fc8042bbd916fd37e3b2d9b5c5830100c25bdf07f60745694aa6d53', 0),
(3, 'smolgayplant', 'sgplant@gmail.com', '477f1571924e3b6ea4e9111ae2d749ada8a6e11842bcb1ad92e1cafdcda7ea0f81cc950504b24967972342d2d67c27ff29956daebe6f1ef6731db93115b44da6', 1),
(4, 'Herobrine', 'NULL', 'NULL', 0),
(5, 'Flixanoa', 'feffington@gmail.com', '6dcbe3b1e13a9749e1fe9627cedb881a7844536608d78b973df2b364583bd11b7379e131c0f88eb155ed6dd17b3f9253cdfdc6dd709901d0c6c60f0ac0cf2755', 0),
(6, 'celaakpl', 'celaak@gmail.com', '5e55a1bc2cb5c0cd879509f42c201f11377db3e62b0dd93cb505549c17a8fad084d42a4c4872839cceb6d4fc29b3c54f2d056e31440fa5bb4097c2a0b2c3e641', 1),
(7, 'Jacob_Kappowicz', 'NULL', 'NULL', 0),
(9, '_PanSmietanka_', 'panpikus85@wp.pl', '97f80df44c8647926d39466520a7d48282e3ff89beb267fed6e0790e78c72d9829fbd59d7f7db7f7f4ca1fdbcdb2e847e7427452d629e66e149655c41f4f3d61', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int UNSIGNED NOT NULL,
  `nazwa` varchar(64) NOT NULL,
  `cena` double NOT NULL,
  `opis` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `czy_promocyjny` tinyint(1) NOT NULL COMMENT 'Jeśli wartość = 1 to produkt jest dostępny tylko podczas promocji zawierającej ten przedmiot',
  `obraz` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'link do obrazu',
  `id_kategorii` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `nazwa`, `cena`, `opis`, `czy_promocyjny`, `obraz`, `id_kategorii`) VALUES
(1, 'Serduszka', 0.99, 'W momencie kiedy gracz jest AFK dookoła niego pojawiają się serduszka.', 0, 'https://i.pinimg.com/originals/3c/8c/60/3c8c60a624459d29ddc5efe0f0361574.png', 2),
(2, 'Dostęp do komendy /skin', 2.99, 'Umożliwia użycie komendy \"/skin\", która pozwala na zmianę skina w grze na całym serwerze', 0, 'https://s.namemc.com/3d/skin/body.png?id=0cf380a32683aa2e&model=slim&width=317&height=317', 1),
(4, 'Kolorowy dym', 0.99, 'Efekt kolorowego dymu unoszącego się nad głową gdy gracz jest AFK', 0, 'https://learn.microsoft.com/en-us/minecraft/creator/documents/media/particleeffects/emitter.png', 2),
(6, '2500 tokenów na serwerze Creative', 1.89, 'Dodaje 2500 tokenów do portfela do wykorzystania na serwerze Creative', 0, 'http://albmic.ct8.pl/resources/coin.png', 4),
(7, 'Bombelki', 0.99, 'Efekt bombelków AFK', 0, 'http://albmic.ct8.pl/resources/bombelki.webp', 2),
(8, 'Dostęp do komendy /head', 1.49, 'Pozwala na użycie komendy /head na serwerze creative.', 0, 'http://albmic.ct8.pl/resources/0x0.png', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `id_promocji` int UNSIGNED NOT NULL,
  `kod` varchar(16) NOT NULL,
  `nazwa` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `znizka` tinyint UNSIGNED NOT NULL COMMENT '(w %)',
  `od_kiedy` date NOT NULL,
  `do_kiedy` date NOT NULL,
  `czy_limitowany` tinyint(1) NOT NULL COMMENT '0 - Nielimitowany, 1 - korzysta z określonego limitu',
  `ilosc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `promocje`
--

INSERT INTO `promocje` (`id_promocji`, `kod`, `nazwa`, `znizka`, `od_kiedy`, `do_kiedy`, `czy_limitowany`, `ilosc`) VALUES
(1, 'XMAS2022', 'Promocje Świąteczne 2022', 33, '2022-12-20', '2022-12-25', 0, 1),
(2, 'dzzielNY', 'Kupon dla dzielnego pacjenta', 100, '2022-12-01', '2023-01-31', 1, 1);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `Sklep`
-- (Zobacz poniżej rzeczywisty widok)
--
CREATE TABLE `Sklep` (
`cena` double
,`cid` int unsigned
,`cname` varchar(64)
,`czy_promocyjny` tinyint(1)
,`id_produktu` int unsigned
,`obraz` varchar(128)
,`opis` tinytext
,`pid` int unsigned
,`pname` varchar(64)
,`typ` tinyint unsigned
);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `szczegoly_transakcji`
--

INSERT INTO `szczegoly_transakcji` (`id_szczegolow`, `id_transakcji`, `id_produktu`, `ilosc`, `cena`) VALUES
(1, 1, 2, 1, 1.99),
(2, 3, 7, 1, 0.99),
(3, 3, 6, 3, 4.5),
(4, 4, 7, 1, 0.99),
(5, 5, 1, 1, 0.99),
(6, 6, 2, 1, 2.99),
(7, 6, 6, 2, 3),
(8, 7, 2, 1, 2.99),
(9, 7, 1, 1, 0.99),
(10, 7, 6, 4, 7.56);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `transakcja`
--

CREATE TABLE `transakcja` (
  `id_transakcji` int UNSIGNED NOT NULL,
  `id_klienta` int UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `realizacja` tinyint(1) NOT NULL COMMENT 'czy zrealizowane (0 - nie, 1 - tak, 2 - anulowano/zwrot pieniedzy)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `transakcja`
--

INSERT INTO `transakcja` (`id_transakcji`, `id_klienta`, `data`, `realizacja`) VALUES
(1, 1, '2022-12-12', 0),
(2, 1, '2022-12-10', 1),
(3, 1, '2022-12-10', 1),
(4, 1, '2022-12-10', 1),
(5, 2, '2022-12-11', 1),
(6, 2, '2022-12-11', 1),
(7, 5, '2022-12-12', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wpisy`
--

CREATE TABLE `wpisy` (
  `id_wpisu` int UNSIGNED NOT NULL,
  `id_klienta` int UNSIGNED NOT NULL,
  `tytul` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tresc` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Zrzut danych tabeli `wpisy`
--

INSERT INTO `wpisy` (`id_wpisu`, `id_klienta`, `tytul`, `tresc`, `data`) VALUES
(1, 1, 'Otwarcie nowej edycji serwera MinersMC!', 'Zapraszamy na otwarcie nowej, a zarazem pierwszej edycji serwera MinersMC już w tą sobotę 3 grudnia o godzinie 19:00. Wersja gry - \'1.16\'.', '2022-11-27'),
(3, 6, 'Dużo, dużo znaków!!!', 'Fortress Faceoffs presents to you a tale as old as time: A crew of mercs fighting for their lives to escape the grasp of Hell!\r\n\r\n\r\nHappens to the best of us, of course. In a voyage to uncover a cache of hidden treasure within the murky and treacherous waters of Michiganne, a ship of five drunken savages (that\'\'s you!) was caught in the eye of a treacherous storm and cast out to sea. This invoked the presence of a being only spoken of in shanties... Having been fed up with the sudden delivery of dead meat on his doorstep, THE DEVIL!!! himself forced these brutes back onto their boats and had them float across the River Styx so that he could be left in peace. After regaining consciousness and adjusting their one good eye, these men realized they weren\'\'t alone on their quest! An amassment of ships was on the same track, all with the goal of claiming bounty! Armed with cannons and ready to charge, these scurvy dogs must defeat all the other swashbucklin\'\' sailors and make it to the treasure alone! With the sound of explosions and slurred screams from every direction, THE DEVIL!!! may never get his rest...\r\n\r\n\r\nSign up your shipmates today for Fortress Faceoffs\'\' 6th event and become known as the best crew in history! The departure begins Oct. 14th @ 13:00 CEST (for Europe) / Oct. 21st @ 1:00pm EDT (for the Americas) and will last around 3 days each. For more information about event rules, prizes, and more, join the Fortress Faceoffs Discord and double-donk your way out of the deep sea! The top 8 crews will be broadcasted live, so perform your best or get washed up!', '2022-11-16'),
(4, 1, 'Celaku, co ty kombinujesz?', 'Co celak wyprawia o godzinie 02:07', '2022-12-07'),
(5, 1, 'Nie wytrzymam', 'bottom text', '2022-12-13'),
(7, 1, 'Zaraz mnie szlag jasny trafi', 'Zaraz mnie szlag jasny trafi jest godzina 02:15 i dalej klepie tą głupią stronę bo oczywiście tylko ja nie mam nic innego do roboty przecież od 4 tygodni', '2022-12-13');

-- --------------------------------------------------------

--
-- Struktura widoku `Sklep`
--
DROP TABLE IF EXISTS `Sklep`;

CREATE VIEW `Sklep`  AS SELECT `p`.`id_produktu` AS `id_produktu`, `p`.`nazwa` AS `pname`, `p`.`cena` AS `cena`, `p`.`opis` AS `opis`, `p`.`czy_promocyjny` AS `czy_promocyjny`, `p`.`obraz` AS `obraz`, `p`.`id_kategorii` AS `pid`, `k`.`id_kategorii` AS `cid`, `k`.`nazwa` AS `cname`, `k`.`typ` AS `typ` FROM (`produkty` `p` join `kategorie_prod` `k` on((`p`.`id_kategorii` = `k`.`id_kategorii`))) ;

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
  MODIFY `id_kategorii` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `promocje`
--
ALTER TABLE `promocje`
  MODIFY `id_promocji` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `szczegoly_transakcji`
--
ALTER TABLE `szczegoly_transakcji`
  MODIFY `id_szczegolow` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `transakcja`
--
ALTER TABLE `transakcja`
  MODIFY `id_transakcji` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `wpisy`
--
ALTER TABLE `wpisy`
  MODIFY `id_wpisu` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk2` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie_prod` (`id_kategorii`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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