<?php
 $this->ImportClass("project", "ProjectPage");
 $this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
 $this->ImportClass("web.controls.feedbackformcontrol", "FeedbackFormControl");
 /** Basic Frontend  page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @modified  Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Frameworik
   * @subpackage pages
   * @access public
   **/
    class FeedbackPage extends ProjectPage  {

        var $ClassName="FeedbackPage";
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
        $this->AddControl(new FeedbackFormControl("feedback_form", "feedback_form"));
   }


  /**
    *  Method draws xml-content of page
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    **/
   function XmlControlOnRender(&$xmlWriter) {
       //render page node
        parent::XmlControlOnRender(&$xmlWriter);
   }



}
?>