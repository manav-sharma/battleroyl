-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2018 at 04:49 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_battleroyale`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `whatsapp_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `admin_type` enum('1','2') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=admin,2=super admin',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `phone_number`, `whatsapp_number`, `status`, `admin_type`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Dy2ls9tAUMUjzxj-ihBWUEgXCnYrbcaJ', '$2y$13$rgQoxtIatmbeUR.TErrXSOIM/Q3tfimlzCj.DkjD5rbvoP3.8PYY6', NULL, 'rachita@webworldexpertsindia.com', '+197677734', '+188585544', 10, '1', 1456402867, 1509604222),
(4, 'superadmin', 'Dy2ls9tAUMUjzxj-ihBWUEgXCnYrbcaJ', '$2y$13$jL1IYcx0BFLSkWop97JZY.nmwWx7qMoiVlHpASA9O4K3W6yYgWnEW', NULL, 'testsuperadmin@testmail.com', '+5435345666', '+5464564566', 10, '2', 0, 1502449346);

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE IF NOT EXISTS `advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `advertisement_image` varchar(255) NOT NULL,
  `user_images` text NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `approved` enum('0','1','2') NOT NULL,
  `status` enum('1','2') NOT NULL,
  `delete_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `membership_id`, `name`, `advertisement_image`, `user_images`, `description`, `start_date`, `end_date`, `user_id`, `approved`, `status`, `delete_status`, `date_created`) VALUES
(2, 1, 'Test Advertisement 02', 'agrimg_1500980541.jpg', '', 'This is dummy text just for testing.', '2017-06-01', '2017-07-28', 6, '1', '1', 0, '2017-10-31 07:34:18'),
(3, 1, 'Test Advertisement 01 ', 'agrimg_1501744957.jpg', '', 'This is dummy description.', '2017-07-04', '2017-07-31', 10, '1', '1', 0, '2017-10-31 11:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `bannerImage` varchar(255) NOT NULL,
  `banner_assign` enum('1','2') NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `status` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `bannerImage`, `banner_assign`, `description`, `dateCreated`, `status`) VALUES
(1, 'Battle Royale', '01-landing-01_1520916656_1520921002.jpg', '1', 'NIGERIA’S First Street Talent Show', '2018-03-13 11:33:22', '1'),
(2, 'Battle Royale', 'bodybg_1520916684_1520921054.jpg', '2', 'NIGERIA’S First Street Talent Show', '2018-03-13 11:34:14', '1');

-- --------------------------------------------------------

--
-- Table structure for table `business_opportunities`
--

CREATE TABLE IF NOT EXISTS `business_opportunities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `documents` varchar(255) NOT NULL,
  `photos` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`) VALUES
(1, 'Bombuflat', 1),
(2, 'Garacharma', 1),
(3, 'Port Blair', 1),
(4, 'Rangat', 1),
(5, 'Addanki', 2),
(6, 'Adivivaram', 2),
(7, 'Adoni', 2),
(8, 'Aganampudi', 2),
(9, 'Ajjaram', 2),
(10, 'Akividu', 2),
(11, 'Akkarampalle', 2),
(12, 'Akkayapalle', 2),
(13, 'Akkireddipalem', 2),
(14, 'Alampur', 2),
(15, 'Amalapuram', 2),
(16, 'Amudalavalasa', 2),
(17, 'Amur', 2),
(18, 'Anakapalle', 2),
(19, 'Anantapur', 2),
(20, 'Andole', 2),
(21, 'Atmakur', 2),
(22, 'Attili', 2),
(23, 'Avanigadda', 2),
(24, 'Badepalli', 2),
(25, 'Badvel', 2),
(26, 'Balapur', 2),
(27, 'Bandarulanka', 2),
(28, 'Banganapalle', 2),
(29, 'Bapatla', 2),
(30, 'Bapulapadu', 2),
(31, 'Itanagar', 3);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=247 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name`, `phonecode`) VALUES
(1, 'AF', 'Afghanistan', 93),
(2, 'AL', 'Albania', 355),
(3, 'DZ', 'Algeria', 213),
(4, 'AS', 'American Samoa', 1684),
(5, 'AD', 'Andorra', 376),
(6, 'AO', 'Angola', 244),
(7, 'AI', 'Anguilla', 1264),
(8, 'AQ', 'Antarctica', 0),
(9, 'AG', 'Antigua And Barbuda', 1268),
(10, 'AR', 'Argentina', 54),
(11, 'AM', 'Armenia', 374),
(12, 'AW', 'Aruba', 297),
(13, 'AU', 'Australia', 61),
(14, 'AT', 'Austria', 43),
(15, 'AZ', 'Azerbaijan', 994),
(16, 'BS', 'Bahamas The', 1242),
(17, 'BH', 'Bahrain', 973),
(18, 'BD', 'Bangladesh', 880),
(19, 'BB', 'Barbados', 1246),
(20, 'BY', 'Belarus', 375),
(21, 'BE', 'Belgium', 32),
(22, 'BZ', 'Belize', 501),
(23, 'BJ', 'Benin', 229),
(24, 'BM', 'Bermuda', 1441),
(25, 'BT', 'Bhutan', 975),
(26, 'BO', 'Bolivia', 591),
(27, 'BA', 'Bosnia and Herzegovina', 387),
(28, 'BW', 'Botswana', 267),
(29, 'BV', 'Bouvet Island', 0),
(30, 'BR', 'Brazil', 55),
(31, 'IO', 'British Indian Ocean Territory', 246),
(32, 'BN', 'Brunei', 673),
(33, 'BG', 'Bulgaria', 359),
(34, 'BF', 'Burkina Faso', 226),
(35, 'BI', 'Burundi', 257),
(36, 'KH', 'Cambodia', 855),
(37, 'CM', 'Cameroon', 237),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 238),
(40, 'KY', 'Cayman Islands', 1345),
(41, 'CF', 'Central African Republic', 236),
(42, 'TD', 'Chad', 235),
(43, 'CL', 'Chile', 56),
(44, 'CN', 'China', 86),
(45, 'CX', 'Christmas Island', 61),
(46, 'CC', 'Cocos (Keeling) Islands', 672),
(47, 'CO', 'Colombia', 57),
(48, 'KM', 'Comoros', 269),
(49, 'CG', 'Congo', 242),
(50, 'CD', 'Congo The Democratic Republic Of The', 242),
(51, 'CK', 'Cook Islands', 682),
(52, 'CR', 'Costa Rica', 506),
(53, 'CI', 'Cote D''Ivoire (Ivory Coast)', 225),
(54, 'HR', 'Croatia (Hrvatska)', 385),
(55, 'CU', 'Cuba', 53),
(56, 'CY', 'Cyprus', 357),
(57, 'CZ', 'Czech Republic', 420),
(58, 'DK', 'Denmark', 45),
(59, 'DJ', 'Djibouti', 253),
(60, 'DM', 'Dominica', 1767),
(61, 'DO', 'Dominican Republic', 1809),
(62, 'TP', 'East Timor', 0),
(63, 'EC', 'Ecuador', 593),
(64, 'EG', 'Egypt', 20),
(65, 'SV', 'El Salvador', 503),
(66, 'GQ', 'Equatorial Guinea', 240),
(67, 'ER', 'Eritrea', 291),
(68, 'EE', 'Estonia', 372),
(69, 'ET', 'Ethiopia', 251),
(70, 'XA', 'External Territories of Australia', 0),
(71, 'FK', 'Falkland Islands', 500),
(72, 'FO', 'Faroe Islands', 298),
(73, 'FJ', 'Fiji Islands', 679),
(74, 'FI', 'Finland', 358),
(75, 'FR', 'France', 33),
(76, 'GF', 'French Guiana', 594),
(77, 'PF', 'French Polynesia', 689),
(78, 'TF', 'French Southern Territories', 0),
(79, 'GA', 'Gabon', 241),
(80, 'GM', 'Gambia The', 220),
(81, 'GE', 'Georgia', 995),
(82, 'DE', 'Germany', 49),
(83, 'GH', 'Ghana', 233),
(84, 'GI', 'Gibraltar', 350),
(85, 'GR', 'Greece', 30),
(86, 'GL', 'Greenland', 299),
(87, 'GD', 'Grenada', 1473),
(88, 'GP', 'Guadeloupe', 590),
(89, 'GU', 'Guam', 1671),
(90, 'GT', 'Guatemala', 502),
(91, 'XU', 'Guernsey and Alderney', 0),
(92, 'GN', 'Guinea', 224),
(93, 'GW', 'Guinea-Bissau', 245),
(94, 'GY', 'Guyana', 592),
(95, 'HT', 'Haiti', 509),
(96, 'HM', 'Heard and McDonald Islands', 0),
(97, 'HN', 'Honduras', 504),
(98, 'HK', 'Hong Kong S.A.R.', 852),
(99, 'HU', 'Hungary', 36),
(100, 'IS', 'Iceland', 354),
(101, 'IN', 'India', 91),
(102, 'ID', 'Indonesia', 62),
(103, 'IR', 'Iran', 98),
(104, 'IQ', 'Iraq', 964),
(105, 'IE', 'Ireland', 353),
(106, 'IL', 'Israel', 972),
(107, 'IT', 'Italy', 39),
(108, 'JM', 'Jamaica', 1876),
(109, 'JP', 'Japan', 81),
(110, 'XJ', 'Jersey', 0),
(111, 'JO', 'Jordan', 962),
(112, 'KZ', 'Kazakhstan', 7),
(113, 'KE', 'Kenya', 254),
(114, 'KI', 'Kiribati', 686),
(115, 'KP', 'Korea North', 850),
(116, 'KR', 'Korea South', 82),
(117, 'KW', 'Kuwait', 965),
(118, 'KG', 'Kyrgyzstan', 996),
(119, 'LA', 'Laos', 856),
(120, 'LV', 'Latvia', 371),
(121, 'LB', 'Lebanon', 961),
(122, 'LS', 'Lesotho', 266),
(123, 'LR', 'Liberia', 231),
(124, 'LY', 'Libya', 218),
(125, 'LI', 'Liechtenstein', 423),
(126, 'LT', 'Lithuania', 370),
(127, 'LU', 'Luxembourg', 352),
(128, 'MO', 'Macau S.A.R.', 853),
(129, 'MK', 'Macedonia', 389),
(130, 'MG', 'Madagascar', 261),
(131, 'MW', 'Malawi', 265),
(132, 'MY', 'Malaysia', 60),
(133, 'MV', 'Maldives', 960),
(134, 'ML', 'Mali', 223),
(135, 'MT', 'Malta', 356),
(136, 'XM', 'Man (Isle of)', 0),
(137, 'MH', 'Marshall Islands', 692),
(138, 'MQ', 'Martinique', 596),
(139, 'MR', 'Mauritania', 222),
(140, 'MU', 'Mauritius', 230),
(141, 'YT', 'Mayotte', 269),
(142, 'MX', 'Mexico', 52),
(143, 'FM', 'Micronesia', 691),
(144, 'MD', 'Moldova', 373),
(145, 'MC', 'Monaco', 377),
(146, 'MN', 'Mongolia', 976),
(147, 'MS', 'Montserrat', 1664),
(148, 'MA', 'Morocco', 212),
(149, 'MZ', 'Mozambique', 258),
(150, 'MM', 'Myanmar', 95),
(151, 'NA', 'Namibia', 264),
(152, 'NR', 'Nauru', 674),
(153, 'NP', 'Nepal', 977),
(154, 'AN', 'Netherlands Antilles', 599),
(155, 'NL', 'Netherlands The', 31),
(156, 'NC', 'New Caledonia', 687),
(157, 'NZ', 'New Zealand', 64),
(158, 'NI', 'Nicaragua', 505),
(159, 'NE', 'Niger', 227),
(160, 'NG', 'Nigeria', 234),
(161, 'NU', 'Niue', 683),
(162, 'NF', 'Norfolk Island', 672),
(163, 'MP', 'Northern Mariana Islands', 1670),
(164, 'NO', 'Norway', 47),
(165, 'OM', 'Oman', 968),
(166, 'PK', 'Pakistan', 92),
(167, 'PW', 'Palau', 680),
(168, 'PS', 'Palestinian Territory Occupied', 970),
(169, 'PA', 'Panama', 507),
(170, 'PG', 'Papua new Guinea', 675),
(171, 'PY', 'Paraguay', 595),
(172, 'PE', 'Peru', 51),
(173, 'PH', 'Philippines', 63),
(174, 'PN', 'Pitcairn Island', 0),
(175, 'PL', 'Poland', 48),
(176, 'PT', 'Portugal', 351),
(177, 'PR', 'Puerto Rico', 1787),
(178, 'QA', 'Qatar', 974),
(179, 'RE', 'Reunion', 262),
(180, 'RO', 'Romania', 40),
(181, 'RU', 'Russia', 70),
(182, 'RW', 'Rwanda', 250),
(183, 'SH', 'Saint Helena', 290),
(184, 'KN', 'Saint Kitts And Nevis', 1869),
(185, 'LC', 'Saint Lucia', 1758),
(186, 'PM', 'Saint Pierre and Miquelon', 508),
(187, 'VC', 'Saint Vincent And The Grenadines', 1784),
(188, 'WS', 'Samoa', 684),
(189, 'SM', 'San Marino', 378),
(190, 'ST', 'Sao Tome and Principe', 239),
(191, 'SA', 'Saudi Arabia', 966),
(192, 'SN', 'Senegal', 221),
(193, 'RS', 'Serbia', 0),
(194, 'SC', 'Seychelles', 248),
(195, 'SL', 'Sierra Leone', 232),
(196, 'SG', 'Singapore', 65),
(197, 'SK', 'Slovakia', 421),
(198, 'SI', 'Slovenia', 386),
(199, 'XG', 'Smaller Territories of the UK', 0),
(200, 'SB', 'Solomon Islands', 677),
(201, 'SO', 'Somalia', 252),
(202, 'ZA', 'South Africa', 27),
(203, 'GS', 'South Georgia', 0),
(204, 'SS', 'South Sudan', 0),
(205, 'ES', 'Spain', 34),
(206, 'LK', 'Sri Lanka', 94),
(207, 'SD', 'Sudan', 249),
(208, 'SR', 'Suriname', 597),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', 47),
(210, 'SZ', 'Swaziland', 268),
(211, 'SE', 'Sweden', 46),
(212, 'CH', 'Switzerland', 41),
(213, 'SY', 'Syria', 963),
(214, 'TW', 'Taiwan', 886),
(215, 'TJ', 'Tajikistan', 992),
(216, 'TZ', 'Tanzania', 255),
(217, 'TH', 'Thailand', 66),
(218, 'TG', 'Togo', 228),
(219, 'TK', 'Tokelau', 690),
(220, 'TO', 'Tonga', 676),
(221, 'TT', 'Trinidad And Tobago', 1868),
(222, 'TN', 'Tunisia', 216),
(223, 'TR', 'Turkey', 90),
(224, 'TM', 'Turkmenistan', 7370),
(225, 'TC', 'Turks And Caicos Islands', 1649),
(226, 'TV', 'Tuvalu', 688),
(227, 'UG', 'Uganda', 256),
(228, 'UA', 'Ukraine', 380),
(229, 'AE', 'United Arab Emirates', 971),
(230, 'GB', 'United Kingdom', 44),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States Minor Outlying Islands', 1),
(233, 'UY', 'Uruguay', 598),
(234, 'UZ', 'Uzbekistan', 998),
(235, 'VU', 'Vanuatu', 678),
(236, 'VA', 'Vatican City State (Holy See)', 39),
(237, 'VE', 'Venezuela', 58),
(238, 'VN', 'Vietnam', 84),
(239, 'VG', 'Virgin Islands (British)', 1284),
(240, 'VI', 'Virgin Islands (US)', 1340),
(241, 'WF', 'Wallis And Futuna Islands', 681),
(242, 'EH', 'Western Sahara', 212),
(243, 'YE', 'Yemen', 967),
(244, 'YU', 'Yugoslavia', 0),
(245, 'ZM', 'Zambia', 260),
(246, 'ZW', 'Zimbabwe', 263);

-- --------------------------------------------------------

--
-- Table structure for table `event_newsletter_template`
--

CREATE TABLE IF NOT EXISTS `event_newsletter_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eventid` bigint(20) NOT NULL,
  `newsletterid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `event_newsletter_template`
