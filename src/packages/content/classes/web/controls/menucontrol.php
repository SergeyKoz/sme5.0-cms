<?php

define("MENU_TYPE_DEFAULT","default");
define("MENU_TYPE_JAVASCRIPT","javascript");

$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("web.helper.packagehelper", 'PackageHelper');

   /** Menu control class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Content
     * @access public
     */
class  MenuControl extends XmlControl {
    var $ClassName = "ContentControl";
    var $Version = "1.0";
     /**
       * Current page id
       * @var int    $PageId
       **/
    var $PageId = 0;

      /**
       * Root page id
       * @var int    $PageId
       **/
    var $rootPageId = 0;
     /**
       * Menu type
       * @var string    $MenuType
       **/
    var $MenuType = "default";

    /**
       * Menu data array
       * @var array    $MenuData
       **/
    var $topMenuData = array();
    var $bottomMenuData = array();
    var $pageMenuData = array();

     /**
       * Current level menu data array
       * @var array    $currentMenuData
       **/
    var $currentMenuData = array();
    var $levelMenuData = array();
    /**
      * Init control event
      * param   array   $data       data    array
      **/
    function ControlOnLoad() {
    	parent::ControlOnLoad();
        $structure=&$this->Page->Controls["cms_structure"]->structure;

        $page=DataDispatcher::Get("page_id");
        $parent_page_id=DataDispatcher::Get("parent_page_id");

		$path=array();
		AbstractTable::GetTreeItemPath($structure, $page, "id", "parent_id",  $path);
		$this->PagePath=array_keys($path);

        $this->GetRecursiveMenuItems($structure[0]["_children"], $this->topMenuData, "show_in_top_menu");
        $this->GetRecursiveMenuItems($structure[0]["_children"], $this->pageMenuData, "show_in_page_menu");
        $this->GetRecursiveMenuItems($structure[0]["_children"], $this->bottomMenuData, "show_in_bottom_menu");

		$this->currentMenuData=$structure[$page]["_children"];

		if ($parent_page_id!=0)
			$this->levelMenuData=$structure[$parent_page_id]["_children"];

    }

    function GetRecursiveMenuItems(&$structure, &$menu, $field){
        if (is_array($structure)){
            foreach ($structure as $i=>$node){
            	if ($node[$field]==1){
            		$menu[$i]=$node;
            	}
	          	if (!empty($node["_children"])){
	            	$this->GetRecursiveMenuItems($node["_children"], $menu, $field);
            	}
            }
        }
    }

    function CreateChildControls(){
    	if (Engine::isPackageExists($this->Page->Kernel, "context")){
      		$context_parameters=array(	"item_id"=>"top_menu", "menu_caption"=>$this->Page->Kernel->Localization->GetItem("MAIN", "top_menu_caption"));
			$this->Page->Controls["cms_context"]->AddContextMenu("menu", "content", $context_parameters);
			$context_parameters=array("item_id"=>"page_menu", "menu_caption"=>$this->Page->Kernel->Localization->GetItem("MAIN", "page_menu_caption"));
			$this->Page->Controls["cms_context"]->AddContextMenu("menu", "content", $context_parameters);
			$context_parameters=array("item_id"=>"bottom_menu", "menu_caption"=>$this->Page->Kernel->Localization->GetItem("MAIN", "bottom_menu_caption"));
			$this->Page->Controls["cms_context"]->AddContextMenu("menu", "content", $context_parameters);
    	}
    	parent::CreateChildControls();
    }

    function GetItem($str){
    	return array("id"=>$str["id"],
					"parent_id"=>$str["parent_id"],
					"title"=>$str["title_".$this->Page->Kernel->Language],
					"point_type"=>$str["point_type"],
					"url"=>$str["path"],
					"external" => (PackageHelper::CheckUrl($str["path"]) ? 1 : 0 ));
    }

      /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        **/
    function XmlControlOnRender(&$xmlWriter){
    	$xmlWriter->WriteStartElement("top_menu");
    		$this->RenderRecursiveMenu($xmlWriter, $this->topMenuData);
    	$xmlWriter->WriteEndElement("top_menu");

    	$xmlWriter->WriteStartElement("page_menu");
    		$this->RenderRecursiveMenu($xmlWriter, $this->pageMenuData);
    	$xmlWriter->WriteEndElement("page_menu");

    	$xmlWriter->WriteStartElement("bottom_menu");
    		$this->RenderRecursiveMenu($xmlWriter, $this->bottomMenuData);
    	$xmlWriter->WriteEndElement("bottom_menu");

    	$xmlWriter->WriteStartElement("current_menu");
    		if (!count($this->currentMenuData) && count($this->levelMenuData))
    		    $this->currentMenuData=$this->levelMenuData;
    		$this->RenderRecursiveMenu($xmlWriter, $this->currentMenuData);
    	$xmlWriter->WriteEndElement("current_menu");

        parent::XmlControlOnRender($xmlWriter);
    }

    function RenderRecursiveMenu(&$xmlWriter, &$menuData){
    	if (is_array($menuData)){
            foreach ($menuData as $i=>$node){
            	$item=$this->GetItem($node);
            	$xmlWriter->WriteStartElement("item");
		            $xmlWriter->WriteAttributeString("id", $item["id"]);
		            $xmlWriter->WriteElementString("title", $item["title"]);
		            $xmlWriter->WriteElementString("parent_id", $item["parent_id"]);
		            $xmlWriter->WriteElementString("point_type", $item["point_type"]);
		            $xmlWriter->WriteElementString("url",$item["url"]);
		            $xmlWriter->WriteElementString("external",$item["external"]);
		            if (in_array($item["id"], $this->PagePath)){
		                $xmlWriter->WriteElementString("selected", 1);
		          	}
		          	if (!empty($node["_children"])){
		            	$xmlWriter->WriteStartElement("sub_menu");
		            		$this->RenderRecursiveMenu($xmlWriter, $node["_children"]);
		            	$xmlWriter->WriteEndElement("sub_menu");
	            	}
            	$xmlWriter->WriteEndElement("item");
            }
        }
    }

}       //--end of class
?>