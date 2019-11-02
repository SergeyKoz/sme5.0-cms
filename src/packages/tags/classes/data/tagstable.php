<?php
$this->ImportClass("data.projecttable", "ProjectTable");
/** Parameters storage class
 * @author Artem MIkhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class TagsTable extends ProjectTable{
	var $ClassName = "TagsTable";
	var $Version = "1.0";
	var $autocomplete_enable=true;
	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string	$TableName	Table name
	* @access	public
	*/
	function TagsTable(&$Connection, $TableName) {
		ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns() {
		parent::prepareColumns();
		$this->columns[] = array("name" => "tag_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "tag_%s", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "tag_type", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
		$this->columns[] = array("name" => "tag_code", "type" => DB_COLUMN_STRING,"length"=>255,"dtype"=>"string");
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

	function makeWeightedList($data, $numericalSeries){
        $minQty = PHP_INT_MAX;
        $maxQty = 0;
        if (is_object($data)) {
        $items = array();
            while ($item = $data->Read()) {
                $items[] = $item;
	            $minQty = min($minQty, (int)$item['qty']);
	            $maxQty = max($maxQty, (int)$item['qty']);
            }
	    } else {
	    	$items = $data;
	        foreach ($items as $item) {
	            $minQty = min($minQty, (int)$item['qty']);
	            $maxQty = max($maxQty, (int)$item['qty']);
	        }
	    }

	    $k = ($maxQty-$minQty == 0) ? 0 : (count($numericalSeries)-1)/($maxQty-$minQty);
	    foreach ($items as $index => $item) {
	        $items[$index]['weightVal'] = $numericalSeries[round(((int)$item['qty']-$minQty)*$k)];
	    }
	    return $items;
    }

	function GetTagsPageCount($data){
        $l=$this->Connection->Kernel->Language;
        $this->tg=$this->Connection->EscapeString($data["tag"]);
		$SQL=sprintf("	SELECT count(*) as cnt
						FROM %s AS ti
						JOIN %s As t ON (ti.item_code=t.tag_code)
						WHERE tag_%s='%s'",
						$this->GetTable("TagsItemsTable"), $this->defaultTableName,
						$l, $this->tg);

		$record=$this->Connection->ExecuteScalar($SQL);
		return $record["cnt"];
	}

	function GetTagsPageList($start = null, $rpp = null, $orders = ""){
		$l=$this->Connection->Kernel->Language;
		$SQL=sprintf("	SELECT ti.item_id, ti.caption, ti.description, ti.entry, ti.item_date, ti.item_type
						FROM %s AS ti
						JOIN %s As t ON (ti.item_code=t.tag_code)
						WHERE tag_%s='%s' AND language='%s'
						ORDER BY item_date DESC
						%s",
						$this->GetTable("TagsItemsTable"), $this->defaultTableName,
						$l, $this->tg, $l, ($start>0 || $rpp>0 ? "LIMIT ".$start.", ".$rpp : ""));


		$list=$relaton_table=array();
		$reader=$this->Connection->ExecuteReader($SQL);
		for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();
			$record["item_date"] = Component::dateconv($record["item_date"], false);
			$list[$record["item_id"]]=$record;
			$relaton_table[]="SELECT '".$record["item_id"].$record["item_type"]."' AS code ";
		}
		if (!empty($relaton_table)){
			$relaton_table="(".implode(" UNION ", $relaton_table).")";

			$SQL=sprintf("	SELECT t.item_id AS id, t.tag_%s AS tag
							FROM %s AS t JOIN %s AS r ON (t.tag_code=r.code)
	        				WHERE tag_%s!='' AND tag_%s!='%s' ORDER BY t.item_id, t.tag_%s",
	        				$l, $this->GetTable("TagsTable"),
							$relaton_table, $l, $l, $this->tg, $l, $l);
	        $this->ListItemsTags=array();
		    $reader=$this->Connection->ExecuteReader($SQL);
			for ($i=0; $i<$reader->RecordCount; $i++){
		       	$record=$reader->read();
		       	$this->ListItemsTags[$record["id"]][]=array("tag"=>$record["tag"], "tag_decode"=>urlencode($record["tag"]));
		    }
	    }
        return $list;
	}

	function RenewTagInformation(){
	 	$filename = $this->Connection->Kernel->Settings->GetItem ( "Module", "SitePath" )."CACHE/tags";
		if (!CACHE::hasValidCache ($filename, 3600*24, true)){
			$packages=array_keys($this->Connection->Kernel->Settings->GetSection("PACKAGES"));
			$tagsItemsStorage = DataFactory::GetStorage($this->Connection->Kernel->Page, "TagsItemsTable", "", false, "tags");
			$sql=sprintf("DELETE FROM %s", $this->GetTable("TagsItemsTable"));
	    	$this->Connection->ExecuteNonQuery($sql);

			foreach ($packages as $package){
	             $HelperClassName=ucfirst($package)."TagsHelper";
	             $currenTpackage = Engine::GetPackage($this->Connection->Kernel, $package);
	             $currenTpackage->setDirs();
	             if (file_exists(Path::buildPathString(strtolower($HelperClassName), $currenTpackage->ClassesDirs, $this->Connection->Kernel->ClassExt))){
	             	$this->Connection->Kernel->ImportClass(strtolower($HelperClassName), $HelperClassName, $package);
	             	$tagsHelper = new $HelperClassName;
	                $tagsHelper->RenewTagsItemsInformation($this, $tagsItemsStorage);
	             }
			}

        	$ls=$this->Connection->Kernel->Languages;
            $tagsData=array();
        	foreach ($ls as $l){
             	$query = sprintf("	SELECT t.tag_%s AS caption, COUNT(t.tag_%s) AS qty
						            FROM %s AS t JOIN %s AS ti ON (ti.item_code=t.tag_code) WHERE t.tag_%s!=''
						            GROUP BY t.tag_%s
						            ORDER BY t.tag_%s",
						            $l, $l, $this->defaultTableName, $this->GetTable("TagsItemsTable"), $l, $l, $l);
	            $reader=$this->Connection->ExecuteReader($query);
	            $tagsData[$l] = $this->makeWeightedList($reader, range(1, 5));
            }
			CACHE::RenewCache ($filename, $tagsData, true);
		}
	}

	function OnBeforeInsert(&$data){
		$data["tag_code"]=$data["item_id"].$data["tag_type"];
		parent::OnBeforeInsert($data);
	}




} //--end of class

?>