-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2019 at 01:58 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `bookId` int(11) NOT NULL,
  `bookNo` varchar(100) NOT NULL,
  `guestName` varchar(100) NOT NULL,
  `guestContact` varchar(100) NOT NULL,
  `guestEmail` varchar(100) NOT NULL,
  `checkIn` date NOT NULL,
  `checkOut` date NOT NULL,
  `roomId` int(10) NOT NULL,
  `roomNo` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `active` int(11) NOT NULL,
  `customerIP` varchar(100) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`bookId`, `bookNo`, `guestName`, `guestContact`, `guestEmail`, `checkIn`, `checkOut`, `roomId`, `roomNo`, `status`, `active`, `customerIP`, `dateAdded`) VALUES
(1, '8cbc48', 'Domincik', '09957880045', 'dominicksanchez30@gmail.com', '2019-05-30', '2019-05-31', 2, 1, 2, 1, '::1', '2019-05-30 11:55:21'),
(2, '03bab3', 'Domincik', '09957880045', 'dominicksanchez30@gmail.com', '2019-05-30', '2019-05-31', 1, 1, 2, 1, '::1', '2019-05-30 11:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `contactId` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `message` longtext NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `orderId` int(11) NOT NULL,
  `bookNo` varchar(200) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`orderId`, `bookNo`, `productId`, `quantity`, `status`, `dateAdded`) VALUES
(1, '385b88', 4, 10, 3, '2019-05-06 07:13:46'),
(2, '385b88', 4, 10, 2, '2019-05-07 11:32:31'),
(3, '385b88', 3, 5, 1, '2019-05-07 12:01:09'),
(4, '385b88', 4, 10, 1, '2019-05-07 12:05:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `productId` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` int(11) NOT NULL,
  `visible` int(1) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`productId`, `title`, `description`, `price`, `status`, `visible`, `dateAdded`) VALUES
(1, '1pc Fried Chicken', 'This is sample description', '80.00', 1, 1, '2019-05-01 06:41:23'),
(2, 'Rice', 'This is sample description 123', '30.00', 1, 1, '2019-05-01 07:02:44'),
(3, 'Coca Cola', 'This is sample description', '70.00', 2, 1, '2019-05-01 07:03:08'),
(4, 'Bottled water', 'This is sample description', '40.00', 1, 1, '2019-05-01 07:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `roomId` int(11) NOT NULL,
  `img` longtext NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` int(200) NOT NULL,
  `roomCount` int(10) NOT NULL,
  `guestCount` int(10) NOT NULL,
  `dateAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room`
--

INSERT INTO `tbl_room` (`roomId`, `img`, `name`, `type`, `description`, `price`, `roomCount`, `guestCount`, `dateAdded`, `active`) VALUES
(1, 'a:1:{i:0;s:13:\"service03.JPG\";}', 'BAHAY KUBO', '', 'A two-storey single detached unit inspired by and named after the homey Filipino native dwelling place. The ground level has spacious open-air living and dining area. Bedroom is on the second level with 1 King size bed and balcony facing the surf. Toilet & Bath are Located at the Ground Floor Area.', 8000, 5, 8, '2019-05-02 12:33:00', 1),
(2, 'a:1:{i:0;s:13:\"service01.jpg\";}', 'CASITAS', '', 'A two bedroom detached units, which can accommodate up to seven people with living and out side dining area. It has an all glass wall with sliding doors, giving you a view of the South... more details\n\nAll amenities\nAir conditioningBathroom with showerCeiling fanCoffee/tea making facilitiesLinen providedMini barRefrigeratorShowerTV – cable/satellite\nBed size: 2 single beds, 1 queen bed', 11000, 5, 6, '2019-05-02 12:34:49', 1),
(3, 'a:3:{i:0;s:13:\"service05.jpg\";i:1;s:13:\"service06.jpg\";i:2;s:13:\"service07.jpg\";}', 'MANSION VILLA', '', 'Spacious two-storey buiding done in the Mediterranean style. Each unit has two twin beds with individual verandas.', 6000, 5, 6, '2019-04-21 12:35:52', 1),
(4, 'a:3:{i:0;s:10:\"room01.jpg\";i:1;s:10:\"room02.jpg\";i:2;s:10:\"room03.jpg\";}', 'SITIO AMORE', '', 'Sitio Amore with a spacious 2 floor suite inspired with contemporary design . All unit are facing Infinity pool and with seaview.', 15000, 5, 8, '2019-04-21 12:37:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userId` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pass` varchar(100) CHARACTER SET macroman COLLATE macroman_bin NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userId`, `email`, `username`, `pass`, `dateAdded`) VALUES
(1, 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2019-04-19 03:22:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`bookId`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`contactId`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `tbl_room`
--
ALTER TABLE `tbl_room`
  ADD PRIMARY KEY (`roomId`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `contactId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_room`
--
ALTER TABLE `tbl_room`
  MODIFY `roomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
