-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: dev
-- ------------------------------------------------------
-- Server version	8.0.26

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
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20211018071617','2021-10-18 07:16:29',420),('DoctrineMigrations\\Version20211018072028','2021-10-18 07:20:35',145),('DoctrineMigrations\\Version20211020114134','2021-10-20 11:41:46',87),('DoctrineMigrations\\Version20211020115011','2021-10-20 11:50:26',85),('DoctrineMigrations\\Version20211020121629','2021-10-20 12:16:34',66);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie`
--

DROP TABLE IF EXISTS `movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movie` (
  `id` binary(16) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:dateinterval)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie`
--

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;
INSERT INTO `movie` VALUES (_binary 'I\�\�t��I,�hQ�\�\�\�','Опять изменил название','+P00Y00M00DT00H00M00S'),(_binary 'K#/��NN�\�Ew��hk','Девчата','+P00Y00M00DT01H25M00S'),(_binary 'O��\�C�E¢7h\�㶱\�','Я','+P00Y00M00DT01H25M00S'),(_binary 'Xk٘++Lƛ��+�\�\�m','Я','+P00Y00M00DT01H25M00S'),(_binary '|:kG\�\�NR�ª,�\�','Я233','+P00Y00M00DT01H25M00S'),(_binary '�1\\�7�MH��\�Sz\�Q\�','Операция удалить','+P00Y00M00DT02H25M00S'),(_binary '�\�(\�\nwBA�\�T�\�','Я233','+P00Y00M00DT01H25M00S'),(_binary '�\�\�k�2Kz�|�`	','Я233','+P00Y00M00DT01H25M00S'),(_binary '�&�\�V\�E��O�N�*5','Еще один созданный фильм','+P00Y00M00DT10H25M00S'),(_binary '��R!�D���\�&T��g','Операция удалить','+P00Y00M00DT02H25M00S'),(_binary '���t\ZE\���\�_/�','Девчата','+P00Y00M00DT01H25M00S'),(_binary '\�0\\\�{0K�D\'\n','Операция удалить','+P00Y00M00DT02H25M00S'),(_binary '\�zǊ�gFƮ�É��w','Фильм с формы','+P00Y00M00DT06H25M00S'),(_binary '\�\r~�־E��\�! @%\�\r','Операция Ы','+P00Y00M00DT02H25M00S'),(_binary '֌�\�C\�\��!b��\�','Я','+P00Y00M00DT01H25M00S'),(_binary '\�\�dy��@y�\'˳!�\�)','Изменил название','+P00Y00M00DT10H25M00S'),(_binary '\�\�\�uEf���ؾ��','Я233','+P00Y00M00DT01H25M00S'),(_binary '���tIWF\�\�t�6<�$','Я233','+P00Y00M00DT01H25M00S');
/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session` (
  `id` binary(16) NOT NULL,
  `movie_id` binary(16) DEFAULT NULL,
  `number_of_seats` int NOT NULL,
  `start_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D48F93B6FC` (`movie_id`),
  CONSTRAINT `FK_D044D5D48F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (_binary '\��q��JNv�\�M^v(W',_binary '�1\\�7�MH��\�Sz\�Q\�',20,'2021-02-02 00:00:00'),(_binary '����iH���xX�',_binary '�1\\�7�MH��\�Sz\�Q\�',20,'2021-02-02 00:00:00');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `id` binary(16) NOT NULL,
  `session_id` binary(16) DEFAULT NULL,
  `client_details_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_details_phone_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_97A0ADA3613FECDF` (`session_id`),
  CONSTRAINT `FK_97A0ADA3613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (_binary 'Q�j�IS�� \�g\�#',_binary '\��q��JNv�\�M^v(W','Андрей','89996066942'),(_binary '#�\�rXJ���\�\�z\"�',_binary '\��q��JNv�\�M^v(W','Андрей','89996066942'),(_binary ')\�\�b?I��[&�\�V`+',_binary '\��q��JNv�\�M^v(W','Андрей','89996066942'),(_binary 'O��\�\�\�J_�I\�I�\Zq\�',_binary '����iH���xX�','Андрей','89996066942'),(_binary 'qŎ\��\�L��c\�\��:;',_binary '����iH���xX�','Андрей','89996066942'),(_binary '�Ր�(@��%\�y?�3\�',_binary '����iH���xX�','1','2'),(_binary '�i��\�C��rW\�Z��',_binary '\��q��JNv�\�M^v(W','Андрей','89996066942'),(_binary 'Ӑt��-L��9U\�N	��',_binary '\��q��JNv�\�M^v(W','Андрей','89996066942');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-20 16:39:11
