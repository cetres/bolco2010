-- MySQL dump 10.13  Distrib 5.1.44, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: bolco
-- ------------------------------------------------------
-- Server version	5.1.44

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
-- Table structure for table `bwin`
--

DROP TABLE IF EXISTS `bwin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bwin` (
  `bw_jogo` smallint(5) unsigned NOT NULL,
  `bw_data` date NOT NULL,
  `bw_time1` float unsigned NOT NULL,
  `bw_time2` float unsigned NOT NULL,
  `bw_empate` float unsigned NOT NULL,
  PRIMARY KEY (`bw_jogo`,`bw_data`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bwin`
--

LOCK TABLES `bwin` WRITE;
/*!40000 ALTER TABLE `bwin` DISABLE KEYS */;
INSERT INTO `bwin` VALUES (2,'2010-05-24',3.9,2,3.1),(1,'2010-05-24',2.8,2.55,3),(4,'2010-05-24',3.2,2.3,3),(3,'2010-05-24',1.53,5.75,4),(5,'2010-05-24',1.5,6.5,3.8),(6,'2010-05-24',3.4,2.15,3.1),(8,'2010-05-24',2.25,3.2,3.1),(7,'2010-05-24',1.45,6.5,4.2),(9,'2010-05-24',1.65,5,3.6),(10,'2010-05-24',3.6,2.05,3.2),(11,'2010-05-24',1.78,4.75,3.25),(12,'2010-05-24',7,1.42,4.25),(13,'2010-05-24',2.95,2.35,3.2),(14,'2010-05-24',1.08,19.5,9.75),(15,'2010-05-24',5.25,1.6,3.75),(16,'2010-05-24',1.33,8.5,4.75),(17,'2010-05-24',3.1,2.25,3.2),(20,'2010-05-24',1.34,9,4.5),(19,'2010-05-24',3,2.35,3.1),(18,'2010-05-24',2,3.75,3.2),(21,'2010-05-24',1.72,4.75,3.5),(22,'2010-05-24',3.2,2.15,3.3),(23,'2010-05-24',1.25,12.5,5),(25,'2010-05-24',1.4,7.5,4.33),(24,'2010-05-24',2.25,3.1,3.2),(26,'2010-05-24',2.6,2.6,3.2),(27,'2010-05-24',3.9,1.95,3.25),(28,'2010-05-24',1.12,15,8.25),(29,'2010-05-24',1.62,5,3.8),(30,'2010-05-24',1.14,15.5,7.25),(31,'2010-05-24',2.25,3,3.3),(32,'2010-05-24',1.16,13.5,7),(34,'2010-05-24',1.7,5,3.4),(33,'2010-05-24',2.6,2.6,3.2),(36,'2010-05-24',5.5,1.57,3.9),(35,'2010-05-24',1.91,3.9,3.3),(37,'2010-05-24',7,1.45,4.1),(38,'2010-05-24',1.72,4.75,3.5),(40,'2010-05-24',3.4,2.1,3.2),(39,'2010-05-24',4.75,1.7,3.5),(42,'2010-05-24',1.31,8.5,5),(41,'2010-05-24',6,1.55,3.75),(44,'2010-05-24',4.5,1.72,3.6),(43,'2010-05-24',2.2,3.2,3.2),(46,'2010-05-24',13,1.18,6.5),(45,'2010-05-24',3.8,1.85,3.6),(47,'2010-05-24',5.5,1.55,4),(48,'2010-05-24',1.72,4.5,3.6),(1,'2010-06-02',2.7,2.55,3.15),(2,'2010-06-02',3.9,1.91,3.3),(4,'2010-06-02',2.8,2.55,3),(3,'2010-06-02',1.45,7,4),(5,'2010-06-02',1.4,7.5,4.25),(6,'2010-06-02',3,2.3,3.2),(8,'2010-06-02',2.1,3.4,3.2),(7,'2010-06-02',1.45,6.75,4.05),(9,'2010-06-02',1.58,5.65,3.65),(10,'2010-06-02',3.65,2,3.25),(11,'2010-06-02',1.78,4.75,3.2),(12,'2010-06-02',7.5,1.38,4.45),(13,'2010-06-02',3.05,2.25,3.2),(14,'2010-06-02',1.08,19.5,9.75),(15,'2010-06-02',5.6,1.55,3.85),(16,'2010-06-02',1.25,11,5.25),(17,'2010-06-02',3.05,2.25,3.2),(20,'2010-06-02',1.3,10,4.75),(19,'2010-06-02',3,2.3,3.2),(18,'2010-06-02',1.9,3.95,3.3),(21,'2010-06-02',1.75,4.3,3.6),(22,'2010-06-02',3.05,2.25,3.25),(23,'2010-06-02',1.22,11,5.75),(25,'2010-06-02',1.35,8.5,4.5),(24,'2010-06-02',2.25,3.1,3.2),(26,'2010-06-02',2.6,2.6,3.2),(27,'2010-06-02',3.55,2,3.3),(28,'2010-06-02',1.12,15,8.25),(29,'2010-06-02',1.62,5,3.8),(30,'2010-06-02',1.14,15.5,7.25),(31,'2010-06-02',2.05,3.45,3.3),(32,'2010-06-02',1.16,13.5,7),(34,'2010-06-02',1.7,4.75,3.5),(33,'2010-06-02',2.6,2.6,3.2),(36,'2010-06-02',6.5,1.5,3.8),(35,'2010-06-02',1.9,3.95,3.3),(37,'2010-06-02',8.5,1.35,4.5),(38,'2010-06-02',1.8,4.5,3.3),(40,'2010-06-02',3.4,2.1,3.2),(39,'2010-06-02',4.75,1.7,3.5),(42,'2010-06-02',1.3,8.75,5),(41,'2010-06-02',6.05,1.55,3.65),(44,'2010-06-02',4.5,1.72,3.6),(43,'2010-06-02',2,3.65,3.25),(46,'2010-06-02',12,1.18,6.5),(45,'2010-06-02',4.15,1.8,3.5),(47,'2010-06-02',5.5,1.55,4),(48,'2010-06-02',1.72,4.5,3.6),(1,'2010-06-05',2.8,2.5,3.1),(2,'2010-06-05',3.6,2.05,3.2),(4,'2010-06-05',2.8,2.55,3),(3,'2010-06-05',1.4,7.5,4.25),(5,'2010-06-05',1.42,7.5,4.1),(6,'2010-06-05',3.55,2.05,3.2),(8,'2010-06-05',2.05,3.7,3.1),(7,'2010-06-05',1.4,7.75,4.2),(9,'2010-06-05',1.5,6.5,3.9),(10,'2010-06-05',3.6,2.05,3.2),(11,'2010-06-05',1.88,4.25,3.2),(12,'2010-06-05',7.75,1.4,4.25),(13,'2010-06-05',3.7,2,3.25),(14,'2010-06-05',1.08,26,8.5),(15,'2010-06-05',6,1.55,3.75),(16,'2010-06-05',1.25,12.5,5),(17,'2010-06-05',2.9,2.4,3.1),(20,'2010-06-05',1.3,10.5,4.6),(19,'2010-06-05',2.95,2.4,3.1),(18,'2010-06-05',2,3.9,3.1),(21,'2010-06-05',1.78,4.5,3.4),(22,'2010-06-05',3.2,2.2,3.2),(23,'2010-06-05',1.22,12.5,5.5),(25,'2010-06-05',1.37,8.25,4.4),(24,'2010-06-05',2.25,3.2,3.1),(26,'2010-06-05',2.65,2.6,3.1),(27,'2010-06-05',3.7,2,3.25),(28,'2010-06-05',1.14,18.5,6.75),(29,'2010-06-05',1.5,6.25,4),(30,'2010-06-05',1.14,18.5,6.75),(31,'2010-06-05',2.15,3.25,3.25),(32,'2010-06-05',1.14,18.5,6.75),(34,'2010-06-05',1.75,4.75,3.4),(33,'2010-06-05',2.6,2.6,3.2),(36,'2010-06-05',6,1.5,4),(35,'2010-06-05',1.91,4,3.25),(37,'2010-06-05',7.75,1.4,4.2),(38,'2010-06-05',1.8,4.5,3.3),(40,'2010-06-05',3.3,2.15,3.2),(39,'2010-06-05',5,1.67,3.5),(42,'2010-06-05',1.3,10,4.75),(41,'2010-06-05',6.25,1.53,3.75),(44,'2010-06-05',4.75,1.75,3.4),(43,'2010-06-05',2,3.7,3.25),(46,'2010-06-05',10,1.3,4.75),(45,'2010-06-05',4.1,1.8,3.6),(47,'2010-06-05',6,1.5,4),(48,'2010-06-05',1.7,4.75,3.5),(1,'2010-06-06',2.8,2.5,3.1),(2,'2010-06-06',3.6,2.05,3.2),(4,'2010-06-06',2.8,2.55,3),(3,'2010-06-06',1.4,7.5,4.25),(5,'2010-06-06',1.42,7.5,4.1),(6,'2010-06-06',3.55,2.05,3.2),(8,'2010-06-06',2.05,3.7,3.1),(7,'2010-06-06',1.4,7.75,4.2),(9,'2010-06-06',1.5,6.5,3.9),(10,'2010-06-06',3.6,2.05,3.2),(11,'2010-06-06',1.88,4.25,3.2),(12,'2010-06-06',7.75,1.4,4.25),(13,'2010-06-06',3.7,2,3.25),(14,'2010-06-06',1.08,26,8.5),(15,'2010-06-06',6,1.55,3.75),(16,'2010-06-06',1.25,12.5,5),(17,'2010-06-06',2.9,2.4,3.1),(20,'2010-06-06',1.3,10.5,4.6),(19,'2010-06-06',2.95,2.4,3.1),(18,'2010-06-06',2,3.9,3.1),(21,'2010-06-06',1.78,4.5,3.4),(22,'2010-06-06',3.2,2.2,3.2),(23,'2010-06-06',1.22,12.5,5.5),(25,'2010-06-06',1.37,8.25,4.4),(24,'2010-06-06',2.25,3.2,3.1),(26,'2010-06-06',2.65,2.6,3.1),(27,'2010-06-06',3.7,2,3.25),(28,'2010-06-06',1.14,18.5,6.75),(29,'2010-06-06',1.5,6.25,4),(30,'2010-06-06',1.14,18.5,6.75),(31,'2010-06-06',2.15,3.25,3.25),(32,'2010-06-06',1.14,18.5,6.75),(34,'2010-06-06',1.75,4.75,3.4),(33,'2010-06-06',2.6,2.6,3.2),(36,'2010-06-06',6,1.5,4),(35,'2010-06-06',1.91,4,3.25),(37,'2010-06-06',7.75,1.4,4.2),(38,'2010-06-06',1.8,4.5,3.3),(40,'2010-06-06',3.3,2.15,3.2),(39,'2010-06-06',5,1.67,3.5),(42,'2010-06-06',1.3,10,4.75),(41,'2010-06-06',6.25,1.53,3.75),(44,'2010-06-06',4.75,1.75,3.4),(43,'2010-06-06',2,3.7,3.25),(46,'2010-06-06',10,1.3,4.75),(45,'2010-06-06',4.1,1.8,3.6),(47,'2010-06-06',6,1.5,4),(48,'2010-06-06',1.7,4.75,3.5),(48,'2010-06-09',1.7,4.75,3.5),(47,'2010-06-09',6,1.5,4),(45,'2010-06-09',4.1,1.8,3.6),(46,'2010-06-09',10,1.3,4.75),(43,'2010-06-09',2,3.7,3.25),(44,'2010-06-09',4.75,1.75,3.4),(41,'2010-06-09',6.25,1.53,3.75),(42,'2010-06-09',1.3,10,4.75),(39,'2010-06-09',5,1.67,3.5),(40,'2010-06-09',3.3,2.15,3.2),(38,'2010-06-09',1.8,4.5,3.3),(37,'2010-06-09',7.75,1.4,4.2),(35,'2010-06-09',1.91,4,3.25),(36,'2010-06-09',6,1.5,4),(33,'2010-06-09',2.6,2.6,3.2),(34,'2010-06-09',1.75,4.75,3.4),(32,'2010-06-09',1.14,18.5,6.75),(31,'2010-06-09',2.15,3.25,3.25),(30,'2010-06-09',1.14,18.5,6.75),(29,'2010-06-09',1.5,6.25,4),(28,'2010-06-09',1.14,18.5,6.75),(27,'2010-06-09',3.7,2,3.25),(26,'2010-06-09',2.65,2.6,3.1),(24,'2010-06-09',2.25,3.2,3.1),(25,'2010-06-09',1.37,8.25,4.4),(23,'2010-06-09',1.22,12.5,5.5),(22,'2010-06-09',3.2,2.2,3.2),(21,'2010-06-09',1.78,4.5,3.4),(18,'2010-06-09',2,3.9,3.1),(19,'2010-06-09',2.95,2.4,3.1),(20,'2010-06-09',1.3,10.5,4.6),(17,'2010-06-09',2.9,2.4,3.1),(16,'2010-06-09',1.25,12.5,5),(15,'2010-06-09',6,1.55,3.75),(14,'2010-06-09',1.08,26,8.5),(13,'2010-06-09',3.7,2,3.25),(12,'2010-06-09',7.75,1.4,4.25),(11,'2010-06-09',1.88,4.25,3.2),(10,'2010-06-09',3.6,2.05,3.2),(9,'2010-06-09',1.48,6.5,4),(7,'2010-06-09',1.4,7.75,4.2),(8,'2010-06-09',2.05,3.7,3.1),(6,'2010-06-09',3.55,2.05,3.2),(5,'2010-06-09',1.42,7.5,4.1),(3,'2010-06-09',1.4,7.5,4.25),(4,'2010-06-09',2.8,2.55,3),(2,'2010-06-09',3.6,2.05,3.2),(1,'2010-06-09',2.75,2.55,3.1),(23,'2010-06-15',1.22,12.5,5.5),(22,'2010-06-15',3.6,2.05,3.2),(21,'2010-06-15',1.5,6,4),(18,'2010-06-15',2.2,3.4,3),(19,'2010-06-15',4.1,1.91,3.2),(20,'2010-06-15',1.4,7.75,4.2),(17,'2010-06-15',3.1,2.4,2.95),(16,'2010-06-15',1.22,13.5,5.25),(15,'2010-06-15',6.25,1.55,3.6),(25,'2010-06-15',1.35,9,4.4),(24,'2010-06-15',1.91,4,3.25),(26,'2010-06-15',2.9,2.35,3.25),(27,'2010-06-15',4.25,1.9,3.1),(28,'2010-06-15',1.14,15,7.25),(29,'2010-06-15',1.55,6,3.7),(30,'2010-06-15',1.25,12.5,5),(31,'2010-06-15',2.3,3.1,3.1),(32,'2010-06-15',1.14,18.5,6.75),(34,'2010-06-15',1.83,4.33,3.3),(33,'2010-06-15',2.65,2.6,3.1),(36,'2010-06-15',9,1.35,4.4),(35,'2010-06-15',2.3,3.1,3.1),(37,'2010-06-15',8,1.4,4.1),(38,'2010-06-15',1.67,5.25,3.5),(40,'2010-06-15',3.6,2,3.3),(39,'2010-06-15',5.75,1.55,3.9),(42,'2010-06-15',1.3,10,4.75),(41,'2010-06-15',6.25,1.53,3.75),(44,'2010-06-15',4.75,1.7,3.5),(43,'2010-06-15',2.2,3.3,3.1),(46,'2010-06-15',9.5,1.35,4.25),(45,'2010-06-15',4.5,1.8,3.3),(47,'2010-06-15',6,1.5,4),(48,'2010-06-15',1.7,4.75,3.5),(7,'2010-06-13',1.48,6.75,3.9),(9,'2010-06-13',1.48,6.5,4),(10,'2010-06-13',3.6,2.05,3.2),(11,'2010-06-13',2.05,3.65,3.1),(12,'2010-06-13',7.75,1.4,4.25),(13,'2010-06-13',3.6,2,3.3),(14,'2010-06-13',1.08,26,8.5),(15,'2010-06-13',6,1.55,3.75),(16,'2010-06-13',1.25,12.5,5),(17,'2010-06-13',3.2,2.25,3.1),(20,'2010-06-13',1.38,8.25,4.25),(19,'2010-06-13',4.1,1.91,3.2),(18,'2010-06-13',2.1,3.6,3.1),(22,'2010-06-13',3.6,2.05,3.2),(23,'2010-06-13',1.22,12.5,5.5),(25,'2010-06-13',1.37,8.25,4.4),(26,'2010-06-13',2.65,2.6,3.1),(27,'2010-06-13',3.7,2,3.25),(28,'2010-06-13',1.14,18.5,6.75),(29,'2010-06-13',1.5,6.25,4),(30,'2010-06-13',1.14,18.5,6.75),(31,'2010-06-13',2.15,3.25,3.25),(32,'2010-06-13',1.14,18.5,6.75),(34,'2010-06-13',1.83,4.33,3.3),(33,'2010-06-13',2.65,2.6,3.1),(36,'2010-06-13',9,1.35,4.4),(35,'2010-06-13',2.3,3.1,3.1),(37,'2010-06-13',8.75,1.37,4.25),(38,'2010-06-13',1.67,5.25,3.5),(42,'2010-06-13',1.3,10,4.75),(41,'2010-06-13',6.25,1.53,3.75),(44,'2010-06-13',4.75,1.75,3.4),(43,'2010-06-13',2,3.7,3.25),(46,'2010-06-13',10,1.3,4.75),(45,'2010-06-13',4.1,1.8,3.6),(47,'2010-06-13',6,1.5,4),(48,'2010-06-13',1.7,4.75,3.5),(7,'2010-06-11',1.4,7.75,4.2),(8,'2010-06-11',2.05,3.7,3.1),(6,'2010-06-11',3.55,2.05,3.2),(5,'2010-06-11',1.42,7.5,4.1),(3,'2010-06-11',1.4,7.5,4.25),(4,'2010-06-11',2.8,2.55,3),(2,'2010-06-11',3.55,2.05,3.2),(1,'2010-06-11',2.75,2.5,3.15),(9,'2010-06-11',1.48,6.5,4),(10,'2010-06-11',3.6,2.05,3.2),(11,'2010-06-11',1.88,4.25,3.2),(12,'2010-06-11',7.75,1.4,4.25),(13,'2010-06-11',3.6,2,3.3),(14,'2010-06-11',1.08,26,8.5),(15,'2010-06-11',6,1.55,3.75),(16,'2010-06-11',1.25,12.5,5),(17,'2010-06-11',2.9,2.4,3.1),(20,'2010-06-11',1.3,10.5,4.6),(19,'2010-06-11',2.95,2.4,3.1),(18,'2010-06-11',2,3.9,3.1),(21,'2010-06-11',1.75,4.5,3.45),(22,'2010-06-11',3.2,2.2,3.2),(23,'2010-06-11',1.22,12.5,5.5),(25,'2010-06-11',1.37,8.25,4.4),(24,'2010-06-11',2.25,3.2,3.1),(26,'2010-06-11',2.65,2.6,3.1),(27,'2010-06-11',3.7,2,3.25),(28,'2010-06-11',1.14,18.5,6.75),(29,'2010-06-11',1.5,6.25,4),(30,'2010-06-11',1.14,18.5,6.75),(31,'2010-06-11',2.15,3.25,3.25),(32,'2010-06-11',1.14,18.5,6.75),(34,'2010-06-11',1.75,4.75,3.4),(33,'2010-06-11',2.6,2.6,3.2),(36,'2010-06-11',6,1.5,4),(35,'2010-06-11',1.91,4,3.25),(37,'2010-06-11',7.75,1.4,4.2),(38,'2010-06-11',1.8,4.5,3.3),(40,'2010-06-11',3.3,2.15,3.2),(39,'2010-06-11',5,1.67,3.5),(42,'2010-06-11',1.3,10,4.75),(41,'2010-06-11',6.25,1.53,3.75),(44,'2010-06-11',4.75,1.75,3.4),(43,'2010-06-11',2,3.7,3.25),(46,'2010-06-11',10,1.3,4.75),(45,'2010-06-11',4.1,1.8,3.6),(47,'2010-06-11',6,1.5,4),(48,'2010-06-11',1.7,4.75,3.5),(1,'2010-06-07',2.8,2.5,3.1),(2,'2010-06-07',3.6,2.05,3.2),(4,'2010-06-07',2.8,2.55,3),(3,'2010-06-07',1.4,7.5,4.25),(5,'2010-06-07',1.42,7.5,4.1),(6,'2010-06-07',3.55,2.05,3.2),(8,'2010-06-07',2.05,3.7,3.1),(7,'2010-06-07',1.4,7.75,4.2),(9,'2010-06-07',1.5,6.5,3.9),(10,'2010-06-07',3.6,2.05,3.2),(11,'2010-06-07',1.88,4.25,3.2),(12,'2010-06-07',7.75,1.4,4.25),(13,'2010-06-07',3.7,2,3.25),(14,'2010-06-07',1.08,26,8.5),(15,'2010-06-07',6,1.55,3.75),(16,'2010-06-07',1.25,12.5,5),(17,'2010-06-07',2.9,2.4,3.1),(20,'2010-06-07',1.3,10.5,4.6),(19,'2010-06-07',2.95,2.4,3.1),(18,'2010-06-07',2,3.9,3.1),(21,'2010-06-07',1.78,4.5,3.4),(22,'2010-06-07',3.2,2.2,3.2),(23,'2010-06-07',1.22,12.5,5.5),(25,'2010-06-07',1.37,8.25,4.4),(24,'2010-06-07',2.25,3.2,3.1),(26,'2010-06-07',2.65,2.6,3.1),(27,'2010-06-07',3.7,2,3.25),(28,'2010-06-07',1.14,18.5,6.75),(29,'2010-06-07',1.5,6.25,4),(30,'2010-06-07',1.14,18.5,6.75),(31,'2010-06-07',2.15,3.25,3.25),(32,'2010-06-07',1.14,18.5,6.75),(34,'2010-06-07',1.75,4.75,3.4),(33,'2010-06-07',2.6,2.6,3.2),(36,'2010-06-07',6,1.5,4),(35,'2010-06-07',1.91,4,3.25),(37,'2010-06-07',7.75,1.4,4.2),(38,'2010-06-07',1.8,4.5,3.3),(40,'2010-06-07',3.3,2.15,3.2),(39,'2010-06-07',5,1.67,3.5),(42,'2010-06-07',1.3,10,4.75),(41,'2010-06-07',6.25,1.53,3.75),(44,'2010-06-07',4.75,1.75,3.4),(43,'2010-06-07',2,3.7,3.25),(46,'2010-06-07',10,1.3,4.75),(45,'2010-06-07',4.1,1.8,3.6),(47,'2010-06-07',6,1.5,4),(48,'2010-06-07',1.7,4.75,3.5),(17,'2010-06-16',3.1,2.4,2.95),(20,'2010-06-16',1.4,8.25,4.1),(19,'2010-06-16',4.1,1.91,3.2),(18,'2010-06-16',2.2,3.4,3),(21,'2010-06-16',1.5,6,4),(22,'2010-06-16',3.6,2.05,3.2),(23,'2010-06-16',1.22,12.5,5.5),(25,'2010-06-16',1.38,8.5,4.15),(24,'2010-06-16',1.91,4,3.25),(26,'2010-06-16',2.9,2.35,3.25),(27,'2010-06-16',4.25,1.9,3.1),(28,'2010-06-16',1.14,15,7.25),(29,'2010-06-16',1.55,6,3.7),(30,'2010-06-16',1.3,11,4.55),(32,'2010-06-16',1.14,20,6.5),(34,'2010-06-16',1.83,4.33,3.3),(33,'2010-06-16',2.65,2.6,3.1),(36,'2010-06-16',9,1.35,4.4),(35,'2010-06-16',2.3,3.1,3.1),(37,'2010-06-16',8,1.4,4.1),(38,'2010-06-16',1.67,5.25,3.5),(40,'2010-06-16',3.6,2,3.3),(39,'2010-06-16',5.75,1.55,3.9),(42,'2010-06-16',1.3,10,4.75),(41,'2010-06-16',6.25,1.53,3.75),(44,'2010-06-16',4.75,1.7,3.5),(43,'2010-06-16',2.2,3.3,3.1),(46,'2010-06-16',9.5,1.35,4.25),(45,'2010-06-16',4.5,1.8,3.3),(18,'2010-06-17',1.95,4.1,3.1),(21,'2010-06-17',1.5,6,4),(22,'2010-06-17',3.6,2.05,3.2),(23,'2010-06-17',1.25,12.5,5),(25,'2010-06-17',1.4,9,3.9),(24,'2010-06-17',1.9,4.25,3.1),(26,'2010-06-17',2.9,2.4,3.1),(27,'2010-06-17',3.85,2,3.1),(28,'2010-06-17',1.18,15,5.9),(29,'2010-06-17',1.6,6,3.5),(30,'2010-06-17',1.35,10,4.2),(31,'2010-06-17',2.25,3.2,3.1),(32,'2010-06-17',1.1,21,8),(34,'2010-06-17',1.7,5.25,3.35),(33,'2010-06-17',2.85,2.5,3),(36,'2010-06-17',6.5,1.55,3.5),(35,'2010-06-17',2.75,2.45,3.2),(37,'2010-06-17',8,1.4,4.1),(38,'2010-06-17',1.67,5.25,3.5),(40,'2010-06-17',3.6,2,3.3),(39,'2010-06-17',5.75,1.55,3.9),(42,'2010-06-17',1.3,10,4.75),(41,'2010-06-17',6.25,1.55,3.6),(44,'2010-06-17',4.75,1.7,3.5),(43,'2010-06-17',2.2,3.3,3.1),(46,'2010-06-17',9.5,1.35,4.25),(45,'2010-06-17',4.5,1.8,3.3),(47,'2010-06-17',6.75,1.5,3.8),(48,'2010-06-17',1.6,5.75,3.6),(23,'2010-06-18',1.22,14.5,5.25),(25,'2010-06-18',1.4,9,3.9),(24,'2010-06-18',1.9,4.25,3.1),(26,'2010-06-18',2.9,2.4,3.1),(27,'2010-06-18',3.85,2,3.1),(28,'2010-06-18',1.18,15,5.9),(29,'2010-06-18',1.6,6,3.5),(30,'2010-06-18',1.35,10,4.2),(31,'2010-06-18',2.25,3.2,3.1),(32,'2010-06-18',1.1,21,8),(34,'2010-06-18',1.91,3.7,3.5),(33,'2010-06-18',3.6,4.3,1.75),(36,'2010-06-18',6.5,1.55,3.5),(35,'2010-06-18',2.75,2.45,3.2),(37,'2010-06-18',8,1.4,4.1),(40,'2010-06-18',4.6,1.72,3.5),(39,'2010-06-18',5.75,1.55,3.9),(42,'2010-06-18',1.3,10,4.75),(41,'2010-06-18',6.25,1.55,3.6),(44,'2010-06-18',4.75,1.7,3.5),(43,'2010-06-18',2.2,3.3,3.1),(46,'2010-06-18',9.5,1.35,4.25),(45,'2010-06-18',4.5,1.8,3.3),(47,'2010-06-18',6.75,1.5,3.8),(48,'2010-06-18',1.6,5.75,3.6),(24,'2010-06-19',2.1,3.45,3.15),(26,'2010-06-19',2.9,2.4,3.1),(27,'2010-06-19',3.85,2,3.1),(28,'2010-06-19',1.18,15,5.9),(29,'2010-06-19',1.6,6,3.5),(30,'2010-06-19',1.35,10,4.2),(31,'2010-06-19',2.25,3.2,3.1),(32,'2010-06-19',1.1,21,8),(34,'2010-06-19',1.91,3.7,3.5),(33,'2010-06-19',3.75,4.4,1.7),(36,'2010-06-19',6.5,1.55,3.5),(35,'2010-06-19',2.75,2.45,3.2),(37,'2010-06-19',6.5,1.48,4),(38,'2010-06-19',1.85,3.85,3.55),(40,'2010-06-19',4.6,1.72,3.5),(39,'2010-06-19',5.75,1.55,3.9),(42,'2010-06-19',1.33,8.25,4.75),(41,'2010-06-19',6.25,1.6,3.4),(46,'2010-06-19',9.5,1.35,4.25),(45,'2010-06-19',4.5,1.8,3.3),(47,'2010-06-19',6.75,1.5,3.8),(48,'2010-06-19',1.6,5.75,3.6),(31,'2010-06-21',2.1,3.6,3.1),(32,'2010-06-21',1.1,18,8.5),(34,'2010-06-21',2.25,3.1,3.2),(33,'2010-06-21',3.75,4.4,1.7),(36,'2010-06-21',5.75,1.55,3.8),(35,'2010-06-21',2.85,2.4,3.2),(37,'2010-06-21',6.5,1.45,4.2),(38,'2010-06-21',1.9,3.75,3.45),(40,'2010-06-21',3.8,1.85,3.6),(39,'2010-06-21',6.35,1.45,4.25),(42,'2010-06-21',1.4,7.5,4.25),(41,'2010-06-21',5.35,1.55,4),(44,'2010-06-21',4.25,1.8,3.45),(43,'2010-06-21',2.15,3.3,3.2),(47,'2010-06-21',6.75,1.5,3.8),(48,'2010-06-21',1.6,5.75,3.6),(34,'2010-06-22',2,3.35,3.5),(33,'2010-06-22',3.5,3.7,1.9),(36,'2010-06-22',5.75,1.53,3.9),(35,'2010-06-22',3,2.3,3.2),(37,'2010-06-22',6.5,1.45,4.2),(38,'2010-06-22',1.9,3.75,3.45),(40,'2010-06-22',3.8,1.85,3.6),(39,'2010-06-22',6.35,1.45,4.25),(42,'2010-06-22',1.4,7.5,4.25),(41,'2010-06-22',5.35,1.55,4),(44,'2010-06-22',4.25,1.8,3.45),(43,'2010-06-22',2.1,3.3,3.3),(46,'2010-06-22',7,1.38,4.65),(45,'2010-06-22',3.6,2.2,2.85),(47,'2010-06-22',6.75,1.45,4.1),(48,'2010-06-22',1.53,6.25,3.75);
/*!40000 ALTER TABLE `bwin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-06-22 10:45:40