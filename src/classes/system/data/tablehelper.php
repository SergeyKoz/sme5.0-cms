<?php
/** @const DB_COLUMN_NUMERIC Constant of numeric column type **/
define("DB_COLUMN_NUMERIC", 1);

/** @const DB_COLUMN_STRING Constant of string column type **/
define("DB_COLUMN_STRING", 2);

/** @const DB_COLUMNTYPE_TEXT Constant of text database column type **/
define("DB_COLUMNTYPE_TEXT", "text");

/** @const DB_COLUMNTYPE_LONGTEXT Constant of long text database column type **/
define("DB_COLUMNTYPE_LONGTEXT", "longtext");

/** @const DB_COLUMNTYPE_MEDIUMTEXT Constant of medium text database column type **/
define("DB_COLUMNTYPE_MEDIUMTEXT", "mediumtext");

/** @const DB_COLUMNTYPE_BLOB Constant of blob  database column type **/
define("DB_COLUMNTYPE_BLOB", "blob");

/** @const DB_COLUMNTYPE_MEDIUMBLOB Constant of medium blob database column type **/
define("DB_COLUMNTYPE_MEDIUMBLOB", "mediumblob");

/** @const DB_COLUMNTYPE_LONGBLOB Constant of long blob database column type **/
define("DB_COLUMNTYPE_LONGBLOB", "longblob");

/** @const DB_COLUMNTYPE_INTEGER Constant of integer database column type **/
define("DB_COLUMNTYPE_INTEGER", "int");

/** @const DB_COLUMNTYPE_LONGINTEGER Constant of integer database column type **/
define("DB_COLUMNTYPE_LONGINTEGER", "longint");

/** @const DB_COLUMNTYPE_TINYINTEGER Constant of tiny integer database column type **/
define("DB_COLUMNTYPE_TINYINTEGER", "tinyint");

/** @const DB_COLUMNTYPE_SHORTINTEGER Constant of short integer database column type **/
define("DB_COLUMNTYPE_SHORTINTEGER", "shortint");

/** @const DB_COLUMNTYPE_MEDIUMINTEGER Constant of medium integer database column type **/
define("DB_COLUMNTYPE_MEDIUMINTEGER", "mediumint");

/** @const DB_COLUMNTYPE_BIGINTEGER Constant of big integer database column type **/
define("DB_COLUMNTYPE_BIGINTEGER", "bigint");

/** @const DB_COLUMNTYPE_FLOAT Constant of float database column type **/
define("DB_COLUMNTYPE_FLOAT", "float");

/** @const DB_COLUMNTYPE_DOUBLE Constant of double database column type **/
define("DB_COLUMNTYPE_DOUBLE", "double");

/** @const DB_COLUMNTYPE_DATE Constant of date database column type **/
define("DB_COLUMNTYPE_DATE", "date");

/** @const DB_COLUMNTYPE_DATE Constant of datetime database column type **/
define("DB_COLUMNTYPE_DATETIME", "datetime");

/**
 * Abstract table helper class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.system.data
 * @access public
 * @static
 */
class TableHelper extends Component
{

