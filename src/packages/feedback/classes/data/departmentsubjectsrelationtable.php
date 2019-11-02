<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Sites storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Feedback
 * @access public
 */
class DepartmentSubjectsRelationTable extends ProjectTable
{
  var $ClassName = "DepartmentSubjectsRelationTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function DepartmentSubjectsRelationTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
  $this->columns[] = array("name" => "department_id", "type" => DB_COLUMN_NUMERIC );
  $this->columns[] = array("name" => "subject_id", "type" => DB_COLUMN_NUMERIC );

 }


}

?>