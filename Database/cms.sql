-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-01-04 16:51:04
-- 服务器版本： 5.6.15-log
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--
CREATE DATABASE IF NOT EXISTS `cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cms`;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_admin`
--

DROP TABLE IF EXISTS `gccms_admin`;
CREATE TABLE IF NOT EXISTS `gccms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` char(30) NOT NULL,
  `pwd` char(32) NOT NULL,
  `email` char(100) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `lasttime` char(100) DEFAULT NULL,
  `secrand` char(64) NOT NULL COMMENT '随机码',
  `secauth` char(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_article`
--

DROP TABLE IF EXISTS `gccms_article`;
CREATE TABLE IF NOT EXISTS `gccms_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `detail` longtext NOT NULL COMMENT '内容',
  `intro` varchar(500) NOT NULL COMMENT '简介',
  `thumbnail` varchar(500) NOT NULL COMMENT '封面缩略图',
  `imgurl` varchar(500) NOT NULL COMMENT '封面',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  `on` int(11) NOT NULL DEFAULT '0' COMMENT '顶',
  `off` int(11) NOT NULL DEFAULT '0' COMMENT '踩',
  `like` int(11) NOT NULL DEFAULT '0' COMMENT '喜欢',
  `collect` int(11) NOT NULL DEFAULT '0' COMMENT '收藏',
  `createtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='文章内容' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_event_track`
--

DROP TABLE IF EXISTS `gccms_event_track`;
CREATE TABLE IF NOT EXISTS `gccms_event_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` char(20) DEFAULT NULL,
  `time` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21509 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_global_timeoffset`
--

