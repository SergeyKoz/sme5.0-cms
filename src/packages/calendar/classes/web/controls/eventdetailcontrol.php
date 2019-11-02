<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");

   /** Menu control class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Content
     * @access public
     */
class EventDetailControl extends XmlControl {
    var $ClassName = "EventDetailControl";
    var $Version = "1.0";

    function ControlOnLoad() {
        DataFactory::GetStorage($this, "CalendarEventsTable", "eventsStorage");

        $thumb=$this->Page->Kernel->Package->Settings->GetSection("EVENTSDETAILTHUMBS");
    	$this->Event=$this->eventsStorage->GetEvent($this->Page->e, $thumb);

    	if ($this->Event["enable_comments"]==1 && Engine::isPackageExists($this->Page->Kernel, "comments"))
			DataDispatcher::Set ("comments", $this->Event["event_id"], "a", "calendar_".$this->Event["category_id"]);

        parent::ControlOnLoad();
    }

    function CreateChildControls(){
        $lang=$this->Page->Kernel->Language;
    	$pathes = DataDispatcher::Get("PATHES");
        $titles = DataDispatcher::Get("page_titles");
        $base_url = sprintf(DataDispatcher::Get("page_point_url"), $lang);

        $title=$this->Event["category_title"];
        $url=$base_url."/".$this->Event["category_system"]."/";
   		$pathes[] = array(	"title" => $title, "url" => $url);
       	$titles[] = $title;

        $title=$this->Event["title"];
        $url=$url.$this->Event["system"]."/";
   		$pathes[] = array(	"title" => $title, "url" => $url);
       	$titles[] = $title;

        DataDispatcher::Set("PATHES", $pathes);
        DataDispatcher::Set("page_titles", $titles);

        if (Engine::isPackageExists($this->Page->Kernel, "context")){
	        $context_parameters=array(	"item_id"=>$this->Page->e,
	        							"storage"=>$this->eventsStorage);
			$this->Page->Controls["cms_context"]->AddContextMenu("event", "calendar", $context_parameters);
		}

        parent::CreateChildControls();
    }

    function XmlControlOnRender(&$xmlWriter) {
        parent::XmlControlOnRender($xmlWriter);
		$this->XmlTag = "event";
		if (count($this->Event)){
	        $this->data=$this->Event;
	        $this->data["date_start"] = Component::dateconv($this->data["date_start"], false);
	        $this->data["date_end"] = Component::dateconv($this->data["date_end"], false);

	        if (count($this->data["tags"])){
	        	$xmlWriter->WriteStartElement("tags");
		   		foreach ($this->data["tags"] As $tag){
		   			$xmlWriter->WriteStartElement("tag");
		   			$xmlWriter->WriteAttributeString ("tag_decode", $tag["tag_decode"]);
		   			$xmlWriter->WriteString($tag["tag"]);
		   			$xmlWriter->WriteEndElement("tag");
		   		}
		   		$xmlWriter->WriteEndElement("tags");
		   		unset($this->data["tags"]);
		   	}
	        RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }
    }

} //--end of class
?>