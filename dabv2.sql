-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 03, 2018 at 11:22 AM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dabv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key_encrypt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `role_id`, `salt`, `key_encrypt`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 4, NULL, NULL, NULL, NULL),
(3, 'admin2', 'admin2@gmail.com', '', 4, NULL, NULL, NULL, NULL),
(4, 'adminN', 'adminN@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 4, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_role`
--

CREATE TABLE `client_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Nội Khoa', 'Có chức năng đặc biệt', NULL, NULL),
(2, 'Ngoại khoa', 'Cũng có chức năng đặc biệt', NULL, NULL),
(3, 'Khoa Xét ngiệm huyết học', 'xét ngiệm máu,lấy thông tin liên quan', NULL, NULL),
(4, 'Phòng siêu âm', 'Lấy kết quả siêu âm', NULL, NULL),
(5, 'Không', 'khoa dành cho nhân viên hành chính\n', '2017-08-16 02:36:56', '2017-08-16 02:36:56'),
(6, 'Phổi', 'khám các bệnh liên quan đến phổi\n', '2017-08-17 20:26:35', '2017-08-17 20:26:35'),
(7, 'Tai-Mũi-Họng', 'khám các bệnh đường về tai,mũi,hong', '2017-08-17 20:27:07', '2017-08-17 20:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `type` int(2) DEFAULT NULL,
  `khoa` int(3) DEFAULT NULL,
  `chucvu` int(3) NOT NULL DEFAULT '4',
  `bangcap` int(3) NOT NULL DEFAULT '4',
  `phongban` int(11) DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_id`, `type`, `khoa`, `chucvu`, `bangcap`, `phongban`, `fullname`, `avatar`) VALUES
