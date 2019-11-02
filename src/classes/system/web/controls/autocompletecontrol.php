<?php
  $this->ImportClass("system.web.controls.form","formcontrol");
  //$this->ImportClass("system.web.controls.recordcontrol","RecordControl");

/** DateTime control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class AutocompleteControl extends FormControl {
		var $ClassName = "AutocompleteControl";
		var $Version = "1.0";

        var $data = array();
        var $WordsDelimeter=",";
        var $Parameters=array();

        function ControlOnLoad(){
        	parent::ControlOnLoad();
        	$this->Page->IncludeScript("scripts.jqueryautocomplete");
        	$this->Page->IncludeLink("css.autocomplete", "libraries");
        }

		/**
		* Method sets initial data for control
		*  @param 	array	$data	Array with initial data
		*  @access public
		*/
		function InitControl($data=array()){
			$this->data = $data;
			if ($this->Page->Event=="EditItem")
				if ($this->data["field_table"]!=""){
					$ItemsStorage=DataFactory::GetStorage($this->Page->Kernel->Connection, $this->data["field_table"]);
					$word_field_name=($this->data["field_words_name"]!="" ? $this->data["field_words_name"] : $this->data["name"]);
					$get_method=($this->data["get_method"]!="" ? $this->data["get_method"] : "GetList");

					$field_relation_name=($this->data["field_relation_name"]!="" ? $this->data["field_relation_name"] : "item_id");
                    if ($field_relation_name!="item_id")
						$ItemsStorage->AddRelationColumn($field_relation_name);

					$get_data=array($field_relation_name=>$this->Page->Request->Value("item_id"));

					if ($this->data["item_type"]!="") $get_data["tag_type"]=$this->data["item_type"];
                    $items=array();
					$reader=$ItemsStorage->$get_method($get_data);
					for ($i=0; $i<$reader->RecordCount; $i++){
						 $record=$reader->read();
						 $word=trim($record[$word_field_name]);
						 if ($word!="") $items[]=$word;
					}

					if (!empty($items)){
						$WordsDelimeter=($this->data["words_delimeter"]!="" ? $this->data["words_delimeter"] : $this->WordsDelimeter);
						$this->data["value"]=implode($WordsDelimeter." ", $items);
					}
				}
		}

		function XmlControlOnRender(&$xmlWriter) {
			$xmlWriter->WriteStartElement("autocomplete");
		        $this->XmlGetErrorFields($xmlWriter);
		        $xmlWriter->WriteElementString("name", $this->data["name"]);
		        $xmlWriter->WriteElementString("value", $this->data["value"]);
		        if (strlen($this->data["caption"]))
		        	$xmlWriter->WriteElementString("caption", $this->data["caption"]);
		        if (strlen($this->data["error_field"]))
		        	$xmlWriter->WriteElementString("error_field", $this->data["error_field"]);
		   		if (strlen($this->data["disabled"]))
		        	$xmlWriter->WriteElementString("disabled", $this->data["disabled"]);
		 		if (strlen($this->data["field_words_name"]))
		 			$xmlWriter->WriteElementString("words_field", $this->data["field_words_name"]);
				if (strlen($this->data["field_table"]))
		 			$xmlWriter->WriteElementString("field_table", $this->data["field_table"]);
				if (strlen($this->data["words_delimeter"]))
		 			$xmlWriter->WriteElementString("words_delimeter", $this->data["words_delimeter"]);
		 		if (strlen($this->data["autocomplete_method"]))
		 			$xmlWriter->WriteElementString("autocomplete_method", $this->data["autocomplete_method"]);
				if (strlen($this->data["multiple"]))
		 			$xmlWriter->WriteElementString("multiple", $this->data["multiple"]);

                if (is_array($this->Parameters)){
			 		$xmlWriter->WriteStartElement("parameters");
			 		foreach ($this->Parameters as $key=>$item){
			 			$xmlWriter->WriteStartElement("parameter");
			 				$xmlWriter->WriteAttributeString("name", $key);
			 				$xmlWriter->WriteString($item);
			 			$xmlWriter->WriteEndElement("parameter");
					}
			 		$xmlWriter->WriteEndElement("parameters");

		 		}

        	$xmlWriter->WriteEndElement();
   		}

 }// class
?>