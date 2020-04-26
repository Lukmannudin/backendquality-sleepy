/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.45-log : Database - db_diamondsleep
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_diamondsleep` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_diamondsleep`;

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis` enum('ADMIN','SUPERADMIN') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `admins` */

insert  into `admins`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`jenis`) values (1,'BayuWPP','bayubayyz@gmail.com','$2y$10$rT/pIRq4M6MtqcGDgmb2Z.sXScUVFijFROVwGRCkSeABBX.zvKj.m','wLyraWTUFTzlI9fToDUVyaU3spVqVOsLCMm0YBosyg15lNWOjwHeYtO7swDv','2017-03-22 07:21:02','2017-04-01 10:57:58','SUPERADMIN'),(4,'Bayu Firmawan Paoh','bayupaoh@gmail.com','$2y$10$uCTL2clK83vsw6yAOHXi0OMjihdOZ79dmfnPfeI3ebonA6E4S33Wy','ipVbZU3u2RbRYrlorTQyQz6hXGtJhZ3iApzldb5XqhZoClFUE1mnZl0QA4rM','2017-05-05 03:32:56','2017-05-05 03:32:56','ADMIN'),(11,'Yoga Tri Nugroho','yogatrinugroho@outlook.com','$2y$10$hh0WyRSAuh0Mvo.f3RvkOet6uOd4XUh6q4vsBDVVtUS2t1DNSkCiK',NULL,'2017-05-08 06:48:54','2017-05-08 06:48:54','ADMIN');

/*Table structure for table `article_tag` */

DROP TABLE IF EXISTS `article_tag`;

CREATE TABLE `article_tag` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned DEFAULT NULL,
  `tag_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_tag_ibfk_1` (`article_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `article_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `article_tag_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `article_tag` */

insert  into `article_tag`(`id`,`article_id`,`tag_id`) values (1,21,1);

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_admin` int(10) unsigned NOT NULL DEFAULT '1',
  `category_id` int(10) unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PUBLISHED','DRAFT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_fk_1` (`category_id`),
  KEY `articles_ibfk_2` (`id_admin`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

insert  into `articles`(`id`,`id_admin`,`category_id`,`title`,`slug`,`content`,`image`,`status`,`date`,`created_at`,`updated_at`,`deleted_at`) values (11,1,4,'Bahaya Tidur Malam','bahaya-tidur-malam','Tidur merupakan salah satu kebutuhan pokok manusia yang menurut para ahli fungsinya justru lebih penting dari makanan. Sebab seseorang akan dapat lebih lama bertahan hidup tanpa makanan dibandingkan tanpa tidur. Dengan tanpa makanan sama sekali, seseorang masih mampu bertahan hidup sekitar 40 hari, tanpa minuman seseorang mampu bertahan hidup sekitar 3 hari, tanpa udara kemampuan bertahan hidup seseorang hanya dalam hitungan menit, sedang tanpa tidur seseorang hanya mampu bertahan hidup selama 11 hari. Hal ini menunjukkan bahwa kebutuhan vital manusia jika diurutkan adalah: udara, air, tidur, serta makanan.\r\nNamun bagi Anda yang suka tidur terlalu malam, maka Anda sudah sepatutnya mengetahui bahayanya bagi kesehatan, berikut ini:\r\n\r\n1. Konsentrasi menurun.\r\nTidur yang baik berperan penting dalam beraktvitas dan berpikir. Maka dari itu, kurang tidur akan memberikan pengaruh yang kurang baik untuk badan dan pikiran. Seperti dapat mengganggu tingkat kewaspadaan, konsentrasi, penalaran, dan pemecahan masalah. Hal ini membuat belajar menjadi sulit dan tidak efisien.\r\n\r\n2. Pelupa.\r\nPada tahun 2009, peneliti dari Amerika dan Perancis memaparkan hasil penelitiannya bahwa peristiwa otak yang disebut sharp wave ripples bertanggungjawab menguatkan memori atau ingatan pada otak. Peristiwa ini juga mentransfer informasi dari hipokampus ke neokorteks di otak, tempat kenangan jangka panjang disimpan. Sharp wave ripples kebanyakan terjadi pada saat tidur.\r\n\r\n3. Masalah kesehatan serius.\r\nGangguan tidur dan kurang tidur tahap kronis dapat membawa Anda pada risiko:\r\n\r\nPenyakit jantung: gagal jantung; detak jantung tidak teratur, serangan jantung\r\nTekanan darah tinggi\r\nStroke\r\nDiabetes\r\n4. Menyebabkan depresi\r\nDalam studi tahun 1997, peneliti dari Universitas Pennsylvania melaporkan bahwa orang-orang yang tidur kurang dari 5 jam per hari selama seminggu, mudah terserang stres, marah, sedih, dan kelelahan mental. Hal inilah yang memicu tingkat depresi lebih tinggi.\r\n\r\n5. Mempengaruhi kesehatan kulit.\r\nKebanyakan orang mengalami kulit pucat dan mata bengkak setelah beberapa malam kurang tidur. Keadaan tersebut benar karena kurang tidur yang kronis dapat mengakibatkan kulit kusam, garis-garis halus pada wajah, dan lingkaran hitam di bawah mata. Bila Anda tidak mendapatkan cukup tidur, tubuh Anda melepaskan lebih banyak hormon stres atau kortisol. Dalam jumlah yang berlebihan, kortisol akan dapat memecah kolagen kulit atau protein yang justru membuat kulit tetap halus dan elastis.\r\n\r\n8. Risiko berat badan naik.\r\nKurang tidur juga berhubungan dengan peningkatan rasa lapar dan nafsu makan, dan dapat memicu obesitas. Menurut sebuah studi tahun 2004, hampir 30 persen dari orang-orang yang tidur kurang dari enam jam sehari cenderung menjadi lebih gemuk daripada mereka yang tidur tujuh sampai sembilan jam sehari.',NULL,'PUBLISHED','2017-05-05','2017-05-05 12:46:49','2017-05-05 12:47:14',NULL),(21,1,4,'Makan Buah Pisang Sebelum Tidur Meningkatkan Kualitas Tidur','makan-buah-pisang-sebelum-tidur-meningkatkan-kualitas-tidur','<p>Buah pisang memiliki khasiat yang dapat meingkatkan kualitas tidur.</p>\r\n\r\n<p>Saat Anda mengonsumsi buah pisang 1 jam sebelum tidur, hal ini dapat meningkatkan kualitas tidur yang baik. Selain itu, anda juga akan merasa tubuh menjadi lebih ringan dan rileks. Karena inilah, tidak heran jika konsumsi satu buah pisang saat malam akan membuat esok pagimun lebih semangat dan menyenangkan.</p>','uploads\\20 Manfaat Buah Pisang Untuk Kesehatan Tubuh - AyoKesehatan.jpg','PUBLISHED','2017-05-06','2017-05-06 10:42:33','2017-05-06 10:42:33',NULL);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`slug`,`created_at`,`updated_at`,`deleted_at`) values (2,'Tips','tips','2017-04-01 17:15:54','2017-04-01 17:15:54',NULL),(4,'Artikel','artikel','2017-04-01 18:43:09','2017-04-01 18:43:09',NULL),(5,'Berita','berita','2017-05-05 02:58:39','2017-05-05 02:58:39',NULL);

