<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");

    /** Banners General Statistics control control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class BannerGeneralStatsControl extends XmlControl {
        var $ClassName = "BannerGeneralStatsControl";
        var $Version = "1.0";

        /**
        * Method executes on control load
        * @access   public
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
            $now = time();
            $this->data = array();
            $this->data["today"] = $this->bannereventsStorage->GetDaysStats($now, $now);
            $this->data["yesterday"] = $this->bannereventsStorage->GetDaysStats($now-86400, $now-86400);
            $this->data["month"] = $this->bannereventsStorage->GetDaysStats(mktime(0,0,0,date("n")-1,date("d"),date("Y")), $now);
            $this->XmlTag="views";
            RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);

            $this->data = array();
            $this->data["today"] = $this->bannereventsStorage->GetDaysStats($now, $now, BANNER_EVENT_CLICK);
            $this->data["yesterday"] = $this->bannereventsStorage->GetDaysStats($now-86400, $now-86400, BANNER_EVENT_CLICK);
            $this->data["month"] = $this->bannereventsStorage->GetDaysStats(mktime(0,0,0,date("n")-1,date("d"),date("Y")), $now, BANNER_EVENT_CLICK);
            $this->XmlTag="clicks";
            RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);

            $this->data = array();
            $this->XmlTag="date";
            $this->data["today"]=date("d", $now);
            $this->data["yesterday"]=date("d", $now-86400);
            $this->data["today_month"]=date("Y-m", $now);
            $this->data["yesterday_month"]=date("Y-m", $now-86400);
            RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
        }// function

} // class

?>