<?php
	$this->ImportClass('system.data.idatareader', 'IDatareader');

	/** Class contains base functionality for data reading
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.data.mysql
	 * @access public
	 */
	class MySqlDataReader extends IDataReader {
		// Class information
		var $ClassName = "IDataReader";
		var $Version = "1.0";

		// Public fields
		var $RecordCount;
		var $FieldCount;
		// Current record values
		var $Item;

		// Private fields
		// Query result id
		var $queryId = 0;
		// Current position in query
		var $currentRecord = 0;
		// Reader state
		var $state = DB_READER_STATE_CLOSED;

		/** Closes the SqlDataReader object. */
		function Close() {
			unset($this);
		}

		/** Gets a value indicating whether the data reader is closed. */
		function IsClosed() {
			if ($this->state == DB_READER_STATE_CLOSED) {
				return TRUE;
			}
			else {
				return false;
			}
		}

		/**
		*	Advances the DataReader to the next record. Return Value: true if there are more rows; otherwise, false.
		*  @return        mixed   Read items on success, false otherwise
		*/
		function Read() {
			if (($this->state == DB_READER_STATE_OPENED) && ($this->Item = mysql_fetch_array($this->queryId, MYSQL_ASSOC))) {
				$this->currentRecord++;
				return $this->Item;
			}
			else {
				$this->state = DB_READER_STATE_CLOSED;
				return false;
			}
		}

	}
?>