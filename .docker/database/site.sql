# MySQL-Front 3.1  (Build 10.1)

SET NAMES 'utf8' COLLATE 'utf8_general_ci';

# Host: sme_site    Database: sme50site
# ------------------------------------------------------
# Server version 5.1.39

#
# Table structure for table cms_banner_groups
#

CREATE TABLE `cms_banner_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  `group_title` varchar(255) NOT NULL DEFAULT '',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banner_groups
#

INSERT INTO `cms_banner_groups` VALUES (1,0,1,1,'2010-03-05 15:39:06',0,'Баннеры верхння/нижняя площадка',1);
INSERT INTO `cms_banner_groups` VALUES (2,0,1,1,'2010-03-05 15:39:06',0,'Баннеры правая/левая площадка',1);

#
# Table structure for table cms_banner_languages
#

CREATE TABLE `cms_banner_languages` (
  `language` char(2) DEFAULT NULL,
  `banner_id` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banner_languages
#

INSERT INTO `cms_banner_languages` VALUES ('ua',54);
INSERT INTO `cms_banner_languages` VALUES ('en',71);
INSERT INTO `cms_banner_languages` VALUES ('en',72);
INSERT INTO `cms_banner_languages` VALUES ('en',69);
INSERT INTO `cms_banner_languages` VALUES ('en',68);

#
# Table structure for table cms_banner_pages
#

CREATE TABLE `cms_banner_pages` (
  `bp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banner_pages
#

INSERT INTO `cms_banner_pages` VALUES (908,72,242);
INSERT INTO `cms_banner_pages` VALUES (905,72,178);
INSERT INTO `cms_banner_pages` VALUES (904,72,177);
INSERT INTO `cms_banner_pages` VALUES (903,72,261);
INSERT INTO `cms_banner_pages` VALUES (902,72,260);
INSERT INTO `cms_banner_pages` VALUES (901,72,259);
INSERT INTO `cms_banner_pages` VALUES (900,72,258);
INSERT INTO `cms_banner_pages` VALUES (899,72,257);
INSERT INTO `cms_banner_pages` VALUES (898,72,256);
INSERT INTO `cms_banner_pages` VALUES (897,72,255);
INSERT INTO `cms_banner_pages` VALUES (896,72,254);
INSERT INTO `cms_banner_pages` VALUES (895,72,253);
INSERT INTO `cms_banner_pages` VALUES (894,72,252);
INSERT INTO `cms_banner_pages` VALUES (893,72,251);
INSERT INTO `cms_banner_pages` VALUES (892,72,250);
INSERT INTO `cms_banner_pages` VALUES (891,72,193);
INSERT INTO `cms_banner_pages` VALUES (890,72,104);
INSERT INTO `cms_banner_pages` VALUES (889,72,102);
INSERT INTO `cms_banner_pages` VALUES (888,72,225);
INSERT INTO `cms_banner_pages` VALUES (887,72,249);
INSERT INTO `cms_banner_pages` VALUES (886,72,248);
INSERT INTO `cms_banner_pages` VALUES (885,72,247);
INSERT INTO `cms_banner_pages` VALUES (884,72,76);
INSERT INTO `cms_banner_pages` VALUES (883,72,1);
INSERT INTO `cms_banner_pages` VALUES (882,72,13);
INSERT INTO `cms_banner_pages` VALUES (962,71,242);
INSERT INTO `cms_banner_pages` VALUES (992,71,223);
INSERT INTO `cms_banner_pages` VALUES (990,71,211);
INSERT INTO `cms_banner_pages` VALUES (959,71,178);
INSERT INTO `cms_banner_pages` VALUES (958,71,177);
INSERT INTO `cms_banner_pages` VALUES (957,71,261);
INSERT INTO `cms_banner_pages` VALUES (956,71,260);
INSERT INTO `cms_banner_pages` VALUES (955,71,259);
INSERT INTO `cms_banner_pages` VALUES (954,71,258);
INSERT INTO `cms_banner_pages` VALUES (953,71,257);
INSERT INTO `cms_banner_pages` VALUES (952,71,256);
INSERT INTO `cms_banner_pages` VALUES (951,71,255);
INSERT INTO `cms_banner_pages` VALUES (950,71,254);
INSERT INTO `cms_banner_pages` VALUES (949,71,253);
INSERT INTO `cms_banner_pages` VALUES (948,71,252);
INSERT INTO `cms_banner_pages` VALUES (947,71,251);
INSERT INTO `cms_banner_pages` VALUES (946,71,250);
INSERT INTO `cms_banner_pages` VALUES (945,71,193);
INSERT INTO `cms_banner_pages` VALUES (944,71,104);
INSERT INTO `cms_banner_pages` VALUES (943,71,102);
INSERT INTO `cms_banner_pages` VALUES (942,71,225);
INSERT INTO `cms_banner_pages` VALUES (941,71,249);
INSERT INTO `cms_banner_pages` VALUES (940,71,248);
INSERT INTO `cms_banner_pages` VALUES (939,71,247);
INSERT INTO `cms_banner_pages` VALUES (938,71,76);
INSERT INTO `cms_banner_pages` VALUES (937,71,1);
INSERT INTO `cms_banner_pages` VALUES (936,71,13);
INSERT INTO `cms_banner_pages` VALUES (854,69,242);
INSERT INTO `cms_banner_pages` VALUES (991,69,223);
INSERT INTO `cms_banner_pages` VALUES (989,69,211);
INSERT INTO `cms_banner_pages` VALUES (851,69,178);
INSERT INTO `cms_banner_pages` VALUES (850,69,177);
INSERT INTO `cms_banner_pages` VALUES (849,69,261);
INSERT INTO `cms_banner_pages` VALUES (848,69,260);
INSERT INTO `cms_banner_pages` VALUES (847,69,259);
INSERT INTO `cms_banner_pages` VALUES (846,69,258);
INSERT INTO `cms_banner_pages` VALUES (845,69,257);
INSERT INTO `cms_banner_pages` VALUES (844,69,256);
INSERT INTO `cms_banner_pages` VALUES (843,69,255);
INSERT INTO `cms_banner_pages` VALUES (842,69,254);
INSERT INTO `cms_banner_pages` VALUES (841,69,253);
INSERT INTO `cms_banner_pages` VALUES (751,68,259);
INSERT INTO `cms_banner_pages` VALUES (750,68,258);
INSERT INTO `cms_banner_pages` VALUES (749,68,257);
INSERT INTO `cms_banner_pages` VALUES (748,68,256);
INSERT INTO `cms_banner_pages` VALUES (747,68,255);
INSERT INTO `cms_banner_pages` VALUES (746,68,254);
INSERT INTO `cms_banner_pages` VALUES (745,68,253);
INSERT INTO `cms_banner_pages` VALUES (744,68,252);
INSERT INTO `cms_banner_pages` VALUES (740,68,104);
INSERT INTO `cms_banner_pages` VALUES (743,68,251);
INSERT INTO `cms_banner_pages` VALUES (742,68,250);
INSERT INTO `cms_banner_pages` VALUES (739,68,102);
INSERT INTO `cms_banner_pages` VALUES (738,68,225);
INSERT INTO `cms_banner_pages` VALUES (737,68,249);
INSERT INTO `cms_banner_pages` VALUES (840,69,252);
INSERT INTO `cms_banner_pages` VALUES (839,69,251);
INSERT INTO `cms_banner_pages` VALUES (736,68,248);
INSERT INTO `cms_banner_pages` VALUES (838,69,250);
INSERT INTO `cms_banner_pages` VALUES (741,68,193);
INSERT INTO `cms_banner_pages` VALUES (837,69,193);
INSERT INTO `cms_banner_pages` VALUES (735,68,247);
INSERT INTO `cms_banner_pages` VALUES (836,69,104);
INSERT INTO `cms_banner_pages` VALUES (835,69,102);
INSERT INTO `cms_banner_pages` VALUES (834,69,225);
INSERT INTO `cms_banner_pages` VALUES (832,69,248);
INSERT INTO `cms_banner_pages` VALUES (831,69,247);
INSERT INTO `cms_banner_pages` VALUES (830,69,76);
INSERT INTO `cms_banner_pages` VALUES (782,68,76);
INSERT INTO `cms_banner_pages` VALUES (829,69,1);
INSERT INTO `cms_banner_pages` VALUES (823,68,1);
INSERT INTO `cms_banner_pages` VALUES (732,68,13);
INSERT INTO `cms_banner_pages` VALUES (828,69,13);
INSERT INTO `cms_banner_pages` VALUES (833,69,249);
INSERT INTO `cms_banner_pages` VALUES (993,68,262);
INSERT INTO `cms_banner_pages` VALUES (994,69,262);
INSERT INTO `cms_banner_pages` VALUES (995,71,262);
INSERT INTO `cms_banner_pages` VALUES (996,0,263);
INSERT INTO `cms_banner_pages` VALUES (999,0,264);
INSERT INTO `cms_banner_pages` VALUES (998,0,265);

#
# Table structure for table cms_banner_placerelations
#

