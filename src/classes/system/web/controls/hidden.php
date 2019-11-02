<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Hidden control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class HiddenControl extends FormControl {
		var $ClassName = "HiddenControl";
		var $Version = "1.0";
		 /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>value</b>          - control value
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		 $xmlWriter->WriteStartElement("hidden");
          $this->WriteLanguageVersion($xmlWriter);
			 $xmlWriter->WriteStartElement("name");
				  $xmlWriter->WriteString($this->data["name"]);
			 $xmlWriter->WriteEndElement();
			 $xmlWriter->WriteStartElement("value");
				  $xmlWriter->WriteString($this->data["value"]);
			 $xmlWriter->WriteEndElement();
		 $xmlWriter->WriteEndElement();

   }


   }// class
?>