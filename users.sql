-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2026 at 05:29 AM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u559276167_learn_ccna`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verification_token` varchar(64) DEFAULT NULL,
  `auth_provider` varchar(32) NOT NULL DEFAULT 'email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `created_at`, `role`, `status`, `is_verified`, `verification_token`, `auth_provider`) VALUES
(1, 'Asif', 'asif@gmail.com', '$2y$10$nh8ExwEMFrbbsoYrDLv7v.gCam2uZuqvwJfLAk5jxrl02qEkecxNW', 1773666643701, 'user', 'active', 1, NULL, 'email'),
(2, 'Hifsa', 'teamhifsa@gmail.com', '$2y$10$VEkgTDluvu7qPu4D3zngzu4dyLv0ATDEkuir2VsTTJqTBD23e0X2S', 1773688342861, 'admin', 'active', 1, NULL, 'email'),
(3, 'Muhammad Shahid', 'everydayisnewopportunity@gmail.com', '$2y$10$GKf1WT4fvPmI8BcWl1X7eeM.6cI/G4eGZRb86D4RuludQJeXfAPRm', 1773705064532, 'user', 'active', 1, NULL, 'email'),
(4, 'Muhammad SK', 'muhammadsulemank949@gmail.com', '$2y$10$TvR5q1/ko.FuqshcqiffgeRHXC3ePa8ILq1ZlkYHEM22N98C/WXvK', 1773719159624, 'user', 'active', 1, NULL, 'email'),
(5, 'Maaz bangash', 'maazb8477@gmail.com', '$2y$10$3EEMcKzEHEAch.0tR/qW.OBrFAkpy.18NkZTjiPF1qT9oWkcgKYZO', 1773721525268, 'user', 'active', 1, NULL, 'email'),
(6, 'Muhammad Nauman', 'naumankhanbs17@gmail.com', '$2y$10$FTJ2SgH1Q7UbKnUQu9o4TOxtJFnUlmNSxu4XMUTq/sOetReFqWGgK', 1773726489547, 'user', 'active', 1, NULL, 'email'),
(7, 'Hammad', 'hammadsadiq@msn.com', '$2y$10$E8eCvzZhGfhHmZrC7pDO7uYHtLapaXQ9tkRxmQzW7zer/Ug1a3gmK', 1773728560491, 'user', 'active', 1, NULL, 'email'),
(8, 'JayRam BK', 'jayrambk58@gmail.com', '$2y$10$Ey0lztVhkcFEjB3t2SIPieOV4NrZxtKAKuHiz.Zmny7JaqHmQkxDC', 1773732012305, 'user', 'active', 1, NULL, 'email'),
(9, 'Asad Naeem', 'm.asadnaeem3007@gmail.com', '$2y$10$zw2ZJauD/mpvrY5oAHY2SOTIUZDW96zA1Tt2r5bK0RrK8.y/LluqK', 1773732110170, 'user', 'active', 1, NULL, 'email'),
(10, 'Sajid', 'hsajid230@gmail.com', '$2y$10$D1XZX3Y26DFrREgl7O.mHe.pYbU6GKujQ978Q3R2yX7dYSRYSPzue', 1773734267826, 'user', 'active', 1, NULL, 'email'),
(11, 'Sardar Muhammad Haris', 'smharis13@gmail.com', '$2y$10$0FzphEj3ey2IbclOFWQq8Ouu5kod.zF2bdiPZvDnQSLRyLEAif5S6', 1773736618375, 'user', 'active', 1, NULL, 'email'),
(12, 'Huzaif', 'huzaifakhanchm@gmail.com', '$2y$10$beIt3kX3v1Hlw/zKgl82SeEIH3jJd5fyhHRc0IYnuuwcdh27DG.Ju', 1773739400428, 'user', 'active', 1, NULL, 'email'),
(13, 'Farman', 'fgbhatti29@gmail.com', '$2y$10$iiuSSi2YWiGMlE5ZEyZoDedOybapfkJlYah0YN.Zo6PqD8MdHdCKi', 1773743732781, 'user', 'active', 1, NULL, 'email'),
(14, 'Sakhawat Shah', 'sakhawat4159@gmail.com', '$2y$10$7SP3TGvK9/xdDn69dlYpduSS8J5skGEaOBQ9jzqJWAQrT4VxqiaOK', 1773756104518, 'user', 'active', 1, NULL, 'email'),
(15, 'HUSSNAIN ILYAS', 'hussnainsckhan@gmail.com', '$2y$10$HoxsmIpqqYdTQHEXpJsDYex0tae8R3X4I36hblW4IPOgqxT/ISCQG', 1773759029417, 'user', 'active', 1, NULL, 'email'),
(16, 'Mahr Ahmad Rehman', 'mahrahmadrehman@gmail.com', '$2y$10$0IFhzZZw1QUaCOKCKf2CSORtYR1RRS.TuAO1ZlPre2GTLiQp6z95C', 1773760920628, 'user', 'active', 1, NULL, 'email'),
(17, 'Kifayat ullah', 'ku725695@gmail.com', '$2y$10$QDTjeqbvc65SoPsqw7ipdOGYH7Y7cPfB4VUATKr5fVRtqGvileQ4C', 1773765623536, 'user', 'active', 1, NULL, 'email'),
(18, 'SAQIB ALI', 'saqibit786@gmail.com', '$2y$10$x5mQt1I0vBfHZT9FPaM/ButZOu9EGGTH40djAEbXDmOXaAa.ZiXP2', 1773792428718, 'user', 'active', 1, NULL, 'email'),
(19, 'M zahid khan', 'zahidkhan03000@gmail.com', '$2y$10$puWPi041Db1W1vBcE6qRQOod2YJK4MA/wya11v.ATGYsKLlf1QI6W', 1773795068159, 'user', 'active', 1, NULL, 'email'),
(20, 'Fakhar Razzaq', 'fakharrazzaq67@gmail.com', '$2y$10$A5kq4RDc1GnTWjGbHg7QIugorVRRqctquFauaBMUbEb/Z7W5fsnJe', 1773803328017, 'user', 'active', 1, NULL, 'email'),
(21, 'Zeeshan ali', 'zeeshanchaudhary858@gmail.com', '$2y$10$s4ydMKWUmEaMGGsNY6jQ9.t/6KF349fhmnmt8pCVF.tClrifjZPea', 1773836660079, 'user', 'active', 1, NULL, 'email'),
(22, 'Muhammad Umar', 'umarkhn7869@gmail.com', '$2y$10$Y8TCfoS9vbjG/hxCSqdrx./tIErYDRBTSa30VpGGdG3h2Er3MSSnC', 1773849145834, 'user', 'active', 1, NULL, 'email'),
(23, 'Tayyab', 'juttshaab74@gmail.com', '$2y$10$Ly9BALKDLtxABlYgcU902up8j3BABs5pwHiwklE1XSypr6.Ul4xNe', 1773861350997, 'user', 'active', 1, NULL, 'email'),
(24, 'Hafsa', 'mafilow163@onbap.com', '$2y$10$dRYCyLZFpUtFWCnsKKoIf.VW5KPGIZug7wY1Jivqb738R.5vmLtgS', 1773902159449, 'user', 'active', 1, NULL, 'email'),
(28, 'jhon ripper', 'jhonripper893@gmail.com', 'google_oauth_1803926ee9fcc87c', 1773968208189, 'user', 'active', 1, NULL, 'email'),
(30, 'Haqi Ultra', 'haqiultra@gmail.com', 'google_oauth_5fa5d1da4762a092', 1773972674698, 'user', 'active', 1, NULL, 'google'),
(31, 'Mohsin Ali', 'rmohsin.ali890@gmail.com', '$2y$10$.B.dmNmglj8qTi2R0tDDIuH0QEnOZkpQWJgVj6uScKC1vMq4l6Vom', 1773997889494, 'user', 'active', 1, NULL, 'email'),
(32, 'Shahzad Ahmed', 'shazimoon667@gmail.com', '$2y$10$/rQPlAa1cDRgYlFraMp4KO.NFd.lZ3wB2GXRNk4CYFcY9m.XxOhMe', 1774152799135, 'user', 'active', 1, NULL, 'email'),
(33, 'ArsLan Tahir', 'arslan464as@gmail.com', '$2y$10$SUpIxt0AC.LFMMvJZBQ33OI1gjAwfCLcYrqcbu0wHuKVyVsuED87i', 1774162729622, 'user', 'active', 1, NULL, 'email'),
(34, 'ASIM SHARIF', 'asimgujjar42@gmail.com', '$2y$10$oqhfnGUHGdD8xjbVvoTWp.JPCBFQOmjMg13fDCA69kx.uBW9RvC4q', 1774199132753, 'user', 'active', 1, NULL, 'email'),
(35, 'Usman Saeed', 'pakwebdata@gmail.com', '$2y$10$PAkAdhQFY3HMz5mCGSQF..MQt77SPROzO.ERHXWwQGEjdVTq0DnnK', 1774269032881, 'user', 'active', 1, NULL, 'email'),
(36, 'Rehman Mustafa', 'rehmanmustafasoomro800@gmail.com', '$2y$10$YzRiW42mlQhS951abgXl8uH3QUICl6uD0HSsVoeIqxGWpWoQ6xAOy', 1774505485481, 'user', 'active', 1, NULL, 'email'),
(37, 'Jibran Ali', 'jibrannarejo2k20@gmail.com', '$2y$10$cbVeWD/ldsgm2VxWzAKyuOnQnyXCLuCxYlc575u29x0fkTrw7UogK', 1774554467682, 'user', 'active', 1, NULL, 'email'),
(38, 'Azam', 'azamlazar1988@gmail.com', '$2y$10$/IO1wT.WM0.Htf6Lw2WWDOiyepZ3KMC4TrufoOOoSjNPvwE4aXiLu', 1775030637023, 'user', 'active', 1, NULL, 'email'),
(39, 'muhammad', 'bilalkhancs151@gmail.com', '$2y$10$.d4jGh0SpRNJzBehCglK/uldV5dY27Ig44K6Cz10Lu5EGM998CFJ6', 1775118989464, 'user', 'active', 1, NULL, 'email'),
(40, 'Saroor Ayub', 'pk943374@gmail.com', '$2y$10$Ka1H2VYjD/3q9QovxQI4metdS1w224DvpZHoaGyc6tR/2zLdB5kTm', 1775179569803, 'user', 'active', 1, NULL, 'email'),
(41, 'Shakeel Ahmed', 'sa6724272@gmail.com', '$2y$10$S2zLQYNTwqZt.09Z5P5FyumqvumdPRyXFL6vwD2Crz4AuTdFIdSVi', 1775269165729, 'user', 'active', 1, NULL, 'email'),
(42, 'Zafar', 'zafarullah711@gmail.com', '$2y$10$o3iiJm38oiqxTS2eIoMSz./lsn4EyPm/9hu4y.FtihngGfBWD1BX2', 1775439919936, 'user', 'active', 1, NULL, 'email');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
