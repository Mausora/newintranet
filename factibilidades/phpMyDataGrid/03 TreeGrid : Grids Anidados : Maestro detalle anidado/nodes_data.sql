CREATE DATABASE  IF NOT EXISTS `guru_sample_a` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `guru_sample_a`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: localhost    Database: guru_sample_a
-- ------------------------------------------------------
-- Server version	5.1.36-community-log

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
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT NULL,
  `fname` varchar(20) NOT NULL,
  `minit` char(1) DEFAULT NULL,
  `lname` varchar(30) NOT NULL,
  `job_id` smallint(6) NOT NULL DEFAULT '1',
  `job_lvl` tinyint(4) NOT NULL DEFAULT '10',
  `pub_id` char(4) NOT NULL DEFAULT '9952',
  `birth_date` date DEFAULT NULL,
  `hire_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `consecutivo` int(11) DEFAULT NULL,
  `photo` char(130) DEFAULT NULL,
  `salary` float DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `total_salary` float DEFAULT NULL,
  `afiliation_date` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `notes` text,
  `pass` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`emp_id`),
  KEY `pub_id` (`pub_id`),
  KEY `job_id` (`job_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (37,0,'Updating inline','T','Smithers',2,127,'9952','1980-09-10','2000-01-02 05:30:02',9,'images.jpg',40000,45,60000,1007960400,'ccramer@strident.com','0  ','fbc71ce36cc20790f2eeed2197898e71'),(3,1,'Andres','K','Devons',3,127,'9952','2008-05-12','2000-01-02 05:30:02',5,'image1.jpg',14000,15,7000,1009688400,'annie@hotmail.com','0 ','fbc71ce36cc20790f2eeed2197898e71'),(10,0,'Luis','<','Chang',4,127,'9952','1980-02-20','2000-01-02 05:30:02',6,'images.jpg',50000,15,25000,1009688400,'changuito@hongkong.com','',NULL),(20,1,'Mark','A','Lebihan',5,127,'0736','1974-02-02','2000-01-02 05:30:02',2,'simpsons_saint_seiya_fan_art_by.jpg',50000,15,25000,1009688400,'lal@lebihan.com',NULL,NULL),(43,1,'William','K','Ottlieb',5,127,'1389','1987-01-01','2000-01-02 05:30:02',3,'todos_simpsons.jpg',30000,20,10000,1009688400,'ottsvendy@hotmail.com',NULL,NULL),(40,0,'Alfredo','B','Mullera',5,127,'1622',NULL,'2000-01-02 05:30:02',7,'todos_simpsons.jpg',15000,10,5000,1009688400,NULL,NULL,NULL),(28,1,'Camilo','J','Pontes',5,127,'1756',NULL,'2000-01-02 05:30:02',8,NULL,8000,10,2400,1009688400,NULL,NULL,NULL),(16,0,'Victor','Y','Labrune',5,127,'9901',NULL,'2000-01-02 05:30:02',9,'simpsons_saint_seiya_fan_art_by_edwheeler.jpg',10000,9,3000,1009688400,NULL,NULL,NULL),(5,1,'Alicia','F','Hernandez',5,127,'9999','1978-01-12','2000-01-02 05:30:02',10,'todos_simpsons.jpg',10000,10,1666.67,1009688400,NULL,NULL,NULL),(45,0,'Laura','P','Ashworth',0,127,'0877',NULL,'2000-01-02 05:30:02',11,NULL,25000,10,8333.33,1009688400,NULL,NULL,NULL),(19,0,'Sandra','','Brown',7,120,'0877',NULL,'2000-01-02 05:30:02',12,NULL,15000,15,7500,1009688400,NULL,NULL,NULL),(4,0,'Billy','R','Dominguez',8,100,'0877','1976-03-19','2000-01-02 05:30:02',13,'simpsons_saint_seiya_fan_art_by.jpg',30000,15,15000,1009688400,NULL,NULL,NULL),(23,1,'Carlos','','Rance',9,75,'0877',NULL,'2000-01-02 05:30:02',14,NULL,5000,15,2500,1009688400,NULL,NULL,NULL),(32,1,'Carlos','H','Franken',10,75,'0877',NULL,'2000-01-02 05:30:02',15,NULL,3000,30,3000,1009688400,NULL,NULL,NULL),(7,1,'Carlos','B','Tonini',11,75,'0877','1975-09-24','2000-01-02 05:30:02',16,NULL,5000,10,1666.67,1009688400,NULL,NULL,NULL),(13,1,'Carlos','','Bennett',12,35,'0877',NULL,'2000-01-02 05:30:02',17,NULL,8000,15,4000,1009688400,NULL,NULL,NULL),(33,0,'Carlos','M','Accorti',13,35,'0877',NULL,'2000-01-02 05:30:02',18,NULL,15000,10,5000,1009688400,NULL,NULL,NULL),(9,0,'Carlos','N','Lincoln',14,35,'0877','1945-11-20','2000-01-02 05:30:02',19,NULL,15000,15,7500,1009688400,NULL,NULL,NULL),(27,0,'Carlos','G','Karttunen',6,127,'0736',NULL,'2000-01-02 05:30:02',20,NULL,25000,15,12500,1009688400,NULL,NULL,NULL),(31,0,'Carlos','D','Ibsen',7,127,'0736',NULL,'2000-01-02 05:30:02',21,NULL,15000,10,NULL,1009688400,NULL,NULL,NULL),(29,0,'Carlos','M','Saveley',8,127,'0736',NULL,'2000-01-02 05:30:02',22,NULL,12000,10,NULL,1009688400,NULL,NULL,NULL),(12,1,'Carlos','H','Thomas',9,127,'0736',NULL,'2000-01-02 05:30:02',23,NULL,20000,10,NULL,1009688400,NULL,NULL,NULL),(26,0,'Carlos','F','Sommer',10,127,'0736',NULL,'2000-01-02 05:30:02',24,NULL,12000,10,NULL,1009688400,NULL,NULL,NULL),(39,0,'Carlos','','Mendel',11,127,'0736',NULL,'2000-01-02 05:30:02',25,NULL,15000,10,NULL,1009688400,NULL,NULL,NULL),(15,0,'Carlos','A','Snyder',12,100,'0736',NULL,'2000-01-02 05:30:02',26,NULL,20000,10,NULL,1009688400,NULL,NULL,NULL),(44,0,'Carlos','P','O\'Rourke',13,100,'0736',NULL,'2000-01-02 05:30:02',27,NULL,18000,10,NULL,1009688400,NULL,NULL,NULL),(17,0,'Carlos','F','Josephs',14,100,'0736',NULL,'2000-01-02 05:30:02',28,NULL,15000,10,NULL,1009688400,NULL,NULL,NULL),(8,0,'Carlos','W','Roel',6,127,'1389','1979-02-25','2000-01-02 05:30:02',29,NULL,30000,20,NULL,1009688400,NULL,NULL,NULL),(21,0,'Carlos','','Larsson',7,127,'1389',NULL,'2000-01-02 05:30:02',30,NULL,12000,2,NULL,1009688400,NULL,NULL,NULL),(41,0,'Carlos','S','Parente',8,125,'1389',NULL,'2000-01-02 05:30:02',31,NULL,11000,1,NULL,1009688400,NULL,NULL,NULL),(25,0,'Carlos','A','Smith',9,78,'1389',NULL,'2000-01-02 05:30:02',32,NULL,19000,1,NULL,1009688400,NULL,NULL,NULL),(1,1,'Carlos','','Cruz',10,87,'1389','1977-12-24','2000-01-02 05:30:02',33,'http://s3.amazonaws.com/twitter_production/profile_images/104835847/photo_normal.jpg',18000,0,NULL,1009688400,NULL,NULL,NULL),(24,0,'Carlos','A','Paolino',11,112,'1389',NULL,'2000-01-02 05:30:02',34,NULL,17000,20,NULL,1009688400,NULL,NULL,NULL),(36,0,'Carlos','','Latimer',12,32,'1389',NULL,'2000-01-02 05:30:02',35,NULL,18000,2,NULL,1009688400,NULL,NULL,NULL),(6,0,'Carlos','G','Schmitt',13,64,'1389','1981-01-01','2000-01-02 05:30:02',36,NULL,20000,12,NULL,1009688400,NULL,NULL,NULL),(35,0,'Carlos','S','Afonso',14,89,'1389',NULL,'2000-01-02 05:30:02',37,NULL,13000,10,NULL,1009688400,NULL,NULL,NULL),(2,0,'Carlos','','Roulet',6,127,'9999','1976-01-01','2000-01-02 05:30:02',38,'http://s3.amazonaws.com/twitter_production/profile_images/104835847/photo_normal.jpg',25000,12,10000,1009688400,NULL,NULL,NULL),(14,0,'Carlos','A','Nagy',7,120,'9999',NULL,'2000-01-02 05:30:02',39,NULL,18000,12,NULL,1009688400,NULL,NULL,NULL),(22,0,'Carlos','','Pereira',8,101,'9999',NULL,'2000-01-02 05:30:02',40,NULL,16000,2,NULL,1009688400,NULL,NULL,NULL),(18,0,'Carlos','J','Jablonski',9,127,'9999',NULL,'2000-01-02 05:30:02',41,NULL,23000,12,NULL,1009688400,NULL,NULL,NULL),(34,0,'Carlos','O','Koskitalo',10,80,'9999',NULL,'2000-01-02 05:30:02',42,NULL,15000,12,NULL,1009688400,NULL,NULL,NULL),(30,0,'Carlos','C','McKenna',11,127,'9999',NULL,'2000-01-02 05:30:02',43,NULL,14000,21,NULL,1009688400,NULL,NULL,NULL),(42,0,'Carlos','a','Alvarez',1,10,'9952','2008-04-17','2000-01-02 05:30:02',44,NULL,20000,21,NULL,1009688400,NULL,NULL,NULL),(91,0,'Carlos','A','Arcila',1,10,'9952','1975-09-24','2000-01-02 05:30:02',46,NULL,13500,NULL,NULL,1009688400,NULL,NULL,NULL),(96,0,'Carlos','A','Arcila',1,10,'9952','1975-09-24','2008-11-12 01:09:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(98,0,'Carlos','P','Ashworth',1,10,'9952','0000-00-00','2008-11-12 01:22:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(99,NULL,'Carlos','','',1,10,'9952','0000-00-00','0000-00-00 00:00:00',NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL),(100,NULL,'Carlos','','',1,10,'9952','0000-00-00','0000-00-00 00:00:00',NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL),(101,NULL,'Carlos','','',1,10,'9952','0000-00-00','0000-00-00 00:00:00',NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL),(102,NULL,'asdasd','a','asdasdasd',1,10,'9952','2009-01-02','2009-03-11 14:08:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(105,0,'aeqweqwe','a','a',1,10,'9952','0000-00-00','2009-10-13 19:36:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,0,'sads asd','a','asdsad',1,10,'9952','0000-00-00','2009-10-19 15:22:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'<p>wdasasdsad<strong>asdasdsad<em>asdasdsad<span style=\\\"text-decoration: underline;\\\">asdsadsad</span></em></strong></p>',NULL);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_history`
--

DROP TABLE IF EXISTS `payment_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` char(9) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_history`
--

LOCK TABLES `payment_history` WRITE;
/*!40000 ALTER TABLE `payment_history` DISABLE KEYS */;
INSERT INTO `payment_history` VALUES (1,'93','2008-01-30',450),(2,'93','2008-01-30',450),(3,'93','2008-01-30',450),(4,'93','2008-01-30',450),(5,'93','2008-01-30',450),(6,'91','2008-02-15',500),(7,'91','2008-03-15',500),(8,'91','2008-04-15',523.85),(9,'91','2008-05-15',512.21),(10,'45','2007-11-30',300),(11,'45','2007-12-30',300),(12,'45','2008-10-13',500),(13,'93','2008-10-13',432),(14,'103','2009-07-22',441),(15,'103','2009-07-30',21),(16,'103','2009-07-24',54),(17,'102','2009-07-22',4300),(18,'102','2009-07-22',4300),(19,'102','2009-07-22',4300),(20,'106','2010-09-15',1001),(22,'106','2010-09-23',3000);
/*!40000 ALTER TABLE `payment_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_details`
--

DROP TABLE IF EXISTS `payment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` char(9) DEFAULT NULL,
  `detail` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_details`
--

LOCK TABLES `payment_details` WRITE;
/*!40000 ALTER TABLE `payment_details` DISABLE KEYS */;
INSERT INTO `payment_details` VALUES (1,'20','Salary',1201),(2,'20','Social Security',200),(3,'22','Un detalle cualquiera',3000);
/*!40000 ALTER TABLE `payment_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-09-23  0:01:36
