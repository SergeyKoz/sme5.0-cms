<?php
$this->Import("module.data.projecttable");

/** Sites storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Cosmo
 * @access public
 */
class SitesTable extends ProjectTable
{
  var $ClassName = "SitesTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SitesTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "site_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int");
  $this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "period", "type" => DB_COLUMN_NUMERIC,"length"=>255,"notnull"=>0,"dtype"=>"int");
  $this->columns[] = array("name" => "url", "type" => DB_COLUMN_STRING,"length"=>2000,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "tester_url", "type" => DB_COLUMN_STRING,"length"=>2000,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "site_password", "type" => DB_COLUMN_STRING,"length"=>2000,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "transport_method", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0,"dtype"=>"int");
  $this->columns[] = array("name" => "send_emails", "type" => DB_COLUMN_NUMERIC,"length"=>1,"notnull"=>0,"dtype"=>"int");

  
 }
 

}

?>