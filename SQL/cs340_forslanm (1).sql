-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: classmysql.engr.oregonstate.edu:3306
-- Generation Time: Jun 06, 2018 at 02:57 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs340_forslanm`
--

-- --------------------------------------------------------

--
-- Table structure for table `Answer`
--

CREATE TABLE `Answer` (
  `AnswerID` int(11) NOT NULL,
  `Text` varchar(100) NOT NULL,
  `QID` int(11) NOT NULL,
  `Mood` int(11) NOT NULL,
  `Style` int(11) NOT NULL,
  `Humor` int(11) NOT NULL,
  `Woke` int(11) NOT NULL,
  `Crazy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Answer`
--

INSERT INTO `Answer` (`AnswerID`, `Text`, `QID`, `Mood`, `Style`, `Humor`, `Woke`, `Crazy`) VALUES
(321, 'Green', 1, 3, 4, 5, 6, 2),
(432, 'Blue', 1, 8, 8, 8, 9, 7),
(543, 'CS', 2, 2, 2, 2, 2, 2),
(654, 'Eggs', 3, 4, 5, 3, 2, 10),
(765, 'Beatles', 5, 10, 10, 10, 10, 10);

--
-- Triggers `Answer`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Answer` AFTER DELETE ON `Answer` FOR EACH ROW BEGIN
	DELETE FROM QuestionList WHERE AnswerID=old.AnswerID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `After_Update_Answer` AFTER UPDATE ON `Answer` FOR EACH ROW BEGIN
	IF (new.AnswerID != old.AnswerID) THEN
        UPDATE QuestionList
        SET AnswerID=new.AnswerID
        WHERE AnswerID=old.AnswerID;
    END IF;
    IF (new.QID != old.QID) THEN
    	UPDATE QuestionList
        SET QID=new.QID
        WHERE QID=old.QID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Insert_Answer` BEFORE INSERT ON `Answer` FOR EACH ROW BEGIN
	IF (new.QID != ALL (SELECT QID FROM Question)) THEN
		SIGNAL SQLSTATE '20000'
    	SET MESSAGE_TEXT = 'Constraint 20000: No question with that QID exists.';
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_Answer` BEFORE UPDATE ON `Answer` FOR EACH ROW BEGIN
	IF NOT EXISTS (SELECT QID FROM Question WHERE QID=new.QID) THEN
		SIGNAL SQLSTATE '20001'
    	SET MESSAGE_TEXT = 'Constraint 20001: No question with QID @old.QID exists.';
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Caption`
--

CREATE TABLE `Caption` (
  `CaptionID` int(11) NOT NULL,
  `MemeID` int(11) NOT NULL,
  `Mood` int(11) NOT NULL,
  `Style` int(11) NOT NULL,
  `Humor` int(11) NOT NULL,
  `Woke` int(11) NOT NULL,
  `Crazy` int(11) NOT NULL,
  `Text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Caption`
--

INSERT INTO `Caption` (`CaptionID`, `MemeID`, `Mood`, `Style`, `Humor`, `Woke`, `Crazy`, `Text`) VALUES
(1, 1, 9, 10, 3, 4, 8, 'When you had four bowls for breakfast and only one was cereal'),
(2, 2, 7, 6, 4, 0, 3, 'Her: What are Saturdays for?'),
(3, 3, 1, 2, 4, 5, 3, 'When you don\'t buy the book but find a pdf online'),
(4, 4, 6, 5, 7, 4, 3, 'Take home finals'),
(5, 5, 8, 4, 6, 7, 4, '\"You can\'t start the assignment the day before it\'s due\" \"TRY ME\"'),
(6, 1, 8, 4, 3, 1, 7, 'When you have 3 midterms in a week'),
(7, 1, 3, 3, 5, 9, 1, 'After coding for 6 hours straight'),
(8, 2, 11, 2, 3, 4, 5, 'When mom asks you to pause your online game'),
(9, 2, 8, 7, 6, 3, 5, 'Analysis of Algorithms'),
(10, 3, 4, 4, 4, 8, 1, 'Bonus fries'),
(11, 3, 1, 2, 4, 8, 16, 'I\'ll do the planning, you do the assignment, and you do the report'),
(12, 4, 1, 2, 3, 6, 7, 'Our ice cream machine is broken'),
(13, 5, 7, 7, 7, 7, 7, '*walking in front of beaver bus* \"HIT ME\"'),
(14, 5, 4, 6, 2, 3, 1, 'When a biker cuts you off');

--
-- Triggers `Caption`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Caption` AFTER DELETE ON `Caption` FOR EACH ROW BEGIN
	DELETE FROM Questionnaire WHERE CaptionID=old.CaptionID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `After_Update_Caption` AFTER UPDATE ON `Caption` FOR EACH ROW BEGIN
	IF (new.MemeID != old.MemeID) THEN
    	UPDATE Questionnaire
        SET MemeID=new.MemeID
        WHERE MemeID=old.MemeID;
    END IF;
    IF (new.CaptionID != old.CaptionID) THEN 
    	UPDATE Questionnaire
        SET CaptionID=new.CaptionID
        WHERE CaptionID=old.CaptionID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Insert_Caption` BEFORE INSERT ON `Caption` FOR EACH ROW BEGIN
	IF (new.MemeID != ALL (SELECT MemeID FROM Meme)) THEN
		SIGNAL SQLSTATE '10000'
    	SET MESSAGE_TEXT = 'Constraint: No meme with that MemeID exists.';
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_Caption` BEFORE UPDATE ON `Caption` FOR EACH ROW BEGIN
	IF (old.MemeID != ALL (SELECT MemeID FROM Meme)) THEN
		SIGNAL SQLSTATE '10001'
    	SET MESSAGE_TEXT = 'Constraint: No meme with that MemeID exists.';
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Meme`
--

CREATE TABLE `Meme` (
  `MemeID` int(11) NOT NULL,
  `Mood` int(11) NOT NULL,
  `Style` int(11) NOT NULL,
  `Humor` int(11) NOT NULL,
  `Woke` int(11) NOT NULL,
  `Crazy` int(11) NOT NULL,
  `Image_URL` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Meme`
