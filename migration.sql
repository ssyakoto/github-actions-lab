-- ==========================================
-- 📁 Файл миграции: migration.sql
-- 🎯 Полное создание БД + таблицы + демо-данные
-- 💻 Совместимость: MySQL 5.7+ / MariaDB 10.2+
-- ==========================================

-- 1. Создание базы данных
CREATE DATABASE IF NOT EXISTS `black_vantuz`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `black_vantuz`;

-- 2. Безопасная очистка перед созданием
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `logs`, `orders`, `products`, `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 3. Таблица пользователей (Models\User)
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(20) NOT NULL DEFAULT 'user',
    `verified` TINYINT(1) NOT NULL DEFAULT 0,
    `phone` VARCHAR(20) DEFAULT NULL,
    `card_last4` VARCHAR(4) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Таблица товаров (Models\Product)
CREATE TABLE `products` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` INT UNSIGNED NOT NULL DEFAULT 0,
    `period` VARCHAR(50) NOT NULL DEFAULT 'год',
    `image` VARCHAR(255) DEFAULT '/assets/images/auto.jpg',
    `coverage` VARCHAR(255) DEFAULT 'до 10 млн ₽',
    `features` JSON NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Таблица заказов (Models\Product::saveData)
CREATE TABLE `orders` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_id` VARCHAR(50) NOT NULL UNIQUE,
    `user_id` INT UNSIGNED DEFAULT NULL,
    `user_email` VARCHAR(255) DEFAULT '',
    `fio` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `delivery_type` VARCHAR(50) NOT NULL DEFAULT 'email',
    `email` VARCHAR(255) NOT NULL,
    `address` TEXT DEFAULT NULL,
    `products` JSON NOT NULL,
    `total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `status` VARCHAR(50) NOT NULL DEFAULT 'new',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Таблица логов (Models\Log)
CREATE TABLE `logs` (
    `id` VARCHAR(50) PRIMARY KEY,
    `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user` VARCHAR(100) NOT NULL DEFAULT 'Система',
    `action` VARCHAR(255) NOT NULL,
    `ip` VARCHAR(45) NOT NULL DEFAULT 'unknown',
    `details` JSON NULL,
    INDEX `idx_timestamp` (`timestamp`),
    INDEX `idx_action` (`action`),
    INDEX `idx_user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Демо-товары (взяты из Views\ServicesTemplate)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `period`, `image`, `coverage`, `features`) VALUES
(1, 'Carhartt Spring / Summer 2026 Lookbook', 'Introducing the Spring/Summer 2026 collection, which explores color, texture and print through new camouflage motifs and innovative wash techniques. Meanwhile, rugged outdoor influences and prep-inspired shapes are reimagined through a modern lens.', 18500, 'год', '/assets/images/carhartt1.jpg', 'Оригинал 100%', '["Новая коллекция 2026","Камуфляжные мотивы","Уличная классика","Премиум качество"]'),
(2, 'Balenciaga Fall 2026 Lookbook', 'This collection embodies the multitude of design codes that have been part of my creative vision and research on fashion at Balenciaga for a decade. It combines pieces from 35 different collections with new pieces and garments from my personal wardrobe.', 45000, 'год', '/assets/images/balenca1.jpg', 'До 5 млн ₽', '["Коллекция из 35 луков","Авангардный стиль","Лимитированная серия","Гарантия подлинности"]'),
(3, 'Rick Owens Collection', 'Moving on to the next chapter, this is my tribute to the creative research and work that me and my teams have done for the past 10 years. It is also my love letter to the most loyal and fashion forward audience.', 32000, 'год', '/assets/images/rick1.jpg', 'До 3 млн ₽', '["Готический минимализм","Эксклюзивный крой","Ручная работа","Юбилейная серия"]'),
(5, 'Vivienne Westwood Fall/Winter 2026', 'Dame Vivienne Westwood was an iconic British fashion designer and activist largely responsible for bringing punk and new wave fashion into the mainstream. Known as a "queen of punk," she combined 18th-century tailored historical references with rebellious, eco-conscious, and anti-establishment designs. Her legacy continues through her eponymous label.', 28000, 'год', '/assets/images/westwood.jpg', 'До 2 млн ₽', '["Британский панк-стиль","Эко-материалы","Исторический крой","Активистский дизайн"]');

-- Сброс счётчика, чтобы следующий товар получил ID = 6
ALTER TABLE `products` AUTO_INCREMENT = 6;