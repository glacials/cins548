-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: 548webapp
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `item_id` int(11) NOT NULL,
  `item_name` char(100) NOT NULL,
  `image_url` char(100) DEFAULT NULL,
  `item_description` text NOT NULL,
  `item_price` float(5,2) NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_id` (`item_id`),
  UNIQUE KEY `item_name` (`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (0,'Iron Bucket','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/5/52/Bucket.png','Empty buckets can be used to capture water or lava springs, extracting the source block for later use; source blocks can also be taken from lakes of water or lava.',0.00),(1,'Flint and Steel','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/7/7e/Flint_and_Steel.png','When used with right-click on top of a solid, fully opaque block or on the sides of a flammable block, flint and steel places fire in the air block directly adjacent to the surface on which it is used.',0.00),(2,'Fishing Pole','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/c/c7/Fishing_Rod.png','Used to catch fish. Can also be used to pull mobs and other entities.',0.00),(3,'Clock','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/9/93/Watch.png','Clocks (sometimes called watches), are items that display the current in-game time by displaying the sun and the moon\'s position relative to the horizon.',0.00),(4,'Shears','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/d/d1/Shears.png','Used to collect dead bush, leaves, tall grass, vines and wool from sheep. Also breaks leaves, wool, and cobweb faster than by hand. Shears can be used to collect tripwire without triggering a redstone pulse.',0.00),(5,'Map','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/6/67/Map_%28Item%29.png','While a map is being held in the player\'s hand, it will gradually be drawn as the player explores the world.',0.00),(6,'Compass','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/9/92/Compass.png','The compass needle points towards the player\'s original spawn point, whether in your inventory screen, in chests, lying on the floor, or while holding it in your hand.',0.00),(7,'TNT','http://hydra-media.cursecdn.com/minecraft.gamepedia.com/1/1e/TNT.png','TNT is an explosive block that is placed and can be subsequently activated at the player\'s discretion to deliver a powerful blast in a desired area. Its explosion is generally lethal to most players at close range.',0.00);
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Purchase_Items`
--

DROP TABLE IF EXISTS `Purchase_Items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Purchase_Items` (
  `purchase_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  KEY `purchase_id` (`purchase_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `Purchase_Items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `Purchases` (`purchase_id`),
  CONSTRAINT `Purchase_Items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Products` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Purchase_Items`
--

LOCK TABLES `Purchase_Items` WRITE;
/*!40000 ALTER TABLE `Purchase_Items` DISABLE KEYS */;
INSERT INTO `Purchase_Items` VALUES (1,4),(1,6),(1,3),(2,3),(2,4),(2,1),(3,1),(3,5),(3,7),(4,2),(4,6),(5,7),(5,2),(6,7),(6,3),(7,2),(7,1),(7,6),(8,6),(8,4),(8,2),(8,1);
/*!40000 ALTER TABLE `Purchase_Items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Purchases`
--

DROP TABLE IF EXISTS `Purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Purchases`
--

LOCK TABLES `Purchases` WRITE;
/*!40000 ALTER TABLE `Purchases` DISABLE KEYS */;
INSERT INTO `Purchases` VALUES (1,5,'2013-10-05 14:34:11'),(2,4,'2013-10-02 18:24:50'),(3,3,'2013-10-03 22:45:11'),(4,6,'2013-10-01 15:22:55'),(5,4,'2013-09-22 18:35:06'),(6,3,'2013-09-23 22:20:23'),(7,6,'2013-09-22 18:55:04'),(8,5,'2013-09-25 17:32:24');
/*!40000 ALTER TABLE `Purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `password_hash` char(50) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `gender` char(1) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (3,'admin@gmail.com','dL0GU02VpDZYE',1,'m','2013-10-01 04:43:02'),(4,'frank@gmail.com','dL0GU02VpDZYE',0,'m','2013-09-17 15:21:44'),(5,'melissa@gmail.com','dL0GU02VpDZYE',0,'f','2013-09-25 20:44:52'),(6,'billy@gmail.com','dL0GU02VpDZYE',0,'m','2013-10-02 19:06:33');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-04 10:27:49
