-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2018 at 12:23 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nnhslms-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `profileimg` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `contactno` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `hobbies` varchar(200) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`fname`, `lname`, `username`, `password`, `usertype`, `profileimg`, `userid`, `gender`, `birthdate`, `age`, `contactno`, `email`, `bio`, `hobbies`, `enrollment_id`) VALUES
('Samonte', 'Ryan Joseph', 'ryanRS', '1234', 'teacher', '', 1, NULL, NULL, NULL, '', '', '', '', NULL),
('Ryan Joseph', 'Samonte', 'ry', '/', 'teacher', 'ID Pic.jpg', 2, 'Male', '1999-06-01', 18, '091121213123', 'samonteryanjoseph@gmail.com', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distrib', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distrib', NULL),
('Julia', 'Barretto', 'julski', '1234', 'student', 'user.png', 4, 'Female', '', 0, '', '', '', '', 1),
('Ryan', 'Samonte', 'ryannnn', '/', 'student', 'user.png', 5, '', '', 0, '', '', '', '', 2),
('Cardo', 'Dalisay', 'probi', '/', 'student', 'user.png', 6, 'Male', '', 0, '', '', '', '', 3),
('Scottie', 'Thompson', 'skat', '006', 'teacher', 'user.png', 7, 'NONE', 'NONE', 0, 'NONE', 'NONE', 'NONE', 'NONE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment`
--

CREATE TABLE `tbl_assignment` (
  `assign_name` varchar(100) DEFAULT NULL,
  `assign_date` varchar(50) DEFAULT NULL,
  `filename_assign` varchar(100) DEFAULT NULL,
  `subjectid_assign` varchar(100) DEFAULT NULL,
  `assign_id` int(11) NOT NULL,
  `archivestatus_assign` int(1) DEFAULT NULL,
  `assign_desc` varchar(200) DEFAULT NULL,
  `datetimestamp_assign` datetime DEFAULT NULL,
  `deadline_assign` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_assignment`
--

INSERT INTO `tbl_assignment` (`assign_name`, `assign_date`, `filename_assign`, `subjectid_assign`, `assign_id`, `archivestatus_assign`, `assign_desc`, `datetimestamp_assign`, `deadline_assign`) VALUES
('Thisisit', 'April 02, 2018 04:55:16 am', 'DBA_-_SQL_-_Subquery-_pdf.pdf', '483ca99250ebfccb9a04cc17d2f69227', 1, 1, 'TENNTNENENTNNENRNRR', '2018-04-01 12:55:16', ''),
('BLABLA', 'March 23, 2018 01:17:43 am', 'Lecture_3-_IP_Classful_Addressing.pdf', '483ca99250ebfccb9a04cc17d2f69227', 2, 1, 'asdasdddd', NULL, ''),
('Test', 'assign_date', 'filename_assign', 'subjectid_assign', 3, 0, 'assign_desc', '2018-04-05 01:59:08', 'deadline_assign'),
('Foil AgainandAgain', 'assign_date', 'filename_assign', 'subjectid_assign', 4, 0, 'assign_desc', '2018-04-05 01:56:22', 'deadline_assign'),
('Foile', '', '', '', 5, 0, 'gergergerg', '2018-04-05 02:06:02', ''),
('Gagana na itoooooooooooo', 'April 05, 2018 06:11:28 pm', 'ID Pic.jpg', '', 6, 0, 'butter coconut HAHAAHAHAHAH', '2018-04-05 02:11:28', '2018-04-29 20:40'),
('hhhhhhYYYYYYYYYYYYKKKKKKKKKK', 'April 05, 2018 06:15:22 pm', 'IMG20171012123402.jpg', '483ca99250ebfccb9a04cc17d2f69227', 7, 0, 'kjuuigj', '2018-04-05 02:15:22', '2018-04-18 19:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment_record`
--

CREATE TABLE `tbl_assignment_record` (
  `assignment_record_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `submission_desc` varchar(5000) NOT NULL,
  `grade` int(11) NOT NULL,
  `submission_status` varchar(2) NOT NULL,
  `datetimestamp` datetime NOT NULL,
  `subjectid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_assignment_record`
--

INSERT INTO `tbl_assignment_record` (`assignment_record_id`, `assignment_id`, `student_id`, `filename`, `submission_desc`, `grade`, `submission_status`, `datetimestamp`, `subjectid`) VALUES
(4, 4, 4, 'IMG20171012123402.jpg', 'fhfgh', 0, 'S', '2018-04-05 01:11:46', '483ca99250ebfccb9a04cc17d2f69227');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_enrollment`
--

CREATE TABLE `tbl_enrollment` (
  `enrollment_id` int(11) NOT NULL,
  `enrollment_id_student` int(11) DEFAULT NULL,
  `accesscode` varchar(50) DEFAULT NULL,
  `datestamp` varchar(50) DEFAULT NULL,
  `datetimestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_enrollment`
--

INSERT INTO `tbl_enrollment` (`enrollment_id`, `enrollment_id_student`, `accesscode`, `datestamp`, `datetimestamp`) VALUES
(2, 1, '2018322Sci341pm48', 'March 23, 2018 11:55:55 am', NULL),
(3, 2, '2018322Fil342pm59', 'March 23, 2018 12:55:55 pm', NULL),
(4, 3, '2018322Sci341pm48', 'March 23, 2018 02:55:55 pm', NULL),
(5, 1, '2018322TLE306pm14', 'March 24, 2018 12:55:55 am', NULL),
(6, 1, '2018322Fil342pm59', 'April 04, 2018 05:29:30 pm', NULL),
(7, 1, '2018322Soc325pm31', 'April 04, 2018 05:48:28 pm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_session`
--

CREATE TABLE `tbl_exam_session` (
  `date_start` varchar(50) DEFAULT NULL,
  `time_limit` varchar(50) DEFAULT NULL,
  `exam_session_id` int(11) NOT NULL,
  `subjectid` varchar(50) DEFAULT NULL,
  `exam_title` varchar(100) DEFAULT NULL,
  `no_of_items` int(11) DEFAULT NULL,
  `archive_exam` varchar(1) NOT NULL,
  `datetimestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_exam_session`
--

INSERT INTO `tbl_exam_session` (`date_start`, `time_limit`, `exam_session_id`, `subjectid`, `exam_title`, `no_of_items`, `archive_exam`, `datetimestamp`) VALUES
('03/01/2018', '20', 1, '483ca99250ebfccb9a04cc17d2f69227', 'Periodical', 10, '1', '0000-00-00 00:00:00'),
('04/01/2018', '60', 2, '483ca99250ebfccb9a04cc17d2f69227', '2nd Periodical Examination', 60, '0', '0000-00-00 00:00:00'),
('2018-04-05 01:15', '20', 3, '483ca99250ebfccb9a04cc17d2f69227', 'Quiz No. 2', 5, '0', '2018-04-04 00:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lesson_file`
--

CREATE TABLE `tbl_lesson_file` (
  `lessonname_file` varchar(100) NOT NULL,
  `dateposted_file` varchar(50) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `subjectid_file` varchar(100) NOT NULL,
  `lessonid_file` int(11) NOT NULL,
  `archivestatus_file` varchar(1) NOT NULL,
  `lessondesc_file` varchar(200) DEFAULT NULL,
  `datetimestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lesson_file`
--

INSERT INTO `tbl_lesson_file` (`lessonname_file`, `dateposted_file`, `filename`, `subjectid_file`, `lessonid_file`, `archivestatus_file`, `lessondesc_file`, `datetimestamp`) VALUES
('Barangay', 'March 22, 2018 01:17:43 pm', 'Barangay Health Services and Certificate Issuance Management System.pdf', '483ca99250ebfccb9a04cc17d2f69227', 18, '0', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distrib', NULL),
('Forest Trees', 'March 23, 2018 01:17:43 am', 'FOREST  TREES.pptx', '483ca99250ebfccb9a04cc17d2f69227', 19, '0', 'Report about trees', NULL),
('Ecology', 'March 24, 2018 01:17:43 am', '12.jpg', '483ca99250ebfccb9a04cc17d2f69227', 20, '1', 'Ecologyyyy', NULL),
('Music Lesson', 'March 24, 2018 01:42:50 am', '01-Basics.pdf', '483ca99250ebfccb9a04cc17d2f69227', 21, '1', 'Music', '2018-03-24 01:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lesson_url`
--

CREATE TABLE `tbl_lesson_url` (
  `lessonname_url` varchar(100) DEFAULT NULL,
  `dateposted_url` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `subjectid_url` varchar(100) DEFAULT NULL,
  `lessonid_url` int(11) NOT NULL,
  `archivestatus_url` varchar(1) DEFAULT NULL,
  `lessondesc_url` varchar(200) DEFAULT NULL,
  `datetimestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lesson_url`
--

INSERT INTO `tbl_lesson_url` (`lessonname_url`, `dateposted_url`, `url`, `subjectid_url`, `lessonid_url`, `archivestatus_url`, `lessondesc_url`, `datetimestamp`) VALUES
('Download in PHP', 'March 23, 2018 02:15:11 pm', 'https://www.sitepoint.com/community/t/php-download-file-script/8587/4', '483ca99250ebfccb9a04cc17d2f69227', 1, '1', '483ca99250ebfccb9a04cc17d2f69227483ca99250ebfccb9a04cc17d2f69227483ca99250ebfccb9a04cc17d2f69227483ca99250ebfccb9a04cc17d2f69227483ca99250ebfccb9a04cc17d2f69227483ca99250ebfccb9a04cc17d2f69227483ca992', NULL),
('File Open/Read/Close in PHP', 'March 23, 2018 02:20:11 pm', 'https://www.w3schools.com/php/php_file_open.asp', '483ca99250ebfccb9a04cc17d2f69227', 2, '0', 'Opening, Reading and Closing file in PHP', NULL),
('PHP', 'March 23, 2018 04:30:11 pm', 'https://www.w3schools.com/php/php_file_open.asp', '48e35c19330d68caf4e703a0f427b4d2', 3, '0', 'PHP HAHAHHA', NULL),
('Link Meaning', 'March 24, 2018 01:15:11 am', 'https://dictionary.cambridge.org/us/dictionary/english/link', '483ca99250ebfccb9a04cc17d2f69227', 4, '0', 'Study the definition of link', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `exam_session_id` int(11) DEFAULT NULL,
  `question_content` varchar(100) DEFAULT NULL,
  `choice1` varchar(100) DEFAULT NULL,
  `choice2` varchar(100) DEFAULT NULL,
  `choice3` varchar(100) DEFAULT NULL,
  `choice4` varchar(100) DEFAULT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`exam_session_id`, `question_content`, `choice1`, `choice2`, `choice3`, `choice4`, `question_id`) VALUES
(1, 'Who is my idol?', 'Lebron James', 'onKobe Bryant', 'Dirk Nowitzki', 'Lonzo Ball', 1),
(1, 'What is my favorite pinoy dish?', 'Sinigang', 'Nilaga', 'onAdobo', 'Kare-kare', 2),
(1, 'How many dogs I have?', 'on10', '2', '5', '7', 3),
(1, '1+1=?', '1', '3', '4', 'on2', 4),
(1, '5*5?', 'on25', '10', '2', '1', 5),
(1, '6/3=?', '3', 'on2', '1', '4', 6),
(1, '100-25=?', '5', '10', 'on75', '0', 7),
(1, 'Sino idol kong team sa PBA?', 'Magnolia', 'San Miguel', 'Talk n\' Text', 'onBarangay Ginebra San Miguel', 8),
(1, 'True or False?', 'onFalse', 'True', 'Ewan', 'Balakadyan', 9),
(1, 'Ano?', 'Ewan', 'Malay ko sayo', 'onEh?', 'WOW!', 14),
(3, '1+1?', 'on2', '4', '5', '6', 15),
(3, '2+2?', '5', 'on4', '6', '3', 16),
(3, '10-5?', '10', '6', 'on5', '8', 17),
(3, '20/5?', '3', '5', '6', 'on4', 18),
(3, '100*4?', '200', '450', '689', 'on400', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `subjectname` varchar(50) NOT NULL,
  `accesscode` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `archivestatus` varchar(1) NOT NULL,
  `subjectid` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `datetimestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`subjectname`, `accesscode`, `datetime`, `archivestatus`, `subjectid`, `userid`, `datetimestamp`) VALUES
('MAPEH', '2018324MAP109am00', 'March 24, 2018 01:09:00 am', '1', '1f32277dbc463a0523456eceaf366526', 2, NULL),
('Science', '2018322Sci341pm48', 'March 26, 2018 01:09:00 am', '0', '483ca99250ebfccb9a04cc17d2f69227', 2, NULL),
('TLE', '2018322TLE306pm14', '2018/3/22 3:06 pm', '0', '48e35c19330d68caf4e703a0f427b4d2', 2, NULL),
('Social Science', '2018322Soc325pm31', 'October 24, 2018 01:09:00 am', '0', '58740e904ee5b3c0ad6220f814021b03', 2, NULL),
('Filipino', '2018322Fil342pm59', '2018/3/22 3:42 pm', '0', '812d1cfa231a674f10afa287def891a7', 2, NULL),
('Social Science', '2018315Soc323pm38', '2018/3/15 3:23 pm', '0', '8f4081b1c0213275a46bc99e584ebaf0', 0, NULL),
('Economics', '2018324Eco138am58', 'March 24, 2018 01:38:58 am', '1', 'a1e61e817a1caad91dde51d4554e0fd2', 2, '2018-03-24 01:38:58'),
('Advanced Programming', '2018315Adv316pm', '2018/3/15 3:16 pm', '0', 'c4ca4238a0b923820dcc509a6f75849b', 0, NULL),
('Multimedia', '2018315Mul319pm', '2018/3/15 3:19 pm', '0', 'c81e728d9d4c2f636f067f89cc14862c', 0, NULL),
('Social Studies', '2018315Soc323pm59', '2018/3/15 3:23 pm', '0', 'e729e72ffb932049b3ce6355ff802f88', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_updates`
--

CREATE TABLE `tbl_updates` (
  `update_id` int(11) NOT NULL,
  `subjectid` varchar(50) DEFAULT NULL,
  `datestamp` varchar(50) DEFAULT NULL,
  `content` varchar(5000) DEFAULT NULL,
  `datetimestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_updates`
--

INSERT INTO `tbl_updates` (`update_id`, `subjectid`, `datestamp`, `content`, `datetimestamp`) VALUES
(1, '483ca99250ebfccb9a04cc17d2f69227', 'March 24, 2018 12:22:20 am', '', NULL),
(2, '483ca99250ebfccb9a04cc17d2f69227', 'March 24, 2018 12:22:24 am', '', NULL),
(3, '483ca99250ebfccb9a04cc17d2f69227', 'March 24, 2018 12:23:19 am', 'Exam tomorrow!', NULL),
(4, '483ca99250ebfccb9a04cc17d2f69227', 'March 24, 2018 12:25:03 am', 'Perfect', NULL),
(5, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 09:22:16 am', 'Exam heyheyheyhey', NULL),
(6, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 09:24:16 am', 'Exam again!', '2018-04-03 17:24:16'),
(7, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 10:43:13 am', 'Bago na to!', '2018-04-03 18:43:13'),
(8, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 04:41:20 pm', 'Grades have been posted in SIS.  \r\n\r\nFor everybody\'s information, the following were done to pull up the grades\r\n\r\n1.   Total Finals denominator is adjusted to 75 instead of 85 points meaning if you got  38,you get  51% instead of 45% equivalent grade\r\n\r\n2.   Project has been given the highest weight in grade computation and all groups got passing marks for their respective projects, the lowest grade being 2.25. \r\n\r\n3.  I have added all bonus points earned during the sem to any of your quizzes.\r', '2018-04-04 00:41:20'),
(9, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 04:59:10 pm', 'Grades have been posted in SIS.  \r\n\r\nFor everybody\'s information, the following were done to pull up the grades\r\n\r\n1.   Total Finals denominator is adjusted to 75 instead of 85 points meaning if you got  38,you get  51% instead of 45% equivalent grade\r\n\r\n2.   Project has been given the highest weight in grade computation and all groups got passing marks for their respective projects, the lowest grade being 2.25. \r\n\r\n3.  I have added all bonus points earned during the sem to any of your quizzes.\r', '2018-04-04 00:59:10'),
(10, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 05:01:08 pm', 'Grades have been posted in SIS.  \r\n\r\nFor everybody\'s information, the following were done to pull up the grades\r\n\r\n1.   Total Finals denominator is adjusted to 75 instead of 85 points meaning if you got  38,you get  51% instead of 45% equivalent grade\r\n\r\n2.   Project has been given the highest weight in grade computation and all groups got passing marks for their respective projects, the lowest grade being 2.25. \r\n\r\n3.  I have added all bonus points earned during the sem to any of your quizzes.\r\n\r\nPassing grade has also been lowered to 45% (which is way too low).\r\n\r\nAfter i have factored in all of these inputs, whatever grades i have computed becomes final.  \r\n\r\nIf you have any questions, message me here in schoology.  I will finalize the grades within 1 to 2 weeks.\r\n\r\nThanks.', '2018-04-04 01:01:08'),
(11, '48e35c19330d68caf4e703a0f427b4d2', 'April 04, 2018 05:10:27 pm', 'EYYYY!!', '2018-04-04 01:10:27'),
(12, '812d1cfa231a674f10afa287def891a7', 'April 04, 2018 05:27:13 pm', 'Sana gumana ulit', '2018-04-04 01:27:13'),
(13, '812d1cfa231a674f10afa287def891a7', 'April 04, 2018 05:30:18 pm', 'GAGANA KA ULIT!', '2018-04-04 01:30:18'),
(14, '483ca99250ebfccb9a04cc17d2f69227', 'April 04, 2018 05:41:12 pm', 'GAGANA ', '2018-04-04 01:41:12'),
(15, '812d1cfa231a674f10afa287def891a7', 'April 05, 2018 08:42:42 am', 'Dillinger', '2018-04-04 16:42:42'),
(16, '483ca99250ebfccb9a04cc17d2f69227', 'April 05, 2018 09:47:46 am', 'Brownlee', '2018-04-04 17:47:46'),
(17, '48e35c19330d68caf4e703a0f427b4d2', 'April 05, 2018 09:48:37 am', 'You are mine', '2018-04-04 17:48:37'),
(18, '483ca99250ebfccb9a04cc17d2f69227', 'April 05, 2018 10:29:57 am', 'dhdfh', '2018-04-04 18:29:57'),
(19, '483ca99250ebfccb9a04cc17d2f69227', 'April 05, 2018 05:32:06 pm', 'Grades have been posted in SIS.  \r\n\r\nFor everybody\'s information, the following were done to pull up the grades\r\n\r\n1.   Total Finals denominator is adjusted to 75 instead of 85 points meaning if you got  38,you get  51% instead of 45% equivalent grade\r\n\r\n2.   Project has been given the highest weight in grade computation and all groups got passing marks for their respective projects, the lowest grade being 2.25. \r\n\r\n3.  I have added all bonus points earned during the sem to any of your quizzes.\r\n\r\nPassing grade has also been lowered to 45% (which is way too low).\r\n\r\nAfter i have factored in all of these inputs, whatever grades i have computed becomes final.  \r\n\r\nIf you have any questions, message me here in schoology.  I will finalize the grades within 1 to 2 weeks.\r\n\r\nThanks.', '2018-04-05 01:32:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `tbl_assignment_record`
--
ALTER TABLE `tbl_assignment_record`
  ADD PRIMARY KEY (`assignment_record_id`);

--
-- Indexes for table `tbl_enrollment`
--
ALTER TABLE `tbl_enrollment`
  ADD PRIMARY KEY (`enrollment_id`);

--
-- Indexes for table `tbl_exam_session`
--
ALTER TABLE `tbl_exam_session`
  ADD PRIMARY KEY (`exam_session_id`);

--
-- Indexes for table `tbl_lesson_file`
--
ALTER TABLE `tbl_lesson_file`
  ADD PRIMARY KEY (`lessonid_file`);

--
-- Indexes for table `tbl_lesson_url`
--
ALTER TABLE `tbl_lesson_url`
  ADD PRIMARY KEY (`lessonid_url`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`subjectid`);

--
-- Indexes for table `tbl_updates`
--
ALTER TABLE `tbl_updates`
  ADD PRIMARY KEY (`update_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_assignment_record`
--
ALTER TABLE `tbl_assignment_record`
  MODIFY `assignment_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_enrollment`
--
ALTER TABLE `tbl_enrollment`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_lesson_file`
--
ALTER TABLE `tbl_lesson_file`
  MODIFY `lessonid_file` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_lesson_url`
--
ALTER TABLE `tbl_lesson_url`
  MODIFY `lessonid_url` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_updates`
--
ALTER TABLE `tbl_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
