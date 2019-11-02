<?php

 class PublicationsContextHelper {
    var $ClassName = "PublicationsContextHelper";
    var $Version = "1.0";

    // check methods //

    // publication
    function PublicationEdit(&$parameters){
    	$res=false;
    	$this->GetPublication($parameters);
    	return (!empty($this->publication) ? true : false);
    }

    function PublicationActivate(&$parameters){
    	$this->GetPublication($parameters);
    	return ((!empty($this->publication) && $this->publication["active_".$parameters["language"]]==0) ? true : false);
    }

    function PublicationDeactivate(&$parameters){
    	$this->GetPublication($parameters);
    	return ((!empty($this->publication) && $this->publication["active_".$parameters["language"]]==1) ? true : false);
    }

    function PublicationDelete(&$parameters){
    	$res=false;
    	$this->GetPublication($parameters);
    	if (!empty($this->publication)){
	    	$childsCount=$parameters["storage"]->GetCount(array("parent_id"=>$parameters["item_id"]));
	    	$sql=sprintf("SELECT count(*) AS c FROM %s WHERE publication_id=%s", $parameters["storage"]->GetTable("MappingTable"), $parameters["item_id"]);
	    	$record=$parameters["storage"]->Connection->ExecuteScalar($sql);
	    	if ($record["c"]==0 && $childsCount==0) $res=true;
    	}
    	return $res;
    }

    function PublicationSeparator1(&$parameters){
        return (!empty($this->publication) && $this->GetCommentsEnable($parameters) ? true : false);
    }

    function PublicationCommentsEnable(&$parameters){
    	$this->GetPublication($parameters);
    	return (!empty($this->publication) && $this->GetCommentsEnable($parameters) && $this->publication["disable_comments"]==1 ? true : false);
    }

    function PublicationCommentsDisable(&$parameters){
    	$this->GetPublication($parameters);
    	return (!empty($this->publication) && $this->GetCommentsEnable($parameters) && $this->publication["disable_comments"]==0 ? true : false);
    }

    function GetCommentsEnable(&$parameters){
    	$res=false;
    	if (!empty($this->publication)){
    		$mappings=$parameters["storage"]->Connection->Kernel->Page->Controls["cms_publications"]->mappings;
    		if (is_array($mappings))
	    		foreach ($mappings as $m)
	    			if ($m["enable_comments"]==1 && $m["publication_type"]==0 && $m["publication_id"]==$this->publication["publication_id"])
	        			$res=true;
    	}
    	return $res;
    }

    function GetPublication(&$parameters){
    	if (empty($this->publication))
            $this->publication=$parameters["storage"]->Get(array("publication_id"=>$parameters["item_id"]));
    }

    // mapping
    function MappingAddItem(&$parameters){
    	return $this->GetMapping($parameters);
    }

    function MappingProperties(&$parameters){
    	return $this->GetMapping($parameters);
    }

    function MappingDeactivate(&$parameters){
    	$res=false;
    	if ($this->GetMapping($parameters)){
    		$record=$parameters["storage"]->Get(array("mapping_id"=>$parameters["item_id"], "active"=>1));
    		if ($record["mapping_id"]>0) $res=true;
    	}
    	return $res;
    }

	function GetMapping(&$parameters){
		$res=false;
		if ($this->mapping_id>0){
			$res=true;
		} else {
			$record=$parameters["storage"]->Get(array("mapping_id"=>$parameters["item_id"]));
            $sql=sprintf("SELECT count(*) AS c FROM %s AS p JOIN %s AS t ON (p.template_id=t.template_id) WHERE p.publication_id=%s AND t.is_category=1",
	    				$parameters["storage"]->GetTable("PublicationsTable"), $parameters["storage"]->GetTable("TemplatesTable"), $parameters["publication_id"]);
	    	$_record=$parameters["storage"]->Connection->ExecuteScalar($sql);
			if ($record["mapping_id"]>0 && $_record["c"]==1){
				$this->mapping_id=$record["mapping_id"];
				$res=true;
			}
		}
		return $res;
	}

    // action methods //

    // publication
    function OnPublicationActivation(&$object){
    	$res="";
		if ($this->GetActionPublication($object)){
			$l=$object->Request->Value("language");
			if ($this->CheckLanguage($l, $object)){
				$updateData=array("publication_id"=>$this->publication_id, "active_".$l=>1);
				$object->publicationsStorage->Update($updateData);
			}
			$res=$object->SetMessages(array("CTX_PUBLICATION_ACTIVATED"));
		}
		return $res;
	}

	function OnPublicationDeactivation(&$object){
		$res="";
		if ($this->GetActionPublication($object)){
			$l=$object->Request->Value("language");
			if ($this->CheckLanguage($l, $object)){
				$updateData=array("publication_id"=>$this->publication_id, "active_".$l=>0);
				$object->publicationsStorage->Update($updateData);
			}
			$res=$object->SetMessages(array("CTX_PUBLICATION_DEACTIVATED"));
		}
		return $res;
	}

	function OnPublicationDelete(&$object){
		$res="";
		if ($this->GetActionPublication($object)){
			$childs=$object->publicationsStorage->GetCount(array("parent_id"=>$this->publication_id));
	    	$sql=sprintf("SELECT count(*) AS c FROM %s WHERE publication_id=%s",
	    				$object->publicationsStorage->GetTable("MappingTable"), $this->publication_id);
	    	$record=$object->publicationsStorage->Connection->ExecuteScalar($sql);
	    	if ($record["c"]==0 && $childs==0){
	    		$sql=sprintf("DELETE FROM %s WHERE publication_id=%s", $object->publicationsStorage->GetTable("PublicationParamsTable"), $this->publication_id);
	    		$object->publicationsStorage->Connection->ExecuteNonQuery($sql);
	    		if (Engine::isPackageExists($object->Kernel, "tags")){
        		    $sql=sprintf("DELETE FROM %s WHERE tag_type='publication' AND item_id=%d",
        		    			$object->publicationsStorage->GetTable("TagsTable"), $this->publication_id);
	    			$object->publicationsStorage->Connection->ExecuteNonQuery($sql);
	    		}
	    		$delete_data=array("publication_id"=>$this->publication_id);
	    		$object->publicationsStorage->Delete($delete_data);
	    		$res=$object->SetMessages(array("CTX_PUBLICATION_DELETED"));
	    	}
	  	}

		return $res;
	}

	 function OnCommentsEnable(&$object){
		$res="";
		if ($this->GetActionPublication($object)){
			$updateData=array("publication_id"=>$this->publication_id, "disable_comments"=>0);
			$object->publicationsStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_ENABLED"));
		}
		return $res;
    }

    function OnCommentsDisable(&$object){
		$res="";
		if ($this->GetActionPublication($object)){
			$updateData=array("publication_id"=>$this->publication_id, "disable_comments"=>1);
			$object->publicationsStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_COMMENTS_DISABLES"));
		}
		return $res;
    }

	function GetActionPublication(&$object){
		$res=false;
		if (empty($this->publication)){
			$this->publication_id = $object->Request->Value("item_id");
			DataFactory::GetStorage ($object, "PublicationsTable", "publicationsStorage");
			TableHelper::prepareColumnsDB($object->publicationsStorage, true, false);
			$this->publication=$object->publicationsStorage->Get(array("publication_id"=>$this->publication_id));
			if (!empty($this->publication)) $res=true;
		}
		return $res;
	}

	function CheckLanguage($l, &$object){
		$res=false;
		if ($object->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1){
			if (in_array($l, $object->Kernel->Languages))
				$res=true;
		} elseif ($object->Kernel->Language==$l)
			$res=true;
		return $res;
	}

	// mapping
	function OnMappingDeactivation(&$object){
		if ($this->GetActionMapping($object) && $this->mapping["active"]==1){
			$updateData=array("mapping_id"=>$this->mapping_id, "active"=>0);
			$object->mappingsStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_MAPPING_DEACTIVATED"));
	  	}
	  	return $res;
	}

	function GetActionMapping(&$object){
		$res=false;
		if (empty($this->mapping)){
			$this->mapping_id = $object->Request->Value("item_id");
			DataFactory::GetStorage ($object, "MappingTable", "mappingsStorage");
			TableHelper::prepareColumnsDB($object->mappingsStorage, true, false);
			$this->mapping=$object->mappingsStorage->Get(array("mapping_id"=>$this->mapping_id));
			if (!empty($this->mapping)) $res=true;
		}
		return $res;
	}

 }// class
?>