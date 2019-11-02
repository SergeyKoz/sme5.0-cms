<?php
$this->ImportClass("module.web.modulepage", 'ModulePage');
$this->ImportClass("module.web.controls.cmscontrolsprovider", "CmsControlsProvider");

/** Content management system  page class (frontend)
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  Framework
 * @subpackage classes.module.web
 * @access public
 **/
class CmsPage extends ModulePage {
    var $ClassName = "CmsPage";
    var $Version = "1.0";
    var $id = 0;
    var $formData = array();

    /**
     * Page mode variable (enum (Backend,Frontend)), default - Backend
     * @var string    $PageMode
     **/
    var $PageMode = "Frontend";

    /** Method creates child controls
     * @access public
     */
    function CreateChildControls(){
        parent::CreateChildControls();

        if (class_exists("ControlsProvider"))
            ControlsProvider::AddControls($this);
        else
            CMSControlsProvider::AddControls($this);
    }

    /**
     *  Method draws xml-content of page
     *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
     *  @access  public
     **/
    function XmlControlOnRender(&$xmlWriter)
    {
        if (DataDispatcher::isExists("point_type")) {
            $this->PageType = DataDispatcher::Get("point_type");
        }
        parent::XmlControlOnRender($xmlWriter);
    }

    function appendPageTitle($caption) {
        $tmp = DataDispatcher::Get("PATHES");
        $tmp[] = array(
            "title" => $caption,
            "url" => "",
            "type" => ""
        );
        DataDispatcher::Set("PATHES", $tmp);

        $tmp = (array) DataDispatcher::Get("page_titles");
        $tmp[] = $caption;

        DataDispatcher::Set("page_titles", $tmp);
    }


}
?>