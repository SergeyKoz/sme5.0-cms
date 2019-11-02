<?php
$this->ImportClass('system.data.tablehelper', 'TableHelper');
$this->ImportClass('system.xml.xmlhelper', 'XmlHelper');

/** @const DB_COLUMN_NUMERIC Constant of numeric column type **/
define('DB_COLUMN_NUMERIC', 1);

/** @const DB_COLUMN_STRING Constant of string column type **/
define('DB_COLUMN_STRING', 2);

/**
 * Base AbstractTable class.
 * @author Sergey Grishko <sgrishko@reaktivate.com>
 * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 2.0
 * @package Framework
 * @subpackage classes.system.data
 * @access public
 */
class AbstractTable extends Component
{

    var $ClassName = "AbstractTable";

    var $Version = "2.0";

    /**
     * Database connection object
     * @var    IConnection $Connection
     **/
    var $Connection;
    /**
     * Default table name
     * @var string $defaultTableName
     **/
    var $defaultTableName;
    /**
     * Array with table columns definitions
     * @var array    $columns
     **/
    var $columns = array();
    /**
     * Array with cached reader objects
     * @var array    $tree_data
     **/
    var $tree_data = array();

    /**
     * Use database columns definition in constructor  (flag)
     * @var array    $use_db_definition
     **/
    var $use_db_definition = false;

    /**
     * Available column paramaters  names
     * @var array      $columnparameters
     **/
    var $columnparameters = array(
        "name",
        /** name of column  **/
        "type",
        /** type of column (DB_COLUMN_NUMERIC or DB_COLUMN_STRING)  **/
        "key",
        /** key column flag **/
        "incremental",
        /** incremental column flag **/
        "length",
        /** length of column (used in validation) **/
        "notnull",
        /** not empty column flag **/
        "dtype"
    )/** validation and edit type (used in form creation, see Validate class) **/
    ;

    /**
     * Constructor
     * @param       IConnection          $Connection        Instance of Connection class
     * @param       string               $defaultTableName  Default Table Name
     * @param       boolean              $use_db_definition Use database columns definition
     * @access      public
     **/
    function AbstractTable(&$Connection, $defaultTableName = "",
        $use_db_definition = null)
    {
        // Store current connection
        @$this->Connection = &$Connection;
        $this->defaultTableName = $defaultTableName;
        if (isset($use_db_definition))
            $this->use_db_definition = $use_db_definition;


        static $storageColumns = array();
        if ($this->use_db_definition) {
            if (isset($storageColumns[$this->defaultTableName])) {
                $this->columns = $storageColumns[$this->defaultTableName];
            } else {
                TableHelper::prepareColumnsDB($this);
                $storageColumns[$this->defaultTableName] = $this->columns;
            }
        }
        else {
            $this->prepareColumns();
        }
        DataManipulator::prepareMultilangColumns($this->columns, $this->Connection->Kernel->Languages);
    }

    /**
     * Method prepares columns (prototype)
     * @access      public
     * @abstract
     **/
    function prepareColumns()
    {
    }

    /**
     * Method gets a list of key fileds in a table
     * @return     array Array with key column names
     * @access      public
     **/
    function getKeyColumns()
    {
        $result = array();
        foreach ($this->columns as $column)
            if (AbstractTable::IsKey($column)) {
                $result[] = $column;
            }
        return $result;
    }

    /**
     * Method returns field type for value validation
     * @param     string     $field_name    Name to get type
     * @return    string      Field type
     * @access    public
     */
    function GetField($field_name)
    {
        for ($i = 0; $i < sizeof($this->columns); $i ++) {
            if ($this->columns[$i]["name"] == $field_name) {
                return $this->columns[$i];
            }
        }
    }

    /**
     * Method gets a list of incremental fileds in a table
     * @return      array Array with incremental columns
     * @access      public
     **/
    function getIncrementalColumn()
    {
        $result = array();
        foreach ($this->columns as $column)
            if (AbstractTable::IsIncremental($column)) {
                $result = $column;
                break;
            }
        return $result;
    }

    /**
     * Method gets the value of incremental field after last insert query
     * @return      int The value of last inserted incremental field
     * @access      public
     **/
    function getInsertId()
    {
        $incremental_column = $this->getIncrementalColumn();
        return $this->Connection->GetLastInsertId($this->defaultTableName, $incremental_column["name"]);
    }

