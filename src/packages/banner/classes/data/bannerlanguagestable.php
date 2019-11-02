<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** Banner languages storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerLanguagesTable extends AbstractTable   {
  var $ClassName = "BannerLanguagesTable";
  var $Version = "1.0";
  

 function prepareColumns() {  
  $this->columns[] = array("name" => "banner_id",     "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "language",      "type" => DB_COLUMN_STRING);

  //	parent::prepareColumns();
 }
  
  
} //--end of class

?>