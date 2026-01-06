-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 02:26 AM
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
-- Database: `bdhr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','cancelled','completed') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `reason`, `status`, `created_at`) VALUES
(13, 1, 1, '2026-01-10', '10:30:00', 'Fever and headache', 'pending', '2026-01-06 04:28:08'),
(14, 2, 2, '2026-01-12', '12:00:00', 'Chest pain and breathing issue', 'approved', '2026-01-06 04:28:08'),
(15, 3, 1, '2026-01-15', '11:15:00', 'Diabetes follow-up', 'approved', '2026-01-06 04:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `symptoms` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `patient_id`, `doctor_id`, `symptoms`, `diagnosis`, `created_at`) VALUES
(1, 2, 2, 'Chest pain, shortness of breath', 'Possible angina. Recommend ECG and blood test.', '2026-01-06 04:28:19'),
(2, 3, 1, 'High blood sugar, frequent thirst', 'Type 2 Diabetes - needs regular monitoring.', '2026-01-06 04:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `license_no` varchar(50) DEFAULT NULL,
  `chamber` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialization`, `license_no`, `chamber`) VALUES
(1, 1, 'Medicine', 'DHA-1001', 'Dhaka Medical, Dhaka'),
(2, 2, 'Cardiology', 'DHA-1002', 'Square Hospital, Dhaka'),
(3, 9, 'Medicine', 'DHA-1003', 'Evercare Hospital');

-- --------------------------------------------------------

--
-- Table structure for table `lab_reports`
--

CREATE TABLE `lab_reports` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `report_date` date DEFAULT NULL,
  `doctor_comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_reports`
--

INSERT INTO `lab_reports` (`id`, `patient_id`, `title`, `file_path`, `report_date`, `doctor_comment`, `created_at`) VALUES
(1, 2, 'ECG Report', 'uploads/reports/ecg_ayesha.pdf', '2026-01-11', 'ECG shows mild abnormality. Need cardiology review.', '2026-01-06 04:28:44'),
(2, 3, 'Blood Sugar Test', 'uploads/reports/sugar_rahim.pdf', '2026-01-14', 'Sugar level is high. Continue Metformin.', '2026-01-06 04:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `purpose` enum('register','login','reset_password') NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp_codes`
--

INSERT INTO `otp_codes` (`id`, `email`, `otp`, `purpose`, `expires_at`, `created_at`) VALUES
(1, 'sadman@bdhr.com', '123456', 'login', '2026-01-06 04:33:52', '2026-01-06 04:28:52'),
(2, 'ayesha@bdhr.com', '654321', 'reset_password', '2026-01-06 04:33:52', '2026-01-06 04:28:52'),
(3, 'tanvir@bdhr.com', '111222', 'login', '2026-01-06 04:33:52', '2026-01-06 04:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medical_id` varchar(30) NOT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `medical_id`, `dob`, `address`) VALUES
(1, 3, 'BDHR-P-1001', '2001-08-07', 'Mirpur, Dhaka'),
(2, 4, 'BDHR-P-1002', '2002-03-15', 'Dhanmondi, Dhaka'),
(3, 5, 'BDHR-P-1003', '1998-10-22', 'Uttara, Dhaka'),
(4, 7, 'BDHR-P-1004', '2003-05-11', 'Mymensingh');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `diagnosis_id` int(11) DEFAULT NULL,
  `medicine` text NOT NULL,
  `advice` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `patient_id`, `doctor_id`, `diagnosis_id`, `medicine`, `advice`, `created_at`) VALUES
(1, 2, 2, 1, 'Aspirin 75mg - 1 tablet daily\nAtorvastatin 10mg - 1 tablet at night', 'Avoid oily foods, do ECG ASAP and follow-up in 7 days.', '2026-01-06 04:28:33'),
(2, 3, 1, 2, 'Metformin 500mg - 1+0+1 after meals\nVitamin D - once daily', 'Drink more water, exercise daily, check glucose level weekly.', '2026-01-06 04:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('patient','doctor') NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` char(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `gender`, `email`, `phone`, `password`, `status`, `created_at`) VALUES
(1, 'doctor', 'Dr. Tanvir Ahmed', 'male', 'tanvir@bdhr.com', '01711111111', 'tanvir123', 'active', '2026-01-06 04:26:14'),
(2, 'doctor', 'Dr. Nusrat Jahan', 'female', 'nusrat@bdhr.com', '01822222222', 'nusrat123', 'active', '2026-01-06 04:26:14'),
(3, 'patient', 'Sadman Sakib', 'male', 'sadman@bdhr.com', '01933333333', 'sadman123', 'active', '2026-01-06 04:26:14'),
(4, 'patient', 'Ayesha Rahman', 'female', 'ayesha@bdhr.com', '01644444444', 'ayesha123', 'active', '2026-01-06 04:26:14'),
(5, 'patient', 'Rahim Uddin', 'male', 'rahim@bdhr.com', '01555555555', 'rahim123', 'active', '2026-01-06 04:26:14'),
(6, 'doctor', 'Sadman Sakib', 'male', 'contact.sadman19@gmail.com', '01713571667', '123456', 'active', '2026-01-06 06:01:40'),
(7, 'patient', 'Sadman ss', 'male', 'sadman19@gmail.com', '01713578667', '11111111', 'active', '2026-01-06 06:46:46'),
(9, 'doctor', 'Ishtiak Khan', 'male', 'khanishtiak@gmail.com', '01323456789', '111111', 'active', '2026-01-06 06:57:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `idx_appointment_date` (`appointment_date`);

--
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `idx_diagnosis_created` (`created_at`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `license_no` (`license_no`);

--
-- Indexes for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `idx_report_title` (`title`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `medical_id` (`medical_id`),
  ADD KEY `idx_medical_id` (`medical_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `idx_prescription_created` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_reports`
--
ALTER TABLE `lab_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD CONSTRAINT `diagnoses_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diagnoses_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lab_reports`
--
ALTER TABLE `lab_reports`
  ADD CONSTRAINT `lab_reports_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
