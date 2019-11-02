-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Ноя 26 2004 г., 14:52
-- Версия сервера: 4.0.20
-- Версия PHP: 4.3.9
-- 
-- БД: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_feedback_departments`
-- 

DROP TABLE IF EXISTS `cms_feedback_departments`;
CREATE TABLE `cms_feedback_departments` (
  `department_id` int(10) unsigned NOT NULL auto_increment,
  `caption_ru` varchar(255) default NULL,
  `caption_ua` varchar(255) default NULL,
  `caption_en` varchar(255) default NULL,
  `description_ru` text,
  `description_ua` text,
  `description_en` text,
  `_priority` int(10) unsigned default NULL,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `is_main` tinyint(1) default NULL,
  `emails` text,
  `content_type` varchar(255) default NULL,
  `encoding` varchar(255) default NULL,
  PRIMARY KEY  (`department_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_feedback_departments_subjects_relation`
-- 

DROP TABLE IF EXISTS `cms_feedback_departments_subjects_relation`;
CREATE TABLE `cms_feedback_departments_subjects_relation` (
  `department_id` int(10) unsigned default NULL,
  `subject_id` int(10) unsigned default NULL,
  KEY `cms_feedback_departments_subjects_relation_FKIndex1` (`department_id`),
  KEY `cms_feedback_departments_subjects_relation_FKIndex2` (`subject_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_feedback_form`
-- 

DROP TABLE IF EXISTS `cms_feedback_form`;
CREATE TABLE `cms_feedback_form` (
  `field_id` int(10) unsigned NOT NULL auto_increment,
  `caption_ru` varchar(255) default NULL,
  `caption_ua` varchar(255) default NULL,
  `caption_en` varchar(255) default NULL,
  `not_null` tinyint(1) default NULL,
  `field_type` varchar(255) default NULL,
  `_priority` int(10) unsigned default NULL,
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `default_value_ru` varchar(255) default NULL,
  `default_value_ua` varchar(255) default NULL,
  `default_value_en` varchar(255) default NULL,
  `max_length` int(10) unsigned default NULL,
  PRIMARY KEY  (`field_id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_feedback_subjects`
-- 

DROP TABLE IF EXISTS `cms_feedback_subjects`;
CREATE TABLE `cms_feedback_subjects` (
  `subject_id` int(10) unsigned NOT NULL auto_increment,
  `subject_ru` varchar(255) default NULL,
  `subject_en` varchar(255) default NULL,
  `subject_ua` varchar(255) default NULL,
  `_priority` int(10) unsigned NOT NULL default '0',
  `active` tinyint(1) default NULL,
  `_created_by` int(10) unsigned default NULL,
  `_modified_by` int(10) unsigned default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `internal_subject` varchar(255) default NULL,
  PRIMARY KEY  (`subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
