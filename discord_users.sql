-- Database: discord_login
CREATE DATABASE IF NOT EXISTS `discord_login` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `discord_login`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `discord_id` VARCHAR(50) UNIQUE NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `discriminator` VARCHAR(10),
  `email` VARCHAR(150),
  `avatar` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
