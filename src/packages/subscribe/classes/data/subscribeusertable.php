<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Subscribers storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 2.0
 * @package  Subscribe
 * @access public
 */
class SubscribeUserTable extends ProjectTable
{
  var $ClassName = "subscribeusertable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function EventslistTtable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);
}

 function prepareColumns() {
   $this->columns[] = array("name" => "user_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
   $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "first_name", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "last_name", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "post", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "organization", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "country", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "sub_type", "type" => DB_COLUMN_STRING, "dtype"=>"int","notnull"=>0, "length"=>1);
   $this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1, "dtype"=>"email");
   $this->columns[] = array("name" => "lang", "type" => DB_COLUMN_STRING,"length"=>2,"notnull"=>0);
   $this->columns[] = array("name" => "uni_id", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0);
   $this->columns[] = array("name" => "is_tester", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);
   $this->columns[] = array("name" => "activity", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);
   $this->columns[] = array("name" => "state", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);

   parent::prepareColumns();
 }

 function OnBeforeInsert(&$data){
     if ($data["uni_id"]=="")
         $data["uni_id"]=md5(uniqid(rand(), true));
 }


 function GetSubscribeUsers($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
   $content_id = $this->Connection->Kernel->Page->Request->ToNumber("id", 0);
   if($content_id > 0){
      $contentStorage=DataFactory::GetStorage($this->Connection->Kernel->Page, "SubscribeContentTable");
      $content = $contentStorage->Get(array("content_id" => $content_id));
      if($content["is_test"] == 1){
        $data["is_tester"] = 1;
      }

   }

   return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids,  $table_alias, $raw_sql);

 }

 function GetSubscribeUsersCount($data = null, $table_alias="", $raw_sql=array()){
   $content_id = $this->Connection->Kernel->Page->Request->ToNumber("id", 0);
   if($content_id > 0){
      $contentStorage=DataFactory::GetStorage($this->Connection->Kernel->Page, "SubscribeContentTable");
      $content = $contentStorage->Get(array("content_id" => $content_id));
      if($content["is_test"] == 1){
        $data["is_tester"] = 1;
      }

   }


   return $this->GetCount($data, $table_alias, $raw_sql);

 }


}

?>