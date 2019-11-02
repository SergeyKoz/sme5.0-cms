CREATE FUNCTION plpgsql_call_handler () RETURNS LANGUAGE_HANDLER AS '$libdir/plpgsql' LANGUAGE C;
CREATE TRUSTED LANGUAGE plpgsql HANDLER plpgsql_call_handler;

CREATE TABLE "url" (
	"rec_id"          serial primary key,
	"status"          int4 NOT NULL DEFAULT 0,
	"docsize"         int4 NOT NULL DEFAULT 0,
	"next_index_time" int4 NOT NULL,
	"last_mod_time"   int4 NOT NULL DEFAULT 0,
	"referrer"        int4 NOT NULL DEFAULT 0,
	"hops"            int4 NOT NULL DEFAULT 0,
	"crc32"           int4 NOT NULL DEFAULT -1,
	"seed"            int NOT NULL DEFAULT 0,
	"bad_since_time"  int4,
	"site_id"	  int4,
	"server_id"	  int4,
	"shows"           int4 NOT NULL DEFAULT 0,
	"pop_rank"	  float NOT NULL DEFAULT 0,
	"url"             text NOT NULL
);

CREATE TABLE "urlinfo" (
       url_id int4 NOT NULL,
       sname  text NOT NULL,
       sval   text NOT NULL
);

CREATE INDEX urlinfo_id ON urlinfo (url_id);

CREATE TABLE "dict" (
	"url_id" int4 NOT NULL,
	"word"   text NOT NULL,
	"intag"  int4 NOT NULL
);

CREATE INDEX "dict_word" ON "dict" ( "word"   );
CREATE INDEX "dict_url"  ON "dict" ( "url_id" );
CREATE INDEX "dict_word_url_id" ON "dict" ( "word", "url_id" );

CREATE TABLE "bdict" (
	word varchar(255) NOT NULL,
	secno int2 NOT NULL,
	intag text NOT NULL
);

CREATE INDEX "bdict_word" ON "bdict" ("word");

CREATE UNIQUE INDEX "url_url" ON "url" ( "url" );
CREATE INDEX "url_crc" ON "url" ( "crc32" );
CREATE INDEX "url_seed" ON "url" ( "seed" );
CREATE INDEX "url_referrer" ON "url" ( "referrer" );
CREATE INDEX "url_next_index_time" ON "url" ( "next_index_time" );
CREATE INDEX "url_status" ON "url" ( "status" );
CREATE INDEX "url_bad_since_time" ON "url" ( "bad_since_time" );
CREATE INDEX "url_hops" ON "url" ( "hops" );
CREATE INDEX "url_siteid" ON "url" ( "site_id" );


CREATE TABLE "server" (
        "rec_id"		int4		not null,
        "enabled"               int             not null        default 0,
        "url"                   text            not null        default '',
        "tag"                   text            not null        default '',
        "category"              int4            not null        default 0,
	"command"		char(1)		not null	default 'S',
	"ordre"			int		not null	default 0,
	"parent"		int4		not null	default 0,
	"weight"		float		not null	default 1,
	"pop_weight"		float		not null	default 0
);

ALTER TABLE ONLY server ADD CONSTRAINT server_pkey PRIMARY KEY (rec_id); 
CREATE INDEX srv_ordre ON server (ordre);
CREATE INDEX srv_parent ON server (parent);
CREATE INDEX srv_command ON server ("command");


CREATE TABLE "srvinfo" (
       srv_id int4 NOT NULL,
       sname  text NOT NULL,
       sval   text NOT NULL
);

CREATE INDEX srvinfo_id ON srvinfo (srv_id);


CREATE FUNCTION clean_srvinfo() RETURNS trigger 
AS 'begin DELETE FROM srvinfo WHERE srv_id=old.rec_id; UPDATE url SET next_index_time=0 WHERE server_id=old.rec_id OR site_id=old.rec_id return NULL; end;'
LANGUAGE plpgsql;


CREATE TRIGGER srvdel AFTER DELETE ON server FOR EACH ROW EXECUTE PROCEDURE clean_srvinfo();


CREATE TABLE "links" (
	"ot"	 int4 not null,
	"k"	 int4 not null,
	"weight" float not null default 0
);

CREATE UNIQUE INDEX links_links ON links (ot, k);
CREATE INDEX links_ot ON links (ot);
CREATE INDEX links_k ON links (k);


CREATE TABLE "categories" (
	"rec_id" serial primary key,
	"path" varchar(10) DEFAULT '' NOT NULL,
	"link" varchar(10) DEFAULT '' NOT NULL,
	"name" varchar(64) DEFAULT '' NOT NULL
);


CREATE TABLE "qtrack" (
        "rec_id" serial4 primary key,
	"ip"     text NOT NULL,
	"qwords" text NOT NULL,
	"qtime"  int4 NOT NULL,
	"found"  int4 NOT NULL
);
CREATE INDEX qtrack_ipt ON qtrack(ip,qtime);

