<? 
    /** @const PHPCODE_WRITER_STATUS_OPEN value **/   
   define("PHPCODE_WRITER_STATUS_OPEN", 1);
   /** @const PHPCODE_WRITER_STATUS_CLOSE value **/   
   define("PHPCODE_WRITER_STATUS_CLOSE", 0);
   
   /** Class represents single php code string writer	 
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 2.0
	 * @package Framework
	 * @subpackage classes.system.php
	 * @access public
	 **/
	class PHPCodeWriter {
	    
	    // Class information
		var $className = "PHPCodeWriter";
		
		var $version = "1.0";
		 /**
		  * Class status
		  * @var int $Status
		  **/		
		var $Status = 0;
		/**
		  * Public. stream with php code data 
		  * @var  string  $Strean
		  **/
		var $Stream;
		
		/**
		  * Method open PHP-code stream
		  * @access   public
		  **/
		function Open()   {
		    if ($this->Status == PHPCODE_WRITER_STATUS_CLOSE)    {		        
		      $this->Stream = '<? '.chr(10);
		      $this->Status = PHPCODE_WRITER_STATUS_OPEN;
		    }  
		}    
		
		/**
		  * Method add variable definition to php-stream
		  * @param    string  name    Variable name
		  * @param    mixed   value   Variable value
		  * @param    bool    $eval   Evaluate variable value after assignmen, or     not
		  * @access   public
		  **/
		function addVariable($name,$value,$eval = true)   {
		    $this->Open();
		    if ($eval)    {		        		        
		        $this->Stream .= '$'.$name.' = '.$this->prepareVariableString($value).';'.chr(10);
		        
		    } else    {		        
		        $this->Stream .= '$'.$name.' = $'.$value.";".chr(10);
		    }        
		}
		
		/**
		  * Method add include definition
		  * @param    string  path    Include file path		  
		  * @param    bool    $eval   Evaluate variable value after assignmen, or     not
		  * @access   public
		  **/
		function addInclude($path,$eval = true)   {
		    $this->Open();
		    if ($eval)    {		        		        
		        $this->Stream .= 'include('.$this->prepareVariableString($path).');'.chr(10);
		        
		    } else    {		        
		        $this->Stream .= 'include($'.$value.');'.chr(10);
		    }        
		}
		    
		/**
		  * Method prepare variable value string
		  * @param    string  value    Variable value
		  * @return   string           php-value string		  
		  * @access   private
		  **/
		function prepareVariableString($value) {
		    if (!is_array($value)) {
		        return '"'.addslashes($value).'"';
		    }    else {
		        $str = 'array('.chr(10);
		        foreach ($value as $key => $item) {
		            $str .= '"'. addslashes($key).'" => '.'"'.addslashes($item).'",'.chr(10);
		        }    
		        $str .= ")";
		    }    
		    return $str;
		}    
		
		/**
		  * Method close php-stream		  
		  * @access   public
		  **/
		function Close()  {
		   if ($this->Status == PHPCODE_WRITER_STATUS_OPEN)    {
		      $this->Stream .= ' ?>'.chr(10);
		      $this->Status = PHPCODE_WRITER_STATUS_CLOSE;
		    }   
		}    
						
		/**
		  * Method add already done php-code
		  * @param    string  $code   php code
		  * @access   public
		  **/
		function addCode($code)    {
		    $this->Stream .= $code.chr(10);
		}    
		
		/**
		  * Method get php-stream (stream close automaticaly)		  
		  * @access   public
		  **/
		function getStream()  {
		    $this->Close();
		    return $this->Stream;
		}    
	}	    
?>