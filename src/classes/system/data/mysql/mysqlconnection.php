<?php
    $this->ImportClass('system.data.iconnection', 'IConnection');
    $this->ImportClass('system.data.mysql.mysqldatareader', 'MySqlDataReader');
    //echo pr($this);

    /** Class works with connection yo MySQL server
     * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.data.mysql
     * @access public
     */

    define('MYSQL_CP_NAMES_DEFAULT', 'cp1251');

    class MySqlConnection extends IConnection {
        // Class information
        var $ClassName = "MySqlConnection";
        var $Version = "1.0";
        // Connection properties
        var $Properties;
        // Connection state
        var $State = DB_CONNECTION_STATE_CLOSED;
        /**
          * Database type
          * @var    string  $DBType
          **/
        var $DBType = "MySQL";
        /**
          * Syntax differences array
          * @var    array   $Syntax
          **/
        var $Syntax = array("LIMIT" => " LIMIT %d, %d ",
                            "RANDOMIZE" =>   "RAND(%s)",
                            "UCASE" => "UCASE");

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

             $tmp["description"] = "Connecting to DB : type=".$this->DBType.";host=".$properties["host"]."; ";//user=".$properties["user"]."; pwd: ".$properties["password"];
             $tmp["time"] = __microtime();
             $this->_Res = mysql_connect($properties["host"], $properties["user"], $properties["password"]);

             $tmp["time"] = __microtime()-$tmp["time"];
            if ($this->_Res) {
                $tmp["result"] = "Connected";
                $this->State = DB_CONNECTION_STATE_CONNECTED;

                $this->GetServerVersion();
                $this->SetNames($properties);
                //add debug info
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                $tmp["time"] = __microtime();
                if (mysql_select_db($properties["database"], $this->_Res))
                {
                    $this->State = DB_CONNECTION_STATE_OPENED;
                    $tmp["description"] = "Changing DB to: ".$properties["database"];
                    $tmp["result"]="OK";
                }
               $tmp["time"] = __microtime()-$tmp["time"];
               $this->Properties = $properties;
           $this->Kernel->Debug->AddDebugItem("sql",$tmp);
            }   else    {
                die("Can't connect to DB: ".mysql_error());
            }

            return true;
        }


        /**
         * Sets names for current client connection.
         *
         * @access public
         * @param  array  connection properties
         * @return mixed  true if connection to server made in other
         *                case return false
         */

       function SetNames(&$properties){

          if((($this->_server_major_version == 4) &&
              ($this->_server_minor_version > 0)
             )  ||
             ($this->_server_major_version > 4)

              ) {
                $tmp["time"] = __microtime();

                if(!isset($properties["names"])){
                   $properties["names"] = MYSQL_CP_NAMES_DEFAULT;
                   $tmp["description"] = "Setting NAMES to DEFAULT: ".$properties["names"];
                } else {
                   $tmp["description"] = "Setting NAMES to: ".$properties["names"];

                }

                if(@mysql_query(sprintf("SET NAMES %s", $properties["names"]), $this->_Res)){
                    $tmp["result"]="OK";
                } else {
                    $tmp["result"]="Error";
                    $tmp["error"] = mysql_error();
                }

                $tmp["time"] = __microtime()-$tmp["time"];
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
             }
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
                                mysql_close($this->_Res);
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
            // Change state
            $tmp["description"] = "Changing DB to: ".$database;
            if ($this->State == DB_CONNECTION_STATE_OPENED) {

            $tmp["result"]="OK";
                        $tmp["time"] = __microtime();
                        mysql_select_db($database, $this->_Res);
                        $tmp["time"] = __microtime()-$tmp["time"];
                        $this->Properties["database"] = $database;
            //add debug info

            $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                return true;
            }
            else {
               $tmp["result"]="Error";
               $tmp["error"] = "Not opened";
               $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                return false;
            }
        }

       /**
        * Method returms last insert ID for specified table
        * @return   int     Increment value
        * @access   private
        ***/
        function GetLastInsertId(){
            return mysql_insert_id($this->_Res);
        }


       /**
        * Method returms last insert ID for specified table
        * @param    string   $string  String to escape
        * @return   string   Escaped string
        * @access   public
        ***/
        function EscapeString($string){
            return mysql_escape_string($string);
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
                $_res = mysql_query($query, $this->_Res);
                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["result"] = $_res ? "Ok":"Error";
                $tmp["error"] = mysql_error();
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
                $_res = mysql_query($query, $this->_Res);
                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["result"] = ($_res !== false ? "OK":"Error");
                $_num = mysql_num_rows($_res);
                $tmp["error"] = mysql_error();
                $tmp["records"] = $_num;
                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                $MySqlDataReader = new MySqlDataReader;
                $MySqlDataReader->RecordCount = $_num;
                $MySqlDataReader->FieldCount = mysql_num_fields($_res);
                $MySqlDataReader->queryId = $_res;
                $MySqlDataReader->state = DB_READER_STATE_OPENED;
                //$this->debug_array[] = $tmp;

                return $MySqlDataReader;
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
                $res = mysql_query($query, $this->_Res);
                $tmp["time"] = __microtime()-$tmp["time"];
                $tmp["error"] = mysql_error();
                if(!$res){
                    die(pr($tmp));

                }

                $num = @mysql_num_rows($res);
                $tmp["result"] = $res ? "Ok":"Error";
                $tmp["records"] = $num;

                $this->Kernel->Debug->AddDebugItem("sql",$tmp);
                if ($num > 0) {
                    $ret = mysql_fetch_array($res,MYSQL_ASSOC);
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
            if ($this->State == DB_CONNECTION_STATE_CONNECTED) {
               $server_info = explode(".", mysql_get_server_info(),3);
               $this->_server_major_version = (int)$server_info[0];
               $this->_server_minor_version = (int)$server_info[1];
               $this->_server_subversion = (string)$server_info[2];
            } else {
               parent::GetServerVersion();
            }
        }


    }

?>