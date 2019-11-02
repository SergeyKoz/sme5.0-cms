<?php
	$this->ImportClass("web.listpage", "ListPage", "libraries");
	/**
	 * Publications list page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class PublicationsListPage extends ListPage {
		// Class name
		var $ClassName = "PublicationsListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="publicationslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="publicationsedit";
        /**    XSL template name
        * @var     string     $XslTemplate
        */
        var $XslTemplate = "publicationslist";

      /**  Access to this page roles
        * @var     array     $access_role_id
        **/
        var $access_role_id = array("ADMIN","PUBLICATIONS_MANAGER", "PUBLICATIONS_PUBLISHER", "PUBLICATIONS_EDITOR");

	  /**
	  * Method executes on page load
	  * @access public
	  */
        function ControlOnLoad()  {
            $lib = $this->Request->ToString("library", "");
            $this->Package=Engine::GetPackageName();
            //echo pr($lib);
            if ($this->Auth->isRoleExists("PUBLICATIONS_MANAGER")) { // content publisher
                if($lib != "publications_modified") {
                    $this->libs[0] = "publications";
                } else {
                    $this->libs[0] = $lib;
                }
            }   elseif($this->Auth->isRoleExists("PUBLICATIONS_PUBLISHER")) {
                if($lib != "publications_modified") {
                    $this->libs[0] = "publications_publisher";
                } else {
                    $this->libs[0] = $lib;
                }
            } else {
                if(($lib != "publications_modified") && ($lib != "publications_modified_editor")) {
                    $this->libs[0] = "publications_editor";
                } else {
                    $this->libs[0] = "publications_modified_editor";
                }

            }
            parent::ControlOnLoad();

        }


  /** Method creates child controls
	  * @access public
	  */
	  function CreateChildControls(){
	   for($i=0; $i<sizeof($this->libs); $i++){
		if(!$this->error[$this->libs[$i]]){
			$this->AddControl(new ItemsListControl("ItemsList_".$this->libs[$i], "list", $this->Storage));
			 //Add control to controls
			$extra_url="";  // Clearing ExtraUrl
			for($j=0; $j<sizeof($this->libs); $j++){ // MAking ExtraUrl based on current controls state
				  $extra_url .= "&amp;".$this->libs[$j]."_start=".$this->start[$this->libs[$j]]."&amp;".$this->libs[$j]."_order_by=".$this->order_by[$this->libs[$j]].($this->is_context_frame ? "&amp;contextframe=1" : "");
			}
			// Adding ItemsList control
			$this->Controls["ItemsList_".$this->libs[$i]]->InitControl(array(
													  //"fields" => $this->fields,
													  "library_ID" => $this->libs[$i],
													  "self" => $this->self."".$extra_url,
													  "handler" =>$this->handler,
													  "package" =>$this->Package,
													  "order_by" => $this->order_by[$this->libs[$i]],
													  "start" => $this->start[$this->libs[$i]],
													  "data_extractor" => $this->extractor_method,
													  "parent_id" =>  $this->parent_id[$this->libs[$i]],
													  "data" => $this->data[$this->libs[$i]]
													 ));
		   // Getting list of subcategories
		   $sub_categories = $this->Controls["ItemsList_".$this->libs[$i]]->GetSubCategories();
		   $tree_control = $this->Controls["ItemsList_".$this->libs[$i]]->GetTreeControl();
		   $nodelevels =  $this->Controls["ItemsList_".$this->libs[$i]]->GetNodeLevels();
		   // Geting current level in catalog
		   $nodelevel = (empty($nodelevels) ? 0 : $nodelevels[$this->parent_id[$this->libs[$i]]]+1);
		   if($sub_categories !== false){
			   for($k=0; $k<sizeof($sub_categories); $k++){
				 if((!empty($sub_categories[$k]["levels"]) && in_array($nodelevel, $sub_categories[$k]["levels"])) ||
					(empty($sub_categories[$k]["levels"]))
				 ) {
				 // Preparing data for Sub-categories controls
				  $sub_start="";
				  $sub_order_by="";
				  $append_str="";
				  // Building parts of url to preserve host-catalog  sorting orders and paging
				  for($l=0; $l<sizeof($sub_categories); $l++){
					  $sub_start[$l] = $this->Request->ToNumber($sub_categories[$l]["library"]."_start",0);
					  $sub_order_by[$l] = $this->Request->ToString($sub_categories[$l]["library"]."_order_by","");
					  $append_str .= "&amp;".$sub_categories[$l]["library"]."_start=".$sub_start[$l]."&amp;".$sub_categories[$l]["library"]."_order_by=".$sub_order_by[$l];
				  }
				  $host_extra_url = "&amp;".$this->libs[$i]."_parent_id=".$this->parent_id[$this->libs[$i]]."&amp;".$this->libs[$i]."_start=".$this->start[$this->libs[$i]]."&amp;".$this->libs[$i]."_order_by=".$this->order_by[$this->libs[$i]];
				  // Appending built extra url to host-catalog control
				  $this->Controls["ItemsList_".$this->libs[$i]]->AppendSelfString($append_str);
				  // Adding Child catalog to current host
				  $this->AddControl(new ItemsListControl("ItemsList_sub_".$sub_categories[$k]["library"], "list", $this->Storage));
				  $this->Controls["ItemsList_sub_".$sub_categories[$k]["library"]]->InitControl(array(
													  "library_ID" => $sub_categories[$k]["library"],
													  "host_library_ID" => $this->libs[$i],
													  "self" => $this->self."".$extra_url."".$host_extra_url.$append_str,
													  "handler" =>$this->handler,
													  "package" =>$this->Package,
													  "order_by" => $sub_order_by[$k],
													  "start" => $sub_start[$k],
													  "data_extractor" => $this->extractor_method,
													  "parent_id" =>  $this->parent_id[$this->libs[$i]],
													  "data" => array($sub_categories[$k]["link_field"] => $this->parent_id[$this->libs[$i]]),
													  "custom_var" => $sub_categories[$k]["link_field"],
													  "custom_val" => $this->parent_id[$this->libs[$i]],
													  "tree_control" => $tree_control,
													 ));
				}// if
			   } // for k

		   } // if sub_categories
		} // if !error
		} // for i
	}

}
?>