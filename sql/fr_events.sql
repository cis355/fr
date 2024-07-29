-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2024 at 04:55 AM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cis355_2017`
--

-- --------------------------------------------------------

--
-- Table structure for table `fr_events`
--

CREATE TABLE `fr_events` (
  `id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_location` varchar(50) NOT NULL,
  `event_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fr_events`
--

INSERT INTO `fr_events` (`id`, `event_date`, `event_time`, `event_location`, `event_description`) VALUES
(17, '2017-04-12', '16:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(18, '2017-04-13', '08:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(19, '2017-04-13', '12:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(20, '2017-04-13', '16:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(21, '2017-04-14', '08:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(22, '2017-04-14', '12:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitatity Volunteer'),
(23, '2017-04-14', '16:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(24, '2017-04-15', '18:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Volunteer for Clean Up'),
(25, '2017-04-15', '08:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(26, '2017-04-15', '12:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Hospitality Volunteer'),
(28, '2017-04-14', '08:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Judge (Until 5:00 pm)'),
(29, '2017-04-15', '08:00:00', 'Ryder-South Recreation Entrance', 'FIRST Robotics Judge (Until 5:00 pm)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fr_events`
--
ALTER TABLE `fr_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fr_events`
--
ALTER TABLE `fr_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
