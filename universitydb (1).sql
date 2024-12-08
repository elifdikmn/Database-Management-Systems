-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 May 2024, 11:24:42
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `universitydb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `InstructorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`CourseID`, `CourseName`, `DepartmentID`, `InstructorID`) VALUES
(1, 'cse 348', 1, 2),
(2, 'CSE 344', 2, 2),
(3, 'CSE 354', 1, 2),
(5, 'CSE 351', 1, 2),
(6, 'ES 272', 2, 1),

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `department`
--

CREATE TABLE `department` (
  `DepartmentID` NOT NULL,
  `DepartmentName` NOT NULL,
  `FacultyID`  DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `department`
--

INSERT INTO `department` (`DepartmentID`, `DepartmentName`, `FacultyID`) VALUES
(1, 'Computer Engineering', 1),
(2, 'Web Development', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `employee`
--

CREATE TABLE `employee` (
  `EmployeeID`  NOT NULL,
  `FirstName`  NOT NULL,
  `LastName`  NOT NULL,
  `username` text NOT NULL,
  `password`  NOT NULL,
  `Email`  NOT NULL,
  `Phone`  DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `employee`
--

INSERT INTO `employee` (`EmployeeID`, `FirstName`, `LastName`, `username`, `password`, `Email`, `Phone`, `Title`, `DepartmentID`) VALUES
(1, 'admin', 'gulsah', 'selcuk', '123', 'gulsahselcuk@yeditepe.edu.tr', '01', 'Assistant', 1),
(2, 'Selçuk', 'Kerem', 'perente', '123', 'keremperente@yeditepe.edu.tr', '02', 'Assistant', 1),
(3, 'irem', 'ünlü', 'irem', '123', 'iremunlu@gmail.com', '03', 'Secretary', 1),
(4, 'aaa', 'gurkan', 'kucuk', '123', 'gurhankucuk@yeditepe.edu.tr', '04', 'Head of Department', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exam`
--

CREATE TABLE `exam` (
  `ExamID` ) NOT NULL,
  `ExamName` text DEFAULT NULL,
  `ExamDate` date NOT NULL,
  `time` time DEFAULT NULL,
  `CourseID`  DEFAULT NULL,
  `InstructorID` DEFAULT NULL,
  `DepartmentID`  DEFAULT NULL,
  `FacultyID`  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `exam`
--

INSERT INTO `exam` (`ExamID`, `ExamName`, `ExamDate`, `time`, `CourseID`, `InstructorID`, `DepartmentID`, `FacultyID`) VALUES
(1, 'Vize', '2024-06-03', '09:30:00', 3, 2, 1, 1),
(3, 'MidTerm', '2024-05-26', '18:20:00', 1, 1, 1, 1),
(20, 'Demo', '2024-05-10', '12:12:00', 2, 2, 1, 0),
(21, 'Project ', '2024-05-09', '12:32:00', 1, 2, 1, 0),
(22, '348 Final ', '2024-05-09', '12:32:00', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faculty`
--

CREATE TABLE `faculty` (
  `FacultyID`  NOT NULL,
  `FacultyName`  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `FacultyName`) VALUES
(1, 'Engineering Faculty');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `weeklyplan`
--

CREATE TABLE `weeklyplan` (
  `PlanID` int(11) NOT NULL,
  `CourseID` int(11) DEFAULT NULL,
  `ExamID` int(11) DEFAULT NULL,
  `AssistantID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `weeklyplan`
--

INSERT INTO `weeklyplan` (`PlanID`, `CourseID`, `ExamID`, `AssistantID`) VALUES
(1, 1, 1, 2),
(4, 2, 20, 2),
(5, 1, 21, 2),
(7, 5, 22, 1),
(8, 6, NULL, 1),
(9, 15, NULL, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `DepartmentID` (`DepartmentID`),
  ADD KEY `InstructorID` (`InstructorID`);

--
-- Tablo için indeksler `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD KEY `FacultyID` (`FacultyID`);

--
-- Tablo için indeksler `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD KEY `DepartmentID` (`DepartmentID`);

--
-- Tablo için indeksler `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`ExamID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `InstructorID` (`InstructorID`);

--
-- Tablo için indeksler `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FacultyID`);

--
-- Tablo için indeksler `weeklyplan`
--
ALTER TABLE `weeklyplan`
  ADD PRIMARY KEY (`PlanID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `ExamID` (`ExamID`),
  ADD KEY `AssistantID` (`AssistantID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `department`
--
ALTER TABLE `department`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `employee`
--
ALTER TABLE `employee`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `exam`
--
ALTER TABLE `exam`
  MODIFY `ExamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `faculty`
--
ALTER TABLE `faculty`
  MODIFY `FacultyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `weeklyplan`
--
ALTER TABLE `weeklyplan`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`InstructorID`) REFERENCES `employee` (`EmployeeID`);

--
-- Tablo kısıtlamaları `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`);

--
-- Tablo kısıtlamaları `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `department` (`DepartmentID`);

--
-- Tablo kısıtlamaları `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `exam_ibfk_2` FOREIGN KEY (`InstructorID`) REFERENCES `employee` (`EmployeeID`);

--
-- Tablo kısıtlamaları `weeklyplan`
--
ALTER TABLE `weeklyplan`
  ADD CONSTRAINT `weeklyplan_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `weeklyplan_ibfk_2` FOREIGN KEY (`ExamID`) REFERENCES `exam` (`ExamID`),
  ADD CONSTRAINT `weeklyplan_ibfk_3` FOREIGN KEY (`AssistantID`) REFERENCES `employee` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
