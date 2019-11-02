<?php
$this->Import("module.data.projecttable");

/** Magazine banners content  storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Cosmo
 * @access public
 */
class SiteTestsTable extends ProjectTable
{
  var $ClassName = "SiteTestsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SiteTestsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "site_test_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "site_id", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int");
  $this->columns[] = array("name" => "test_id", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>1,"dtype"=>"int");
  //$this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "init", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "send_emails", "type" => DB_COLUMN_NUMERIC,"length"=>1,"notnull"=>0,"dtype"=>"int");
 }

 function getSiteTests($site_id, $emails = false){
        $SQL = sprintf("SELECT st.*, t.test_file as test_file, s.site_password as site_password FROM %s as st, %s as s, %s as t
                        WHERE s.site_id = %d
                          AND s.site_id = st.site_id
                          AND t.test_id = st.test_id
                          AND s.active=1
                          AND t.active=1
                          AND st.active=1 
                          %s 
                        ",
                        $this->defaultTableName,
                        $this->getTable("SitesTable"),
                        $this->getTable("TestsTable"),
                        $site_id,
                        ($emails ? "AND st.send_emails = 1" : "")
                        ); 
                        //echo pr($SQL);
        return $this->Connection->ExecuteReader($SQL);
 }
 
}

?>