    /**
     * Method create SQL constructions array for get list method
     * array structure
     *       0 => where clause
     *       1 => order clause
     *       2 => limit clause
     * @param       AbstractTable    $storage        Storage object
     * @param       array    $data        Array with data
     * @param       array    $orders      Array with orders
     * @param       int      $limitCount  Number of records to retrieve
     * @param       int      $limitoffset Offset of records to retrieve
     * @param           array        $ids                                 Array of key fields values
     * @param       string   $table_alias         aliased table name


     * @return      array    Array with SQL constructions
     * @access      public
     **/
    static function prepareGetListSQL($storage, $data = null, $orders = null, $limitCount = null,
        $limitOffset = null, $ids = null, $table_alias = "")
    {
        $whereClause = "";
        if (! is_null($data)) {
            foreach ($storage->columns as $column) {
                if (isset($data[$column["name"]])) {
                    if (strlen($whereClause))
                        $whereClause .= " AND ";
                    if (is_array($data[$column["name"]])) {
                        if (! empty($data[$column["name"]])) {
                            $implode_str = "";
                            foreach ($data[$column["name"]] as $value) {
                                $value = $value = AbstractTable::prepareColumnValue($column, $value);

                                ($implode_str != "" ? $implode_str .= "," . $value . "" : $implode_str .= "" . $value . "");
                            }
                            $whereClause .= $table_alias . $column["name"] . " IN (" . $implode_str . ") ";
                        }
                    }
                    else {
                        $value = AbstractTable::prepareColumnValue($column, $data[$column["name"]]);
                        if (strpos($value, "%") === false) {
                            $whereClause .= $table_alias . $column["name"] . "=" . $value;
                        }
                        else {
                            $whereClause .= $table_alias . $column["name"] . " LIKE (" . $value . ")";
                        }
                    }
                }
            }
        }
        //if have a ids array
        if ($ids !== null) {
            $keys = $storage->getKeyColumns();
            if (strlen($whereClause))
                $whereClause .= " AND ";
            $whereClause .= sprintf("%s IN (%s)", $table_alias . $keys[0]["name"], implode(",", $ids));
        }
        if (strlen($whereClause))
            $whereClause = " WHERE " . $whereClause;
        $orderClause = "";
        if (is_array($orders)) {
            $keys = array_keys($orders);
            foreach ($keys as $key) {
                if (strlen($orderClause)) {
                    $orderClause .= ", ";
                }
                $orderClause = $orderClause . $table_alias . $key . ($orders[$key] ? "" : " DESC");
            }
        }

        if (strlen($orderClause)) {
            $orderClause = " ORDER BY " . $orderClause;
        }
        $limitClause = "";
        if (! is_null($limitCount)) {
            if (! is_null($limitOffset)) {
                if ($limitOffset < 0) {
                    $limitOffset = 0;
                }
                //$limitClause = $limitOffset . ", ";
                $limitClause = " " . sprintf($storage->Connection->Syntax["LIMIT"], $limitOffset, $limitCount);
            }
        }
        return array(
            $whereClause,
            $orderClause,
            $limitClause
        );
    }

    /**
     * Method prepare count of DB-records SQL-where clause for storage object
     * @param       AbstractTable    $storage        Storage object
     * @param       array    $data      Array with data
     * @param       string   $table_alias         aliased table name
     * @return      string      where clause string
     * @access      public
     **/
    static function prepareGetCountSQL($storage, $data = null, $table_alias = "")
    {
        $whereClause = "";
        foreach ($storage->columns as $column) {
            if (isset($data[$column["name"]])) {
                if (strlen($whereClause))
                    $whereClause .= " AND ";
                if (is_array($data[$column["name"]])) {
                    if (! empty($data[$column["name"]])) {
                        $whereClause .= $table_alias . $column["name"] . " IN (" . implode(", ", $data[$column["name"]]) . ")";
                    }
                }
                else {
                    $value = AbstractTable::prepareColumnValue($column, $data[$column["name"]]);
                    if (strpos($value, "%") === false) {
                        $whereClause .= $table_alias . $column["name"] . "=" . $value;
                    }
                    else {
                        $whereClause .= $table_alias . $column["name"] . " LIKE (" . $value . ")";
                    }
                }
            }
        }
        if (strlen($whereClause))
            $whereClause = " WHERE " . $whereClause;
        return $whereClause;
    }

    /**
     * Method prepare SQL constructions for Get method of AbstractTable class
     * array structure
     *       0 => where clause
     *       1 => order clause
     * @param       AbstractTable    $storage        Storage object
     * @param       array    $data      Array with data
     * @param       array    $orders    Array with orders
     * @return      array    Array with SQL constructions
     * @access      public
     **/
    static function prepareGetSQL($storage, $data, $orders = null){
        $keyColumns = $storage->columns; //getKeyColumns();
        $orderClause = "";

        if (count($keyColumns)) {
            $storage->OnBeforeGet($data);
            $whereClause = "";
            foreach ($keyColumns as $keyColumn) {
                if (isset($data[$keyColumn["name"]])) {
                    if (strlen($whereClause))
                        $whereClause .= " AND ";
                    if (is_array($data[$keyColumn["name"]])) {
                        if (! empty($data[$keyColumn["name"]])) {
                            $whereClause .= $keyColumn["name"] . " IN (" . implode(", ", $data[$keyColumn["name"]]) . ")";
                        }
                    }
                    else {
                        $whereClause .= $keyColumn["name"] . "=" . AbstractTable::prepareColumnValue($keyColumn, $data[$keyColumn["name"]]);
                    }
                }
            }
            if (strlen($whereClause))
                $whereClause = " WHERE " . $whereClause;
            if (is_array($orders)) {

                $keys = array_keys($orders);
                foreach ($keys as $key) {

                    if (strlen($orderClause)) {
                        $orderClause .= ", ";
                    }
                    $orderClause = $orderClause . $key . ($orders[$key] ? "" : " DESC");
                }
            }
            if (strlen($orderClause)) {
                $orderClause = " ORDER BY " . $orderClause;
            }

        }
        return array(
            $whereClause,
            $orderClause
        );
    }

