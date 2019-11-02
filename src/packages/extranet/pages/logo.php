<?php
 $this->ImportClass("web.frame", "FramePage");

 /** Extranet Logo Page class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package  Extranet
     * @subpackage pages
     * @access public
     */
 class LogoPage extends FramePage
 {
        var $ClassName = "LogoPage";
        var $Version = "1.0";

       /**
         *  Method builds rows of a list
         * @param  XMLWriter   $xmlWriter  instance of XMLWriter
         * @access private
         **/
        function XmlControlOnRender(&$xmlWriter){
            $this->Kernel->setVariable("ShowDebug",false);
            FramePage::XmlControlOnRender($xmlWriter);
        }
// class
 }

?>