(1, 1, 2, NULL, 1, 1, NULL, '', 'default.jpg'),
(2, 4, 1, 6, 3, 2, 7, 'Bác Sĩ 2', 'default.jpg'),
(3, 7, 3, 3, 3, 3, NULL, '', 'default.jpg'),
(4, 10, NULL, 1, 1, 1, 1, '', 'default.jpg'),
(5, 13, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(6, 16, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(7, 19, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(8, 22, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(10, 28, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(11, 31, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(12, 34, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(13, 37, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(14, 40, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(15, 43, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(16, 46, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(17, 49, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(18, 52, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(19, 55, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(20, 58, NULL, NULL, 0, 0, NULL, '', 'default.jpg'),
(27, 102, NULL, 1, 1, 1, NULL, 'Bs24', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_applications`
--

CREATE TABLE `medical_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medical_date` date DEFAULT NULL,
  `Shift` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_specialist_applications`
--

CREATE TABLE `medical_specialist_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `medical_type` int(3) DEFAULT NULL,
  `khoa` int(3) DEFAULT NULL,
  `phongban` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medical_date` date DEFAULT NULL,
  `Shift` smallint(6) DEFAULT '1',
  `so_bo` mediumtext COLLATE utf8_unicode_ci,
  `chan_doan` mediumtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medical_specialist_applications`
--

INSERT INTO `medical_specialist_applications` (`id`, `date`, `patient_id`, `medical_type`, `khoa`, `phongban`, `status`, `url`, `created_at`, `updated_at`, `medical_date`, `Shift`, `so_bo`, `chan_doan`) VALUES
(12, '2017-08-18 04:11:13', 5, 1, 6, NULL, 0, '2017-08-18-5-b24a945864a887a.xml', '2017-08-17 21:11:13', '2017-08-18 18:50:04', '2017-08-18', 1, 'bệnh lao', 'ho,phế quản'),
(15, '2017-08-19 02:49:59', 20, 1, 6, NULL, 0, '2017-08-19-20-39ac27f427f9a2e.xml', '2017-08-18 19:49:59', '2017-08-18 19:51:23', '2017-08-19', 0, '-dấu hiệu lao phổi', '-lao phổi\r\n-điểu trị ....'),
(19, '2017-08-22 00:02:59', 2, 1, 6, NULL, 0, '2017-08-22-2-f8fdc6e09d23444.xml', '2017-08-21 17:02:59', '2017-08-21 17:09:20', '2017-08-22', 1, '-bệnh phổi', '-lao phổi'),
(20, '2017-08-22 00:41:08', 11, 1, 6, NULL, 0, '2017-08-22-11-b15c3247f80b862.xml', '2017-08-21 17:41:08', '2017-08-21 18:00:25', '2017-08-22', 1, '-ho bình thường', '-Viêm họng abc'),
(38, '2017-08-24 02:00:34', 2, 1, 6, NULL, 0, '2017-08-24-2-c7eb42c083caf13.xml', '2017-08-23 19:00:34', '2017-08-23 19:27:25', '2017-08-24', 1, 'viêm phổi', 'xvx'),
(39, '2017-08-24 02:03:30', 5, 1, 6, NULL, 0, '2017-08-24-5-4b405e8e35e6833.xml', '2017-08-23 19:03:30', '2017-08-23 19:43:31', '2017-08-24', 1, '123123', '123124'),
(40, '2017-08-24 02:45:49', 2, 1, 6, NULL, 0, '2017-08-24-2-742b88e580749af.xml', '2017-08-23 19:45:49', '2017-08-23 19:46:34', '2017-08-24', 1, 'abc', 'xyz'),
(41, '2017-08-24 02:52:09', 11, 1, 6, NULL, 0, '2017-08-24-11-e583322641cf0d2.xml', '2017-08-23 19:52:09', '2017-08-23 19:56:26', '2017-08-24', 1, 'abc', 'xyz'),
(44, '2017-08-25 02:22:08', 2, 1, 6, NULL, 0, '2017-08-25-2-dc5edb744fb97f7.xml', '2017-08-24 19:22:08', '2017-08-24 19:47:44', '2017-08-25', 1, 'abc', 'xong roi\r\n'),
(45, '2017-08-25 02:35:46', 23, 1, 6, NULL, 0, '2017-08-25-23-9d80eae459059aa.xml', '2017-08-24 19:35:46', '2017-08-24 19:47:54', '2017-08-25', 1, 'abc', 'a lo 123'),
(54, '2017-08-29 07:29:24', 23, 1, 6, NULL, 0, '2017-08-29-23-b68269c2e764512.xml', '2017-08-29 00:29:24', '2017-08-29 02:27:29', '2017-08-29', 2, 'abc', 'điều trị ...'),
(56, '2017-08-29 08:59:33', 2, 1, 6, NULL, 0, '2017-08-29-2-09dcae62453c5c6.xml', '2017-08-29 01:59:33', '2017-08-29 02:25:44', '2017-08-29', 2, 'abc', '123'),
(57, '2017-08-29 09:06:59', 5, 1, 6, NULL, 0, '2017-08-29-5-84f5ccfde80c0bb.xml', '2017-08-29 02:06:59', '2017-08-29 02:25:58', '2017-08-29', 2, 'bệnh lao', '123'),
(58, '2017-08-29 09:24:19', 8, 1, 6, NULL, 0, '2017-08-29-8-de037bae1dbe7eb.xml', '2017-08-29 02:24:19', '2017-08-29 02:32:50', '2017-08-29', 2, 'bệnh lao', 'abc'),
(59, '2017-09-01 03:01:07', 2, 1, 6, NULL, 3, '2017-09-01-2-624505babeede42.xml', '2017-08-31 20:01:07', '2017-09-01 03:02:52', '2017-09-02', 1, '123', NULL),
(61, '2017-09-01 03:13:38', 5, 1, 6, NULL, 3, '2017-09-01-5-2e59f4100b06b4e.xml', '2017-08-31 20:13:38', '2017-09-20 01:05:44', '2017-09-01', 1, 'lao phổi\r\n', NULL),
(62, '2017-09-01 03:14:05', 11, 1, 6, NULL, 2, '2017-09-01-11-b723c96189141a1.xml', '2017-08-31 20:14:05', '2017-09-01 00:27:59', '2017-09-01', 1, 'abc', NULL),
(63, '2017-10-25 08:55:38', 23, 1, 6, NULL, 2, '2017-10-25-23-55985ac6b12366b.xml', '2017-10-25 01:55:38', '2017-10-25 01:57:17', '2017-10-25', 2, '-viêm phổi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_specialist_type`
--

CREATE TABLE `medical_specialist_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medical_specialist_type`
--

INSERT INTO `medical_specialist_type` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'khám chuyên khoa', NULL, NULL),
(2, 'khám bảo hiểm', NULL, NULL),
(3, 'khám trưởng khoa,phó khoa', '2017-08-16 01:31:43', '2017-08-16 01:31:43'),
(4, 'khám Giáo sư,Tiến sĩ', '2017-08-16 01:31:43', '2017-08-16 01:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `medical_test_applications`
--

CREATE TABLE `medical_test_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `xetnghiem` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `medical_date` date DEFAULT NULL,
  `Shift` smallint(6) DEFAULT '1',
  `register_by` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medical_test_applications`
--

INSERT INTO `medical_test_applications` (`id`, `date`, `patient_id`, `status`, `xetnghiem`, `url`, `created_at`, `updated_at`, `medical_date`, `Shift`, `register_by`) VALUES
(14, '2017-08-14 03:02:43', 5, 0, 1, '2017-08-14-5-2fe9d5a844cccab.xml', '2017-08-13 20:02:43', '2017-08-13 20:04:46', '2017-08-15', 1, 1),
(15, '2017-08-14 03:56:29', 11, 0, 1, '2017-08-14-11-bd3d6f7b9796956.xml', '2017-08-13 20:56:29', '2017-08-13 21:00:29', '2017-08-06', 1, 1),
(16, '2017-08-14 04:01:42', 14, 0, 1, '2017-08-14-14-342240a6260dc0a.xml', '2017-08-13 21:01:42', '2017-08-13 21:03:59', '2017-08-01', 1, 1),
(52, '2017-08-18 09:54:22', 5, 0, 2, '2017-08-18-4-770a26f9db02c78.xml', '2017-08-18 02:54:22', '2017-08-18 03:54:12', '2017-08-18', 1, 2),
(53, '2017-08-19 02:28:07', 11, 0, 1, '2017-08-19-4-617e13c76066512.xml', '2017-08-18 19:28:07', '2017-08-18 19:29:41', '2017-08-19', 1, 2),
(54, '2017-08-19 02:28:07', 11, 0, 2, '2017-08-19-4-77ce7b93d0fb7fd.xml', '2017-08-18 19:28:07', '2017-08-18 19:28:33', '2017-08-19', 1, 2),
(55, '2017-08-19 02:28:08', 11, 0, 3, '2017-08-19-4-6f559048ba3ce32.xml', '2017-08-18 19:28:08', '2017-08-18 19:29:06', '2017-08-19', 1, 2),
(56, '2017-08-19 02:50:26', 20, 0, 1, '2017-08-19-4-4e51ee0e71f5943.xml', '2017-08-18 19:50:26', '2017-08-18 19:50:53', '2017-08-19', 1, 2),
(62, '2017-08-22 00:04:41', 2, 0, 1, '2017-08-22-4-ec4b5a09011f47b.xml', '2017-08-21 17:04:41', '2017-08-21 17:08:33', '2017-08-22', 1, 2),
(63, '2017-08-22 02:00:49', 23, 0, 1, '2017-08-22-23-f2f1878ec4472a1.xml', '2017-08-21 19:00:49', '2017-08-21 19:02:09', '2017-08-22', 1, 1),
(68, '2017-08-22 02:45:15', 11, 0, 2, '2017-08-22-11-924a8da1a693639.xml', '2017-08-21 19:45:15', '2017-08-24 18:30:34', '2017-08-22', 1, 1),
(77, '2017-08-24 02:08:38', 2, 0, 1, '2017-08-24-4-7f35ae179a5b640.xml', '2017-08-23 19:08:38', '2017-08-23 19:25:24', '2017-08-24', 1, 2),
(78, '2017-08-24 02:54:22', 11, 0, 1, '2017-08-24-4-208f787a27bee28.xml', '2017-08-23 19:54:22', '2017-08-23 19:55:08', '2017-08-24', 1, 2),
(79, '2017-08-24 09:59:17', 103, 0, 2, '2017-08-24-9-5d45355b86e84a1.xml', '2017-08-24 02:59:17', '2017-08-23 20:04:01', '2017-08-24', 1, 1),
(80, '2017-08-24 09:59:17', 103, 0, 3, '2017-08-24-9-4f24066a95b2df4.xml', '2017-08-24 02:59:17', '2017-08-23 20:03:28', '2017-08-24', 1, 1),
(91, '2017-08-25 02:38:54', 23, 0, 1, '2017-08-25-4-30e74d9289a519a.xml', '2017-08-24 19:38:54', '2017-08-24 19:39:21', '2017-08-25', 1, 2),
(92, '2017-08-25 02:47:05', 2, 0, 1, '2017-08-25-4-0de84f0c1bc37d9.xml', '2017-08-24 19:47:05', '2017-08-24 19:47:24', '2017-08-25', 1, 2),
(98, '2017-08-29 08:45:00', 23, 0, 4, '2017-08-29-23-2a2cb6607c4d063.xml', '2017-08-29 01:45:00', '2017-08-29 02:03:23', '2017-08-29', 2, 1),
(99, '2017-08-29 15:56:49', 2, 0, 4, '2017-08-29-4-a6fcf507eadbaf3.xml', '2017-08-29 08:56:49', '2017-08-29 02:03:51', '2017-08-29', 2, 2),
(101, '2017-08-29 16:07:30', 5, 0, 4, '2017-08-29-4-495ba200ce12ff9.xml', '2017-08-29 09:07:30', '2017-08-29 02:07:51', '2017-08-29', 2, 2),
(102, '2017-08-29 09:25:28', 23, 0, 4, '2017-08-29-4-554fbf02de5cd4f.xml', '2017-08-29 02:25:28', '2017-08-29 02:26:34', '2017-08-29', 1, 2),
(103, '2017-08-29 09:31:08', 8, 0, 4, '2017-08-29-4-ac6eef96d88a7c0.xml', '2017-08-29 02:31:08', '2017-08-29 02:31:26', '2017-08-29', 1, 2),
(105, '2017-09-01 03:17:45', 5, 0, 4, '2017-09-01-4-54dbee129d35d19.xml', '2017-08-31 20:17:45', '2017-09-20 01:05:44', '2017-09-01', 1, 2),
(112, '2017-09-20 07:16:21', 2, 0, 4, '2017-09-20-2-d4cc7ff539e2701.xml', '2017-09-20 00:16:21', '2017-09-20 01:11:29', '2017-09-20', 1, 1),
(113, '2017-10-25 08:57:17', 23, 2, 1, '2017-10-25-4-376609e4bfbaba2.xml', '2017-10-25 01:57:17', '2017-10-25 01:58:26', '2017-10-25', 1, 2),
(118, '2017-10-31 07:33:57', 2, 2, 4, '2017-10-31-2-5421473fe532640.xml', '2017-10-31 00:33:57', '2017-11-03 02:03:48', '2017-10-31', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medical_test_type`
--

CREATE TABLE `medical_test_type` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `khoa` int(3) NOT NULL,
  `phongban` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medical_test_type`
--

INSERT INTO `medical_test_type` (`id`, `name`, `khoa`, `phongban`, `created_at`, `updated_at`) VALUES
(1, 'Xét nghiệm máu', 3, 3, '2017-08-10 02:26:18', '2017-08-10 02:26:18'),
(2, 'Siêu âm', 4, 4, '2017-08-10 02:26:18', '2017-08-09 19:42:29'),
(3, 'Chụp X-Quang', 2, 5, '2017-08-16 00:48:52', '2017-08-16 00:48:52'),
(4, 'Đo phổi', 6, 9, '2017-08-29 08:38:35', '2017-08-29 08:38:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_10_17_075246_add_user_role_column', 1),
(4, '2016_10_17_080452_add_role_table', 1),
(5, '2016_10_26_164830_create_departments_table', 1),
(6, '2016_11_08_075145_create_medical_applications_table', 1),
(7, '2016_11_14_084947_add_patient_info', 1),
(8, '2016_11_16_075201_add_user_avatar', 1),
(9, '2016_11_30_032659_add_khoa_column_user', 1),
(10, '2017_03_02_060756_permission', 1),
(11, '2017_03_03_042455_add_cate_column_permission', 1),
(12, '2017_03_03_042935_create_role_permission_table', 1),
(13, '2017_03_06_050415_create_foreign_key_role_permission', 1),
(14, '2017_03_08_012904_create_user_role_table', 1),
(15, '2017_03_09_031756_add_column_users_table', 1),
(16, '2017_03_09_071651_create_share_table', 1),
(17, '2017_03_15_014734_add_scope_column_role_permission_table', 1),
(18, '2017_03_22_011624_rename_role_id_column_users_table', 1),
(19, '2017_03_22_025358_add_description_column_roles_table', 1),
(20, '2017_03_22_031657_rename_role_name_column_roles_table', 1),
(21, '2017_03_22_032026_rename_id_column_roles_table', 1),
(22, '2017_03_22_044918_add_time_stamp_column_roles_table', 1),
(23, '2017_03_23_011931_position', 1),
(24, '2017_03_29_032521_create_user_department_table', 1),
(25, '2017_03_29_034050_drop_khoa_column_users_table', 1),
(26, '2017_03_30_011732_create_foreign_key_position_users_table', 1),
(27, '2017_04_17_072453_create_hospital_table', 1),
(28, '2017_04_20_095117_create_oidcrequests_table', 1),
(29, '2017_04_20_095225_create_oidcproviders_table', 1),
(30, '2017_04_20_095332_create_oidcclients_table', 1),
(31, '2017_04_20_095605_create_doctors_table', 1),
(32, '2017_04_20_095650_create_staffs_table', 1),
(33, '2017_04_20_095750_create_patients_table', 1),
(34, '2017_04_20_095825_create_admins_table', 1),
(35, '2017_04_23_094330_add_khoa_column_user_table', 1),
(36, '2017_04_26_173242_create_client_role_table', 1),
(37, '2017_05_12_033338_add_column_to_openid_table', 1),
(38, '2017_05_12_070715_add_role_id_to_provider_table', 1),
(39, '2017_05_15_063111_add_role_id_to_request_table', 1),
(40, '2017_08_11_033314_create_medical_specialist_applications_table', 2),
(41, '2017_08_11_033331_create_medical_test_applications_table', 2),
(42, '2017_08_14_113358_add_column_tostaffs_table', 3),
(43, '2017_08_14_120111_add_column_to_doctors_table', 4),
(44, '2017_08_15_025511_add_column_to_applications_table', 5),
(45, '2017_08_16_012731_create_medical_specialist_type_table', 6),
(46, '2017_08_16_024438_add_column_name_and_avatar', 7),
(47, '2017_08_18_083645_add_column-medical', 8);

-- --------------------------------------------------------

--
-- Table structure for table `oidcclients`
--

CREATE TABLE `oidcclients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `redirect_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `algorithm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key_secret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `del_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oidcproviders`
--

CREATE TABLE `oidcproviders` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_provider` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `authen_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `del_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `info_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_token_endpoint` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `algorithm` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_age` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oidcrequests`
--

CREATE TABLE `oidcrequests` (
  `id` int(10) UNSIGNED NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_callback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_rp_get_result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_rp_delete` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `algorithm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_age` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contacts` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isAccept` tinyint(4) NOT NULL DEFAULT '-1',
  `request_type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('Nam','Nữ','','') COLLATE utf8_unicode_ci DEFAULT 'Nam',
  `birthday` date DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_date` datetime DEFAULT NULL,
  `id_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permanent_residence` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `staying_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `family_history` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_history` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_id`, `url`, `gender`, `birthday`, `id_number`, `id_date`, `id_address`, `permanent_residence`, `staying_address`, `job`, `company`, `family_history`, `personal_history`, `fullname`, `avatar`) VALUES
(2, 5, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân2', 'default.jpg'),
(3, 8, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân3', 'default.jpg'),
(4, 11, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân4', 'default.jpg'),
(5, 14, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân5', 'default.jpg'),
(6, 20, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân7', 'default.jpg'),
(8, 23, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân8', 'default.jpg'),
(9, 26, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân9', 'default.jpg'),
(10, 29, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân10', 'default.jpg'),
(11, 2, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân1', 'default.jpg'),
(12, 32, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân11', 'default.jpg'),
(13, 35, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân12', 'default.jpg'),
(14, 38, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân13', 'default.jpg'),
(15, 41, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân14', 'default.jpg'),
(16, 47, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân16', 'default.jpg'),
(17, 50, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân17', 'default.jpg'),
(18, 53, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân18', 'default.jpg'),
(19, 56, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân19', 'default.jpg'),
(20, 59, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'Bệnh nhân20', 'default.jpg'),
(21, 103, NULL, 'Nam', '2017-08-03', NULL, NULL, NULL, NULL, 'ha noi', NULL, NULL, '', '', 'bệnh nhân mới', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `created_at`, `updated_at`, `cate`) VALUES
(1, 'khám thể lực', NULL, NULL, NULL),
(2, 'khám nội khoa', NULL, NULL, NULL),
(3, 'khám mắt', NULL, NULL, NULL),
(4, 'khám tai mũi họng', NULL, NULL, NULL),
(5, 'khám răng hàm mặt', NULL, NULL, NULL),
(6, 'khám da liễu', NULL, NULL, NULL),
(7, 'khám cận lâm sàng', NULL, NULL, NULL),
(8, 'khám tổng quan', NULL, NULL, NULL),
(9, 'xem', NULL, NULL, NULL),
(10, 'Sửa', NULL, NULL, NULL),
(11, 'Xóa', NULL, NULL, NULL),
(12, 'Chia sẻ', NULL, NULL, NULL),
(13, 'Tạo mới hồ sơ bệnh nhân', NULL, NULL, NULL),
(14, 'Khám chuyên khoa phổi', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Bệnh nhân', 'Người đến khám bệnh trong bệnh viện', NULL, NULL),
(2, 'Bác sĩ', 'Người khám bệnh cho bệnh nhân', NULL, NULL),
(3, 'Nhân viên', 'Người thực hiện các công vụ trong bệnh viện', NULL, NULL),
(4, 'Admin', 'Người quản lý trang của bệnh viện', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'role bệnh nhân', 'role này là role của các bệnh nhân', '2017-08-08 17:52:51', '2017-08-08 17:52:51'),
(2, 'role nhân viên', 'role này quản lý các nhân viên', '2017-08-08 17:52:51', '2017-08-08 17:52:51'),
(3, 'role bác sĩ', 'role này là role của bác sĩ', '2017-08-08 20:12:32', '2017-08-08 20:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `permission_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `scope` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`, `scope`) VALUES
(1, 1, 9, '2017-08-08 17:52:51', '2017-08-08 17:52:51', NULL),
(2, 2, 13, '2017-08-08 17:52:51', '2017-08-08 17:52:51', NULL),
(6, 3, 12, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(7, 3, 10, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(8, 3, 9, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(9, 3, 8, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(10, 3, 7, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(11, 3, 6, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(12, 3, 5, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(13, 3, 4, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(14, 3, 3, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(15, 3, 2, '2017-09-27 05:56:34', '2017-09-27 05:56:34', NULL),
(16, 3, 1, '2017-09-27 05:56:35', '2017-09-27 05:56:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE `share` (
  `id` int(10) UNSIGNED NOT NULL,
  `resource_owner` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `resource_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `phongban` int(11) DEFAULT NULL,
  `khoa` int(11) DEFAULT NULL,
  `chucvu` int(11) DEFAULT NULL,
  `bangcap` int(11) DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `staff_id`, `phongban`, `khoa`, `chucvu`, `bangcap`, `fullname`, `avatar`) VALUES
(1, 3, 5, 4, 7, 4, 'Nhân viên1', 'default.jpg'),
(2, 6, 4, 4, 7, 3, 'Nhân viên2', 'default.jpg'),
(3, 9, 6, 5, 11, 5, 'Nhân viên3', 'default.jpg'),
(4, 12, 3, 3, 7, 3, '', 'default.jpg'),
(5, 15, 9, 6, 7, 3, 'Nhân viên5', 'default.jpg'),
(6, 18, NULL, 0, 0, 0, '', 'default.jpg'),
(7, 21, NULL, 0, 0, 0, '', 'default.jpg'),
(9, 27, NULL, 0, 0, 0, '', 'default.jpg'),
(10, 30, NULL, 0, 0, 0, '', 'default.jpg'),
(11, 33, NULL, 0, 0, 0, '', 'default.jpg'),
(12, 36, NULL, 0, 0, 0, '', 'default.jpg'),
(13, 39, NULL, 0, 0, 0, '', 'default.jpg'),
(14, 42, NULL, 0, 0, 0, '', 'default.jpg'),
(15, 45, NULL, 0, 0, 0, '', 'default.jpg'),
(16, 48, NULL, 0, 0, 0, '', 'default.jpg'),
(17, 51, NULL, 0, 0, 0, '', 'default.jpg'),
(18, 54, NULL, 0, 0, 0, '', 'default.jpg'),
(19, 57, NULL, 0, 0, 0, '', 'default.jpg'),
(20, 60, NULL, 0, 0, 0, '', 'default.jpg'),
(23, 94, 1, 1, 7, 1, '', 'default.jpg'),
(24, 95, 3, 1, 7, 3, '', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `position` int(10) UNSIGNED DEFAULT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_local` tinyint(1) NOT NULL DEFAULT '1',
  `last_auth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expired` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `position`, `domain`, `is_local`, `last_auth`, `expired`) VALUES
(1, 'Bác Sĩ 1', 'bs1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'd3xDPqmgVd2riWSjMtM6R87sVeXoOiiamG48uUrsVf1MGOGQYiER8lfPkY91', '2017-08-08 17:52:51', '2017-11-12 07:17:10', 2, NULL, 1, NULL, NULL),
(2, 'Bệnh nhân1', 'bn1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '44juUNuwLS7s6S4qGTABfpmGbljR5S2Fg2DpjhUpjYLEdxtT0k3nhNugZBOB', '2017-08-08 17:52:52', '2017-11-21 17:42:10', 1, NULL, 1, NULL, NULL),
(3, 'Nhân viên1', 'nv1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'mbTaEIAUEpu0OgEDTlIdRldpUtSSTOClsoAHGSuE9T25XdC8TVhT2h0eVREM', '2017-08-08 17:52:52', '2017-10-26 20:53:06', 3, NULL, 1, NULL, NULL),
(4, 'Bác Sĩ 2', 'bs2@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'Nvwv3eFrBp8GtESbrFDA8uEvK1xlGjHCNUoMXn9wvJr3ZGIrp5ac5tQUEIMv', '2017-08-08 17:52:52', '2017-10-25 01:57:40', 2, NULL, 1, NULL, NULL),
(5, 'Bệnh nhân2', 'bn2@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'ByQZDnFyKqJJrdvv1Zl2ZUGkr1HVsfxTqABsk0jWxKrlaSH6s45p8HbTYGtx', '2017-08-08 17:52:52', '2017-09-23 21:37:43', 1, NULL, 1, NULL, NULL),
(6, 'Nhân viên2', 'nv2@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'X8BNlmeawrl1SX8Uvz4mlDhdUljjQctgtrexfmU8mnNPEk8BoASPkBLoXYjI', '2017-08-08 17:52:52', '2017-08-24 18:46:53', 3, NULL, 1, NULL, NULL),
(7, 'Bác Sĩ 3', 'bs3@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'i0j3verGDzrwlCIc0G7UjJGHcsrBhzcxQGeVBoNhm5rVQF7G3lzxzfKJC0kM', '2017-08-08 17:52:52', '2017-08-10 02:31:03', 2, NULL, 1, NULL, NULL),
(8, 'Bệnh nhân3', 'bn3@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'lHUShG1VCXIMx8akFv2molLqQmG3JLA1gyCPJgpbWXM4Cew2FLq2fUJSkJrb', '2017-08-08 17:52:52', '2017-08-29 02:24:21', 1, NULL, 1, NULL, NULL),
(9, 'Nhân viên3', 'nv3@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'KIKyHXWQVgw4HlrnJ8SrBVaRInWR3n3yIRe2b4KIhwPsUYSI4JxZbiUItcjA', '2017-08-08 17:52:52', '2017-10-26 20:52:46', 3, NULL, 1, NULL, NULL),
(10, 'Bác Sĩ 4', 'bs4@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:52', '2017-08-14 18:08:47', 2, NULL, 1, NULL, NULL),
(11, 'Bệnh nhân4', 'bn4@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '0p6v2KwhHxKY5OJRjB3l8VlpmkFn9Xz6ZI2Ym9u6L3SGanTaFI9cfRH0wgI7', '2017-08-08 17:52:52', '2017-08-31 20:17:22', 1, NULL, 1, NULL, NULL),
(12, 'Nhân viên4', 'nv4@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'KQ8Yghzt3GJHpQ1BB1QXIA5fCWaT1aVBgSaDS0qEIK23CS54yiJoMA7hrVRZ', '2017-08-08 17:52:53', '2017-10-26 20:53:24', 3, NULL, 1, NULL, NULL),
(13, 'Bác Sĩ 5', 'bs5@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'PTKLG33EVQHFVC9kwgZDx7w6BgQZnkOrmk7yloMvQEoVCPKCAK0TTxr4Hxcl', '2017-08-08 17:52:53', '2017-10-25 01:56:38', 2, NULL, 1, NULL, NULL),
(14, 'Bệnh nhân5', 'bn5@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'v3TnURD1U6s9OBKKDHNxPCz8Z1gbEdft4XurF6VXIhhE6n9ePGRix6lmWC3K', '2017-08-08 17:52:53', '2017-08-15 23:37:03', 1, NULL, 1, NULL, NULL),
(15, 'Nhân viên5', 'nv5@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'S5uSR0vXok70z4LyarpKQUAffEvgDjE9hXIgQgBhNjZvY05EPE6LV1ZV93ZP', '2017-08-08 17:52:53', '2017-08-29 01:57:16', 3, NULL, 1, NULL, NULL),
(16, 'Bác Sĩ 6', 'bs6@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:53', '2017-08-08 17:52:53', 2, NULL, 1, NULL, NULL),
(17, 'Bệnh nhân6', 'bn6@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'SpUnCxvngpdJ6WcX4mSkfuFmVFo4ym0HN6aJv5LSoEnEX5b1zv4tQyGW4g69', '2017-08-08 17:52:53', '2017-08-29 01:59:14', 1, NULL, 1, NULL, NULL),
(18, 'Nhân viên6', 'nv6@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:53', '2017-08-08 17:52:53', 3, NULL, 1, NULL, NULL),
(19, 'Bác Sĩ 7', 'bs7@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:53', '2017-08-08 17:52:53', 2, NULL, 1, NULL, NULL),
(20, 'Bệnh nhân7', 'bn7@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'gzhC9TFLGmBtMNcjXyS55Suh89IB3OfYoq1NP72tOSFsXacvvYb022EUDuyi', '2017-08-08 17:52:53', '2017-08-29 00:29:10', 1, NULL, 1, NULL, NULL),
(21, 'Nhân viên7', 'nv7@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:53', '2017-08-08 17:52:53', 3, NULL, 1, NULL, NULL),
(22, 'Bác Sĩ 8', 'bs8@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:53', '2017-08-08 17:52:53', 2, NULL, 1, NULL, NULL),
(23, 'Bệnh nhân8', 'bn8@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'nz8JQNDqTuonzsMrTvnSvTskgLtrAGug2mO5hHqKRFIfdirwJ9rfsjyZzntn', '2017-08-08 17:52:53', '2017-10-25 01:58:55', 1, NULL, 1, NULL, NULL),
(26, 'Bệnh nhân9', 'bn9@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-16 21:01:53', 1, NULL, 1, NULL, NULL),
(27, 'Nhân viên9', 'nv9@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 3, NULL, 1, NULL, NULL),
(28, 'Bác Sĩ 10', 'bs10@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 2, NULL, 1, NULL, NULL),
(29, 'Bệnh nhân10', 'bn10@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-16 21:02:01', 1, NULL, 1, NULL, NULL),
(30, 'Nhân viên10', 'nv10@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 3, NULL, 1, NULL, NULL),
(31, 'Bác Sĩ 11', 'bs11@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 2, NULL, 1, NULL, NULL),
(32, 'Bệnh nhân11', 'bn11@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:54', '2017-08-15 20:34:20', 1, NULL, 1, NULL, NULL),
(33, 'Nhân viên11', 'nv11@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 3, NULL, 1, NULL, NULL),
(34, 'Bác Sĩ 12', 'bs12@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 2, NULL, 1, NULL, NULL),
(35, 'Bệnh nhân12', 'bn12@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:54', '2017-08-15 20:34:22', 1, NULL, 1, NULL, NULL),
(36, 'Nhân viên12', 'nv12@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:54', '2017-08-08 17:52:54', 3, NULL, 1, NULL, NULL),
(37, 'Bác Sĩ 13', 'bs13@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 2, NULL, 1, NULL, NULL),
(38, 'Bệnh nhân13', 'bn13@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:55', '2017-08-15 20:34:24', 1, NULL, 1, NULL, NULL),
(39, 'Nhân viên13', 'nv13@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 3, NULL, 1, NULL, NULL),
(40, 'Bác Sĩ 14', 'bs14@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 2, NULL, 1, NULL, NULL),
(41, 'Bệnh nhân14', 'bn14@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:55', '2017-08-15 20:34:26', 1, NULL, 1, NULL, NULL),
(42, 'Nhân viên14', 'nv14@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 3, NULL, 1, NULL, NULL),
(43, 'Bác Sĩ 15', 'bs15@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 2, NULL, 1, NULL, NULL),
(44, 'Bệnh nhân15', 'bn15@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 1, NULL, 1, NULL, NULL),
(45, 'Nhân viên15', 'nv15@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 3, NULL, 1, NULL, NULL),
(46, 'Bác Sĩ 16', 'bs16@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 2, NULL, 1, NULL, NULL),
(47, 'Bệnh nhân16', 'bn16@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:55', '2017-08-15 20:34:28', 1, NULL, 1, NULL, NULL),
(48, 'Nhân viên16', 'nv16@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:55', '2017-08-08 17:52:55', 3, NULL, 1, NULL, NULL),
(49, 'Bác Sĩ 17', 'bs17@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 2, NULL, 1, NULL, NULL),
(50, 'Bệnh nhân17', 'bn17@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:56', '2017-08-15 20:34:30', 1, NULL, 1, NULL, NULL),
(51, 'Nhân viên17', 'nv17@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 3, NULL, 1, NULL, NULL),
(52, 'Bác Sĩ 18', 'bs18@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 2, NULL, 1, NULL, NULL),
(53, 'Bệnh nhân18', 'bn18@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:56', '2017-08-15 20:34:32', 1, NULL, 1, NULL, NULL),
(54, 'Nhân viên18', 'nv18@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 3, NULL, 1, NULL, NULL),
(55, 'Bác Sĩ 19', 'bs19@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 2, NULL, 1, NULL, NULL),
(56, 'Bệnh nhân19', 'bn19@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:56', '2017-08-15 20:34:34', 1, NULL, 1, NULL, NULL),
(57, 'Nhân viên19', 'nv19@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 3, NULL, 1, NULL, NULL),
(58, 'Bác Sĩ 20', 'bs20@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'Rcr2KGUqLGVlHBg8sj5Cx6Dor508SMDpVNtWrlRag4fgcw3gVBxJifkjyaaq', '2017-08-08 17:52:56', '2017-08-09 23:05:00', 2, NULL, 1, NULL, NULL),
(59, 'Bệnh nhân20', 'bn20@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-08 17:52:56', '2017-08-15 20:27:41', 1, NULL, 1, NULL, NULL),
(60, 'Nhân viên20', 'nv20@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-08 17:52:56', '2017-08-08 17:52:56', 3, NULL, 1, NULL, NULL),
(62, 'admin1', 'ad1@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'XSL8jRtkVJgrbqxtrED75ijYoRxCQQdkb3KmhryLFtM16deWiikACvQoMy3L', '2017-08-08 19:32:29', '2017-08-16 01:02:08', 4, NULL, 1, NULL, NULL),
(94, 'nv21', 'nv21@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-10 20:27:34', '2017-08-10 20:28:31', 3, NULL, 1, NULL, NULL),
(95, 'nv22', 'nv22@gmail.com', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', NULL, '2017-08-14 18:15:18', '2017-08-14 18:17:32', 3, NULL, 1, NULL, NULL),
(102, 'Bs24', 'bs24@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, '2017-08-16 00:29:57', '2017-08-16 00:29:57', 2, NULL, 1, NULL, NULL),
(103, 'bệnh nhân mới', 'bnm@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'qXzJm4ziMilDx1DDCPbQOohpXpiZtdcHDTYTKXj0JgQvRfXJtT8do1jbwxQl', '2017-08-23 19:58:44', '2017-08-23 20:02:19', 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_degree`
--

CREATE TABLE `user_degree` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_degree`
--

INSERT INTO `user_degree` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Giáo sư', '2017-08-09 04:11:45', '0000-00-00 00:00:00'),
(2, 'Tiến sĩ', '2017-08-09 04:11:45', '0000-00-00 00:00:00'),
(3, 'Thạc sĩ', '2017-08-09 04:12:08', '0000-00-00 00:00:00'),
(4, 'Cao học', '2017-08-09 04:12:08', '0000-00-00 00:00:00'),
(5, 'Khác', '2017-08-16 02:36:00', '2017-08-16 02:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_infomation`
--

CREATE TABLE `user_infomation` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `khoa_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `chucvu_id` int(3) DEFAULT NULL,
  `bangcap_id` int(3) DEFAULT NULL,
  `phongban_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_infomation`
--

INSERT INTO `user_infomation` (`id`, `user_id`, `khoa_id`, `created_at`, `updated_at`, `chucvu_id`, `bangcap_id`, `phongban_id`) VALUES
(3, 94, 1, NULL, NULL, 7, 1, 1),
(4, 9, 1, NULL, NULL, 7, 3, 3),
(11, 95, 1, NULL, NULL, 7, 1, 1),
(13, 102, 1, NULL, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_office`
--

CREATE TABLE `user_office` (
  `id` int(11) NOT NULL,
  `position_id` int(3) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_office`
--

INSERT INTO `user_office` (`id`, `position_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Trưởng khoa', '2017-08-09 04:10:41', '2017-08-09 04:10:41'),
(2, 2, 'Phó khoa', '2017-08-09 04:10:41', '2017-08-09 04:10:41'),
(3, 2, 'Bác sĩ', '2017-08-09 04:11:04', '2017-08-09 04:11:04'),
(4, 2, 'Bác sĩ nội chú', '2017-08-09 04:11:04', '2017-08-09 04:11:04'),
(5, 2, 'Bác sĩ thực tập', '2017-08-09 19:16:32', '2017-08-09 19:16:32'),
(6, 2, 'Bác sĩ xét nghiệm', '2017-08-09 20:40:13', '2017-08-09 20:40:13'),
(7, 3, 'Kỹ sư y học', '2017-08-11 01:19:39', '2017-08-11 01:19:39'),
(11, 3, 'Lễ tân', '2017-08-16 02:23:27', '2017-08-16 02:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(2, 3, 2, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(3, 5, 1, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(4, 6, 2, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(5, 8, 1, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(6, 9, 2, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(7, 11, 1, '2017-08-08 17:52:52', '2017-08-08 17:52:52'),
(8, 12, 2, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(9, 14, 1, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(10, 15, 2, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(11, 17, 1, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(12, 18, 2, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(13, 20, 1, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(14, 21, 2, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(15, 23, 1, '2017-08-08 17:52:53', '2017-08-08 17:52:53'),
(17, 26, 1, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(18, 27, 2, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(19, 29, 1, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(20, 30, 2, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(21, 32, 1, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(22, 33, 2, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(23, 35, 1, '2017-08-08 17:52:54', '2017-08-08 17:52:54'),
(24, 36, 2, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(25, 38, 1, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(26, 39, 2, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(27, 41, 1, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(28, 42, 2, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(29, 44, 1, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(30, 45, 2, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(31, 47, 1, '2017-08-08 17:52:55', '2017-08-08 17:52:55'),
(32, 48, 2, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(33, 50, 1, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(34, 51, 2, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(35, 53, 1, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(36, 54, 2, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(37, 56, 1, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(38, 57, 2, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(39, 59, 1, '2017-08-08 17:52:56', '2017-08-08 17:52:56'),
(40, 60, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(41, 59, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(42, 56, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(43, 53, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(44, 50, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(45, 47, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(46, 44, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(47, 41, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(48, 38, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(49, 35, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(50, 32, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(51, 29, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(52, 26, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(53, 23, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(54, 20, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(55, 17, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(56, 14, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(57, 11, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(58, 8, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(59, 5, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(60, 2, 1, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(61, 60, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(62, 57, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(63, 54, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(64, 51, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(65, 48, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(66, 45, 2, '2017-08-08 17:52:57', '2017-08-08 17:52:57'),
(67, 42, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(68, 39, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(69, 36, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(70, 33, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(71, 30, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(72, 27, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(74, 21, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(75, 18, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(76, 15, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(77, 12, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(78, 9, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(79, 6, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(80, 3, 2, '2017-08-08 17:52:58', '2017-08-08 17:52:58'),
(81, 58, 1, '2017-08-08 20:13:16', '2017-08-08 20:13:16'),
(82, 58, 3, '2017-08-08 20:15:57', '2017-08-08 20:15:57'),
(85, 94, 2, '2017-08-10 20:27:34', '2017-08-10 20:27:34'),
(86, 95, 2, '2017-08-14 18:15:18', '2017-08-14 18:15:18'),
(87, 103, 1, '2017-08-23 19:58:44', '2017-08-23 19:58:44'),
(88, 7, 3, '2017-09-27 05:56:43', '2017-09-27 05:56:43'),
(89, 4, 3, '2017-09-27 05:56:43', '2017-09-27 05:56:43'),
(90, 1, 3, '2017-09-27 05:56:43', '2017-09-27 05:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_room`
--

CREATE TABLE `user_room` (
  `id` int(11) NOT NULL,
  `room_number` varchar(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` int(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_room`
--

INSERT INTO `user_room` (`id`, `room_number`, `name`, `department`, `created_at`, `updated_at`) VALUES
(1, '101', 'Phòng khám sức khỏe 1', NULL, '2017-08-11 01:46:56', '2017-08-11 01:46:56'),
(2, '102', 'Phòng khám sức khỏe 2', NULL, '2017-08-11 01:46:56', '2017-08-11 01:46:56'),
(3, '201', 'phòng xét nghiệm máu', 3, '2017-08-11 01:48:22', '2017-08-11 01:48:22'),
(4, '205', 'Phòng siêu âm', 4, '2017-08-11 01:48:22', '2017-08-11 01:48:22'),
(5, '301', 'Phòng chụp X_quang', 2, '2017-08-11 01:49:56', '2017-08-11 01:49:56'),
(6, 'DK1', 'phòng tiếp tân', NULL, '2017-08-16 02:35:17', '2017-08-16 02:35:17'),
(7, '202', 'Phổi 1', 6, '2017-08-17 20:29:48', '2017-08-17 20:29:48'),
(8, '203', 'Phổi 2', 6, '2017-08-17 20:30:12', '2017-08-17 20:30:12'),
(9, '204', 'Phòng đo phổi', 6, '2017-08-29 08:37:56', '2017-08-29 08:37:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `client_role`
--
ALTER TABLE `client_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_role_client_id_foreign` (`client_id`),
  ADD KEY `client_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hospital_role_id_foreign` (`role_id`);

--
-- Indexes for table `medical_applications`
--
ALTER TABLE `medical_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_applications_url_unique` (`url`),
  ADD KEY `medical_applications_user_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_specialist_applications`
--
ALTER TABLE `medical_specialist_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_specialist_applications_url_unique` (`url`),
  ADD KEY `medical_specialist_applications_user_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_specialist_type`
--
ALTER TABLE `medical_specialist_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_test_applications`
--
ALTER TABLE `medical_test_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medical_test_applications_url_unique` (`url`),
  ADD KEY `medical_test_applications_user_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_test_type`
--
ALTER TABLE `medical_test_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oidcclients`
--
ALTER TABLE `oidcclients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oidcclients_domain_unique` (`domain`);

--
-- Indexes for table `oidcproviders`
--
ALTER TABLE `oidcproviders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oidcproviders_id_provider_unique` (`id_provider`);

--
-- Indexes for table `oidcrequests`
--
ALTER TABLE `oidcrequests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oidcrequests_domain_unique` (`domain`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_id_unique` (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permission_role_id_foreign` (`role_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_resource_owner_foreign` (`resource_owner`),
  ADD KEY `share_role_id_foreign` (`role_id`),
  ADD KEY `share_resource_id_foreign` (`resource_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffs_staff_id_foreign` (`staff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_position_foreign` (`position`);

--
-- Indexes for table `user_degree`
--
ALTER TABLE `user_degree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_infomation`
--
ALTER TABLE `user_infomation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_department_user_id_foreign` (`user_id`),
  ADD KEY `user_department_department_id_foreign` (`khoa_id`);

--
-- Indexes for table `user_office`
--
ALTER TABLE `user_office`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_user_id_foreign` (`user_id`),
  ADD KEY `user_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_room`
--
ALTER TABLE `user_room`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `client_role`
--
ALTER TABLE `client_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medical_applications`
--
ALTER TABLE `medical_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medical_specialist_applications`
--
ALTER TABLE `medical_specialist_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `medical_specialist_type`
--
ALTER TABLE `medical_specialist_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `medical_test_applications`
--
ALTER TABLE `medical_test_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `medical_test_type`
--
ALTER TABLE `medical_test_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `oidcclients`
--
ALTER TABLE `oidcclients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oidcproviders`
--
ALTER TABLE `oidcproviders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oidcrequests`
--
ALTER TABLE `oidcrequests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `user_degree`
--
ALTER TABLE `user_degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_infomation`
--
ALTER TABLE `user_infomation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_office`
--
ALTER TABLE `user_office`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `user_room`
--
ALTER TABLE `user_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_role`
--
ALTER TABLE `client_role`
  ADD CONSTRAINT `client_role_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oidcclients` (`id`),
  ADD CONSTRAINT `client_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `hospital_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `medical_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `share_resource_owner_foreign` FOREIGN KEY (`resource_owner`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `share_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_position_foreign` FOREIGN KEY (`position`) REFERENCES `position` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_infomation`
--
ALTER TABLE `user_infomation`
  ADD CONSTRAINT `user_department_department_id_foreign` FOREIGN KEY (`khoa_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_department_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
