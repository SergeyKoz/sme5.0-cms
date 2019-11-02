<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** Banner places storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerPlacesTable extends AbstractTable   {
	var $ClassName = "BannerPlacesTable";
	var $Version = "1.0";


	function prepareColumns() {
		$this->columns[] = array("name" => "place_id",           "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "place_title",        "type" => DB_COLUMN_STRING,   "length"=>255,   "notnull"=>1);
		$this->columns[] = array("name" => "max_banners_qty",    "type" => DB_COLUMN_NUMERIC,  "length"=>10,    "notnull"=>1);
		$this->columns[] = array("name" => "is_random",           "type" => DB_COLUMN_NUMERIC,  "length"=>10,    "notnull"=>0, "dtype"=> "int");
		parent::prepareColumns();
	}

	/**
  * Method returns quantities of banners that could be allocated in each banner placeholder
  * @return     MySQLReader   Reader of banner placeholder data
  * @access     public
  **/
	function GetPlacesQuantity(){
		$SQL = sprintf("SELECT *
                       FROM %s
                       WHERE max_banners_qty > 0
                       ORDER BY place_id
                       ",
		$this->defaultTableName
		);
		return $this->Connection->ExecuteReader($SQL);
	}

} //--end of class

?>