CREATE TABLE "qinfo" (
       "q_id"  int4,
       "name"  text,
       "value" text
);
CREATE INDEX qinfo_id ON qinfo (q_id);
CREATE INDEX qinfo_nv ON qinfo (name, value);

CREATE TABLE crossdict (
  url_id int4 DEFAULT '0' NOT NULL,
  ref_id int4 DEFAULT '0' NOT NULL,
  intag  int4 DEFAULT '0' NOT NULL,
  word   varchar(32) DEFAULT '0' NOT NULL
);

CREATE INDEX crossdict_url_id ON crossdict (url_id);
CREATE INDEX crossdict_ref_id ON crossdict (ref_id);
CREATE INDEX crossdict_word ON crossdict (word);
CREATE INDEX crossdict_word_url_id ON crossdict (word, url_id);

CREATE TABLE wrdstat (
  word varchar(64) NOT NULL,
  snd varchar(16) NOT NULL,
  cnt int NOT NULL
);
CREATE INDEX wrdstat_word ON wrdstat (word);
CREATE INDEX wrdstat_snd  ON wrdstat (snd);

CREATE TABLE dict00 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict01 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict02 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict03 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict04 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict05 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict06 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict07 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict08 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict09 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict0F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict10 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict11 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict12 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict13 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict14 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict15 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict16 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict17 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict18 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict19 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict1F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict20 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict21 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict22 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict23 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict24 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict25 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict26 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict27 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict28 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict29 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict2F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict30 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict31 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict32 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict33 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict34 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict35 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict36 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict37 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict38 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict39 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict3F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict40 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict41 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict42 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict43 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict44 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict45 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict46 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict47 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict48 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict49 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict4F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict50 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict51 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict52 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict53 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict54 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict55 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict56 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict57 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict58 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict59 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict5F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict60 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict61 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict62 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict63 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict64 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict65 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict66 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict67 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict68 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict69 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict6F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict70 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict71 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict72 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict73 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict74 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict75 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict76 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict77 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict78 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict79 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict7F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict80 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict81 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict82 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict83 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict84 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict85 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict86 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict87 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict88 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict89 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict8F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dict90 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict91 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict92 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict93 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict94 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict95 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict96 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict97 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict98 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict99 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9A (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9B (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9C (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9D (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9E (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dict9F (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictA0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictA9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAD (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictAF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictB0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictB9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBD (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictBF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictC0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictC9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCD (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictCF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictD0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictD9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDD (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictDF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictE0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictE9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictEA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictEB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictEC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictED (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictEE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictEF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE TABLE dictF0 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF1 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF2 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF3 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF4 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF5 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF6 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF7 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF8 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictF9 (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFA (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFB (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFC (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFD (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFE (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);
CREATE TABLE dictFF (url_id int4 NOT NULL, secno int2 NOT NULL, word varchar(255) NOT NULL, intag text NOT NULL);

CREATE INDEX url_id00 ON dict00 (url_id);
CREATE INDEX word00 ON dict00 (word);

CREATE INDEX url_id01 ON dict01 (url_id);
CREATE INDEX word01 ON dict01 (word);

CREATE INDEX url_id02 ON dict02 (url_id);
CREATE INDEX word02 ON dict02 (word);

CREATE INDEX url_id03 ON dict03 (url_id);
CREATE INDEX word03 ON dict03 (word);

CREATE INDEX url_id04 ON dict04 (url_id);
CREATE INDEX word04 ON dict04 (word);

CREATE INDEX url_id05 ON dict05 (url_id);
CREATE INDEX word05 ON dict05 (word);

CREATE INDEX url_id06 ON dict06 (url_id);
CREATE INDEX word06 ON dict06 (word);

CREATE INDEX url_id07 ON dict07 (url_id);
CREATE INDEX word07 ON dict07 (word);

CREATE INDEX url_id08 ON dict08 (url_id);
CREATE INDEX word08 ON dict08 (word);

CREATE INDEX url_id09 ON dict09 (url_id);
CREATE INDEX word09 ON dict09 (word);

CREATE INDEX url_id0A ON dict0A (url_id);
CREATE INDEX word0A ON dict0A (word);

CREATE INDEX url_id0B ON dict0B (url_id);
CREATE INDEX word0B ON dict0B (word);

CREATE INDEX url_id0C ON dict0C (url_id);
CREATE INDEX word0C ON dict0C (word);

CREATE INDEX url_id0D ON dict0D (url_id);
CREATE INDEX word0D ON dict0D (word);

CREATE INDEX url_id0E ON dict0E (url_id);
CREATE INDEX word0E ON dict0E (word);

CREATE INDEX url_id0F ON dict0F (url_id);
CREATE INDEX word0F ON dict0F (word);

CREATE INDEX url_id10 ON dict10 (url_id);
CREATE INDEX word10 ON dict10 (word);

CREATE INDEX url_id11 ON dict11 (url_id);
CREATE INDEX word11 ON dict11 (word);

CREATE INDEX url_id12 ON dict12 (url_id);
CREATE INDEX word12 ON dict12 (word);

CREATE INDEX url_id13 ON dict13 (url_id);
CREATE INDEX word13 ON dict13 (word);

CREATE INDEX url_id14 ON dict14 (url_id);
CREATE INDEX word14 ON dict14 (word);

CREATE INDEX url_id15 ON dict15 (url_id);
CREATE INDEX word15 ON dict15 (word);

CREATE INDEX url_id16 ON dict16 (url_id);
CREATE INDEX word16 ON dict16 (word);

CREATE INDEX url_id17 ON dict17 (url_id);
CREATE INDEX word17 ON dict17 (word);

CREATE INDEX url_id18 ON dict18 (url_id);
CREATE INDEX word18 ON dict18 (word);

CREATE INDEX url_id19 ON dict19 (url_id);
CREATE INDEX word19 ON dict19 (word);

CREATE INDEX url_id1A ON dict1A (url_id);
CREATE INDEX word1A ON dict1A (word);

CREATE INDEX url_id1B ON dict1B (url_id);
CREATE INDEX word1B ON dict1B (word);

CREATE INDEX url_id1C ON dict1C (url_id);
CREATE INDEX word1C ON dict1C (word);

CREATE INDEX url_id1D ON dict1D (url_id);
CREATE INDEX word1D ON dict1D (word);

CREATE INDEX url_id1E ON dict1E (url_id);
CREATE INDEX word1E ON dict1E (word);

CREATE INDEX url_id1F ON dict1F (url_id);
CREATE INDEX word1F ON dict1F (word);

CREATE INDEX url_id20 ON dict20 (url_id);
CREATE INDEX word20 ON dict20 (word);

CREATE INDEX url_id21 ON dict21 (url_id);
CREATE INDEX word21 ON dict21 (word);

CREATE INDEX url_id22 ON dict22 (url_id);
CREATE INDEX word22 ON dict22 (word);

CREATE INDEX url_id23 ON dict23 (url_id);
CREATE INDEX word23 ON dict23 (word);

CREATE INDEX url_id24 ON dict24 (url_id);
CREATE INDEX word24 ON dict24 (word);

CREATE INDEX url_id25 ON dict25 (url_id);
CREATE INDEX word25 ON dict25 (word);

CREATE INDEX url_id26 ON dict26 (url_id);
CREATE INDEX word26 ON dict26 (word);

CREATE INDEX url_id27 ON dict27 (url_id);
CREATE INDEX word27 ON dict27 (word);

CREATE INDEX url_id28 ON dict28 (url_id);
CREATE INDEX word28 ON dict28 (word);

CREATE INDEX url_id29 ON dict29 (url_id);
CREATE INDEX word29 ON dict29 (word);

CREATE INDEX url_id2A ON dict2A (url_id);
CREATE INDEX word2A ON dict2A (word);

CREATE INDEX url_id2B ON dict2B (url_id);
CREATE INDEX word2B ON dict2B (word);

CREATE INDEX url_id2C ON dict2C (url_id);
CREATE INDEX word2C ON dict2C (word);

CREATE INDEX url_id2D ON dict2D (url_id);
CREATE INDEX word2D ON dict2D (word);

CREATE INDEX url_id2E ON dict2E (url_id);
CREATE INDEX word2E ON dict2E (word);

CREATE INDEX url_id2F ON dict2F (url_id);
CREATE INDEX word2F ON dict2F (word);

CREATE INDEX url_id30 ON dict30 (url_id);
CREATE INDEX word30 ON dict30 (word);

CREATE INDEX url_id31 ON dict31 (url_id);
CREATE INDEX word31 ON dict31 (word);

CREATE INDEX url_id32 ON dict32 (url_id);
CREATE INDEX word32 ON dict32 (word);

CREATE INDEX url_id33 ON dict33 (url_id);
CREATE INDEX word33 ON dict33 (word);

CREATE INDEX url_id34 ON dict34 (url_id);
CREATE INDEX word34 ON dict34 (word);

CREATE INDEX url_id35 ON dict35 (url_id);
CREATE INDEX word35 ON dict35 (word);

CREATE INDEX url_id36 ON dict36 (url_id);
CREATE INDEX word36 ON dict36 (word);

CREATE INDEX url_id37 ON dict37 (url_id);
CREATE INDEX word37 ON dict37 (word);

CREATE INDEX url_id38 ON dict38 (url_id);
CREATE INDEX word38 ON dict38 (word);

CREATE INDEX url_id39 ON dict39 (url_id);
CREATE INDEX word39 ON dict39 (word);

CREATE INDEX url_id3A ON dict3A (url_id);
CREATE INDEX word3A ON dict3A (word);

CREATE INDEX url_id3B ON dict3B (url_id);
CREATE INDEX word3B ON dict3B (word);

CREATE INDEX url_id3C ON dict3C (url_id);
CREATE INDEX word3C ON dict3C (word);

CREATE INDEX url_id3D ON dict3D (url_id);
CREATE INDEX word3D ON dict3D (word);

CREATE INDEX url_id3E ON dict3E (url_id);
CREATE INDEX word3E ON dict3E (word);

CREATE INDEX url_id3F ON dict3F (url_id);
CREATE INDEX word3F ON dict3F (word);

CREATE INDEX url_id40 ON dict40 (url_id);
CREATE INDEX word40 ON dict40 (word);

CREATE INDEX url_id41 ON dict41 (url_id);
CREATE INDEX word41 ON dict41 (word);

CREATE INDEX url_id42 ON dict42 (url_id);
CREATE INDEX word42 ON dict42 (word);

CREATE INDEX url_id43 ON dict43 (url_id);
CREATE INDEX word43 ON dict43 (word);

CREATE INDEX url_id44 ON dict44 (url_id);
CREATE INDEX word44 ON dict44 (word);

CREATE INDEX url_id45 ON dict45 (url_id);
CREATE INDEX word45 ON dict45 (word);

CREATE INDEX url_id46 ON dict46 (url_id);
CREATE INDEX word46 ON dict46 (word);

CREATE INDEX url_id47 ON dict47 (url_id);
CREATE INDEX word47 ON dict47 (word);

CREATE INDEX url_id48 ON dict48 (url_id);
CREATE INDEX word48 ON dict48 (word);

CREATE INDEX url_id49 ON dict49 (url_id);
CREATE INDEX word49 ON dict49 (word);

CREATE INDEX url_id4A ON dict4A (url_id);
CREATE INDEX word4A ON dict4A (word);

CREATE INDEX url_id4B ON dict4B (url_id);
CREATE INDEX word4B ON dict4B (word);

CREATE INDEX url_id4C ON dict4C (url_id);
CREATE INDEX word4C ON dict4C (word);

CREATE INDEX url_id4D ON dict4D (url_id);
CREATE INDEX word4D ON dict4D (word);

CREATE INDEX url_id4E ON dict4E (url_id);
CREATE INDEX word4E ON dict4E (word);

CREATE INDEX url_id4F ON dict4F (url_id);
CREATE INDEX word4F ON dict4F (word);

CREATE INDEX url_id50 ON dict50 (url_id);
CREATE INDEX word50 ON dict50 (word);

CREATE INDEX url_id51 ON dict51 (url_id);
CREATE INDEX word51 ON dict51 (word);

CREATE INDEX url_id52 ON dict52 (url_id);
CREATE INDEX word52 ON dict52 (word);

CREATE INDEX url_id53 ON dict53 (url_id);
CREATE INDEX word53 ON dict53 (word);

CREATE INDEX url_id54 ON dict54 (url_id);
CREATE INDEX word54 ON dict54 (word);

CREATE INDEX url_id55 ON dict55 (url_id);
CREATE INDEX word55 ON dict55 (word);

CREATE INDEX url_id56 ON dict56 (url_id);
CREATE INDEX word56 ON dict56 (word);

CREATE INDEX url_id57 ON dict57 (url_id);
CREATE INDEX word57 ON dict57 (word);

CREATE INDEX url_id58 ON dict58 (url_id);
CREATE INDEX word58 ON dict58 (word);

CREATE INDEX url_id59 ON dict59 (url_id);
CREATE INDEX word59 ON dict59 (word);

CREATE INDEX url_id5A ON dict5A (url_id);
CREATE INDEX word5A ON dict5A (word);

CREATE INDEX url_id5B ON dict5B (url_id);
CREATE INDEX word5B ON dict5B (word);

CREATE INDEX url_id5C ON dict5C (url_id);
CREATE INDEX word5C ON dict5C (word);

CREATE INDEX url_id5D ON dict5D (url_id);
CREATE INDEX word5D ON dict5D (word);

CREATE INDEX url_id5E ON dict5E (url_id);
CREATE INDEX word5E ON dict5E (word);

CREATE INDEX url_id5F ON dict5F (url_id);
CREATE INDEX word5F ON dict5F (word);

CREATE INDEX url_id60 ON dict60 (url_id);
CREATE INDEX word60 ON dict60 (word);

CREATE INDEX url_id61 ON dict61 (url_id);
CREATE INDEX word61 ON dict61 (word);

CREATE INDEX url_id62 ON dict62 (url_id);
CREATE INDEX word62 ON dict62 (word);

CREATE INDEX url_id63 ON dict63 (url_id);
CREATE INDEX word63 ON dict63 (word);

CREATE INDEX url_id64 ON dict64 (url_id);
CREATE INDEX word64 ON dict64 (word);

CREATE INDEX url_id65 ON dict65 (url_id);
CREATE INDEX word65 ON dict65 (word);

CREATE INDEX url_id66 ON dict66 (url_id);
CREATE INDEX word66 ON dict66 (word);

CREATE INDEX url_id67 ON dict67 (url_id);
CREATE INDEX word67 ON dict67 (word);

CREATE INDEX url_id68 ON dict68 (url_id);
CREATE INDEX word68 ON dict68 (word);

CREATE INDEX url_id69 ON dict69 (url_id);
CREATE INDEX word69 ON dict69 (word);

CREATE INDEX url_id6A ON dict6A (url_id);
CREATE INDEX word6A ON dict6A (word);

CREATE INDEX url_id6B ON dict6B (url_id);
CREATE INDEX word6B ON dict6B (word);

CREATE INDEX url_id6C ON dict6C (url_id);
CREATE INDEX word6C ON dict6C (word);

CREATE INDEX url_id6D ON dict6D (url_id);
CREATE INDEX word6D ON dict6D (word);

CREATE INDEX url_id6E ON dict6E (url_id);
CREATE INDEX word6E ON dict6E (word);

CREATE INDEX url_id6F ON dict6F (url_id);
CREATE INDEX word6F ON dict6F (word);

CREATE INDEX url_id70 ON dict70 (url_id);
CREATE INDEX word70 ON dict70 (word);

CREATE INDEX url_id71 ON dict71 (url_id);
CREATE INDEX word71 ON dict71 (word);

CREATE INDEX url_id72 ON dict72 (url_id);
CREATE INDEX word72 ON dict72 (word);

CREATE INDEX url_id73 ON dict73 (url_id);
CREATE INDEX word73 ON dict73 (word);

CREATE INDEX url_id74 ON dict74 (url_id);
CREATE INDEX word74 ON dict74 (word);

CREATE INDEX url_id75 ON dict75 (url_id);
CREATE INDEX word75 ON dict75 (word);

CREATE INDEX url_id76 ON dict76 (url_id);
CREATE INDEX word76 ON dict76 (word);

CREATE INDEX url_id77 ON dict77 (url_id);
CREATE INDEX word77 ON dict77 (word);

CREATE INDEX url_id78 ON dict78 (url_id);
CREATE INDEX word78 ON dict78 (word);

CREATE INDEX url_id79 ON dict79 (url_id);
CREATE INDEX word79 ON dict79 (word);

CREATE INDEX url_id7A ON dict7A (url_id);
CREATE INDEX word7A ON dict7A (word);

CREATE INDEX url_id7B ON dict7B (url_id);
CREATE INDEX word7B ON dict7B (word);

CREATE INDEX url_id7C ON dict7C (url_id);
CREATE INDEX word7C ON dict7C (word);

CREATE INDEX url_id7D ON dict7D (url_id);
CREATE INDEX word7D ON dict7D (word);

CREATE INDEX url_id7E ON dict7E (url_id);
CREATE INDEX word7E ON dict7E (word);

CREATE INDEX url_id7F ON dict7F (url_id);
CREATE INDEX word7F ON dict7F (word);

CREATE INDEX url_id80 ON dict80 (url_id);
CREATE INDEX word80 ON dict80 (word);

CREATE INDEX url_id81 ON dict81 (url_id);
CREATE INDEX word81 ON dict81 (word);

CREATE INDEX url_id82 ON dict82 (url_id);
CREATE INDEX word82 ON dict82 (word);

CREATE INDEX url_id83 ON dict83 (url_id);
CREATE INDEX word83 ON dict83 (word);

CREATE INDEX url_id84 ON dict84 (url_id);
CREATE INDEX word84 ON dict84 (word);

CREATE INDEX url_id85 ON dict85 (url_id);
CREATE INDEX word85 ON dict85 (word);

CREATE INDEX url_id86 ON dict86 (url_id);
CREATE INDEX word86 ON dict86 (word);

CREATE INDEX url_id87 ON dict87 (url_id);
CREATE INDEX word87 ON dict87 (word);

CREATE INDEX url_id88 ON dict88 (url_id);
CREATE INDEX word88 ON dict88 (word);

CREATE INDEX url_id89 ON dict89 (url_id);
CREATE INDEX word89 ON dict89 (word);

CREATE INDEX url_id8A ON dict8A (url_id);
CREATE INDEX word8A ON dict8A (word);

CREATE INDEX url_id8B ON dict8B (url_id);
CREATE INDEX word8B ON dict8B (word);

CREATE INDEX url_id8C ON dict8C (url_id);
CREATE INDEX word8C ON dict8C (word);

CREATE INDEX url_id8D ON dict8D (url_id);
CREATE INDEX word8D ON dict8D (word);

CREATE INDEX url_id8E ON dict8E (url_id);
CREATE INDEX word8E ON dict8E (word);

CREATE INDEX url_id8F ON dict8F (url_id);
CREATE INDEX word8F ON dict8F (word);

CREATE INDEX url_id90 ON dict90 (url_id);
CREATE INDEX word90 ON dict90 (word);

CREATE INDEX url_id91 ON dict91 (url_id);
CREATE INDEX word91 ON dict91 (word);

CREATE INDEX url_id92 ON dict92 (url_id);
CREATE INDEX word92 ON dict92 (word);

CREATE INDEX url_id93 ON dict93 (url_id);
CREATE INDEX word93 ON dict93 (word);

CREATE INDEX url_id94 ON dict94 (url_id);
CREATE INDEX word94 ON dict94 (word);

CREATE INDEX url_id95 ON dict95 (url_id);
CREATE INDEX word95 ON dict95 (word);

CREATE INDEX url_id96 ON dict96 (url_id);
CREATE INDEX word96 ON dict96 (word);

CREATE INDEX url_id97 ON dict97 (url_id);
CREATE INDEX word97 ON dict97 (word);

CREATE INDEX url_id98 ON dict98 (url_id);
CREATE INDEX word98 ON dict98 (word);

CREATE INDEX url_id99 ON dict99 (url_id);
CREATE INDEX word99 ON dict99 (word);

CREATE INDEX url_id9A ON dict9A (url_id);
CREATE INDEX word9A ON dict9A (word);

CREATE INDEX url_id9B ON dict9B (url_id);
CREATE INDEX word9B ON dict9B (word);

CREATE INDEX url_id9C ON dict9C (url_id);
CREATE INDEX word9C ON dict9C (word);

CREATE INDEX url_id9D ON dict9D (url_id);
CREATE INDEX word9D ON dict9D (word);

CREATE INDEX url_id9E ON dict9E (url_id);
CREATE INDEX word9E ON dict9E (word);

CREATE INDEX url_id9F ON dict9F (url_id);
CREATE INDEX word9F ON dict9F (word);

CREATE INDEX url_idA0 ON dictA0 (url_id);
CREATE INDEX wordA0 ON dictA0 (word);

CREATE INDEX url_idA1 ON dictA1 (url_id);
CREATE INDEX wordA1 ON dictA1 (word);

CREATE INDEX url_idA2 ON dictA2 (url_id);
CREATE INDEX wordA2 ON dictA2 (word);

CREATE INDEX url_idA3 ON dictA3 (url_id);
CREATE INDEX wordA3 ON dictA3 (word);

CREATE INDEX url_idA4 ON dictA4 (url_id);
CREATE INDEX wordA4 ON dictA4 (word);

CREATE INDEX url_idA5 ON dictA5 (url_id);
CREATE INDEX wordA5 ON dictA5 (word);

CREATE INDEX url_idA6 ON dictA6 (url_id);
CREATE INDEX wordA6 ON dictA6 (word);

CREATE INDEX url_idA7 ON dictA7 (url_id);
CREATE INDEX wordA7 ON dictA7 (word);

CREATE INDEX url_idA8 ON dictA8 (url_id);
CREATE INDEX wordA8 ON dictA8 (word);

CREATE INDEX url_idA9 ON dictA9 (url_id);
CREATE INDEX wordA9 ON dictA9 (word);

CREATE INDEX url_idAA ON dictAA (url_id);
CREATE INDEX wordAA ON dictAA (word);

CREATE INDEX url_idAB ON dictAB (url_id);
CREATE INDEX wordAB ON dictAB (word);

CREATE INDEX url_idAC ON dictAC (url_id);
CREATE INDEX wordAC ON dictAC (word);

CREATE INDEX url_idAD ON dictAD (url_id);
CREATE INDEX wordAD ON dictAD (word);

CREATE INDEX url_idAE ON dictAE (url_id);
CREATE INDEX wordAE ON dictAE (word);

CREATE INDEX url_idAF ON dictAF (url_id);
CREATE INDEX wordAF ON dictAF (word);

CREATE INDEX url_idB0 ON dictB0 (url_id);
CREATE INDEX wordB0 ON dictB0 (word);

CREATE INDEX url_idB1 ON dictB1 (url_id);
CREATE INDEX wordB1 ON dictB1 (word);

CREATE INDEX url_idB2 ON dictB2 (url_id);
CREATE INDEX wordB2 ON dictB2 (word);

CREATE INDEX url_idB3 ON dictB3 (url_id);
CREATE INDEX wordB3 ON dictB3 (word);

CREATE INDEX url_idB4 ON dictB4 (url_id);
CREATE INDEX wordB4 ON dictB4 (word);

CREATE INDEX url_idB5 ON dictB5 (url_id);
CREATE INDEX wordB5 ON dictB5 (word);

CREATE INDEX url_idB6 ON dictB6 (url_id);
CREATE INDEX wordB6 ON dictB6 (word);

CREATE INDEX url_idB7 ON dictB7 (url_id);
CREATE INDEX wordB7 ON dictB7 (word);

CREATE INDEX url_idB8 ON dictB8 (url_id);
CREATE INDEX wordB8 ON dictB8 (word);

CREATE INDEX url_idB9 ON dictB9 (url_id);
CREATE INDEX wordB9 ON dictB9 (word);

CREATE INDEX url_idBA ON dictBA (url_id);
CREATE INDEX wordBA ON dictBA (word);

CREATE INDEX url_idBB ON dictBB (url_id);
CREATE INDEX wordBB ON dictBB (word);

CREATE INDEX url_idBC ON dictBC (url_id);
CREATE INDEX wordBC ON dictBC (word);

CREATE INDEX url_idBD ON dictBD (url_id);
CREATE INDEX wordBD ON dictBD (word);

CREATE INDEX url_idBE ON dictBE (url_id);
CREATE INDEX wordBE ON dictBE (word);

CREATE INDEX url_idBF ON dictBF (url_id);
CREATE INDEX wordBF ON dictBF (word);

CREATE INDEX url_idC0 ON dictC0 (url_id);
CREATE INDEX wordC0 ON dictC0 (word);

CREATE INDEX url_idC1 ON dictC1 (url_id);
CREATE INDEX wordC1 ON dictC1 (word);

CREATE INDEX url_idC2 ON dictC2 (url_id);
CREATE INDEX wordC2 ON dictC2 (word);

CREATE INDEX url_idC3 ON dictC3 (url_id);
CREATE INDEX wordC3 ON dictC3 (word);

CREATE INDEX url_idC4 ON dictC4 (url_id);
CREATE INDEX wordC4 ON dictC4 (word);

CREATE INDEX url_idC5 ON dictC5 (url_id);
CREATE INDEX wordC5 ON dictC5 (word);

CREATE INDEX url_idC6 ON dictC6 (url_id);
CREATE INDEX wordC6 ON dictC6 (word);

CREATE INDEX url_idC7 ON dictC7 (url_id);
CREATE INDEX wordC7 ON dictC7 (word);

CREATE INDEX url_idC8 ON dictC8 (url_id);
CREATE INDEX wordC8 ON dictC8 (word);

CREATE INDEX url_idC9 ON dictC9 (url_id);
CREATE INDEX wordC9 ON dictC9 (word);

CREATE INDEX url_idCA ON dictCA (url_id);
CREATE INDEX wordCA ON dictCA (word);

CREATE INDEX url_idCB ON dictCB (url_id);
CREATE INDEX wordCB ON dictCB (word);

CREATE INDEX url_idCC ON dictCC (url_id);
CREATE INDEX wordCC ON dictCC (word);

CREATE INDEX url_idCD ON dictCD (url_id);
CREATE INDEX wordCD ON dictCD (word);

CREATE INDEX url_idCE ON dictCE (url_id);
CREATE INDEX wordCE ON dictCE (word);

CREATE INDEX url_idCF ON dictCF (url_id);
CREATE INDEX wordCF ON dictCF (word);

CREATE INDEX url_idD0 ON dictD0 (url_id);
CREATE INDEX wordD0 ON dictD0 (word);

CREATE INDEX url_idD1 ON dictD1 (url_id);
CREATE INDEX wordD1 ON dictD1 (word);

CREATE INDEX url_idD2 ON dictD2 (url_id);
CREATE INDEX wordD2 ON dictD2 (word);

CREATE INDEX url_idD3 ON dictD3 (url_id);
CREATE INDEX wordD3 ON dictD3 (word);

CREATE INDEX url_idD4 ON dictD4 (url_id);
CREATE INDEX wordD4 ON dictD4 (word);

CREATE INDEX url_idD5 ON dictD5 (url_id);
CREATE INDEX wordD5 ON dictD5 (word);

CREATE INDEX url_idD6 ON dictD6 (url_id);
CREATE INDEX wordD6 ON dictD6 (word);

CREATE INDEX url_idD7 ON dictD7 (url_id);
CREATE INDEX wordD7 ON dictD7 (word);

CREATE INDEX url_idD8 ON dictD8 (url_id);
CREATE INDEX wordD8 ON dictD8 (word);

CREATE INDEX url_idD9 ON dictD9 (url_id);
CREATE INDEX wordD9 ON dictD9 (word);

CREATE INDEX url_idDA ON dictDA (url_id);
CREATE INDEX wordDA ON dictDA (word);

CREATE INDEX url_idDB ON dictDB (url_id);
CREATE INDEX wordDB ON dictDB (word);

CREATE INDEX url_idDC ON dictDC (url_id);
CREATE INDEX wordDC ON dictDC (word);

CREATE INDEX url_idDD ON dictDD (url_id);
CREATE INDEX wordDD ON dictDD (word);

CREATE INDEX url_idDE ON dictDE (url_id);
CREATE INDEX wordDE ON dictDE (word);

CREATE INDEX url_idDF ON dictDF (url_id);
CREATE INDEX wordDF ON dictDF (word);

CREATE INDEX url_idE0 ON dictE0 (url_id);
CREATE INDEX wordE0 ON dictE0 (word);

CREATE INDEX url_idE1 ON dictE1 (url_id);
CREATE INDEX wordE1 ON dictE1 (word);

CREATE INDEX url_idE2 ON dictE2 (url_id);
CREATE INDEX wordE2 ON dictE2 (word);

CREATE INDEX url_idE3 ON dictE3 (url_id);
CREATE INDEX wordE3 ON dictE3 (word);

CREATE INDEX url_idE4 ON dictE4 (url_id);
CREATE INDEX wordE4 ON dictE4 (word);

CREATE INDEX url_idE5 ON dictE5 (url_id);
CREATE INDEX wordE5 ON dictE5 (word);

CREATE INDEX url_idE6 ON dictE6 (url_id);
CREATE INDEX wordE6 ON dictE6 (word);

CREATE INDEX url_idE7 ON dictE7 (url_id);
CREATE INDEX wordE7 ON dictE7 (word);

CREATE INDEX url_idE8 ON dictE8 (url_id);
CREATE INDEX wordE8 ON dictE8 (word);

CREATE INDEX url_idE9 ON dictE9 (url_id);
CREATE INDEX wordE9 ON dictE9 (word);

CREATE INDEX url_idEA ON dictEA (url_id);
CREATE INDEX wordEA ON dictEA (word);

CREATE INDEX url_idEB ON dictEB (url_id);
CREATE INDEX wordEB ON dictEB (word);

CREATE INDEX url_idEC ON dictEC (url_id);
CREATE INDEX wordEC ON dictEC (word);

CREATE INDEX url_idED ON dictED (url_id);
CREATE INDEX wordED ON dictED (word);

CREATE INDEX url_idEE ON dictEE (url_id);
CREATE INDEX wordEE ON dictEE (word);

CREATE INDEX url_idEF ON dictEF (url_id);
CREATE INDEX wordEF ON dictEF (word);

CREATE INDEX url_idF0 ON dictF0 (url_id);
CREATE INDEX wordF0 ON dictF0 (word);

CREATE INDEX url_idF1 ON dictF1 (url_id);
CREATE INDEX wordF1 ON dictF1 (word);

CREATE INDEX url_idF2 ON dictF2 (url_id);
CREATE INDEX wordF2 ON dictF2 (word);

CREATE INDEX url_idF3 ON dictF3 (url_id);
CREATE INDEX wordF3 ON dictF3 (word);

CREATE INDEX url_idF4 ON dictF4 (url_id);
CREATE INDEX wordF4 ON dictF4 (word);

CREATE INDEX url_idF5 ON dictF5 (url_id);
CREATE INDEX wordF5 ON dictF5 (word);

CREATE INDEX url_idF6 ON dictF6 (url_id);
CREATE INDEX wordF6 ON dictF6 (word);

CREATE INDEX url_idF7 ON dictF7 (url_id);
CREATE INDEX wordF7 ON dictF7 (word);

CREATE INDEX url_idF8 ON dictF8 (url_id);
CREATE INDEX wordF8 ON dictF8 (word);

CREATE INDEX url_idF9 ON dictF9 (url_id);
CREATE INDEX wordF9 ON dictF9 (word);

CREATE INDEX url_idFA ON dictFA (url_id);
CREATE INDEX wordFA ON dictFA (word);

CREATE INDEX url_idFB ON dictFB (url_id);
CREATE INDEX wordFB ON dictFB (word);

CREATE INDEX url_idFC ON dictFC (url_id);
CREATE INDEX wordFC ON dictFC (word);

CREATE INDEX url_idFD ON dictFD (url_id);
CREATE INDEX wordFD ON dictFD (word);

CREATE INDEX url_idFE ON dictFE (url_id);
CREATE INDEX wordFE ON dictFE (word);

CREATE INDEX url_idFF ON dictFF (url_id);
CREATE INDEX wordFF ON dictFF (word);