    /**
     * Method checks if specified column is a key-field
     * @param       array    $column    Array describing the column
     * @return      bool     true if column exists and is a key-field, false otherwise
     * @access      public
     **/
    function IsKey(&$column)
    {
        return (is_array($column) && isset($column["key"]) && $column["key"]);
    }

    /**
     * Method checks if specified column is a system
     * @param       array    $column    Array describing the column
     * @return      bool     true if column exists and is a system-field, false otherwise
     * @access      public
     **/
    function IsSystem(&$column)
    {
        return (is_array($column) && isset($column["name"]) && (substr($column["name"], 0, 1) == "_"));
    }

    /**
     * Method checks if specified column is an incremental-field
     * @param       array    $column    Array describing the column
     * @return      bool     true if column exists and is an incremental-field, false otherwise
     * @access      public
     **/
    function IsIncremental(&$column)
    {
        return (is_array($column) && isset($column["incremental"]) && $column["incremental"]);
    }

    /**
     * Method checks if specified column is an nullable-field (NULL)
     * @param       array    $column    Array describing the column
     * @return      bool     true if column exists and is an nullable-field, false otherwise
     * @access      public
     **/
    static function IsNullable(&$column)
    {
        return (is_array($column) && isset($column["nullable"]) && $column["nullable"]);
    }

    /**
     * Method formats date and time
     * @param       int      $datetime    Timestamp
     * @return      string   Formatted date and time
     * @access      public
     **/
    static function FormatDateTime($datetime)
    {
        return date("Y-m-d H:i:s", $datetime);
    }

    /**
     * Method formats sql string
     * @param       string   $string    SQL-string
     * @param       bool     $allowNull  Flag, if set to true allows null-strings
     * @return      string   Formatted escaped SQL-string
     * @access      public
     **/
    static function SqlString($string, $allowNull = false){
    	$Loader = &$GLOBALS["Loader"];
        return ($allowNull && (is_null($string) || ! strlen($string)) ? "NULL" : "'" . $Loader->Connection->EscapeString((string) $string) . "'");
    }

