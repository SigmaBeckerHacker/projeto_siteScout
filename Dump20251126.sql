-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_escoteiro
-- ------------------------------------------------------
-- Server version	8.4.5

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
-- Table structure for table `tbdistintivo`
--

DROP TABLE IF EXISTS `tbdistintivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbdistintivo` (
  `id_distintivo` int NOT NULL AUTO_INCREMENT,
  `nome_distintivo` varchar(50) DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `categoria_distintivo` varchar(50) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_distintivo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbdistintivo`
--

LOCK TABLES `tbdistintivo` WRITE;
/*!40000 ALTER TABLE `tbdistintivo` DISABLE KEYS */;
INSERT INTO `tbdistintivo` VALUES (1,'Jovem',2,'progressao','1764124927-Captura de tela 2025-11-24 194548.png');
/*!40000 ALTER TABLE `tbdistintivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbescoteiro`
--

DROP TABLE IF EXISTS `tbescoteiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbescoteiro` (
  `nome` varchar(100) NOT NULL,
  `registro` decimal(8,0) NOT NULL,
  `ramo` varchar(50) NOT NULL,
  PRIMARY KEY (`registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbescoteiro`
--

LOCK TABLES `tbescoteiro` WRITE;
/*!40000 ALTER TABLE `tbescoteiro` DISABLE KEYS */;
INSERT INTO `tbescoteiro` VALUES ('Joao',1549012,'senior');
/*!40000 ALTER TABLE `tbescoteiro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbrequisicao`
--

DROP TABLE IF EXISTS `tbrequisicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbrequisicao` (
  `id_requisicao` int NOT NULL AUTO_INCREMENT,
  `distintivo` varchar(255) NOT NULL,
  `data_requisicao` date NOT NULL,
  `registroChefe` decimal(8,0) DEFAULT NULL,
  PRIMARY KEY (`id_requisicao`),
  KEY `fk_tbRequisicao_distintivo` (`distintivo`),
  KEY `fk_tbRequisicao_registroChefe` (`registroChefe`),
  CONSTRAINT `fk_tbRequisicao_registroChefe` FOREIGN KEY (`registroChefe`) REFERENCES `tbusuario` (`registro`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbrequisicao`
--

LOCK TABLES `tbrequisicao` WRITE;
/*!40000 ALTER TABLE `tbrequisicao` DISABLE KEYS */;
INSERT INTO `tbrequisicao` VALUES (1,'Distintivo tale','2025-11-26',12345678);
/*!40000 ALTER TABLE `tbrequisicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbusuario`
--

DROP TABLE IF EXISTS `tbusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbusuario` (
  `nome` varchar(100) NOT NULL,
  `registro` decimal(8,0) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuario`
--

LOCK TABLES `tbusuario` WRITE;
/*!40000 ALTER TABLE `tbusuario` DISABLE KEYS */;
INSERT INTO `tbusuario` VALUES ('Administrador',12345678,'Administrador','admin@exemplo.com'),('Com',87654321,'Usuário Comum','comum@exemplo.com');
/*!40000 ALTER TABLE `tbusuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-26  0:20:20
