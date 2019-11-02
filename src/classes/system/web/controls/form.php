<?php
$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
/** Form control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class FormControl extends XmlControl {
		var $ClassName = "FormControl";
		var $Version = "1.0";

		function FormControl($name, $xmlTag,$data = array()) {
			parent::XmlControl($name,$xmlTag);
		}

		/**
		* Method gets error fields from parent page and draws error xml-content
		*  @param	XMLWriter	$xmlWriter	Instance of Writer object
		* @access	public
		*/
		function XmlGetErrorFields(&$xmlWriter)
		{
			if((isset($this->Page->validator->formerr_arr[$this->Name]) &&  ($this->Page->validator->formerr_arr[$this->Name] > 0))
			   || ($this->Page->validator->formerr_arr[$this->XmlTag] > 0))
			{
				$xmlWriter->WriteStartElement("error_field");
					$xmlWriter->WriteString($this->Name);
				$xmlWriter->WriteEndElement();

			}

		}
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		   $xmlWriter->WriteStartElement("name");
			   $xmlWriter->WriteString($this->data["name"]);
		   $xmlWriter->WriteEndElement();
		   $xmlWriter->WriteStartElement("action");
			   $xmlWriter->WriteString($this->data["action"]);
		   $xmlWriter->WriteEndElement();
		   $xmlWriter->WriteStartElement("target");
			   $xmlWriter->WriteString($this->data["target"]);
		   $xmlWriter->WriteEndElement();
		   $xmlWriter->WriteStartElement("method");
			   $xmlWriter->WriteString($this->data["method"]);
		   $xmlWriter->WriteEndElement();
		   $xmlWriter->WriteStartElement("onsubmit");
			   $xmlWriter->WriteString($this->data["onsubmit"]);
		   $xmlWriter->WriteEndElement();

   }

   /**
     * Method write language version to control
      *  @param XMLWriter    $xmlWriter  instance of XMLWriter
  		 *  @access private
     * @return    string    output string
     */
   function WriteLanguageVersion(&$xmlWriter)	{

   }
   /**
   	 * Smart cut string (cut after symbol)
     * @param		string	input string
     * @param		int			output string length
     * @param    string  cut symbol
     * @return	string	output string
     */
   function cutString($str,$length=60,$symbol=" ")	{
   	if(strlen($str)<=$length)   return $str;
   	$str=substr($str,0,$length);
   	if($str[$length]==$symbol)	return $str."...";
  	$spos=strrpos($str,$symbol);
   	if($spos!=0)	{
    	return substr($str,0,$spos)."...";
    }	else	{
     return $str."...";
   	}
   }


   /**
   	 * Method get control parameter of form field from input parameter or from configuration files input parameter, and set for current field
     * @param   string  $parameter    parameter name
     * @param		string	$configvar		configuration variable name
     * @param		mixed		$value				parameter value
     * @access private
     **/
   function setControlParameter($parameter,$configvar,$value)	{
   	 if (strlen($value)==0) 	{
        if($this->Page->Kernel->Settings->HasItem($this->Page->ClassName, "Text_".$this->data["name"])){
        $this->data[$parameter] = $this->Page->Kernel->Settings->GetItem($this->Page->ClassName, "Text_".$this->data["name"]);

       } else {
        if ($this->Page->Kernel->Package->Settings->HasItem("MAIN", $configvar))
          $this->data[$parameter] = $this->Page->Kernel->Package->Settings->GetItem("MAIN", $configvar);
       }
    }	else	{
    	 $this->data[$parameter]=$value;
    }
   }

   /**
   	 * Method set defined  in array controls data
     * @param		array		$data		data associative array
     * @access	public
     **/
   function SetControl($data)	{
   	if (sizeof($data)!=0)	{
    	foreach($data as $_key => $_value)	$this->data[$_key]=$_value;
    }
   }

    /**
      * Method convert associative array to options array ("value" - key, "caption" - value)
      * for group controls as dbselect,select,radiogroup, etc.
      * Static method.
      * @param    array      $data      input data array
      * @param    boolean    $revert    use revert logic flag ("value" - value, "caption" - key)
      * @return    array                options array
      **/
    function ToOptionsArray($data,$revert=false)  {
         $options=array();
         $i=0;
         if (sizeof($data))  {
           foreach($data as $key => $value)  {
            if (!$revert)  {
                  $options[$i]["caption"] = $value;
                  $options[$i]["value"] =   $key;
            }    else  {
                  $options[$i]["caption"] = $key;
                  $options[$i]["value"] = $value;
            }
            $i++;
           }
         }
      return $options;
    }

}// class
?>