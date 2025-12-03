/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 11.7.2-MariaDB : Database - seghis_patient_portal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`seghis_patient_portal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;

USE `seghis_patient_portal`;

/*Table structure for table `appointments` */

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_user_id_foreign` (`user_id`),
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `appointments` */

insert  into `appointments`(`id`,`user_id`,`title`,`appointment_date`,`appointment_time`,`notes`,`status`,`created_at`,`updated_at`) values 
(1,10,'Checkup','2025-12-10','08:30:00','Sample notes for appointment 1','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(2,11,'Checkup','2025-12-15','12:00:00','Sample notes for appointment 1','Cancelled','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(3,12,'Checkup','2025-11-25','16:00:00','Sample notes for appointment 1','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(4,12,'Checkup','2025-12-05','12:00:00','Sample notes for appointment 2','Cancelled','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(5,12,'Checkup','2025-12-16','08:00:00','Sample notes for appointment 3','Cancelled','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(6,24,'Checkup','2025-12-13','12:00:00','Sample notes for appointment 1','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(7,24,'Checkup','2025-12-16','17:00:00','Sample notes for appointment 2','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(8,29,'Checkup','2025-12-12','17:00:00','Sample notes for appointment 1','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(9,29,'Checkup','2025-11-29','13:00:00','Sample notes for appointment 2','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(10,31,'Checkup','2025-12-27','09:00:00','Sample notes for appointment 1','Pending','2025-11-18 06:47:45','2025-11-19 03:34:51'),
(11,31,'Checkup','2025-12-13','11:00:00','Sample notes for appointment 2','Pending','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(14,34,'Checkup','2025-12-03','14:00:00','Sample notes for appointment 2','Cancelled','2025-11-18 06:47:45','2025-11-18 21:11:29'),
(15,35,'Checkup','2025-12-01','08:00:00','Sample notes for appointment 1','Cancelled','2025-11-18 06:47:45','2025-11-18 21:21:47'),
(16,35,'Checkup','2025-11-22','15:00:00','Sample notes for appointment 2','Cancelled','2025-11-18 06:47:45','2025-11-18 06:47:45'),
(19,38,'For Checkup','2025-11-20','08:00:00','Sample notes for appointment 2','Cancelled','2025-11-18 06:47:45','2025-11-18 21:22:07'),
(20,38,'Laboratory','2025-11-18','16:43:00','asdsad','Confirmed','2025-11-18 08:39:46','2025-11-18 21:24:13'),
(22,38,'Medical Exam','2025-11-12','08:50:00','Edit Appointment','Pending','2025-11-18 19:45:08','2025-11-19 05:11:57'),
(26,24,'Medical Exam','2025-11-24','08:30:00','Your notes','Pending','2025-11-19 03:37:27','2025-11-19 03:38:47'),
(28,46,'Medical Exam','2025-11-20','08:20:00','Notes','Pending','2025-11-19 05:18:15','2025-11-19 05:20:26'),
(34,46,'Check up','2025-11-29','13:54:00','Cancel','Pending','2025-11-19 05:51:02','2025-11-19 05:53:04'),
(36,46,'test','2025-11-21','09:33:00','teset atasdfg saddsadgasgasdfg  agadf','Pending','2025-11-19 09:29:55','2025-11-19 09:30:13'),
(42,46,'test','2025-11-27','10:30:00','test test','Confirmed','2025-11-23 12:29:52','2025-11-24 02:37:33'),
(46,49,'TEST TWO','2025-11-24','08:30:00','TEST','Confirmed','2025-11-23 13:10:34','2025-11-23 13:10:34'),
(48,53,'Medical Exam','2025-11-29','10:30:00','Test test','Confirmed','2025-11-24 02:25:55','2025-11-24 02:29:41');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `files` */

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medical_record_id` bigint(20) unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_medical_record_id_foreign` (`medical_record_id`),
  CONSTRAINT `files_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `files` */

insert  into `files`(`id`,`medical_record_id`,`file_path`,`file_name`,`file_type`,`file_size`,`created_at`,`updated_at`) values 
(4,31,'medical_records/IbDWpsCHp728wnbZ8Vsj2dsJ2axVfSlDn0zWiPpf.pdf','Medical Result.pdf','application/pdf',186905,'2025-11-19 07:50:21','2025-11-19 07:50:21'),
(5,38,'medical_records/bqisZdKnnJ22N0XlIyQYByEWPWfJcEUIRgiEFnTT.pdf','Medical Result 1.pdf','application/pdf',188418,'2025-11-19 07:51:35','2025-11-19 07:51:35'),
(10,38,'medical_records/uSDWuNdHfRdR5Ia4TkYk3ld56PoEynlWI6zxaiJU.pdf','Medical Result 2.pdf','application/pdf',188432,'2025-11-19 08:03:23','2025-11-19 08:03:23'),
(11,38,'medical_records/cHNsJH58UronfvfVZEqxCa1wnUd7jlZUN14xMp1e.pdf','Medical Result.pdf','application/pdf',186905,'2025-11-19 08:03:43','2025-11-19 08:03:43'),
(14,38,'medical_records/GatF3KLEYUE8DmF7WwmZTtdt6gUebOqfQBNgG0to.pdf','Medical Result.pdf','application/pdf',186905,'2025-11-19 09:03:05','2025-11-19 09:03:05'),
(15,31,'medical_records/tdpaU50f5ur7DJDSxBLSY1jw2uuHfouVVUXcVrBr.pdf','Medical Result 1.pdf','application/pdf',188418,'2025-11-19 09:03:11','2025-11-19 09:03:11'),
(17,26,'medical_records/UsI4Lde8KLExu1VxBLA8uuoDAui2xwz5keH27AQd.pdf','Medical Result 2.pdf','application/pdf',188432,'2025-11-19 09:03:55','2025-11-19 09:03:55'),
(18,40,'medical_records/4umXMwBNaejXLGsfxnK3mVBS9ft8GgjPbY3GZ1AS.pdf','Medical Result 2.pdf','application/pdf',188432,'2025-11-19 09:06:47','2025-11-19 09:06:47'),
(19,41,'medical_records/KfZ9JOnKZUXQYxxmfTWBk8JuTFDTzPXvLz88LWFm.pdf','Medical Result 2.pdf','application/pdf',188432,'2025-11-23 12:00:01','2025-11-23 12:00:01'),
(20,42,'medical_records/BEl3xXDZJ8tKpihKepBtyY2YoO1VYaNWU0DG6BjA.pdf','Medical Result 1.pdf','application/pdf',188418,'2025-11-24 02:32:56','2025-11-24 02:32:56');

/*Table structure for table `medical_records` */

DROP TABLE IF EXISTS `medical_records`;

CREATE TABLE `medical_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `record_type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_records_patient_id_foreign` (`patient_id`),
  CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `medical_records` */

insert  into `medical_records`(`id`,`patient_id`,`record_type`,`description`,`record_date`,`created_at`,`updated_at`) values 
(1,32,'Lab Result','Sample description for patient 4','2025-10-01','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(2,4,'Vaccination','Sample description for patient 4','2024-11-19','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(3,4,'Lab Result','Sample description for patient 4','2025-10-05','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(4,5,'Vaccination','Sample description for patient 5','2025-01-16','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(5,5,'Lab Result','Sample description for patient 5','2025-11-08','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(6,5,'X-ray','Sample description for patient 5','2025-07-13','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(7,6,'Lab Result','Sample description for patient 6','2024-11-29','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(8,6,'Lab Result','Sample description for patient 6','2025-09-09','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(9,6,'Vaccination','Sample description for patient 6','2025-06-21','2025-11-17 15:34:49','2025-11-17 15:34:49'),
(13,4,'PE','asdasdads','2025-11-07','2025-11-18 23:11:21','2025-11-18 23:11:21'),
(14,5,'X-ray','sadfasdfasdf','2025-11-08','2025-11-18 23:14:18','2025-11-18 23:14:18'),
(15,5,'X-ray','sadfasdfasdf','2025-11-08','2025-11-18 23:14:33','2025-11-18 23:14:33'),
(16,5,'X-ray','sadfasdfasdf','2025-11-08','2025-11-18 23:14:37','2025-11-18 23:14:37'),
(17,5,'PE','qwewqe','2025-11-06','2025-11-18 23:14:47','2025-11-18 23:14:47'),
(18,23,'Lab Result','sadfasdfasdfs','2025-11-07','2025-11-18 23:16:18','2025-11-18 23:16:18'),
(19,4,'X-ray','sadfasdfasdfsdaf','2025-11-14','2025-11-19 00:31:57','2025-11-19 00:31:57'),
(20,18,'X-ray','Good','2025-11-15','2025-11-19 03:24:56','2025-11-19 03:24:56'),
(21,18,'Physical Exam','Good','2025-11-14','2025-11-19 03:27:41','2025-11-19 03:27:41'),
(24,5,'Physical Exam','PE Description','2025-11-12','2025-11-19 06:17:44','2025-11-23 14:10:39'),
(25,18,'Vaccination','Test result','2025-11-13','2025-11-19 06:32:57','2025-11-19 06:32:57'),
(26,18,'Vaccination','Test result','2025-11-13','2025-11-19 06:37:00','2025-11-19 06:37:00'),
(31,18,'Physical Exam','PE Description','2025-11-08','2025-11-19 06:44:41','2025-11-23 14:10:13'),
(38,18,'X-ray','Medical Result 1','2025-11-15','2025-11-19 07:51:35','2025-11-19 07:51:35'),
(40,6,'Lab Result','Lab result','2025-11-18','2025-11-19 09:06:47','2025-11-19 09:06:47'),
(41,41,'X-ray','X-ray result','2025-11-20','2025-11-23 12:00:00','2025-11-23 12:00:00'),
(42,45,'Physical Exam','Result','2025-11-29','2025-11-24 02:32:55','2025-11-24 02:32:55');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2025_11_16_203046_role',2),
(6,'2025_11_16_203157_user_role',2),
(7,'2025_11_17_004527_patient_table',3),
(8,'2025_11_17_152752_create_medical_records_table',4),
(9,'2025_11_18_062732_create_appointments_table',5),
(10,'2025_11_18_223550_create_notifications_table',6),
(11,'2025_11_19_062313_create_files_table',7);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_patient_id_foreign` (`patient_id`),
  CONSTRAINT `notifications_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

insert  into `notifications`(`id`,`patient_id`,`type`,`message`,`status`,`created_at`,`updated_at`) values 
(1,32,'info','Your X-ray result is now available.','Unread','2025-11-19 00:31:57','2025-11-19 00:31:57'),
(2,18,'info','Your X-ray result is now available.','Unread','2025-11-19 03:24:56','2025-11-19 03:24:56'),
(3,18,'info','Your Physical Exam result is available.','Unread','2025-11-19 03:27:41','2025-11-19 03:27:41'),
(5,18,'info','Your Physical Exam result is now available.','Unread','2025-11-19 05:39:55','2025-11-19 05:39:55'),
(6,5,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:17:44','2025-11-19 06:17:44'),
(7,18,'info','Your Vaccination result is now available.','Unread','2025-11-19 06:37:00','2025-11-19 06:37:00'),
(8,18,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:39:50','2025-11-19 06:39:50'),
(9,18,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:45:09','2025-11-19 06:45:09'),
(10,5,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:46:46','2025-11-19 06:46:46'),
(11,5,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:46:55','2025-11-19 06:46:55'),
(12,18,'info','Your Physical Exam result is now available.','Unread','2025-11-19 06:47:12','2025-11-19 06:47:12'),
(13,23,'info','Your Lab Result result is now available.','Unread','2025-11-19 06:48:11','2025-11-19 06:48:11'),
(14,23,'info','Your X-ray result has been updated.','Unread','2025-11-19 07:37:24','2025-11-19 07:37:24'),
(15,23,'info','Your X-ray result has been updated.','Unread','2025-11-19 07:38:17','2025-11-19 07:38:17'),
(16,23,'info','Your Physical Exam result has been updated.','Unread','2025-11-19 07:39:38','2025-11-19 07:39:38'),
(17,6,'info','Your Vaccination result is now available.','Unread','2025-11-19 07:40:53','2025-11-19 07:40:53'),
(18,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-19 07:50:21','2025-11-19 07:50:21'),
(19,18,'info','Your X-ray result is now available.','Unread','2025-11-19 07:51:35','2025-11-19 07:51:35'),
(20,18,'info','Your Vaccination result is now available.','Unread','2025-11-19 07:52:03','2025-11-19 07:52:03'),
(21,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-19 07:59:13','2025-11-19 07:59:13'),
(22,18,'info','Your Vaccination result has been updated.','Unread','2025-11-19 08:00:32','2025-11-19 08:00:32'),
(23,18,'info','Your Vaccination result has been updated.','Unread','2025-11-19 08:01:16','2025-11-19 08:01:16'),
(24,18,'info','Your X-ray result has been updated.','Unread','2025-11-19 08:03:23','2025-11-19 08:03:23'),
(25,18,'info','Your X-ray result has been updated.','Unread','2025-11-19 08:03:43','2025-11-19 08:03:43'),
(28,18,'info','Your X-ray result has been updated.','Unread','2025-11-19 09:03:05','2025-11-19 09:03:05'),
(29,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-19 09:03:11','2025-11-19 09:03:11'),
(30,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-19 09:03:16','2025-11-19 09:03:16'),
(31,18,'info','Your Vaccination result has been updated.','Unread','2025-11-19 09:03:55','2025-11-19 09:03:55'),
(32,6,'info','Your Lab Result result is now available.','Unread','2025-11-19 09:06:47','2025-11-19 09:06:47'),
(33,41,'info','Your X-ray result is now available.','Read','2025-11-23 12:00:01','2025-11-23 12:00:43'),
(34,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-23 14:10:13','2025-11-23 14:10:13'),
(35,5,'info','Your Physical Exam result has been updated.','Unread','2025-11-23 14:10:39','2025-11-23 14:10:39'),
(36,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-23 14:10:43','2025-11-23 14:10:43'),
(37,45,'info','Your Physical Exam result is now available.','Read','2025-11-24 02:32:56','2025-11-24 02:33:49'),
(38,18,'info','Your Physical Exam result has been updated.','Unread','2025-11-24 02:36:54','2025-11-24 02:36:54');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `patients` */

DROP TABLE IF EXISTS `patients`;

CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_user_id_unique` (`user_id`),
  UNIQUE KEY `patients_email_unique` (`email`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `patients` */

insert  into `patients`(`id`,`user_id`,`name`,`email`,`phone`,`address`,`date_of_birth`,`created_at`,`updated_at`) values 
(4,10,'Mark G. Dela Cruz','t@gmail.com','12344','qweqwe',NULL,'2025-11-17 08:21:05','2025-11-17 16:23:16'),
(5,11,'Glen Alex G. Dela Cruz','monday@gmail.com','12344','qweqwe',NULL,'2025-11-17 08:23:49','2025-11-17 16:47:16'),
(6,12,'Tuesday B. Santos','tuesday@gmail.com','33344','Davao City',NULL,'2025-11-17 08:24:38','2025-11-17 16:47:39'),
(18,24,'Aria Winslow','patient18@gmail.com','44323111','Davao City',NULL,'2025-11-17 09:13:35','2025-11-18 08:11:43'),
(23,29,'Liam Calder','patien23@gmail.com','5566666','qweqwe',NULL,'2025-11-17 09:25:07','2025-11-18 08:11:21'),
(25,31,'Maya Thornton','patient26@gmail.com','1233333','qweqwe',NULL,'2025-11-17 10:06:18','2025-11-18 08:11:07'),
(28,34,'Kairos Bennett','patient28@gmail.com','12344','Davao City',NULL,'2025-11-17 11:40:33','2025-11-18 08:10:46'),
(29,35,'Sophie Langford','tpatient28@gmail.com','12344','qweqwe',NULL,'2025-11-17 13:55:19','2025-11-18 08:10:31'),
(32,38,'Evan Mercer','lab123@gmail.com','12321321','Davao Citylab@gmail.com',NULL,'2025-11-17 15:24:51','2025-11-19 05:55:24'),
(41,49,'Alex G. Gonzaga','testname@gmail.com','1112222','Davao City',NULL,'2025-11-23 11:55:15','2025-11-23 22:40:30'),
(45,53,'Mark H. Dela Cruz','patientname@gmail.com','12321312','qwewqe',NULL,'2025-11-24 02:22:39','2025-11-24 02:30:39');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'admin','2025-11-16 20:59:53','2025-11-16 20:59:53'),
(2,'doctor','2025-11-16 20:59:53','2025-11-16 20:59:53'),
(3,'patient','2025-11-16 20:59:53','2025-11-16 20:59:53');

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `user_role_role_id_foreign` (`role_id`),
  CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_role` */

insert  into `user_role`(`id`,`user_id`,`role_id`) values 
(1,1,1),
(2,2,1),
(10,10,3),
(11,11,3),
(12,12,3),
(24,24,3),
(29,29,3),
(31,31,3),
(34,34,3),
(35,35,3),
(38,38,3),
(44,43,2),
(45,44,1),
(48,46,3),
(51,49,3),
(55,53,3);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin@example.com',NULL,'$2y$10$co90Eb7WkMOdW9qeYY1lw.uCwQXpN2x4eBFyYpogrRWL0rDsn/CxW',NULL,'2025-11-16 21:02:51','2025-11-16 21:02:51'),
(2,'jcdelacernajr@gmail.com',NULL,'$2y$10$UBpJBtISuiyOTFtXaFODPuyAfdP/PPs/Azt49NzjNR9gL8jz6zzg2','9SmoNr1p078Cw6zkh1aNvuJYt4mdsW6OkedTa4jFNaBKURsUh8SPAF4R23PS','2025-11-16 21:14:51','2025-11-16 21:14:51'),
(10,'t@gmail.com',NULL,'$2y$10$d66ed84OzGdSzKgVNwHmIe16omftU/X20S.boiWr7iACE5GoNdmkO',NULL,'2025-11-17 08:21:05','2025-11-17 16:25:15'),
(11,'monday@gmail.com',NULL,'$2y$10$ZzHWW0xJzQlKacnCMVFXJ.Z5SyTQ9s9QsVlj1X8jd6.tzOkj6f4Cq',NULL,'2025-11-17 08:23:49','2025-11-17 16:47:15'),
(12,'tuesday@gmail.com',NULL,'$2y$10$vP48qjePxyW2qdrcbpvwruPZH27.G.gXNeCFYjfuf6ACd6whChYjG',NULL,'2025-11-17 08:24:38','2025-11-17 16:47:39'),
(24,'patient18@gmail.com',NULL,'$2y$10$NOM9yfrk/FpP3Xm8rj17YeWEcTZa/BKkaqq2FYVEGFId4nyYbmzg2',NULL,'2025-11-17 09:13:35','2025-11-18 08:11:43'),
(29,'patien23@gmail.com',NULL,'$2y$10$zcCGEJ2AmXoN93W16pOMc.412/Qb8MprYeQy5GbGNUvmCIxOfjUHO',NULL,'2025-11-17 09:25:07','2025-11-20 05:44:47'),
(31,'patient26@gmail.com',NULL,'$2y$10$mU4rxNigRsgi56dIIpehUuvFjGa9RGo7n9Dw/w9SeTkDwxuu8ktj2',NULL,'2025-11-17 10:06:18','2025-11-18 08:11:07'),
(34,'patient28@gmail.com',NULL,'$2y$10$yDYB4MNQIDzll0tzlVdtQObzGb8KGrb1RdKO8E/EEaXGRABd72ODq',NULL,'2025-11-17 11:40:33','2025-11-18 08:10:46'),
(35,'tpatient28@gmail.com',NULL,'$2y$10$XGFbciOnuMZZKozcGkWuMOIZ/BRLesbkSTDS8/h61L.MoL2EM1YWC',NULL,'2025-11-17 13:55:19','2025-11-18 08:10:31'),
(38,'lab123@gmail.com',NULL,'$2y$10$LxUYGwzj/UZVAlbl7H5tTetkTLttYziOf3tP/74PP8avyy7PTrqL2',NULL,'2025-11-17 15:24:51','2025-11-19 05:55:24'),
(43,'doctoruser@gmail.com',NULL,'$2y$10$xYhQdeKdWcoOXYTjvxpib.aLus5QmtcF9QUuWlU.btED2fhxzb0fC',NULL,'2025-11-19 02:51:00','2025-11-19 02:51:00'),
(44,'seghisadmin@gmail.com',NULL,'$2y$10$qEb1Z.8m05mGKaZ8tFJNx.fSWBjOEgWyHztyhKqB517m7Flc1W6/e','BU1MGpPMdxKcm8iHWeL7KFuGmappOt7DbIkB5wufyoPytGdIEX4ZxCyYjYA1','2025-11-19 02:52:17','2025-11-20 05:33:47'),
(46,'lab@gmail.com',NULL,'$2y$10$.7IBESxmz4LQrVM28.Ouk.S5knkLvtgYfgN5kPiz4pEY23k1ePbeC',NULL,'2025-11-19 05:17:32','2025-11-23 11:53:05'),
(49,'testname@gmail.com',NULL,'$2y$10$e0tdTV4DJtZZLgNY0zygjeqqJB9P8AlwwQXms7m0gJ3wY0lyKNM7G',NULL,'2025-11-23 11:55:15','2025-11-23 22:40:30'),
(53,'patientname@gmail.com',NULL,'$2y$10$gmpBQxicXoWqYkcfonDSZegr1GU3WWUNJ83UXluSuTXue3DLpMFsC',NULL,'2025-11-24 02:22:39','2025-11-24 02:30:39');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
