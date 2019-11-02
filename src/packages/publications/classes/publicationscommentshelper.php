<?php

 class PublicationsCommentsHelper {

    var $ClassName = "PublicationsCommentsHelper";
    var $Version = "1.0";

    function UpdateCommentsGroup(&$CommentsControl, $group_id){
    	//$l=$CommentsControl->Page->Kernel->Language;


    	$MultiLanguage=$CommentsControl->Page->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage");

    	if ($MultiLanguage==1){
    		$ls=$CommentsControl->Page->Kernel->Languages;
    	}else{
    		$ls[0]=$CommentsControl->Page->Kernel->Language;
    	}
        $select=array();
    	foreach($ls as $l)$select[]="_sort_caption_".$l." AS group_name_".$l;
    	$select=implode(", ",$select);
    	$SQL=sprintf("SELECT %s,
    						(SELECT group_id FROM %s WHERE group_id='publications%d' LIMIT 0,1) AS group_id
    						 FROM %s WHERE publication_id=%d", $select,
    						 $CommentsControl->commentsStorage->GetTable("CommentGroupsTable"), $group_id,
    						 $CommentsControl->commentsStorage->GetTable("PublicationsTable"), $group_id);
    	$record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);
        $update=array();
    	foreach($ls as $l)$update["group_name_".$l]=$record["group_name_".$l];

    	if ($record["group_id"]!=""){
    		$update_data=$update;
    		$update_data["group_id"]="publications".$record["group_id"];
           	$CommentsControl->commentGroupsStorage->Update($update_data);
    	}else{
            $insert_data=$update;
    		$insert_data["group_id"]="publications".$group_id;
           	$CommentsControl->commentGroupsStorage->Insert($insert_data);
     	}
     	return $update["group_name_".$ls[0]];
    }

    function GetArticleTitle(&$CommentsControl, $article_id, $group_id){
    	$MultiLanguage=$CommentsControl->Page->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage");
    	if ($MultiLanguage==1){
    		$ls=$CommentsControl->Page->Kernel->Languages;
    	}else{
    		$ls[0]=$CommentsControl->Page->Kernel->Language;
    	}

    	$select=array();
    	foreach($ls as $l)$select[]="_sort_caption_".$l.", active_".$l;
    	$select=implode(", ",$select);
        $SQL=sprintf("SELECT %s FROM %s WHERE publication_id=%d", $select,
					 $CommentsControl->commentsStorage->GetTable("PublicationsTable"), $article_id);

        $record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);

        if ($record["active_".$ls[0]]==1){
        	$title=$record["_sort_caption_".$ls[0]];
        } else {
        	for ($i=1; $i<count($ls); $l++)
                if ($record["_sort_caption_".$ls[$i]]!="" && $record["active_".$ls[$i]]==1)
                	$title=$record["_sort_caption_".$ls[$i]];
        }

        return $title;
    }

 }// class
?>