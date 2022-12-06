-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2022 at 09:22 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_ID` int(10) NOT NULL,
  `client_ID` int(10) NOT NULL,
  `hospital_ID` int(10) NOT NULL,
  `user_ID` int(10) NOT NULL,
  `date_time` datetime NOT NULL,
  `donor_name` varchar(255) NOT NULL,
  `donor_email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_ID`, `client_ID`, `hospital_ID`, `user_ID`, `date_time`, `donor_name`, `donor_email`) VALUES
(1, 1, 1, 1, '2022-12-12 11:01:00', 'Chi Castro', 'chil@yahoo.ca'),
(2, 1, 1, 1, '2022-12-12 11:01:00', 'Chi Castro', 'chil@yahoo.ca'),
(3, 2, 8, 1, '2022-12-12 11:01:00', 'Mary Doe', 'marydoe@yahoo.ca'),
(4, 1, 1, 1, '2022-12-29 10:00:00', 'Chi Castro', 'chil@yahoo.ca'),
(5, 1, 1, 1, '2022-12-29 10:00:00', 'Chi Castro', 'chil@yahoo.ca'),
(6, 1, 2, 1, '2022-12-13 11:01:00', 'Chi Castro', 'chil@yahoo.ca'),
(7, 1, 2, 1, '2022-12-07 02:40:00', 'Chi Castro', 'chil@yahoo.ca');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_ID` int(10) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `license_num` varchar(100) NOT NULL,
  `license_start_date` date NOT NULL,
  `license_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_ID`, `client_name`, `api_key`, `license_num`, `license_start_date`, `license_end_date`) VALUES
(1, 'Blood Donation Company A', 'abcd123', '64char', '2022-11-09', '2023-12-31'),
(2, 'Blood Donation Company B', 'apikey123', '64char', '2022-11-08', '2023-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `hospital_id` int(10) NOT NULL,
  `hospital_name` varchar(300) NOT NULL,
  `hospital_street` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(30) NOT NULL,
  `postal_code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`hospital_id`, `hospital_name`, `hospital_street`, `city`, `province`, `postal_code`) VALUES
(1, 'St. Marys Hospital Center', '3830 Av. Lacombe', 'Montreal', 'QC', 'H3T 1M5'),
(2, 'Lachine Hospital (MUHC)', '650 16 Ave', 'Lachine', 'QC', 'H8S 3N5'),
(3, 'LaSalle Hospital', '8585 Terr. Champlain', 'Lasalle', 'QC', 'H8P 1C1'),
(4, 'Verdun Hospital', '4000 Bd LaSalle', 'Verdun', 'QC', 'H4G 2A3'),
(5, 'Sacré-Coeur de Montréal Hospital', '5400 Boul Gouin O', 'Montreal', 'QC', 'H4J 1C5'),
(6, 'Fleury Hospital', '2180 Rue Fleury E', 'Montreal', 'QC', 'H2B 1K3'),
(7, 'Montreal General Hospital (MUHC)', '1650 Cedar Ave', 'Montreal', 'QC', 'H3G 1A4'),
(8, 'Lakeshore General Hospital', '160 Stillview Ave', 'Pointe-Claire', 'QC', 'H9R 2Y2'),
(9, 'Jewish General Hospital', ' 3755 Chem. de la Côte-Sainte-Catherine', 'Montreal', 'QC', 'H3T 1E2'),
(10, 'Jean-Talon Hospital', '1385 Rue Jean-Talon E', 'Montreal', 'QC', 'H2E 1S6'),
(11, 'Maisonneuve-Rosemont Hospital', ' 5415 Assomption Blvd', 'Montreal', 'QC', 'H1T 2M4'),
(12, 'Notre-Dame Hospital', '1560 Sherbrooke St E', 'Montreal', 'QC', 'H2L 4M1'),
(13, 'Saint-Luc Hospital (CHUM)', '1051 Rue Sanguinet', 'Montreal', 'QC', 'H2X 3E4'),
(14, 'Santa Cabrini Hospital', '5655 Rue Saint-Zotique E', 'Montreal', 'QC', 'H1T 1P7'),
(15, 'Hôtel-Dieu (CHUM)', '109 Pine Ave W', 'Montreal', 'QC', 'H2W 1R5'),
(16, 'Montreal Heart Institute', '5000 Rue Bélanger', 'Montreal', 'QC', 'H1T 1C8'),
(17, 'Montreal Chest Institute (MUHC)', '1001 Decarie Blvd', 'Montreal', 'QC', 'H4A 3J1'),
(18, 'Montreal Neurological Hospital (MUHC)', '3801 Rue University', 'Montreal', 'QC', 'H3A 2B4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_ID`),
  ADD KEY `FK_client_ID` (`client_ID`),
  ADD KEY `FK_hospital_ID` (`hospital_ID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_ID`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hospital_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hospital_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `FK_client_ID` FOREIGN KEY (`client_ID`) REFERENCES `clients` (`client_ID`),
  ADD CONSTRAINT `FK_hospital_ID` FOREIGN KEY (`hospital_ID`) REFERENCES `hospitals` (`hospital_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
