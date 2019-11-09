<?php

 class PollsTagsHelper {
    var $ClassName = "PollsTagsHelper";
    var $Version = "1.0";

    function RenewTagsItemsInformation(&$storageTags, &$tagsItemsStorage){
     	$ls=$storageTags->Connection->Kernel->Languages;
		
    	$contentStorage = DataFactory::GetStorage($storageTags->Connection->Kernel->Page, "ContentTable", "", false, "tags");
        $record=$contentStorage->Get(array("point_page"=>"polls|poll"));
		
        if ($record["path"]!=""){
        	$path=$record["path"];
	     	$sql=sprintf("	SELECT p.poll_id, p.caption_ru AS caption, p._lastmodified AS modified_date, p.system
	     					FROM %s AS p 
	     					LEFT JOIN %s AS tg ON (p.poll_id = tg.item_id AND tg.tag_type='poll')
	     					WHERE tg.tag_%s IS NOT NULL
	     					GROUP BY p.poll_id
	     					ORDER BY p._priority",
	     					$storageTags->GetTable("PollsTable"), 
	     					$storageTags->GetTable("TagsTable"), "ru");
	     	$reader = $storageTags->Connection->ExecuteReader($sql);
	     	for($i=0; $i<$reader->RecordCount; $i++){
		   		$record=$reader->read();
		   		$description="";		   		
		   		$entry=$path."/".$record["system"].".htm";
		   		$insert_data=array(	"item_id"=>$record["poll_id"],
		   							"item_type"=>"poll",
		   							"item_code"=>$record["poll_id"]."poll",
		   							"item_date"=>$record["modified_date"],
		   							"entry"=>$entry,
		   							"caption"=>$record["caption"],
		   							"description"=>$description,
		   							"language"=>"ru");
                $tagsItemsStorage->Insert($insert_data);
		   	}
	   	}
    }

 }// class
?>