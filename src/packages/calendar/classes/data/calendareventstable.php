<?php
  $this->ImportClass("module.data.projecttable", "ProjectTable");

/** Catalog categories storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 1.0
 * @package JA
 * @subpackage classes.data
 * @access public
 */
class CalendarEventsTable extends ProjectTable{
    var $ClassName = "CalendarEventsTable";
    var $Version = "1.0";

    function CalendarEventsTable(&$Connection, $TableName) {
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns() {
        $this->columns[] = array("name" => "event_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "system", "type" => DB_COLUMN_STRING,"length"=>255);
        $this->columns[] = array("name" => "category_id", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "title_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);

        $this->columns[] = array("name" => "short_description_%s", "type" => DB_COLUMN_STRING,"length"=>1000);
        $this->columns[] = array("name" => "full_description_%s", "type" => DB_COLUMN_STRING,"length"=>100000);
        $this->columns[] = array("name" => "small_image", "type" => DB_COLUMN_STRING,"length"=>255);
        $this->columns[] = array("name" => "contacts_%s", "type" => DB_COLUMN_STRING,"length"=>1000);
        $this->columns[] = array("name" => "url", "type" => DB_COLUMN_STRING,"length"=>255);
        $this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING,"length"=>255);

        $this->columns[] = array("name" => "date_start", "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "date_end", "type" => DB_COLUMN_STRING);

        $this->columns[] = array("name" => "repeat_event", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "repeat_every_count", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "repeat_every_term", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "repeat_end", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "repeat_end_iterations", "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "repeat_end_day", "type" => DB_COLUMN_STRING);

        $this->columns[] = array("name" => "enable_comments", "type" => DB_COLUMN_STRING);

        $this->columns[] = array("name" => "mixed_%s", "type" => DB_COLUMN_STRING);

        $this->columns[] = array("name" => "meta_title_%s", "type" => DB_COLUMN_STRING, "length"=>255);
        $this->columns[] = array("name" => "meta_keywords_%s", "type" => DB_COLUMN_STRING, "length"=>255);
        $this->columns[] = array("name" => "meta_description_%s", "type" => DB_COLUMN_STRING, "length"=>255);

        parent::prepareColumns();
    }

    function MakeSqlForDate(){
		$SQL = '';
		$date_period = Page()->Session->Get('date_period');
		if (isset($date_period)){
			if (strlen($date_period['start']) > 0)
				$SQL = " date_start >= '{$date_period['start']} 00:00:00'";

			if (strlen($date_period['end']) > 0)
				$SQL .= " AND date_start <= '{$date_period['end']} 23:59:59'";
		}
		return $SQL;
	}

	function &GetAdminEventsListCount($data = null, $table_alias="", $raw_sql=array()){
		$date_clause = $this->MakeSqlForDate();
		$raw_sql["where"] = $date_clause;
		$Count=$this->GetCount($data, $table_alias, $raw_sql);
		return $Count;
	}

	function &GetAdminEventsListList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
		$date_clause = $this->MakeSqlForDate();
		$raw_sql["where"] = $date_clause;
		$Reader=$this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
		return $Reader;
	}

	function PrepareMonthBlockQuery($year="", $month=""){
		$this->kw=$this->cd="";
		$this->md=1;
		$y=($year!="" ? $year : "Y");
		$m=($month!="" ? $month : "m");
        $this->ch=$this->prepareCheckEvent(date($y."-".$m."-01 00:00:00"), date($y."-".$m."-".$this->d(date($m))." 00:00:00"));
	}

	function PrepareLastBlockQuery(){
		$this->kw=$this->cd="";
		$this->md=1;
		$this->ch=$this->prepareCheckEvent(date("Y-m-d 00:00:00"), date("Y-m-d 00:00:00", mktime(0, 0, 0, date("m")+1  , date("d"), date("Y"))));
	}

	function d($m){return date("t", mktime(0,0,0, $m, 1, date("Y")));}

	function prepareCheckEvent($period_start, $period_end){
		return "CheckEvent(	'".$period_start."',
							'".$period_end."',
							e.date_start,
							e.date_end,
							e.repeat_event,
							e.repeat_every_count,
							e.repeat_every_term,
							e.repeat_end,
							e.repeat_end_iterations,
							e.repeat_end_day,
							%s)";
	}

	function GetEventsCount($data){
		$lang=$this->Connection->Kernel->Language;

		$f=$data["filter"];

        $keyword_cond="";
		if ($f["keywords"]!=""){
    		$words=explode(" ", $f["keywords"]);
    		$title_conds=array();
    		$description_conds=array();
    		foreach ($words as $word){
    			$word=trim($word);
    			if ($word!=""){
    				$title_conds[]="e.mixed_".$lang." LIKE '%".mysql_escape_string($word)."%'";
    			}
    		}
    		if (count($title_conds)){
    			$keyword_cond="AND (".implode(" AND ", $title_conds).")";
    		}
    	}

    	$category_cond=($f["category"]>0 ? "AND e.category_id=".$f["category"] : "");

        if (($f["day1"]=="" && $f["month1"]=="" && $f["year1"]=="") ||
        	($f["day1"]!="" && $f["month1"]=="" && $f["year1"]!="") ||
        	($f["day1"]!="" && $f["month1"]=="" && $f["year1"]=="") ||
        	($f["day1"]=="" && $f["month1"]!="" && $f["year1"]=="") ||
        	($f["day1"]=="" && $f["month1"]=="" && $f["year1"]!="")
        	){
        	$f["year1"]=$f["year"];
        	$f["month1"]=$f["month"];
        	$f["day1"]=$f["day"];

        	if ($f["day"]==""){
         		$f["day"]="01";
         		$f["day1"]=$this->d($f["month1"]);
        	}else{
        		$f["day1"]=$f["day"];
        	}
        }

        if ($f["month1"]!="" && $f["year1"]!="" && $f["day1"]==""){
        	$f["day1"]=$this->d($f["month1"]);
        }

       	if ($f["day"]==""){
            $f["day"]="01";
        }

        $period_start=$f["year"]."-".$f["month"]."-".$f["day"]." 00:00:00";
        $period_end=$f["year1"]."-".$f["month1"]."-".$f["day1"]." 00:00:00";

		$check_event=$this->prepareCheckEvent($period_start, $period_end);

		$SQL=sprintf("SELECT count(*) as cnt FROM %s AS e JOIN %s As c ON (e.category_id=c.category_id) %s WHERE
		     				e.active=c.active=1
		     				%s
		     				%s",
							$this->defaultTableName, $this->GetTable("CalendarCategoriesTable"),
							$keyword_cond, $category_cond,
							"AND ".sprintf($check_event, 0)."=1");

        $this->kw=$keyword_cond;
        $this->cd=$category_cond;
        $this->ch=$check_event;
        $this->md=1;

		$reader=$this->Connection->ExecuteReader($SQL);
		$ret=$reader->read();
		return $ret["cnt"];
	}

	function GetEventsList($start = null, $rpp = null, $orders = "near_date_start"){
		$lang=$this->Connection->Kernel->Language;
		$fields=array(	"e.event_id",
						"e.category_id",
						"e.system",
						"e.title_".$lang." As title",
						"e.small_image",
						"e.short_description_".$lang." As short_description",
						"e.date_start",
						"e.date_end",
						"e.repeat_event",
						"c.caption_".$lang." AS category_title",
						"c.system AS category_system",
						"c._priority",
						sprintf($this->ch, $this->md)." AS near_date_start");

		$SQL=sprintf("SELECT %s FROM %s AS e JOIN %s As c ON (e.category_id=c.category_id) %s WHERE
	     				e.active=c.active=1
	     				%s
	     				%s
	     				%s
	     				ORDER BY %s
	     				%s",
		 				implode(", ", $fields),
						$this->defaultTableName, $this->GetTable("CalendarCategoriesTable"), $this->tg,
						$this->kw, $this->cd,
						"AND ".sprintf($this->ch, 0)."='1'",
						$orders,
						($start>0 || $rpp>0 ? "LIMIT ".$start.", ".$rpp : "")
						);

        $list=array();
		$reader=$this->Connection->ExecuteReader($SQL);
		for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();
			if ($record["date_start"]!=$record["near_date_start"]){
                $duration=(strtotime($record["date_end"])-strtotime($record["date_start"]))/(3600*24);
                if ($duration>0)
                	$record["date_end"]=date("Y-m-d 00:00:00", strtotime($record["near_date_start"]."+".$duration." DAY"));
                else
                	$record["date_end"]=$record["near_date_start"];

                $record["date_start"]=$record["near_date_start"];
                unset($record["near_date_start"]);
			}
			$list[$record["event_id"]]=$record;
		}

		if (Engine::isPackageExists($this->Connection->Kernel, "tags"))
			$this->GetEventsTags($list);
		return array_values($list);
	}

	function GetEventsTags(&$list){
        $l=$this->Connection->Kernel->Language;
        $ids=array_keys($list);
        if (count($ids)){
            $SQL=sprintf("	SELECT t.item_id AS id, t.tag_%s AS tag FROM %s AS t JOIN %s AS r ON (t.item_id=r.id)
	        				WHERE t.tag_%s!='' AND t.tag_type='event' ORDER BY t.item_id, t.tag_%s",
	        				$l, $this->GetTable("TagsTable"),
							"(SELECT ".implode(" AS id UNION SELECT ", $ids)." AS id)", $l, $l);

	        $reader=$this->Connection->ExecuteReader($SQL);
			for ($i=0; $i<$reader->RecordCount; $i++){
	        	$record=$reader->read();
	        	$list[$record["id"]]["tags"][]=array("tag"=>$record["tag"], "tag_decode"=>urlencode($record["tag"]));
	        }
        }
    }

	function GetEvent($id, $thumb){
		$ch=$this->prepareCheckEvent(date("Y-m-d 00:00:00"), date("Y-12-".$this->d(12)." 00:00:00"));

		$lang=$this->Connection->Kernel->Language;
		$fields=array(	"e.event_id",
						"e.category_id",
						"e.system",
						"c.caption_".$lang." As category_title",
						"c.system As category_system",
						"e.title_".$lang." As title",
						"e.small_image",
						"e.full_description_".$lang." As full_description",
						"e.contacts_".$lang." As contacts",
						"e.url",
						"e.email",
						"e.date_start",
						"e.date_end",
						"e.enable_comments",
						sprintf($ch, 1)." AS near_date_start");

		$SQL=sprintf("SELECT %s FROM %s AS e JOIN %s As c ON (e.category_id=c.category_id) WHERE
	     				e.active=c.active=1
	     				AND e.event_id=%d",
		 				implode(", ", $fields),
						$this->defaultTableName, $this->GetTable("CalendarCategoriesTable"),
						$id);

        $list=array();
		$record=$this->Connection->ExecuteScalar($SQL);

		if ($record["date_start"]!=$record["near_date_start"]){
			$duration=(strtotime($record["date_end"])-strtotime($record["date_start"]))/(3600*24);
			if ($duration>0){
				$record["date_end"]=date("Y-m-d 00:00:00", strtotime($record["near_date_start"]."+".$duration." DAY"));
			}else{
				$record["date_end"]=$record["near_date_start"];
			}
			$record["date_start"]=$record["near_date_start"];
			unset($record["near_date_start"]);
		}

        if ($record["event_id"]>0 && Engine::isPackageExists($this->Connection->Kernel, "tags")){
			$tags=array($record["event_id"]=>array());
			$this->GetEventsTags($tags);
			$record["tags"]=$tags[$record["event_id"]]["tags"];
		}

		ImageHelper::CheckImageThumbnail($this->Connection->Kernel, $record["small_image"], $thumb["width"], $thumb["height"], $thumb["color"], $thumb["method"]);

		return $record;
	}

	function GetNextMonthRepeat($id, $date, $year="", $month=""){
		$y=($year!="" ? $year : "Y");
		$m=($month!="" ? $month : "m");
		$ch=$this->prepareCheckEvent($date, date($y."-".$m."-".$this->d(date($m))." 00:00:00"));
		$SQL=sprintf("SELECT %s AS next_repeat_date FROM %s AS e WHERE e.event_id=%d",
						sprintf($ch, 1),
						$this->defaultTableName,
						$id);
		$record=$this->Connection->ExecuteScalar($SQL);
		return $record["next_repeat_date"];
	}

	function UploadEventCheckStoredFunction(){
		$SQL="DROP FUNCTION IF EXISTS CheckEvent";
		$record=$this->Connection->ExecuteNonQuery($SQL);

$SQL=sprintf("
CREATE FUNCTION CheckEvent (period_start DATETIME,
							period_end DATETIME,
							event_start DATETIME,
							event_end DATETIME,
							repeat_event INT,
							repeat_every_count INT,
							repeat_every_term INT,
							repeat_end INT,
							repeat_end_iterations INT,
							repeat_end_day DATETIME,
							mode INT) RETURNS VARCHAR(255)
BEGIN
	DECLARE f VARCHAR(255);

	DECLARE near_event_start_0 DATETIME;
	DECLARE near_event_end_0 DATETIME;
	DECLARE near_event_start_1 DATETIME;
	DECLARE near_event_end_1 DATETIME;
	DECLARE iteration_date DATETIME;
	DECLARE iterations INT;

	DECLARE month_iteration DATETIME;


	SET f=0;
	SET iterations=0;

	IF repeat_event=1 AND event_start < period_end THEN

		IF repeat_end=2 THEN
   			IF period_start>repeat_end_day THEN
   				SET repeat_every_term=-1;
   				SET f=0;
   			END IF;

   			IF period_start<=repeat_end_day AND repeat_end_day>period_end THEN
   				SET period_end=repeat_end_day;
   			END IF;

   		END IF;


        -- days
        IF repeat_every_term=0 THEN
			SET iterations = ROUND((TO_DAYS(period_start)-TO_DAYS(event_start))/repeat_every_count);

   			IF repeat_end=1 AND iterations>repeat_end_iterations THEN SET iterations=repeat_end_iterations; END IF;

			SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count DAY;
			SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count DAY;
			SET near_event_start_1 = event_start + INTERVAL (iterations+1)*repeat_every_count DAY;
			SET near_event_end_1 = event_end + INTERVAL (iterations+1)*repeat_every_count DAY;

		END IF;

		 -- week
        IF repeat_every_term=1 THEN

        	SET repeat_every_count=repeat_every_count*7;
			SET iterations=0;
            SET iteration_date=event_start;

            IF event_start<period_start THEN
				WHILE iteration_date < period_start DO
					SET iteration_date = iteration_date + INTERVAL repeat_every_count DAY;
					SET iterations = iterations + 1;
				END WHILE;

				IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count DAY;
				SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count DAY;
				SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count DAY;
				SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count DAY;

			ELSE
			    WHILE iteration_date >= period_end DO
					SET iteration_date = iteration_date - INTERVAL repeat_every_count DAY;
					SET iterations = iterations + 1;
				END WHILE;

	   			IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count DAY;
				SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count DAY;
				SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count DAY;
				SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count DAY;

			END IF;

		END IF;

        -- month
		IF repeat_every_term=2 THEN
            SET iterations=0;
            SET iteration_date=event_start;

            IF event_start<=period_start THEN
				WHILE iteration_date < period_start DO
					SET iteration_date = iteration_date + INTERVAL repeat_every_count MONTH;
					SET iterations = iterations + 1;
				END WHILE;

				IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count MONTH;
				SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count MONTH;
				SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count MONTH;
				SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count MONTH;

			ELSE
			    WHILE iteration_date > period_end DO
					SET iteration_date = iteration_date - INTERVAL repeat_every_count MONTH;
					SET iterations = iterations + 1;
				END WHILE;

	   			IF repeat_end=1 AND repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count MONTH;
				SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count MONTH;
				SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count MONTH;
				SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count MONTH;

			END IF;

		END IF;

		-- year
		IF repeat_every_term=3 THEN
            SET iterations=0;
            SET iteration_date=event_start;

            IF event_start<=period_start THEN
				WHILE iteration_date < period_start DO
					SET iteration_date = iteration_date + INTERVAL repeat_every_count YEAR;
					SET iterations = iterations + 1;
				END WHILE;

				IF repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start + INTERVAL iterations*repeat_every_count YEAR;
				SET near_event_end_0 = event_end + INTERVAL iterations*repeat_every_count YEAR;
				SET near_event_start_1 = event_start + INTERVAL (iterations-1)*repeat_every_count YEAR;
				SET near_event_end_1 = event_end + INTERVAL (iterations-1)*repeat_every_count YEAR;

			ELSE
			    WHILE iteration_date > period_end DO
					SET iteration_date = iteration_date - INTERVAL repeat_every_count YEAR;
					SET iterations = iterations + 1;
				END WHILE;

	   			IF repeat_end=1 AND iterations>=repeat_end_iterations THEN SET iterations=repeat_end_iterations-1; END IF;

				SET near_event_start_0 = event_start - INTERVAL iterations*repeat_every_count YEAR;
				SET near_event_end_0 = event_end - INTERVAL iterations*repeat_every_count YEAR;
				SET near_event_start_1 = event_start - INTERVAL (iterations-1)*repeat_every_count YEAR;
				SET near_event_end_1 = event_end - INTERVAL (iterations-1)*repeat_every_count YEAR;

			END IF;

		END IF;

		IF 	(near_event_start_0<=period_end AND near_event_end_0>=period_start) THEN
           SET f=1;
		ELSEIF (near_event_start_1<=period_end AND near_event_end_1>=period_start) THEN
           SET f=2;
		ELSE
           SET f=0;
		END IF;

	ELSE
		-- if no repeat
		IF event_start<=period_end AND event_end>=period_start THEN
			SET f=1;
		ELSE
			SET f=0;
		END IF;
	END IF;

	CASE mode
	    WHEN 0 THEN
	    	IF f=1 OR f=2 THEN
				SET f=1;
			END IF;
	    WHEN 1 THEN

	    	IF iterations>0 THEN
		    	IF f=1 THEN
					SET iterations = ABS(iterations);
				ELSEIF f=2 THEN
			 		SET iterations = ABS(iterations+1);
				END IF;

                IF event_start<period_start THEN
					CASE repeat_every_term
						WHEN 0 THEN SET f=event_start + INTERVAL iterations*repeat_every_count DAY;
						WHEN 1 THEN SET f=event_start + INTERVAL iterations*repeat_every_count DAY;
						WHEN 2 THEN SET f=event_start + INTERVAL iterations*repeat_every_count MONTH;
						WHEN 3 THEN SET f=event_start + INTERVAL iterations*repeat_every_count YEAR;
					END CASE;
				ELSE
					CASE repeat_every_term
						WHEN 0 THEN SET f=event_start - INTERVAL iterations*repeat_every_count DAY;
						WHEN 1 THEN SET f=event_start - INTERVAL iterations*repeat_every_count DAY;
						WHEN 2 THEN SET f=event_start - INTERVAL iterations*repeat_every_count MONTH;
						WHEN 3 THEN SET f=event_start - INTERVAL iterations*repeat_every_count YEAR;
					END CASE;
				END IF;
            ELSE
            	SET f=event_start;
	    	END IF;

	    -- WHEN 2 THEN

            -- WHILE period_start<period_end DO
            --
            -- 	SET month_iteration = CheckEvent( period_start,
			-- 			    period_end,
			-- 			    event_start,
			--			    event_end,
			--			    repeat_event,
			--			    repeat_every_count,
			--			    repeat_every_term,
			--			    repeat_end,
			--			    repeat_end_iterations,
			--			    repeat_end_day,
			--			    1);
   			--  IF month_iteration!=0 THEN
			--		SET f = CONCAT(f, month_iteration);
			--		SET period_start=month_iteration + INTERVAL 1 DAY;
			--	ELSE
			--		SET period_start=period_end;
			--	END IF;
   			--
            -- END WHILE;

	END CASE;      -- SET f=iterations;
	RETURN f;
END"
);
	    $record=$this->Connection->ExecuteNonQuery($SQL);
	}

	function UpdateMixed(&$data){
    	$mixed="";
        if ($data["event_id"]>0){
        	$event=$this->Get(array("event_id"=>$data["event_id"]));

        	$Languages=$this->Connection->Kernel->Languages;

        	foreach($Languages as $Language){
		     	$fields=array("title_".$Language, "full_description_".$Language, "contacts_".$Language);
		     	foreach($fields as $field){
		     		$field=trim(strip_tags($event[$field]));
		     		if ($field!=""){
		            	$mixed.="\n".$field;
		          	}
		   		}
		   		$mixed=trim($mixed);
		     	if ($mixed!=""){
	                $SQL = "UPDATE ".$this->defaultTableName." SET mixed_".$Language."='".$this->Connection->EscapeString($mixed)."' WHERE event_id=".$event["event_id"];
	                $this->Connection->ExecuteNonQuery($SQL);
		     	}
	     	}
     	}
    }

} //--end of class

?>