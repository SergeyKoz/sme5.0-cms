<?php
$this->ImportClass("data.projecttable", "ProjectTable");
/** Parameters storage class
 * @author Artem MIkhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class TagsItemsTable extends ProjectTable{
	var $ClassName = "TagsItemsTable";
	var $Version = "1.0";

	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string	$TableName	Table name
	* @access	public
	*/
	function TagsItemsTable(&$Connection, $TableName) {
		ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns() {
		parent::prepareColumns();
		$this->columns[] = array("name" => "id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "item_id", "type" => DB_COLUMN_NUMERIC,"length"=>10);
		$this->columns[] = array("name" => "item_type", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "item_code", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "item_date", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "entry", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "description", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "language", "type" => DB_COLUMN_STRING,"length"=>2,"dtype"=>"string");
	}

} //--end of class

?>