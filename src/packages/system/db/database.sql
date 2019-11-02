-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 26 2004 г., 14:56
-- Версия сервера: 4.0.20
-- Версия PHP: 4.3.9
-- 
-- БД: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_settings`
-- 

DROP TABLE IF EXISTS `cms_settings`;
CREATE TABLE `cms_settings` (
  `settingid` int(10) unsigned NOT NULL default '0',
  `_modified_by` int(10) unsigned NOT NULL default '0',
  `_created_by` int(10) unsigned NOT NULL default '0',
  `settingname` varchar(255) default NULL,
  `settingvalue` varchar(255) default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  PRIMARY KEY  (`settingid`),
  KEY `euroline_settings_FKIndex1` (`_created_by`),
  KEY `euroline_settings_FKIndex2` (`_modified_by`)
) TYPE=MyISAM;

-- 
-- Дамп данных таблицы `cms_settings`
-- 

INSERT INTO `cms_settings` VALUES (1, 1, 0, 'Administrator email', 'kmatsebora@activemedia.com.ua', '20041014165243');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_user_groups`
-- 

DROP TABLE IF EXISTS `cms_user_groups`;
CREATE TABLE `cms_user_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `_modified_by` int(10) unsigned NOT NULL default '0',
  `_created_by` int(10) unsigned NOT NULL default '0',
  `group_name_ru` varchar(255) default NULL,
  `group_name_ua` varchar(255) default NULL,
  `group_name_en` varchar(255) default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `_priority` int(10) unsigned NOT NULL default '0',
  `parent_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=12 ;

-- 
-- Дамп данных таблицы `cms_user_groups`
-- 

INSERT INTO `cms_user_groups` VALUES (1, 0, 0, 'Администраторы', 'Адміністраторы', 'Administrators', '20040903124038', 1, 0);
INSERT INTO `cms_user_groups` VALUES (2, 0, 0, 'Модераторы', 'Модератори', 'Moderators', '20040903124118', 0, 0);
INSERT INTO `cms_user_groups` VALUES (3, 0, 0, 'Менеджеры контента', 'Менеджери контенту', 'Content managers', '20040903124223', 0, 0);
INSERT INTO `cms_user_groups` VALUES (4, 0, 0, 'Редакторы контента', 'Редактори контенту', 'Content editors', '20040903124431', 0, 0);
INSERT INTO `cms_user_groups` VALUES (5, 0, 0, 'Зарегистрированные пользователи', 'Зареєстровані користувачі', 'Registered users', '20040903155828', 0, 0);
INSERT INTO `cms_user_groups` VALUES (6, 1, 1, 'Зарегистрированные пользователи (1)', 'Зареєстровані користувачі', 'Registered users', '20041009153949', 0, 5);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_user_roles`
-- 

DROP TABLE IF EXISTS `cms_user_roles`;
CREATE TABLE `cms_user_roles` (
  `user_role_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `role_name` varchar(255) default NULL,
  PRIMARY KEY  (`user_role_id`)
) TYPE=MyISAM AUTO_INCREMENT=48 ;

-- 
-- Дамп данных таблицы `cms_user_roles`
-- 

INSERT INTO `cms_user_roles` VALUES (47, 1, 'CONTENT_EDITOR');
INSERT INTO `cms_user_roles` VALUES (46, 1, 'CONTENT_MANAGER');
INSERT INTO `cms_user_roles` VALUES (45, 1, 'ADMIN');
INSERT INTO `cms_user_roles` VALUES (15, 7, 'CONTENT_MANAGER');
INSERT INTO `cms_user_roles` VALUES (17, 8, 'CONTENT_EDITOR');
INSERT INTO `cms_user_roles` VALUES (18, 8, 'PUBLICATIONS_EDITOR');
INSERT INTO `cms_user_roles` VALUES (19, 15, 'ADMIN');
INSERT INTO `cms_user_roles` VALUES (21, 16, 'ADMIN');
INSERT INTO `cms_user_roles` VALUES (22, 16, 'CONTENT_MANAGER');
INSERT INTO `cms_user_roles` VALUES (23, 16, 'PUBLICATIONS_EDITOR');
INSERT INTO `cms_user_roles` VALUES (24, 16, 'PUBLICATIONS_MANAGER');
INSERT INTO `cms_user_roles` VALUES (25, 16, 'BANNER_PUBLISHER');
INSERT INTO `cms_user_roles` VALUES (26, 21, 'ADMIN');

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_users`
-- 

DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '1',
  `user_login` varchar(45) NOT NULL default '',
  `user_password` varchar(45) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  `_lastmodified` timestamp(14) NOT NULL,
  `_created_by` int(10) unsigned NOT NULL default '0',
  `_modified_by` int(10) unsigned NOT NULL default '0',
  `_priority` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=24 ;

-- 
-- Дамп данных таблицы `cms_users`
-- 

INSERT INTO `cms_users` VALUES (1, 1, 'admin', 'admin', 1, '20041011110137', 0, 1, 0);
INSERT INTO `cms_users` VALUES (7, 3, 'content_manager', 'content_manager', 1, '20040908142402', 1, 1, 0);
INSERT INTO `cms_users` VALUES (8, 4, 'content_editor', 'content_editor', 1, '20040908142423', 1, 1, 0);
INSERT INTO `cms_users` VALUES (10, 6, 'user', 'user', 0, '20041009151731', 1, 1, 0);
INSERT INTO `cms_users` VALUES (22, 5, 'user1', 'user', 0, '20041010161736', 1, 1, 0);