--

INSERT INTO `event_newsletter_template` (`id`, `eventid`, `newsletterid`) VALUES
(1, 1, 1),
(3, 2, 1),
(4, 4, 4),
(6, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `event_template`
--

CREATE TABLE IF NOT EXISTS `event_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `event_template`
--

INSERT INTO `event_template` (`id`, `event`) VALUES
(1, 'TEST_2'),
(2, 'TEST_EVENT'),
(4, 'REGISTRATION'),
(6, 'TESTEMAIL');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_rating`
--

CREATE TABLE IF NOT EXISTS `feedback_rating` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_userid` bigint(20) NOT NULL,
  `receiver_userid` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `starrating` int(5) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('1','2') NOT NULL COMMENT '1 = Active, 2 = Inactive',
  `property_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedback_rating`
--

INSERT INTO `feedback_rating` (`id`, `sender_userid`, `receiver_userid`, `comment`, `starrating`, `date_time`, `status`, `property_id`) VALUES
(1, 6, 10, 'Good', 5, '2017-10-30 06:36:16', '1', 34);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `membership_type` enum('MONTH','YEAR') NOT NULL,
  `package_type` enum('USER','ADS') NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `delete_status` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `name`, `description`, `amount`, `membership_type`, `package_type`, `image`, `status`, `delete_status`, `datetime`) VALUES
(1, 'Basic', 'Basic Plan', 12.00, 'MONTH', 'USER', 'agrimg_1496913660.jpg', '1', 0, '2017-06-08 14:45:53'),
(3, 'Premium', 'Premium', 12.00, 'MONTH', 'USER', '', '1', 0, '2017-06-08 18:00:59'),
(4, 'Advertisement 1', 'Advertisement 1', 12.00, 'MONTH', 'ADS', '', '1', 0, '2017-06-28 16:49:38'),
(5, 'Advertisement 2', 'Advertisement 2', 120.00, 'MONTH', 'ADS', '', '1', 0, '2017-06-28 16:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `membership_services`
--

CREATE TABLE IF NOT EXISTS `membership_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `allowed_service` enum('NO','ALL','LIMITED') NOT NULL,
  `number_of_access` int(11) NOT NULL,
  `service_type` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `membership_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `delete_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `membership_services`
--

INSERT INTO `membership_services` (`id`, `name`, `description`, `allowed_service`, `number_of_access`, `service_type`, `membership_id`, `datetime`, `status`, `delete_status`) VALUES
(1, 'A', 'A', 'ALL', 2, '1', 1, '2017-06-08 16:52:09', '2', 0),
(2, 'ABC', 'A', 'LIMITED', 5, '1', 1, '2017-06-08 16:58:27', '1', 0),
(3, 'ABC', 'fghjfg', 'ALL', 22, '2', 3, '2017-06-08 18:08:00', '1', 0),
(5, 'test membership service', 'heyyy', 'LIMITED', 12, '4', 1, '2017-08-03 02:42:33', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menulinks`
--

CREATE TABLE IF NOT EXISTS `menulinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `parent_page_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `menuType` enum('Page','Url') NOT NULL,
  `menuUrl` varchar(100) NOT NULL,
  `sort_order` tinyint(1) NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `menulinks`
--

INSERT INTO `menulinks` (`id`, `menu_id`, `title`, `parent_page_id`, `page_id`, `menuType`, `menuUrl`, `sort_order`, `dateCreated`) VALUES
(79, 30, 'Home', 0, 4, 'Page', '', 1, '2016-04-19 05:04:28'),
(83, 30, 'About-Us', 0, 4, 'Page', '', 1, '2016-03-15 09:03:38'),
(84, 30, 'FB', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-15 09:03:55'),
(85, 30, 'Services', 79, 4, 'Page', '', 1, '2016-03-15 09:03:26'),
(86, 30, 'Test', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 10:03:54'),
(87, 30, 'Test', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 10:03:06'),
(88, 30, 'Test', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 10:03:25'),
(89, 30, 'Test', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 10:03:33'),
(90, 30, 'Test', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 10:03:28'),
(91, 30, 'Contact-us', 0, 0, 'Url', 'http//.www.facebook.com', 1, '2016-03-18 11:03:59'),
(92, 31, 'Contact-us', 87, 4, 'Page', '', 1, '2016-03-18 11:03:43'),
(93, 31, 'Services', 0, 4, 'Page', '', 1, '2016-03-18 11:03:27'),
(94, 31, 'sdfsad', 0, 4, 'Page', '', 1, '2016-03-18 11:03:57'),
(95, 31, 'dffgd', 0, 4, 'Page', '', 1, '2016-03-18 11:03:53'),
(96, 31, 'dffgd', 0, 4, 'Page', '', 1, '2016-03-18 11:03:21'),
(97, 31, 'Contact-us', 0, 4, 'Page', '', 1, '2016-03-18 11:03:54'),
(98, 31, 'ContactUS', 0, 4, 'Page', '', 1, '2016-03-29 07:03:23'),
(99, 30, 'TestRE', 0, 4, 'Page', '', 1, '2016-03-21 12:03:09'),
(100, 30, 'TEst', 0, 4, 'Page', '', 1, '2016-03-22 02:03:28'),
(101, 30, 'TEst', 0, 4, 'Page', '', 1, '2016-03-22 02:03:41'),
(102, 30, 'TEst', 0, 0, 'Url', 'dfgsdgssdf', 1, '2016-03-22 02:03:53'),
(103, 30, 'TESTTT', 0, 4, 'Page', '', 1, '2016-03-22 02:03:15'),
(104, 30, 'fgfghdf', 0, 4, 'Page', '', 1, '2016-03-23 10:03:21'),
(105, 30, 'fgfghdf', 0, 0, 'Url', 'http.www.com', 1, '2016-03-23 10:03:47'),
(106, 30, 'fgfghdf', 0, 0, 'Url', 'http.www.google.com', 1, '2016-03-23 10:03:15'),
(107, 30, 'fgfghdf', 0, 0, 'Url', 'https://www.facebook.com', 1, '2016-03-23 10:03:30'),
(109, 30, 'fgfghdf', 0, 4, 'Page', '', 1, '2016-03-23 10:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `mnuId` int(11) NOT NULL AUTO_INCREMENT,
  `mnuName` varchar(250) NOT NULL,
  `menuSlug` varchar(100) NOT NULL,
  `mnuStatus` enum('Active','Inactive') DEFAULT NULL,
  `mnuDateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mnuId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`mnuId`, `mnuName`, `menuSlug`, `mnuStatus`, `mnuDateCreated`) VALUES
(30, 'Header', 'header', 'Active', '2016-04-19 05:45:05'),
(31, 'Footer', 'footer', 'Active', '2016-03-29 07:20:56');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1461241209),
('m160104_073803_create_newsletter_template_table', 1461241211),
('m160104_073815_create_event_template_table', 1461241212),
('m160104_073828_create_event_newsletter_template_table', 1461241212);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_template`
--

CREATE TABLE IF NOT EXISTS `newsletter_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `variable_info` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `newsletter_template`
--

