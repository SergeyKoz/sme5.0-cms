<?php

 class BannerContextHelper {
    var $ClassName = "BannerContextHelper";
    var $Version = "1.0";

    // check methods //

    // banner place
    function Banner_PlaceAdd(&$parameters){
	    $this->GetPlace($parameters);
        return (!empty($this->place) ? true : false);
    }

    function Banner_PlaceEdit(&$parameters){
	    $this->GetPlace($parameters);
        return (!empty($this->place) ? true : false);
    }

    function GetPlace(&$parameters){
        if (empty($this->place))
            $this->place=$parameters["storage"]->Get(array("place_id"=>$parameters["item_id"]));
    }

    // banner
    function BannerEdit(&$parameters){
	    $this->GetBanner($parameters);
        return (!empty($this->banner) ? true : false);
    }

    function GetBanner(&$parameters){
        if (empty($this->banner))
            $this->banner=$parameters["storage"]->Get(array("banner_id"=>$parameters["item_id"]));
    }

    function BannerDeactivate(&$parameters){
    	$this->GetBanner($parameters);
    	return ($this->banner["active"]==1 ? true : false);
    }


    function BannerDeactivateMultiLang(&$parameters){
    	if ($parameters["storage"]->Connection->Kernel->MultiLanguage){
	    	$this->GetBanner($parameters);
	    	if (!empty($this->banner)){
		    	$SQL=sprintf("	SELECT COUNT(*) AS c FROM %s WHERE banner_id=%d AND language='%s'",
					    		$parameters["storage"]->GetTable("BannerLanguagesTable"),
					    		$parameters["item_id"], $parameters["language"]);
		    	$record=$parameters["storage"]->Connection->ExecuteScalar($SQL);
		    	if ($record["c"]==1) return true;
	    	}
    	} else {
    		return false;
    	}
    }

    function BannerDelete(&$parameters){
	    $this->GetBanner($parameters);
        return (!empty($this->banner) ? true : false);
    }

    // action methods //

    // banner
    function OnBannerDeactivation(&$object){
		$res="";
		if ($this->GetActionBanner($object)){
			$updateData=array("banner_id"=>$this->banner_id, "active"=>0);
			$object->bannersStorage->Update($updateData);
			$res=$object->SetMessages(array("CTX_BANNER_DEACTIVATED"));
		}
		return $res;
    }


    function OnBannerDeactivateMultiLanguage(&$object){
		$res="";
		if ($this->GetActionBanner($object)){
			$l=$object->Request->Value("language");
			if (in_array($l, $object->Kernel->Languages)){
                DataFactory::GetStorage ($object, "BannerLanguagesTable", "bannerLanguagesStorage");
                $count=$object->bannerLanguagesStorage->GetCount(array("banner_id"=>$this->banner_id, "language"=>$l));
                if ($count==1){
                	$SQL=sprintf("	DELETE FROM %s WHERE banner_id=%d AND language='%s'",
					    		$object->bannerLanguagesStorage->defaultTableName, $this->banner_id, $l);

					$object->bannerLanguagesStorage->Connection->ExecuteNonQuery($SQL);
					$res=$object->SetMessages(array("CTX_BANNER_LANGUAGE_DEACTIVATED"));
                }
			}
		}
		return $res;
    }

    function OnBannerDelete(&$object){
    	$res="";
		if ($this->GetActionBanner($object)){
			DataFactory::GetStorage ($object, "BannersTable", "bannersStorage");

			$del="DELETE FROM %s WHERE banner_id=%d";

			$sql=sprintf($del, $object->bannersStorage->GetTable("BannerPlacesRelationTable"), $this->banner_id);
    		$object->bannersStorage->Connection->ExecuteNonQuery($sql);

    		$sql=sprintf($del, $object->bannersStorage->GetTable("BannerPagesTable"), $this->banner_id);
    		$object->bannersStorage->Connection->ExecuteNonQuery($sql);

    		$sql=sprintf($del, $object->bannersStorage->GetTable("BannerLanguagesTable"), $this->banner_id);
    		$object->bannersStorage->Connection->ExecuteNonQuery($sql);

    		$delete_data=array("banner_id"=>$this->banner_id);

    		$object->bannersStorage->Delete($delete_data);
    		$res=$object->SetMessages(array("CTX_BANNER_DELETED"));
		}
		return $res;
    }

     function GetActionBanner(&$object){
		$res=false;
		if (empty($this->banner)){
			$this->banner_id = $object->Request->Value("item_id");

			DataFactory::GetStorage ($object, "BannersTable", "bannersStorage");
			TableHelper::prepareColumnsDB($object->bannersStorage, true, false);
			$this->banner=$object->bannersStorage->Get(array("banner_id"=>$this->banner_id));
			if (!empty($this->banner)) $res=true;
		}
		return $res;
	}

 }// class
?>