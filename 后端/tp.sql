-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-02-14 20:18:15
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `tp`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'md5密码',
  `login_time` datetime DEFAULT NULL COMMENT '登入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `login_time`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2023-02-14 20:09:19');

-- --------------------------------------------------------

--
-- 表的结构 `photo_album`
--

CREATE TABLE `photo_album` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authority` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `photo_album`
--

INSERT INTO `photo_album` (`id`, `user_id`, `name`, `authority`) VALUES
(2, 2, '测试', 0),
(4, 2, '测试相册', 1),
(5, 13, '测试相册', 0),
(7, 13, '新相册', 0),
(8, 15, '我的相册1', 1),
(9, 15, '测试相册', 0),
(10, 15, '私密', 1),
(11, 15, '创建相册', 0),
(21, 15, '我的测试', 0);

-- --------------------------------------------------------

--
-- 表的结构 `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `pictures`
--

INSERT INTO `pictures` (`id`, `url`, `name`, `text`, `photoid`) VALUES
(5, 'https://img0.baidu.com/it/u=189649806,2789154204&fm=253&app=138&size=w931&n=0&f=JPEG&fmt=auto?sec=1674666000&t=5ce776c88ad77528992064e3f9a3db78', '', '', 2),
(7, 'https://img0.baidu.com/it/u=189649806,2789154204&fm=253&app=138&size=w931&n=0&f=JPEG&fmt=auto?sec=1674666000&t=5ce776c88ad77528992064e3f9a3db78', '', '', 4),
(8, '/storage/topic/20230130\\f96e2bd6504db7acba6c79c4a343ad7e.png', '测试', '', 2),
(10, '/storage/topic/20230211\\b6d4887c555d941a013219079f972d2a.png', 'hhh', '', 7),
(11, '/storage/topic/20230211\\b6d4887c555d941a013219079f972d2a.png', NULL, NULL, 7),
(12, '/storage/topic/20230211\\b6d4887c555d941a013219079f972d2a.png', 'hhh', '', 7),
(20, '/storage/topic/20230213\\4051d22f1918378d129b392a394f5049.png', '测试', '测试一下', 8),
(21, '/storage/topic/20230213\\27e2d4012f13522c44c9974941c14e80.png', '', '', 11),
(23, '/storage/topic/20230213\\85a8b78b057b69ed037714f76b8e13c5.png', '', '', 11),
(24, '/storage/topic/20230213\\64c11128775297b6df3aa8a601a21e68.png', NULL, NULL, 9),
(25, 'https://ts2.cn.mm.bing.net/th?id=ORMS.a125236b05671f108f258a328277f16f&pid=Wdp&w=300&h=156&qlt=90&c=1&rs=1&dpr=1&p=0', NULL, NULL, 9),
(26, 'https://ts2.cn.mm.bing.net/th?id=ORMS.a125236b05671f108f258a328277f16f&pid=Wdp&w=300&h=156&qlt=90&c=1&rs=1&dpr=1&p=0', '', '', 9),
(27, '/storage/topic/20230214\\a5472618575be20bd0524d4b7bb0cfa6.png', '', '', 8),
(35, '/storage/topic/20230214\\42f62dd893f29847792c411c09c81a75.png', NULL, NULL, 21),
(36, '/storage/topic/20230214\\fe72338f428e546c2618604bc63bf195.png', '', '', 9),
(37, '/storage/topic/20230214\\2a4ca76806db0b8440be877116c48e1c.png', '', '', 8),
(40, '/storage/topic/20230214\\334b46f1f1bff7182168c5587013826b.png', '', '', 8),
(41, '/storage/topic/20230214\\c62cf58dfebfeeab4f5d47116ee4edfd.png', '', '', 8);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `head_img` text COLLATE utf8_unicode_ci,
  `sex` int(11) DEFAULT '0',
  `address` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `birthday` date DEFAULT NULL,
  `resume` text COLLATE utf8_unicode_ci,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT '127.0.0.1',
  `register_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `login_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `number`, `password`, `username`, `email`, `head_img`, `sex`, `address`, `birthday`, `resume`, `ip`, `register_time`, `login_time`) VALUES
(2, 'test0', 'e10adc3949ba59abbe56e057f20f883e', '47h4xnpr9gr4', 'abcerddd@qq.com', 'https://img0.baidu.com/it/u=189649806,2789154204&fm=253&app=138&size=w931&n=0&f=JPEG&fmt=auto?sec=1674666000&t=5ce776c88ad77528992064e3f9a3db78', 0, '', NULL, NULL, '127.0.0.1', '2023-01-24 01:00:30', '2023-01-24 01:00:30'),
(3, 'test1', '25f9e794323b453885f5181f1b624d0b', '47iyagn4nmma', '', '/storage/topic/20230128\\f5a6a90cf01f73eb7aca95c378a0d253.png', 1, '', NULL, '', '127.0.0.1', '2023-01-25 00:11:04', '2023-01-25 00:11:04'),
(4, 'test2', 'e10adc3949ba59abbe56e057f20f883e', '47ochrgq52yo', '', 'https://img2.baidu.com/it/u=2326278852,469902066&fm=253&app=120&size=w931&n=0&f=JPEG&fmt=auto?sec=1675011600&t=d70a7287d222f845c8b4a6cfe55dcc49', 2, '', NULL, '', '127.0.0.1', '2023-01-27 22:05:51', '2023-01-27 22:05:51'),
(10, 'test3', 'fcea920f7412b5da7be0cf42b8c93759', '47ohz7jn2b49', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-01-28 00:04:19', '2023-01-28 00:04:19'),
(11, '100000000', '4999644a5eb7bd56311478a71d156106', '48dzqxtbv4fq', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-10 18:28:09', '2023-02-12 12:07:42'),
(12, '123456789', '4999644a5eb7bd56311478a71d156106', '48e17xvk3iq2', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-10 18:59:57', '2023-02-10 18:59:57'),
(13, '123456781', '4999644a5eb7bd56311478a71d156106', '48e1wulzbyye', 'test@qq.com', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-10 19:14:54', '2023-02-11 02:20:55'),
(14, '200000000', '4999644a5eb7bd56311478a71d156106', '48h7ha3ff7h3', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-12 12:07:58', '2023-02-12 12:07:58'),
(15, 'testtest', '05a671c66aefea124cc08b76ea6d30bb', '48h9p1e8egwr', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-12 12:55:49', '2023-02-14 20:07:23'),
(16, 'testtest1', 'c23b2ed66eedb321c5bcfb5e3724b978', '48hd7o967vog', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-12 14:11:48', '2023-02-12 14:11:48'),
(17, 'abcdabcd', '794fd8df6686e85e0d8345670d2cd4ae', '48jwyrg2y4y8', '', NULL, 0, '', NULL, NULL, '127.0.0.1', '2023-02-13 23:13:39', '2023-02-13 23:13:39');

--
-- 转储表的索引
--

--
-- 表的索引 `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `photo_album`
--
ALTER TABLE `photo_album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`);

--
-- 表的索引 `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photoid` (`photoid`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `photo_album`
--
ALTER TABLE `photo_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 限制导出的表
--

--
-- 限制表 `photo_album`
--
ALTER TABLE `photo_album`
  ADD CONSTRAINT `userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`photoid`) REFERENCES `photo_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
