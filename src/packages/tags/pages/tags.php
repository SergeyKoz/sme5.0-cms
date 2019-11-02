<?php
 Kernel::ImportClass("project", "ProjectPage");
 Kernel::ImportClass("system.web.controls.simplyitemslistcontrol","SimplyItemsListControl");
 Kernel::ImportClass("system.cache.cache", "Cache");
 Kernel::ImportClass("web.controls.tagscloudcontrol","TagsCloudControl");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class TagsPage extends ProjectPage {
        var $ClassName = "TagsPage";
        var $Version = "1.0";
        var $countMethod = "GetTagsPageCount";
        var $getMethod = "GetTagsPageList";
        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
        	$this->tag=$this->Page->Request->Value("tag");
         	DataFactory::GetStorage($this, "TagsTable", "tagsStorage");
         	$this->tagsStorage->RenewTagInformation();
            parent::ControlOnLoad();
        }

        function CreateChildControls(){
        	parent::CreateChildControls();
	       	if ($this->tag!=""){
		        $data["storage"]=&$this->tagsStorage;
				$data["countMethod"]=$this->countMethod;
		       	$data["getMethod"]=$this->getMethod;
		       	$data["rpp"]= $this->Page->Kernel->AdminSettings["rpp"];
		       	$data["tag"]=$this->tag;
		       	$data["url"]="tag=".urlencode($this->tag);
		       	$this->AddControl(new SimplyItemsListControl("tagslist", "tagslist"));
		       	$this->Controls["tagslist"]->initControl($data);

		       	$pathes = DataDispatcher::Get("PATHES");
		        $titles = DataDispatcher::Get("page_titles");
		        $base_url = DataDispatcher::Get("page_point_url");
		   		$pathes[] = array("title" => $this->tag, "url" => $base_url."/?tag=".urlencode($this->tag));
		       	$titles[] = $this->tag;
		        DataDispatcher::Set("PATHES", $pathes);
		        DataDispatcher::Set("page_titles", $titles);

	       	} else {
	       		$this->AddControl(new TagsCloudControl("tags_cloud", "tags_cloud"));
	       	}


        }

        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
        	$this->XmlTag = "tag";
            $xmlWriter->WriteStartElement("tagslist");
        	if (count($this->tagsStorage->ListItemsTags)){
        		foreach($this->tagsStorage->ListItemsTags as $item=>$tags){
        			$xmlWriter->WriteStartElement("tags");
        			$xmlWriter->WriteAttributeString ("item_id", $item);
                    foreach($tags as $this->data)
						RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
                    $xmlWriter->WriteEndElement("tags");
        		}
        	}
        	$xmlWriter->WriteEndElement("tagslist");
        }// function

} // class

?>