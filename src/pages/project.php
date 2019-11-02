<?php
 $this->ImportClass("module.web.cmspage", 'CmsPage');
 $this->ImportClass("web.controls.controlsprovider", "ControlsProvider");

 /** Basic Frontend  page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @modified  Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage pages
   * @access public
   **/
    class ProjectPage extends CmsPage  {

        var $ClassName="ProjectPage";
        var $Version="1.0";
        var $id = 0;
     /**
          * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
          * @var string    $PageMode
          **/
        var $PageMode = "Frontend";


  /** Method creates child controls
      * @access public
      */
   function CreateChildControls(){
        parent::CreateChildControls();

   }


  /**
    *  Method draws xml-content of page
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    **/
   function XmlControlOnRender(&$xmlWriter) {
       //render page node
        parent::XmlControlOnRender($xmlWriter);
   }


}
?>