-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 09 2010 г., 14:47
-- Версия сервера: 5.1.22
-- Версия PHP: 4.4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `newspaperdirect`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cms_polls`
--

CREATE TABLE IF NOT EXISTS `cms_polls` (
  `poll_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `caption_ua` varchar(255) DEFAULT NULL,
  `caption_ru` varchar(255) NOT NULL,
  `caption_en` varchar(255) NOT NULL,
  `description_ua` text,
  `description_ru` text NOT NULL,
  `description_en` text NOT NULL,
  `votes` int(10) unsigned NOT NULL DEFAULT '0',
  `poll_visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_index` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `res_visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT NULL,
  `active_ru` tinyint(1) NOT NULL DEFAULT '0',
  `active_en` tinyint(1) NOT NULL DEFAULT '0',
  `active_ua` tinyint(1) NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `variants` tinyint(1) NOT NULL,
  PRIMARY KEY (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=202 ;

--
-- Дамп данных таблицы `cms_polls`
--

INSERT INTO `cms_polls` (`poll_id`, `parent_id`, `caption_ua`, `caption_ru`, `caption_en`, `description_ua`, `description_ru`, `description_en`, `votes`, `poll_visible`, `is_index`, `res_visible`, `active`, `active_ru`, `active_en`, `active_ua`, `_created_by`, `_modified_by`, `_lastmodified`, `_priority`, `variants`) VALUES
(192, 0, '', 'Название (Рус.)1', 'Название (Анг.)1', '', 'Описание (Рус.)', 'Описание (Анг.)', 7, 0, 0, 1, 1, 1, 1, 0, 1, 1, '2010-05-09 14:39:21', 192, 0),
(193, 192, '', 'Вариант 1', 'Вариант 1', NULL, '', '', 5, 0, 0, 0, 1, 1, 1, 0, 1, 1, '2010-05-09 14:27:11', 193, 0),
(194, 192, '', 'Вариант 2', 'Вариант 2', NULL, '', '', 2, 0, 0, 0, 1, 1, 1, 0, 1, 1, '2010-05-06 00:02:16', 194, 0),
(195, 192, '', 'Вариант 3', 'Вариант 3', NULL, '', '', 0, 0, 0, 0, 1, 1, 1, 0, 1, 1, '2010-05-09 14:36:04', 195, 0),
(196, 192, '', 'Вариант 4', 'Вариант 4', NULL, '', '', 0, 0, 0, 0, 1, 1, 1, 0, 1, 1, '2010-05-09 14:39:21', 196, 1),
(197, 0, '', 'Название (Рус.)2', 'Название (Анг.)2', '', 'Описание (Рус.)\r\n', 'Описание (Анг.)\r\n', 1, 0, 0, 1, 1, 1, 1, 0, 1, 1, '2010-05-09 14:43:39', 197, 0),
(198, 197, '', 'Вариант 1', 'Вариант 1', NULL, '', '', 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2010-05-05 23:49:51', 198, 0),
(199, 197, '', 'Вариант 2', 'Вариант 2', NULL, '', '', 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2010-05-09 14:36:27', 199, 0),
(200, 197, '', 'Вариант 3', 'Вариант 3', NULL, '', '', 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2010-05-09 14:36:27', 200, 0),
(201, 197, '', 'Вариант 4', 'Вариант 4', NULL, '', '', 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2010-05-09 14:43:39', 201, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `cms_polls_pages_relations`
--

CREATE TABLE IF NOT EXISTS `cms_polls_pages_relations` (
  `snap_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) unsigned DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`snap_id`),
  KEY `cms_polls_snap_FKIndex1` (`poll_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cms_polls_variants`
--

CREATE TABLE IF NOT EXISTS `cms_polls_variants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `variant_text` varchar(255) DEFAULT NULL,
  `q_id` int(10) unsigned NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `p_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `cms_polls_variants`
--

INSERT INTO `cms_polls_variants` (`id`, `variant_text`, `q_id`, `_created_by`, `_modified_by`, `_lastmodified`, `_priority`, `active`, `p_id`) VALUES
(20, 'Вариант 4', 201, 1, 1, '2010-05-09 14:43:39', NULL, NULL, 197);
