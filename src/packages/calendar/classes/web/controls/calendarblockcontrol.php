<?php

Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
//Kernel::ImportClass("module.web.controls.calendarcontrol", "CalendarControl");
//Kernel::ImportClass("system.web.controls.datetime", "DateTimeControl");

$this->ImportClass("calendarhelper", "CalendarHelper", "calendar");

/**  Cover control class for main page
* @author Alexandr Degtiar <aedgtiar@activemedia.com.ua>
* @version 1.0
* @package
* @access public
* class for poll controll attached to page
**/
class CalendarBlockControl extends XMLControl {

    var $ClassName = "CalendarBlockControl";
    var $Version = "1.0";

    function ControlOnLoad(){
     	DataFactory::GetStorage($this, "CalendarEventsTable", "eventsStorage");

     	$lang=$this->Page->Kernel->Language;

    	$this->Page->IncludeTemplate("blocks/calendar_block");

    	$DatapickerLang=$lang;
    	if ($lang=="ua"){
            $DatapickerLang="uk";
    	}
    	if ($lang=="en"){
            $DatapickerLang="";
    	}

    	$this->Page->IncludeScript("scripts.jqueryui");
		$this->Page->IncludeLink("css.calendarui.styleui");
		if ($DatapickerLang!=''){
			$this->Page->IncludeScript("js.jqueryuidatepicker-".$DatapickerLang);
		}

        $pckg=$this->Page->Kernel->getPackage("calendar");
        $this->LastEventsCount=$pckg->Settings->GetItem("MAIN", "LastEventsCount");
        $this->block_thumb=$pckg->Settings->GetSection("EVENTSBLOCKTHUMBS");

        DataFactory::GetStorage($this, "ContentTable", "contentStorage");
        $record=$this->contentStorage->Get(array("point_page"=>"calendar|calendar"));
        if (count($record)){
        	$this->Entry=$record["path"].($record["path"]!="" ? "/" : "");
        }

    	parent::ControlOnLoad();
    }

    function CreateChildControls(){

   		if (Engine::isPackageExists($this->Page->Kernel, "context")){
	        $context_parameters=array();
			$this->Page->Controls["cms_context"]->AddContextMenu("eventsblock", "calendar", $context_parameters);
		}

        $this->MonthDays=CalendarHelper::GetMonthDays($this->eventsStorage);

        $this->eventsStorage->PrepareLastBlockQuery();
   		$this->LastEvents=$this->eventsStorage->GetEventsList(0, $this->LastEventsCount);

   		parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter){

        parent::XmlControlOnRender($xmlWriter);
        $xmlWriter->WriteElementString("entry", $this->Entry);

        $xmlWriter->WriteElementString("month", date("m.Y"));
        $xmlWriter->WriteStartElement("days");
    	foreach ($this->MonthDays as $day){
            $xmlWriter->WriteElementString("day", $day);
     	}
    	$xmlWriter->WriteEndElement("days");

    	$xmlWriter->WriteStartElement("events");

    	$this->XmlTag = "event";
        foreach ($this->LastEvents as $this->data){
        	$this->data["date_start"] = Component::dateconv($this->data["date_start"], false);
        	$this->data["date_end"] = Component::dateconv($this->data["date_end"], false);
        	if($this->data["small_image"]!=""){
				ImageHelper::CheckImageThumbnail($this->Page->Kernel, $this->data["small_image"], $this->block_thumb["width"], $this->block_thumb["height"], $this->block_thumb["color"], $this->block_thumb["method"]);
        	}

        	RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }
        $xmlWriter->WriteEndElement("events");
    }

}// class
?>