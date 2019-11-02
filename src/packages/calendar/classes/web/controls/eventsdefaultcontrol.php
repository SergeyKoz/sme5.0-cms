<?php

  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");

  /**  Cover control class for main page
   * @author Alexandr Degtiar <aedgtiar@activemedia.com.ua>
   * @version 1.0
   * @package
   * @access public
   * class for poll controll attached to page
   **/
class EventsDefaultControl extends XMLControl {

    var $ClassName = "EventsDefaultControl";
    var $Version = "1.0";

    function ControlOnLoad(){
     	DataFactory::GetStorage($this, "CalendarEventsTable", "eventsStorage");

        //$this->DefaultEventsCount=$this->Page->Kernel->Package->Settings->GetItem("MAIN", "DefaultEventsCount");
    	parent::ControlOnLoad();
    }

    function CreateChildControls(){
    	if (Engine::isPackageExists($this->Page->Kernel, "context")){
	        $context_parameters=array();
			$this->Page->Controls["cms_context"]->AddContextMenu("eventsdefault", "calendar", $context_parameters);
		}
		
		$filter=&$this->Page->Controls["events_filter"]->form;		
		$this->eventsStorage->PrepareMonthBlockQuery($filter['year'], $filter['month']);
		$this->MonthEvents=$this->eventsStorage->GetEventsList(null, null);

        /*$this->eventsStorage->PrepareLastBlockQuery();
   		$this->DefaultEvents=$this->eventsStorage->GetEventsList(0, $this->DefaultEventsCount, "c._priority, near_date_start");
            */
   		parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter){
        parent::XmlControlOnRender($xmlWriter);

       	$filter=$this->Page->Controls["events_filter"]->form;


       	$y=$filter['year'];
		$m=$filter['month'];

           $this->DrawCalendar($xmlWriter, $y, $m);

   		if (is_array($this->MonthEvents)){
	   		$xmlWriter->WriteStartElement("monthevents");
			$this->XmlTag = "event";
	        foreach ($this->MonthEvents as $event){
	        	$days=array();
	        	CalendarHelper::GetEventDays($event, $y, $m, $days, $this->eventsStorage);
	        	foreach($days as $day){
	        		$this->data=array(	"event_id"=>$event["event_id"],
						        		"system"=>$event["system"],
						        		"title"=>$event["title"],
						        		"short_description"=>$event["short_description"],
						        		"category_id"=>$event["category_id"],
						        		"category_system"=>$event["category_system"],
						        		"day"=>$day);
					RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
		       	}
	        }
	        $xmlWriter->WriteEndElement("monthevents");
        }


		/*$xmlWriter->WriteStartElement("events");
		$this->XmlTag = "event";
        foreach ($this->DefaultEvents as $this->data){
        	$this->data["date_start"] = Component::dateconv($this->data["date_start"], false);
        	$this->data["date_end"] = Component::dateconv($this->data["date_end"], false);
        	RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }
        $xmlWriter->WriteEndElement("events");*/
    }

