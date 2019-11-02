<?php
$this->ImportClass("module.data.projecttable","ProjectTable");

/** Settings storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package System
 * @subpackage pages
 * @access public
 */
class SettingsTable extends ProjectTable
{
  var $ClassName = "SettingsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string  $TableName  Table name
* @access  public
*/
function SettingsTable(&$Connection, $TableName) {
  ProjectTable::ProjectTable($Connection, $TableName);
}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "settingid",       "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "title_%s",     "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);
  $this->columns[] = array("name" => "email",    "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1, "dtype"=>"email");
  $this->columns[] = array("name" => "skin",    "type" => DB_COLUMN_STRING,"length"=>255);
  $this->columns[] = array("name" => "logo",    "type" => DB_COLUMN_STRING,"length"=>255);
  $this->columns[] = array("name" => "meta_keywords_%s",    "type" => DB_COLUMN_STRING,"length"=>1000);
  $this->columns[] = array("name" => "meta_description_%s",    "type" => DB_COLUMN_STRING,"length"=>1000);
  $this->columns[] = array("name" => "rpp",    "type" => DB_COLUMN_NUMERIC, "dtype"=>"int");

  if (Engine::isPackageExists($this->Connection->Kernel, "comments")){
	  $this->columns[] = array("name" => "comments_auto_publishing", "type" => DB_COLUMN_NUMERIC);
	  $this->columns[] = array("name" => "comments_only_register", "type" => DB_COLUMN_NUMERIC);
	  $this->columns[] = array("name" => "comments_emails", "type" => DB_COLUMN_STRING);
	  $this->columns[] = array("name" => "comments_voting", "type" => DB_COLUMN_NUMERIC);
	  $this->columns[] = array("name" => "comments_length", "type" => DB_COLUMN_NUMERIC,"notnull"=>1);
	  $this->columns[] = array("name" => "comments_pp", "type" => DB_COLUMN_NUMERIC);
  }

 }

 function OnAfterUpdate(&$data){
 	parent::OnAfterUpdate($data);

 	if (Engine::isPackageExists($this->Connection->Kernel, "calendar")){
        $CalendarEventsStorage=DataFactory::GetStorage($this->Connection->Kernel->Page, "CalendarEventsTable", "", true, "calendar");
        $CalendarEventsStorage->UploadEventCheckStoredFunction();
  	}
 }


}

?>