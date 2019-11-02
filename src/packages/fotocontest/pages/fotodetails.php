<?php
 $this->ImportClass("project", "ProjectPage");
 $this->ImportClass("web.controls.fotocontestscontrol", "FotoContestsControl", "fotocontest");
$this->ImportClass("web.controls.fotodetailscontrol", "FotoDetailsControl", "fotocontest"); 

 /** Polls page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   * class for poll page, page include block poll and list of polls
   **/
    class FotoDetailsPage extends ProjectPage  {

        var $ClassName="FotoDetailsPage";
        var $Version="2.0";
        var $moder_page = false;

  /** Method creates child controls
   * @access public
   **/
   function CreateChildControls(){
      parent::CreateChildControls();
      $this->AddControl(new FotoContestsControl("fotocontests", "fotocontests"));
      $this->AddControl(new FotoDetailsControl("fotodetails", "fotodetails"));
   }

   function XmlControlOnRender(&$xmlWriter)  {
       parent::XmlControlOnRender(&$xmlWriter);
   }

}
?>