<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** User roles storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package System
 * @subpackage classes.data
 * @access public
 */
class UserRolesTable extends AbstractTable   {
  var $ClassName = "UserRolesTable";
  var $Version = "1.0";
  
/**
  * Class constructor
  * @param  MySqlConnection   	$Connection Connection object
  * @param  string	$TableName	Table name
  * @access	public
  **/
function UserRolesTable(&$Connection, $TableName) {
	AbstractTable::AbstractTable($Connection, $TableName);
}


 function prepareColumns() {  
  $this->columns[] = array("name" => "user_role_id",  	       	       	 "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);    
	$this->columns[] = array("name" => "role_name", 	   	       	       	 "type" => DB_COLUMN_STRING,	"length" => 255);    
	$this->columns[] = array("name" => "user_id",				 				           "type" => DB_COLUMN_NUMERIC);   	
	parent::prepareColumns();
}	
     
} //--end of class

?>