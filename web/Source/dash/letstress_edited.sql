-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 30 Nis 2022, 17:30:17
-- Sunucu sürümü: 10.3.34-MariaDB
-- PHP Sürümü: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `letstress_edited`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `2authsettings`
--

CREATE TABLE `2authsettings` (
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `actions`
--

CREATE TABLE `actions` (
  `id` int(64) NOT NULL,
  `admin` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `client` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(6444) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(21) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `affiliateWithdraws`
--

CREATE TABLE `affiliateWithdraws` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `withdrawAmount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paymentMethod` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paymentAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `api`
--

CREATE TABLE `api` (
  `id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `api` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `slots` int(3) NOT NULL,
  `methods` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vip` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `api`
--

INSERT INTO `api` (`id`, `name`, `api`, `slots`, `methods`, `vip`) VALUES
(83, 'LWXSERVER', 'https://api.venomstresser.com/?key=1qsr9BqCcxaI2pwG&host=[host]&port=[port]&time=[time]&method=[method]', 4, 'SYNBOT UDPBOT XMASBOT UDPPLAIN VSEBOT OVH', 0),
(102, 'lovestirk', 'http://api.stresser.gg/?key=9AjWZ-ZFVff-nHcEL-dgbaT-iOLAg&action=start&host=[host]&port=[port]&time=[time]&method=[method]', 54, 'HTTPNUXT', 0),
(95, 'LOVEHTTP', 'http://139.162.149.74/api2.php?key=spnlsap0md1vodtdoqxva5kxpx6hs4fr&host=[host]&port=[port]&time=[time]&method=[method]', 4, 'LOVEHTTP', 0),
(112, 'BROWSERVUR', 'http://139.162.149.74/specialisted.php?key=spnlsap0md1vodtdoqxva5kxpx6hs4fr&host=[host]&port=[port]&time=[time]&method=[method]', 40, 'JSBYPASS', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bans`
--

CREATE TABLE `bans` (
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `bans`
--

INSERT INTO `bans` (`username`, `reason`) VALUES
('rootboy', 'aynen kanka'),
('test123w', 'test'),
('SkidStresser', 'you skid?'),
('testget123', 'khoamod'),
('Wolterzzz', ''),
('erick05', ''),
('erick05', ''),
('Wolterzzz', ''),
('alca', 'booter.sx skiddo'),
('Efefix', ''),
('Efefix', 'Gün dpğdu ve yine göremedik.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blacklist`
--

CREATE TABLE `blacklist` (
  `ID` int(11) NOT NULL,
  `data` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cark`
--

CREATE TABLE `cark` (
  `id` int(11) NOT NULL,
  `plan` int(11) NOT NULL DEFAULT 0,
  `sans` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faq`
--

CREATE TABLE `faq` (
  `id` int(3) NOT NULL,
  `question` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `answer` varchar(5000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fe`
--

CREATE TABLE `fe` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `giftcards`
--

CREATE TABLE `giftcards` (
  `ID` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `planID` int(11) NOT NULL,
  `claimedby` int(11) NOT NULL,
  `dateClaimed` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `user` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iplogs`
--

CREATE TABLE `iplogs` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `logged` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `loginlogs`
--

CREATE TABLE `loginlogs` (
  `id` int(11) NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `country` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(4) NOT NULL,
  `method` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `postdata` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ratelimit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cookie` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `chart` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stopped` int(1) NOT NULL DEFAULT 0,
  `handler` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `origin` varchar(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `sender` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `methods`
--

CREATE TABLE `methods` (
  `id` int(2) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `command` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `methods`
--

INSERT INTO `methods` (`id`, `name`, `fullname`, `type`, `command`) VALUES
(116, 'SYN', 'SYN', 'layer4', ''),
(139, 'LOVEHTTP', 'CF-KILL', 'layer7', ''),
(140, 'CFHELL', 'CF-HELL', 'layer7', ''),
(117, 'VSE', 'VSE', 'layer4', ''),
(118, 'LDAP', 'LDAP', 'layer4', ''),
(119, 'MTA', 'MTA', 'layer4', ''),
(120, 'CSGO', 'CSGO', 'layer4', ''),
(111, 'BYPASS', 'SYN (BYPASS)', 'layer4', ''),
(107, 'NTP', 'NTP', 'layer4', ''),
(141, 'DDGHELL', 'DDG-HELL', 'layer7', ''),
(131, 'JSBYPASS', 'BROWSER-BYPASS', 'layer7', ''),
(121, 'FiveM', 'FiveM', 'layer4', ''),
(122, 'TS3', 'TS3', 'layer4', ''),
(123, 'SYNBOT', 'SYNBOT', 'layer4', ''),
(124, 'UDPBOT', 'UDPBOT', 'layer4', ''),
(125, 'XMASBOT', 'XMASBOT', 'layer4', ''),
(126, 'UDPPLAIN', 'UDPPLAIN', 'layer4', ''),
(127, 'VSEBOT', 'VSEBOT', 'layer4', ''),
(128, 'OVH', 'OVH', 'layer4', ''),
(142, 'BROWSERCACHE', 'BROWSER-CACHE', 'layer7', ''),
(143, 'HTTP2KILLER', 'HTTP2-KILLER (PREMIU', 'layer7', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `title` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(55) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`ID`, `title`, `content`, `date`) VALUES
(11, 'Special services are discounted until May.', 'Hello, we offer 10% discount on all our services, you can use promo code MONTH10 when purchasing.', '1647906656'),
(12, 'MULTI-ACC', 'All shared accounts will be banned within 24 hours. Our system will automatically proceed and detect and ban multiple entries. If you shared your account, you must now change your password.\r\n', '1648271793'),
(13, 'WEEKLY WHEEL SYSTEM!', 'Each of our users can win prizes by spinning the wheel every 7 days.\r\n\r\nYou can view the rewards you have earned in the Dashboard -> GiftCode section below and use them whenever you want.\r\n', '1648327499');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `ID` int(11) NOT NULL,
  `paid` float NOT NULL,
  `plan` int(11) NOT NULL,
  `user` int(15) NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `tid` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ping_sessions`
--

CREATE TABLE `ping_sessions` (
  `ID` int(11) NOT NULL,
  `ping_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `ping_ip` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `ping_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `plans`
--

CREATE TABLE `plans` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `vip` int(11) NOT NULL,
  `mbt` int(11) NOT NULL,
  `unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `length` int(11) NOT NULL,
  `price` float NOT NULL,
  `concurrents` int(11) NOT NULL,
  `private` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `plans`
--

INSERT INTO `plans` (`ID`, `name`, `vip`, `mbt`, `unit`, `length`, `price`, `concurrents`, `private`) VALUES
(56, '10conc', 1500, 1500, 'Years', 200, 9999, 10, 1),
(60, 'Reality', 0, 1500, 'Days', 30, 105, 5, 0),
(57, 'Starter', 0, 120, 'Days', 7, 15, 1, 0),
(58, 'JETS', 600, 600, 'Days', 30, 60, 2, 0),
(61, 'Lifetime', 0, 1200, 'Years', 99, 400, 4, 0),
(62, '', 1500, 1500, 'Years', 99, 50, 3, 1),
(63, 'ozel', 400, 400, 'Days', 15, 99, 2, 1),
(64, 'FIX', 1, 86400, 'Years', 64, 9999, 450, 1),
(65, 'ipstress.vip', 0, 1500, 'Years', 99, 500, 5, 1),
(68, 'SURPRISE', 0, 200, 'Days', 1, 10, 1, 0),
(67, 'GETGIFT', 0, 100, 'Days', 1, 10, 2, 0),
(69, 'NORMAL', 0, 60, 'Days', 1, 10, 2, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `report` varchar(644) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `servers`
--

CREATE TABLE `servers` (
  `id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slots` int(3) NOT NULL,
  `methods` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `sitename` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `stripePubKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cooldown` int(11) NOT NULL,
  `cooldownTime` int(11) NOT NULL,
  `paypal` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bitcoin` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stripe` int(11) NOT NULL,
  `maintaince` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rotation` int(1) NOT NULL DEFAULT 0,
  `system` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `maxattacks` int(5) NOT NULL,
  `testboots` int(1) NOT NULL,
  `cloudflare` int(1) NOT NULL,
  `skype` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `issuerId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `coinpayments` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ipnSecret` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `google_site` varchar(644) COLLATE utf8_unicode_ci NOT NULL,
  `google_secret` varchar(644) COLLATE utf8_unicode_ci NOT NULL,
  `btc_address` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `secretKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cbp` int(1) NOT NULL,
  `paypal_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `stripeSecretKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`sitename`, `stripePubKey`, `url`, `description`, `cooldown`, `cooldownTime`, `paypal`, `bitcoin`, `stripe`, `maintaince`, `rotation`, `system`, `maxattacks`, `testboots`, `cloudflare`, `skype`, `key`, `issuerId`, `coinpayments`, `ipnSecret`, `google_site`, `google_secret`, `btc_address`, `secretKey`, `cbp`, `paypal_email`, `theme`, `logo`, `stripeSecretKey`) VALUES
('GETSTRESS', '', 'https://getstress.net/', 'Best stresser, L4 / L7 in market.', 0, 1648460370, '', '', 0, '', 1, 'api', 400, 0, 1, '', '', '', '', '', '6Lf_3a4eAAAAADI7gzzu9EVbn7ZMj00DRIhbfKdc', '6Lf_3a4eAAAAAEVXNQghlwnwFeIkeJCnSw7I9wq0', '', '', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `smtpsettings`
--

CREATE TABLE `smtpsettings` (
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `subject` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `tickets`
--

INSERT INTO `tickets` (`id`, `subject`, `content`, `status`, `username`, `date`) VALUES
(1, 'Test', 'Hello!', 'Waiting for user response', 'Kaneki', 1642257963),
(2, 'Hey', 'Do you know, what i have big dick?', 'Closed', 'Swebs', 1642270672),
(3, 'sdad', 'asdad', 'Closed', 'ALH1MIK', 1642345602),
(4, 'dsa', 'das', 'Closed', 'qweqweqwe', 1642415916),
(5, '?????', '???????', 'Closed', 'qweqwe', 1642491956),
(6, '????????', '????', 'Closed', 'qweqwe', 1642491972),
(7, 'sdfsdfsdfs', 'fdsfsdfds', 'Waiting for user response', 'qweqwe', 1642491974),
(8, 'test', 'test', 'Closed', 'fdsgfsdgfg', 1643074365),
(9, 'gfd', 'gfd', 'Closed', 'qweqwe1', 1643194193),
(10, 'r', 'r', 'Closed', 'Efefix', 1646691444),
(11, 'r', 'r', 'Closed', 'Efefix', 1646691445),
(12, 'r', 'r', 'Closed', 'Efefix', 1646691446),
(13, '123', '123', 'Closed', 'Efefix', 1646785795),
(14, 'Hey', 'Not hehe', 'Closed', 'Wolterzzz', 1646861781),
(15, 'test', 'test', 'Closed', 'w1sley', 1646918254);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tos`
--

CREATE TABLE `tos` (
  `archive` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `membership` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `referral` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `referralbalance` int(3) NOT NULL DEFAULT 0,
  `testattack` int(1) NOT NULL,
  `activity` int(64) NOT NULL DEFAULT 0,
  `2auth` int(11) NOT NULL,
  `referedBy` int(11) NOT NULL,
  `login_ip` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_useragent` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `cark` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ban_sbp` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `affiliateWithdraws`
--
ALTER TABLE `affiliateWithdraws`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `cark`
--
ALTER TABLE `cark`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fe`
--
ALTER TABLE `fe`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `giftcards`
--
ALTER TABLE `giftcards`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `iplogs`
--
ALTER TABLE `iplogs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Tablo için indeksler `loginlogs`
--
ALTER TABLE `loginlogs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);

--
-- Tablo için indeksler `methods`
--
ALTER TABLE `methods`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Tablo için indeksler `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `ping_sessions`
--
ALTER TABLE `ping_sessions`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `reports`
--
ALTER TABLE `reports`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `sitename` (`sitename`(333));

--
-- Tablo için indeksler `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `affiliateWithdraws`
--
ALTER TABLE `affiliateWithdraws`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `api`
--
ALTER TABLE `api`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Tablo için AUTO_INCREMENT değeri `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `cark`
--
ALTER TABLE `cark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `fe`
--
ALTER TABLE `fe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `giftcards`
--
ALTER TABLE `giftcards`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `iplogs`
--
ALTER TABLE `iplogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `loginlogs`
--
ALTER TABLE `loginlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2868;

--
-- Tablo için AUTO_INCREMENT değeri `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `messages`
--
ALTER TABLE `messages`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `methods`
--
ALTER TABLE `methods`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- Tablo için AUTO_INCREMENT değeri `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `ping_sessions`
--
ALTER TABLE `ping_sessions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `plans`
--
ALTER TABLE `plans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Tablo için AUTO_INCREMENT değeri `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1065;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
