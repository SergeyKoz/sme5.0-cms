<?php

$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.navigationcontrol","NavigationControl");

/**  Cover controll class for main page
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Polls
* @access public
* Элемент управления формирующий блок опроса на странице опроса
**/

class PollPageControl extends XMLControl {
	var $ClassName = "PollPageControl";
	var $Version = "1.0";

	/**
	* Method handles Poll event
	* @access    public
	**/
	function OnPoll(){
		$poll=$this->Page->Request->Value("poll_var", REQUEST_ALL, false);

		if (!in_array($poll["poll"], $this->cookie)){
			if ($this->pollsStorage->UpdatePollState($poll["poll"], $poll["var"])){
				$this->cookie[]=$poll["poll"];
				$_COOKIE["poll"]=serialize($this->cookie);
				setcookie("poll", serialize($this->cookie), time()+3600*24*30, '/');
			}

			$variants=$this->Page->Request->Value("input", REQUEST_ALL, false);

			if ($variants[$poll["var"]]!=""){
				$insert_data=array(	"variant_text"=>$variants[$poll["var"]],
									"q_id"=>$poll["var"],
									"p_id"=>$poll["poll"]);

				$this->variantsStorage->Insert($insert_data);
			}
		}

		$this->PollID=$poll["poll"];

		$message = "&MESSAGE=POLL_SAVED";
		$this->Page->Response->Redirect("?".$message);
	}

	/**
	* Method executes on page load
	* @access public
	**/
	function ControlOnLoad(){
		DataFactory::GetStorage($this, "PollsTable", "pollsStorage");
		DataFactory::GetStorage($this, "PollsVariantsTable", "variantsStorage");

		$this->cookie=unserialize( str_replace("\\\"", "\"", $_COOKIE["poll"]) );
		$this->cookie=(is_array($this->cookie) ? $this->cookie : array());

		$this->PollID=$this->Page->Request->ToNumber("poll_id", 0);

		//initialize navigator
		$AdminSettings=$this->Page->Kernel->AdminSettings["rpp"];
		$this->_RPP = ($AdminSettings>0 ? $AdminSettings : 10);
		$this->_PPD = 10;

		$this->_START = ($this->Page->Request->Value("start") =="" ? "0":$this->Page->Request->Value("start"));
		$this->_TOTAL = $this->pollsStorage->GetPollsCount($this->cookie);

		if($this->_START*$this->_RPP >= $this->_TOTAL){
			$this->_START = ceil($this->_TOTAL/$this->_RPP)-1;
		}
		if($this->_START<0){
			$this->_START=0;
		}
		$this->_URL="?";
		if (isset($PollID)){
			$this->_URL=$this->_URL."poll_id=".$PollID;
		}
	}

	function CreateChildControls(){
		$this->poll=$this->pollsStorage->GetPoll($this->PollID, $this->cookie);
		if (!empty($this->poll) && $this->PollID>0){

			$pathes = DataDispatcher::Get("PATHES");
			$titles = DataDispatcher::Get("page_titles");
			$title=$this->poll["caption"];

			$url="polls/".$this->poll["system"].".htm";

			$pathes[] = array("title" => $title, "url" => $url);
			$titles[] = $title;

			DataDispatcher::Set("PATHES", $pathes);
			DataDispatcher::Set("page_titles", $titles);
		}
		parent::CreateChildControls();
	}

	/**
	*  Method Draws XML-content of a control
	*  @param XMLWriter    $xmlWriter  instance of XMLWriter
	*  @access private
	**/
	function XmlControlOnRender(&$xmlWriter) {

		$poll=$this->poll;

		if (!empty($poll)){
			$variants = $this->pollsStorage->GetAnsvers($poll["poll_id"]);

			$tags[$poll["poll_id"]]=array();
			if (Engine::isPackageExists($this->Page->Kernel, "tags")){
				$this->pollsStorage->GetTags($tags, "poll");
				$tags=$tags[$poll["poll_id"]]["tags"];
			}

			//render poll
			if(!empty($variants)){
				$xmlWriter->WriteElementString("id", $poll["poll_id"]);
				$xmlWriter->WriteElementString("caption", $poll["caption"]);
				$xmlWriter->WriteElementString("votes", $poll["votes"]);
				if (isset($poll["voted"])){
					$xmlWriter->WriteElementString("voted", $poll["voted"]);
				}else{
					$xmlWriter->WriteElementString("voted", ( in_array($poll["poll_id"], $this->cookie)  ? 1 : 0));
				}
				$size = sizeof($variants);
				$total_polls = 0;
				$max_polls = 0;
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

				if (is_array($tags) && !empty($tags)){
					$xmlWriter->WriteStartElement("tags");
					foreach($tags as $tag){
						$xmlWriter->WriteStartElement("item");
						$xmlWriter->WriteAttributeString("tag_decode", $tag["tag_decode"]);
						$xmlWriter->WriteString($tag["tag"]);
						$xmlWriter->WriteEndElement();
					}
                    $xmlWriter->WriteEndElement();
				}
			}    //if
		}

		$xmlWriter->WriteStartElement("polls_list");
		//add navigator
		$this->AddControl(new NavigationControl("navigator","navigator"));
		$this->Controls["navigator"]->SetData(array(
			"start"=>$this->_START,
			"total"=>$this->_TOTAL,
			"rpp"  =>$this->_RPP,
			"ppd"  =>$this->_PPD,
			"url"  =>$this->_URL));

		$polls = $this->pollsStorage->GetPollsList($this->_START*$this->_RPP, $this->_RPP, $this->cookie);

		//render list of polls
		$this->XmlTag = "item";
		if(!empty($polls)){
			foreach($polls as $key => $this->data){
				RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
			}
		}
		$xmlWriter->WriteEndElement("polls_list");
	}//XmlControlOnRender

}// class
?>