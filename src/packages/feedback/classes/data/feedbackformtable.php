<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Sites storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Feedback
 * @access public
 */
class FeedbackFormTable extends ProjectTable
{
  var $ClassName = "FeedbackFormTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function FeedbackFormTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {

  $this->columns[] = array("name" => "field_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "caption_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "not_null", "type" => DB_COLUMN_NUMERIC,"length"=>1,"notnull"=>0,"dtype"=>"int");
  $this->columns[] = array("name" => "field_type", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "max_length", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>1,"dtype"=>"int");
  $this->columns[] = array("name" => "default_value_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "_lastmodified", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
  parent::prepareColumns();

 }


}

?>