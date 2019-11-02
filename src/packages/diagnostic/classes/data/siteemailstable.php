<?php
$this->Import("module.data.projecttable");

/** Site Emails content  storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Cosmo
 * @access public
 */
class SiteEmailsTable extends ProjectTable
{
  var $ClassName = "SiteEmailsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SiteEmailsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "email_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "site_id", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int");
  $this->columns[] = array("name" => "email_owner", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"email");  
  $this->columns[] = array("name" => "errors_only", "type" => DB_COLUMN_NUMERIC,"length"=>1,"notnull"=>0,"dtype"=>"int");    
 }

 function GetEmails(){
        $SQL = sprintf("SELECT e.* FROM %s as e, %s as s
                        WHERE e.active = 1
                          AND s.active = 1
                          AND e.site_id = s.site_id
                          AND s.send_emails = 1
                       ",
                        $this->defaultTableName,
                        $this->GetTable("SitesTable")
                        ); 
        $_reader = $this->Connection->ExecuteReader($SQL);         
        $_tmp = array();       
        for($i=0; $i<$_reader->RecordCount; $i++){
            $__tmp = $_reader->Read();
            $_tmp[$__tmp["site_id"]][$__tmp["email"]] = $__tmp;
        }
        return $_tmp;
 }
 
}

?>