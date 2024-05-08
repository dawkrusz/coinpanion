-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: coinpanion
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kategoria`
--

DROP TABLE IF EXISTS `kategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategoria` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Nazwa` varchar(50) NOT NULL,
  `Id_Uzytkownik` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nazwa` (`Nazwa`),
  KEY `fk_Kategoria_Uzytkownik` (`Id_Uzytkownik`),
  CONSTRAINT `fk_Kategoria_Uzytkownik` FOREIGN KEY (`Id_Uzytkownik`) REFERENCES `uzytkownik` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategoria`
--

LOCK TABLES `kategoria` WRITE;
/*!40000 ALTER TABLE `kategoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konto`
--

DROP TABLE IF EXISTS `konto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konto` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Id_Uzytkownik` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Uzytkownik` (`Id_Uzytkownik`),
  CONSTRAINT `konto_ibfk_1` FOREIGN KEY (`Id_Uzytkownik`) REFERENCES `uzytkownik` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konto`
--

LOCK TABLES `konto` WRITE;
/*!40000 ALTER TABLE `konto` DISABLE KEYS */;
/*!40000 ALTER TABLE `konto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `powiadomienie`
--

DROP TABLE IF EXISTS `powiadomienie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `powiadomienie` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Tresc` text NOT NULL,
  `Data_wyslania` datetime NOT NULL,
  `Id_Uzytkownik` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Uzytkownik` (`Id_Uzytkownik`),
  CONSTRAINT `powiadomienie_ibfk_1` FOREIGN KEY (`Id_Uzytkownik`) REFERENCES `uzytkownik` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `powiadomienie`
--

LOCK TABLES `powiadomienie` WRITE;
/*!40000 ALTER TABLE `powiadomienie` DISABLE KEYS */;
/*!40000 ALTER TABLE `powiadomienie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raport`
--

DROP TABLE IF EXISTS `raport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `raport` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Okres` varchar(50) NOT NULL,
  `Id_Uzytkownik` int DEFAULT NULL,
  `Id_Kategoria` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Uzytkownik` (`Id_Uzytkownik`),
  KEY `Id_Kategoria` (`Id_Kategoria`),
  CONSTRAINT `raport_ibfk_1` FOREIGN KEY (`Id_Uzytkownik`) REFERENCES `uzytkownik` (`Id`),
  CONSTRAINT `raport_ibfk_2` FOREIGN KEY (`Id_Kategoria`) REFERENCES `kategoria` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raport`
--

LOCK TABLES `raport` WRITE;
/*!40000 ALTER TABLE `raport` DISABLE KEYS */;
/*!40000 ALTER TABLE `raport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uzytkownik`
--

DROP TABLE IF EXISTS `uzytkownik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `uzytkownik` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Login` varchar(50) NOT NULL,
  `Haslo` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Imie` varchar(50) NOT NULL,
  `Nazwisko` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uzytkownik`
--

LOCK TABLES `uzytkownik` WRITE;
/*!40000 ALTER TABLE `uzytkownik` DISABLE KEYS */;
/*!40000 ALTER TABLE `uzytkownik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wydatek`
--

DROP TABLE IF EXISTS `wydatek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wydatek` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Kwota` decimal(10,2) NOT NULL,
  `Data` date NOT NULL,
  `Opis` varchar(255) DEFAULT NULL,
  `Id_Kategoria` int DEFAULT NULL,
  `Id_Uzytkownik` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_Kategoria` (`Id_Kategoria`),
  KEY `Id_Uzytkownik` (`Id_Uzytkownik`),
  CONSTRAINT `wydatek_ibfk_1` FOREIGN KEY (`Id_Kategoria`) REFERENCES `kategoria` (`Id`),
  CONSTRAINT `wydatek_ibfk_2` FOREIGN KEY (`Id_Uzytkownik`) REFERENCES `uzytkownik` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wydatek`
--

LOCK TABLES `wydatek` WRITE;
/*!40000 ALTER TABLE `wydatek` DISABLE KEYS */;
/*!40000 ALTER TABLE `wydatek` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-10 10:56:28