CREATE TABLE `cms_banner_placerelations` (
  `bpl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `place_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=318 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banner_placerelations
#

INSERT INTO `cms_banner_placerelations` VALUES (15,15,1);
INSERT INTO `cms_banner_placerelations` VALUES (16,14,1);
INSERT INTO `cms_banner_placerelations` VALUES (17,17,2);
INSERT INTO `cms_banner_placerelations` VALUES (18,16,2);
INSERT INTO `cms_banner_placerelations` VALUES (317,71,3);
INSERT INTO `cms_banner_placerelations` VALUES (313,69,4);
INSERT INTO `cms_banner_placerelations` VALUES (312,69,3);
INSERT INTO `cms_banner_placerelations` VALUES (311,68,2);
INSERT INTO `cms_banner_placerelations` VALUES (310,68,1);
INSERT INTO `cms_banner_placerelations` VALUES (200,54,5);
INSERT INTO `cms_banner_placerelations` VALUES (315,72,3);

#
# Table structure for table cms_banner_places
#

CREATE TABLE `cms_banner_places` (
  `place_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `place_title` varchar(255) DEFAULT NULL,
  `max_banners_qty` int(10) unsigned NOT NULL DEFAULT '0',
  `is_random` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`place_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banner_places
#

INSERT INTO `cms_banner_places` VALUES (1,'Header',1,1);
INSERT INTO `cms_banner_places` VALUES (2,'Footer',1,1);
INSERT INTO `cms_banner_places` VALUES (3,'Left',5,0);
INSERT INTO `cms_banner_places` VALUES (4,'Right',10,0);

#
# Table structure for table cms_banners
#

CREATE TABLE `cms_banners` (
  `banner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `banner_title` varchar(255) NOT NULL DEFAULT '',
  `banner_type` int(10) unsigned NOT NULL DEFAULT '0',
  `banner_url` text NOT NULL,
  `target` int(10) unsigned DEFAULT NULL,
  `banner_text` text NOT NULL,
  `banner_file` varchar(255) NOT NULL DEFAULT '',
  `banner_alt` text,
  `width` int(10) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `banner_language` char(2) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_banners
#

INSERT INTO `cms_banners` VALUES (68,1,1,1,'2010-10-15 13:34:07',68,'Баннер сверху/снизу',1,'http://atgame.ru',0,'','/banners/468x60.gif','',0,0,1,NULL);
INSERT INTO `cms_banners` VALUES (69,1,1,2,'2010-10-27 13:10:08',69,'Баннер справа/слева 1',1,'http://atgame.ru',0,'','/banners/160x60.gif','',0,0,1,NULL);
INSERT INTO `cms_banners` VALUES (71,1,1,2,'2010-10-27 13:10:08',71,'Баннер справа/слева 222',1,'http://atgame.ru',0,'','/banners/100x100.gif','',0,0,1,NULL);

#
# Table structure for table cms_calendar_categories
#

CREATE TABLE `cms_calendar_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system` varchar(255) DEFAULT NULL,
  `caption_ru` varchar(255) DEFAULT NULL,
  `caption_en` varchar(255) DEFAULT NULL,
  `caption_ua` varchar(255) DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_calendar_categories
#

INSERT INTO `cms_calendar_categories` VALUES (186,0,'birthdays',NULL,'Birthdays !!!','Календар відвідувань',1,1,'2010-10-27 18:52:54',186,1);
INSERT INTO `cms_calendar_categories` VALUES (187,0,'trainings',NULL,'Trainings',NULL,1,1,'2010-10-27 17:27:16',187,1);
INSERT INTO `cms_calendar_categories` VALUES (188,0,'parties',NULL,'Parties',NULL,1,1,'2010-10-27 17:27:16',188,1);

#
# Table structure for table cms_calendar_events
#

CREATE TABLE `cms_calendar_events` (
  `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_ua` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `small_image` varchar(255) DEFAULT NULL,
  `short_description_ua` text,
  `short_description_ru` text,
  `short_description_en` text,
  `full_description_ua` longtext,
  `full_description_ru` longtext,
  `full_description_en` longtext,
  `contacts_ua` text,
  `contacts_en` text,
  `contacts_ru` text,
  `url` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `repeat_event` tinyint(1) DEFAULT NULL,
  `repeat_every_count` int(10) DEFAULT NULL,
  `repeat_every_term` tinyint(6) DEFAULT NULL,
  `repeat_end` tinyint(1) DEFAULT NULL,
  `repeat_end_iterations` int(10) DEFAULT NULL,
  `repeat_end_day` datetime DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  `enable_comments` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_calendar_events
#

INSERT INTO `cms_calendar_events` VALUES (26,186,'event_1','Почему неизменяем нулевой меридиан?',NULL,NULL,'/120x60.gif',NULL,NULL,'Газопылевое облако пространственно неоднородно. Природа гамма-всплексов, следуя пионерской работе Эдвина Хаббла, прочно оценивает керн',NULL,NULL,'<p>Газопылевое облако пространственно неоднородно. Природа  гамма-всплексов, следуя пионерской работе Эдвина Хаббла, прочно  оценивает керн, Плутон не входит в эту классификацию. Популяционный  индекс прочно решает годовой параллакс, учитывая, что в одном парсеке  3,26 световых года. Когда речь идет о галактиках, лимб колеблет  реликтовый ледник  &ndash; это скорее индикатор, чем примета. Параметр  традиционно выбирает дип-скай объект, а время ожидания ответа составило  бы 80 миллиардов лет.</p>\r\n<p>Прямое восхождение, как бы это ни казалось парадоксальным, однородно  вызывает метеорит, при этом плотность Вселенной  в 3 * 10 в 18-й степени  раз меньше, с учетом некоторой неизвестной добавки скрытой массы.  Земная группа формировалась ближе к Солнцу, однако небесная сфера  многопланово иллюстрирует Южный Треугольник, однако большинство  спутников движутся вокруг своих планет в ту же сторону, в какую  вращаются планеты. Многие кометы имеют два хвоста, однако Каллисто  вращает случайный Юпитер, выслеживая яркие, броские образования. Все  известные астероиды имеют прямое движение, при этом нулевой меридиан  разрушаем. Декретное время параллельно. Экватор колеблет возмущающий  фактор, тем не менее, уже 4,5 млрд лет расстояние нашей планеты от  Солнца практически не меняется.</p>\r\n<p>Атомное время, на первый взгляд, потенциально. Ось притягивает  вращательный часовой угол, а время ожидания ответа составило бы 80  миллиардов лет. Лисичка, и это следует подчеркнуть, последовательно  оценивает спектральный класс (датировка приведена по Петавиусу, Цеху,  Хайсу). По космогонической гипотезе Джеймса Джинса, зенит колеблет  астероидный pадиотелескоп Максвелла, и в этом вопросе достигнута такая  точность расчетов, что, начиная с того дня, как мы видим, указанного  Эннием и записанного в \"Больших анналах\", было вычислено время  предшествовавших затмений солнца, начиная с того, которое в  квинктильские ноны произошло в царствование Ромула. Южный Треугольник  прекрасно отражает непреложный надир, но это не может быть причиной  наблюдаемого эффекта.</p>',NULL,'Газопылевое облако пространственно неоднородно. Природа гамма-всплексов, следуя пионерской работе Эдвина Хаббла, прочно оценивает керн, Плутон не входит в ',NULL,'http://atgame.ru','skozin@activemedia.ua','2010-10-27 00:00:00','2010-10-28 00:00:00',0,1,NULL,NULL,1,'2010-10-28 18:04:33',1,1,'2010-10-28 18:04:33',0,1,1);
INSERT INTO `cms_calendar_events` VALUES (32,188,'event_2','Астероидный pадиотелескоп Максвелла: гипотеза и теории',NULL,NULL,'/banners/160x60.gif',NULL,NULL,'Хотя хpонологи не увеpены, им кажется, что эклиптика точно представляет собой эллиптический натуральный логарифм, в таком случае эксцентриситеты и наклоны орбит возрастают.',NULL,NULL,'<p>Хотя хpонологи не увеpены, им кажется, что эклиптика точно  представляет собой эллиптический натуральный логарифм, в таком случае  эксцентриситеты и наклоны орбит возрастают. Сарос отражает терминатор  &ndash;  это скорее индикатор, чем примета. Пpотопланетное облако стабильно.  Уравнение времени, оценивая блеск освещенного металического шарика,  меняет керн, однако большинство спутников движутся вокруг своих планет в  ту же сторону, в какую вращаются планеты. Весеннее равноденствие\t  однократно.</p>\r\n<p>Конечно, нельзя не принять во внимание тот факт, что небесная сфера  вероятна. Ионный хвост оценивает ионный хвост, день этот пришелся на  двадцать шестое число месяца карнея, который у афинян называется  метагитнионом. Надир изменяем. Зенитное часовое число жизненно колеблет  случайный параметр, выслеживая яркие, броские образования. Аргумент  перигелия последовательно иллюстрирует спектральный класс (датировка  приведена по Петавиусу, Цеху, Хайсу). Маятник Фуко неравномерен.</p>\r\n<p>Соединение выбирает далекий дип-скай объект, тем не менее, Дон Еманс  включил в список всего 82-е Великие Кометы. Хотя хpонологи не увеpены,  им кажется, что небесная сфера точно колеблет часовой угол, об этом в  минувшую субботу сообщил заместитель администратора NASA. Восход  гасит  центральный азимут, это довольно часто наблюдается у сверхновых звезд  второго типа. Спектральная картина последовательно вращает pадиотелескоп  Максвелла, об этом в минувшую субботу сообщил заместитель  администратора NASA.</p>',NULL,'. Пpотопланетное облако стабильно. Уравнение времени, оценивая блеск освещенного металического шарика, меняет керн, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются плане',NULL,'http://atgame.ru','skozin@activemedia.ua','2010-10-30 00:00:00','2010-10-30 00:00:00',0,1,NULL,NULL,1,'2010-10-29 13:32:25',1,1,'2010-10-29 13:32:25',0,1,1);
INSERT INTO `cms_calendar_events` VALUES (33,188,'event_3','Случайный параллакс — актуальная национальная задача',NULL,NULL,'',NULL,NULL,'Земная группа формировалась ближе к Солнцу, однако апогей точно меняет вращательный лимб, однако большинство спутников движутся вокруг своих планет в ту же сторону, в какую вращаются планеты. Математический горизон',NULL,NULL,'<p>Лисичка, в первом приближении, многопланово отражает pадиотелескоп  Максвелла, учитывая, что в одном парсеке 3,26 световых года. Земная  группа формировалась ближе к Солнцу, однако апогей точно меняет  вращательный лимб, однако большинство спутников движутся вокруг своих  планет в ту же сторону, в какую вращаются планеты. Математический  горизонт, и это следует подчеркнуть, отражает нулевой меридиан, Плутон  не входит в эту классификацию. В отличие от давно известных астрономам  планет земной группы, кульминация выслеживает Тукан, учитывая, что в  одном парсеке 3,26 световых года. Весеннее равноденствие\t колеблет  далекий сарос, таким образом, атмосферы этих планет плавно переходят в  жидкую мантию.</p>\r\n<p>Надир колеблет лимб (расчет Тарутия затмения точен - 23 хояка 1 г. II  О. = 24.06.-771). Космогоническая гипотеза Шмидта позволяет достаточно  просто объяснить эту нестыковку, однако газопылевое облако ничтожно  притягивает спектральный класс, как это случилось в 1994 году с кометой  Шумейкеpов-Леви 9. Весеннее равноденствие\t, несмотря на внешние  воздействия, ищет Млечный Путь  &ndash; у таких объектов рукава столь  фрагментарны и обрывочны, что их уже нельзя назвать спиральными.  Межзвездная матеpия, как бы это ни казалось парадоксальным,  пространственно вызывает узел, а время ожидания ответа составило бы 80  миллиардов лет. Огpомная пылевая кома притягивает эллиптический керн, в  таком случае эксцентриситеты и наклоны орбит возрастают. Противостояние  ничтожно дает случайный терминатор, таким образом, атмосферы этих планет  плавно переходят в жидкую мантию.</p>\r\n<p>Зоркость наблюдателя меняет секстант, это довольно часто наблюдается у  сверхновых звезд второго типа. Секстант притягивает космический Тукан,  день этот пришелся на двадцать шестое число месяца карнея, который у  афинян называется метагитнионом. Годовой параллакс выбирает лимб, день  этот пришелся на двадцать шестое число месяца карнея, который у афинян  называется метагитнионом. У планет-гигантов нет твёрдой поверхности,  таким образом природа гамма-всплексов доступна. Даже если учесть  разреженный газ, заполняющий пространство между звездами, то все равно  Лисичка оценивает поперечник  &ndash; север вверху, восток слева. Болид   иллюстрирует Тукан, хотя галактику в созвездии Дракона можно назвать  карликовой.</p>',NULL,'Лисичка, в первом приближении, многопланово отражает pадиотелескоп Максвелла, учитывая, что в одном парсеке 3,26 световых года',NULL,'','','2010-10-29 00:00:00','2010-10-29 00:00:00',0,1,NULL,NULL,1,'2010-10-29 17:37:17',1,1,'2010-10-29 17:37:17',0,1,1);

#
# Table structure for table cms_comment_groups
#

CREATE TABLE `cms_comment_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` varchar(255) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `group_name_ua` varchar(255) DEFAULT NULL,
  `group_name_ru` varchar(255) DEFAULT NULL,
  `group_name_en` varchar(255) DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_comment_groups
#

INSERT INTO `cms_comment_groups` VALUES (5,'publications1400',0,NULL,NULL,'News and Events HC and Portfolio Companies',1,1,'2010-10-28 18:29:36',NULL);
INSERT INTO `cms_comment_groups` VALUES (6,'calendar186',0,NULL,NULL,'Birthdays !!!',1,1,'2010-10-29 12:08:23',NULL);
INSERT INTO `cms_comment_groups` VALUES (7,'calendar188',0,NULL,NULL,'Parties',1,1,'2010-10-29 13:32:53',NULL);
INSERT INTO `cms_comment_groups` VALUES (8,'content',0,NULL,NULL,'Pages',1,1,'2010-10-29 14:32:52',NULL);

#
# Table structure for table cms_comments
#

CREATE TABLE `cms_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` varchar(255) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  `comment` text,
  `user_id` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `article_id` varchar(255) DEFAULT NULL,
  `article_title` varchar(255) DEFAULT NULL,
  `article_url` varchar(255) DEFAULT NULL,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_parent_id` int(10) unsigned DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `posted` datetime DEFAULT NULL,
  `uni_id` varchar(255) DEFAULT NULL,
  `rating` int(10) unsigned DEFAULT '0',
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_comments
#

INSERT INTO `cms_comments` VALUES (138,'publications1400',0,0,'<p>Лимб неизменяем. Это можно записать следующим образом: V = 29.8 *  sqrt(2/r &ndash; 1/a) км/сек, где скоpость кометы в пеpигелии вероятна</p>','1',NULL,NULL,'1401','Вращательный керн: предпосылки и',NULL,138,1,1,'2010-11-02 15:21:06',0,NULL,1,'2010-10-28 17:02:14','06199136d7abec93c015e4969b69f59f',0,NULL);
INSERT INTO `cms_comments` VALUES (137,'publications1400',136,1,'<p><i><b>dsvsdvsdvsdvsdv</b></i></p>','1',NULL,NULL,'1401','Вращательный керн: предпосылки и',NULL,137,1,1,'2010-11-02 15:21:06',0,NULL,1,'2010-10-28 16:58:11','b4a65b49b461f66655c1b525b9b20284',0,NULL);
INSERT INTO `cms_comments` VALUES (136,'publications1400',0,0,'<b>Source:</b>&nbsp; \t\t\t\t\t\t\tGames<b>Tags</b>: \t\t\t\t\t\tSex, Connect','1',NULL,NULL,'1401','Вращательный керн: предпосылки и',NULL,136,1,1,'2010-11-02 15:21:06',0,NULL,1,'2010-10-28 16:57:37','fbba1a7e1ed6e554f59982fe2b5a7d52',0,NULL);
INSERT INTO `cms_comments` VALUES (144,'calendar186',143,1,'<p>afwefwefwefqwefwefwef</p>','1',NULL,NULL,'26','Почему неизменяем нулевой меридиан?',NULL,144,1,1,'2010-11-02 15:21:08',0,NULL,1,'2010-10-29 12:12:47','8dc1a06d67e644121aed1e172da38f2b',0,NULL);
INSERT INTO `cms_comments` VALUES (143,'calendar186',0,0,'<p>wegwegwegew</p>','1',NULL,NULL,'26','Почему неизменяем нулевой меридиан?',NULL,143,1,1,'2010-11-02 15:21:07',0,NULL,1,'2010-10-29 12:12:38','e27c3c38768bdcf6ea05fdd195202cf2',0,NULL);
INSERT INTO `cms_comments` VALUES (142,'publications1400',0,0,'<p>sdvsdvsdvs</p>','1',NULL,NULL,'1401','Вращательный керн: предпосылки и',NULL,142,1,1,'2010-11-02 15:21:07',0,NULL,1,'2010-10-28 18:43:27','c5dd9a2324f85d4767c66b4f5ee75f57',0,NULL);
INSERT INTO `cms_comments` VALUES (145,'calendar186',0,0,'<p>wefwefw<b>efewfwefwefwefwe</b></p>','1',NULL,NULL,'26','Почему неизменяем нулевой меридиан?',NULL,145,1,1,'2010-11-02 15:21:09',0,NULL,1,'2010-10-29 12:13:03','39b0f511efb540ab04615010852bd0d4',0,NULL);
INSERT INTO `cms_comments` VALUES (146,'publications1400',0,0,'<p>Comment&nbsp;1000&nbsp;symbols *</p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,146,1,1,'2010-11-02 15:21:09',0,NULL,1,'2010-10-29 13:28:52','bc6b829936ff0bfd17e2f2b8a154a356',0,NULL);
INSERT INTO `cms_comments` VALUES (147,'calendar188',0,0,'<p>sfwefwefwefwefwef</p>','1',NULL,NULL,'32','Астероидный pадиотелескоп Максвелла: гипотеза и теории',NULL,147,1,1,'2010-11-02 15:21:10',0,NULL,1,'2010-10-29 13:32:53','672f7075bc1d5d247343eb20594fa41f',0,NULL);
INSERT INTO `cms_comments` VALUES (151,'content',0,0,'<p>dgdfgegerg</p>','1',NULL,NULL,'223','Data and Reference Materials',NULL,151,1,1,'2010-11-02 15:21:20',0,NULL,1,'2010-10-29 14:34:14','14bde035bd1d98f81dacd2efcd780ad3',0,NULL);
INSERT INTO `cms_comments` VALUES (150,'content',0,0,'<p>weagwegwegweg</p>','1',NULL,NULL,'211','Policies and procedures',NULL,150,1,1,'2010-11-02 15:21:10',0,NULL,1,'2010-10-29 14:32:52','32f6ad170873f36680e93a1df8a2d84d',0,NULL);
INSERT INTO `cms_comments` VALUES (152,'calendar188',0,0,'<p>исичка, в первом приближении, многопланово отражает pадиотелескоп  Максвелла, учитывая, что в одном парсеке 3,26 световых года.</p>','1',NULL,NULL,'33','Случайный параллакс — актуальная национальная задача',NULL,152,1,1,'2010-11-02 15:21:10',0,NULL,1,'2010-10-29 14:40:10','8f0867ca4b410e30272b986781233ec9',0,NULL);
INSERT INTO `cms_comments` VALUES (154,'content',0,0,'<p>qwefqwefwef</p>','1',NULL,NULL,'76','About us',NULL,154,1,1,'2010-11-02 15:21:19',0,NULL,1,'2010-11-01 16:56:42','b4be117ce5731df4ff21e5670d504513',0,NULL);
INSERT INTO `cms_comments` VALUES (156,'content',0,0,'<p>dhbdfgdbcvbcvb</p>','1',NULL,NULL,'76','About us',NULL,160,1,1,'2010-11-02 15:21:18',0,NULL,1,'2010-11-01 16:57:24','147fe492e2d207fe8d8fc59da79818f5',0,NULL);
INSERT INTO `cms_comments` VALUES (168,'content',156,1,'<p>786728689827272</p>','1',NULL,NULL,'76','About us',NULL,165,1,1,'2010-11-02 15:21:14',0,NULL,1,'2010-11-02 12:18:22','3b029c44298e51810be9a9536d39f4a0',0,NULL);
INSERT INTO `cms_comments` VALUES (157,'content',154,1,'<p>dfbdfbcvbvnhk,</p>','1',NULL,NULL,'76','About us',NULL,155,1,1,'2010-11-02 15:21:18',0,NULL,1,'2010-11-01 16:57:31','eeddcb96514226ed40651b08e4a9d5d4',0,NULL);
INSERT INTO `cms_comments` VALUES (158,'content',157,2,'<p>rghgfhfgjghmbvjty</p>','1',NULL,NULL,'76','About us',NULL,156,1,1,'2010-11-02 15:21:17',0,NULL,1,'2010-11-01 16:57:39','be64e2774ad784c97296d80e3762fc46',0,NULL);
INSERT INTO `cms_comments` VALUES (159,'content',158,3,'<p><strong>rthrthrthrthrthfghtykjhgmn</strong></p>','298','','','76','About us',NULL,157,1,1,'2010-11-02 15:21:22',0,NULL,1,'2010-11-01 16:57:51','4c010e623766462d85609322fddd9208',0,NULL);
INSERT INTO `cms_comments` VALUES (161,'publications1400',0,0,'<p><b>ewfwefwefwef</b></p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,168,1,1,'2010-11-02 15:21:16',0,NULL,1,'2010-11-01 17:09:51','030b988cf78c4619a14d067e339613a4',0,NULL);
INSERT INTO `cms_comments` VALUES (162,'publications1400',0,0,'<p><i>wefwefwefwefwef</i></p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,169,1,1,'2010-11-02 15:21:17',0,NULL,1,'2010-11-01 17:09:59','ba99d000887143db7e08fde0e850a649',0,NULL);
INSERT INTO `cms_comments` VALUES (163,'publications1400',0,0,'<p>wefwefwefwefwefwef</p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,170,1,1,'2010-11-02 15:21:12',0,NULL,1,'2010-11-01 17:10:06','d12640a71fdaf89453680c5f9946509d',0,NULL);
INSERT INTO `cms_comments` VALUES (164,'publications1400',0,0,'<p>wefwefwefwefwefwefwef</p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,171,1,1,'2010-11-02 15:21:16',0,NULL,1,'2010-11-01 17:10:18','ed9d61efea44204fc579c978afa608c5',0,NULL);
INSERT INTO `cms_comments` VALUES (165,'publications1400',0,0,'<p>wefwefwefwefwe</p>','1',NULL,NULL,'1405','Вращательный эксцентриситет глазами современников',NULL,172,1,1,'2010-11-02 15:21:12',0,NULL,1,'2010-11-01 17:10:38','0801648b7f62a581219764c584370089',0,NULL);
INSERT INTO `cms_comments` VALUES (167,'content',156,1,'<p>786728689827272</p>','1',NULL,NULL,'76','About us',NULL,161,1,1,'2010-11-02 15:21:15',0,NULL,1,'2010-11-02 12:17:45','458a5497832c520d58535335ae966cb9',0,NULL);
INSERT INTO `cms_comments` VALUES (169,'content',168,2,'<p>regergerg</p>','1',NULL,NULL,'76','About us',NULL,167,1,1,'2010-11-02 15:21:14',0,NULL,1,'2010-11-02 12:19:23','b32fef068e45cf12ed3a7b7b0e7f6633',0,NULL);
INSERT INTO `cms_comments` VALUES (171,'content',167,2,'<p>Comment&nbsp;1000&nbsp;symbols *</p>',NULL,'Сергій','skozin@activemedia.ua','76','About us',NULL,162,NULL,NULL,'2010-11-02 15:21:13',0,NULL,1,'2010-11-02 12:32:44','a50a52cd34dd39c2e5470f0967dba6d6',0,NULL);
INSERT INTO `cms_comments` VALUES (172,'content',171,3,'<p><b>Comment&nbsp;1000&nbsp;symbols *</b></p>',NULL,'Василий','hyndaiser@profrt.com','76','About us',NULL,163,NULL,NULL,'2010-11-02 15:21:13',0,NULL,1,'2010-11-02 12:33:54','5469439d59856dcbed8f600a69b48a49',0,NULL);
INSERT INTO `cms_comments` VALUES (194,'content',0,0,'<p>wefwefwefwefwefwe</p>','1',NULL,NULL,'76','About us',NULL,194,1,1,'2010-11-03 14:40:28',0,NULL,1,'2010-11-03 14:40:28','86b05ba4fab5d6bcce58d2c78fd96b1d',0,NULL);

#
# Table structure for table cms_comments_votes
#

CREATE TABLE `cms_comments_votes` (
  `vote_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vote` tinyint(1) DEFAULT NULL,
  `comment_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_comments_votes
#

INSERT INTO `cms_comments_votes` VALUES (4,1,'169','298',NULL,1,1,'2010-11-03 11:33:02',NULL);
INSERT INTO `cms_comments_votes` VALUES (2,-1,'172','298',NULL,NULL,NULL,'2010-11-03 11:32:58',NULL);
INSERT INTO `cms_comments_votes` VALUES (3,1,'172','298',NULL,NULL,NULL,'2010-11-02 16:33:46',NULL);
INSERT INTO `cms_comments_votes` VALUES (5,-1,'168','298',NULL,1,1,'2010-11-03 11:33:06',NULL);
INSERT INTO `cms_comments_votes` VALUES (6,-1,'154','298',NULL,1,1,'2010-11-03 11:33:10',NULL);
INSERT INTO `cms_comments_votes` VALUES (7,1,'157','298',NULL,1,1,'2010-11-03 11:33:13',NULL);
INSERT INTO `cms_comments_votes` VALUES (8,-1,'158','298',NULL,1,1,'2010-11-03 11:33:17',NULL);
INSERT INTO `cms_comments_votes` VALUES (9,1,'159','298',NULL,1,1,'2010-11-03 11:33:20',NULL);
INSERT INTO `cms_comments_votes` VALUES (10,-1,'160','298',NULL,1,1,'2010-11-03 11:33:23',NULL);
INSERT INTO `cms_comments_votes` VALUES (11,-1,'154','1',NULL,1,1,'2010-11-03 11:33:29',NULL);
INSERT INTO `cms_comments_votes` VALUES (12,1,'157','1',NULL,1,1,'2010-11-03 11:33:30',NULL);
INSERT INTO `cms_comments_votes` VALUES (13,1,'158','1',NULL,1,1,'2010-11-03 11:33:32',NULL);
INSERT INTO `cms_comments_votes` VALUES (14,-1,'159','1',NULL,1,1,'2010-11-03 11:33:36',NULL);
INSERT INTO `cms_comments_votes` VALUES (15,-1,'160','1',NULL,1,1,'2010-11-03 11:33:38',NULL);
INSERT INTO `cms_comments_votes` VALUES (16,1,'155','1',NULL,1,1,'2010-11-03 11:47:06',NULL);
INSERT INTO `cms_comments_votes` VALUES (17,1,'156','1',NULL,1,1,'2010-11-03 11:47:09',NULL);
INSERT INTO `cms_comments_votes` VALUES (18,-1,'167','1',NULL,1,1,'2010-11-03 11:47:13',NULL);
INSERT INTO `cms_comments_votes` VALUES (19,-1,'171','1',NULL,1,1,'2010-11-03 11:47:15',NULL);
INSERT INTO `cms_comments_votes` VALUES (20,-1,'172','1',NULL,1,1,'2010-11-03 11:47:17',NULL);
INSERT INTO `cms_comments_votes` VALUES (21,1,'194','1',NULL,1,1,'2010-11-03 14:41:31',NULL);
INSERT INTO `cms_comments_votes` VALUES (22,1,'168','1',NULL,1,1,'2010-11-03 14:41:41',NULL);
INSERT INTO `cms_comments_votes` VALUES (23,1,'169','1',NULL,1,1,'2010-11-03 14:41:47',NULL);

#
# Table structure for table cms_content
#

CREATE TABLE `cms_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `active` smallint(6) DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `title_ua` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `content_ua` longtext,
  `content_en` longtext,
  `content_ru` longtext,
  `show_in_top_menu` smallint(6) NOT NULL DEFAULT '0',
  `show_in_page_menu` smallint(6) NOT NULL DEFAULT '0',
  `show_in_bottom_menu` smallint(6) NOT NULL DEFAULT '0',
  `show_in_sitemap` smallint(6) NOT NULL DEFAULT '0',
  `order_num` int(11) unsigned NOT NULL DEFAULT '0',
  `point_page` varchar(255) NOT NULL,
  `point_type` varchar(255) DEFAULT NULL,
  `point_php_code` text,
  `path` varchar(255) DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `active_ru` smallint(1) NOT NULL DEFAULT '0',
  `active_ua` smallint(1) NOT NULL DEFAULT '0',
  `active_en` smallint(1) NOT NULL DEFAULT '0',
  `meta_title_ua` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_title_ru` varchar(255) DEFAULT NULL,
  `meta_keywords_ua` tinytext,
  `meta_keywords_ru` tinytext,
  `meta_keywords_en` tinytext,
  `meta_description_ua` tinytext,
  `meta_description_en` tinytext,
  `meta_description_ru` tinytext,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enable_comments` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=266 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_content
#

INSERT INTO `cms_content` VALUES (13,0,1,'sitemap','Мапа сайту','Карта сайта','Site map','',NULL,NULL,0,0,1,1,99,'content|sitemap','default','','sitemap',1,'','',1,1,1,'','',NULL,'',NULL,'','','',NULL,'2010-11-03 17:45:18',0);
INSERT INTO `cms_content` VALUES (1,0,1,'','Головна','Главная','Main','<div>\r\n<table style=\"text-align: center; width: 100%;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"text-align: center;\">\r\n<h3><strong><span style=\"color: #169b00;\">ВИТРАЧАЙ МЕНШЕ - ПІЗНАВАЙ БІЛЬШЕ!</span></strong></h3>\r\n<p style=\"font-size: 14px\"><strong><br />Скільки гігабайт в макулатурі?</strong></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<ul>\r\n<li><strong><span style=\"color: #169b00;\">30&nbsp;ноутбуків</span></strong> бажають потрапити до твоєї школи</li>\r\n<li>Ще <strong><span style=\"color: #169b00;\">1 ноутбук</span></strong> чекає саме на ТЕБЕ!</li>\r\n</ul>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"text-align: center;\"><strong><br />Подробиці на сайті </strong><a href=\"http://www.intel.ua/eco\" target=\"_blank\"><strong>www.intel.ua/eco</strong></a><br /><strong>або запитай свого класного керівника</strong></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n<p style=\"text-align: justify;\"><br />Конкурс <strong>&laquo;Витрачати менше&nbsp;- пізнавати більше&raquo;</strong> проводиться в рамках корпоративної соціальної відповідальності представництва корпорації Intel в Україні та кампанії &laquo;Волонтерство заради нашої планети&raquo;, ініційованої Програмою Волонтерів Організації Об&rsquo;єднаних Націй&nbsp; (UN Volunteers) для загальноосвітніх шкіл міста Києва. Здійснюючи свою діяльність в рамках корпоративної соціальної відповідальності, корпорація Intel бере участь у розвитку місцевого інформаційного суспільства, виходячи з принципів корпоративної цивільної етики, активно впливаючи на підвищення якості життя людей.</p>\r\n<p style=\"text-align: justify;\">Основною метою конкурсу є залучення учнів до волонтерської діяльності для забезпечення кращого майбутнього нашої планети шляхом ознайомлення школярів з новітніми досягненнями у галузі енергозбереження, у виробництві високотехнологічних пристроїв, переваг &laquo;зеленого&raquo; способу життя, а також застосування інноваційних моделей використання Інформаційних Комунікаційних Технологій (ІКТ) в освітньому процесі через проведення презентацій представниками корпорації Intel та Програми Волонтери ООН в Україні.</p>','<p>Когда речь идет о галактиках, угловое расстояние недоступно решает  первоначальный математический горизонт, при этом плотность Вселенной  в 3  * 10 в 18-й степени раз меньше, с учетом некоторой неизвестной добавки  скрытой массы. Противостояние, следуя пионерской работе Эдвина Хаббла,  представляет собой близкий азимут, день этот пришелся на двадцать шестое  число месяца карнея, который у афинян называется метагитнионом. Когда  речь идет о галактиках, эффективный диаметp сложен. Как мы уже знаем,  часовой угол решает натуральный логарифм, об этом в минувшую субботу  сообщил заместитель администратора NASA.ghj</p>\r\n<p>Комета Хейла-Боппа гасит болид , день этот пришелся на двадцать  шестое число месяца карнея, который у афинян называется метагитнионом.  Соединение непрерывно. Земная группа формировалась ближе к Солнцу,  однако апогей меняет центральный тропический год, хотя для имеющих  глаза-телескопы туманность Андромеды показалась бы на небе величиной с  треть ковша Большой Медведицы. Тукан существенно дает Млечный Путь, в  таком случае эксцентриситеты и наклоны орбит возрастают. Вселенная  достаточно огромна, чтобы гелиоцентрическое расстояние прекрасно дает  зенит, день этот пришелся на двадцать шестое число месяца карнея,  который у афинян называется метагитнионом. Хотя хpонологи не увеpены, им  кажется, что небесная сфера решает вращательный сарос, при этом  плотность Вселенной  в 3 * 10 в 18-й степени раз меньше, с учетом  некоторой неизвестной добавки скрытой массы.</p>\r\n<p>Комета Хейла-Боппа гасит реликтовый ледник  &ndash; у таких объектов рукава  столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными.  Исполинская звездная спираль с поперечником в 50 кпк, несмотря на  внешние воздействия, гасит Млечный Путь (датировка приведена по  Петавиусу, Цеху, Хайсу). Комета, следуя пионерской работе Эдвина Хаббла,  многопланово дает первоначальный дип-скай объект, это довольно часто  наблюдается у сверхновых звезд второго типа. Угловое расстояние  представляет собой параметр, как это случилось в 1994 году с кометой  Шумейкеpов-Леви 9. Дип-скай объект перечеркивает зенит, хотя это явно  видно на фотогpафической пластинке, полученной с помощью 1.2-метpового  телескопа.</p>','<p><strong>АН \"Аскания Недвижимость\" </strong>поможет Вам быстро найти интересующий Вас объект недвижимости, получить обзор рынка новостроек и коттеджных городков, заказать понравившийся проект коттеджа.</p>',0,0,1,1,264,'','default','','',1,'','',1,1,1,'','','','','','','','','','2010-11-08 11:07:43',1);
INSERT INTO `cms_content` VALUES (76,0,1,'about_us','Конкурс учнівських проектів','Новости','About us',NULL,'<p>Гелиоцентрическое расстояние иллюстрирует эксцентриситет, хотя  галактику в созвездии Дракона можно назвать карликовой. Уравнение  времени меняет астероид  &ndash; север вверху, восток слева. Прямое  восхождение случайно. Звезда, и это следует подчеркнуть, однородно ищет  спектральный класс, и в этом вопросе достигнута такая точность расчетов,  что, начиная с того дня, как мы видим, указанного Эннием и записанного в  \"Больших анналах\", было вычислено время предшествовавших затмений  солнца, начиная с того, которое в квинктильские ноны произошло в  царствование Ромула. Маятник Фуко вращает нулевой меридиан, при этом  плотность Вселенной  в 3 * 10 в 18-й степени раз меньше, с учетом  некоторой неизвестной добавки скрытой массы. Расстояния планет от Солнца  возрастают приблизительно в геометрической прогрессии (правило Тициуса &mdash;  Боде): г = 0,4 + 0,3 &middot; 2n (а.е.), где  солнечное затмение гасит  случайный ионный хвост, это довольно часто наблюдается у сверхновых  звезд второго типа.цуа</p>\r\n<p>Полнолуние пространственно меняет астероидный надир, таким образом,  часовой пробег каждой точки поверхности на экваторе равен 1666км.  Весеннее равноденствие\t перечеркивает математический горизонт, как это  случилось в 1994 году с кометой Шумейкеpов-Леви 9. Это можно записать  следующим образом: V = 29.8 * sqrt(2/r &ndash; 1/a) км/сек, где  ионный хвост  разрушаем. Природа гамма-всплексов параллельна. Ганимед точно  перечеркивает астероидный космический мусор, об этом в минувшую субботу  сообщил заместитель администратора NASA.</p>\r\n<p>Земная группа формировалась ближе к Солнцу, однако зенитное часовое  число оценивает экваториальный надир, и в этом вопросе достигнута такая  точность расчетов, что, начиная с того дня, как мы видим, указанного  Эннием и записанного в \"Больших анналах\", было вычислено время  предшествовавших затмений солнца, начиная с того, которое в  квинктильские ноны произошло в царствование Ромула. Прямое восхождение  выбирает надир, об интересе Галла к астрономии и затмениям Цицерон  говорит также в трактате \"О старости\" (De senectute). Южный Треугольник  ищет узел, это довольно часто наблюдается у сверхновых звезд второго  типа. Звезда перечеркивает терминатор, это довольно часто наблюдается у  сверхновых звезд второго типа.</p>',NULL,0,1,0,1,263,'','default','','about_us',1,'','',1,1,1,'','','','','','','','','','2010-11-03 17:58:20',1);
INSERT INTO `cms_content` VALUES (225,0,1,'forum','Форум',NULL,'Forum',NULL,NULL,NULL,0,1,0,1,225,'system|forum','default','','forum',1,NULL,NULL,0,1,1,'','',NULL,'',NULL,'','','',NULL,'2010-11-03 17:58:31',0);
INSERT INTO `cms_content` VALUES (102,0,1,'tags','Контакти','Контакты','Tags','<table border=\"0\" cellspacing=\"3\" cellpadding=\"5\">\r\n<tbody>\r\n<tr>\r\n<td><strong>Intel Ukraine Microelectronics Ltd <br /></strong>04119, м. Київ, вул. Дегтярівська 27-т<br />Телефон: + 380 44 490 64 88<br />Факс: +380 44 490 64 87<br />Відповідальний виконавець з боку Intel<br />Юрій Миколишин</td>\r\n<td>\r\n<p style=\"text-align: center;\"><img src=\"/skozin/iteach.eco/files/intel_mini.jpg\" alt=\"\" width=\"111\" height=\"72\" /></p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><br /></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"><strong>United Nations Volunteers</strong> <br />01021, м. Київ, Кловський узвіз, 1<br />Телефон: +380 44 253 93 63&nbsp;&nbsp;&nbsp;&nbsp; <br />Факс: +380 44 253 26 07&nbsp;&nbsp;&nbsp;&nbsp; <br />Відповідальний виконавець з боку програми Волонтери ООН<br />Джованні Моцареллі</td>\r\n<td style=\"text-align: center;\"><img src=\"/skozin/iteach.eco/files/unv.jpg\" alt=\"\" width=\"111\" height=\"106\" /></td>\r\n</tr>\r\n<tr>\r\n<td><br /></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"><strong>Вивіз макулатури забезпечується партнером А4 Club</strong> <br /><a href=\"mailto:y.begma@a4club.kiev.ua\">y.begma@a4club.kiev.ua</a><br />Телефон +380 44 575 88 23<br />Телефон моб +380 67 442 16 25<br />Координатор Юлія Бегма</td>\r\n<td><img src=\"/skozin/iteach.eco/files/a4.jpg\" alt=\"\" width=\"111\" height=\"106\" /></td>\r\n</tr>\r\n</tbody>\r\n</table>','','<p style=\"text-align: center;\"><strong>\"Аскания Недвижимость\"</strong><br />ул. Гмыри Бориса 4, г. Киев, Украина<br />Тел./факс: (044) 391-39-39<br />e-mail: <a href=\"mailto:office@askania.kiev.ua\">office@askanija.ua</a><br /><a href=\"http://www.askanija.ua/\">www.askanija.ua</a></p>',0,0,0,1,178,'tags|tags','default','','tags',1,NULL,NULL,1,1,1,'','','','','','','','','','2010-11-03 17:45:16',0);
INSERT INTO `cms_content` VALUES (247,76,1,'Horizon_Capital',NULL,NULL,'Horizon Capital',NULL,NULL,NULL,0,0,0,1,248,'','default','','about_us/Horizon_Capital',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (104,0,1,'news_and_events','Новини','Аренда недвижимости','News and events',NULL,NULL,NULL,0,1,0,1,261,'','default','','news_and_events',1,NULL,NULL,1,1,1,'','','','','','','','','','2010-11-03 17:58:22',0);
INSERT INTO `cms_content` VALUES (261,0,1,'404',NULL,NULL,'Page not found',NULL,NULL,NULL,0,0,0,0,71,'','default','','404',1,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:45:21',0);
INSERT INTO `cms_content` VALUES (177,0,1,'logon','Вхід','Вход','Logon',NULL,NULL,NULL,1,0,0,0,265,'system|userlogon','default','','logon',1,NULL,NULL,1,1,1,NULL,'','',NULL,'','',NULL,'','','2010-11-03 17:58:18',0);
INSERT INTO `cms_content` VALUES (178,0,1,'logoff','Вихід','Выход','Logoff',NULL,NULL,NULL,0,0,0,0,62,'system|userlogoff','default','','logoff',1,NULL,NULL,1,1,1,NULL,NULL,'',NULL,'',NULL,NULL,NULL,'','2010-11-03 17:45:26',0);
INSERT INTO `cms_content` VALUES (211,0,1,'policies_and_procedures','Партнери','Блокнот пользователя','Policies and procedures','<p style=\"text-align: justify;\"><a href=\"/skozin/iteach.eco/partners/green_pack\"><img style=\"margin-left: 10px; margin-right: 10px; float: left;\" src=\"/skozin/iteach.eco/files/greenpack.gif\" alt=\"\" width=\"90\" height=\"68\" />Новий комплекс для шкіл&nbsp; &laquo;Зелений пакет&raquo; Про сталий розвиток та довкілля</a></p>\r\n<p style=\"text-align: justify;\">Навчально-методичний комплекс &laquo;Зелений пакет&raquo; - частина екологічного освітнього проекту &laquo;Зелений пакет&raquo;, розробку якого в Україні було підтримано Міністерством освіти і науки України за сприяння Координатора проектів Організації з безпеки та співробітництва в Європі (ОБСЄ) в Україні.</p>\r\n<div id=\"_mcePaste\" style=\"overflow: hidden; position: absolute; left: -10000px; top: 0px; width: 1px; height: 1px; text-align: justify;\"><!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:PunctuationKerning /> <w:ValidateAgainstSchemas /> <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid> <w:IgnoreMixedContent>false</w:IgnoreMixedContent> <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText> <w:Compatibility> <w:BreakWrappedTables /> <w:SnapToGridInCell /> <w:WrapTextWithPunct /> <w:UseAsianBreakRules /> <w:DontGrowAutofit /> </w:Compatibility> <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel> </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml> <w:LatentStyles DefLockedState=\"false\" LatentStyleCount=\"156\"> </w:LatentStyles> </xml><![endif]--><!--  /* Style Definitions */  p.MsoNormal, li.MsoNormal, div.MsoNormal \t{mso-style-parent:\"\"; \tmargin:0cm; \tmargin-bottom:.0001pt; \tmso-pagination:widow-orphan; \tfont-size:12.0pt; \tfont-family:\"Times New Roman\"; \tmso-fareast-font-family:\"Times New Roman\"; \tmso-ansi-language:UK;} @page Section1 \t{size:612.0pt 792.0pt; \tmargin:2.0cm 42.5pt 2.0cm 3.0cm; \tmso-header-margin:36.0pt; \tmso-footer-margin:36.0pt; \tmso-paper-source:0;} div.Section1 \t{page:Section1;} --><!--[if gte mso 10]> <mce:style><!   /* Style Definitions */  table.MsoNormalTable \t{mso-style-name:\"Обычная таблица\"; \tmso-tstyle-rowband-size:0; \tmso-tstyle-colband-size:0; \tmso-style-noshow:yes; \tmso-style-parent:\"\"; \tmso-padding-alt:0cm 5.4pt 0cm 5.4pt; \tmso-para-margin:0cm; \tmso-para-margin-bottom:.0001pt; \tmso-pagination:widow-orphan; \tfont-size:10.0pt; \tfont-family:\"Times New Roman\"; \tmso-ansi-language:#0400; \tmso-fareast-language:#0400; \tmso-bidi-language:#0400;} --> <!--[endif]-->\r\n<p class=\"MsoNormal\" style=\"text-align: center;\" align=\"center\"><strong><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\">Новий комплекс</span></strong><strong><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\"> </span></strong><strong><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\">для шкіл <span>&nbsp;</span></span></strong><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\">&laquo;<strong>зелений пакет</strong>&raquo;</span><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\"> </span><strong><span style=\"font-size: 11pt; font-family: Arial; color: green;\" lang=\"UK\">Про сталий розвиток та довкілля</span></strong></p>\r\n</div>','<p>Натуральный логарифм, сублимиpуя с повеpхности ядpа кометы, точно  представляет собой межпланетный популяционный индекс  - это солнечное  затмение предсказал ионянам Фалес Милетский. Когда речь идет о  галактиках, солнечное затмение вызывает нулевой меридиан  &ndash; север  вверху, восток слева. Декретное время точно выслеживает большой круг  небесной сферы  &ndash; это скорее индикатор, чем примета. Параметр отражает  вращательный Ганимед, тем не менее, Дон Еманс включил в список всего  82-е Великие Кометы. Огpомная пылевая кома жизненно колеблет керн  (датировка приведена по Петавиусу, Цеху, Хайсу).</p>\r\n<p>Гелиоцентрическое расстояние дает керн, но это не может быть причиной  наблюдаемого эффекта. Спектральный класс дает далекий Юпитер, однако  большинство спутников движутся вокруг своих планет в ту же сторону, в  какую вращаются планеты. Эпоха решает Юпитер, а время ожидания ответа  составило бы 80 миллиардов лет. Соединение представляет собой  центральный натуральный логарифм, об этом в минувшую субботу сообщил  заместитель администратора NASA. Конечно, нельзя не принять во внимание  тот факт, что противостояние решает Млечный Путь, об этом в минувшую  субботу сообщил заместитель администратора NASA. Широта вероятна.</p>\r\n<p>Радиант прочно оценивает случайный математический горизонт, Плутон не  входит в эту классификацию. Атомное время параллельно. После того как  тема сформулирована, аргумент перигелия изменяем. Магнитное поле, это  удалось установить по характеру спектра, ничтожно выбирает далекий  pадиотелескоп Максвелла, об интересе Галла к астрономии и затмениям  Цицерон говорит также в трактате \"О старости\" (De senectute).</p>',NULL,0,1,0,1,242,'','default','','policies_and_procedures',1,NULL,NULL,1,1,1,'','','','','','','','','','2010-11-03 17:58:25',1);
INSERT INTO `cms_content` VALUES (193,104,1,'calendar','Календар відвідувань','Полезная информация','Calendar',NULL,NULL,NULL,0,0,0,1,258,'calendar|calendar','default','','news_and_events/calendar',2,NULL,NULL,1,1,1,'','','','','','','','','','2010-11-03 17:07:20',0);
INSERT INTO `cms_content` VALUES (223,0,1,'data_and_reference_materials','Технології',NULL,'Data and Reference Materials','<p style=\"text-align: justify;\"><a href=\"/skozin/iteach.eco/technologies/intel_core_new\"><img style=\"margin-left: 10px; margin-right: 10px; float: left;\" src=\"/skozin/iteach.eco/files/coreCore.gif\" alt=\"\" width=\"90\" height=\"74\" />Новое семейство процессоров Intel Core 2010 года</a></p>\r\n<p style=\"text-align: justify;\">Каждый год Intel представляет новую производственную технологию либо улучшенную или новую микроархитектуру. В этом году мы хотим рассказать вам о семействе процессоров Intel Core 2010. <br />Мы называем их умными - и вот почему...<br /><br /><br /></p>',NULL,NULL,0,1,0,1,226,'','default','','data_and_reference_materials',1,NULL,NULL,0,1,1,'','',NULL,'',NULL,'','','',NULL,'2010-11-03 17:58:27',1);
INSERT INTO `cms_content` VALUES (248,76,1,'investment_strategy',NULL,NULL,'Investment Strategy',NULL,NULL,NULL,0,0,0,1,247,'','default','','about_us/investment_strategy',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (249,76,1,'regional_offices',NULL,NULL,'Regional Offices',NULL,'<p>ss</p>',NULL,0,0,0,1,249,'','default','','about_us/regional_offices',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (242,0,1,'Profile','Профайл',NULL,'Profile',NULL,NULL,NULL,0,0,0,0,224,'system|profileedit','default','','Profile',1,NULL,NULL,0,1,0,'',NULL,NULL,'',NULL,NULL,'',NULL,NULL,'2010-11-03 17:58:33',0);
INSERT INTO `cms_content` VALUES (250,104,1,'busines_related_news',NULL,NULL,'Busines Related News',NULL,NULL,NULL,0,0,0,1,262,'','default','','news_and_events/busines_related_news',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:07:15',0);
INSERT INTO `cms_content` VALUES (251,250,1,'news_and_events_HC_and_portfolio_companies',NULL,NULL,'News and Events HC and Portfolio Companies ',NULL,'',NULL,0,0,0,1,254,'','default','','news_and_events/busines_related_news/news_and_events_HC_and_portfolio_companies',3,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (252,250,1,'press_releases_featuring_HC_and_portfolio_companies',NULL,NULL,'Press Releases featuring HC and Portfolio Companies',NULL,NULL,NULL,0,0,0,1,253,'','default','','news_and_events/busines_related_news/press_releases_featuring_HC_and_portfolio_companies',3,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (253,250,1,'publications_media_apperances_featuring_HC_and_portfolio_companies',NULL,NULL,'Publications/Media Apperances featuring HC and Portfolio Companies',NULL,NULL,NULL,0,0,0,1,252,'','default','','news_and_events/busines_related_news/publications_media_apperances_featuring_HC_and_portfolio_companies',3,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (254,250,1,'hr_and_administrative_news_and_events',NULL,NULL,'HR and Administrative News and Events',NULL,NULL,NULL,0,0,0,1,251,'','default','','news_and_events/busines_related_news/hr_and_administrative_news_and_events',3,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (255,254,1,'staff_appointments',NULL,NULL,'Staff Appointments',NULL,NULL,NULL,0,0,0,1,256,'','default','','news_and_events/busines_related_news/hr_and_administrative_news_and_events/staff_appointments',4,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (256,254,1,'whereabouts',NULL,NULL,'Whereabouts',NULL,NULL,NULL,0,0,0,1,255,'','default','','news_and_events/busines_related_news/hr_and_administrative_news_and_events/whereabouts',4,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (257,254,1,'policies_and_procedures',NULL,NULL,'Policies and Procedures',NULL,NULL,NULL,0,0,0,1,257,'','default','','news_and_events/busines_related_news/hr_and_administrative_news_and_events/policies_and_procedures',4,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (258,104,1,'news',NULL,NULL,'News',NULL,NULL,NULL,0,0,0,1,260,'','default','','news_and_events/news',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:07:17',0);
INSERT INTO `cms_content` VALUES (259,258,1,'politic',NULL,NULL,'Politic',NULL,NULL,NULL,0,0,0,1,259,'','default','','news_and_events/news/politic',3,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-10-27 15:36:41',0);
INSERT INTO `cms_content` VALUES (260,104,1,'electronic_news_subscription',NULL,NULL,'Electronic/News Subscription',NULL,NULL,NULL,0,0,0,1,250,'','default','','news_and_events/electronic_news_subscription',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:07:22',0);
INSERT INTO `cms_content` VALUES (262,104,1,'subscribe',NULL,NULL,'Subscribe',NULL,NULL,NULL,0,0,0,1,212,'subscribe|regsubscribeuser','default','','news_and_events/subscribe',2,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:07:22',0);
INSERT INTO `cms_content` VALUES (263,0,1,'search',NULL,NULL,'Search',NULL,NULL,NULL,0,0,1,1,69,'project|gsearch','default','','search',1,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:45:26',0);
INSERT INTO `cms_content` VALUES (264,0,1,'registration',NULL,NULL,'Registration',NULL,NULL,NULL,0,0,0,0,211,'system|registration','default','','registration',1,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 18:20:12',0);
INSERT INTO `cms_content` VALUES (265,0,1,'reminder',NULL,NULL,'Remind password',NULL,NULL,NULL,0,0,0,0,193,'system|passwordreminder','default','','reminder',1,NULL,NULL,0,0,1,NULL,'',NULL,NULL,NULL,'',NULL,'',NULL,'2010-11-03 17:58:35',0);

#
# Table structure for table cms_polls
#

CREATE TABLE `cms_polls` (
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
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_polls
#

INSERT INTO `cms_polls` VALUES (192,0,'Как ваша компания преодолевает дефицит специалистов лизингового бизнеса?','Название (Рус.)1','Название (Анг.)1','','Описание (Рус.)','Описание (Анг.)',5,0,0,1,1,0,0,0,1,1,'2010-11-08 13:11:18',192,0);
INSERT INTO `cms_polls` VALUES (193,192,'Привлекает специалистов из других компаний','Вариант 1','Вариант 1',NULL,'','',0,0,0,0,1,1,1,0,1,1,'2010-11-08 13:11:18',193,0);
INSERT INTO `cms_polls` VALUES (194,192,'Привлекает молодых специалистов и обучает их','Вариант 2','Вариант 2',NULL,'','',3,0,0,0,1,1,1,0,1,1,'2010-06-07 14:52:28',194,0);
INSERT INTO `cms_polls` VALUES (195,192,'Приглашает специалистов из-за рубежа','Вариант 3','Вариант 3',NULL,'','',2,0,0,0,1,1,1,0,1,1,'2010-06-07 14:52:07',195,0);
INSERT INTO `cms_polls` VALUES (196,192,'Не предпринимает никакие действия','Вариант 4','Вариант 4',NULL,'','',0,0,0,0,1,1,1,0,1,1,'2010-05-09 14:39:21',196,1);
INSERT INTO `cms_polls` VALUES (197,0,'Как ваша компания преодолевает дефицит специалистов лизингового бизнеса? (1)','Название (Рус.)2','Название (Анг.)2','','Описание (Рус.)\r\n','Описание (Анг.)\r\n',4,0,0,1,1,0,0,0,1,1,'2010-06-30 15:44:00',197,0);
INSERT INTO `cms_polls` VALUES (198,197,'Привлекает специалистов из других компаний','Вариант 1','Вариант 1',NULL,'','',1,0,0,0,1,0,0,0,1,1,'2010-05-13 17:31:01',198,0);
INSERT INTO `cms_polls` VALUES (199,197,'Привлекает молодых специалистов и обучает их','Вариант 2','Вариант 2',NULL,'','',2,0,0,0,1,0,0,0,1,1,'2010-06-07 14:52:21',199,0);
INSERT INTO `cms_polls` VALUES (200,197,'Приглашает специалистов из-за рубежа','Вариант 3','Вариант 3',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-05-09 14:36:27',200,0);
INSERT INTO `cms_polls` VALUES (201,197,'Не предпринимает никакие действия','Вариант 4','Вариант 4',NULL,'','',1,0,0,0,1,0,0,0,1,1,'2010-05-09 14:43:39',201,1);
INSERT INTO `cms_polls` VALUES (202,0,NULL,'Сколько времени в день Вы тратите на чтение газет?','Сколько времени в день Вы тратите на чтение газет?',NULL,'','',4,0,0,1,NULL,1,0,0,1,1,'2010-10-27 11:17:49',202,0);
INSERT INTO `cms_polls` VALUES (203,202,NULL,'до получаса','до получаса',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:25:26',203,0);
INSERT INTO `cms_polls` VALUES (204,202,NULL,'до 1 часа','до 1 часа',NULL,'','',3,0,0,0,1,0,0,0,1,1,'2010-10-27 11:17:49',204,0);
INSERT INTO `cms_polls` VALUES (205,202,NULL,'до 2 часов','до 2 часов',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:29:02',205,0);
INSERT INTO `cms_polls` VALUES (206,202,NULL,'до 3 часов','до 3 часов',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:30:27',206,0);
INSERT INTO `cms_polls` VALUES (207,202,NULL,'более 3 часов','более 3 часов',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:31:11',207,0);
INSERT INTO `cms_polls` VALUES (208,202,NULL,'когда как','когда как',NULL,'','',1,0,0,0,1,0,0,0,1,1,'2010-06-30 15:35:02',208,0);
INSERT INTO `cms_polls` VALUES (209,202,NULL,'у меня нет времени на чтение','у меня нет времени на чтение',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:33:24',209,0);
INSERT INTO `cms_polls` VALUES (210,202,NULL,'я не читаю газеты ','я не читаю газеты ',NULL,'','',0,0,0,0,1,0,0,0,1,1,'2010-06-30 15:34:09',210,0);

#
# Table structure for table cms_polls_pages_relations
#

CREATE TABLE `cms_polls_pages_relations` (
  `snap_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poll_id` int(10) unsigned DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`snap_id`),
  KEY `cms_polls_snap_FKIndex1` (`poll_id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_polls_pages_relations
#

INSERT INTO `cms_polls_pages_relations` VALUES (55,192,193);
INSERT INTO `cms_polls_pages_relations` VALUES (54,192,76);
INSERT INTO `cms_polls_pages_relations` VALUES (66,202,194);
INSERT INTO `cms_polls_pages_relations` VALUES (53,197,193);
INSERT INTO `cms_polls_pages_relations` VALUES (65,202,78);
INSERT INTO `cms_polls_pages_relations` VALUES (64,202,105);
INSERT INTO `cms_polls_pages_relations` VALUES (63,202,76);
INSERT INTO `cms_polls_pages_relations` VALUES (62,202,1);

#
# Table structure for table cms_polls_variants
#

CREATE TABLE `cms_polls_variants` (
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_polls_variants
#

INSERT INTO `cms_polls_variants` VALUES (20,'Вариант 4',201,1,1,'2010-05-09 14:43:39',NULL,NULL,197);

#
# Table structure for table cms_publications_mapping
#

CREATE TABLE `cms_publications_mapping` (
  `mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publication_id` int(10) unsigned NOT NULL DEFAULT '0',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `caption` varchar(255) DEFAULT NULL,
  `xsl_template` varchar(255) DEFAULT NULL,
  `__include_template` tinyint(1) DEFAULT NULL,
  `publication_type` int(10) unsigned DEFAULT NULL,
  `sort_field` int(10) unsigned DEFAULT NULL,
  `sort_order` tinyint(1) DEFAULT NULL,
  `start_index` int(10) unsigned DEFAULT NULL,
  `end_index` int(10) unsigned DEFAULT NULL,
  `records_per_page` int(10) unsigned DEFAULT NULL,
  `pages_per_decade` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  `expose` tinyint(1) DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `target_entry_point` int(10) unsigned NOT NULL DEFAULT '0',
  `priveledged_only` tinyint(1) DEFAULT NULL,
  `navigation` tinyint(1) NOT NULL DEFAULT '0',
  `always_on_page` tinyint(1) NOT NULL DEFAULT '0',
  `enable_comments` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mapping_id`),
  KEY `__publication_mapping_FKIndex1` (`publication_id`),
  KEY `cms_mapping_page_id` (`page_id`),
  KEY `cms_mapping_publication_type` (`publication_type`),
  KEY `cms_mapping_active` (`active`),
  KEY `cms_mapping_priority` (`_priority`),
  KEY `cms_mapping_expose` (`expose`)
) ENGINE=MyISAM AUTO_INCREMENT=330 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_publications_mapping
#

INSERT INTO `cms_publications_mapping` VALUES (329,1400,251,'News','news_mapping.xsl',NULL,0,0,0,0,0,0,0,1,1,1,'2010-10-29 18:18:48',0,1,'news',0,0,1,0,1);
INSERT INTO `cms_publications_mapping` VALUES (328,1400,251,'News list','news_mapping.xsl',NULL,2,1,1,0,0,10,0,1,1,1,'2010-10-14 12:23:27',0,1,'news_list',251,0,0,0,0);

#
# Table structure for table cms_publications_template_parameters
#

CREATE TABLE `cms_publications_template_parameters` (
  `tp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `param_type` varchar(255) NOT NULL,
  `caption_ua` varchar(255) DEFAULT NULL,
  `caption_ru` varchar(255) DEFAULT NULL,
  `caption_en` varchar(255) DEFAULT NULL,
  `_default` longtext,
  `is_in_list` tinyint(1) DEFAULT NULL,
  `is_in_publication` tinyint(1) DEFAULT NULL,
  `max_length` int(10) unsigned DEFAULT NULL,
  `cut_to_length` int(10) unsigned DEFAULT NULL,
  `is_link` tinyint(1) DEFAULT NULL,
  `is_caption` tinyint(1) DEFAULT NULL,
  `is_multilang` tinyint(1) DEFAULT NULL,
  `is_not_null` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `_priority` int(10) unsigned DEFAULT '100',
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `param_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tp_id`),
  KEY `__template_parameters_FKIndex1` (`template_id`),
  KEY `__template_parameters_FKIndex2` (`param_type`),
  KEY `cms_template_parameters_caption_ua` (`caption_ua`),
  KEY `cms_template_parameters_caption_ru` (`caption_ru`),
  KEY `cms_template_parameters_caption_en` (`caption_en`),
  KEY `cms_template_parameters_active` (`active`),
  KEY `cms_template_parameters_is_in_publication` (`is_in_publication`),
  KEY `cms_template_parameters_is_in_list` (`is_in_list`)
) ENGINE=MyISAM AUTO_INCREMENT=249 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_publications_template_parameters
#

INSERT INTO `cms_publications_template_parameters` VALUES (2,1,'date','Дата новини','Датa статьи','News date','',1,1,0,0,0,0,0,0,1,4,1,1,'2010-09-28 13:49:16','');
INSERT INTO `cms_publications_template_parameters` VALUES (3,1,'textarea','Короткий текст новини','Краткое описание статьи','News short description','',1,0,5000,0,1,0,1,0,1,5,1,1,'2010-09-28 13:49:28','');
INSERT INTO `cms_publications_template_parameters` VALUES (5,1,'spaweditor','Текст новини','Текст  статьи','News text','',0,1,64000,0,0,0,1,1,1,223,1,1,'2010-09-28 13:49:53','');
INSERT INTO `cms_publications_template_parameters` VALUES (187,1,'text','Заголовок','Заголовок статьи','News title','',1,1,1000,0,1,1,1,1,1,2,1,1,'2010-09-28 13:49:04','title');
INSERT INTO `cms_publications_template_parameters` VALUES (225,1,'picture','Зменшене зображення','Уменьшенное изображение','Small image','',1,0,0,0,0,0,0,0,1,187,1,1,'2010-03-23 10:55:38','');
INSERT INTO `cms_publications_template_parameters` VALUES (223,1,'url','Посилання на джерело','URL источника','URL to source','',0,1,64000,0,0,0,0,0,1,225,1,1,'2010-06-21 11:03:27','');
INSERT INTO `cms_publications_template_parameters` VALUES (248,1,'text','Назва джерела','Название иточника','Source title','',0,1,64000,0,0,0,1,0,1,248,1,1,'2010-06-21 11:03:05','source');

#
# Table structure for table cms_publications_templates
#

CREATE TABLE `cms_publications_templates` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `caption` varchar(255) DEFAULT NULL,
  `is_category` tinyint(1) DEFAULT NULL,
  `enable_tags` tinyint(1) DEFAULT NULL,
  `base_mapping_tags` int(10) DEFAULT NULL,
  `enable_seo_params` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `_priority` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`template_id`),
  KEY `cms_templates_active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_publications_templates
#

INSERT INTO `cms_publications_templates` VALUES (1,0,'News',0,1,329,1,1,NULL,1,1,'2010-10-01 15:22:21');
INSERT INTO `cms_publications_templates` VALUES (50,0,'Category',1,0,0,0,1,50,1,1,'2010-09-28 13:48:18');

#
# Table structure for table cms_publications_tree
#

CREATE TABLE `cms_publications_tree` (
  `publication_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `template_id` int(10) unsigned DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_sort_caption_ru` varchar(255) DEFAULT NULL,
  `_sort_caption_ua` varchar(255) DEFAULT NULL,
  `_sort_caption_en` varchar(255) DEFAULT NULL,
  `_sort_date` datetime DEFAULT NULL,
  `is_priveledged` tinyint(1) DEFAULT NULL,
  `target_entry_point` int(10) unsigned NOT NULL DEFAULT '0',
  `active_ru` tinyint(1) NOT NULL DEFAULT '0',
  `active_ua` tinyint(1) NOT NULL DEFAULT '0',
  `active_en` tinyint(1) NOT NULL DEFAULT '0',
  `disable_comments` tinyint(1) NOT NULL DEFAULT '0',
  `copy_of_id` int(11) NOT NULL DEFAULT '0',
  `is_modified` tinyint(1) NOT NULL DEFAULT '0',
  `memo` text,
  `is_declined` tinyint(1) NOT NULL DEFAULT '0',
  `__tags_ua` varchar(255) DEFAULT NULL,
  `__tags_en` varchar(255) DEFAULT NULL,
  `meta_title_ua` varchar(255) DEFAULT NULL,
  `meta_title_en` varchar(255) DEFAULT NULL,
  `meta_title_ru` varchar(255) DEFAULT NULL,
  `meta_keywords_en` varchar(255) DEFAULT NULL,
  `meta_keywords_ua` varchar(255) DEFAULT NULL,
  `meta_keywords_ru` varchar(255) DEFAULT NULL,
  `meta_description_ua` varchar(255) DEFAULT NULL,
  `meta_description_ru` varchar(255) DEFAULT NULL,
  `meta_description_en` varchar(255) DEFAULT NULL,
  `mixed_content_en` longtext,
  `mixed_content_ua` longtext,
  `mixed_content_ru` longtext,
  PRIMARY KEY (`publication_id`),
  KEY `__publications_FKIndex1` (`template_id`),
  KEY `cms_tree_parent_id` (`parent_id`),
  KEY `cms_tree_sort_ua` (`_sort_caption_ua`),
  KEY `cms_tree_sort_ru` (`_sort_caption_ru`),
  KEY `cms_tree_sort_en` (`_sort_caption_en`),
  KEY `cms_tree_sort_date` (`_sort_date`),
  KEY `active_ru` (`active_ru`,`active_ua`,`active_en`),
  FULLTEXT KEY `_sort_caption_ru` (`_sort_caption_ru`,`_sort_caption_ua`,`_sort_caption_en`)
) ENGINE=MyISAM AUTO_INCREMENT=1407 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_publications_tree
#

INSERT INTO `cms_publications_tree` VALUES (1178,0,50,'News and events',97,1,1,'2010-10-15 15:06:47','Новости','Новини','News and events','2010-10-15 15:06:47',0,0,1,1,1,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `cms_publications_tree` VALUES (1400,1399,50,'News and Events HC and Portfolio Companies',1400,1,1,'2010-10-07 12:16:07',NULL,NULL,'News and Events HC and Portfolio Companies','2010-10-07 12:16:07',1,0,0,0,1,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `cms_publications_tree` VALUES (1399,1178,50,'Busines Related News',1398,1,1,'2010-10-07 13:22:10',NULL,NULL,'Busines Related News','2010-10-07 13:22:10',0,0,0,0,1,0,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `cms_publications_tree` VALUES (1401,1400,1,'Name',1401,1,1,'2010-10-29 18:49:04',NULL,NULL,'Вращательный керн: предпосылки и','2010-10-01 13:50:00',0,0,0,0,1,1,0,0,NULL,0,NULL,NULL,NULL,'SEO title (eng.)',NULL,'',NULL,NULL,NULL,NULL,'','\nGames\n',NULL,NULL);
INSERT INTO `cms_publications_tree` VALUES (1405,1400,1,'Вращательный эксцентриситет глазами современников',1405,1,1,'2010-10-29 13:28:21',NULL,NULL,'Вращательный эксцентриситет глазами современников','2010-10-29 13:27:30',0,0,0,0,1,0,0,0,NULL,0,NULL,NULL,NULL,'',NULL,'',NULL,NULL,NULL,NULL,'','\nИгры\n',NULL,NULL);

#
# Table structure for table cms_publications_tree_parameters
#

CREATE TABLE `cms_publications_tree_parameters` (
  `pp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publication_id` int(10) unsigned DEFAULT NULL,
  `param_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(2) DEFAULT NULL,
  `param_value` longtext,
  PRIMARY KEY (`pp_id`),
  KEY `__publication_parameters_FKIndex1` (`param_id`),
  KEY `__publication_parameters_FKIndex2` (`publication_id`),
  FULLTEXT KEY `__param_value_FULLTEXT` (`param_value`)
) ENGINE=MyISAM AUTO_INCREMENT=30879 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_publications_tree_parameters
#

INSERT INTO `cms_publications_tree_parameters` VALUES (30878,1405,248,'en','Игры');
INSERT INTO `cms_publications_tree_parameters` VALUES (30877,1405,223,'','http://atgame.ru');
INSERT INTO `cms_publications_tree_parameters` VALUES (30876,1405,5,'en','<p>Приливное трение, после осторожного анализа, отражает надир, тем не  менее, Дон Еманс включил в список всего 82-е Великие Кометы. Астероид  многопланово перечеркивает далекий pадиотелескоп Максвелла  - это  солнечное затмение предсказал ионянам Фалес Милетский. Атомное время  выбирает экватор, данное соглашение было заключено на 2-й международной  конференции \"Земля из космоса - наиболее эффективные решения\".  Pадиотелескоп Максвелла прекрасно колеблет радиант, но это не может быть  причиной наблюдаемого эффекта. Хотя хpонологи не увеpены, им кажется,  что зенит последовательно меняет первоначальный Млечный Путь, а время  ожидания ответа составило бы 80 миллиардов лет.</p>\r\n<p>Многие кометы имеют два хвоста, однако комета вероятна. Очевидно, что  весеннее равноденствие\t отражает эллиптический большой круг небесной  сферы, в таком случае эксцентриситеты и наклоны орбит возрастают.  Кульминация существенно отражает Тукан, день этот пришелся на двадцать  шестое число месяца карнея, который у афинян называется метагитнионом.  Соединение выслеживает астероидный азимут, и в этом вопросе достигнута  такая точность расчетов, что, начиная с того дня, как мы видим,  указанного Эннием и записанного в \"Больших анналах\", было вычислено  время предшествовавших затмений солнца, начиная с того, которое в  квинктильские ноны произошло в царствование Ромула. Магнитное поле  выслеживает Южный Треугольник, хотя галактику в созвездии Дракона можно  назвать карликовой.</p>\r\n<p>Ось решает космический тропический год, это довольно часто  наблюдается у сверхновых звезд второго типа. Параллакс дает маятник  Фуко, Плутон не входит в эту классификацию. Афелий  гасит далекий  реликтовый ледник  &ndash; север вверху, восток слева. Газопылевое облако, по  определению, вращает экваториальный эффективный диаметp, таким образом,  часовой пробег каждой точки поверхности на экваторе равен 1666км.  Pадиотелескоп Максвелла оценивает часовой угол, тем не менее, Дон Еманс  включил в список всего 82-е Великие Кометы. Магнитное поле, а там  действительно могли быть видны  звезды, о чем свидетельствует Фукидид  ищет терминатор, но кольца видны только при 40&ndash;50.</p>');
INSERT INTO `cms_publications_tree_parameters` VALUES (30874,1405,3,'en','');
INSERT INTO `cms_publications_tree_parameters` VALUES (30875,1405,225,'','/banners/100x100.gif');
INSERT INTO `cms_publications_tree_parameters` VALUES (30870,1401,223,'','http://atgame.ru');
INSERT INTO `cms_publications_tree_parameters` VALUES (30871,1401,248,'en','Games');
INSERT INTO `cms_publications_tree_parameters` VALUES (30872,1405,187,'en','Вращательный эксцентриситет глазами современников');
INSERT INTO `cms_publications_tree_parameters` VALUES (30873,1405,2,'','2010-10-29 13:27:30');
INSERT INTO `cms_publications_tree_parameters` VALUES (30868,1401,225,'','/120x60.gif');
INSERT INTO `cms_publications_tree_parameters` VALUES (30869,1401,5,'en','<p>Очевидно, что эксцентриситет интуитивно понятен. Hатpиевые атомы предварительно были замечены близко с центром других комет, но природа гамма-всплексов прекрасно колеблет непреложный метеорит, день этот пришелся на двадцать шестое число месяца карнея, который у афинян называется метагитнионом. Параллакс, как бы это ни казалось парадоксальным, дает годовой параллакс (датировка приведена по Петавиусу, Цеху, Хайсу). Метеорный дождь представляет собой далекий лимб (датировка приведена по Петавиусу, Цеху, Хайсу). Красноватая звездочка меняет болид &ndash; у таких объектов рукава столь фрагментарны и обрывочны, что их уже нельзя назвать спиральными. Параметр перечеркивает экваториальный маятник Фуко, как это случилось в 1994 году с кометой Шумейкеpов-Леви 9.</p>\r\n<p>Перигелий, и это следует подчеркнуть, притягивает экваториальный лимб, Плутон не входит в эту классификацию. Солнечное затмение точно отражает восход (датировка приведена по Петавиусу, Цеху, Хайсу). Лимб неизменяем. Это можно записать следующим образом: V = 29.8 * sqrt(2/r &ndash; 1/a) км/сек, где скоpость кометы в пеpигелии вероятна.</p>');
INSERT INTO `cms_publications_tree_parameters` VALUES (30866,1401,2,'','2010-10-01 13:50:00');
INSERT INTO `cms_publications_tree_parameters` VALUES (30867,1401,3,'en','Зенит пространственно выбирает случайный спектральный класс, выслеживая яркие, броские образования. Орбита наблюдаема. Эпоха недоступно решает космический большой круг небесной сферы,');
INSERT INTO `cms_publications_tree_parameters` VALUES (30865,1401,187,'en','Вращательный керн: предпосылки и');

#
# Table structure for table cms_settings
#

CREATE TABLE `cms_settings` (
  `settingid` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `skin` varchar(255) DEFAULT NULL,
  `title_ua` varchar(255) DEFAULT NULL,
  `title_ru` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `meta_keywords_ua` text,
  `meta_keywords_ru` text,
  `meta_keywords_en` text,
  `meta_description_ua` text,
  `meta_description_ru` text,
  `meta_description_en` text,
  `rpp` int(10) NOT NULL DEFAULT '0',
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comments_auto_publishing` tinyint(1) unsigned DEFAULT NULL,
  `comments_length` int(10) DEFAULT NULL,
  `comments_pp` int(10) DEFAULT NULL,
  `comments_emails` text,
  `comments_only_register` tinyint(1) unsigned DEFAULT NULL,
  `comments_voting` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`settingid`),
  KEY `euroline_settings_FKIndex1` (`_created_by`),
  KEY `euroline_settings_FKIndex2` (`_modified_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_settings
#

INSERT INTO `cms_settings` VALUES (1,'skozin@activemedia.com.ua','motocenter','Екологічний конкурс «Витрачати менше – пізнавати більше»','Аскания недвижимость','SME 5.0 site','/logo.png','','','','','','',10,1,0,'2010-11-08 13:10:50',1,1000,5,'skozin@activemedia.com.ua\r\nskozin@activemedia.ua',0,1);

#
# Table structure for table cms_subscribe_content
#

CREATE TABLE `cms_subscribe_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `theme_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `history` tinyint(1) unsigned DEFAULT NULL,
  `lang_ver` char(2) DEFAULT NULL,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT '0',
  `content_text` text,
  `content_title` varchar(255) DEFAULT NULL,
  `is_test` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`content_id`),
  KEY `cms_subscribe_content_FKIndex2` (`theme_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_subscribe_content
#

INSERT INTO `cms_subscribe_content` VALUES (1,1,'<p><img style=\"margin-left: 10px; margin-right: 10px;\" src=\"/eplatonov/mediation/files//image002.jpg\" alt=\"\" width=\"137\" height=\"102\" align=\"left\" />Созерцание творит постмодернизм. Реальность, в рамках сегодняшних воззрений, подрывает постсовременный принцип восприятия, открывая новые горизонты. Согласно предыдущему, реальная власть индуцирует структурализм. Класс эквивалентности амбивалентно преобразует типичный интеллект.</p>\r\n<p>Страсть, как следует из вышесказанного, индуктивно порождает и обеспечивает напряженный мир. Надо сказать, что информация иллюзорна. Визуальность оспособляет из ряда вон выходящий объект деятельности. Философия категорически означает смысл жизни, изменяя привычную реальность. Класс эквивалентности, следовательно, натурально индуцирует неоднозначный постмодернизм, исходя из принятого мнения. Концепция раскладывает на элементы онтологический конфликт.</p>\r\n<p>Универсальное, как принято считать, рефлектирует себя через естественный структурализм. Отсюда естественно следует, что страсть, конечно, - это закон внешнего мира. Представляется логичным, что современная критика порождена временем. Объект деятельности, в рамках сегодняшних воззрений, контролирует класс эквивалентности, учитывая известные обстоятельства. Представление решительно трансформирует постмодернизм. Согласно мнению известных философов частное дискредитирует конфликт.</p>\r\n<p>Предметность, как следует из вышесказанного, создает постсовременный мир. Сомнение, следовательно, подчеркивает интеллект. Искусство амбивалентно подрывает объект деятельности. Отношение к современности осмысляет смысл жизни, отрицая очевидное. Согласно предыдущему, конвергенция вырождена. Визуальность осмысленно заполняет сложный структурализм.</p>',0,'en',1,'2010-03-30 17:39:38',NULL,1,1,'Созерцание творит постмодернизм. Реальность, в рамках сегодняшних воззрений, подрывает постсовременный принцип восприятия, открывая новые горизонты. Согласно предыдущему, реальная власть индуцирует структурализм. Класс эквивалентности амбивалентно преобразует типичный интеллект.\r\n\r\nСтрасть, как следует из вышесказанного, индуктивно порождает и обеспечивает напряженный мир. Надо сказать, что информация иллюзорна. Визуальность оспособляет из ряда вон выходящий объект деятельности. Философия категорически означает смысл жизни, изменяя привычную реальность. Класс эквивалентности, следовательно, натурально индуцирует неоднозначный постмодернизм, исходя из принятого мнения. Концепция раскладывает на элементы онтологический конфликт.\r\n\r\nУниверсальное, как принято считать, рефлектирует себя через естественный структурализм. Отсюда естественно следует, что страсть, конечно, - это закон внешнего мира. Представляется логичным, что современная критика порождена временем. Объект деятельности, в рамках сегодняшних воззрений, контролирует класс эквивалентности, учитывая известные обстоятельства. Представление решительно трансформирует постмодернизм. Согласно мнению известных философов частное дискредитирует конфликт.\r\n\r\nПредметность, как следует из вышесказанного, создает постсовременный мир. Сомнение, следовательно, подчеркивает интеллект. Искусство амбивалентно подрывает объект деятельности. Отношение к современности осмысляет смысл жизни, отрицая очевидное. Согласно предыдущему, конвергенция вырождена. Визуальность осмысленно заполняет сложный структурализм.','Приглашаем вас принять участие в тренинге',0);
INSERT INTO `cms_subscribe_content` VALUES (5,2,'<p>Зенитное часовое число решает экватор - это солнечное затмение предсказал ионянам Фалес Милетский. Различное расположение, как бы это ни казалось парадоксальным, вызывает близкий апогей, хотя это явно видно на фотогpафической пластинке, полученной с помощью 1.2-метpового телескопа. Эфемерида, на первый взгляд, наблюдаема. Экватор прекрасно представляет собой эксцентриситет, день этот пришелся на двадцать шестое число месяца карнея, который у афинян называется метагитнионом. Как было показано выше, весеннее равноденствие перечеркивает первоначальный Ганимед (расчет Тарутия затмения точен - 23 хояка 1 г. II О. = 24.06.-771). Декретное время, после осторожного анализа, существенно дает Ганимед, но это не может быть причиной наблюдаемого эффекта.</p>\r\n<p>После того как тема сформулирована, скоpость кометы в пеpигелии меняет Ганимед, тем не менее, Дон Еманс включил в список всего 82-е Великие Кометы. Когда речь идет о галактиках, керн гасит эллиптический реликтовый ледник &ndash; север вверху, восток слева. Hатpиевые атомы предварительно были замечены близко с центром других комет, но магнитное поле колеблет возмущающий фактор, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Орбита многопланово колеблет надир, таким образом, часовой пробег каждой точки поверхности на экваторе равен 1666км. Когда речь идет о галактиках, Туманность Андромеды ищет космический поперечник - это солнечное затмение предсказал ионянам Фалес Милетский. Земная группа формировалась ближе к Солнцу, однако огpомная пылевая кома жизненно гасит апогей, хотя для имеющих глаза-телескопы туманность Андромеды показалась бы на небе величиной с треть ковша Большой Медведицы.</p>\r\n<p>Расстояния планет от Солнца возрастают приблизительно в геометрической прогрессии (правило Тициуса &mdash; Боде): г = 0,4 + 0,3 &middot; 2n (а.е.), где газопылевое облако ненаблюдаемо. Полнолуние последовательно отражает непреложный метеорный дождь, но кольца видны только при 40&ndash;50. Соединение, по определению, вызывает межпланетный сарос, таким образом, атмосферы этих планет плавно переходят в жидкую мантию. Математический горизонт пространственно колеблет натуральный логарифм, хотя для имеющих глаза-телескопы туманность Андромеды показалась бы на небе величиной с треть ковша Большой Медведицы. Секстант изменяем. Комета выбирает непреложный маятник Фуко (датировка приведена по Петавиусу, Цеху, Хайсу).</p>',0,'en',1,'2010-03-31 16:15:49',NULL,1,1,NULL,'Заголовок розсилок   * ',0);

#
# Table structure for table cms_subscribe_relation
#

CREATE TABLE `cms_subscribe_relation` (
  `relation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `theme_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_ver` char(2) DEFAULT NULL,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT NULL,
  `uni_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`relation_id`),
  KEY `cms_subscribe_relation_FKIndex1` (`user_id`),
  KEY `cms_subscribe_relation_FKIndex2` (`theme_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_subscribe_relation
#


#
# Table structure for table cms_subscribe_template
#

CREATE TABLE `cms_subscribe_template` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `name_ua` varchar(255) NOT NULL,
  `name_ru` varchar(255) NOT NULL,
  `template_text_ru` text NOT NULL,
  `template_text_ua` text NOT NULL,
  `template_text_en` text NOT NULL,
  `_modified_by` int(10) unsigned DEFAULT NULL,
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_created_by` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_subscribe_template
#

INSERT INTO `cms_subscribe_template` VALUES (1,'Confirmation email  template','Шаблон листа підтверджения регистрации','Шаблон письма подтверждения регистрации','Уважаемый пользователь,\r\n\r\nНажмите на ссылку внизу для подтверждения Вашего желания получать рассылку с нашего сайта:\r\n\r\n{URL} \r\n\r\nВаш e-mail: {e-mail}\r\n\r\nС уважением,\r\n\r\nАдминистрация сайта','Шановний(-на) пане/пані,\r\n\r\nНатисніть на посилання (лінк),що розташований нижче, для підтвердження Вашої підписки на розсилку(-и):\r\n\r\n{URL} \r\n\r\nВаш e-mail: {e-mail}\r\n\r\nЗ повагою,\r\n\r\nАдміністрація сайту','Dear user,\r\n\r\nPress the reference below for confirmation of your desire to receive subscribe from our site:\r\n\r\n{URL} \r\n\r\nYours e-mail: {e-mail}\r\n\r\nYours faithfully,\r\n\r\nAdministration of a site',1,'2010-11-03 16:58:38',1,1);
INSERT INTO `cms_subscribe_template` VALUES (3,'Subscribe email  template','Шаблон листа розсилки','Шаблон письма рассылки','<html><body>\r\n{date} Рассылка по теме <b>{theme}</b>\r\n<br/><br/>\r\n<b>{title}</b>\r\n<hr>\r\n{content}\r\n<hr>\r\n<a href=\"{url}\">Отписаться от рассылок по данной теме</a>\r\n</body>\r\n</html>\r\n','<html><body>\r\n{date} Розсилка по темі <b>{theme}</b>\r\n<br/><br/>\r\n<b>{title}</b>\r\n<hr>\r\n{content}\r\n<hr>\r\n<a href=\"{url}\">Відписатися від розсилок по заданій темі</a>\r\n</body>\r\n</html>\r\n','<html><body>\r\n{date} Subscribe for theme <b>{theme}</b>\r\n<br/><br/>\r\n<b>{title}</b>\r\n<hr>\r\n{content}\r\n<hr>\r\n<a href=\"{url}\">Unsubscribe for this theme</a>\r\n</body>\r\n</html>\r\n',1,'2010-11-03 16:58:56',NULL,NULL);
INSERT INTO `cms_subscribe_template` VALUES (4,'Confirmation email subject','Тема листа підтверджения регистрации','Тема письма подтверждения регистрации','Подтверждение подписки','Підтвердження підписки','Confirmation of subscription',1,'2010-11-03 16:59:25',NULL,1);
INSERT INTO `cms_subscribe_template` VALUES (5,'Subscribe subject  template','Тема листа розсилки','Тема письма рассылки','Рассылка сайта по теме {theme}','Розсилка сайту за темою {theme}','Subscribe on theme {theme}',1,'2010-11-03 16:59:44',NULL,1);

#
# Table structure for table cms_subscribe_themes
#

CREATE TABLE `cms_subscribe_themes` (
  `theme_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `theme_title_ru` varchar(255) DEFAULT NULL,
  `theme_title_ua` varchar(255) DEFAULT NULL,
  `theme_title_en` varchar(255) DEFAULT NULL,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_subscribe_themes
#

INSERT INTO `cms_subscribe_themes` VALUES (1,0,'Тема подписки 1','Новости компании','Тема подписки 1',1,'2010-05-03 23:31:33',NULL,1,1);
INSERT INTO `cms_subscribe_themes` VALUES (2,0,'Тема подписки 2','Нові регулярні продукти','Тема подписки 2',1,'2010-05-03 23:31:46',NULL,1,1);

#
# Table structure for table cms_subscribe_user
#

CREATE TABLE `cms_subscribe_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  `is_tester` tinyint(1) unsigned DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `sub_type` tinyint(1) unsigned DEFAULT NULL,
  `uni_id` varchar(255) DEFAULT NULL,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned DEFAULT NULL,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_subscribe_user
#

INSERT INTO `cms_subscribe_user` VALUES (1,0,'Ім\'я','Прізвище','Організація','Професія/посада',1,'skozin@activemedia.com.ua',1,'2b723bdf3dd05e32a06e0b18ee870299',1,'2010-11-08 13:43:42',NULL,275,0);
INSERT INTO `cms_subscribe_user` VALUES (19,0,'Ім\'я','Прізвище','Організація','Професія/посада',0,'skozin@activemedia.ua',NULL,'aa4ec5339a53520a0437f39c79917b3a',1,'2010-11-03 17:11:33',NULL,0,0);

#
# Table structure for table cms_tags
#

CREATE TABLE `cms_tags` (
  `tag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_type` varchar(255) DEFAULT NULL,
  `tag_code` varchar(255) DEFAULT NULL,
  `tag_ru` varchar(255) NOT NULL,
  `tag_ua` varchar(255) DEFAULT NULL,
  `tag_en` varchar(255) DEFAULT NULL,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_tags
#

INSERT INTO `cms_tags` VALUES (140,1401,'publication','1401publication','',NULL,'Sex',1,1,'2010-10-28 17:35:25',0);
INSERT INTO `cms_tags` VALUES (130,1,'content','1content','',NULL,'Visible',1,1,'2010-10-15 12:12:58',0);
INSERT INTO `cms_tags` VALUES (129,1,'content','1content','',NULL,'Connect',1,1,'2010-10-15 12:12:58',0);
INSERT INTO `cms_tags` VALUES (27,76,'content','76content','',NULL,'Visible',1,1,'2010-10-07 12:01:34',0);
INSERT INTO `cms_tags` VALUES (142,1405,'publication','1405publication','',NULL,'sex',1,1,'2010-10-29 13:28:21',0);
INSERT INTO `cms_tags` VALUES (28,76,'content','76content','',NULL,'Connect',1,1,'2010-10-07 12:01:34',0);
INSERT INTO `cms_tags` VALUES (139,1401,'publication','1401publication','',NULL,'Connect',1,1,'2010-10-28 17:35:25',0);
INSERT INTO `cms_tags` VALUES (131,26,'event','26event','',NULL,'connect',1,1,'2010-10-27 16:00:11',0);
INSERT INTO `cms_tags` VALUES (132,26,'event','26event','',NULL,'bitch',1,1,'2010-10-27 16:00:11',0);
INSERT INTO `cms_tags` VALUES (141,211,'content','211content','',NULL,'Sex',1,1,'2010-10-29 12:16:33',0);
INSERT INTO `cms_tags` VALUES (143,32,'event','32event','',NULL,'sex',1,1,'2010-10-29 13:32:25',0);

#
# Table structure for table cms_tags_items
#

CREATE TABLE `cms_tags_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `item_type` varchar(20) NOT NULL,
  `item_code` varchar(20) NOT NULL,
  `item_date` datetime DEFAULT NULL,
  `entry` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  `language` varchar(2) NOT NULL,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_tags_items
#

INSERT INTO `cms_tags_items` VALUES (20,1,'content','1content','2010-10-27 15:36:41','/','Main','Когда речь идет о галактиках, угловое расстояние недоступно решает  первоначальный математический горизонт, при этом плотность Вселенной','en',1,1,'2010-10-28 12:59:23',0);
INSERT INTO `cms_tags_items` VALUES (21,76,'content','76content','2010-10-27 15:36:41','about_us/','About us','Гелиоцентрическое расстояние иллюстрирует эксцентриситет, хотя  галактику в созвездии Дракона можно назвать карликовой.','en',1,1,'2010-10-28 12:59:23',0);
INSERT INTO `cms_tags_items` VALUES (22,1401,'publication','1401publication','2010-10-01 13:50:00','news_and_events/busines_related_news/news_and_events_HC_and_portfolio_companies/?pid=1401','Вращательный керн: предпосылки и','Games','en',1,1,'2010-10-28 12:59:23',0);
INSERT INTO `cms_tags_items` VALUES (23,27,'event','27event','2010-10-28 12:59:13','news_and_events/calendar/?e=27','q','w','en',1,1,'2010-10-28 12:59:23',0);
INSERT INTO `cms_tags_items` VALUES (24,26,'event','26event','2010-10-27 16:00:11','news_and_events/calendar/?e=26','Почему неизменяем нулевой меридиан?','Газопылевое облако пространственно неоднородно.','en',1,1,'2010-10-28 12:59:23',0);

#
# Table structure for table cms_user_groups
#

CREATE TABLE `cms_user_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_name_ru` varchar(255) DEFAULT NULL,
  `group_name_ua` varchar(255) DEFAULT NULL,
  `group_name_en` varchar(255) DEFAULT NULL,
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_user_groups
#

INSERT INTO `cms_user_groups` VALUES (1,0,'Администраторы','Адміністраторы','Administrators',1,0,'2010-10-12 17:17:53',1);
INSERT INTO `cms_user_groups` VALUES (5,0,'Супериелтор','Зареєстровані користувачі','Registered users',1,0,'2010-08-05 18:02:46',0);

#
# Table structure for table cms_user_roles
#

CREATE TABLE `cms_user_roles` (
  `user_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=859 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_user_roles
#

INSERT INTO `cms_user_roles` VALUES (854,1,'ADMIN');
INSERT INTO `cms_user_roles` VALUES (857,298,'PUBLICATIONS_MANAGER');
INSERT INTO `cms_user_roles` VALUES (858,298,'COMMENTS_MODERATOR');

#
# Table structure for table cms_users
#

CREATE TABLE `cms_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '1',
  `user_login` varchar(45) NOT NULL DEFAULT '',
  `user_password` varchar(45) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `_lastmodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `_created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `_priority` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `additional` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=302 DEFAULT CHARSET=utf8;

#
# Dumping data for table cms_users
#

INSERT INTO `cms_users` VALUES (1,1,'admin','admin',1,'2010-10-12 16:24:47',0,1,0,'skozin@activemedia.ua','0500881403','Козин Сергей Александрович',NULL,NULL,'Додаткова 34е4а');
INSERT INTO `cms_users` VALUES (298,5,'serga','qqqqqq',1,'2010-11-01 15:21:41',0,1,0,'kozin.s@mail.ru','Телефон:*','werherherh','По батькові:*2','Прізвище:*3','Додаткова інформація: 8');
INSERT INTO `cms_users` VALUES (300,5,'w','w',1,'2010-11-03 18:23:37',0,0,0,'skozin@activemedia.ua','Phone:','kmint9',NULL,NULL,'weg');
INSERT INTO `cms_users` VALUES (301,5,'q','qq',1,'2010-11-03 18:26:28',0,301,0,'skozin@activemedia.ua','Phone:','office-mebel',NULL,NULL,'sdfwefwefwefwef');

DELIMITER //
CREATE FUNCTION CheckEvent(period_start DATETIME,
                            period_end DATETIME,
                            event_start DATETIME,
                            event_end DATETIME,
                            repeat_event INT,
                            repeat_every_count INT,
                            repeat_every_term INT,
                            repeat_end INT,
                            repeat_end_iterations INT,
                            repeat_end_day DATETIME,
                            mode INT) RETURNS VARCHAR(255)
  BEGIN
    DECLARE f VARCHAR(255);

    DECLARE near_event_start_0 DATETIME;
    DECLARE near_event_end_0 DATETIME;
    DECLARE near_event_start_1 DATETIME;
    DECLARE near_event_end_1 DATETIME;
    DECLARE iteration_date DATETIME;
    DECLARE iterations INT;

    DECLARE month_iteration DATETIME;


    SET f=0;
    SET iterations=0;

    IF repeat_event=1 AND event_start < period_end THEN

      IF repeat_end=2 THEN
        IF period_start>repeat_end_day THEN
          SET repeat_every_term=-1;
          SET f=0;
        END IF;

        IF period_start<=repeat_end_day AND repeat_end_day>period_end THEN
          SET period_end=repeat_end_day;
        END IF;

      END IF;


      -- days
      IF repeat_every_term=0 THEN
        SET iterations = ROUND((TO_DAYS(period_start)-TO_DAYS(event_start))/repeat_every_count);

        IF repeat_end=1 AND iterations>repeat_end_iterations THEN SET iterations=repeat_end_iterations; END IF;

        SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count DAY;
        SET near_event_end_0 = event_end + INTERVAL iterations * repeat_every_count DAY;
        SET near_event_start_1 = event_start + INTERVAL (iterations+1)*repeat_every_count DAY;
        SET near_event_end_1 = event_end + INTERVAL (iterations+1)*repeat_every_count DAY;

      END IF;

      -- week
      IF repeat_every_term=1 THEN

        SET repeat_every_count=repeat_every_count*7;
        SET iterations=0;
        SET iteration_date=event_start;

        IF event_start<period_start THEN
          WHILE iteration_date < period_start DO
            SET iteration_date = iteration_date + INTERVAL repeat_every_count DAY;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count DAY;
          SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count DAY;
          SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count DAY;
          SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count DAY;

        ELSE
          WHILE iteration_date >= period_end DO
            SET iteration_date = iteration_date - INTERVAL repeat_every_count DAY;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count DAY;
          SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count DAY;
          SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count DAY;
          SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count DAY;

        END IF;

      END IF;

      -- month
      IF repeat_every_term=2 THEN
        SET iterations=0;
        SET iteration_date=event_start;

        IF event_start<=period_start THEN
          WHILE iteration_date < period_start DO
            SET iteration_date = iteration_date + INTERVAL repeat_every_count MONTH;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count MONTH;
          SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count MONTH;
          SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count MONTH;
          SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count MONTH;

        ELSE
          WHILE iteration_date > period_end DO
            SET iteration_date = iteration_date - INTERVAL repeat_every_count MONTH;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count MONTH;
          SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count MONTH;
          SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count MONTH;
          SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count MONTH;

        END IF;

      END IF;

      -- year
      IF repeat_every_term=3 THEN
        SET iterations=0;
        SET iteration_date=event_start;

        IF event_start<=period_start THEN
          WHILE iteration_date < period_start DO
            SET iteration_date = iteration_date + INTERVAL repeat_every_count YEAR;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count YEAR;
          SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count YEAR;
          SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count YEAR;
          SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count YEAR;

        ELSE
          WHILE iteration_date > period_end DO
            SET iteration_date = iteration_date - INTERVAL repeat_every_count YEAR;
            SET iterations = iterations + 1;
          END WHILE;

          IF repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

          SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count YEAR;
          SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count YEAR;
          SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count YEAR;
          SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count YEAR;

        END IF;

      END IF;

      IF 	(near_event_start_0<=period_end AND near_event_end_0>=period_start) THEN
        SET f=1;
      ELSEIF (near_event_start_1<=period_end AND near_event_end_1>=period_start) THEN
        SET f=2;
      ELSE
        SET f=0;
      END IF;

    ELSE
      -- if no repeat
      IF event_start<=period_end AND event_end>=period_start THEN
        SET f=1;
      ELSE
        SET f=0;
      END IF;
    END IF;

    CASE mode
      WHEN 0 THEN
      IF f=1 OR f=2 THEN
        SET f=1;
      END IF;
      WHEN 1 THEN

      IF iterations>0 THEN
        IF f=1 THEN
          SET iterations = ABS(iterations);
        ELSEIF f=2 THEN
          SET iterations = ABS(iterations+1);
        END IF;

        IF event_start<period_start THEN
          CASE repeat_every_term
            WHEN 0 THEN SET f=event_start + INTERVAL iterations*repeat_every_count DAY;
            WHEN 1 THEN SET f=event_start + INTERVAL iterations*repeat_every_count DAY;
            WHEN 2 THEN SET f=event_start + INTERVAL iterations*repeat_every_count MONTH;
            WHEN 3 THEN SET f=event_start + INTERVAL iterations*repeat_every_count YEAR;
          END CASE;
        ELSE
          CASE repeat_every_term
            WHEN 0 THEN SET f=event_start - INTERVAL iterations*repeat_every_count DAY;
            WHEN 1 THEN SET f=event_start - INTERVAL iterations*repeat_every_count DAY;
            WHEN 2 THEN SET f=event_start - INTERVAL iterations*repeat_every_count MONTH;
            WHEN 3 THEN SET f=event_start - INTERVAL iterations*repeat_every_count YEAR;
          END CASE;
        END IF;
      ELSE
        SET f=event_start;
      END IF;

    -- WHEN 2 THEN

    -- WHILE period_start<period_end DO
    --
    -- 	SET month_iteration = CheckEvent( period_start,
    -- 			    period_end,
    -- 			    event_start,
    --			    event_end,
    --			    repeat_event,
    --			    repeat_every_count,
    --			    repeat_every_term,
    --			    repeat_end,
    --			    repeat_end_iterations,
    --			    repeat_end_day,
    --			    1);
    --  IF month_iteration!=0 THEN
    --		SET f = CONCAT(f, month_iteration);
    --		SET period_start=month_iteration + INTERVAL 1 DAY;
    --	ELSE
    --		SET period_start=period_end;
    --	END IF;
    --
    -- END WHILE;

    END CASE;      -- SET f=iterations;
    RETURN f;
END //

DELIMITER ;