--

INSERT INTO `Meme` (`MemeID`, `Mood`, `Style`, `Humor`, `Woke`, `Crazy`, `Image_URL`) VALUES
(1, 4, 5, 3, 5, 6, '\r\nhttp://i0.kym-cdn.com/photos/images/facebook/001/240/860/528.png'),
(2, 5, 8, 6, 8, 4, 'https://i.imgur.com/dLfPsSw.png'),
(3, 6, 7, 8, 3, 4, 'https://longreadsblog.files.wordpress.com/2016/07/donald-trump-book.jpg?w=1200'),
(4, 8, 7, 6, 9, 10, 'https://imgflip.com/s/meme/Third-World-Skeptical-Kid.jpg'),
(5, 4, 8, 7, 6, 3, 'https://pixel.nymag.com/imgs/daily/selectall/2018/04/05/amchop.w710.h473.jpg');

--
-- Triggers `Meme`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Meme` AFTER DELETE ON `Meme` FOR EACH ROW BEGIN
	DELETE FROM Caption WHERE MemeID=old.MemeID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_Meme` BEFORE UPDATE ON `Meme` FOR EACH ROW BEGIN
	IF (new.MemeID != old.MemeID) THEN
    	UPDATE Caption
        SET MemeID=new.MemeID
        WHERE MemeID=old.MemeID;
        UPDATE Questionnaire
        SET MemeID=new.MemeID
        WHERE MemeID=old.MemeID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Question`
--

CREATE TABLE `Question` (
  `QID` int(11) NOT NULL,
  `Text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Question`
--

INSERT INTO `Question` (`QID`, `Text`) VALUES
(1, 'What is your favorite color?'),
(2, 'What\'s your major?'),
(3, 'Eggs or oatmeal?'),
(4, 'Coffee or tea?'),
(5, 'Beatles or Rolling Stones?');

--
-- Triggers `Question`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Question` AFTER DELETE ON `Question` FOR EACH ROW BEGIN
	DELETE FROM Answer WHERE QID=old.QID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `After_Update_Question` AFTER UPDATE ON `Question` FOR EACH ROW BEGIN
	IF(new.QID != old.QID) THEN
		UPDATE Answer
        SET QID=new.QID
        WHERE QID=old.QID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `QuestionList`
--