/*Table structure for table `kualitas_tidur` */

DROP TABLE IF EXISTS `kualitas_tidur`;

CREATE TABLE `kualitas_tidur` (
  `id` int(10) DEFAULT NULL,
  `id_device` varchar(20) DEFAULT NULL,
  `subjektif_kualitas_tidur` int(11) DEFAULT NULL,
  `latensi_tidur` int(11) DEFAULT NULL,
  `efisiensi_kebiasaan_tidur` int(11) DEFAULT NULL,
  `gangguan_tidur` int(11) DEFAULT NULL,
  `penggunaan_obat` int(11) DEFAULT NULL,
  `disfungsi_siang_hari` int(11) DEFAULT NULL,
  `tanggal` varchar(25) DEFAULT NULL,
  KEY `kualitastidur_fk_1` (`id_device`),
  CONSTRAINT `kualitastidur_fk_1` FOREIGN KEY (`id_device`) REFERENCES `user_device` (`id_device`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kualitas_tidur` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(60) CHARACTER SET latin1 NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_at` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `password_resets` */

/*Table structure for table `pola_tidur` */

DROP TABLE IF EXISTS `pola_tidur`;

CREATE TABLE `pola_tidur` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_device` varchar(20) DEFAULT NULL,
  `waktu_tidur` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `waktu_bangun` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `waktu_untuk_tidur` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `cahaya` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `suhu` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `kebisingan` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `tanggal` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `polatidur_fk_iddevice` (`id_device`),
  CONSTRAINT `polatidur_fk_iddevice` FOREIGN KEY (`id_device`) REFERENCES `user_device` (`id_device`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `pola_tidur` */

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `tags` */

insert  into `tags`(`id`,`name`,`created_at`,`updated_at`) values (1,'Latensi Tidur','2017-05-06 03:10:49','2017-05-06 10:20:02'),(11,'Durasi Tidur','2017-05-06 10:35:22','2017-05-06 10:35:22'),(21,'Efisiensi Kebiasaan Tidur','2017-05-06 13:54:32','2017-05-06 13:54:32');

/*Table structure for table `user_device` */

DROP TABLE IF EXISTS `user_device`;

CREATE TABLE `user_device` (
  `id_device` varchar(20) NOT NULL,
  `nama_device` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_device`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_device` */

insert  into `user_device`(`id_device`,`nama_device`) values ('hjhj21','Acer S51'),('hjhj211','Acer S51');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
