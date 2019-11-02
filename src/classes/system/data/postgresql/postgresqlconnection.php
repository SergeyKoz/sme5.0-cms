<?php
    $this->ImportClass("system.data.iconnection", 'IConnection');
    $this->ImportClass("system.data.postgresql.postgresqldatareader", "PostgreSQLdatareader");
    ////echo pr($this);

    /** Class works with connection your PostgreSQL server
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.data.postgresql
     * @access public
     */
    class PostgreSQLConnection extends IConnection {
        // Class information
        var $ClassName = "PostgreSQLConnection";
        var $Version = "1.0";
        // Connection properties
        var $Properties;
        // Connection state
        var $State = DB_CONNECTION_STATE_CLOSED;
        /**
          * Database type
          * @var    string  $DBType
          **/
        var $DBType = "PostgreSQL";
        /**
          * Syntax differences array
          * @var    array   $Syntax
          **/
        var $Syntax = array("LIMIT" => " OFFSET %d LIMIT %d ",
                            "RANDOMIZE" =>   "random(%s)",
                            "UCASE" => "upper");

        /**
         * Opens connection to specified MySQL server and processing
         * selection of database. Also raises error if something goes
         * wrong. And if any of arguments are empty strings replaces
         * them with predefined constants.
         *
         * @access public
         * @param  array  connection properties
         * @return mixed  true if connection to server made in other
         *                case return false
         */
       function Open($properties = null) {

             $tmp["description"] = "Connecting to DB : type=".$this->DBType.";host=".$properties["host"].";database=".$properties["dbname"];
             $tmp["time"] = __microtime();
             //create connection string
             $connectionString = "";
             foreach ($properties as $name => $value)   $connectionString .= " ".$name."=".$value;
             $this->_Res = pg_connect($connectionString);
             $tmp["time"] = __microtime()-$tmp["time"];
            if ($this->_Res) {
                $tmp["result"] = "Connected";
                //add debug info
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                $this->State = DB_CONNECTION_STATE_OPENED;
            }   else    {
                die("Can't connect to DB: ".pg_errormessage());
            }
            $this->GetServerVersion();
            return true;
        }

        /**
         * Close connection.
         *
         * @access public
         * @return void
         */
        function Close() {
            if ($this->State > DB_CONNECTION_STATE_CLOSED) {
                $tmp["description"] = "Closing connection to DB";
                $tmp["result"]="OK";
                            $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                                pg_close($this->_Res);
                $this->State = DB_CONNECTION_STATE_CLOSED;
            }
        }

        /**
         * Change current database.
         *
         * @access public
         * @param  string  database name
         * @return void
         */
        function ChangeDatabase($database) {
            return false;
        }

       /**
        * Method returms last insert ID for specified table
        * @param    string   $table_name    Name of table
        * @param    string   $incremental_column_name    Name of incremental column
        * @return   int     Increment value
        * @access   private
        ***/
        function GetLastInsertId($table_name, $incremental_column_name){
            /*$SQL = sprintf("SELECT %s FROM %s WHERE oid=%d",
                                    $incremental_column_name,
                                    $table_name,
                                    $this->_OID
                                    );
                                    */

             $SQL = sprintf("SELECT %s FROM %s ORDER BY %s DESC offset 0 limit 1",
                                    $incremental_column_name,
                                    $table_name,
                                    $incremental_column_name,
                                    $this->_OID
                                    );


            $id = $this->ExecuteScalar($SQL);
            //if($incremental_column_name == "spo_id"){
            //    echo pr($SQL);
            //    echo pr($id);
            //    die();
            //}
            return $id[$incremental_column_name];

        }

       /**
        * Method returms last insert ID for specified table
        * @param    string   $string  String to escape
        * @return   string   Escaped string
        * @access   public
        ***/
        function EscapeString($string){
            return pg_escape_string($string);
        }


        /**
         * Executes specified SQL statement. This method is
         * implied to run queries that don't return any data
         * such as INSERT, UPDATE and DELETE.
         *
         * @access public
         * @param  mixed    sql statement
         * @return resource result identifier of query execution
         */
        function ExecuteNonQuery($query) {
            $tmp["description"] = $query;
            if ($this->State == DB_CONNECTION_STATE_OPENED) {
                $tmp["time"] = __microtime();
                $_res = @pg_query($this->_Res,$query);
                $this->_OID = @pg_last_oid ($_res);
                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["result"] = $_res ? "Ok":"Error";
                $tmp["error"] = pg_errormessage();
                $tmp["records"] = 0;
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                return $_res;
            }
            else {
                $tmp["result"] = "Error";
                $tmp["error"] = "Not opened";
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                return false;
            }
        }

        /**
         * Executes specified SQL statement. This method is
         * implied to run queries that return some data.
         *
         * @access public
         * @param  mixed  sql statement
         * @return object data reader object
         */
        function &ExecuteReader($query) {
            $tmp["description"] = $query;
            if ($this->State == DB_CONNECTION_STATE_OPENED) {
                $tmp["time"] = __microtime();
                $_res = pg_query($this->_Res,$query);

                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["result"] = ($_res !== false ? "OK":"Error");
                $_num = pg_numrows($_res);
                $tmp["error"] = pg_errormessage();
                $tmp["records"] = $_num;
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);

                $PostgreSQLDataReader = new PostgreSQLDataReader();
                $PostgreSQLDataReader->RecordCount = $_num;
                $PostgreSQLDataReader->FieldCount = pg_numfields($_res);
                $PostgreSQLDataReader->queryId = $_res;
                $PostgreSQLDataReader->state = DB_READER_STATE_OPENED;
                //$this->debug_array[] = $tmp;
                return $PostgreSQLDataReader;
            }
            else {
                $tmp->result = false;
                $tmp["error"] = "Not opened";
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);

                return false;
            }
        }

        /**
         * Executes specified SQL statement. This method is
         * implied to run queries that return some data.
         *
         * @access public
         * @param  mixed  sql statement
         * @return object data reader object
         */
        function ExecuteScalar($query) {
                $tmp["description"] = $query;
            if ($this->State == DB_CONNECTION_STATE_OPENED) {
                $tmp["time"] = __microtime();

                $res = pg_query($this->_Res,$query);
               //echo pr($query);
                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["error"] = pg_errormessage();
                $num = @pg_numrows($res);
                $tmp["result"] = $res ? "Ok":"Error";
                $tmp["records"] = $num;
                                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                if ($num > 0) {
                    $ret = pg_fetch_assoc($res);
                    return $ret;
                }
                else {
                    return array();
                }
            }
            else {
                $tmp["error"] = "Not opened";
                $tmp["result"] = "Error";
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                return array();
            }
        }

        /**
         * Get default properties.
         *
         * @access public
         * @return array  default properties
         */
        function GetDefaults() {
            return array();
        }

        /**
        * Method sets up server version info
        * @access   public
        **/
        function GetServerVersion(){
            return false;
        }


    }

?>