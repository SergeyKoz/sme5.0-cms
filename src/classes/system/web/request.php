<?php
/** @const REQUEST_QUERYSTRING REQUEST QUERYSTRING Flag*/
define("REQUEST_QUERYSTRING", 1);
/** @const REQUEST_FORM REQUEST FORM Flag*/
define("REQUEST_FORM", 2);
/** @const REQUEST_COOKIES REQUEST COOKIES Flag*/
define("REQUEST_COOKIES", 4);
/** @const REQUEST_SERVERVARIABLES REQUEST SERVER VARIABLES Flag*/
define("REQUEST_SERVERVARIABLES", 8);
/** @const REQUEST_FILES REQUEST FILES Flag*/
define("REQUEST_FILES", 16);
/** @const REQUEST_USERDATA REQUEST USERDATA Flag */
define("REQUEST_USERDATA", REQUEST_QUERYSTRING | REQUEST_FORM);
/** @const REQUEST_ALL REQUEST ALL Flag*/
define("REQUEST_ALL", REQUEST_QUERYSTRING | REQUEST_FORM | REQUEST_COOKIES | REQUEST_SERVERVARIABLES);

/** Class holds all browser input
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
* @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 1.0
* @package Framework
* @subpackage classes.system.web
* @access public
*/
class Request {
	// Class information
	var $className = "Request";
	var $version = "1.0";

	/**
	* Cookies collection
	* @var array $Cookies
	**/
	var $Cookies;

	/**
	* Query string
	* @var array $QueryString
	**/
	var $QueryString;

	/**
	* Form data collection
	* @var array $Form
	**/
	var $Form;

	/**
	* Server variables collection
	* @var array $ServerVariables
	**/
	var $ServerVariables;

	/**
	* Posted by form files collection
	* @var array $Files
	**/
	var $Files;

	/**
	* Constructor. Make collections initialization
	* @access    public
	*/
	function Request() {
		$this->Cookies = $_COOKIE;
		$this->QueryString = $_GET;
		$this->Form = $_POST;
		$this->ServerVariables = $_SERVER;
		$this->Files = $_FILES;
	}

	/**
	* Method prepares array values
	* @param   mixed   $value             value to be checked
	* @param        boolean    $reindex        Reindex array flag
	* @return  mixed   correct value
	* @access   private
	**/
	function prepareArray($array, $reindex=true){
		$result = array();
		if(!empty($array)){
			foreach($array as $_key => $value){
				if(is_array($value)){
					if($reindex){
						$result[] = $this->prepareArray($value, $reindex);
					} else {
						$result[$_key] = $this->prepareArray($value, $reindex);
					}
				} else {
					if($reindex){
						$result[] = stripslashes($value);
					} else {
						$result[$_key] = stripslashes($value);
					}
				}
			}
		}
		return $result;
	}

	static function staticPrepareArray($array, $reindex=true){
		$result = array();
		if(!empty($array)){
			foreach($array as $_key => $value){
				if(is_array($value)){
					if($reindex){
						$result[] = Request::staticPrepareArray($value, $reindex);
					} else {
						$result[$_key] = Request::staticPrepareArray($value, $reindex);
					}
				} else {
					if($reindex){
						$result[] = stripslashes($value);
					} else {
						$result[$_key] = stripslashes($value);
					}
				}
			}
		}
		return $result;
	}


	/**
	* Check for magic quotesm, if variable is array
	* check for quotas in array.
	*
	* @param   mixed   $value          value to be checked
	* @param       boolean $reindex        Reindex array flag
	* @return  mixed   correct value
	* @access   private
	*/
	function prepareValue($value,$reindex=true) {
		if (get_magic_quotes_gpc()){
			if (is_array($value)){
				$result = array();
				$result = $this->prepareArray($value, $reindex);
				return $result;
			}else{
				return stripslashes($value);
			}
		}else{
			return $value;
		}
	}

	static function staticPrepareValue($value,$reindex=true) {
		if (get_magic_quotes_gpc()){
			if (is_array($value)) {
				$result = array();
				$result = Request::staticPrepareArray($value, $reindex);
				return $result;
			}else{
				return stripslashes($value);
			}
		}else{
			return $value;
		}
	}

	function ForceEvent($event){
		$this->QueryString["event"]=$event;
	}

