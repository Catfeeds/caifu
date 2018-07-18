-- MySQL dump 10.13  Distrib 5.6.26, for osx10.8 (x86_64)
--
-- Host: testzqtv.mysql.rds.aliyuncs.com    Database: cfrs
-- ------------------------------------------------------
-- Server version	5.6.70

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED='20dc7a0e-3224-11e8-a47c-6c92bf2bfb45:1-1588602,
3fcf96e9-850c-11e4-abc6-d89d672a7358:1-13386932,
403eb802-850c-11e4-abc6-d89d672a03e0:1-16697139,
59284ceb-ab68-11e6-b093-6c92bf367318:1-10635670,
6906ca5c-0acc-11e8-a3f0-2880239dce10:1-2';

--
-- Table structure for table `clean_data`
--

DROP TABLE IF EXISTS `clean_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clean_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `clean_table` varchar(25) DEFAULT NULL COMMENT '重新统计表',
  `clean_date` int(11) DEFAULT NULL COMMENT '重新统计日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='重新统计日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `introduction` varchar(128) NOT NULL DEFAULT '' COMMENT '宣言',
  `user_id` int(11) NOT NULL COMMENT '社长ID',
  `address` text NOT NULL COMMENT '地址json',
  `member` smallint(4) NOT NULL COMMENT '人数',
  `investment` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT '在库投资金额',
  `notice` varchar(255) DEFAULT '' COMMENT '公告',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-正常 1-已禁用 2-已解散',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1109 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_amount_log`
--

DROP TABLE IF EXISTS `club_amount_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_amount_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL COMMENT '合作社ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `amount` decimal(14,4) NOT NULL COMMENT '金额',
  `type` tinyint(3) NOT NULL COMMENT '0-社员投资 1-社员投资回款 2-社员退社',
  `state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-未更新订单在社金额 1-已更新',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10054 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_join`
--

DROP TABLE IF EXISTS `club_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_join` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `club_id` int(11) NOT NULL COMMENT '合作社ID',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态 0-待批复 1-已入社 2-拒绝入社 3-已退社 4-已解散',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `club_id` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27586 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_advance_fees`
--

DROP TABLE IF EXISTS `order_advance_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_advance_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单sn',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `unit_code` varchar(32) NOT NULL DEFAULT '' COMMENT '业主单元编码',
  `address` text NOT NULL COMMENT '冲抵详细地址jason',
  `owner_toll` text NOT NULL COMMENT '收费项',
  `notify_state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '收费系统通知状态：0 未通知 1 通知成功 2 通知失败 ',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=112276 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='冲抵物业费费';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_appreciation_fees`
--

DROP TABLE IF EXISTS `order_appreciation_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_appreciation_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单sn',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `unit_code` varchar(32) DEFAULT '' COMMENT '业主单元编码',
  `address` text NOT NULL COMMENT '冲抵详细地址jason',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44821 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='增值宝';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_master`
--

DROP TABLE IF EXISTS `order_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_master` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(32) NOT NULL DEFAULT '',
  `trade_no` varchar(64) NOT NULL DEFAULT '' COMMENT '金融渠道订单号',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `model_name` varchar(16) NOT NULL DEFAULT '' COMMENT '订单类别 欠费[PropertyFees]物业费[AdvancePropertyFees]停车费[ParkingFees]增值[Appreciation]',
  `investment_amount` decimal(12,4) NOT NULL COMMENT '投资金额',
  `profit_rate` decimal(6,4) NOT NULL COMMENT '利率',
  `user_profit_rate` decimal(6,4) NOT NULL COMMENT '用户利率',
  `profit_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-现金 1-饭票 2-现金+饭票',
  `cash_profit_amount` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '现金收益',
  `fp_profit_amount` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '饭票奖励',
  `offset_fees` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '冲抵费用（物业费、停车费）',
  `balance_amount` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '结余金额',
  `months` tinyint(3) NOT NULL COMMENT '投资时长（月）',
  `begin_time` int(11) NOT NULL COMMENT '起始时间',
  `stop_time` int(11) NOT NULL COMMENT '到期时间',
  `last_sn` varchar(32) DEFAULT NULL COMMENT '历史订单',
  `next_sn` varchar(32) DEFAULT NULL COMMENT '续投后订单',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `pay_channel` enum('QUICKPAY','TLPOS','LLPAY','BALANCEPAY') DEFAULT NULL COMMENT '支付渠道',
  `pay_sn` varchar(32) DEFAULT NULL COMMENT '支付订单号',
  `pay_time` int(11) DEFAULT NULL COMMENT '支付时间',
  `recommend_mobile` char(11) DEFAULT '' COMMENT '推荐人手机',
  `platform_code` tinyint(3) NOT NULL DEFAULT '100' COMMENT '100 - 彩之云 101 - 银湾',
  `channel_code` tinyint(3) NOT NULL DEFAULT '100' COMMENT '100 - 彩付宝',
  `device_source` varchar(16) DEFAULT '' COMMENT '订单设备来源',
  `created_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '创建ip',
  `coupon_id` int(11) unsigned DEFAULT NULL COMMENT '优惠券ID',
  `split_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分账状态（0-未分账，1-已分账）',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区uuid',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `sn` (`sn`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `community_code` (`community_code`)
) ENGINE=InnoDB AUTO_INCREMENT=60001 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='定点主表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_parking_fees`
--

