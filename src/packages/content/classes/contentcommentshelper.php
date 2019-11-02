<?php

 class ContentCommentsHelper {

    var $ClassName = "ContentCommentsHelper";
    var $Version = "1.0";

    function UpdateCommentsGroup(&$CommentsControl, $group_id){

    	$ls=$CommentsControl->Page->Kernel->Languages;

    	$SQL=sprintf("SELECT id FROM %s WHERE group_id='content'",$CommentsControl->commentsStorage->GetTable("CommentGroupsTable"));
    	$record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);

    	if (empty($record)){
            $insert_data=array();
	    	foreach($ls as $l){
	    		$insert_data["group_name_".$l]=$CommentsControl->Page->Kernel->Localization->GetItem("MAIN", "comments_content_group_title_".$l);
	    	}

			$insert_data["group_id"]="content";
	        $CommentsControl->commentGroupsStorage->Insert($insert_data);
    	}
    	return $CommentsControl->Page->Kernel->Localization->GetItem("MAIN", "comments_content_group_title_".$ls["0"]);
    }

    function GetArticleTitle(&$CommentsControl, $article_id, $group_id){
    	$ls=$CommentsControl->Page->Kernel->Languages;

    	$MultiLanguage=$CommentsControl->Page->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage");
    	$ls=$CommentsControl->Page->Kernel->Languages;

    	$select=array();
    	foreach($ls as $l){
    		$select[]="title_".$l.", active_".$l;
    	}
    	$select=implode(", ",$select);
    	$SQL=sprintf("SELECT %s, active FROM %s WHERE id=%d", $select,
					 $CommentsControl->commentsStorage->GetTable("ContentTable"), $article_id);
        $record=$CommentsControl->commentsStorage->Connection->ExecuteScalar($SQL);

        if ($MultiLanguage){
			if ($record["active_".$ls[0]]==1){
	        	$title=$record["title_".$ls[0]];
	        } else {
	        	for ($i=1; $i<count($ls); $i++){
	                if ($record["title_".$ls[$i]]!="" && $record["active_".$ls[$i]]==1){
	                	$title=$record["title_".$ls[$i]];
	             	}
	        	}
	        }
        }elseif ($record["active"]==1){
            $title=$record["title_".$ls[0]];
        }

        return $title;
    }

 }// class
?>