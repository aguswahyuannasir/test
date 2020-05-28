/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100410
 Source Host           : localhost:3306
 Source Schema         : tes

 Target Server Type    : MySQL
 Target Server Version : 100410
 File Encoding         : 65001

 Date: 27/05/2020 12:14:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for contact_groups
-- ----------------------------
DROP TABLE IF EXISTS `contact_groups`;
CREATE TABLE `contact_groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_customer` tinyint(1) NULL DEFAULT NULL,
  `is_vendor` tinyint(1) NULL DEFAULT NULL,
  `group` int(11) NULL DEFAULT NULL,
  `phone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `company_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `telephone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fax` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tax_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES (1, 12, 'Customer 1', NULL, 1, 0, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2019-11-04 07:19:43', '2019-11-04 07:19:43', 1, NULL, NULL);
INSERT INTO `contacts` VALUES (2, 12, 'Vendor 1', NULL, 0, 1, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2019-11-04 08:38:02', '2019-11-04 08:38:02', 1, NULL, NULL);
INSERT INTO `contacts` VALUES (3, 13, 'PT Pertiwi Agung', 'PWAG', 1, 0, 0, '', '', '', '', '', '', '', 'Afghanistan', '', '', 0, '2019-11-20 17:25:00', '2020-01-29 02:46:32', 2, 2, NULL);
INSERT INTO `contacts` VALUES (4, 13, 'PT Fasih Media Harapan', NULL, 1, 0, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2019-11-20 18:22:58', '2019-11-20 18:22:58', 2, NULL, NULL);
INSERT INTO `contacts` VALUES (6, 13, 'Vendor Test', NULL, 0, 1, NULL, '082139819238', 'vendora@gmail.com', 'Vendoranian', NULL, NULL, NULL, 'Test', NULL, NULL, NULL, 0, '2020-01-13 04:25:19', '2020-01-13 04:25:19', 5, NULL, NULL);
INSERT INTO `contacts` VALUES (7, 17, 'PT. Yulia', NULL, 1, 0, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2020-02-05 03:24:45', '2020-02-05 03:24:45', 2, NULL, NULL);
INSERT INTO `contacts` VALUES (8, 17, 'Customer 1', NULL, 1, 0, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2020-02-05 08:40:23', '2020-02-05 08:40:23', 2, NULL, NULL);
INSERT INTO `contacts` VALUES (9, 13, 'Yulia', '', 1, 0, 0, '087878774448', '', 'Pt. Abadi', '', '', '', 'Jl. Katulampa\r\nRT 03/09', 'Indonesia', 'Jawa barat', '', 0, '2020-02-05 08:43:56', '2020-02-10 04:23:43', 2, 2, NULL);
INSERT INTO `contacts` VALUES (10, 20, 'PT asdf', 'asfd', 1, 0, NULL, '123', 'asdf@mail.com', '', NULL, NULL, NULL, 'asdfasfdasdf', NULL, NULL, NULL, 0, '2020-02-26 04:47:27', '2020-02-26 04:47:27', 2, NULL, NULL);
INSERT INTO `contacts` VALUES (11, 20, 'PT astuti', '123', 1, 0, NULL, '', '', '', NULL, NULL, NULL, 'asdfklsanldfkjas', NULL, NULL, NULL, 0, '2020-02-26 04:47:46', '2020-02-26 04:47:46', 2, NULL, NULL);
INSERT INTO `contacts` VALUES (12, 18, 'asdfa', 'asdf', 1, 0, NULL, '', '', '', NULL, NULL, NULL, '', NULL, NULL, NULL, 0, '2020-03-05 04:42:40', '2020-03-05 04:42:40', 8, NULL, NULL);
INSERT INTO `contacts` VALUES (13, 13, 'Pejabat Pembuat Komitmen Direktorat Kesehatan kerja', '', 1, 0, 0, '', '', '', '', '', '', '', 'Afghanistan', '', '', 0, '2020-05-08 02:51:06', '2020-05-08 02:51:06', 2, NULL, NULL);

-- ----------------------------
-- Table structure for currencies
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rate` double NOT NULL DEFAULT 1,
  `prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `suffix` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `decimal_digit` int(2) NOT NULL DEFAULT 2,
  `decimal_separator` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `thousand_separator` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES (1, 12, 'IDR', 'Rupiah', 14000, 'Rp ', '', 0, ',', '.', 0, 0, '2019-11-01 13:09:42', '2019-11-04 07:20:46', 1, 1, NULL);
INSERT INTO `currencies` VALUES (2, 12, 'USD', 'Dollar', 1, '$', '', 2, '.', ',', 1, 0, '2019-11-04 07:20:46', '2019-11-04 07:20:46', 1, NULL, NULL);
INSERT INTO `currencies` VALUES (3, 13, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2019-11-04 20:52:25', '2019-11-04 20:52:25', 2, NULL, NULL);
INSERT INTO `currencies` VALUES (4, 14, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-01-05 03:37:17', '2020-01-05 03:37:17', 2, NULL, NULL);
INSERT INTO `currencies` VALUES (5, 15, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-01-09 04:08:00', '2020-01-09 04:08:00', 2, NULL, NULL);
INSERT INTO `currencies` VALUES (6, 16, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-01-09 13:12:28', '2020-01-09 13:12:28', 2, NULL, NULL);
INSERT INTO `currencies` VALUES (7, 17, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-05 03:24:07', '2020-02-05 03:24:07', 2, NULL, NULL);
INSERT INTO `currencies` VALUES (8, 18, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-12 03:16:54', '2020-02-12 03:16:54', 8, NULL, NULL);
INSERT INTO `currencies` VALUES (9, 19, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-12 03:38:55', '2020-02-12 03:38:55', 8, NULL, NULL);
INSERT INTO `currencies` VALUES (10, 20, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-25 09:50:35', '2020-02-25 09:50:35', 5, NULL, NULL);
INSERT INTO `currencies` VALUES (11, 21, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-26 03:38:36', '2020-02-26 03:38:36', 3, NULL, NULL);
INSERT INTO `currencies` VALUES (12, 22, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-26 03:39:20', '2020-02-26 03:39:20', 3, NULL, NULL);
INSERT INTO `currencies` VALUES (13, 23, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-02-28 02:57:16', '2020-02-28 02:57:16', 8, NULL, NULL);
INSERT INTO `currencies` VALUES (14, 24, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 1, 0, '2020-05-27 10:48:03', '2020-05-27 10:48:03', 2, NULL, NULL);

-- ----------------------------
-- Table structure for master_account
-- ----------------------------
DROP TABLE IF EXISTS `master_account`;
CREATE TABLE `master_account`  (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `acc_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `acc_additional` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` tinyint(4) NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `user_added` int(100) NULL DEFAULT NULL,
  `date_added` datetime(0) NULL DEFAULT current_timestamp(0),
  `organization` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`acc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_account
-- ----------------------------
INSERT INTO `master_account` VALUES (1, 'BCA', '100000001', NULL, 1, 0, NULL, '2020-02-19 07:09:10', NULL);
INSERT INTO `master_account` VALUES (2, 'BNI', '200000002', NULL, 1, 0, NULL, '2020-02-19 07:09:10', NULL);
INSERT INTO `master_account` VALUES (3, 'BCA', '10002311', '', 1, 0, 2, '2020-02-19 07:10:55', 13);

-- ----------------------------
-- Table structure for member_groups
-- ----------------------------
DROP TABLE IF EXISTS `member_groups`;
CREATE TABLE `member_groups`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_groups
-- ----------------------------
INSERT INTO `member_groups` VALUES (1, 'owner', 'Owner');
INSERT INTO `member_groups` VALUES (2, 'user', 'User');

-- ----------------------------
-- Table structure for member_invitation
-- ----------------------------
DROP TABLE IF EXISTS `member_invitation`;
CREATE TABLE `member_invitation`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `role` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `exp_date` date NOT NULL,
  `status` tinyint(4) NULL DEFAULT 0 COMMENT '\"0\" = \"Not Proccess\", \"1\" = \"Proccess\"',
  `invited_by` int(11) NOT NULL,
  `invited_date` datetime(0) NULL DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_invitation
-- ----------------------------
INSERT INTO `member_invitation` VALUES (1, 'fitrianiyulia1@gmail.com', 'user', '2020-02-26', 1, 2, '2020-02-25 16:51:21', 2, 9);
INSERT INTO `member_invitation` VALUES (2, 'fathi.rahmat97@gmail.com', 'user', '2020-02-28', 0, 2, '2020-02-27 13:07:55', 2, 0);
INSERT INTO `member_invitation` VALUES (3, 'rahmat.fathi97@gmail.com', 'user', '2020-02-28', 2, 2, '2020-02-27 13:08:49', 2, 0);
INSERT INTO `member_invitation` VALUES (4, 'technical@omeoo.com', 'user', '2020-02-29', 1, 2, '2020-02-28 09:36:05', 2, 8);
INSERT INTO `member_invitation` VALUES (5, 'myemailtempyf@gmail.com', 'user', '2020-02-29', 2, 8, '2020-02-28 09:37:46', 8, 0);

-- ----------------------------
-- Table structure for member_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `member_login_attempts`;
CREATE TABLE `member_login_attempts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(39) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `timestamp` datetime(0) NULL DEFAULT NULL,
  `login_attempts` tinyint(2) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 289 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_login_attempts
-- ----------------------------
INSERT INTO `member_login_attempts` VALUES (1, '::1', '2019-07-03 14:41:26', 3);
INSERT INTO `member_login_attempts` VALUES (2, '::1', '2019-07-03 14:50:14', 3);
INSERT INTO `member_login_attempts` VALUES (53, '127.0.0.1', '2019-08-09 19:00:44', 4);
INSERT INTO `member_login_attempts` VALUES (54, '127.0.0.1', '2019-08-10 01:08:24', 3);
INSERT INTO `member_login_attempts` VALUES (56, '127.0.0.1', '2019-10-31 13:39:21', 1);
INSERT INTO `member_login_attempts` VALUES (62, '127.0.0.1', '2019-11-04 13:54:16', 4);
INSERT INTO `member_login_attempts` VALUES (178, '127.0.0.1', '2020-01-31 16:32:57', 1);
INSERT INTO `member_login_attempts` VALUES (181, '127.0.0.1', '2020-02-04 17:44:15', 3);
INSERT INTO `member_login_attempts` VALUES (264, '162.158.166.146', '2020-03-16 16:08:23', 1);

-- ----------------------------
-- Table structure for member_module
-- ----------------------------
DROP TABLE IF EXISTS `member_module`;
CREATE TABLE `member_module`  (
  `member_id` int(11) NOT NULL,
  `module_id` int(11) NULL DEFAULT NULL,
  `organization` int(11) NULL DEFAULT NULL,
  `invitation_id` int(11) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_module
-- ----------------------------
INSERT INTO `member_module` VALUES (6, 1, NULL, NULL);
INSERT INTO `member_module` VALUES (6, 2, NULL, NULL);
INSERT INTO `member_module` VALUES (5, 1, 13, NULL);
INSERT INTO `member_module` VALUES (5, 2, 13, NULL);
INSERT INTO `member_module` VALUES (5, 3, 13, NULL);
INSERT INTO `member_module` VALUES (5, 4, 13, NULL);
INSERT INTO `member_module` VALUES (5, 5, 13, NULL);
INSERT INTO `member_module` VALUES (5, 6, 13, NULL);
INSERT INTO `member_module` VALUES (5, 1, 17, NULL);
INSERT INTO `member_module` VALUES (5, 2, 17, NULL);
INSERT INTO `member_module` VALUES (5, 3, 17, NULL);
INSERT INTO `member_module` VALUES (5, 4, 17, NULL);
INSERT INTO `member_module` VALUES (5, 5, 17, NULL);
INSERT INTO `member_module` VALUES (5, 6, 17, NULL);
INSERT INTO `member_module` VALUES (7, 1, 13, NULL);
INSERT INTO `member_module` VALUES (7, 2, 13, NULL);
INSERT INTO `member_module` VALUES (7, 3, 13, NULL);
INSERT INTO `member_module` VALUES (7, 1, 17, NULL);
INSERT INTO `member_module` VALUES (7, 2, 17, NULL);
INSERT INTO `member_module` VALUES (7, 3, 17, NULL);
INSERT INTO `member_module` VALUES (7, 4, 17, NULL);
INSERT INTO `member_module` VALUES (7, 5, 17, NULL);
INSERT INTO `member_module` VALUES (7, 6, 17, NULL);
INSERT INTO `member_module` VALUES (9, 1, 20, NULL);
INSERT INTO `member_module` VALUES (9, 2, 20, NULL);
INSERT INTO `member_module` VALUES (9, 3, 20, NULL);
INSERT INTO `member_module` VALUES (9, 4, 20, NULL);
INSERT INTO `member_module` VALUES (9, 5, 20, NULL);
INSERT INTO `member_module` VALUES (9, 6, 20, NULL);
INSERT INTO `member_module` VALUES (0, 1, 17, 2);
INSERT INTO `member_module` VALUES (0, 2, 17, 2);
INSERT INTO `member_module` VALUES (0, 3, 17, 2);
INSERT INTO `member_module` VALUES (0, 4, 17, 2);
INSERT INTO `member_module` VALUES (0, 5, 17, 2);
INSERT INTO `member_module` VALUES (0, 6, 17, 2);
INSERT INTO `member_module` VALUES (10, 1, 13, 3);
INSERT INTO `member_module` VALUES (10, 2, 13, 3);
INSERT INTO `member_module` VALUES (10, 3, 13, 3);
INSERT INTO `member_module` VALUES (10, 4, 13, 3);
INSERT INTO `member_module` VALUES (10, 5, 13, 3);
INSERT INTO `member_module` VALUES (10, 6, 13, 3);
INSERT INTO `member_module` VALUES (10, 1, 17, 0);
INSERT INTO `member_module` VALUES (10, 2, 17, 0);
INSERT INTO `member_module` VALUES (10, 3, 17, 0);
INSERT INTO `member_module` VALUES (10, 4, 17, 0);
INSERT INTO `member_module` VALUES (10, 5, 17, 0);
INSERT INTO `member_module` VALUES (10, 6, 17, 0);
INSERT INTO `member_module` VALUES (4, 1, 13, 0);
INSERT INTO `member_module` VALUES (4, 2, 13, 0);
INSERT INTO `member_module` VALUES (4, 3, 13, 0);
INSERT INTO `member_module` VALUES (4, 4, 13, 0);
INSERT INTO `member_module` VALUES (4, 5, 13, 0);
INSERT INTO `member_module` VALUES (4, 6, 13, 0);
INSERT INTO `member_module` VALUES (11, 1, 18, 5);
INSERT INTO `member_module` VALUES (11, 2, 18, 5);
INSERT INTO `member_module` VALUES (11, 3, 18, 5);
INSERT INTO `member_module` VALUES (11, 4, 18, 5);
INSERT INTO `member_module` VALUES (11, 5, 18, 5);
INSERT INTO `member_module` VALUES (11, 6, 18, 5);
INSERT INTO `member_module` VALUES (11, 1, 19, 0);
INSERT INTO `member_module` VALUES (11, 2, 19, 0);
INSERT INTO `member_module` VALUES (11, 3, 19, 0);
INSERT INTO `member_module` VALUES (11, 4, 19, 0);
INSERT INTO `member_module` VALUES (11, 5, 19, 0);
INSERT INTO `member_module` VALUES (11, 6, 19, 0);

-- ----------------------------
-- Table structure for member_module_sub
-- ----------------------------
DROP TABLE IF EXISTS `member_module_sub`;
CREATE TABLE `member_module_sub`  (
  `member_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_sub_id` int(11) NOT NULL,
  `organization` int(11) NULL DEFAULT NULL,
  `invitation_id` int(11) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_module_sub
-- ----------------------------
INSERT INTO `member_module_sub` VALUES (6, 1, 2, NULL, NULL);
INSERT INTO `member_module_sub` VALUES (6, 2, 3, NULL, NULL);
INSERT INTO `member_module_sub` VALUES (5, 1, 1, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 1, 2, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 2, 3, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 3, 4, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 3, 5, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 6, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 7, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 8, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 9, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 10, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 11, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 12, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 13, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 14, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 15, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 16, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 17, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 18, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 19, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 20, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 21, 13, NULL);
INSERT INTO `member_module_sub` VALUES (5, 1, 1, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 1, 2, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 2, 3, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 3, 4, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 3, 5, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 6, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 7, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 8, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 4, 9, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 10, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 11, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 12, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 13, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 5, 14, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 15, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 16, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 17, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 18, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 19, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 20, 17, NULL);
INSERT INTO `member_module_sub` VALUES (5, 6, 21, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 1, 1, 13, NULL);
INSERT INTO `member_module_sub` VALUES (7, 1, 2, 13, NULL);
INSERT INTO `member_module_sub` VALUES (7, 2, 3, 13, NULL);
INSERT INTO `member_module_sub` VALUES (7, 3, 4, 13, NULL);
INSERT INTO `member_module_sub` VALUES (7, 1, 1, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 1, 2, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 2, 3, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 3, 4, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 3, 5, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 4, 6, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 4, 7, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 4, 8, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 4, 9, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 5, 10, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 5, 11, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 5, 12, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 5, 13, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 5, 14, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 15, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 16, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 17, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 18, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 19, 17, NULL);
INSERT INTO `member_module_sub` VALUES (7, 6, 20, 17, NULL);
INSERT INTO `member_module_sub` VALUES (9, 1, 1, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 1, 2, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 2, 3, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 3, 4, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 3, 5, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 4, 6, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 4, 7, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 4, 8, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 4, 9, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 5, 10, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 5, 11, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 5, 12, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 5, 13, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 5, 14, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 15, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 16, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 17, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 18, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 19, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 20, 20, NULL);
INSERT INTO `member_module_sub` VALUES (9, 6, 21, 20, NULL);
INSERT INTO `member_module_sub` VALUES (0, 1, 1, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 1, 2, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 2, 3, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 3, 4, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 3, 5, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 4, 6, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 4, 7, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 4, 8, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 4, 9, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 5, 10, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 5, 11, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 5, 12, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 5, 13, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 5, 14, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 15, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 16, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 17, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 18, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 19, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 20, 17, 2);
INSERT INTO `member_module_sub` VALUES (0, 6, 21, 17, 2);
INSERT INTO `member_module_sub` VALUES (10, 1, 1, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 1, 2, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 2, 3, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 3, 4, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 3, 5, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 4, 6, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 4, 7, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 4, 8, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 4, 9, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 5, 10, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 5, 11, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 5, 12, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 5, 13, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 5, 14, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 15, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 16, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 17, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 18, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 19, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 20, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 6, 21, 13, 3);
INSERT INTO `member_module_sub` VALUES (10, 1, 1, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 1, 2, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 2, 3, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 3, 4, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 3, 5, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 4, 6, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 4, 7, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 4, 8, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 4, 9, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 5, 10, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 5, 11, 17, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 12, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 5, 13, 17, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 14, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 15, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 16, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 17, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 18, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 19, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 20, 17, 0);
INSERT INTO `member_module_sub` VALUES (10, 6, 21, 17, 0);
INSERT INTO `member_module_sub` VALUES (4, 1, 1, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 1, 2, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 2, 3, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 3, 4, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 3, 5, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 4, 6, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 4, 7, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 4, 8, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 4, 9, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 5, 10, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 5, 11, 13, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 12, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 5, 13, 13, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 14, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 15, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 16, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 17, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 18, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 19, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 20, 13, 0);
INSERT INTO `member_module_sub` VALUES (4, 6, 21, 13, 0);
INSERT INTO `member_module_sub` VALUES (11, 1, 1, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 1, 2, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 2, 3, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 3, 4, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 3, 5, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 4, 6, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 4, 7, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 4, 8, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 4, 9, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 5, 10, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 5, 11, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 5, 12, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 5, 13, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 5, 14, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 15, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 16, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 17, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 18, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 19, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 20, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 6, 21, 18, 5);
INSERT INTO `member_module_sub` VALUES (11, 1, 1, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 1, 2, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 2, 3, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 3, 4, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 3, 5, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 4, 6, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 4, 7, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 4, 8, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 4, 9, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 5, 10, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 5, 11, 19, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 12, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 5, 13, 19, 0);
INSERT INTO `member_module_sub` VALUES (0, 5, 14, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 15, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 16, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 17, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 18, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 19, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 20, 19, 0);
INSERT INTO `member_module_sub` VALUES (11, 6, 21, 19, 0);

-- ----------------------------
-- Table structure for member_perm_to_group
-- ----------------------------
DROP TABLE IF EXISTS `member_perm_to_group`;
CREATE TABLE `member_perm_to_group`  (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member_perms
-- ----------------------------
DROP TABLE IF EXISTS `member_perms`;
CREATE TABLE `member_perms`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member_to_group
-- ----------------------------
DROP TABLE IF EXISTS `member_to_group`;
CREATE TABLE `member_to_group`  (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_to_group
-- ----------------------------
INSERT INTO `member_to_group` VALUES (1, 1);
INSERT INTO `member_to_group` VALUES (2, 1);
INSERT INTO `member_to_group` VALUES (3, 1);
INSERT INTO `member_to_group` VALUES (5, 1);
INSERT INTO `member_to_group` VALUES (7, 2);
INSERT INTO `member_to_group` VALUES (8, 1);
INSERT INTO `member_to_group` VALUES (9, 2);
INSERT INTO `member_to_group` VALUES (12, 1);

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `banned` tinyint(1) NULL DEFAULT 0,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `last_activity` datetime(0) NULL DEFAULT NULL,
  `date_created` datetime(0) NULL DEFAULT NULL,
  `forgot_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `remember_time` datetime(0) NULL DEFAULT NULL,
  `remember_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `verification_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `totp_secret` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fullname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country` int(11) NULL DEFAULT NULL,
  `city` int(11) NULL DEFAULT NULL,
  `postcode` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_admin` int(1) NULL DEFAULT 0,
  `owner_id` int(11) NULL DEFAULT NULL COMMENT 'ID from member id',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `updated_by` int(11) NULL DEFAULT NULL,
  `updated_date` datetime(0) NULL DEFAULT NULL,
  `manage_member` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES (2, 'test@omeoo.com', '$2y$10$ErYB0ca.3Vjcv0BIW9QmjuGMIR8J0Ax5oqP7xPGJvKADyyDtZDOdK', '', 0, '2020-05-27 10:44:40', '2020-05-27 10:44:40', '2019-11-04 20:51:47', NULL, NULL, NULL, NULL, NULL, '::1', 'Testing', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 0);

-- ----------------------------
-- Table structure for organization_members
-- ----------------------------
DROP TABLE IF EXISTS `organization_members`;
CREATE TABLE `organization_members`  (
  `organization` int(11) NOT NULL,
  `member` int(11) NOT NULL,
  `role` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `invitation_id` tinyint(11) NOT NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of organization_members
-- ----------------------------
INSERT INTO `organization_members` VALUES (12, 1, 'owner', 0);
INSERT INTO `organization_members` VALUES (13, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (13, 5, 'user', 0);
INSERT INTO `organization_members` VALUES (13, 6, 'user', 0);
INSERT INTO `organization_members` VALUES (13, 7, 'user', 0);
INSERT INTO `organization_members` VALUES (14, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (15, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (16, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (17, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (17, 5, 'user', 0);
INSERT INTO `organization_members` VALUES (17, 7, 'user', 0);
INSERT INTO `organization_members` VALUES (18, 8, 'owner', 0);
INSERT INTO `organization_members` VALUES (18, 9, 'user', 0);
INSERT INTO `organization_members` VALUES (19, 8, 'owner', 0);
INSERT INTO `organization_members` VALUES (20, 2, 'owner', 0);
INSERT INTO `organization_members` VALUES (20, 5, 'user', 0);
INSERT INTO `organization_members` VALUES (20, 9, 'user', 1);
INSERT INTO `organization_members` VALUES (21, 3, 'owner', 0);
INSERT INTO `organization_members` VALUES (22, 3, 'owner', 0);
INSERT INTO `organization_members` VALUES (17, 0, 'user', 2);
INSERT INTO `organization_members` VALUES (13, 10, 'user', 0);
INSERT INTO `organization_members` VALUES (17, 10, 'user', 0);
INSERT INTO `organization_members` VALUES (13, 4, 'user', 0);
INSERT INTO `organization_members` VALUES (18, 11, 'user', 0);
INSERT INTO `organization_members` VALUES (19, 11, 'user', 0);
INSERT INTO `organization_members` VALUES (23, 8, 'owner', 0);
INSERT INTO `organization_members` VALUES (24, 2, 'owner', 0);

-- ----------------------------
-- Table structure for organizations
-- ----------------------------
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE `organizations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fax` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tax_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `website` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `category` int(11) NULL DEFAULT NULL,
  `format_sale_invoice` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'INV/[NUM]/[MM][YY]',
  `format_sale_invoice_child` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/[NUM]',
  `format_sale_quote` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'QUO/[NUM]/[MM][YY]',
  `format_purchase_invoice` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'PI/[NUM]/[MM][YY]',
  `format_purchase_order` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'PO/[NUM]/[MM][YY]',
  `format_purchase_quote` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'PQ/[NUM]/[MM][YY]',
  `format_date` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y-m-d',
  `format_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'H:i',
  `template_sale_invoice` int(11) NOT NULL DEFAULT 1,
  `template_sale_invoice_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `template_sale_quote` int(11) NOT NULL DEFAULT 2,
  `template_sale_quote_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `template_purchase_invoice` int(11) NOT NULL DEFAULT 3,
  `template_purchase_invoice_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `template_purchase_order` int(11) NOT NULL DEFAULT 5,
  `template_purchase_order_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `template_purchase_quote` int(11) NOT NULL DEFAULT 4,
  `template_purchase_quote_options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `signatures` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `package` int(1) NULL DEFAULT 1,
  `start_from` date NULL DEFAULT NULL,
  `valid_until` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of organizations
-- ----------------------------
INSERT INTO `organizations` VALUES (13, 'PT. CKI', 'files/13/819b7fe62fa17fc4ab0426d76f1db8e7.jpg', 'Komplek Golden Plaza Blok C 11\r\nJl.RS Fatmawati Raya No.15, Gandaria Selatan, Cilandak ', '', '', '', '', '', NULL, 'INV/[NUM]/[MM][YY]', '/[NUM]', 'QUO/[NUM]/[MM][YY]', 'PI/[NUM]/[MM][YY]', 'PO/[NUM]/[MM][YY]', 'PQ/[NUM]/[MM][YY]', 'Y-m-d', 'H:i', 1, '{\"margin_left\":\"\",\"signature_count\":\"1\",\"signature\":\"1\",\"logo\":\"1\",\"organization_name\":\"1\",\"organization_address\":\"1\",\"organization_contact\":\"1\",\"product_code\":\"1\",\"product_tax\":\"1\"}', 2, '{\"margin_left\":\"100\",\"signature_count\":\"1\",\"signature\":\"1\",\"logo\":\"1\",\"organization_name\":\"1\",\"organization_address\":\"1\",\"organization_contact\":\"1\",\"product_code\":\"1\",\"product_tax\":\"1\"}', 3, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 5, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 4, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', '[{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"files\\/13\\/3f370bb7af7bac54965c5752c65ab6b0.png\",\"as\":\"Disetujui\",\"name\":\"Raymond\",\"job_title\":\"Direktur\"}]', 0, '2019-11-04 20:52:25', '2019-11-25 11:16:24', 0, 2, NULL, 1, 1, NULL, NULL);
INSERT INTO `organizations` VALUES (14, 'PT. KAI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/[NUM]/[MM][YY]', '/[NUM]', 'QUO/[NUM]/[MM][YY]', 'PI/[NUM]/[MM][YY]', 'PO/[NUM]/[MM][YY]', 'PQ/[NUM]/[MM][YY]', 'Y-m-d', 'H:i', 1, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 2, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 3, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 5, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 4, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', '[{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"}]', 1, '2020-01-05 03:37:17', '2020-01-05 03:37:17', 0, NULL, 2, 1, 0, '2020-01-05', '2020-02-04');
INSERT INTO `organizations` VALUES (17, 'PT. ABC', 'files/17/5f6a22581acb4f6d893f165e218e8746.png', '', '', '', '', '', '', NULL, 'INV/[NUM]/[MM][YY]', '/[NUM]', 'QUO/[NUM]/[MM][YY]', 'PI/[NUM]/[MM][YY]', 'PO/[NUM]/[MM][YY]', 'PQ/[NUM]/[MM][YY]', 'Y-m-d', 'H:i', 1, '{\"margin_left\":\"\",\"signature_count\":\"4\",\"signature\":\"1\",\"logo\":\"1\",\"organization_name\":\"1\",\"organization_address\":\"1\",\"organization_contact\":\"1\",\"product_code\":\"1\",\"product_tax\":\"1\"}', 2, '{\"margin_left\":\"\",\"signature_count\":\"4\",\"signature\":\"1\",\"logo\":\"1\",\"organization_name\":\"1\",\"organization_address\":\"1\",\"organization_contact\":\"1\",\"product_code\":\"1\",\"product_tax\":\"1\"}', 3, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 5, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 4, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', '[{\"image\":\"files\\/17\\/2d1559153eeb90dcef81faed68c84f8e.png\",\"as\":\"aaaaaa\",\"name\":\"Yulia\",\"job_title\":\"sdfsdfsdf\"},{\"image\":\"\",\"as\":\"\\u00a0\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\\u00a0\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"files\\/17\\/24c0ccd63a4d65c90c592b43e15e6785.png\",\"as\":\"sdfsdfs\",\"name\":\"Raymond\",\"job_title\":\"sdfsdf\"}]', 0, '2020-02-05 03:24:07', '2020-02-05 03:24:07', 0, 2, NULL, 1, 1, '2020-02-05', '2020-03-06');
INSERT INTO `organizations` VALUES (20, 'New Test Organization', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/[NUM]/[MM][YY]', '/[NUM]', 'QUO/[NUM]/[MM][YY]', 'PI/[NUM]/[MM][YY]', 'PO/[NUM]/[MM][YY]', 'PQ/[NUM]/[MM][YY]', 'Y-m-d', 'H:i', 1, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 2, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 3, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 5, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 4, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', '[{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"}]', 0, '2020-02-25 09:50:35', '2020-02-25 09:50:35', 0, NULL, NULL, 1, 1, '2020-02-25', '2020-03-26');
INSERT INTO `organizations` VALUES (24, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/[NUM]/[MM][YY]', '/[NUM]', 'QUO/[NUM]/[MM][YY]', 'PI/[NUM]/[MM][YY]', 'PO/[NUM]/[MM][YY]', 'PQ/[NUM]/[MM][YY]', 'Y-m-d', 'H:i', 1, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 2, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 3, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 5, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', 4, '{\"signature_count\":0,\"logo\":false,\"organization_name\":true,\"organization_address\":true,\"organization_contact\":true,\"product_code\":true,\"product_tax\":true}', '[{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"},{\"image\":\"\",\"as\":\"\",\"name\":\"\",\"job_title\":\"\"}]', 0, '2020-05-27 10:48:03', '2020-05-27 10:48:03', 0, NULL, NULL, 1, 1, '2020-05-27', '2020-06-26');

-- ----------------------------
-- Table structure for other_currency
-- ----------------------------
DROP TABLE IF EXISTS `other_currency`;
CREATE TABLE `other_currency`  (
  `transaction` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `rate` double NOT NULL,
  `amount_1` double NOT NULL COMMENT 'subtotal',
  `amount_2` double NOT NULL COMMENT 'total_tax',
  `amount_3` double NOT NULL COMMENT 'total_chargees_fee\n',
  `amount_4` double NOT NULL COMMENT 'total',
  `amount_5` double NOT NULL COMMENT 'other',
  PRIMARY KEY (`transaction_id`, `transaction`, `currency`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of other_currency
-- ----------------------------
INSERT INTO `other_currency` VALUES ('purchase_invoice', 1, 2, 1, 5, 0, 0, 5, 0);
INSERT INTO `other_currency` VALUES ('purchase_product', 1, 2, 1, 5, 5, 0, 0, 5);
INSERT INTO `other_currency` VALUES ('sale_invoice', 1, 1, 14000, 168000, 0, 0, 168000, 0);
INSERT INTO `other_currency` VALUES ('sale_product', 1, 1, 14000, 70000, 70000, 0, 0, 70000);
INSERT INTO `other_currency` VALUES ('purchase_invoice', 2, 2, 1, 3.57, 0, 0, 3.57, 0);
INSERT INTO `other_currency` VALUES ('purchase_product', 2, 2, 1, 3.57, 3.57, 0, 0, 3.57);
INSERT INTO `other_currency` VALUES ('sale_invoice', 2, 1, 14000, 196000, 0, 0, 196000, 0);
INSERT INTO `other_currency` VALUES ('sale_product', 2, 1, 14000, 98000, 98000, 0, 0, 98000);
INSERT INTO `other_currency` VALUES ('purchase_invoice', 3, 1, 14000, 56000, 0, 0, 56000, 0);
INSERT INTO `other_currency` VALUES ('purchase_product', 3, 1, 14000, 56000, 56000, 0, 0, 56000);
INSERT INTO `other_currency` VALUES ('sale_product', 3, 1, 14000, 56000, 56000, 0, 0, 56000);
INSERT INTO `other_currency` VALUES ('sale_product', 4, 1, 14000, 140000, 140000, 0, 0, 140000);
INSERT INTO `other_currency` VALUES ('sale_quote', 6, 1, 14000, 70000, 0, 0, 70000, 0);
INSERT INTO `other_currency` VALUES ('sale_product', 10, 1, 14000, 14000, 14000, 0, 0, 14000);
INSERT INTO `other_currency` VALUES ('sale_product', 11, 1, 14000, 56000, 56000, 0, 0, 56000);

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages`  (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `created_date` datetime(0) NULL DEFAULT current_timestamp(0),
  `updated_date` datetime(0) NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`package_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES (1, 'Free', 0, 1, '2019-11-26 09:51:46', '2019-11-26 10:15:59');
INSERT INTO `packages` VALUES (2, 'Business', 10, 1, '2019-11-26 09:52:00', '2019-11-27 13:33:52');

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `vendor` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `setting` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `is_account` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES (1, 'transfer', 'Bank Transfer', 'BRI, Mandiri, BCA', '', NULL, '', 1, 1, 1);
INSERT INTO `payment_methods` VALUES (2, 'credit_card', 'Credit Card', 'Visa / Master Card', '', NULL, NULL, 2, 1, 1);
INSERT INTO `payment_methods` VALUES (3, 'cash', 'Cash', 'Cash Payment', NULL, NULL, NULL, 3, 1, 0);

-- ----------------------------
-- Table structure for product_categories
-- ----------------------------
DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE `product_categories`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_charges_fees
-- ----------------------------
DROP TABLE IF EXISTS `product_charges_fees`;
CREATE TABLE `product_charges_fees`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'percentage',
  `value` float NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_units
-- ----------------------------
DROP TABLE IF EXISTS `product_units`;
CREATE TABLE `product_units`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_units
-- ----------------------------
INSERT INTO `product_units` VALUES (1, 13, 'Unit1', 0, 0, '2020-01-10 10:35:03', '2020-01-15 07:06:16', 5, NULL, NULL);
INSERT INTO `product_units` VALUES (2, 13, 'Unit2', 0, 0, '2020-01-10 10:35:07', '2020-01-15 07:06:17', 5, NULL, NULL);
INSERT INTO `product_units` VALUES (3, 13, 'Unit3', 1, 0, '2020-01-10 10:35:10', '2020-01-15 07:06:20', 5, NULL, NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'product',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `category` int(11) NULL DEFAULT NULL,
  `unit` int(11) NULL DEFAULT NULL,
  `cost_price` double NULL DEFAULT NULL,
  `cost_currency` int(11) NULL DEFAULT NULL,
  `sale_price` double NULL DEFAULT NULL,
  `sale_currency` int(11) NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 12, 'product', 'Product 1', 'PR1-0001', NULL, 0, 0, 50000, 1, 70000, 1, 0, '2019-11-04 07:20:08', '2019-11-04 07:20:08', 1, NULL, NULL);
INSERT INTO `products` VALUES (2, 12, 'product', 'Product 2', 'PR2-0001', NULL, 0, 0, 5, 2, 7, 2, 0, '2019-11-04 07:21:12', '2019-11-04 07:21:12', 1, NULL, NULL);
INSERT INTO `products` VALUES (3, 12, 'service', 'Service 1', '', NULL, 0, NULL, NULL, NULL, 10, 2, 0, '2019-11-04 07:24:20', '2019-11-04 07:24:20', 1, NULL, NULL);
INSERT INTO `products` VALUES (4, 12, 'product', 'Rifky Syaripudin', 'RIS-0001', NULL, NULL, NULL, 2, 2, 4, 2, 0, '2019-11-15 08:11:48', '2019-11-15 08:11:48', 1, NULL, NULL);
INSERT INTO `products` VALUES (5, 12, 'service', 'Nur Rohman', 'NUR-0001', NULL, NULL, NULL, 0, 2, 10, 2, 0, '2019-11-15 08:12:02', '2019-11-15 08:12:02', 1, NULL, NULL);
INSERT INTO `products` VALUES (6, 13, 'service', 'Radio Placement', 'RAP-0001', NULL, NULL, NULL, 0, 3, 0, 3, 0, '2019-11-20 17:25:18', '2019-11-20 17:25:18', 2, NULL, NULL);
INSERT INTO `products` VALUES (7, 13, 'product', 'TV Station Placement', 'TVS-0001', NULL, NULL, NULL, 0, 3, 0, 3, 0, '2019-11-20 18:23:18', '2019-11-20 18:23:18', 2, NULL, NULL);
INSERT INTO `products` VALUES (8, 12, 'product', 'asdasd', 'ASD-0001', NULL, NULL, NULL, 2, 2, 1, 2, 0, '2019-11-22 09:00:03', '2019-11-22 09:00:03', 1, NULL, NULL);
INSERT INTO `products` VALUES (9, 13, 'service', 'Pre Production', 'PRP-0001', NULL, 0, 0, 0, 3, 13200000, 3, 0, '2020-01-07 07:26:55', '2020-01-07 07:27:52', 5, 5, NULL);
INSERT INTO `products` VALUES (10, 13, 'service', 'KV & Brochure', 'KV&-0001', NULL, 0, 1, 0, 3, 0, 3, 0, '2020-01-07 07:39:14', '2020-01-10 10:50:53', 5, 5, NULL);
INSERT INTO `products` VALUES (11, 13, 'product', 'discount', 'DIS-0001', NULL, NULL, NULL, 0, 3, 0, 3, 0, '2020-02-05 05:11:42', '2020-02-05 05:11:42', 2, NULL, NULL);
INSERT INTO `products` VALUES (12, 18, 'service', 'service', 'service', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:42:59', '2020-03-05 04:42:59', 8, NULL, NULL);
INSERT INTO `products` VALUES (13, 18, 'service', 'PENGARON', 'PEN-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:46:28', '2020-03-05 04:46:28', 8, NULL, NULL);
INSERT INTO `products` VALUES (14, 18, 'service', 'service 2', 'SE2-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:51:15', '2020-03-05 04:51:15', 8, NULL, NULL);
INSERT INTO `products` VALUES (15, 18, 'service', 'Social Media Maintenance', 'SMM-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:55:29', '2020-03-05 04:55:29', 8, NULL, NULL);
INSERT INTO `products` VALUES (16, 18, 'service', 'Account Management', 'ACM-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:55:40', '2020-03-05 04:55:40', 8, NULL, NULL);
INSERT INTO `products` VALUES (17, 18, 'service', 'Website Maintenance', 'WEM-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:55:51', '2020-03-05 04:55:51', 8, NULL, NULL);
INSERT INTO `products` VALUES (18, 18, 'service', 'Content Creation', 'COC-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:56:10', '2020-03-05 04:56:10', 8, NULL, NULL);
INSERT INTO `products` VALUES (19, 18, 'service', 'Adjusment', 'ADJ-0001', NULL, NULL, NULL, 0, 8, 0, 8, 0, '2020-03-05 04:58:08', '2020-03-05 04:58:08', 8, NULL, NULL);
INSERT INTO `products` VALUES (20, 17, 'product', 'asdfads', 'ASD-0001', NULL, NULL, NULL, 0, 7, 0, 7, 0, '2020-03-13 11:09:52', '2020-03-13 11:09:52', 7, NULL, NULL);

-- ----------------------------
-- Table structure for quick_access
-- ----------------------------
DROP TABLE IF EXISTS `quick_access`;
CREATE TABLE `quick_access`  (
  `quick_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`quick_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of quick_access
-- ----------------------------
INSERT INTO `quick_access` VALUES (1, 'Add Invoice', 'fa fa-file-invoice', '/sale/invoices/form', 'app');

-- ----------------------------
-- Table structure for sale_product_charges_fees
-- ----------------------------
DROP TABLE IF EXISTS `sale_product_charges_fees`;
CREATE TABLE `sale_product_charges_fees`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_product` int(11) NOT NULL,
  `charges_fee` int(11) NOT NULL,
  `charges_fee_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `charges_fee_type` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `charges_fee_value` float NOT NULL,
  `charges_fee_amount` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sale_product_taxes
-- ----------------------------
DROP TABLE IF EXISTS `sale_product_taxes`;
CREATE TABLE `sale_product_taxes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_product` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `tax_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tax_rate` float NOT NULL,
  `tax_amount` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 128 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sale_product_taxes
-- ----------------------------
INSERT INTO `sale_product_taxes` VALUES (3, 21, 1, 'PPn', 10, 300000);
INSERT INTO `sale_product_taxes` VALUES (8, 28, 3, 'ASF', 5, 30000);
INSERT INTO `sale_product_taxes` VALUES (9, 28, 1, 'PPn', 10, 63000);
INSERT INTO `sale_product_taxes` VALUES (12, 30, 2, 'ASF', 10, 20000);
INSERT INTO `sale_product_taxes` VALUES (13, 30, 1, 'PPN', 10, 22000);
INSERT INTO `sale_product_taxes` VALUES (14, 31, 1, 'PPN', 10, 1000000);
INSERT INTO `sale_product_taxes` VALUES (47, 52, 3, 'ASF 5%', 5, 50000);
INSERT INTO `sale_product_taxes` VALUES (48, 52, 1, 'PPN', 10, 105000);
INSERT INTO `sale_product_taxes` VALUES (49, 53, 2, 'ASF', 10, 52379292000);
INSERT INTO `sale_product_taxes` VALUES (50, 53, 1, 'PPN', 10, 57617221200);
INSERT INTO `sale_product_taxes` VALUES (51, 54, 3, 'ASF 5%', 5, -25000);
INSERT INTO `sale_product_taxes` VALUES (52, 54, 1, 'PPN', 10, -52500);
INSERT INTO `sale_product_taxes` VALUES (53, 55, 2, 'ASF', 10, 60000);
INSERT INTO `sale_product_taxes` VALUES (54, 55, 1, 'PPN', 10, 66000);
INSERT INTO `sale_product_taxes` VALUES (55, 57, 2, 'ASF', 10, 20000);
INSERT INTO `sale_product_taxes` VALUES (56, 57, 1, 'PPN', 10, 22000);
INSERT INTO `sale_product_taxes` VALUES (57, 58, 1, 'PPN', 10, 20000);
INSERT INTO `sale_product_taxes` VALUES (100, 90, 2, 'ASF', 10, 20000);
INSERT INTO `sale_product_taxes` VALUES (101, 90, 1, 'PPN', 10, 22000);
INSERT INTO `sale_product_taxes` VALUES (102, 91, 1, 'PPN', 10, 3000);
INSERT INTO `sale_product_taxes` VALUES (103, 92, 1, 'PPN', 10, -100);
INSERT INTO `sale_product_taxes` VALUES (120, 145, 2, 'ASF', 10, 20000);
INSERT INTO `sale_product_taxes` VALUES (121, 145, 1, 'PPN', 10, 22000);
INSERT INTO `sale_product_taxes` VALUES (122, 146, 1, 'PPN', 10, 300000);
INSERT INTO `sale_product_taxes` VALUES (123, 147, 1, 'PPN', 10, -1000);
INSERT INTO `sale_product_taxes` VALUES (124, 148, 2, 'ASF', 10, 0);
INSERT INTO `sale_product_taxes` VALUES (125, 148, 1, 'PPN', 10, 0);
INSERT INTO `sale_product_taxes` VALUES (126, 149, 1, 'PPN', 10, 3000);
INSERT INTO `sale_product_taxes` VALUES (127, 150, 1, 'PPN', 10, -100);

-- ----------------------------
-- Table structure for sale_products
-- ----------------------------
DROP TABLE IF EXISTS `sale_products`;
CREATE TABLE `sale_products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale` int(11) NOT NULL,
  `product` int(11) NULL DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `qty` float NOT NULL,
  `price` double NOT NULL,
  `subtotal` double NOT NULL,
  `unit` int(11) NULL DEFAULT NULL,
  `unit_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `charges_fee_total` double NULL DEFAULT NULL,
  `tax_total` double NULL DEFAULT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 151 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sale_products
-- ----------------------------
INSERT INTO `sale_products` VALUES (1, 1, 1, 'PR1-0001', 'Product 1', '', 1, 5, 5, 0, NULL, 0, 0, 5);
INSERT INTO `sale_products` VALUES (2, 1, 2, 'PR2-0001', 'Product 2', '', 1, 7, 7, 0, NULL, 0, 0, 7);
INSERT INTO `sale_products` VALUES (3, 2, 4, 'RIS-0001', 'product 3', '', 1, 4, 4, NULL, NULL, 0, 0, 4);
INSERT INTO `sale_products` VALUES (4, 2, 5, 'NUR-0001', 'Nur Rohman', '', 1, 10, 10, NULL, NULL, 0, 0, 10);
INSERT INTO `sale_products` VALUES (8, 5, 7, 'TVS-0001', 'TV Station Placement', 'TRANS TV', 1, 1000000, 1000000, NULL, NULL, 0, 0, 1000000);
INSERT INTO `sale_products` VALUES (9, 5, 6, 'RAP-0001', 'Radio Placement', 'Gen FM', 1, 500000, 500000, NULL, NULL, 0, 0, 500000);
INSERT INTO `sale_products` VALUES (10, 6, 8, 'ASD-0001', 'asdasd', '', 1, 1, 1, NULL, NULL, 0, 0, 1);
INSERT INTO `sale_products` VALUES (11, 6, 4, 'RIS-0001', 'Rifky Syaripudin', '', 1, 4, 4, NULL, NULL, 0, 0, 4);
INSERT INTO `sale_products` VALUES (12, 7, 8, 'ASD-0001', 'asdasd', '', 1, 1, 1, NULL, NULL, 0, 0, 1);
INSERT INTO `sale_products` VALUES (13, 7, 4, 'RIS-0001', 'Rifky Syaripudin', '', 1, 4, 4, NULL, NULL, 0, 0, 4);
INSERT INTO `sale_products` VALUES (14, 3, 6, 'RAP-0001', 'Radio Placement', 'Sonora FM', 1, 100000000, 100000000, NULL, NULL, 0, 0, 100000000);
INSERT INTO `sale_products` VALUES (15, 8, 9, 'PRP-0001', 'Pre Production', '', 1, 13200000, 13200000, NULL, NULL, 0, 0, 13200000);
INSERT INTO `sale_products` VALUES (21, 9, 10, 'KV&-0001', 'KV & Brochure', '', 1, 3000000, 3000000, 1, 'Unit', 0, 300000, 3300000);
INSERT INTO `sale_products` VALUES (28, 10, 6, 'RAP-0001', 'Radio Placement', '', 2, 300000, 600000, 2, 'Unit2', 0, 93000, 693000);
INSERT INTO `sale_products` VALUES (30, 11, 6, 'RAP-0001', 'Radio Placement', '', 2, 100000, 200000, 1, 'Unit1', 0, 42000, 242000);
INSERT INTO `sale_products` VALUES (31, 12, 6, 'RAP-0001', 'Radio Placement', '', 100, 100000, 10000000, 2, 'Unit2', 0, 1000000, 11000000);
INSERT INTO `sale_products` VALUES (52, 4, 7, 'TVS-0001', 'TV Station Placement', 'TRANS TV', 1, 1000000, 1000000, NULL, '', 0, 155000, 1155000);
INSERT INTO `sale_products` VALUES (53, 4, 9, 'PRP-0001', 'Pre Production', 'sdgdfgd', 4, 130948230000, 523792920000, 0, '', 0, 109996513200, 633789433200);
INSERT INTO `sale_products` VALUES (54, 4, 6, 'RAP-0001', 'Radio Placement', 'Gen FM', 1, -500000, -500000, NULL, '', 0, -77500, -577500);
INSERT INTO `sale_products` VALUES (55, 4, 7, 'TVS-0001', 'TV Station Placement', '', 1, 600000, 600000, 0, '', 0, 126000, 726000);
INSERT INTO `sale_products` VALUES (56, 4, 11, 'DIS-0001', 'discount', '', 21, -938293, -19704153, 0, '', 0, 0, -19704153);
INSERT INTO `sale_products` VALUES (57, 13, 6, 'RAP-0001', 'Radio Placement', 'Description for every item', 20, 10000, 200000, 3, 'Unit3', 0, 42000, 242000);
INSERT INTO `sale_products` VALUES (58, 13, 7, 'TVS-0001', 'TV Station Placement', '', 1, 200000, 200000, 0, '', 0, 20000, 220000);
INSERT INTO `sale_products` VALUES (90, 15, 6, 'RAP-0001', 'Radio Placement', 'Ini desc 1\ndesc 2\ndesc 3', 1, 200000, 200000, 1, 'Unit1', 0, 42000, 242000);
INSERT INTO `sale_products` VALUES (91, 15, 10, 'KV&-0001', 'KV & Brochure', '', 1, 30000, 30000, 1, 'Unit1', 0, 3000, 33000);
INSERT INTO `sale_products` VALUES (92, 15, 11, 'DIS-0001', 'discount', '', 1, -1000, -1000, 0, '', 0, -100, -1100);
INSERT INTO `sale_products` VALUES (93, 15, 9, 'PRP-0001', 'Pre Production', '', 1, 10000, 10000, 0, '', 0, 0, 10000);
INSERT INTO `sale_products` VALUES (105, 18, 12, 'service', 'service', '', 1, 1200000, 1200000, 0, '', 0, 0, 1200000);
INSERT INTO `sale_products` VALUES (106, 18, 13, 'PEN-0001', 'PENGARON', '', 1, 300000, 300000, 0, '', 0, 0, 300000);
INSERT INTO `sale_products` VALUES (107, 19, 12, 'service', 'service', '', 1, 1200000, 1200000, 0, '', 0, 0, 1200000);
INSERT INTO `sale_products` VALUES (114, 20, 12, 'service', 'service', '', 3, 1200000, 3600000, 0, '', 0, 0, 3600000);
INSERT INTO `sale_products` VALUES (115, 20, 13, 'PEN-0001', 'PENGARON', '', 5, 400000, 2000000, 0, '', 0, 0, 2000000);
INSERT INTO `sale_products` VALUES (119, 21, 14, 'SE2-0001', 'service 2', '', 1, 500000, 500000, 0, '', 0, 0, 500000);
INSERT INTO `sale_products` VALUES (120, 17, 15, 'SMM-0001', 'Social Media Maintenance', '', 12, 30000000, 360000000, 0, '', 0, 0, 360000000);
INSERT INTO `sale_products` VALUES (121, 17, 16, 'ACM-0001', 'Account Management', '', 12, 8500000, 102000000, 0, '', 0, 0, 102000000);
INSERT INTO `sale_products` VALUES (122, 17, 17, 'WEM-0001', 'Website Maintenance', '', 12, 11000000, 132000000, 0, '', 0, 0, 132000000);
INSERT INTO `sale_products` VALUES (123, 17, 18, 'COC-0001', 'Content Creation', '', 120, 250000, 30000000, 0, '', 0, 0, 30000000);
INSERT INTO `sale_products` VALUES (124, 17, 19, 'ADJ-0001', 'Adjusment', '', 1, -2000000, -2000000, 0, '', 0, 0, -2000000);
INSERT INTO `sale_products` VALUES (125, 22, 15, 'SMM-0001', 'Social Media Maintenance', '', 12, 30000000, 360000000, 0, '', 0, 0, 360000000);
INSERT INTO `sale_products` VALUES (126, 22, 16, 'ACM-0001', 'Account Management', '', 12, 8500000, 102000000, 0, '', 0, 0, 102000000);
INSERT INTO `sale_products` VALUES (127, 22, 17, 'WEM-0001', 'Website Maintenance', '', 12, 11000000, 132000000, 0, '', 0, 0, 132000000);
INSERT INTO `sale_products` VALUES (128, 22, 18, 'COC-0001', 'Content Creation', '', 120, 250000, 30000000, 0, '', 0, 0, 30000000);
INSERT INTO `sale_products` VALUES (129, 22, 19, 'ADJ-0001', 'Adjusment', '', 1, -2000000, -2000000, 0, '', 0, 0, -2000000);
INSERT INTO `sale_products` VALUES (138, 23, 15, 'SMM-0001', 'Social Media Maintenance', '', 12, 30000000, 360000000, 0, '', 0, 0, 360000000);
INSERT INTO `sale_products` VALUES (139, 23, 16, 'ACM-0001', 'Account Management', '', 12, 8500000, 102000000, 0, '', 0, 0, 102000000);
INSERT INTO `sale_products` VALUES (140, 23, 19, 'ADJ-0001', 'Adjusment', '', 1, -1000000, -1000000, 0, '', 0, 0, -1000000);
INSERT INTO `sale_products` VALUES (144, 24, 20, 'ASD-0001', 'asdfads', 'asdfa', 1, 10000, 10000, 0, '', 0, 0, 10000);
INSERT INTO `sale_products` VALUES (145, 16, 6, 'RAP-0001', 'Radio Placement', 'Ini desc 1\ndesc 2\ndesc 3', 1, 200000, 200000, 1, 'Unit1', 0, 42000, 242000);
INSERT INTO `sale_products` VALUES (146, 16, 10, 'KV&-0001', 'KV & Brochure', '', 1, 3000000, 3000000, 1, 'Unit1', 0, 300000, 3300000);
INSERT INTO `sale_products` VALUES (147, 16, 11, 'DIS-0001', 'discount', '', 1, -10000, -10000, 0, '', 0, -1000, -11000);
INSERT INTO `sale_products` VALUES (148, 14, 6, 'RAP-0001', 'Radio Placement', 'Ini desc 1\ndesc 2\ndesc 3', 1, 0, 0, 1, 'Unit1', 0, 0, 0);
INSERT INTO `sale_products` VALUES (149, 14, 10, 'KV&-0001', 'KV & Brochure', '', 1, 30000, 30000, 1, 'Unit1', 0, 3000, 33000);
INSERT INTO `sale_products` VALUES (150, 14, 11, 'DIS-0001', 'discount', '', 1, -1000, -1000, 0, '', 0, -100, -1100);

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `type` enum('invoice','quote') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer` int(11) NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_company` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `proposal` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `term` int(11) NULL DEFAULT NULL,
  `term_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `term_length` tinyint(5) NULL DEFAULT NULL,
  `date` date NOT NULL,
  `due_date` date NOT NULL,
  `purchase_order_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `currency_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_rate` double NOT NULL,
  `currency_prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency_suffix` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `currency_decimal_digit` int(2) NOT NULL DEFAULT 2,
  `currency_decimal_separator` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_thousand_separator` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('draft','open','paid','close') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subtotal` double NOT NULL,
  `total_charges_fee` double NOT NULL,
  `total_tax` double NOT NULL,
  `total` double NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `quote_converted` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  `quote_reference` int(11) NULL DEFAULT NULL COMMENT 'sales id with type quote',
  `paid_date` date NULL DEFAULT NULL COMMENT 'Date Paid when user has paid their INV',
  `paid_payment_method` int(11) NULL DEFAULT NULL,
  `paid_master_account` int(11) NULL DEFAULT NULL COMMENT 'ID From Master Account',
  `paid_acc_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'acc_name',
  `paid_acc_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'acc_number',
  `paid_amount` double NULL DEFAULT NULL COMMENT 'Amount Already Paid',
  `paid_note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `paid_by_member` int(11) NULL DEFAULT NULL,
  `outstanding_amount` double NULL DEFAULT NULL COMMENT 'Outstanding Amount (update on payment later (total - paid_amount))',
  `customer_received_date` date NULL DEFAULT NULL COMMENT 'P. Length',
  `brand` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `project` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `project_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `close_date` datetime(0) NULL DEFAULT NULL,
  `close_by` int(11) NULL DEFAULT NULL,
  `close_note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `payment_advice` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO `sales` VALUES (1, 12, 'invoice', '', 'INV/00001/1119', 1, 'Customer 1', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-04', '2019-11-10', '', 2, 'USD', 'Dollar', 1, '$', '', 2, '.', ',', 'open', 12, 0, 0, 12, NULL, 0, 0, '2019-11-04 07:26:34', '2020-01-10 07:39:54', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (2, 12, 'invoice', 'Pembelian domain', 'INV/00002/1119', 1, 'Customer 1', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-15', '2019-11-15', '', 2, 'USD', 'Dollar', 1, '$', '', 2, '.', ',', 'open', 14, 0, 0, 14, NULL, 0, 0, '2019-11-15 08:12:20', '2020-01-10 07:39:54', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (3, 13, 'invoice', '', 'INV/00001/1119', 3, 'PT Pertiwi Agung', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-20', '2019-11-20', '788787878', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 100000000, 0, 0, 100000000, NULL, 0, 0, '2019-11-20 17:25:35', '2020-01-10 07:39:54', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (4, 13, 'quote', 'Astria - Q2 - Offline Plcement', 'QUO/00001/1119', 4, 'PT Fasih Media Harapan', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-20', '2019-11-20', NULL, 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 523774315847, 0, 109996716700, 633771032547, 'Test Message', 1, 0, '2019-11-20 18:24:23', '2020-02-05 08:37:33', 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (5, 13, 'invoice', 'Astria - Q2 - Offline Plcement', 'INV/00002/1119', 4, 'PT Fasih Media Harapan', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-20', '2020-05-14', NULL, 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 1500000, 0, 0, 1500000, '', 0, 0, '2019-11-20 18:24:35', '2020-05-27 10:36:03', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (6, 12, 'quote', 'asdasdas', 'QUO/00002/1119', 1, 'Customer 1', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-22', '2019-11-22', NULL, 2, 'USD', 'Dollar', 1, '$', '', 2, '.', ',', 'open', 5, 0, 0, 5, '', 1, 0, '2019-11-22 09:00:13', '2020-01-10 07:39:54', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (7, 12, 'invoice', 'asdasdas', 'INV/00003/1119', 1, 'Customer 1', NULL, '', NULL, NULL, NULL, NULL, NULL, '2019-11-22', '2020-01-07', NULL, 2, 'USD', 'Dollar', 1, '$', '', 2, '.', ',', 'open', 5, 0, 0, 5, '', 0, 0, '2019-11-22 09:00:23', '2020-05-27 10:35:41', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (8, 13, 'invoice', 'Astria - Tvc, Refer to Quotation details 25 attached', 'INV/00001/0120', 3, 'PT Pertiwi Agung', NULL, 'Jl. DDN No. 16 Sukadanau\nCikarang Barat, Bekasi.\nJakarta Pusat, Jakarta Raya 17843\nIndonesia', NULL, NULL, NULL, NULL, NULL, '2019-02-28', '2020-01-07', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 13200000, 0, 0, 13200000, NULL, 0, 0, '2020-01-07 07:27:12', '2020-01-10 07:40:18', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (9, 13, 'invoice', '', 'INV/00001/0120', 5, 'Bank OCBC NISP', NULL, '', NULL, NULL, 2, '30 Days', 30, '2020-01-07', '2020-02-08', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 3000000, 0, 300000, 3300000, NULL, 0, 0, '2020-01-07 07:40:46', '2020-01-14 03:24:41', 5, 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3300000, '2020-01-13', '', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (10, 13, 'invoice', 'Pembayaran 1', 'INV/00002/0120', 3, 'PT Pertiwi Agung', NULL, 'Jl. Katulampa No.12', NULL, NULL, 1, '15 Days', 15, '2020-01-27', '2020-02-11', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 600000, 0, 93000, 693000, 'Mohon dibayar tepat waktu', 0, 0, '2020-01-27 12:08:09', '2020-01-28 04:27:08', 7, 2, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 693000, '2020-01-27', '', 'Project Name', '', NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (11, 13, 'invoice', 'Invoice 123', 'INV/00003/0120', 5, 'Bank OCBC NISP', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-01-28', '2020-01-28', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'paid', 200000, 0, 42000, 242000, '', 0, 0, '2020-01-28 08:08:15', '2020-01-29 02:50:07', 2, 2, NULL, 0, '2020-01-29', 1, 1, 'BCA', '100000001', 242000, '', 2, 242000, '2020-01-28', '', 'Project Name', '', NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (12, 13, 'invoice', 'test yulia', 'INV/00004/0120', 3, 'PT Pertiwi Agung', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-01-29', '2020-01-29', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'close', 10000000, 0, 1000000, 11000000, '', 0, 0, '2020-01-29 02:55:32', '2020-01-29 10:01:58', 2, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11000000, '2020-01-29', '', 'Project Name', '', '2020-01-29 17:01:58', 2, 'Test to close', NULL);
INSERT INTO `sales` VALUES (13, 13, 'quote', 'Test New quotes', 'QUO/00001/0220', 4, 'PT Fasih Media Harapan', NULL, 'Test Address', NULL, NULL, 2, '30 Days', 30, '2020-02-05', '2020-03-06', NULL, 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', NULL, 400000, 0, 62000, 462000, '', 0, 0, '2020-02-05 08:38:25', '2020-02-05 08:38:25', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (14, 13, 'quote', 'Quotes Test', 'QUO/00002/0220', 13, 'Pejabat Pembuat Komitmen Direktorat Kesehatan kerja', NULL, '', NULL, NULL, 2, '30 Days', 30, '2020-02-05', '2020-02-05', NULL, 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', NULL, 29000, 0, 2900, 31900, '', 1, 0, '2020-02-05 08:44:40', '2020-05-08 03:12:05', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (15, 13, 'invoice', 'Quotes Test', 'INV/00005/0220', 9, 'Yulia', NULL, '', NULL, NULL, 2, '30 Days', 30, '2020-02-13', '2020-02-05', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 239000, 0, 44900, 283900, '', 0, 0, '2020-02-13 07:52:01', '2020-02-14 04:01:27', 0, 2, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 283900, '1970-01-01', '', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (16, 13, 'invoice', 'Quotes Test', 'INV/00006/0220', 13, 'Pejabat Pembuat Komitmen Direktorat Kesehatan kerja', NULL, '', NULL, NULL, 2, '30 Days', 30, '2020-02-13', '2020-02-05', '', 3, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 3190000, 0, 341000, 3531000, '', 1, 0, '2020-02-13 09:48:52', '2020-05-08 03:11:52', 0, 2, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3531000, '1970-01-01', '', '', '', NULL, NULL, NULL, 3);
INSERT INTO `sales` VALUES (17, 18, 'quote', 'asdfasdf', 'QUO/00001/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', NULL, 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', NULL, 622000000, 0, 0, 622000000, '', 1, 0, '2020-03-05 04:43:07', '2020-03-05 04:58:52', 8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (18, 18, 'invoice', 'asdfasdf', 'INV/00001/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', '', 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 1500000, 0, 0, 1500000, '', 0, 1, '2020-03-05 04:43:11', '2020-03-05 04:50:47', 0, 8, 8, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1500000, '1970-01-01', '', '', '', NULL, NULL, NULL, 0);
INSERT INTO `sales` VALUES (19, 18, 'invoice', 'asdfasdf', 'INV/00002/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', NULL, 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'draft', 1200000, 0, 0, 1200000, '', 1, 1, '2020-03-05 04:48:40', '2020-03-05 04:50:49', 0, NULL, 8, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (20, 18, 'invoice', 'asdfasdf', 'INV/00003/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', '', 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 5600000, 0, 0, 5600000, '', 1, 1, '2020-03-05 04:52:16', '2020-03-05 04:59:10', 0, 8, 8, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5600000, '1970-01-01', '', '', '', NULL, NULL, NULL, 0);
INSERT INTO `sales` VALUES (21, 18, 'invoice', 'asdfasdf', 'INV/00004/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', '', 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 500000, 0, 0, 500000, '', 1, 1, '2020-03-05 04:52:50', '2020-03-05 04:55:03', 0, 8, 8, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500000, '1970-01-01', '', '', '', NULL, NULL, NULL, 0);
INSERT INTO `sales` VALUES (22, 18, 'invoice', 'asdfasdf', 'INV/00005/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', NULL, 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'draft', 622000000, 0, 0, 622000000, '', 1, 1, '2020-03-05 04:59:04', '2020-03-05 04:59:12', 0, NULL, 8, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales` VALUES (23, 18, 'invoice', 'asdfasdf', 'INV/00006/0320', 12, 'asdfa', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-05', '2020-03-05', '', 8, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', 'open', 461000000, 0, 0, 461000000, '', 1, 0, '2020-03-05 04:59:15', '2020-03-05 05:02:23', 0, 8, NULL, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 461000000, '1970-01-01', '', '', '', NULL, NULL, NULL, 0);
INSERT INTO `sales` VALUES (24, 17, 'quote', 'asfadf', 'QUO/00001/0320', 7, 'PT. Yulia', NULL, '', NULL, NULL, NULL, NULL, NULL, '2020-03-13', '2020-03-13', NULL, 7, 'IDR', 'Rupiah', 1, 'Rp ', NULL, 0, ',', '.', NULL, 10000, 0, 0, 10000, '', 0, 0, '2020-03-13 11:10:01', '2020-03-13 11:10:01', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sales_invoice_child
-- ----------------------------
DROP TABLE IF EXISTS `sales_invoice_child`;
CREATE TABLE `sales_invoice_child`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sale` int(11) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `term` int(11) NULL DEFAULT NULL,
  `term_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `term_length` tinyint(5) NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date` date NOT NULL,
  `item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `due_date` date NOT NULL,
  `status` enum('open','paid','close') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `payment_percentage` float NOT NULL,
  `payment_amount` double NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  `pay_date` date NULL DEFAULT NULL,
  `pay_method_id` int(11) NULL DEFAULT NULL,
  `pay_method_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pay_account_id` int(11) NULL DEFAULT NULL,
  `pay_account_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pay_account_number` varchar(225) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pay_notes` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `pay_by_member` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sales_invoice_child
-- ----------------------------
INSERT INTO `sales_invoice_child` VALUES (1, 1, 'INV/00001/1119/001', 0, NULL, NULL, NULL, '2019-11-04', NULL, NULL, '2019-11-04', NULL, 40, 4.8, 0, '2019-11-04 07:26:47', '2019-11-04 07:26:47', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales_invoice_child` VALUES (2, 3, 'INV/00001/1119/001', 0, NULL, NULL, NULL, '2019-11-23', NULL, NULL, '2019-11-23', NULL, 10, 10000000, 0, '2019-11-23 07:09:53', '2019-11-23 07:09:53', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales_invoice_child` VALUES (3, 12, 'INV/00004/0120/001', 2, '30 Days', 30, NULL, '2020-01-29', NULL, NULL, '2020-02-28', 'paid', 50, 5500000, 0, '2020-01-29 02:56:14', '2020-01-29 02:56:34', 2, NULL, NULL, '2020-01-29', 3, 'Cash', 0, '', '0', '', 2);
INSERT INTO `sales_invoice_child` VALUES (4, 12, 'INV/00004/0120/002', 1, '15 Days', 15, NULL, '2020-01-29', NULL, NULL, '2020-02-13', 'paid', 50, 5500000, 0, '2020-01-29 02:56:27', '2020-01-29 02:56:41', 2, NULL, NULL, '2020-01-29', 3, 'Cash', 0, '', '0', '', 2);
INSERT INTO `sales_invoice_child` VALUES (5, 10, 'INV/00002/0120/001', 1, '15 Days', 15, NULL, '2020-01-30', NULL, NULL, '2020-02-14', NULL, 29, 200970, 0, '2020-01-30 02:34:56', '2020-01-30 02:34:56', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales_invoice_child` VALUES (6, 18, 'INV/00001/0320/001', 0, NULL, NULL, NULL, '2020-03-05', NULL, NULL, '2020-03-05', NULL, 8.33333, 100000, 0, '2020-03-05 04:44:33', '2020-03-05 04:44:33', 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales_invoice_child` VALUES (7, 23, 'INV/00006/0320/001', 0, NULL, NULL, NULL, '2020-03-06', NULL, 'testing', '2020-03-05', NULL, 8.15217, 37581503.7, 0, '2020-03-05 05:02:02', '2020-03-06 03:54:56', 8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sales_invoice_child` VALUES (8, 16, 'INV/00006/0220/001', 1, '15 Days', 15, 'set', '2020-03-06', 'test', 'sets', '2020-03-21', NULL, 14.1603, 500000, 0, '2020-03-06 08:11:19', '2020-03-06 08:11:19', 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` longblob NOT NULL,
  INDEX `sessions_timestamp`(`timestamp`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('s6jot5gqt5hsjo4acfj2oqgstlkq5aos', '::1', 1590550655, 0x5F5F63695F6C6173745F726567656E65726174657C693A313539303535303635353B6B6162756C6B616E53657474696E67737C613A31383A7B733A383A226170705F6E616D65223B733A353A22506179646F223B733A31313A226170705F76657273696F6E223B733A383A22312E302E302E3235223B733A31313A22646174655F666F726D6174223B733A353A22642F6D2F59223B733A31363A2264656661756C745F63757272656E6379223B733A333A22555344223B733A383A226C616E6775616765223B733A373A22656E676C697368223B733A31363A226D6574615F6465736372697074696F6E223B733A303A22223B733A31323A226D6574615F6B6579776F7264223B733A303A22223B733A31303A226D6574615F7469746C65223B733A353A22506179646F223B733A31373A226E756D6265725F6F665F646563696D616C223B733A313A2230223B733A31373A22736570617261746F725F646563696D616C223B733A313A222C223B733A31383A22736570617261746F725F74686F7573616E64223B733A313A222E223B733A31303A227365727665725F656E76223B733A31313A22646576656C6F706D656E74223B733A31313A22736D74705F63727970746F223B733A303A22223B733A393A22736D74705F686F7374223B733A303A22223B733A31333A22736D74705F70617373776F7264223B733A303A22223B733A393A22736D74705F706F7274223B733A303A22223B733A393A22736D74705F75736572223B733A303A22223B733A373A2274657374696E67223B733A333A22312E32223B7D);
INSERT INTO `sessions` VALUES ('6lugsse234vdlo2gtf2rl5h1k811bphm', '::1', 1590551928, 0x5F5F63695F6C6173745F726567656E65726174657C693A313539303535313737383B6B6162756C6B616E53657474696E67737C613A31383A7B733A383A226170705F6E616D65223B733A353A22506179646F223B733A31313A226170705F76657273696F6E223B733A383A22312E302E302E3235223B733A31313A22646174655F666F726D6174223B733A353A22642F6D2F59223B733A31363A2264656661756C745F63757272656E6379223B733A333A22555344223B733A383A226C616E6775616765223B733A373A22656E676C697368223B733A31363A226D6574615F6465736372697074696F6E223B733A303A22223B733A31323A226D6574615F6B6579776F7264223B733A303A22223B733A31303A226D6574615F7469746C65223B733A353A22506179646F223B733A31373A226E756D6265725F6F665F646563696D616C223B733A313A2230223B733A31373A22736570617261746F725F646563696D616C223B733A313A222C223B733A31383A22736570617261746F725F74686F7573616E64223B733A313A222E223B733A31303A227365727665725F656E76223B733A31313A22646576656C6F706D656E74223B733A31313A22736D74705F63727970746F223B733A303A22223B733A393A22736D74705F686F7374223B733A303A22223B733A31333A22736D74705F70617373776F7264223B733A303A22223B733A393A22736D74705F706F7274223B733A303A22223B733A393A22736D74705F75736572223B733A303A22223B733A373A2274657374696E67223B733A333A22312E32223B7D);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `key` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('app_name', 'Paydo');
INSERT INTO `settings` VALUES ('app_version', '1.0.0.25');
INSERT INTO `settings` VALUES ('date_format', 'd/m/Y');
INSERT INTO `settings` VALUES ('default_currency', 'USD');
INSERT INTO `settings` VALUES ('language', 'english');
INSERT INTO `settings` VALUES ('meta_description', '');
INSERT INTO `settings` VALUES ('meta_keyword', '');
INSERT INTO `settings` VALUES ('meta_title', 'Paydo');
INSERT INTO `settings` VALUES ('number_of_decimal', '0');
INSERT INTO `settings` VALUES ('separator_decimal', ',');
INSERT INTO `settings` VALUES ('separator_thousand', '.');
INSERT INTO `settings` VALUES ('server_env', 'development');
INSERT INTO `settings` VALUES ('smtp_crypto', '');
INSERT INTO `settings` VALUES ('smtp_host', '');
INSERT INTO `settings` VALUES ('smtp_password', '');
INSERT INTO `settings` VALUES ('smtp_port', '');
INSERT INTO `settings` VALUES ('smtp_user', '');
INSERT INTO `settings` VALUES ('testing', '1.2');

-- ----------------------------
-- Table structure for sys_module
-- ----------------------------
DROP TABLE IF EXISTS `sys_module`;
CREATE TABLE `sys_module`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alias` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Usualy for active menu',
  `is_parent` tinyint(4) NULL DEFAULT 0,
  `module_order` tinyint(4) NULL DEFAULT NULL,
  `module_link` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `module_level` tinyint(4) NULL DEFAULT NULL COMMENT '1 = \"Superadmin\", 2=\"Owner\", 3 = \"User PT\"',
  `module_icon` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_deleted` tinyint(4) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_module
-- ----------------------------
INSERT INTO `sys_module` VALUES (1, 'Sale', 'sale', 1, 1, '#', 3, 'icon-price-tag', 0);
INSERT INTO `sys_module` VALUES (2, 'Purchases', 'purchase', 1, 2, '#', 3, 'icon-credit-card', 0);
INSERT INTO `sys_module` VALUES (3, 'Contacts', 'contact', 1, 3, '#', 3, 'icon-address-book', 0);
INSERT INTO `sys_module` VALUES (4, 'Product & Service', 'product', 1, 4, '#', 3, 'icon-cube4', 0);
INSERT INTO `sys_module` VALUES (5, 'Reports', 'report', 1, 5, '#', 3, 'icon-graph', 0);
INSERT INTO `sys_module` VALUES (6, 'Settings', 'setting', 1, 6, '#', 3, 'icon-cog', 0);

-- ----------------------------
-- Table structure for sys_module_sub
-- ----------------------------
DROP TABLE IF EXISTS `sys_module_sub`;
CREATE TABLE `sys_module_sub`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_link` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alias` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Use for menu and assigned menu validation for user',
  `sub_order` tinyint(4) NULL DEFAULT NULL,
  `module_id` int(11) NULL DEFAULT NULL,
  `is_parent` tinyint(4) NULL DEFAULT 0,
  `parent_id` int(11) NULL DEFAULT NULL COMMENT 'Module Sub ID',
  `is_deleted` tinyint(4) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_module_sub
-- ----------------------------
INSERT INTO `sys_module_sub` VALUES (1, 'Invoice', 'sale/invoices', 'sale/invoice', 1, 1, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (2, 'Quotes', 'sale/quotes', 'sale/quote', 2, 1, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (3, 'Orders', 'purchase/orders', 'purchase/order', 1, 2, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (4, 'Contacts', 'contacts', 'contact/contact', 1, 3, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (5, 'Groups', 'contacts/groups', 'contact/group', 2, 3, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (6, 'Products', 'products', 'product/product', 1, 4, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (7, 'Services', 'products/services', 'product/service', 2, 4, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (8, 'Categories', 'products/categories', 'product/category', 3, 4, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (9, 'Charges Fee', 'products/charges_fees', 'product/charges_fee', 4, 4, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (10, 'Products', '#', '#', 1, 5, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (11, 'Sales', '#', 'report/sale', 2, 5, 1, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (12, 'Invoices', 'reports/sales/invoices', 'report/sale/invoice', 1, 5, 0, 11, 0);
INSERT INTO `sys_module_sub` VALUES (13, 'Purchases', '#', 'report/purchases', 3, 5, 1, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (14, 'Invoices', 'reports/purchases/invoices', 'report/purchase/invoice', 1, 5, 0, 13, 0);
INSERT INTO `sys_module_sub` VALUES (15, 'Organization', 'settings/organization', 'setting/organization', 1, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (16, 'Format & Template', 'settings/format', 'setting/format', 2, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (17, 'Taxes', 'settings/taxes', 'setting/tax', 3, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (18, 'Currencies', 'settings/currencies', 'setting/currencie', 4, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (19, 'Units', 'settings/units', 'setting/unit', 5, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (20, 'Terms', 'settings/terms', 'setting/term', 6, 6, 0, NULL, 0);
INSERT INTO `sys_module_sub` VALUES (21, 'Bank', 'settings/bank', 'setting/bank', 7, 6, 0, NULL, 0);

-- ----------------------------
-- Table structure for taxes
-- ----------------------------
DROP TABLE IF EXISTS `taxes`;
CREATE TABLE `taxes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rate` float NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  `is_ppn` tinyint(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of taxes
-- ----------------------------
INSERT INTO `taxes` VALUES (1, 13, 'PPN', 10, 0, '2020-01-07 09:07:42', '2020-01-28 06:56:00', 5, 2, NULL, 1);
INSERT INTO `taxes` VALUES (2, 13, 'ASF', 10, 0, '2020-01-10 10:52:54', '2020-01-10 10:52:54', 5, NULL, NULL, NULL);
INSERT INTO `taxes` VALUES (3, 13, 'ASF 5%', 5, 0, '2020-01-10 10:53:09', '2020-02-05 05:09:09', 5, 2, NULL, NULL);

-- ----------------------------
-- Table structure for terms
-- ----------------------------
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `length` tinyint(5) NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `date_modified` datetime(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `user_added` int(10) NOT NULL,
  `user_modified` int(10) NULL DEFAULT NULL,
  `user_deleted` int(10) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  `is_default` tinyint(2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of terms
-- ----------------------------
INSERT INTO `terms` VALUES (1, 13, '15 Days', 15, 0, '2020-01-07 09:08:07', '2020-02-07 10:38:48', 5, 2, NULL, NULL, 1);
INSERT INTO `terms` VALUES (2, 13, '30 Days', 30, 0, '2020-01-07 09:08:17', '2020-01-09 04:36:33', 5, 2, NULL, NULL, NULL);
INSERT INTO `terms` VALUES (3, 17, '30 Days', 30, 0, '2020-02-05 08:40:56', '2020-02-05 08:40:56', 2, NULL, NULL, NULL, NULL);
INSERT INTO `terms` VALUES (4, 23, '15 Days', 15, 0, '2020-02-28 02:57:16', '2020-02-28 02:57:16', 0, NULL, NULL, NULL, 1);

SET FOREIGN_KEY_CHECKS = 1;