INSERT INTO `newsletter_template` (`id`, `title`, `code`, `message`, `variable_info`, `status`) VALUES
(16, 'Upload Document', 'UPLOADDOCUMENT01', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n	<style type="text/css">\r\n	a {\r\n		color: #f7683b;\r\n	}\r\n	a:hover {\r\n		color: #333333;\r\n	}\r\n	.email_footer a {\r\n		color: #f7683b;\r\n	}\r\n	.email_footer a:hover {\r\n		color: #333333;\r\n	}\r\n	</style>\r\n</head>\r\n<body style="margin:0px;">\r\n<table style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #ffffff; line-height: 20px;" border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td valign="top" width="590">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-size: 13px; color: #585858; padding: 0 5px 0 0;" align="right" height="30">&lt;{time}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="border: solid 1px #F7683B; background: #F7683B; padding: 4px;">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td bgcolor="#fff">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="text-align: center; padding-top: 20px; padding-bottom: 20px; background: #ffffff;" height="68">&lt;{logo}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 14px; color: #ffffff; padding: 12px 10px;" bgcolor="#F7683B"><span style="font-size: 17px; font-weight: 500; color: #fff;">&lt;{subject}&gt;</span></td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 12px;" valign="top" bgcolor="#ffffff">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-size: 15px; font-weight: 500; color: #2c1f14;" height="26">Dear &lt;{username}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 13px; color: #2c1f14; line-height: 18px; padding-bottom: 10px;">&lt;{name}&gt; has uploaded identity document. Click {link} to review the document.</td>\r\n</tr>\r\n<tr>\r\n<td>&lt;{content}&gt;</td>\r\n</tr>\r\n<!--<tr>\r\n                            <td height="5"></td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td align="left"><table width="287" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#2c1f14;">\r\n                                <tr  bgcolor="#2c1f14">\r\n                                  <td colspan="2" style="border-top:#203367 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Password Reset Information</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td width="100" >Username</td>\r\n                                  <td width="270" >Username</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td>Password</td>\r\n                                  <td >Password</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td >Question</td>\r\n                                  <td >What is your Lorem Ipsum ?</td>\r\n                                </tr>\r\n                              </table></td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td height="15"></td>\r\n                          </tr>-->\r\n<tr>\r\n<td height="10">&nbsp;</td>\r\n</tr>\r\n<tr style="color: #585858; font-size: 13px; line-height: 19px;">\r\n<td>Regards,<br /> Customer Support Team<br /> Myguyde</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 15px 0 10px 0; font-size: 13px;" align="center" valign="top" height="37"><a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="Home" href="&lt;{baseurl}&gt;" target="_blank">Home</a> <strong style="margin: 7px 0 0 0; padding: 0 15px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #f7683b;">|</strong> <a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="About Us" href="&lt;{baseurl}&gt;cms/page/about-us" target="_blank">About us</a> <strong style="margin: 7px 0 0 0; padding: 0 15px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #f7683b;">|</strong> <a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="Contact Us" href="&lt;{baseurl}&gt;site/contact-us" target="_blank">Contact Us</a></td>\r\n</tr>\r\n<tr>\r\n<td align="center" valign="top"><a title="Facebook" href="https://www.facebook.com/MyGuyde-148500729011370/" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/fb.png" alt="" /></a> <a title="Twitter" href="https://twitter.com/_Myguyde_" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/tt.png" alt="" /></a> <a title="Instagram" href="https://www.instagram.com/myguyde/" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/insta.png" alt="" /></a> <a title="Linkedin" href="https://www.linkedin.com" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/in.png" alt="" /></a> <a title="Dribbble" href="https://dribbble.com" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/dr.png" alt="" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</body>\r\n</html>', 'Upload document', 'Y'),
(21, 'Feedback notification', 'FEEDBACKNOTIFICATION01', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n	<style type="text/css">\r\n	a {\r\n		color: #f7683b;\r\n	}\r\n	a:hover {\r\n		color: #333333;\r\n	}\r\n	.email_footer a {\r\n		color: #f7683b;\r\n	}\r\n	.email_footer a:hover {\r\n		color: #333333;\r\n	}\r\n	</style>\r\n</head>\r\n<body style="margin:0px;">\r\n<table style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #ffffff; line-height: 20px;" border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td valign="top" width="590">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-size: 13px; color: #585858; padding: 0 5px 0 0;" align="right" height="30">&lt;{time}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="border: solid 1px #F7683B; background: #F7683B; padding: 4px;">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td bgcolor="#fff">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="text-align: center; padding-top: 20px; padding-bottom: 20px; background: #ffffff;" height="68">&lt;{logo}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 14px; color: #ffffff; padding: 12px 10px;" bgcolor="#F7683B"><span style="font-size: 17px; font-weight: 500; color: #fff;">&lt;{subject}&gt;</span></td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 12px;" valign="top" bgcolor="#ffffff">\r\n<table border="0" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-size: 15px; font-weight: 500; color: #2c1f14;" height="26">Dear &lt;{username}&gt;</td>\r\n</tr>\r\n<tr>\r\n<td style="font-size: 13px; color: #2c1f14; line-height: 18px; padding-bottom: 10px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.&nbsp;Please click {link} to verify your email address. Below are login details:</td>\r\n</tr>\r\n<tr>\r\n<td>&lt;{content}&gt;</td>\r\n</tr>\r\n<!--<tr>\r\n                            <td height="5"></td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td align="left"><table width="287" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#2c1f14;">\r\n                                <tr  bgcolor="#2c1f14">\r\n                                  <td colspan="2" style="border-top:#203367 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Password Reset Information</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td width="100" >Username</td>\r\n                                  <td width="270" >Username</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td>Password</td>\r\n                                  <td >Password</td>\r\n                                </tr>\r\n                                <tr  bgcolor="#ffffff">\r\n                                  <td >Question</td>\r\n                                  <td >What is your Lorem Ipsum ?</td>\r\n                                </tr>\r\n                              </table></td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td height="15"></td>\r\n                          </tr>-->\r\n<tr>\r\n<td height="10">&nbsp;</td>\r\n</tr>\r\n<tr style="color: #585858; font-size: 13px; line-height: 19px;">\r\n<td>Regards,<br /> Customer Support Team<br /> Myguyde</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 15px 0 10px 0; font-size: 13px;" align="center" valign="top" height="37"><a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="Home" href="&lt;{baseurl}&gt;" target="_blank">Home</a> <strong style="margin: 7px 0 0 0; padding: 0 15px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #f7683b;">|</strong> <a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="About Us" href="&lt;{baseurl}&gt;cms/page/about-us" target="_blank">About us</a> <strong style="margin: 7px 0 0 0; padding: 0 15px; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #f7683b;">|</strong> <a style="text-decoration: none; font-family: Arial, Helvetica, sans-serif;" title="Contact Us" href="&lt;{baseurl}&gt;site/contact-us" target="_blank">Contact Us</a></td>\r\n</tr>\r\n<tr>\r\n<td align="center" valign="top"><a title="Facebook" href="https://www.facebook.com/MyGuyde-148500729011370/" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/fb.png" alt="" /></a> <a title="Twitter" href="https://twitter.com/_Myguyde_" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/tt.png" alt="" /></a> <a title="Instagram" href="https://www.instagram.com/myguyde/" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/insta.png" alt="" /></a> <a title="Linkedin" href="https://www.linkedin.com" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/in.png" alt="" /></a> <a title="Dribbble" href="https://dribbble.com" target="_blank"><img src="&lt;{baseurl}&gt;frontend/web/themes/myguyde/images/dr.png" alt="" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</body>\r\n</html>', 'feebback notification', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageName` varchar(500) DEFAULT NULL,
  `pageTitle` varchar(500) DEFAULT NULL,
  `pageType` enum('Module','Page') DEFAULT NULL,
  `metaTitle` varchar(500) DEFAULT NULL,
  `metaKeyword` varchar(500) DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `metaDescriptions` varchar(500) DEFAULT NULL,
  `pageContent` text NOT NULL,
  `pageDateCreated` datetime NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `pageName`, `pageTitle`, `pageType`, `metaTitle`, `metaKeyword`, `slug`, `metaDescriptions`, `pageContent`, `pageDateCreated`, `status`, `image`) VALUES
(8, 'Home Page About Us', 'Home Page About Us', 'Module', 'About Us', '', 'Home-Page-About-Us', '', '<h2>About</h2>\r\n<div class="battleDark">BATTLE ROYALE</div>\r\n<p><img src="../../themes/gentelella/js/tiny_mce/plugins/media/about.png" alt="" /></p>\r\n<h4 class="text-uppercase">Proin gravida nibh vel velit auctor aliquet.</h4>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>', '2018-03-21 12:57:32', 'Active', ''),
(9, 'Contact Us Address', 'Contact Us Address', 'Module', '', '', 'Contact-Us-Address', '', '<ul>\r\n<li>4, Ogundana Street<br /> Off Allen Avenue, Ikeja<br /> Lagos, Nigeria</li>\r\n<li>+234 818 811 1501</li>\r\n<li><a href="javascript:void(0)">shaun88suk@hotmail.com</a></li>\r\n</ul>', '2018-03-15 06:58:09', 'Active', NULL),
(10, 'about', 'About Us', 'Page', 'About Us', '', 'about', '', '<section class="innerBanner defineFloat">\r\n<div class="bannerThumb">\r\n<div class="container">\r\n<div class="col-xs-12">\r\n<div class="bannerText">\r\n<h1 class="whiteText upperText">About us</h1>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="colorBg" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12 text-center">\r\n<h2>H2 Standard heading</h2>\r\n</div>\r\n<div class="col-md-12 col-sm-12 col-xs-12">\r\n<div class="hightedBox">\r\n<p class="highlight">P-Highlighted. Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>\r\n</div>\r\n<div class="stdThumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/stdthumb.jpg" alt="" /></div>\r\n<p>Standard Paragraph-01. Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n<div class="button"><a href="javascript:void(0)">button-01</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="blackOuter" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-12 col-sm-12 col-xs-12 text-center">\r\n<h3>H3-Standard Heading</h3>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc1.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Class aptent taciti sociosqu litora</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc2.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Proin gravida nibh vel velit</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section class="contentArea defineFloat listOuter">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12">\r\n<h3>Standard Listing</h3>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n</div>\r\n<div class="twoColumn">\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01 list02">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', '2018-03-21 12:24:28', 'Active', ''),
(11, 'prizes', 'Prizes', 'Page', 'Prizes', '', 'prizes', '', '<section class="innerBanner defineFloat">\r\n<div class="bannerThumb">\r\n<div class="container">\r\n<div class="col-xs-12">\r\n<div class="bannerText">\r\n<h1 class="whiteText upperText">Prizes</h1>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="colorBg" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12 text-center">\r\n<h2>H2 Standard heading</h2>\r\n</div>\r\n<div class="col-md-12 col-sm-12 col-xs-12">\r\n<div class="hightedBox">\r\n<p class="highlight">P-Highlighted. Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>\r\n</div>\r\n<div class="stdThumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/stdthumb.jpg" alt="" /></div>\r\n<p>Standard Paragraph-01. Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n<div class="button"><a href="javascript:void(0)">button-01</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="blackOuter" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-12 col-sm-12 col-xs-12 text-center">\r\n<h3>H3-Standard Heading</h3>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc1.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Class aptent taciti sociosqu litora</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc2.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Proin gravida nibh vel velit</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section class="contentArea defineFloat listOuter">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12">\r\n<h3>Standard Listing</h3>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n</div>\r\n<div class="twoColumn">\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01 list02">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', '2018-03-21 12:27:07', 'Active', ''),
(12, 'vote', 'Votes', 'Page', 'vote', '', 'vote', '', '<section class="innerBanner defineFloat">\r\n<div class="bannerThumb">\r\n<div class="container">\r\n<div class="col-xs-12">\r\n<div class="bannerText">\r\n<h1 class="whiteText upperText">Vote</h1>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="colorBg" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12 text-center">\r\n<h2>H2 Standard heading</h2>\r\n</div>\r\n<div class="col-md-12 col-sm-12 col-xs-12">\r\n<div class="hightedBox">\r\n<p class="highlight">P-Highlighted. Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>\r\n</div>\r\n<div class="stdThumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/stdthumb.jpg" alt="" /></div>\r\n<p>Standard Paragraph-01. Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n<div class="button"><a href="javascript:void(0)">button-01</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section id="blackOuter" class="contentArea defineFloat">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-12 col-sm-12 col-xs-12 text-center">\r\n<h3>H3-Standard Heading</h3>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc1.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Class aptent taciti sociosqu litora</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-6 widthBlk">\r\n<div class="thumb"><img src="../../themes/gentelella/js/tiny_mce/plugins/media/desc2.jpg" alt="" /></div>\r\n<div class="detail"><span class="whiteText">Proin gravida nibh vel velit</span>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.</p>\r\n<div class="button"><a href="javascript:void(0)">button-02</a></div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<section class="contentArea defineFloat listOuter">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-xs-12">\r\n<h3>Standard Listing</h3>\r\n<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n</div>\r\n<div class="twoColumn">\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n<div class="col-md-6 col-sm-6 col-xs-12">\r\n<div class="list01 list02">\r\n<ul>\r\n<li><a href="javascript:void(0)">Nam nec tellus a odio tincidunt auctor a ornare odio</a></li>\r\n<li><a href="javascript:void(0)">Sed non mauris vitae erat consequat auctor eu in elit</a></li>\r\n<li><a href="javascript:void(0)">Class aptent taciti sociosqu ad litora torquent per conubia</a></li>\r\n<li><a href="javascript:void(0)">Mauris in erat justo ullam ac urna eu felis dapibus</a></li>\r\n<li><a href="javascript:void(0)">Sed non neque elit roin condimentum fermentum nunc</a></li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', '2018-03-21 12:27:44', 'Active', NULL),
(13, 'Contact us Bottom Map', 'Contact us Bottom Map', 'Module', '', '', 'Contact-us-Bottom-Map', '', '<div><iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.3715867706865!2d3.3516712153188593!3d6.6006587064024576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b9230dc8fc41f%3A0xe76ed5f7034e85a5!2sTorge+Events+%26+Decor!5e0!3m2!1sen!2sin!4v1507721895968" width="100%" height="322" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>', '2018-03-23 09:59:28', 'Active', NULL),
(14, 'Footer Contact Info', 'Footer Contact Info', 'Module', '', '', 'Footer-Contact-Info', '', '<p><em class="fa fa-phone">&nbsp;</em>+234 818 811 1501</p>\r\n<p><em class="fa fa-commenting">&nbsp;</em>+234 818 811 1501</p>\r\n<p><em class="fa fa-envelope-o">&nbsp;</em><a href="mailto:shaun88suk@hotmail.com">shaun88suk@hotmail.com</a></p>', '2018-03-23 11:18:20', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `documents` varchar(255) NOT NULL,
  `photos` varchar(255) NOT NULL,
  `copy_of_deed` varchar(255) NOT NULL,
  `copy_of_licenses` varchar(255) NOT NULL,
  `copy_of_power_of_attorney` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1','2') NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `property_type`, `user_id`, `title`, `price`, `documents`, `photos`, `copy_of_deed`, `copy_of_licenses`, `copy_of_power_of_attorney`, `description`, `status`, `datetime`) VALUES
(1, 2, 6, 'Partner 01', 200.00, 'document', 'test', 'test', 'test', '1', 'It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '2017-08-18 12:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE IF NOT EXISTS `payment_transaction` (
  `payment_transaction_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `currency` varchar(100) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `payment_status` enum('Paid','Pending','Failed') NOT NULL,
  `delete_status` int(11) NOT NULL,
  PRIMARY KEY (`payment_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`payment_transaction_id`, `user_id`, `booking_id`, `amount`, `trans_id`, `trans_date`, `currency`, `payment_type`, `payment_status`, `delete_status`) VALUES
(11, 6, 9, 103.00, '31D3213619789353T', '2017-10-31 11:55:28', 'EUR', 'instant', 'Paid', 0),
(12, 11, 10, 103.00, '0LA33823PG5992830', '2017-10-31 11:55:27', 'EUR', 'instant', 'Paid', 0),
(13, 10, 10, 103.00, '0LA33823PG5992830', '2017-10-31 11:55:25', 'EUR', 'instant', 'Paid', 0),
(14, 6, 11, 103.00, '2RD653225E193390N', '2017-10-31 11:55:24', 'EUR', 'instant', 'Paid', 0),
(15, 11, 12, 103.00, '4GY30210KR9927344', '2017-10-31 11:55:23', 'EUR', 'instant', 'Paid', 0),
(16, 10, 13, 61.80, '71X49039412527915', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(17, 6, 14, 103.00, '4P9697220D931035R', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(18, 11, 15, 103.00, '4NN44824GX473024W', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(19, 11, 16, 15.45, '9XP90934J8056664P', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(20, 10, 17, 108.15, '4N795292L2873082N', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(21, 10, 18, 123.60, '7K685843S3269392L', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(22, 6, 19, 92.70, '3VV19479PC998500B', '2017-10-30 07:15:39', 'EUR', 'instant', 'Paid', 0),
(23, 6, 20, 370.80, '3E948275VF718151M', '2017-08-18 12:52:35', 'EUR', 'instant', 'Paid', 0);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `reference_number` int(11) NOT NULL,
  `property_type` int(11) NOT NULL,
  `property_for` enum('1','2','3','4','5','6','7') NOT NULL,
  `country` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `build_year` varchar(40) NOT NULL,
  `area` float NOT NULL,
  `rooms` int(11) NOT NULL,
  `floors` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `specification` text NOT NULL,
  `description` text NOT NULL,
  `property_right` enum('1','2','3') NOT NULL COMMENT '1=public,2=private,3=Ministry of Housing',
  `added_by` enum('1','2') NOT NULL,
  `user_id` int(11) NOT NULL,
  `auction` enum('0','1') NOT NULL,
  `expiry_date` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `delete_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `reference_number`, `property_type`, `property_for`, `country`, `region`, `city`, `address`, `latitude`, `longitude`, `build_year`, `area`, `rooms`, `floors`, `price`, `specification`, `description`, `property_right`, `added_by`, `user_id`, `auction`, `expiry_date`, `updated_at`, `created_at`, `status`, `delete_status`) VALUES
(33, 'testAbc', 293623, 17, '2', 101, 2, 7, '', '', '', '2016', 56, 4, 4, 4000.00, 'specification', '', '2', '2', 10, '1', '2017-08-17', '2017-07-17 17:11:09', '2017-07-17 11:41:09', '1', 0),
(35, 'Testing PRerasdf', 782360, 4, '5', 101, 2, 18, '', '', '', '2013', 2300, 3, 3, 2000.00, 'zfgsadf sadfsafdsfdsdafasf', '', '1', '2', 11, '0', '2017-08-27', '2017-07-27 06:35:27', '2017-07-27 06:35:27', '1', 0),
(36, 'XYZ', 722984, 2, '1', 101, 2, 13, '#567889 ', '', '', '2006', 1234, 12, 4, 12000.00, 'The building is new renovated.', '', '1', '2', 6, '1', '2017-08-31', '2017-07-31 08:31:59', '2017-07-31 00:20:31', '1', 0),
(37, 'Test property', 585395, 2, '1', 101, 3, 31, 'abc street ', '', '', '2000', 200, 2, 2, 1200000.00, 'Hey this is test specification !!', '', '2', '2', 10, '0', '2017-09-03', '2017-08-16 05:54:41', '2017-08-03 01:07:17', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_documents`
--

CREATE TABLE IF NOT EXISTS `property_documents` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `type` enum('1','2','3','4','5') NOT NULL COMMENT '1=Document,2=Image,3=Video,4=360 Video,5=3D Video',
  `datetime` datetime NOT NULL,
  `property_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

--
-- Dumping data for table `property_documents`
--

INSERT INTO `property_documents` (`name`, `id`, `description`, `type`, `datetime`, `property_id`) VALUES
('agarid_11500291669.doc', 78, '', '1', '2017-07-17 17:11:09', 33),
('agarid_11501155327.doc', 180, '', '1', '2017-07-27 06:35:27', 35),
('agarip_11501155327.jpg', 181, '', '2', '2017-07-27 06:35:27', 35),
('agarid_11501478431.txt', 182, '', '1', '2017-07-31 00:20:31', 36),
('agarid_21501478431.doc', 183, '', '1', '2017-07-31 00:20:31', 36),
('agarip_11501478431.jpg', 184, '', '2', '2017-07-31 00:20:31', 36),
('agarip_21501478431.jpg', 185, '', '2', '2017-07-31 00:20:31', 36),
('agarip_11501507919.jpg', 186, '', '2', '2017-07-31 08:31:59', 36),
('agarip_21501507919.jpg', 187, '', '2', '2017-07-31 08:31:59', 36),
('agarid_11501740437.docx', 188, '', '1', '2017-08-03 01:07:17', 37),
('agarip_11501740437.jpg', 189, '', '2', '2017-08-03 01:07:17', 37),
('agarip_21501740437.jpg', 190, '', '2', '2017-08-03 01:07:17', 37),
('agarip_31501740437.jpg', 191, '', '2', '2017-08-03 01:07:17', 37),
('agarip_41501740437.jpg', 192, '', '2', '2017-08-03 01:07:17', 37),
('agarivv_1501740437.mp4', 194, '', '4', '2017-08-03 01:07:17', 37),
('agaridv_1501740437.mp4', 195, '', '5', '2017-08-03 01:07:17', 37);

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE IF NOT EXISTS `property_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `delete_status` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`id`, `name`, `description`, `image`, `status`, `delete_status`, `datetime`) VALUES
(2, 'Flats', 'Flats', '', '1', 0, '2017-06-13 09:07:00'),
(3, 'Villas', 'Villas', '', '1', 0, '2017-06-13 09:07:00'),
(4, 'Duplexes', 'Duplexes', '', '1', 0, '2017-06-13 09:07:00'),
(5, 'Single Floors', 'Single Floors', '', '1', 0, '2017-06-13 09:07:00'),
(6, 'Compounds', 'Compounds', '', '1', 0, '2017-06-13 09:07:00'),
(7, 'Furnished Flats', 'Furnished Flats', '', '1', 0, '2017-06-13 09:07:00'),
(8, 'Hotels', 'Hotels', '', '1', 0, '2017-06-13 09:07:00'),
(9, 'Offices', 'Offices', '', '1', 0, '2017-06-13 09:07:01'),
(10, 'Buildings', 'Buildings', '', '1', 0, '2017-06-13 09:07:01'),
(11, 'Shops', 'Shops', '', '1', 0, '2017-06-13 09:07:01'),
(12, 'Showrooms', 'Showrooms', '', '1', 0, '2017-06-13 09:07:01'),
(13, 'Restaurants', 'Restaurants', '', '1', 0, '2017-06-13 09:07:01'),
(14, 'Workshops', 'Workshops', '', '1', 0, '2017-06-13 09:07:01'),
(15, 'Halls', 'Halls', '', '1', 0, '2017-06-13 09:07:01'),
(16, 'Stores', 'Stores', '', '1', 0, '2017-06-13 09:07:01'),
(17, 'Schools', 'Schools', '', '1', 0, '2017-06-13 09:07:01'),
(18, 'Sport Gyms', 'Sport Gyms', '', '1', 0, '2017-06-13 09:07:01'),
(19, 'Hospitals', 'Hospitals', '', '1', 0, '2017-06-13 09:07:01'),
(20, 'Farms', 'Farms', '', '1', 0, '2017-06-13 09:07:01'),
(21, 'Stables', 'Stables', '', '1', 0, '2017-06-13 09:07:01'),
(22, 'Chalets', 'Chalets', '', '1', 0, '2017-06-13 09:07:01'),
(23, 'Factories', 'Factories', '', '1', 0, '2017-06-13 09:07:01'),
(24, 'Land', 'Land', '', '1', 0, '2017-06-13 09:07:01'),
(25, 'Land (industrial)', 'Land (industrial)', '', '1', 0, '2017-06-13 09:07:01'),
(26, 'Land (agricultural)', 'Land (agricultural)', '', '1', 0, '2017-06-13 09:07:01'),
(27, 'Storage', 'Storage', '', '1', 0, '2017-06-13 09:07:02'),
(28, 'Garages', 'Garages', '', '1', 0, '2017-06-13 09:07:02'),
(29, 'Time Shares', 'Time Shares', '', '1', 0, '2017-06-13 09:07:02'),
(30, 'Other Objects', 'Other Objects', '', '1', 0, '2017-06-13 09:07:02'),
(32, 'Flowers', 'Test Description.', 'news_1501740898.jpg', '1', 0, '2017-08-03 01:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_type` enum('banner','video') DEFAULT 'banner' COMMENT 'banner=show banner on homepage, video=show video section on homepage and hide banners',
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_type`, `video`) VALUES
(1, 'banner', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`) VALUES
(1, 'Andaman and Nicobar Islands', 101),
(2, 'Andhra Pradesh', 101),
(3, 'Arunachal Pradesh', 101),
(4, 'Assam', 101),
(5, 'Bihar', 101),
(6, 'Chandigarh', 101),
(7, 'Chhattisgarh', 101),
(8, 'Dadra and Nagar Haveli', 101),
(9, 'Daman and Diu', 101),
(10, 'Delhi', 101),
(11, 'Goa', 101),
(12, 'Gujarat', 101),
(13, 'Haryana', 101),
(14, 'Himachal Pradesh', 101),
(15, 'Jammu and Kashmir', 101),
(16, 'Jharkhand', 101),
(17, 'Karnataka', 101),
(18, 'Kenmore', 101),
(19, 'Kerala', 101),
(20, 'Lakshadweep', 101),
(21, 'Madhya Pradesh', 101),
(22, 'Maharashtra', 101);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_description` text NOT NULL,
  `status` enum('1','2') NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_comments`
--

INSERT INTO `tbl_comments` (`comment_id`, `user_id`, `post_id`, `comment_description`, `status`, `date_created`, `date_updated`) VALUES
(1, 14, 8, 'This is testing comment.', '1', '2018-03-21 17:26:23', '2018-03-21 17:26:23'),
(2, 14, 9, 'Testing again', '1', '2018-03-21 17:27:50', '2018-03-21 17:27:50'),
(3, 14, 9, 'Testing again 123', '1', '2018-03-21 17:28:17', '2018-03-21 17:28:17'),
(4, 14, 9, 'Last Testing message', '1', '2018-03-21 17:30:02', '2018-03-21 17:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contestant`
--

CREATE TABLE IF NOT EXISTS `tbl_contestant` (
  `contestant_id` int(11) NOT NULL AUTO_INCREMENT,
  `contestant_name` varchar(255) NOT NULL,
  `contestant_description` text NOT NULL,
  `contestant_youtubelink` text NOT NULL,
  `contestant_votes` int(11) NOT NULL,
  `result` enum('0','1','2','3') NOT NULL COMMENT '0=>participant,1=>winner,2=>1st runner up,3=>2nd runner up',
  `status` enum('0','1') NOT NULL,
  `season_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`contestant_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_contestant`
--

INSERT INTO `tbl_contestant` (`contestant_id`, `contestant_name`, `contestant_description`, `contestant_youtubelink`, `contestant_votes`, `result`, `status`, `season_id`, `date_created`, `date_updated`) VALUES
(1, 'Peter Okoye', 'Vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam ', 'https://www.youtube.com/watch?v=9xwazD5SyVg,https://www.youtube.com/watch?v=ScMzIvxBSi4,https://www.youtube.com/watch?v=EkhNsxw9DyI', 702, '0', '1', 1, '2018-03-12 15:26:45', '2018-03-23 13:35:34'),
(2, 'Denise Brooks', 'Auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.sd', 'asdsa,https://www.youtube.com/watch?v=EkhNsxw9DyI', 560, '0', '1', 1, '2018-03-12 15:27:52', '2018-03-23 13:35:34'),
(3, 'Ernest Diaz', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.', '', 233, '0', '1', 1, '2018-03-12 15:31:06', '2018-03-23 13:35:34'),
(4, 'Henry Shaw ', 'Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. ', '', 2500, '0', '1', 2, '2018-03-12 15:31:57', '2018-03-23 13:32:06'),
(5, 'Korede Bello', 'Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.', '', 150, '0', '1', 1, '2018-03-20 15:17:19', '2018-03-23 13:35:34'),
(6, 'Bello Korede ', 'Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulput', '', 5000, '1', '1', 4, '2016-03-21 10:27:55', '2018-03-21 12:36:40'),
(7, 'Eorede Rodricks', 'Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulput', '', 3500, '2', '1', 4, '2016-03-21 10:28:29', '2018-03-21 12:39:52'),
(8, 'Hobret Juliana', 'Lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulput', '', 3250, '3', '1', 4, '2016-03-21 10:29:03', '2018-03-21 12:40:22'),
(9, 'Roman D', 'Nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulput', '', 3000, '0', '1', 4, '2016-03-21 10:29:30', '2018-03-21 10:41:37'),
(10, 'Mathew Johnason', 'Consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulput', '', 2560, '0', '1', 4, '2016-03-21 10:30:05', '2018-03-21 12:35:46'),
(11, 'Johnson Remo', 'Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 7841, '1', '1', 5, '2017-03-21 10:48:06', '0000-00-00 00:00:00'),
(12, 'Nicloas', 'Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 6852, '2', '1', 5, '2017-03-21 10:48:45', '2018-03-21 10:49:17'),
(13, 'Gibson Louis', 'Sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 4589, '3', '1', 5, '2017-03-21 10:50:02', '0000-00-00 00:00:00'),
(14, 'Philip Shaw', 'Elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 3580, '0', '1', 5, '2017-03-21 10:50:38', '2018-03-21 12:24:52'),
(15, 'Miller', 'Psum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 3200, '0', '1', 5, '2017-03-21 10:51:09', '0000-00-00 00:00:00'),
(16, 'Walter Lopz', 'Vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio ', '', 2500, '0', '1', 5, '2017-03-21 10:51:42', '0000-00-00 00:00:00'),
(17, 'Roni JAckson', 'Dummy', '', 4545, '0', '1', 1, '2018-03-21 13:48:01', '2018-03-23 13:35:34'),
(18, 'Cena', 'Dummy Description', '', 1500, '0', '1', 2, '2018-03-22 15:04:40', '2018-03-23 13:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contestant_detail`
--

CREATE TABLE IF NOT EXISTS `tbl_contestant_detail` (
  `contestant_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `contestant_id` int(11) NOT NULL,
  `contestant_image` varchar(255) NOT NULL,
  PRIMARY KEY (`contestant_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tbl_contestant_detail`
--

INSERT INTO `tbl_contestant_detail` (`contestant_detail_id`, `contestant_id`, `contestant_image`) VALUES
(1, 1, 'agarid_11520848605.jpg'),
(2, 2, 'agarid_11520848672.jpg'),
(3, 2, 'agarid_11520848772.jpg'),
(4, 3, 'agarid_11520849054.jpg'),
(5, 4, 'agarid_11520849350.jpg'),
(6, 5, 'agarid_11521539310.jpg'),
(7, 2, 'agarid_11521542905.jpg'),
(9, 9, 'agarid_11521609097.jpg'),
(13, 11, 'agarid_11521609486.jpg'),
(14, 12, 'agarid_11521609557.jpg'),
(15, 13, 'agarid_11521609602.jpeg'),
(17, 15, 'agarid_11521609669.jpg'),
(18, 16, 'agarid_11521609702.jpg'),
(19, 14, 'agarid_11521615292.jpg'),
(20, 10, 'agarid_11521615946.jpg'),
(21, 6, 'agarid_11521616000.jpg'),
(22, 7, 'agarid_11521616192.jpg'),
(23, 8, 'agarid_11521616222.jpg'),
(24, 18, 'agarid_11521711280.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_category`
--

CREATE TABLE IF NOT EXISTS `tbl_document_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_document_category`
--

INSERT INTO `tbl_document_category` (`id`, `name`, `description`, `datetime`, `status`) VALUES
(1, 'A', 'just for testing purpose', '2017-06-22 00:00:00', '1'),
(2, 'B', 'just for testing purpose', '2017-06-23 00:00:00', '1'),
(3, 'C', 'just for testing purpose', '2017-07-31 08:00:26', '1'),
(4, 'D', 'just for testing purpose', '2017-07-31 08:01:32', '1'),
(5, 'AAAA kk', 'AA', '2017-08-03 02:58:43', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_upload`
--

CREATE TABLE IF NOT EXISTS `tbl_document_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `document_type` char(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_document_upload`
--

INSERT INTO `tbl_document_upload` (`id`, `cat_id`, `title`, `filename`, `description`, `document_type`, `datetime`, `status`) VALUES
(3, 2, 'Test Document 5', 'document_1500980565.doc', 'Test Document 5', 'doc', '2017-06-01 16:53:21', '1'),
(4, 1, 'Test Document 4', 'document_1496316739.docx', 'Test Document 4', 'docx', '2017-06-01 16:53:44', '1'),
(5, 1, 'Test Document 3', 'document_1496395272.jpg', 'Test Document 3', 'jpg', '2017-06-01 17:01:11', '1'),
(8, 3, 'Test Document 1', 'document_1501506146.doc', 'Test Document 1', 'doc', '2017-07-31 08:02:26', '1'),
(11, 2, 'Test Document 1', 'document_1502881685.docx', 'Test Document 1', 'docx', '2017-08-16 06:08:05', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE IF NOT EXISTS `tbl_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `user_id` int(11) NOT NULL,
  `user_type` enum('1','2') NOT NULL COMMENT '1=Admin,2=User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`id`, `name`, `description`, `datetime`, `status`, `user_id`, `user_type`) VALUES
(5, 'Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum', '<p>Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>', '2018-01-10 16:34:07', '1', 0, '1'),
(6, 'Proin gravida nibh vel velit auctor aliquet. ', '<p>Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>', '2018-01-10 16:46:18', '1', 0, '1'),
(7, 'lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit ', '<p>Vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>\r\n<p>Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>', '2018-01-10 16:47:33', '1', 0, '1'),
(8, 'Nisi elit consequat ipsum, nec sagittis sem nibh id elit ', '<p>Aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. </p>\r\n<p>Aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. </p>', '2018-01-10 16:48:14', '1', 0, '1'),
(9, 'Sagittis sem nibh id elit ', '<p>Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n<p>Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>', '2018-01-10 16:48:54', '1', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_images`
--

CREATE TABLE IF NOT EXISTS `tbl_group_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `season_id` int(11) NOT NULL,
  `group_image` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_group_images`
--

INSERT INTO `tbl_group_images` (`image_id`, `season_id`, `group_image`, `date_created`) VALUES
(3, 6, 'seasonGroup_11521625343.jpg', '2018-03-21 15:12:23'),
(4, 6, 'seasonGroup_21521625343.jpg', '2018-03-21 15:12:23'),
(5, 4, 'seasonGroup_11521625446.jpg', '2018-03-21 15:14:06'),
(6, 4, 'seasonGroup_21521625446.jpg', '2018-03-21 15:14:06'),
(7, 5, 'seasonGroup_11521625453.jpg', '2018-03-21 15:14:13'),
(9, 2, 'seasonGroup_11521625673.jpg', '2018-03-21 15:17:53'),
(10, 2, 'seasonGroup_21521625673.jpg', '2018-03-21 15:17:53'),
(11, 4, 'seasonGroup_11521626222.png', '2018-03-21 15:27:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_homebannervideo`
--

CREATE TABLE IF NOT EXISTS `tbl_homebannervideo` (
  `video_banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(255) NOT NULL,
  `youtubevideolink` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`video_banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_homebannervideo`
--

INSERT INTO `tbl_homebannervideo` (`video_banner_id`, `video_name`, `youtubevideolink`, `status`, `date_created`) VALUES
(3, 'Hip Hop is an Evolving Culture in Nigeria', 'https://www.youtube.com/watch?v=55j-qFbjDZM', '1', '2018-03-15 11:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_homepagevideo`
--

CREATE TABLE IF NOT EXISTS `tbl_homepagevideo` (
  `home_video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(255) NOT NULL,
  `youtubevideolink` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`home_video_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_homepagevideo`
--

INSERT INTO `tbl_homepagevideo` (`home_video_id`, `video_name`, `youtubevideolink`, `status`, `date_created`, `date_updated`) VALUES
(1, 'D Mode King of Benin', 'https://www.youtube.com/watch?v=OccUNl4EHSM', '1', '2018-03-12 19:05:58', '2018-03-12 19:05:58'),
(2, 'Soldiers with Abuja', 'https://www.youtube.com/watch?v=EiRcgmQ8rnQ', '1', '2018-03-12 19:06:51', '2018-03-12 19:19:42'),
(3, 'Ways rules Jos', 'https://www.youtube.com/watch?v=yAoLSRbwxL8', '1', '2018-03-13 13:47:44', '2018-03-13 15:20:44'),
(4, 'D Mode King of Benin12', 'https://www.youtube.com/watch?v=EkhNsxw9DyI', '1', '2018-03-13 13:47:55', '2018-03-13 15:20:33'),
(5, 'Soldiers with Abuja32', 'https://www.youtube.com/watch?v=ScMzIvxBSi4', '1', '2018-03-13 13:48:04', '2018-03-13 15:20:22'),
(6, 'Ways rules Jos41', 'https://www.youtube.com/watch?v=9xwazD5SyVg', '1', '2018-03-13 13:48:12', '2018-03-13 15:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_main_cities`
--

CREATE TABLE IF NOT EXISTS `tbl_main_cities` (
  `main_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `main_city_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`main_city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_main_cities`
--

INSERT INTO `tbl_main_cities` (`main_city_id`, `main_city_name`, `date_created`) VALUES
(1, 'Lagos', '2018-03-01 00:00:00'),
(2, 'Ibadan', '2018-03-02 00:00:00'),
(3, 'Benin City', '2018-03-03 00:00:00'),
(4, 'Port Harcourt', '2018-03-04 00:00:00'),
(6, 'Jos', '2018-03-05 00:00:00'),
(7, 'Abuja', '2018-03-06 00:00:00'),
(8, 'Enugu', '2018-03-07 00:00:00'),
(9, 'Calabar', '2018-03-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`id`, `name`, `description`, `image`, `datetime`, `status`) VALUES
(5, 'Invetion of Technology', 'It is evident that how life has changed since technology has been invented in the human life. When we think about the technology, the first thing comes in mind that is the computer.', 'news_1499779568.png', '2017-07-11 18:56:08', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE IF NOT EXISTS `tbl_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `youtubevideolink` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `user_id` int(11) NOT NULL,
  `user_type` enum('1','2') NOT NULL COMMENT '1=Admin,2=User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbl_posts`
--

INSERT INTO `tbl_posts` (`id`, `name`, `description`, `image`, `youtubevideolink`, `datecreated`, `dateupdated`, `status`, `user_id`, `user_type`) VALUES
(1, 'Bibendum auctor, nisi elit consequat', 'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.', 'right-img-4_1520926062.png', '', '2018-01-15 11:55:24', '2018-03-13 12:57:42', '1', 0, '1'),
(6, 'Lorem quis bibendum auctor, nisi elit consequat', ' Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio', 'right-img-1_1520926029.png', '', '2018-01-15 15:44:29', '2018-03-13 12:57:09', '1', 0, '1'),
(7, 'Aenean sollicitudin lorem quis bibendum auctor, nisi elit consequat ipsum.', '<p>Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n\r\n<p>Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim. </p>', 'bigthumb_1520925961.jpg', 'https://www.youtube.com/watch?v=WGuFofNF1Pk', '2018-03-08 10:10:59', '2018-03-13 18:32:45', '1', 0, '1'),
(8, 'Sollicitudin lorem quis bibendum', 'Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam', 'postthumb2_1520946174.jpg', '', '2018-03-13 12:58:48', '2018-03-13 18:32:54', '1', 0, '1'),
(9, 'Nisi elit consequat ips', ' Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim. ', 'postthumb3_1520946144.jpg', '', '2018-03-13 12:58:53', '2018-03-13 18:32:24', '1', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_real_estate_market`
--

CREATE TABLE IF NOT EXISTS `tbl_real_estate_market` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `document_type` char(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `delete_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_real_estate_market`
--

INSERT INTO `tbl_real_estate_market` (`id`, `cat_id`, `title`, `filename`, `description`, `document_type`, `datetime`, `status`, `delete_status`) VALUES
(9, 1, 'Real Estate Testing -2', 'document_1500980620.jpg', 'Real Estate Testing -2', 'jpg', '2017-06-27 15:56:33', '1', 1),
(11, 2, 'Real Estate Testing -1', 'document_1501492781.doc', 'It is dummy content just for testing..!!', 'doc', '2017-07-31 04:19:41', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seasons`
--

CREATE TABLE IF NOT EXISTS `tbl_seasons` (
  `season_id` int(11) NOT NULL AUTO_INCREMENT,
  `season_name` varchar(255) NOT NULL,
  `season_year` int(11) NOT NULL,
  `seasonMainCity_Id` int(11) NOT NULL,
  `seasonSubCity_Id` int(11) NOT NULL,
  `season_description` text NOT NULL,
  `season_venue` varchar(255) NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0=>inactive,1=>open,2=>close',
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`season_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_seasons`
--

INSERT INTO `tbl_seasons` (`season_id`, `season_name`, `season_year`, `seasonMainCity_Id`, `seasonSubCity_Id`, `season_description`, `season_venue`, `status`, `date_created`) VALUES
(1, 'Lagos Street Talent Show', 2018, 1, 1, 'Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.\r\n\r\nSed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.', '<ul>\r\n<li>Smooth Promotions Nigeria Limited.<br /> 4, Ogundana Street<br /> Off Allen Avenue, Ikeja<br /> Lagos, Nigeria</li>\r\n<li>+234 818 811 1501</li>\r\n</ul>', '1', '2017-03-08 18:16:53'),
(2, 'Calabar Kids Champion', 2018, 9, 0, 'Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.\r\n\r\nSed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.', '<ul>\r\n<li>Promotions Nigeria Limited.<br /> 78, Street<br /> Off Avenue, Ikeja<br /> Calabar, Nigeria</li>\r\n<li>+234 818 811 9999</li>\r\n</ul>', '1', '2018-03-08 18:17:40'),
(3, 'Festc Voice Hunt', 2018, 1, 2, '<p>Nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue.</p>\r\n\r\n<p>Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.</p>', '<ul>\r\n<li>Smooth Limited.<br /> Ogundana Street<br /> Avenue, Ikeja<br /> Festc, Nigeria</li>\r\n<li>+456 818 811 1501</li>\r\n</ul>', '1', '2018-03-13 17:01:24'),
(4, 'Talent Hunt Show for Kids ', 2016, 4, 0, 'Kids Hunt talent show', '<ul>\r\n<li>New Auditorium Nigeria Limited.<br /> 70 West Street Lane,<br />Avenue Tower,<br /> Port Harcort, Nigeria</li>\r\n<li>+234 818 811 1501</li>\r\n</ul>', '2', '2016-03-21 10:26:47'),
(5, 'Talent Hunt Show for Kids Season2 ', 2017, 4, 0, 'Kids Hunt talent show Season2', '<ul>\r\n<li>New Auditorium Nigeria Limited.<br /> 70 West Street Lane,<br />Avenue Tower,<br /> Port Harcort, Nigeria</li>\r\n<li>+234 818 811 1501</li>\r\n</ul>', '2', '2017-02-05 10:26:47'),
(6, 'Talent Hunt Show for Kids Season3 ', 2018, 4, 0, 'Kids Hunt talent show Season3', '<ul>\r\n<li>New Auditorium Nigeria Limited.<br /> 70 West Street Lane,<br />Avenue Tower,<br /> Port Harcort, Nigeria</li>\r\n<li>+234 818 811 1501</li>\r\n</ul>', '1', '2018-02-05 10:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE IF NOT EXISTS `tbl_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`id`, `name`, `description`, `image`, `datetime`, `status`) VALUES
(4, 'Infographics & Brochures', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', 'agrimg_1500980581.jpg', '2017-06-01 18:49:56', '1'),
(5, 'Building Renovation', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', '', '2017-06-01 18:50:24', '1'),
(6, 'Home Moving', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', '', '2017-06-06 15:12:15', '1'),
(8, 'Home Cleaning', 'This will be analysed by looking at how convenience and economic benefits have made them the most preferred choice of customers.', '', '2017-07-12 14:46:10', '1'),
(10, 'Property Advertising', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', 'agrimg_1501569969.jpg', '2017-08-01 01:46:09', '1'),
(11, 'Property Valuation', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', 'agrimg_1501570022.jpg', '2017-08-01 01:47:02', '1'),
(12, 'Feasibility Studies', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', 'agrimg_1501570055.jpg', '2017-08-01 01:47:35', '1'),
(13, 'Property Management ', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', 'agrimg_1501570154.jpg', '2017-08-01 01:49:14', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_cities`
--

CREATE TABLE IF NOT EXISTS `tbl_sub_cities` (
  `sub_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_city_name` varchar(255) NOT NULL,
  `main_city_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`sub_city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_sub_cities`
--

INSERT INTO `tbl_sub_cities` (`sub_city_id`, `sub_city_name`, `main_city_id`, `date_created`) VALUES
(1, 'Ikeja', 1, '2018-03-09 00:00:00'),
(2, 'Festac', 1, '2018-03-09 02:00:00'),
(3, 'Lagos island', 1, '2018-03-10 00:00:00'),
(4, 'Surulere', 1, '2018-03-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonial`
--

CREATE TABLE IF NOT EXISTS `tbl_testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=Active,2=Inactive',
  `user_id` int(11) NOT NULL,
  `user_type` enum('1','2') NOT NULL COMMENT '1=Admin,2=User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_testimonial`
--

INSERT INTO `tbl_testimonial` (`id`, `name`, `description`, `image`, `datetime`, `status`, `user_id`, `user_type`) VALUES
(1, 'Testimonials 2', 'its test description jus for testings..!!', 'agrimg_1500980604.jpg', '2017-06-02 12:31:29', '1', 0, '1'),
(2, 'Testimonial 1', 'its dummy description just for testing..!!', '', '2017-06-02 13:27:05', '1', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_types`
--

CREATE TABLE IF NOT EXISTS `tbl_user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_user_types`
--

INSERT INTO `tbl_user_types` (`id`, `name`, `description`, `datetime`, `status`) VALUES
(1, 'Construction Company', 'Real estate developers', '2017-06-06 00:00:00', '1'),
(2, 'Real estate developers', 'Real estate developers', '2017-06-06 00:00:00', '1'),
(3, 'Agents', 'Agents', '2017-06-06 00:00:00', '1'),
(4, 'Engineering Consulting', 'Engineering Consulting', '2017-06-06 00:00:00', '1'),
(5, 'Simple user', 'Simple user', '2017-06-06 00:00:00', '1'),
(7, 'lllll', 'khlkhl hoiuoi iupopjpojopj ', '2017-08-16 05:33:40', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_uploaded_files`
--

CREATE TABLE IF NOT EXISTS `tmp_uploaded_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `referenace_number` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tmp_uploaded_files`
--

INSERT INTO `tmp_uploaded_files` (`id`, `name`, `referenace_number`, `datetime`) VALUES
(1, '01504006510banner1.jpg', '1122', '2017-08-29 11:35:10'),
(2, '01504006522c.txt', '1122', '2017-08-29 11:35:22'),
(3, '11504006522b.txt', '1122', '2017-08-29 11:35:22'),
(4, '01504006630banner3.jpg', '1122', '2017-08-29 11:37:10'),
(5, '01504006699banner3.jpg', '1122', '2017-08-29 11:38:19'),
(6, '11504006699banner2.jpg', '1122', '2017-08-29 11:38:19'),
(7, '01504006950banner2.jpg', '1122', '2017-08-29 11:42:30'),
(8, '01504006980c.txt', '1122', '2017-08-29 11:43:00'),
(9, '11504006980test5.doc', '1122', '2017-08-29 11:43:00'),
(10, '01504007287banner1.jpg', '1122', '2017-08-29 11:48:07'),
(11, '01504007598banner1.jpg', '1122', '2017-08-29 11:53:18'),
(12, '11504007598banner3.jpg', '1122', '2017-08-29 11:53:18'),
(13, '21504007598banner4.jpg', '1122', '2017-08-29 11:53:18'),
(14, '31504007598banner2.jpg', '1122', '2017-08-29 11:53:18'),
(15, '01504009867c.txt', '1122', '2017-08-29 12:31:07'),
(16, '11504009867a.txt', '1122', '2017-08-29 12:31:07'),
(17, '01504009873banner1.jpg', '1122', '2017-08-29 12:31:13'),
(18, '11504009873banner2.jpg', '1122', '2017-08-29 12:31:13'),
(19, '01504009956banner1.jpg', '1122', '2017-08-29 12:32:36'),
(20, '11504009956banner3.jpg', '1122', '2017-08-29 12:32:36'),
(21, '01504013117banner2.jpg', '1122', '2017-08-29 13:25:17'),
(22, '01504013154test1.docx', '1122', '2017-08-29 13:25:54'),
(23, '01504013159banner4.jpg', '1122', '2017-08-29 13:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '2' COMMENT '0=Pending,1=Active,2=Inactive',
  `profile_image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usrEmail` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `phone`, `status`, `profile_image`, `address`, `date_created`) VALUES
(12, 'Sarul', 'Gupta', '93rEWbfcQaRj_kD6MHQQgewxaGkQp-sS', '$2y$13$yC7ItX2emVNZ4LX3YGoIGezLuan3qqPXZobZSzzaYV9SslJQnFfo.', NULL, 'sdff@webworldexpertsindia.com', '34', '1', 'unnamed_1521115295.jpg', 'house no. - 3831, sector - 47/D, Chandigarh, India', '2018-01-16 12:57:31'),
(14, 'Sunny', 'Gupta', 'rikz0PkXIdkSikMmTB9RwJmG6Hp8G0AF', '$2y$13$LHphiafCCSZO0VqKst47OOBlPsoblgJ.aBY.0n58eVd3XUy5d.jkW', NULL, 'sunny@test.com', '9632587410', '1', 'profilethumb_1521637440.jpg', 'house no. - 3831, sector - 47/D, Chandigarh, India', '2018-03-14 11:08:31'),
(15, 'Ravi', 'Sen', 'kHwLJ4iF0yr6iP4X_h4cTx-gyQf445ks', '$2y$13$4lg/ZAf4cLJZTjxq.vE9M.cy8xRCDfjHcR8KjrTSXPWiFry8/j4Pa', NULL, 'ravi@gmail.com', '7894561230', '1', 'banner3_1521199372.jpg', 'Chandigarh, India', '2018-03-15 13:37:23'),
(16, 'Jytona', 'testing', 's8-KEsxcJVoZhw6XSo7FqYw0jq3VPGYa', '$2y$13$yMbwBUar8dX6B6DowY./zewJqBYAB5ehi/JlbMrGMxxmRyib2II0y', NULL, 'newuser@test.com', '', '1', '', '', '2018-03-15 13:43:48'),
(17, 'Mandeep', 'Chandel', 'Iw5xsACFL5lz1Y_wZ1pZAADSDBFInlNo', '$2y$13$N.7As0zk5x3DmEknKMLCbuI0jQOMDzwBOyycNZB7YFZB4KBcREVDe', NULL, 'mandeep@test.com', '9999999999999', '1', 'contestant9_1521637616.jpg', '', '2018-03-21 13:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_inquiries`
--

CREATE TABLE IF NOT EXISTS `user_inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(40) NOT NULL,
  `user_lastname` varchar(40) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_comment` text NOT NULL,
  `status` enum('1','2') NOT NULL,
  `delete_status` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_inquiries`
--

INSERT INTO `user_inquiries` (`id`, `user_firstname`, `user_lastname`, `user_email`, `user_phone`, `user_comment`, `status`, `delete_status`, `datetime`) VALUES
(2, 'Stafan', 'Savatore', 'savatore.stf@test.com', '9874563254', 'This is dummy text just for testing purpose.', '1', 1, '2017-08-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE IF NOT EXISTS `user_memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_memberships`
--

INSERT INTO `user_memberships` (`id`, `membership_id`, `user_id`, `start_date`, `end_date`, `date_created`) VALUES
(1, 1, 11, '2017-07-01', '2017-08-01', '2017-08-18 12:59:51'),
(2, 1, 6, '2017-07-01', '2017-08-01', '2017-08-18 12:59:57');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
