<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("system.web.xmlcontrol", "XMLControl");


class MoveTreeControl extends XmlControl   {

    var $ClassName = "MoveTreeControl";
    var $Version = "1.0";
    var $id = 0;

    var $structure = array();
    var $title_cut_length = 30;
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

    function BuildRecursiveTree(&$tree_data, &$xmlWriter){
        static $level;
        $level++;
        $from_node = $this->Page->Request->ToNumber('id', 0);
		if (is_array($tree_data)){
			foreach ($tree_data as $item_id => $node){
				$_page_title = $node['title_' . $this->Page->Kernel->Language];
				if (strlen($_page_title) == 0){
					$_page_title = $node['name'];
				}
				$item = array(
					'parent_id' => $node['parent_id'],
					'active' => $node['active'],
					'page_title' => $_page_title,
					'page_name' => $node['name'],
					'order' => $node['order_num']);

				$xmlWriter->WriteStartElement("item");
				$xmlWriter->WriteAttributeString("id", $item_id);
				$xmlWriter->WriteAttributeString("pid", $item['parent_id']);
				$xmlWriter->WriteAttributeString("level", $level - 1);

				if (($from_node == $item_id) || in_array($item_id, $this->nodes)){
					$can_move_here = 0;
				} else {
					$can_move_here = 1;
				}

				$xmlWriter->WriteAttributeString("can_move_here", $can_move_here);

				$_title = (strlen($item['page_title']) > $this->title_cut_length) ?
				substr($item['page_title'], 0, $this->title_cut_length) . "..." : $item['page_title'];
				$xmlWriter->WriteElementString("title", $_title);
				$xmlWriter->WriteElementString("title_encoded", addslashes($_title));
				$xmlWriter->WriteElementString('url', sprintf(	"?page=%s&package=%s&library=%s&id=%d",
																$this->Page->Request->QueryString['page'],
																$this->Page->Request->QueryString['package'],
																$this->Page->Request->QueryString['library'],
																$item_id));
				if (!empty($node["_children"])){
					$this->BuildRecursiveTree($node["_children"], $xmlWriter);
				}
				$xmlWriter->WriteEndElement("item");
			}
		}
        $level--;
    }

	function GetChildNodesId(&$data, &$nodes){
		if (is_array($data)){
			foreach ($data as $i=>$node){
                $nodes[]=$i;
				if (!empty($node["_children"])){
					$this->GetChildNodesId($node["_children"], $nodes);
				}
			}
		}
        return $nodes;
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);
		$from_node = $this->Page->Request->ToNumber('id', 0);
		$this->nodes=array();
		$this->GetChildNodesId($this->structure[$from_node]["_children"], $this->nodes);

        $this->BuildRecursiveTree($this->structure[0]["_children"], $xmlWriter);
    }

}

?>