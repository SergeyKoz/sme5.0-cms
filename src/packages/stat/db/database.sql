-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Мар 22 2005 г., 12:21
-- Версия сервера: 4.0.20
-- Версия PHP: 4.3.10
-- 
-- БД: `cms_test`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `cms_stat`
-- 

CREATE TABLE `cms_stat` (
  `id` int(11) NOT NULL auto_increment,
  `remote_host` text,
  `request_url` text,
  `referer` text,
  `visit_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_agent` text,
  `referer_domain` text,
  PRIMARY KEY  (`id`),
  KEY `date_time_of_visit` (`visit_date`)
) TYPE=MyISAM;
