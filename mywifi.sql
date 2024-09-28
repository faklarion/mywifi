-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 28, 2024 at 05:53 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mywifi`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `sub_name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `picture` text NOT NULL,
  `logo` text NOT NULL,
  `whatsapp` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `instagram` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `owner` varchar(128) NOT NULL,
  `video` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `sub_name`, `description`, `picture`, `logo`, `whatsapp`, `facebook`, `twitter`, `instagram`, `phone`, `email`, `owner`, `video`, `address`) VALUES
(1, 'Iconnet', 'Computer, Network Engineering and Web Developer', '<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p>Demikian pula, tidak adakah orang yang mencintai atau mengejar atau ingin mengalami penderitaan, bukan semata-mata karena penderitaan itu sendiri, tetapi karena sesekali terjadi keadaan di mana susah-payah dan penderitaan dapat memberikan kepadanya kesenangan yang besar. Sebagai contoh sederhana, siapakah di antara kita yang pernah melakukan pekerjaan fisik yang berat, selain untuk memperoleh manfaat daripadanya? Tetapi siapakah yang berhak untuk mencari kesalahan pada diri orang yang memilih untuk menikmati kesenangan yang tidak menimbulkan akibat-akibat yang mengganggu, atau orang yang menghindari penderitaan yang tidak menghasilkan kesenangan?</p>\r\n\r\n<p><!--?= $company[\'company_name\'] ?--><!--?=$company[\'company_name\']?\r\n--></p>\r\n', 'picture-191121-62a0af9970.jpg', 'logoicon.png', '0808878776767', 'ade', 'luigifauzi', 'asep', '6282130415558', 'admin@gmail.com', '-', 'https://www.youtube.com/watch?v=SiPuvEFaC3g', '-');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `no_services` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `no_wa` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `no_ktp` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `no_services`, `email`, `address`, `no_wa`, `no_ktp`, `created`) VALUES
(4, 'Eka Erlina Andayani', '230806132134', 'eka@gmail.com', ' Jl Mentaos Raya', '08535003142152', '71837676471442532', 1691320933),
(5, 'Muhammad Dony Rifani', '230806132222', 'dony@gmail.com', 'Jl Murung Raya ', '083142141231', '0391048148210432', 1691320965),
(6, 'Muhammad Rahmatullah', '230812031355', 'rahmat@gmail.com', ' asad', '0853547183', '654712819378491', 1691802852),
(7, 'Suher', '240928024259', 'suher@gmail.com', 'Bjb tungkaran ', '082183291920', '637129219238', 1727491407);

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE `expenditure` (
  `expenditure_id` int NOT NULL,
  `date_payment` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` text COLLATE utf8mb4_general_ci NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int NOT NULL,
  `date_payment` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` text COLLATE utf8mb4_general_ci NOT NULL,
  `created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `date_payment`, `nominal`, `remark`, `created`) VALUES
(5, '2023-03-01', '296650', 'Pembayaran iuran no layanan 230806132222 a/n Muhammad Dony Rifani Periode Februari 2023', 1691324311),
(6, '2023-08-12', '707350', 'Pembayaran iuran no layanan 230812031355 a/n Muhammad Rahmatullah Periode Juli 2023', 1691802999);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int NOT NULL,
  `invoice` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `month` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `year` int NOT NULL,
  `no_services` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `created` int NOT NULL,
  `date_payment` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice`, `month`, `year`, `no_services`, `status`, `created`, `date_payment`) VALUES
(9, '230806001', '01', 2023, '230806132134', 'BELUM BAYAR', 1691321065, NULL),
(10, '230806002', '02', 2023, '230806132222', 'SUDAH BAYAR', 1691321073, 1691324311),
(11, '230812003', '07', 2023, '230812031355', 'SUDAH BAYAR', 1691802957, 1691802999);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `detail_id` int NOT NULL,
  `invoice_id` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `disc` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` text COLLATE utf8mb4_general_ci NOT NULL,
  `total` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `item_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`detail_id`, `invoice_id`, `price`, `qty`, `disc`, `remark`, `total`, `item_id`, `category_id`) VALUES
