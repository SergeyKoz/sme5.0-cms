<?php

    /** @const DB_CONNECTION_STATE_CLOSED Flag of closed state DB connection*/
	define('DB_CONNECTION_STATE_CLOSED', 1);
	/** @const DB_CONNECTION_STATE_CONNECTED Flag of connected state DB connection*/
	define('DB_CONNECTION_STATE_CONNECTED', 2);
	/** @const DB_CONNECTION_STATE_OPENED Flag of opened state DB connection*/
	define('DB_CONNECTION_STATE_OPENED', 3);

	/**
    * Abstract class which works with connection to SQL server
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
	 * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.data
	 * @access public
	 */
	class IConnection extends Component {
		// Class information
		var $ClassName = "IConnection";
		var $Version = "1.0";
		/**
      * Connection properties
      * @var	array	$Properties
	  */
		var $Properties;
      /**
      * Connection state
      * @var	int	$State
      */
		var $State = DB_CONNECTION_STATE_CLOSED;
	  /**
      * Array with debug info
      * @var  array	$debug array
      */
		var $debug_array = array();

        /**
        * Major server version
        * @var  int    $_server_major_version
        **/
        var $_server_major_version;

        /**
        * Minor server version
        * @var  int    $_server_minor_version
        **/
        var $_server_minor_version;

        /**
        * Server subversion
        * @var  string    $_server_subversion
        **/
        var $_server_subversion;

		/**
		 * Opens connection to specified MySQL server and processing
		 * selection of database. Also raises error if somthing goes
		 * wrong. And if any of arguments are empty strings replaces
		 * them with predefined constants.
		 *
		 * @access public
		 * @param  array  connection properties
		 * @return bool   true if connection to server made in other
		 *                case return false
		 */
		function Open($properties = null) {
			$this->State = DB_CONNECTION_STATE_OPENED;
            $this->GetServerVersion();
			return true;
		}

		/**
		 * Closes connection.
		 *
		 * @access public
		 * @return void
		 */
		function Close() {
			$this->State = DB_CONNECTION_STATE_CLOSED;
		}

		/**
		 * Changes current database.
		 *
		 * @access public
		 * @param  string  database name
		 * @return void
		 */
		function ChangeDatabase($database) {
			// Change state
			$this->State == DB_CONNECTION_STATE_OPENED;
			$this->Properties["database"] = $database;
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
			return null;
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
			return null;
		}

		function ReaderToArray($reader)
		{
		    $result = array();
		    if (!is_object($reader)) {
		        return false;
		    }
            while($item = $reader->Read()) {
                if (isset($item['ARRAY_KEY'])) {
                    $result[$item['ARRAY_KEY']] = $item;
                } else {
                    $result[] = $item;
                }
            }
            return $result;
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
			return array();
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
            $this->_server_major_version = 0;
            $this->_server_minor_version = 0;
            $this->_server_subversion = 0;
        }

	}

?>