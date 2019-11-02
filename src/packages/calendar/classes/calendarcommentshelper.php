<?php

 class CalendarCommentsHelper {

    var $ClassName = "CalendarCommentsHelper";
    var $Version = "1.0";

    function UpdateCommentsGroup(&$CommentsControl, $group_id){
    	$ls=$CommentsControl->Page->Kernel->Languages;

    	$select=array();
    	foreach($ls as $l)$select[]="caption_".$l." AS group_name_".$l;
    	$select=implode(", ",$select);

    	$SQL=sprintf("SELECT %s,
    						(SELECT group_id FROM %s WHERE group_id='calendar%d' LIMIT 0,1) AS group_id
    						 FROM %s WHERE category_id=%d", $select,
    						 $CommentsControl->commentsStorage->GetTable("CommentGroupsTable"), $group_id,
    						 $CommentsControl->commentsStorage->GetTable("CalendarCategoriesTable"), $group_id);
    	$record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);
        $update=array();
    	foreach($ls as $l)$update["group_name_".$l]=$record["group_name_".$l];

     	if ($record["group_id"]!=""){
    		$update_data=$update;
    		$update_data["group_id"]="calendar".$record["group_id"];
           	$CommentsControl->commentGroupsStorage->Update(&$update_data);
    	}else{
            $insert_data=$update;
    		$insert_data["group_id"]="calendar".$group_id;
           	$CommentsControl->commentGroupsStorage->Insert(&$insert_data);
     	}
     	return $update["group_name_".$ls[0]];
    }

    function GetArticleTitle(&$CommentsControl, $article_id, $group_id){
    	$ls=$CommentsControl->Page->Kernel->Languages;

    	$select=array();
    	foreach($ls as $l)$select[]="title_".$l;
    	$select=implode(", ",$select);

    	$SQL=sprintf("SELECT %s, active FROM %s WHERE event_id=%d", $select,
					 $CommentsControl->commentsStorage->GetTable("CalendarEventsTable"), $article_id);

        $record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);
		if ($record["active"]==1){
	       	$title=$record["title_".$ls[0]];
	       	if ($title=="")
		       	for ($i=1; $i<count($ls); $l++)
		       		if ($record["title_".$ls[$i]]!="")
		                $title=$record["title_".$ls[$i]];
        }

        return $title;
    }

 }// class
?>