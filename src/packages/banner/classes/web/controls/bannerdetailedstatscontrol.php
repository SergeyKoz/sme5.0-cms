<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");

    /** Banners Detailed Statistics control control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class BannerDetailedStatsControl extends XmlControl {
        var $ClassName = "BannerDetailedStatsControl";
        var $Version = "1.0";

        /**
        * Method executes on control load
        * @access	public
        **/
        function ControlOnLoad(){
            DataFactory::GetStorage($this, "BannerEventsTable", "bannereventsStorage", true, "banner");
            DataFactory::GetStorage($this, "BannersTable", "bannersStorage", true, "banner");
        }


        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
            $month = $this->Page->Request->ToString("month_id", date("Y-m"));

            $data["month_id"] = $month;
            $data["banner_id"] = $this->Page->Request->ToNumber("banner_id",0);
            $data["page_id"] = $this->Page->Request->ToNumber("page_id", 0);
            $data["place_id"] = $this->Page->Request->ToNumber("place_id", 0);
            $data["day"] = $this->Page->Request->ToString("day", "01");
            $data["date"] = $data["month_id"]."-".$data["day"];
            if($data["banner_id"] == 0){
                $_array = null;
            } else {
                $_array = array("banner_id" => $data["banner_id"]);
            }

            $_reader = $this->bannersStorage->GetList($_array, array("banner_title" => 1));
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $__tmp[$_tmp["banner_id"]]["views"] = 0;
                $__tmp[$_tmp["banner_id"]]["clicks"] = 0;
                $__tmp[$_tmp["banner_id"]]["caption"] = $_tmp["banner_title"];
            }


            $_reader = $this->bannereventsStorage->GetDetailedStats($data, BANNER_EVENT_VIEW);
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $__tmp[$_tmp["banner_id"]]["views"] = $_tmp["counter"];
            }
            $_reader = $this->bannereventsStorage->GetDetailedStats($data, BANNER_EVENT_CLICK);
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $__tmp[$_tmp["banner_id"]]["clicks"] = $_tmp["counter"];
            }

            if(!empty($__tmp)){
                $this->XmlTag = "banner";
                foreach($__tmp as $banner => $stats){
                    $this->data = array("caption" => $stats["caption"], "views" => $stats["views"], "clicks" => $stats["clicks"]);
                    RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
                }
            }
           // echo pr($__tmp);
        }// function

} // class

?>