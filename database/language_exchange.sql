-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 10:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `language_exchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(23) NOT NULL,
  `username` varchar(23) NOT NULL,
  `email` varchar(23) NOT NULL,
  `password` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'pascaline', 'ingabirepascaline45@gma', 'pascaline123');

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `AvailabilityID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `DayOfWeek` varchar(15) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`AvailabilityID`, `UserID`, `DayOfWeek`, `StartTime`, `EndTime`) VALUES
(1, 1, 'Monday', '08:00:00', '16:00:00'),
(2, 2, 'Tuesday', '09:00:00', '17:00:00'),
(3, 3, 'Wednesday', '10:00:00', '18:00:00'),
(4, 3, 'Sunday', '02:32:00', '02:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` int(11) NOT NULL,
  `OrganizerID` int(11) DEFAULT NULL,
  `LanguageID` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `DateScheduled` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exchangesessions`
--

CREATE TABLE `exchangesessions` (
  `SessionID` int(11) NOT NULL,
  `OrganizerID` int(11) DEFAULT NULL,
  `LanguageID` int(11) DEFAULT NULL,
  `DateScheduled` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exchangesessions`
--

INSERT INTO `exchangesessions` (`SessionID`, `OrganizerID`, `LanguageID`, `DateScheduled`, `StartTime`, `EndTime`, `Location`, `Description`) VALUES
(1, 1, 1, '2024-05-10', '10:00:00', '12:00:00', 'Virtual', 'Introduction to Language Exchange.'),
(2, 2, 1, '2024-05-02', '02:38:00', '04:35:00', 'nyabihu', 'introduction to computer language');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FeedbackText` text DEFAULT NULL,
  `FeedbackTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `UserID`, `FeedbackText`, `FeedbackTime`) VALUES
(1, 3, 'This is a sample feedback text.', '2024-05-06 10:30:00'),
(2, 1, 'you are good customer', '1970-01-13 01:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `LanguageID` int(11) NOT NULL,
  `LanguageName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`LanguageID`, `LanguageName`) VALUES
(1, 'kinyarwanda'),
(2, 'spanish'),
(3, 'espanyol');

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `OrganizerID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OrganizerName` varchar(100) NOT NULL,
  `OrganizerEmail` varchar(255) DEFAULT NULL,
  `OrganizerPhone` varchar(20) DEFAULT NULL,
  `OrganizerBio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`OrganizerID`, `UserID`, `OrganizerName`, `OrganizerEmail`, `OrganizerPhone`, `OrganizerBio`) VALUES
(1, 1, 'John Doe', 'john.doe@example.com', '+1234567890', 'Bio of John Doe, the organizer.'),
(2, 2, 'gentille', 'gentille@gmail.com', '0785780088', 'gentille,the organizer'),
(5, 1, 'louise', 'lulu@gmail.com', '0789090345678', 'lulu is a good organizer');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `ParticipantID` int(11) NOT NULL,
  `SessionID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`ParticipantID`, `SessionID`, `UserID`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`PaymentID`, `UserID`, `Amount`, `PaymentDate`, `PaymentMethod`, `Description`) VALUES
(1, 1, 50.00, '2024-05-06', 'Credit Card', 'Online purchase'),
(2, 2, 75.00, '2024-05-05', 'PayPal', 'Subscription renewal'),
(3, 2, 80.00, '2024-04-05', 'online payment', 'transaction of selling');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ProfileID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `NativeLanguage` varchar(50) DEFAULT NULL,
  `LearningLanguage` varchar(50) DEFAULT NULL,
  `DateJoined` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ProfileID`, `UserID`, `FullName`, `Age`, `Gender`, `NativeLanguage`, `LearningLanguage`, `DateJoined`) VALUES
(1, 3, 'pascalineingabire', 22, '0', 'kinyarwanda', 'english', '2024-06-04');

-- --------------------------------------------------------

--
-- Table structure for table `resourcesharing`
--

