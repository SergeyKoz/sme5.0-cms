<?php
    $this->ImportClass("module.web.modulepage", "ModulePage");
    /**
     * Banners list page class.
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package System
     * @subpackage pages
     * @access public
     **/
    class BannerClickerPage extends ModulePage {
        // Class name
        var $ClassName = "BannerClickerPage";
        // Class version
        var $Version = "1.0";
        /**    Self page name
        * @var     string     $self
        */
   /**
     * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
     * @var string    $PageMode
     **/
    var $PageMode="Frontend";


    /**
      * Method executes on page load
      * @access public
      **/
        function ControlOnLoad()  {
            //parent::ControlOnLoad();
            DataFactory::GetStorage($this, "BannersTable", "bannersStorage");
            DataFactory::GetStorage($this, "BannerEventsTable", "bannereventsStorage");
            $banner_id = $this->Request->ToNumber("b_id",0);
            $page_id = $this->Request->ToNumber("p_id",0);
            $place_id = $this->Request->ToNumber("pl_id",0);
            $language = $this->Request->ToString("l");

            $banner = $this->bannersStorage->Get(array("banner_id" => $banner_id));
            if(!empty($banner)){
                 if($banner["banner_type"] != 0) {
                     $this->bannereventsStorage->LogEvent($banner_id, $page_id, $place_id, BANNER_EVENT_CLICK, $language);
                     $this->Response->Redirect($banner["banner_url"]);

                 }

            } else {
                      $this->Response->Redirect($this->Kernel->Settings->GetItem("AUTHORIZATION", "Frontend_HREF_Default_Redirect_project"));
            }

        }

}
?>