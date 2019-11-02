<?php
$this->ImportClass("data.projecttable", "ProjectTable");

/** Template parameters storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class TemplateParamsTable extends ProjectTable
{
  var $ClassName = "TemplateParamsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string	$TableName	Table name
* @access	public
*/
function TemplateParamsTable(&$Connection, $TableName) {
	ProjectTable::ProjectTable($Connection, $TableName);
}

 function prepareColumns() {
  $this->columns[] = array("name" => "tp_id",          "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "template_id",    "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "param_type",       "type" => DB_COLUMN_STRING);
  $this->columns[] = array("name" => "caption_%s",     "type" => DB_COLUMN_STRING, "length"=>255, "notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "param_name",    "type" => DB_COLUMN_STRING, "length"=>255, "notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "_default",    "type" => DB_COLUMN_STRING, "length"=>10000,"notnull"=>0,"dtype"=>"string");

  $this->columns[] = array("name" => "is_in_list",         "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "is_in_publication",         "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "max_length",    "type" => DB_COLUMN_NUMERIC, "length"=>10,"notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "cut_to_length",    "type" => DB_COLUMN_NUMERIC, "length"=>10,"notnull"=>0,"dtype"=>"string");

  $this->columns[] = array("name" => "is_link",      "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "is_caption",   "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "is_multilang",         "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "is_not_null",         "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);



  //$this->columns[] = array("name" => "active",         "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
  parent::prepareColumns();

 }

 function getTemplateParameters($template_id)   {
     $SQL = sprintf("SELECT tp.*,tp.caption_%s as title_specific, tp.param_type AS system_name
                     FROM %s as tp
                     WHERE tp.template_id=%d
                       AND tp.active=1
                       ORDER BY tp._priority",
                        $this->Connection->Kernel->Language,
                        $this->defaultTableName, $template_id);
     return @$this->Connection->ExecuteReader($SQL);
 }
} //--end of class
?>