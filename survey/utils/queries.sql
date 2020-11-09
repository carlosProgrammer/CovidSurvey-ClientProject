SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-05:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_db`
--
CREATE DATABASE IF NOT EXISTS `survey_db` DEFAULT CHARACTER SET utf32 COLLATE utf32_general_ci;
USE `survey_db`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `age` text NOT NULL,
  `gender` text NOT NULL,
  `race` text NOT NULL,
  `county` text NOT NULL,
  `role` text NOT NULL,
  `affected` text NOT NULL,
  `effect` text NOT NULL,
  `measure` text NOT NULL,
  `test` text NOT NULL,
  `howMany` int(11) NOT NULL,
  `user_condition` text NOT NULL,
  `comments` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `option_content` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_content`, `question_id`) VALUES
(1, '10-15', 1),
(2, '16-20', 1),
(3, '21-28', 1),
(4, '29-45', 1),
(5, '46-60', 1),
(6, '60 or above', 1),
(7, 'Male', 2),
(8, 'Female', 2),
(9, 'Other', 2),
(10, 'Harris', 4),
(11, 'Galveston', 4),
(12, 'Fort Bend', 4),
(13, 'Chambers', 4),
(14, 'Brazoria', 4),
(15, 'Austin', 4),
(16, 'Liberty', 4),
(17, 'Montgomery', 4),
(18, 'Waller', 4),
(19, 'Other', 4),
(20, 'Student', 5),
(21, 'Teacher', 5),
(22, 'Health-care provider', 5),
(23, 'Business owner', 5),
(24, 'Other', 5),
(25, 'Highly', 6),
(26, 'Moderately', 6),
(27, 'Slightly', 6),
(28, 'No effect', 6),
(29, 'Financial', 7),
(30, 'Family', 7),
(31, 'Education', 7),
(32, 'Health', 7),
(33, 'Wearing mask', 8),
(34, 'Social distancing', 8),
(35, 'Working from home', 8),
(36, 'Sanitization', 8),
(37, 'Monitoring your health', 8),
(38, 'None', 8),
(39, 'Yes', 9),
(40, 'No', 9),
(41, 'Fully Recovered', 11),
(42, 'Still affected', 11),
(43, 'Untimely demise', 11);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`) VALUES
(1, 'Select your age group'),
(2, 'Select your gender'),
(3, 'Race'),
(4, 'Select the county you live in'),
(5, 'Which options best describes your role?'),
(6, 'How deeply has covid-19 affected you?'),
(7, 'In what way has covid-19 affected you? (select all that apply)'),
(8, 'what measures are you taking to prevent from covid-19? (select all that apply)'),
(9, 'Were you or your family tested positive for covid-19?'),
(10, 'if yes, how many?'),
(11, 'What are the conditions of the people infected by covid-19?'),
(12, 'Any comments or suggestions?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `fk_question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
