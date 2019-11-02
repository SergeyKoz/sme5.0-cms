<?php

 class ContentContextHelper {
    var $ClassName = "ContentContextHelper";
    var $Version = "1.0";

    // check methods //

    // menu
    function MenuEdit(&$parameters){
    	return true;
    }

    //content
    function ContentEdit(&$parameters){
    	$this->GetPage($parameters);
    	return (!empty($this->page) ? true : false);
    }

    function GetPage(&$parameters){
    	if (empty($this->page))
            $this->page=$parameters["storage"]->Get(array("id"=>$parameters["item_id"]));
    }

    function ContentDeactivate(&$parameters){
    	if ($parameters["storage"]->Connection->Kernel->MultiLanguage){
	    	$this->GetPage($parameters);
	    	return ($this->page["active_".$parameters["language"]]==1 ? true : false);
    	} else {
    		return false;
    	}
    }

    function ContentActivate(&$parameters){
    	if ($parameters["storage"]->Connection->Kernel->MultiLanguage){
	    	$this->GetPage($parameters);
	    	return ($this->page["active_".$parameters["language"]]==0 ? true : false);
    	} else {
    		return false;
    	}
    }

    function ContentSeparator1(&$parameters){
        return true;
    }

    function ContentCommentsEnable(&$parameters){
    	$this->GetPage($parameters);
    	return ($this->page["enable_comments"]==0 ? true : false);
    }

    function ContentCommentsDisable(&$parameters){
    	$this->GetPage($parameters);
    	return ($this->page["enable_comments"]==1 ? true : false);
    }

    // sitemap
    function SitemapEdit(&$parameters){
    	return true;
    }

    //page
    function PageAdd(&$parameters){
    	$this->GetPage($parameters);
    	return (!empty($this->page) ? true : false);
    }

    function PageEdit(&$parameters){
    	$this->GetPage($parameters);
    	return (!empty($this->page) ? true : false);
    }

    function PageDeactivate(&$parameters){
    	$this->GetPage($parameters);
    	return ($this->page["active"]==1 ? true : false);
    }

    /*function PageActivate(&$parameters){
    	$this->GetPage(&$parameters);
    	return ($this->page["active"]==0 ? true : false);
    }*/

    function PageDelete(&$parameters){
    	$res=false;
    	$this->GetPage($parameters);
        if (!empty($this->page)){
	    	$childsCount=$parameters["storage"]->GetCount(array("parent_id"=>$parameters["item_id"]));
            if ($childsCount==0) $res=true;
    	}
    	return $res;
    }

    // action methods //

    // content
    function OnContentDeactivation(&$object){
		$res="";
		if ($this->GetActionPage($object) && $object->Kernel->MultiLanguage){
			$language = $object->Request->Value("language");
			$updateData=array("id"=>$this->page_id, "active_".$language=>0);
			$object->contentStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_PAGE_CONTENT_DEACTIVATED"));
		}
		return $res;
    }

    function OnCommentsEnable(&$object){
		$res="";
		if ($this->GetActionPage($object)){
			$updateData=array("id"=>$this->page_id, "enable_comments"=>1);
			$object->contentStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_ENABLED"));
		}
		return $res;
    }

    function OnCommentsDisable(&$object){
		$res="";
		if ($this->GetActionPage($object)){
			$updateData=array("id"=>$this->page_id, "enable_comments"=>0);
			$object->contentStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_DISABLES"));
		}
		return $res;
    }

    // page

    function OnPageDeactivation(&$object){
		$res="";
		if ($this->GetActionPage($object)){
			$updateData=array("id"=>$this->page_id, "active"=>0);
			$object->contentStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_PAGE_DEACTIVATED"));
		}
		return $res;
    }

    function OnPageActivation(&$object){
		$res="";
		if ($this->GetActionPage($object)){
			$updateData=array("id"=>$this->page_id, "active"=>1);
			$object->contentStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_PAGE_ACTIVATED"));
		}
		return $res;
    }

    function OnPageDelete(&$object){
        if ($this->GetActionPage($object)){
            $childsCount=$object->contentStorage->GetCount(array("parent_id"=>$this->page_id));
	    	if ($childs==0){
	    		if (Engine::isPackageExists($object->Kernel, "tags")){
        		    $sql=sprintf("DELETE FROM %s WHERE tag_type='content' AND item_id=%d",
        		    			$object->contentStorage->GetTable("TagsTable"), $this->page_id);
	    			$object->contentStorage->Connection->ExecuteNonQuery($sql);
	    		}

	    		if (Engine::isPackageExists($object->Kernel, "banner")){
        		    $sql=sprintf("DELETE FROM %s WHERE page_id=%d",
        		    			$object->contentStorage->GetTable("BannerPagesTable"), $this->page_id);
	    			$object->contentStorage->Connection->ExecuteNonQuery($sql);
	    		}

	    		$delete_data=array("id"=>$this->page_id);
	    		$object->contentStorage->Delete($delete_data);
	    		$res=$object->SetMessages(array("CTX_PAGE_DELETED"));
	    	}
	  	}
    }

    function GetActionPage(&$object){
		$res=false;
		if (empty($this->page)){
			$this->page_id = $object->Request->Value("item_id");

			DataFactory::GetStorage ($object, "ContentTable", "contentStorage");
			TableHelper::prepareColumnsDB($object->contentStorage, true, false);
			$this->page=$object->contentStorage->Get(array("id"=>$this->page_id));
			if (!empty($this->page)) $res=true;
		}
		return $res;
	}


 }// class
?>