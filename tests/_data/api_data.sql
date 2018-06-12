INSERT INTO `oauth2clients` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `secret`, `redirect_url`, `is_confidential`, `allowed_grant_type`, `duration_value`, `duration_amount`, `duration_unit`, `assigned_user_id`) VALUES
('API-4c59-f678-cecc-6594-5a8d9c704473', 'Password Grant API Client', '2018-02-21 16:20:43', '2018-02-21 16:20:43', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'password', 8640000, 1, 'day', NULL),
('API-6d34-6c4c-59be-9fb5-5a8d9cda918f', 'Implicit API Client', '2018-02-21 16:22:07', '2018-02-21 16:22:17', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'implicit', 8640000, 1, 'day', NULL),
('API-b95b-19cd-0229-a3ed-5a8d9cc0d3eb', 'Authorization Code API Client', '2018-02-21 16:22:46', '2018-02-21 16:22:46', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'authorization_code', 8640000, 1, 'day', NULL),
('API-ea74-c352-badd-c2be-5a8d9c9d4351', 'Client Credentials API Client', '2018-02-21 16:21:42', '2018-02-22 17:03:17', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'client_credentials', 1, 1, 'day', '1');


-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 12, 2018 at 04:34 PM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.2.5-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suitecrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `oauth2clients`
--

CREATE TABLE `oauth2clients` (
  `id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `modified_user_id` char(36) DEFAULT NULL,
  `created_by` char(36) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `secret` varchar(4000) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `is_confidential` tinyint(1) DEFAULT '1',
  `allowed_grant_type` varchar(255) DEFAULT 'password',
  `duration_value` int(11) DEFAULT NULL,
  `duration_amount` int(11) DEFAULT NULL,
  `duration_unit` varchar(255) DEFAULT 'Duration Unit',
  `assigned_user_id` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oauth2clients`
--

INSERT INTO `oauth2clients` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `secret`, `redirect_url`, `is_confidential`, `allowed_grant_type`, `duration_value`, `duration_amount`, `duration_unit`, `assigned_user_id`) VALUES
('suitecrm_client', 'suitecrm_client', '2018-06-12 14:12:49', '2018-06-12 14:12:49', '1', '1', NULL, 0, '2bb80d537b1da3e38bd30361aa855686bde0eacd7162fef6a25fe97bf527a25b', NULL, 1, 'password', 60, 1, 'minute', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth2clients`
--
ALTER TABLE `oauth2clients`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;