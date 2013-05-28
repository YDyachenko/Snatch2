-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: bank2
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.04.1-log

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `number` varchar(100) NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `number` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,1,'90107430600227300001',0),(2,2,'90107430600227300002',0),(3,3,'90107430600227300003',0),(4,4,'90107430600227300004',0),(5,5,'90107430600227300005',0),(6,6,'90107430600227300006',0),(7,7,'90107430600227300007',0),(8,8,'90107430600227300008',0),(9,9,'90107430600227300009',0),(10,10,'90107430600227300010',0),(11,11,'90107430600227300011',137),(12,12,'90107430600227300012',869),(13,13,'90107430600227300013',100),(14,14,'90107430600227300014',100),(15,15,'90107430600227300015',100),(16,16,'90107430600227300016',100),(17,17,'90107430600227300017',100),(18,18,'90107430600227300018',100),(19,19,'90107430600227300019',100),(20,20,'90107430600227300020',100),(21,21,'90107430600227300021',100),(22,22,'90107430600227300022',100),(23,23,'90107430600227300023',100),(24,24,'90107430600227300024',100),(25,25,'90107430600227300025',100),(26,26,'90107430600227300026',100),(27,27,'90107430600227300027',100),(28,28,'90107430600227300028',193),(29,29,'90107430600227300029',193),(30,30,'90107430600227300030',193),(31,31,'90107430600227300031',193),(32,32,'90107430600227300032',193),(33,33,'90107430600227300033',193),(34,34,'90107430600227300034',193),(35,35,'90107430600227300035',193),(36,36,'90107430600227300036',193),(37,37,'90107430600227300037',193),(38,38,'90107430600227300038',193),(39,39,'90107430600227300039',193),(40,40,'90107430600227300040',193),(41,41,'90107430600227300041',200),(42,42,'90107430600227300042',200),(43,43,'90107430600227300043',200),(44,44,'90107430600227300044',200),(45,45,'90107430600227300045',200),(46,46,'90107430600227300046',200),(47,47,'90107430600227300047',200),(48,48,'90107430600227300048',200),(49,49,'90107430600227300049',200),(50,50,'90107430600227300050',200),(51,51,'90107430600227300051',200),(52,52,'90107430600227300052',200),(53,53,'90107430600227300053',200),(54,54,'90107430600227300054',200),(55,55,'90107430600227300055',200),(56,56,'90107430600227300056',333),(57,57,'90107430600227300057',333),(58,58,'90107430600227300058',333),(59,59,'90107430600227300059',333),(60,60,'90107430600227300060',333),(61,61,'90107430600227300061',333),(62,62,'90107430600227300062',333),(63,63,'90107430600227300063',333),(64,64,'90107430600227300064',333),(65,65,'90107430600227300065',333),(66,66,'90107430600227300066',333),(67,67,'90107430600227300067',333),(68,68,'90107430600227300068',333),(69,69,'90107430600227300069',333),(70,70,'90107430600227300070',333),(71,71,'90107430600227300071',233),(72,72,'90107430600227300072',233),(73,73,'90107430600227300073',233),(74,74,'90107430600227300074',233),(75,75,'90107430600227300075',233),(76,76,'90107430600227300076',233),(77,77,'90107430600227300077',233),(78,78,'90107430600227300078',233),(79,79,'90107430600227300079',233),(80,80,'90107430600227300080',233),(81,81,'90107430600227300081',233),(82,82,'90107430600227300082',233),(83,83,'90107430600227300083',233),(84,84,'90107430600227300084',233),(85,85,'90107430600227300085',233),(86,86,'90107430600227300086',233),(87,87,'90107430600227300087',233),(88,88,'90107430600227300088',233),(89,89,'90107430600227300089',233),(90,90,'90107430600227300090',233),(91,91,'90107430600227300091',233),(92,92,'90107430600227300092',233),(93,93,'90107430600227300093',233),(94,94,'90107430600227300094',233),(95,95,'90107430600227300095',233),(96,96,'90107430600227300096',233),(97,97,'90107430600227300097',233),(98,98,'90107430600227300098',233),(99,99,'90107430600227300099',233),(100,100,'90107430600227300100',233);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `account` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rel_users_services`
--

DROP TABLE IF EXISTS `rel_users_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rel_users_services` (
  `user_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rel_users_services`
--

LOCK TABLES `rel_users_services` WRITE;
/*!40000 ALTER TABLE `rel_users_services` DISABLE KEYS */;
INSERT INTO `rel_users_services` VALUES (1,1),(1,3),(2,1),(2,3),(3,1),(3,3),(4,1),(4,3),(5,1),(5,3),(6,1),(6,3),(7,1),(7,3),(8,1),(8,3),(9,1),(9,3),(10,1),(10,3),(11,1),(11,3),(12,1),(12,3),(28,1),(28,2),(29,1),(29,2),(30,1),(30,2),(31,1),(31,2),(32,1),(32,2),(33,1),(33,2),(34,1),(34,2),(35,1),(35,2),(36,1),(36,2),(37,1),(37,2),(38,1),(38,2),(39,1),(39,2),(40,1),(40,2),(56,2),(57,2),(58,2),(59,2),(60,2),(61,2),(62,2),(63,2),(64,2),(65,2),(66,2),(67,2),(68,2),(69,2),(70,2);
/*!40000 ALTER TABLE `rel_users_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Mobile bank'),(2,'SMS-tokens'),(3,'Transaction authentication numbers');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` char(40) NOT NULL,
  `data` blob NOT NULL,
  `access_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('o5fr1c1s9elco06volp4eurhh7','','2013-05-28 07:40:10');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tan`
