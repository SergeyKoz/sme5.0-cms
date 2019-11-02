<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/
$this->ImportClass("system.web.xmlcontrol", 'XmlControl');
$this->ImportClass("web.helper.packagehelper", 'PackageHelper');

class SiteStructureControl extends XmlControl   {

    var $ClassName = "SiteStructureControl";
    var $Version = "1.0";

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
        DataFactory::GetStorage($this, "ContentTable", "contentStorage", true, "content");
        $l=$this->Page->Kernel->Language;
        $get_tree_data=array("active"=>1);
        if ($this->Page->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1) $get_tree_data["active_".$l]=1;
        $this->structure=$this->contentStorage->GetTreeData($get_tree_data, "parent_id", array("order_num"=>0), "GetStructurePages");
        $this->_page = DataDispatcher::Get("PAGE_DATA");

        for ($i=0; $i<count($this->Page->Kernel->Languages); $i++)
			 if ($this->_page["active_".$this->Page->Kernel->Languages[$i]]==0)
                 unset($this->Page->Kernel->Languages[$i]);

        if($this->_page){
	        if (!isset($GLOBALS["page_id"]))
	        	$this->Page->id = $this->_page["page_id"];

	        DataDispatcher::Set("page_point_url",$this->_page["path"]);
	        DataDispatcher::Set("page_id",$this->_page["page_id"]);
	        DataDispatcher::Set("parent_page_id",$this->_page["parent_id"]);
	        DataDispatcher::Set("page_system_name", $this->_page["name"]);

	        if ($this->_page["is_page"]==1){
	            $meta_keywords= ($this->_page["meta_keywords_".$l]=="" ? $this->Page->Kernel->AdminSettings["meta_keywords_".$l] : $this->_page["meta_keywords_".$l]);
		        $meta_description= ($this->_page["meta_description_".$l]=="" ? $this->Page->Kernel->AdminSettings["meta_description_".$l] : $this->_page["meta_description_".$l]);

		        DataDispatcher::Set("meta_title", $this->_page["meta_title_".$l]);
		        DataDispatcher::Set("meta_keywords", $meta_keywords);
		        DataDispatcher::Set("meta_description", $meta_description);
	        }

	        $path=array();
	       	AbstractTable::GetTreeItemPath($this->structure, $this->_page["page_id"], "id", "parent_id",  $path);
			if (count($path)){
        		$path=array_reverse($path);
        		$pathes = DataDispatcher::Get("PATHES");
        		$titles = DataDispatcher::Get("page_titles");
        		foreach ($path as $item){
        			$title=$item["title_".$this->Page->Kernel->Language];
        			$pathes[] = array("title" => $title, "title" => $title, "url" => $item["path"], "point_type"=>$item["point_type"]);
        			$titles[] = $title;
        		}
        		DataDispatcher::Set("PATHES", $pathes);
        		DataDispatcher::Set("page_titles", $titles);
        	}
	    }
        parent::ControlOnLoad();

    }

    function CreateChildControls(){
    	if (Engine::isPackageExists($this->Page->Kernel, "context") && $this->Page->id>0){
      		$context_parameters=array(	"item_id"=>$this->Page->id,
      									"storage"=>$this->contentStorage);
			$this->Page->Controls["cms_context"]->AddContextMenu("page", "content", $context_parameters);
    	}

        parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter){
    	$xmlWriter->WriteElementString("title",$this->_page["title_".$this->Page->Kernel->Language]);
    	$xmlWriter->WriteElementString("path",$this->_page["path"]);
        parent::XmlControlOnRender($xmlWriter);

        $pathes = DataDispatcher::Get("PATHES");

		$xmlWriter->WriteStartElement("pathes");
		if (is_array($pathes)){
			foreach($pathes as $page){
			    $xmlWriter->WriteStartElement("path");
			    $xmlWriter->WriteElementString("title", $page["title"]);
			    $xmlWriter->WriteElementString("url", $page["url"]);
			    $xmlWriter->WriteElementString("point_type", $page["point_type"]);
			    $xmlWriter->WriteEndElement("path");
			}
		}
		$xmlWriter->WriteEndElement("pathes");

    }

}

?>