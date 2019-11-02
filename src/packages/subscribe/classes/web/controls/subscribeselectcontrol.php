<?php
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");
$this->ImportClass("system.web.controls.checkbox","CheckboxControl");
$this->ImportClass("system.web.controls.radio","RadioControl");
/** Content control class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 1.0
 * @package subscribe
 * @access public
 */
class SubscribeSelectControl extends FormControl {
	var $ClassName = "SubscribeSelectControl";
	var $Version = "2.0";
	/**
	* Content data
	* @var    array $content_data
	**/
	var $data = array();

	/**
	* Method executes on control load
	* @access        public
	**/
	function ControlOnLoad(){
		parent::ControlOnLoad();
		DataFactory::GetStorage($this, "SubscribeThemesTable", "themesStorage", false);
		$this->state_checkbox=$this->Page->Request->Value("theme", REQUEST_ALL, false);
		$this->state_language=$this->Page->Request->Value("lang", REQUEST_ALL, false);
	}

	/**
	*  Method draws xml-content of control
	*  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
	*  @access  public
	*/
	function XmlControlOnRender(&$xmlWriter) {
		$l=$this->Page->Kernel->Language;
		$reader=$this->themesStorage->GetList(array("active"=>1));
		$xmlWriter->WriteStartElement("themes");
		for ($i=0; $i<$reader->RecordCount; $i++) {
			$record=$reader->Read();
			$this->data = array(
				"name" => "theme[".$record["theme_id"]."]",
				"value"=>$record["theme_id"],
				"checked"=> (isset($this->state_checkbox[$record["theme_id"]]) ? "yes" : ""),
				"caption" => $record["theme_title_".$l]);
			CheckboxControl::StaticXmlControlOnRender(&$this, &$xmlWriter);


			if (!isset($this->state_language[$record["theme_id"]])){
				$this->state_language[$record["theme_id"]]=$l;
			}

			$xmlWriter->WriteStartElement("languages");
			$xmlWriter->WriteAttributeString("theme_id", $record["theme_id"]);
			foreach ($this->Page->Kernel->Languages as $language){
				$this->data = array(
					"name" => "lang[".$record["theme_id"]."]",
					"value"=> $language,
					"checked"=> ($this->state_language[$record["theme_id"]]==$language ? "yes" : ""));
				RadioControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
			}
			$xmlWriter->WriteEndElement("languages");
      	}
      	$xmlWriter->WriteEndElement("themes");

        }// function
} // class
?>