    /**
     * Methiod get storage (table) structure and set object columns definition
     * @param     AbstractTable  $storage         Storage object
     * @param     boolean        $empty           Clear columns definitions after (flag)
     * @param     boolean        $ignore_system   Ignore (not add) system fields (fields started with _ )
     * @access    public
     **/
    static function prepareColumnsDB(&$storage, $empty = true, $ignore_system = false)
    {
        //--if need empty table columns
        if ($empty === true) {
            $storage->clearColumns();
        }
        $reader = $storage->Connection->ExecuteReader('DESCRIBE ' . $storage->defaultTableName);
        if ($reader->RecordCount > 0) {
            while ($record = $reader->Read()) {
                $is_system_field = (substr($record["Field"], 0, 1) == "_" ? true : false);
                if ($ignore_system && $is_system_field) {
                    continue;
                }
                $storage->AddColumn(TableHelper::prepareColumnValueDB($record));
            }
        }
    }

    /**
     * Method create object column array definition
     * using column database definition (get by DESCRIBE SQL command)
     * @param   array   $record       column database definition
     * @return  array   $columnd      object column array definition
     * @access  private
     **/
    static function prepareColumnValueDB($record)
    {
//        $is_system_field = (substr($record["Field"], 0, 1) == "_" ? true : false);
        $column["name"] = $record["Field"];
        $column["notnull"] = $record["Null"] == "YES" ? 0 : 1;

        //--if record key
        if ($record["Key"] == "PRI")
            $column["key"] = true;

        //--if auotincrement
        if ($record["Extra"] == "auto_increment") {
            $column["incremental"] = true;
            $column["notnull"] = 0;
        }

        //--get type and length
        preg_match("/^(\w+)\((\d+)\) (\w+)$/", $record["Type"], $matches);
        list(,$type, $length, $extra) = $matches;
        $column["length"] = intval($length);

        if ($type == "int") {
            $column["type"] = DB_COLUMN_NUMERIC;
        }
        else {
            $column["type"] = DB_COLUMN_STRING;
        }

        // get validation type and type for non-standart types
        switch ($type) {
            //--int fields
            case DB_COLUMNTYPE_INTEGER:
            case DB_COLUMNTYPE_LONGINTEGER:
            case DB_COLUMNTYPE_TINYINTEGER:
            case DB_COLUMNTYPE_SHORTINTEGER:
            case DB_COLUMNTYPE_MEDIUMINTEGER:
            case DB_COLUMNTYPE_BIGINTEGER:
                $column["dtype"] = "int";
                break;
            //-- numbers with float points fields
            case DB_COLUMNTYPE_FLOAT:
            case DB_COLUMNTYPE_DOUBLE:
                $column["dtype"] = "float";
                break;
            //--text or binary fields
            case DB_COLUMNTYPE_TEXT:
            case DB_COLUMNTYPE_BLOB:
                $column["length"] = 65535;
                break;
            //--medium text or binary fields
            case DB_COLUMNTYPE_MEDIUMTEXT:
            case DB_COLUMNTYPE_MEDIUMBLOB:
                $column["length"] = 16777215;
                break;
            //--long text or binary fields
            case DB_COLUMNTYPE_LONGTEXT:
            case DB_COLUMNTYPE_LONGBLOB:
                $column["length"] = 4294967295;
                break;
            //--date field
            case DB_COLUMNTYPE_DATE:
                $column["length"] = 10;
                break;

            //--datetime field
            case DB_COLUMNTYPE_DATETIME:
                $column["length"] = 19;
                break;
            default:
                break;
        }

        return $column;
    }