DROP TABLE IF EXISTS `gccms_global_timeoffset`;
CREATE TABLE IF NOT EXISTS `gccms_global_timeoffset` (
  `name` varchar(200) NOT NULL COMMENT '全球时区名称',
  `timeoffset` char(50) NOT NULL COMMENT '时差'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全局时区';

-- --------------------------------------------------------

--
-- 表的结构 `gccms_logrecord`
--

DROP TABLE IF EXISTS `gccms_logrecord`;
CREATE TABLE IF NOT EXISTS `gccms_logrecord` (
  `logtags` char(8) DEFAULT NULL,
  `logtext` longtext,
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日志记录';

-- --------------------------------------------------------

--
-- 表的结构 `gccms_menu`
--

DROP TABLE IF EXISTS `gccms_menu`;
CREATE TABLE IF NOT EXISTS `gccms_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` char(100) DEFAULT NULL COMMENT '图标',
  `link` varchar(500) NOT NULL DEFAULT '#' COMMENT '菜单链接',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `order` int(11) NOT NULL DEFAULT '99' COMMENT '菜单排序',
  `used` char(30) NOT NULL DEFAULT '1' COMMENT '使用状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='菜单管理' AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_nav`
--

DROP TABLE IF EXISTS `gccms_nav`;
CREATE TABLE IF NOT EXISTS `gccms_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate` char(30) NOT NULL COMMENT '导航位置',
  `delete` tinyint(1) NOT NULL COMMENT '是否可以删除，内置导航禁止删除',
  `order` int(11) NOT NULL COMMENT '排序',
  `name` char(100) NOT NULL COMMENT '导航名称',
  `subtype` tinyint(1) NOT NULL COMMENT '0 菜单样式 1横排样式',
  `urlnew` text NOT NULL COMMENT '链接地址',
  `defaultindex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认首页',
  `availablenew` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `title` varchar(300) NOT NULL COMMENT 'title标签内容',
  `stylenew` char(30) NOT NULL COMMENT '0下划线 1  斜体 2 粗体',
  `color` int(11) NOT NULL COMMENT '字体颜色',
  `target` tinyint(1) NOT NULL COMMENT '是否新窗口打开',
  `level` int(11) NOT NULL COMMENT '可见用户组权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='导航菜单设置' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_operation_log`
--

DROP TABLE IF EXISTS `gccms_operation_log`;
CREATE TABLE IF NOT EXISTS `gccms_operation_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `nick` char(100) NOT NULL COMMENT '用户名',
  `cate` char(100) NOT NULL COMMENT '用户组',
  `sql` text NOT NULL COMMENT '查询语句',
  `remark` varchar(500) NOT NULL COMMENT '备注',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='系统操作日志' AUTO_INCREMENT=3026 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_pay_config`
--

DROP TABLE IF EXISTS `gccms_pay_config`;
CREATE TABLE IF NOT EXISTS `gccms_pay_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tags` char(30) NOT NULL,
  `name` char(50) NOT NULL,
  `remark` char(200) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 关闭 1 开通',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_point`
--

DROP TABLE IF EXISTS `gccms_point`;
CREATE TABLE IF NOT EXISTS `gccms_point` (
  `name` text NOT NULL COMMENT '积分名称',
  `ico` text NOT NULL COMMENT '积分图标',
  `unit` text NOT NULL COMMENT '积分单位',
  `initpoint` text NOT NULL COMMENT '初始积分',
  `lowpoint` text NOT NULL COMMENT '积分下线',
  `exchange` text NOT NULL COMMENT '兑换比例',
  `exout` tinyint(1) DEFAULT '0' COMMENT '兑出',
  `exin` tinyint(1) DEFAULT '0' COMMENT '兑入',
  `variable` char(200) NOT NULL COMMENT '积分变量',
  PRIMARY KEY (`variable`),
  UNIQUE KEY `variable` (`variable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分配置';

-- --------------------------------------------------------

--
-- 表的结构 `gccms_policy`
--

DROP TABLE IF EXISTS `gccms_policy`;
CREATE TABLE IF NOT EXISTS `gccms_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `valid` char(50) NOT NULL COMMENT '周期',
  `rewardnum` char(20) NOT NULL,
  `cycletime` int(11) NOT NULL COMMENT '间隔时间',
  `variable` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_recharge`
--

DROP TABLE IF EXISTS `gccms_recharge`;
CREATE TABLE IF NOT EXISTS `gccms_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `nick` char(120) NOT NULL COMMENT '用户名',
  `amount` decimal(20,2) NOT NULL COMMENT '充值金额',
  `method` char(30) NOT NULL COMMENT '充值方式',
  `order` char(50) NOT NULL COMMENT '充值订单',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '充值时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 0未到账 1 已到账 2 已取消',
  `mer_no` varchar(500) NOT NULL COMMENT '商户订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='充值记录' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_session`
--

DROP TABLE IF EXISTS `gccms_session`;
CREATE TABLE IF NOT EXISTS `gccms_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `time` char(20) CHARACTER SET latin1 NOT NULL,
  `ip` char(15) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='登录缓存' AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- 表的结构 `gccms_setting`
--

DROP TABLE IF EXISTS `gccms_setting`;
CREATE TABLE IF NOT EXISTS `gccms_setting` (
  `field` char(200) NOT NULL,
  `val` longtext,
  UNIQUE KEY `key` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- --------------------------------------------------------

--
-- 表的结构 `gccms_sort`
--

DROP TABLE IF EXISTS `gccms_sort`;
CREATE TABLE IF NOT EXISTS `gccms_sort` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL COMMENT '分类名称',
  `use` tinyint(1) NOT NULL DEFAULT '1' COMMENT '使用',
  `pid` int(11) NOT NULL COMMENT '上级菜单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

DELIMITER $$
--
-- 事件
--
DROP EVENT `update_secauth`$$
CREATE DEFINER=`coinfact_send`@`localhost` EVENT `update_secauth` ON SCHEDULE EVERY 1 MINUTE STARTS '2016-12-20 00:00:00' ENDS '2031-10-20 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT '更新随机码' DO UPDATE `gccms_admin` SET `secauth`=ceiling(rand() * 999999)$$

DROP EVENT `clean_session`$$
CREATE DEFINER=`coinfact_send`@`localhost` EVENT `clean_session` ON SCHEDULE EVERY 1 MINUTE STARTS '2016-12-23 00:00:00' ENDS '2036-12-23 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT '删除超过1800秒的缓存' DO delete from gccms_session where unix_timestamp(now()) - `time`  > 1800$$

DROP EVENT `event_track`$$
CREATE DEFINER=`coinfact_send`@`localhost` EVENT `event_track` ON SCHEDULE EVERY 1 MINUTE STARTS '2016-12-20 00:00:00' ENDS '2031-12-20 00:00:00' ON COMPLETION PRESERVE ENABLE DO insert into gccms_event_track(`category`,`time`) values ('update_secauth',now())$$

DROP EVENT `change_recharge_status`$$
CREATE DEFINER=`coinfact_send`@`localhost` EVENT `change_recharge_status` ON SCHEDULE EVERY 30 MINUTE STARTS '2017-01-04 00:00:00' ENDS '2038-01-04 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT '更新状态未到账并且充值时间大于1800秒的订单为已取消' DO update gccms_recharge set `status`=2 where unix_timestamp(`time`) < unix_timestamp(now()) - 1800$$

DROP EVENT `event_track1`$$
CREATE DEFINER=`coinfact_send`@`localhost` EVENT `event_track1` ON SCHEDULE EVERY 30 MINUTE STARTS '2017-01-04 00:00:00' ENDS '2038-01-04 00:00:00' ON COMPLETION PRESERVE ENABLE COMMENT '运行充值记录状态更新监听事件' DO insert into gccms_event_track(`category`,`time`) values ('change_recharge',now())$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
