-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2020 at 04:28 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DoAnCuoiKi`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `full_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `token` text,
  `token_expire_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`email`, `user`, `full_name`, `date_of_birth`, `phone`, `password`, `role`, `token`, `token_expire_time`) VALUES
('khoile2239@gmail.com', 'khoil', 'Lê Công Minh Khôi', '2001-02-08', '0372300853', '$2y$10$juEcevEqBatH25UHDo2U4.rvfsQdFzKnoyXAkfKqdSbHm2xPqx3/O', 'admin', NULL, NULL),
('yennhu1110@gmail.com', 'kipinhu', 'Nguyễn Thị Yến Như', '2001-10-11', '0372300853', '$2y$10$CH1Qz0jSl9gzUXHg6zGpv.9OtJCqZTUDl0L5EkPDZvkx/YeXYkSsy', 'pending', NULL, NULL),
('khoilr730@gmail.com', 'khoi', 'Khôi Lê', '2001-08-28', '0372300853', '$2y$10$xk1j2SY9Uuu3jq8NUewpdO4on.5Eya9.V.oBKK9mPA6Ep9fTP511a', 'teacher', NULL, NULL),
('foo@gmail.com', 'foo', 'foo', '2001-08-20', '0372300853', '$2y$10$FhIcBXJhrgqeOkQqUADyEeMc..FwvWZrRBzvLcYFKsuEgLJNTEtBW', 'student', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_join` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`email`, `class_code`, `date_join`, `status`) VALUES
('khoilr730@gmail.com', 'FwDuIY', '2020-11-27 04:00:05', 'current'),
('yennhu1110@gmail.com', 'FwDuIY', '2020-11-27 04:04:08', 'current'),
('khoilr730@gmail.com', '5hT2BG', '2020-11-29 09:23:16', 'current'),
('yennhu1110@gmail.com', '5hT2BG', '2020-11-29 09:26:48', 'student-pending');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `class_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `teacher` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `course_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `room` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`class_code`, `teacher`, `class_name`, `course_name`, `class_image`, `room`) VALUES
('FwDuIY', 'khoile2239@gmail.com', 'ádsadvd', 'ád', './classroom/FwDuIY/FwDuIY.png', 'ádasa'),
('r0WgyL', 'khoile2239@gmail.com', 'dasd', 'sadsa', './classroom/r0WgyL/r0WgyL.png', 'das'),
('5hT2BG', 'khoile2239@gmail.com', 'foo', 'bar', './classroom/5hT2BG/5hT2BG.png', 'qiojgrdi');

-- --------------------------------------------------------

--
-- Table structure for table `classwork`
--

CREATE TABLE `classwork` (
  `class_code` text NOT NULL,
  `classwork_code` text NOT NULL,
  `title` text NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classwork`
--

INSERT INTO `classwork` (`class_code`, `classwork_code`, `title`, `description`, `file`) VALUES
('8EfsAi', '8EfsAi_vzIRQb', 'sádf', '', NULL),
('8EfsAi', '8EfsAi_0fRMyC', 'asdasdasd', '', NULL),
('MNqZ7s', 'MNqZ7s_aGOiCH', 'dsd', '', NULL),
('MNqZ7s', 'MNqZ7s_GFDIsB', 'asdsad', '', './classroom/MNqZ7s/519H0181_LeCongMinhKhoi_DSA_2020.zip'),
('0Uq8XO', '0Uq8XO_BhYvFd', 'adsa', 'asd', './classroom/0Uq8XO/Screenshot 2020-11-14 091031.png'),
('HhQuuz', 'HhQuuz_32PL8p', 'sdfsdf', '', './classroom/HhQuuz/samsung-galaxy-j3-2017-2-400x460-1.png'),
('yCuGRi', 'yCuGRi_qRC4q3', 'asdsa', '', './classroom/yCuGRi/iphone-7-plus-128gb-de-400x460.png'),
('TI5Wds', 'TI5Wds_pFdFKA', 'ádsa', '', './classroom/TI5Wds/samsung-galaxy-j7-plus-1-400x460.png'),
('fCDj3g', 'fCDj3g_W3JF4i', 'asdsa', '', './classroom/fCDj3g/mobile3.jpg'),
('OxmtKr', 'OxmtKr_8SIvrs', 'asdsa', '', './classroom/OxmtKr/mobile1.jpg'),
('arBvlI', 'arBvlI_0eX32y', 'asdsad', 'asdas', './classroom/arBvlI/mobile3.jpg'),
('twmZm3', 'twmZm3_i6KZsY', 'asddas', '', './classroom/twmZm3/mobile1.jpg'),
('Q5CwW4', 'Q5CwW4_ICpSpi', 'asdsad', '', NULL),
('RYYk1T', 'RYYk1T_TTJXTk', 'dfvdv', 'sfsdf', './classroom/RYYk1T/20201123_154456.jpg'),
('zxGyR5', 'zxGyR5_0Yqpeu', 'sfdsf', '', NULL),
('OBXAgE', 'OBXAgE_rJW8Gi', 'đasad', '', './classroom/OBXAgE/20201123_154456.jpg'),
('FwDuIY', 'FwDuIY_SUzVDv', 'khoicute', 'đâsdsfdsfds\r\nidgodfjg\r\náidjioasdj\r\nsdfjsd', NULL),
('FwDuIY', 'FwDuIY_m8YBaQ', 'Khô icute', 'Khoi cute\r\n', NULL),
('FwDuIY', 'FwDuIY_fdVho7', 'asdsad', '', NULL),
('5hT2BG', '5hT2BG_GF6Z53', 'ssdfsdf', 'ojdso', './classroom/5hT2BG/4.png'),
('5hT2BG', '5hT2BG_J7eTkA', 'sifjsdio', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_code` text NOT NULL,
  `classwork_code` text NOT NULL,
  `email` text NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cookie`
--

CREATE TABLE `cookie` (
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cookie`
--

INSERT INTO `cookie` (`email`, `token`) VALUES
('khoile2239@gmail.com', '37b8e3e59a523eecba9050ff4ebda232'),
('khoilr730@gmail.com', '7babadc489aaf31c94f3305e3ee883b6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
