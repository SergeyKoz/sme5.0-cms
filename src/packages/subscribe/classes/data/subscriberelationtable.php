<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Subscribers storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 2.0
 * @package  Subsctibe
 * @access public
 */
class SubscribeRelationTable extends ProjectTable
{
  var $ClassName = "subscriberelationtable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SubscribeRelationTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
   $this->columns[] = array("name" => "relation_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
   $this->columns[] = array("name" => "user_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "theme_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "lang_ver", "type" => DB_COLUMN_STRING,"length"=>2,"notnull"=>0);
   $this->columns[] = array("name" => "uni_id", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   parent::prepareColumns();
 }

  function OnBeforeInsert(&$data){
     if ($data["uni_id"]=="")
         $data["uni_id"]=md5(uniqid(rand(), true));
  }

}
?>