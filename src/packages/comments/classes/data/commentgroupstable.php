<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Banner groups storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class CommentGroupsTable extends ProjectTable   {
  var $ClassName = "CommentGroupsTable";
  var $Version = "1.0";

/**
  * Class constructor
  * @param  MySqlConnection   $Connection Connection object
  * @param  string	$TableName	Table name
  * @access	public
  **/
function CommentGroupsTable(&$Connection, $TableName) {
	ProjectTable::ProjectTable($Connection, $TableName);
}


    function prepareColumns()
    {
        parent::prepareColumns();
        $this->columns[] = array("name" => "id",  "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "group_id",  "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "group_name_%s", "type" => DB_COLUMN_STRING,   "length"=>255,      "notnull"=>1);
        $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC);

    }

    function GetEditGroupList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
       	$raw_sql["select"]="group_id AS id, group_name_".$this->Connection->Kernel->Language." AS group_name";
		return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }

    /*function GetAllGroups()
    {
        $SQL = sprintf("SELECT DISTINCT(comment_group_id) FROM %s WHERE active = 1", $this->defaultTableName);
        $_reader=$this->Connection->ExecuteReader($SQL);
        $__tmp = array();
        for($i=0; $i<$_reader->RecordCount; $i++){
            $_tmp = $_reader->Read();
            $__tmp[] = $_tmp["comment_group_id"];
        }
        return $__tmp;
    }

    function AddNewGroup($group_id, $group_name)
    {
        $group_name = addslashes($group_name);
        $SQL = "INSERT INTO {$this->defaultTableName}
          (comment_group_id, group_name, group_emails, group_send_emails, group_auto_publish, active)
          VALUES
          ($group_id, '$group_name', '', 0, 0, 1)";
        $this->Connection->ExecuteNonQuery($SQL);
        return true;
    }*/
} //--end of class

?>