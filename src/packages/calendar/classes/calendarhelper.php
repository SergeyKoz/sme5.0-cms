<?php

 class CalendarHelper {

    var $ClassName = "CalendarHelper";
    var $Version = "1.0";

    static function GetMonthDays(&$eventsStorage, $year="", $month=""){
       	$eventsStorage->PrepareMonthBlockQuery($year, $month);
   		$events=$eventsStorage->GetEventsList(null, null);
   		$y=($year!="" ? $year : "Y");
   		$m=($month!="" ? $month : "m");
        $days=array();

        foreach ($events as $event){
        	CalendarHelper::GetEventDays($event, $y, $m, $days, $eventsStorage);
        }

        return $days;
    }

    static function GetEventDays(&$event, $y, $m, &$days, &$eventsStorage){
       	$start_time=strtotime($event["date_start"]);
		$day=date("d", $start_time);
		$duration=(strtotime($event["date_end"])-$start_time)/(3600*24);

		if ($event["date_start"]!=$event["date_end"]){
			for ($i=0; $i<$duration+1; $i++){
				$month=date("m", $start_time+($i*3600*24));
				$current_day=date("d", $start_time+($i*3600*24));
				if ($month==date($m) && !in_array((int)$current_day, $days) ){
					$days[]=(int)$current_day;
				}
			}
		} else {
			if (!in_array((int)$day, $days)){
				$days[]=(int)$day;
			}
		}

		$c=0;

		if ($event["repeat_event"]==1){
  			while ($event["date_end"]<date($y."-".$m."-31 00:00:00")){
				$prev_start=strtotime($event["date_start"]);
				$DayAfterEvent=date("Y-m-d 00:00:00", strtotime($event["date_end"]." +1 DAY"));
               	$event["date_start"]=$eventsStorage->GetNextMonthRepeat($event["event_id"], $DayAfterEvent, $y, $m);
				$event["date_end"]=date("Y-m-d 00:00:00", strtotime($event["date_start"]." +".$duration." DAY"));

				if (date("m", strtotime($event["date_start"]))==(int)date($m)){
					if ( $prev_start>=strtotime($event["date_start"])){
						$event["date_end"]=date($y."-".$m."-31 00:00:00");
					} else {
		                $start_time=strtotime($event["date_start"]);
						$day=date("d", $start_time);
						$month=date("m", $start_time);
						if ($event["date_start"]!=$event["date_end"]){
							for ($i=0; $i<$duration+1; $i++){
								$month=date("m", $start_time+($i*3600*24));
								$current_day=date("d", $start_time+($i*3600*24));
								if (!in_array((int)$current_day, $days) ){
									$days[]=(int)$current_day;
								}
							}
						} else {
							if (!in_array((int)$day, $days)){
								$days[]=(int)$day;
							}
						}
					}
				}
    		}
		}
    }

 }// class
?>