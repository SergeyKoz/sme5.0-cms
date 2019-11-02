<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");
$this->ImportClass("system.web.controls.dbcombobox", "DbComboBoxControl");
$this->ImportClass("system.web.controls.dbtreecombobox", "DbTreeComboBoxControl");
    /** Banners filter control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class BannersFilterControl extends XmlControl {
        var $ClassName = "BannersFilterControl";
        var $Version = "1.0";

        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            $this->AddControl(new DbComboBoxControl("banners", "banners"));
            $this->AddControl(new DbTreeComboBoxControl("pages", "pages"));
            $this->AddControl(new DbComboBoxControl("places", "places"));
            $this->AddControl(new DbComboBoxControl("month", "month"));
            
            
            $this->Controls["banners"]->InitControl(array(
                                    "name" => "banner_id",
                                    "selected_value" => $this->Page->Request->ToNumber("banner_id", 0),
                                    "table" => "BannersTable",
                                    "caption_field" => "banner_title",
                                    "caption" => "",
                                    "use_root_caption" => 1,
                                    "library" => "BannerStatsPage"
            ));
            
            $this->Controls["pages"]->InitControl(array(
                                    "name" => "page_id",
                                    "selected_value" => $this->Page->Request->ToNumber("page_id", 0),
                                    "parent" => "parent_id",
                                    "table" => "StructureTable",
                                    "caption_field" => "page_title_".$this->Page->Kernel->Language,
                                    "caption" => "",
                                    "use_root_caption" => 1,
                                    "library" => "BannerStatsPage"
            ));
            
            $this->Controls["places"]->InitControl(array(
                                    "name" => "place_id",
                                    "selected_value" => $this->Page->Request->ToNumber("place_id", 0),
                                    "table" => "BannerPlacesTable",
                                    "caption_field" => "place_title",
                                    "caption" => "",
                                    "use_root_caption" => 1,
                                    "library" => "BannerStatsPage"
            ));

            $this->Controls["month"]->InitControl(array(
                                    "name" => "month_id",
                                    "selected_value" => $this->Page->Request->ToString("month_id", date("Y-m")),
                                    "table" => "BannerEventsTable",
                                    "caption_field" => "month",
                                    "caption" => "",
                                    "use_root_caption" => 0,
                                    "library" => "BannerStatsPage",
                                    "method" => "GetMonthList",
                                    "onchange" => "changeMonth();"
            ));
            

            
        }
        /**
        * Method handles Default page event
        * @access public
        **/
        function OnDetailed(){
            $this->AddControl(new DbComboBoxControl("days", "days"));                       
            $this->Controls["days"]->InitControl(array(
                                    "name" => "day",
                                    "selected_value" => $this->Page->Request->ToString("day", date("d")),
                                    "table" => "BannerEventsTable",
                                    "caption_field" => "month",
                                    "caption" => "",
                                    "use_root_caption" => 0,
                                    "library" => "BannerStatsPage",
                                    "method" => "GetDaysList",
                                    "query_data" => array("month" => $this->Page->Request->ToString("month_id", date("Y-m")))
            ));
        }        


        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
            $xmlWriter->WriteElementString("banner_id", $this->Page->Request->ToNumber("banner_id", 0));
            $xmlWriter->WriteElementString("page_id", $this->Page->Request->ToNumber("page_id", 0));
            $xmlWriter->WriteElementString("place_id", $this->Page->Request->ToNumber("place_id", 0));
            $xmlWriter->WriteElementString("month_id", $this->Page->Request->ToString("month_id", date("Y-m")));
            $xmlWriter->WriteElementString("day", $this->Page->Request->ToString("day", "01"));            
            $xmlWriter->WriteElementString("event", ($this->Page->Event=="Default" ? "daily":$this->Page->Event));
            
            
        }// function

} // class

?>