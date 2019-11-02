<?php

  /**
   * String class
   * @author Konstantin Matsebora<kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.types
   * @access public
   **/

class String	{
    
	/**
	  * String value
	  * @var	string	$value
	  **/
	var $Value;
	
	/**
	  * Class constructor
	  * @param	string	$value	string value	  	  
	  **/			  
	function String($value = null)	{
		$this->Set($value);
	}  
	
	/**
	  * Method replace /r/n for <BR>. If value = null, or not defined method parse $this->Value variable
	  * @param	string	$value	string value
	  * @return string			parsed string
	  **/	
	function ParseForBR($value=null)	{
		 if ($value != null)	{	
		 	$this->Set($value);		 	
		 }
		 return nl2br($this->Value);
	}
		
	/**
	  * Method set string class value
	  * @param	string	$value	string value	  	  
	  **/			  
	function Set($value)  {
	    $this->Value = $value;
	}    		
	
	/**
	  * Method get string class value
	  * @param	string	$value	string value	  	  
	  **/			  
	function Get() {
	    return $this->Value;
	}    
	
} //--end of class

?>