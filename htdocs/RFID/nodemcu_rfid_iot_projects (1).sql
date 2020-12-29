-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 05:41 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nodemcu_rfid_iot_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `email_admin` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email_admin`, `password`) VALUES
(1, 'Pitaloka Fortuna Dewi Setyorini', 'admin@gmail.com', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `data_warga`
--

CREATE TABLE `data_warga` (
  `id` int(10) NOT NULL,
  `no_rfid` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `rt` int(10) NOT NULL,
  `rw` int(10) NOT NULL,
  `dukuh` varchar(20) NOT NULL,
  `desa` varchar(30) NOT NULL,
  `saldo` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_warga`
--

INSERT INTO `data_warga` (`id`, `no_rfid`, `nama`, `rt`, `rw`, `dukuh`, `desa`, `saldo`, `tanggal_transaksi`) VALUES
(5, '0', 'pita', 12, 2, 'bangkle', 'klumutan', 200000, '2020-10-05 21:15:42'),
(7, '1', 'Hani', 14, 4, 'Lori', 'Klumutan', 200000, '2020-12-06 22:44:24'),
(8, '2', 'oo', 11, 23, 'Bruwok', 'klumutan', 0, '2020-10-05 22:57:07'),
(10, 'A5674', 'Pitaloka', 12, 32, 'nna', 'jkja', 200000, '2020-10-26 21:41:42'),
(11, '097876', 'Roman Jati', 4, 13, 'Sumber', 'Sumbersari', 200000, '2020-12-06 21:58:59'),
(12, '098768', 'Naira', 19, 5, 'Pranti', 'Klumutan', 200000, '2020-12-06 22:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_status` int(10) NOT NULL,
  `no_rfid` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `januari` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `no_rfid`, `nama`, `januari`) VALUES
(1, '0', 'pita', 'Belum Pencairan'),
(3, '1', 'Hani', 'Belum Pencairan'),
(4, '2', 'oo', 'Sudah Pencairan'),
(10, 'A5674', 'Pitaloka', 'Belum Pencairan'),
(11, '097876', 'Roman Jati', 'Belum Pencairan'),
(12, '098768', 'Naira', 'Belum Pencairan');

-- --------------------------------------------------------

--
-- Table structure for table `table_the_iot_projects`
--

CREATE TABLE `table_the_iot_projects` (
  `name` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_the_iot_projects`
--

INSERT INTO `table_the_iot_projects` (`name`, `id`, `gender`, `email`, `mobile`) VALUES
('Alsan', '39EAB06D', 'Male', 'mydigitalnepal@gmail.com', '9800998787'),
('Thvhm,b', '81A3DC79', 'Female', 'jgkhkkmanjil@gmail.com', '45768767564'),
('The IoT Projects', '866080F8', 'Male', 'ask.theiotprojects@gmail.com', '9800988978');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `data_warga`
--
ALTER TABLE `data_warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_rfid` (`no_rfid`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `no_rfid` (`no_rfid`);

--
-- Indexes for table `table_the_iot_projects`
--
ALTER TABLE `table_the_iot_projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_warga`
--
ALTER TABLE `data_warga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_1` FOREIGN KEY (`no_rfid`) REFERENCES `data_warga` (`no_rfid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