CREATE TABLE `QuestionList` (
  `Username` varchar(40) NOT NULL,
  `QID` int(11) NOT NULL,
  `AnswerID` int(11) NOT NULL,
  `QuestionnaireID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `QuestionList`
--

INSERT INTO `QuestionList` (`Username`, `QID`, `AnswerID`, `QuestionnaireID`) VALUES
('alechayden', 1, 321, 0),
('burtonjaursch', 1, 432, 0),
('randomuser', 2, 543, 1),
('randomuser', 3, 654, 1),
('randomuser', 5, 765, 2);

--
-- Triggers `QuestionList`
--
DELIMITER $$
CREATE TRIGGER `Before_Insert_QuestionList` BEFORE INSERT ON `QuestionList` FOR EACH ROW BEGIN
	IF NOT EXISTS (SELECT * FROM Questionnaire Q WHERE Q.QuestionnaireID=new.QuestionnaireID AND Q.username=new.Username) THEN
		SIGNAL SQLSTATE '40000'
    	SET MESSAGE_TEXT = 'Constraint 40000: No questionnaire for that user at that time and date exists.';
	END IF;
    IF (new.QID != ALL (SELECT QID FROM Question)) THEN
		SIGNAL SQLSTATE '40001'
    	SET MESSAGE_TEXT = 'Constraint 40001: No question with that QID exists.';
	END IF;
    IF (new.AnswerID != ALL (SELECT AnswerID FROM Answer WHERE QID=new.QID)) THEN
		SIGNAL SQLSTATE '40002'
    	SET MESSAGE_TEXT = 'Constraint 40002: No answer for that question with that AnswerID exists.';
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_QuestionList` BEFORE UPDATE ON `QuestionList` FOR EACH ROW BEGIN
	IF NOT EXISTS (SELECT * FROM Questionnaire Q WHERE Q.QuestionnaireID=old.QuestionnaireID AND Q.username=old.Username) THEN
		SIGNAL SQLSTATE '40100'
    	SET MESSAGE_TEXT = 'Constraint 40100: No questionnaire for that user at that time and date exists.';
	END IF;
    IF NOT EXISTS (SELECT * FROM Question WHERE QID=new.QID) THEN
		SIGNAL SQLSTATE '40101'
    	SET MESSAGE_TEXT = 'Constraint 40101: No question with that QID exists.';
    ELSEIF NOT EXISTS (SELECT * FROM Answer WHERE AnswerID=new.AnswerID) THEN
		SIGNAL SQLSTATE '40102'
    	SET MESSAGE_TEXT = 'Constraint 40102: No answer for that question with that AnswerID exists.';
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Questionnaire`
--

CREATE TABLE `Questionnaire` (
  `username` varchar(40) NOT NULL,
  `MemeID` int(11) NOT NULL,
  `CaptionID` int(11) NOT NULL,
  `QuestionnaireID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Questionnaire`
--

INSERT INTO `Questionnaire` (`username`, `MemeID`, `CaptionID`, `QuestionnaireID`) VALUES
('alechayden', 1, 1, 0),
('burtonjaursch', 2, 2, 0),
('randomuser', 3, 3, 0),
('randomuser', 4, 4, 1),
('randomuser', 5, 5, 2);

--
-- Triggers `Questionnaire`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_Questionairre` AFTER DELETE ON `Questionnaire` FOR EACH ROW BEGIN
	DELETE FROM QuestionList 
    WHERE QuestionnaireID=old.QuestionnaireID AND Username=old.Username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `After_Update_Questionnaire` AFTER UPDATE ON `Questionnaire` FOR EACH ROW BEGIN
    UPDATE QuestionList Q
    SET Q.QuestionnaireID=new.QuestionnaireID, Q.Username=new.Username
    WHERE Q.QuestionnaireID=old.QuestionnaireID AND Q.Username=old.Username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Insert_Questionnaire` BEFORE INSERT ON `Questionnaire` FOR EACH ROW BEGIN
	IF (new.Username != ALL (SELECT Username FROM User)) THEN
		SIGNAL SQLSTATE '30000'
    	SET MESSAGE_TEXT = 'Constraint: No user with that Username exists.';
	END IF;
    IF EXISTS (SELECT * FROM Questionnaire WHERE Username=new.Username AND QuestionnaireID=new.QuestionnaireID) THEN
    	SIGNAL SQLSTATE '30100'
        SET MESSAGE_TEXT = 'Constraint: That user has already taken a questionnaire at that time.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_Questionnaire` BEFORE UPDATE ON `Questionnaire` FOR EACH ROW BEGIN
	IF (new.Username != old.Username OR 
        new.QuestionnaireID != old.QuestionnaireID) THEN
		IF (new.Username != ALL (SELECT Username FROM User)) THEN
			SIGNAL SQLSTATE '30001'
    		SET MESSAGE_TEXT = 'Constraint: No user with that Username exists.';
		END IF;
	    IF EXISTS (SELECT * FROM Questionnaire Q WHERE Username=new.Username AND Q.QuestionnaireID=new.QuestionnaireID) THEN
    		SIGNAL SQLSTATE '30101'
    	    SET MESSAGE_TEXT = 'Constraint: That user has already taken a questionnaire at that time.';
    	END IF;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Search`
--

CREATE TABLE `Search` (
  `username` varchar(40) NOT NULL,
  `Entry` varchar(100) NOT NULL,
  `Results` varchar(100) NOT NULL,
  `Time` time NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Search`
--

INSERT INTO `Search` (`username`, `Entry`, `Results`, `Time`, `Date`) VALUES
('alechayden', 'computer', 'computer meme', '02:05:40', '2018-05-04'),
('benwindheim', 'sad', 'sad meme', '11:30:31', '2018-05-13'),
('burtonjaursch', 'databases', 'database meme', '12:45:21', '2018-05-01'),
('mattforsland', 'dank meme', 'dank meme, really dank meme', '13:17:14', '2017-02-20'),
('benwindheim', 'funny', 'good meme, quality meme', '23:45:23', '2018-04-20');

--
-- Triggers `Search`
--
DELIMITER $$
CREATE TRIGGER `Before_Insert_Search` BEFORE INSERT ON `Search` FOR EACH ROW BEGIN
	IF NOT EXISTS (SELECT * FROM User WHERE username=new.Username) THEN
    	SIGNAL SQLSTATE '50000'
        SET MESSAGE_TEXT = 'Constraint 50000: No user with that username exists.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Before_Update_Search` BEFORE UPDATE ON `Search` FOR EACH ROW BEGIN
	IF NOT EXISTS (SELECT * FROM User WHERE username=new.Username) THEN
    	SIGNAL SQLSTATE '50001'
        SET MESSAGE_TEXT = 'Constraint 50001: No user with that username exists.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `Username` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`Username`, `Email`, `Password`) VALUES
('alechayden', 'haydena@oregonstate.edu', 'cs340alec'),
('benwindheim', 'windheib@oregonstate.edu', 'cs340ben'),
('burtonjaursch', 'jaurschb@oregonstate.edu', 'cs340burton'),
('mattforsland', 'forslanm@oregonstate.edu', 'cs340matt'),
('randomuser', 'gmail@gmail.com', 'uniquepassword');

--
-- Triggers `User`
--
DELIMITER $$
CREATE TRIGGER `After_Delete_User` AFTER DELETE ON `User` FOR EACH ROW BEGIN
	DELETE FROM Questionnaire WHERE Username=old.Username;
	DELETE FROM Search WHERE Username=old.Username;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Answer`
--
ALTER TABLE `Answer`
  ADD PRIMARY KEY (`AnswerID`,`QID`);

--
-- Indexes for table `Caption`
--
ALTER TABLE `Caption`
  ADD PRIMARY KEY (`CaptionID`,`MemeID`);

--
-- Indexes for table `Meme`
--
ALTER TABLE `Meme`
  ADD PRIMARY KEY (`MemeID`);

--
-- Indexes for table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`QID`);

--
-- Indexes for table `QuestionList`
--
ALTER TABLE `QuestionList`
  ADD PRIMARY KEY (`Username`,`QID`,`AnswerID`);

--
-- Indexes for table `Questionnaire`
--
ALTER TABLE `Questionnaire`
  ADD PRIMARY KEY (`username`,`QuestionnaireID`);

--
-- Indexes for table `Search`
--
ALTER TABLE `Search`
  ADD PRIMARY KEY (`Time`,`Date`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Username`,`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
