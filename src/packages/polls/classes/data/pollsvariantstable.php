<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Polls storage class
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package  Polls
* @access public
*/
class PollsVariantsTable extends ProjectTable{
	var $ClassName = "PollsVariantsTable";
	var $Version = "1.0";
	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string    $TableName    Table name
	* @access    public
	*/
	function PollsVariantsTable(&$Connection, $TableName) {
		ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns() {
		$this->columns[] = array("name" => "id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "variant_text", "type" => DB_COLUMN_STRING, "length"=>255, "notnull"=>1, "dtype"=>"string");
		$this->columns[] = array("name" => "q_id", "type" => DB_COLUMN_NUMERIC,"length"=>10,"dtype"=>"int");
		$this->columns[] = array("name" => "p_id", "type" => DB_COLUMN_NUMERIC,"length"=>10,"dtype"=>"int");
		parent::prepareColumns();
	}

	function VariantsPoll(){
		//$q_id=$this->Connection->Kernel->Page->Request->Value("item_id");
		$q_id=Page()->Request->Value("item_id");
		$SQL = sprintf("SELECT id, variant_text, count(*) AS count_var
			FROM %s
			%s
			GROUP BY variant_text
			ORDER BY count_var DESC",
			$this->defaultTableName,
			($q_id!="" ? "WHERE q_id=".$q_id : ""));
		$reader=$this->Connection->ExecuteReader($SQL);
		return $reader;
	}
}

?>