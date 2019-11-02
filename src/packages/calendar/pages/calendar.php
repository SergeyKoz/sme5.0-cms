<?php
Kernel::ImportClass("project", "ProjectPage");
Kernel::ImportClass("web.controls.eventsfiltercontrol", "EventsFilterControl");
Kernel::ImportClass("web.controls.eventslistcontrol", "EventsListControl");
Kernel::ImportClass("web.controls.eventdetailcontrol", "EventDetailControl");
Kernel::ImportClass("web.controls.eventsdefaultcontrol", "EventsDefaultControl");
Kernel::ImportClass("calendarhelper", "CalendarHelper", "calendar");

/** BizStat page class
* @author Sergey Kozin <skozin@activemedia.com.ua>
* @version 1.0
* @package  BizStat
* @access public
**/
class CalendarPage extends ProjectPage  {
	var $ClassName="CalendarPage";
	var $Version="1.0";
	var $moder_page = false;
	var $default=true;

	function ControlOnLoad() {
		$this->e=$this->Page->Request->ToNumber("e", 0);

		$category=$this->Page->Request->ToNumber("category", 0);
		$day=$this->Page->Request->ToNumber("day", 0);
		$month=$this->Page->Request->ToNumber("month", 0);
		$year=$this->Page->Request->ToNumber("year", 0);

		if ($this->Page->Event=="search" || $category!=0 || ($day!="" && $month!="" && $year!="" )){
			$this->default=false;
		}

		parent::ControlOnLoad();
	}

	/** Method creates child controls
	* @access public
	**/
	function CreateChildControls(){
		parent::CreateChildControls();

		if ($this->e==0){
			$this->AddControl(new EventsFilterControl("events_filter", "events_filter"));
		}else{
			$this->AddControl(new EventDetailControl("event_detail", "event_detail"));
		}

		if (!$this->default){
			$this->AddControl(new EventsListControl("events_list", "events_list"));
		}elseif ($this->e==0){
			$this->AddControl(new EventsDefaultControl("events_default", "events_default"));
		}
	}

	function XmlControlOnRender(&$xmlWriter) {
		parent::XmlControlOnRender($xmlWriter);

		DataFactory::GetStorage($this, "ContentTable", "contentStorage");
		$record=$this->contentStorage->Get(array("point_page"=>"calendar|calendar"));

		if (count($record)){
			$xmlWriter->WriteElementString("calendar_entry", $record["path"].($record["path"]!="" ? "/" : ""));
		}
	}
}
?>