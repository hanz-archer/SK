-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 03:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountID` int(11) NOT NULL,
  `SK_ID` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `phone_number` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountID`, `SK_ID`, `first_name`, `middle_name`, `last_name`, `birthdate`, `phone_number`, `email`, `password`) VALUES
(1, 2401, 'Christian', 'Rosal', 'Abregana', '2024-11-22', 2147483647, 'ca@gmail.com', '$2y$10$.g/rRSfcr.B0nyKgoFmFqOeqMUMUfu7sicj4c615s4gXIPz9ovJGa'),
(3, 2418, 'Allan Christian', 'Quiroga', 'Casio', '2004-07-04', 2147483647, 'allan@gmail.com', '$2y$10$9lDLxQNFPBAdp3k4fqM6ZugS31kHrU48GQ1nZWp68lD28CA6P6K3a'),
(4, 2433, 'Claison Mar', 'Gicale', 'Famor', '2024-12-11', 2147483647, 'cf@gmail.com', '$2y$10$kmu2bMP18WpQoAtN10mg2Ogir7QH.vcSKVbwQkvxmnoQnEw6t7V9q');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `AnnouncementID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`AnnouncementID`, `Title`, `Date`, `Description`) VALUES
(2, 'LARO NG LAHI ', '2025-01-04 16:28:42', 'Attention Residents of Barangay Sumaguan!\r\n\r\nWe are excited to announce the upcoming LARO NG LAHI, a vibrant celebration of traditional games and sports that will take place in our barangay! This event aims to foster community spirit, promote physical activity, and revive the cultural heritage associated with our beloved Filipino games.\r\n\r\nEvent Details:\r\n\r\nDate: [Insert Date]\r\nTime: [Insert Start Time] to [Insert End Time]\r\nVenue: [Specify Venue or Location]\r\nParticipants: Open to all ages\r\nJoin us for a day filled with fun, excitement, and friendly competition! Enjoy classic games such as patintero, sack race, and luksong tinik, as well as various other activities designed to engage the whole family.\r\n\r\nRegistration Details:\r\n\r\nRegistration will take place at [Insert Location] from [Insert Start Time] to [Insert End Time].\r\nParticipants can register as individuals or as teams.\r\nPrizes and Snacks: Exciting prizes await the winners! Complimentary snacks and refreshments will be provided throughout the event.\r\n\r\nLet’s come together as a community to celebrate our culture and strengthen our bonds through playful competition. Bring your friends and family, and let’s make this event memorable!\r\n\r\nFor more information, contact: [Insert Contact Person’s Name] [Insert Contact Number]');

-- --------------------------------------------------------

--
-- Table structure for table `archive_announcements`
--

CREATE TABLE `archive_announcements` (
  `AnnouncementID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `archive_announcements`
--

INSERT INTO `archive_announcements` (`AnnouncementID`, `Title`, `Date`, `Description`) VALUES
(1, 'asdas', '2025-01-04 15:55:01', 'dasdasd\r\nasdasd\r\nasdasd\r\nasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `AwardID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `DatePosted` date NOT NULL,
  `DateAwarded` date NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`AwardID`, `Title`, `DatePosted`, `DateAwarded`, `Image`, `Description`) VALUES
(1, 'best in dress', '2025-01-04', '2024-12-10', '1735980682_6778f68a03d62.png', 'Certainly! Let\'s ensure that your AdminAwards.php correctly displays the uploaded images associated with each award. Based on the snippets you\'ve provided and the previous steps taken to handle image uploads, there are a few areas we should review and adjust to ensure seamless functionality.'),
(2, 'asdadsd', '2025-01-04', '2025-01-03', '1735980717_6778f6ad05129.jpg', 'Certainly! Let\'s ensure that your AdminAwards.php correctly displays the uploaded images associated with each award. Based on the snippets you\'ve provided and the previous steps taken to handle image uploads, there are a few areas we should review and adjust to ensure seamless functionality.');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `Budget_ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Date` date NOT NULL,
  `Total_Budget` double(10,2) NOT NULL,
  `Description` longtext NOT NULL,
  `Created_At` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`Budget_ID`, `Title`, `Date`, `Total_Budget`, `Description`, `Created_At`) VALUES
