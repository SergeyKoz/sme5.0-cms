<?
 /**
   * Content indexer
   * @package Search
   * @access  public
   * @subpackage lib.sinc
   **/

 $conf->updWordToPageQuery="update ".$conf->TBLwordspageso." set weight=weight+1 where url_id='#page_id#' and word_id='#word_id#'";
 $conf->insWordToPageQuery="insert into ".$conf->TBLwordspageso." (url_id,word_id,weight,created) values ('#page_id#','#word_id#',0,now())";
 $conf->insWordQuery="insert into ".$conf->TBLwordso." (word,created) values ('#word#',now())";
 $conf->selWordQuery="select id from ".$conf->TBLwordso." where word='#word#'";
 $conf->insPageQuery="insert into ".$conf->TBLpageso." (url,created) values ('#page#',now())";
 $conf->updPageInfoQuery="update ".$conf->TBLpageso." set title='#title#',descr='#descr#',status='#status#' where id='#id#'";
 $conf->delWordsQuery="delete from ".$conf->TBLwordso;
 $conf->delPagesQuery="delete from ".$conf->TBLpageso;
 $conf->delWordsToPagesQuery="delete from ".$conf->TBLwordspageso;
 $conf->insUrlToProcessQuery="insert into ".$conf->TBLtodo."(url, processed) values ('#url#', 0)";
 $conf->selUrlFromProcessQuery="select * from ".$conf->TBLtodo." where processed = 0 order by id limit 0,1";
 $conf->updUrlFromProcessQuery="update ".$conf->TBLtodo." set processed = 1 where url='#url#'";
 $conf->delUrlFromProcessQuery="delete from ".$conf->TBLtodo;
 $conf->updIDFromProcessQuery="update ".$conf->TBLtodo." set processed = 1 where id='#id#'";





 $conf->alterPage1Query="alter table ".$conf->TBLpages." rename to ".$conf->TBLpagest;
 $conf->alterWord1Query="alter table ".$conf->TBLwords." rename to ".$conf->TBLwordst;
 $conf->alterWord1ToPageQuery="alter table ".$conf->TBLwordspages." rename to ".$conf->TBLwordspagest;
 $conf->alterPage2Query="alter table ".$conf->TBLpageso." rename to ".$conf->TBLpages;
 $conf->alterWord2Query="alter table ".$conf->TBLwordso." rename to ".$conf->TBLwords;
 $conf->alterWord2ToPageQuery="alter table ".$conf->TBLwordspageso." rename to ".$conf->TBLwordspages;
 $conf->alterPage3Query="alter table ".$conf->TBLpagest." rename to ".$conf->TBLpageso;
 $conf->alterWord3Query="alter table ".$conf->TBLwordst." rename to ".$conf->TBLwordso;
 $conf->alterWord3ToPageQuery="alter table ".$conf->TBLwordspagest." rename to ".$conf->TBLwordspageso;

?>