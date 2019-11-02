<?php

 class CommentsContextHelper {
    var $ClassName = "CommentsContextHelper";
    var $Version = "1.0";

    // check methods //

    // comment
    function CommentEdit(&$parameters){
    	$this->GetComment($parameters);
        return (!empty($this->comment) ? true : false);
    }

    function CommentDecline(&$parameters){
    	$this->GetComment($parameters);
        return ($this->comment["published"]==1 ? true : false);
    }

     function CommentDelete(&$parameters){
    	$this->GetComment($parameters);
        return (!empty($this->comment) ? true : false);
    }

    function GetComment(&$parameters){
        if ( empty($this->comment) && isset($parameters["storage"]) )
            $this->comment=$parameters["storage"]->Get(array("comment_id"=>$parameters["item_id"]));
    }

    // actions block

    // comment

    function OnCommentDecline(&$object){
        $res="";
		if ($this->GetActionComment($object)){
			$updateData=array("comment_id"=>$this->comment_id, "published"=>0);
			$object->commentsStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_COMMENT_DECLINED"));
		}
		return $res;
    }

    function OnCommentDelete(&$object){
        $res="";
		if ($this->GetActionComment($object)){
			$deleteData=array("comment_id"=>$this->comment_id);
			$object->commentsStorage->Delete($deleteData);
			$res=$object->SetMessages(array("CTX_COMMENT_DELETED"));
		}
		return $res;
    }

    function GetActionComment(&$object){
		$res=false;
		if (empty($this->comment)){
			$this->comment_id = $object->Request->Value("item_id");
			DataFactory::GetStorage ($object, "CommentsTable", "commentsStorage");
			TableHelper::prepareColumnsDB($object->commentsStorage, true, false);
			$this->comment=$object->commentsStorage->Get(array("comment_id"=>$this->comment_id));
			if (!empty($this->comment)) $res=true;
		}
		return $res;
	}



    /*
    // events default

    // events list
    function EventsListAdd(&$parameters){
    	return true;
    }

    function EventsListSeparator1(&$parameters){
    	$this->GetCategory(&$parameters);
        return (!empty($this->category) ? true : false);
    }

    function EventsListCategoryEdit(&$parameters){
    	$this->GetCategory(&$parameters);
        return (!empty($this->category) ? true : false);
    }

    function EventsListActivate(&$parameters){
    	$this->GetCategory(&$parameters);
    	return (!empty($this->category) && $this->category["active"]==0 ? true : false);
    }

    function EventsListDeactivate(&$parameters){
    	$this->GetCategory(&$parameters);
    	return (!empty($this->category) && $this->category["active"]==1 ? true : false);
    }

    // event
    function EventEdit(&$parameters){
    	$this->GetEvent(&$parameters);
        return (!empty($this->e) ? true : false);
    }

    function EventActivate(&$parameters){
    	$this->GetEvent(&$parameters);
    	return (!empty($this->e) && $this->e["active"]==0 ? true : false);
    }

    function EventDeactivate(&$parameters){
    	$this->GetEvent(&$parameters);
    	return (!empty($this->e) && $this->e["active"]==1 ? true : false);
    }

    function EventDelete(&$parameters){
	    $this->GetEvent(&$parameters);
        return (!empty($this->e) ? true : false);
    }

    function EventSeparator1(&$parameters){
        return true;
    }

    function EventCommentsEnable(&$parameters){
    	$this->GetEvent(&$parameters);
    	return ($this->e["enable_comments"]==0 ? true : false);
    }

    function EventCommentsDisable(&$parameters){
    	$this->GetEvent(&$parameters);
    	return ($this->e["enable_comments"]==1 ? true : false);
    }

    function GetCategory(&$parameters){
        if ( empty($this->category) && isset($parameters["storage"]) )
            $this->category=$parameters["storage"]->Get(array("category_id"=>$parameters["category_id"]));
    }

    function GetEvent(&$parameters){
        if ( empty($this->e) && isset($parameters["storage"]) )
            $this->e=$parameters["storage"]->Get(array("event_id"=>$parameters["item_id"]));
    }

    // action methods //

    // events list
    function OnEventsCategoryDeactivation(&$object){
		$res="";
		if ($this->GetActionCategory(&$object)){
			$updateData=array("category_id"=>$this->category_id, "active"=>0);
			$object->calendarCategoriesStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_EVENTS_CATEGORY_DEACTIVATED"));
		}
		return $res;
    }

    function OnEventsCategoryActivation(&$object){
		$res="";
		if ($this->GetActionCategory(&$object)){
			$updateData=array("category_id"=>$this->category_id, "active"=>1);
			$object->calendarCategoriesStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_EVENTS_CATEGORY_ACTIVATED"));
		}
		return $res;
    }

    function GetActionCategory(&$object){
		$res=false;
		if (empty($this->category)){
			$this->category_id = $object->Request->Value("item_id");
			DataFactory::GetStorage ($object, "CalendarCategoriesTable", "calendarCategoriesStorage");
			TableHelper::prepareColumnsDB(&$object->calendarCategoriesStorage, true, false);
			$this->category=$object->calendarCategoriesStorage->Get(array("category_id"=>$this->category_id));
			if (!empty($this->category)) $res=true;
		}
		return $res;
	}

	function OnEventDeactivation(&$object){
		$res="";
		if ($this->GetActionEvent(&$object)){
			$updateData=array("event_id"=>$this->event_id, "active"=>0);
			$object->eventsStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_EVENT_DEACTIVATED"));
		}
		return $res;
    }

    function OnEventActivation(&$object){
		$res="";
		if ($this->GetActionEvent(&$object)){
			$updateData=array("event_id"=>$this->event_id, "active"=>1);
			$object->eventsStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_EVENT_ACTIVATED"));
		}
		return $res;
    }

    function OnEventDelete(&$object){
        if ($this->GetActionEvent(&$object)){
    		if (Engine::isPackageExists($object->Kernel, "tags")){
       		    $sql=sprintf("DELETE FROM %s WHERE tag_type='event' AND item_id=%d",
       		    			$object->eventsStorage->GetTable("TagsTable"), $this->event_id);
    			$object->eventsStorage->Connection->ExecuteNonQuery($sql);
    		}
    		$delete_data=array("event_id"=>$this->event_id);
   			$object->eventsStorage->Delete(&$delete_data);
    		$res=$object->SetMessages(array("CTX_EVENT_DELETED"));
	  	}
	  	return $res;
    }

    function OnCommentsEnable(&$object){
		$res="";
		if ($this->GetActionEvent(&$object)){
			$updateData=array("event_id"=>$this->event_id, "enable_comments"=>1);
			$object->eventsStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_ENABLED"));
		}
		return $res;
    }

    function OnCommentsDisable(&$object){
		$res="";
		if ($this->GetActionEvent(&$object)){
			$updateData=array("event_id"=>$this->event_id, "enable_comments"=>0);
			$object->eventsStorage->Update(&$updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_DISABLES"));
		}
		return $res;
    }

	function GetActionEvent(&$object){
		$res=false;
		if (empty($this->e)){
			$this->event_id = $object->Request->Value("item_id");
			DataFactory::GetStorage ($object, "CalendarEventsTable", "eventsStorage");
			TableHelper::prepareColumnsDB(&$object->eventsStorage, true, false);
			$this->e=$object->eventsStorage->Get(array("event_id"=>$this->event_id));
			if (!empty($this->e)) $res=true;
		}
		return $res;
	}   */

 }// class
?>