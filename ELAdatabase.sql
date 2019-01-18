-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ela
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assessment`
--

DROP TABLE IF EXISTS `assessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assessment` (
  `ExamID` int(11) NOT NULL AUTO_INCREMENT,
  `ClassHistoryID` int(5) DEFAULT NULL,
  `Date` date NOT NULL,
  `ClassSize` int(2) DEFAULT NULL,
  PRIMARY KEY (`ExamID`),
  KEY `Assessment_ClassHistoryID_fk` (`ClassHistoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment`
--

LOCK TABLES `assessment` WRITE;
/*!40000 ALTER TABLE `assessment` DISABLE KEYS */;
/*!40000 ALTER TABLE `assessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `BookID` int(11) NOT NULL AUTO_INCREMENT,
  `ExamID` int(5) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `NumberOfQuestions` int(3) DEFAULT NULL,
  `BookNumber` int(2) DEFAULT NULL,
  `Grade` int(2) DEFAULT NULL,
  `Year` date DEFAULT NULL,
  PRIMARY KEY (`BookID`),
  KEY `Book_ExamID_fk` (`ExamID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `choices`
--

DROP TABLE IF EXISTS `choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `choices` (
  `ChoiceID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionID` int(5) DEFAULT NULL,
  `Letter` varchar(1) NOT NULL,
  `Text` varchar(50) NOT NULL,
  PRIMARY KEY (`ChoiceID`),
  KEY `Questions_QuestionID_FK` (`QuestionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `choices`
--

LOCK TABLES `choices` WRITE;
/*!40000 ALTER TABLE `choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `ClassID` int(11) NOT NULL AUTO_INCREMENT,
  `TeacherID` int(5) DEFAULT NULL,
  `Grade` int(2) DEFAULT NULL,
  `ClassYear` int(4) DEFAULT NULL,
  `Size` int(2) DEFAULT NULL,
  PRIMARY KEY (`ClassID`),
  KEY `Class_TeacherID_fk` (`TeacherID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classhistory`
--

DROP TABLE IF EXISTS `classhistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classhistory` (
  `ClassHistoryID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` int(5) DEFAULT NULL,
  KEY `ClassHistory_ClassHistoryID_fk` (`ClassHistoryID`),
  KEY `ClassHistory_StudentID_fk` (`StudentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classhistory`
--

LOCK TABLES `classhistory` WRITE;
/*!40000 ALTER TABLE `classhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `classhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `StoryID` int(5) DEFAULT NULL,
  `CorrectAnswer` varchar(1) NOT NULL,
  `QuestionType` varchar(1) NOT NULL,
  `Points` int(1) NOT NULL,
  `Std` int(1) NOT NULL,
  `QuestionText` varchar(255) NOT NULL,
  `Indicator` varchar(1) NOT NULL,
  `Evidence` varchar(50) DEFAULT NULL,
  `KeyWords` varchar(100) DEFAULT NULL,
  `QuestionNumber` int(11) NOT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `Story_StoryID_FK` (`StoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `SchoolID` int(11) NOT NULL AUTO_INCREMENT,
  `School_Name` varchar(80) DEFAULT NULL,
  `Address` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`SchoolID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story`
--

DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `story` (
  `StoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(90) DEFAULT NULL,
  `Style` varchar(30) DEFAULT NULL,
  `Author` varchar(40) DEFAULT NULL,
  `Age` int(3) DEFAULT NULL,
  `TotalWordCount` int(4) DEFAULT NULL,
  `UniqueWordCount` int(3) DEFAULT NULL,
  PRIMARY KEY (`StoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story`
--

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL AUTO_INCREMENT,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  PRIMARY KEY (`StudentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentanswers`
--

DROP TABLE IF EXISTS `studentanswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentanswers` (
  `AnswerID` int(11) NOT NULL AUTO_INCREMENT,
  `ExamID` int(5) NOT NULL,
  `QuestionID` int(5) NOT NULL,
  `QuestionNumber` int(3) NOT NULL,
  `LetterAnswer` varchar(1) NOT NULL,
  PRIMARY KEY (`AnswerID`),
  KEY `Exam_ExamID_FK` (`ExamID`),
  KEY `Question_QuestionID_FK` (`QuestionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentanswers`
--

LOCK TABLES `studentanswers` WRITE;
/*!40000 ALTER TABLE `studentanswers` DISABLE KEYS */;
/*!40000 ALTER TABLE `studentanswers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `TeacherID` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolID` int(5) DEFAULT NULL,
  `UserID` int(5) DEFAULT NULL,
  PRIMARY KEY (`TeacherID`),
  KEY `Teacher_SchoolID_fk` (`SchoolID`),
  KEY `Teacher_UserID_fk` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `useraccount` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolID` int(5) DEFAULT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `AccountType` varchar(20) DEFAULT NULL,
  `RecoveryPassword` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `UserAccount_SchoolID_fk` (`SchoolID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `useraccount`
--

LOCK TABLES `useraccount` WRITE;
/*!40000 ALTER TABLE `useraccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `useraccount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wordfrequency`
--

DROP TABLE IF EXISTS `wordfrequency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wordfrequency` (
  `WordFreqID` int(11) NOT NULL AUTO_INCREMENT,
  `StoryID` int(5) NOT NULL,
  `Word` varchar(45) NOT NULL,
  `Frequency` int(4) NOT NULL,
  PRIMARY KEY (`WordFreqID`),
  KEY `Story_StoryID_FK` (`StoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wordfrequency`
--

LOCK TABLES `wordfrequency` WRITE;
/*!40000 ALTER TABLE `wordfrequency` DISABLE KEYS */;
/*!40000 ALTER TABLE `wordfrequency` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-25 15:14:49
