<?php

 /**
 	 * Error messages handling class
	 * @author Sergey Grishko <sgrishko@reaktivate.com>
  	 * @modified	Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 2.0
	 * @package Loader
	 * @subpackage classes
	 * @access public
	 */
	class Error {
    /**
    *  Class name
    * @var  string  $ClassName
    **/
		var $ClassName = "Error";
  /**
    *  Class version
    * @var  string  $Version
    **/
		var $Version = "1.0";
    /**
    	* Messages array
      * @var	array	$Messages
      **/
		var $Messages = array();
    /**
      * System messages array
      * @var  array  $SystemMessages
      **/
		var $SystemMessages;

   /**
    * Method initializes SystemMessage property  with Class instance
    * @access          public
    **/
	 function Error(){
		$this->SystemMessages = &ConfigFile::GetInstance("errorMessages");
	 }

   /**
    * Method adds messages to specified section
    * @param       string   $section    Section name
    * @param       string   $name 		  File name with messages
    * @param       mixed    $data  		  message data
    * @param			 boolean	$warning	  Warning message flag
    * @param       boolean  $user_error E_USER_ERROR message type (method only return message)
    * @return      mixed    $message    Return string message or function result
    * @access      public
	**/
	function AddMessage($section, $name, $data = null,$warning=false,$user_error = false) {
		if (is_object($this->SystemMessages))	{
			$cb = $this->SystemMessages->GetItem($section, $name);
			if (!is_array($data)) {
				$cb = str_replace("{1}", $data, $cb);
			} else {
				$i = 1;
				while (list(,$value) = each ($data)) {
					$cb = str_replace("{" . $i. "}", $value, $cb);
					$i++;
				}
			}
		}
		if (!$user_error){
			if (!$warning)	{
				$this->Messages[$section][$name] = $cb;
			} else {
				$this->WarningMessages[$section][$name] = $cb;
			}
		} else{
			return $cb;
		}
	}



   /**
	* Method checks if there is such error message
	* @param       string   $section Section name
	* @param       string   $name File name with messages
	* @return      bool     True if has, false - otherwise
	* @access      public
	**/
		function HasMessage($section, $name) {
			return $this->SystemMessages->HasItem($section, $name);
		}
   /**
    * Method gets an instance of ErrorObject
    * @return      (object structure) Error Object instance
    * @access      public
    **/
		static function &GetInstance() {
			$errorObject = &$GLOBALS["errorMessages"];
			if (!is_object($errorObject) || get_class($errorObject) != "Error") {
				$errorObject = new Error();
				@$GLOBALS["errorMessages"] = &$errorObject;
			}
			return $errorObject;
		}
	}

?>