    /**
     * Method returns array with all ID's of nested records relative to given root_id
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param  int     $root_id   ID of root record of a tree branch
     * @param  string  $parent_id_name   Name of parent holder field
     * @return array   Array with nested ID's
     * @access public
     **/
    static function GetNestedIDs(&$object, $root_id, $parent_id_name)
    {
        $nested_ids = array();
        $keycolumns = $object->getKeyColumns();
        $temp_roots = $root_id;
        do {

            $reader = $object->GetList(array(
                $parent_id_name => $temp_roots
            ));
            $temp_roots = array();
            for ($j = 0; $j < $reader->RecordCount; $j ++) {
                $tmp = $reader->read();
                $temp_roots[] = $tmp[$keycolumns[0]["name"]];
            }
            $nested_ids = array_merge($nested_ids, $temp_roots);
        } while (count($temp_roots));
        return $nested_ids;
    }

    /**
     * Method returns list of nodes that belongs to selected node
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param                array                 $raw_data                     Raw list of records
     * @param                int                              $node_id                           Current node ID
     * @param                string          $key_field_name     Name of key-field
     * @param     string                    $parent_id_name                Name of parent-link field
     * @param                array                    &$node_list         Final list of nodes
     * @access        public
     */

   static  function GetRecursiveNodeList(&$object, &$raw_data, $node_id, $key_field_name, $parent_id_name,&$node_list){
        if ($raw_data[$node_id]["_children"]){
		  	foreach($raw_data[$node_id]["_children"] as $i=>$node){
		  		$item=$node;
		  		unset($item["_children"]);
				$node_list[] = $item;
				TableHelper::GetRecursiveNodeList($object, $raw_data, $node[$key_field_name], $key_field_name, $parent_id_name, $node_list);
		  	}
		 }
	}

    /**
     * Method returns set of records that belongs to specified node in case of tree-data
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param                array              $data                             Data to get from DB
     * @param                 int                    $root_id               ID of node to search down
     * @param      string            $parent_id_name        Name of parent link
     * @param                array              $orders                         Orders array to sort get results
     * @param      string                   $get_method                           Get records list method
     * @return                array                List of found records
     * @access                public
     */

    static function GetTreeData(&$object, $data, $parent_id_name, $orders = null, $get_method = "GetList"){
        $node_list = array();
        $key = md5($parent_id_name . $get_method . $object->defaultTableName . pr(array($data,$orders)));
        global $TREE_DATA;
        if ($TREE_DATA[$key] == "") {
        	$key_columns = $object->getKeyColumns();

            $reader = $object->$get_method($data, $orders);

            if (is_object($reader)) {
                for ($i = 0; $i < $reader->RecordCount; $i ++) {
                    $record = $reader->Read();
                    $tree[$record[$key_columns[0]["name"]]] = $record;
                }
            } else {
                $tree = $reader;
            }

            if (is_array($tree)){
	            foreach ($tree as $id => $node){
					$tree[$node[$parent_id_name]]['_children'][$id] =&$tree[$id];
				}
			}

            $TREE_DATA[$key] = $tree;
        }

        if (is_array($TREE_DATA[$key])){
       		$node_list=$TREE_DATA[$key];
       	}
        return $node_list;
    }

    /**
     * Method returns node level of defined record
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param                 int                $root_id            ID of node to search down
     * @param      string         $parent_id_name     Name of parent link
     * @return                int                                       Node level of defined record
     * @access                public
     */
    static function GetNodeLevels(&$object, $root_id, $parent_id_name)
    {
        $node_list = array();
        $key_columns = $object->getKeyColumns();
        TableHelper::GetRecursiveNodeLevels($object, $root_id, $key_columns[0]["name"], $parent_id_name, $node_list);
        return $node_list;
    }