	/**
	* Function searches specified varible in user request.
	* Search sequence RequestString, Form, Cookies,
	*
	* @param     string   $name            Name of variable to be searched
	* @param     int      $requestType type of collection to be searched
	* @param           boolean  $reindex     Reindex array flag
	* @return    mixed    value of specified variable or nulll if variable is not found
	* @access    public
	**/
	function Value($name, $requestType = REQUEST_ALL,$reindex = true) {
		if ($this->className == "Request"){ //-- not static
			if (($requestType & REQUEST_QUERYSTRING) && isset($this->QueryString[(string)$name])){
				return $this->prepareValue($this->QueryString[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_FORM) && isset($this->Form[(string)$name])){
				return $this->prepareValue($this->Form[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_COOKIES) && isset($this->Cookies[(string)$name])){
				return $this->prepareValue($this->Cookies[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_SERVERVARIABLES) && isset($this->ServerVariables[(string)$name])){
				return $this->ServerVariables[(string)$name];
			}
			if (($requestType & REQUEST_FILES) && isset($this->Files[(string)$name])){
				return $this->Files[(string)$name];
			}
			return null;
		} else  { // static
			return Request::GlobalsValue($name, $requestType,$reindex);
		}
	}

	static function StaticValue(&$object, $name, $requestType = REQUEST_ALL,$reindex = true) {
		if ($object->className == "Request"){ //-- not static
			if (($requestType & REQUEST_QUERYSTRING) && isset($object->QueryString[(string)$name])){
				return Request::staticPrepareValue($object->QueryString[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_FORM) && isset($object->Form[(string)$name])){
				return Request::staticPrepareValue($object->Form[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_COOKIES) && isset($object->Cookies[(string)$name])){
				return Request::staticPrepareValue($object->Cookies[(string)$name],$reindex);
			}
			if (($requestType & REQUEST_SERVERVARIABLES) && isset($object->ServerVariables[(string)$name])){
				return $object->ServerVariables[(string)$name];
			}
			if (($requestType & REQUEST_FILES) && isset($object->Files[(string)$name])){
				return $object->Files[(string)$name];
			}
			return null;
		} else  { // static
			return Request::staticGlobalsValue($name, $requestType,$reindex);
		}
	}

	/**
	* Function searches specified varible in GLOBALS variable (used for static calling)
	*
	* @param     string   $name            Name of variable to be searched
	* @param     int      $requestType     type of collection to be searched
	* @param     boolean  $reindex         Reindex array flag
	* @return    mixed    value of specified variable or nulll if variable is not found
	* @access    public
	**/

	function GlobalsValue($name, $requestType = REQUEST_ALL,$reindex = true) {
		if (($requestType & REQUEST_QUERYSTRING) && isset($_GET[(string)$name])){
			return $this->prepareValue($_GET[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_FORM) && isset($_POST[(string)$name])){
			return $this->prepareValue($_POST[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_COOKIES) && isset($_COOKIE[(string)$name])){
			return $this->prepareValue($_COOKIE[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_SERVERVARIABLES) && isset($_SERVER[(string)$name])){
			return $_SERVER[(string)$name];
		}
		if (($requestType & REQUEST_FILES) && isset($_FILES[(string)$name])){
			return $_FILES[(string)$name];
		}
		return null;
	}

	static function staticGlobalsValue($name, $requestType = REQUEST_ALL,$reindex = true) {
		if (($requestType & REQUEST_QUERYSTRING) && isset($_GET[(string)$name])){
			return Request::staticPrepareValue($_GET[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_FORM) && isset($_POST[(string)$name])){
			return Request::staticPrepareValue($_POST[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_COOKIES) && isset($_COOKIE[(string)$name])){
			return Request::staticPrepareValue($_COOKIE[(string)$name],$reindex);
		}
		if (($requestType & REQUEST_SERVERVARIABLES) && isset($_SERVER[(string)$name])){
			return $_SERVER[(string)$name];
		}
		if (($requestType & REQUEST_FILES) && isset($_FILES[(string)$name])){
			return $_FILES[(string)$name];
		}
		return null;
	}



	/**
	* Function return string representatin of the specified
	* value using specified rules
	*
	* @param    string   $name       name of variable to be searched
	* @param    string   $default    default value return if varialbe not found
	* @param    int      $min        minimum string length
	* @param    int      $max        maximum string length
	* @param    bool     $stripWhite strip or not leading and trailing spaces
	* @param    int      $case       0 - no translation, 1 -  translate to upper case, 2 - translate to lower case
	* @return   string   value of specified variable or $default value if variable is not found
	* @access public
	*/
	function ToString($name, $default = null, $min = null, $max = null, $stripWhite = true, $case = 0) {
		// Retrive value
		$value = $this->Value($name, REQUEST_USERDATA);
		// Value is of string?
		if (is_null($value)){
			return $default;
		}
		// Stripping leading and trailing whitespaces
		if ($stripWhite){
			$value = trim($value);
		}
		// Processing value to upper or lower if needed
		if ($case == 1){
			$value = strtoupper($value);
		}elseif ($case == 2){
			$value = strtolower($value);
		}
		// Checking if string is not out of bounds
		if (((int)$max > 0) && (strlen($value) > (int)$max)) {
			$value = substr($value, 0, (int)$max - 1);
			return $value;
		}
		if (((int)$min > 0) && (strlen($value) < (int)$min)){
			return $default;
		}
		return $value;
	}

	/**
	* Function return number representatin of the specified
	* value using specified rules
	*
	* @param    string    $name       name of variable to be searched
	* @param    int       $default    default value return if varialbe not found
	* @param    int       $min        minimum number value
	* @param    int       $max        maximum number value
	* @return   int       value of specified variable or $default value if variable is not found
	* @access   public
	*/
	function ToNumber($name, $default = null, $min = null, $max = null) {
		// Retrive value
		$value = $this->Value($name, REQUEST_USERDATA);
		// Value is of string?
		if (is_null($value)){
			return $default;
		}
		$value = (int)$value;
		// Checking if string is not out of bounds
		if (((int)$max > 0) && ($value > (int)$max)){
			return $default;
		}
		if (((int)$min > 0) && ($value < (int)$min)){
			return $default;
		}
		return $value;
	}
	/**
	* Method returns formatted date and time in string representation
	* @param    string   $prefix  prefix of date and time variables names
	* @return   string   formatted string with date and time
	* @access   public
	*/
	function ToDateTime($prefix) {
		$year = $this->ToNumber($prefix . "Year", 1900, 1900);
		$month = $this->ToNumber($prefix . "Month", 1, 1, 12);
		$day = $this->ToNumber($prefix . "Day", 1, 1, 31);
		$hour = $this->ToNumber($prefix . "Hour", 0, 0, 23);
		$minute = $this->ToNumber($prefix . "Minute", 0, 0, 59);
		$second = $this->ToNumber($prefix . "Second", 0, 0, 59);
		return sprintf("%04d-%02d-%02d %02d:%02d:%02d", $year, $month, $day, $hour, $minute, $second);
	}

	/**
	* Method returns formatted date and time in string representation
	* @param    string   $prefix  prefix of date and time variables names
	* @return   string   formatted string with date and time
	* @access   public
	*/
	function ToDate($prefix, $default=null) {
		if($default!==null){
			list($_dyear, $_dmonth, $_dday) = explode("-",$default);
		} else {
			list($_dyear, $_dmonth, $_dday) = array(0,0,0);
		}
		$year = $this->ToNumber($prefix . "_year", $_dyear, 1900);
		$month = $this->ToNumber($prefix . "_month", $_dmonth, 1, 12);
		$day = $this->ToNumber($prefix . "_day", $_dday, 1, 31);
		return sprintf("%04d-%02d-%02d", $year, $month, $day);
	}

	/**
	* Method returns timestamp of date and time
	* @param    string   $prefix  prefix of date and time variables names
	* @return   string   timestamp
	* @access   public
	*/
	function ToTimeStamp($prefix)   {
		$year = $this->ToNumber($prefix . "Year", 1900, 1900);
		$month = $this->ToNumber($prefix . "Month", 1, 1, 12);
		$day = $this->ToNumber($prefix . "Day", 1, 1, 31);
		$hour = $this->ToNumber($prefix . "Hour", 0, 0, 23);
		$minute = $this->ToNumber($prefix . "Minute", 0, 0, 59);
		$second = $this->ToNumber($prefix . "Second", 0, 0, 59);
		return mktime($hour , $minute, $second, $month , $day,   $year);
	}

	/**
	* Method set specified variable in user request.
	* Variable can be set a sequence RequestString, Form, Cookies,
	*
	* @param     string   $name    Name of variable to be searched
	* @param           mixed        $value     Value of variable
	* @param     int      $requestType type of collection
	* @access    public
	**/
	function SetValue($name,$value,$requestType=REQUEST_QUERYSTRING){
		if ($requestType & REQUEST_QUERYSTRING){
			$this->QueryString[(string)$name]=$value;
		}
		if ($requestType & REQUEST_FORM){
			$this->Form[(string)$name]=$value;
		}
		if ($requestType & REQUEST_COOKIES){
			$this->Cookies[(string)$name]=$value;
		}
		if ($requestType & REQUEST_SERVERVARIABLES){
			$this->ServerVariables[(string)$name]=$value;
		}
		if ($requestType & REQUEST_FILES){
			$this->Files[(string)$name]=$value;
		}
	}

	/**
	* Method return global variable (if not defined in any _(POST,GET,COOKIE) arrays)
	* @param    string    $name   variable name
	* @return   mixed             variable  value
	**/
	function &globalValue($name) {
		global $$name;
		$value=$$name;
		if (
		!($this->Cookies[$name] == $value) ||
		!($this->QueryString[$name] == $value)  ||
		!($this->Form[$name] == $value)
		){
			return $value;
		}else{
			return null;
		}
		return $$name;
	}

} //class
?>