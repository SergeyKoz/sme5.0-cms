<?php
	$this->ImportClass("system.web.xmlcontrol", "XMLControl");
	$this->ImportClass("web.helper.packagehelper", 'PackageHelper');
	/**
	  * @author Sergey Kozin <skozin@activemedia.com.ua>
	  * @version 1.0
	  * @package Stat
	  * @access public
	 **/

    class SitemapControl extends XmlControl   {

        var $ClassName="SitemapControl";
        var $Version="1.0";
        var $id = 0;
        var $structure = array();

    function ControlOnLoad(){
        parent::ControlOnLoad();
        $this->structure=&$this->Page->Controls["cms_structure"]->structure;
    }

    function CreateChildControls(){
   		if (Engine::isPackageExists($this->Page->Kernel, "context")){
	     	$context_parameters=array();
			$this->Page->Controls["cms_context"]->AddContextMenu("sitemap", "content", $context_parameters);
		}
    	parent::CreateChildControls();
    }

    function BuildRecursiveTree($node, &$xmlWriter){
		if (is_array($node)){
			foreach ($node as $i=>$item){
				if($item["show_in_sitemap"]==1){
					$xmlWriter->WriteStartElement("item");
					$xmlWriter->WriteAttributeString("id", $item["id"]);
					$xmlWriter->WriteElementString("title", $item["title_".$this->Page->Kernel->Language]);
					$xmlWriter->WriteElementString("parent_id", $item["parent_id"]);
					$xmlWriter->WriteElementString("point_type", $item["point_type"]);
					$xmlWriter->WriteElementString("url",$item["path"]);
					$xmlWriter->WriteElementString("external",(PackageHelper::CheckUrl($item["path"]) ? 1 : 0 ));
					if (!empty($item['_children'])){
						$this->BuildRecursiveTree($item['_children'], $xmlWriter);
					}
					$xmlWriter->WriteEndElement("item");
				}
			}
		}
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);
        $this->BuildRecursiveTree($this->structure[0]["_children"], $xmlWriter);
    }

}
?>