    /**
     * Method returns list nodelevels
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param                array             &$raw_data                     Raw list of records
     * @param                int                          $node_id                           Current node ID
     * @param                string      $key_field_name     Name of key-field
     * @param     string                $parent_id_name                Name of parent-link field
     * @param     string                $node_level                    Level of node
     * @param                array                &$node_list         Final list of nodes
     * @access        public
     */
    static function GetRecursiveNodeLevels(&$object, $node_id, $key_field_name,
        $parent_id_name, &$node_list)
    {
        $SQL = sprintf("SELECT %s, %s FROM %s WHERE %s = %d", $key_field_name, $parent_id_name, $object->defaultTableName, $key_field_name, $node_id);

        $_tmp = $object->Connection->ExecuteScalar($SQL);
        if (! empty($_tmp)) {
            if (is_array($node_list)) {
                $keys = array_keys($node_list);
                $size = sizeof($keys);
                for ($i = 0; $i < $size; $i ++) {
                    $node_list[$keys[$i]] ++;
                }
            }
            $node_list[$_tmp[$key_field_name]] = 0;
            TableHelper::GetRecursiveNodeLevels($object, $_tmp[$parent_id_name], $key_field_name, $parent_id_name, $node_list);
        }
    }

    /**
     * Method retrives nodes from bottom node to root
     * @param     AbstractTable   &$object            AbstractTable object (or child)
     * @param        array         $data        Array                            with data for Where constructor
     * @param        int     $node_id                                        ID of bottom node
     * @param        string        $parent_field                           Name of parent field
     * @param        boolean $removeprefix                           Remove language prefixes from field names flag
     * @return                array        array with node entries
     */
    static Function RetrieveNodesFromBottom(&$object, $data, $node_id, $parent_field, $removeprefix = false){
        $keyField = $object->getKeyColumns();
        $_reader = $object->GetList($data, $orders);
        for ($i = 0; $i < $_reader->RecordCount; $i ++) {
            $_tmp = $_reader->Read();
            $categories[$_tmp[$keyField[0]["name"]]] = $_tmp;
        }
        // Retrieving nodes of catalog for current vendor
        $_list[$node_id] = $categories[$node_id];
        if ($removeprefix) {
            if (is_array($_list[$node_id])) {
                foreach ($_list[$node_id] as $field_key => $value) {
                    $_list[$node_id][removeLangPrefix($field_key, $object->Connection->Kernel->Language)] = $value;
                }
            }
        }
        TableHelper::BuildTreeFromBottom($object, $categories, $categories[$node_id][$parent_field], $keyField[0]["name"], $parent_field, $_list, $removeprefix);
        return $_list;
    }

    /**
     *  Method gets node from bottom to root
     *  @param     AbstractTable   &$object            AbstractTable object (or child)
     *  @param        array         $data        Array with tree data
     *  @param        int                        $node_id        Low-level node ID
     *  @param        string  $keyfield        Name of keyfield
     *  @param string        $parent_field        Name of parent field
     *  @param        array   $node_list        Nodelist
     *  @param boolean $removeprefix    Remove language prefixes from field names flag
     *  @access        public
     */
    static function BuildTreeFromBottom(&$object, &$data, $node_id, $keyfield, $parent_field, &$node_list, $removeprefix = false){
        if (! empty($data)) {
        	$parent_id=$data[$node_id][$parent_field];
        	if ($data[$parent_id][$keyfield]>0){
        		$item=$data[$parent_id];

				if ($removeprefix)
					foreach ($item as $field_key => $value)
						$item[removeLangPrefix($field_key, $object->Connection->Kernel->Language)] = $value;

				$node_list[$parent_id]=$item;
				TableHelper::BuildTreeFromBottom($object, $data, $parent_id, $keyfield, $parent_field, $node_list);
			}
        }
    }

	static function GetTreeItemPath(&$data, $node_id, $key_field, $parent_field, &$node_list, $language=""){
		$item=$data[$node_id];
		if ($item[$key_field]>0){
			unset($item["_children"]);

			if ($language!=""){
				foreach ($item as $field_key => $value){
					$item[removeLangPrefix($field_key, $language)] = $value;
				}
			}

			$node_list[$item[$key_field]]=$item;
			TableHelper::GetTreeItemPath($data, $item[$parent_field], $key_field, $parent_field, $node_list, $language);
		}
    }

	static function GetTreeNestedIds(&$tree, $key_field, $parent_field, &$ids){
        if (is_array($tree)){
            foreach ($tree as $i=>$node){
            	$ids[]=$node[$key_field];
	          	if (!empty($node["_children"])){
	            	TableHelper::GetTreeNestedIds($node["_children"], $key_field, $parent_field, $ids);
            	}
            }
        }
    }

