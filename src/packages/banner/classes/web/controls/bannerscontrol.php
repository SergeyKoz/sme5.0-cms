<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");

    /** Banners control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class BannersControl extends XmlControl {
        var $ClassName = "BannersControl";
        var $Version = "1.0";

        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            DataFactory::GetStorage($this, "BannersTable", "bannersStorage");
            DataFactory::GetStorage($this, "ContentTable", "contentStorage");

        }


        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
            $_page = DataDispatcher::Get("PAGE_DATA");
            if($_page !== false){
                DataFactory::GetStorage($this, "BannerPlacesTable", "bannerplacesStorage");
                DataFactory::GetStorage($this, "BannerEventsTable", "bannereventsStorage");

                $banners=array();
                $reader = $this->bannersStorage->GetBanners($_page["page_id"]);
                for($i=0; $i<$reader->RecordCount; $i++)
                	$banners[] = $reader->Read();

                $places=array();
                $reader = $this->bannerplacesStorage->GetPlacesQuantity();
                for($i=0; $i<$reader->RecordCount; $i++)
                	$places[] = $reader->Read();

                $this->XmlTag="banner";

                foreach ($places as $place){
	                if (Engine::isPackageExists($this->Page->Kernel, "context")){
				        $context_parameters=array(	"item_id"=>$place["place_id"],
				       								"storage"=>$this->bannerplacesStorage);
						$this->Page->Controls["cms_context"]->AddContextMenu("banner_place", "banner", $context_parameters);
					}

                	$xmlWriter->WriteStartElement("bannerplace");
                		$xmlWriter->WriteAttributeString("place_id", $place["place_id"]);
                        $i=0;
	                	if ($place["is_random"]==0){

		                	foreach ($banners as $banner)
		                        if ($place["place_id"]==$banner["place_id"] && $i<$place["max_banners_qty"]){
                                    $this->WriteBanner($xmlWriter, $banner, $_page["page_id"]);
                                    $i++;
		                        }

	                	} else {
	                		$place_panners=array();
	                		foreach ($banners as $banner)
		                        if ($place["place_id"]==$banner["place_id"] && $i<$place["max_banners_qty"])
                                    $place_banners[]=$banner;

		                	$rand_banners=array();
		                	$cnt=count($place_banners);
							while ($cnt!=0){
		                		$c=rand(0, $cnt-1);
		                		$rand_banners[]=$place_banners[$c];
		                		unset($place_banners[$c]);
		                		$place_banners=array_values($place_banners);
                                $cnt--;
		                	}

		                	foreach ($rand_banners as $banner){
		                		if ($i<$place["max_banners_qty"]){
                   					$this->WriteBanner($xmlWriter, $banner, $_page["page_id"]);
                   					$i++;
                   				}
                   			}
	                	}

                	$xmlWriter->WriteEndElement("bannerplace");
                }

                //$this->bannereventsStorage->LogViewEvents($this->LogData);
            }
        }// function

        function WriteBanner(&$xmlWriter, $banner, $page_id){
            $this->data=$banner;
            if (Engine::isPackageExists($this->Page->Kernel, "context")){
		        $context_parameters=array(	"item_id"=>$banner["banner_id"],
		        							"group_id"=>$banner["group_id"],
		        							"language"=>$this->Page->Kernel->Language,
		       								"storage"=>$this->bannersStorage);
				$this->Page->Controls["cms_context"]->AddContextMenu("banner", "banner", $context_parameters);
			}

            if ($this->data["banner_php_text"]!=""){
				ob_start();
				eval($this->data["banner_php_text"]);
				$php_banner = ob_get_contents();
				ob_end_clean();
				$this->data["banner_text"].=$php_banner;
			}
            $this->Page->Kernel->prepareContent($this->data["banner_text"]);
            $this->Page->Kernel->prepareContent($this->data["banner_alt"]);
            //$this->LogData[]=sprintf("(%d, %d, %d, '%s', '%s', '%s')",
            //					$this->data["banner_id"], $page_id, BANNER_EVENT_VIEW,
            //					date("Y-m-d H:i:s", time()), $this->Page->Kernel->Language, sprintf("%u",ip2long($_SERVER["REMOTE_ADDR"])) );
            RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }

} // class

?>