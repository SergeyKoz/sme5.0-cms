<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Subscribers storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 2.0
 * @package  Cosmo
 * @access public
 */
class SubscribeThemesTable extends ProjectTable
{
  var $ClassName = "subscribethemestable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SubscribeThemesTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
   $this->columns[] = array("name" => "theme_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
   $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "theme_title_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);
   //$this->columns[] = array("name" => "active_%s", "type" => DB_COLUMN_STRING, "dtype"=>"int","notnull"=>0, "length"=>1);
   parent::prepareColumns();
 }

 function OnAfterDelete(&$data) {
     //data id ����� ��������� ������
     $r=DataFactory::GetStorage($this->Connection->Kernel, "SubscribeRelationTable", false);
     $r->delete( $data );
 }

 function OnAfterGroupDelete($in_field, $in_data){
    $r=DataFactory::GetStorage($this->Connection->Kernel, "SubscribeRelationTable", false);
    $r->GroupDelete($in_field, $in_data);

 }

}
?>