    /**
     * Method set column parameter (array item)
     * @param   AbstractTable   &$object            AbstractTable object (or child)
     * @param    string    $columnname Name of column
     * @param    string    $paramname    Parameter name
     * @param    mixed        $paramvalue    parameter value
     * @access    public
     **/
    static function setColumnParameter(&$object, $columnname, $paramname, $paramvalue){
        $column_exists = false;
        $sizeof = sizeof($languages);
        for ($i = 0; $i < sizeof($object->columns); $i ++) {
            if ($object->columns[$i]["name"] == $columnname) {
                if ($paramname != "name") {
                    $object->columns[$i][$paramname] = $paramvalue;
                }
                $column_exists = true;
            }
        }
        if (! $column_exists) {
            $object->columns[] = array(
                "name" => $columnname,
                $paramname => $paramvalue
            );
        }
    }

    /**
     * Method get first not key field
     * @param   AbstractTable   &$object            AbstractTable object (or child)
     * @return   string                             Column name
     * @access   public
     * @static
     **/
    static function GetFirstNotKeyColumn(&$object)
    {
        for ($i = 0; $i < count($object->columns); $i ++) {
            if (! $object->IsKey($object->Storage->columns[$i]) && ! $object->IsSystem($object->columns[$i]) && $object->columns[$i]["type"] == DB_COLUMN_STRING) {
                $field = $object->columns[$i]["name"];
                return $field;
            }
        }
    }

    /**
     * Method create where clause with library list filter data
     * @param    string   &$library_name            Name of library
     * @return   string                             where Clause or empty string
     * @access   public
     * @static
     **/
    static function GetWhereClauseListFilter(&$object, $library_name)
    {
        $filter_data = DataDispatcher::Get($library_name . "_filter");
        if (count($filter_data)) {
            foreach ($filter_data as $i => $data) {
                if (! $data["field_exclude_sql"]) {
                    if (! is_array($data["current_value"])) {
                        $data["current_value"] = $object->Connection->EscapeString($data["current_value"]);
                    }
                    switch ($data["type"]) {
                        //select input field


                        case "combobox":

                        //text input field
                        case "text":
                            if (strlen($data["current_value"])) {
                                switch ($data["value_type"]) {
                                    //- n day from timestamp field
                                    case "lastmodified":
                                        if (intval($data["current_value"]) != 0) {
                                            if (! $data["field_is_unix_timestamp"]) {
                                                $SQL .= sprintf(" AND %s>'%s' ", $data["where_clause"], date("Y-m-d H:i:s", strtotime(sprintf(" -%d day", intval($data["current_value"])))));
                                            }
                                            else {
                                                $SQL .= sprintf(" AND %s>'%s' ", $data["where_clause"], strtotime(sprintf(" -%d day", intval($data["current_value"]))));
                                            }
                                        }
                                        break;
                                    //integer value
                                    case "int":
                                        if ($data["consider_zero"] == 1) {
                                            if ($data["current_value"] != "") {
                                                $SQL .= sprintf(" AND %s=%d ", $data["where_clause"], $data["current_value"]);
                                            }
                                        }
                                        else {
                                            if (intval($data["current_value"]) != 0) {
                                                $SQL .= sprintf(" AND %s=%d ", $data["where_clause"], $data["current_value"]);
                                            }
                                        }
                                        break;

                                    //text value
                                    default:
                                        if ($data["type"] == "text") {
                                            $SQL .= sprintf(" AND %s(%s) LIKE %s('%s%s%s') ", $object->Connection->Syntax["UCASE"], $data["where_clause"], $object->Connection->Syntax["UCASE"], "%", $data["current_value"], "%");
                                        }
                                        else {
                                            if (($data["current_value"] != "") && (! is_array($data["current_value"]))) {
                                                $SQL .= sprintf(" AND %s = '%s' ", $data["where_clause"], $data["current_value"]);
                                            }
                                            elseif (is_array($data["current_value"])) {
                                                $usefull_values = array_unique($data["current_value"]);
                                                sort($usefull_values);
                                                if ($usefull_values[0] == 0) {
                                                    array_shift($usefull_values);
                                                }

                                                if (! empty($usefull_values)) {
                                                    $SQL .= sprintf(" AND %s IN( %s ) ", $data["where_clause"], implode(",", $usefull_values));
                                                }
                                            }
                                        }
                                        break;
                                }
                            }
                            break;
                        //range (2 text fields)
                        case "range":
                            if (strlen($data["current_value"]["min"]) || strlen($data["current_value"]["max"])) {
                                switch ($data["value_type"]) {
                                    //integer value
                                    case "int":
                                        if (intval($data["current_value"]["max"]) != 0 || intval($data["current_value"]["min"]) != 0) {
                                            if (intval($data["current_value"]["max"] == 0)) {
                                                $SQL .= sprintf(" AND %s>=%d", $data["where_clause"], $data["current_value"]["min"]);
                                            }
                                            elseif (intval($data["current_value"]["min"]) == 0) {
                                                $SQL .= sprintf(" AND %s<=%d", $data["where_clause"], $data["current_value"]["max"]);
                                            }
                                            elseif (intval($data["current_value"]["max"]) > intval($data["current_value"]["min"])) {
                                                $SQL .= sprintf(" AND %s>=%d AND %s<=%d", $data["where_clause"], $data["current_value"]["min"], $data["where_clause"], $data["current_value"]["max"]);
                                            }
                                        }
                                        break;

                                    //default(string) value
                                    default:

                                        if (strlen($data["current_value"]["max"]) != 0 || strlen($data["current_value"]["min"]) != 0) {

                                            if ($data["value_type"] == "lastmodified") {
                                                if ($data["field_is_unix_timestamp"]) {
                                                    if (strlen($data["current_value"]["max"]) != 0) {
                                                        $data["current_value"]["max"] = Component::getUnixTimeStamp($data["current_value"]["max"]);
                                                    }
                                                    if (strlen($data["current_value"]["min"]) != 0) {
                                                        $data["current_value"]["min"] = Component::getUnixTimeStamp($data["current_value"]["min"]);
                                                    }

                                                }
                                            }

                                            if (strlen($data["current_value"]["max"]) == 0) {
                                                $SQL .= sprintf(" AND %s>='%s'", $data["where_clause"], $data["current_value"]["min"]);
                                            }
                                            elseif (strlen($data["current_value"]["min"]) == 0) {
                                                $SQL .= sprintf(" AND %s<='%s'", $data["where_clause"], $data["current_value"]["max"]);
                                            }
                                            else {
                                                $SQL .= sprintf(" AND %s>='%s' AND %s<='%s'", $data["where_clause"], $data["current_value"]["min"], $data["where_clause"], $data["current_value"]["max"]);
                                            }
                                        }
                                        else {
                                            $SQL .= sprintf(" AND %s='%s' ", $data["where_clause"], $data["current_value"]);
                                        }
                                        break;
                                }
                            }
                            break;
                    }
                } // if
            }
            if (strlen($SQL))
                $SQL = substr($SQL, strlen(" AND"));
            return $SQL;
        }
        else
            return "";

    }

