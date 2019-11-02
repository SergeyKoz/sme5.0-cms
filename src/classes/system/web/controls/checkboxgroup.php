<?php
 $this->ImportClass("system.web.controls.checkbox","checkboxcontrol");
 $this->ImportClass("system.web.controls.dbcheckboxgroup","dbcheckboxrgoupcontrol");

/** DbRadioGroupControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class CheckboxGroupControl extends DbCheckboxGroupControl {
		var $ClassName = "CheckboxGroupControl";
		var $Version = "1.0";
		/** Abstract table object
		* @var  PhoneTypesLibTable   $Storage
		*/
		var $Storage;
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
          *           <li> <b>method</b>         - Get method for get values )(default GetList)
          *           <li> <b>query_data</b>     - WHERE clause data array for get method {@see GetList()}
          *           <li> <b>orders</b>         - ORDER BY clause data array for get method {@see GetList()}
          *           <li> <b>caption</b>        - control caption
          *           <li> <b>multiple</b>       - draw multiple control , flag
          *           <li> <b>number</b>         - control number
          *           <li> <b>only_selected</b>  - draw only selected    values
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
   * Method sets control with initial data
   * @access public
   */
   function InitControl($data=array()){
	  $this->data = $data;
	  $this->data["name"] = $data["name"];
	  $this->data["selected_value"] = $data["selected_value"];

	  $this->data["caption"] = $data["caption"];
      if(!isset($this->data["library"])){
         $this->data["library"] = $this->Page->library_ID;
      }


	  //$evalstr = '$this->Storage =  new '.$this->data["table"].'($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database", "'.$this->data["table"].'"));';
	  //eval($evalstr);
	  //$this->list = $this->data["options"];//Storage->$method($this->data["query_data"],$this->data["orders"]);
	  /*
	  $this->list = array();
      if(is_array($list)){
          $this->list = $list;
      } else {
          for($i=0; $i<$list->RecordCount; $i++){
	    		$this->list[] = $list->Read();
    	  }
      }
      */

	  //$keyField = $this->Storage->getKeyColumns();
      if($data["use_root_caption"]){
         $option = array();
         $option["caption"]  = $this->Page->Kernel->Localization->GetItem(strtoupper($this->data["library"]), strtolower($data["name"])."_caption_tree_root");
         $option["value"]  = "";
         $option["selected"] = "";
         $this->data["options"][] = $option;
      }

	  for($i=0; $i<sizeof($this->list); $i++){
		 $option = array();
		 $option["caption"]  = $this->list[$i]["caption"];
		 $option["value"]  = $this->list[$i]["value"];
		 $this->data["options"][] = $option;
	  }
	  if ($data["multiple"] && $this->Page->Event=="EditItem") {
			  $Table=$this->Page->listSettings->GetItem("FIELD_".$data["number"],"RELATIONS_TABLE");
			  $this->Page->Kernel->ImportClass("data.".strtolower($Table), $Table);
			  $Storage =  new $Table ($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database",$Table));
			  //$eval_str = '$Storage = new '.$Table.'($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database",$Table));';
			  //eval($eval_str);
			  $data=$Storage->GetList(array($this->Page->key_field=>$this->Page->Request->Value("item_id")));
			  $this->data["selected_value"]=array();
			  while (!$data->isClosed())   {
				  $rec=$data->Read();
				  $this->data["selected_value"][]=$rec[$this->data["name"]];
			  }
	  }
   }



   }// class
?>