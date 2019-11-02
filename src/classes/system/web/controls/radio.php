<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Radio control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class RadioControl extends FormControl {
		var $ClassName = "RadioControl";
		var $Version = "1.0";

	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		 $xmlWriter->WriteStartElement("radio");
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

	static function StaticXmlControlOnRender(&$object, &$xmlWriter) {
		$xmlWriter->WriteStartElement("radio");
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


   }// class
?>