(9, '230806001', '216730', '1', '0', '', '216730', 3, 3),
(10, '230806002', '296650', '1', '0', '', '296650', 5, 3),
(11, '230812003', '707350', '1', '0', '', '707350', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `package_category`
--

CREATE TABLE `package_category` (
  `p_category_id` int NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` int NOT NULL,
  `date_updated` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_category`
--

INSERT INTO `package_category` (`p_category_id`, `name`, `description`, `date_created`, `date_updated`) VALUES
(3, 'Internet Broadband Retail', 'Internet Broadband untuk rumahan', 1691320149, 1691320245),
(4, 'Internet Broadband Bisnis', ' Ineternet Broadband untuk keperluan bisnis', 1691320278, 0);

-- --------------------------------------------------------

--
-- Table structure for table `package_item`
--

CREATE TABLE `package_item` (
  `p_item_id` int NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `picture` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `date_created` int NOT NULL,
  `date_update` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_item`
--

INSERT INTO `package_item` (`p_item_id`, `name`, `price`, `picture`, `description`, `category_id`, `date_created`, `date_update`) VALUES
(3, 'ICONNET 10', '216730', '', 'Internet Broadband Up To 10 Mbps', 3, 1691320626, 0),
(4, 'ICONNET 20', '280000', '', 'Internet Broadband Up To 20 Mbps', 3, 1691320616, 0),
(5, 'ICONNET 35', '296650', '', ' Internet Broadband Up To 35 Mbps', 3, 1691320669, 0),
(6, 'ICONNET 50', '440950', '', ' Internet Broadband Up To 50 Mbps', 3, 1691320708, 0),
(7, 'ICONNET 100', '707350', '', ' Internet Broadband Up To 100 Mbps', 3, 1691320733, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `pengaduan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `keluhan` text NOT NULL,
  `tanggal_pengaduan` datetime NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`pengaduan_id`, `user_id`, `keluhan`, `tanggal_pengaduan`, `status`) VALUES
(3, 10, 'Tidak bisa konek', '2024-09-28 13:24:59', 2),
(4, 11, 'Pagat kabel', '2024-09-28 13:51:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `services_id` int NOT NULL,
  `item_id` int NOT NULL,
  `category_id` int NOT NULL,
  `no_services` varchar(125) COLLATE utf8mb4_general_ci NOT NULL,
  `qty` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `disc` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `remark` text COLLATE utf8mb4_general_ci NOT NULL,
  `services_create` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_id`, `item_id`, `category_id`, `no_services`, `qty`, `price`, `disc`, `total`, `remark`, `services_create`) VALUES
(5, 3, 3, '230806132134', '1', '216730', '0', '216730', '', 1691321020),
(6, 5, 3, '230806132222', '1', '296650', '0', '296650', '', 1691321040),
(7, 7, 3, '230812031355', '1', '707350', '0', '707350', '', 1691802912),
(8, 4, 3, '240928024259', '1', '280000', '0', '280000', '', 1727493436);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(128) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `image` varchar(225) NOT NULL,
  `role_id` text NOT NULL,
  `is_active` int NOT NULL,
  `date_created` int NOT NULL,
  `gender` varchar(10) NOT NULL,
  `customer_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `phone`, `address`, `image`, `role_id`, `is_active`, `date_created`, `gender`, `customer_id`) VALUES
(1, 'ginginabdulgoni@gmail.com', '$2y$10$9a7b78YWmpUO1yS3Q2CeMOuWvemjp4Q13q52ykg5alI/f9NrICqB.', 'Gingin Abdul Goni', '082337481227', 'Kp. Ciparay', 'default1.jpg', '1', 1, 1565599788, 'Male', NULL),
(7, '11duabelasproject@gmail.com', '$2y$10$9a7b78YWmpUO1yS3Q2CeMOuWvemjp4Q13q52ykg5alI/f9NrICqB.', 'Rosita Wulandari', '085283935826', 'Perum Baru Paros, Tarogong Kaler - Garut', 'default.jpg', '1', 1, 1574219676, 'Male', NULL),
(8, 'faisal@gmail.com', '$2y$10$QaXllbTFMIatgTTDXnaycONUkbvy6PKue4N/6idh9e0Nr8dVLSIRW', 'Faisal', '08821321', 'Mangga', 'image_750x_63bc1e0a6531d.jpg', '1', 1, 1574219676, 'Male', NULL),
(9, 'admin@gmail.com', '$2y$10$4RLCItJ5EOr05NC3rPskjej0q3HmFdPrBxcUqFjscDM3TD3y14XyW', 'Admin', '082192132912', 'Jl Karang Anyar 1 GG Arrozak 2', 'logo_rinaya_crop.JPG', '1', 1, 1574219676, 'Male', NULL),
(10, 'suher@gmail.com', '$2y$10$6.EsimzGRu63HbweFlEmveAs9WlDU8/ovCpphh/u0F.upgOg5F1Mi', 'Suher', '082183291920', ' Jl Mentaos Raya', '', '2', 1, 0, 'Male', 7),
(11, 'eka@gmail.com', '$2y$10$B.ofNRBB5qBcqreibXwRn.ICmYQZLBqM8PLE82xmPbYu3iuDiGcLa', 'Eka', '08535003142152', 'Bjb tungkaran ', '', '2', 1, 0, 'Male', 4),
(12, 'dony@gmail.com', '$2y$10$uoRmJwL8S9M0VTvMSh69E.TBKyHXfS7cVjhBNd6ga7.PszXb2Opj6', 'Muhammad Dony Rifani', '083142141231', 'Jl Murung Raya ', '', '2', 1, 0, 'Male', 5),
(13, 'rahmat@gmail.com', '$2y$10$.jBrJkCGFpQk6e4GlVW1ke37Mt4/omD9cJRgMgDBLsMzqAnSmRB06', 'Muhammad Rahmatullah', '0853547183', ' asad', '', '2', 1, 0, 'Male', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(1, 'ginginabdulgoni@gmail.com', 'GjZqpcy8yr8Hdkquzl32bmSMLN8GKoEtKGAlI2fvngQ=', 1570072906),
(3, 'gintha45@gmail.com', 'oCCP4stUvFl4DIp1Lu65jt7mb2d6QSpuCl7zZC/LF7k=', 1570168320),
(4, 'lugifauzi@gmail.com', 'bRnILkp6INc5y7DzecGl0ZTcMS8AlhNJuyKctRf+IDU=', 1573961329),
(5, 'ginginabdulgoni@gmail.com', 'FUzKQm+L8RfYGRnAChlCALfPWcMUV1GmOHvT5MkQ0+I=', 1587090654),
(6, 'ginginabdulgoni@gmail.com', '1zFT9QCj4DRfAEJJe2CYzx1lukaDeA033RKGcKfyjWE=', 1587090751),
(7, 'ginginabdulgoni@gmail.com', 'ZoxgfYKiuDI88xNLIfYALjua/PAuZgJFX2LLrpilDeY=', 1587090826),
(8, 'ginginabdulgoni@gmail.com', 'Yss8Va6tbD5KggdGrgBbTmrLq3mfQjs1NkJXdvHTNdw=', 1587090982),
(9, 'ginginabdulgoni@gmail.com', 'wuhos5GVdbM3nGDlwrAgf2Vk39wc+yrOLr374a5xMlA=', 1587091009),
(10, 'ginginabdulgoni@gmail.com', 'LirJB/wK8hBjc/WKXGT+CSMxX/HZOsTHHeP7riT8/VQ=', 1587091091),
(11, 'ginginabdulgoni@gmail.com', 'T9TUDbKNl7IXWWkk6x1OP5BG/3igJeGZgc6DSCFC1aY=', 1587221474),
(12, 'ginginabdulgoni@gmail.com', 'kXN4Sc/jMpmL0U5ogANNTXyUM/ssg4UIubxydgNhy0w=', 1587221529),
(13, 'ginginabdulgoni@gmail.com', 'e8baN8qvyzwEFspz21UEGAj3CWICxRi3xG9nNv0phe0=', 1587517654);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `expenditure`
--
ALTER TABLE `expenditure`
  ADD PRIMARY KEY (`expenditure_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice` (`invoice`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `package_category`
--
ALTER TABLE `package_category`
  ADD PRIMARY KEY (`p_category_id`);

--
-- Indexes for table `package_item`
--
ALTER TABLE `package_item`
  ADD PRIMARY KEY (`p_item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`pengaduan_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`services_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenditure`
--
ALTER TABLE `expenditure`
  MODIFY `expenditure_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `package_category`
--
ALTER TABLE `package_category`
  MODIFY `p_category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `package_item`
--
ALTER TABLE `package_item`
  MODIFY `p_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `pengaduan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `services_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `invoice_detail_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `package_category` (`p_category_id`),
  ADD CONSTRAINT `invoice_detail_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `package_item` (`p_item_id`);

--
-- Constraints for table `package_item`
--
ALTER TABLE `package_item`
  ADD CONSTRAINT `package_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `package_category` (`p_category_id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `package_item` (`p_item_id`),
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `package_category` (`p_category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
