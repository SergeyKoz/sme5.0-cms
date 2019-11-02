<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
class ContentControl extends XmlControl   {

    var $ClassName = "ContentControl";
    var $Version = "1.0";

    function ControlOnLoad() {
    	$page=DataDispatcher::Get("PAGE_DATA");
    	if ($page["enable_comments"]==1 && Engine::isPackageExists($this->Page->Kernel, "comments"))
			DataDispatcher::Set ("comments", $page["id"], "a", "content");
        parent::ControlOnLoad();
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);
        $page=DataDispatcher::Get("PAGE_DATA");
        $l=$this->Page->Kernel->Language;

        $AdminSettings=$this->Page->Kernel->AdminSettings;

        $xmlWriter->WriteElementString('meta_title', DataDispatcher::Get("meta_title"));
        $xmlWriter->WriteElementString('meta_keywords', DataDispatcher::Get("meta_keywords"));
        $xmlWriter->WriteElementString('meta_description', DataDispatcher::Get("meta_description"));

        if (Engine::isPackageExists($this->Page->Kernel, "context")){
	        $context_parameters=array(	"item_id"=>$page["id"],
	       								"language"=>$this->Page->Kernel->Language,
	       								"storage"=>$this->Page->Controls["cms_structure"]->contentStorage);
			$this->Page->Controls["cms_context"]->AddContextMenu("content", "content", $context_parameters);
		}

        $content=$page["content_".$l];
        $MultiLanguage=$this->Page->Kernel->MultiLanguage;
        if (($page["active_".$l]==1 && $MultiLanguage) || !$MultiLanguage){
	        if ($content!=""){
	        	$this->Page->Kernel->prepareContent($content);
	        	$xmlWriter->WriteElementString('content_text', $content);
	        }

	        if (Engine::isPackageExists($this->Page->Kernel, "tags")){
                $this->Page->Kernel->ImportClass("contenttagshelper", "ContentTagsHelper", "content");
	            $tagsHelper = new ContentTagsHelper;
	            $tags=$tagsHelper->GetPageTags($this, $page["id"]);

	            if (count($tags)){
		        	$xmlWriter->WriteStartElement("tags");
			   		foreach ($tags As $tag){
			   			$xmlWriter->WriteStartElement("tag");
			   			$xmlWriter->WriteAttributeString ("tag_decode", $tag["tag_decode"]);
			   			$xmlWriter->WriteString($tag["tag"]);
			   			$xmlWriter->WriteEndElement("tag");
			   		}
			   		$xmlWriter->WriteEndElement("tags");
			   	}
	        }
        }
        if (Engine::isPackageExists($this->Page->Kernel, "comments"))
        	$xmlWriter->WriteElementString('enable_comments', $page["enable_comments"]);

        if ($AdminSettings["title_".$l]!="")
        	$this->Page->Kernel->Localization->SetItem("MAIN", "SiteTitle", $AdminSettings["title_".$l]);
    }

}

?>