    /**
     * Method formats field-value regarding column type
     * @param       array    $column    Array with column descriotion
     * @param       mixed    $value     Value to be formatted
     * @return      mixed    Formatted  value
     * @access      public
     **/
    static function prepareColumnValue($column, $value){
        $result = "";
        if ($column["type"] == DB_COLUMN_NUMERIC) {
            $result = (int) $value;
        }
        elseif ($column["type"] == DB_COLUMN_STRING) {
            $result = AbstractTable::SqlString($value, AbstractTable::IsNullable($column));
        }
        else {
            $result = "NULL";
        }
        return $result;
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
    function GetCount($data = null, $table_alias = "", $raw_sql = array())
    {
        $result = array();
        $whereClause = TableHelper::prepareGetCountSQL($this, $data);

        if (strlen($whereClause)) {
            if (strlen($raw_sql["filter"])) {
                $raw_sql["filter"] = " AND " . $raw_sql["filter"];
            }
            if (strlen($raw_sql["where"])) {
                $raw_sql["where"] = " AND " . $raw_sql["where"];
            }
        }
        else {
            if (strlen($raw_sql["filter"]) || $raw_sql["where"]) {
                $whereClause = " WHERE 1=1 ";
            }
            if (strlen($raw_sql["filter"])) {
                $raw_sql["filter"] = " AND " . $raw_sql["filter"];
            }
            if (strlen($raw_sql["where"])) {
                $raw_sql["where"] = " AND " . $raw_sql["where"];
            }

        }

        $SQL = sprintf(
        	"SELECT COUNT(*) AS counter %s FROM %s %s %s %s %s %s %s %s %s ", (strlen($raw_sql["select"]) > 0 ? ", " . $raw_sql["select"] : ""), $this->defaultTableName, (strlen($table_alias) > 0 ? " as " . str_replace(".", "", $table_alias) : ""), $raw_sql["from"], $whereClause, $raw_sql["filter"], $raw_sql["where"], $raw_sql["group_by"], $raw_sql["order_by"], ((strlen($raw_sql["limit"]) != 0) ? $raw_sql["limit"] : sprintf($this->Connection->Syntax["LIMIT"], 0, 1)))

        ;
        $result = $this->Connection->ExecuteScalar($SQL);
        return $result["counter"];
    }

    /**
     * Method gets a record from DB matching data  (only keyfields)
     * @param       array    $data      Array with data
     * @param       array    $orders    Array with orders
     * @return      array    An associative array with record from DB
     * @access      public
     **/
    function Get($data, $orders = null){
        $result = array();
        $keyColumns = $this->columns;
        $orderClause = "";
        list ($whereClause, $orderClause) = TableHelper::prepareGetSQL($this, $data, $orders);
        $SQL = sprintf("SELECT * FROM %s %s%s %s", $this->defaultTableName, $whereClause, $orderClause, sprintf($this->Connection->Syntax["LIMIT"], 0, 1));
        $result = $this->Connection->ExecuteScalar($SQL);
        $this->OnAfterGet($data, $result);
        return $result;
    }

    /**
     * Method gets a record from DB matching data
     * @param       array    $data      Array with data
     * @param       array    $orders    Array with orders
     * @return      array    An associative array with record from DB
     * @access      public
     **/
    function GetRecord($data = null, $orders = null)
    {
        $result = array();
        global $RECORD_DATA;
        $str = pr(array(
            $data,
            $orders
        ));
        $key = md5($this->defaultTableName . $str);
        if (($RECORD_DATA[$key] != "") && is_array($RECORD_DATA[$key])) {
            return $RECORD_DATA[$key];
        }
        else {
            if (count($data)) {
                $this->OnBeforeGet($data);
                $whereClause = "";
                foreach ($data as $fieldname => $fieldvalue) {
                    for ($i = 0; $i < sizeof($this->columns); $i ++) {
                        if ($this->columns[$i]["name"] == $fieldname) {
                            $Column = $this->columns[$i];
                            break;
                        }
                    }
                    if (strlen($whereClause))
                        $whereClause .= " AND ";
                    $whereClause .= $fieldname . "=" . AbstractTable::prepareColumnValue($Column, $fieldvalue);
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
            $SQL = sprintf("SELECT * FROM %s %s%s %s", $this->defaultTableName, $whereClause, $orderClause, sprintf($this->Connection->Syntax["LIMIT"], 0, 1));

            $result = $this->Connection->ExecuteScalar($SQL);
            $this->OnAfterGet($data, $result);
            $RECORD_DATA[$key] = $result;
            return $result;
        }
    }

    /**
     * Method executes some actions before getting data from DB (prototype)
     * @param       array      $data   Data to process
     * @access      public
     * @abstract
     **/
    function OnBeforeGet(&$data)
    {
    }

    /**
     * Method executes some actions after getting data from DB (prototype)
     * @param       array      $data   Data to process
     * @param       array      $result   Result data
     * @abstract
     * @access      public
     **/
    function OnAfterGet(&$data, &$result)
    {
    }

    /**
     * Method gets a record from DB matching data  by fields
     * @param       array    $data      Array with data
     * @param       array    $orders    Array with orders
     * @return      array    An associative array with record from DB
     * @access      public
     **/
    function GetByFields($data = null, $orders = null)
    {
        $result = array();
        $whereClause = "";
        $orderClause = "";
        foreach ($this->columns as $column) {
            if (isset($data[$column["name"]])) {
                if (strlen($whereClause))
                    $whereClause .= " AND ";
                $whereClause .= $column["name"] . "=" . AbstractTable::prepareColumnValue($column, $data[$column["name"]]);
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
        $SQL = sprintf("SELECT * FROM %s %s%s %s", $this->defaultTableName, $whereClause, $orderClause, sprintf($this->Connection->Syntax["LIMIT"], 0, 1));
        $result = $this->Connection->ExecuteScalar($SQL);
        return $result;
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
    function &GetList($data = null, $orders = null, $limitCount = null, $limitOffset = null,
        $ids = null, $table_alias = "", $raw_sql = array())
    {
        list ($whereClause, $orderClause, $limitClause) = TableHelper::prepareGetListSQL($this, $data, $orders, $limitCount, $limitOffset, $ids, $table_alias);

        if (strlen($whereClause)) {
            if (strlen($raw_sql["filter"])) {
                $raw_sql["filter"] = " AND " . $raw_sql["filter"];
            }
            if (strlen($raw_sql["where"])) {
                $raw_sql["where"] = " AND " . $raw_sql["where"];
            }
        }
        else {
            if (strlen($raw_sql["filter"]) || $raw_sql["where"]) {
                $whereClause = " WHERE 1=1 ";
            }
            if (strlen($raw_sql["filter"])) {
                $raw_sql["filter"] = " AND " . $raw_sql["filter"];
            }
            if (strlen($raw_sql["where"])) {
                $raw_sql["where"] = " AND " . $raw_sql["where"];
            }

        }

        $SQL = sprintf("SELECT %s FROM %s %s %s %s%s %s %s%s%s %s%s ", (strlen($raw_sql["select"]) > 0 ? "" . $raw_sql["select"] : $table_alias."*"), $this->defaultTableName, (strlen($table_alias) > 0 ? " as " . str_replace(".", "", $table_alias) : ""), $raw_sql["from"], $whereClause, $raw_sql["filter"], $raw_sql["where"], $raw_sql["group_by"], $orderClause, $raw_sql["order_by"], $limitClause, $raw_sql["limit"]);

        $reader = & $this->Connection->ExecuteReader($SQL);
        return $reader;

    }

    /**
     * Method inserts the records to DB filled with data
     * @param       array    $data        Array with data
     * @return      boolean               Insert status
     * @access      public
     **/
    function Insert(&$data)
    {
        $this->OnBeforeInsert($data);
        $sqlColumns = "";
        $sqlValues = "";
        foreach ($this->columns as $column)
            if ((! AbstractTable::IsIncremental($column)) && (isset($data[$column["name"]]))) {
                if (strlen($sqlColumns))
                    $sqlColumns .= ", ";
                $sqlColumns .= "`" . $column["name"] . "`";
                if (strlen($sqlValues))
                    $sqlValues .= ", ";
                $sqlValues .= AbstractTable::prepareColumnValue($column, $data[$column["name"]]);
            }
        $SQL = sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->defaultTableName, $sqlColumns, $sqlValues);
        $_status = $this->Connection->ExecuteNonQuery($SQL);
        $incrementalColumn = $this->getIncrementalColumn();
        if (count($incrementalColumn)) {
            $data[$incrementalColumn["name"]] = $this->getInsertId();
        }
        if ($_status)
            $this->OnAfterInsert($data);
        return $_status;
    }

    /**
     * Method executes some actions before insert (prototype)
     * @param       array      $data   Data to process
     * @access      public
     * @abstract
     **/
    function OnBeforeInsert(&$data)
    {
    }

    /**
     * Method executes some actions after insert (prototype)
     * @param       array      $data   Data to process
     * @access      public
     * @abstract
     **/
    function OnAfterInsert(&$data)
    {
    }

    /**
     * Method updates the records in DB filled with data
     * @param       array    $data      Array with data
     * @return      boolean             Update status
     * @access      public
     **/
    function Update(&$data)
    {
        $keyColumns = $this->getKeyColumns();
        if (count($keyColumns)) {

            $this->OnBeforeUpdate($data);

            $SQL = "";
            foreach ($this->columns as $column)
                if (! AbstractTable::IsIncremental($column) && isset($data[$column["name"]])) {
                    if (strlen($SQL))
                        $SQL .= ", ";

                    $SQL .= sprintf("%s=%s", $column["name"], AbstractTable::prepareColumnValue($column, $data[$column["name"]]));
                }
            $whereClause = "";
            foreach ($keyColumns as $keyColumn) {
                if (strlen($whereClause))
                    $whereClause .= " AND ";
                $whereClause .= $keyColumn["name"] . "=" . AbstractTable::prepareColumnValue($keyColumn, $data[$keyColumn["name"]]);
            }
            $SQL = sprintf("UPDATE %s SET %s WHERE %s", $this->defaultTableName, $SQL, $whereClause);

            $_result = $this->Connection->ExecuteNonQuery($SQL);
            if ($_result)
                $this->OnAfterUpdate($data);
            return $_result;
        }
    }

    /**
     * Method updates the records in DB filled with data
     * @param       array    $fields      Array with fields to update
     * @param       array    $data        Array with data to update
     * @access      public
     **/
    function UpdateByFields($fields, &$data){
        $keyColumns = $this->columns;
        if (count($keyColumns)) {
            $this->OnBeforeUpdate($data);
            $SQL = "";
            foreach ($this->columns as $column){
                if (! AbstractTable::IsIncremental($column) && ! empty($data[$column["name"]])) {
                    if (strlen($SQL)) $SQL .= ", ";
                    $SQL .= sprintf("%s=%s", $column["name"], AbstractTable::prepareColumnValue($column, $data[$column["name"]]));
                }

                if (! AbstractTable::IsIncremental($column) && ! empty($fields[$column["name"]])) {
                    if (!empty($fields[$column["name"]]))
                        if (strlen($whereClause))
                            $whereClause .= " AND ";
                    $whereClause .= $column["name"] . "=" . AbstractTable::prepareColumnValue($column, $fields[$column["name"]]);
                }
            }
            $SQL = sprintf("UPDATE %s SET %s WHERE %s", $this->defaultTableName, $SQL, $whereClause);
            $this->Connection->ExecuteNonQuery($SQL);

            $this->OnAfterUpdate($data);
        }
    }

    /**
     * Method executes some actions before update (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnBeforeUpdate(&$data)
    {
    }

    /**
     * Method executes some actions after update (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnAfterUpdate(&$data)
    {

    }

    /**
     * Method deletes the records in DB filled with data
     * @param       array    $data        Array with data
     * @return      boolean               Delete status
     * @access      public
     **/
    function Delete(&$data)
    {
        $keyColumns = $this->columns;
        //$this->getKeyColumns();
        if (count($keyColumns)) {
            $this->OnBeforeDelete($data);
            $whereClause = "";
            foreach ($keyColumns as $keyColumn) {
                if (isset($data[$keyColumn["name"]])) {
                    if (strlen($whereClause))
                        $whereClause .= " AND ";

                    $whereClause .= $keyColumn["name"] . "=" . AbstractTable::prepareColumnValue($keyColumn, $data[$keyColumn["name"]]);
                }
            }
            $SQL = sprintf("DELETE FROM %s WHERE %s", $this->defaultTableName, $whereClause);

            $_result = $this->Connection->ExecuteNonQuery($SQL);
            if ($_result)
                $this->OnAfterDelete($data);
            $data = array();
            return $_result;
        }

    }

    /**
     * Method executes some actions before delete (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnBeforeDelete(&$data)
    {
    }

    /**
     * Method executes some actions after delete (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnAfterDelete(&$data)
    {
    }

    /**
     * Method deletes the records in DB filled with data  by key
     * @param       array    $data        Array with data
     * @access      public
     **/
    function DeleteByKey(&$data)
    {
        if (count($data)) {
            $whereClause = "";
            while (list ($_key, $_value) = each($data)) {
                if (strlen($whereClause))
                    $whereClause .= " AND ";
                if (is_array($_value) && ! empty($_value)) {
                    $whereClause .= $_key . " IN (" . implode(",", $_value) . ") ";
                }
                else {
                    $whereClause .= $_key . "=" . AbstractTable::prepareColumnValue($this->GetField($_key), $_value);
                }
            }
            $SQL = sprintf("DELETE FROM %s WHERE %s", $this->defaultTableName, $whereClause);
            $this->Connection->ExecuteNonQuery($SQL);
            $data = array();
        }
    }

    /**
     * Method builds XML page regarding on data, orders, decorator
     * @param       (object structure)    $xmlWriter    Instance of xmlWriter Class
     * @param       array    $data        Array with data
     * @param       array    $orders      Array with orders
     * @param       string   $decorator   Name of the method used to decorate the result
     * @param       string   $readerMethod  Name of the method used to read
     * @param       string   $counterMethod Name of the method used to count
     * @param       bool     $withPager     Flag if used pager capability
     * @param       int      $page         Page number
     * @param       int      $itemsPerPage Items per page
     * @param       int      $pagesPerPage Pages per page
     * @access      public
     **/
    function GetListXml(&$xmlWriter, $data = null, $orders = null, $decorator = null,
        $readerMethod = null, $counterMethod = null, $withPager = false,
        $page = 1, $itemsPerPage = 0, $pagesPerPager = 0)
    {
        if (is_null($counterMethod))
            $counterMethod = "GetCount";
        if (is_null($readerMethod)) {
            $readerMethod = "GetList";
        }

        if (! $withPager) {
            XmlHelper::buildListXml($xmlWriter, $this->$readerMethod($data, $orders), $decorator, $this);
            return;
        }
        // With pager section
        $itemsCount = $this->$counterMethod($data);

        $pageCount = (int) (($itemsCount - 1) / $itemsPerPage) + 1;

        if ($page < 1 || $page > $pageCount)
            $page = 1;

        XmlHelper::buildListXml($xmlWriter, $this->$readerMethod($data, $orders, $itemsPerPage, $itemsPerPage * ($page - 1)), $decorator, $this);
        if ($pageCount > 1) {
            XmlHelper::buildPagerXml($xmlWriter, $page, $itemsCount, $itemsPerPage, $pagesPerPager);
        }
    }

    // Functions to deal with XmlWriter


    /**
     * Method counts number of pages and start item number
     * Functions to deal with XmlWriter
     *
     * @param       int      $page         Page number
     * @param       int      $itemPerPage Items per page
     * @param       int      $itemCount   Items Count
     * @access      public
     **/
    function calculateStartItem($page, $itemPerPage, $itemsCount)
    {
        $pageCount = ($itemsCount - 1) / $itemsPerPage + 1;
        $startItem = $itemsPerPage * ($page - 1) + 1;
    }

    /**
     * Method updates the records in DB filled with data using "IN" clause
     * @param       string   $in_field    Name of field used in IN() clause
     * @param       array    $in_data     Array with data in IN() clause
     * @param       array    $data        Array with data
     * @access      public
     **/
    function GroupUpdate($in_field, $in_data, $data)
    {
        $keyColumns = $this->getKeyColumns();
        if (count($keyColumns)) {
            $SQL = "";
            foreach ($this->columns as $column)

                if (! AbstractTable::IsIncremental($column) && isset($data[$column["name"]])) {
                    if (strlen($SQL))
                        $SQL .= ", ";

                    $SQL .= sprintf("%s=%s", $column["name"], AbstractTable::prepareColumnValue($column, $data[$column["name"]]));
                }
            $whereClause = "";

            for ($i = 0; $i < sizeof($in_data); $i ++) {
                if (strlen($whereClause))
                    $whereClause .= ",";
                $whereClause .= $in_data[$i];
            }
            if (strlen($whereClause)) {
                $whereClause = $in_field . " IN (" . $whereClause . ")";
            }

            $SQL = sprintf("UPDATE %s SET %s WHERE %s", $this->defaultTableName, $SQL, $whereClause);
            $this->Connection->ExecuteNonQuery($SQL);
        }
        $this->OnAfterGroupUpdate($in_field, $in_data);

    }

    /**
     * Method deletes the records from DB using "IN()" clause
     * @param       string   $in_field    Name of field used in IN() clause
     * @param       array    $in_data        Array with data in IN() clause
     * @access      public
     **/
    function GroupDelete($in_field, $in_data)
    {
        $keyColumns = $this->getKeyColumns();
        if (count($keyColumns)) {
            $whereClause = "";

            for ($i = 0; $i < sizeof($in_data); $i ++) {
                if (strlen($whereClause))
                    $whereClause .= ",";
                $whereClause .= $in_data[$i];
            }
            if (strlen($whereClause)) {
                $whereClause = $in_field . " IN (" . $whereClause . ")";
            }

            $SQL = sprintf("DELETE FROM %s WHERE %s", $this->defaultTableName, $whereClause);

            $this->Connection->ExecuteNonQuery($SQL);

            $this->OnAfterGroupDelete($in_field, $in_data);

        }
    }

    /**
     * Method executes after GroupDelete (prototype)

     * @param       string   $in_field    Name of field used in IN() clause
     * @param       array    $in_data        Array with data in IN() clause
     * @access      public
     * @abstract
     **/
    function OnAfterGroupDelete($in_field, $in_data)
    {
    }

    /**
     * Method executes after GroupUpdate (prototype)
     * @param       string   $in_field    Name of field used in IN() clause
     * @param       array    $in_data        Array with data in IN() clause
     * @access      public
     * @abstract
     **/
    function OnAfterGroupUpdate($in_field, $in_data)
    {

    }

    /**
     * Method returns list of nodes that belongs to selected node
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param     array       $raw_data           Raw list of records
     * @param     int         $node_id            Current node ID
     * @param     string      $key_field_name     Name of key-field
     * @param     string      $parent_id_name     Name of parent-link field
     * @param     array       &$node_list         Final list of nodes
     * @access    public
     */
    function GetRecursiveNodeList($raw_data, $node_id, $key_field_name,
        $parent_id_name, &$node_list)
    {
        TableHelper::GetRecursiveNodeList($this, $raw_data, $node_id, $key_field_name, $parent_id_name, $node_list);
    }

    /**
     * Method returns set of records that belongs to specified node in case of tree-data
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param      array       $data                  Data to get from DB
     * @param      int         $root_id               ID of node to search down
     * @param      string      $parent_id_name        Name of parent link
     * @param      array       $orders                Orders array to sort get results
     * @param      string      $get_method            Get records list method
     * @return     array       List of found records
     * @access     public
     */
    function GetTreeData($data, $parent_id_name, $orders = null,
        $get_method = "GetList")
    {
        return TableHelper::GetTreeData($this, $data, $parent_id_name, $orders, $get_method);
    }

    /**
     * Method returns array with all ID's of nested records relative to given root_id
     * @param  int     $root_id   ID of root record of a tree branch
     * @param  string  $parent_id_name   Name of parent holder field
     * @return array   Array with nested ID's
     * @access public
     **/
    function GetNestedIDs($root_id, $parent_id_name)
    {
        return TableHelper::GetNestedIDs($this, $root_id, $parent_id_name);
    }

    /**
     * Method returns list nodelevels
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param     array       &$raw_data          Raw list of records
     * @param     int         $node_id            Current node ID
     * @param     string      $key_field_name     Name of key-field
     * @param     string      $parent_id_name     Name of parent-link field
     * @param     string      $node_level         Level of node
     * @param     array       &$node_list         Final list of nodes
     * @access    public
     */
    function GetRecursiveNodeLevels($raw_data, $node_id, $key_field_name,
        $parent_id_name, $node_level, &$node_list)
    {
        TableHelper::GetRecursiveNodeLevels($this, $raw_data, $node_id, $key_field_name, $parent_id_name, $node_level, $node_list);
    }

    /**
     * Method returns node level of defined record
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param      int      $root_id  ID of node to search down
     * @param      string   $parent_id_name   Name of parent link
     * @return     int    Node level of defined record
     * @access     public
     */
    function GetNodeLevels($root_id, $parent_id_name)
    {
        return TableHelper::GetNodeLevels($this, $root_id, $parent_id_name);
    }

    /**
     * Method increments specified fields by specified values
     * @param       mixed     $key_value        Value(s) of key field where to increment
     * @param       mixed     $field_name       Name(s) of fields which to increment
     * @param       int       $increment        Value of increment
     * @access      public
     */
    function UpdateCounter($key_value, $field_name, $increment)
    {
        $keyFields = $this->getKeyColumns();
        if (is_array($key_value) && ! empty($key_value)) {
            $whereClause = "WHERE " . $keyFields[0]["name"] . " IN (" . implode(",", $key_value) . ") ";
        }
        else {
            $whereClause = "WHERE " . $keyFields[0]["name"] . "=" . AbstractTable::prepareColumnValue($keyFields[0], $key_value) . " ";
        }

        if (is_array($field_name) && ! empty($field_name)) {
            for ($i = 0; $i < sizeof($field_name); $i ++) {
                $updateClause .= " " . $field_name . "=" . $field_name . "+" . $increment . " ";
            }
        }
        else {
            $updateClause = " " . $field_name . "=" . $field_name . "+" . $increment . " ";
        }

        $SQL = sprintf("UPDATE %s SET %s %s", $this->defaultTableName, $updateClause, $whereClause);
        $this->Connection->ExecuteNonQuery($SQL);
    }

    /**
     * Method retrives nodes from bottom node to root
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param  array   $data   Array       with data for Where constructor
     * @param  int     $node_id                ID of bottom node
     * @param  string  $parent_field       Name of parent field
     * @param  boolean $removeprefix       Remove language prefixes from field names flag
     * @return     array   array with node entries
     */
    Function RetrieveNodesFromBottom($data, $node_id, $parent_field, $removeprefix = false){
        return TableHelper::RetrieveNodesFromBottom($this, $data, $node_id, $parent_field, $removeprefix);
    }

    /**
     *  Method gets node from bottom to root
     * removed definition to TableHelper   class (leaved for older site versions)
     *  @param   array   $data   Array with tree data
     *  @param   int         $node_id    Low-level node ID
     *  @param   string  $keyfield   Name of keyfield
     *  @param string    $parent_field   Name of parent field
     *  @param   array   $node_list  Nodelist
     *  @param boolean $removeprefix    Remove language prefixes from field names flag
     *  @access  public
     **/
    static function BuildTreeFromBottom($data, $node_id, $keyfield, $parent_field, &$node_list, $removeprefix = false){
        if (!empty($data)) {
			$tree=array();
			foreach ($data as $id => $node)
				$tree[$node[$keyfield]]=$node;
			if (!empty($tree[$node_id]))
				$node_list[$node_id]=$tree[$node_id];
		}
        TableHelper::BuildTreeFromBottom($this, $tree, $node_id, $keyfield, $parent_field, $node_list, $removeprefix);
    }

    static function GetTreeItemPath(&$data, $node_id, $key_field, $parent_field, &$node_list, $language =""){
        TableHelper::GetTreeItemPath($data, $node_id, $key_field, $parent_field, $node_list, $language);
    }

    /**
     * Method set column parameter (array item)
     * removed definition to TableHelper   class (leaved for older site versions)
     * @param    string  $columnname Name of column
     * @param    string  $paramname  Parameter name
     * @param    mixed       $paramvalue parameter value
     * @access   public
     **/
    function setColumnParameter($columnname, $paramname, $paramvalue)
    {
        TableHelper::setColumnParameter($this, $columnname, $paramname, $paramvalue);
    }

    /**
     * Method add column to table definitions
     * @param    array   $data    column data
     * @access   public
     **/
    function addColumn($data)
    {
        $this->columns[] = $data;
    }

    /**
     * Method clear columns array
     * @access private
     **/
    function clearColumns()
    {
        $this->columns = array();
    }

    /**
     * Method search column by name
     * @param    string  $name   Column name (not case-sensitive)
     * @return   mixed           column number if exists, otherwise - false
     **/
    function HasColumn($name)
    {
        for ($i = 0; $i < count($this->columns); $i ++) {
            if (strtoupper($this->columns[$i]["name"]) == strtoupper($name))
                return $i;
        }
        return false;
    }

    /**
     * Method remove column by name
     * @param    string  $name   Column name (not case-sensitive)
     * @return   mixed           true if removed, false if column not found
     **/
    function RemoveColumn($name)
    {
        $pos = $this->HasColumn($name);
        if ($pos !== false) {
            array_splice($this->columns, $pos, 1);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Method exchange two incremental fields values (using zero value)
     * @param int     $id1    first ID value
     * @param int     $id2    second ID value
     * @access public
     **/
    function exchangeIncrementals($id1, $id2)
    {
        $column = $this->getIncrementalColumn();
        $key_field = $column["name"];
        $SQL = sprintf(" UPDATE %s SET %s=0 WHERE %s=%d", $this->defaultTableName, $key_field, $key_field, $id1);
        $this->Connection->ExecuteNonQuery($SQL);
        $SQL = sprintf(" UPDATE %s SET %s=%d WHERE %s=%d", $this->defaultTableName, $key_field, $id1, $key_field, $id2);
        $this->Connection->ExecuteNonQuery($SQL);
        $SQL = sprintf(" UPDATE %s SET %s=%d WHERE %s=0", $this->defaultTableName, $key_field, $id2, $key_field);
        $this->Connection->ExecuteNonQuery($SQL);

    }

    /**
     * Method returns string name of a table for SQL clause
     * @param   string    $table_name   Table name in settings
     * @return  string     Database table name
     * @access  public
     ***/
    function GetTable($table_name)
    {
        return $this->Connection->Kernel->Settings->GetItem("database", $table_name);
    }

    /**
     * Method create where clause with library list filter data
     * @param    string   &$library_name            Name of library
     * @return   string                             where Clause or empty string
     * @access   public
     * @static
     **/
    function GetWhereClauseListFilter(&$object, $library_name)
    {
        return TableHelper::GetWhereClauseListFilter($object, $library_name);
    }

} //class
?>