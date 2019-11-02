<?php

 class CalendarTagsHelper {
    var $ClassName = "CalendarTagsHelper";
    var $Version = "1.0";

    function RenewTagsItemsInformation(&$storageTags, &$tagsItemsStorage){
     	$ls=$storageTags->Connection->Kernel->Languages;

    	$contentStorage = DataFactory::GetStorage($storageTags->Connection->Kernel->Page, "ContentTable", "", false, "tags");
        $record=$contentStorage->Get(array("point_page"=>"calendar|calendar"));

        if ($record["path"]!=""){
        	$path=$record["path"];

	        foreach($ls as $l){
		     	$sql=sprintf("	SELECT e.event_id, e.system, c.system AS category_system, e.title_%s AS caption, e.short_description_%s  AS description, e._lastmodified AS modified_date
		     					FROM %s AS e
		     					JOIN %s AS c ON (	c.category_id=e.category_id
		     										AND c.active=1
		     										AND e.active=1)
		     					LEFT JOIN %s AS tg ON (e.event_id = tg.item_id AND tg.tag_type='event')
		     					WHERE tg.tag_%s IS NOT NULL
		     					GROUP BY e.event_id
		     					ORDER BY e.date_start DESC",
		     					$l, $l, $storageTags->GetTable("CalendarEventsTable"),
		     					$storageTags->GetTable("CalendarCategoriesTable"),
		     					$storageTags->GetTable("TagsTable"), $l);
		     	$reader = $storageTags->Connection->ExecuteReader($sql);

		     	for($i=0; $i<$reader->RecordCount; $i++){
			   		$record=$reader->read();
			   		$description=$record["description"];
			   		$description=substr(str_replace("\n", " ", $description), 0, 250);
					$pos = strrpos($description, " ");
					if ($pos!==false) $description=rtrim(substr($description, 0, $pos))."...";

			   		$entry=$path."/".$record["category_system"]."/".$record["system"]."/";
			   		$insert_data=array(	"item_id"=>$record["event_id"],
			   							"item_type"=>"event",
			   							"item_code"=>$record["event_id"]."event",
			   							"item_date"=>$record["modified_date"],
			   							"entry"=>$entry,
			   							"caption"=>$record["caption"],
			   							"description"=>$description,
			   							"language"=>$l);
	                $tagsItemsStorage->Insert($insert_data);
			   	}
		   	}
	   	}
    }

 }// class
?>