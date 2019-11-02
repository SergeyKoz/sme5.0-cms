<?php
$this->ImportClass("data.projecttable", "ProjectTable");

/** Templates storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class TemplatesTable extends ProjectTable
{
  var $ClassName = "TemplatesTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName  Table name
* @access   public
*/
function TemplatesTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);
}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "template_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC, "key" => true);
  $this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "is_category", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);

  $this->columns[] = array("name" => "enable_seo_params", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);

  if (Engine::isPackageExists($this->Connection->Kernel, "tags")){
	  $this->columns[] = array("name" => "enable_tags", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
	  $this->columns[] = array("name" => "base_mapping_tags", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>10);
  }
 }


} //--end of class

?>