--

DROP TABLE IF EXISTS `tan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tan` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(5) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tan`
--

LOCK TABLES `tan` WRITE;
/*!40000 ALTER TABLE `tan` DISABLE KEYS */;
INSERT INTO `tan` VALUES (1,1,'93242',0),(1,2,'73814',0),(1,3,'80857',0),(1,4,'71338',0),(1,5,'33006',0),(1,6,'19274',0),(1,7,'99929',0),(1,8,'89257',0),(1,9,'80171',0),(1,10,'40828',0),(1,11,'94688',0),(1,12,'00845',0),(2,1,'19446',0),(2,2,'70616',0),(2,3,'64837',0),(2,4,'66095',0),(2,5,'98394',0),(2,6,'51468',0),(2,7,'42676',0),(2,8,'55565',0),(2,9,'24598',0),(2,10,'02066',0),(2,11,'72663',0),(2,12,'39719',0),(3,1,'65090',0),(3,2,'06453',0),(3,3,'30919',0),(3,4,'22648',0),(3,5,'95474',0),(3,6,'76105',0),(3,7,'37802',0),(3,8,'92347',0),(3,9,'72817',0),(3,10,'07622',0),(3,11,'03354',0),(3,12,'36737',0),(4,1,'71153',0),(4,2,'31086',0),(4,3,'28305',0),(4,4,'00532',0),(4,5,'11995',0),(4,6,'34006',0),(4,7,'46688',0),(4,8,'98420',0),(4,9,'81501',0),(4,10,'23992',0),(4,11,'84650',0),(4,12,'66631',0),(5,1,'91106',0),(5,2,'95060',0),(5,3,'01248',0),(5,4,'27552',0),(5,5,'41244',0),(5,6,'27564',0),(5,7,'43973',0),(5,8,'45341',0),(5,9,'29178',0),(5,10,'55527',0),(5,11,'07481',0),(5,12,'94475',0),(6,1,'27279',0),(6,2,'50761',0),(6,3,'42814',0),(6,4,'42412',0),(6,5,'44269',0),(6,6,'48321',0),(6,7,'99033',0),(6,8,'12651',0),(6,9,'49674',0),(6,10,'62030',0),(6,11,'69764',0),(6,12,'23053',0),(7,1,'67381',0),(7,2,'64445',0),(7,3,'60455',0),(7,4,'38472',0),(7,5,'49340',0),(7,6,'24051',0),(7,7,'73275',0),(7,8,'73109',0),(7,9,'16524',0),(7,10,'17090',0),(7,11,'95954',0),(7,12,'76460',0),(8,1,'50104',0),(8,2,'91563',0),(8,3,'22016',0),(8,4,'23922',0),(8,5,'94834',0),(8,6,'50396',0),(8,7,'12889',0),(8,8,'85542',0),(8,9,'65924',0),(8,10,'90206',0),(8,11,'72749',0),(8,12,'99971',0),(9,1,'86985',0),(9,2,'26961',0),(9,3,'75677',0),(9,4,'45509',0),(9,5,'32989',0),(9,6,'17237',0),(9,7,'42723',0),(9,8,'13548',0),(9,9,'70651',0),(9,10,'91353',0),(9,11,'05331',0),(9,12,'90764',0),(10,1,'05711',0),(10,2,'30338',0),(10,3,'59690',0),(10,4,'31995',0),(10,5,'49138',0),(10,6,'87287',0),(10,7,'97965',0),(10,8,'34676',0),(10,9,'34384',0),(10,10,'58657',0),(10,11,'72638',0),(10,12,'53126',0),(11,1,'11221',0),(11,2,'03309',0),(11,3,'19234',0),(11,4,'21377',0),(11,5,'78992',0),(11,6,'81437',0),(11,7,'81878',0),(11,8,'62106',0),(11,9,'51469',0),(11,10,'91354',0),(11,11,'64512',0),(11,12,'31178',0),(12,1,'94822',0),(12,2,'45922',0),(12,3,'18690',0),(12,4,'61903',0),(12,5,'43770',0),(12,6,'97620',0),(12,7,'26820',0),(12,8,'31996',0),(12,9,'21898',0),(12,10,'11614',0),(12,11,'77244',0),(12,12,'69265',0),(13,1,'88917',0),(13,2,'08653',0),(13,3,'06052',0),(13,4,'23261',0),(13,5,'72007',0),(13,6,'85590',0),(13,7,'10348',0),(13,8,'07027',0),(13,9,'30582',0),(13,10,'73283',0),(13,11,'64969',0),(13,12,'54100',0),(14,1,'06726',0),(14,2,'24480',0),(14,3,'68470',0),(14,4,'48431',0),(14,5,'19102',0),(14,6,'64004',0),(14,7,'86064',0),(14,8,'91355',0),(14,9,'05897',0),(14,10,'28358',0),(14,11,'43218',0),(14,12,'19917',0),(15,1,'10318',0),(15,2,'80777',0),(15,3,'05562',0),(15,4,'78739',0),(15,5,'54552',0),(15,6,'62295',0),(15,7,'00773',0),(15,8,'56811',0),(15,9,'26881',0),(15,10,'95930',0),(15,11,'11345',0),(15,12,'10887',0),(16,1,'91463',0),(16,2,'90724',0),(16,3,'32291',0),(16,4,'76066',0),(16,5,'49163',0),(16,6,'07236',0),(16,7,'07094',0),(16,8,'64631',0),(16,9,'01640',0),(16,10,'38903',0),(16,11,'42705',0),(16,12,'24136',0),(17,1,'57479',0),(17,2,'62792',0),(17,3,'30154',0),(17,4,'59786',0),(17,5,'93292',0),(17,6,'02746',0),(17,7,'68545',0),(17,8,'30340',0),(17,9,'09156',0),(17,10,'70505',0),(17,11,'57019',0),(17,12,'86894',0),(18,1,'66458',0),(18,2,'74866',0),(18,3,'57326',0),(18,4,'44845',0),(18,5,'44612',0),(18,6,'54327',0),(18,7,'37219',0),(18,8,'08197',0),(18,9,'07796',0),(18,10,'92754',0),(18,11,'28653',0),(18,12,'75402',0),(19,1,'63654',0),(19,2,'63654',0),(19,3,'63654',0),(19,4,'63654',0),(19,5,'63654',0),(19,6,'63654',0),(19,7,'63654',0),(19,8,'63654',0),(19,9,'63654',0),(19,10,'63654',0),(19,11,'63654',0),(19,12,'63654',0),(20,1,'36118',0),(20,2,'36118',0),(20,3,'36118',0),(20,4,'36118',0),(20,5,'36118',0),(20,6,'36118',0),(20,7,'36118',0),(20,8,'36118',0),(20,9,'36118',0),(20,10,'36118',0),(20,11,'36118',0),(20,12,'36118',0);
/*!40000 ALTER TABLE `tan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_templates`
--

DROP TABLE IF EXISTS `transaction_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `account_from` varchar(100) NOT NULL,
  `account_to` varchar(100) NOT NULL,
  `sum` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_templates`
--

LOCK TABLES `transaction_templates` WRITE;
/*!40000 ALTER TABLE `transaction_templates` DISABLE KEYS */;
INSERT INTO `transaction_templates` VALUES (1,71,'Template 71 - 72','90107430600227300071','90107430600227300072',25),(2,72,'Template 72 - 73','90107430600227300072','90107430600227300073',25),(3,73,'Template 73 - 74','90107430600227300073','90107430600227300074',25),(4,74,'Template 74 - 75','90107430600227300074','90107430600227300075',25),(5,75,'Template 75 - 71','90107430600227300075','90107430600227300071',25),(6,76,'Template 76 - 77','90107430600227300076','90107430600227300077',25),(7,77,'Template 77 - 78','90107430600227300077','90107430600227300078',25),(8,78,'Template 78 - 79','90107430600227300078','90107430600227300079',25),(9,79,'Template 79 - 80','90107430600227300079','90107430600227300080',25),(10,80,'Template 80 - 76','90107430600227300080','90107430600227300076',25),(11,81,'Template 81 - 82','90107430600227300081','90107430600227300082',25),(12,82,'Template 82 - 83','90107430600227300082','90107430600227300083',25),(13,83,'Template 83 - 84','90107430600227300083','90107430600227300084',25),(14,84,'Template 84 - 85','90107430600227300084','90107430600227300085',25),(15,85,'Template 85 - 81','90107430600227300085','90107430600227300081',25),(16,86,'Template 86 - 87','90107430600227300086','90107430600227300087',25),(17,87,'Template 87 - 88','90107430600227300087','90107430600227300088',25),(18,88,'Template 88 - 89','90107430600227300088','90107430600227300089',25),(19,89,'Template 89 - 90','90107430600227300089','90107430600227300090',25),(20,90,'Template 90 - 86','90107430600227300090','90107430600227300086',25),(21,91,'Template 91 - 92','90107430600227300091','90107430600227300092',25),(22,92,'Template 92 - 93','90107430600227300092','90107430600227300093',25),(23,93,'Template 93 - 94','90107430600227300093','90107430600227300094',25),(24,94,'Template 94 - 95','90107430600227300094','90107430600227300095',25),(25,95,'Template 95 - 91','90107430600227300095','90107430600227300091',25),(26,96,'Template 96 - 97','90107430600227300096','90107430600227300097',25),(27,97,'Template 97 - 98','90107430600227300097','90107430600227300098',25),(28,98,'Template 98 - 99','90107430600227300098','90107430600227300099',25),(29,99,'Template 99 - 100','90107430600227300099','90107430600227300100',25),(30,100,'Template 100 - 96','90107430600227300100','90107430600227300096',25);
/*!40000 ALTER TABLE `transaction_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `sum` double NOT NULL,
  `otp_code` char(5) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions_history`
--

DROP TABLE IF EXISTS `transactions_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions_history` (
  `id` int(10) unsigned NOT NULL,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `sum` double NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `to` (`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions_history`
--

LOCK TABLES `transactions_history` WRITE;
/*!40000 ALTER TABLE `transactions_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `force_change_password` tinyint(1) NOT NULL,
  `otp_method` enum('tan','mtan','none') NOT NULL DEFAULT 'none',
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'100001','b2aa606769fa12d7fb46721238a490f5',0,'tan','user1@ibank2.phd','','','981-123-45-67'),(2,'100002','22ebc7b4198b62b139b5d1890851f186',0,'tan','user2@ibank2.phd','','','981-765-43-21'),(3,'100003','6d03e5546016acb53c6bc2f92feb7a8e',0,'tan','user3@ibank2.phd','','','981-123-45-67'),(4,'100004','3226a209028446d70a3b4454563916fd',0,'tan','user4@ibank2.phd','','','981-765-43-21'),(5,'100005','75f123e2e192d455b4319934404a9729',0,'tan','user5@ibank2.phd','','','981-123-45-67'),(6,'100006','d43cdc090ff07d9c06e23a737eb8a4d7',0,'tan','user6@ibank2.phd','','','981-765-43-21'),(7,'100007','511ce009443887e2ef5395d0bd0626f2',0,'tan','user7@ibank2.phd','','','981-123-45-67'),(8,'100008','4e2b48ef0a18e2f9861127b3ab844220',0,'tan','user8@ibank2.phd','','','981-765-43-21'),(9,'100009','a073b2e44f198d905443b386799171aa',0,'tan','user9@ibank2.phd','','','981-123-45-67'),(10,'100010','2bfd8e39567da3d90a51ba85f8ed081a',0,'tan','user10@ibank2.phd','','','981-765-43-21'),(11,'100011','5f4dcc3b5aa765d61d8327deb882cf99',0,'tan','user11@ibank2.phd','Sergey','Scherbel','981-123-45-67'),(12,'100012','7c477abdf7ee8d5d53a65b32d0d70217',0,'tan','user12@ibank2.phd','Yuriy','Dyachenko','981-765-43-21'),(13,'100013','d8578edf8458ce06fbc5bb76a58c5ca4',0,'none','user13@ibank2.phd','Kevin','Smith',''),(14,'100014','5f4dcc3b5aa765d61d8327deb882cf99',0,'none','user14@ibank2.phd','Christopher','Reid',''),(15,'100015','e10adc3949ba59abbe56e057f20f883e',0,'none','user15@ibank2.phd','Nathan','Sutherland',''),(16,'100016','827ccb0eea8a706c4c34a16891f84e7b',0,'none','user16@ibank2.phd','Charles','Sharp',''),(17,'100017','b0baee9d279d34fa1dfd71aadb908c3f',0,'none','user17@ibank2.phd','Benjamin','Howard',''),(18,'100018','3899dcbab79f92af727c2190bbd8abc5',0,'none','user18@ibank2.phd','Jack','Stewart',''),(19,'100019','4297f44b13955235245b2497399d7a93',0,'none','user19@ibank2.phd','Zoe','Robertson',''),(20,'100020','3c3662bcb661d6de679c636744c66b62',0,'none','user20@ibank2.phd','Peter','Davies',''),(21,'100021','cffbad68bb97a6c3f943538f119c992c',0,'none','user21@ibank2.phd','Warren','Mackay',''),(22,'100022','c33367701511b4f6020ec61ded352059',0,'none','user22@ibank2.phd','Emily','Stewart',''),(23,'100023','f25a2fc72690b780b2a14e140ef6a9e0',0,'none','user23@ibank2.phd','Liam','Dyer',''),(24,'100024','63a9f0ea7bb98050796b649e85481845',0,'none','user24@ibank2.phd','Sean','Bell',''),(25,'100025','eb0a191797624dd3a48fa681d3061212',0,'none','user25@ibank2.phd','Penelope','Gray',''),(26,'100026','84d961568a65073a3bcf0eb216b2a576',0,'none','user26@ibank2.phd','Kylie','Avery',''),(27,'100027','7b24afc8bc80e548d66c4e7ff72171c5',0,'none','user27@ibank2.phd','Penelope','Davies',''),(28,'100028','0d107d09f5bbe40cade3de5c71e9e9b7',0,'mtan','user28@ibank2.phd','Andrew','Mathis',''),(29,'100029','3bf1114a986ba87ed28fc1b5884fc2f8',0,'mtan','user29@ibank2.phd','Angela','Brown',''),(30,'100030','25d55ad283aa400af464c76d713c07ad',0,'mtan','user30@ibank2.phd','Alan','Terry',''),(31,'100031','d0763edaa9d9bd2a9516280e9044d885',0,'mtan','user31@ibank2.phd','Richard','Grant',''),(32,'100032','276f8db0b86edaa7fc805516c852c889',0,'mtan','user32@ibank2.phd','Sophie','Russell',''),(33,'100033','8621ffdbc5698829397d97767ac13db3',0,'mtan','user33@ibank2.phd','Leah','Walsh',''),(34,'100034','110d46fcd978c24f306cd7fa23464d73',0,'mtan','user34@ibank2.phd','Thomas','Skinner',''),(35,'100035','d8578edf8458ce06fbc5bb76a58c5ca4',0,'mtan','user35@ibank2.phd','Ruth','Fisher',''),(36,'100036','5f4dcc3b5aa765d61d8327deb882cf99',0,'mtan','user36@ibank2.phd','Sam','Ferguson',''),(37,'100037','e10adc3949ba59abbe56e057f20f883e',0,'mtan','user37@ibank2.phd','Lucas','Forsyth',''),(38,'100038','e99a18c428cb38d5f260853678922e03',0,'mtan','user38@ibank2.phd','Connor','Bailey',''),(39,'100039','fcea920f7412b5da7be0cf42b8c93759',0,'mtan','user39@ibank2.phd','Thomas','Piper',''),(40,'100040','36f17c3939ac3e7b2fc9396fa8e953ea',0,'mtan','user40@ibank2.phd','Felicity','Buckland',''),(41,'100041','340e9fd76758f0dd174625a57ce75a19',0,'none','user41@ibank2.phd','Owen','Rees',''),(42,'100042','ea6d0a351c28adfbabea222584409200',0,'none','user42@ibank2.phd','Fiona','Mackay',''),(43,'100043','45c5c5762e36a077b24e181ad6ec1a73',0,'none','user43@ibank2.phd','Jasmine','Hart',''),(44,'100044','970821139ce4f042aef574d2240d4d5e',0,'none','user44@ibank2.phd','Carol','Bower',''),(45,'100045','107b33f3e6f060689174046093bb9427',0,'none','user45@ibank2.phd','Adrian','North',''),(46,'100046','3269de4d29b2d77b6390901530c3d16e',0,'none','user46@ibank2.phd','Angela','King',''),(47,'100047','4656ea936016eefbccb6989abfc1106a',0,'none','user47@ibank2.phd','Sally','Arnold',''),(48,'100048','11dd846889acb52b34f32568db84d4dc',0,'none','user48@ibank2.phd','Michael','Ince',''),(49,'100049','e5f1bed6956c08c5b106f9990a5e9265',0,'none','user49@ibank2.phd','Simon','Alsop',''),(50,'100050','f31ced80e1e7df69816a56681bb263ba',0,'none','user50@ibank2.phd','Penelope','Tucker',''),(51,'100051','d8fcf0743a2c7245dae908d43c0d484d',0,'none','user51@ibank2.phd','Vanessa','Mathis',''),(52,'100052','0a0b5634d2ebd80f9e1d21b4e4286974',0,'none','user52@ibank2.phd','Andrea','Vaughan',''),(53,'100053','ab35867a6703b9dafbda5cdb46a73fb9',0,'none','user53@ibank2.phd','Alexandra','Marshall',''),(54,'100054','358950d975114f2810c2ac220654d2d3',0,'none','user54@ibank2.phd','Leonard','Mills',''),(55,'100055','2e03ffc03e8a1dd463e83316c33cf31b',0,'none','user55@ibank2.phd','Tracey','Forsyth',''),(56,'100056','2b05899327f5cb4ed74929672bc75439',0,'mtan','user56@ibank2.phd','Thomas','Rutherford',''),(57,'100057','9c22ca8ea9fd44b63b2d587a8e31f595',0,'mtan','user57@ibank2.phd','Michael','Hart',''),(58,'100058','975b8bbb74f23914f9196ab01c857a66',0,'mtan','user58@ibank2.phd','Carolyn','Wilkins',''),(59,'100059','bdd743f04011c0e8b2f3896577c029f6',0,'mtan','user59@ibank2.phd','Andrea','Bond',''),(60,'100060','5066172a998c1a74307344e748ada904',0,'mtan','user60@ibank2.phd','Dan','Ball',''),(61,'100061','d90a45e7e3d361fe92a4c84e2d280084',0,'mtan','user61@ibank2.phd','Simon','Rees',''),(62,'100062','7854401e9cc5a78739495810466b120e',0,'mtan','user62@ibank2.phd','Gordon','Wallace',''),(63,'100063','b9951c4fb9540c7cdaf78ba8a1607de7',0,'mtan','user63@ibank2.phd','Penelope','Fisher',''),(64,'100064','f02162acef5328b6461201ac3bda214e',0,'mtan','user64@ibank2.phd','Cameron','Slater',''),(65,'100065','f3f4b8c3bfbde4563c2e128019410d7f',0,'mtan','user65@ibank2.phd','Julian','Carr',''),(66,'100066','9754ef8d9b27f1250bfe10fda3c29d14',0,'mtan','user66@ibank2.phd','Dominic','Abraham',''),(67,'100067','b6ec8a6c4133d5aada2b1cf664f2e183',0,'mtan','user67@ibank2.phd','Tracey','Dowd',''),(68,'100068','a9c6dc2e043848aa30b953779546be9e',0,'mtan','user68@ibank2.phd','Nicola','Howard',''),(69,'100069','8642d94b9bb4966f374e192610add613',0,'mtan','user69@ibank2.phd','Austin','Morgan',''),(70,'100070','bf438015528dc6cfd5bae2dc91748d0c',0,'mtan','user70@ibank2.phd','Rachel','Slater',''),(71,'100071','f010611f58edb04143b5ceceb50037d7',0,'none','user71@ibank2.phd','Gabrielle','Fraser',''),(72,'100072','f010611f58edb04143b5ceceb50037d7',0,'none','user72@ibank2.phd','Diane','Young',''),(73,'100073','f010611f58edb04143b5ceceb50037d7',0,'none','user73@ibank2.phd','Diana','White',''),(74,'100074','f010611f58edb04143b5ceceb50037d7',0,'none','user74@ibank2.phd','Adam','Pullman',''),(75,'100075','f010611f58edb04143b5ceceb50037d7',0,'none','user75@ibank2.phd','Dominic','Vaughan',''),(76,'100076','f010611f58edb04143b5ceceb50037d7',0,'none','user76@ibank2.phd','Thomas','Lee',''),(77,'100077','f010611f58edb04143b5ceceb50037d7',0,'none','user77@ibank2.phd','Sebastian','Paige',''),(78,'100078','f010611f58edb04143b5ceceb50037d7',0,'none','user78@ibank2.phd','Sonia','Payne',''),(79,'100079','f010611f58edb04143b5ceceb50037d7',0,'none','user79@ibank2.phd','Brandon','Miller',''),(80,'100080','f010611f58edb04143b5ceceb50037d7',0,'none','user80@ibank2.phd','Carolyn','Sharp',''),(81,'100081','f010611f58edb04143b5ceceb50037d7',0,'none','user81@ibank2.phd','Joseph','Metcalfe',''),(82,'100082','f010611f58edb04143b5ceceb50037d7',0,'none','user82@ibank2.phd','Ella','Avery',''),(83,'100083','f010611f58edb04143b5ceceb50037d7',0,'none','user83@ibank2.phd','Anthony','King',''),(84,'100084','f010611f58edb04143b5ceceb50037d7',0,'none','user84@ibank2.phd','Jake','Hodges',''),(85,'100085','f010611f58edb04143b5ceceb50037d7',0,'none','user85@ibank2.phd','Emily','Black',''),(86,'100086','f010611f58edb04143b5ceceb50037d7',0,'none','user86@ibank2.phd','Isaac','Baker',''),(87,'100087','f010611f58edb04143b5ceceb50037d7',0,'none','user87@ibank2.phd','Dan','Ogden',''),(88,'100088','f010611f58edb04143b5ceceb50037d7',0,'none','user88@ibank2.phd','Thomas','Coleman',''),(89,'100089','f010611f58edb04143b5ceceb50037d7',0,'none','user89@ibank2.phd','Warren','Glover',''),(90,'100090','f010611f58edb04143b5ceceb50037d7',0,'none','user90@ibank2.phd','Diane','Arnold',''),(91,'100091','f010611f58edb04143b5ceceb50037d7',0,'none','user91@ibank2.phd','Molly','Ross',''),(92,'100092','f010611f58edb04143b5ceceb50037d7',0,'none','user92@ibank2.phd','Thomas','North',''),(93,'100093','f010611f58edb04143b5ceceb50037d7',0,'none','user93@ibank2.phd','Felicity','Parsons',''),(94,'100094','f010611f58edb04143b5ceceb50037d7',0,'none','user94@ibank2.phd','Diane','Lewis',''),(95,'100095','f010611f58edb04143b5ceceb50037d7',0,'none','user95@ibank2.phd','Carolyn','Lee',''),(96,'100096','f010611f58edb04143b5ceceb50037d7',0,'none','user96@ibank2.phd','Carolyn','Hardacre',''),(97,'100097','f010611f58edb04143b5ceceb50037d7',0,'none','user97@ibank2.phd','Samantha','Slater',''),(98,'100098','f010611f58edb04143b5ceceb50037d7',0,'none','user98@ibank2.phd','Neil','Nash',''),(99,'100099','f010611f58edb04143b5ceceb50037d7',0,'none','user99@ibank2.phd','Keith','Harris',''),(100,'100100','f010611f58edb04143b5ceceb50037d7',0,'none','user100@ibank2.phd','Leonard','Black','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-28 11:41:50
