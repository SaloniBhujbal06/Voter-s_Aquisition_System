-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2021 at 09:56 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prj_voter_aquisition_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `cid` int(9) NOT NULL,
  `cat_name` varchar(45) NOT NULL,
  `regdate` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`cid`, `cat_name`, `regdate`, `status`) VALUES
(1, 'Complaints', '2019-02-25', 1),
(2, 'Help', '2019-02-25', 1),
(3, 'Requirement', '2019-02-25', 1),
(4, 'Other', '2019-02-25', 0),
(5, 'Request', '2019-03-22', 1),
(6, 'Invitation', '2021-05-08', 1),
(7, 'Meeting', '2021-05-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `comid` int(9) NOT NULL,
  `comtitle` varchar(50) NOT NULL,
  `comdesc` varchar(250) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `exptime` varchar(30) NOT NULL,
  `reply` varchar(500) NOT NULL,
  `comdate` date NOT NULL,
  `city` varchar(100) NOT NULL,
  `caddress` varchar(500) NOT NULL,
  `imgpath` varchar(300) NOT NULL,
  `comstatus` varchar(50) NOT NULL,
  `cid` int(9) NOT NULL,
  `puid` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`comid`, `comtitle`, `comdesc`, `priority`, `exptime`, `reply`, `comdate`, `city`, `caddress`, `imgpath`, `comstatus`, `cid`, `puid`) VALUES
(1, 'sample', 'None', 'High', '2 Days', '', '2021-05-13', 'Manchar', 'Manchar 121', 'uploads/1_20210513083616.png', 'Pending', 1, 1),
(2, 'SSS', 'no', 'High', '2 Days', '', '2021-05-20', 'Manchar', 'sdfsdf', '#', 'Pending', 2, 1),
(3, 'Test', 'Sample', 'Low', 'f', '', '2021-05-20', 'Manchar', 'Manchar', 'uploads/1_20210520041856.jpg', 'Pending', 3, 1),
(4, 'Shop Opening', 'None', 'Medium', '2 Days', '', '2021-06-13', 'Narayangaon', 'Narayangaon Bus Stand', '#', 'Pending', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `pid` int(9) NOT NULL,
  `ptitle` varchar(30) NOT NULL,
  `pdesc` varchar(150) NOT NULL,
  `pimgpath` varchar(90) NOT NULL,
  `pdate` date NOT NULL,
  `pstatus` tinyint(1) NOT NULL,
  `uid` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`pid`, `ptitle`, `pdesc`, `pimgpath`, `pdate`, `pstatus`, `uid`) VALUES
(2, 'sample w', 'none', 'uploads/5_20210513083157.jpg', '2021-05-13', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `puser`
--

CREATE TABLE `puser` (
  `puid` int(9) NOT NULL,
  `puname` varchar(45) NOT NULL,
  `pupass` varchar(20) NOT NULL,
  `pumob` varchar(10) NOT NULL,
  `bdate` date NOT NULL,
  `buemail` varchar(50) NOT NULL,
  `address` varchar(90) NOT NULL,
  `regdate` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `puser`
--

INSERT INTO `puser` (`puid`, `puname`, `pupass`, `pumob`, `bdate`, `buemail`, `address`, `regdate`, `status`) VALUES
(1, 'Subhan', '123', '8888789402', '1990-05-30', 'zelosinfotech@gmail.com', 'Pasaydan Complex, Manchar', '2021-05-13', 1);

-- ------------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `did` int(9) NOT NULL,
  `msg` varchar(500) NOT NULL,
  `comid` int(9) NOT NULL,
  `uid` int(9) NOT NULL,
  `ddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(9) NOT NULL,
  `uname` varchar(45) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `uregdate` datetime NOT NULL,
  `utype` int(9) NOT NULL,
  `ustatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uname`, `pass`, `uregdate`, `utype`, `ustatus`) VALUES
(1, 'admin', 'admin', '2019-02-25 00:00:00', 1, 1),
(5, 'master-admin', 'admin', '2021-05-08 15:02:28', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`comid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `puid` (`puid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `puser`
--
ALTER TABLE `puser`
  ADD PRIMARY KEY (`puid`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`did`),
  ADD KEY `comid` (`comid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `cid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `comid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `pid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `puser`
--
ALTER TABLE `puser`
  MODIFY `puid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `did` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
