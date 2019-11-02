<?php
  $this->ImportClass("system.web.xmlcontrol","xmlcontrol");

/** GraphicPriceControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class GraphicPriceControl extends XmlControl {
		var $ClassName = "GraphicPriceControl";
		var $Version = "1.0";


	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {

		   $xmlWriter->WriteStartElement("graphic");
               if(strlen($this->data["value"])){
                    $chars = preg_split('//', $this->data["value"], -1, PREG_SPLIT_NO_EMPTY);
                    for($i=0; $i<sizeof($chars); $i++){
                        if($chars[$i]=="."){
                            $xmlWriter->WriteElementString("char", 'dot');
                        } elseif ($chars[$i]=="-"){
                            $xmlWriter->WriteElementString("char", 'minus');
                        } else{
                            if(is_numeric($chars[$i])){
                            	$xmlWriter->WriteElementString("char", $chars[$i]);
                            }
                        }
                    }
               }

		   $xmlWriter->WriteEndElement();
   }


   }// class
?>