<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.editpage", "EditPage", "libraries");

class ChangeMenuPage extends EditPage  {

    var $ClassName = "ChangeMenuPage";
    var $Version = "1.0";
    var $XslTemplate = "changemenuedit";

    var $handler="changemenu";
    var $PageMode = "Backend";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER");

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
    	$this->Request->SetValue("library", "changemenu");
    	$this->MenuType=$this->Request->Value("menu");
        parent::ControlOnLoad();
    }

    function OnBeforeEdit(){
    	$pages=$this->_data["page_id"];

    	$sql=sprintf("UPDATE %s SET show_in_%s=0", $this->Storage->defaultTableName, $this->MenuType);
        $this->Storage->Connection->ExecuteNonQuery($sql);

    	$this->Storage->GroupUpdate("id", $pages, array("show_in_".$this->MenuType=>1));

    	if ($this->is_context_frame)
			$url = "?package=context&page=contextframe&event=refresh&MESSAGE[]=EDIT_ITEM_SAVED";
		else
			$url = "?package=content&page=structure";
		$this->AfterSubmitRedirect($url);
    }

    function ValidateBeforeAdd(){
    }

    function OnBeforeCreateEditControl(){
    	$EditTitle=$this->Kernel->Localization->GetItem(strtoupper($this->library_ID), "_EDIT_TITLE");
    	$MenuCaption=$this->Kernel->Localization->GetItem("MAIN", $this->MenuType."_caption");
    	$this->Kernel->Localization->SetItem(strtoupper($this->library_ID), "_EDIT_TITLE", sprintf($EditTitle, $MenuCaption));

        parent::OnBeforeCreateEditControl();
    }

    function OnAfterEdit() {
    	parent::OnAfterEdit();
    }

    function InitLibraryData(){
    	$this->listSettings->SetItem("FIELD_1", "VALUE", $this->MenuType);
        parent::InitLibraryData();
    }

    function XmlControlOnRender(&$xmlWriter){
		$PagesTree=$this->Storage->GetTreeData(array(), "parent_id", array("order_num"=>0));
		$reader=$this->Storage->GetList(array("show_in_".$this->MenuType=>1));
		$inmenu=array();
		for($i=0; $i<$reader->RecordCount; $i++){
            $record=$reader->read();
            $inmenu[]=$record["id"];
		}
		$l = $this->Page->Kernel->Language;
		$xmlWriter->WriteStartElement("pagestree");
		$this->RenderRecursiveTree($xmlWriter, $PagesTree[0]["_children"], 0, $l, $inmenu);
		$xmlWriter->WriteEndElement("pagestree");
    	parent::XmlControlOnRender($xmlWriter);
    }

	function RenderRecursiveTree(&$xmlWriter, &$tree, $item_id, $l, &$inmenu){
		if (is_array($tree)){
			foreach($tree as $id=>$node){
				$xmlWriter->WriteStartElement("page");
				$xmlWriter->WriteElementString("id", $node["id"]);
				$xmlWriter->WriteElementString("title", $node["title_".$l]);
				if (in_array($node["id"], $inmenu))
					$xmlWriter->WriteElementString("selected", 1);

				if (!empty($node["_children"])){
					$this->RenderRecursiveTree($xmlWriter, $node["_children"], $node["id"], $l, $inmenu);
				}
				$xmlWriter->WriteEndElement("page");

			}
		}
	}

}

?>