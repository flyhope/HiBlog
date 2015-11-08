SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `gb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '作者UID',
  `category_id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0.未发布，1.已发布',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `publish_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发布时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `category_id` (`category_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章内容';

CREATE TABLE IF NOT EXISTS `gb_blog` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户UID',
  `data` text NOT NULL COMMENT '内容',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='博客信息表';

CREATE TABLE IF NOT EXISTS `gb_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL COMMENT '所有者UID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `alias` varchar(32) NOT NULL DEFAULT '' COMMENT '英文别名',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_uid_alias` (`uid`,`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分类表';

CREATE TABLE IF NOT EXISTS `gb_config` (
  `k` varchar(64) NOT NULL COMMENT '配置名称',
  `v` text NOT NULL COMMENT '配置值',
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置信息表';

CREATE TABLE IF NOT EXISTS `gb_test` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(32) NOT NULL DEFAULT '',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='单元测试数据库';

CREATE TABLE IF NOT EXISTS `gb_user` (
  `id` int(10) unsigned NOT NULL COMMENT 'GITHUB用户UID',
  `github_access_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'GITHUB的授权AccessToken',
  `metadata` text NOT NULL COMMENT '元数据',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户注册时间',
  `login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '用户登录境',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户数据表';

CREATE TABLE IF NOT EXISTS `gb_counter_article` (
`uid` INT UNSIGNED NOT NULL COMMENT  '用户ID',
`category_id` INT UNSIGNED NOT NULL COMMENT  '分类ID',
`total_number` MEDIUMINT UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '计数',
PRIMARY KEY (  `uid` ,  `category_id` )
) ENGINE = MYISAM COMMENT =  '文章计数器';

INSERT INTO `gb_category` (`id`, `uid`, `name`, `alias`, `sort`) VALUES
(1, 0, '默认分类', 'default', 0);


--
-- 表的结构 `gb_tpl_main`
--

CREATE TABLE IF NOT EXISTS `gb_tpl_main` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板ID',
  `name` varchar(16) NOT NULL COMMENT '模板名称',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '模板作者',
  `pic` varchar(128) NOT NULL DEFAULT '' COMMENT '模板截图',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模板表';

--
-- 转存表中的数据 `gb_tpl_main`
--

INSERT INTO `gb_tpl_main` (`id`, `name`, `user_id`, `pic`, `create_time`) VALUES
(1, '默认模板', 0, '', '2015-11-08 05:16:48');

-- --------------------------------------------------------

--
-- 表的结构 `gb_tpl_resource`
--

CREATE TABLE IF NOT EXISTS `gb_tpl_resource` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `tpl_id` mediumint(8) UNSIGNED NOT NULL COMMENT '模板ID',
  `resource_name` varchar(32) NOT NULL COMMENT '资源名称',
  `content` text NOT NULL COMMENT '模板内容',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_tpl_id_resource_name` (`tpl_id`,`resource_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='博客模板资源';

