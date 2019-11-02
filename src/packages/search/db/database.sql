# phpMyAdmin SQL Dump
# version 2.5.4
# http://www.phpmyadmin.net
#
# Хост: localhost
# Время создания: Окт 18 2004 г., 17:13
# Версия сервера: 4.0.20
# Версия PHP: 4.3.8
# 
# БД : `cms`
# 

# --------------------------------------------------------

#
# Структура таблицы `s_urls`
#

DROP TABLE IF EXISTS `s_urls`;
CREATE TABLE `s_urls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(255) NOT NULL default '',
  `url` char(255) NOT NULL default '',
  `descr` char(255) NOT NULL default '',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  `status` smallint(6) NOT NULL default '200',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `status` (`status`)
) TYPE=MyISAM AUTO_INCREMENT=144 ;

# --------------------------------------------------------

#
# Структура таблицы `s_words`
#

DROP TABLE IF EXISTS `s_words`;
CREATE TABLE `s_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `word` char(255) NOT NULL default '',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `word` (`word`)
) TYPE=MyISAM AUTO_INCREMENT=4723 ;

# --------------------------------------------------------

#
# Структура таблицы `s_words_urls`
#

DROP TABLE IF EXISTS `s_words_urls`;
CREATE TABLE `s_words_urls` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `url_id` int(10) unsigned NOT NULL default '0',
  `word_id` int(10) unsigned NOT NULL default '0',
  `weight` int(10) unsigned NOT NULL default '0',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url_id` (`url_id`,`word_id`)
) TYPE=MyISAM AUTO_INCREMENT=48538 ;

# --------------------------------------------------------

#
# Структура таблицы `t_urls`
#

DROP TABLE IF EXISTS `t_urls`;
CREATE TABLE `t_urls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(255) NOT NULL default '',
  `url` char(255) NOT NULL default '',
  `descr` char(255) NOT NULL default '',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  `status` smallint(6) NOT NULL default '200',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`),
  KEY `status` (`status`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

# --------------------------------------------------------

#
# Структура таблицы `t_words`
#

DROP TABLE IF EXISTS `t_words`;
CREATE TABLE `t_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `word` char(255) NOT NULL default '',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `word` (`word`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

# --------------------------------------------------------

#
# Структура таблицы `t_words_urls`
#

DROP TABLE IF EXISTS `t_words_urls`;
CREATE TABLE `t_words_urls` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `url_id` int(10) unsigned NOT NULL default '0',
  `word_id` int(10) unsigned NOT NULL default '0',
  `weight` int(10) unsigned NOT NULL default '0',
  `updated` timestamp(14) NOT NULL,
  `created` timestamp(14) NOT NULL default '00000000000000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url_id` (`url_id`,`word_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

# --------------------------------------------------------

#
# Структура таблицы `todo_urls`
#

DROP TABLE IF EXISTS `todo_urls`;
CREATE TABLE `todo_urls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` char(255) NOT NULL default '',
  `processed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`)
) TYPE=MyISAM AUTO_INCREMENT=273 ;
