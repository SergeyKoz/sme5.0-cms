<?php

/** Base Component class.
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 2.0
* @package Loader
* @subpackage classes
* @access public
**/
class Component {
	/**
	*  Class name
	* @var	string	$ClassName
	**/
	var $ClassName = "Component";
		
	/**
	*  Class version
	* @var  string  $Version
	**/
	var $Version = "2.0";
	
	protected static $Instance;
	
	/**
	* Method instantiates Error Class and adds messages for specified section
	* @param       string   $section    Section name
	* @param       string   $name       File name with messages
	* @param       mixed    $data       message data
	* @param       boolean  $warning    Warning message flag
	* @param       boolean  $user_error E_USER_ERROR message type (method only return message)
	* @return      mixed    $message    Return string message or function result
	* @access      public
	**/
	function AddErrorMessage($section, $name, $data = null,$warning = false, $user_error = false) {
		@$errClass =&Error::GetInstance();
		$pos = strpos($name, "{");
		if($pos!==false){
			$data = explode(",", substr($name, $pos+1,-1));
			$name = substr($name, 0, $pos);
		}
		return $errClass->AddMessage($section, $name, $data,$warning, $user_error);
	}
	/**
	* Method instantiates Error Class and adds warning messages for specified section
	* @param       string   $section Section name
	* @param       string   $name File name with messages
	* @param       mixed    $data  message data
	* @access      public
	**/
	function AddWarningMessage($section,$name,$data = null)	{
		$this->AddErrorMessage($section,$name,$data,true);
	}
	
	/**
	* Method instantiates Error Class
	* @return      array    Messages array
	* @access      public
	**/
	function GetErrorMessages() {
		@$errClass = &Error::GetInstance();
		return $errClass->Messages;
	}
	
	/**
	* Method instantiates warnings form Error Class
	* @return      array    Messages array
	* @access      public
	**/
	function GetWarningMessages() {
		@$errClass = &Error::GetInstance();
		return $errClass->WarningMessages;
	}

	/**
	* Method instantiates Error Class and check if there is such error message
	* @param       string   $section Section name
	* @param       string   $name File name with messages
	* @return      bool     true if has, false - otherwise
	* @access      public
	**/
	function &HasErrorMessage($section, $name) {
		@$errClass = &Error::GetInstance();
		$pos = strpos($name, "{");
		if($pos!==false){
			$name = substr($name, 0, $pos);
		}
		return $errClass->HasMessage($section, $name);
	}

	/**
	* Method returns string representation of class information
	* @return      string    Class info
	* @access      public
	**/
	function ToString() {
		return "Class: [" . $this->ClassName . "]; Version: [" . $this->Version . "]";
	}

	/**
	* Метод вычисляет интервал между двумя временами.
	* Возвращает его в секундах (до трех знаков после запятой)
	* @param string $starttime Время старта
	* @param string $endtime Время окончания
	* @return double Временной интервал
	* @access public
	**/

	function Get_Interval($starttime,$endtime, $precision=3)   {
		list($stsec, $stmsec) = explode(" ",$starttime);
		list($endsec, $endmsec) = explode(" ",$endtime);
		$time_start=((float)$stsec + (float)$stmsec);
		$time_end=((float)$endsec + (float)$endmsec);
		return  number_format(($time_end - $time_start),$precision,".","");
	}

	/**
	* Method strip commas in string
	* @param		string		$str		input string
	* @return	string						output string
	* @access public
	**/
	function StripCommas($str){
		if(substr($str,0,1)==","){
			$str = substr($str,1);
		}
		if(substr($str,-1, 1)==","){
			$str = substr($str,0, -1);
		}
		return $str;
	}


	/**
	* Method parse text and cut denied tags
	* @param		string		$text		input text
	* @return											output text
	* @access		public
	**/
	function ParseText($text){
		$enabled_tags = array(
			"P",
			"FONT",
			"UL",
			"LI",
			"OL",
			"STRONG",
			"U",
			"EM",
			"I",
			"BR",
			"B",
			"HR"
			);

		$filter = array(
			"/\</",
			);

		$replacement = array(
			"&lt;",
			);


		$random_delimiter = "_".rand(100000,999999)."_";
		for($i=0; $i<sizeof($enabled_tags); $i++){
			$start_patterns[$i] = "/\<".$enabled_tags[$i]."\s?/";
			$start_replacement[$i] = "".$random_delimiter.$enabled_tags[$i]."";
			$back_start_patterns[$i] = "/".$start_replacement[$i]."/";
			$back_start_replacement[$i] = "<".$enabled_tags[$i]." ";


			$end_patterns[$i] = "/<\/".$enabled_tags[$i].">/";
			$end_replecement[$i] = "".$random_delimiter."_".$enabled_tags[$i].$random_delimiter."";
			$back_end_patterns[$i] = "/".$random_delimiter."_".$enabled_tags[$i].$random_delimiter."/";
			$back_end_replacement[$i] = "</".$enabled_tags[$i].">";
		}




		$text = preg_replace($start_patterns, $start_replacement, $text);
		$text = preg_replace($end_patterns, $end_replecement, $text);

		$text = preg_replace($filter, $replacement, $text);

		$text = preg_replace($back_start_patterns, $back_start_replacement, $text);
		$text = preg_replace($back_end_patterns, $back_end_replacement, $text);


		return $text;
	}


