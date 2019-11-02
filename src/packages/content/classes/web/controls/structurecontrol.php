<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/
$this->ImportClass("system.web.xmlcontrol", 'XmlControl');
class StructureControl extends XmlControl   {

    var $ClassName = "StructureControl";
    var $Version = "1.0";
    var $id = 0;

    var $structure = array();
    var $title_cut_length = 30;
    var $publication_types = array();

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
        parent::ControlOnLoad();
        DataFactory::GetStorage($this, "ContentTable", "contentStorage", true, "content");
    }

    function CreateChildControls(){
        parent::CreateChildControls();
    }

    function BuildRecursiveTree($tree_data, &$xmlWriter){
        static $level;
        $level++;
		if (is_array($tree_data)){
			foreach ($tree_data as $item_id => $node){
				$item=$this->GetItem($node);

				$xmlWriter->WriteStartElement("item");
				$xmlWriter->WriteAttributeString("id", $item_id);
				$xmlWriter->WriteAttributeString("pid", $item['parent_id']);
				$xmlWriter->WriteAttributeString("level", $level - 1);
				$_active_languages_count = 0;

				$xmlWriter->WriteAttributeString("active", $item['active']);
				$xmlWriter->WriteAttributeString("is_first", 0);
				$xmlWriter->WriteAttributeString("is_last", 0);

				$languages=$this->Page->Kernel->Languages;
				$language=$this->Page->Kernel->Language;

				$xmlWriter->WriteElementString("name", $item['page_name']);

				$_title = (strlen($item['page_title']) > $this->title_cut_length) ?
				substr($item['page_title'], 0, $this->title_cut_length) . "..." : $item['page_title'];
				if (!strlen($_title)){
					$_title = $item['page_name'];
				}
				$xmlWriter->WriteElementString("title", $_title);
				$xmlWriter->WriteElementString("title_encoded", addslashes($_title));
				$xmlWriter->WriteElementString('url', sprintf(	"?page=%s&package=%s&library=%s&id=%d",
																$this->Page->Request->QueryString['page'],
																$this->Page->Request->QueryString['package'],
																$this->Page->Request->QueryString['library'],
																$item_id));

				$m=false;
				if ($this->Page->Kernel->Settings->HasItem("DEFAULT", "MultiLanguage"))
					if ($this->Page->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1)
						$m=true;

				if ($m){
					$xmlWriter->WriteStartElement("languages");
					foreach($languages AS $lang){
						$xmlWriter->WriteStartElement("language");
						$xmlWriter->WriteAttributeString("active", $node['active_'.$lang]);
						$xmlWriter->WriteString($lang);
						$xmlWriter->WriteEndElement("language");
					}
					$xmlWriter->WriteEndElement("languages");
				}

				if (!empty($node["_children"])){
					$this->BuildRecursiveTree($node["_children"], $xmlWriter);
				}
				$xmlWriter->WriteEndElement("item");

			}
		}
        $level--;
    }

    function GetItem($item){
		$_page_title = $item['title_' . $this->Page->Kernel->Language];
		if (strlen($_page_title) == 0){
			$_page_title = $item['name'];
		}

   		$item=array(
               'parent_id' => $item['parent_id'],
               'active' => $item['active'],
               'page_title' => $_page_title,
               'page_name' => $item['name'],
               'order' => $item['order_num']);
     	return $item;
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);
        $this->BuildRecursiveTree($this->structure[0]["_children"], $xmlWriter);
    }

}

?>