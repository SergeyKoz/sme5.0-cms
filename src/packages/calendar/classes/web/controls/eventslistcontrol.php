<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.simplyitemslistcontrol","SimplyItemsListControl");

/** Menu control class
* @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 1.0
* @package Content
* @access public
*/
class EventsListControl extends XmlControl {
    var $ClassName = "EventsListControl";
    var $Version = "1.0";
    var $countMethod="GetEventsCount";
    var $getMethod="GetEventsList";
    var $KeywordsMarkStart="<font color=\"brown\"><b>";
    var $KeywordsMarkEnd="</b></font>";

    function ControlOnLoad(){
    	DataFactory::GetStorage($this, "CalendarEventsTable", "eventsStorage");
    	$this->list_thumb=$this->Page->Kernel->Package->Settings->GetSection("EVENTSLISTTHUMBS");

        parent::ControlOnLoad();
    }

    function CreateChildControls(){
       	parent::CreateChildControls();

       	$filter=&$this->Page->Controls["events_filter"];
       	$data["filter"]=$filter->form;
        $data["storage"]=&$this->eventsStorage;
		$data["countMethod"]=$this->countMethod;
       	$data["getMethod"]=$this->getMethod;
       	$data["rpp"]= $this->Page->Kernel->Package->Settings->GetItem("MAIN", "EventsRPP");
       	$data["url"]=$filter->FilterUrl;
       	$data["sort"]="near_date_start";
       	$this->AddControl(new SimplyItemsListControl("events", "events"));
       	$this->Controls["events"]->initControl($data);

       	if (Engine::isPackageExists($this->Page->Kernel, "context")){
	        $context_parameters=array(	"category_id"=>$filter->data["c"],
	        							"storage"=>$filter->eventsCategoriesStorage);
			$this->Page->Controls["cms_context"]->AddContextMenu("eventslist", "calendar", $context_parameters);
		}
    }

    function XmlControlOnRender(&$xmlWriter) {
    	$EventsList=&$this->Controls["events"]->ItemsList;

    	if (count($EventsList)){
    		$keywords=$this->Page->Controls["events_filter"]->data["keywords"];
    		$xmlWriter->WriteStartElement("tags");
    		for ($i=0; $i<count($EventsList); $i++){
    			$EventsList[$i]["date_start"] = Component::dateconv($EventsList[$i]["date_start"], false);
    			$EventsList[$i]["date_end"] = Component::dateconv($EventsList[$i]["date_end"], false);

    			if ($EventsList[$i]["small_image"]){
                     ImageHelper::CheckImageThumbnail($this->Page->Kernel, $EventsList[$i]["small_image"], $this->list_thumb["width"], $this->list_thumb["height"], $this->list_thumb["color"], $this->list_thumb["method"]);
    			}

    			if ($keywords){
			    	$words=explode(" ",$keywords);
			   		foreach ($words as $word){
			   			$word=trim($word);
		                for ($i=0; $i<count($EventsList); $i++){
		                	$EventsList[$i]["title"]=str_replace($word, $this->KeywordsMarkStart.$word.$this->KeywordsMarkEnd, $EventsList[$i]["title"]);
		                	$EventsList[$i]["short_description"]=str_replace($word, $this->KeywordsMarkStart.$word.$this->KeywordsMarkEnd, $EventsList[$i]["short_description"]);
			    		}
			   		}
		   		}
		   		if (count($EventsList[$i]["tags"])){
			   		foreach ($EventsList[$i]["tags"] As $tag){
			   			$xmlWriter->WriteStartElement("tag");
			   			$xmlWriter->WriteAttributeString ("event_id", $EventsList[$i]["event_id"]);
			   			$xmlWriter->WriteAttributeString ("tag_decode", $tag["tag_decode"]);
			   			$xmlWriter->WriteString($tag["tag"]);
			   			$xmlWriter->WriteEndElement("tag");
			   		}
			   		unset($EventsList[$i]["tags"]);
		   		}
    		}
    		$xmlWriter->WriteEndElement("tags");
    	}
    	parent::XmlControlOnRender($xmlWriter);
    }

    function OnSearch(){
    	if (!count($this->Controls["events"]->ItemsList)){
			$this->Page->AddErrorMessage("MESSAGE","EVENTS_NOT_FOUND");
		}
    }

} //--end of class
?>