-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2022 at 07:09 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `namear` varchar(100) NOT NULL,
  `nameen` varchar(100) NOT NULL,
  `balance_sheet` int(11) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL DEFAULT 0,
  `parentId` int(11) NOT NULL DEFAULT 0,
  `parent_2_id` int(11) NOT NULL DEFAULT 0,
  `parent_3_id` double NOT NULL DEFAULT 0,
  `parent_4_id` double NOT NULL DEFAULT 0,
  `parent_5_id` int(11) NOT NULL DEFAULT 0,
  `child` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `namear`, `nameen`, `balance_sheet`, `parent`, `parentId`, `parent_2_id`, `parent_3_id`, `parent_4_id`, `parent_5_id`, `child`, `created_at`, `updated_at`) VALUES
(1, 'أصول', 'ass', 2, 1, 0, 0, 0, 0, 0, 0, '2022-01-25 11:57:49', '2022-01-25 11:57:49'),
(2, 'خصوم', 'خصوم', 2, 1, 0, 0, 0, 0, 0, 0, '2022-01-25 11:58:18', '2022-01-25 11:58:18'),
(3, 'ايرادات / تكلفة الايرادات', 'ايرادات / تكلفة الايرادات', 1, 1, 0, 0, 0, 0, 0, 0, '2022-01-25 11:58:57', '2022-01-25 11:58:57'),
(4, 'المصروفات', 'المصروفات', 1, 1, 0, 0, 0, 0, 0, 0, '2022-01-25 11:59:40', '2022-01-25 11:59:40'),
(5, 'حقوق الملكية', 'حقوق الملكية', 2, 1, 0, 0, 0, 0, 0, 0, '2022-01-25 11:59:57', '2022-01-25 11:59:57'),
(6, 'أصول طويلة الاجل', 'أصول طويلة الاجل', 2, 1, 1, 0, 0, 0, 0, 0, '2022-01-25 12:00:30', '2022-01-25 12:00:30'),
(7, 'اصول متداولة', 'اصول متداولة', 2, 1, 1, 0, 0, 0, 0, 0, '2022-01-25 12:00:55', '2022-01-25 12:00:55'),
(8, 'العملاء', 'العملاء', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:01:35', '2022-01-25 12:01:35'),
(9, 'النقدية', 'النقدية', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:02:06', '2022-01-25 12:02:06'),
(10, 'البنوك', 'البنوك', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:03:07', '2022-01-25 12:03:07'),
(11, 'المخزون', 'المخزون', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:03:34', '2022-01-25 12:03:34'),
(13, 'البنك', 'البنك', 2, 0, 1, 7, 10, 0, 0, 1, '2022-01-25 12:04:55', '2022-01-25 12:04:55'),
(14, 'الفيزا', 'الفيزا', 2, 0, 1, 7, 10, 0, 0, 1, '2022-01-25 12:05:24', '2022-01-25 12:05:24'),
(15, 'الموظفين', 'الموظفين', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:05:52', '2022-01-25 12:05:52'),
(16, 'مدينون متنوعون', 'مدينون متنوعون', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:06:23', '2022-01-25 12:06:23'),
(17, 'تحويلات مخازن بين الفروع', 'تحويلات مخازن بين الفروع', 2, 0, 1, 7, 11, 0, 0, 1, '2022-01-25 12:07:10', '2022-01-25 12:07:10'),
(18, 'السلف', 'السلف', 2, 1, 1, 7, 0, 0, 0, 0, '2022-01-25 12:07:48', '2022-01-25 12:07:48'),
(19, 'خصوم غير متداولة', 'خصوم غير متداولة', 2, 1, 2, 0, 0, 0, 0, 0, '2022-01-25 12:08:48', '2022-01-25 12:08:48'),
(20, 'خصوم متداولة', 'خصوم متداولة', 2, 1, 2, 0, 0, 0, 0, 0, '2022-01-25 12:09:17', '2022-01-25 12:09:17'),
(21, 'الموردون', 'الموردون', 2, 1, 2, 20, 0, 0, 0, 0, '2022-01-25 12:09:39', '2022-01-25 12:09:39'),
(22, 'الضرائب', 'الضرائب', 2, 1, 2, 20, 0, 0, 0, 0, '2022-01-25 12:10:13', '2022-01-25 12:10:13'),
(23, 'ضريبة القيمة المضافة', 'ضريبة القيمة المضافة', 2, 0, 2, 20, 22, 0, 0, 1, '2022-01-25 12:10:33', '2022-01-25 12:10:33'),
(24, 'الايرادات', 'الايرادات', 1, 1, 3, 0, 0, 0, 0, 0, '2022-01-25 12:10:57', '2022-01-25 12:10:57'),
(25, 'المبيعات', 'المبيعات', 1, 0, 3, 24, 0, 0, 0, 1, '2022-01-25 12:13:04', '2022-01-25 12:13:04'),
(26, 'تكلفة المبيعات', 'تكلفة المبيعات', 1, 1, 3, 0, 0, 0, 0, 0, '2022-01-25 12:13:30', '2022-01-25 12:13:30'),
(27, 'تكلفة مبيعات المخزن الرئيسى', 'تكلفة مبيعات المخزن الرئيسى', 1, 0, 3, 26, 0, 0, 0, 1, '2022-01-25 12:13:55', '2022-01-25 12:13:55'),
(28, 'خصم مكتسب', 'خصم مكتسب', 1, 0, 3, 24, 0, 0, 0, 1, '2022-01-25 12:14:38', '2022-01-25 12:14:38'),
(29, 'خصم مسموح به', 'خصم مسموح به', 1, 0, 3, 26, 0, 0, 0, 1, '2022-01-25 12:15:51', '2022-01-25 12:15:51'),
(30, 'مصروفات تشغيل', 'مصروفات تشغيل', 1, 1, 4, 0, 0, 0, 0, 0, '2022-01-25 12:16:26', '2022-01-25 12:16:26'),
(31, 'مصروفات عمومية', 'مصروفات عمومية', 1, 1, 4, 0, 0, 0, 0, 0, '2022-01-25 12:16:51', '2022-01-25 12:16:51'),
(32, 'راس المال', 'راس المال', 2, 0, 5, 0, 0, 0, 0, 1, '2022-01-25 12:17:24', '2022-01-25 12:17:24'),
(33, 'جارى الشريك', 'جارى الشريك', 2, 1, 5, 0, 0, 0, 0, 0, '2022-01-25 12:18:00', '2022-01-25 12:18:00'),
(34, 'جارى الشريك', 'جارى الشريك', 2, 0, 5, 33, 0, 0, 0, 1, '2022-01-25 12:18:17', '2022-01-25 12:18:17'),
(35, 'الارباح والخسائر المرحله', 'الارباح والخسائر المرحله', 2, 0, 5, 0, 0, 0, 0, 1, '2022-01-25 12:19:05', '2022-01-25 12:19:05'),
(36, 'مرتجع المبيعات', 'مرتجع المبيعات', 1, 0, 3, 26, 0, 0, 0, 1, '2022-01-25 12:20:29', '2022-01-25 12:20:29'),
(37, 'ايرادات اخرى', 'ايرادات اخرى', 1, 1, 3, 0, 0, 0, 0, 0, '2022-01-25 12:22:52', '2022-01-25 12:22:52'),
(39, 'الصندوق', 'الصندوق', 2, 0, 1, 7, 9, 0, 0, 1, '2022-01-25 12:51:03', '2022-01-25 12:51:03'),
(40, 'ضريبة خصم المنبع', 'ضريبة خصم المنبع', 1, 0, 2, 20, 22, 0, 0, 1, '2022-02-16 08:20:16', '2022-02-16 08:20:16'),
(42, 'مصروف ايجار سيارات نقل ابو وليد', 'مصروف ايجار سيارات نقل ابو وليد', 1, 0, 4, 30, 0, 0, 0, 1, '2022-02-19 19:19:06', '2022-02-19 19:19:06'),
(43, 'محطة الخالد', 'محطة الخالد', 2, 0, 1, 7, 16, 0, 0, 1, '2022-02-19 19:19:52', '2022-02-19 19:19:52'),
(44, 'مصروفات نثريه', 'مصروفات نثريه', 1, 0, 4, 31, 0, 0, 0, 1, '2022-02-19 19:20:16', '2022-02-19 19:20:16'),
(45, 'مصروف ايجار المكتب', 'مصروف ايجار المكتب', 1, 0, 4, 31, 0, 0, 0, 1, '2022-02-19 19:20:53', '2022-02-19 19:20:53'),
(46, 'مصروفات بوفيه', 'مصروفات بوفيه', 1, 0, 4, 31, 0, 0, 0, 1, '2022-02-19 19:21:14', '2022-02-19 19:21:14'),
(47, 'اجور ومرتبات', 'اجور ومرتبات', 1, 0, 4, 30, 0, 0, 0, 1, '2022-02-19 19:21:37', '2022-02-19 19:21:37'),
(48, 'اكراميات عمال', 'اكراميات عمال', 1, 0, 4, 30, 0, 0, 0, 1, '2022-02-19 19:22:15', '2022-02-19 19:22:15'),
(49, 'مصروف السيارات', 'مصروف السيارات', 1, 1, 4, 30, 0, 0, 0, 0, '2022-02-19 19:23:13', '2022-02-19 19:23:13'),
(50, 'صيانة السيارات', 'صيانة السيارات', 1, 0, 4, 30, 49, 0, 0, 1, '2022-02-19 19:23:42', '2022-02-19 19:23:42'),
(51, 'المحروقات', 'المحروقات', 1, 0, 4, 30, 49, 0, 0, 1, '2022-02-19 19:24:30', '2022-02-19 19:24:30'),
(52, 'غيار زيت', 'غيار زيت', 1, 0, 4, 30, 49, 0, 0, 1, '2022-02-19 19:24:57', '2022-02-19 19:24:57'),
(53, 'اتصالات وانترنت', 'اتصالات وانترنت', 1, 0, 4, 31, 0, 0, 0, 1, '2022-02-19 19:26:54', '2022-02-19 19:26:54'),
(54, 'كهرباء ومياه المكتب', 'اتصالات وانترنت', 1, 0, 4, 31, 0, 0, 0, 1, '2022-02-19 19:27:28', '2022-02-19 19:27:28'),
(55, 'خدمة التوصيل', 'خدمة التوصيل', 1, 0, 3, 37, 0, 0, 0, 1, '2022-03-23 08:35:33', '2022-03-23 08:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `bond`
--

CREATE TABLE `bond` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL DEFAULT 1,
  `fiscal_year` varchar(100) NOT NULL DEFAULT '1',
  `account_id` int(11) NOT NULL DEFAULT 0,
  `account_name` varchar(100) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bond_list`
--

CREATE TABLE `bond_list` (
  `id` int(11) NOT NULL,
  `bond_id` int(11) NOT NULL DEFAULT 0,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `account_name` varchar(111) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `cost_center` int(11) DEFAULT NULL,
  `cost_center_name` varchar(255) DEFAULT NULL,
  `delegate` int(11) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `balance` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `namear` varchar(255) NOT NULL,
  `nameen` varchar(255) NOT NULL,
  `code_activite` float DEFAULT NULL,
  `activite_code` float DEFAULT NULL,
  `companyId` int(11) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `namear`, `nameen`, `code_activite`, `activite_code`, `companyId`, `city`, `address`, `region`, `country`, `phone`, `updated_at`, `created_at`) VALUES
(1, 'الشفاء', 'الفرع الرئيسي', NULL, NULL, 1, 'الرياض', 'ش المثنى بن حارثة', 'الرياض', 'السعودية', '053', '2022-05-26 13:36:36', '2022-05-26 14:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `categoryitems`
--

CREATE TABLE `categoryitems` (
  `id` int(11) NOT NULL,
  `namear` varchar(255) NOT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `main` tinyint(4) NOT NULL DEFAULT 0,
  `main_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categoryitems`
--

INSERT INTO `categoryitems` (`id`, `namear`, `nameen`, `img`, `main`, `main_id`) VALUES
(1, 'باستا', 'pasta', '', 0, 0),
(2, 'مشروبات', 'Drinks', '', 0, 0),
(3, 'بيتزا', 'pizza', NULL, 0, 0),
(4, 'سلطات', 'salad', NULL, 0, 0),
(5, 'اضافات', 'add', NULL, 0, 0),
(6, 'ديناميت شريمب', 'dynamite shrimp', NULL, 0, 0),
(7, 'خدمة توصيل', 'Delivery', NULL, 0, 0),
(8, 'وجبات', 'Meals', NULL, 0, 0),
(9, 'ماك اند تشيز', 'Mac&cheese', NULL, 0, 0),
(26, 'تيستات', 'تيستات', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `compaines`
--

CREATE TABLE `compaines` (
  `id` int(11) NOT NULL,
  `restaurant` int(11) NOT NULL DEFAULT 0,
  `printFront` int(11) NOT NULL DEFAULT 0,
  `negative_sale` int(2) NOT NULL DEFAULT 0,
  `companyNameAr` varchar(255) NOT NULL,
  `companyNameEn` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `taxNum` varchar(255) NOT NULL DEFAULT '0',
  `tax_source` tinyint(4) NOT NULL DEFAULT 0,
  `tobacco_tax` tinyint(2) NOT NULL DEFAULT 0,
  `signature_type` varchar(5) NOT NULL DEFAULT 'I',
  `token_serial_name` varchar(50) NOT NULL DEFAULT '',
  `token_pin_password` varchar(255) DEFAULT NULL,
  `document_type_version` tinyint(4) NOT NULL DEFAULT 1,
  `client_id` varchar(100) DEFAULT NULL,
  `client_secret` varchar(100) DEFAULT NULL,
  `token_url` varchar(100) NOT NULL DEFAULT 'https://id.eta.gov.eg/connect/token',
  `document_url` varchar(100) NOT NULL DEFAULT 'https://api.invoicing.eta.gov.eg/api/v1/documentsubmissions',
  `show_document_url` varchar(100) NOT NULL DEFAULT 'https://invoicing.eta.gov.eg/documents',
  `type_invoice_electronic` varchar(100) NOT NULL DEFAULT 'Bللاعمال التجارية فى مصر',
  `country_tax_code` varchar(50) NOT NULL DEFAULT 'EGY',
  `active` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compaines`
--

INSERT INTO `compaines` (`id`, `restaurant`, `printFront`, `negative_sale`, `companyNameAr`, `companyNameEn`, `logo`, `taxNum`, `tax_source`, `tobacco_tax`, `signature_type`, `token_serial_name`, `token_pin_password`, `document_type_version`, `client_id`, `client_secret`, `token_url`, `document_url`, `show_document_url`, `type_invoice_electronic`, `country_tax_code`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 'كيانك المحاسبي', 'kayanac', '1.png', '300767259900003', 0, 1, 'I', 'null', '123', 1, '', '', 'https://id.eta.gov.eg/connect/token', 'https://api.invoicing.eta.gov.eg/api/v1/documentsubmissions', 'https://invoicing.eta.gov.eg/documents', 'Bللاعمال التجارية فى مصر', 'EGY', 'تقنية معلومات \r\nسوفت وير', '2022-07-13 12:55:47', '2022-07-13 10:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `cost_centers`
--

CREATE TABLE `cost_centers` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 1,
  `namear` varchar(255) NOT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `group1` int(11) NOT NULL DEFAULT 0,
  `group2` int(11) NOT NULL DEFAULT 0,
  `group3` int(11) NOT NULL DEFAULT 0,
  `group4` int(11) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL DEFAULT 0,
  `child` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customers`
--

CREATE TABLE `crm_customers` (
  `id` int(11) NOT NULL,
  `account_id` double NOT NULL DEFAULT 0,
  `employee` varchar(100) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `namear` varchar(255) DEFAULT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `group` int(11) NOT NULL DEFAULT 1,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT '1',
  `VATRegistration` varchar(50) DEFAULT NULL,
  `IdentificationNumber` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `bigar` varchar(100) NOT NULL DEFAULT '',
  `bigen` varchar(100) NOT NULL DEFAULT '',
  `smallar` varchar(100) NOT NULL DEFAULT '',
  `smallen` varchar(100) NOT NULL DEFAULT '',
  `main` int(2) NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `tax_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `bigar`, `bigen`, `smallar`, `smallen`, `main`, `rate`, `tax_code`) VALUES
(1, 'ريال', 'S.R', 'هلله', 'h', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `account_id` double NOT NULL DEFAULT 0,
  `type_invoice_electronice` varchar(100) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `namear` varchar(255) DEFAULT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `group` int(11) NOT NULL DEFAULT 1,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT '1',
  `VATRegistration` varchar(50) DEFAULT NULL,
  `IdentificationNumber` varchar(50) DEFAULT NULL,
  `delegateId` int(11) DEFAULT NULL,
  `Obalance` varchar(255) DEFAULT NULL,
  `TObalance` tinyint(4) NOT NULL DEFAULT 1,
  `term_maturity` varchar(255) NOT NULL DEFAULT '30',
  `pricing_policy` double DEFAULT NULL,
  `credit_limit` double DEFAULT NULL,
  `is_credit_limit` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `account_id`, `type_invoice_electronice`, `code`, `name`, `namear`, `nameen`, `group`, `address`, `phone`, `VATRegistration`, `IdentificationNumber`, `delegateId`, `Obalance`, `TObalance`, `term_maturity`, `pricing_policy`, `credit_limit`, `is_credit_limit`) VALUES
(1, 101001, '', 201, 'customer', 'customer', 'customer', 1, '', '12345', NULL, NULL, NULL, NULL, 1, '30', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dailyrestrictions`
--

CREATE TABLE `dailyrestrictions` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 1,
  `manual` tinyint(4) NOT NULL DEFAULT 0,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `document` varchar(250) DEFAULT NULL,
  `branshId` int(11) NOT NULL DEFAULT 0,
  `debtor` double NOT NULL DEFAULT 0,
  `creditor` double NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(250) DEFAULT NULL,
  `source` int(11) NOT NULL DEFAULT 0,
  `source_name` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dailyrestrictions`
--

INSERT INTO `dailyrestrictions` (`id`, `num`, `manual`, `fiscal_year`, `document`, `branshId`, `debtor`, `creditor`, `date`, `description`, `source`, `source_name`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '2022', '', 1, 100, 100, '2022-05-18 18:42:14', '', 1, 'مبيعات', '2022-05-18 18:42:14', '2022-05-18 18:42:14'),
(2, 1, 0, '2022', '', 1, 100, 100, '2022-05-18 18:42:41', '', 2, 'مبيعات', '2022-05-18 18:42:41', '2022-05-18 18:42:41'),
(3, 1, 0, '2022', '', 1, 3.45, 3.45, '2022-06-05 11:55:09', '', 3, 'مبيعات', '2022-06-05 12:55:09', '2022-06-05 12:55:09'),
(4, 1, 0, '2022', '', 1, 3.45, 3.45, '2022-06-05 11:56:20', '', 4, 'مبيعات', '2022-06-05 09:56:20', '2022-06-05 09:56:20'),
(5, 1, 0, '2022', '', 1, 13.3, 13.3, '2022-06-05 12:48:11', '', 5, 'مبيعات', '2022-06-05 13:48:11', '2022-06-05 13:48:11'),
(6, 1, 0, '2022', '', 1, 10.3, 10.3, '2022-06-05 12:49:02', '', 6, 'مبيعات', '2022-06-05 13:49:02', '2022-06-05 13:49:02'),
(7, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-05 12:49:26', '', 7, 'مبيعات', '2022-06-05 13:49:26', '2022-06-05 13:49:26'),
(8, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-05 13:18:11', '', 8, 'مبيعات', '2022-06-05 14:18:11', '2022-06-05 14:18:11'),
(9, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-05 13:18:23', '', 9, 'مبيعات', '2022-06-05 14:18:23', '2022-06-05 14:18:23'),
(10, 1, 0, '2022', '', 1, 2, 2, '2022-06-05 13:18:44', '', 10, 'مبيعات', '2022-06-05 14:18:44', '2022-06-05 14:18:44'),
(11, 1, 0, '2022', '', 1, 2, 2, '2022-06-05 13:21:10', '', 11, 'مبيعات', '2022-06-05 14:21:10', '2022-06-05 14:21:10'),
(12, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-05 13:21:19', '', 12, 'مبيعات', '2022-06-05 14:21:19', '2022-06-05 14:21:19'),
(13, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-05 13:22:18', '', 13, 'مبيعات', '2022-06-05 14:22:18', '2022-06-05 14:22:18'),
(14, 1, 0, '2022', '', 1, 2.3, 2.3, '2022-06-08 09:25:11', '', 14, 'مبيعات', '2022-06-08 10:25:11', '2022-06-08 10:25:11'),
(15, 1, 0, '2022', '', 1, 2, 2, '2022-06-08 09:27:38', '', 15, 'مبيعات', '2022-06-08 10:27:38', '2022-06-08 10:27:38'),
(16, 1, 0, '2022', '', 1, 6, 6, '2022-06-08 09:28:08', '', 16, 'مبيعات', '2022-06-08 10:28:08', '2022-06-08 10:28:08'),
(17, 1, 0, '2022', '', 1, 2, 2, '2022-06-08 09:35:54', '', 17, 'مبيعات', '2022-06-08 10:35:54', '2022-06-08 10:35:54'),
(18, 1, 0, '2022', '', 1, 2500, 2500, '2022-06-08 13:05:24', '', 1, 'فاتورة مشتريات', '2022-06-08 11:05:24', '2022-06-08 11:05:24'),
(19, 1, 0, '2022', '', 1, 30, 30, '2022-06-08 14:54:08', '', 2, 'فاتورة مشتريات', '2022-06-08 12:54:08', '2022-06-08 12:54:08'),
(20, 1, 0, '2022', '', 1, 2, 2, '2022-06-08 14:54:49', '', 18, 'مبيعات', '2022-06-08 15:54:49', '2022-06-08 15:54:49'),
(21, 1, 0, '2022', '', 1, 3, 3, '2022-06-08 14:57:03', '', 19, 'مبيعات', '2022-06-08 15:57:03', '2022-06-08 15:57:03'),
(22, 1, 0, '2022', '', 1, 3, 3, '2022-06-08 14:57:07', '', 20, 'مبيعات', '2022-06-08 15:57:07', '2022-06-08 15:57:07'),
(23, 1, 0, '2022', '', 1, 2, 2, '2022-06-09 09:59:19', '', 22, 'مبيعات', '2022-06-09 10:59:19', '2022-06-09 10:59:19'),
(24, 1, 0, '2022', '', 1, 3, 3, '2022-06-09 11:30:32', '', 23, 'مبيعات', '2022-06-09 12:30:32', '2022-06-09 12:30:32'),
(25, 1, 0, '2022', '', 1, 4, 4, '2022-06-09 11:35:29', '', 24, 'مبيعات', '2022-06-09 12:35:29', '2022-06-09 12:35:29'),
(26, 1, 0, '2022', '', 1, 22500, 22500, '2022-06-13 12:34:59', '', 3, 'فاتورة مشتريات', '2022-06-13 10:34:59', '2022-06-13 10:34:59'),
(27, 1, 0, '2022', '', 1, 25000, 25000, '2022-07-03 09:52:09', '', 4, 'فاتورة مشتريات', '2022-07-03 07:52:09', '2022-07-03 07:52:09'),
(28, 1, 0, '2022', '', 1, 2, 2, '2022-07-05 14:44:47', '', 25, 'مبيعات', '2022-07-05 17:44:47', '2022-07-05 17:44:47'),
(29, 1, 0, '2022', '', 1, 5000, 5000, '2022-07-06 14:39:35', '', 25, 'مبيعات', '2022-07-06 17:39:35', '2022-07-06 17:39:35'),
(30, 1, 0, '2022', '', 1, 5000, 5000, '2022-07-06 16:04:17', '', 26, 'مبيعات', '2022-07-06 19:04:17', '2022-07-06 19:04:17'),
(31, 1, 0, '2022', '', 1, 5, 5, '2022-07-13 12:16:18', '', 27, 'مبيعات', '2022-07-13 13:16:18', '2022-07-13 13:16:18'),
(32, 1, 0, '2022', '', 1, 5, 5, '2022-07-13 12:36:31', '', 28, 'مبيعات', '2022-07-13 13:36:31', '2022-07-13 13:36:31'),
(33, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 12:42:47', '', 29, 'مبيعات', '2022-07-13 13:42:47', '2022-07-13 13:42:47'),
(34, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 12:44:03', '', 30, 'مبيعات', '2022-07-13 13:44:03', '2022-07-13 13:44:03'),
(35, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 12:44:38', '', 31, 'مبيعات', '2022-07-13 13:44:38', '2022-07-13 13:44:38'),
(36, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 12:57:47', '', 32, 'مبيعات', '2022-07-13 13:57:47', '2022-07-13 13:57:47'),
(37, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 13:02:41', '', 33, 'مبيعات', '2022-07-13 14:02:41', '2022-07-13 14:02:41'),
(38, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 13:05:18', '', 34, 'مبيعات', '2022-07-13 14:05:18', '2022-07-13 14:05:18'),
(39, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 13:07:01', '', 35, 'مبيعات', '2022-07-13 14:07:01', '2022-07-13 14:07:01'),
(40, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 13:07:39', '', 36, 'مبيعات', '2022-07-13 14:07:39', '2022-07-13 14:07:39'),
(41, 1, 0, '2022', '', 1, 2, 2, '2022-07-13 13:08:24', '', 37, 'مبيعات', '2022-07-13 14:08:24', '2022-07-13 14:08:24'),
(42, 1, 0, '2022', '', 1, 4, 4, '2022-07-13 13:16:09', '', 38, 'مبيعات', '2022-07-13 14:16:09', '2022-07-13 14:16:09'),
(43, 1, 0, '2022', '', 1, 4, 4, '2022-07-13 13:21:04', '', 39, 'مبيعات', '2022-07-13 14:21:04', '2022-07-13 14:21:04'),
(44, 1, 0, '2022', '', 1, 4, 4, '2022-07-13 13:24:21', '', 40, 'مبيعات', '2022-07-13 14:24:21', '2022-07-13 14:24:21'),
(45, 1, 0, '2022', '', 1, 4, 4, '2022-07-13 13:26:08', '', 41, 'مبيعات', '2022-07-13 14:26:08', '2022-07-13 14:26:08'),
(46, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 12:30:32', '', 42, 'مبيعات', '2022-07-14 13:30:32', '2022-07-14 13:30:32'),
(47, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 12:31:08', '', 43, 'مبيعات', '2022-07-14 13:31:08', '2022-07-14 13:31:08'),
(48, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 12:31:18', '', 44, 'مبيعات', '2022-07-14 13:31:18', '2022-07-14 13:31:18'),
(49, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 12:37:21', '', 45, 'مبيعات', '2022-07-14 13:37:21', '2022-07-14 13:37:21'),
(50, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 12:37:41', '', 46, 'مبيعات', '2022-07-14 13:37:41', '2022-07-14 13:37:41'),
(51, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 13:34:05', '', 47, 'مبيعات', '2022-07-14 14:34:05', '2022-07-14 14:34:05'),
(52, 1, 0, '2022', '', 1, 4, 4, '2022-07-14 13:34:29', '', 48, 'مبيعات', '2022-07-14 14:34:29', '2022-07-14 14:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `dailyrestrictions_list`
--

CREATE TABLE `dailyrestrictions_list` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL DEFAULT '',
  `account_id` int(11) NOT NULL DEFAULT 0,
  `invoice_id` int(11) NOT NULL DEFAULT 0,
  `debtor` float NOT NULL DEFAULT 0,
  `creditor` float NOT NULL DEFAULT 0,
  `cost_center` int(11) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dailyrestrictions_list`
--

INSERT INTO `dailyrestrictions_list` (`id`, `account_name`, `account_id`, `invoice_id`, `debtor`, `creditor`, `cost_center`, `currency`, `description`) VALUES
(1, 'customer', 101001, 1, 100, 0, NULL, NULL, ''),
(2, 'المبيعات', 25, 1, 0, 100, NULL, NULL, ''),
(3, 'الصندوق', 39, 1, 100, 0, NULL, NULL, ''),
(4, 'customer', 101001, 1, 0, 100, NULL, NULL, ''),
(5, 'customer', 101001, 2, 100, 0, NULL, NULL, ''),
(6, 'المبيعات', 25, 2, 0, 100, NULL, NULL, ''),
(7, 'الصندوق', 39, 2, 100, 0, NULL, NULL, ''),
(8, 'customer', 101001, 2, 0, 100, NULL, NULL, ''),
(9, 'customer', 101001, 3, 3.45, 0, NULL, NULL, ''),
(10, 'المبيعات', 25, 3, 0, 3, NULL, NULL, ''),
(11, 'ضريبة القيمة المضافة', 23, 3, 0, 0.45, NULL, NULL, ''),
(12, 'الصندوق', 39, 3, 3.45, 0, NULL, NULL, ''),
(13, 'customer', 101001, 3, 0, 3.45, NULL, NULL, ''),
(14, 'customer', 101001, 4, 3.45, 0, NULL, NULL, ''),
(15, 'المبيعات', 25, 4, 0, 3, NULL, NULL, ''),
(16, 'ضريبة القيمة المضافة', 23, 4, 0, 0.45, NULL, NULL, ''),
(17, 'الصندوق', 39, 4, 3.45, 0, NULL, NULL, ''),
(18, 'customer', 101001, 4, 0, 3.45, NULL, NULL, ''),
(19, 'customer', 101001, 5, 13.3, 0, NULL, NULL, ''),
(20, 'المبيعات', 25, 5, 0, 11.5652, NULL, NULL, ''),
(21, 'ضريبة القيمة المضافة', 23, 5, 0, 1.73478, NULL, NULL, ''),
(22, 'الصندوق', 39, 5, 13.3, 0, NULL, NULL, ''),
(23, 'customer', 101001, 5, 0, 13.3, NULL, NULL, ''),
(24, 'customer', 101001, 6, 10.3, 0, NULL, NULL, ''),
(25, 'المبيعات', 25, 6, 0, 8.95652, NULL, NULL, ''),
(26, 'ضريبة القيمة المضافة', 23, 6, 0, 1.34348, NULL, NULL, ''),
(27, 'الصندوق', 39, 6, 10.3, 0, NULL, NULL, ''),
(28, 'customer', 101001, 6, 0, 10.3, NULL, NULL, ''),
(29, 'customer', 101001, 7, 2.3, 0, NULL, NULL, ''),
(30, 'المبيعات', 25, 7, 0, 2, NULL, NULL, ''),
(31, 'ضريبة القيمة المضافة', 23, 7, 0, 0.3, NULL, NULL, ''),
(32, 'الصندوق', 39, 7, 2.3, 0, NULL, NULL, ''),
(33, 'customer', 101001, 7, 0, 2.3, NULL, NULL, ''),
(34, 'customer', 101001, 8, 2.3, 0, NULL, NULL, ''),
(35, 'المبيعات', 25, 8, 0, 2, NULL, NULL, ''),
(36, 'ضريبة القيمة المضافة', 23, 8, 0, 0.3, NULL, NULL, ''),
(37, 'الصندوق', 39, 8, 2.3, 0, NULL, NULL, ''),
(38, 'customer', 101001, 8, 0, 2.3, NULL, NULL, ''),
(39, 'customer', 101001, 9, 2.3, 0, NULL, NULL, ''),
(40, 'المبيعات', 25, 9, 0, 2, NULL, NULL, ''),
(41, 'ضريبة القيمة المضافة', 23, 9, 0, 0.3, NULL, NULL, ''),
(42, 'الصندوق', 39, 9, 2.3, 0, NULL, NULL, ''),
(43, 'customer', 101001, 9, 0, 2.3, NULL, NULL, ''),
(44, 'customer', 101001, 10, 2, 0, NULL, NULL, ''),
(45, 'المبيعات', 25, 10, 0, 1.73913, NULL, NULL, ''),
(46, 'ضريبة القيمة المضافة', 23, 10, 0, 0.26087, NULL, NULL, ''),
(47, 'الصندوق', 39, 10, 2, 0, NULL, NULL, ''),
(48, 'customer', 101001, 10, 0, 2, NULL, NULL, ''),
(49, 'customer', 101001, 11, 2, 0, NULL, NULL, ''),
(50, 'المبيعات', 25, 11, 0, 1.73913, NULL, NULL, ''),
(51, 'ضريبة القيمة المضافة', 23, 11, 0, 0.26087, NULL, NULL, ''),
(52, 'الصندوق', 39, 11, 2, 0, NULL, NULL, ''),
(53, 'customer', 101001, 11, 0, 2, NULL, NULL, ''),
(54, 'customer', 101001, 12, 2.3, 0, NULL, NULL, ''),
(55, 'المبيعات', 25, 12, 0, 2, NULL, NULL, ''),
(56, 'ضريبة القيمة المضافة', 23, 12, 0, 0.3, NULL, NULL, ''),
(57, 'الصندوق', 39, 12, 2.3, 0, NULL, NULL, ''),
(58, 'customer', 101001, 12, 0, 2.3, NULL, NULL, ''),
(59, 'customer', 101001, 13, 2.3, 0, NULL, NULL, ''),
(60, 'المبيعات', 25, 13, 0, 2, NULL, NULL, ''),
(61, 'ضريبة القيمة المضافة', 23, 13, 0, 0.3, NULL, NULL, ''),
(62, 'الصندوق', 39, 13, 2.3, 0, NULL, NULL, ''),
(63, 'customer', 101001, 13, 0, 2.3, NULL, NULL, ''),
(64, 'customer', 101001, 14, 2.3, 0, NULL, NULL, ''),
(65, 'المبيعات', 25, 14, 0, 2, NULL, NULL, ''),
(66, 'ضريبة القيمة المضافة', 23, 14, 0, 0.3, NULL, NULL, ''),
(67, 'الصندوق', 39, 14, 2.3, 0, NULL, NULL, ''),
(68, 'customer', 101001, 14, 0, 2.3, NULL, NULL, ''),
(69, 'customer', 101001, 15, 2, 0, NULL, NULL, ''),
(70, 'المبيعات', 25, 15, 0, 1.73913, NULL, NULL, ''),
(71, 'ضريبة القيمة المضافة', 23, 15, 0, 0.26087, NULL, NULL, ''),
(72, 'الصندوق', 39, 15, 2, 0, NULL, NULL, ''),
(73, 'customer', 101001, 15, 0, 2, NULL, NULL, ''),
(74, 'customer', 101001, 16, 6, 0, NULL, NULL, ''),
(75, 'المبيعات', 25, 16, 0, 5.21739, NULL, NULL, ''),
(76, 'ضريبة القيمة المضافة', 23, 16, 0, 0.782609, NULL, NULL, ''),
(77, 'الصندوق', 39, 16, 6, 0, NULL, NULL, ''),
(78, 'customer', 101001, 16, 0, 6, NULL, NULL, ''),
(79, 'customer', 101001, 17, 2, 0, NULL, NULL, ''),
(80, 'المبيعات', 25, 17, 0, 1.73913, NULL, NULL, ''),
(81, 'ضريبة القيمة المضافة', 23, 17, 0, 0.26087, NULL, NULL, ''),
(82, 'الصندوق', 39, 17, 2, 0, NULL, NULL, ''),
(83, 'customer', 101001, 17, 0, 2, NULL, NULL, ''),
(84, 'مخزون المخزن الرئيسى', 12, 18, 2500, 0, NULL, NULL, ''),
(85, 'user', 201001, 18, 0, 2500, NULL, NULL, ''),
(86, 'user', 201001, 18, 2500, 0, NULL, NULL, ''),
(87, 'الصندوق', 39, 18, 0, 2500, NULL, NULL, ''),
(92, 'مخزون المخزن الرئيسى', 12, 19, 30, 0, NULL, NULL, ''),
(93, 'user', 201001, 19, 0, 30, NULL, NULL, ''),
(94, 'user', 201001, 19, 30, 0, NULL, NULL, ''),
(95, 'الصندوق', 39, 19, 0, 30, NULL, NULL, ''),
(96, 'customer', 101001, 20, 2, 0, NULL, NULL, ''),
(97, 'المبيعات', 25, 20, 0, 1.73913, NULL, NULL, ''),
(98, 'ضريبة القيمة المضافة', 23, 20, 0, 0.26087, NULL, NULL, ''),
(99, 'تكلفة مبيعات المخزن الرئيسى', 27, 20, 3, 0, NULL, NULL, ''),
(100, 'مخزون المخزن الرئيسى', 12, 20, 0, 3, NULL, NULL, ''),
(101, 'الصندوق', 39, 20, 2, 0, NULL, NULL, ''),
(102, 'customer', 101001, 20, 0, 2, NULL, NULL, ''),
(103, 'customer', 101001, 21, 3, 0, NULL, NULL, ''),
(104, 'المبيعات', 25, 21, 0, 2.6087, NULL, NULL, ''),
(105, 'ضريبة القيمة المضافة', 23, 21, 0, 0.391304, NULL, NULL, ''),
(106, 'الصندوق', 39, 21, 3, 0, NULL, NULL, ''),
(107, 'customer', 101001, 21, 0, 3, NULL, NULL, ''),
(108, 'customer', 101001, 22, 3, 0, NULL, NULL, ''),
(109, 'المبيعات', 25, 22, 0, 2.6087, NULL, NULL, ''),
(110, 'ضريبة القيمة المضافة', 23, 22, 0, 0.391304, NULL, NULL, ''),
(111, 'الصندوق', 39, 22, 3, 0, NULL, NULL, ''),
(112, 'customer', 101001, 22, 0, 3, NULL, NULL, ''),
(113, 'customer', 101001, 23, 2, 0, NULL, NULL, ''),
(114, 'المبيعات', 25, 23, 0, 1.73913, NULL, NULL, ''),
(115, 'ضريبة القيمة المضافة', 23, 23, 0, 0.26087, NULL, NULL, ''),
(116, 'تكلفة مبيعات المخزن الرئيسى', 27, 23, 3, 0, NULL, NULL, ''),
(117, 'مخزون المخزن الرئيسى', 12, 23, 0, 3, NULL, NULL, ''),
(118, 'الصندوق', 39, 23, 2, 0, NULL, NULL, ''),
(119, 'customer', 101001, 23, 0, 2, NULL, NULL, ''),
(120, 'customer', 101001, 24, 3, 0, NULL, NULL, ''),
(121, 'المبيعات', 25, 24, 0, 2.6087, NULL, NULL, ''),
(122, 'ضريبة القيمة المضافة', 23, 24, 0, 0.391304, NULL, NULL, ''),
(123, 'الصندوق', 39, 24, 3, 0, NULL, NULL, ''),
(124, 'customer', 101001, 24, 0, 3, NULL, NULL, ''),
(125, 'customer', 101001, 25, 4, 0, NULL, NULL, ''),
(126, 'المبيعات', 25, 25, 0, 3.47826, NULL, NULL, ''),
(127, 'ضريبة القيمة المضافة', 23, 25, 0, 0.521739, NULL, NULL, ''),
(128, 'تكلفة مبيعات المخزن الرئيسى', 27, 25, 3, 0, NULL, NULL, ''),
(129, 'مخزون المخزن الرئيسى', 12, 25, 0, 3, NULL, NULL, ''),
(130, 'الصندوق', 39, 25, 4, 0, NULL, NULL, ''),
(131, 'customer', 101001, 25, 0, 4, NULL, NULL, ''),
(132, 'مخزون المخزن الرئيسى', 12, 26, 22500, 0, NULL, NULL, ''),
(133, 'user', 201001, 26, 0, 22500, NULL, NULL, ''),
(134, 'user', 201001, 26, 22500, 0, NULL, NULL, ''),
(135, 'الصندوق', 39, 26, 0, 22500, NULL, NULL, ''),
(136, 'مخزون المخزن الرئيسى', 12, 27, 25000, 0, NULL, NULL, ''),
(137, 'user', 201001, 27, 0, 25000, NULL, NULL, ''),
(138, 'user', 201001, 27, 25000, 0, NULL, NULL, ''),
(139, 'الصندوق', 39, 27, 0, 25000, NULL, NULL, ''),
(140, 'customer', 101001, 28, 2, 0, NULL, NULL, ''),
(141, 'المبيعات', 25, 28, 0, 1.73913, NULL, NULL, ''),
(142, 'ضريبة القيمة المضافة', 23, 28, 0, 0.26087, NULL, NULL, ''),
(143, 'الصندوق', 39, 28, 2, 0, NULL, NULL, ''),
(144, 'customer', 101001, 28, 0, 2, NULL, NULL, ''),
(145, 'customer', 101001, 29, 5000, 0, NULL, NULL, ''),
(146, 'المبيعات', 25, 29, 0, 5000, NULL, NULL, ''),
(147, 'تكلفة مبيعات المخزن الرئيسى', 27, 29, 4875, 0, NULL, NULL, ''),
(148, 'مخزون المخزن الرئيسى', 12, 29, 0, 4875, NULL, NULL, ''),
(149, 'الصندوق', 39, 29, 5000, 0, NULL, NULL, ''),
(150, 'customer', 101001, 29, 0, 5000, NULL, NULL, ''),
(151, 'customer', 101001, 30, 5000, 0, NULL, NULL, ''),
(152, 'المبيعات', 25, 30, 0, 5000, NULL, NULL, ''),
(153, 'تكلفة مبيعات المخزن الرئيسى', 27, 30, 4875, 0, NULL, NULL, ''),
(154, 'مخزون المخزن الرئيسى', 12, 30, 0, 4875, NULL, NULL, ''),
(155, 'الصندوق', 39, 30, 5000, 0, NULL, NULL, ''),
(156, 'customer', 101001, 30, 0, 5000, NULL, NULL, ''),
(157, 'customer', 101001, 31, 5, 0, NULL, NULL, ''),
(158, 'المبيعات', 25, 31, 0, 4.34783, NULL, NULL, ''),
(159, 'ضريبة القيمة المضافة', 23, 31, 0, 0.652174, NULL, NULL, ''),
(160, 'ضريبة تبغ', 56, 31, 5, 0, NULL, NULL, ''),
(161, 'الصندوق', 39, 31, 5, 0, NULL, NULL, ''),
(162, 'customer', 101001, 31, 0, 5, NULL, NULL, ''),
(163, 'customer', 101001, 32, 5, 0, NULL, NULL, ''),
(164, 'المبيعات', 25, 32, 0, 4.34783, NULL, NULL, ''),
(165, 'ضريبة القيمة المضافة', 23, 32, 0, 0.652174, NULL, NULL, ''),
(166, 'ضريبة تبغ', 56, 32, 5, 0, NULL, NULL, ''),
(167, 'الصندوق', 39, 32, 5, 0, NULL, NULL, ''),
(168, 'customer', 101001, 32, 0, 5, NULL, NULL, ''),
(169, 'customer', 101001, 33, 2, 0, NULL, NULL, ''),
(170, 'المبيعات', 25, 33, 0, 1.73913, NULL, NULL, ''),
(171, 'ضريبة القيمة المضافة', 23, 33, 0, 0.26087, NULL, NULL, ''),
(172, 'ضريبة تبغ', 56, 33, 2, 0, NULL, NULL, ''),
(173, 'customer', 101001, 33, 0, 2, NULL, NULL, ''),
(174, 'الصندوق', 39, 33, 2, 0, NULL, NULL, ''),
(175, 'customer', 101001, 33, 0, 2, NULL, NULL, ''),
(176, 'customer', 101001, 34, 2, 0, NULL, NULL, ''),
(177, 'المبيعات', 25, 34, 0, 1.73913, NULL, NULL, ''),
(178, 'ضريبة القيمة المضافة', 23, 34, 0, 0.26087, NULL, NULL, ''),
(179, 'ضريبة تبغ', 56, 34, 2, 0, NULL, NULL, ''),
(180, 'customer', 101001, 34, 0, 2, NULL, NULL, ''),
(181, 'الصندوق', 39, 34, 2, 0, NULL, NULL, ''),
(182, 'customer', 101001, 34, 0, 2, NULL, NULL, ''),
(183, 'customer', 101001, 35, 2, 0, NULL, NULL, ''),
(184, 'المبيعات', 25, 35, 0, 1.73913, NULL, NULL, ''),
(185, 'ضريبة القيمة المضافة', 23, 35, 0, 0.26087, NULL, NULL, ''),
(186, 'ضريبة تبغ', 56, 35, 1.73913, 0, NULL, NULL, ''),
(187, 'customer', 101001, 35, 0, 1.73913, NULL, NULL, ''),
(188, 'الصندوق', 39, 35, 2, 0, NULL, NULL, ''),
(189, 'customer', 101001, 35, 0, 2, NULL, NULL, ''),
(190, 'customer', 101001, 36, 2, 0, NULL, NULL, ''),
(191, 'المبيعات', 25, 36, 0, 1.73913, NULL, NULL, ''),
(192, 'ضريبة القيمة المضافة', 23, 36, 0, 0.26087, NULL, NULL, ''),
(193, 'ضريبة تبغ', 56, 36, 0, 1.73913, NULL, NULL, ''),
(194, 'customer', 101001, 36, 1.73913, 0, NULL, NULL, ''),
(195, 'الصندوق', 39, 36, 2, 0, NULL, NULL, ''),
(196, 'customer', 101001, 36, 0, 2, NULL, NULL, ''),
(197, 'customer', 101001, 37, 2, 0, NULL, NULL, ''),
(198, 'المبيعات', 25, 37, 0, 1.73913, NULL, NULL, ''),
(199, 'ضريبة القيمة المضافة', 23, 37, 0, 0.26087, NULL, NULL, ''),
(200, 'ضريبة تبغ', 56, 37, 0, 1.73913, NULL, NULL, ''),
(201, 'customer', 101001, 37, 3.73913, 0, NULL, NULL, ''),
(202, 'الصندوق', 39, 37, 3.73913, 0, NULL, NULL, ''),
(203, 'customer', 101001, 37, 0, 3.73913, NULL, NULL, ''),
(204, 'customer', 101001, 38, 3.73913, 0, NULL, NULL, ''),
(205, 'المبيعات', 25, 38, 0, 1.73913, NULL, NULL, ''),
(206, 'ضريبة القيمة المضافة', 23, 38, 0, 0.26087, NULL, NULL, ''),
(207, 'ضريبة تبغ', 56, 38, 0, 1.73913, NULL, NULL, ''),
(208, 'الصندوق', 39, 38, 3.73913, 0, NULL, NULL, ''),
(209, 'customer', 101001, 38, 0, 3.73913, NULL, NULL, ''),
(210, 'customer', 101001, 39, 3.73913, 0, NULL, NULL, ''),
(211, 'المبيعات', 25, 39, 0, 1.73913, NULL, NULL, ''),
(212, 'ضريبة القيمة المضافة', 23, 39, 0, 0.0680529, NULL, NULL, ''),
(213, 'ضريبة تبغ', 56, 39, 0, 1.73913, NULL, NULL, ''),
(214, 'الصندوق', 39, 39, 3.73913, 0, NULL, NULL, ''),
(215, 'customer', 101001, 39, 0, 3.73913, NULL, NULL, ''),
(216, 'customer', 101001, 40, 3.73913, 0, NULL, NULL, ''),
(217, 'المبيعات', 25, 40, 0, 1.73913, NULL, NULL, ''),
(218, 'ضريبة القيمة المضافة', 23, 40, 0, 0.521739, NULL, NULL, ''),
(219, 'ضريبة تبغ', 56, 40, 0, 1.73913, NULL, NULL, ''),
(220, 'الصندوق', 39, 40, 3.73913, 0, NULL, NULL, ''),
(221, 'customer', 101001, 40, 0, 3.73913, NULL, NULL, ''),
(222, 'customer', 101001, 41, 4.26087, 0, NULL, NULL, ''),
(223, 'المبيعات', 25, 41, 0, 1.73913, NULL, NULL, ''),
(224, 'ضريبة القيمة المضافة', 23, 41, 0, 0.521739, NULL, NULL, ''),
(225, 'ضريبة تبغ', 56, 41, 0, 1.73913, NULL, NULL, ''),
(226, 'الصندوق', 39, 41, 3.73913, 0, NULL, NULL, ''),
(227, 'customer', 101001, 41, 0, 3.73913, NULL, NULL, ''),
(228, 'customer', 101001, 42, 4, 0, NULL, NULL, ''),
(229, 'المبيعات', 25, 42, 0, 1.73913, NULL, NULL, ''),
(230, 'ضريبة القيمة المضافة', 23, 42, 0, 0.521739, NULL, NULL, ''),
(231, 'ضريبة تبغ', 56, 42, 0, 1.73913, NULL, NULL, ''),
(232, 'الصندوق', 39, 42, 3.73913, 0, NULL, NULL, ''),
(233, 'customer', 101001, 42, 0, 3.73913, NULL, NULL, ''),
(234, 'customer', 101001, 43, 4, 0, NULL, NULL, ''),
(235, 'المبيعات', 25, 43, 0, 1.73913, NULL, NULL, ''),
(236, 'ضريبة القيمة المضافة', 23, 43, 0, 0.52, NULL, NULL, ''),
(237, 'ضريبة تبغ', 56, 43, 0, 1.74, NULL, NULL, ''),
(238, 'الصندوق', 39, 43, 3.73913, 0, NULL, NULL, ''),
(239, 'customer', 101001, 43, 0, 3.73913, NULL, NULL, ''),
(240, 'customer', 101001, 44, 4, 0, NULL, NULL, ''),
(241, 'المبيعات', 25, 44, 0, 1.74, NULL, NULL, ''),
(242, 'ضريبة القيمة المضافة', 23, 44, 0, 0.52, NULL, NULL, ''),
(243, 'ضريبة تبغ', 56, 44, 0, 1.74, NULL, NULL, ''),
(244, 'الصندوق', 39, 44, 3.74, 0, NULL, NULL, ''),
(245, 'customer', 101001, 44, 0, 3.74, NULL, NULL, ''),
(246, 'customer', 101001, 45, 4, 0, NULL, NULL, ''),
(247, 'المبيعات', 25, 45, 0, 1.74, NULL, NULL, ''),
(248, 'ضريبة القيمة المضافة', 23, 45, 0, 0.52, NULL, NULL, ''),
(249, 'ضريبة تبغ', 56, 45, 0, 1.74, NULL, NULL, ''),
(250, 'الصندوق', 39, 45, 4, 0, NULL, NULL, ''),
(251, 'customer', 101001, 45, 0, 4, NULL, NULL, ''),
(252, 'customer', 101001, 46, 4, 0, NULL, NULL, ''),
(253, 'المبيعات', 25, 46, 0, 1.74, NULL, NULL, ''),
(254, 'ضريبة القيمة المضافة', 23, 46, 0, 0.52, NULL, NULL, ''),
(255, 'ضريبة تبغ', 56, 46, 0, 1.74, NULL, NULL, ''),
(256, 'الصندوق', 39, 46, 4, 0, NULL, NULL, ''),
(257, 'customer', 101001, 46, 0, 4, NULL, NULL, ''),
(258, 'customer', 101001, 47, 4, 0, NULL, NULL, ''),
(259, 'المبيعات', 25, 47, 0, 1.74, NULL, NULL, ''),
(260, 'ضريبة القيمة المضافة', 23, 47, 0, 0.52, NULL, NULL, ''),
(261, 'ضريبة تبغ', 56, 47, 0, 1.74, NULL, NULL, ''),
(262, 'الصندوق', 39, 47, 4, 0, NULL, NULL, ''),
(263, 'customer', 101001, 47, 0, 4, NULL, NULL, ''),
(264, 'customer', 101001, 48, 4, 0, NULL, NULL, ''),
(265, 'المبيعات', 25, 48, 0, 1.74, NULL, NULL, ''),
(266, 'ضريبة القيمة المضافة', 23, 48, 0, 0.52, NULL, NULL, ''),
(267, 'ضريبة تبغ', 56, 48, 0, 1.74, NULL, NULL, ''),
(268, 'الصندوق', 39, 48, 4, 0, NULL, NULL, ''),
(269, 'customer', 101001, 48, 0, 4, NULL, NULL, ''),
(270, 'customer', 101001, 49, 4, 0, NULL, NULL, ''),
(271, 'المبيعات', 25, 49, 0, 1.74, NULL, NULL, ''),
(272, 'ضريبة القيمة المضافة', 23, 49, 0, 0.52, NULL, NULL, ''),
(273, 'ضريبة تبغ', 56, 49, 0, 1.74, NULL, NULL, ''),
(274, 'الصندوق', 39, 49, 4, 0, NULL, NULL, ''),
(275, 'customer', 101001, 49, 0, 4, NULL, NULL, ''),
(276, 'customer', 101001, 50, 4, 0, NULL, NULL, ''),
(277, 'المبيعات', 25, 50, 0, 1.74, NULL, NULL, ''),
(278, 'ضريبة القيمة المضافة', 23, 50, 0, 0.52, NULL, NULL, ''),
(279, 'ضريبة تبغ', 56, 50, 0, 1.74, NULL, NULL, ''),
(280, 'الصندوق', 39, 50, 4, 0, NULL, NULL, ''),
(281, 'customer', 101001, 50, 0, 4, NULL, NULL, ''),
(282, 'customer', 101001, 51, 4, 0, NULL, NULL, ''),
(283, 'المبيعات', 25, 51, 0, 1.74, NULL, NULL, ''),
(284, 'ضريبة القيمة المضافة', 23, 51, 0, 0.52, NULL, NULL, ''),
(285, 'ضريبة تبغ', 56, 51, 0, 1.74, NULL, NULL, ''),
(286, 'الصندوق', 39, 51, 4, 0, NULL, NULL, ''),
(287, 'customer', 101001, 51, 0, 4, NULL, NULL, ''),
(288, 'customer', 101001, 52, 4, 0, NULL, NULL, ''),
(289, 'المبيعات', 25, 52, 0, 1.74, NULL, NULL, ''),
(290, 'ضريبة القيمة المضافة', 23, 52, 0, 0.52, NULL, NULL, ''),
(291, 'ضريبة تبغ', 56, 52, 0, 1.74, NULL, NULL, ''),
(292, 'الصندوق', 39, 52, 4, 0, NULL, NULL, ''),
(293, 'customer', 101001, 52, 0, 4, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT 0,
  `namear` varchar(255) NOT NULL DEFAULT '',
  `nameen` varchar(255) NOT NULL DEFAULT '',
  `occupation` varchar(100) NOT NULL DEFAULT '',
  `branchId` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `status_type` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fiscal_years`
--

CREATE TABLE `fiscal_years` (
  `id` int(11) NOT NULL,
  `code` float NOT NULL DEFAULT 0,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `notes` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fiscal_years`
--

INSERT INTO `fiscal_years` (`id`, `code`, `start`, `end`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2022, '2022-01-01', '2022-12-31', '1', '', '2022-02-13 13:25:01', '2022-02-13 13:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `holdinvoices`
--

CREATE TABLE `holdinvoices` (
  `id` int(11) NOT NULL,
  `itemId` int(11) DEFAULT NULL,
  `catId` int(11) DEFAULT NULL,
  `quantityM` varchar(100) DEFAULT '0',
  `namear` varchar(255) DEFAULT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `nature` varchar(100) DEFAULT NULL,
  `groupItem` varchar(100) DEFAULT NULL,
  `priceWithTax` double DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `customerId` int(11) DEFAULT NULL,
  `netTotal` double DEFAULT NULL,
  `invoiceId` int(11) DEFAULT NULL,
  `qtn` float DEFAULT NULL,
  `taxRate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `tobacco_tax` float DEFAULT NULL,
  `dateInvoice` timestamp NULL DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `cost_center` int(11) DEFAULT NULL,
  `branchId` int(100) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `tab` int(11) DEFAULT NULL,
  `deleiver` float NOT NULL DEFAULT 0,
  `status_type` int(11) DEFAULT NULL,
  `netTotal` float NOT NULL DEFAULT 0,
  `shiftNum` int(11) NOT NULL DEFAULT 0,
  `customerId` int(11) NOT NULL DEFAULT 0,
  `delegateId` int(11) DEFAULT NULL,
  `cash` float NOT NULL DEFAULT 0,
  `visa` float NOT NULL DEFAULT 0,
  `masterCard` float NOT NULL DEFAULT 0,
  `credit` float NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `fiscal_year`, `taxSource`, `tobacco_tax`, `dateInvoice`, `duedate`, `cost_center`, `branchId`, `storeId`, `status`, `tab`, `deleiver`, `status_type`, `netTotal`, `shiftNum`, `customerId`, `delegateId`, `cash`, `visa`, `masterCard`, `credit`, `updated_at`, `created_at`) VALUES
(1, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 100, 1, 1, NULL, 0, 0, 0, 0, '2022-06-09 09:38:03', '2022-06-09 09:38:03'),
(2, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 100, 1, 1, NULL, 0, 0, 0, 0, '2022-05-18 18:42:41', '2022-05-18 18:42:41'),
(3, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 3.45, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 12:55:09', '2022-06-05 12:55:09'),
(4, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 3.45, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 09:56:20', '2022-06-05 09:56:20'),
(5, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 13.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 13:48:11', '2022-06-05 13:48:11'),
(6, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 10.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 13:49:02', '2022-06-05 13:49:02'),
(7, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 13:49:26', '2022-06-05 13:49:26'),
(8, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:18:11', '2022-06-05 14:18:11'),
(9, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:18:23', '2022-06-05 14:18:23'),
(10, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:18:44', '2022-06-05 14:18:44'),
(11, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:21:10', '2022-06-05 14:21:10'),
(12, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:21:19', '2022-06-05 14:21:19'),
(13, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 1, 1, NULL, 0, 0, 0, 0, '2022-06-05 14:22:18', '2022-06-05 14:22:18'),
(14, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2.3, 2, 1, NULL, 0, 0, 0, 0, '2022-06-08 10:25:11', '2022-06-08 10:25:11'),
(15, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2, 4, 1, NULL, 0, 0, 0, 0, '2022-06-08 10:27:38', '2022-06-08 10:27:38'),
(16, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 6, 4, 1, NULL, 0, 0, 0, 0, '2022-06-08 10:28:08', '2022-06-08 10:28:08'),
(17, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-06-08 10:35:54', '2022-06-08 10:35:54'),
(18, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-06-08 15:54:49', '2022-06-08 15:54:49'),
(19, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 3, 6, 1, NULL, 0, 0, 0, 0, '2022-06-08 15:57:03', '2022-06-08 15:57:03'),
(20, '2022', 0, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 0, NULL, 3, 6, 1, NULL, 0, 0, 0, 0, '2022-06-08 15:57:07', '2022-06-08 15:57:07'),
(21, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-06-09 10:56:56', '2022-06-09 10:56:56'),
(22, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-06-09 10:59:19', '2022-06-09 10:59:19'),
(23, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 3, 6, 1, NULL, 0, 0, 0, 0, '2022-06-09 12:30:32', '2022-06-09 12:30:32'),
(24, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-06-09 12:35:29', '2022-06-09 12:35:29'),
(25, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 5000, 6, 1, NULL, 0, 0, 0, 0, '2022-07-06 17:39:35', '2022-07-06 17:39:35'),
(26, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 5000, 6, 1, NULL, 0, 0, 0, 0, '2022-07-06 19:04:17', '2022-07-06 19:04:17'),
(27, '2022', 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 5, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:16:18', '2022-07-13 13:16:18'),
(28, '2022', 0, 4.35, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 5, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:36:31', '2022-07-13 12:36:31'),
(29, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:42:47', '2022-07-13 12:42:47'),
(30, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:44:03', '2022-07-13 12:44:03'),
(31, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:44:38', '2022-07-13 12:44:38'),
(32, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 13:57:47', '2022-07-13 12:57:47'),
(33, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:02:41', '2022-07-13 13:02:41'),
(34, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:05:18', '2022-07-13 13:05:18'),
(35, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:07:01', '2022-07-13 13:07:01'),
(36, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:07:39', '2022-07-13 13:07:39'),
(37, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 2, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:08:24', '2022-07-13 13:08:24'),
(38, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:16:09', '2022-07-13 13:16:09'),
(39, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:21:04', '2022-07-13 13:21:04'),
(40, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:24:21', '2022-07-13 13:24:21'),
(41, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-13 14:26:08', '2022-07-13 13:26:08'),
(42, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 13:30:32', '2022-07-14 12:30:32'),
(43, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 13:31:08', '2022-07-14 12:31:08'),
(44, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, NULL, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 13:31:18', '2022-07-14 12:31:18'),
(45, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, 5, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 13:37:21', '2022-07-14 12:37:21'),
(46, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, 1, 0, 7, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 13:37:41', '2022-07-14 12:37:41'),
(47, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, 5, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 14:34:05', '2022-07-14 13:34:05'),
(48, '2022', 0, 1.74, NULL, NULL, NULL, 1, 1, 1, NULL, 0, 5, 4, 6, 1, NULL, 0, 0, 0, 0, '2022-07-14 14:34:29', '2022-07-14 13:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `invoices_list`
--

CREATE TABLE `invoices_list` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `invoiceId` int(11) DEFAULT NULL,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(255) NOT NULL DEFAULT '',
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices_list`
--

INSERT INTO `invoices_list` (`id`, `status`, `invoiceId`, `storeId`, `unit_id`, `item_id`, `item_name`, `qtn`, `price`, `discountRate`, `discountValue`, `rate`, `value`, `customer_id`, `total`, `nettotal`, `description`) VALUES
(1, 1, 1, 1, 1, 1, 'صنف عام', 1, 100, 0, 0, 0, 0, 1, 100, 100, NULL),
(2, 1, 2, 1, 1, 1, 'صنف عام', 1, 100, 0, 0, 0, 0, 1, 100, 100, NULL),
(3, 1, 3, 1, 13, 193, 'عصير', 1, 3, 0, 0, 15, 0.45, 1, 3, 3, NULL),
(4, 1, 4, 1, 13, 193, 'عصير', 1, 3, 0, 0, 15, 0.45, 1, 3, 3, NULL),
(5, 1, 5, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(6, 1, 5, 1, 3, 195, 'فانتا', 1, 6.08696, 0, 0, 15, 0.913043, 1, 6.08696, 6.08696, NULL),
(7, 1, 5, 1, 15, 202, 'كوكاكولا', 1, 3.47826, 0, 0, 15, 0.521739, 1, 3.47826, 3.47826, NULL),
(8, 1, 6, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(9, 1, 6, 1, 1, 195, 'فانتا', 1, 5.21739, 0, 0, 15, 0.782609, 1, 5.21739, 5.21739, NULL),
(10, 1, 6, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 1.73913, 1.73913, NULL),
(11, 1, 7, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(12, 1, 8, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(13, 1, 9, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(14, 1, 10, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 1.73913, 1.73913, NULL),
(15, 1, 11, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(16, 1, 12, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2, 2.3, NULL),
(17, 1, 13, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2.3, 2.3, NULL),
(18, 1, 14, 1, 13, 193, 'عصير', 1, 2, 0, 0, 15, 0.3, 1, 2.3, 2.3, NULL),
(19, 1, 15, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(20, 1, 16, 1, 1, 195, 'فانتا', 1, 5.21739, 0, 0, 15, 0.782609, 1, 6, 6, NULL),
(21, 1, 17, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(22, 1, 18, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(23, 1, 19, 1, 1, 190, 'مياه معدنية', 1, 2.6087, 0, 0, 15, 0.391304, 1, 3, 3, NULL),
(24, 1, 20, 1, 1, 190, 'مياه معدنية', 1, 2.6087, 0, 0, 15, 0.391304, 1, 3, 3, NULL),
(25, 1, 21, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(26, 1, 22, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(27, 1, 23, 1, 1, 190, 'مياه معدنية', 1, 2.6087, 0, 0, 15, 0.391304, 1, 3, 3, NULL),
(28, 1, 24, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(29, 1, 24, 1, 13, 190, 'مياه معدنية', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(39, 1, 25, 1, 45, 242, 'لاب توب لينوفو', 1, 5000, 0, 0, 0, 0, 1, 5000, 5000, NULL),
(40, 1, 26, 1, 45, 242, 'لاب توب لينوفو', 1, 5000, 0, 0, 0, 0, 1, 5000, 5000, NULL),
(41, 1, 27, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(42, 1, 27, 1, 1, 190, 'مياه معدنية', 1, 2.6087, 0, 0, 15, 0.391304, 1, 3, 3, NULL),
(43, 1, 28, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(44, 1, 28, 1, 1, 190, 'مياه معدنية', 1, 2.6087, 0, 0, 15, 0.391304, 1, 3, 3, NULL),
(45, 1, 29, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(46, 1, 30, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(47, 1, 31, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(48, 1, 32, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(49, 1, 33, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(50, 1, 34, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(51, 1, 35, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(52, 1, 36, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(53, 1, 37, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(54, 1, 38, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(55, 1, 39, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(56, 1, 40, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(57, 1, 41, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(58, 1, 42, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(59, 1, 43, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(60, 1, 44, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(61, 1, 45, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(62, 1, 46, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(63, 1, 47, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL),
(64, 1, 48, 1, 13, 193, 'عصير', 1, 1.73913, 0, 0, 15, 0.26087, 1, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `namear` longtext NOT NULL,
  `nameen` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `delegateC` float DEFAULT NULL,
  `coding_type` varchar(100) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `catId` varchar(255) NOT NULL DEFAULT '1',
  `item_type` tinyint(4) NOT NULL DEFAULT 0,
  `taxRate` int(11) DEFAULT 0,
  `quantityM` varchar(255) DEFAULT NULL,
  `nature` varchar(100) DEFAULT NULL,
  `group` varchar(255) NOT NULL,
  `priceWithTax` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `namear`, `nameen`, `code`, `delegateC`, `coding_type`, `img`, `catId`, `item_type`, `taxRate`, `quantityM`, `nature`, `group`, `priceWithTax`, `description`, `active`) VALUES
(1, 'صوص', 'Sauce', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(2, 'مارجريتا', 'Margarita', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(190, 'مياه معدنية', 'Water', '', NULL, '', NULL, '2', 1, 15, NULL, NULL, '2', 1, '', 1),
(191, 'هلابينو', 'Halabino', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(192, 'ديناميت شريمب', 'Dynamite Shrimp', '', NULL, '', NULL, '6', 3, 15, NULL, NULL, '6', 1, '', 1),
(193, 'عصير', 'juice', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(194, 'خدمة توصيل', 'Delivery', '', NULL, '', NULL, '7', 3, 15, NULL, NULL, '7', 1, '', 1),
(195, 'فانتا', 'fanta', '', NULL, '', NULL, '2', 3, 15, NULL, NULL, '2', 1, '', 1),
(196, 'بيتزا دجاج', 'Chicken Pizza', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(197, 'سوبريم', 'Suprem', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(198, 'اضافة باستا', 'pasta add', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(199, 'اسباغتي', 'Spaghetti', '', NULL, '', NULL, '1', 1, 15, NULL, NULL, '1', 1, '', 1),
(200, 'نقانق', 'Sausage', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(201, 'فاهيتا', 'Fahita', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(202, 'كوكاكولا', 'Coca Cola', '', NULL, '', NULL, '2', 3, 15, NULL, NULL, '2', 1, '', 1),
(203, 'سيزر سلطة', 'Caesar salad', '', NULL, '', NULL, '4', 3, 15, NULL, NULL, '4', 1, '', 1),
(204, 'بطاطس ودجز', 'Potatoes wedges', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(205, 'سلطة يونانيه', 'Greek salad', '', NULL, '', NULL, '4', 3, 15, NULL, NULL, '4', 1, '', 1),
(206, 'بيبروني', 'Piperone', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(207, 'خدمة توصيل.', 'Delivery', '', NULL, '', NULL, '7', 3, 15, NULL, NULL, '7', 1, '', 1),
(208, 'اسبرايت', 'spreit', '', NULL, '', NULL, '2', 3, 15, NULL, NULL, '2', 1, '', 1),
(209, 'لحم', 'Meat', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(210, 'باستا قصدير', 'pasta staoin', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(211, 'بيتزا صوص ابيض', 'Pizza White Sauce', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(212, 'وجبة باستا', 'pasta meal', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(213, 'وجبة أطفال', 'Children Meal', '', NULL, '', NULL, '8', 3, 15, NULL, NULL, '8', 1, '', 1),
(216, 'كومبو', 'Combo', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(217, 'ديناميت بيتزا', 'Dynamite Pizza', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(218, 'ماهيتو', 'mahito', '', NULL, '', NULL, '2', 3, 15, NULL, NULL, '2', 1, '', 1),
(219, 'بيتزا رانش', 'Pizza Ranch', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(220, 'دجاج', 'chicken', '', NULL, '', NULL, '5', 1, 15, NULL, NULL, '5', 1, '', 1),
(221, 'فيتوتشني', 'fettuccine', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(222, 'ماك اند تشيز', 'Mac&cheese', '', NULL, '', NULL, '9', 3, 15, NULL, NULL, '9', 1, '', 1),
(223, 'خبز', 'bread', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(224, 'بيتزا خضار', 'Vegetables pizza', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(225, 'كمبو', 'Kembo', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(226, 'خدمة توصيل	..', 'Delivery', '', NULL, '', NULL, '7', 3, 15, NULL, NULL, '7', 1, '', 1),
(227, 'لازانيا', 'lazagne', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(228, 'جبن', 'cheese', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(229, 'خضار.', 'Vegetables add', '', NULL, '', NULL, '1', 1, 15, NULL, NULL, '1', 1, '', 1),
(231, 'اضافة روبيان', 'Shrimp add', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(232, 'بيتزا باربيكيو', 'Pizza BBQ', '', NULL, '', NULL, '3', 3, 15, NULL, NULL, '3', 1, '', 1),
(233, 'ديت كولا', 'dait kola', '', NULL, '', NULL, '2', 3, 15, NULL, NULL, '2', 1, '', 1),
(234, 'باستا', 'Pasta', '', NULL, '', NULL, '1', 3, 15, NULL, NULL, '1', 1, '', 1),
(235, 'كمبو فتشوني', 'Combo Fucini', '', NULL, '', NULL, '5', 3, 15, NULL, NULL, '5', 1, '', 1),
(236, 'رسوم توصيل', 'Delivery', '', NULL, '', NULL, '7', 3, 15, NULL, NULL, '7', 1, '', 1),
(239, 'بدون', 'no', '', NULL, '', NULL, '1', 3, 0, NULL, NULL, '1', NULL, '', 1),
(240, 'صوص .', 'souse .', '', NULL, '', NULL, '1', 3, 0, NULL, NULL, '1', NULL, '', 1),
(241, 'صنف تجريبي', 'صنف تجريبي', '', NULL, '', NULL, '8', 1, 0, NULL, NULL, '8', NULL, '', 1),
(242, 'لاب توب لينوفو', 'laptop lenovo', '', NULL, '', NULL, '26', 1, 0, NULL, NULL, '26', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemslist`
--

CREATE TABLE `itemslist` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` varchar(11) NOT NULL DEFAULT '',
  `packing` float NOT NULL DEFAULT 0,
  `barcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `av_price` float NOT NULL DEFAULT 0,
  `price1` float DEFAULT 0,
  `price2` float DEFAULT NULL,
  `price3` float DEFAULT NULL,
  `price4` float DEFAULT NULL,
  `price5` float DEFAULT NULL,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `small_unit` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `itemslist`
--

INSERT INTO `itemslist` (`id`, `itemId`, `unitId`, `packing`, `barcode`, `av_price`, `price1`, `price2`, `price3`, `price4`, `price5`, `discountRate`, `discountValue`, `total`, `small_unit`) VALUES
(2, 190, '13', 1, '', 3, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(3, 211, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(4, 199, '4', 0, '', 0, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(5, 199, '5', 1, '', 0, 26, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(6, 199, '6', 1, '', 0, 26, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(7, 199, '7', 1, '', 0, 22, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(8, 199, '17', 0, '', 0, 19, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(9, 234, '4', 1, '', 0, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(10, 234, '5', 1, '', 0, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(11, 234, '6', 1, '', 0, 26, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(12, 234, '7', 1, '', 0, 24, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(13, 212, '13', 1, '', 0, 19, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(14, 216, '13', 1, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(15, 221, '4', 1, '', 0, 34, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(16, 221, '5', 1, '', 0, 32, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(17, 221, '6', 1, '', 0, 32, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(18, 221, '7', 1, '', 0, 30, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(19, 221, '8', 1, '', 0, 26, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(20, 221, '9', 1, '', 0, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(21, 221, '17', 1, '', 0, 24, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(22, 227, '6', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(23, 227, '5', 1, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(24, 239, '39', 1, '0', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1),
(25, 240, '22', 1, '0', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1),
(26, 210, '5', 0, '', 0, 34, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(27, 210, '6', 1, '', 0, 34, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(28, 210, '4', 0, '', 0, 38, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(29, 210, '17', 1, '', 0, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(30, 240, '23', 0, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(31, 240, '24', 1, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(32, 239, '40', 0, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(33, 239, '41', 0, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(34, 239, '42', 0, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(35, 239, '43', 1, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(36, 239, '44', 1, '', 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(37, 193, '13', 1, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(38, 195, '1', 0, '', 0, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(39, 195, '3', 0, '', 0, 7, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(40, 195, '15', 1, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(41, 202, '1', 0, '', 0, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(42, 202, '3', 0, '', 0, 7, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(43, 202, '15', 1, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(44, 208, '1', 1, '', 0, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(45, 208, '3', 0, '', 0, 7, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(46, 208, '15', 1, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(47, 218, '18', 0, '', 0, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(48, 218, '20', 0, '', 0, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(49, 218, '21', 0, '', 0, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(50, 233, '1', 0, '', 0, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(51, 233, '3', 0, '', 0, 7, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(52, 233, '15', 0, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(53, 196, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(54, 196, '3', 1, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(55, 197, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(56, 197, '3', 1, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(57, 201, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(58, 201, '3', 0, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(59, 204, '2', 0, '', 0, 10, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(60, 204, '3', 0, '', 0, 16, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(61, 206, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(62, 206, '3', 0, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(63, 211, '3', 0, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(64, 2, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(65, 2, '3', 0, '', 0, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(66, 192, '2', 0, '', 0, 30, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(67, 192, '3', 0, '', 0, 38, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(68, 217, '2', 0, '', 0, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(69, 217, '3', 0, '', 0, 38, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(70, 219, '2', 0, '', 0, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(71, 219, '3', 0, '', 0, 38, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(72, 224, '2', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(73, 232, '2', 0, '', 0, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(74, 232, '3', 0, '', 0, 38, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(75, 203, '5', 0, '', 0, 24, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(76, 205, '2', 0, '', 0, 12, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(77, 191, '13', 0, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(78, 198, '13', 0, '', 0, 5, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(79, 200, '13', 0, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(80, 209, '13', 0, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(81, 1, '10', 0, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(82, 1, '11', 0, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(83, 1, '12', 0, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(84, 1, '14', 0, '', 0, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(85, 220, '13', 0, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(86, 223, '13', 0, '', 0, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(87, 225, '5', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(88, 225, '6', 0, '', 0, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(89, 225, '4', 0, '', 0, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(90, 225, '7', 0, '', 0, 23, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(91, 231, '13', 0, '', 0, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(92, 235, '5', 0, '', 0, 31, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(93, 235, '6', 0, '', 0, 31, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(94, 235, '4', 0, '', 0, 33, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(95, 235, '7', 0, '', 0, 29, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(96, 194, '13', 0, '', 0, 5, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(97, 207, '13', 0, '', 0, 10, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(98, 226, '13', 0, '', 0, 15, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(99, 236, '13', 0, '', 0, 20, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(100, 213, '13', 0, '', 0, 18, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(101, 222, '13', 0, '', 0, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(102, 228, '13', 0, '', 0, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(103, 228, '16', 0, '', 0, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(104, 228, '15', 0, '', 0, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(105, 229, '13', 0, '', 0, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(106, 241, '2', 1, '', 43.3333, 50, NULL, NULL, NULL, NULL, 0, 0, 0, 1),
(107, 190, '1', 1, '', 0, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(108, 242, '45', 1, '', 4875, 5000, NULL, NULL, NULL, NULL, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items_assembly`
--

CREATE TABLE `items_assembly` (
  `id` int(11) NOT NULL,
  `storeId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `cost` float NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `startDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `endDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items_assembly_list`
--

CREATE TABLE `items_assembly_list` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `assembly_id` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  `qtn` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items_collection`
--

CREATE TABLE `items_collection` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `startDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `endDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `items_collection_list`
--

CREATE TABLE `items_collection_list` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  `qtn` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `numorders`
--

CREATE TABLE `numorders` (
  `id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `numorders`
--

INSERT INTO `numorders` (`id`, `num`) VALUES
(1, 41);

-- --------------------------------------------------------

--
-- Table structure for table `offer_price`
--

CREATE TABLE `offer_price` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `discount_added` float NOT NULL DEFAULT 0,
  `date_follow` timestamp NOT NULL DEFAULT current_timestamp(),
  `cost_center` int(11) DEFAULT NULL,
  `branchId` int(100) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `netTotal` float NOT NULL DEFAULT 0,
  `shiftNum` int(11) NOT NULL DEFAULT 0,
  `customerId` int(11) NOT NULL DEFAULT 0,
  `cash` float NOT NULL DEFAULT 0,
  `visa` float NOT NULL DEFAULT 0,
  `masterCard` float NOT NULL DEFAULT 0,
  `credit` float NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offer_price_list`
--

CREATE TABLE `offer_price_list` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `invoiceId` int(11) DEFAULT NULL,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(255) NOT NULL DEFAULT '',
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance`
--

CREATE TABLE `opening_balance` (
  `id` int(11) NOT NULL,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opening_balance`
--

INSERT INTO `opening_balance` (`id`, `storeId`, `date`) VALUES
(8, 1, '2022-06-13 12:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance_accounts`
--

CREATE TABLE `opening_balance_accounts` (
  `id` int(11) NOT NULL,
  `branchId` int(11) NOT NULL DEFAULT 0,
  `debtor` double NOT NULL DEFAULT 0,
  `creditor` double NOT NULL DEFAULT 0,
  `source` varchar(250) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance_accounts_list`
--

CREATE TABLE `opening_balance_accounts_list` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL DEFAULT '',
  `account_id` int(11) NOT NULL DEFAULT 0,
  `invoice_id` int(11) NOT NULL DEFAULT 0,
  `debtor` double NOT NULL DEFAULT 0,
  `creditor` double NOT NULL DEFAULT 0,
  `description` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance_list`
--

CREATE TABLE `opening_balance_list` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `opening_balance_list`
--

INSERT INTO `opening_balance_list` (`id`, `invoice_id`, `itemId`, `unitId`, `qtn`, `price`, `discountRate`, `discountValue`, `total`, `value`, `rate`, `nettotal`) VALUES
(8, 8, 242, 45, 10, 5000, 0, 0, 50000, 0, 0, 50000);

-- --------------------------------------------------------

--
-- Table structure for table `orders_pages`
--

CREATE TABLE `orders_pages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `power_id` int(11) DEFAULT NULL,
  `power_name` varchar(50) DEFAULT NULL,
  `show` tinyint(4) NOT NULL DEFAULT 0,
  `add` tinyint(4) NOT NULL DEFAULT 0,
  `edit` tinyint(4) NOT NULL DEFAULT 0,
  `delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_pages`
--

INSERT INTO `orders_pages` (`id`, `user_id`, `power_id`, `power_name`, `show`, `add`, `edit`, `delete`) VALUES
(1, 0, NULL, 'TsSystem', 1, 1, 1, 1),
(2, 0, NULL, 'TsStores', 1, 1, 1, 1),
(3, 0, NULL, 'TsSales', 1, 1, 1, 1),
(4, 0, NULL, 'TsPurchases', 1, 1, 1, 1),
(5, 0, NULL, 'TsAccounts', 1, 1, 1, 1),
(6, 0, NULL, 'TsBonds', 1, 1, 1, 1),
(7, 0, NULL, 'TsPointOfSales', 1, 1, 1, 1),
(8, 0, NULL, 'TsSettings', 1, 1, 1, 1),
(9, 0, NULL, 'TsPos', 1, 1, 1, 1),
(10, 0, NULL, 'TsBackup', 1, 1, 1, 1),
(11, 0, NULL, 'TsPrintSetting', 1, 1, 1, 1),
(12, 0, NULL, 'TsCompany', 1, 1, 1, 1),
(13, 0, NULL, 'TsBranchs', 1, 1, 1, 1),
(14, 0, NULL, 'TsFiscalYears', 1, 1, 1, 1),
(15, 0, NULL, 'TsCurrencies', 1, 1, 1, 1),
(16, 0, NULL, 'TsUsers', 1, 1, 1, 1),
(17, 0, NULL, 'TsEmployees', 1, 1, 1, 1),
(18, 0, NULL, 'TsCustomers', 1, 1, 1, 1),
(19, 0, NULL, 'TsSuppliers', 1, 1, 1, 1),
(20, 0, NULL, 'TsCategoryCard', 1, 1, 1, 1),
(21, 0, NULL, 'TsItems', 1, 1, 1, 1),
(22, 0, NULL, 'TsUnits', 1, 1, 1, 1),
(23, 0, NULL, 'TsGroupItems', 1, 1, 1, 1),
(24, 0, NULL, 'TsStoresOpeningBalance', 1, 1, 1, 1),
(25, 0, NULL, 'TsDefinitionStores', 1, 1, 1, 1),
(26, 0, NULL, 'TsOrderAdd', 1, 1, 1, 1),
(27, 0, NULL, 'TsOrderCashing', 1, 1, 1, 1),
(28, 0, NULL, 'TsInvoiceSales', 1, 1, 1, 1),
(29, 0, NULL, 'TsPriceOfferSalles', 1, 1, 1, 1),
(30, 0, NULL, 'TsInvoiceReports', 1, 1, 1, 1),
(31, 0, NULL, 'TsReturnedSales', 1, 1, 1, 1),
(32, 0, NULL, 'TsReportsItemsSals', 1, 1, 1, 1),
(33, 0, NULL, 'TsInvoicePurchases', 1, 1, 1, 1),
(34, 0, NULL, 'TsPurchasesReports', 1, 1, 1, 1),
(35, 0, NULL, 'TsReturnedPurchases', 1, 1, 1, 1),
(36, 0, NULL, 'TsReportsItemsPurchases', 1, 1, 1, 1),
(37, 0, NULL, 'TsAccountsGuide', 1, 1, 1, 1),
(38, 0, NULL, 'TsCostCenters', 1, 1, 1, 1),
(39, 0, NULL, 'TsRestrictions', 1, 1, 1, 1),
(40, 0, NULL, 'TsAccountStatement', 1, 1, 1, 1),
(41, 0, NULL, 'TsOpeningAccounts', 1, 1, 1, 1),
(42, 0, NULL, 'TsBudgetReport', 1, 1, 1, 1),
(43, 0, NULL, 'TsCostCenterReport', 1, 1, 1, 1),
(44, 0, NULL, 'TsCashReceipt', 1, 1, 1, 1),
(45, 0, NULL, 'TsCashExChange', 1, 1, 1, 1),
(46, 0, NULL, 'TsBankReceipt', 1, 1, 1, 1),
(47, 0, NULL, 'TsBankExChange', 1, 1, 1, 1),
(48, 0, NULL, 'TsTablesResturant', 1, 1, 1, 1),
(49, 0, NULL, 'TsShiftReport', 1, 1, 1, 1),
(50, 0, NULL, 'TsCollectionOfItems', 1, 1, 1, 1),
(51, 0, NULL, 'TsTransfersStores', 1, 1, 1, 1),
(52, 0, NULL, 'TsItemsBalances', 1, 1, 1, 1),
(53, 0, NULL, 'TsStoreEvaluation', 1, 1, 1, 1),
(54, 1, NULL, 'TsSystem', 0, 0, 0, 0),
(55, 1, NULL, 'TsStores', 0, 0, 0, 0),
(56, 1, NULL, 'TsSales', 0, 0, 0, 0),
(57, 1, NULL, 'TsPurchases', 0, 0, 0, 0),
(58, 1, NULL, 'TsAccounts', 0, 0, 0, 0),
(59, 1, NULL, 'TsBonds', 0, 0, 0, 0),
(60, 1, NULL, 'TsPointOfSales', 0, 0, 0, 0),
(61, 1, NULL, 'TsSettings', 0, 0, 0, 0),
(62, 1, NULL, 'TsPos', 0, 0, 0, 0),
(63, 1, NULL, 'TsBackup', 0, 0, 0, 0),
(64, 1, NULL, 'TsPrintSetting', 0, 0, 0, 0),
(65, 1, NULL, 'TsCompany', 0, 0, 0, 0),
(66, 1, NULL, 'TsBranchs', 0, 0, 0, 0),
(67, 1, NULL, 'TsFiscalYears', 0, 0, 0, 0),
(68, 1, NULL, 'TsCurrencies', 0, 0, 0, 0),
(69, 1, NULL, 'TsUsers', 0, 0, 0, 0),
(70, 1, NULL, 'TsEmployees', 0, 0, 0, 0),
(71, 1, NULL, 'TsCustomers', 0, 0, 0, 0),
(72, 1, NULL, 'TsSuppliers', 0, 0, 0, 0),
(73, 1, NULL, 'TsCategoryCard', 0, 0, 0, 0),
(74, 1, NULL, 'TsItems', 0, 0, 0, 0),
(75, 1, NULL, 'TsUnits', 0, 0, 0, 0),
(76, 1, NULL, 'TsGroupItems', 0, 0, 0, 0),
(77, 1, NULL, 'TsStoresOpeningBalance', 0, 0, 0, 0),
(78, 1, NULL, 'TsDefinitionStores', 0, 0, 0, 0),
(79, 1, NULL, 'TsOrderAdd', 0, 0, 0, 0),
(80, 1, NULL, 'TsOrderCashing', 0, 0, 0, 0),
(81, 1, NULL, 'TsInvoiceSales', 0, 0, 0, 0),
(82, 1, NULL, 'TsPriceOfferSalles', 0, 0, 0, 0),
(83, 1, NULL, 'TsInvoiceReports', 0, 0, 0, 0),
(84, 1, NULL, 'TsReturnedSales', 0, 0, 0, 0),
(85, 1, NULL, 'TsReportsItemsSals', 0, 0, 0, 0),
(86, 1, NULL, 'TsInvoicePurchases', 0, 0, 0, 0),
(87, 1, NULL, 'TsPurchasesReports', 0, 0, 0, 0),
(88, 1, NULL, 'TsReturnedPurchases', 0, 0, 0, 0),
(89, 1, NULL, 'TsReportsItemsPurchases', 0, 0, 0, 0),
(90, 1, NULL, 'TsAccountsGuide', 0, 0, 0, 0),
(91, 1, NULL, 'TsCostCenters', 0, 0, 0, 0),
(92, 1, NULL, 'TsRestrictions', 0, 0, 0, 0),
(93, 1, NULL, 'TsAccountStatement', 0, 0, 0, 0),
(94, 1, NULL, 'TsOpeningAccounts', 0, 0, 0, 0),
(95, 1, NULL, 'TsBudgetReport', 0, 0, 0, 0),
(96, 1, NULL, 'TsCostCenterReport', 0, 0, 0, 0),
(97, 1, NULL, 'TsCashReceipt', 0, 0, 0, 0),
(98, 1, NULL, 'TsCashExChange', 0, 0, 0, 0),
(99, 1, NULL, 'TsBankReceipt', 0, 0, 0, 0),
(100, 1, NULL, 'TsBankExChange', 0, 0, 0, 0),
(101, 1, NULL, 'TsTablesResturant', 0, 0, 0, 0),
(102, 1, NULL, 'TsShiftReport', 0, 0, 0, 0),
(103, 1, NULL, 'TsCollectionOfItems', 0, 0, 0, 0),
(104, 1, NULL, 'TsTransfersStores', 0, 0, 0, 0),
(105, 1, NULL, 'TsItemsBalances', 0, 0, 0, 0),
(106, 1, NULL, 'TsStoreEvaluation', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `page_name` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `page_name`, `parent`, `parent_id`, `active`) VALUES
(1, 'النظام', 'TsSystem', 1, 0, 1),
(2, 'المخازن', 'TsStores', 1, 0, 0),
(3, 'المبيعات', 'TsSales', 1, 0, 0),
(4, 'المشتريات', 'TsPurchases', 1, 0, 0),
(5, 'المحاسبة المالية', 'TsAccounts', 1, 0, 0),
(6, 'السندات', 'TsBonds', 1, 0, 0),
(7, 'التقارير', 'TsReports', 1, 0, 0),
(8, 'الاعدادات', 'TsSettings', 1, 0, 0),
(9, 'اعدادات الطابعة', 'TsPrintSetting', 1, 0, 0),
(10, 'الشركة', 'TsCompany', 0, 1, 0),
(11, 'الفروع', 'TsBranchs', 0, 1, 0),
(12, 'السنوات المالية', 'TsFiscalYears', 0, 1, 0),
(13, 'العملات', 'TsCurrencies', 0, 1, 0),
(14, 'المستخدمين', 'TsUsers', 0, 1, 1),
(15, 'الموظفين', 'TsEmployees', 0, 1, 0),
(16, 'العملاء', 'TsCustomers', 0, 1, 0),
(17, 'الموردين', 'TsSuppliers', 0, 1, 0),
(18, 'كارت الصنف', 'TsCategoryCard', 0, 2, 0),
(19, 'الاصناف', 'TsItems', 0, 2, 0),
(20, 'الوحدات', 'TsUnits', 0, 2, 0),
(21, 'مجموعة الاصناف', 'TsGroupItems', 0, 2, 0),
(22, 'رصيد افتتاحي المخازن', 'TsStoresOpeningBalance', 0, 2, 0),
(23, 'تعريف المخازن', 'TsDefinitionStores', 0, 2, 0),
(24, 'اذن اضافة', 'TsOrderAdd', 0, 2, 0),
(25, 'اذن صرف', 'TsOrderCashing', 0, 2, 0),
(26, 'فاتورة بيع', 'TsInvoiceSales', 0, 3, 0),
(27, 'تقرير بيع', 'TsInvoiceReports', 0, 3, 0),
(28, 'مرتجع بيع', 'TsReturnedSales', 0, 3, 0),
(29, 'تقرير الاصناف', 'TsReportsItemsSals', 0, 3, 0),
(30, 'التجميع', 'TsCollectionOfItems', 0, 2, 0),
(31, 'تحويلات المخازن', 'TsTransfersStores', 0, 2, 0),
(32, 'ارصدة الاصناف', 'TsItemsBalances', 0, 2, 0),
(33, 'تقييم المخزون', 'TsStoreEvaluation', 0, 2, 0),
(35, 'عرض سعر - مبيعات', 'TsPriceOfferSalles', 0, 3, 0),
(39, 'فاتورة مشتريات', 'TsInvoicePurchases', 0, 4, 0),
(40, 'تقارير المشتريات', 'TsPurchasesReports', 0, 4, 0),
(41, 'مرتجع المشتريات', 'TsReturnedPurchases', 0, 4, 0),
(42, 'دليل الحسابات', 'TsAccountsGuide', 0, 5, 0),
(43, 'مراكز التكلفة', 'TsCostCenters', 0, 5, 0),
(44, 'قيود اليومية', 'TsRestrictions', 0, 5, 0),
(45, 'رصيد افتتاحي - حسابات', 'TsOpeningAccounts', 0, 5, 0),
(46, 'سند قبض نقدي', 'TsCashReceipt', 0, 6, 0),
(47, 'سند صرف نقدي', 'TsCashExChange', 0, 6, 0),
(48, 'سند قبض بنكي', 'TsBankReceipt', 0, 6, 0),
(49, 'سند صرف بنكي', 'TsBankExChange', 0, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_add`
--

CREATE TABLE `permission_add` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `source_num` int(11) NOT NULL DEFAULT 0,
  `num` int(11) NOT NULL DEFAULT 1,
  `source` varchar(100) NOT NULL DEFAULT '',
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `customerId` int(11) NOT NULL DEFAULT 1,
  `payment` int(11) NOT NULL DEFAULT 3,
  `netTotal` float NOT NULL DEFAULT 0,
  `branchId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_add`
--

INSERT INTO `permission_add` (`id`, `fiscal_year`, `source_num`, `num`, `source`, `dateInvoice`, `customerId`, `payment`, `netTotal`, `branchId`, `storeId`, `created_at`, `updated_at`) VALUES
(1, '2022', 1, 1, 'مشتريات', '2022-06-08 13:05:24', 1, 1, 2500, 1, 1, '2022-06-08 11:05:24', '2022-06-08 11:05:24'),
(3, '2022', 2, 2, 'مشتريات', '2022-06-08 14:54:08', 1, 1, 30, 1, 1, '2022-06-08 12:54:08', '2022-06-08 12:54:08'),
(4, '2022', 3, 3, 'مشتريات', '2022-06-13 12:34:59', 1, 1, 22500, 1, 1, '2022-06-13 10:34:59', '2022-06-13 10:34:59'),
(5, '2022', 4, 4, 'مشتريات', '2022-07-03 09:52:09', 1, 1, 25000, 1, 1, '2022-07-03 07:52:09', '2022-07-03 07:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `permission_add_list`
--

CREATE TABLE `permission_add_list` (
  `id` int(11) NOT NULL,
  `source_num` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `invoiceId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_add_list`
--

INSERT INTO `permission_add_list` (`id`, `source_num`, `storeId`, `invoiceId`, `itemId`, `unitId`, `qtn`, `price`, `discountRate`, `discountValue`, `total`, `value`, `rate`, `nettotal`) VALUES
(1, 1, 0, 1, 241, 2, 50, 50, 0, 0, 2500, 0, 0, 2500),
(3, 3, 0, 2, 190, 13, 10, 3, 0, 0, 30, 0, 0, 30),
(4, 4, 0, 3, 242, 45, 5, 4500, 0, 0, 22500, 0, 0, 22500),
(5, 5, 0, 4, 242, 45, 5, 5000, 0, 0, 25000, 0, 0, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `permission_cashing`
--

CREATE TABLE `permission_cashing` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT 1,
  `source_num` int(11) NOT NULL DEFAULT 0,
  `source` varchar(250) NOT NULL DEFAULT '',
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `customerId` int(11) NOT NULL DEFAULT 0,
  `payment` int(11) NOT NULL DEFAULT 3,
  `netTotal` float NOT NULL DEFAULT 0,
  `branchId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_cashing`
--

INSERT INTO `permission_cashing` (`id`, `fiscal_year`, `num`, `source_num`, `source`, `dateInvoice`, `customerId`, `payment`, `netTotal`, `branchId`, `storeId`, `created_at`, `updated_at`) VALUES
(1, '2022', 1, 18, 'مبيعات', '2022-06-08 14:54:49', 1, 1, 2, 1, 1, '2022-06-08 15:54:49', '2022-06-08 15:54:49'),
(2, '2022', 1, 19, 'مبيعات', '2022-06-08 14:57:03', 1, 1, 3, 1, 1, '2022-06-08 15:57:03', '2022-06-08 15:57:03'),
(3, '2022', 1, 20, 'مبيعات', '2022-06-08 14:57:07', 1, 1, 3, 1, 1, '2022-06-08 15:57:07', '2022-06-08 15:57:07'),
(4, '2022', 1, 21, 'مبيعات', '2022-06-09 09:56:56', 1, 1, 2, 1, 0, '2022-06-09 10:56:56', '2022-06-09 10:56:56'),
(5, '2022', 1, 22, 'مبيعات', '2022-06-09 09:59:19', 1, 1, 2, 1, 0, '2022-06-09 10:59:19', '2022-06-09 10:59:19'),
(6, '2022', 1, 23, 'مبيعات', '2022-06-09 11:30:32', 1, 1, 3, 1, 1, '2022-06-09 12:30:32', '2022-06-09 12:30:32'),
(7, '2022', 1, 24, 'مبيعات', '2022-06-09 11:35:29', 1, 1, 4, 1, 1, '2022-06-09 12:35:29', '2022-06-09 12:35:29'),
(8, '2022', 1, 25, 'مبيعات', '2022-07-06 14:39:35', 1, 1, 5000, 1, 1, '2022-07-06 17:39:35', '2022-07-06 17:39:35'),
(9, '2022', 1, 26, 'مبيعات', '2022-07-06 16:04:17', 1, 1, 5000, 1, 1, '2022-07-06 19:04:17', '2022-07-06 19:04:17'),
(10, '2022', 1, 27, 'مبيعات', '2022-07-13 12:16:18', 1, 1, 5, 1, 1, '2022-07-13 13:16:18', '2022-07-13 13:16:18'),
(11, '2022', 1, 28, 'مبيعات', '2022-07-13 12:36:31', 1, 1, 5, 1, 1, '2022-07-13 13:36:31', '2022-07-13 13:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `permission_cashing_list`
--

CREATE TABLE `permission_cashing_list` (
  `id` int(11) NOT NULL,
  `source_num` int(11) NOT NULL DEFAULT 0,
  `invoiceId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_cashing_list`
--

INSERT INTO `permission_cashing_list` (`id`, `source_num`, `invoiceId`, `storeId`, `itemId`, `unitId`, `qtn`, `price`, `discountRate`, `discountValue`, `total`, `value`, `rate`, `nettotal`) VALUES
(1, 1, 18, 1, 190, 13, 1, 1.73913, 0, 0, 2, 0.26087, 15, 2),
(2, 2, 19, 1, 190, 1, 1, 2.6087, 0, 0, 3, 0.391304, 15, 3),
(3, 3, 20, 1, 190, 1, 1, 2.6087, 0, 0, 3, 0.391304, 15, 3),
(4, 5, 22, 1, 190, 13, 1, 1.73913, 0, 0, 2, 0.26087, 15, 2),
(5, 6, 23, 1, 190, 1, 1, 2.6087, 0, 0, 3, 0.391304, 15, 3),
(6, 7, 24, 1, 190, 13, 1, 1.73913, 0, 0, 2, 0.26087, 15, 2),
(9, 8, 25, 1, 242, 45, 1, 5000, 0, 0, 5000, 0, 0, 5000),
(10, 9, 26, 1, 242, 45, 1, 5000, 0, 0, 5000, 0, 0, 5000),
(11, 10, 27, 1, 190, 1, 1, 2.6087, 0, 0, 3, 0.391304, 15, 3),
(12, 11, 28, 1, 190, 1, 1, 2.6087, 0, 0, 3, 0.391304, 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `powers`
--

CREATE TABLE `powers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `TsSystem` tinyint(4) NOT NULL DEFAULT 0,
  `TsStores` tinyint(4) NOT NULL DEFAULT 0,
  `TsSales` tinyint(4) NOT NULL DEFAULT 0,
  `TsPurchases` tinyint(4) NOT NULL DEFAULT 0,
  `TsAccounts` tinyint(4) NOT NULL DEFAULT 0,
  `TsBonds` tinyint(4) NOT NULL DEFAULT 0,
  `TsPointOfSales` tinyint(4) NOT NULL DEFAULT 0,
  `TsSettings` tinyint(4) NOT NULL DEFAULT 0,
  `TsPos` tinyint(4) NOT NULL DEFAULT 0,
  `TsBackup` tinyint(4) NOT NULL DEFAULT 0,
  `TsPrintSetting` tinyint(4) NOT NULL DEFAULT 0,
  `TsCompany` tinyint(4) NOT NULL DEFAULT 0,
  `TsBranchs` tinyint(4) NOT NULL DEFAULT 0,
  `TsFiscalYears` tinyint(4) NOT NULL DEFAULT 0,
  `TsCurrencies` tinyint(4) NOT NULL DEFAULT 0,
  `TsUsers` tinyint(4) NOT NULL DEFAULT 0,
  `TsEmployees` tinyint(4) NOT NULL DEFAULT 0,
  `TsCustomers` tinyint(4) NOT NULL DEFAULT 0,
  `TsSuppliers` tinyint(4) NOT NULL DEFAULT 0,
  `TsCategoryCard` tinyint(4) NOT NULL DEFAULT 0,
  `TsItems` tinyint(4) NOT NULL DEFAULT 0,
  `TsUnits` tinyint(4) NOT NULL DEFAULT 0,
  `TsGroupItems` tinyint(4) NOT NULL DEFAULT 0,
  `TsStoresOpeningBalance` tinyint(4) NOT NULL DEFAULT 0,
  `TsDefinitionStores` tinyint(4) NOT NULL DEFAULT 0,
  `TsOrderAdd` tinyint(4) NOT NULL DEFAULT 0,
  `TsOrderCashing` tinyint(4) NOT NULL DEFAULT 0,
  `TsInvoiceSales` tinyint(4) NOT NULL DEFAULT 0,
  `TsPriceOfferSalles` tinyint(2) NOT NULL DEFAULT 0,
  `TsInvoiceReports` tinyint(4) NOT NULL DEFAULT 0,
  `TsReturnedSales` tinyint(4) NOT NULL DEFAULT 0,
  `TsReportsItemsSals` tinyint(4) NOT NULL DEFAULT 0,
  `TsInvoicePurchases` tinyint(4) NOT NULL DEFAULT 0,
  `TsPurchasesReports` tinyint(4) NOT NULL DEFAULT 0,
  `TsReturnedPurchases` tinyint(4) NOT NULL DEFAULT 0,
  `TsReportsItemsPurchases` tinyint(4) NOT NULL DEFAULT 0,
  `TsAccountsGuide` tinyint(4) NOT NULL DEFAULT 0,
  `TsCostCenters` tinyint(4) NOT NULL DEFAULT 0,
  `TsRestrictions` tinyint(4) NOT NULL DEFAULT 0,
  `TsAccountStatement` tinyint(4) NOT NULL DEFAULT 0,
  `TsOpeningAccounts` tinyint(4) NOT NULL DEFAULT 0,
  `TsBudgetReport` tinyint(4) NOT NULL DEFAULT 0,
  `TsCostCenterReport` tinyint(4) NOT NULL DEFAULT 0,
  `TsCashReceipt` tinyint(4) NOT NULL DEFAULT 0,
  `TsCashExChange` tinyint(4) NOT NULL DEFAULT 0,
  `TsBankReceipt` tinyint(4) NOT NULL DEFAULT 0,
  `TsBankExChange` tinyint(4) NOT NULL DEFAULT 0,
  `TsTablesResturant` tinyint(4) NOT NULL DEFAULT 0,
  `TsShiftReport` tinyint(4) NOT NULL DEFAULT 0,
  `TsCollectionOfItems` tinyint(4) NOT NULL DEFAULT 0,
  `TsTransfersStores` tinyint(4) NOT NULL DEFAULT 0,
  `TsItemsBalances` tinyint(4) NOT NULL DEFAULT 0,
  `TsStoreEvaluation` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `powers`
--

INSERT INTO `powers` (`id`, `user_id`, `TsSystem`, `TsStores`, `TsSales`, `TsPurchases`, `TsAccounts`, `TsBonds`, `TsPointOfSales`, `TsSettings`, `TsPos`, `TsBackup`, `TsPrintSetting`, `TsCompany`, `TsBranchs`, `TsFiscalYears`, `TsCurrencies`, `TsUsers`, `TsEmployees`, `TsCustomers`, `TsSuppliers`, `TsCategoryCard`, `TsItems`, `TsUnits`, `TsGroupItems`, `TsStoresOpeningBalance`, `TsDefinitionStores`, `TsOrderAdd`, `TsOrderCashing`, `TsInvoiceSales`, `TsPriceOfferSalles`, `TsInvoiceReports`, `TsReturnedSales`, `TsReportsItemsSals`, `TsInvoicePurchases`, `TsPurchasesReports`, `TsReturnedPurchases`, `TsReportsItemsPurchases`, `TsAccountsGuide`, `TsCostCenters`, `TsRestrictions`, `TsAccountStatement`, `TsOpeningAccounts`, `TsBudgetReport`, `TsCostCenterReport`, `TsCashReceipt`, `TsCashExChange`, `TsBankReceipt`, `TsBankExChange`, `TsTablesResturant`, `TsShiftReport`, `TsCollectionOfItems`, `TsTransfersStores`, `TsItemsBalances`, `TsStoreEvaluation`) VALUES
(1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `printersetting`
--

CREATE TABLE `printersetting` (
  `id` int(11) NOT NULL,
  `printkitchen` varchar(255) DEFAULT NULL,
  `printcasher` varchar(255) DEFAULT NULL,
  `print_qr` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `printersetting`
--

INSERT INTO `printersetting` (`id`, `printkitchen`, `printcasher`, `print_qr`) VALUES
(1, '', 'XP-80C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `branchId` int(11) NOT NULL,
  `supplier_invoice` float DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `netTotal` float NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `fiscal_year`, `dateInvoice`, `supplier`, `payment`, `branchId`, `supplier_invoice`, `taxSource`, `netTotal`, `updated_at`, `created_at`) VALUES
(1, '2022', '2022-06-08 13:05:24', 1, 1, 1, NULL, 0, 0, '2022-06-08 11:05:24', '2022-06-08 11:05:24'),
(2, '2022', '2022-06-08 14:54:08', 1, 1, 1, NULL, 0, 0, '2022-06-08 12:54:08', '2022-06-08 12:54:08'),
(3, '2022', '2022-06-13 12:34:59', 1, 1, 1, NULL, 0, 0, '2022-06-13 10:34:59', '2022-06-13 10:34:59'),
(4, '2022', '2022-07-03 09:52:09', 1, 1, 1, NULL, 0, 0, '2022-07-03 07:52:09', '2022-07-03 07:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseslist`
--

CREATE TABLE `purchaseslist` (
  `id` int(11) NOT NULL,
  `purchasesId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `qtn_unit` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `av_price` float NOT NULL DEFAULT 0,
  `discountValue` float DEFAULT NULL,
  `discountRate` float DEFAULT NULL,
  `total` float NOT NULL DEFAULT 0,
  `value` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchaseslist`
--

INSERT INTO `purchaseslist` (`id`, `purchasesId`, `storeId`, `itemId`, `unitId`, `qtn`, `qtn_unit`, `price`, `av_price`, `discountValue`, `discountRate`, `total`, `value`, `rate`, `nettotal`) VALUES
(1, 1, 1, 241, 2, 50, 0, 50, 50, 0, 0, 2500, 0, 0, 2500),
(3, 2, 1, 190, 13, 10, 0, 3, 3, 0, 0, 30, 0, 0, 30),
(4, 3, 1, 242, 45, 5, 0, 4500, 4807.69, 0, 0, 22500, 0, 0, 22500),
(5, 4, 1, 242, 45, 5, 0, 5000, 4875, 0, 0, 25000, 0, 0, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_follow` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `branchId` int(11) NOT NULL,
  `supplier_invoice` float DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `netTotal` float NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_list`
--

CREATE TABLE `purchase_order_list` (
  `id` int(11) NOT NULL,
  `purchasesId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `qtn_unit` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `av_price` float NOT NULL DEFAULT 0,
  `discountValue` float DEFAULT NULL,
  `discountRate` float DEFAULT NULL,
  `total` float NOT NULL DEFAULT 0,
  `value` float DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quantity_of_items`
--

CREATE TABLE `quantity_of_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quantity_of_items`
--

INSERT INTO `quantity_of_items` (`id`, `item_id`, `unit_id`, `store_id`, `qtn`) VALUES
(1, 241, 2, 1, 50),
(2, 190, 13, 1, 2),
(3, 242, 45, 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `ref`
--

CREATE TABLE `ref` (
  `id` int(11) NOT NULL,
  `ref` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ref`
--

INSERT INTO `ref` (`id`, `ref`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `system` varchar(4) NOT NULL DEFAULT '0',
  `stores` varchar(4) NOT NULL DEFAULT '0',
  `sales` tinyint(4) NOT NULL DEFAULT 0,
  `purchases` tinyint(4) NOT NULL DEFAULT 0,
  `financial_account` tinyint(4) NOT NULL DEFAULT 0,
  `bonds` tinyint(4) NOT NULL DEFAULT 0,
  `point_of_sales` tinyint(4) NOT NULL DEFAULT 0,
  `setting` tinyint(4) NOT NULL DEFAULT 0,
  `pos` tinyint(4) NOT NULL DEFAULT 0,
  `backup` tinyint(4) NOT NULL DEFAULT 0,
  `other` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`id`, `system`, `stores`, `sales`, `purchases`, `financial_account`, `bonds`, `point_of_sales`, `setting`, `pos`, `backup`, `other`) VALUES
(1, '1', '1', 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reference_items`
--

CREATE TABLE `reference_items` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reference_items`
--

INSERT INTO `reference_items` (`id`, `parent_id`, `name`, `active`) VALUES
(1, 1, 'company', 0),
(2, 1, 'branches', 0),
(3, 1, 'fiscal', 0),
(4, 1, 'currency', 0),
(5, 1, 'users', 0);

-- --------------------------------------------------------

--
-- Table structure for table `returned_invoices_purchases`
--

CREATE TABLE `returned_invoices_purchases` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier` int(11) NOT NULL DEFAULT 0,
  `payment` int(11) NOT NULL DEFAULT 0,
  `branchId` int(11) NOT NULL DEFAULT 0,
  `supplier_invoice` float DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returned_invoices_purchases_list`
--

CREATE TABLE `returned_invoices_purchases_list` (
  `id` int(11) NOT NULL,
  `purchasesId` int(11) NOT NULL DEFAULT 0,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountValue` float DEFAULT NULL,
  `discountRate` float DEFAULT NULL,
  `total` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returned_salles`
--

CREATE TABLE `returned_salles` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `cost_center` int(11) DEFAULT NULL,
  `dateInvoice` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeId` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `netTotal` float NOT NULL DEFAULT 0,
  `shiftNum` int(11) NOT NULL DEFAULT 0,
  `customerId` int(11) NOT NULL DEFAULT 1,
  `payment` int(11) NOT NULL DEFAULT 3,
  `cash` float NOT NULL DEFAULT 0,
  `visa` float NOT NULL DEFAULT 0,
  `masterCard` float NOT NULL DEFAULT 0,
  `credit` float NOT NULL DEFAULT 0,
  `branchId` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returned_salles_list`
--

CREATE TABLE `returned_salles_list` (
  `id` int(11) NOT NULL,
  `invoiceId` int(11) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sell_order`
--

CREATE TABLE `sell_order` (
  `id` int(11) NOT NULL,
  `fiscal_year` varchar(100) DEFAULT NULL,
  `taxSource` float NOT NULL DEFAULT 0,
  `cost_center` int(11) DEFAULT NULL,
  `branchId` int(100) NOT NULL DEFAULT 0,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `netTotal` float NOT NULL DEFAULT 0,
  `shiftNum` int(11) NOT NULL DEFAULT 0,
  `customerId` int(11) NOT NULL DEFAULT 0,
  `cash` float NOT NULL DEFAULT 0,
  `visa` float NOT NULL DEFAULT 0,
  `masterCard` float NOT NULL DEFAULT 0,
  `credit` float NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sell_order_list`
--

CREATE TABLE `sell_order_list` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `invoiceId` int(11) DEFAULT NULL,
  `storeId` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(255) NOT NULL DEFAULT '',
  `qtn` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `discountRate` float NOT NULL DEFAULT 0,
  `discountValue` float NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `value` float NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `total` float NOT NULL DEFAULT 0,
  `nettotal` float NOT NULL DEFAULT 0,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `openDate` timestamp NULL DEFAULT NULL,
  `closeDate` timestamp NULL DEFAULT NULL,
  `opening` int(11) NOT NULL DEFAULT 0,
  `closeing` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `openDate`, `closeDate`, `opening`, `closeing`, `created_at`, `updated_at`) VALUES
(1, '2022-05-18 18:36:59', '2022-06-08 10:24:07', 0, 1, '2022-06-08 09:24:07', '2022-06-08 10:24:07'),
(2, '2022-06-08 07:24:44', '2022-06-08 10:27:05', 0, 1, '2022-06-08 09:27:05', '2022-06-08 10:27:05'),
(3, '2022-06-08 07:27:06', '2022-06-08 10:27:12', 0, 1, '2022-06-08 09:27:12', '2022-06-08 10:27:12'),
(4, '2022-06-08 07:27:14', '2022-06-08 10:33:21', 0, 1, '2022-06-08 09:33:21', '2022-06-08 10:33:21'),
(5, '2022-06-08 07:33:38', '2022-06-08 10:35:35', 0, 1, '2022-06-08 09:35:35', '2022-06-08 10:35:35'),
(6, '2022-06-08 10:35:43', NULL, 1, 0, '2022-06-08 09:35:43', '2022-06-08 10:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `branchId` varchar(100) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `namear` varchar(100) DEFAULT NULL,
  `nameen` varchar(255) NOT NULL,
  `main` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `branchId`, `active`, `namear`, `nameen`, `main`) VALUES
(1, '1', 1, 'المخزن الرئيسي', 'main Store', 1),
(2, '1', 1, 'فرعي', 'فرعي', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `account_id` double NOT NULL DEFAULT 0,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `group` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `VATRegistration` varchar(100) DEFAULT NULL,
  `IdentificationNumber` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `account_id`, `code`, `name`, `group`, `address`, `phone`, `VATRegistration`, `IdentificationNumber`) VALUES
(1, 201001, 201, 'user', NULL, 'Egypt', '01011404312', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `numTable` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `numTable`, `created_at`, `updated_at`) VALUES
(1, '1', '2022-07-14 12:23:39', '2022-07-14 10:23:39'),
(2, '21', '2022-07-14 12:44:46', '2022-07-14 10:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `terms_of_reference`
--

CREATE TABLE `terms_of_reference` (
  `id` int(11) NOT NULL,
  `secret_code` varchar(250) NOT NULL DEFAULT '0',
  `experimental` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT NULL,
  `activation` int(11) NOT NULL DEFAULT 0,
  `movements` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms_of_reference`
--

INSERT INTO `terms_of_reference` (`id`, `secret_code`, `experimental`, `date`, `activation`, `movements`) VALUES
(1, 'SerialNumber     \r\nWD-WCC4J4571735  \r\n0                \r\n30047890411      \r\n\r\n', 1, '2022-02-02 09:31:50', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL,
  `branchId` int(11) NOT NULL DEFAULT 0,
  `storeId1` int(11) NOT NULL DEFAULT 0,
  `storeId2` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transfers_list`
--

CREATE TABLE `transfers_list` (
  `id` int(11) NOT NULL,
  `transferId` int(11) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL DEFAULT 0,
  `unitId` int(11) NOT NULL DEFAULT 0,
  `qtn` float NOT NULL DEFAULT 0,
  `cost` float NOT NULL DEFAULT 0,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `namear` varchar(255) NOT NULL,
  `nameen` varchar(255) NOT NULL,
  `tax_code` varchar(100) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `namear`, `nameen`, `tax_code`, `active`) VALUES
(1, 'صغير', 'small', NULL, 1),
(2, 'وسط', 'medium', NULL, 1),
(3, 'كبير', 'large', NULL, 1),
(4, 'روبيان', 'Shrimp', NULL, 1),
(5, 'دجاج', 'chicken', NULL, 1),
(6, 'لحم', 'meat', NULL, 1),
(7, 'خضار', 'Vegetables', NULL, 1),
(8, 'نقانق', 'Nqanq', NULL, 1),
(9, 'ببرونى', 'paprony', NULL, 1),
(10, 'ديناميت', 'dynamite', NULL, 1),
(11, 'ثوم', 'garlic', NULL, 1),
(12, 'رانش', 'Ranch', NULL, 1),
(13, '..', '..', NULL, 1),
(14, 'باربكيو', 'barbecue', NULL, 1),
(15, '4', '4', NULL, 1),
(16, '3', '3', NULL, 1),
(17, 'ساده', 'sada', NULL, 1),
(18, 'فراولة', 'Strawberry', NULL, 1),
(19, 'توت ازرق', 'blueberry', NULL, 1),
(20, 'بطيخ', 'watermelon', NULL, 1),
(21, 'كرز', 'Cherry', NULL, 1),
(22, 'احمر', 'red', NULL, 1),
(23, 'ابيض', 'white', NULL, 1),
(24, 'مكس', 'mix', NULL, 1),
(39, 'كوسة', 'kusah', NULL, 1),
(40, 'بصل', 'Onion', NULL, 1),
(41, 'زيتون', 'olive', NULL, 1),
(42, 'بروكلي', 'Broccoli', NULL, 1),
(43, 'بقدونس', 'parsley', NULL, 1),
(44, 'زهرة', 'zahra', NULL, 1),
(45, 'عدد', 'عدد', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `barnchId` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `barnchId`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(0, 'admin', NULL, 'active', 1, 3, NULL, '$2y$10$c4VMiyDxnMLWReYkL9iLqeUcydlZJhvGQPwiJoumS3CaVW6cGpH/i', NULL, '2022-07-04 11:11:25', '2022-07-04 11:11:25'),
(1, 'user', NULL, 'active', 1, 1, NULL, '$2y$10$3UWckCcKCmVYUUz7QyU9jO5YiQFnJd0b4npXgJhsrIm3N34kJhyN6', NULL, '2022-07-04 11:24:44', '2022-07-04 11:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `id` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `version` varchar(100) NOT NULL DEFAULT '0',
  `updateDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`id`, `active`, `version`, `updateDate`) VALUES
(1, 0, '2.5', '2022-03-21 09:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `version_db`
--

CREATE TABLE `version_db` (
  `id` int(11) NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `version_db`
--

INSERT INTO `version_db` (`id`, `version`, `name`, `file`, `active`, `date`) VALUES
(1, '0', '', '', 1, '2022-03-31 12:15:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bond`
--
ALTER TABLE `bond`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bond_list`
--
ALTER TABLE `bond_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `namear` (`namear`),
  ADD UNIQUE KEY `nameen` (`nameen`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `categoryitems`
--
ALTER TABLE `categoryitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compaines`
--
ALTER TABLE `compaines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_centers`
--
ALTER TABLE `cost_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crm_customers`
--
ALTER TABLE `crm_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rate` (`rate`),
  ADD UNIQUE KEY `bigar` (`bigar`),
  ADD UNIQUE KEY `bigen` (`bigen`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `dailyrestrictions`
--
ALTER TABLE `dailyrestrictions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailyrestrictions_list`
--
ALTER TABLE `dailyrestrictions_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `namear` (`namear`),
  ADD UNIQUE KEY `nameen` (`nameen`);

--
-- Indexes for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `end` (`end`),
  ADD UNIQUE KEY `start` (`start`);

--
-- Indexes for table `holdinvoices`
--
ALTER TABLE `holdinvoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices_list`
--
ALTER TABLE `invoices_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itemslist`
--
ALTER TABLE `itemslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_assembly`
--
ALTER TABLE `items_assembly`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_assembly_list`
--
ALTER TABLE `items_assembly_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_collection`
--
ALTER TABLE `items_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_collection_list`
--
ALTER TABLE `items_collection_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `numorders`
--
ALTER TABLE `numorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_price`
--
ALTER TABLE `offer_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_price_list`
--
ALTER TABLE `offer_price_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_balance`
--
ALTER TABLE `opening_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_balance_accounts`
--
ALTER TABLE `opening_balance_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_balance_accounts_list`
--
ALTER TABLE `opening_balance_accounts_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opening_balance_list`
--
ALTER TABLE `opening_balance_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_pages`
--
ALTER TABLE `orders_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permission_add`
--
ALTER TABLE `permission_add`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_add_list`
--
ALTER TABLE `permission_add_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_cashing`
--
ALTER TABLE `permission_cashing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_cashing_list`
--
ALTER TABLE `permission_cashing_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `powers`
--
ALTER TABLE `powers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printersetting`
--
ALTER TABLE `printersetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseslist`
--
ALTER TABLE `purchaseslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_list`
--
ALTER TABLE `purchase_order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quantity_of_items`
--
ALTER TABLE `quantity_of_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref`
--
ALTER TABLE `ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_items`
--
ALTER TABLE `reference_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returned_invoices_purchases`
--
ALTER TABLE `returned_invoices_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returned_invoices_purchases_list`
--
ALTER TABLE `returned_invoices_purchases_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returned_salles`
--
ALTER TABLE `returned_salles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returned_salles_list`
--
ALTER TABLE `returned_salles_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_order`
--
ALTER TABLE `sell_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_order_list`
--
ALTER TABLE `sell_order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numTable` (`numTable`);

--
-- Indexes for table `terms_of_reference`
--
ALTER TABLE `terms_of_reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers_list`
--
ALTER TABLE `transfers_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `version_db`
--
ALTER TABLE `version_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `bond`
--
ALTER TABLE `bond`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bond_list`
--
ALTER TABLE `bond_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categoryitems`
--
ALTER TABLE `categoryitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `compaines`
--
ALTER TABLE `compaines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cost_centers`
--
ALTER TABLE `cost_centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_customers`
--
ALTER TABLE `crm_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dailyrestrictions`
--
ALTER TABLE `dailyrestrictions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `dailyrestrictions_list`
--
ALTER TABLE `dailyrestrictions_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holdinvoices`
--
ALTER TABLE `holdinvoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `invoices_list`
--
ALTER TABLE `invoices_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `itemslist`
--
ALTER TABLE `itemslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `items_assembly`
--
ALTER TABLE `items_assembly`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_assembly_list`
--
ALTER TABLE `items_assembly_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_collection`
--
ALTER TABLE `items_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_collection_list`
--
ALTER TABLE `items_collection_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `numorders`
--
ALTER TABLE `numorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offer_price`
--
ALTER TABLE `offer_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_price_list`
--
ALTER TABLE `offer_price_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opening_balance`
--
ALTER TABLE `opening_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `opening_balance_accounts`
--
ALTER TABLE `opening_balance_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opening_balance_accounts_list`
--
ALTER TABLE `opening_balance_accounts_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opening_balance_list`
--
ALTER TABLE `opening_balance_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders_pages`
--
ALTER TABLE `orders_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `permission_add`
--
ALTER TABLE `permission_add`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_add_list`
--
ALTER TABLE `permission_add_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_cashing`
--
ALTER TABLE `permission_cashing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permission_cashing_list`
--
ALTER TABLE `permission_cashing_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `powers`
--
ALTER TABLE `powers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `printersetting`
--
ALTER TABLE `printersetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchaseslist`
--
ALTER TABLE `purchaseslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_list`
--
ALTER TABLE `purchase_order_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quantity_of_items`
--
ALTER TABLE `quantity_of_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref`
--
ALTER TABLE `ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference_items`
--
ALTER TABLE `reference_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `returned_invoices_purchases`
--
ALTER TABLE `returned_invoices_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returned_invoices_purchases_list`
--
ALTER TABLE `returned_invoices_purchases_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returned_salles`
--
ALTER TABLE `returned_salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returned_salles_list`
--
ALTER TABLE `returned_salles_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_order`
--
ALTER TABLE `sell_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_order_list`
--
ALTER TABLE `sell_order_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
