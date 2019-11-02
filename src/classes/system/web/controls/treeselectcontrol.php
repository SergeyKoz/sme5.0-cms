<?php
  $this->ImportClass("system.web.controls.select","selectcontrol");

/** Select control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @modified Alexandr Degtiar <adegtiar@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class TreeSelectControl extends SelectControl {
		var $ClassName = "TreeSelectControl";
		var $Version = "1.0";
		/**  Array with tree data
		* @var		array    $tree
		*/
		var $tree;
		/**  Name of key field
		* @var    string   $key_field_name
		*/
		var $key_field_name;
		/**  Name of parent field
		* @var    string    $parent_field_name
		*/
		var $parent_field_name;
		/**  Name of caption field
		* @var    string    $caption_field_name
		*/
		var $caption_field_name;
   /**
   * Method builds tree data for option select
   * @param    array    &$data    Array with tree data
   * @param		int		$node_id   Current node ID
   * @param		int		$level		Current level of recurcy
   * @param		array	&$options   Array with result options data
   * @access	public
   */
	function BuildRecursiveTree(&$data, $level, &$options){
		if (is_array($data)){
			foreach($data as $id=>$node){
				$indent = "";
				for($j=0; $j<$level; $j++){
					$indent .= "&nbsp;&nbsp;&nbsp;";
				}

				$has_children=!empty($node["_children"]);
				if($has_children){
					$indent .="[-]";
				} else {
					$indent.="&nbsp;&nbsp;&nbsp;&nbsp;";
				}

				$option["caption"] = $indent.$node[$this->caption_field_name];
				$option["value"] = (string)$node[$this->key_field_name];
				$options[] = $option;

				if ($has_children){
					$this->BuildRecursiveTree($node["_children"], $level+1, $options);
				}
			}
		}
	}
	/**
	* MEthod sets data to draw by select control
	* @param    array   $data  Array with data
	* @access 	public
	*/
	function SetTreeData($data){
		$this->data = $data["selectdata"];
		$this->tree=$data["tree"];

		$this->key_field_name = $data["key_field"];
		$this->parent_field_name = $data["parent_field"];
		$this->caption_field_name = $data["caption_field"];

		$start_parent_id = null;
		if ($this->data["selected_value"]>0){
			$path=array();
		    AbstractTable::GetTreeItemPath($this->tree, $this->data["selected_value"], $this->key_field_name, $this->parent_field_name, $path);
		    if (!empty($path)){
       			$path=array_reverse($path);
       			$start_parent_id=$path[0][$this->parent_field_name];
       		}else{
       			$start_parent_id=$this->data["selected_value"];
       		}
	    }

		$options[] = array(	"caption"=> $this->Page->Kernel->Localization->GetItem($data["section"], "_caption_root_tree"),
							"value" => $start_parent_id);

		$this->BuildRecursiveTree($this->tree[0]["_children"], 0, $options);

		$this->data["options"] = $options;
	}

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
		   parent::XmlControlOnRender($xmlWriter);
   }


   }// class
?>