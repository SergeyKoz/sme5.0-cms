<?php
$this->ImportClass("data.projecttable", "ProjectTable");

/** Publications storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class PublicationsTable extends ProjectTable{
    var $ClassName = "PublicationsTable";
    var $Version = "1.0";
    var $old_sql = 2;

    /**
     * Class constructor
     * @param  MySqlConnection   $Connection Connection object
     * @param  string    $TableName  Table name
     * @access   public
     */
    function PublicationsTable(&$Connection, $TableName){
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns (){
        $this->columns[] = array(
            "name" => "publication_id" ,
            "type" => DB_COLUMN_NUMERIC ,
            "key" => true ,
            "incremental" => true
        );
        $this->columns[] = array(
            "name" => "parent_id" ,
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "copy_of_id" ,
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "template_id" ,
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "template_id_preset" ,
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "caption" ,
            "type" => DB_COLUMN_STRING ,
            "length" => 200 ,
            "notnull" => 1
        );
        $this->columns[] = array(
            "name" => "system",
            "type" => DB_COLUMN_STRING,
            "length" => 255,
        );
        $this->columns[] = array(
            "name" => "xsl_template" ,
            "type" => DB_COLUMN_STRING ,
            "length" => 255 ,
            "notnull" => 0
        );
        $this->columns[] = array(
            "name" => "include_template" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "target_entry_point" ,
            "type" => DB_COLUMN_NUMERIC ,
            "length" => 255 ,
            "notnull" => 1 ,
            "dtype" => "int"
        );
        $this->columns[] = array(
            "name" => "is_priveledged" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "disable_comments" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "_sort_caption_%s" ,
            "type" => DB_COLUMN_STRING ,
            "notnull" => 0
        );
        $this->columns[] = array(
            "name" => "_sort_date" ,
            "type" => DB_COLUMN_STRING ,
            "notnull" => 0
        );
        $this->columns[] = array(
            "name" => "active_%s" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "is_modified" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "is_declined" ,
            "type" => DB_COLUMN_NUMERIC ,
            "dtype" => "int" ,
            "notnull" => 0 ,
            "length" => 1
        );
        $this->columns[] = array(
            "name" => "memo" ,
            "type" => DB_COLUMN_STRING ,
            "length" => 10000 ,
            "notnull" => 0 ,
            "dtype" => "string"
        );

        $this->columns[] = array(
            "name" => "meta_title_%s" ,
            "type" => DB_COLUMN_STRING ,
            "notnull" => 0
        );
        $this->columns[] = array(
            "name" => "meta_keywords_%s" ,
            "type" => DB_COLUMN_STRING ,
            "notnull" => 0
        );
        $this->columns[] = array(
            "name" => "meta_description_%s" ,
            "type" => DB_COLUMN_STRING ,
            "notnull" => 0
        );
        parent::prepareColumns();
    }

    /**
     * Method gets only categories tree from publications
     * @access  public
     * @return  MySQLReader   Reader object
     **/
    function GetCategoriesTree (){
        // preparing SQL to get categories tree
        $SQL = sprintf("SELECT p.*
                     FROM %s as p, %s as t
                     WHERE p.template_id=t.template_id
                       AND t.is_category=1
                     ORDER BY p._sort_caption_%s
                     ", $this->defaultTableName, $this->getTable("TemplatesTable"), $this->Connection->Kernel->Language);
        return $this->Connection->ExecuteReader($SQL);
    }

    /**
     * Method gets a records from DB matching data  by limitcount and limitoffset
     * @param       array    $data        Array with data
     * @param       array    $orders      Array with orders
     * @param       int      $limitCount  Number of records to retrieve
     * @param       int      $limitoffset Offset of records to retrieve
     * @param             array      $ids                 Array of key fields values
     * @param       string   $table_alias         aliased table name
     * @param       array    $raw_sql         Array with additional sql-code for select, from, where, group_by, order_by and limit clauses
                                            $raw_sql = array(["select"=> string,]
                                                             ["from"=> string,]
                                                             ["where"=> string,]
                                                             ["group_by"=> string,]
                                                             ["order_by"=> string,]
                                                             ["limit"=> string,]
                                                             ["filter" =>string]
                                                            );

     * @return      array    DataReader object
     * @access      public
     **/
    function &GetEditorList ($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array())
    {
        $raw_sql["where"] = sprintf(" ((_created_by = %s AND is_modified = 1) OR (is_modified = 0)) ", $this->Connection->Kernel->Page->Auth->UserId);
        return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);

    }

    /**
     * Method gets count of DB-records matching data conditions
     * @param       array    $data      Array with data
     * @param       string   $table_alias         aliased table name
     * @param       array    $raw_sql         Array with additional sql-code for select, from, where, group_by, order_by and limit clauses
                                            $raw_sql = array(["select"=> string,]
                                                             ["from"=> string,]
                                                             ["where"=> string,]
                                                             ["group_by"=> string,]
                                                             ["order_by"=> string,]
                                                             ["limit"=> string,]
                                                             ["filter"=> string]
                                                            );

     * @return      int      Number of records matching request
     * @access      public
     **/
    function GetEditorCount ($data = null, $table_alias = "", $raw_sql = array()){
        $raw_sql["where"] = sprintf(" ((_created_by = %s AND is_modified = 1) OR (is_modified = 0)) ", $this->Connection->Kernel->Page->Auth->UserId);
        return $this->GetCount($data, $table_alias, $raw_sql);
    }

    /**
     * Method gets a records from DB matching data  by limitcount and limitoffset
     * @param       array    $data        Array with data
     * @param       array    $orders      Array with orders
     * @param       int      $limitCount  Number of records to retrieve
     * @param       int      $limitoffset Offset of records to retrieve
     * @param             array      $ids                 Array of key fields values
     * @param       string   $table_alias         aliased table name
     * @param       array    $raw_sql         Array with additional sql-code for select, from, where, group_by, order_by and limit clauses
                                            $raw_sql = array(["select"=> string,]
                                                             ["from"=> string,]
                                                             ["where"=> string,]
                                                             ["group_by"=> string,]
                                                             ["order_by"=> string,]
                                                             ["limit"=> string,]
                                                             ["filter" =>string]
                                                            );

     * @return      array    DataReader object
     * @access      public
     **/
    function &GetModifiedEditorList ($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
        $raw_sql["where"] = sprintf(" _created_by = %s ", $this->Connection->Kernel->Page->Auth->UserId);
        return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }

    /**
     * Method gets count of DB-records matching data conditions
     * @param       array    $data      Array with data
     * @param       string   $table_alias         aliased table name
     * @param       array    $raw_sql         Array with additional sql-code for select, from, where, group_by, order_by and limit clauses
                                            $raw_sql = array(["select"=> string,]
                                                             ["from"=> string,]
                                                             ["where"=> string,]
                                                             ["group_by"=> string,]
                                                             ["order_by"=> string,]
                                                             ["limit"=> string,]
                                                             ["filter"=> string]
                                                            );

     * @return      int      Number of records matching request
     * @access      public
     **/
    function GetModifiedEditorCount ($data = null, $table_alias = "", $raw_sql = array()){
        $raw_sql["where"] = sprintf(" _created_by = %s ", $this->Connection->Kernel->Page->Auth->UserId);
        return $this->GetCount($data, $table_alias, $raw_sql);
    }

    /**
     * Method executes after GroupDelete (prototype)

     * @param       string   $in_field    Name of field used in IN() clause
     * @param       array    $in_data        Array with data in IN() clause
     * @access      public
     * @abstract
     **/
    function OnAfterGroupDelete ($in_field, $in_data){
        $publication_parameters_Storage = DataFactory::GetStorage($this->Connection->Kernel->Page, "PublicationParamsTable");
        $publication_parameters_Storage->GroupDelete($in_field, $in_data);
        if (! empty($in_data)){
            $SQL = sprintf("DELETE FROM %s, %s
                                USING %s, %s
                                WHERE %s.copy_of_id IN (%s)
                                AND %s.publication_id = %s.publication_id", $this->defaultTableName, $this->GetTable("PublicationParamsTable"), $this->defaultTableName, $this->GetTable("PublicationParamsTable"), $this->defaultTableName, implode(", ", $in_data), $this->defaultTableName, $this->GetTable("PublicationParamsTable"));
            $this->Connection->ExecuteNonQuery($SQL);
        }
    }

    /**
     * Method executes some actions after delete (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnAfterDelete (&$data){
        $publication_parameters_Storage = DataFactory::GetStorage($this->Connection->Kernel->Page, "PublicationParamsTable");
        $publication_parameters_Storage->Delete($data);

        $SQL = sprintf("DELETE FROM %s, %s
                        WHERE %s.copy_of_id = %d
                        AND %s.publication_id = %s.publication_id", $this->defaultTableName, $this->GetTable("PublicationParamsTable"), $this->defaultTableName, $data["publication_id"], $this->defaultTableName, $this->GetTable("PublicationParamsTable"));
        $this->Connection->ExecuteNonQuery($SQL);
    }

    /**
     * Method gets Count of publications for short list
     * @param    int      $_mapping   Maping Data
     * @param    bool      $_categories   Extract categories or not
     * @access   public
     * @return   array   Array of publications
     **/
    function GetPublicationsShortListCount ($_mapping, $_categories = true){
        $l=$this->Connection->Kernel->Language;
    	$tags=$_mapping["tags"];

        if (count($tags))
        	$tags_condition=sprintf(	" JOIN (	SELECT tg.item_id, tg.tag_%s FROM %s AS tg JOIN (%s) ttg ON (ttg.tag_%s=tg.tag_%s) WHERE tg.tag_type='publication' GROUP BY tg.item_id ) AS tg ON (p.publication_id=tg.item_id)",
         							$l, $this->GetTable("TagsTable"), "SELECT '".implode("' AS tag_".$l." UNION SELECT '", $tags)."' AS tag_".$l, $l, $l);
        if ($_mapping["tag"]!="")
        	$tags_condition.=sprintf(" JOIN (SELECT item_id FROM %s WHERE tag_%s='%s' AND tag_type='publication' GROUP BY item_id) AS tp ON (tp.item_id=p.publication_id)",
        							$this->GetTable("TagsTable"), $l, $_mapping["tag"]);

        $order_field_idx = $_mapping["sort_field"];
        $SQL = sprintf("SELECT count(*) as counter
                        FROM %s as p %s, %s as t

                        WHERE p.parent_id = %d
                          AND p.template_id=t.template_id
                          AND p.active_%s=1
                          AND t.active=1
                          AND p.is_modified = 0
                          AND p.copy_of_id = 0
                          " . "AND t.is_category = %d
                          " . "
                          %s
                        LIMIT 0, 1
                       ", $this->defaultTableName,
        				$tags_condition, $this->GetTable("TemplatesTable"),
        				$_mapping["publication_id"], $l,
        				($_categories ? 1 : 0),
        				($_mapping["priveledged_only"] == 1 ? " AND p.is_priveledged = 1" : ""));
        $_tmp = $this->Connection->ExecuteScalar($SQL);

        // limiting count according to list settings
        $_start_index = ($_mapping["start_index"] < 0 ? 0 : (int) $_mapping["start_index"]);
        $_end_index = ($_mapping["end_index"] < 0 ? 0 : (int) $_mapping["end_index"]);
        if ($_end_index < $_start_index) {
            $_end_index = 0;
        }
        if (($_end_index < $_tmp["counter"]) && ($_end_index != 0)) {
            $_tmp["counter"] = $_end_index;
        }
        return $_tmp["counter"];
    }

    /**
     * Method gets list of publications for short list
     * @param    int      $_mapping   Maping Data
     * @param    bool      $_categories   Extract categories or not
     * @access   public
     * @return   array   Array of publications
     **/
    function GetPublicationsShortList ($_mapping, $_categories = true){
    	$l=$this->Connection->Kernel->Language;
        $order_field_idx = $_mapping["sort_field"];
        $order_direction_idx = $_mapping["sort_order"];
        //Getting starting and ending indexes
        $_start_index = ($_mapping["start_index"] < 0 ? 0 : (int) $_mapping["start_index"]);
        $_end_index = ($_mapping["end_index"] < 0 ? 0 : (int) $_mapping["end_index"]);
        if ($_end_index < $_start_index) {
            $_end_index = 0;
        }

        // Records per page and starting page
        $_rpp = $_mapping["records_per_page"];
        //echo pr(Page());
        $start_array = Page()->Request->Value("start", REQUEST_QUERYSTRING, false);

        $_start = 0;
        if (isset($start_array[$_mapping["mapping_id"]])) {
            if ($start_array[$_mapping["mapping_id"]] >= 0) {
                $_start = $start_array[$_mapping["mapping_id"]];
            }
        }

        $limit_offset = $_start_index + ($_rpp * $_start);
        if ($_rpp > 0) {
            $limit_count = $_rpp;
        } else {
            $limit_count = $_end_index;
        }

        // Adjusting limit count and offset
        if ($_end_index > 0) {
            $max_position = $limit_offset + $limit_count;

            // if last element out of end_inder range
            if ($max_position > $_end_index) {
                // calculating difference
                $differ = $max_position - $_end_index;

                // If difference less than limit_count - only 1 page out of bounds
                if ($differ <= $limit_count) {
                    // normalizing limit value
                    $limit_count = $limit_count - $differ;
                } else {
                    // if more than 1 page out of bounds - reseting start index value
                    $limit_offset = $_start_index;
                    // if last element out of bounds
                    if (($limit_offset + $limit_count) > $_end_index) {
                        // adjusting limit count again
                        $limit_count = $_end_index - $limit_offset;
                    }
                }
            }
        }
        // Building limit clause
        $_limit_clause = ($limit_count > 0 ? "LIMIT " . $limit_offset . ", " . $limit_count : "");

        switch ($order_field_idx) {
            case 1:
                $_field = "p._sort_date";
                break;
            case 0:
                $_field = "p._sort_caption_".$l;
                break;
            case 2:
                $_field = "p._priority";
                break;
            case 3:
                $_field = "RAND()";
                break;
            default:
                $_field = "p._priority";
                break;
        }

        $tags=$_mapping["tags"];
		if (count($tags))
        	$tags_condition=sprintf(	" JOIN (	SELECT tg.item_id, tg.tag_%s FROM %s AS tg JOIN (%s) ttg ON (ttg.tag_%s=tg.tag_%s) WHERE tg.tag_type='publication' GROUP BY tg.item_id ) AS tg ON (p.publication_id=tg.item_id)",
         							$l, $this->GetTable("TagsTable"), "SELECT '".implode("' AS tag_".$l." UNION SELECT '", $tags)."' AS tag_".$l, $l, $l);
        if ($_mapping["tag"]!="")
        	$tags_condition.=sprintf(" JOIN (SELECT item_id FROM %s WHERE tag_%s='%s' AND tag_type='publication' GROUP BY item_id) AS tp ON (tp.item_id=p.publication_id)",
        							$this->GetTable("TagsTable"), $l, $_mapping["tag"]);

        $SQL = sprintf("SELECT p.*, t.is_category as is_category,
                        c.path
                        FROM %s as t,
                        %s as p
                        LEFT JOIN %s as c ON (p.target_entry_point = c.id)
                        %s
                        WHERE p.parent_id = %d
                          AND p.template_id=t.template_id
                          AND p.active_%s=1
                          AND t.active=1
                          AND p.is_modified = 0
                          AND p.copy_of_id = 0
                          " . "AND t.is_category = %d
                          " . "
                          %s
                        ORDER BY %s %s
                        %s",
        			$this->GetTable("TemplatesTable"), $this->defaultTableName,
        			$this->GetTable("ContentTable"), $tags_condition,
        			$_mapping["publication_id"],
        			$this->Connection->Kernel->Language,
        			($_categories ? 1 : 0),
        			($_mapping["priveledged_only"] == 1 ? " AND p.is_priveledged = 1" : ""),
        			$_field,
        			($order_direction_idx == 1 ? "DESC" : ""),
        			$_limit_clause);
        return $this->Connection->ExecuteReader($SQL);
    }

    /**
     * Method gets list of publications for search
     * @param    $pub_id_str, $keys_words, $lang_act, $template_is_category   data for query
     * @param    bool      $_categories   Extract categories or not
     * @access   public
     * @return   array   Array of publications
     **/
    function GetPublicationIDSearch ($pub_id_str, $key_words, $lang_act, $template_is_category)
    {
        $template_is_category = implode(",", $template_is_category);
        $lang = "";
        if (! empty($lang_act)) {
            for ($i = 0; $i < count($lang_act); $i ++) {
                if ($i != 0) {
                    $lang = $lang . "OR active_" . $lang_act[$i] . "=1 ";
                }
                if ($i == 0) {
                    $lang = "active_" . $lang_act[$i] . "=1 ";
                }
            }
            $lang = "AND (" . $lang . ")";
        }
        for ($i = 0; $i < sizeof($this->Connection->Kernel->Languages); $i ++) {
            if ($i != 0) {
                $capt = $capt . ", _sort_caption_" . $this->Connection->Kernel->Languages[$i];
            }
            if ($i == 0) {
                $capt = "_sort_caption_" . $this->Connection->Kernel->Languages[$i];
            }
        }
        $SQL = sprintf("SELECT publication_id
                        FROM %s
                        WHERE publication_id IN (%s)
                        AND template_id NOT IN (%s)
                        AND is_modified = 0
                        AND copy_of_id = 0
                        %s
                        %s
                        ORDER BY _sort_date DESC
                       ", $this->defaultTableName, $pub_id_str, $template_is_category, ($key_words != "" ? sprintf("AND MATCH (%s) AGAINST ('%s')", $capt, $key_words) : ""), $lang);
        return $this->Connection->ExecuteReader($SQL);
    }

    /**
     * Method Approves specified publication
     * @param    int     $id     Publication ID to approve
     * @access   public
     **/
    function ApprovePublication ($id)
    {
        $_tmp = $this->Get(array(
            "publication_id" => $id
        ));
        if (! empty($_tmp)) {
            $copy_of = $_tmp["copy_of_id"];
            $publication_id = $_tmp["publication_id"];
            if ($copy_of > 0) {
                $_tmp["publication_id"] = $copy_of;
                $_tmp["copy_of_id"] = 0;
                $_tmp["is_modified"] = 0;
                $_tmp["is_declined"] = 0;
                $_tmp["memo"] = "";
                unset($_tmp["_created_by"]);
                $this->Update($_tmp);

                $SQL = sprintf("DELETE  FROM %s WHERE publication_id = %d", $this->GetTable("PublicationParamsTable"), $copy_of);
                $this->Connection->ExecuteNonQuery($SQL);

                $SQL = sprintf("UPDATE %s SET publication_id = %d WHERE publication_id = %d", $this->GetTable("PublicationParamsTable"), $copy_of, $publication_id);
                $this->Connection->ExecuteNonQuery($SQL);
                $delete_data = array(
                    "publication_id" => $publication_id
                );
                $this->Delete($delete_data);

            } else {
                $_tmp["copy_of_id"] = 0;
                $_tmp["is_modified"] = 0;
                $_tmp["is_declined"] = 0;
                $_tmp["memo"] = "";
                $this->Update($_tmp);
            }
        }
    }

    /**
     * Method Approves specified publication
     * @param    int     $id     Publication ID to approve
     * @access   public
     **/
    function DeclinePublication ($id, $reason = "")
    {
        $SQL = sprintf("UPDATE %s SET
                        memo = CONCAT(memo, '\\n%s'),
                        is_declined = 1
                        WHERE publication_id = %d
                        ", $this->defaultTableName, $reason, $id);
        $this->Connection->ExecuteNonQuery($SQL);
    }

    /**
     * Method processes custom field for copyed publications
     * @param    array    $field     Field description array
     * @param    array    $row       Array with row data
     * @access public
     **/
    function GetOriginaPublication ($field, &$row){
        if (($row["is_modified"] == 1) && ($row["copy_of_id"] > 0)) {
            $_tmp = $this->Get(array(
                "publication_id" => $row["copy_of_id"]
            ));
            $row["_sort_caption_" . $this->Connection->Kernel->Language] .= "<br>( " . $_tmp["_sort_caption_" . $this->Connection->Kernel->Language] . " )";
        }
    }

    function GetPublicationTreeForSelectBaseMapping($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){

		$pids=$mids=$cids=array();

        $_raw_sql=array("select"=>"publication_id, parent_id");
		$reader=$this->GetList(null, null, null, null, null, "", $_raw_sql);
	  	for($i=0; $i<$reader->RecordCount; $i++){
	   		$record=$reader->read();
	   		$pids[]=$record;
	   	}

		$mappingsStorage = DataFactory::GetStorage($this->Connection->Kernel->Page, "MappingTable", "", false, "publications");
		$_raw_sql=array("select"=>"mapping_id, publication_id", "where"=>"page_id>0", "group_by"=>"GROUP BY publication_id");
		$reader=$mappingsStorage->GetList(null, null, null, null, null, "", $_raw_sql);
	  	for($i=0; $i<$reader->RecordCount; $i++){
	   		$record=$reader->read();
	   		$nodelist=array();
			AbstractTable::BuildTreeFromBottom($pids, $record["publication_id"], "publication_id", "parent_id", $nodelist);
            $cids=array_merge($cids, array_keys($nodelist));
	   	}
	   	$cids=array_unique($cids);
	   	$data["publication_id"]=$cids;
		$Reader=$this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
		return $Reader;
	}

} //--end of class
?>