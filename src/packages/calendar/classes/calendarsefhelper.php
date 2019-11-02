<?php

class CalendarSEFHelper {
    var $ClassName = "CalendarSEFHelper";
    var $Version = "1.0";

    function GetPageData($url, &$object){
   		$SQL=sprintf("SELECT * FROM %s WHERE active=1 AND point_page='calendar|calendar' LIMIT 0, 1", $object->defaultTableName);
		$page_data=$object->Connection->ExecuteScalar($SQL);

		if (!empty($page_data)){
	        $PathLen=mb_strlen($page_data["path"]);
	        if (mb_substr($url, 0, $PathLen+1)==$page_data["path"]."/"){
   				$CalendarState=mb_substr($url, $PathLen+1, mb_strlen($url)-$PathLen);
   				$code=$this->ParseCalendarState($CalendarState, $page_data, $object);
   				if ($code!=""){
                    $page_data["point_php_code"].=$code;
   				}
			}else{
				unset($page_data);
			}
		}

        return $page_data;
    }

    function ParseStartDate($date){
        $code="";
        $date=explode("-", $date);
		if (count($date)==2 || count($date)==3){
			$code="\$_GET['year']='".$this->y($date[0])."'; \$_GET['month']='".$this->m($date[1])."';";
			if ($date[2]>0){
				$code.="\$_GET['day']='".$this->d($date[2])."';";
			}
		}
		return $code;
    }

    function ParseEndDate($date){
        $code="";
        $date=explode("-", $date);

		if (count($date)==2 && $date[0]=="" && $date[1]==""){
			$code=" ";
		}

		if (count($date)==3){
			if ($date[0]>0){
				$code.="\$_GET['year1']='".$this->y($date[0])."';";
			}
			if ($date[1]>0){
				$code.="\$_GET['month1']='".$this->m($date[1])."';";
			}
			if ($date[2]>0){
				$code.="\$_GET['day1']='".$this->d($date[2])."';";
			}
		}

		return $code;
    }

	function y($y){
		return $y;
	}

	function m($m){
		if ($m>12){
			$m=12;
		}
		return $m;
	}

	function d($d){
		if ($d>31){
			$d=31;
		}
		return $d;
	}

	function ParseCalendarState($CalendarState, &$page_data, &$object){
		$code="";

		if($CalendarState!=""){
			$CalendarState=explode("/", $CalendarState);
			if (count($CalendarState)==1){
				$SQL=sprintf("SELECT category_id FROM %s WHERE system='%s' LIMIT 0, 1", $object->GetTable("CalendarCategoriesTable"), $CalendarState[0]);
				$record=$object->Connection->ExecuteScalar($SQL);
				if ($record["category_id"]>0){
					$code="\$_GET['category']='".$record["category_id"]."';";
				}else {
					$date=explode("-", $CalendarState[0]);
					if (count($date)==2){
						$code="\$_GET['year']='".$this->y($date[0])."'; \$_GET['month']='".$this->m($date[1])."';";
					}
					if (count($date)==3){
						$code="\$_GET['year']='".$this->y($date[0])."'; \$_GET['month']='".$this->m($date[1])."'; \$_GET['day']='".$this->d($date[2])."';";
					}
				}
			}

			if (count($CalendarState)==2){
				$date1Code=$this->ParseStartDate($CalendarState[0]);
				$date2Code=$this->ParseEndDate($CalendarState[1]);
				if ($date1Code!='' && $date2Code!=''){
					$code=$date1Code." ".$date2Code;
				}else{
					$SQL=sprintf("SELECT category_id FROM %s WHERE system='%s' LIMIT 0, 1", $object->GetTable("CalendarCategoriesTable"), $CalendarState[0]);
					$CategoryRecord=$object->Connection->ExecuteScalar($SQL);
					if ($CategoryRecord["category_id"]>0){
						$SQL=sprintf("SELECT event_id FROM %s WHERE category_id=%d AND system='%s' LIMIT 0, 1", $object->GetTable("CalendarEventsTable"), $CategoryRecord["category_id"], $CalendarState[1]);
						$Record=$object->Connection->ExecuteScalar($SQL);
						if ($Record["event_id"]>0){
                            $code="\$_GET['e']='".$Record["event_id"]."';";
						}
					}
				}
			}

			if (count($CalendarState)==3){

				$date1Code=$this->ParseStartDate($CalendarState[0]);
				$date2Code=$this->ParseEndDate($CalendarState[1]);

				if ($CalendarState[2]!=""){
					$SQL=sprintf("SELECT category_id FROM %s WHERE system='%s' LIMIT 0, 1", $object->GetTable("CalendarCategoriesTable"), $CalendarState[2]);
					$record=$object->Connection->ExecuteScalar($SQL);
					if ($record["category_id"]>0){
						$categoryCode="\$_GET['category']='".$record["category_id"]."';";
					}
				}

				if ($date1Code!='' && $date2Code!='' && $categoryCode!=""){
					$code=$categoryCode." ".$date1Code." ".$date2Code;
				}
			}
		}
		return $code;
	}

}// class
?>