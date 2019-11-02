<?php
$this->ImportClass("system.web.controls.link","linkcontrol");
$this->ImportClass("system.web.controls.dbfield","dbfieldcontrol");

/** DbTreePathControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
class DbTreePathControl extends DbFieldControl  {
	var $ClassName = "DbTreePathControl";
	var $Version = "1.0";
	/**  Table object
	* @var  AbstractTable   $Storage
	*/
	var $Storage;

	/**
	* Initialization data array
	* structure:
	*           <ul>
	*           <li> <b>name</b>           - control name
	*           <li> <b>table</b>          - Storage name (in module.ini) for get values
	*           <li> <b>parent_field</b>   - control parent field name value
	*           <li> <b>caption_field</b>  - Field name in storage where caption is
	*           <li> <b>category_value</b> - Current category id value
	*           <li> <b>caption</b>        - Field caption
	*           </ul>
	* @var    array   $data
	**/
	var $data = array();
	/**
	 * Method  Executes on control load to the parent
	 * @access  private
	 */
	function ControlOnLoad(){
	 // parent::ControlOnLoad();
	}

	/**
	* Method finds path through categories from root to specified category
	* @param	array		$tree  				Array with tree data
	* @param    int			$category_id		Category ID
	* @param    string		$key_field       	Name of key field
	* @param	string		$parent_field       Name of parent field
	* @param	string		$caption_field       Name of caption field

	* @param	array       $path               Array with path info
	* @access	public
	*/

	function GetRecursivePath($tree, $category_id, $key_field, $parent_field, $caption_field, &$path){
		if($category_id > 0){
			$_tmp = $this->Storage->Get(array($key_field => $category_id));
			if (!empty($_tmp)){
				$__tmp = array();
				$__tmp["caption"] = $_tmp[$caption_field];
				$__tmp["value"] = $_tmp[$key_field];
				$path[] = $__tmp;
				if($_tmp[$parent_field] >= 0){
					$this->GetRecursivePath($tree, $_tmp[$parent_field], $key_field, $parent_field, $caption_field, $path);
				}
			}
		}
	}

   /**
   * Method sets control with initial data
   * @access public
   */
	function InitControl($data=array()){
		$this->data = $data;
		$this->data["name"] = $data["name"];
		$this->data["table"] = $data["table"];
		$this->data["caption_field"] = $data["caption_field"];
		$this->data["parent_field"] = $data["parent_field"];
		$this->data["category_value"] = $data["category_value"];
		$this->caption = $data["caption"];
		if (!class_exists($this->data["table"])) {
			$this->Page->Kernel->ImportClass("data.".strtolower($this->data["table"]), $this->data["table"]);
		}
		$this->Storage = new $this->data["table"] ($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database", $this->data["table"]));

		$this->data = array();
		$keyField = $this->Storage->getKeyColumns();
		$this->path = array();

		$this->GetRecursivePath(null, $data["category_value"], $keyField[0]["name"], $data["parent_field"], $data["caption_field"], $this->path);

		if ($this->Page->Event=="EditItem" || $this->Page->Event=="AddItem" || $this->Page->Event=="DoEditItem" || $this->Page->Event=="DoAddItem"){
			$this->data["colspan"] = "2";
		}
		if($data["check_last"]){
			$check_data = (isset($data["check_data"]) ? $data["check_data"] : array());
			$check_data = array_merge(array($data["parent_field"] =>  $data["category_value"]), $check_data);
			$__tmp = $this->Storage->Get($check_data);
			if(isset($__tmp[$data["parent_field"]])){
				$this->path[0]["last"] = 0;
			} else {
				$this->path[0]["last"] = 1;
			}
		}
	}
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
	function XmlControlOnRender(&$xmlWriter) {
		$xmlWriter->WriteStartElement("treepath");
		$xmlWriter->WriteElementString("caption",$this->caption);
		for($i=(sizeof($this->path)-1);$i>=0; $i--){
			$this->data["caption"] = $this->path[$i]["caption"];
			$this->data["value"] = $this->path[$i]["value"];
			$this->data["disabled"] = "yes";
			$this->data["last"] = $this->path[$i]["last"];;
			LinkControl::StaticXmlControlOnRender($this, $xmlWriter);
		}
		$xmlWriter->WriteEndElement();
	}


}// class
?>