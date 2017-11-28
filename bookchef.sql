-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 17-11-28 06:44
-- 서버 버전: 5.7.20
-- PHP 버전: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `bookchef`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `keyword`
--

CREATE TABLE `keyword` (
  `id` varchar(12) NOT NULL,
  `category` varchar(20) NOT NULL,
  `soje` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `keyword`
--

INSERT INTO `keyword` (`id`, `category`, `soje`) VALUES
('ggaca123', 'book', 'novel');

-- --------------------------------------------------------

--
-- 테이블 구조 `members`
--

CREATE TABLE `members` (
  `id` varchar(12) DEFAULT NULL,
  `pw` varchar(100) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `intro` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `members`
--

INSERT INTO `members` (`id`, `pw`, `phone`, `name`, `nickname`, `intro`) VALUES
('saulpark', 'qkrtmddn', '01097015065', 'ë°•ìŠ¹ìš°', 'ë°©êµ¬ë°©êµ¬', ''),
('test', '$2y$10$u15oNWbfch5/dcwd1EAGpeR//6BujTbWwCM37dASGVZ/jXkxKzctq', '010971', 'paul', 'paul', ''),
('1234', '$2y$10$.CveX2q2GurV95QeLwM0QuQ31Ndp6kvreBYvgFctrVZnR9OdNxP7G', '01097015065', '1234', '1234', ''),
('saulline', '$2y$10$A5hbD7.vefVN8k.x7Sxq5.uUIthEtUUxKkpeTM/6X6aiRcY.0yS9S', '01012341234', '욜로', '얄루', ''),
('aaaaa', '$2y$10$gpCHEFfrcr3UU.WJTXZRk.2ADH4cXzZGTfMIoSQQWsAozTLrI4qvu', '01097015065', 'aaaa', 'aaaa', ''),
('ggaca123', '$2y$10$qx3zdSgpSq1phxZm2GzzneU7SMEuljGK5uvGvSbLDB5Hm2DQCxJLa', '01096444444', '박승우', '까까깎', ''),
('123123', '$2y$10$fpXb.OrxlcEDKrATE0AV4ei7.9ltV./mEnylSYZEb6THmLeXc2M3q', '01012341234', '123123', '123123', ''),
('11111', '$2y$10$WToA0NaOQO3TZZiBrrraoeuk1lwFLG.VJ4dxYGaIg3PIeQWcYx3Qq', '01011111111', '11111', '11111', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `memberID` varchar(12) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `soje` varchar(20) DEFAULT NULL,
  `title` varchar(30) NOT NULL DEFAULT 'TITLE',
  `content` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hits` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`id`, `memberID`, `category`, `soje`, `title`, `content`, `timestamp`, `hits`) VALUES
(1, 'ggaca123', 'category', 'soje', 'TITLE', 'content', '2017-11-27 15:38:59', 0),
(2, 'ggaca123', 'movie', 'mymovie', 'TITLE', 'moviemovie', '2017-11-28 13:24:50', 0),
(3, 'ggaca123', 'Sports', 'Football', 'Liverpool vs Chelsea Review', 'Liverpool vs Chelsea was a good match.', '2017-11-28 14:33:07', 0),
(4, 'ggaca123', 'Sports', 'Football', 'Liverpool vs Chelsea Review', 'Liverpool vs Chelsea was a good match.', '2017-11-20 15:00:00', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `subscription`
--

CREATE TABLE `subscription` (
  `subscriber` varchar(12) NOT NULL,
  `writer` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `keyword`
--
ALTER TABLE `keyword`
  ADD PRIMARY KEY (`id`,`category`,`soje`);

--
-- 테이블의 인덱스 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscriber`,`writer`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
