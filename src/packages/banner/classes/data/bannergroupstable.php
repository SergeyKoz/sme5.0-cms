<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Banner groups storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerGroupsTable extends ProjectTable   {
  var $ClassName = "BannerGroupsTable";
  var $Version = "1.0";
  
/**
  * Class constructor
  * @param  MySqlConnection   $Connection Connection object
  * @param  string	$TableName	Table name
  * @access	public
  **/
function BannerGroupsTable(&$Connection, $TableName) {
	ProjectTable::ProjectTable($Connection, $TableName);
}


 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "group_id",  	       	       "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);    
  $this->columns[] = array("name" => "parent_id",  	       	       "type" => DB_COLUMN_NUMERIC);    
  $this->columns[] = array("name" => "group_title", 		           "type" => DB_COLUMN_STRING,   "length"=>255,      "notnull"=>1);   	
	
}	
     
} //--end of class

?>