-- MySQL dump 10.13  Distrib 8.3.0, for Win64 (x86_64)
--
-- Host: localhost    Database: web-library
-- ------------------------------------------------------
-- Server version	8.3.0

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `author` varchar(64) NOT NULL,
  `rent_price` decimal(10,2) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `description_short` varchar(255) NOT NULL,
  `description_long` tinytext NOT NULL,
  `stock_quantity` int NOT NULL,
  `available_for_rent` tinyint(1) NOT NULL DEFAULT '1',
  `available_for_purchase` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  CONSTRAINT `book_chk_1` CHECK ((`stock_quantity` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (7,'1984','George Orwell',6.00,12.50,'A dystopian novel about surveillance.','Explores the dangers of totalitarianism and extreme political ideology.',3,1,1),(8,'To Kill a Mockingbird','Harper Lee',4.50,15.00,'A novel about racial injustice.','A powerful story about morality, law, and human nature.',4,1,1),(9,'Moby Dick','Herman Melville',7.00,9.99,'A seafaring adventure.','An epic tale of obsession and revenge on the high seas.',2,1,0),(10,'The Hobbit','J.R.R. Tolkien',6.50,20.00,'A fantasy adventure.','A thrilling journey through Middle-earth with Bilbo Baggins.',6,0,1),(11,'The Great Gatsby (Updated)','F. Scott Fitzgerald',6.99,13.99,'An updated short description...','An updated long detailed description...',8,1,1),(12,'1984','George Orwell',6.00,12.50,'A dystopian novel about surveillance.','Explores the dangers of totalitarianism and extreme political ideology.',3,1,1),(13,'To Kill a Mockingbird','Harper Lee',4.50,15.00,'A novel about racial injustice.','A powerful story about morality, law, and human nature.',4,1,1),(14,'Moby Dick','Herman Melville',7.00,9.99,'A seafaring adventure.','An epic tale of obsession and revenge on the high seas.',2,1,0),(15,'The Hobbit','J.R.R. Tolkien',6.50,20.00,'A fantasy adventure.','A thrilling journey through Middle-earth with Bilbo Baggins.',6,0,1),(16,'The Great Gatsby','F. Scott Fitzgerald',3.99,10.99,'A classic novel set in the 1920s.','A deep dive into the American dream and the Roaring Twenties.',5,1,1),(17,'1984','George Orwell',4.50,12.50,'A dystopian novel about surveillance.','Explores the dangers of totalitarianism and extreme political ideology.',3,1,1),(18,'To Kill a Mockingbird','Harper Lee',5.00,15.00,'A novel about racial injustice.','A powerful story about morality, law, and human nature.',4,1,1),(19,'Moby Dick','Herman Melville',2.99,9.99,'A seafaring adventure.','An epic tale of obsession and revenge on the high seas.',2,1,0),(20,'The Hobbit','J.R.R. Tolkien',6.00,20.00,'A fantasy adventure.','A thrilling journey through Middle-earth with Bilbo Baggins.',6,0,1),(21,'Test book','Lazar Matic',5.99,24.99,'short description','Test book long description',5,0,1),(22,'The Newest Book','Lazar Matic',5.99,12.99,'A short description...','A long detailed description...',10,1,1);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookrental`
--

DROP TABLE IF EXISTS `bookrental`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookrental` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `rental_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Rented','Returned') NOT NULL DEFAULT 'Rented',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `bookrental_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookrental_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookrental`
--

LOCK TABLES `bookrental` WRITE;
/*!40000 ALTER TABLE `bookrental` DISABLE KEYS */;
INSERT INTO `bookrental` VALUES (11,7,7,'2025-03-26','2025-03-26','Returned'),(12,7,7,'2025-03-26','2025-03-26','Rented'),(13,7,7,'2025-03-26','2025-03-26','Rented'),(14,7,7,'2025-03-26','2025-03-26','Rented');
/*!40000 ALTER TABLE `bookrental` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookstore`
--

DROP TABLE IF EXISTS `bookstore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookstore` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `purchase_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `bookstore_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookstore_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookstore_chk_1` CHECK ((`quantity` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookstore`
--

LOCK TABLES `bookstore` WRITE;
/*!40000 ALTER TABLE `bookstore` DISABLE KEYS */;
INSERT INTO `bookstore` VALUES (5,5,11,'2025-03-26 13:23:11',3,40.00),(6,1,15,'2025-03-26 13:26:51',3,45.00);
/*!40000 ALTER TABLE `bookstore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `review_text` text,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (2,3,10,'Very thought-provoking and relevant even today.','2025-03-21 14:57:11'),(5,3,10,'Review text','2025-03-25 09:22:01');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `passw` varchar(64) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'updatedUsername','Updated User','updated@gmail.com','123456789','password123','Admin'),(2,'admin2','Librarian Two','admin2@example.com','0987654321','securepass1','Admin'),(3,'user1','John Doe','john.doe@example.com','1112223333','password123','User'),(5,'johndoe','John Doe','john@example.com','13540004','$2y$10$0018GsWIiJDobgp5N9GWcO7pZiNu4KQ9mhUzHMl6f/O4w/Dgqqaee','User'),(7,'johndoeNEW','John New','johnNEW@example.com','13540004','$2y$10$CDbiTUiMeFuZ.TyDhOs2MeDGvTVCQdcyOq4u4tTDdTeIfHaNpJS5e','User'),(8,'johndoeNEWEST','John Newest','johnNEWEST@example.com','13540004','$2y$10$W7y0LSpTj3h48df4g93gS.lnbJFcFC3l3jS9hURhwD/FNZb1VbSiK','User'),(11,'testusername','Lazar Matic','testing@gmail.com','063312245','passwordtest','Admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'web-library'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-05 17:05:15
