<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Sites storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Feedback
 * @access public
 */
class DepartmentsTable extends ProjectTable
{
  var $ClassName = "DepartmentsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function DepartmentsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {

  $this->columns[] = array("name" => "department_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "caption_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "description_%s", "type" => DB_COLUMN_STRING,"length"=>100000,"notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "_lastmodified", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
  $this->columns[] = array("name" => "is_main", "type" => DB_COLUMN_NUMERIC,"length"=>1,"notnull"=>0,"dtype"=>"int");
  $this->columns[] = array("name" => "emails", "type" => DB_COLUMN_STRING,"length"=>100000,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "content_type", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "encoding", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");

  parent::prepareColumns();

 }


 /**
 * Method returns list of departments with assosiated subjects for each department
 * @access  public
 ***/
 function GetDepartmentSubjects(){
    $SQL = sprintf("SELECT d.*
                    FROM %s as d, %s as s, %s as ds
                    WHERE d.active=1
                      AND s.active=1
                      AND d.department_id = ds.department_id
                      AND s.subject_id = ds.subject_id
                    GROUP BY d.department_id
                    ORDER BY d._priority

                    ",
                    $this->defaultTableName,
                    $this->getTable("SubjectsTable"),
                    $this->getTable("DepartmentSubjectsRelationTable")

    );
    $_reader = $this->Connection->ExecuteReader($SQL);
    $_departments = array();
    for($i=0; $i<$_reader->RecordCount; $i++){
        $_tmp = $_reader->Read();
        $_departments[] = $_tmp;

    }
    return $_departments;
 }

}

?>