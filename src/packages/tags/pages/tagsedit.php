<?php
	$this->ImportClass("web.editpage","EditPage", "libraries");
	/**
	 * Templates edit page class
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class TagsEditPage extends EditPage {
		// Class name
		var $ClassName = "TagsEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="tagsedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="tagslist";

        /**    XSL template name
        * @var     string     $XslTemplate
        */
        var $XslTemplate = "itemsedit";

       /**  Access to this page roles
        * @var     array     $access_role_id
        **/
        var $access_role_id = array("ADMIN","PUBLICATIONS_MANAGER", "PUBLICATIONS_PUBLISHER", "TAGS_EDITOR");

        function InitLibraryData(){
        	$fields_count = $this->listSettings->GetItem("LIST","FIELDS_COUNT");
        	for ($i=0; $i<$fields_count; $i++){
                $field_name=$this->listSettings->GetItem("FIELD_".$i, "FIELD_NAME");
    			$this->listSettings->SetItem("FIELD_".$i, "FIELD_NAME", sprintf($field_name, $this->Kernel->Language));
    		}
        	parent::InitLibraryData();
        }

        function OnBeforeCreateEditControl(){
        	if ($this->item_id>0)
                $this->_data["tag_count"]=$this->Storage->GetTagsCount($this->item_id);
        }

        function OnBeforeEdit(){
        	if ($this->item_id>0)
        		$this->TagUpdateItems=$this->Storage->GetTagsItems(array($this->item_id), true);
        	parent::OnBeforeEdit();
        }

        function OnAfterEdit(){
        	parent::OnBeforeEdit();
        	if (count($this->TagUpdateItems)){
        		$tag_field=sprintf("tag_%s", $this->Kernel->Language);
        		$this->Storage->GroupUpdate($this->key_field, $this->TagUpdateItems, array($tag_field=>$this->_data[$tag_field]));
        	}
        }

        function OnBeforeApply(){
        	parent::OnBeforeApply();
            $delete_items=$this->Request->Value("delete_item");
            if (count($delete_items)){
            	$TagDeleteItems=$this->Storage->GetTagsItems($delete_items);
            	$this->Request->SetValue("delete_item", $TagDeleteItems);
            }
        }

        function OnBeforeDeleteItem(){
        	parent::OnBeforeDeleteItem();
            $deleteItems=$this->Storage->GetTagsItems(array($this->item_id), true);
            if (count($deleteItems))
            	$this->Storage->GroupDelete($this->key_field, $deleteItems);
        }


}

?>