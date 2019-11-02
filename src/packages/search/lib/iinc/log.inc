<?
 /**
   * Log writing module
   * @package Search
   * @access  public
   * @subpackage  lib.iinc
   **/

 require ($lib_path."cinc/clog.inc");

 // log file object for mysql
 $conf->mlog=new cLOG($conf->CONFmysqllogfile);
 // log file for indexer
 $conf->ilog=new cLOG($conf->CONFindexerlogfile);

?>
