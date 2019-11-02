<?php
 Kernel::ImportClass("project", "ProjectPage");
 Kernel::ImportClass("web.controls.searchcontrol", "SearchControl");


  /** Polls page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   **/
   class SearchPage extends ProjectPage  {

        var $ClassName="SearchPage";
        var $Version="2.0";
        var $moder_page = false;

  /** Method creates child controls
      * @access public
      */
   function CreateChildControls(){
        parent::CreateChildControls();
        $this->AddControl(new SearchControl("search", "search"));
   }

}
?>