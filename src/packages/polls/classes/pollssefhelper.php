<?php

 class PollsSEFHelper {
    var $ClassName = "PollsSEFHelper";
    var $Version = "1.0";

    function GetPageData($url, &$object){

		$PollsPage="polls";
		if (substr($url, 0, 5)."/"==$PollsPage."/" && substr($url, -4)==".htm"){
            $pollsystem=substr($url, 6, strlen($url)-10);
            $l=$object->Connection->Kernel->Language;

			if ($pollsystem!=""){
				$SQL=sprintf(	"SELECT p.poll_id FROM %s AS p
								WHERE p.active_%s=1 AND p.system='%s'
								LIMIT 0, 1",
								$object->GetTable("PollsTable"), $l, $pollsystem);
				$poll=$object->Connection->ExecuteScalar($SQL);
				if ($poll["poll_id"]>0){
					$SQL=sprintf("SELECT * FROM %s WHERE active =1 AND name='%s' ORDER BY level",
									$object->defaultTableName, $PollsPage);
					$page_data=$object->Connection->ExecuteScalar($SQL);
					$page_data["point_php_code"]="\$_GET['poll_id']=".$poll["poll_id"].";";
				}
			}
    	}
        return $page_data;
    }
 }// class
?>