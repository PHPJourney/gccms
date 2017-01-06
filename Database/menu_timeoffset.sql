-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-01-06 16:42:25
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

--
-- 转存表中的数据 `gccms_global_timeoffset`
--

INSERT INTO `gccms_global_timeoffset` (`name`, `timeoffset`) VALUES
('(GMT -12:00) 埃尼威托克岛, 夸贾林..', '-12'),
('(GMT -11:00) 中途岛, 萨摩亚群岛..', '-11'),
('(GMT -10:00) 夏威夷', '-10'),
('(GMT -09:00) 阿拉斯加', '-9'),
('(GMT -08:00) 太平洋时间(美国和加拿..', '-8'),
('(GMT -07:00) 山区时间(美国和加拿大..', '-7'),
('(GMT -06:00) 中部时间(美国和加拿大..', '-6'),
('(GMT -05:00) 东部时间(美国和加拿大..', '-5'),
('(GMT -04:00) 大西洋时间(加拿大), ..', '-4'),
('(GMT -03:30) 纽芬兰', '-3.5'),
('(GMT -03:00) 巴西利亚, 布宜诺斯艾..', '-3'),
('(GMT -02:00) 中大西洋, 阿森松群岛,..', '-2.5'),
('(GMT -01:00) 亚速群岛, 佛得角群岛 ..', '-1'),
('(GMT) 卡萨布兰卡, 都柏林, 爱丁堡, ..', '0'),
('(GMT +01:00) 柏林, 布鲁塞尔, 哥本..', '1'),
('(GMT +02:00) 赫尔辛基, 加里宁格勒,..', '2'),
('(GMT +03:00) 巴格达, 利雅得, 莫斯..', '3'),
('(GMT +03:30) 德黑兰', '3.5'),
('(GMT +04:00) 阿布扎比, 巴库, 马斯..', '4'),
('(GMT +04:30) 坎布尔', '4.5'),
('(GMT +05:00) 叶卡特琳堡, 伊斯兰堡,..', '5'),
('(GMT +05:30) 孟买, 加尔各答, 马德..', '5.5'),
('(GMT +05:45) 加德满都', '5.75'),
('(GMT +06:00) 阿拉木图, 科伦坡, 达..', '6'),
('(GMT +06:30) 仰光', '6.5'),
('(GMT +07:00) 曼谷, 河内, 雅加达..', '7'),
('(GMT +08:00) 北京, 香港, 帕斯, 新..', '8'),
('(GMT +09:00) 大阪, 札幌, 首尔, 东..', '9'),
('(GMT +09:30) 阿德莱德, 达尔文..', '9.5'),
('(GMT +10:00) 堪培拉, 关岛, 墨尔本,..', '10'),
('(GMT +11:00) 马加丹, 新喀里多尼亚,..', '11'),
('(GMT +12:00) 奥克兰, 惠灵顿, 斐济,..', '12');

--
-- 转存表中的数据 `gccms_menu`
--

INSERT INTO `gccms_menu` (`id`, `name`, `icon`, `link`, `pid`, `order`, `used`) VALUES
(1, '全局管理', 'asterisk', '#', 0, 1, '1'),
(2, '站点信息', NULL, '/Cpanel/info.shtml', 1, 0, '1'),
(3, '注册与访问', NULL, '/Cpanel/sign.shtml', 1, 1, '1'),
(4, '站点功能', NULL, '/Cpanel/func.shtml', 1, 2, '1'),
(5, '性能优化', NULL, '/Cpanel/nature.shtml', 1, 3, '1'),
(6, 'SEO设置', NULL, '/Cpanel/seo.shtml', 1, 4, '1'),
(7, '积分设置', NULL, '/Cpanel/point.shtml', 1, 5, '1'),
(8, '时间设置', NULL, '/Cpanel/time.shtml', 1, 6, '1'),
(9, '上传设置', NULL, '/Cpanel/upload.shtml', 1, 7, '1'),
(10, '水印设置', NULL, '/Cpanel/mark.shtml', 1, 8, '1'),
(11, '搜索设置', NULL, '/Cpanel/search.shtml', 1, 9, '1'),
(12, '修改密码', NULL, '/Cpanel/pass.shtml', 1, 10, '1'),
(13, '网站设置', 'cog', '#', 0, 2, '1'),
(14, '导航设置', NULL, '/Cpanel/nav.shtml', 13, 1, '1'),
(15, '界面设置', NULL, '/Cpanel/ui.shtml', 13, 2, '1'),
(16, '风格管理', NULL, '/Cpanel/themes.shtml', 13, 3, '1'),
(17, '文章管理', 'hacker-news', '#', 0, 3, '1'),
(18, '内容管理', NULL, '/Cpanel/news.shtml', 17, 1, '1'),
(19, '添加内容', NULL, '/Cpanel/add_news.shtml', 17, 2, '1'),
(20, '添加分类', NULL, '/Cpanel/cate.shtml', 17, 3, '1'),
(21, '工具', 'wrench', '#', 0, 4, '1'),
(22, '菜单管理', NULL, '/Cpanel/menu.shtml', 21, 0, '1'),
(23, '更新缓存', NULL, '/Cpanel/cache.shtml', 21, 1, '1'),
(24, '更新统计', NULL, '/Cpanel/statis.shtml', 21, 2, '1'),
(25, '运行记录', NULL, '/Cpanel/runtime.shtml', 21, 3, '1'),
(26, '计划任务', NULL, '/Cpanel/planTask.shtml', 21, 4, '1'),
(27, '备份数据库', NULL, '/Cpanel/dbbak.shtml', 21, 5, '1'),
(28, '还原数据库', NULL, '/Cpanel/dbreset.shtml', 21, 6, '1'),
(31, '用户管理', 'user', '#', 0, 0, '1'),
(32, '添加用户', NULL, '/Cpanel/user_add.shtml', 31, 1, '1'),
(33, '用户列表', NULL, '/Cpanel/user_list.shtml', 31, 0, '1'),
(34, '资料统计', NULL, '/Cpanel/user_statis.shtml', 31, 2, '1'),
(35, '用户栏目', NULL, '/Cpanel/profile.shtml', 31, 3, '1'),
(36, '发送通知', NULL, '/Cpanel/newsletter.shtml', 31, 4, '1'),
(37, '发送手机通知', NULL, '/Cpanel/newsletter_mobile.shtml', 31, 5, '1'),
(38, '积分奖惩', NULL, '/Cpanel/reward.shtml', 31, 6, '1'),
(39, '用户组', NULL, '/Cpanel/usergroups.shtml', 31, 7, '1'),
(40, '认证设置', NULL, '/Cpanel/userverify.shtml', 31, 8, '1'),
(41, '实名认证', NULL, '/Cpanel/realverify.shtml', 31, 9, '1'),
(42, '电子商务', 'bookmark', '#', 0, 2, '1'),
(43, '基本设置', NULL, '/Cpanel/ec.shtml', 42, 0, '1'),
(44, '充值类型', NULL, '/Cpanel/recharge.shtml', 42, 1, '1'),
(45, '充值记录', NULL, '/Cpanel/recharge_log.shtml', 42, 3, '1'),
(46, '网站日志', NULL, '/Cpanel/log.shtml', 21, 3, '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
