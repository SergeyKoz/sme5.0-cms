<?php
  $this->ImportClass("system.web.xmlcontrol","xmlcontrol");

/** RaitingControl control (use for draw raiting of item)
	 * @author Konstantin Matsebors<kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class RaitingControl extends XmlControl {
		var $ClassName = "RaitingControl";
		var $Version = "1.0";

   function InitControl($data=array())  {
      $this->data=$data;
   }
	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
      $maxvalue=$this->data["maxvalue"];
      $value=$this->data["value"];
      $range=$this->data["range"];
      $xmlWriter->WriteStartElement("item");
      while($maxvalue > 0)  {
        if($value>0)  {
          $xmlWriter->WriteElementString("peace",1);
        } else  {
          $xmlWriter->WriteElementString("peace",0);
        }
        $value=$value-$range;
        $maxvalue=$maxvalue-$range;
        if (intval($maxvalue)==$maxvalue) {
          $xmlWriter->WriteEndElement("item");
          $xmlWriter->WriteStartElement("item");
        }
      }
      $xmlWriter->WriteEndElement("item");
   }


   }// class
?>