<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Sites storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Feedback
 * @access public
 */
class SubjectsTable extends ProjectTable
{
  var $ClassName = "SubjectsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SubjectsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {

  $this->columns[] = array("name" => "subject_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "subject_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "internal_subject", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
  $this->columns[] = array("name" => "_lastmodified", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
  parent::prepareColumns();

 }

 /**
 * Method returns reader with selected subjects for specified department
 * @param   int $department_id  Department ID
 * @return  MySQLReader Reader Object
 * @access  public
 **/
 function GetDepartmentSubjects($department_id){
    $SQL = sprintf("SELECT s.*
                    FROM %s as s, %s as ds
                    WHERE s.active = 1
                        AND s.subject_id =  ds.subject_id
                        AND ds.department_id = %d
                    ORDER BY s._priority
                   ", $this->defaultTableName,
                    $this->GetTable("DepartmentSubjectsRelationTable"),
                    $department_id
                    );
    return $this->Connection->ExecuteReader($SQL);

 }


}

?>