<?
 /**
   * Search query module
   * @package Search
   * @access  public
   * @subpackage lib.sinc
   **/

 $conf->getWordsQuery="select id from ".$conf->TBLwords." where #words#";
 $conf->getSearchQuery="select DISTINCT(u.url) as url,u.descr,u.title from ".$conf->TBLpages." as u, ".$conf->TBLwordspages." as wp where wp.word_id in (#words#) and u.id=wp.url_id order by wp.weight desc,u.created desc";
?>
