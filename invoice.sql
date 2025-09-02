-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 11:00 AM
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
-- Database: `invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Mahendra', 'Mandal Jodha', '8769664473', '2025-08-19 14:32:12', '2025-08-23 15:10:55'),
(2, 'Deepak', 'Amarawati', '9509033054', '2025-08-19 14:37:37', '2025-08-23 15:11:11'),
(3, 'Jitendra', 'Degana', '9587108436', '2025-08-19 14:37:59', '2025-08-23 10:26:29'),
(4, 'Jagrup', 'Jaipur', '7850984303', '2025-08-19 14:38:19', '2025-08-23 15:11:25'),
(5, 'Rahul', 'Jawla', '7073938656', '2025-08-19 14:39:03', '2025-08-23 15:11:16'),
(6, 'Rakesh Meghwal', 'Jhotwara', '6375664473', '2025-08-22 13:10:20', '2025-08-23 15:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `grand_total` decimal(12,2) DEFAULT 0.00,
  `previous_pending` decimal(10,2) DEFAULT NULL,
  `pending_amount` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('unpaid','paid') DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_id`, `invoice_no`, `invoice_date`, `due_date`, `subtotal`, `discount`, `grand_total`, `previous_pending`, `pending_amount`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(3, 3, 'INV0003', '2025-08-01', '2025-08-08', '500.00', '0.00', '500.00', '0.00', NULL, '', 'paid', '2025-08-22 08:45:25', '2025-08-23 04:59:14'),
