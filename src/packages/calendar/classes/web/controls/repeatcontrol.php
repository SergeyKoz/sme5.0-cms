<?php
  $this->ImportClass("system.web.xmlcontrol", "XMLControl");
  $this->ImportClass("system.web.controls.checkbox","checkboxcontrol");
  $this->ImportClass("system.web.controls.select","SelectControl");
  $this->ImportClass("web.controls.containercontrol","ContainerControl");
  $this->ImportClass("web.controls.datetime","DateTimeControl");


/** DateTime control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class RepeatControl extends XMLControl {
		var $ClassName = "RepeatControl";
		var $Version = "1.0";

        var $data = array();
	/**
		* Method sets initial data for control
		*  @param 	array	$data	Array with initial data
		*  @access public
		*/
		function InitControl($data=array()){
			$this->data = $data;

	        $field="repeat_container";
			$this->AddControl(new ContainerControl($field, $field));
	        $container=&$this->Controls[$field];

	        $field="repeat_every_count";
			$container->AddControl(new TextControl($field,$field));
			$data=array("name" => $field,
						"value" => ($this->data[$field]>1 ? $this->data[$field] : "1"),
						"size" => 5);
			$container->Controls[$field]->InitControl($data);

			$field="repeat_every_term";
	  		$options_localization=$this->Page->Kernel->Localization->GetItem("MAIN", "EVERY_TERM_OPTIONS");
	        foreach($options_localization as $option ){
	        	$item=explode("|", $option);
	        	$options[]=array("caption"=>$item[0], "value"=>$item[1]);
	        }
			$container->AddControl(new SelectControl($field,$field));
			$data=array("name" => $field,
	                    "options" => $options,
	                    "selected_value" => $this->data[$field]);
			$container->Controls[$field]->InitControl($data);

			$field="repeat_end_iterations";
			$container->AddControl(new TextControl($field,$field));
			$data=array("name" => $field,
						"value" => ($this->data[$field]>1 ? $this->data[$field] : "1"),
						"size" => 5);
			$container->Controls[$field]->InitControl($data);

			$field="repeat_end_day";
			$container->AddControl(new DateTimeControl($field,$field));
			$data=array("name" => $field,
						"value" => (strlen($this->data[$field])==10 && $this->data[$field]!="0000-00-00" ? $this->data[$field] : date("Y-m-d") ),
						"fulldate" => 0);
			$container->Controls[$field]->InitControl($data);

		}

		function XmlControlOnRender(&$xmlWriter) {
          $xmlWriter->WriteStartElement("repeatcontrol");

           	$xmlWriter->WriteElementString("name", $this->data["name"]);
			if($this->data["caption"])
			$xmlWriter->WriteElementString("caption", $this->data["caption"]);
			if($this->data["notnull"])
			$xmlWriter->WriteElementString("notnull", $this->data["notnull"]);
			if($this->data["error_field"])
			$xmlWriter->WriteElementString("error_field", $this->data["error_field"]);
			if($this->data["disabled"])
			$xmlWriter->WriteElementString("disabled", $this->data["disabled"]);

			$xmlWriter->WriteElementString("repeat_event", $this->data["repeat_event"]);
			$xmlWriter->WriteElementString("repeat_end", ($this->data["repeat_end"]=="" ? 0 : $this->data["repeat_end"]) );

          $xmlWriter->WriteEndElement("repeatcontrol");

   		}

 }// class
?>