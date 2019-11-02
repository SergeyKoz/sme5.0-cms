<?php
    /** @const DB_READER_STATE_CLOSED Closed state constant */
	define("DB_READER_STATE_CLOSED", 1);
	/** @const DB_READER_STATE_OPENED Opened state constant */
    define("DB_READER_STATE_OPENED", 2);

	/**
     * Class contains base functionality for data reading
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.data
	 * @access public
	 */
	class IDataReader extends Component {
		var $ClassName = "IDataReader";

		var $Version = "1.0";
       /**
         *Records count
         *@var string $RecordCount
         */
		var $RecordCount;
        /**
         *Fields count
         *@var string $FieldsCount
         */
		var $FieldCount;
       /**
         * Current record values
         * @var array $Item
         */
		var $Item;
       /**
         * Reader state
         * @var int $state
         */
        var $state = DB_READER_STATE_CLOSED;

		/**
      * Closes the SqlDataReader object. (prototype)
      * @access public
      */
		function Close() {
		}

		/**
      * Gets a value indicating whether the data reader is closed. (prototype)
      */
		function IsClosed() {
		}

		/**
		 *	Advances the DataReader to the next record.
		 *	Return Value: true if there are more rows; otherwise, false. (prototype)
     *  @access public
		*/
		function Read() {
		}

	}
?>