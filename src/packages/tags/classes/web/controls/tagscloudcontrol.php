<?php
  $this->ImportClass("system.web.xmlcontrol", "XMLControl");

/** DateTime control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class TagsCloudControl extends XMLControl {
		var $ClassName = "TagsCloudControl";
		var $Version = "1.0";

        var $data = array();

        function ControlOnLoad(){
        	parent::ControlOnLoad();
        	$cache_file_name=$this->Page->Kernel->Settings->GetItem("Module", "SitePath")."CACHE/tags";
        	$this->tags = CACHE::GetCachedContent($cache_file_name, true);
        }

		/**
		* Method sets initial data for control
		*  @param 	array	$data	Array with initial data
		*  @access public
		*/
		function XmlControlOnRender(&$xmlWriter) {
			parent::XmlControlOnRender($xmlWriter);

			$l=$this->Page->Kernel->Language;
			$this->XmlTag = "tag";
	    	foreach ($this->tags[$l] AS $this->data){
	    		$this->data["encodecaption"]=urlencode($this->data["caption"]);
	            RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
	     	}
   		}

 }// class
?>