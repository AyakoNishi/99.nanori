-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021 年 5 朁E04 日 19:39
-- サーバのバージョン： 10.4.17-MariaDB
-- PHP のバージョン: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `fd7_26_nanori`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `guest_table`
--

CREATE TABLE `guest_table` (
  `user_id` int(8) NOT NULL,
  `user_page` int(3) NOT NULL,
  `guest_id` int(8) NOT NULL,
  `guest_page` int(3) NOT NULL,
  `created_ad` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `guest_table`
--

INSERT INTO `guest_table` (`user_id`, `user_page`, `guest_id`, `guest_page`, `created_ad`) VALUES
(1, 0, 1, 1, '2021-04-29 16:19:21'),
(1, 0, 8, 1, '2021-05-02 01:45:26'),
(1, 1, 8, 1, '2021-04-29 17:29:06'),
(8, 0, 1, 1, '2021-05-04 00:11:50'),
(8, 0, 8, 1, '2021-05-04 00:05:43'),
(8, 1, 8, 1, '2021-05-04 15:58:25'),
(8, 1, 16, 1, '2021-05-04 19:01:03');

-- --------------------------------------------------------

--
-- テーブルの構造 `mypage_table`
--

CREATE TABLE `mypage_table` (
  `user_id` int(8) NOT NULL,
  `page` int(2) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name_yomi` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `circle` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `circle_yomi` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `genre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `genre_yomi` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `main_chara` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `couple` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `NG_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hosoku` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `web_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Pixiv_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FanBox` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `next_eve` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `next_eve_url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_ad` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_ad` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `mypage_table`
--

INSERT INTO `mypage_table` (`user_id`, `page`, `name`, `name_yomi`, `circle`, `circle_yomi`, `genre`, `genre_yomi`, `main_chara`, `couple`, `NG_type`, `hosoku`, `twitter_id`, `web_url`, `Pixiv_id`, `FanBox`, `next_eve`, `next_eve_url`, `image`, `created_ad`, `updated_ad`) VALUES
(1, 1, '名前', 'なまえ', 'サークル１', 'さーくる１', 'BASARA', 'ばさら', '政宗様', 'さなだて', '女体化', 'ほのぼの', '@xxxx', 'https://aaa.aaa', '99999999', 'https://aaa/bbb', 'エアブー', 'https://www.akaboo.jp/', 'mycard/1_1_1_1_PixivFactory_my_card.png', '2021-04-25 15:47:26', '2021-05-03 17:36:48'),
(8, 1, 'hoge2', 'ほげ2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'image/2473170.jpg', '2021-04-25 15:47:26', '2021-04-25 15:47:58'),
(16, 1, 'ほげ６', '  ', 'サークル　ほげ６', '', '', '', '', '', '', '', '', '', '', '', '', '', 'mycard/16_1_3243048_m.jpg.jpg', '2021-05-03 21:23:43', '2021-05-03 21:27:13'),
(18, 1, 'ほげ７', ' ', 'サークルほげ７', '', '', '', '', '', '', '', '', '', '', '', '', '', 'mycard/18_1_18_1_1446562.jpg', '2021-05-04 19:59:27', '2021-05-04 19:59:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_table`
--

CREATE TABLE `users_table` (
  `user_id` int(8) NOT NULL,
  `user_nm` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin` int(1) NOT NULL,
  `created_ad` datetime NOT NULL,
  `updated_ad` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users_table`
--

INSERT INTO `users_table` (`user_id`, `user_nm`, `password`, `is_admin`, `created_ad`, `updated_ad`) VALUES
(1, 'kanri', 'kanri999', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'hoge', 'hoge1', 0, '2021-04-24 18:56:01', '2021-04-24 18:56:01'),
(8, 'hoge2', 'hoge2', 0, '2021-04-24 19:06:51', '2021-04-24 19:06:51'),
(11, 'hoge5', 'hoge5', 0, '2021-05-03 01:19:20', '2021-05-03 01:19:20'),
(16, 'hoge6', 'hoge6', 0, '2021-05-03 21:23:07', '2021-05-03 21:23:07'),
(18, 'hoge7', 'hoge7', 0, '2021-05-04 13:07:01', '2021-05-04 13:07:01'),
(21, 'hoge8', 'hoge8', 0, '2021-05-04 15:07:32', '2021-05-04 15:07:32'),
(22, 'hoge9', 'hoge9', 0, '2021-05-04 15:10:05', '2021-05-04 15:10:05');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `guest_table`
--
ALTER TABLE `guest_table`
  ADD PRIMARY KEY (`user_id`,`user_page`,`guest_id`,`guest_page`);

--
-- テーブルのインデックス `mypage_table`
--
ALTER TABLE `mypage_table`
  ADD PRIMARY KEY (`user_id`,`page`);

--
-- テーブルのインデックス `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_nm` (`user_nm`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
