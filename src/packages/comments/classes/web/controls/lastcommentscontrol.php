<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class LastCommentsControl extends XmlControl {
        var $ClassName = "CommentsControl";
        var $Version = "1.0";
        var $CommentLength=100;

        /**
        * Method executes on control load
        * @access   public
        **/
     function ControlOnLoad(){
    	DataFactory::GetStorage($this, "CommentsTable", "commentsStorage");
    	$this->Page->IncludeTemplate("blocks/lastcommentsblock");
    	$Count=$this->Page->Kernel->Settings->GetItem("MAIN", "CommentsBlockCount");
    	$this->LastComments=$this->commentsStorage->GetLastComments($Count, $this->CommentLength);
        parent::ControlOnLoad();
     }

     function CreateChildControls(){
     	parent::CreateChildControls();
     }

     function XmlControlOnRender(&$xmlWriter) {
     	if (count($this->LastComments)){
			$this->XmlTag = "comment";
			foreach($this->LastComments as $this->data )
				RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
		}
     	parent::XmlControlOnRender($xmlWriter);
     }

} // class

?>