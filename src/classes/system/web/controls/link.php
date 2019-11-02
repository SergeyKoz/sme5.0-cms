<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Link control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class LinkControl extends FormControl {
		var $ClassName = "LinkControl";
		var $Version = "1.0";

	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
		   $xmlWriter->WriteStartElement("link");
			   $_keys = array_keys($this->data);
				for($i=0, $c=sizeof($_keys); $i<$c; $i++)
				   {
					  $xmlWriter->WriteStartElement($_keys[$i]);
						   $xmlWriter->WriteString(str_replace(chr(10),"",str_replace(chr(13), "<br>",$this->data[$_keys[$i]])));
					  $xmlWriter->WriteEndElement();
				   }
		   $xmlWriter->WriteEndElement();
   }

   static function StaticXmlControlOnRender(&$object, &$xmlWriter) {
		   $xmlWriter->WriteStartElement("link");
			   $_keys = array_keys($object->data);
				for($i=0; $i<sizeof($_keys); $i++)
				   {
					  $xmlWriter->WriteStartElement($_keys[$i]);
						   $xmlWriter->WriteString(str_replace(chr(10),"",str_replace(chr(13), "<br>",$object->data[$_keys[$i]])));
					  $xmlWriter->WriteEndElement();
				   }
		   $xmlWriter->WriteEndElement();
   }

   }// class
?>