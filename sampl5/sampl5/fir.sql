-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 08:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fir`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `severity` enum('high','medium','low') NOT NULL DEFAULT 'low',
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `description`, `date`, `type`, `status`, `severity`, `priority`) VALUES
(7, 5, 'riot', '2024-03-14', 'riot', 'completed', 'low', NULL),
(8, 5, 'there was accident in jyothi', '2024-03-15', 'car accident', 'completed', 'low', NULL),
(12, 5, 'assualt', '2024-03-15', 'assault', 'completed', 'high', NULL),
(13, 6, 'robbery in pvs', '2024-03-18', 'robbery', 'completed', 'high', 1);

--
-- Triggers `complaints`
--
DELIMITER $$
CREATE TRIGGER `remove_completed_complaints` AFTER UPDATE ON `complaints` FOR EACH ROW BEGIN
    IF NEW.status = 'completed' THEN
        IF DATEDIFF(NOW(), NEW.date) >= 5 THEN
            DELETE FROM complaints WHERE id = NEW.id;
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_priority_trigger` BEFORE INSERT ON `complaints` FOR EACH ROW BEGIN
    DECLARE priority_value INT;

    -- Calculate priority based on severity
    IF NEW.severity = 'high' THEN
        SET priority_value = 1;
    ELSEIF NEW.severity = 'medium' THEN
        SET priority_value = 2;
    ELSE
        SET priority_value = 3;
    END IF;

    -- Set the priority for the new row
    SET NEW.priority = priority_value;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `crimeinformation`
-- (See below for the actual view)
--
CREATE TABLE `crimeinformation` (
`id` int(11)
,`username` varchar(50)
,`description` text
,`date` date
,`type` varchar(100)
,`severity` enum('high','medium','low')
,`status` enum('pending','completed')
,`priority` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `criminals`
--

CREATE TABLE `criminals` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_of_capture` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criminals`
--

INSERT INTO `criminals` (`id`, `complaint_id`, `name`, `age`, `description`, `date_of_capture`) VALUES
(1, 12, 'jasraj', 28, 'short,wide frame', '0000-00-00'),
(2, 13, 'brian', 28, 'fair skin,long hair', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `location_found` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evidence`
--

INSERT INTO `evidence` (`id`, `complaint_id`, `description`, `location_found`) VALUES
(1, 12, 'cctv footage', 'putur'),
(2, 13, 'hair dna in home of culprit', 'house');

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police`
--

INSERT INTO `police` (`id`, `username`, `password`, `email`) VALUES
(1, 'police1', 'police1', 'arjun.cy21@sahyadri.edu.in'),
(3, 'ram', '4321', 'admin1@gmail.com'),
(4, 'police2', 'police2', 'police2@gmail.com'),
(5, 'police3', 'police3', '123@gmail.com'),
(6, 'police4', 'police4', 'police4@gmail.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `usercomplaints`
-- (See below for the actual view)
--
CREATE TABLE `usercomplaints` (
`complaint_id` int(11)
,`description` text
,`date` date
,`status` enum('pending','completed')
,`severity` enum('high','medium','low')
,`type` varchar(100)
,`criminal_name` varchar(100)
,`user_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'arjun', 'shetty', 'shettyarjun2003@gmail.com', 'user'),
(2, 'admin', 'pass', 'admin@gmail.com', 'admin'),
(4, 'raj', '123', 'anonymousshetty2003@gmail.com', 'user'),
(5, 'shreyas', 'shreyas', 'shreyas@gmail.com', 'user'),
(6, 'anup', '12345', 'anuppai@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

CREATE TABLE `witnesses` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `witnesses`
--

INSERT INTO `witnesses` (`id`, `complaint_id`, `name`, `contact_info`) VALUES
(1, 12, 'arjun', '9876543'),
(2, 13, 'rohan', '9741732770');

-- --------------------------------------------------------

--
-- Structure for view `crimeinformation`
--
DROP TABLE IF EXISTS `crimeinformation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `crimeinformation`  AS SELECT `c`.`id` AS `id`, `u`.`username` AS `username`, `c`.`description` AS `description`, `c`.`date` AS `date`, `c`.`type` AS `type`, `c`.`severity` AS `severity`, `c`.`status` AS `status`, if(`c`.`severity` = 'high',1,if(`c`.`severity` = 'medium',2,3)) AS `priority` FROM (`complaints` `c` join `users` `u` on(`c`.`user_id` = `u`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `usercomplaints`
--
DROP TABLE IF EXISTS `usercomplaints`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usercomplaints`  AS SELECT `complaints`.`id` AS `complaint_id`, `complaints`.`description` AS `description`, `complaints`.`date` AS `date`, `complaints`.`status` AS `status`, `complaints`.`severity` AS `severity`, `complaints`.`type` AS `type`, `criminals`.`name` AS `criminal_name`, `complaints`.`user_id` AS `user_id` FROM (`complaints` left join `criminals` on(`complaints`.`id` = `criminals`.`complaint_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `criminals`
--
ALTER TABLE `criminals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_criminals_complaint_id` (`complaint_id`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evidence_complaint_id` (`complaint_id`);

--
-- Indexes for table `police`
--
ALTER TABLE `police`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_witnesses_complaint_id` (`complaint_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `criminals`
--
ALTER TABLE `criminals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `police`
--
ALTER TABLE `police`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `witnesses`
--
ALTER TABLE `witnesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `criminals`
--
ALTER TABLE `criminals`
  ADD CONSTRAINT `criminals_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`),
  ADD CONSTRAINT `fk_criminals_complaint_id` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `evidence`
--
ALTER TABLE `evidence`
  ADD CONSTRAINT `fk_evidence_complaint_id` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);

--
-- Constraints for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD CONSTRAINT `fk_witnesses_complaint_id` FOREIGN KEY (`complaint_id`) REFERENCES `complaints` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
