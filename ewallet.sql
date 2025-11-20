-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 02:35 PM
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
-- Database: `ewallet`
--

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `in_id` varchar(12) NOT NULL,
  `userid` varchar(12) NOT NULL,
  `income_source` varchar(40) NOT NULL,
  `date_received` date DEFAULT curdate(),
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`in_id`, `userid`, `income_source`, `date_received`, `amount`) VALUES
('IN-000001', 'PN-000001', 'work', '2025-11-20', 150000),
('IN-000001', 'PN-000002', 'allowance', '2025-11-20', 10000),
('IN-000002', 'pn-000002', 'work', '2025-11-20', 150000),
('IN-000001', 'PN-000003', 'allowance', '2025-11-20', 50000);

--
-- Triggers `earnings`
--
DELIMITER $$
CREATE TRIGGER `trg_add_earning` AFTER INSERT ON `earnings` FOR EACH ROW BEGIN
    UPDATE user 
    SET budget = budget + NEW.amount
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_delete_earning` AFTER DELETE ON `earnings` FOR EACH ROW BEGIN
    UPDATE user
    SET budget = budget - OLD.amount
    WHERE userid = OLD.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_in_id_before_insert` BEFORE INSERT ON `earnings` FOR EACH ROW BEGIN
    DECLARE max_seq INT;

    SELECT IFNULL(MAX(CAST(SUBSTRING(in_id, 4) AS UNSIGNED)), 0)
    INTO max_seq
    FROM earnings
    WHERE userid = NEW.userid;

    SET NEW.in_id = CONCAT('IN-', LPAD(max_seq + 1, 6, '0'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_earning` AFTER UPDATE ON `earnings` FOR EACH ROW BEGIN
    DECLARE diff DOUBLE;

    SET diff = NEW.amount - OLD.amount;

    UPDATE user
    SET budget = budget + diff
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `out_id` varchar(12) NOT NULL,
  `userid` varchar(12) NOT NULL,
  `category_expense` varchar(50) NOT NULL,
  `cashout_amount` double NOT NULL,
  `date_out` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`out_id`, `userid`, `category_expense`, `cashout_amount`, `date_out`) VALUES
('OUT-000001', 'PN-000001', 'motor', 100000, NULL),
('OUT-000001', 'PN-000002', 'pc set', 60000, NULL);

--
-- Triggers `expenses`
--
DELIMITER $$
CREATE TRIGGER `trg_add_expense` AFTER INSERT ON `expenses` FOR EACH ROW BEGIN
    UPDATE user 
    SET budget = budget - NEW.cashout_amount
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_delete_expense` AFTER DELETE ON `expenses` FOR EACH ROW BEGIN
    UPDATE user
    SET budget = budget + OLD.cashout_amount
    WHERE userid = OLD.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_out_id_before_insert` BEFORE INSERT ON `expenses` FOR EACH ROW BEGIN
    DECLARE max_seq INT;

    SELECT IFNULL(
        MAX(CAST(SUBSTRING(out_id, 5) AS UNSIGNED)),
        0
    )
    INTO max_seq
    FROM expenses
    WHERE userid = NEW.userid;

    SET NEW.out_id = CONCAT('OUT-', LPAD(max_seq + 1, 6, '0'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_expense` AFTER UPDATE ON `expenses` FOR EACH ROW BEGIN
    DECLARE diff DOUBLE;

    SET diff = NEW.cashout_amount - OLD.cashout_amount;

    UPDATE user
    SET budget = budget - diff
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `savingsno` varchar(12) NOT NULL,
  `userid` varchar(12) NOT NULL,
  `bank` varchar(20) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `savings_amount` double NOT NULL,
  `date_of_save` date DEFAULT curdate(),
  `interest_earned` double GENERATED ALWAYS AS (round(`savings_amount` * `interest_rate` / 100,2)) STORED,
  `passkey` int(4) NOT NULL,
  `interest_rate` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`savingsno`, `userid`, `bank`, `description`, `savings_amount`, `date_of_save`, `passkey`, `interest_rate`) VALUES
('SAVE-000001', 'PN-000001', 'bpi', 'concert', 20000, '2025-11-20', 1231, 0.2),
('SAVE-000001', 'PN-000003', 'bdo', 'concert', 20000, '2025-11-20', 1234, 0.23);

--
-- Triggers `savings`
--
DELIMITER $$
CREATE TRIGGER `trg_add_savings` AFTER INSERT ON `savings` FOR EACH ROW BEGIN
    UPDATE user 
    SET budget = budget - NEW.savings_amount
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_delete_savings` AFTER DELETE ON `savings` FOR EACH ROW BEGIN
    UPDATE user
    SET budget = budget + OLD.savings_amount
    WHERE userid = OLD.userid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_savingsno_before_insert` BEFORE INSERT ON `savings` FOR EACH ROW BEGIN
    DECLARE max_seq INT;

    SELECT IFNULL(
        MAX(CAST(SUBSTRING(savingsno, 7) AS UNSIGNED)), 
        0
    )
    INTO max_seq
    FROM savings
    WHERE userid = NEW.userid;

    SET NEW.savingsno = CONCAT('SAVE-', LPAD(max_seq + 1, 6, '0'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_savings` AFTER UPDATE ON `savings` FOR EACH ROW BEGIN
    DECLARE diff DOUBLE;

    SET diff = NEW.savings_amount - OLD.savings_amount;

    UPDATE user
    SET budget = budget - diff
    WHERE userid = NEW.userid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` varchar(12) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `date_of_birth` date NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `citizenship` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sex` char(1) NOT NULL CHECK (`sex` in ('M','F')),
  `budget` double DEFAULT 0,
  `budget_status` varchar(50) DEFAULT NULL,
  `currentdate` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `full_name`, `date_of_birth`, `username`, `age`, `citizenship`, `address`, `phone_number`, `email_address`, `password`, `sex`, `budget`, `budget_status`, `currentdate`) VALUES
('PN-000001', 'Kelia Gamayo', '2005-05-15', 'kagamayo', 20, 'Filipino', 'Manila', '09393534330', 'kagamayow@gmail.com', '12345', 'F', 30000, 'You may save this in your savings account.', '2025-11-20'),
('PN-000002', 'Jan Marc', '2004-09-17', 'jmzaxe', 20, 'Filipino', 'Quezon City', '09111111111', 'jmj@gmail.com', '54321', 'M', 100000, 'You may save this in your savings account.', '2025-11-20'),
('PN-000003', 'Micka Lim', '2004-10-06', 'mickaxd', 21, 'Filipino', 'Quezon City', '09222222222', 'miks@gmail.com', 'hahahehe123', 'F', 30000, 'You may save this in your savings account.', '2025-11-20');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `trg_update_budget_status` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN
    IF NEW.budget > 0 THEN
        SET NEW.budget_status = 'You may save this in your savings account.';
    ELSEIF NEW.budget = 0 THEN
        SET NEW.budget_status = 'If you spend more, you will be over the budget.';
    ELSEIF NEW.budget < 0 THEN
        SET NEW.budget_status = 'Warning: You are already over your budget!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_userid_before_insert` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
    DECLARE max_seq INT;

    SELECT IFNULL(MAX(CAST(SUBSTRING(userid, 4) AS UNSIGNED)), 0)
    INTO max_seq
    FROM user
    WHERE userid LIKE 'PN-%';

    SET NEW.userid = CONCAT('PN-', LPAD(max_seq + 1, 6, '0'));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`userid`,`in_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`userid`,`out_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`userid`,`savingsno`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
