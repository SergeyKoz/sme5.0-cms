<?php

 class PublicationsSEFHelper {
    var $ClassName = "PublicationsSEFHelper";
    var $Version = "1.0";

    function GetPageData($url, &$object){
    	$parts=explode("/", $url);
    	if (!empty($parts)){
    		$part=$parts[count($parts)-1];
    		if (substr($part, -12)=="-publication"){
    			$system=substr($part, 0, strlen($part)-12);
    			$page=substr($url, 0, strlen($url)-strlen($part)-1);
    			if ($system!="" && $page!=""){
    				$SQL=sprintf(	"SELECT * FROM %s WHERE active =1 AND path='%s'",
	        						$object->defaultTableName, $page);
	        		$page_data=$object->Connection->ExecuteScalar($SQL);

	        		if (!empty($page_data)){
	        			$SQL=sprintf("SELECT publication_id FROM %s WHERE system='%s' ",
	        			$object->getTable("PublicationsTable"), $system);
	        			$publication=$object->Connection->ExecuteScalar($SQL);
	        			if ($publication["publication_id"]>0){
	        				$page_data["point_php_code"]="\$_GET['pid']=".$publication["publication_id"].";";
	        			} else{
	        				unset($page_data);
	        			}
	        		}
    			}
    		}
        }
        return $page_data;
    }
 }// class
?>