(1, 'edwed', '2024-12-05', 43345.00, 'dcsd', '2024-12-05 21:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_administration`
--

CREATE TABLE `cbydp_pa_administration` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_agriculture`
--

CREATE TABLE `cbydp_pa_agriculture` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_citizenship`
--

CREATE TABLE `cbydp_pa_citizenship` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_economic`
--

CREATE TABLE `cbydp_pa_economic` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_education`
--

CREATE TABLE `cbydp_pa_education` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_governance`
--

CREATE TABLE `cbydp_pa_governance` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_health`
--

CREATE TABLE `cbydp_pa_health` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_peace`
--

CREATE TABLE `cbydp_pa_peace` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_social`
--

CREATE TABLE `cbydp_pa_social` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cbydp_pa_sports`
--

CREATE TABLE `cbydp_pa_sports` (
  `id` int(11) NOT NULL,
  `youth_development_concern` text NOT NULL,
  `objective` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `target_2024` varchar(255) NOT NULL,
  `target_2025` varchar(255) NOT NULL,
  `target_2026` varchar(255) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `responsible_person` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(50) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `meeting_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_meeting` date NOT NULL,
  `call_to_order` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invocation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_call` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reading_minutes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agenda` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendar_of_business` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adjournment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prepared_by_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prepared_by_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attested_by_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attested_by_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `meeting_title`, `date_of_meeting`, `call_to_order`, `invocation`, `roll_call`, `reading_minutes`, `agenda`, `calendar_of_business`, `adjournment`, `prepared_by_name`, `prepared_by_position`, `attested_by_name`, `attested_by_position`, `created_at`, `visibility`) VALUES