DROP TABLE IF EXISTS `order_parking_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_parking_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单sn',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `unit_code` varchar(32) DEFAULT '' COMMENT '业主单元编码',
  `address` text NOT NULL COMMENT '详细地址jason',
  `channel` tinyint(3) NOT NULL DEFAULT '100' COMMENT '100 彩之云 101 易停车',
  `system_order` varchar(32) DEFAULT NULL COMMENT '易停车订单',
  `rule` text NOT NULL COMMENT '车库类型',
  `notify_state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 未通知 1 成功 2 失败',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4875 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='冲抵停车费';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_parking_space_fees`
--

DROP TABLE IF EXISTS `order_parking_space_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_parking_space_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `address` text NOT NULL,
  `channel` tinyint(3) NOT NULL DEFAULT '100' COMMENT '100 默认  101 易停',
  `parking_lot_code` varchar(32) NOT NULL DEFAULT '',
  `system_order` varchar(32) NOT NULL DEFAULT '',
  `rule` text COMMENT '车库类型',
  `notify_state` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1703 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_property_fees`
--

DROP TABLE IF EXISTS `order_property_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_property_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单SN',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `unit_code` varchar(32) NOT NULL DEFAULT '' COMMENT '业主单元编码',
  `address` text NOT NULL COMMENT '详细地址jason',
  `owner_toll` text NOT NULL COMMENT '收费项',
  `bills` text NOT NULL COMMENT '欠费账单',
  `system_order` varchar(32) NOT NULL COMMENT '物业收费系统订单',
  `notify_state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 未通知 1 成功  2 失败',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10637 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='冲抵物业历史欠费';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_ydb_fees`
--

DROP TABLE IF EXISTS `order_ydb_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_ydb_fees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单sn',
  `community_code` varchar(64) NOT NULL DEFAULT '' COMMENT '小区唯一编码',
  `unit_code` varchar(32) NOT NULL DEFAULT '' COMMENT '单元编码',
  `address` text NOT NULL COMMENT '冲抵详细地址jason',
  `fee` decimal(6,2) DEFAULT NULL COMMENT '赠送金额',
  `third_order` varchar(64) DEFAULT NULL,
  `notify_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-已通知 2-未通知',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6529 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organize`
--