    function DrawCalendar(&$xmlWriter, $y, $m){
    	$y=(int)$y;
    	$m=(int)$m;

    	$currentDate = getdate();

    	$xmlWriter->WriteStartElement("monthcalendar");
		$this->_days_in_prev_month = date("t", mktime(0, 0, 0, $m - 1, 1, $y['year']));
		$this->_days_in_current_month = date("d", mktime(0, 0, 0, $m + 1, 0, $y['year']));

        if ($this->data['day'] > $this->_days_in_current_month){
            $this->data['day'] = $this->_days_in_current_month;
        }

    	$xmlWriter->WriteStartElement("localization");
    	$xmlWriter->WriteStartElement("weekdays");
		$i=0;
    	foreach($this->Page->Kernel->Localization->GetItem('CALENDAR', 'day') as $item)
		if ($i!=7){
			$xmlWriter->WriteElementString("day", $item);
			$i++;
		}
		$xmlWriter->WriteEndElement("weekdays");
   	    $xmlWriter->WriteEndElement("localization");

   	    $monthName_localized = $this->Page->Kernel->Localization->GetItem('CALENDAR', 'month');

   	    $xmlWriter->WriteStartElement("current_month");
		$xmlWriter->WriteElementString("month", ($m<10 ? "0" : '' ).$m);
		$xmlWriter->WriteElementString("year", $y);
		$xmlWriter->WriteElementString("month_caption", $monthName_localized[$m-1]);
		$xmlWriter->WriteEndElement("current_month");

    	$prev_year = $y;
		$prev_month = $m - 1;
		if ($prev_month < 1){
			$prev_month = 12;
			$prev_year--;
		}

		$xmlWriter->WriteStartElement("prev_month");
		$xmlWriter->WriteElementString("month", ($prev_month<10 ? "0" : '' ).$prev_month);
		$xmlWriter->WriteElementString("year", $prev_year);
		$xmlWriter->WriteElementString("month_caption", $monthName_localized[$prev_month-1]);
		$xmlWriter->WriteEndElement("prev_month");

		$next_year = $y;
		$next_month = $m + 1;
		if ($next_month > 12){
			$next_month = 1;
			$next_year++;
		}

		$xmlWriter->WriteStartElement("next_month");
		$xmlWriter->WriteElementString("month", ($next_month<10 ? "0" : '' ).$next_month);
		$xmlWriter->WriteElementString("year", $next_year);
		$xmlWriter->WriteElementString("month_caption", $monthName_localized[$next_month-1]);
		$xmlWriter->WriteEndElement("next_month");

		// month starts at this week day
		$this->_start_weekDay = date("w", mktime(0, 0, 0, $m, 1, $y));
		if ($this->_start_weekDay == 0){
			$this->_start_weekDay = 7;
		}

    	$xmlWriter->WriteStartElement("week");
    	// --- Create XML
		// if month starts not from monday, then
		// fill week with days of prior month
		for ($i = 1; $i < $this->_start_weekDay; $i++){
	    	$xmlWriter->WriteStartElement("day");
			$xmlWriter->WriteAttributeString('outside', 1);
			if (($i == 6) || ($i == 7)){
				$xmlWriter->WriteAttributeString('weekend', 1);
			}
			$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($this->_days_in_prev_month - $this->_start_weekDay + 1 + $i);
	    	$xmlWriter->WriteEndElement("day");
		}
		// fill with days of current month
		$week_day = $this->_start_weekDay;
		for ($i = 1; $i <= $this->_days_in_current_month; $i++) {
			// weekend days
			if (($week_day == 6) || ($week_day == 7)){
				$is_weekend = true;
			} else {
				$is_weekend = false;
			}

			// end of week, starting from monday
			if ($week_day > 7){
				$week_day = 1;
		        $xmlWriter->WriteEndElement("week");
		    	$xmlWriter->WriteStartElement("week");
			}

	    	$xmlWriter->WriteStartElement("day");

			if ($is_weekend){
				$xmlWriter->WriteAttributeString('weekend', 1);
			}

	    	if (($i == $currentDate['mday']) &&
	    		($m == $currentDate['mon']) &&
	   			($y == $currentDate['year'])){
				$xmlWriter->WriteAttributeString('today', 1);
			}

			$xmlWriter->WriteEndAttribute();

			$xmlWriter->WriteString($i);
	    	$xmlWriter->WriteEndElement("day");
			$week_day++;
		}
		// fill rest of week with days of next month
		$days_left = 8 - $week_day;
		for ($i = 1; $i <= $days_left; $i++){
	    	$xmlWriter->WriteStartElement("day");
			$xmlWriter->WriteAttributeString('outside', 1);
			if (($week_day == 6) || ($week_day == 7)){
				$xmlWriter->WriteAttributeString('weekend', 1);
			}
			$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($i);
	    	$xmlWriter->WriteEndElement("day");
	    	$week_day++;
		}
		$xmlWriter->WriteEndElement("week");
		$xmlWriter->WriteEndElement("monthcalendar");
    }

}// class
?>