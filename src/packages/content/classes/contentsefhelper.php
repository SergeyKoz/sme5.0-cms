<?php

 class ContentSEFHelper {
    var $ClassName = "ContentSEFHelper";
    var $Version = "1.0";

    function GetPageData($url, &$object){
    	$SQL=sprintf("SELECT *, 1 as is_page FROM %s WHERE active =1 AND %s ORDER BY level",
        			$object->defaultTableName, ($url!="" ? "path LIKE '".$url."'" : "path=''"));
        $page_data=$object->Connection->ExecuteScalar($SQL);
        return $page_data;
    }
 }// class
?>