DROP TABLE IF EXISTS s_urls;
CREATE TABLE s_urls (
   id int(10) unsigned NOT NULL auto_increment,
   title char(255) NOT NULL,
   url char(255) NOT NULL,
   descr char(255) NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   status smallint(6) DEFAULT '200' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE url (url),
   KEY status (status)
);


DROP TABLE IF EXISTS s_words;
CREATE TABLE s_words (
   id int(10) unsigned NOT NULL auto_increment,
   word char(255) NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   PRIMARY KEY (id),
   UNIQUE word (word)
);

DROP TABLE IF EXISTS s_words_urls;
CREATE TABLE s_words_urls (
   id bigint(20) unsigned NOT NULL auto_increment,
   url_id int(10) unsigned DEFAULT '0' NOT NULL,
   word_id int(10) unsigned DEFAULT '0' NOT NULL,
   weight int(10) unsigned DEFAULT '0' NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   PRIMARY KEY (id),
   UNIQUE url_id (url_id, word_id)
);

DROP TABLE IF EXISTS t_urls;
CREATE TABLE t_urls (
   id int(10) unsigned NOT NULL auto_increment,
   title char(255) NOT NULL,
   url char(255) NOT NULL,
   descr char(255) NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   status smallint(6) DEFAULT '200' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE url (url),
   KEY status (status)
);


DROP TABLE IF EXISTS t_words;
CREATE TABLE t_words (
   id int(10) unsigned NOT NULL auto_increment,
   word char(255) NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   PRIMARY KEY (id),
   UNIQUE word (word)
);

DROP TABLE IF EXISTS t_words_urls;
CREATE TABLE t_words_urls (
   id bigint(20) unsigned NOT NULL auto_increment,
   url_id int(10) unsigned DEFAULT '0' NOT NULL,
   word_id int(10) unsigned DEFAULT '0' NOT NULL,
   weight int(10) unsigned DEFAULT '0' NOT NULL,
   updated timestamp(14),
   created timestamp(14),
   PRIMARY KEY (id),
   UNIQUE url_id (url_id, word_id)
);


DROP TABLE IF EXISTS todo_urls;
CREATE TABLE todo_urls (
   id int(10) unsigned NOT NULL auto_increment,
   url char(255) NOT NULL,
   processed tinyint(1) NOT NULL DEFAULT 0,

   PRIMARY KEY (id),
   UNIQUE url (url)
);
