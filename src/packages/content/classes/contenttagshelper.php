<?php

 class ContentTagsHelper {
    var $ClassName = "ContentTagsHelper";
    var $Version = "1.0";

    function RenewTagsItemsInformation(&$storageTags, &$tagsItemsStorage){
     	$ls=$storageTags->Connection->Kernel->Languages;

        foreach($ls as $l){
        	$sql=sprintf("	SELECT c.id, c.title_%s AS caption, c.content_%s  AS description, c._lastmodified AS modified_date, c.path
		     					FROM %s AS c LEFT JOIN %s AS tg ON (c.id = tg.item_id AND tg.tag_type='content')
		     					WHERE tg.tag_%s IS NOT NULL
		     					AND c.active=1 AND c.active_%s=1
		     					GROUP BY c.id
		     					ORDER BY modified_date DESC",
		     					$l, $l, $storageTags->GetTable("ContentTable"),
		     					$storageTags->GetTable("TagsTable"), $l, $l);
		    $reader = $storageTags->Connection->ExecuteReader($sql);

		    for($i=0; $i<$reader->RecordCount; $i++){
		   		$record=$reader->read();
		   		$description=strip_tags($record["description"]);
		   		$description=substr(str_replace("\n", " ", $description), 0, 250);
				$pos = strrpos($description, " ");
				if ($pos!==false) $description=rtrim(substr($description, 0, $pos))."...";

		   		$insert_data=array(	"item_id"=>$record["id"],
		   							"item_type"=>"content",
		   							"item_code"=>$record["id"]."content",
		   							"item_date"=>$record["modified_date"],
		   							"entry"=>$record["path"]."/",
		   							"caption"=>$record["caption"],
		   							"description"=>$description,
		   							"language"=>$l);
                $tagsItemsStorage->Insert($insert_data);
			}
        }
    }

    function GetPageTags($object, $id){
		$l=$object->Page->Kernel->Language;
		DataFactory::GetStorage ($object, "ContentTable", "contentStorage");
		$SQL=sprintf("	SELECT t.item_id AS id, t.tag_%s AS tag FROM %s AS t
						WHERE t.tag_%s!='' AND t.tag_code='%dcontent' ORDER BY t.item_id, t.tag_%s",
						$l, $object->contentStorage->GetTable("TagsTable"), $l, $id, $l);
		$reader=$object->contentStorage->Connection->ExecuteReader($SQL);
		$tags=array();
		for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();
			$tags[]=array("tag"=>$record["tag"], "tag_decode"=>urlencode($record["tag"]));
		}
		return $tags;
	 }

 }// class
?>