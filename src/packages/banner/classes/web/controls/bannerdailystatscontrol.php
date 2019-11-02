<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");

    /** Banners Daily Statistics control control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class BannerDailyStatsControl extends XmlControl {
        var $ClassName = "BannerDailyStatsControl";
        var $Version = "1.0";

        /**
        * Method executes on control load
        * @access	public
        **/
        function ControlOnLoad(){
            DataFactory::GetStorage($this, "BannerEventsTable", "bannereventsStorage", true, "banner");
        }


        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
            $month = $this->Page->Request->ToString("month_id", date("Y-m"));
            list($__year, $__month) = explode("-", $month);
            $days = date("t", mktime(0,0,0,$__month,1,$__year));

            $data["month_id"] = $month;
            $data["banner_id"] = $this->Page->Request->ToNumber("banner_id", 0);
            $data["page_id"] = $this->Page->Request->ToNumber("page_id", 0);
            $data["place_id"] = $this->Page->Request->ToNumber("place_id", 0);

            for($i=1; $i<=$days; $i++){
                $day = ($i<10 ? 0:"").$i;
                $__tmp[$day]["clicks"] = 0;
                $__tmp[$day]["views"] = 0;
            }

            $_reader = $this->bannereventsStorage->GetDailyStats($data, BANNER_EVENT_VIEW);
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $__tmp[$_tmp["_day"]]["views"] = $_tmp["counter"];
            }
            $_reader = $this->bannereventsStorage->GetDailyStats($data, BANNER_EVENT_CLICK);
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $__tmp[$_tmp["_day"]]["clicks"] = $_tmp["counter"];
            }

            if(!empty($__tmp)){
                $this->XmlTag = "day";
                foreach($__tmp as $day => $stats){
                    $this->data = array("day" => $day, "views" => $stats["views"], "clicks" => $stats["clicks"]);
                    RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
                }
            }
           // echo pr($__tmp);
        }// function

} // class

?>