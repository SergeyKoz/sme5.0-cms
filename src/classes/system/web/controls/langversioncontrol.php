<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Language version of edit fields control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package	Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class LangVersionControl extends FormControl {
        var $ClassName = "LangVersionControl";
        var $Version = "1.0";
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
        	$xmlWriter->WriteElementString("prefix",$this->data["prefix"]);
			$xmlWriter->WriteElementString("shortname",$this->data["shortname"]);
			$xmlWriter->WriteElementString("longname",$this->data["longname"]);
        }
   }// class
   ?>