-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 17-12-01 08:58
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
-- 테이블 구조 `category`
--

CREATE TABLE `category` (
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `category`
--

INSERT INTO `category` (`category`) VALUES
('IT'),
('동물'),
('여행'),
('시사'),
('건강'),
('영화'),
('음식'),
('사랑'),
('직장'),
('육아'),
('학교'),
('음악'),
('예능'),
('문화'),
('예술'),
('철학'),
('사진'),
('도서'),
('역사'),
('생활'),
('게임'),
('스포츠'),
('여가'),
('종교');

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
('ggaca123', 'book', 'novel'),
('ggaca123', 'sports', 'football'),
('qwe123', '스포츠', '축구'),
('qwe123', '역사', '세계사'),
('qweqwe', 'IT', '아이폰');

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
('saulpark', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('test', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('1234', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('saulline', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('aaaaa', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('123123', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('11111', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('qwe123', '$2y$10$.vsyj/pdCTJPPNQa8WdW6utDPmo1BbjX2QinCJMXu/.M0NZdIpdo2', '01012312312', 'qweqwe', '123123', ''),
('qweqwe', '$2y$10$jOmb90Q1wAA.b.UiAl1jgu6N/oRt/UCJ.T7Gittuw3aZgnLhnVFTG', '01011111111', 'qqqq', 'wwww', '');

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
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hits` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `posts`
--

INSERT INTO `posts` (`id`, `memberID`, `category`, `soje`, `title`, `content`, `timestamp`, `hits`) VALUES
(1, 'ggaca123', 'sports', 'football', 'TITLE2', ' content2', '2017-11-27 15:38:59', 0),
(2, 'ggaca123', 'book', 'novel', 'TITLE2', ' moviemovie', '2017-11-30 13:44:27', 1),
(3, 'ggaca123', 'sports', 'football', 'Mr. Son', 'Good job man.', '2017-11-30 13:31:08', 0),
(4, 'ggaca123', 'book', 'novel', 'book', 'book ', '2017-11-30 13:40:43', 2),
(5, 'ggaca123', 'sports', 'football', 'sports!', 'it is sports! ', '2017-11-30 13:41:38', 0),
(6, 'ggaca123', 'sports', 'football', 'bbb', '  kkkk', '2017-11-30 13:42:39', 5),
(7, 'qwe123', '스포츠', '축구', '손흥민의 부진.', '주모!!', '2017-12-01 11:58:13', 0),
(8, 'qwe123', '역사', '세계사', '제 2차 세계대전과 보르도', '와인꿀맛 ', '2017-12-01 12:11:02', 0),
(10, 'qwe123', '스포츠', '축구', '해외축구 근황', '근황입니다 ', '2017-12-01 12:36:00', 0),
(11, 'qwe123', '스포츠', '축구', '대한민국 2018 월드컵 예상', '예상입니다 ', '2017-12-01 12:36:33', 0),
(12, 'qwe123', '스포츠', '축구', '', ' ', '2017-12-01 12:42:41', 0),
(13, 'qwe123', '스포츠', '축구', '123', ' 123', '2017-12-01 12:42:46', 0),
(14, 'qwe123', '스포츠', '축구', '123', ' 123', '2017-12-01 12:53:58', 0),
(15, 'qwe123', '스포츠', '축구', '`1`1', ' `1`1', '2017-12-01 12:55:26', 0),
(18, 'qwe123', '스포츠', '축구', '스포츠', '  ㅋㅋ', '2017-12-01 13:53:53', 0),
(19, 'qweqwe', 'IT', '아이폰', '아이폰X 리뷰', ' 존좋', '2017-12-01 15:42:48', 16);

-- --------------------------------------------------------

--
-- 테이블 구조 `subscription`
--

CREATE TABLE `subscription` (
  `subscriber` varchar(12) NOT NULL,
  `writer` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `subscription`
--

INSERT INTO `subscription` (`subscriber`, `writer`) VALUES
('qwe123', 'ggaca123'),
('qwe123', 'qweqwe');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
