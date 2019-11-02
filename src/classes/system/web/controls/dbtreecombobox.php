<?php
 $this->ImportClass("system.web.controls.select","selectcontrol");
 $this->ImportClass("system.web.controls.dbcombobox","dbcomboboxcontrol");

/** DbTreeComboBoxControl control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class DbTreeComboBoxControl extends DbComboBoxControl {

        var $ClassName = "DbTreeComboBoxControl";
        var $Version = "1.0";

        /**  Storage table object
        * @var  AbstractTable   $Storage
        */
        var $TreeStorage;
        /**  Array with phonetypes
        * @var    array   $types
        */
        var $list;

        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>selected_value</b> - control selected value
          *           <li> <b>table</b>          - Storage name (in module.ini) for get values
          *           <li> <b>caption_field</b>  - Field name in storage where caption is
          *           <li>  <B>parent</B>        - Parent field name
          *           <li> <b>method</b>         - Get method for get values )(default GetList)
          *           <li> <b>query_data</b>     - WHERE clause data array for get method {@see GetList()}
          *           <li> <b>orders</b>         - ORDER BY clause data array for get method {@see GetList()}
          *           <li> <b>caption</b>        - control caption
          *           <li> <b>multiple</b>       - draw multiple control , flag
          *           <li> <b>number</b>         - control number
          *           <li> <b>user_root_caption</b>  - draw root caption(Like --Root---), flag
          *           <li> <b>event</b>          - field events array (format: array("eventname javascript","eventname javascript")
          *           <li> <b>use_entries</b>    - use entries, flag
          *           <li> <B>entries_table</B>  - entries table (in DATABASE section module.ini.php)
          *           <li>  <B>entriesvalue_name</B> - entries values id field name
          *           <li>  <B>entriesvalue_caption</B>  - entries values caption field name
          *           <li>  <B>allow_category_select</B> - allow category select , flag
          *           <li>  <B>get_method</B>         - get method name (like GetList())
          *           <li>  <B>entries_get_method</B> - entries get method name (like GetList())
          *           <li>  <B>get_from</B>           - ID of root record
          *           <li>  <B>parsed_fields</B>      - parsed (htmlentities) fields names, array
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();
    /**
     * Method  Executes on control load to the parent
     * @access  private
     */
    function ControlOnLoad(){
      parent::ControlOnLoad();
    }

   /**
   * Method builds tree data for option select
   * @param    array    &$data    Array with tree data
   * @param     int     $node_id   Current node ID
   * @param     int     $level      Current level of recurcy
   * @param     array   &$options   Array with result options data
   * @access    public
   */
	function BuildRecursiveTree(&$data, $node_id, $level, &$options){
		if (is_array($data)){
			foreach($data as $id=>$node){
				$indent = "";
				$sub_indent = "";
				for($j=0; $j<$level; $j++){
					$indent .= "&nbsp;&nbsp;&nbsp;";
					$sub_indent = "&nbsp;&nbsp;&nbsp;";
				}

				$has_children=!empty($node["_children"]);

				if($has_children){
					$indent .="[-]";
					$sub_indent = "&nbsp;&nbsp;&nbsp;";
				} else {
					$indent.="&nbsp;&nbsp;&nbsp;&nbsp;";
					$sub_indent = "&nbsp;&nbsp;&nbsp;&nbsp;";
				}

				$options[] = $this->BuildItemData($node,$indent);

				// using entries
				if($this->data["use_entries"]){
					$entry_keyfields = $this->Entries->getKeyColumns();
					$_get_method=$this->data["entries_get_method"];
					$_reader = $this->Entries->$_get_method(
						array($this->data["entriesvalue_name"] => $node[$this->key_field_name]),
						$this->data["entries_orders"]
					);
					for($k=0; $k<$_reader->RecordCount; $k++){
						$_tmp = $_reader->Read();
						$options[]=$this->BuildEntriesItemData($_tmp,$entry_keyfields,$sub_indent);
					}
				}
				if ($has_children)
					$this->BuildRecursiveTree($node["_children"], $id, $level+1, $options);
			}
		}
	}

   /**
     * Method build item  data array
     * @param       array           $data                       input data
     * @param       string      $indent                 string indent
     * @return  array           item data array
     * @access  private
     **/
	function BuildItemData($data,$indent="") {
		$option["caption"] = $indent.$data[$this->caption_field_name];
		$option["value"] = $data[$this->key_field_name];
		if($this->data["use_entries"]){
			$option["class"] = "category_class";
				if(!$this->data["allow_category_select"]){
					$option['disabled'] = 1;
					unset($option["value"]);
				}
		}
		return $option;
	}


   /**
      * Method build entries item  data array
      * @param    array             $data            input data
      * @param      array               $keyfields       entries keyfields array
      * @param    string            $indent          string indent
      * @return  array              item data array
      * @access  private
      **/
	function BuildEntriesItemData($data,$keyfields,$indent="")  {
		$option = array();
		$option["caption"] = $indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data[$this->data["entriesvalue_caption"]];
		$option["value"] = $data[$keyfields[0]["name"]];
		$option["class"] = "entry_class";
		return $option;
	}

   /**
   * MEthod sets data to draw by select control
   * @param    array   $data  Array with data
   * @access    public
   */
	function SetTreeData($data){
		$this->InitControl($data);
	}
   /**
   * MEthod sets data to draw by select control
   * @param    array   $data  Array with data
   * @access    public
   */

	function InitControl($data=array()){

		$this->data["name"] = $data["name"];
		$this->data["selected_value"] = $data["selected_value"];
		$this->data["table"] = $data["table"];
		$this->caption_field_name = $this->data["caption_field"] = $data["caption_field"];
		$this->parent_field_name = $this->data["parent"] = $data["parent"];
		$this->data["caption"] = $data["caption"];
		$this->data["multiple"] = $data["multiple"];
		if ($data["notnull"]) {
			$this->data["notnull"] = $data["notnull"];
		}

		$this->data["query_data"] = ($data["query_data"]==""? null:$data["query_data"]);
		$this->data["orders"] = ($data["orders"]==""? null:$data["orders"]);

		$this->TreeStorage=DataFactory::GetStorage($this, $this->data["table"]);

		$this->data["use_entries"] = $data["use_entries"];
		$this->data["entries_table"] = $data["entries_table"];
		$this->data["entriesvalue_name"] = $data["entriesvalue_name"];
		$this->data["entriesvalue_caption"] = sprintf($data["entriesvalue_caption"],$this->Page->Kernel->Language);

		$this->data["entries_orders"] = ($data["entries_orders"]=="" ? array($this->data["entriesvalue_caption"]=>true) : $data["entries_orders"]);

		$this->data["allow_category_select"] = $data["allow_category_select"];
		$this->data["size"] = intval($data["size"]);
		$this->data["get_method"]=($data["get_method"]==""? "GetList" : $data["get_method"]);
		$this->data["entries_get_method"]=($data["entries_get_method"]==""? "GetList":$data["entries_get_method"]);
		$this->data["item_id"]=($data["item_id"]==""? 0:$data["item_id"]);
		$this->data["event"]=$data["event"];

		if($this->data["use_entries"]){ // using category entries
          	$this->Entries=DataFactory::GetStorage($this, $this->data["entries_table"]);
      	}
		$tmp = $this->TreeStorage->getKeyColumns();
		$this->key_field_name = $tmp[0]["name"];
		$options=array();
		if($data["use_root_caption"]){
			if (is_array($this->Page->library_ID))   {
				$library_keys = array_keys($this->Page->library_ID);
				$library_ID = $library_keys[0];
			}else {
				$library_ID = $this->Page->library_ID;
			}

			if(isset($data["library"]) && ($library_ID=="")){
				$library_ID = $data["library"];
			}
			$option["caption"] = $this->Page->Kernel->Localization->GetItem(strtoupper($library_ID), strtolower($data["name"])."_caption_tree_root");
			$option["value"] = "0";
			$option["selected"] = "";
			$options[] = $option;
      	}
        $_get_method = $this->data["get_method"];

		if ($data["multiple"] && $this->Page->Event=="EditItem") {
			$Table=$this->Page->listSettings->GetItem("FIELD_".$data["number"],"RELATIONS_TABLE");
			$this->Page->Kernel->ImportClass("data.".strtolower($Table), $Table);
			$Storage = new $Table ($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database",$Table));
			$reader=$Storage->$_get_method(array($this->Page->key_field=>$this->Page->Request->Value("item_id")));
			$this->data["selected_value"]=array();
			while (!$reader->isClosed())   {
				$rec=$reader->Read();
				$this->data["selected_value"][] = $rec[$this->data["name"]];
			}
		}

		//if tree created from defined branch
		$list = $this->TreeStorage->GetTreeData($this->data["query_data"], $this->data["parent"], $this->data["orders"], $this->data["get_method"]);

		$get_from=0;
		if ($data["get_from"]){
			if (intval($this->data["item_id"])!=0){
				$get_from=$this->data["item_id"];
				if ($data["render_root"]==1){
					$from=$list[$get_from]["parent_id"];
					unset($list[$from]);
					$list[$from]["_children"][$get_from]=$list[$get_from];
					$get_from=$from;
				}
			}
		}

		$this->BuildRecursiveTree($list[$get_from]["_children"], intval($this->data["item_id"]), 0, $options);

		$this->data["options"] = $options;
		if (!is_array($this->data["options"])){
			$this->data["options"]=array();
		}
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