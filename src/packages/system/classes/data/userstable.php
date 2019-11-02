<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** System User profile storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 2.0
 * @package System
 * @subpackage classes.data
 * @access public
 */
class UsersTable extends ProjectTable{
	var $ClassName = "UsersTable";
	var $Version = "1.0";
	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string	$TableName	Table name
	* @access	public
	*/
	function UsersTable(&$Connection, $TableName) {
		ProjectTable::ProjectTable($Connection, $TableName);

	}

	function prepareColumns() {
		parent::prepareColumns();
		$this->columns[] = array("name" => "user_id",         "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "group_id",        "type" => DB_COLUMN_NUMERIC,"length"=>2);
		$this->columns[] = array("name" => "user_login",      "type" => DB_COLUMN_STRING,"length"=>64,"notnull"=>1,"dtype"=>"string");
		$this->columns[] = array("name" => "user_password",   "type" => DB_COLUMN_STRING,"length"=>64,"notnull"=>1,"dtype"=>"password");

		$this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING, "length"=>200, "dtype"=>"email", "notnull"=>1);
		$this->columns[] = array("name" => "name", "type" => DB_COLUMN_STRING,"length"=>100, "notnull"=>1);

		$this->columns[] = array("name" => "phone", "type" => DB_COLUMN_STRING,"length"=>300);
		$this->columns[] = array("name" => "additional", "type" => DB_COLUMN_STRING,"length"=>2000);
	}

	function OnAfterDelete(&$data){
		$this->DeleteRoles($data);
		parent::OnAfterDelete($data);
	}

	function OnAfterGroupDelete($in_field, $in_data){
		$data=array($in_field=>$in_data);
		$this->DeleteRoles($data);
		parent::OnAfterGroupDelete($in_field, $in_data);
	}

	function DeleteRoles(&$data){
		$UsersRelationStorage=DataFactory::GetStorage($this->Connection->Kernel->Page, "UserRolesTable");
		$UsersRelationStorage->DeleteByKey($data);
	}

} //--end of class

?>