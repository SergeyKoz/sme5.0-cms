<?php
 $this->ImportClass("project", "ProjectPage");
 $this->ImportClass("web.controls.pollpagecontrol", "PollPageControl");

 /** Polls page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   * class for poll page, page include block poll and list of polls
   **/
    class PollPage extends ProjectPage  {

        var $ClassName="PollPage";
        var $Version="2.0";
        var $moder_page = false;
        var $id=50;
  /** Method creates child controls
   * @access public
   **/
   function CreateChildControls(){
      parent::CreateChildControls();
      $this->AddControl(new PollPageControl("poll_page", "poll_page"));
   }

   function XmlControlOnRender(&$xmlWriter)  {
       parent::XmlControlOnRender(&$xmlWriter);
   }

}
?>