DROP TABLE IF EXISTS `organize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_uuid` varchar(50) NOT NULL COMMENT '小区uuid',
  `community_name` varchar(50) NOT NULL DEFAULT '' COMMENT '小区名称',
  `parent1_uuid` varchar(50) NOT NULL DEFAULT '' COMMENT '片区UUID',
  `parent1_name` varchar(50) NOT NULL DEFAULT '' COMMENT '片区名',
  `parent2_uuid` varchar(50) NOT NULL DEFAULT '' COMMENT '事业部UUID',
  `parent2_name` varchar(50) NOT NULL DEFAULT '' COMMENT '事业部名',
  `parent3_uuid` varchar(50) NOT NULL DEFAULT '' COMMENT '大区UUID',
  `parent3_name` varchar(50) NOT NULL DEFAULT '' COMMENT '大区名',
  `parent4_uuid` varchar(50) NOT NULL DEFAULT '' COMMENT '地区UUID',
  `parent4_name` varchar(50) NOT NULL DEFAULT '' COMMENT '地区事业部/小股',
  `parent5_uuid` varchar(50) NOT NULL DEFAULT '' COMMENT '集团UUID',
  `parent5_name` varchar(50) NOT NULL DEFAULT '' COMMENT '集团名',
  `parent6_uuid` varchar(50) NOT NULL DEFAULT '',
  `parent6_name` varchar(50) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `community_uuid` (`community_uuid`) USING BTREE,
  KEY `community_name` (`community_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5812 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='组织架构临时表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organize_kpi_target`
--

DROP TABLE IF EXISTS `organize_kpi_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organize_kpi_target` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `o_group` varchar(20) NOT NULL DEFAULT '' COMMENT '集团',
  `large_area` varchar(20) NOT NULL DEFAULT '' COMMENT '大区',
  `department` varchar(20) NOT NULL DEFAULT '' COMMENT '事业部',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '片区',
  `project` varchar(20) NOT NULL DEFAULT '' COMMENT '项目',
  `month01` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '1月',
  `month02` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '2月',
  `month03` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '3月',
  `month04` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '4月',
  `month05` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '5月',
  `month06` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '6月',
  `month07` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '7月',
  `month08` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '8月',
  `month09` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '9月',
  `month10` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '10月',
  `month11` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '11月',
  `month12` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '12月',
  `year` int(10) unsigned NOT NULL COMMENT '年份',
  `annual` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '全年kpi',
  `ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `utime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `large_area` (`large_area`),
  KEY `department` (`department`),
  KEY `area` (`area`),
  KEY `project` (`project`),
  KEY `year` (`year`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='组织架构kpi目标配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organize_xls`
--

DROP TABLE IF EXISTS `organize_xls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organize_xls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(50) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `name1` varchar(20) DEFAULT NULL,
  `name2` varchar(20) DEFAULT NULL,
  `name3` varchar(20) DEFAULT NULL,
  `name4` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3270 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_area_user`
--

DROP TABLE IF EXISTS `stat_area_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_area_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `o_group` varchar(20) NOT NULL DEFAULT '' COMMENT '集团',
  `large_area` varchar(20) NOT NULL DEFAULT '' COMMENT '大区',
  `department` varchar(20) NOT NULL DEFAULT '' COMMENT '事业群',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '小区',
  `project` varchar(20) NOT NULL DEFAULT '' COMMENT '项目',
  `owner_num` int(11) NOT NULL DEFAULT '0' COMMENT '业主数',
  `staff_num` int(11) NOT NULL DEFAULT '0' COMMENT '员工数',
  `investment_num` int(11) NOT NULL DEFAULT '0' COMMENT '投资户数',
  `flushing_num` int(11) NOT NULL DEFAULT '0' COMMENT '冲抵户数',
  `recast_num` int(11) NOT NULL DEFAULT '0' COMMENT '复投户数',
  `referee_num` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人数',
  `president_num` int(11) NOT NULL DEFAULT '0' COMMENT '社长数',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `organize` (`o_group`,`large_area`,`department`,`area`,`project`)
) ENGINE=InnoDB AUTO_INCREMENT=73638 DEFAULT CHARSET=utf8 COMMENT='地区用户统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_club`
--

DROP TABLE IF EXISTS `stat_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_club` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `club_id` int(11) NOT NULL COMMENT '合作社ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '合作社名称',
  `created_at` int(11) NOT NULL COMMENT '合作社创建时间',
  `username` varchar(16) DEFAULT NULL COMMENT '社长姓名',
  `mobile` char(11) DEFAULT NULL COMMENT '社长手机号码',
  `member` smallint(4) NOT NULL COMMENT '社员人数',
  `investment_person` smallint(4) NOT NULL COMMENT '在投人数',
  `investment_fee` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT '在库投资金额',
  `annualized_fee` decimal(10,2) DEFAULT NULL COMMENT '年化金额',
  `offset_fee` decimal(10,2) DEFAULT NULL COMMENT '冲抵订单金额',
  `o_group` varchar(20) NOT NULL DEFAULT '' COMMENT '集团',
  `large_area` varchar(20) NOT NULL DEFAULT '' COMMENT '大区',
  `department` varchar(20) NOT NULL DEFAULT '' COMMENT '事业群',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '小区',
  `project` varchar(20) NOT NULL DEFAULT '' COMMENT '项目',
  `created_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `in_club_id` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57107 DEFAULT CHARSET=utf8 COMMENT='合作社统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_daily`
--

DROP TABLE IF EXISTS `stat_daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_daily` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `date` int(11) DEFAULT NULL COMMENT '日期',
  `property_fee` decimal(10,2) DEFAULT NULL COMMENT '物业宝费用',
  `parking_fee` decimal(10,2) DEFAULT NULL COMMENT '停车宝费用',
  `offset_fee` decimal(10,2) DEFAULT NULL COMMENT '冲抵总金额',
  `offset_num` int(11) DEFAULT NULL COMMENT '冲抵总单数',
  `investment_amounts` decimal(10,2) DEFAULT NULL COMMENT '资金端交易额',
  `investment_num` int(11) DEFAULT NULL COMMENT '资金端交易单数',
  `assets_amounts` decimal(10,2) DEFAULT NULL COMMENT '资产端交易额',
  `assets_num` int(11) DEFAULT NULL COMMENT '资产端交易单数',
  `manager_num` int(11) DEFAULT NULL COMMENT '社长人数',
  `member_num` int(11) DEFAULT NULL COMMENT '社员人数',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `in_data` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=2681 DEFAULT CHARSET=utf8 COMMENT='日报统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_kpi`
--

DROP TABLE IF EXISTS `stat_kpi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_kpi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `o_group` varchar(20) NOT NULL DEFAULT '' COMMENT '集团',
  `large_area` varchar(20) NOT NULL DEFAULT '' COMMENT '大区',
  `department` varchar(20) NOT NULL DEFAULT '' COMMENT '事业群',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '小区',
  `project` varchar(20) NOT NULL DEFAULT '' COMMENT '项目',
  `date` int(11) DEFAULT NULL COMMENT '日期',
  `gmv` int(11) NOT NULL DEFAULT '0' COMMENT 'gmv',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `in_date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=27325 DEFAULT CHARSET=utf8 COMMENT='kpi统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_order_info`
--

DROP TABLE IF EXISTS `stat_order_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_order_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `date` int(11) DEFAULT NULL COMMENT '订单日期',
  `sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_name` varchar(16) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `mobile` char(11) DEFAULT NULL COMMENT '用户手机',
  `idcard_number` char(20) NOT NULL DEFAULT '' COMMENT '用户身份证',
  `recommend_name` varchar(16) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `recommend_mobile` char(11) DEFAULT NULL COMMENT '推荐人手机',
  `profit_amount` decimal(10,4) DEFAULT '0.0000' COMMENT '推荐人收益',
  `employee_type` char(1) DEFAULT NULL COMMENT '0 内部员工 1 外员员工',
  `club_id` int(11) NOT NULL COMMENT '合作社ID',
  `club_created_at` int(11) NOT NULL COMMENT '合作社创建时间',
  `address` text NOT NULL COMMENT '详细地址json',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `in_sn` (`sn`)
) ENGINE=InnoDB AUTO_INCREMENT=37939 DEFAULT CHARSET=utf8 COMMENT='订单信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_user_club`
--

DROP TABLE IF EXISTS `stat_user_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_user_club` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `username` varchar(16) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `idcard_number` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `club_id` int(11) NOT NULL DEFAULT '0' COMMENT '合作社ID',
  `club_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '合作社社长用户ID',
  `club_name` varchar(32) NOT NULL DEFAULT '' COMMENT '合作社名称',
  `join_club_time` int(11) NOT NULL DEFAULT '0' COMMENT '入社时间',
  `o_group` varchar(20) NOT NULL DEFAULT '' COMMENT '集团',
  `large_area` varchar(20) NOT NULL DEFAULT '' COMMENT '大区',
  `department` varchar(20) NOT NULL DEFAULT '' COMMENT '事业群',
  `area` varchar(20) NOT NULL DEFAULT '' COMMENT '小区',
  `project` varchar(20) NOT NULL DEFAULT '' COMMENT '项目',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `club_id` (`club_id`),
  KEY `created_at` (`created_at`),
  KEY `join_club_time` (`join_club_time`),
  KEY `organize` (`large_area`,`department`,`area`,`project`)
) ENGINE=InnoDB AUTO_INCREMENT=424749 DEFAULT CHARSET=utf8 COMMENT='用户合作社统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stat_users`
--

DROP TABLE IF EXISTS `stat_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stat_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `date` int(11) DEFAULT NULL COMMENT '日期',
  `user_num` int(11) DEFAULT NULL COMMENT '用户人数',
  `recommend_num` int(11) DEFAULT NULL COMMENT '推荐人数',
  `club_num` int(11) DEFAULT NULL COMMENT '合作社数',
  `member_num` int(11) DEFAULT NULL COMMENT '社员人数',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `in_data` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=3556 DEFAULT CHARSET=utf8 COMMENT='用户统计表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_idcard`
--

DROP TABLE IF EXISTS `user_idcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_idcard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `name` varchar(16) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard_number` char(20) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `idcard_front` varchar(64) DEFAULT '' COMMENT '身份证正面',
  `idcard_back` varchar(64) DEFAULT '' COMMENT '身份证反面',
  `syn_state` tinyint(3) NOT NULL DEFAULT '0' COMMENT '同步合和年状态 0-未同步 1-已同步',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=35033 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户身份认证';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_master`
--

DROP TABLE IF EXISTS `user_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_master` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(32) NOT NULL COMMENT '用户标示',
  `mobile` char(11) DEFAULT NULL COMMENT '用户手机',
  `from_source` tinyint(3) NOT NULL DEFAULT '100' COMMENT '来源 100-彩之云',
  `pay_passwd` varchar(32) DEFAULT NULL COMMENT '支付密码',
  `fp_amount` decimal(14,4) NOT NULL DEFAULT '0.0000' COMMENT '饭票奖励余额',
  `income_amount` decimal(14,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '收益金额',
  `integration` int(11) NOT NULL DEFAULT '0' COMMENT '积分值',
  `check` varchar(16) NOT NULL DEFAULT '0,0,0' COMMENT '身份认证,密码设置,绑卡',
  `deleted` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-正常 1-已删除',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `customer_id` (`customer_id`,`from_source`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=137455 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户信息主表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_recommend_log`
--

DROP TABLE IF EXISTS `user_recommend_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_recommend_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `model_name` varchar(16) NOT NULL DEFAULT '' COMMENT '订单类型',
  `recommend_id` int(11) NOT NULL COMMENT '推荐人ID',
  `recommend_mobile` char(11) NOT NULL DEFAULT '' COMMENT '推荐人手机',
  `profit_amount` decimal(10,4) DEFAULT '0.0000' COMMENT '收益',
  `type` enum('0','1') DEFAULT '1' COMMENT '0 退单 1 投资',
  `created_at` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `sn` (`sn`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=49864 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-18 18:41:50
