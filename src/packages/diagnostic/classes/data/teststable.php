<?php
$this->Import("module.data.projecttable");

/** Files content  storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  BHV
 * @access public
 */
class TestsTable extends ProjectTable
{
  var $ClassName = "TestsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function TestsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "test_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "test_file", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "description", "type" => DB_COLUMN_STRING,"length"=>10000,"notnull"=>0,"dtype"=>"string");  
  $this->columns[] = array("name" => "init_description", "type" => DB_COLUMN_STRING,"length"=>10000,"notnull"=>0,"dtype"=>"string");    
 }



}

?>