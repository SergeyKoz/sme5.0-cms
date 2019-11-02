<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Subscribers storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 2.0
 * @package  Cosmo
 * @access public
 */
class SubscribeTemplateTable extends ProjectTable
{
  var $ClassName = "subscribetemplatetable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SubscribeTemplateTtable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);
}

 function prepareColumns() {
   $this->columns[] = array("name" => "template_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
   $this->columns[] = array("name" => "name_%s", "type" => DB_COLUMN_STRING,"length"=>255, "notnull"=>0);
   $this->columns[] = array("name" => "template_text_%s", "type" => DB_COLUMN_STRING,"length"=>10000,"notnull"=>1);
   parent::prepareColumns();
 }

  function GetTemplate($id){
 	$record=$this->Get(array("template_id"=>$id));
 	return $record["template_text_".$this->Connection->Kernel->Language];
 }

}
?>