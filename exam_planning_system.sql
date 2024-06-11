-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 09 Haz 2024, 20:31:59
-- Sunucu sürümü: 8.0.36
-- PHP Sürümü: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `exam_planning_system`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Assistants`
--

CREATE TABLE `Assistants` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `score` int DEFAULT '0',
  `faculty_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Assistants`
--

INSERT INTO `Assistants` (`id`, `name`, `department_id`, `score`, `faculty_id`) VALUES
(2, 'Assistant User', 1, 0, 1),
(7, 'Ahmet', 1, 6, 1),
(8, 'Ali', 1, 4, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `AssistantsCourses`
--

CREATE TABLE `AssistantsCourses` (
  `id` int NOT NULL,
  `assistant_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `AssistantsCourses`
--

INSERT INTO `AssistantsCourses` (`id`, `assistant_id`, `course_id`) VALUES
(1, 2, 1),
(2, 2, 1),
(3, 2, 1),
(4, 2, 1),
(5, 2, 1),
(6, 2, 3),
(7, 2, 2),
(8, 2, 1),
(9, 2, 1),
(10, 2, 2),
(11, 2, 3),
(12, 7, 1),
(13, 8, 4),
(14, 8, 1),
(15, 8, 1),
(16, 8, 3),
(17, 8, 1),
(18, 8, 5),
(19, 8, 1),
(20, 8, 1),
(21, 8, 3),
(22, 8, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `AssistantsExams`
--

CREATE TABLE `AssistantsExams` (
  `id` int NOT NULL,
  `assistant_id` int DEFAULT NULL,
  `exam_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `AssistantsExams`
--

INSERT INTO `AssistantsExams` (`id`, `assistant_id`, `exam_id`) VALUES
(1, 2, 2),
(2, 2, 3),
(3, 8, 2),
(4, 8, 4),
(5, 7, 6),
(6, 2, 6),
(7, 7, 7),
(8, 8, 7),
(9, 8, 8),
(10, 8, 8),
(11, 8, 8),
(12, 8, 8),
(13, 8, 9),
(14, 7, 8),
(15, 7, 16),
(16, 7, 16),
(17, 7, 16),
(18, 7, 16),
(19, 7, 16);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Courses`
--

CREATE TABLE `Courses` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `faculty_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Courses`
--

INSERT INTO `Courses` (`id`, `name`, `department_id`, `faculty_id`) VALUES
(1, 'CSE348', 1, 1),
(2, 'CSE331', NULL, NULL),
(3, 'CSE341', NULL, NULL),
(4, 'CSE351', 1, 1),
(5, 'CSE101', 1, 1),
(6, 'ES272', NULL, 1),
(9, 'ES200', NULL, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Departments`
--

CREATE TABLE `Departments` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Departments`
--

INSERT INTO `Departments` (`id`, `name`) VALUES
(1, 'Computer Engineering');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Employees`
--

CREATE TABLE `Employees` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('assistant','secretary','head_of_department','head_of_secretary','dean') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `faculty_id` int DEFAULT NULL,
  `department_id` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Employees`
--

INSERT INTO `Employees` (`id`, `username`, `password`, `role`, `name`, `faculty_id`, `department_id`) VALUES
(1, 'admin', '900150983cd24fb0d6963f7d28e17f72', 'dean', 'Admin User', NULL, 1),
(2, 'assistant_user', '900150983cd24fb0d6963f7d28e17f72', 'assistant', 'Assistant User', NULL, 1),
(3, 'secretary_user', '900150983cd24fb0d6963f7d28e17f72', 'secretary', 'Secretary User', NULL, 1),
(4, 'head_of_department_user', '900150983cd24fb0d6963f7d28e17f72', 'head_of_department', 'Head of Department User', NULL, 1),
(5, 'head_of_secretary_user', '900150983cd24fb0d6963f7d28e17f72', 'head_of_secretary', 'Head of Secretary User', NULL, 1),
(6, 'dean_user', '900150983cd24fb0d6963f7d28e17f72', 'dean', 'Dean User', NULL, 1),
(7, 'ahmet', '900150983cd24fb0d6963f7d28e17f72', 'assistant', 'Ahmet', NULL, 1),
(8, 'ali', '900150983cd24fb0d6963f7d28e17f72', 'assistant', 'Ali', NULL, 1);

--
-- Tetikleyiciler `Employees`
--
DELIMITER $$
CREATE TRIGGER `after_insert_assistant` AFTER INSERT ON `Employees` FOR EACH ROW BEGIN
    IF NEW.role = 'assistant' THEN
        INSERT INTO Assistants (id, name, department_id) VALUES (NEW.id, NEW.name, NULL);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Exams`
--

CREATE TABLE `Exams` (
  `id` int NOT NULL,
  `exam_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_time` time DEFAULT NULL,
  `num_classes` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `num_assistants` int DEFAULT '0',
  `faculty_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Exams`
--

INSERT INTO `Exams` (`id`, `exam_name`, `exam_date`, `exam_time`, `num_classes`, `department_id`, `course_id`, `num_assistants`, `faculty_id`) VALUES
(1, 'xxx', '2024-06-28', '11:11:00', 2, NULL, NULL, 0, NULL),
(2, 'aaa', '2024-06-13', '10:10:00', 3, NULL, NULL, 0, NULL),
(3, 'Midterm', '2024-06-27', '10:10:00', 2, 1, 1, 0, 1),
(4, 'alisınav', '2024-06-14', '10:00:00', 3, 1, 3, 0, 1),
(5, 'ahmetalisınav', '2024-06-21', '12:00:00', NULL, 1, 4, 0, 1),
(6, 'aliahmetsınav2', '2024-06-20', '12:00:00', 2, 1, 1, 2, 1),
(7, 'aliahmetsınav3', '2024-06-13', '12:00:00', 2, 1, 4, 2, 1),
(8, 'alisınav2', '2024-06-20', '10:00:00', 1, 1, 1, 1, 1),
(9, 'essınav1', '2024-06-20', '12:00:00', 1, NULL, 6, 1, 1),
(10, 'essinavyeni2', '2024-06-13', '09:00:00', 1, NULL, 6, 1, 1),
(16, 'essinav3', '2024-06-21', '10:00:00', 1, NULL, 6, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Faculties`
--

CREATE TABLE `Faculties` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Faculties`
--

INSERT INTO `Faculties` (`id`, `name`) VALUES
(1, 'Engineering'),
(3, 'Business');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Schedules`
--

CREATE TABLE `Schedules` (
  `id` int NOT NULL,
  `assistant_id` int DEFAULT NULL,
  `day` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `course_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Schedules`
--

INSERT INTO `Schedules` (`id`, `assistant_id`, `day`, `time`, `course_id`) VALUES
(1, 2, 'Monday', '09:00', 1),
(2, 2, 'Monday', '13:00', 1),
(3, 2, 'Monday', '09:00', 2),
(4, 2, 'Wednesday', '13:00', 3),
(5, 7, 'Monday', '09:00', 1),
(6, 8, 'Saturday', '09:00', 4),
(7, 8, 'Monday', '13:00', 1),
(8, 8, 'Monday', '14:00', 1),
(9, 8, 'Saturday', '09:00', 3),
(10, 8, 'Thursday', '09:00', 1),
(11, 8, 'Friday', '09:00', 5),
(12, 8, 'Monday', '09:00', 1),
(13, 8, 'Monday', '09:00', 1),
(14, 8, 'Tuesday', '09:00', 3),
(15, 8, 'Monday', '11:00', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `Assistants`
--
ALTER TABLE `Assistants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Tablo için indeksler `AssistantsCourses`
--
ALTER TABLE `AssistantsCourses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_id` (`assistant_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Tablo için indeksler `AssistantsExams`
--
ALTER TABLE `AssistantsExams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_id` (`assistant_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Tablo için indeksler `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Tablo için indeksler `Departments`
--
ALTER TABLE `Departments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `Employees`
--
ALTER TABLE `Employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Tablo için indeksler `Exams`
--
ALTER TABLE `Exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Tablo için indeksler `Faculties`
--
ALTER TABLE `Faculties`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `Schedules`
--
ALTER TABLE `Schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_id` (`assistant_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `Assistants`
--
ALTER TABLE `Assistants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `AssistantsCourses`
--
ALTER TABLE `AssistantsCourses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `AssistantsExams`
--
ALTER TABLE `AssistantsExams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `Courses`
--
ALTER TABLE `Courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `Departments`
--
ALTER TABLE `Departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `Employees`
--
ALTER TABLE `Employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `Exams`
--
ALTER TABLE `Exams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `Faculties`
--
ALTER TABLE `Faculties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `Schedules`
--
ALTER TABLE `Schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `Assistants`
--
ALTER TABLE `Assistants`
  ADD CONSTRAINT `assistants_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `Departments` (`id`);

--
-- Tablo kısıtlamaları `AssistantsCourses`
--
ALTER TABLE `AssistantsCourses`
  ADD CONSTRAINT `assistantscourses_ibfk_1` FOREIGN KEY (`assistant_id`) REFERENCES `Employees` (`id`),
  ADD CONSTRAINT `assistantscourses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`);

--
-- Tablo kısıtlamaları `AssistantsExams`
--
ALTER TABLE `AssistantsExams`
  ADD CONSTRAINT `assistantsexams_ibfk_1` FOREIGN KEY (`assistant_id`) REFERENCES `Employees` (`id`),
  ADD CONSTRAINT `assistantsexams_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `Exams` (`id`);

--
-- Tablo kısıtlamaları `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `Departments` (`id`);

--
-- Tablo kısıtlamaları `Exams`
--
ALTER TABLE `Exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `Departments` (`id`);

--
-- Tablo kısıtlamaları `Schedules`
--
ALTER TABLE `Schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`assistant_id`) REFERENCES `Employees` (`id`),
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
