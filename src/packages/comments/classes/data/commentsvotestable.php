<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Banner groups storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Comments
 * @subpackage classes.data
 * @access public
 */
class CommentsVotesTable extends ProjectTable   {
  var $ClassName = "CommentsVotesTable";
  var $Version = "1.0";

/**
  * Class constructor
  * @param  MySqlConnection   $Connection Connection object
  * @param  string  $TableName  Table name
  * @access public
  **/
	function CommentsVotesTable(&$Connection, $TableName) {
	    ProjectTable::ProjectTable($Connection, $TableName);
	}


	function prepareColumns() {
		$this->columns[] = array("name" => "vote_id",  "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "comment_id",  "type" => DB_COLUMN_NUMERIC);
		$this->columns[] = array("name" => "user_id",  "type" => DB_COLUMN_NUMERIC);
		$this->columns[] = array("name" => "vote",  "type" => DB_COLUMN_NUMERIC);
		parent::prepareColumns();
	}

	function &GetCommentsVotesAdminList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
        $table_alias="c.";
        $user="(SELECT u.user_login FROM ".$this->getTable("UsersTable")." AS u WHERE u.user_id=c.user_id) as user";
        $raw_sql["select"]="c.*, ".$user;
		return parent::GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }

} //--end of class

?>