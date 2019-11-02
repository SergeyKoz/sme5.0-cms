<?php
 $this->ImportClass("system.web.controls.checkbox","checkboxcontrol");
 $this->ImportClass("system.web.controls.dbfield","dbfieldcontrol");

/** DbRadioGroupControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DbCheckboxGroupControl extends DbFieldControl  {
		var $ClassName = "DbCheckboxGroupControl";
		var $Version = "1.0";
		/** Abstract table object
		* @var  PhoneTypesLibTable   $Storage
		*/
		var $Storage;
		/**  Array with phonetypes
		* @var    array   $types
		*/
		var $list;

		 /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>selected_value</b> - control selected value
          *           <li> <b>table</b>          - Storage name (in module.ini) for get values
          *           <li> <b>caption_field</b>  - Field name in storage where caption is
          *           <li> <b>method</b>         - Get method for get values )(default GetList)
          *           <li> <b>query_data</b>     - WHERE clause data array for get method {@see GetList()}
          *           <li> <b>orders</b>         - ORDER BY clause data array for get method {@see GetList()}
          *           <li> <b>caption</b>        - control caption
          *           <li> <b>multiple</b>       - draw multiple control , flag
          *           <li> <b>number</b>         - control number
          *           <li> <b>only_selected</b>  - draw only selected    values
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();
	/**
	 * Method  Executes on control load to the parent
	 * @access  private
	 */
	function ControlOnLoad(){
	  parent::ControlOnLoad();
	}
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
           $only_selected=$this->data["only_selected"];
	   $xmlWriter->WriteStartElement("checkboxgroup");
		  $this->XmlGetErrorFields($xmlWriter);

		  $xmlWriter->WriteElementString("caption", $this->data["caption"]);
		  if($this->data["notnull"]){
			$xmlWriter->WriteElementString("notnull", "1");
		  }
		  $tmp_data = $this->data;

		  for($i=0; $i<sizeof($tmp_data["options"]); $i++){
                          $checked = false;
                          $selected = (is_array($tmp_data["selected_value"])?$tmp_data["selected_value"]:array($tmp_data["selected_value"]));
                          if(in_array( $tmp_data["options"][$i]["value"], $selected))   $checked = true;
                           if (!$only_selected || $checked)    {
			        $this->data = array();
			        $this->data["name"] = $tmp_data["name"]."[]";
			        $this->data["value"] = $tmp_data["options"][$i]["value"];
			        $this->data["caption"] = $tmp_data["options"][$i]["caption"];
			        if ($tmp_data["options"][$i]["disabled"]!='')    $this->data["disabled"] = "yes";
			        if($checked)    $this->data["checked"] = "yes";
			        CheckboxControl::StaticXmlControlOnRender($this, $xmlWriter);
                           }
		  }
	   $xmlWriter->WriteEndElement();


	  //parent::XmlControlOnRender($xmlWriter);

   }

	function StaticXmlControlOnRender(&$object, &$xmlWriter) {
		$only_selected=$this->data["only_selected"];
		$xmlWriter->WriteStartElement("checkboxgroup");
		$object->XmlGetErrorFields($xmlWriter);

		$xmlWriter->WriteElementString("caption", $this->data["caption"]);
		if($object->data["notnull"])
			$xmlWriter->WriteElementString("notnull", "1");

		$tmp_data = $object->data;

		for($i=0; $i<sizeof($tmp_data["options"]); $i++){
			$checked = false;
			$selected = (is_array($tmp_data["selected_value"])?$tmp_data["selected_value"]:array($tmp_data["selected_value"]));
			if(in_array( $tmp_data["options"][$i]["value"], $selected))
				$checked = true;
			if (!$only_selected || $checked){
				$object->data = array();
				$object->data["name"] = $tmp_data["name"]."[]";
				$object->data["value"] = $tmp_data["options"][$i]["value"];
				$object->data["caption"] = $tmp_data["options"][$i]["caption"];
				if ($tmp_data["options"][$i]["disabled"]!='')
					$object->data["disabled"] = "yes";
				if($checked)
					$object->data["checked"] = "yes";
				CheckboxControl::StaticXmlControlOnRender($object, $xmlWriter);
			}
		}
		$xmlWriter->WriteEndElement();
	}


   }// class
?>