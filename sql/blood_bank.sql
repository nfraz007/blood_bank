-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2018 at 01:39 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `bb_blood`
--

CREATE TABLE `bb_blood` (
  `blood_id` int(11) NOT NULL,
  `blood` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='data of all available blood group';

--
-- Dumping data for table `bb_blood`
--

INSERT INTO `bb_blood` (`blood_id`, `blood`, `detail`, `status`) VALUES
(1, 'A+', '', 1),
(2, 'A-', '', 1),
(3, 'B+', '', 1),
(4, 'B-', '', 1),
(5, 'AB+', '', 1),
(6, 'AB-', '', 1),
(7, 'O+', '', 1),
(8, 'O-', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_hospital`
--

CREATE TABLE `bb_hospital` (
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='store the details of hospital data';

INSERT INTO `bb_hospital` (`hospital_id`, `hospital_name`, `username`, `password`, `mobile`, `datetime`, `status`) VALUES
(2, 'Admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 9748277144, '2018-08-15 14:09:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bb_request`
--

CREATE TABLE `bb_request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL COMMENT 'in ml',
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='request detail by user to the hospital';

-- --------------------------------------------------------

--
-- Table structure for table `bb_stock`
--

CREATE TABLE `bb_stock` (
  `stock_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='blood stock available in the hospital';

-- --------------------------------------------------------

--
-- Table structure for table `bb_user`
--

CREATE TABLE `bb_user` (
  `user_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='all data of reciever';

INSERT INTO `bb_user` (`user_id`, `blood_id`, `first_name`, `last_name`, `username`, `password`, `mobile`, `datetime`, `status`) VALUES
(3, 1, 'user', 'user', 'user', 'e10adc3949ba59abbe56e057f20f883e', 9748277144, '2018-08-15 14:09:32', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bb_blood`
--
ALTER TABLE `bb_blood`
  ADD PRIMARY KEY (`blood_id`);

--
-- Indexes for table `bb_hospital`
--
ALTER TABLE `bb_hospital`
  ADD PRIMARY KEY (`hospital_id`);

--
-- Indexes for table `bb_request`
--
ALTER TABLE `bb_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `bb_stock`
--
ALTER TABLE `bb_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `bb_user`
--
ALTER TABLE `bb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bb_blood`
--
ALTER TABLE `bb_blood`
  MODIFY `blood_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bb_hospital`
--
ALTER TABLE `bb_hospital`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bb_request`
--
ALTER TABLE `bb_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bb_stock`
--
ALTER TABLE `bb_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bb_user`
--
ALTER TABLE `bb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;