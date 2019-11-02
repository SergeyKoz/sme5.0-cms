<?php

  KErnel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**  Cover controll class for main page
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class FotoContestsControl extends XMLControl {

    var $ClassName = "FotoContestsControl";
    var $Version = "2.0";


   /**
   *  Method Draws XML-content of a contest group
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @param array  $group  Array with group content
   *  @param   string   $tag_name    XML tag name
   *  @access private
   **/

   function DrawContestGroup(&$xmlWriter, $group, $tag_name){
       if(is_array($group) && !empty($group)){
           $this->XmlTag = "data";
           $xmlWriter->WriteStartElement($tag_name);
            foreach($group as $element){
                $this->data = $element;
                RecordControl::StaticXmlControlOnRender(&$this, $xmlWriter);
            }
            $xmlWriter->WriteEndElement($tag_name);
        }

   }

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {
        DataFactory::GetStorage($this, "FotoContestsTable", "fotocontestsStorage");
        $_contests = $this->fotocontestsStorage->GetValidContests();
        $this->DrawContestGroup($xmlWriter, $_contests["agenda"], "agenda");
        $this->DrawContestGroup($xmlWriter, $_contests["now"], "now");
        $this->DrawContestGroup($xmlWriter, $_contests["history"], "history");
   }

 }// class
?>
