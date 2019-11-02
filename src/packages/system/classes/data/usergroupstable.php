<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** User groups storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package System
 * @subpackage classes.data
 * @access public
 */
class UserGroupsTable extends ProjectTable   {
  var $ClassName = "UserGroupsTable";
  var $Version = "1.0";
  
/**
  * Class constructor
  * @param  MySqlConnection   	$Connection Connection object
  * @param  string	$TableName	Table name
  * @access	public
  **/
function UserGroupsTable(&$Connection, $TableName) {
	ProjectTable::ProjectTable($Connection, $TableName);
}


 function prepareColumns() {  
  $this->columns[] = array("name" => "group_id",  	       	       "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);    
	$this->columns[] = array("name" => "parent_id",  	       	       "type" => DB_COLUMN_NUMERIC);    
	$this->columns[] = array("name" => "group_name_%s", 		           "type" => DB_COLUMN_STRING,   "length"=>255,      "notnull"=>1);   	
	parent::prepareColumns();
}	
     
} //--end of class

?>