-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: brief
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours` (
  `id_cours` int NOT NULL AUTO_INCREMENT,
  `nom_cours` varchar(20) DEFAULT NULL,
  `categorie` varchar(20) DEFAULT NULL,
  `date_cours` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `duree` int DEFAULT NULL,
  `max` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours`
--

LOCK TABLES `cours` WRITE;
/*!40000 ALTER TABLE `cours` DISABLE KEYS */;
INSERT INTO `cours` VALUES (13,'amine elhailaa','Cardio','2025-12-17','11:01:00',11122,12),(14,'alsdf','CrossFit','2025-12-04','11:11:00',133,3),(15,'hii','Musculation','2025-12-11','11:01:00',212,2);
/*!40000 ALTER TABLE `cours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cours_equipement`
--

DROP TABLE IF EXISTS `cours_equipement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cours_equipement` (
  `id_cours` int NOT NULL,
  `id_equipement` int NOT NULL,
  `quantity` int DEFAULT '0',
  PRIMARY KEY (`id_cours`,`id_equipement`),
  KEY `id_equipement` (`id_equipement`),
  CONSTRAINT `cours_equipement_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`),
  CONSTRAINT `cours_equipement_ibfk_2` FOREIGN KEY (`id_equipement`) REFERENCES `equipements` (`id_equipement`),
  CONSTRAINT `notnegative` CHECK ((`quantity` >= 0))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cours_equipement`
--

LOCK TABLES `cours_equipement` WRITE;
/*!40000 ALTER TABLE `cours_equipement` DISABLE KEYS */;
INSERT INTO `cours_equipement` VALUES (13,13,0),(13,16,5);
/*!40000 ALTER TABLE `cours_equipement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipements`
--

DROP TABLE IF EXISTS `equipements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipements` (
  `id_equipement` int NOT NULL AUTO_INCREMENT,
  `nom_equipement` varchar(30) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `qte` smallint DEFAULT NULL,
  `etat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_equipement`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipements`
--

LOCK TABLES `equipements` WRITE;
/*!40000 ALTER TABLE `equipements` DISABLE KEYS */;
INSERT INTO `equipements` VALUES (13,'cars','Haltères',22,'moyen'),(14,'game','Vélo',22,'moyen'),(15,'hello','Ballon',11,'bon'),(16,'salut','Machine',-13,'à remplacer');
/*!40000 ALTER TABLE `equipements` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-12 17:56:05
