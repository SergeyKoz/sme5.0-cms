<?php
 Kernel::ImportClass("project", "ProjectPage");
 Kernel::ImportClass("calendarhelper", "CalendarHelper", "calendar");

  /** BizStat page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  BizStat
   * @access public
   **/
class GetMonthPage extends ProjectPage  {

	var $ClassName="GetMonthPage";
	var $Version="1.0";
	var $moder_page = false;
	var $default=true;


	function CreateChildControls(){
		parent::CreateChildControls();

		$m=$this->Page->Request->ToNumber("m", 0);
		$y=$this->Page->Request->ToNumber("y", 0);

		if ($m>0 && $m<=12 && strlen($y)==4){
			DataFactory::GetStorage($this, "CalendarEventsTable", "eventsStorage");
			$m=(strlen($m)==1 ? "0" : "").$m;
			if ($c0>0){
				$days=CalendarHelper::GetMonthDays($this->eventsStorage, $y, $m);
				if (count($days)){
					die("[{'month':'".$m.".".$y."', 'days':[".implode(",", $days)."]}]");
				}
			}else{
				$this->eventsStorage->PrepareMonthBlockQuery($y, $m);
				$MonthEvents=$this->eventsStorage->GetEventsList(null, null);

                $site=$this->Kernel->Settings->GetItem("MODULE", "Url");

                $evts=array();
				foreach ($MonthEvents as $event){
					$days=array();
					CalendarHelper::GetEventDays($event, $y, (strlen($m)==1 ? "0" : "").$m, $days, $this->eventsStorage);
					foreach($days as $day){
                        $item=sprintf("{'event':'%d', 'title':'%s', 'url':'%s', 'description':'%s'}",
                        				$event["event_id"], $event["title"], $event["short_description"],
                        				$site.$event["category_system"]."/".$event["system"].".htm"
                        			);
                        $evts[$day][]=$item;
					}
				}
				foreach($evts as $day => $events){
					if (is_array($events)){
                    	$evts[$day]="{'".$day."':[".implode(", ", $events)."]}";
                    }
				}
				$evts="[{month:'".$m.".".$y."', 'days':[".implode(", ", $evts)."]}]";
				die($evts);
			}
		}
		die("[]");
	}
}
?>