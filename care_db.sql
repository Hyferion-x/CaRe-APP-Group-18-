-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 07:03 AM
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
-- Database: `care_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `activity_date` date NOT NULL,
  `activity_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `activity_type`, `activity_date`, `activity_time`, `created_at`) VALUES
(1, 6, 'sleeping', '2024-10-06', '14:45:00', '2024-10-06 04:15:17'),
(2, 6, 'eating', '2024-10-06', '02:50:00', '2024-10-06 04:19:21'),
(3, 6, 'exercise', '2024-10-10', '14:53:00', '2024-10-06 04:19:28'),
(4, 6, 'eating', '2024-10-04', '12:17:00', '2024-10-06 13:47:46'),
(5, 6, 'eating', '2024-10-05', '00:38:00', '2024-10-06 14:06:45'),
(6, 6, 'eating', '2024-10-05', '00:38:00', '2024-10-06 14:06:45'),
(7, 6, 'eating', '2024-10-05', '00:38:00', '2024-10-06 14:06:46'),
(8, 6, 'eating', '2024-10-05', '00:38:00', '2024-10-06 14:06:47'),
(9, 6, 'exercise', '2024-10-05', '00:38:00', '2024-10-06 14:07:03'),
(10, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:46:43'),
(11, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:46:44'),
(12, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:47:04'),
(13, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:47:04'),
(14, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:47:04'),
(15, 6, 'eating', '2024-10-20', '14:16:00', '2024-10-06 15:47:05'),
(16, 6, 'exercise', '2024-10-13', '02:19:00', '2024-10-06 15:47:31'),
(17, 6, 'exercise', '2024-10-13', '02:19:00', '2024-10-06 15:47:31'),
(18, 6, 'exercise', '2024-10-13', '02:19:00', '2024-10-06 15:47:32'),
(19, 6, 'exercise', '2024-10-13', '02:19:00', '2024-10-06 15:47:32'),
(20, 6, 'sleeping', '2024-10-13', '02:32:00', '2024-10-06 16:00:20'),
(21, 6, 'exercise', '2024-10-07', '14:30:00', '2024-10-06 16:00:50'),
(22, 6, 'exercise', '2024-10-07', '14:30:00', '2024-10-06 16:00:51'),
(23, 6, 'eating', '2024-10-07', '02:35:00', '2024-10-06 16:05:08'),
(24, 6, 'eating', '2024-10-07', '02:35:00', '2024-10-06 16:05:09'),
(25, 6, 'eating', '2024-10-07', '02:35:00', '2024-10-06 16:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `therapist_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `therapist_id`, `group_name`) VALUES
(109, 9, 'asaxaxax'),
(110, 9, 'asas'),
(112, 9, 'asdasdd'),
(114, 9, 'qwwwwwwwww'),
(115, 9, 'dfsfsd'),
(116, 9, 'dfdf'),
(117, 9, 'ssad'),
(118, 9, 'asass'),
(119, 9, 'gfhfh'),
(120, 9, 'xxcc'),
(121, 9, 'bvb');

-- --------------------------------------------------------

--
-- Table structure for table `group_patients`
--

CREATE TABLE `group_patients` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_patients`
--

INSERT INTO `group_patients` (`id`, `group_id`, `patient_id`) VALUES
(183, 109, 23),
(185, 110, 23),
(194, 120, 6);

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `mood` varchar(255) NOT NULL,
  `energy_level` int(11) NOT NULL,
  `entry` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `user_id`, `date`, `mood`, `energy_level`, `entry`, `created_at`) VALUES
(6, 6, '2024-08-25', 'happy', 10, 'I\'m ok', '2024-08-25 06:50:46'),
(7, 6, '2024-08-29', 'anxious', 10, 'I\'m ok', '2024-08-29 00:33:02'),
(9, 6, '2024-08-14', 'anxious', 6, 'cars', '2024-08-29 18:11:24'),
(10, 6, '2024-08-22', 'anxious', 1, 'I\'m not ok', '2024-08-29 18:12:18'),
(15, 6, '2024-08-30', 'excited', 2, 'I\'m ok', '2024-08-29 19:39:52'),
(26, 6, '2024-08-15', 'excited', 1, 'I\'m ok', '2024-08-29 20:25:50'),
(28, 6, '2024-08-30', 'anxious', 8, 'im ok', '2024-08-30 04:51:09'),
(29, 6, '0000-00-00', 'sad', 10, 'lol', '2024-08-30 07:02:34'),
(30, 6, '0000-00-00', 'sad', 7, '', '2024-09-02 06:52:48'),
(31, 6, '2024-09-03', 'happy', 3, 'poool', '2024-09-02 15:46:02'),
(32, 6, '0000-00-00', 'excited', 9, 'hello ', '2024-09-08 03:23:23'),
(33, 8, '2024-09-11', 'happy', 6, 'gfsdf', '2024-09-10 16:07:23'),
(34, 6, '2024-09-11', 'happy', 9, 'im ok today', '2024-09-11 07:02:11'),
(35, 6, '0000-00-00', 'sad', 5, '', '2024-09-12 00:54:53'),
(36, 6, '2024-09-23', 'happy', 7, 'bboakbo', '2024-09-23 02:02:25'),
(37, 23, '2024-10-25', 'happy', 10, 'gooddd', '2024-10-08 18:03:19'),
(38, 23, '2024-10-22', 'happy', 3, 'okkk', '2024-10-08 18:03:26'),
(39, 23, '2024-10-25', 'anxious', 3, 'hmmmm ya', '2024-10-08 18:03:38'),
(40, 23, '2024-10-14', 'sad', 1, 'no', '2024-10-08 18:03:44'),
(41, 23, '2024-10-14', 'happy', 8, 'yessss', '2024-10-08 18:03:50'),
(42, 23, '2024-10-20', 'excited', 10, 'lets goooooo', '2024-10-08 18:03:59'),
(43, 23, '2024-10-31', 'happy', 8, 'ok ok', '2024-10-08 18:04:06'),
(44, 23, '2024-10-04', 'anxious', 3, 'no yes', '2024-10-08 18:04:16'),
(45, 23, '0000-00-00', 'excited', 7, 'yesssss', '2024-10-08 18:04:25'),
(46, 6, '2024-10-14', 'happy', 8, 'ghbfhfgh', '2024-10-13 16:34:22'),
(47, 6, '2024-10-14', 'happy', 9, 'fgfgfg', '2024-10-13 16:52:42'),
(48, 6, '2024-10-14', 'anxious', 10, 'qqqqqqqqqqqqqqq', '2024-10-13 16:52:57'),
(49, 6, '0000-00-00', 'happy', 9, 'aaaaaaaaaaaaa', '2024-10-13 16:53:08'),
(50, 6, '2024-10-14', 'happy', 10, '101010', '2024-10-13 17:00:08');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `therapist_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note_text` text NOT NULL,
  `note_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `therapist_id`, `user_id`, `note_text`, `note_date`) VALUES
(24, 1, 1, 'Patient is showing signs of improvement in anxiety management.', '2024-09-15'),
(25, 2, 1, 'Therapy session focused on mindfulness techniques.', '2024-09-17'),
(26, 1, 2, 'Discussed coping strategies for stress.', '2024-09-18'),
(27, 3, 3, 'Patient is adhering well to the prescribed therapy.', '2024-09-19'),
(28, 2, 4, 'Explored breathing exercises to manage panic attacks.', '2024-09-20'),
(29, 3, 2, 'Patient requested to reschedule the next appointment.', '2024-09-21'),
(30, 1, 4, 'Reviewed progress on emotional regulation techniques.', '2024-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `therapist_id` int(11) NOT NULL,
  `session_date` date NOT NULL,
  `session_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `group_id`, `therapist_id`, `session_date`, `session_time`, `notes`, `status`) VALUES
(13, 115, 9, '2024-10-11', '02:03:00', 'dfgdfgdfg', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `todo_id` int(11) NOT NULL,
  `therapist_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `note_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `insurance_id` varchar(50) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `therapist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `photo`, `role`, `phone`, `mobile`, `address`, `gender`, `birthday`, `age`, `allergies`, `blood_type`, `insurance_id`, `bio`, `therapist_id`) VALUES
(6, 'Takina', 'Takina@email.com', '$2y$10$.83ZoSHCTfv02WwSyrcDuernpbmxpd2W0ha4lLmAHbJ0/w2L7KXNa', 'Takina Ramy', 'uploads/Takina.png', 'patient', '0998877665', '0112233445', '123 Health St, Cityville', 'female', '2002-06-06', 18, 'I hate vanilla JavaScript', 'B plus', 'INS987654', 'hello', 9),
(8, 'Hulk', 'hulk@com', '$2y$10$KxAFpchoOR30VJWkXuAad.EkK3hKbLjENsyApgxpYUqqtMbRxFVOq', 'hulk', '', 'staff', '0456335554', '0456335551', '14 abc, bcs', 'female', '2024-09-11', 222, 'lolipop', 'B+', '10101000', 'bla bla', 9),
(9, 'rony', 'rony@emial.com', '$2y$10$vfqfU52.jc4RW0WDg5u9VurmWHMZC6ziW57jHAZYmKABqqFxFUby.', 'rony talk', '', 'therapist', '', '', '', 'male', '0000-00-00', NULL, '', '', '', '', NULL),
(23, 'sara', 'sara@email.com', '$2y$10$hZoPCFY59dWP3pOW99xFz.EzfblVhhCmgH2pRWpe.ECyQnNENPlQ6', 'Sara W', 'uploads/pusheen-23.jpg', 'auditor', '0444877854', '454545454545', '10 greentree  usa , at your house', 'male', '2024-10-09', NULL, 'Vanilla JavaScript ', 'B', '5545400', 'hello class', 0),
(45, 'john_doe', 'john.doe@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'John Doe', NULL, 'patient', '0123456789', '0987654321', '123 Main St, Cityville', 'male', '1995-06-15', 29, 'None', 'A+', 'INS123456', 'Bio for John', 9),
(46, 'jane_smith', 'jane.smith@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Jane Smith', NULL, 'patient', '0123456781', '0987654322', '456 Oak St, Townsville', 'female', '1992-03-22', 32, 'Peanuts', 'O-', 'INS654321', 'Bio for Jane', 9),
(47, 'alice_wong', 'alice.wong@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Alice Wong', NULL, 'patient', '0123456782', '0987654323', '789 Pine St, Villagetown', 'female', '1988-08-10', 36, 'Dust', 'B+', 'INS789123', 'Bio for Alice', 9),
(48, 'bob_jones', 'bob.jones@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Bob Jones', NULL, 'patient', '0123456783', '0987654324', '321 Birch St, Hamlet', 'male', '1990-02-02', 34, 'Shellfish', 'AB+', 'INS321987', 'Bio for Bob', 9),
(49, 'carol_lee', 'carol.lee@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Carol Lee', NULL, 'patient', '0123456784', '0987654325', '654 Cedar St, Cityberg', 'female', '1997-11-14', 27, 'Pollen', 'A-', 'INS852741', 'Bio for Carol', 9),
(50, 'daniel_kim', 'daniel.kim@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Daniel Kim', NULL, 'patient', '0123456785', '0987654326', '987 Spruce St, Metropolis', 'male', '1985-07-07', 39, 'Lactose', 'B-', 'INS963852', 'Bio for Daniel', 9),
(51, 'emily_brown', 'emily.brown@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Emily Brown', NULL, 'patient', '0123456786', '0987654327', '159 Willow St, Capital City', 'female', '1993-04-19', 31, 'Gluten', 'O+', 'INS147258', 'Bio for Emily', 9),
(52, 'frank_harris', 'frank.harris@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Frank Harris', NULL, 'patient', '0123456787', '0987654328', '753 Maple St, Rivertown', 'male', '1987-12-25', 36, 'None', 'A+', 'INS456789', 'Bio for Frank', 9),
(53, 'grace_chen', 'grace.chen@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Grace Chen', NULL, 'patient', '0123456788', '0987654329', '246 Elm St, Lakeside', 'female', '1998-09-05', 26, 'None', 'B-', 'INS753951', 'Bio for Grace', 9),
(54, 'henry_clark', 'henry.clark@email.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Henry Clark', NULL, 'patient', '0123456789', '0987654330', '369 Poplar St, Hilltop', 'male', '1991-01-16', 33, 'None', 'O-', 'INS159753', 'Bio for Henry', 9),
(55, 'dr_john_smith', 'john.smith@clinic.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. John Smith', NULL, 'therapist', '0111111111', '0999999991', '789 Clinic Rd, Townsville', 'male', '1980-05-23', 44, 'None', 'A+', 'THERA12345', 'Experienced therapist', NULL),
(56, 'dr_jane_doe', 'jane.doe@clinic.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Jane Doe', NULL, 'therapist', '0122222222', '0988888882', '456 Mental Health St, Cityville', 'female', '1985-12-10', 39, 'None', 'O-', 'THERA54321', 'Expert in mental health therapy', NULL),
(57, 'dr_bob_martin', 'bob.martin@therapy.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Bob Martin', NULL, 'therapist', '0133333333', '0977777773', '321 Wellness Dr, Health Town', 'male', '1979-08-05', 45, 'Dust', 'B+', 'THERA98765', 'Specialist in cognitive therapy', NULL),
(58, 'dr_alice_green', 'alice.green@therapy.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Alice Green', NULL, 'therapist', '0144444444', '0966666664', '654 Therapy Ave, Healtown', 'female', '1990-11-29', 33, 'Peanuts', 'AB-', 'THERA85236', 'Family therapy expert', NULL),
(59, 'dr_david_lee', 'david.lee@therapy.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. David Lee', NULL, 'therapist', '0155555555', '0955555555', '123 Recovery St, Rehabsburg', 'male', '1983-02-15', 41, 'Pollen', 'A-', 'THERA96325', 'Behavioral therapy expert', NULL),
(60, 'dr_linda_wilson', 'linda.wilson@wellness.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Linda Wilson', NULL, 'therapist', '0166666666', '0944444446', '321 Mind Care Blvd, Mindville', 'female', '1978-07-30', 46, 'None', 'O+', 'THERA65487', 'Adolescent therapy specialist', NULL),
(61, 'dr_chris_taylor', 'chris.taylor@wellness.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Chris Taylor', NULL, 'therapist', '0177777777', '0933333337', '567 Therapy Rd, Happyville', 'male', '1987-10-03', 37, 'Shellfish', 'B-', 'THERA32147', 'Expert in trauma therapy', NULL),
(62, 'dr_susan_brown', 'susan.brown@therapy.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Susan Brown', NULL, 'therapist', '0188888888', '0922222228', '654 Wellness Way, Rehabsburg', 'female', '1995-05-20', 29, 'Gluten', 'A-', 'THERA15973', 'Addiction recovery specialist', NULL),
(63, 'dr_mark_white', 'mark.white@clinic.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Mark White', NULL, 'therapist', '0199999999', '0911111119', '789 Mind St, Cityville', 'male', '1992-06-15', 32, 'None', 'O-', 'THERA25874', 'Relationship counseling expert', NULL),
(64, 'dr_rachel_jones', 'rachel.jones@therapy.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Dr. Rachel Jones', NULL, 'therapist', '0101010101', '0900000000', '159 Health Rd, Wellness Town', 'female', '1982-04-18', 42, 'None', 'AB+', 'THERA75396', 'Stress management and anxiety specialist', NULL),
(65, 'staff_jack_williams', 'jack.williams@company.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Jack Williams', NULL, 'staff', '0112345678', '0998765432', '100 Company St, Business City', 'male', '1980-04-12', 44, 'None', 'A+', 'STAFF12345', 'Experienced staff member', NULL),
(66, 'staff_anna_clark', 'anna.clark@company.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Anna Clark', NULL, 'staff', '0123456789', '0987654321', '200 Company Rd, Industry Town', 'female', '1985-09-23', 39, 'None', 'O-', 'STAFF54321', 'Dedicated staff member', NULL),
(67, 'staff_brian_johnson', 'brian.johnson@company.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Brian Johnson', NULL, 'staff', '0134567890', '0976543210', '300 Office Dr, Work City', 'male', '1990-12-01', 33, 'None', 'B+', 'STAFF98765', 'Reliable staff member', NULL),
(68, 'staff_clara_moore', 'clara.moore@company.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Clara Moore', NULL, 'staff', '0145678901', '0965432109', '400 Business St, Admin Town', 'female', '1993-03-15', 31, 'None', 'AB-', 'STAFF85236', 'Efficient staff member', NULL),
(69, 'staff_steve_davis', 'steve.davis@company.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Steve Davis', NULL, 'staff', '0156789012', '0954321098', '500 Corporate Rd, Commerce City', 'male', '1987-07-18', 37, 'None', 'A-', 'STAFF96325', 'Hardworking staff member', NULL),
(70, 'mary_jones', 'mary.jones@audit.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Mary Jones', NULL, 'auditor', '0212345678', '0898765432', '100 Audit Ave, Finance City', 'female', '1982-11-19', 41, 'None', 'A+', 'AUDIT12345', 'Experienced auditor', NULL),
(71, 'james_miller', 'james.miller@audit.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'James Miller', NULL, 'auditor', '0223456789', '0887654321', '200 Audit St, Business Town', 'male', '1986-06-22', 38, 'None', 'O-', 'AUDIT54321', 'Meticulous auditor', NULL),
(72, 'susan_hall', 'susan.hall@audit.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Susan Hall', NULL, 'auditor', '0234567890', '0876543210', '300 Audit Dr, Compliance City', 'female', '1991-02-11', 33, 'None', 'B+', 'AUDIT98765', 'Detailed auditor', NULL),
(73, 'peter_smith', 'peter.smith@audit.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Peter Smith', NULL, 'auditor', '0245678901', '0865432109', '400 Audit Blvd, Regulatory Town', 'male', '1988-04-05', 36, 'None', 'AB-', 'AUDIT85236', 'Experienced auditor', NULL),
(74, 'emma_davis', 'emma.davis@audit.com', '$2y$10$h4fKPIpmqi/GWx/hjJ7LDOFSO8IlE5.zawRlSHgtPptIcMNIGX6fq', 'Emma Davis', NULL, 'auditor', '0256789012', '0854321098', '500 Compliance Rd, Inspection City', 'female', '1990-09-15', 34, 'None', 'A-', 'AUDIT96325', 'Efficient auditor', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapist_id` (`therapist_id`);

--
-- Indexes for table `group_patients`
--
ALTER TABLE `group_patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_therapist` (`therapist_id`),
  ADD KEY `fk_patient` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `therapist_id` (`therapist_id`);

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`todo_id`),
  ADD KEY `therapist_id` (`therapist_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `group_patients`
--
ALTER TABLE `group_patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_patients`
--
ALTER TABLE `group_patients`
  ADD CONSTRAINT `group_patients_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_patients_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD CONSTRAINT `journal_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `fk_patient` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_therapist` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`therapist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD CONSTRAINT `todo_list_ibfk_1` FOREIGN KEY (`therapist_id`) REFERENCES `therapists` (`therapist_id`),
  ADD CONSTRAINT `todo_list_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
