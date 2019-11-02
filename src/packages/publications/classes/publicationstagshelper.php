<?php

 class PublicationsTagsHelper {
    var $ClassName = "PublicationsTagsHelper";
    var $Version = "1.0";

    function RenewTagsItemsInformation(&$storageTags, &$tagsItemsStorage){
     	$ls=$storageTags->Connection->Kernel->Languages;

        foreach($ls as $l){
	     	$sql=sprintf("	SELECT p.publication_id, p.system, p._sort_caption_%s AS caption, p.mixed_content_%s  AS mixed, p._sort_date, c.path
	     					FROM %s AS p
	     					JOIN %s AS t ON (	p.template_id=t.template_id
	     										AND t.enable_tags=1
	     										AND t.active=1
	     										AND t.base_mapping_tags>0
	     										AND p.active_%s=1
	     										AND p.is_modified = 0
	     										AND p.copy_of_id = 0 )
	     					JOIN %s AS m ON (m.mapping_id=t.base_mapping_tags AND m.active=1)
	     					LEFT JOIN %s AS tg ON (p.publication_id = tg.item_id AND tg.tag_type='publication')
	     					JOIN %s AS c ON (m.page_id=c.id AND c.active=1)
	     					WHERE tg.tag_%s IS NOT NULL
	     					GROUP BY p.publication_id
	     					ORDER BY p._sort_date DESC",
	     					$l, $l, $storageTags->GetTable("PublicationsTable"),
	     					$storageTags->GetTable("TemplatesTable"),$l,
	     					$storageTags->GetTable("MappingTable"),
	     					$storageTags->GetTable("TagsTable"),
	     					$storageTags->GetTable("ContentTable"), $l);
	     	$reader = $storageTags->Connection->ExecuteReader($sql);

	     	for($i=0; $i<$reader->RecordCount; $i++){
		   		$record=$reader->read();
		   		$description=$record["mixed"];
		   		$description=trim(str_replace($record["caption"]."\n", "", $description));
		   		$description=substr(str_replace("\n", " ", $description), 0, 250);
				$pos = strrpos($description, " ");
				if ($pos!==false) $description=rtrim(substr($description, 0, $pos))."...";

		   		$entry=$record["path"]."/".$record["system"]."-publication/";
		   		$insert_data=array(	"item_id"=>$record["publication_id"],
		   							"item_type"=>"publication",
		   							"item_code"=>$record["publication_id"]."publication",
		   							"item_date"=>$record["_sort_date"],
		   							"entry"=>$entry,
		   							"caption"=>$record["caption"],
		   							"description"=>$description,
		   							"language"=>$l);
                $tagsItemsStorage->Insert($insert_data);
		   	}
	   	}
    }

 }// class
?>