CREATE TABLE `resourcesharing` (
  `ResourceID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `ResourceContent` varchar(255) NOT NULL,
  `DateShared` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resourcesharing`
--

INSERT INTO `resourcesharing` (`ResourceID`, `UserID`, `Title`, `Description`, `ResourceContent`, `DateShared`) VALUES
(1, 1, 'Sample Title', 'This is a sample description', 'SampleContent', '2024-05-06'),
(2, 2, 'importance', 'resource importane', 'window content', '2024-05-01'),
(3, 1, 'introduction to computer', 'gatsata ', 'memberes of gatsata', '2024-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `ReviewerID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReviewDate` date DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `ReviewText` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewers`
--

INSERT INTO `reviewers` (`ReviewerID`, `UserID`, `ReviewDate`, `Rating`, `ReviewText`) VALUES
(1, 2, '2024-05-04', 2, 'you are my sunshine love you'),
(2, 3, '2024-05-02', 2, 'thank you for help me'),
(3, 2, '2024-05-02', 6, 'hello my name is ingabire');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `name` varchar(12) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `native_language` varchar(12) NOT NULL,
  `learning_language` varchar(12) NOT NULL,
  `preferred_language` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `Email`, `Password`, `native_language`, `learning_language`, `preferred_language`) VALUES
(1, 'pacc', 'pacc@12gmail.com', '123', 'english', 'british', 'kinyarwanda'),
(2, 'emmy', 'nepo@gmail.com.com', '456', 'french', 'british', 'spanish'),
(3, 'fideline', 'fidel@gmail.com.com', '789', 'swahili', 'british', 'icyarabu'),
(4, 'ishimwe', 'ish@gmail.com', 'ni1ish12', 'kinyarwanda', 'spanish', 'French'),
(5, 'ingabire', 'ingabirepascaline45@gmail.com', 'ingabire4', 'swahili', 'british', 'spanish'),
(7, 'nita', 'inga@3', '222006249', 'english', 'english', 'French'),
(8, 'pascaline', 'ingabirepascaline45@gmail.com', 'ingabire4', 'british', 'spanish', 'French'),
(9, 'pascaline', 'ingabirepascaline45@gmail.com', 'ingabire123', 'kinyarwanda', 'english', 'Spanish'),
(10, 'aimediane', 'aime@gmail.com', 'aime', 'english', 'spanish', 'French'),
(11, 'nita', 'ni@2', 'ni12', 'kinyarwanda', 'english', 'Spanish'),
(12, '', '', '', '', '', ''),
(13, '', '', '', '', '', ''),
(16, 'Paccy', 'inga@1', '222006249', 'english', 'english', 'English'),
(17, '', '', '', '', '', ''),
(18, '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`AvailabilityID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `OrganizerID` (`OrganizerID`),
  ADD KEY `LanguageID` (`LanguageID`);

--
-- Indexes for table `exchangesessions`
--
ALTER TABLE `exchangesessions`
  ADD PRIMARY KEY (`SessionID`),
  ADD KEY `OrganizerID` (`OrganizerID`),
  ADD KEY `LanguageID` (`LanguageID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`LanguageID`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`OrganizerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`ParticipantID`),
  ADD KEY `SessionID` (`SessionID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ProfileID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `resourcesharing`
--
ALTER TABLE `resourcesharing`
  ADD PRIMARY KEY (`ResourceID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`ReviewerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `AvailabilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exchangesessions`
--
ALTER TABLE `exchangesessions`
  MODIFY `SessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `LanguageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `OrganizerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `ParticipantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `ProfileID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resourcesharing`
--
ALTER TABLE `resourcesharing`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `ReviewerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`OrganizerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`LanguageID`) REFERENCES `languages` (`LanguageID`);

--
-- Constraints for table `exchangesessions`
--
ALTER TABLE `exchangesessions`
  ADD CONSTRAINT `exchangesessions_ibfk_1` FOREIGN KEY (`OrganizerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `exchangesessions_ibfk_2` FOREIGN KEY (`LanguageID`) REFERENCES `languages` (`LanguageID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `organizer`
--
ALTER TABLE `organizer`
  ADD CONSTRAINT `organizer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`SessionID`) REFERENCES `exchangesessions` (`SessionID`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `resourcesharing`
--
ALTER TABLE `resourcesharing`
  ADD CONSTRAINT `resourcesharing_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD CONSTRAINT `reviewers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
