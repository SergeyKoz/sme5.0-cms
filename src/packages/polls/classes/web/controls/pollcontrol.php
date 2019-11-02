<?php

Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
/**  Cover controll class for main page
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Polls
* @access public
* Класс элемента управления предназначенный для отображения прикрепленного к указанной странице блока
* опроса
**/
class PollControl extends XMLControl {

	var $ClassName = "PollControl";
	var $Version = "1.0";
	/**
	* Method executes on page load
	* @access public
	**/
	function ControlOnLoad(){
		DataFactory::GetStorage($this, "PollsTable", "pollsStorage");
		parent::ControlOnLoad();
	}

	function XmlControlOnRender(&$xmlWriter) {
		$this->cookie=unserialize( str_replace("\\\"", "\"", $_COOKIE["poll"]) );
		$this->cookie=(is_array($this->cookie) ? $this->cookie : array());
		$page_id = DataDispatcher::Get("page_id");
		$poll=$this->pollsStorage->GetPoll(0, $this->cookie, $page_id);

		if (!empty($poll)) {
			$variants = $this->pollsStorage->GetAnsvers($poll["poll_id"]);
			//render poll
			if(!empty($variants)) {
				$xmlWriter->WriteElementString("id", $poll["poll_id"]);
				$xmlWriter->WriteElementString("caption", $poll["caption"]);
				$xmlWriter->WriteElementString("system", $poll["system"]);
				$xmlWriter->WriteElementString("votes", $poll["votes"]);
				if (isset($poll["voted"])){
					$xmlWriter->WriteElementString("voted", $poll["voted"]);
				}else{
					$xmlWriter->WriteElementString("voted", ( in_array($poll["poll_id"], $this->cookie)  ? 1 : 0));
				}

				$size = sizeof($variants);
				$total_polls =$max_polls=0;
				for($i=0; $i<$size; $i++){
					$total_polls += $variants[$i]["votes"];
					$max_polls = ($variants[$i]["votes"] > $max_polls ? $variants[$i]["votes"] : $max_polls);
				}

				$xmlWriter->WriteStartElement("variants");
				for($i=0; $i<$size; $i++){
					$variant_percentage = ($total_polls > 0 ? number_format(($variants[$i]["votes"]/$total_polls)*100,0,".","") : 0);
					$xmlWriter->WriteStartElement("item");
					$xmlWriter->WriteElementString("caption", $variants[$i]["caption"]);

					$xmlWriter->WriteElementString("id", $variants[$i]["poll_id"]);
					$xmlWriter->WriteElementString("votes", $variant_percentage);
					$xmlWriter->WriteElementString("your_variant", $variants[$i]["variants"]);
					if($variants[$i]["votes"] == $max_polls){
						$xmlWriter->WriteElementString("max", 1);
					}
					$xmlWriter->WriteEndElement();
				}
				$xmlWriter->WriteEndElement();
			}    //if
		}

	}     //XmlControlOnRender
}

?>