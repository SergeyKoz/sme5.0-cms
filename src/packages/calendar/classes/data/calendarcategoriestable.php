<?php
  $this->ImportClass("module.data.projecttable", "ProjectTable");

/** Catalog categories storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 1.0
 * @package JA
 * @subpackage classes.data
 * @access public
 */
class CalendarCategoriesTable extends ProjectTable
{
    var $ClassName = "CalendarCategoriesTable";
    var $Version = "1.0";

    var $UpdateCacheStarted = false;

    function CalendarCategoriesTable(&$Connection, $TableName) {
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns() {
        $this->columns[] = array("name" => "category_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "system", "type" => DB_COLUMN_STRING,"length"=>255);
        $this->columns[] = array("name" => "caption_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);

        parent::prepareColumns();
    }

} //--end of class

?>