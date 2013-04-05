-- MySQL dump 10.13  Distrib 5.5.8, for Win32 (x86)
--
-- Host: localhost    Database: cms2
-- ------------------------------------------------------
-- Server version	5.5.8-log

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
-- Table structure for table `bundles`
--

DROP TABLE IF EXISTS `bundles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bundles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bundles`
--

LOCK TABLES `bundles` WRITE;
/*!40000 ALTER TABLE `bundles` DISABLE KEYS */;
INSERT INTO `bundles` VALUES (8,'dbbackup',''),(7,'httpimage',''),(4,'filemange','');
/*!40000 ALTER TABLE `bundles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_album_nid`
--

DROP TABLE IF EXISTS `content_album_nid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_album_nid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_album_nid`
--

LOCK TABLES `content_album_nid` WRITE;
/*!40000 ALTER TABLE `content_album_nid` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_album_nid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_album_varchar`
--

DROP TABLE IF EXISTS `content_album_varchar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_album_varchar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_album_varchar`
--

LOCK TABLES `content_album_varchar` WRITE;
/*!40000 ALTER TABLE `content_album_varchar` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_album_varchar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_img_int`
--

DROP TABLE IF EXISTS `content_img_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_img_int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_img_int`
--

LOCK TABLES `content_img_int` WRITE;
/*!40000 ALTER TABLE `content_img_int` DISABLE KEYS */;
INSERT INTO `content_img_int` VALUES (1,1,18,1),(12,2,18,1),(11,2,18,2),(19,3,18,11),(18,3,18,10);
/*!40000 ALTER TABLE `content_img_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_img_nid`
--

DROP TABLE IF EXISTS `content_img_nid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_img_nid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_img_nid`
--

LOCK TABLES `content_img_nid` WRITE;
/*!40000 ALTER TABLE `content_img_nid` DISABLE KEYS */;
INSERT INTO `content_img_nid` VALUES (1,1361852790,1361852790,1,1,1),(2,1361852795,1361852795,1,1,2),(3,1362731580,1362731580,1,1,3);
/*!40000 ALTER TABLE `content_img_nid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_post_int`
--

DROP TABLE IF EXISTS `content_post_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_post_int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_post_int`
--

LOCK TABLES `content_post_int` WRITE;
/*!40000 ALTER TABLE `content_post_int` DISABLE KEYS */;
INSERT INTO `content_post_int` VALUES (65,29,6,8),(64,29,6,9),(63,29,6,13),(41,28,6,5),(11,29,7,4),(16,28,7,3),(68,29,8,7),(67,29,8,6),(32,29,9,3),(42,28,8,6),(40,28,9,3),(112,21,6,11),(109,8,6,7),(45,8,7,4),(111,8,8,6),(47,8,9,3),(70,27,6,8),(54,27,7,0),(69,27,6,12),(66,29,6,5),(71,27,6,5),(108,8,6,11),(121,30,6,5),(120,30,6,8),(124,30,8,7),(123,30,8,13),(84,30,9,3),(87,30,7,4),(122,30,8,12),(110,8,8,12),(113,21,7,3),(125,30,21,2),(126,30,22,1),(127,30,23,3);
/*!40000 ALTER TABLE `content_post_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_post_nid`
--

DROP TABLE IF EXISTS `content_post_nid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_post_nid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_post_nid`
--

LOCK TABLES `content_post_nid` WRITE;
/*!40000 ALTER TABLE `content_post_nid` DISABLE KEYS */;
INSERT INTO `content_post_nid` VALUES (1,1361353274,1361353274,1,0,1),(2,1361353330,1361353330,1,0,2),(3,1361353596,1361353596,1,1,3),(4,1361353633,1361353633,1,0,21),(5,1361353665,1361353665,1,1,4),(6,1361353667,1361353667,1,1,4),(7,1361353680,1361353680,1,1,2),(8,1361353830,1361353830,1,1,26),(9,1361353836,1361353836,1,1,4),(10,1361353848,1361353848,1,0,1),(11,1361353904,1361353904,1,1,1),(12,1361353961,1361353961,1,1,1),(13,1361353970,1361353970,1,0,4),(14,1361354014,1361354014,1,0,4),(15,1361354045,1361354045,1,0,4),(16,1361354104,1361354104,1,0,16),(17,1361354254,1361354254,1,0,1),(18,1361359251,1361359251,1,0,18),(19,1361759552,1361759552,1,1,2),(20,1361759613,1361759613,1,1,2),(21,1361759615,1361759615,1,1,28),(22,1361759616,1361759616,1,1,4),(23,1361759616,1361759616,1,1,4),(24,1361759630,1361759630,1,1,4),(25,1361759651,1361759651,1,1,8),(26,1361759694,1361759694,1,1,4),(27,1361759764,1361759764,1,0,27),(28,1361759781,1361759781,1,1,30),(29,1361761491,1361761491,1,1,2),(30,1361867622,1361867622,1,1,25);
/*!40000 ALTER TABLE `content_post_nid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_post_text`
--

DROP TABLE IF EXISTS `content_post_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_post_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_post_text`
--

LOCK TABLES `content_post_text` WRITE;
/*!40000 ALTER TABLE `content_post_text` DISABLE KEYS */;
INSERT INTO `content_post_text` VALUES (1,1,3,'内容11'),(2,2,3,'内容3333'),(3,3,3,''),(4,4,3,'asdfadf'),(5,5,3,'sdfsafdsf'),(6,6,3,'sdfsafdsf'),(7,7,3,'fasdfadf'),(8,8,3,'asdfadf'),(9,9,3,'asdfadf'),(10,10,3,'23232'),(11,11,3,'2323'),(12,12,3,'23'),(13,13,3,'2323'),(14,14,3,'werwer'),(15,15,3,'12'),(16,16,3,'23'),(17,17,3,'22'),(18,18,3,'测试内容000'),(19,19,3,'s'),(20,32,3,'q'),(21,34,3,'ee'),(22,27,3,''),(23,28,3,'000\r\n'),(24,29,3,'测试内容'),(25,30,3,'c'),(26,21,3,'asssss');
/*!40000 ALTER TABLE `content_post_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_post_varchar`
--

DROP TABLE IF EXISTS `content_post_varchar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_post_varchar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_post_varchar`
--

LOCK TABLES `content_post_varchar` WRITE;
/*!40000 ALTER TABLE `content_post_varchar` DISABLE KEYS */;
INSERT INTO `content_post_varchar` VALUES (1,1,2,'标题先122'),(2,2,2,'标题2'),(3,3,2,'tset'),(4,4,2,'asdfasdf'),(5,5,2,'test'),(6,6,2,'test'),(7,7,2,'asdfasd'),(8,8,2,'afasdf33'),(9,9,2,'afasdf'),(10,10,2,'23'),(11,11,2,'2323'),(12,12,2,'23'),(13,13,2,'3223'),(14,14,2,'wer'),(15,15,2,'12测试'),(16,16,2,'23'),(17,17,2,'22'),(18,18,2,'测试标题22'),(19,18,4,'男'),(20,1,4,'女'),(21,2,4,'男'),(22,3,4,'男'),(23,4,4,'女'),(24,15,4,'男'),(25,19,2,'aa'),(26,19,4,'a'),(27,20,2,'qq'),(28,21,2,'qq'),(29,22,2,'qq'),(30,23,2,'qq'),(31,24,2,'qq'),(32,25,2,'qq'),(33,20,4,'q'),(34,26,2,'eee'),(35,21,4,'e'),(36,27,2,'rr'),(37,27,4,'rr'),(38,28,2,'qw'),(39,29,2,'测试标题'),(40,29,4,''),(41,28,4,''),(42,28,10,'sfdsf'),(43,28,11,'aaa'),(44,8,4,'男'),(45,8,10,'http://baidu.com'),(46,8,11,'tet'),(47,29,10,'地址'),(48,29,11,'文本哦'),(49,27,10,'a'),(50,27,11,'b3'),(51,30,4,'a'),(52,30,2,'b'),(53,30,10,'aaa'),(54,30,11,'sdfd'),(55,21,10,'sdfsf');
/*!40000 ALTER TABLE `content_post_varchar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_test_int`
--

DROP TABLE IF EXISTS `content_test_int`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_test_int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_test_int`
--

LOCK TABLES `content_test_int` WRITE;
/*!40000 ALTER TABLE `content_test_int` DISABLE KEYS */;
INSERT INTO `content_test_int` VALUES (4,1,20,2);
/*!40000 ALTER TABLE `content_test_int` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_test_nid`
--

DROP TABLE IF EXISTS `content_test_nid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_test_nid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_test_nid`
--

LOCK TABLES `content_test_nid` WRITE;
/*!40000 ALTER TABLE `content_test_nid` DISABLE KEYS */;
INSERT INTO `content_test_nid` VALUES (1,1361791157,1361791157,1,1,1);
/*!40000 ALTER TABLE `content_test_nid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_video_nid`
--

DROP TABLE IF EXISTS `content_video_nid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_video_nid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_video_nid`
--

LOCK TABLES `content_video_nid` WRITE;
/*!40000 ALTER TABLE `content_video_nid` DISABLE KEYS */;
INSERT INTO `content_video_nid` VALUES (1,1361778769,1361778769,1,1,1),(2,1361779064,1361779064,1,1,2);
/*!40000 ALTER TABLE `content_video_nid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_video_varchar`
--

DROP TABLE IF EXISTS `content_video_varchar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_video_varchar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_video_varchar`
--

LOCK TABLES `content_video_varchar` WRITE;
/*!40000 ALTER TABLE `content_video_varchar` DISABLE KEYS */;
INSERT INTO `content_video_varchar` VALUES (1,1,13,'标题'),(2,1,14,'内容'),(3,2,13,'aaa'),(4,2,14,'bbbb');
/*!40000 ALTER TABLE `content_video_varchar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(200) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields`
--

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
INSERT INTO `fields` VALUES (1,'文章','post',0,0),(2,'标题','title',1,23),(3,'内容','body',1,22),(4,'性别','sex',1,21),(6,'单选','dan',1,11),(7,'新性别','news',1,10),(8,'check','checkbox',1,9),(9,'radio','radio',1,8),(10,'网址','url',1,7),(11,'文本','aa',1,6),(12,'视频','video',0,0),(13,'title','title',12,0),(14,'视频','video',12,0),(15,'相册','album',0,0),(16,'名称','name',15,0),(17,'图片','img',0,0),(18,'图片','file',17,0),(19,'test','test',0,0),(20,'图片','img',19,0),(21,'图片','pic',1,4),(22,'文件','file',1,3),(23,'2文件','ff',1,2);
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields_table`
--

DROP TABLE IF EXISTS `fields_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `db_type` varchar(200) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `taxonomy` int(11) DEFAULT NULL,
  `belongs_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields_table`
--

LOCK TABLES `fields_table` WRITE;
/*!40000 ALTER TABLE `fields_table` DISABLE KEYS */;
INSERT INTO `fields_table` VALUES (1,2,'text','varchar',0,0,NULL),(2,3,'textarea','text',0,0,0),(3,4,'text','varchar',0,0,NULL),(5,6,'select','int',1,2,0),(6,7,'select','int',0,1,0),(7,8,'checkbox','int',0,2,0),(8,9,'radiobox','int',0,1,0),(9,10,'text','varchar',0,0,0),(10,11,'text','varchar',0,0,0),(11,13,'text','varchar',0,0,0),(12,14,'text','varchar',0,0,0),(13,16,'text','varchar',0,0,0),(14,18,'file','int',0,0,0),(15,20,'file','int',0,0,NULL),(16,21,'file','int',0,0,NULL),(17,22,'file','int',0,0,NULL),(18,23,'file','int',0,0,NULL);
/*!40000 ALTER TABLE `fields_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields_validate`
--

DROP TABLE IF EXISTS `fields_validate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields_validate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields_validate`
--

LOCK TABLES `fields_validate` WRITE;
/*!40000 ALTER TABLE `fields_validate` DISABLE KEYS */;
INSERT INTO `fields_validate` VALUES (41,2,'required',NULL,0),(16,6,'required',NULL,0),(19,7,'required',NULL,0),(20,10,'required',NULL,0),(21,13,'required',NULL,0),(22,14,'required',NULL,0),(23,16,'required',NULL,0),(24,18,'required',NULL,0),(31,21,'required',NULL,0),(39,22,'required',NULL,0),(40,22,'max:','1',0),(42,2,'min:','1',0);
/*!40000 ALTER TABLE `fields_validate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NOT NULL,
  `uniqid` varchar(255) NOT NULL,
  `size` float NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'uploads/2013/02/26/ec958b6d0ff94470660cdea0f0dc0f0e.jpg','1e4f8b287b519e356ca6b2329ba71253',15616,'image/jpeg'),(2,'uploads/2013/02/26/a19c347befe8d2a3a2f5ea921ecba86b.JPG','3435071a2780bb8836d54cb29670f361',9814,'image/jpeg'),(3,'uploads/2013/02/26/b5e48d555d9c7b96d94d8ffdfb2a6d7f.jpg','81fb5f4f1202bbc2dec0d65c72badb1b',12375,'image/jpeg'),(4,'uploads/2013/02/28/512edea3c22c39.37084301affd6fd58c92ad7ea5b319d04f11e33d.jpg','9e126464c3f4712b03a0a7a33e3be4e6',45118,'file'),(5,'uploads/2013/02/28/512ee25d410004.91726405c22afa4f6dc27ed5f81ff612d88f408f.jpg','1ccb21f7105b8c297bc3e1f2bd3b833b',57842,'file'),(6,'uploads/2013/02/28/512ee2b3d29287.11822395d0111f09f9493b8136f7e1f3eb8a5132.jpg','d9a12a02731d89cae72a75d565d55dff',54317,'file'),(7,'uploads/2013/02/28/512eeb83dc3bb5.734822502ec5cf09e75aeaf37d11c10f317bf8f7.jpg','75923a78f0e8b07c0b83a596331b5136',63372,'file'),(8,'uploads/2013/03/08/0793091ae8f8be6a19a9620d01df9b20.jpg','32225c9159144732d5c2296e61e2703b',3151,'image/jpeg'),(9,'uploads/2013/03/08/389110f7fd52a16824d706dd187c55bf.jpg','563b5bde80ad0b7592934c81f1476f76',46157,'image/jpeg'),(10,'uploads/2013/03/08/2ed7c4bbf2b32855a749ffe7089b79b5.jpg','00ad77ddea75f02fdd83f2a64452d781',351059,'image/jpeg'),(11,'uploads/2013/03/08/d12789f58070e15fe3e885feec26b207.jpg','afcce0f8dd70a64fc54e1d52255d6b18',410401,'image/jpeg');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagecache`
--

DROP TABLE IF EXISTS `imagecache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagecache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagecache`
--

LOCK TABLES `imagecache` WRITE;
/*!40000 ALTER TABLE `imagecache` DISABLE KEYS */;
INSERT INTO `imagecache` VALUES (1,'系统默认','','a:2:{s:7:\"quality\";s:2:\"75\";s:6:\"resize\";a:3:{s:5:\"width\";s:3:\"100\";s:6:\"height\";s:3:\"100\";s:8:\"checkbox\";s:1:\"1\";}}'),(2,'test','','a:1:{s:7:\"bgcolor\";s:4:\"#000\";}');
/*!40000 ALTER TABLE `imagecache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(40) NOT NULL,
  `last_activity` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('kn0aH89wXmNTnD9oXcaTj8CkyXACFUOvV0U3bEpH',1359541917,'a:3:{s:5:\":new:\";a:0:{}s:5:\":old:\";a:0:{}s:10:\"csrf_token\";s:40:\"R76uiIGBDRgOnqjVHzlIfFtc9sLMJ6TQsc16CwLw\";}'),('sF2GPR5O4ehTjEOcRCvAimvDp6GBD5uYfiW7Oc5N',1359541923,'a:3:{s:5:\":new:\";a:0:{}s:5:\":old:\";a:0:{}s:10:\"csrf_token\";s:40:\"xP0vsYuLuL2z0E1vSiaVNlgqNnffjiYR0OgaVnFs\";}');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxonomy`
--

DROP TABLE IF EXISTS `taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `pid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxonomy`
--

LOCK TABLES `taxonomy` WRITE;
/*!40000 ALTER TABLE `taxonomy` DISABLE KEYS */;
INSERT INTO `taxonomy` VALUES (1,'性别',0,0,1),(2,'省份',0,0,1),(3,'男',1,4,1),(4,'女',1,3,1),(5,'北京',2,14,1),(6,'南京',2,13,0),(7,'上海',2,15,1),(8,'江苏',2,11,0),(9,'安徽',2,10,1),(10,'上海',2,9,1),(11,'福建',2,8,1),(12,'四川',2,12,1),(13,'山东',2,16,1),(14,'上海',2,7,1),(15,'上海22',2,6,1),(16,'山东0',2,5,1);
/*!40000 ALTER TABLE `taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2a$08$ZQsKgcrbVt0DpfgxLTln3ucjhP.ch9Qme/Y9q0/wyjQNlZTQN57De');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `views`
--

DROP TABLE IF EXISTS `views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `memo` text NOT NULL,
  `sort` int(11) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `views`
--

LOCK TABLES `views` WRITE;
/*!40000 ALTER TABLE `views` DISABLE KEYS */;
INSERT INTO `views` VALUES (1,0,0,'a:10:{s:2:\"id\";b:1;s:3:\"dan\";b:1;s:4:\"news\";b:1;s:8:\"checkbox\";b:1;s:5:\"radio\";b:1;s:3:\"url\";b:1;s:5:\"video\";b:1;s:4:\"name\";b:1;s:3:\"img\";b:1;s:4:\"file\";b:1;}',0,0);
/*!40000 ALTER TABLE `views` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-08 16:41:48
