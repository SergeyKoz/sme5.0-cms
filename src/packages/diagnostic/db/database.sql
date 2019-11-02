-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 26 2004 г., 14:51
-- Версия сервера: 4.0.20
-- Версия PHP: 4.3.9
-- 
-- БД: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `diagnostic_site_emails`
-- 

DROP TABLE IF EXISTS `diagnostic_site_emails`;
CREATE TABLE `diagnostic_site_emails` (
  `email_id` int(10) unsigned NOT NULL auto_increment,
  `site_id` int(10) unsigned default NULL,
  `email` varchar(255) default NULL,
  `email_owner` varchar(255) default NULL,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastnodified` timestamp(14) NOT NULL,
  `errors_only` tinyint(1) default NULL,
  PRIMARY KEY  (`email_id`),
  KEY `diagnostic_site_emails_FKIndex1` (`site_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `diagnostic_site_tests`
-- 

DROP TABLE IF EXISTS `diagnostic_site_tests`;
CREATE TABLE `diagnostic_site_tests` (
  `site_test_id` int(10) unsigned NOT NULL auto_increment,
  `site_id` int(10) unsigned default NULL,
  `test_id` int(10) unsigned default NULL,
  `init` text,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `send_emails` int(10) unsigned default NULL,
  PRIMARY KEY  (`site_test_id`),
  KEY `m_site_tests_FKIndex1` (`site_id`),
  KEY `m_site_tests_FKIndex2` (`test_id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `diagnostic_sites`
-- 

DROP TABLE IF EXISTS `diagnostic_sites`;
CREATE TABLE `diagnostic_sites` (
  `site_id` int(10) unsigned NOT NULL auto_increment,
  `caption` varchar(255) default NULL,
  `url` text,
  `period` int(10) unsigned default NULL,
  `_priority` int(10) unsigned default NULL,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `parent_id` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `tester_url` text,
  `site_password` varchar(255) default NULL,
  `transport_method` int(10) unsigned NOT NULL default '0',
  `send_emails` tinyint(1) default NULL,
  `status_emails` text,
  PRIMARY KEY  (`site_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `diagnostic_tests`
-- 

DROP TABLE IF EXISTS `diagnostic_tests`;
CREATE TABLE `diagnostic_tests` (
  `test_id` int(10) unsigned NOT NULL auto_increment,
  `caption` varchar(255) default NULL,
  `test_file` varchar(255) default NULL,
  `description` text,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `init_description` text,
  PRIMARY KEY  (`test_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;
