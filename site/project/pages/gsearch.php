<?php
 $this->ImportClass("project", "ProjectPage");

 /** Polls page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   * class for poll page, page include block poll and list of polls
   **/
    class GSearchPage extends ProjectPage  {

        var $ClassName="GSearchPage";
        var $Version="1.0";
        var $moder_page = false;

    function ControlOnLoad(){
    	$this->q=$this->Request->Value("q");
    	parent::ControlOnLoad();
    }

    function OnSearch(){
		if ($this->q=="")
			$this->AddErrorMessage("MESSAGES","TEXT_IS_EMPTY");
   	}

   	function XmlControlOnRender(&$xmlWriter) {
   		parent::XmlControlOnRender($xmlWriter);
   		$xmlWriter->WriteElementString("siterestriction", $this->Kernel->Settings->GetItem("GSEARCH","SiteRestriction"));
   		$xmlWriter->WriteElementString("search_api_key", $this->Kernel->Settings->GetItem("GSEARCH","SearchAPIKey"));
        $xmlWriter->WriteElementString("q", $this->q);
	}

}
?>