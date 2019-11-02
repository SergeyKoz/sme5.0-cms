<?php
  $this->ImportClass("module.web.modulepage", 'ModulePage');
  /**
   * Frontend static page
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.module.web
   * @access public
   **/
  class StaticPage extends ModulePage {
    // Class name
    var $ClassName = "StaticPage";
    // Class version
    var $Version = "1.0";

    /**
      * Page mode variable
      * @var string    $PageMode
      **/
    var $PageMode="Frontend";

    /**
      * OnLoad event handler
      * @access public
      **/
    function ControlOnLoad()    {
      //--get template from global variables
      $template=$this->Kernel->getVariable("_template");
      if (strlen($template)!=0) $this->XslTemplate=$template;
    }

    /**
      * Method render page localization nodes
      * @param  xmlWriter    $xmlWriter    xmlWriter object
      * @access private
      **/
    function RenderPageLocalization(&$xmlWriter)  {
     //write page localization settings
        if ($this->Kernel->Localization->HasSection($this->XslTemplate."Page")) {
         $_curPageSection=$this->Kernel->Localization->GetSection($this->XslTemplate."Page");
        //write page localization settings
          if (($_curPageSection !== false) && sizeof($_curPageSection)) {
          foreach($_curPageSection as $_messageName=>$_messageVal)
                      if (strlen(trim($_messageName))!=0) {
                            $xmlWriter->WriteElementString($_messageName,$_messageVal);
                        }
        }
       }
    }

//end of class
}
?>