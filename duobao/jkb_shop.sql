-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-12-29 11:52:43
-- 服务器版本： 5.6.26
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jkb_shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `think_admin`
--

CREATE TABLE IF NOT EXISTS `think_admin` (
  `id` int(11) NOT NULL,
  `adm_name` varchar(255) NOT NULL,
  `adm_password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_admin`
--

INSERT INTO `think_admin` (`id`, `adm_name`, `adm_password`) VALUES
(1, 'admin', '96e79218965eb72c92a549dd5a330112');

-- --------------------------------------------------------

--
-- 表的结构 `think_goods`
--

CREATE TABLE IF NOT EXISTS `think_goods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_price` double(11,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `unit_price` decimal(11,2) NOT NULL,
  `number` int(11) NOT NULL,
  `pay_number` int(11) NOT NULL,
  `description` text NOT NULL,
  `creat_time` int(11) NOT NULL,
  `begin_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0表示未开始，1表示进行中，2表示已结束',
  `lucky_number` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `issue` int(11) NOT NULL,
  `publish_time` int(11) DEFAULT NULL,
  `periods` int(11) NOT NULL COMMENT '商品期数'
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_goods`
--

INSERT INTO `think_goods` (`id`, `name`, `total_price`, `image`, `unit_price`, `number`, `pay_number`, `description`, `creat_time`, `begin_time`, `end_time`, `type`, `lucky_number`, `user_id`, `issue`, `publish_time`, `periods`) VALUES
(327, '三星手机', 1000.00, '/Public/public1/admin/css/editor/editor/attached/image/20151228/20151228130249_12904.png', '100.00', 10, 0, '此处填写商品图文详情！', 1451250193, 1451250541, 0, 1, NULL, NULL, 201512327, NULL, 5),
(328, '三星手机', 1000.00, '/Public/public1/admin/css/editor/editor/attached/image/20151228/20151228130249_12904.png', '100.00', 10, 0, '此处填写商品图文详情！', 1451250193, 0, 0, 0, NULL, NULL, 0, NULL, 5),
(329, '三星手机', 1000.00, '/Public/public1/admin/css/editor/editor/attached/image/20151228/20151228130249_12904.png', '100.00', 10, 0, '此处填写商品图文详情！', 1451250193, 0, 0, 0, NULL, NULL, 0, NULL, 5),
(330, '三星手机', 1000.00, '/Public/public1/admin/css/editor/editor/attached/image/20151228/20151228130249_12904.png', '100.00', 10, 0, '此处填写商品图文详情！', 1451250193, 0, 0, 0, NULL, NULL, 0, NULL, 5),
(331, '三星手机', 1000.00, '/Public/public1/admin/css/editor/editor/attached/image/20151228/20151228130249_12904.png', '100.00', 10, 0, '此处填写商品图文详情！', 1451250193, 0, 0, 0, NULL, NULL, 0, NULL, 5);

-- --------------------------------------------------------

--
-- 表的结构 `think_order`
--

CREATE TABLE IF NOT EXISTS `think_order` (
  `id` int(11) NOT NULL,
  `notice_sn` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `is_paid` int(11) NOT NULL COMMENT '0表示未支付，1表示支付',
  `user_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `money` decimal(20,0) NOT NULL,
  `out_notice_sn` varchar(255) DEFAULT NULL,
  `lucky_number` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_order`
--

INSERT INTO `think_order` (`id`, `notice_sn`, `create_time`, `pay_time`, `is_paid`, `user_id`, `goods_id`, `number`, `money`, `out_notice_sn`, `lucky_number`) VALUES
(1, '20151208865', 1449305154, 1449305157, 1, 1, 1, 10, '10', '32432432535345444', '01;23;56;78'),
(2, '20151208867', 1449305157, 1449305157, 1, 1, 9, 1, '34', '432535464654654', '01'),
(3, '20151207767', 1449305157, 1449305157, 1, 2, 9, 5, '56', '543564643543', '12;85;96;02;03');

-- --------------------------------------------------------

--
-- 表的结构 `think_unique`
--

CREATE TABLE IF NOT EXISTS `think_unique` (
  `id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `lucky_number` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_unique`
--

INSERT INTO `think_unique` (`id`, `goods_id`, `lucky_number`) VALUES
(1, 9, 'a:0:{}');

-- --------------------------------------------------------

--
-- 表的结构 `think_user`
--

CREATE TABLE IF NOT EXISTS `think_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `wx_openid` varchar(255) NOT NULL,
  `login_time` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `think_user`
--

INSERT INTO `think_user` (`id`, `name`, `image`, `wx_openid`, `login_time`) VALUES
(1, '茂林', 'http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0', '', 232432432),
(2, '小明', 'http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0', '', 343242343),
(4, '王茂林', 'http://wx.qlogo.cn/mmopen/r48cSSlr7jgj6kFMCIRrztgO4eapmljqJ3zYcm1rrupxxlOKwKr3MQAebKweEx5uhBRVxEVHHrK83gzHSvZjDHeU4JREw2wC/0', 'oqBF_wht83V-VQ-hHMbeK2O5JsM0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `think_admin`
--
ALTER TABLE `think_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_goods`
--
ALTER TABLE `think_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_order`
--
ALTER TABLE `think_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_unique`
--
ALTER TABLE `think_unique`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `think_user`
--
ALTER TABLE `think_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `think_admin`
--
ALTER TABLE `think_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `think_goods`
--
ALTER TABLE `think_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=332;
--
-- AUTO_INCREMENT for table `think_order`
--
ALTER TABLE `think_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `think_user`
--
ALTER TABLE `think_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
