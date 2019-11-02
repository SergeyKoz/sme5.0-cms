<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** Banner pages relation storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerPagesTable extends AbstractTable   {
  var $ClassName = "BannerPagesTable";
  var $Version = "1.0";


 function prepareColumns() {
	$this->columns[] = array("name" => "banner_id",         	   "type" => DB_COLUMN_NUMERIC);
	$this->columns[] = array("name" => "page_id",         	     "type" => DB_COLUMN_NUMERIC);
	parent::prepareColumns();
 }

	function OnBeforeInsert(&$data) {
		BannerPagesTable::PrepareIdFields($data);
		parent::OnBeforeInsert($data);
	}

	 function DeleteByKey (&$data) {
	 	BannerPagesTable::PrepareIdFields($data);
	 	parent::DeleteByKey($data);
	 }

	function GetCount($data = null, $table_alias = "", $raw_sql = array()){
		BannerPagesTable::PrepareIdFields($data);
		return parent::GetCount($data, $table_alias, $raw_sql);
	}

	function &GetList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
	 	BannerPagesTable::PrepareIdFields($data);
		return parent::GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
	}

	function PrepareIdFields(&$data){
        if (in_array("id", array_keys($data))){
	 		$data["page_id"]=$data["id"];
	 		unset($data["id"]);
	 	}
	}

} //--end of class
?>