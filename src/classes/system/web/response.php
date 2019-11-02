<?php

	/**
	 * Class contains base response functionality
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
   * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web
	 * @access public
	 */	
	class Response {
		// Class information
		var $className = "Response";
		var $version = "1.0";
        
		/**
		  * Page object
		  * @var Page $Page
		  **/
		var $_page;

		/**
        * Constructor. Assigns response object
        * @param   (object structure)  $page   Page instanse
        * @access   public
        */
		function Response(&$page) {
			@$this->_page = &$page;
		}

		/**
		 * Function make redirect to another page and stop
		 * processing current
		 *
		 * @param    string   $localtion URI with target page location
		 * @access   public
		 */
		function Redirect($location, $endResponse = true) {
			if (is_object($this->_page->Session)) {
				$this->_page->Session->Close();
			}
			header("Location: " . $location);
			if ($endResponse) {
				die();
			}
		}

		/**
		 * Function make page expiration equals to specifed time
		 * @param    int   $date expiration date (timestamp)
		 * @access   public
		 */
		function Expires($date) {
			header("Expires: " . gmdate("D, d M Y H:i:s \G\M\T", $date));
		}
	  //class
	} 
?>