	/**
	* Method convert datetime string to format "dd.mm.yyyy hh:mm:ss"
	* @param		string		$date				datetime string
	* @param		boolean		$fulldate		full date (with time) flag
	* @param		boolean		$is_unix_timestamp		is unix timestamp

	* @return	string		converted string
	* @access	public
	**/
	static function dateconv($date, $fulldate=false, $is_unix_timestamp=false){
		$DatePattern="d.m.Y";
		$FullDatePattern="d.m.Y H:i:s";
		$pattern = ($fulldate ? $FullDatePattern : $DatePattern);

		if(!$is_unix_timestamp){
			list($date, $time) = explode(" ", $date);
			list($year, $month, $day) = explode("-", $date);
			list($hour, $minute, $second) = explode(":", $time);

			if($year == $date){
				$year = substr($date,0,4);
				$month = substr($date,4,2);
				$day = substr($date,6,2);
				$time = substr($date,8,2).":".substr($date,10,2).":".substr($date,12,2);
			}
			return ($year=="" || $month=="" || $day=="" ? "" : date($pattern, mktime((int)$hour, (int)$minute, (int)$second, (int)$month, (int)$day, (int)$year)));
		} else {
			return date($pattern, $date);
		}
	}


	function getUnixTimeStamp($string="", $order=null){
		list($date, $time) = explode(" ", $string, 2);
		$times = array(0,0,0);
		$dates = array(0,0,0);

		if($time != ""){
			$times = explode(":", $time, 3);
		}
		if($date != ""){
			$dates = preg_split("/[.\/-]/", $date, 3);
		}

		if($order === null){
			if(strspn($date, "0123456789") == 2){
				$order = "d";
			}
		}
		if($order !="d"){
			$timestamp = mktime($times[0],$times[1],$times[2], $dates[1], $dates[2], $dates[0]);
		} else {
			$timestamp = mktime($times[0],$times[1],$times[2], $dates[1], $dates[0], $dates[2]);
		}
		return $timestamp;

	}

	/**
	* Method set object variable(s) from value or array of values
	* @param		mixed		$varvalue		variable value or associative array  of values
	* @param		string	$varname		variable name
	**/
	function setVariable($varname=null,$varvalue){
		if ($varname!=null)	{
			$this->$varname=$varvalue;
		}else{
			if (count($varvalue)){
				foreach ($varvalue as $_varname => $_varvalue){
					$this->$_varname=$_varvalue;
				}
			}
		}
	}

	/**
	* Method biulds request URL for passing to search handler
	* @param      array        $data      Array with request data
	* @return     string      QUERY_STRING
	* @access     public
	**/
	static function BuildRequestQuery($data, $amp="&"){
		$str="";
		if(!empty($data)){
			foreach($data as $name => $value){
				if(is_array($value)&&!empty($value)){
					foreach($value as $sub_name =>$array_value){
						if(!empty($array_value)){
							$str .=$amp."".$name."[]=".$array_value;
						}
					}//foreach #2
				}//is_array
				else {
					if($value != ""){
						$str .=$amp."".$name."=".$value;
					}
				}
			}// foreach #1
		} // !empty
		return $str;
	}
  
	/**
	* Method converts localization options to select options list
	* @param	array	$options	Localization options
	* @return	array	Array of select options
	* @access	public
	**/
	function fromConfigOptionsToSelect($options){
		$_options=array();
		for ($i=0;$i<sizeof($options);$i++)	{
			list($caption,$value)=preg_split("/[|]/",$options[$i]);
			$_options[$i]["value"]=$value;
			$_options[$i]["caption"]=$caption;
		}
		return $_options;
	}

	/**
	* Method set object variable
	* @param string  $name       variable name
	* @param mixed   $variable   variable value
	**/
	function setObjectVariable($name,&$variable) {
		$this->$name=&$variable;
	}
	
	function safeMethodCall($methodName, $args) {
		if (method_exists($this, $methodName)) {
			call_user_func_array(array(&$this, $methodName), $args);
		}
	}

//end of class
}
?>
