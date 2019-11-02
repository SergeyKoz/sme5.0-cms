<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** Banner places relation storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerPlacesRelationTable extends AbstractTable   {
  var $ClassName = "BannerPlacesRelationTable";
  var $Version = "1.0";
  

 function prepareColumns() {  
	$this->columns[] = array("name" => "banner_id",    "type" => DB_COLUMN_NUMERIC);
	$this->columns[] = array("name" => "place_id",     "type" => DB_COLUMN_NUMERIC);
	parent::prepareColumns();
 }
     
} //--end of class

?>