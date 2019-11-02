<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.dbtreecombobox", "DbTreeComboBoxControl");
$this->ImportClass("system.web.controls.select", "SelectControl");
$this->ImportClass("system.web.controls.text", "TextControl");
$this->ImportClass("system.web.controls.datetime", "DateTimeControl");

   /** Menu control class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Content
     * @access public
     */
class EventsFilterControl extends XmlControl {
    var $ClassName = "EventsFilterControl";
    var $Version = "1.0";

    var $filter_fields= array(	"day",
    							"month",
    							"year",
    							"day1",
    							"month1",
    							"year1",
    							"keywords");


    function ControlOnLoad() {
    	DataFactory::GetStorage($this, "CalendarCategoriesTable", "eventsCategoriesStorage");

    	$this->Page->IncludeScript("scripts.jqueryui");
		$this->Page->IncludeLink("css.calendarui.styleui");

		$CalendarLang=$this->Page->Kernel->Language;

		if ($CalendarLang=="ua"){
			$CalendarLang="uk";
		}

		$this->Page->IncludeScript("js.jqueryuidatepicker-".$CalendarLang);
    	$this->Page->IncludeTemplate("controls/indicator");
    	$this->Page->IncludeTemplate("controls/select");
    	$this->Page->IncludeTemplate("controls/text");
    	$this->Page->IncludeTemplate("controls/calendardatetime");

    	foreach ($this->filter_fields as $field){
			$this->form[$field]=$this->Page->Request->Value($field);
		}

		if ($this->form["year"]==0){
			$this->form["year"]=date("Y");
		}
		if ($this->form["month"]==0){
			$this->form["month"]=date("m");
		}
		$this->form["category"]=$this->Page->Request->ToNumber("category", 0);

		if ($this->data["keywords"]!=""){
    		$this->FilterUrl.="&keywords=".urlencode($this->data["keywords"]);
    	}

    	if ($this->Page->Event=="search"){
    		$this->FilterUrl.="&event=search";
    	}
        parent::ControlOnLoad();
    }

    function CreateChildControls(){
    	$lang=$this->Page->Kernel->Language;
		$field="form_date1";
		$month=$this->form["month"];
		$month=str_repeat("0", 2-strlen($month)).$month;

		$day=$this->form["day"];
		$day=str_repeat("0", 2-strlen($day)).$day;

        $year=$this->form["year"];
		$year=str_repeat("0", 4-strlen($year)).$year;

		$value=$year."-".$month."-".$day;

	   	$this->AddControl(new DateTimeControl($field, $field));
	   	$this->Controls[$field]->InitControl(array(	"name"=>$field,
	   												"fulldate"=>0,
	   												"caption"=>$this->Localization($field),
	   												"value"=>$value));

	   	$field="form_date2";

	   	$month=$this->form["month1"];
		$month=str_repeat("0", 2-strlen($month)).$month;

		$day=$this->form["day1"];
		$day=str_repeat("0", 2-strlen($day)).$day;

        $year=$this->form["year1"];
		$year=str_repeat("0", 4-strlen($year)).$year;

		$value=$year."-".$month."-".$day;

		$this->AddControl(new DateTimeControl($field, $field));
	   	$this->Controls[$field]->InitControl(array(	"name"=>$field,
	   												"fulldate"=>0,
	   												"caption"=>$this->Localization($field),
	   												"value"=>$value));

	   	$field="keywords";
	   	$this->AddControl(new TextControl($field, $field));
	   	$this->Controls[$field]->InitControl(array(	"name"=>$field,
	   												"caption"=>$this->Localization($field),
	   												"value"=>$this->form[$field]
	   												));

	   	$field="category";
	   	$data=array("name"=>$field,
	   				"table"=>"CalendarCategoriesTable",
	   				"selected_value"=>$this->form[$field],
	   				"caption_field"=>"caption_".$lang,
	   				"use_root_caption"=>1,
	   				"parent"=>"parent_id",
	   				"library"=>"CALENDAR",
	   				"query_data"=>array("active"=>1),
	   				"orders"=>array("_priority"=>1),
	   				"caption" => $this->Localization($field));

	   	$this->AddControl(new DbTreeComboBoxControl($field, $field));
	   	$this->Controls[$field]->InitControl($data);

	   	$this->Categories=array();
		$reader=$this->eventsCategoriesStorage->GetList(array("active"=>1), array("_priority"=>1));
		for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();
			$this->Categories[$record["category_id"]]=array(
				"category_id"=>$record["category_id"],
				"system"=>$record["system"],
				"caption"=>$record["caption_".$this->Page->Kernel->Language]);
		}

		if ($this->form["category"]>0){
	    	$pathes = DataDispatcher::Get("PATHES");
	        $titles = DataDispatcher::Get("page_titles");
	        $base_url = sprintf(DataDispatcher::Get("page_point_url"), $lang);
	        $title=$this->Categories[$this->form["category"]]["caption"];
	        $url=$base_url."/".$this->Categories[$this->form["category"]]["system"]."/";
	   		$pathes[] = array(	"title" => $title, "url" =>$url);
	       	$titles[] = $title;
	        DataDispatcher::Set("PATHES", $pathes);
	        DataDispatcher::Set("page_titles", $titles);
        }

        parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter) {
        parent::XmlControlOnRender($xmlWriter);
        $xmlWriter->WriteElementString("day_default", $this->Localization("day_default"));
    	$xmlWriter->WriteElementString("mon_default", $this->Localization("mon_default"));
    	$xmlWriter->WriteElementString("year_default", $this->Localization("year_default"));

    	$xmlWriter->WriteStartElement("months");
        $i=0;
    	foreach ($this->Localization("month") as $month){
            $xmlWriter->WriteStartElement("month");
            $xmlWriter->WriteAttributeString("mid", ($i+1<10 ? "0".($i+1) : $i+1));
            $xmlWriter->WriteString($month);
            $xmlWriter->WriteEndElement("month");
            $i++;
     	}
    	$xmlWriter->WriteEndElement("months");

    	$xmlWriter->WriteStartElement("categories");
        $this->XmlTag = "category";
        foreach ($this->Categories as $this->data){
        	RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }
        $xmlWriter->WriteEndElement("categories");

    }

    function Localization($var){
       return $this->Page->Kernel->Localization->GetItem("CALENDAR", $var);
    }

} //--end of class
?>