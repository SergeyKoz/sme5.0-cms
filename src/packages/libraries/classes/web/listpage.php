<?php
    $this->ImportClass("module.web.backendpage", "BackendPage");
    /**
     * Base class for all list pages.
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Libraries
     * @subpackage classes.web
     * @access public
     **/
    class ListPage extends BackendPage {
        // Class name
        var $ClassName = "ListPage";
        // Class version
        var $Version = "1.0";
        /** Data storage
        * @var AbstractTable   $Storage
        */
        var $Storage;
        /** Table class name
        * @var string   $Table
        */
        var $Table;
        /** Fields array for list
        * @var array   $fields
        */
        var $fields;
        /** Navigation part url
        * @var string   $self_url
        */
        var $self;
        /** Handler  page
        * @var string   $handler
        */
        var $handler;
        /** Local overriden Records per page
        * @var int   $RPP
        */
        var $RPP;
        /** Key field name
        * @var string   $key_field
        */
        var $key_field;
        /**  List settings object
        * @var ConfigFile  $listSettings
        */
        var $listSettings;
        /** Library string ID
        * @var string   $library_ID
        */
        var $library_ID;
        /** Error flag count
        * @var int   $error
        */
        var $error;

        var $Package;

	  /**
	    * List control class name
	    * @access public
	    */
	    var $listcontrol="itemslistcontrol";

	  /**
	    * List extractor method name
	    * @var  string  $extractor_method
	    **/
	   var $extractor_method;

	  /**
	    * Class data array
	    * @var  array  $data
	    **/
	   var $data=array();

      /**
      * Method executes on page load
      * @access public
      **/
      var $is_context_frame;

   function ControlOnLoad(){
       parent::ControlOnLoad();
       $this->Kernel->ImportClass("web.controls.".$this->listcontrol, $this->listcontrol);

       $this->Package=Engine::GetPackageName();
       if(empty($this->libs)){
            $tmp=$this->Request->Value("library");
            if (!is_array($tmp)){
               $this->libs = array($tmp);
            } else {
               $this->libs = $tmp;
            }
       }

       $this->is_context_frame = $this->Request->ToNumber("contextframe", "0");

       //Initializing localization variable
       for($i=0; $i<sizeof($this->libs); $i++){
           $this->error[$this->libs[$i]]      =   0;
           $this->library_ID[$this->libs[$i]] =   $this->libs[$i];
           $this->order_by[$this->libs[$i]]   =   $this->Request->Value($this->libs[$i]."_order_by");
           $this->start[$this->libs[$i]]      =   $this->Request->Value($this->libs[$i]."_start");
           $this->parent_id[$this->libs[$i]]  =   $this->Request->ToNumber($this->libs[$i]."_parent_id",0);
           $this->prev_parent_id[$this->libs[$i]] = $this->Request->ToNumber($this->libs[$i]."_prev_parent_id",0);
       }
    }

  /** Method creates child controls
      * @access public
      */
	function CreateChildControls(){
  		for($i=0; $i<sizeof($this->libs); $i++){
    		if (!isset($this->data[$this->libs[$i]]))
    			$this->data[$this->libs[$i]]=array();

      		if(!$this->error[$this->libs[$i]]){
           		$this -> Kernel -> ImportClass("web.controls.".$this -> listcontrol, $this -> listcontrol);
           		$_listControl[$this->libs[$i]] = new $this->listcontrol ("ItemsList_".$this -> libs[$i], "list", $this->Storage);
           		$this->AddControl($_listControl[$this->libs[$i]]);
           	 	$extra_url="";
            	for($j=0; $j<sizeof($this->libs); $j++){
            		$extra_url .= "&amp;".$this->libs[$j]."_start=".$this->start[$this->libs[$j]]."&amp;".$this->libs[$j]."_order_by=".$this->order_by[$this->libs[$j]].($this->is_context_frame ? "&amp;contextframe=1" : "");
            	}
            	$this->Controls["ItemsList_".$this->libs[$i]]->InitControl(array(
                                                      "library_ID" => $this->libs[$i],
                                                      "self" => $this->self."".$extra_url,
                                                      "handler" =>$this->handler,
                                                      "package" =>$this->Package,
                                                      "order_by" => $this->order_by[$this->libs[$i]],
                                                      "start" => $this->start[$this->libs[$i]],
                                                      "data_extractor" => $this->extractor_method,
                                                      "parent_id" =>  $this->parent_id[$this->libs[$i]],
                                                      "data" => $this->data[$this->libs[$i]]));

				// Getting list of subcategories
				$sub_categories = $this->Controls["ItemsList_".$this->libs[$i]]->GetSubCategories();
				$tree_control = $this->Controls["ItemsList_".$this->libs[$i]]->GetTreeControl();
				$nodelevels =  $this->Controls["ItemsList_".$this->libs[$i]]->GetNodeLevels();

				$nodelevel = (empty($nodelevels) ? 0 : $nodelevels[$this->parent_id[$this->libs[$i]]]+1);

				if($sub_categories !== false){
					for($k=0; $k<sizeof($sub_categories); $k++){
						if((!empty($sub_categories[$k]["levels"]) && in_array($nodelevel, $sub_categories[$k]["levels"])) ||
						(empty($sub_categories[$k]["levels"]))) {
							$sub_start="";
							$sub_order_by="";
							$append_str="";
							for($l=0; $l<sizeof($sub_categories); $l++){
								$sub_start[$l] = $this->Request->ToNumber($sub_categories[$l]["library"]."_start",0);
								$sub_order_by[$l] = $this->Request->ToString($sub_categories[$l]["library"]."_order_by","");
								$append_str .= "&amp;".$sub_categories[$l]["library"]."_start=".$sub_start[$l]."&amp;".$sub_categories[$l]["library"]."_order_by=".$sub_order_by[$l];
							}
							$host_extra_url = "&amp;".$this->libs[$i]."_parent_id=".$this->parent_id[$this->libs[$i]]."&amp;".$this->libs[$i]."_start=".$this->start[$this->libs[$i]]."&amp;".$this->libs[$i]."_order_by=".$this->order_by[$this->libs[$i]];
							$this->Controls["ItemsList_".$this->libs[$i]]->AppendSelfString($append_str);
							$_listControl[$sub_categories[$k]["library"]] =  new $this->listcontrol ("ItemsList_sub_".$sub_categories[$k]["library"], "list", $this->Storage);
							$this->AddControl($_listControl[$sub_categories[$k]["library"]]);
							$this->Controls["ItemsList_sub_".$sub_categories[$k]["library"]]->InitControl(array(
	                                                      "library_ID"      =>  $sub_categories[$k]["library"],
	                                                      "host_library_ID" =>  $this->libs[$i],
	                                                      "self"            =>  $this->self."".$extra_url."".$host_extra_url.$append_str,
	                                                      "handler"         =>  $this->handler,
	                                                      "package"			=>  $this->Package,
	                                                      "order_by"        =>  $sub_order_by[$k],
	                                                      "start"           =>  $sub_start[$k],
	                                                      "data_extractor"  =>  $this->extractor_method,
	                                                      "parent_id"       =>  $this->parent_id[$this->libs[$i]],
	                                                      "data"            =>  array($sub_categories[$k]["link_field"] => $this->parent_id[$this->libs[$i]]),
	                                                      "custom_var"      =>  $sub_categories[$k]["link_field"],
	                                                      "custom_val"      =>  $this->parent_id[$this->libs[$i]],
	                                                      "tree_control"    =>  $tree_control));
	                	}// if
               		} // for k

           		} // if sub_categories
        	} // if !error
        } // for i
    }


}

?>