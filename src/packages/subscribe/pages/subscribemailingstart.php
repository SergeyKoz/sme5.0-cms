<?php
Kernel::ImportClass("project", "ProjectPage");

/** BizStat page class
* @author Sergey Kozin <skozin@activemedia.com.ua>
* @version 1.0
* @package  BizStat
* @access public
**/
class SubscribeMailingStartPage  extends ProjectPage  {
	var $ClassName="SubscribeMailingStartPage";
	var $Version="1.0";
	var $moder_page = false;
	var $PageMode="Frontend";
	var $access_role_id = array("ADMIN","SUBSCRIBE_MANAGER", "SUBSCRIBE_EDITOR");

	/** Method creates child controls
	* @access public
	**/
    function ControlOnLoad(){
        parent::ControlOnLoad();

       	$event=$this->Request->Value("event");
       	$id=$this->Request->Value("id");
       	$test=$this->Request->Value("test");

       	$GateWay=$this->Kernel->Settings->GetItem("MODULE", "Url")."scripts/subscribemailing.php";

       	$userData=$this->Auth->userData;

       	$password=$userData["user_password"];
		if(!$this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD")){
			$password = md5($password);
		}

		$post_data=array(
			"event"=>$event,
			"id"=>$id,
			"test"=>($test==1 ? "1" : "0"),
			"login"=>$userData["user_login"],
			"password"=>$password);

		$post_data=Component::BuildRequestQuery($post_data);

		$curlParams = array (
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => 0,
			CURLOPT_FAILONERROR => false,
			CURLOPT_HEADER => true,
			CURLOPT_VERBOSE => false,
			CURLOPT_POSTFIELDS => $post_data,
			CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded")
		);

		$ch = curl_init($GateWay);
		curl_setopt_array($ch, $curlParams);

		$mh = curl_multi_init();

		curl_multi_add_handle($mh,$ch);

		$active = null;

		do {
		    $mrc = curl_multi_exec($mh, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		curl_multi_remove_handle($mh, $ch);
		curl_multi_close($mh);

		/*$response = curl_exec($ch);

		$responseHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$responseHttpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlErrorNum = curl_errno($ch);
		curl_close($ch);

		if ($curlErrorNum==CURLE_OK){
			$response = substr($response, $responseHeaderSize);
		}   */


       	/*$u=$this->Auth->userData;
        $PathToPHP=$this->Kernel->Settings->GetItem("MAIN", "PHPSystemPath");
        $PathToProject=$this->Page->Kernel->Settings->GetItem("Module", "SitePath");
        $Script=$PathToProject."scripts/subscribemailing.php ".$event." ".$id." ".$u["user_login"]." ".md5($u["user_password"])." ".($test==1 ? "1" : "0")." ".$PathToProject;
        $cmd=$PathToPHP."php ".$Script." > ".$PathToProject."project/debug/subscribemailingstart.log &";
        echo "<!-- ".$cmd." -->";
        exec($cmd);  */
        die();
	}


}
?>