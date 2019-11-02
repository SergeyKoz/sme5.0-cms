# This is script for MySQL to 
# create database structure for UdmSearch 3.2.x
# use: "mysql database <create.txt"
#


CREATE TABLE url (
  rec_id      int(11) NOT NULL auto_increment,
  status      smallint(6) DEFAULT '0' NOT NULL,
  docsize     int(11) DEFAULT '0' NOT NULL,
  next_index_time INT NOT NULL,
  last_mod_time   INT DEFAULT '0' NOT NULL,
  referrer    int(11) DEFAULT '0' NOT NULL,
  hops        smallint(6) DEFAULT '0' NOT NULL,
  crc32       int(11)   DEFAULT '-1' NOT NULL,
  seed        smallint(6) DEFAULT '0' NOT NULL,
  bad_since_time  INT NOT NULL,
  site_id     int(11),
  server_id   int(11),
  shows           int(11) DEFAULT '0' NOT NULL,
  pop_rank    float DEFAULT 0 NOT NULL,
  url         BLOB DEFAULT '' NOT NULL,
  PRIMARY KEY (rec_id),
  UNIQUE url (url(255)),
  KEY key_crc (crc32),
  KEY key_seed (seed),
  KEY key_referrer (referrer),
  KEY key_bad_since_time (bad_since_time),
  KEY key_next_index_time (next_index_time),
  KEY key_site_id (site_id),
  KEY key_status (status),
  KEY key_hops (hops)
);


CREATE TABLE urlinfo (
  url_id INT NOT NULL,
  sname  VARCHAR(32)  NOT NULL,
  sval   TEXT         NOT NULL,
  KEY    urlinfo_id  (url_id)
);


CREATE TABLE dict (
  url_id int(11) DEFAULT '0' NOT NULL,
  word varchar(32) DEFAULT '' NOT NULL,
  intag int(11) DEFAULT '0' NOT NULL,
  KEY url_id (url_id),
  KEY word_url (word)
);


CREATE TABLE bdict (
  word VARCHAR(255) NOT NULL,
  secno TINYINT UNSIGNED NOT NULL,
  intag LONGBLOB NOT NULL,
  KEY(word)
) MAX_ROWS=300000000 AVG_ROW_LENGTH=512;


CREATE TABLE categories (
  rec_id int(11) NOT NULL auto_increment,
  path char(10) DEFAULT '' NOT NULL,
  link char(10) DEFAULT '' NOT NULL,
  name char(64) DEFAULT '' NOT NULL,
  PRIMARY KEY (rec_id)
);


CREATE TABLE qtrack (
  rec_id  int(11) NOT NULL auto_increment,
  ip      varchar(16) NOT NULL,
  qwords  TEXT DEFAULT '' NOT NULL,
  qtime   int(11) DEFAULT '0' NOT NULL,
  found   int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (rec_id),
  KEY qtrack_ipt (ip, qtime)
);


CREATE TABLE qinfo (
       q_id  int(11),
       name  varchar(128),
       value varchar(255),
       KEY qinfo_id (q_id),
       KEY qinfo_nv (name, value)
);


CREATE TABLE crossdict (
  url_id int(11) DEFAULT '0' NOT NULL,
  ref_id int(11) DEFAULT '0' NOT NULL,
  word  varchar (32) DEFAULT '0' NOT NULL,
  intag  int(11) DEFAULT '0' NOT NULL,
  KEY url_id (url_id),
  KEY ref_id (ref_id),
  KEY word (word)
);


create table server (
    rec_id      int null primary key,
    enabled     int     not null    default 0,
    url     BLOB        not null    default '',
    tag     TEXT        not null    default '',
    category    int     not null    default 0,
    command     char(1)     not null    default 'S',
    ordre       int     not null    default 0,
    parent      int     not null    default 0,
    weight      float       not null    default 1,
    pop_weight  float       not null    default 0,
    KEY srv_ordre (ordre),
    KEY srv_parent (parent),
    KEY srv_command (command),
    UNIQUE srv_url(url(255))
);


CREATE TABLE srvinfo (
       srv_id int  NOT NULL,
       sname  text NOT NULL,
       sval   text NOT NULL,
       KEY srvinfo_id (srv_id)
);


create table links (
       ot      int(11) not null,
       k       int(11) not null,
       weight      float   not null default 0,
       KEY links_ot (ot),
       KEY links_k (k),
       UNIQUE links_links (ot, k)
);


CREATE TABLE wrdstat (
  word varchar(64) NOT NULL,
  snd varchar(16) NOT NULL,
  cnt int(11) NOT NULL,
  KEY word (word),
  KEY snd (snd)
);
