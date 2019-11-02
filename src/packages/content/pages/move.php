<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("web.controls.movetreecontrol", "MoveTreeControl");
$this->ImportClass("module.web.modulepage", "ModulePage");

class MovePage extends ModulePage  {

    var $ClassName = "MovePage";
    var $Version = "1.0";
    var $self = 'structure';
    var $id = 0;
    var $page_id;
    var $PageMode = "Backend";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER");

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
        parent::ControlOnLoad();
        $this->AddControl(new MoveTreeControl("structure_tree", "structure_tree"));
        DataFactory::GetStorage($this, "ContentTable", "contentStorage", true, "content");
        $this->ReadStructure();
        $this->Controls['structure_tree']->structure = $this->structure;
        $this->page_id = $this->Page->Request->ToNumber('id', 0);
    }

    function CreateChildControls(){
        parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);
        $xmlWriter->WriteStartElement("tree_info");
        $xmlWriter->WriteElementString("page_id", $this->page_id);
        $xmlWriter->WriteElementString("page_title",
            $this->structure[$this->page_id]['page_title']);
        $xmlWriter->WriteEndElement("tree_info");
    }

    function ReadStructure(){
        $this->structure=$this->contentStorage->GetTreeData(array(), "parent_id", array("order_num"=>0));
    }

}

?>