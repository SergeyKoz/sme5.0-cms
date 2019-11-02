<?php
 $this->ImportClass("project", "ProjectPage");
 $this->ImportClass("web.controls.sitemapcontrol", "SitemapControl");

 /** Project map (site map) page
   * @author  Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Frameworik
   * @subpackage pages
   * @access public
   **/
    class SiteMapPage extends ProjectPage  {

        var $ClassName="SiteMapPage";
        var $Version="1.0";
        var $id = 0;
        /**
          * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
          * @var string    $PageMode
          **/
        var $PageMode = "Frontend";

        //var $XslTemplate =  "project_sitemap";

	/** Method creates child controls
   * @access public
   */
   function CreateChildControls(){
        parent::CreateChildControls();
        $this->AddControl(new SitemapControl("cms_sitemap", "cms_sitemap"));
   }

}
?>