(1, '1111111', '2025-01-01', '   SK Chairperson Hon. Kian Cabase called the meeting to order at 12:00 pm and continued to preside over the session. ', '          The invocation was done by SK Secretary Hanzel  A . Agarao, followed by the singing of the national anthem led by Hon. Cherielou S. Caspe. ', '     The SK secretary Hanzel A. Agarao called the names of the SK members as instructed by the SK chairperson, and since only one member of the Sangguniang Kabataan is absent, a quorum was declared present.', '', '1.	IRP (Internal Rules and Procedure)\r\n2.	Process requirements for Sangguniang Kabataan Fidelity Bond\r\n3.	Process for Sangguniang Kabataan Open Bank Account by the newly designated signatories\r\n4.	Process for SK TIN Number\r\n5.	Take a seat in the next session with Hon. Jerome Sarvida Barangay Councilor.\r\n', '                    Today’s Business\r\n1.	Councilor Erica Sijesmundo mentioned the IRP of Sangguniang Kabataan and duly seconded by the majority.\r\n2.	Mentioned by Councilor Jackelyn Albor and duly seconded by all the members of the council.\r\n3.	It was mentioned by Councilor Rowelyn Saragena, to update the opening of bank account of Sangguniang Kabataan, Barangay, Sumaguan, Argao and it was duly seconded by the majority of the council.\r\n4.	Process for SK TIN Number was mentioned by SK Chairperson Kian S. Cabase, and duly seconded by the majority of the council .\r\n5.	The SK Chairperson mentioned that in the next session on February 3, 2024, we will be inviting Hon. Jerome Sarvida, the Councilor of Barangay Sumaguan. \r\n', '    After a thorough deliberation, no there is no more concerns being raised the motion to adjourned was made by SK Secretary Avegael Angel C. Saragena and was duly seconded by Hon. Jhon Paul Agarao at 1:08 pm. ', 'HANZEL A. AGARAO', 'Secretary', 'HON. KIAN S. CABASE', 'Chairperson', '2024-12-31 20:27:29', 1),
(2, 'DSDASD', '2025-01-02', '    SK Chairperson Hon. Kian Cabase called the meeting to order at 12:00 pm and continued to preside over the session. ', '          The invocation was done by SK Secretary Hanzel  A . Agarao, followed by the singing of the national anthem led by Hon. Cherielou S. Caspe. ', 'The SK secretary Hanzel A. Agarao called the names of the SK members as instructed by the SK chairperson, and since only one member of the Sangguniang Kabataan is absent, a quorum was declared present.', 'The SK Chairman read the approval of the previous minutes. The approval was only in processing for SK TIN Number', '1.	IRP (Internal Rules and Procedure)\r\n2.	Process requirements for Sangguniang Kabataan Fidelity Bond\r\n3.	Process for Sangguniang Kabataan Open Bank Account by the newly designated signatories\r\n4.	Process for SK TIN Number\r\n5.	Take a seat in the next session with Hon. Jerome Sarvida Barangay Councilor.\r\n', '                    Today’s Business\r\n1.	Councilor Erica Sijesmundo mentioned the IRP of Sangguniang Kabataan and duly seconded by the majority.\r\n2.	Mentioned by Councilor Jackelyn Albor and duly seconded by all the members of the council.\r\n3.	It was mentioned by Councilor Rowelyn Saragena, to update the opening of bank account of Sangguniang Kabataan, Barangay, Sumaguan, Argao and it was duly seconded by the majority of the council.\r\n4.	Process for SK TIN Number was mentioned by SK Chairperson Kian S. Cabase, and duly seconded by the majority of the council .\r\n5.	The SK Chairperson mentioned that in the next session on February 3, 2024, we will be inviting Hon. Jerome Sarvida, the Councilor of Barangay Sumaguan. \r\n', '    After a thorough deliberation, no there is no more concerns being raised the motion to adjourned was made by SK Secretary Avegael Angel C. Saragena and was duly seconded by Hon. Jhon Paul Agarao at 1:08 pm. ', 'HANZEL A. AGARAO', 'Secretary', 'HON. KIAN S. CABASE', 'Chairperson', '2025-01-02 12:42:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_attendees`
--

CREATE TABLE `meeting_attendees` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `attendance_status` enum('Present','Also Present','Absent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meeting_attendees`
--

INSERT INTO `meeting_attendees` (`id`, `meeting_id`, `name`, `position`, `attendance_status`, `created_at`) VALUES
(1, 1, 'Kim Ytac', 'SK Chairperson', 'Present', '2024-12-31 20:27:29'),
(2, 1, 'Kim Ytac', 'SK Councilor', 'Present', '2024-12-31 20:27:29'),
(3, 1, 'Kim Ytac', 'SK Councilor', 'Present', '2024-12-31 20:27:29'),
(4, 1, 'Kim Ytac', 'SK Councilor', 'Present', '2024-12-31 20:27:29'),
(5, 1, 'Kim Ytac', 'SK Councilor', 'Present', '2024-12-31 20:27:29'),
(6, 1, 'Kim Ytac', 'SK Councilor', 'Present', '2024-12-31 20:27:29'),
(7, 1, 'Kim Ytac', 'SK Secretary', 'Also Present', '2024-12-31 20:27:29'),
(8, 1, 'Kim Ytac', 'SK Treasurer', 'Also Present', '2024-12-31 20:27:29'),
(9, 1, 'Kim Ytac', 'SK Councilor', 'Absent', '2024-12-31 20:27:29'),
(10, 2, 'Mary Ann Ytac', 'SK Chairperson', 'Present', '2025-01-02 12:42:21'),
(11, 2, 'Mary Ann Ytac', 'SK Councilor', 'Present', '2025-01-02 12:42:21'),
(12, 2, 'Mary Ann Ytac', 'SK Councilor', 'Present', '2025-01-02 12:42:21'),
(13, 2, 'Mary Ann Ytac', 'SK Secretary', 'Also Present', '2025-01-02 12:42:21'),
(14, 2, 'Mary Ann Ytac', 'SK Treasurer', 'Also Present', '2025-01-02 12:42:21'),
(15, 2, 'Mary Ann Ytac', 'SK Councilor', 'Absent', '2025-01-02 12:42:21'),
(16, 2, 'Mary Ann Ytac', 'SK Councilor', 'Absent', '2025-01-02 12:42:21'),
(17, 2, 'Mary Ann Ytac', 'SK Councilor', 'Absent', '2025-01-02 12:42:21'),
(18, 2, 'Mary Ann Ytac', 'SK Councilor', 'Absent', '2025-01-02 12:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `pa_education`
--

CREATE TABLE `pa_education` (
  `id` int(11) NOT NULL,
  `calendar_year` int(11) NOT NULL,
  `reference_code` varchar(50) NOT NULL,
  `ppas` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expected_result` text NOT NULL,
  `performance_indicator` text NOT NULL,
  `period_of_implementation` varchar(50) NOT NULL,
  `mooe` decimal(15,2) NOT NULL,
  `co` decimal(15,2) DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `person_responsible` varchar(255) NOT NULL,
  `prepared_by_name` varchar(255) NOT NULL,
  `prepared_by_position` varchar(100) NOT NULL,
  `approved_by_name` varchar(255) NOT NULL,
  `approved_by_position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pa_education`
--

INSERT INTO `pa_education` (`id`, `calendar_year`, `reference_code`, `ppas`, `description`, `expected_result`, `performance_indicator`, `period_of_implementation`, `mooe`, `co`, `total`, `person_responsible`, `prepared_by_name`, `prepared_by_position`, `approved_by_name`, `approved_by_position`) VALUES
(1, 0, '', 'GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE', 'To provide essential educational supplies and support for students.', 'The students have the willingness to learn by providing by giving educational supplies and assistance', 'Increase number of pupils who are given by educational supplies and assistance', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(2, 0, '', 'GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE', 'To provide essential educational supplies and support for students.', 'The students have the willingness to learn by providing by giving educational supplies and assistance', 'Increase number of pupils who are given by educational supplies and assistance', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(3, 0, '', 'GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE', 'To provide essential educational supplies and support for students.', 'The students have the willingness to learn by providing by giving educational supplies and assistance', 'Increase number of pupils who are given by educational supplies and assistance', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(4, 0, '', 'GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE', 'asdasd', 'asdasd', 'asdasdsd', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(5, 0, '', 'GIVING OF EDUCATIONAL SUPPLIES AND ASSISTANCE', 'asdasd', 'asdasd', 'asdasdsd', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(6, 0, '', 'assad', 'asdasd', 'asdasd', 'asdasd', 'June', '0.00', '0.00', '0.00', 'SK Officials, Youth Leader, and Teachers', 'AVEGAEL ANGEL SARAGENA', 'Treasurer', 'KIAN S CABASE', 'Chairperson'),
(7, 0, '2022344', 'Trial ppa', 'trial', 'trial', 'trial', 'June', '0.00', '0.00', '0.00', 'Josh', 'JOSH DANIL', 'Secretary', 'HANZ ARCHER', 'Secretary'),
(8, 0, '2022344', 'Trial ppa', 'trial', 'trial', 'trial', 'June', '0.00', '0.00', '0.00', 'Josh', 'JOSH DANIL', 'Secretary', 'HANZ ARCHER', 'Secretary'),
(9, 0, '2022344', 'Trial ppa', 'trial', 'trial', 'trial', 'June', '0.00', '0.00', '0.00', 'Josh', 'JOSH DANIL', 'Secretary', 'HANZ ARCHER', 'Secretary'),
(10, 0, '8912839123', 'HHAHHSDUIDHSUIHD', 'uahwduhawudh', 'uhefuehfuweh', 'hfuehuwhfwuhf', 'May', '0.00', '0.00', '0.00', 'HANZ ARCHER', 'HABZ ARCHERR', 'Chairperson', 'HANZ ARCGER', 'Councilor'),
(11, 0, '8912839123', 'HHAHHSDUIDHSUIHD', 'uahwduhawudh', 'uhefuehfuweh', 'hfuehuwhfwuhf', 'May', '0.00', '0.00', '0.00', 'HANZ ARCHER', 'HABZ ARCHERR', 'Chairperson', 'HANZ ARCGER', 'Councilor'),
(12, 0, '8912839123', 'HHAHHSDUIDHSUIHD', 'uahwduhawudh', 'uhefuehfuweh', 'hfuehuwhfwuhf', 'May', '0.00', '0.00', '0.00', 'HANZ ARCHER', 'HABZ ARCHERR', 'Chairperson', 'HANZ ARCGER', 'Councilor'),
(13, 0, '4234234', 'Hanzhauhduashduawhd', 'duwhquhdqwuhd', 'uqwhduqwhdqwuhd', 'huqwdqhwudqwhduqw', 'February', '0.00', '0.00', '0.00', 'HA', 'HA', 'Treasurer', 'HA', 'Chairperson');

-- --------------------------------------------------------

--
-- Table structure for table `pa_health`
--

CREATE TABLE `pa_health` (
  `id` int(11) NOT NULL,
  `calendar_year` int(11) DEFAULT NULL,
  `reference_code` varchar(50) DEFAULT NULL,
  `PPAs` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expected_results` text DEFAULT NULL,
  `performance_indicator` text DEFAULT NULL,
  `period_of_implementation` varchar(100) DEFAULT NULL,
  `MOOE` decimal(10,2) DEFAULT NULL,
  `CO` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `person_responsible` varchar(100) DEFAULT NULL,
  `approved_by_name` varchar(100) DEFAULT NULL,
  `approved_by_position` varchar(100) DEFAULT NULL,
  `prepared_by_name` varchar(100) DEFAULT NULL,
  `prepared_by_position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pa_health`
--

INSERT INTO `pa_health` (`id`, `calendar_year`, `reference_code`, `PPAs`, `description`, `expected_results`, `performance_indicator`, `period_of_implementation`, `MOOE`, `CO`, `total`, `person_responsible`, `approved_by_name`, `approved_by_position`, `prepared_by_name`, `prepared_by_position`) VALUES
(1, 2024, NULL, 'FEEDING PROGRAM', 'To provide both educational and health benefits to the most vulnerable, children, thereby increasing enrollment rates, reducing absenteeism, and improving food security at the household level.', 'Include alleviating hunger, reducing micronutrient deficiency and anemia, preventing overweight and obesity and improving school enrollment.', 'Reduced level of malnutrition among targeted children.', 'July', '2000.00', NULL, '2000.00', 'Sangguniang Kabataan and Barangay Health Workers', 'KIAN S. CABASE', 'SK Chairperson', 'AVEGAEL ANGEL C. SARAGENA	', 'SK Treasurer');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sk_admin`
--

CREATE TABLE `sk_admin` (
  `AdminID` int(11) NOT NULL,
  `SK_ID` int(11) NOT NULL,
  `AdminUsername` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sk_admin`
--

INSERT INTO `sk_admin` (`AdminID`, `SK_ID`, `AdminUsername`, `password`) VALUES
(1, 2418, 'Chairman', '$2y$10$/o5yaz/fqsajw.cDPrzj5OPvgwCb7J8Pwy/2ZOOTXMm2fStdms.0e'),
(2, 2419, 'Councilor', '$2y$10$39ILpdGQSqQ4Gu/alVKQOuJNCk0yvIKaacTa30l3rWFV767O.NzAy'),
(3, 2407, 'Councilor', '$2y$10$V5EhBsPp26sYWL21B6GfD.urtiKuJVQh/bLyQyMOuKpoXCUhw6aDW');

-- --------------------------------------------------------

--
-- Table structure for table `sk_members`
--

CREATE TABLE `sk_members` (
  `ID` int(11) NOT NULL,
  `SK_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sk_members`
--

INSERT INTO `sk_members` (`ID`, `SK_ID`, `first_name`, `middle_name`, `last_name`, `birthdate`) VALUES
(1, 2401, 'Christian', 'Rosal', 'Abregana', '0000-00-00'),
(2, 2402, 'Mitchie An', 'Albo', 'Camento', '0000-00-00'),
(3, 2403, 'Clement', 'Flores', 'Aalcantara', '0000-00-00'),
(4, 2404, 'Doris John', 'Famat', 'Aligato', '0000-00-00'),
(5, 2405, 'Claudine', 'Ambrad', 'Amancio', '0000-00-00'),
(6, 2406, 'Viah Marie', 'Alberca', 'Amarillo', '0000-00-00'),
(7, 2407, 'Bryan', 'Delima', 'Antier', '0000-00-00'),
(8, 2408, 'Alyza', 'Tenebro', 'Antopina', '0000-00-00'),
(9, 2409, 'Kiro', 'De Leon', 'Basanal', '0000-00-00'),
(10, 2410, 'Ma.Jasce Nova', 'Enolba', 'Belia', '0000-00-00'),
(11, 2411, 'Ernesto Jr.', 'Reyes', 'Beltran', '0000-00-00'),
(12, 2412, 'Jamaiah Shane', 'Sarador', 'Cabigas', '0000-00-00'),
(13, 2413, 'Alyssa Nicklyn', 'Boyles', 'Camello', '0000-00-00'),
(14, 2415, 'Jayzon', 'Lanutan', 'Caololan', '0000-00-00'),
(15, 2416, 'Jhudiel Anthony', 'Sandoval', 'Carzano', '0000-00-00'),
(16, 2417, 'Alex Christian', 'Queroga', 'Casio', '0000-00-00'),
(17, 2418, 'Allan Christian', 'Quiroga', 'Casio', '0000-00-00'),
(18, 2419, 'Honzal Babe', 'Saltarin', 'Chavez', '0000-00-00'),
(19, 2420, 'Shelonie', 'Pantalita', 'Datuin', '0000-00-00'),
(20, 2421, 'Kent', 'Oblianda', 'Dayag', '0000-00-00'),
(21, 2422, 'John Ghendel', 'Amacna', 'De Los Santos', '0000-00-00'),
(22, 2423, 'Roel', 'Paspi', 'Dela Peña', '0000-00-00'),
(23, 2424, 'Matthew', 'Dizon', 'Delfin', '0000-00-00'),
(24, 2425, 'Jehn Clara Dhel', 'Ybañez', 'Delicano', '0000-00-00'),
(25, 2426, 'Mark Louil', 'Mamac', 'Diacamos', '0000-00-00'),
(26, 2427, 'Krystal Mae', 'Kilongkilong', 'Dicdican', '0000-00-00'),
(27, 2428, 'Ma. Angelica', 'Sanoy', 'Dichon', '0000-00-00'),
(28, 2429, 'Harvey Jeem', 'Montañez', 'Empinado', '0000-00-00'),
(29, 2430, 'Ma. Venalyn', 'Cantarona', 'Endona', '0000-00-00'),
(30, 2431, 'Jeans Smitch', 'Carzano', 'Enopia', '0000-00-00'),
(31, 2432, 'Laica', 'Cartesian', 'Ensiñalis', '0000-00-00'),
(32, 2433, 'Claison Mar', 'Gicale', 'Famor', '0000-00-00'),
(33, 2434, 'Stayve Alreach', 'Templa', 'Fedillaga', '0000-00-00'),
(34, 2435, 'Jovan', 'Ceballos', 'Felamin', '0000-00-00'),
(35, 2436, 'Justin Michael', 'Obiedo', 'Gaviola', '0000-00-00'),
(36, 2437, 'Mike Jofeb', 'Abuda', 'Gelig', '0000-00-00'),
(37, 2438, 'Kent Joseph', 'Arobo', 'Gesor', '0000-00-00'),
(38, 2439, 'Apolinario Jr.', 'Guiñarez', 'Glarian', '0000-00-00'),
(39, 2440, 'Ronzell', 'Laude', 'Go', '0000-00-00'),
(40, 2441, 'Jona Mae', 'Velarde', 'Laurente', '0000-00-00'),
(41, 2442, 'Lord Kiann', 'Quiroga', 'Macaraya', '0000-00-00'),
(42, 2443, 'Donna May', 'Valle', 'Magsucang', '0000-00-00'),
(43, 2444, 'Gabriel', 'Calvo', 'Mier', '0000-00-00'),
(44, 2445, 'Joan', 'Jabagat', 'Monceda', '0000-00-00'),
(45, 2446, 'Christy', 'Geyrozaga', 'Montejo', '0000-00-00'),
(46, 2447, 'Dan Guilliamp', 'Cuandot', 'Montenegro', '0000-00-00'),
(47, 2448, 'Edryl', 'Bug-ot', 'Moratas', '0000-00-00'),
(48, 2449, 'Jiesmera', 'Caropo', 'Omboy', '0000-00-00'),
(49, 2450, 'Judilyn', 'None', 'Pagtalonan', '0000-00-00'),
(50, 2451, 'Janlie', 'Geverola', 'Pantinople', '0000-00-00'),
(51, 2452, 'Jyra Anthonyth', 'Remando', 'Pantojan', '0000-00-00'),
(52, 2453, 'Rolando Jr.', 'Molleno', 'Parilla', '0000-00-00'),
(53, 2454, 'Jemarie', 'Yanong', 'Pebro', '0000-00-00'),
(54, 2455, 'Pearly', 'Lanticse', 'Rellon', '0000-00-00'),
(55, 2456, 'Ken', 'Rellin', 'Rocaberte', '0000-00-00'),
(56, 2457, 'Dee Jay', 'None', 'Rodriguez', '0000-00-00'),
(57, 2458, 'Aimee Jean', 'Bequizo', 'Rollon', '0000-00-00'),
(58, 2459, 'Cecelio I', 'Gelig', 'Rozada', '0000-00-00'),
(59, 2460, 'Francis Xavier', 'None', 'Sagarino', '0000-00-00'),
(60, 2461, 'Glaze', 'None', 'Sanchez', '0000-00-00'),
(61, 2462, 'Niño Michael', 'Gimena', 'Saragena', '0000-00-00'),
(62, 2463, 'Jerica Mae', 'Sarmiento', 'Sardido', '0000-00-00'),
(63, 2464, 'Jessa Mae', 'Langi', 'Sardido', '0000-00-00'),
(64, 2465, 'Joshua', 'Pacoin', 'Sardido', '0000-00-00'),
(65, 2466, 'Jeff Alain', 'Saquilon', 'Sarmago', '0000-00-00'),
(66, 2467, 'Bartt Johngil', 'Llanos', 'Sayago', '0000-00-00'),
(67, 2468, 'Mharion Jay', 'Peras', 'Sayson', '0000-00-00'),
(68, 2469, 'Kimberly', 'Indig', 'Silvano', '0000-00-00'),
(69, 2470, 'Junro', 'Cataytay', 'Tabanas', '0000-00-00'),
(70, 2471, 'John Benedick', '', 'Tabasa', '0000-00-00'),
(71, 2472, 'Kimberly Faith', 'Fajardo', 'Ytac', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion_and_feedback`
--

CREATE TABLE `suggestion_and_feedback` (
  `SF_ID` int(11) NOT NULL,
  `FormType` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `DateTime` datetime NOT NULL,
  `IsVisibleToUsers` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `upcoming_events`
--

CREATE TABLE `upcoming_events` (
  `UE_ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Date_of_Event` date NOT NULL,
  `DatePosted` date NOT NULL,
  `Venue` varchar(255) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_feedbacks`
--

CREATE TABLE `user_feedbacks` (
  `FeedbackID` int(11) NOT NULL,
  `SF_ID` int(11) NOT NULL,
  `SK_ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Feedbacks` text NOT NULL,
  `Rating` int(11) NOT NULL CHECK (`Rating` >= 1 and `Rating` <= 5),
  `DateSubmitted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_suggestions`
--

CREATE TABLE `user_suggestions` (
  `SuggestionID` int(11) NOT NULL,
  `SF_ID` int(11) NOT NULL,
  `SK_ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Suggestions` text NOT NULL,
  `DateSubmitted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountID`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`AnnouncementID`);

--
-- Indexes for table `archive_announcements`
--
ALTER TABLE `archive_announcements`
  ADD PRIMARY KEY (`AnnouncementID`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`AwardID`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`Budget_ID`);

--
-- Indexes for table `cbydp_pa_administration`
--
ALTER TABLE `cbydp_pa_administration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_agriculture`
--
ALTER TABLE `cbydp_pa_agriculture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_citizenship`
--
ALTER TABLE `cbydp_pa_citizenship`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_economic`
--
ALTER TABLE `cbydp_pa_economic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_education`
--
ALTER TABLE `cbydp_pa_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_governance`
--
ALTER TABLE `cbydp_pa_governance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_health`
--
ALTER TABLE `cbydp_pa_health`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_peace`
--
ALTER TABLE `cbydp_pa_peace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_social`
--
ALTER TABLE `cbydp_pa_social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cbydp_pa_sports`
--
ALTER TABLE `cbydp_pa_sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_id` (`meeting_id`);

--
-- Indexes for table `pa_education`
--
ALTER TABLE `pa_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pa_health`
--
ALTER TABLE `pa_health`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sk_admin`
--
ALTER TABLE `sk_admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `suggestion_and_feedback`
--
ALTER TABLE `suggestion_and_feedback`
  ADD PRIMARY KEY (`SF_ID`);

--
-- Indexes for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  ADD PRIMARY KEY (`UE_ID`);

--
-- Indexes for table `user_feedbacks`
--
ALTER TABLE `user_feedbacks`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `SF_ID` (`SF_ID`);

--
-- Indexes for table `user_suggestions`
--
ALTER TABLE `user_suggestions`
  ADD PRIMARY KEY (`SuggestionID`),
  ADD KEY `SF_ID` (`SF_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `AwardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `Budget_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cbydp_pa_administration`
--
ALTER TABLE `cbydp_pa_administration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_agriculture`
--
ALTER TABLE `cbydp_pa_agriculture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_citizenship`
--
ALTER TABLE `cbydp_pa_citizenship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_economic`
--
ALTER TABLE `cbydp_pa_economic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_education`
--
ALTER TABLE `cbydp_pa_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_governance`
--
ALTER TABLE `cbydp_pa_governance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_health`
--
ALTER TABLE `cbydp_pa_health`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_peace`
--
ALTER TABLE `cbydp_pa_peace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_social`
--
ALTER TABLE `cbydp_pa_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cbydp_pa_sports`
--
ALTER TABLE `cbydp_pa_sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pa_education`
--
ALTER TABLE `pa_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pa_health`
--
ALTER TABLE `pa_health`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_admin`
--
ALTER TABLE `sk_admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suggestion_and_feedback`
--
ALTER TABLE `suggestion_and_feedback`
  MODIFY `SF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `upcoming_events`
--
ALTER TABLE `upcoming_events`
  MODIFY `UE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_feedbacks`
--
ALTER TABLE `user_feedbacks`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_suggestions`
--
ALTER TABLE `user_suggestions`
  MODIFY `SuggestionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meeting_attendees`
--
ALTER TABLE `meeting_attendees`
  ADD CONSTRAINT `meeting_attendees_ibfk_1` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_feedbacks`
--
ALTER TABLE `user_feedbacks`
  ADD CONSTRAINT `user_feedbacks_ibfk_1` FOREIGN KEY (`SF_ID`) REFERENCES `suggestion_and_feedback` (`SF_ID`) ON DELETE CASCADE;

--
-- Constraints for table `user_suggestions`
--
ALTER TABLE `user_suggestions`
  ADD CONSTRAINT `user_suggestions_ibfk_1` FOREIGN KEY (`SF_ID`) REFERENCES `suggestion_and_feedback` (`SF_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
