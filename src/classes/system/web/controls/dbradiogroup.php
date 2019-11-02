<?php
 $this->ImportClass("system.web.controls.radio","radiocontrol");
 $this->ImportClass("system.web.controls.dbfield","dbfieldcontrol");

/** DbRadioGroupControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DbRadioGroupControl extends DbFieldControl {
		var $ClassName = "DbRadioGroupControl";
		var $Version = "1.0";
		/**  Phonetypes table object
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

	   $xmlWriter->WriteStartElement("radiogroup");
		  $this->XmlGetErrorFields($xmlWriter);

		  $xmlWriter->WriteElementString("caption", $this->data["caption"]);
		  if($this->data["notnull"]){
			$xmlWriter->WriteElementString("notnull", "1");
		  }
		  $tmp_data = $this->data;

		  for($i=0; $i<sizeof($tmp_data["options"]); $i++){
			   $this->data = array();
			   $this->data["name"] = $tmp_data["name"];
			   $this->data["value"] = $tmp_data["options"][$i]["value"];
			   $this->data["caption"] = $tmp_data["options"][$i]["caption"];
			   if($tmp_data["selected_value"] == $tmp_data["options"][$i]["value"]){
				  $this->data["checked"] = "yes";
			   }

			   RadioControl::StaticXmlControlOnRender($this, $xmlWriter);
		  }
	   $xmlWriter->WriteEndElement();
   }

  }// class
?>