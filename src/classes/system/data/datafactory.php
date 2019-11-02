<?php
/** @const CONNECTION_STRING_PATTERN Pattern of connection string*/
define('CONNECTION_STRING_PATTERN', '/(\w+):\/\/([^\/:]+)(:(\d*))?(\/([^\?]*))?(\?([^#]*))/');

/**
* Class works with connection to different servers
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Framework
* @subpackage classes.system.data
* @access public
*/
class DataFactory Extends Component {
	// Class information
	var $ClassName = "DataFactory";
	var $Version = "1.0";

	/**
	* Tries to open connection to specified database.
	*
	* @access public
	* @param  string  $connectionString connection string
	* @param  int           pointer to Kernel object
	* @return (object structure) Instance of connection class if connection is opened otherwise returns null
	*/
	static function &GetConnection($connectionString,&$KernelPointer) {
		list($driverName, $props) = DataFactory::GetConnectionProperties($connectionString);
		$className = $driverName . "connection";
		$driverPath = sprintf("system.data.%s.%s", $driverName, $className);
		if (!$KernelPointer->Exists($driverPath)) {
			// Error handling: to be done
			return null;
		}
		// Creating connection class
		$KernelPointer->Import($driverPath);
		@$obj = new $className;
		$obj->Kernel= &$KernelPointer;
		if (method_exists($obj, "GetDefaults")) {
			$tmp = $obj->GetDefaults();
			if(!empty($tmp)){
				foreach($tmp as $property => $value){
					if(!isset($props[$property])){
						$props[$property] = $value;
					}
				}
			}
		}
		// Open connection
		if (!$obj->Open($props)) {
			// Something wrong with connecting to database
			return null;
		}
		// Return connection object
		return $obj;
	}
	
	/**
	* Tries to get specified storage object.
	*
	* @access public
	* @param  object  $component            Component object
	* @param  string   $storageClassName    Name of storage class
	* @param  string   $storageVarName      Name of storage variable name
	* @param  bool     $forceParentize      Force assign storage variable to Page instance
	* @return AbstractTable                 Instance of storage class
	*/
	static function &GetStorage(&$component, $storageClassName, $storageVarName = "" , $forceParentize=true,$package = "") {
		if (strlen($storageVarName)!=0){
			if(!is_object($component->$storageVarName)){
				if(is_object($component->Page->$storageVarName) && ($component->Page->$storageVarName->ClassName == $storageClassName)){
					$component->$storageVarName = &$component->Page->$storageVarName;
				} else {
					$obj = DataFactory::GetStorageObject($component, $storageClassName, $package);
					if(($forceParentize) && (is_object($component->Page))){
						$component->Page->$storageVarName = &$obj;
					}
					$component->$storageVarName = &$obj;
					return $obj;
				}
			} else {
				return $component->$storageVarName;
			}
		}else{
			return DataFactory::GetStorageObject($component, $storageClassName, $package);
		}
	}

	static function &GetStorageObject(&$component, $storageClassName, $package = ""){
		$kernel=Kernel();
		$Connection=Connection();
		
		if(!class_exists($storageClassName)){
			$kernel->ImportClass("data.".strtolower($storageClassName), $storageClassName, $package);
		}
		$obj = new $storageClassName($kernel->Connection, $kernel->Settings->GetItem("database", $storageClassName));

		return $obj;
	}

	/**
	* Static mehod get properties of connection string
	* @access public
	* @param  object  $connectionString     Connection string
	* @return array                         Array contain values from connection string
	*/
	static function GetConnectionProperties($connectionString){
		// Try ty parse connection string
		if (!preg_match(CONNECTION_STRING_PATTERN, $connectionString, $matches)) {
			// Error handling: to be done
			return null;
		}
		$driverName = strtolower($matches[1]);
		// Changing properties
		if (strlen($matches[2])){
			$props["host"] = $matches[2];
		}
		if (strlen($matches[4])){
			$props["port"] = $matches[4];
		}
		
		if (strlen($matches[6])){
			$props["database"] = $matches[6];
		}
		$params = explode("&", $matches[8]);		
		foreach ($params as $param) {
			$pair = explode("=", $param);
			if (strlen($pair[0])){
				$props[$pair[0]] = trim($pair[1]);
			}
		}
		return array( $driverName,  $props);
	}

}  //--end of class
?>