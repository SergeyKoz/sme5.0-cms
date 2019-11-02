-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 26 2004 г., 14:42
-- Версия сервера: 4.0.20
-- Версия PHP: 4.3.9
-- 
-- БД: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_banner_events`
-- 

DROP TABLE IF EXISTS `cms_banner_events`;
CREATE TABLE `cms_banner_events` (
  `banner_id` int(10) unsigned default NULL,
  `page_id` int(10) unsigned default NULL,
  `event_time` timestamp(14) NOT NULL,
  `event_type` int(10) unsigned default NULL,
  `place_id` int(10) unsigned default NULL,
  `language` char(2) default NULL,
  `ip` int(10) unsigned default NULL,
  KEY `banner_id` (`banner_id`),
  KEY `page_id` (`page_id`),
  KEY `event_type` (`event_type`),
  KEY `place_id` (`place_id`)
) TYPE=MyISAM;


-- 
-- Структура таблицы `cms_banner_groups`
-- 

DROP TABLE IF EXISTS `cms_banner_groups`;
CREATE TABLE `cms_banner_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `_modified_by` int(10) unsigned NOT NULL default '0',
  `_created_by` int(10) unsigned NOT NULL default '0',
  `_lastmodified` timestamp(14) NOT NULL,
  `_priority` int(10) unsigned NOT NULL default '0',
  `group_title` varchar(255) NOT NULL default '',
  `active` tinyint(1) default NULL,
  PRIMARY KEY  (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Дамп данных таблицы `cms_banner_groups`
-- 

INSERT INTO `cms_banner_groups` VALUES (1, 0, 1, 1, '20041013170720', 0, 'Main', 1);
INSERT INTO `cms_banner_groups` VALUES (7, 0, 1, 1, '20041013170720', 0, 'group2', 1);
INSERT INTO `cms_banner_groups` VALUES (6, 0, 1, 1, '20041013170720', 0, 'group1', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_banner_languages`
-- 

DROP TABLE IF EXISTS `cms_banner_languages`;
CREATE TABLE `cms_banner_languages` (
  `language` char(2) default NULL,
  `banner_id` int(10) unsigned default NULL
) TYPE=MyISAM;

-- 
-- Структура таблицы `cms_banner_pages`
-- 

DROP TABLE IF EXISTS `cms_banner_pages`;
CREATE TABLE `cms_banner_pages` (
  `bp_id` int(10) unsigned NOT NULL auto_increment,
  `banner_id` int(10) unsigned NOT NULL default '0',
  `page_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bp_id`)
) TYPE=MyISAM AUTO_INCREMENT=294 ;

-- 
-- Структура таблицы `cms_banner_placerelations`
-- 

DROP TABLE IF EXISTS `cms_banner_placerelations`;
CREATE TABLE `cms_banner_placerelations` (
  `bpl_id` int(10) unsigned NOT NULL auto_increment,
  `banner_id` int(10) unsigned NOT NULL default '0',
  `place_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bpl_id`)
) TYPE=MyISAM AUTO_INCREMENT=35 ;


-- 
-- Структура таблицы `cms_banner_places`
-- 

DROP TABLE IF EXISTS `cms_banner_places`;
CREATE TABLE `cms_banner_places` (
  `place_id` int(10) unsigned NOT NULL auto_increment,
  `place_title` varchar(255) default NULL,
  `max_banners_qty` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`place_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `cms_banner_places`
-- 

INSERT INTO `cms_banner_places` VALUES (1, 'Header', 1);
INSERT INTO `cms_banner_places` VALUES (2, 'Footer', 1);
INSERT INTO `cms_banner_places` VALUES (3, 'Left', 3);
INSERT INTO `cms_banner_places` VALUES (4, 'Right', 3);

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_banners`
-- 

DROP TABLE IF EXISTS `cms_banners`;
CREATE TABLE `cms_banners` (
  `banner_id` int(10) unsigned NOT NULL auto_increment,
  `_modified_by` int(10) unsigned NOT NULL default '0',
  `_created_by` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  `_lastmodified` timestamp(14) NOT NULL,
  `_priority` int(10) unsigned default NULL,
  `banner_title` varchar(255) NOT NULL default '',
  `banner_type` int(10) unsigned NOT NULL default '0',
  `banner_url` text NOT NULL,
  `target` int(10) unsigned default NULL,
  `banner_text` text NOT NULL,
  `banner_file` varchar(255) NOT NULL default '',
  `banner_alt` text,
  `width` int(10) unsigned default NULL,
  `height` int(10) unsigned default NULL,
  `active` tinyint(1) NOT NULL default '0',
  `banner_language` char(2) default NULL,
  PRIMARY KEY  (`banner_id`)
) TYPE=MyISAM AUTO_INCREMENT=24 ;

-- 
-- Дамп данных таблицы `cms_banners`
-- 

INSERT INTO `cms_banners` VALUES (1, 1, 1, 1, '20041029185138', NULL, 'Header & footer banner', 1, 'http://activemedia.com.ua', 1, '', '/banners/banner_large.gif', '', 0, 0, 1, 'ru');
INSERT INTO `cms_banners` VALUES (2, 1, 1, 1, '20041029170233', NULL, 'Left & right banner', 1, 'http://activemedia.com.ua', 0, '', '/banners/banner_small.jpg', '', 0, 0, 1, '');


