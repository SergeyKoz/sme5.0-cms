<?php
 $this->ImportClass("system.web.controls.listcontrol", "ListControl");
 $this->ImportClass("system.web.controls.link", "LinkControl");
 $this->ImportClass("system.web.controls.hidden", "HiddenControl");
 $this->ImportClass("system.web.controls.file", "FileControl");
 $this->ImportClass("system.web.controls.text","textcontrol");
 $this->ImportClass("system.web.controls.textrangecontrol","textrangecontrol");
 $this->ImportClass("system.web.controls.select","SelectControl");
 $this->ImportClass("system.data.abstracttable","AbstractTable");
 $this->ImportClass("web.listcontroldrawer","ListControlDrawer");
 $this->ImportClass("xml.xmlhelper","XmlHelper");

   /** List filter form control
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package Libraries
	 * @subpackage classes.web.controls
	 * @access public
	 */
	class ListFilterFormControl extends FormControl {




	    function InitControl($data=array())    {
	        parent::InitControl($data);
	        $this->CreateFilterForm();
	    }


	    /**
	    * method prepares dynamic select criteria for combobox list extractor
	    * @param   string  $criteria   criteria string
	    * @param   string  $skip_ANDs   bool skip or not AND prefix
	    * @return  string  String with where clause
	    * @access  private
	    **/
	    function GetDynamicSelectCriteria($criteria, $skip_ANDs){
	      if(!strlen($criteria)){
	       return "";
	      }
	      $vars = explode(",", $criteria);
	      $size = sizeof($vars);
	      $sql = array();
	      for($i=0; $i<$size; $i++){
	           list($var_name, $alias_name) = explode(" as ", trim($vars[$i]));
	           if(isset($_REQUEST[$var_name])){
	               $value = $this->Page->Request->ToString($var_name);
	               if((int)$value > 0){
	                   $sql[] = $alias_name." = '".$this->Page->Storage->Connection->EscapeString($value)."'";
	               }
	           }
	      }
	      $SQL = "";
	      if(!empty($sql)){
	           $SQL = implode(" AND ", $sql);
	      }
	      if(strlen($SQL) && (!$skip_ANDs)){
	           $SQL = " AND ".$SQL;
	      }
	      return $SQL;
	    }

	    /**
	    * Method returns true if control should be applied, false otherwise
	    * Control should be applied if http_var with specified names are set and > than 0
	    * @param   array   $http_var_names   Array with http_vars
	    * @return  bool  allowance to apply control
	    * @access private
	    **/
	    function ApplyIfSet($http_var_names){
	         if(empty($http_var_names)){
	              return true;
	         }
	         foreach($http_var_names as $name){
	               $value = $this->Page->Request->Value($name);
	               if(strlen($value)){
	                   if($value == 0){
	                       return false;
	                   } else {
	                       return true;
	                   }
	               } else {
	                   return false;
	               }
	         }
	    }

	    /**
	      * Method create filter form controls
	      * @access    private
	      **/
	    function CreateFilterForm()    {
	      for ($i=0;$i<count($this->data);$i++)    {
	          if($this->ApplyIfSet($this->data[$i]["field_apply_if_set"])){

	          $field_name = $this->Parent->library_ID."_filter_".$this->data[$i]["name"];
	          switch ($this->data[$i]["type"])   {
	              //select field
	             case "combobox":
	                            $this->AddControl(new SelectControl($this->data[$i]["name"],"control"));
                         if(empty($this->data[$i]["options"])){
	                            if($this->data[$i]["field_custom_get_method"]===null){
	                               $SQL = sprintf(" SELECT DISTINCT(%s) AS value, %s AS caption FROM %s
	                                                 WHERE 1=1 %s %s ORDER BY %s ",
	                                                 $this->data[$i]["id_name"], $this->data[$i]["caption_name"],
	                                                 $this->Page->Kernel->Settings->GetItem("DATABASE",$this->data[$i]["table"]),
	                                                 $this->data[$i]["select_criteria"],
	                                                 $this->GetDynamicSelectCriteria($this->data[$i]["dynamic_select_criteria"], strlen($this->data[$i]["select_criteria"])),
	                                                 $this->data[$i]["caption_name"]);

	                               $list = $this->Page->Storage->Connection->ExecuteReader($SQL);
	                            } else {
	                               $table = DataFactory::GetStorage($this, $this->data[$i]["table"]);
	                               $get_method =  $this->data[$i]["field_custom_get_method"];
	                               $list = $table->$get_method($this->data[$i], $this->GetDynamicSelectCriteria($this->data[$i]["dynamic_select_criteria"], true));
	                            }

	                            if(!is_array($list)){
    	                            $list_data = array();
	                               if ($list->RecordCount != 0)   {
	                                    while ($record=$list->Read())  {
	                                        $list_data[]=$record;
	                                    }
	                                }

	                            } else {
	                               $list_data = $list;
	                            }
	                            unset($list);
                                $list_data = array_merge(array("0"=>array("value" => "","caption" => $this->Page->Kernel->Localization->GetItem("main","_caption_select_all"))),$list_data);
                         } else {
                            $list_data = Component::fromConfigOptionsToSelect($this->data[$i]["options"]);
                         }


                                if(is_array($this->data[$i]["current_value"])) {
                                              $usefull_values = array_unique($this->data[$i]["current_value"]);
                                              sort($usefull_values);
                                              if($usefull_values[0]==0){
                                                //array_shift($usefull_values);
                                              }
                                              $this->data[$i]["current_value"] = $usefull_values;
                                }
	                            $this->Controls[$this->data[$i]["name"]]->InitControl(array(
                                "name"          => $field_name,
                                "value"         => $this->data[$i]["current_value"],
                                "selected_value"=> $this->data[$i]["current_value"],
                                "options"       => $list_data,
                                "caption"       => $this->Page->Kernel->Localization->GetItem($this->Parent->library_ID,"filter_".$this->data[$i]["name"]),
                                "event"         => $this->data[$i]["field_event"],
                                "multiple"      => $this->data[$i]["field_multiple"]
                                ));

                                if($this->data[$i]["field_multiple"]){
                                    $name_suffix = "[]";
                                } else {
                                    $name_suffix = "";
                                }

                                if(is_array($this->data[$i]["current_value"])){
                                    $parts = array();
                                    if(!empty($this->data[$i]["current_value"])){
                                        foreach($this->data[$i]["current_value"] as $value){
                                            $parts[] = $field_name.$name_suffix."=".$value;
                                        }
                                    }
                                    $__urls = implode("&", $parts);
                                    $this->Parent->append_hrefs .= "&".$__urls;
                                    $this->Page->append_hrefs .= "&".$__urls;

                                } else {
                                    $this->Parent->append_hrefs .= "&".$field_name.$name_suffix."=".rawurlencode($this->data[$i]["current_value"]);
                                    $this->Page->append_hrefs .= "&".$field_name.$name_suffix."=".rawurlencode($this->data[$i]["current_value"]);
                                }
	                             break;
	              //2 text fields (range from to)
	              case "range":

	                             $this->AddControl(new TextRangeControl($this->data[$i]["name"],"control"));
	                             $array = array(
                                              "name"     =>  $this->Parent->library_ID."_filter_".$this->data[$i]["name"],
                                              "value"    =>  $this->data[$i]["current_value"],
                                              "maxlength"=>  200,
                                              "caption"  =>
                                                            array("min" => $this->Page->Kernel->Localization->GetItem($this->Parent->library_ID,"filter_".$this->data[$i]["name"]."_min"),
                                                                  "max" => $this->Page->Kernel->Localization->GetItem($this->Parent->library_ID,"filter_".$this->data[$i]["name"]."_max"),
                                                                  "main" => $this->Page->Kernel->Localization->GetItem($this->Parent->library_ID,"filter_".$this->data[$i]["name"])),
                                              "size"     =>  10,
                                              "hint"     =>  $this->data[$i]["hint"]);
                                  $this->Controls[$this->data[$i]["name"]]->InitControl($array);
                                  $this->Parent->append_hrefs .= "&".$field_name."_min=".rawurlencode($this->data[$i]["current_value"]["min"])."&".$field_name."_max=".rawurlencode($this->data[$i]["current_value"]["max"]);
                                  $this->Page->append_hrefs .= "&".$field_name."_min=".rawurlencode($this->data[$i]["current_value"]["min"])."&".$field_name."_max=".rawurlencode($this->data[$i]["current_value"]["max"]);
                  break;

                  //text field
	              default:
	                          $this->AddControl(new TextControl($this->data[$i]["name"],"control"));
                              $array = array(
                                              "name"     =>  $this->Parent->library_ID."_filter_".$this->data[$i]["name"],
                                              "value"    =>  $this->data[$i]["current_value"],
                                              "maxlength"=>  200,
                                              "caption"  =>  $this->Page->Kernel->Localization->GetItem($this->Parent->library_ID,"filter_".$this->data[$i]["name"]),
                                              "size"     =>  40,
                                              "hint"     =>  $this->data[$i]["hint"]);
 	                          $this->Controls[$this->data[$i]["name"]]->InitControl($array);
 	                          $this->Parent->append_hrefs .= "&".$field_name."=".rawurlencode($this->data[$i]["current_value"]);
 	                          $this->Page->append_hrefs .= "&".$field_name."=".rawurlencode($this->data[$i]["current_value"]);
	                          break;
	          }
	          }
	      }
	       DataDispatcher::Set($this->Parent->library_ID."_filter",$this->data);

	    }
 /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {

			if ($this->Parent->host_library_ID!="")
				$library_ID=$this->Parent->host_library_ID;
			else
				$library_ID=$this->Parent->library_ID;

		    $this->AddControl(new HiddenControl("page", "hiddens"));
           $this->Controls["page"]->InitControl(array(
                                              "name" => "page",
                                              "value" => $this->Page->self
           ));

           if ($this->Page->Package!=""){
           	$this->AddControl(new HiddenControl("package", "hiddens"));
	           $this->Controls["package"]->InitControl(array(
	                                              "name" => "package",
	                                              "value" => $this->Page->Package
	           ));
           }


		   $this->AddControl(new HiddenControl("start", "hiddens"));
           $this->Controls["start"]->InitControl(array(
                                              "name" => $library_ID."_start",  ///
											  "value" => $this->Parent->start
           ));
           $this->AddControl(new HiddenControl("order_by", "hiddens"));
           $this->Controls["order_by"]->InitControl(array(
                                              "name" => $library_ID."_order_by",   ///
                                              "value" => $this->Parent->order_by
           ));

           $this->AddControl(new HiddenControl("library", "hiddens"));
           $this->Controls["library"]->InitControl(array(
                                              "name" => "library",
                                              "value" => $library_ID         ///
		   ));

		   if ($this->Page->is_context_frame){
	           $this->AddControl(new HiddenControl("contextframe", "hiddens"));
	           $this->Controls["contextframe"]->InitControl(array(
	                                              "name" => "contextframe",
	                                              "value" => 1
	           ));
           }


           $this->AddControl(new HiddenControl("parent", "hiddens"));
           $this->Controls["parent"]->InitControl(array(
                                              "name" => $library_ID."_parent_id",  ///
                                              "value" => $this->Parent->parent_id
           ));

           if(strlen($this->Parent->custom_var) && strlen($this->Parent->custom_val)){
			   $this->AddControl(new HiddenControl("custom_var", "hiddens"));
               $this->Controls["custom_var"]->InitControl(array(
                                                  "name" => "custom_var",
												  "value" => $this->Parent->custom_var
               ));
               $this->AddControl(new HiddenControl("custom_val", "hiddens"));
               $this->Controls["custom_val"]->InitControl(array(
                                                  "name" => "custom_val",
                                                  "value" => $this->Parent->custom_val
			   ));
		   }// if
          if(strlen($this->Parent->host_library_ID)){
               $this->AddControl(new HiddenControl("host_library_ID", "hiddens"));
			   $this->Controls["host_library_ID"]->InitControl(array(
                                                  "name" => "host_library_ID",
                                                  "value" => $this->Parent->host_library_ID
               ));

         }
		}

	} // class



?>