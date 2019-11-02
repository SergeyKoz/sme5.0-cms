<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Checkbox control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class CheckboxControl extends FormControl {
		var $ClassName = "CheckboxControl";
		var $Version = "1.0";


		/**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>      - control name
          *           <li> <b>value</b>     - control value
          *           <li> <b>checked</b>   - control flag if checkbox checked (string "yes" or "no")
          *           <li> <b>caption</b>   - control caption
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

  /**
    *  Method Draws XML-content of a control
    *  @param XMLWriter    $xmlWriter  instance of XMLWriter
    *  @access private
    **/
		function XmlControlOnRender(&$xmlWriter) {
		    $xmlWriter->WriteAttributeString('id', uniqid(''));
		    $xmlWriter->WriteStartElement("checkbox");
          $this->WriteLanguageVersion($xmlWriter);
            $this->XmlGetErrorFields($xmlWriter);
			$_keys = array_keys($this->data);
			for($i=0; $i<sizeof($_keys); $i++)
			   {
				  $xmlWriter->WriteStartElement($_keys[$i]);
					   $xmlWriter->WriteString($this->data[$_keys[$i]]);
				  $xmlWriter->WriteEndElement();
			   }

		 $xmlWriter->WriteEndElement();


   }

	static function StaticXmlControlOnRender($object, &$xmlWriter) {
		$xmlWriter->WriteAttributeString('id', uniqid(''));
		$xmlWriter->WriteStartElement("checkbox");
		$object->WriteLanguageVersion($xmlWriter);
		$object->XmlGetErrorFields($xmlWriter);
		$_keys = array_keys($object->data);
		for($i=0; $i<sizeof($_keys); $i++){
			$xmlWriter->WriteStartElement($_keys[$i]);
			$xmlWriter->WriteString($object->data[$_keys[$i]]);
			$xmlWriter->WriteEndElement();
		}
		$xmlWriter->WriteEndElement();
	}


   } //-- end of class
?>