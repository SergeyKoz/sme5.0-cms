-- 
-- Структура таблицы `cms_guestbook_form`
-- 

DROP TABLE IF EXISTS `cms_guestbook_form`;
CREATE TABLE IF NOT EXISTS `cms_guestbook_form` (
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

-- 
-- Дамп данных таблицы  `cms_guestbook_form`
-- 

INSERT INTO `cms_guestbook_form` VALUES (1, 'Подпись', 'Пiдпис', 'Signature', 1, 'text', 2, 1, 1, 1, '20050311005017', '', '', '', 255);
INSERT INTO `cms_guestbook_form` VALUES (2, 'Ваше сообщение', 'Ваше повiдомлення', 'Your message', 1, 'textarea', 1, 1, 1, 1, '20050311005121', '', '', '', 4096);
INSERT INTO `cms_guestbook_form` VALUES (3, 'Ваш e-mail', 'Ваш e-mail', 'Your e-mail', 1, 'email', 3, 1, 1, 1, '20050308233725', '', '', '', 255);
        
-- 
-- Структура таблицы `cms_guestbook_messages`
-- 

DROP TABLE IF EXISTS `cms_guestbook_messages`;
CREATE TABLE IF NOT EXISTS `cms_guestbook_messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `_modified_by` int(10) unsigned default NULL,
  `_created_by` int(11) default NULL,
  `_lastmodified` timestamp(14) NOT NULL,
  `_priority` int(11) default NULL,
  `posted_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `active` tinyint(4) NOT NULL default '0',
  `signature` varchar(255) default NULL,
  `message` text,
  `comment` text,
  `email` varchar(255) default NULL,
  `language` char(2) NOT NULL default 'ru',
  PRIMARY KEY  (`message_id`)
) TYPE=MyISAM;
