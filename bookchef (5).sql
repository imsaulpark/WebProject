-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 17-12-05 22:13
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
('qwe123', 'IT', '노트북'),
('qwe123', '도서', '자기계발서'),
('qwe123', '동물', '고양이 키우기'),
('qwe123', '생활', '생활'),
('qwe123', '여행', '지구 한바퀴'),
('qwe123', '역사', '세계사'),
('qweqwe', 'IT', '아이폰'),
('webmaster', 'IT', 'CSS 길라잡이'),
('webmaster', 'IT', 'HTML 길라잡이'),
('webmaster', '동물', '냥이의 본능'),
('webmaster', '시사', '신정부');

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
('saulpark', '$2y$10$o1y39DNyw872siwrEBELTuAPv3zSrkOR1ORC/N77gQEuA0zu83kIa', '01096444444', '박승우2', '까까깎2', '123123'),
('test', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('1234', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('saulline', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('aaaaa', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('123123', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('11111', '$2y$10$JtAK9FL1voy2WoSPWTFDk.l7rbIl.LKv5BWEanPeTDzQY9a1Bjcwu', '01096444444', '박승우2', '까까깎2', '123123'),
('qwe123', '$2y$10$CtVFXvVc4pPnnV0lt.HWLu5Qxl0FsWvIk4W23HcRFBaTXnIRYVI9S', '01012312312', '박승우', '달려라슛돌이', 'Giftless people will talk about the talent. Talented people will talk about the fun.'),
('qweqwe', '$2y$10$jOmb90Q1wAA.b.UiAl1jgu6N/oRt/UCJ.T7Gittuw3aZgnLhnVFTG', '01011111111', 'qqqq', 'wwww', ''),
('webmaster', '$2y$10$5ClXw5S9xBYuapWaeJoEbeQO87Hk6WI/8rycTqB5qGCQH6MGWsqxW', '01023233232', '김길동', '홍길동', 'intro.'),
('sososo', '$2y$10$aUD35XrO9TO9XOE194c5SuCxx2OEUi7q80w6fxt0jyduYHwU2HdjC', '01012312312', '소소소', '솟솟솟', '010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312\r\n010-12312312');

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
(4, 'ggaca123', 'book', 'novel', 'book', 'book ', '2017-11-30 13:40:43', 3),
(5, 'ggaca123', 'sports', 'football', 'sports!', 'it is sports! ', '2017-11-30 13:41:38', 0),
(6, 'ggaca123', 'sports', 'football', 'bbb', '  kkkk', '2017-11-30 13:42:39', 7),
(7, 'qwe123', 'IT', '노트북', '손흥민 시즌 5호골 토트넘, 왓포드와 무승부!', ' 								 								 																 \'손세이셔널\' 손흥민(토트넘 홋스퍼)이 리그 3호골을 넣으며 무승부를 제조했다.<br><br>토트넘 홋스퍼는 3일오전 (한국시간) 영국 왓포드의 비커리지 로드에서 열린 2017~2018 잉글리시 프리미어리그 15라운드 왓포드와의 원정 경기에서 1-1로 비겼다.<br><br>하지만, 4경기 무승(2무 2패) 고리를 끊지 못했고 승점 25점에 그치며 6위에 머물렀다. 4위 리버풀과는 승점 3점 차이다.<br><br>전반 12분 카바셀레에게 실점한 상황에서 손흥민의 한 방이 토트넘을 살렸다. 왼쪽 측면 공격수로 출전한 손흥민은 25분 크리스티안 에릭센이 오른쪽 측면에서 수비 뒷공간 사이로 낮게 패스한 볼을 잡아 오른발로 골망을 갈랐다. 수비의 오프사이드 함정을 절묘하게 극복하며 골맛을 봤다.<br><br>시즌 5호골이면서 리그 3호골이다. 지난 22일 보루시아 도르트문트(독일)와 유럽축구연맹(UEFA) 챔피언스리그(UCL) 결승골 이후 11일 만의 골이다.<br><br>하지만, 후반 7분 다빈손 산체스의 퇴장으로 수적 열세게 몰렸다. 고민하던 마우리시오 포체티노 감독은 에릭센을 빼고 무사 시소코, 32분 손흥민을 빼고 에릭 라멜라를 넣었지만 상황은 달라지지 않았고 무승부만 확인했다.<br><br>스완지시티는 꼴찌 탈출에 실패했다. 스토크시티 원정 경기에서 전반 3분 윌프레드 보니의 선제골로 앞서갔지만 36분 샤키리, 40분 디우프에게 연속골을 내주며 1-2로 졌다.<br><br>7경기째 무승(1무 6패)으로 극심한 부진이다. 챔피언십(2부리그) 강등권은 20위를 벗어나지 못했다. 기성용은 이날 중앙 미드필더로 선발 출전해 풀타임을 소화했다.<br><br>부상으로 재활에 집중하고 있는 이청용(크리스탈 팰리스)은 웨스트브로미치 알비언전에 결장했다. 팀은 0-0으로 비겼고 강등권인 18위에 머물렀다.<br>												 							 							 							', '2017-12-01 11:58:13', 50),
(8, 'qwe123', '역사', '세계사', '제 2차 세계대전과 보르도', '와인꿀맛 ', '2017-12-01 12:11:02', 0),
(10, 'qwe123', '스포츠', '축구', '해외축구 근황', '근황입니다 ', '2017-12-01 12:36:00', 0),
(11, 'qwe123', '스포츠', '축구', '대한민국 2018 월드컵 예상', '예상입니다 ', '2017-12-01 12:36:33', 0),
(12, 'qwe123', '스포츠', '축구', '', ' ', '2017-12-01 12:42:41', 0),
(13, 'qwe123', '스포츠', '축구', '123', ' 123', '2017-12-01 12:42:46', 0),
(14, 'qwe123', '스포츠', '축구', '123', ' 123', '2017-12-01 12:53:58', 0),
(15, 'qwe123', '스포츠', '축구', '`1`1', ' `1`1', '2017-12-01 12:55:26', 0),
(18, 'qwe123', '스포츠', '축구', '스포츠', '  ㅋㅋ', '2017-12-01 13:53:53', 0),
(19, 'qweqwe', 'IT', '아이폰', '아이폰X 리뷰', ' 존좋', '2017-12-01 15:42:48', 164),
(20, 'qwe123', 'IT', '노트북', '2018 러시아 월드컵 조추첨 결과', ' 조금전 끝난 <br>2018년 러시아 월드컵 조추첨이<br>끝난 가운데 한국은 <br>FIFA 랭킹 1위 독일과 함께<br>랭킹 16위 멕시코, <br>랭킹 25위 스웨덴과 함께 <br>F조에...<br><br>워낙 대표팀의 월드컵 예선 경기 <br>결과에 실망을 했기에<br>큰 기대는 안했지만 막상 조추첨 결과를 보니 <br>좋은 결과를 예상하기에는 힘들어 보입니다.<br><br>다만 지금부터라도 열심히 준비하여 <br>망신을 당하지 않는 <br>경기 결과를 보여줬으면 하는 바람으로...<br><br>마지막 일본과 마지막 자리를 두고 <br>일본이 F조에 한국이 H조에 <br>나오기를 바랬는데 아쉽네요.<br>F조보다는 그래도 H조가 그나마..~~<br><br>2018년 러시아 월드컵 조편성 결과<br><br>A조=러시아, 사우디, 이집트, 우루과이<br>B조=포르투갈, 스페인, 모로코, 이란<br>C조=프랑스, 호주, 페루, 덴마크<br>D조=아르헨티나, 아이슬란드, 크로아티아, 나이지리아<br>E조=브라질, 스위스, 코스타리카, 세르비아<br>F조=독일, 멕시코, 스웨덴, 한국<br>G조=벨기에, 파나마, 튀니지 , 잉글랜드<br>H조=폴란드, 세네갈, 콜롬비아, 일본<br><br><br><대한민국 경기 일정><br><br>1차전 <br>2018년 6월 18일 밤 9시- 스웨덴 : 한국<br><br>2차전 <br>2018년 6월 24일 자정 0시 - 한국 : 멕시코<br>(기존 새벽 3시에서 변경 공지)<br><br>3차전 <br>2018년 6월 27일 밤 11시 - 한국 : 독일<br>', '2017-12-02 14:47:33', 0),
(21, 'qwe123', '역사', '세계사', '맨유 vs 아스날 3:1', '   아스날이 맨유 골키퍼 다비드 데 헤아의 \'신들린 선방쇼\' 앞에 무릎을 꿇었다. 아스날은 무려 33개의 슈팅을 시도하고도 졌다.<br><br>3일 오전 2시 30분(한국시각) 잉글랜드 런던 에미레이츠 스타디움서 열린 아스날과 맨유의 2017-2018 잉글리시 프리미어리그 15라운드 경기서 아스날이 1-3으로 패했다.<br><br>이날 전반 4분 안토니오 발렌시아의 선제골에 이은 전반 11분 제시 린가드가 추가골로 맨유가 2골을 먼저 터트리며 경기를 리드했다.<br><br>아스날은 후반 3분 라카제트의 골로 추격에 나섰지만 후반 17분 린가드가 또 한 번 골을 뽑아내며 아스날의 추격 의지를 꺾었다.<br><br>이날 단연 돋보인 선수는 맨유의 데 헤아다. 그는 전반 19분 라카제트의 슈팅을 막아냈고 전반 31분에도 몸을 날린 선방으로 라카제트의 득점 기뢰를 차단했다.<br><br>아스날은 총 슈팅 33개라는 엄청난 맹공을 퍼부었지만 번번히 데 헤아에게 막혔다.<br><br>심지어 전반 추가시간 골대 바로 앞에서 수비하던 루카쿠의 몸에 맞아 자책골이 될 뻔 했던 공을 놀라운 반응속도로 쳐내는 등 만점활약을 보여준 데 헤아는 이날 무려 14개의 선방을 기록했다.<br><br>Read more: http://www.segye.com/newsView/20171203000854#csidx751b427e6b26f02a5ce012dd275887d <br>Copyright © LinkBack', '2017-12-03 04:42:50', 0),
(23, 'qwe123', 'IT', '노트북', '맨유 아스날!', ' 																아스날이 맨유 골키퍼 다비드 데 헤아의 \'신들린 선방쇼\' 앞에 무릎을 꿇었다. 아스날은 무려 33개의 슈팅을 시도하고도 졌다.<br><br>3일 오전 2시 30분(한국시각) 잉글랜드 런던 에미레이츠 스타디움서 열린 아스날과 맨유의 2017-2018 잉글리시 프리미어리그 15라운드 경기서 아스날이 1-3으로 패했다.<br><br>이날 전반 4분 안토니오 발렌시아의 선제골에 이은 전반 11분 제시 린가드가 추가골로 맨유가 2골을 먼저 터트리며 경기를 리드했다.<br><br>아스날은 후반 3분 라카제트의 골로 추격에 나섰지만 후반 17분 린가드가 또 한 번 골을 뽑아내며 아스날의 추격 의지를 꺾었다.<br><br>이날 단연 돋보인 선수는 맨유의 데 헤아다. 그는 전반 19분 라카제트의 슈팅을 막아냈고 전반 31분에도 몸을 날린 선방으로 라카제트의 득점 기뢰를 차단했다.<br><br>아스날은 총 슈팅 33개라는 엄청난 맹공을 퍼부었지만 번번히 데 헤아에게 막혔다.<br><br>심지어 전반 추가시간 골대 바로 앞에서 수비하던 루카쿠의 몸에 맞아 자책골이 될 뻔 했던 공을 놀라운 반응속도로 쳐내는 등 만점활약을 보여준 데 헤아는 이날 무려 14개의 선방을 기록했다.<br>																		 							', '2017-12-03 04:54:47', 0),
(24, 'webmaster', NULL, 'CSS', 'What is HTML?', 'HTML is a computer language devised to allow website creation. These websites can then be viewed by anyone else connected to the Internet. It is relatively easy to learn, with the basics being accessible to most people in one sitting; and quite powerful in what it allows you to create. It is constantly undergoing revision and evolution to meet the demands and requirements of the growing Internet audience under the direction of the » W3C, the organisation charged with designing and maintaining the language.<br><br>The definition of HTML is HyperText Markup Language.<br><br>HyperText is the method by which you move around on the web — by clicking on special text called hyperlinks which bring you to the next page. The fact that it is hyper just means it is not linear — i.e. you can go to any place on the Internet whenever you want by clicking on links — there is no set order to do things in.<br>Markup is what HTML tags do to the text inside them. They mark it as a certain type of text (italicised text, for example).<br>HTML is a Language, as it has code-words and syntax like any other language.', '2017-12-04 12:49:53', 0),
(25, 'webmaster', NULL, 'HTML', 'How HTML Work?', 'HTML consists of a series of short codes typed into a text-file by the site author — these are the tags. The text is then saved as a html file, and viewed through a browser, like Internet Explorer or Netscape Navigator. This browser reads the file and translates the text into a visible form, hopefully rendering the page as the author had intended. Writing your own HTML entails using tags correctly to create your vision. You can use anything from a rudimentary text-editor to a powerful graphical editor to create HTML pages.', '2017-12-04 12:51:17', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
