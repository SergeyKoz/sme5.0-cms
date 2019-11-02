<?php
 Kernel::ImportClass("project", "ProjectPage");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class ContextFramePage extends ProjectPage {
        var $ClassName = "ContextFramePage";
        var $Version = "1.0";
        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            parent::ControlOnLoad();
        }

        function CreateChildControls(){
        	parent::CreateChildControls();
        }

        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter){
        	$xmlWriter->WriteElementString("mode",$this->Event);
        	$messages=$this->Request->Value("MESSAGE");
        	if (!is_array($messages) && $messages!="") $messages=array($messages);
        	if (is_array($messages)){
        		$xmlWriter->WriteStartElement("messages");
                foreach ($messages as $message)
                    $xmlWriter->WriteElementString("message",$message);
                $xmlWriter->WriteEndElement("messages");
        	}
        	parent::XmlControlOnRender($xmlWriter);
        }

} // class

?>