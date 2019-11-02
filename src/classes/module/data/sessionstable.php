<?php
	$this->ImportClass("system.data.abstracttable", "AbstractTable");
 /**
	 * Session table class
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.module.data
	 * @access public
	 **/
   
	class SessionsTable extends AbstractTable {
		/**
			* Class constructor
			* @param  object    Connection object
			* @access public
		 */

		function SessionsTable(&$Connection, $sessionsTable) {
			AbstractTable::AbstractTable($Connection, $sessionsTable);
		}

  /**
   * Method prepare columns array
   * @access  public
  */
		function prepareColumns() {
			$this->columns[] = array("name" => "SessionName", "type" => DB_COLUMN_STRING, "key" => true);
			$this->columns[] = array("name" => "RemoteAddr",  "type" => DB_COLUMN_STRING, "key" => true);
			$this->columns[] = array("name" => "SessionTime", "type" => DB_COLUMN_STRING, "dtype"=>"string", "length"=>100 );
			$this->columns[] = array("name" => "SessionData", "type" => DB_COLUMN_STRING, "dtype"=>"string", "length"=>1000);
		}

	}
?>
