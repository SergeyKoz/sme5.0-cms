<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");
//$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Polls storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Polls
 * @access public
 */
class PollsPagesRelationsTable extends ProjectTable
{
  var $ClassName = "PollsPagesRelationsTable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function prepareColumns() {
  $this->columns[] = array("name" => "poll_id", "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "page_id", "type" => DB_COLUMN_NUMERIC);
}

}

?>