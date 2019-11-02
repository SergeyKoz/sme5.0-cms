# This is script for MySQL to 
# create database structure for UdmSearch 3.2.x
# use: "mysql database <create.txt"
#


CREATE TABLE url (
  rec_id	  int(11) NOT NULL auto_increment,
  status	  smallint(6) DEFAULT '0' NOT NULL,
  docsize	  int(11) DEFAULT '0' NOT NULL,
  next_index_time INT NOT NULL,
  last_mod_time	  INT DEFAULT '0' NOT NULL,
  referrer	  int(11) DEFAULT '0' NOT NULL,
  hops		  smallint(6) DEFAULT '0' NOT NULL,
  crc32		  int(11)	DEFAULT '-1' NOT NULL,
  seed		  smallint(6) DEFAULT '0' NOT NULL,
  bad_since_time  INT NOT NULL,
  site_id	  int(11),
  server_id	  int(11),
  shows           int(11) DEFAULT '0' NOT NULL,
  pop_rank	  float DEFAULT 0 NOT NULL,
  url		  BLOB DEFAULT '' NOT NULL,
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

#CREATE TABLE bdict00 (
#  word VARCHAR(255) NOT NULL,
#  secno TINYINT UNSIGNED NOT NULL,
#  intag LONGBLOB NOT NULL,
#  KEY(word)
#) MAX_ROWS=300000000 AVG_ROW_LENGTH=512;

# CREATE TABLE bdictsw (n TINYINT UNSIGNED NOT NULL);

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
	rec_id		int null primary key,
	enabled		int		not null	default 0,
	url		BLOB		not null	default '',
	tag		TEXT		not null	default '',
	category	int		not null	default 0,
	command		char(1)		not null	default 'S',
	ordre		int		not null	default 0,
	parent		int		not null	default 0,
	weight		float		not null	default 1,
	pop_weight	float		not null	default 0,
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
       ot	   int(11) not null,
       k	   int(11) not null,
       weight	   float   not null	default 0,
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

CREATE TABLE dict00 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict01 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict02 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict03 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict04 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict05 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict06 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict07 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict08 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict09 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict0F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict10 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict11 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict12 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict13 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict14 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict15 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict16 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict17 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict18 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict19 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict1F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict20 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict21 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict22 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict23 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict24 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict25 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict26 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict27 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict28 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict29 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict2F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict30 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict31 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict32 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict33 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict34 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict35 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict36 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict37 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict38 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict39 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict3F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict40 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict41 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict42 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict43 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict44 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict45 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict46 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict47 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict48 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict49 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict4F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict50 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict51 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict52 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict53 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict54 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict55 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict56 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict57 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict58 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict59 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict5F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict60 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict61 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict62 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict63 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict64 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict65 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict66 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict67 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict68 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict69 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict6F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict70 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict71 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict72 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict73 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict74 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict75 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict76 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict77 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict78 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict79 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict7F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict80 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict81 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict82 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict83 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict84 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict85 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict86 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict87 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict88 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict89 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict8F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dict90 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict91 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict92 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict93 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict94 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict95 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict96 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict97 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict98 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict99 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9A (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9B (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9C (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9D (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9E (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dict9F (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictA0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictA9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAD (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictAF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictB0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictB9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBD (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictBF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictC0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictC9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCD (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictCF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictD0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictD9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDD (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictDF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictE0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictE9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictEA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictEB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictEC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictED (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictEE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictEF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));

CREATE TABLE dictF0 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF1 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF2 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF3 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF4 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF5 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF6 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF7 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF8 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictF9 (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFA (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFB (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFC (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFD (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFE (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
CREATE TABLE dictFF (url_id int(11) DEFAULT '0' NOT NULL, secno tinyint unsigned DEFAULT '0' NOT NULL, word varchar(255) DEFAULT '' NOT NULL, intag blob NOT NULL, KEY url_id (url_id), KEY word_url (word));
