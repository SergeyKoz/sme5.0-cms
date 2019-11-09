<?php

  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**  Cover controll class for main page
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class AuthIndicatorControl extends XMLControl {

    var $ClassName = "AuthIndicatorControl";
    var $Version = "2.0";
   /**
    * Method executes on page load
    * @access public
   **/
    var $data = array();

   function ControlOnLoad(){
   }

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {
       $xmlWriter->WriteElementString("name", $this->Page->Auth->userData["name"]);
   } //function

 }// class
?>