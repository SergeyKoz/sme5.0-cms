<?php
$this->ImportClass("data.projecttable", "ProjectTable");
/** Parameters storage class
 * @author Artem MIkhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class PublicationsTagsTable extends ProjectTable{
	var $ClassName = "PublicationsTagsTable";
	var $Version = "1.0";
	var $autocomplete_enable=true;
	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string	$TableName	Table name
	* @access	public
	*/
	function PublicationsTagsTable(&$Connection, $TableName) {
		ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns() {
		parent::prepareColumns();
		$this->columns[] = array("name" => "tag_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "tag_%s", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "tag_type", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "item_id", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
	}

	function GetAutocompleteWords($word, $word_field_name){
		$res="";
		if ($word!=""){
	        $SQL=sprintf("SELECT %s AS word FROM %s WHERE
	                               %s LIKE '%s%%' GROUP BY %s ORDER BY %s",
								$word_field_name, $this->defaultTableName,
								$word_field_name, $word, $word_field_name, $word_field_name);
			$reader=$this->Connection->ExecuteReader($SQL);
			$tags=array();
			for ($i=0; $i<$reader->RecordCount; $i++){
				$record=$reader->read();
				$tags[]=$record["word"];
			}
			$res=implode("\n", $tags);
		}
		return $res;
	}


	function &GetAdminTagsList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
	 	$l=$this->Connection->Kernel->Language;
	 	$raw_sql["select"]="count(tag_id) AS tag_count, tag_".$l.", tag_id";
	 	$raw_sql["where"]=sprintf("tag_%s!=''", $l);
	 	$raw_sql["group_by"]=sprintf("GROUP BY tag_%s", $l);
		$ReturnReader=$this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
		return $ReturnReader;
	}

	function &GetAdminTagsCount($data = null, $table_alias="", $raw_sql=array()){
		$l=$this->Connection->Kernel->Language;
	 	$raw_sql["select"]="count(tag_id) AS tag_count";
	 	$raw_sql["where"]=sprintf("tag_%s!=''", $l);
	 	$raw_sql["group_by"]=sprintf("GROUP BY tag_%s", $l);
		$returnCount=$this->GetList($data, null, null, null, null, $table_alias, $raw_sql);
		return $returnCount->RecordCount;
	}

	function &GetTagsCount($item_id){
		$tag_field=sprintf("tag_%s", $this->Connection->Kernel->Language);
		$SQL=sprintf("SELECT count(tag_id) AS count FROM %s WHERE %s = (SELECT %s FROM %s WHERE tag_id=%d) GROUP BY %s",
						$this->defaultTableName, $tag_field, $tag_field, $this->defaultTableName, $item_id, $tag_field);
		$record=$this->Connection->ExecuteScalar($SQL);
	    return $record["count"];
	}

	function GetTagsItems($items_id, $exclude_item_id = false){
		$tag_field=sprintf("tag_%s", $this->Connection->Kernel->Language);
		$SQL=sprintf("	SELECT t.tag_id FROM %s AS t JOIN
						(SELECT %s FROM %s WHERE tag_id IN (%s)) AS tt ON (t.%s=tt.%s)
						GROUP BY t.tag_id",
						$this->defaultTableName, $tag_field, $this->defaultTableName,
						implode(", ", $items_id), $tag_field, $tag_field);

		$reader=$this->Connection->ExecuteReader($SQL);
		$items=array();
		for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();
			if (!($exclude_item_id && count($items_id)==1 && $items_id[0]==$record["tag_id"]))
	        	$items[]=$record["tag_id"];
	 	}
		return $items;
	}

	function GetPublicationsTags($publications_id, $id_field){

		$items=array();
        if (count($publications_id)){
			$tag_field=sprintf("tag_%s", $this->Connection->Kernel->Language);
			$SQL=sprintf("	SELECT tt.item_id, t.%s AS tag FROM %s AS t JOIN (%s) AS tt ON (t.item_id=tt.item_id) WHERE t.%s!='' AND t.tag_type='%s'",
							$tag_field, $this->defaultTableName,
							"SELECT ".implode(" AS item_id UNION SELECT ", $publications_id)." AS item_id",
							$tag_field, $id_field);

			$reader=$this->Connection->ExecuteReader($SQL);
			for ($i=0; $i<$reader->RecordCount; $i++){
				$record=$reader->read();
				$items[$record["item_id"]][]=$record["tag"];
		 	}
	 	}
		return $items;
	}

	function AddRelationColumn($RelationColumn){
		$f=false;
		foreach ($this->columns as $column)
			if ($column["name"]==$RelationColumn) $f=true;
		if (!$f) $this->columns[]=array("name"=>$RelationColumn, "type"=>1, "length"=>10);
	}



} //--end of class

?>