-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 08 Nov 2026 pada 18.12
-- Versi server: 8.0.30
-- Versi PHP: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `maro`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_produk`
--

CREATE TABLE `foto_produk` (
  `id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `katagori`
--

CREATE TABLE `katagori` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_katagori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `katagori`
--

INSERT INTO `katagori` (`id`, `nama_katagori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Cemilan'),
(4, 'Terbaik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_user_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_12_15_103255_create_katagori_table', 1),
(6, '2024_12_15_193950_create_produk_table', 1),
(7, '2024_12_17_015510_create_foto_produk_table', 1),
(8, '2025_05_05_104956_remove_biaya_jasa_from_produk_table', 1),
(9, '2025_05_11_221622_create_pesanans_table', 1),
(10, '2025_05_11_221623_create_pesanan_details_table', 1),
(11, '2025_05_13_204859_create_transaksi_table', 2),
(12, '2025_06_03_182215_create_carts_table', 3),
(13, '2025_06_04_121220_create_orders_table', 4),
(14, '2025_06_04_121221_create_order_items_table', 5),
(15, '2025_06_04_144935_create_order_items_table', 6),
(16, '2025_06_04_145415_create_orders_table', 7),
(17, '2025_06_04_145415_create_order_items_table', 8),
(18, '2025_06_08_195418_alter_payment_verified_column_in_orders_table', 9),
(19, '2025_06_08_195921_fix_payment_verified_data_before_alter', 9),
(20, '2026_11_07_000000_create_smart_penjualan_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` int NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'qris',
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `qris_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_verified` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `table_number`, `customer_name`, `customer_phone`, `notes`, `total_amount`, `status`, `payment_method`, `payment_status`, `qris_reference`, `payment_proof`, `payment_verified`, `created_at`, `updated_at`) VALUES
(32, 'ORD-BEKGKZUO4K', 1, 'kefas', '12345678', 'ga pedes', 45000.00, 'pending', 'qris', 'paid', 'QRIS-WKZ1KO6ZNV', 'payment_proofs/SmPUDBJUuNoQmKqa8ENsTflpWZpMQeUJgbordXZE.jpg', '2026-04-22 12:55:48', '2026-04-22 12:55:12', '2026-04-22 12:55:48'),
(33, 'ORD-N7VE6GUF2P', 2, 'depa', '082247298922', 'cccc', 60000.00, 'pending', 'qris', 'paid', 'QRIS-7KLN05INU2', 'payment_proofs/RcrAfsMENTvWLDvWAymyvy9XM7n2fwQEpKmU4TFD.png', '2026-04-29 06:09:04', '2026-04-29 06:08:17', '2026-04-29 06:09:04'),
(34, 'ORD-WPBJNRCPMQ', 1, 'kefas', '12345678', NULL, 90000.00, 'pending', 'qris', 'paid', 'QRIS-AHBNG1SEEF', 'payment_proofs/iy0K6SwKQkaiCv0zEk6crITUwFWDNqPRbBC19Q4m.jpg', '2026-05-06 16:27:00', '2026-05-06 05:38:47', '2026-05-06 16:27:00'),
(35, 'ORD-ILW8KQM5CN', 1, '1', '082247298922', NULL, 90000.00, 'pending', 'qris', 'paid', 'QRIS-MVV4XO0OEU', 'payment_proofs/qssx7Fo1BacunjS9W2qlUU7P6EZftIcPzftbJjbj.jpg', '2026-05-06 16:26:54', '2026-05-06 06:11:36', '2026-05-06 16:26:54'),
(36, 'ORD-KVYSBXELNP', 9, 'depa', '082247298922', 'pake nasi', 45000.00, 'pending', 'qris', 'paid', 'QRIS-D9MO3PITEI', 'payment_proofs/MKPvAC6qaBd3JcBHNwfmZ57jNcbJQPKrXiRuUQx9.jpg', '2026-05-06 16:26:47', '2026-05-06 06:13:10', '2026-05-06 16:26:47'),
(37, 'ORD-4BWATJCE7S', 1, 'kelompok 2', '012345678910', 'yang cepet', 45000.00, 'pending', 'qris', 'paid', 'QRIS-IQAR1ZNFCR', 'payment_proofs/Kvu4S0SeRfd9PzoDtBkN5ec8cSxQob2vaffvAOlF.jpg', '2026-05-06 16:26:20', '2026-05-06 16:19:51', '2026-05-06 16:26:20'),
(38, 'ORD-5PRQEV7IHC', 10, 'Velix', '082371892941', 'Untuk makanan dibuat pedas, dan minuman less sugar', 145000.00, 'pending', 'qris', 'paid', 'QRIS-T25B0LKAHY', 'payment_proofs/gLYJfSMLkIB2qAWrtNI09dI6Vz70EntFqVFeESqd.jpg', '2026-05-06 16:26:05', '2026-05-06 16:23:31', '2026-05-06 16:26:05'),
(39, 'ORD-JZBD48WR6P', 10, 'BOSS RIJAA', '08293849294', 'IMOOO GAAA', 90000.00, 'pending', 'qris', 'paid', 'QRIS-9MHEMW9WFK', 'payment_proofs/iQVqL0r16YVI41mL4Fe49yH7FUQtlX3eGZSXmef7.png', '2026-05-15 16:12:54', '2026-05-15 15:32:23', '2026-05-15 16:12:54'),
(40, 'ORD-CEUSX9VAWO', 2, 'Ramsey', '08593923532', NULL, 90000.00, 'pending', 'qris', 'paid', 'QRIS-66D7JU8EEU', 'payment_proofs/1778861647.png', '2026-05-15 16:14:59', '2026-05-15 16:14:08', '2026-05-15 16:14:59'),
(41, 'ORD-RMNWDXE0TA', 2, '3', '4', '2', 45000.00, 'pending', 'qris', 'paid', 'QRIS-AROHZRVRFB', 'payment_proofs/1778957671.png', '2026-05-16 19:28:01', '2026-05-16 18:54:33', '2026-05-16 19:28:01'),
(42, 'ORD-L7Z0P74T2N', 4, 'Jaya', '08235910241', NULL, 216000.00, 'pending', 'qris', 'rejected', 'QRIS-X1SFCKR7MV', 'payment_proofs/1779210557.png', NULL, '2026-05-19 17:09:18', '2026-05-19 17:16:53'),
(43, 'ORD-HMT9BU9YTU', 10, 'Jaya', '0824234324', NULL, 123000.00, 'pending', 'qris', 'paid', 'QRIS-DHI91BYRXD', 'payment_proofs/1779213435.png', '2026-06-15 15:03:53', '2026-05-19 17:57:15', '2026-06-15 15:03:53'),
(44, 'ORD-WVEFXCUXKE', 6, 'Saliba', '0825834728324', 'Tolong di sajikan dengan baik dan benar', 123000.00, 'pending', 'qris', 'paid', 'QRIS-CSIQSEPRMR', 'payment_proofs/1780465836.png', '2026-06-03 06:13:55', '2026-06-03 05:50:37', '2026-06-03 06:13:55'),
(45, 'ORD-POB7LOQD1V', 4, 'Zakir', '082384592751', NULL, 45000.00, 'pending', 'qris', 'paid', 'QRIS-Q5GTVRJ7C2', 'payment_proofs/1781259888.png', '2026-06-15 15:03:48', '2026-06-12 10:24:48', '2026-06-15 15:03:48'),
(46, 'ORD-1QVVS6EUOA', 1, 'kefas', '08924232232', 'Cepat', 90000.00, 'pending', 'qris', 'paid', 'QRIS-L4EXCU4A0G', 'payment_proofs/1781545130.png', '2026-06-15 17:40:28', '2026-06-15 17:38:51', '2026-06-15 17:40:28'),
(47, 'ORD-AOTTBYUDFN', 1, 'kefas', '0954231212', 'Mantap', 90000.00, 'pending', 'qris', 'paid', 'QRIS-ZXNH89PWNF', 'payment_proofs/1781549972.png', '2026-06-15 19:01:06', '2026-06-15 18:59:32', '2026-06-15 19:01:06'),
(48, 'ORD-JCSP0TUAP7', 4, 'Jojo', '082373453234', 'Proses dengan cepat', 90000.00, 'pending', 'qris', 'paid', 'QRIS-PDNZ4QEBGQ', 'payment_proofs/1782048649.png', '2026-06-21 13:34:56', '2026-06-21 13:30:51', '2026-06-21 13:34:56'),
(49, 'ORD-RXNRAGJVOK', 10, 'Riza, | && dir', '082321321', 'oke', 45000.00, 'pending', 'qris', 'paid', 'QRIS-ULHCMQBTHD', 'payment_proofs/1782372704.png', '2026-11-06 13:04:07', '2026-06-25 07:31:45', '2026-11-06 13:04:07'),
(50, 'ORD-TQODCP7CKG', 2, 'Jojo', '0823213213', 'ok', 25000.00, 'pending', 'qris', 'paid', 'QRIS-N7SYGAPHSS', 'payment_proofs/1782378460.png', '2026-06-25 09:08:06', '2026-06-25 09:07:40', '2026-06-25 09:08:06'),
(51, 'ORD-7DFBFAR5HQ', 1, 'Fadil', '083325322', 'a', 45000.00, 'pending', 'qris', 'paid', 'QRIS-YUYB5JV6RN', 'payment_proofs/1782380261.png', '2026-06-25 09:38:32', '2026-06-25 09:37:41', '2026-06-25 09:38:32'),
(52, 'ORD-TWNBKV8TL3', 12, 'Jepp', '087435554', 'aaa', 73000.00, 'pending', 'qris', 'paid', 'QRIS-9C7KNFFJSF', 'payment_proofs/1783930291.png', '2026-07-13 08:12:23', '2026-07-13 08:11:32', '2026-07-13 08:12:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `produk_id`, `nama_produk`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(43, 32, 1, 'Cipera Ayam Khas Medan', 1, 30000.00, '2026-04-22 12:55:12', '2026-04-22 12:55:12'),
(44, 32, 2, 'es kopi susu medan', 1, 15000.00, '2026-04-22 12:55:12', '2026-04-22 12:55:12'),
(45, 33, 1, 'Cipera Ayam Khas Medan', 2, 30000.00, '2026-04-29 06:08:17', '2026-04-29 06:08:17'),
(46, 34, 1, 'Beef Bolognese', 1, 45000.00, '2026-05-06 05:38:47', '2026-05-06 05:38:47'),
(47, 34, 8, 'Burger Steak', 1, 45000.00, '2026-05-06 05:38:47', '2026-05-06 05:38:47'),
(48, 35, 6, 'Chicken Carbonara', 2, 45000.00, '2026-05-06 06:11:36', '2026-05-06 06:11:36'),
(49, 36, 7, 'Fish & Chips', 1, 45000.00, '2026-05-06 06:13:10', '2026-05-06 06:13:10'),
(50, 37, 1, 'Beef Bolognese', 1, 45000.00, '2026-05-06 16:19:51', '2026-05-06 16:19:51'),
(51, 38, 5, 'Aglio Olio', 1, 45000.00, '2026-05-06 16:23:31', '2026-05-06 16:23:31'),
(52, 38, 4, 'Strawberry Tea', 2, 25000.00, '2026-05-06 16:23:31', '2026-05-06 16:23:31'),
(53, 38, 16, 'French Fries', 1, 25000.00, '2026-05-06 16:23:31', '2026-05-06 16:23:31'),
(54, 38, 2, 'Kopi Susu', 1, 25000.00, '2026-05-06 16:23:31', '2026-05-06 16:23:31'),
(55, 39, 3, 'Lychee Tea', 1, 25000.00, '2026-05-15 15:32:23', '2026-05-15 15:32:23'),
(56, 39, 17, 'Chicken Wings', 1, 45000.00, '2026-05-15 15:32:23', '2026-05-15 15:32:23'),
(57, 39, 9, 'Kopi Tubruk', 1, 20000.00, '2026-05-15 15:32:23', '2026-05-15 15:32:23'),
(58, 40, 5, 'Aglio Olio', 1, 45000.00, '2026-05-15 16:14:08', '2026-05-15 16:14:08'),
(59, 40, 1, 'Beef Bolognese', 1, 45000.00, '2026-05-15 16:14:08', '2026-05-15 16:14:08'),
(60, 41, 5, 'Aglio Olio', 1, 45000.00, '2026-05-16 18:54:33', '2026-05-16 18:54:33'),
(61, 42, 1, 'Beef Bolognese', 1, 45000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(62, 42, 7, 'Fish & Chips', 1, 45000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(63, 42, 17, 'Chicken Wings', 1, 45000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(64, 42, 11, 'Pinapple Rum', 1, 28000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(65, 42, 14, 'Passion Berry', 1, 28000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(66, 42, 2, 'Kopi Susu', 1, 25000.00, '2026-05-19 17:09:18', '2026-05-19 17:09:18'),
(67, 43, 5, 'Aglio Olio', 1, 45000.00, '2026-05-19 17:57:15', '2026-05-19 17:57:15'),
(68, 43, 13, 'Peach Tea', 1, 28000.00, '2026-05-19 17:57:15', '2026-05-19 17:57:15'),
(69, 43, 18, 'Roti Bakar', 1, 25000.00, '2026-05-19 17:57:15', '2026-05-19 17:57:15'),
(70, 43, 4, 'Strawberry Tea', 1, 25000.00, '2026-05-19 17:57:15', '2026-05-19 17:57:15'),
(71, 44, 5, 'Aglio Olio', 1, 45000.00, '2026-06-03 05:50:37', '2026-06-03 05:50:37'),
(72, 44, 12, 'Mojito', 1, 28000.00, '2026-06-03 05:50:37', '2026-06-03 05:50:37'),
(73, 44, 18, 'Roti Bakar', 1, 25000.00, '2026-06-03 05:50:37', '2026-06-03 05:50:37'),
(74, 44, 4, 'Strawberry Tea', 1, 25000.00, '2026-06-03 05:50:37', '2026-06-03 05:50:37'),
(75, 45, 1, 'Beef Bolognese', 1, 45000.00, '2026-06-12 10:24:48', '2026-06-12 10:24:48'),
(76, 46, 6, 'Chicken Carbonara', 1, 45000.00, '2026-06-15 17:38:51', '2026-06-15 17:38:51'),
(77, 46, 1, 'Beef Bolognese', 1, 45000.00, '2026-06-15 17:38:51', '2026-06-15 17:38:51'),
(78, 47, 1, 'Beef Bolognese', 1, 45000.00, '2026-06-15 18:59:32', '2026-06-15 18:59:32'),
(79, 47, 6, 'Chicken Carbonara', 1, 45000.00, '2026-06-15 18:59:32', '2026-06-15 18:59:32'),
(80, 48, 17, 'Chicken Wings', 1, 45000.00, '2026-06-21 13:30:51', '2026-06-21 13:30:51'),
(81, 48, 7, 'Fish & Chips', 1, 45000.00, '2026-06-21 13:30:51', '2026-06-21 13:30:51'),
(82, 49, 8, 'Burger Steak', 1, 45000.00, '2026-06-25 07:31:45', '2026-06-25 07:31:45'),
(83, 50, 15, 'Cireng', 1, 25000.00, '2026-06-25 09:07:40', '2026-06-25 09:07:40'),
(84, 51, 7, 'Fish & Chips', 1, 45000.00, '2026-06-25 09:37:41', '2026-06-25 09:37:41'),
(85, 52, 1, 'Beef Bolognese', 1, 45000.00, '2026-07-13 08:11:32', '2026-07-13 08:11:32'),
(86, 52, 11, 'Pinapple Rum', 1, 28000.00, '2026-07-13 08:11:32', '2026-07-13 08:11:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `katagori_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `stok` int NOT NULL,
  `berat` double(8,2) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `katagori_id`, `user_id`, `status`, `nama_produk`, `detail`, `harga`, `stok`, `berat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Beef Bolognese', 'Pasta dengan toping daging super mantap dan berlimpah', 45000, 7, 10.00, '20260429171630_69f1da7e79671.jpg', '2025-05-13 10:00:03', '2026-07-13 08:12:23'),
(2, 4, 1, 1, 'Kopi Susu', 'Es kopi susu dengan biji khas pilihan', 25000, 4, 5.00, '20260429174716_69f1e1b40929a.jpg', '2025-05-13 10:01:12', '2026-05-15 16:16:29'),
(3, 4, 1, 1, 'Lychee Tea', 'Minuman teh dengan campuran buah lychee tea segar', 25000, 8, 5.00, '20260429174804_69f1e1e44ed50.jpg', '2025-05-13 10:39:03', '2026-05-15 16:12:54'),
(4, 4, 1, 1, 'Strawberry Tea', 'Minuman teh dengan campuran buah strawberry segar', 25000, 5, 10.00, '20260429174603_69f1e16b1cc28.jpg', '2026-04-22 13:03:20', '2026-06-15 15:03:53'),
(5, 1, 1, 1, 'Aglio Olio', 'Pasta khas Italia dengan bumbu super mantap dan nikmat', 45000, 8, 30.00, '20260429172508_69f1dc84f3710.jpg', '2026-04-29 10:25:09', '2026-06-15 15:03:53'),
(6, 1, 1, 1, 'Chicken Carbonara', 'Pasta dengan racikan saus carbonara gacorr bangett ketua', 45000, 10, 40.00, '20260429172632_69f1dcd803841.jpg', '2026-04-29 10:26:32', '2026-06-15 19:01:06'),
(7, 1, 1, 1, 'Fish & Chips', 'Perpaduan ikan segar dengan campuran kentang super nikmat', 45000, 6, 25.00, '20260429172756_69f1dd2cd9102.jpg', '2026-04-29 10:27:57', '2026-06-25 09:38:32'),
(8, 1, 1, 1, 'Burger Steak', 'Menu burger dengan daging super juicy luicy mahalini rizki febian semua bisa pesen online', 45000, 9, 20.00, '20260429172918_69f1dd7eeac1b.jpg', '2026-04-29 10:29:19', '2026-11-06 13:04:07'),
(9, 2, 1, 1, 'Kopi Tubruk', 'Kopi tubruk dengan biji kopi pilihan', 20000, 14, 10.00, '20260429175027_69f1e273cc2a6.jpg', '2026-04-29 10:50:28', '2026-05-15 16:12:55'),
(10, 2, 1, 1, 'Espresso', 'Espresso dengan biji kopi terbaik semuka bumi', 18000, 14, 5.00, '20260429175113_69f1e2a180133.jpg', '2026-04-29 10:51:13', '2026-06-15 15:03:01'),
(11, 2, 1, 1, 'Pinapple Rum', 'Moctail segar dan nikmat asli', 28000, 14, 15.00, '20260429180010_69f1e4ba26ea1.jpg', '2026-04-29 11:00:10', '2026-07-13 08:12:23'),
(12, 2, 1, 1, 'Mojito', 'Minuman bersoda segar dengan perasan jeruk nipis asem segerr', 28000, 13, 15.00, '20260429180051_69f1e4e37125a.jpg', '2026-04-29 11:00:51', '2026-06-03 06:13:55'),
(13, 2, 1, 1, 'Peach Tea', 'Minuman teh dengan campuran buah peach yang asam dan segar', 28000, 14, 20.00, '20260429181712_69f1e8b89c439.jpg', '2026-04-29 11:16:10', '2026-06-15 15:03:53'),
(14, 2, 1, 1, 'Passion Berry', 'Moctail dengan mix buah marikisa dan buah berry', 28000, 22, 20.00, '20260429182415_69f1ea5fd9275.jpg', '2026-04-29 11:24:16', '2026-05-19 17:05:05'),
(15, 3, 1, 1, 'Cireng', 'Cirengggg cirengggg', 25000, 14, 10.00, '20260506230124_69fb65d42847e.jpeg', '2026-05-06 16:01:25', '2026-06-25 09:08:06'),
(16, 3, 1, 1, 'French Fries', 'Kentang goreng enak asin gurih', 25000, 16, 20.00, '20260506230319_69fb66479bb94.jpg', '2026-05-06 16:03:20', '2026-05-19 17:05:05'),
(17, 3, 1, 1, 'Chicken Wings', 'Chicken wings dengan bumbu khas', 45000, 12, 40.00, '20260506230625_69fb670179412.jpg', '2026-05-06 16:06:26', '2026-06-21 13:34:56'),
(18, 3, 1, 1, 'Roti Bakar', 'Roti bakar dengan toping coklat keju susu', 25000, 14, 25.00, '20260506231118_69fb68263c060.jpg', '2026-05-06 16:11:18', '2026-06-22 06:37:41'),
(19, 4, 1, 1, 'Thai Tea', 'Teh dengan campuran susu segar yang sangat nikmat', 25000, 19, 20.00, '20260515212143_6a072bf76007e.jpg', '2026-05-15 14:21:43', '2026-06-22 06:37:41'),
(22, 2, 7, 0, '<script>alert(\'Stored XSS\')</script>', 'abcd', 25000, 20, 20.00, '20260625193920_6a3d2178e05b8.jpg', '2026-06-25 12:39:21', '2026-06-25 12:39:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `smart_penjualan`
--

CREATE TABLE `smart_penjualan` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_alternatif` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` double NOT NULL DEFAULT '1',
  `harga_asli` double DEFAULT NULL,
  `harga` double NOT NULL DEFAULT '1',
  `penjualan_asli` int DEFAULT NULL,
  `penjualan` double NOT NULL DEFAULT '1',
  `penyajian_asli` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimasi` double NOT NULL DEFAULT '1',
  `laba_penjualan` double DEFAULT NULL,
  `tahun` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2025',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `smart_penjualan`
--

INSERT INTO `smart_penjualan` (`id`, `kode_alternatif`, `nama`, `kategori_nama`, `kategori`, `harga_asli`, `harga`, `penjualan_asli`, `penjualan`, `penyajian_asli`, `estimasi`, `laba_penjualan`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 'A1', 'Beef Bolognese', 'Makanan', 6, 45000, 5, 13, 5, '7 Menit', 1, 585000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(2, 'A2', 'Aglio Olio', 'Makanan', 6, 45000, 5, 7, 4, '7 Menit', 1, 315000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(3, 'A3', 'Burger Steak', 'Makanan', 6, 45000, 5, 6, 3, '7 Menit', 1, 270000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(4, 'A4', 'Pinapple Rum', 'Minuman', 1, 28000, 3, 6, 3, '5 Menit', 2, 168000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(5, 'A5', 'Cipera Ayam Khas Medan', 'Makanan', 6, 30000, 4, 5, 3, '7 Menit', 1, 150000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(6, 'A6', 'Strawberry Tea', 'Tea', 3, 25000, 2, 5, 3, '3 Menit', 4, 125000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(7, 'A7', 'Chicken Carbonara', 'Makanan', 6, 45000, 5, 5, 3, '7 Menit', 1, 225000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(8, 'A8', 'French Fries', 'Cemilan', 5, 25000, 2, 4, 3, '5 Menit', 2, 100000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(9, 'A9', 'Fish & Chips', 'Makanan', 6, 45000, 5, 4, 3, '7 Menit', 1, 180000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(10, 'A10', 'Roti Bakar', 'Cemilan', 5, 25000, 2, 4, 3, '5 Menit', 2, 100000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(11, 'A11', 'es kopi susu medan', 'Coffee', 4, 15000, 1, 3, 2, '4 Menit', 3, 45000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(12, 'A12', 'Passion Berry', 'Minuman', 1, 28000, 3, 3, 2, '5 Menit', 2, 84000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(13, 'A13', 'Chicken Wings', 'Cemilan', 5, 45000, 5, 3, 2, '5 Menit', 2, 135000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(14, 'A14', 'Lychee Tea', 'Tea', 3, 25000, 2, 2, 2, '3 Menit', 4, 50000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(15, 'A15', 'Kopi Susu', 'Coffee', 4, 25000, 2, 2, 2, '4 Menit', 3, 50000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(16, 'A16', 'Mojito', 'Minuman', 1, 28000, 3, 2, 2, '5 Menit', 2, 56000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(17, 'A17', 'Kopi Tubruk', 'Minuman', 1, 20000, 1, 1, 1, '5 Menit', 2, 20000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(18, 'A18', 'Espresso', 'Minuman', 1, 18000, 1, 1, 1, '5 Menit', 2, 18000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(19, 'A19', 'Peach Tea', 'Minuman', 1, 28000, 3, 1, 1, '5 Menit', 2, 28000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(20, 'A20', 'Thai Tea', 'Tea', 3, 25000, 2, 1, 1, '3 Menit', 4, 25000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01'),
(21, 'A21', 'Cireng', 'Cemilan', 5, 25000, 2, 1, 1, '5 Menit', 2, 25000, '2026', '2026-11-08 17:15:01', '2026-11-08 17:15:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `total_item` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `items` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_transaksi`, `tanggal`, `total`, `total_item`, `user_id`, `items`, `created_at`, `updated_at`) VALUES
(84, 'TRX-1776862548-32', '2026-04-22 19:55:48', 45000.00, 2, 7, '[{\"produk_id\":1,\"nama_produk\":\"Cipera Ayam Khas Medan\",\"quantity\":1,\"price\":\"30000.00\",\"subtotal\":30000},{\"produk_id\":2,\"nama_produk\":\"es kopi susu medan\",\"quantity\":1,\"price\":\"15000.00\",\"subtotal\":15000}]', '2026-04-22 12:55:48', '2026-04-22 12:55:48'),
(85, 'TRX-20260422-0001', '2026-04-22 19:56:33', 90000.00, 4, 7, '[{\"produk_id\":1,\"nama_produk\":\"Cipera Ayam Khas Medan\",\"harga\":30000,\"quantity\":\"2\",\"subtotal\":60000},{\"produk_id\":2,\"nama_produk\":\"es kopi susu medan\",\"harga\":15000,\"quantity\":\"2\",\"subtotal\":30000}]', '2026-04-22 12:56:33', '2026-04-22 12:56:33'),
(86, 'TRX-1777442944-33', '2026-04-29 13:09:04', 60000.00, 2, 7, '[{\"produk_id\":1,\"nama_produk\":\"Cipera Ayam Khas Medan\",\"quantity\":2,\"price\":\"30000.00\",\"subtotal\":60000}]', '2026-04-29 06:09:04', '2026-04-29 06:09:04'),
(87, 'TRX-20260506-0001', '2026-05-06 12:45:55', 25000.00, 1, 7, '[{\"produk_id\":3,\"nama_produk\":\"Lychee Tea\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000}]', '2026-05-06 05:45:55', '2026-05-06 05:45:55'),
(88, 'TRX-1778084765-38', '2026-05-06 23:26:05', 145000.00, 5, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":4,\"nama_produk\":\"Strawberry Tea\",\"quantity\":2,\"price\":\"25000.00\",\"subtotal\":50000},{\"produk_id\":16,\"nama_produk\":\"French Fries\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000},{\"produk_id\":2,\"nama_produk\":\"Kopi Susu\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000}]', '2026-05-06 16:26:05', '2026-05-06 16:26:05'),
(89, 'TRX-1778084780-37', '2026-05-06 23:26:20', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-05-06 16:26:20', '2026-05-06 16:26:20'),
(90, 'TRX-1778084807-36', '2026-05-06 23:26:47', 45000.00, 1, 7, '[{\"produk_id\":7,\"nama_produk\":\"Fish & Chips\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-05-06 16:26:47', '2026-05-06 16:26:47'),
(91, 'TRX-1778084814-35', '2026-05-06 23:26:54', 90000.00, 2, 7, '[{\"produk_id\":6,\"nama_produk\":\"Chicken Carbonara\",\"quantity\":2,\"price\":\"45000.00\",\"subtotal\":90000}]', '2026-05-06 16:26:54', '2026-05-06 16:26:54'),
(92, 'TRX-1778084820-34', '2026-05-06 23:27:00', 90000.00, 2, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-05-06 16:27:00', '2026-05-06 16:27:00'),
(93, 'TRX-20260506-0002', '2026-05-06 23:35:26', 216000.00, 6, 7, '[{\"produk_id\":6,\"nama_produk\":\"Chicken Carbonara\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":7,\"nama_produk\":\"Fish & Chips\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":14,\"nama_produk\":\"Passion Berry\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":18,\"nama_produk\":\"Roti Bakar\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000},{\"produk_id\":17,\"nama_produk\":\"Chicken Wings\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-05-06 16:35:26', '2026-05-06 16:35:26'),
(94, 'TRX-1778861575-39', '2026-05-15 23:12:55', 90000.00, 3, 7, '[{\"produk_id\":3,\"nama_produk\":\"Lychee Tea\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000},{\"produk_id\":17,\"nama_produk\":\"Chicken Wings\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":9,\"nama_produk\":\"Kopi Tubruk\",\"quantity\":1,\"price\":\"20000.00\",\"subtotal\":20000}]', '2026-05-15 16:12:55', '2026-05-15 16:12:55'),
(95, 'TRX-1778861699-40', '2026-05-15 23:14:59', 90000.00, 2, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-05-15 16:14:59', '2026-05-15 16:14:59'),
(96, 'TRX-20260515-0001', '2026-05-15 23:16:29', 103000.00, 4, 7, '[{\"produk_id\":4,\"nama_produk\":\"Strawberry Tea\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000},{\"produk_id\":2,\"nama_produk\":\"Kopi Susu\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000},{\"produk_id\":12,\"nama_produk\":\"Mojito\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":16,\"nama_produk\":\"French Fries\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000}]', '2026-05-15 16:16:29', '2026-05-15 16:16:29'),
(97, 'TRX-1778959681-41', '2026-05-17 02:28:01', 45000.00, 1, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-05-16 19:28:01', '2026-05-16 19:28:01'),
(98, 'TRX-20260519-0001', '2026-05-19 23:59:03', 126000.00, 4, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":14,\"nama_produk\":\"Passion Berry\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":16,\"nama_produk\":\"French Fries\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000}]', '2026-05-19 16:59:03', '2026-05-19 16:59:03'),
(99, 'TRX-20260520-0001', '2026-05-20 00:05:05', 126000.00, 4, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":14,\"nama_produk\":\"Passion Berry\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000},{\"produk_id\":16,\"nama_produk\":\"French Fries\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000}]', '2026-05-19 17:05:05', '2026-05-19 17:05:05'),
(100, 'TRX-20260603-0001', '2026-06-03 12:35:08', 118000.00, 3, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000}]', '2026-06-03 05:35:08', '2026-06-03 05:35:08'),
(101, 'TRX-1780467235-44', '2026-06-03 13:13:55', 123000.00, 4, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":12,\"nama_produk\":\"Mojito\",\"quantity\":1,\"price\":\"28000.00\",\"subtotal\":28000},{\"produk_id\":18,\"nama_produk\":\"Roti Bakar\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000},{\"produk_id\":4,\"nama_produk\":\"Strawberry Tea\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000}]', '2026-06-03 06:13:55', '2026-06-03 06:13:55'),
(102, 'TRX-20260615-0001', '2026-06-15 22:03:01', 18000.00, 1, 7, '[{\"produk_id\":10,\"nama_produk\":\"Espresso\",\"harga\":18000,\"quantity\":\"1\",\"subtotal\":18000}]', '2026-06-15 15:03:01', '2026-06-15 15:03:01'),
(103, 'TRX-1781535828-45', '2026-06-15 22:03:48', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-06-15 15:03:48', '2026-06-15 15:03:48'),
(104, 'TRX-1781535833-43', '2026-06-15 22:03:53', 123000.00, 4, 7, '[{\"produk_id\":5,\"nama_produk\":\"Aglio Olio\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":13,\"nama_produk\":\"Peach Tea\",\"quantity\":1,\"price\":\"28000.00\",\"subtotal\":28000},{\"produk_id\":18,\"nama_produk\":\"Roti Bakar\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000},{\"produk_id\":4,\"nama_produk\":\"Strawberry Tea\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000}]', '2026-06-15 15:03:53', '2026-06-15 15:03:53'),
(105, 'TRX-20260616-0001', '2026-06-16 00:39:38', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-06-15 17:39:38', '2026-06-15 17:39:38'),
(106, 'TRX-1781545228-46', '2026-06-16 00:40:28', 90000.00, 2, 7, '[{\"produk_id\":6,\"nama_produk\":\"Chicken Carbonara\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-06-15 17:40:28', '2026-06-15 17:40:28'),
(107, 'TRX-20260616-0002', '2026-06-16 02:00:19', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-06-15 19:00:20', '2026-06-15 19:00:20'),
(108, 'TRX-1781550066-47', '2026-06-16 02:01:06', 90000.00, 2, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":6,\"nama_produk\":\"Chicken Carbonara\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-06-15 19:01:06', '2026-06-15 19:01:06'),
(109, 'TRX-20260616-0003', '2026-06-16 21:00:08', 118000.00, 3, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"harga\":28000,\"quantity\":\"1\",\"subtotal\":28000}]', '2026-06-16 14:00:08', '2026-06-16 14:00:08'),
(110, 'TRX-1782048896-48', '2026-06-21 20:34:56', 90000.00, 2, 7, '[{\"produk_id\":17,\"nama_produk\":\"Chicken Wings\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":7,\"nama_produk\":\"Fish & Chips\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-06-21 13:34:56', '2026-06-21 13:34:56'),
(111, 'TRX-20260622-0001', '2026-06-22 13:37:41', 95000.00, 3, 7, '[{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000},{\"produk_id\":19,\"nama_produk\":\"Thai Tea\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000},{\"produk_id\":18,\"nama_produk\":\"Roti Bakar\",\"harga\":25000,\"quantity\":\"1\",\"subtotal\":25000}]', '2026-06-22 06:37:41', '2026-06-22 06:37:41'),
(112, 'TRX-1782378486-50', '2026-06-25 16:08:06', 25000.00, 1, 7, '[{\"produk_id\":15,\"nama_produk\":\"Cireng\",\"quantity\":1,\"price\":\"25000.00\",\"subtotal\":25000}]', '2026-06-25 09:08:06', '2026-06-25 09:08:06'),
(113, 'TRX-1782380312-51', '2026-06-25 16:38:32', 45000.00, 1, 7, '[{\"produk_id\":7,\"nama_produk\":\"Fish & Chips\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-06-25 09:38:32', '2026-06-25 09:38:32'),
(114, 'TRX-20260625-0001', '2026-06-25 20:37:27', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-06-25 13:37:27', '2026-06-25 13:37:27'),
(115, 'TRX-20260625-0002', '2026-06-25 20:37:55', 45000.00, 1, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-06-25 13:37:55', '2026-06-25 13:37:55'),
(116, 'TRX-1783930343-52', '2026-07-13 15:12:23', 73000.00, 2, 7, '[{\"produk_id\":1,\"nama_produk\":\"Beef Bolognese\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000},{\"produk_id\":11,\"nama_produk\":\"Pinapple Rum\",\"quantity\":1,\"price\":\"28000.00\",\"subtotal\":28000}]', '2026-07-13 08:12:23', '2026-07-13 08:12:23'),
(117, 'TRX-20260713-0001', '2026-07-13 15:13:03', 45000.00, 1, 7, '[{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"harga\":45000,\"quantity\":\"1\",\"subtotal\":45000}]', '2026-07-13 08:13:03', '2026-07-13 08:13:03'),
(118, 'TRX-1793970247-49', '2026-11-06 20:04:07', 45000.00, 1, 7, '[{\"produk_id\":8,\"nama_produk\":\"Burger Steak\",\"quantity\":1,\"price\":\"45000.00\",\"subtotal\":45000}]', '2026-11-06 13:04:07', '2026-11-06 13:04:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `role`, `status`, `password`, `hp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Kefas', 'admin@gmail.com', '1', 1, '$2y$12$H/tGZe6SCzaxLuvjCpYLZO2h7Lo5JFE.WlwWfmr8YB960x1lTycBm', '0812345678901', '20260625180318_6a3d0af6766e0.jpg', '2025-05-11 15:25:30', '2026-06-25 11:03:18'),
(7, 'sovie', 'kasir@gmail.com', '2', 1, '$2y$10$DaUyYtcgu27fs.OovyZW6./BXkkyv98MvOoC9hxrO8jheIXYNbp1W', '081234567890', '20260603123115_6a1fbc2319587.jpg', '2026-04-22 12:52:30', '2026-06-03 05:31:15');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foto_produk_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `katagori`
--
ALTER TABLE `katagori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_katagori_id_foreign` (`katagori_id`),
  ADD KEY `produk_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `smart_penjualan`
--
ALTER TABLE `smart_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksi_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `katagori`
--
ALTER TABLE `katagori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `smart_penjualan`
--
ALTER TABLE `smart_penjualan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `foto_produk`
--
ALTER TABLE `foto_produk`
  ADD CONSTRAINT `foto_produk_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_katagori_id_foreign` FOREIGN KEY (`katagori_id`) REFERENCES `katagori` (`id`),
  ADD CONSTRAINT `produk_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