(7, 4, 'INV0007', '2025-08-01', '2025-08-31', '75000.00', '0.00', '75000.00', '0.00', NULL, '', 'unpaid', '2025-08-22 12:46:51', '2025-09-01 08:34:24'),
(8, 4, 'INV0008', '2025-08-23', '2025-08-23', '150000.10', '0.00', '150000.10', '0.00', NULL, 'test', 'paid', '2025-08-23 05:12:12', '2025-09-02 08:55:01'),
(9, 12, 'INV0009', '2025-09-04', '2025-09-05', '1000.00', '0.00', '1000.00', '0.00', NULL, 'pooja', 'unpaid', '2025-09-01 07:36:57', '2025-09-01 07:36:57'),
(10, 18, 'INV0010', '2025-09-02', '2025-09-02', '200.00', '5.00', '195.00', '0.00', NULL, 'test', 'paid', '2025-09-02 06:55:28', '2025-09-02 07:00:19'),
(11, 18, 'INV0011', '2025-09-02', '2025-09-04', '600.00', '10.00', '789.00', '0.00', NULL, 'test', 'unpaid', '2025-09-02 06:58:40', '2025-09-02 08:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `total` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `description`, `quantity`, `unit_price`, `total`) VALUES
(5, 3, 'Test', 1, '500.00', '500.00'),
(11, 7, 'Zepto', 15, '5000.00', '75000.00'),
(12, 8, 'Mobile', 10, '10000.00', '100000.00'),
(13, 8, 'Mobile', 5, '10000.02', '50000.10'),
(14, 9, 'Test', 1, '1000.00', '1000.00'),
(15, 10, 'mouse', 2, '100.00', '200.00'),
(16, 11, 'keyboard', 3, '200.00', '600.00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `customer_id`, `amount`, `payment_date`) VALUES
(8, 7, 4, '10000.00', '2025-09-10'),
(9, 9, 12, '500.00', '2025-09-01'),
(10, 9, 12, '50.00', '2025-09-02'),
(11, 9, 12, '50.00', '2025-09-02'),
(12, 10, 18, '50.00', '2025-09-02'),
(13, 10, 18, '145.00', '2025-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `whatsapp_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `aadhar_no` varchar(20) DEFAULT NULL,
  `pan_card_no` varchar(20) DEFAULT NULL,
  `gst_no` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_holder` varchar(100) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `vendor_id`, `name`, `username`, `type`, `mobile_no`, `whatsapp_no`, `email`, `password`, `aadhar_no`, `pan_card_no`, `gst_no`, `address`, `pincode`, `bank_name`, `bank_account_holder`, `account_no`, `ifsc_code`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Super Admin', 'superadmin', 1, '9876543210', '9876543210', 'super@inv.com', 'super', NULL, NULL, NULL, 'Jaipur', '331003', NULL, NULL, NULL, NULL, '2025-09-01 10:02:30', '2025-09-02 11:18:12'),
(2, NULL, 'Jagrup Meghwal', 'jagutalniya', 2, '7850984303', NULL, 'jagu@inv.com', 'jagu', NULL, NULL, NULL, 'Jaipur', '302006', NULL, NULL, NULL, NULL, '2025-09-01 10:03:38', '2025-09-02 08:38:27'),
(3, 2, 'Mahendra', 'mahi', 3, '8769664473', '8769664473', 'mahi@inv.com', 'mahi', NULL, NULL, NULL, 'Mandal Jodha', '341503', NULL, NULL, NULL, NULL, '2025-09-01 10:05:20', '2025-09-02 10:47:34'),
(4, 5, 'Rahul Bhalan', 'rahul', 3, '9988776655', '9988776655', 'rahul@inv.com', 'rahul', NULL, NULL, NULL, 'Degana', '341503', NULL, NULL, NULL, NULL, '2025-09-01 06:54:10', '2025-09-02 10:47:41'),
(5, NULL, 'Deepak Maich', 'deepak', 2, '9509033054', '9509033054', 'maichdr@inv.com', 'deepak', NULL, NULL, NULL, 'Amrawati', '831004', NULL, NULL, NULL, NULL, '2025-09-01 07:23:16', '2025-09-02 10:47:27'),
(6, NULL, 'Ravi Kumar', 'ravi.k', 2, '9876543210', '9876543210', 'ravi@inv.com', 'pass123', '123412341234', 'ABCDE1234F', '27ABCDE1234F1Z5', 'Address 1', '110001', 'HDFC Bank', 'Ravi Kumar', '123456789012', 'HDFC0001234', '2025-09-01 12:52:16', '2025-09-02 10:45:51'),
(7, NULL, 'Sita Sharma', 'sita.s', 2, '9876543211', '9876543211', 'sita@inv.com', 'pass123', '123412341235', 'ABCDE1235F', '27ABCDE1235F1Z5', 'Address 2', '110002', 'ICICI Bank', 'Sita Sharma', '123456789013', 'ICIC0001235', '2025-09-01 12:52:16', '2025-09-02 10:45:56'),
(9, NULL, 'Neha Verma', 'neha.v', 2, '9876543213', '9876543213', 'neha@inv.com', 'pass123', '123412341237', 'ABCDE1237F', '27ABCDE1237F1Z5', 'Address 4', '110004', 'Axis Bank', 'Neha Verma', '123456789015', 'UTIB0001237', '2025-09-01 12:52:16', '2025-09-02 10:46:09'),
(10, NULL, 'Rajesh Gupta', 'rajesh.g', 2, '9876543214', '9876543214', 'rajesh@inv.com', 'pass123', '123412341238', 'ABCDE1238F', '27ABCDE1238F1Z5', 'Address 5', '110005', 'Kotak Bank', 'Rajesh Gupta', '123456789016', 'KKBK0001238', '2025-09-01 12:52:16', '2025-09-02 10:46:15'),
(11, 2, 'Vivek Kumar', 'vivek.k', 3, '9876543220', '9876543220', 'vivek@inv.com', 'pass123', '123412341239', 'ABCDE1239F', '27ABCDE1239F1Z5', 'Sikar', '110006', 'HDFC Bank', 'Vivek Kumar', '123456789017', 'HDFC0001239', '2025-09-01 12:52:16', '2025-09-02 11:01:34'),
(12, 2, 'Pooja Sharma', 'pooja.s', 3, '9876543221', '9876543221', 'pooja@inv.com', 'pass123', '123412341240', 'ABCDE1240F', '27ABCDE1240F1Z5', 'Nagaur', '110007', 'ICICI Bank', 'Pooja Sharma', '123456789018', 'ICIC0001240', '2025-09-01 12:52:16', '2025-09-02 11:01:25'),
(13, 5, 'Karan Singh', 'karan.s', 3, '9876543222', '9876543222', 'karan@inv.com', 'pass123', '123412341241', 'ABCDE1241F', '27ABCDE1241F1Z5', 'Ajmer', '110008', 'SBI Bank', 'Karan Singh', '123456789019', 'SBIN0001241', '2025-09-01 12:52:16', '2025-09-02 11:01:15'),
(14, 7, 'Anjali Verma', 'anjali.v', 3, '9876543223', '9876543223', 'anjali@inv.com', 'pass123', '123412341242', 'ABCDE1242F', '27ABCDE1242F1Z5', 'Jodhpur', '110009', 'Axis Bank', 'Anjali Verma', '123456789020', 'UTIB0001242', '2025-09-01 12:52:16', '2025-09-02 11:01:06'),
(15, 2, 'Manish Gupta', 'manish', 3, '9876543224', '9876543224', 'manish@inv.com', 'pass123', '123412341243', 'ABCDE1243F', '27ABCDE1243F1Z5', 'Jaipur', '110010', 'SBI Bank', 'Manish Gupta', '123456789021', 'SBIN0001242', '2025-09-01 12:52:16', '2025-09-02 11:00:55'),
(18, 2, 'Vikas Puri', 'goswami', 3, '6377887817', '6377887817', 'test@gmail.com', 'test@78', '123456789989', 'AAAAA1234A', '', 'jaipur\r\n', '', '', '', '', '', '2025-09-02 08:48:12', '2025-09-02 12:57:32');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_customer_balance`
-- (See below for the actual view)
--
CREATE TABLE `v_customer_balance` (
`customer_id` int(100)
,`name` varchar(255)
,`total_invoiced` decimal(34,2)
,`total_paid` decimal(32,2)
,`balance` decimal(35,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_customer_balance`
--
DROP TABLE IF EXISTS `v_customer_balance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_customer_balance`  AS  select `c`.`id` AS `customer_id`,`c`.`name` AS `name`,ifnull(sum(`i`.`grand_total`),0) AS `total_invoiced`,ifnull((select sum(`p`.`amount`) from `payments` `p` where `p`.`customer_id` = `c`.`id`),0) AS `total_paid`,ifnull(sum(`i`.`grand_total`),0) - ifnull((select sum(`p`.`amount`) from `payments` `p` where `p`.`customer_id` = `c`.`id`),0) AS `balance` from (`customers` `c` left join `invoices` `i` on(`i`.`customer_id` = `c`.`id`)) group by `c`.`id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