    /**
     * Method splits filter returned by GetWhereClauseListFilter method into chunks
     * Result is an array, with keys named by table aliases used in filter
     * Each element is an array with simple condition
     * If no table alias specified for single condition - this conditions goes to __default key
     * Assembled conditions by table alias name stored in __assembled key array element,
     * grouped by table alias name
     * @param   string   $filter     Part of WHERE clause (no braket-grouping supported)
     * @return  array  Array with conditions
     *                   $result = array("table_ailas" => array("table_ailas.a = b", "table_ailas.c = d"),
     *                                    "__default"   => array("a = b", "c = d"),
     *                                    "__assembled" => array("table_ailas" => "table_ailas.a = b AND table_ailas.c = d",
     *                                                           "__default"   => array("a = b AND c = d")
     *                                                           )
     *                                   )
     * @access public
     **/
    function SplitFilter($filter)
    {
        $chunks = preg_split("/(AND|OR)/i", $filter);
        $data = array();
        if (! empty($chunks)) {
            foreach ($chunks as $chunk) {
                $__tmp = preg_split("/(\=|\s+)/", $chunk);

                $alias = (false !== ($pos = strpos($__tmp[1], ".")) ? substr($__tmp[1], 0, $pos) : "__default");
                $data[$alias][] = $chunk;

            }
        }

        if (! empty($data)) {
            foreach ($data as $alias => $clauses) {
                $data["__assembled"][$alias] = implode(" AND ", $clauses);
            }
        }
        return $data;
    }

} //--end of class
?>