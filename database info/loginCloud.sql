-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 29, 2019 at 07:23 PM
-- Server version: 8.0.18
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginCloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `pwdReset`
--

CREATE TABLE `pwdReset` (
  `pwdResetEmail` varchar(255) NOT NULL,
  `pwdResetSelector` varchar(255) NOT NULL,
  `pwdResetToken` varchar(255) NOT NULL,
  `pwdResetExpires` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pwdReset`
--

INSERT INTO `pwdReset` (`pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
('aplazidis@gmail.com', '6bce7b12b1b98975', '$2y$10$yZxzsaUMtXPU9TWWTXHhEuIwx033sxVdXvqJq7nUghMnJXfZu0hJG', '1575056938');

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `FATHERNAME` varchar(255) NOT NULL,
  `BIRTHDAY_DATE` date NOT NULL,
  `GRADE` float NOT NULL,
  `MOBILE_NUMBER` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`ID`, `FIRSTNAME`, `LASTNAME`, `FATHERNAME`, `BIRTHDAY_DATE`, `GRADE`, `MOBILE_NUMBER`) VALUES
(1, 'Apol', 'Laz', 'Christ', '2019-11-20', 10, '6999999999'),
(2, 'Chrsit', 'Laz', 'Apol', '2019-11-20', 8, '6999999991'),
(3, 'Eydokia', 'Nasiadou', 'Andreas', '2019-11-13', 7, '6999999992'),
(4, 'Iokasti', 'Nas', 'Christos', '2019-11-12', 4, '6999999990'),
(5, 'Iwanna', 'Sakav', 'Ilias', '2019-11-13', 6.5, '6999999993'),
(6, 'Maria', 'Swtir', 'Gian', '2019-11-13', 9, '6999999995'),
(7, 'test', 'test', 'test', '2019-11-13', 7.5, '6999999997'),
(8, 'Giorgos', 'Empr', 'Jord', '2019-11-07', 5, '6990000112'),
(9, 'Jordan', 'Pap', 'Nikos', '2019-11-20', 3, '6990000113'),
(10, 'Ice', 'Cub', 'Nix', '2019-11-19', 9.5, '6990000115'),
(11, 'Cristiano', 'Ronaldo', 'Roni', '2019-11-19', 2, '6909999911'),
(12, 'Eleni', 'Four', 'Foir', '2019-11-13', 5.5, '6999000888'),
(13, 'Ariadn', 'Gomz', 'JK', '2019-11-12', 6, '6909999922'),
(14, 'Roy', 'Jones', 'Jander', '2019-11-05', 7, '6999000744');

-- --------------------------------------------------------

--
-- Table structure for table `Teacher`
--

CREATE TABLE `Teacher` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `ADRESS` text NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `MOBILE_NUMBER` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Teacher`
--

INSERT INTO `Teacher` (`ID`, `USERNAME`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `ADRESS`, `PASSWORD`, `MOBILE_NUMBER`) VALUES
(1, 'alazidis', 'Apostolos', 'Lazidis', 'aplazidis@gmail.com', 'Agiou Kosma 113', '1234567890', '6909999990'),
(2, 'test', 'test', 'nefos', 'test@gmail.com', 'Agiou Kosma 11', 'qwerasdf', '6999000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Teacher`
--
ALTER TABLE `Teacher`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
