<?
 /**
   * Database connection module
   * @package Search
   * @access  public
   * @subpackage  lib.iinc
   **/
 require ($lib_path."cinc/cmysql.inc");

 // make new mysql connection
 $conf->DB=new cMySQL($conf->CONFdbhost,$conf->CONFdbuser,$conf->CONFdbpass,$conf->CONFdbdatabase,$conf->mlog, $conf);
?>
