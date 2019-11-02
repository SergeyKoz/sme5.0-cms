<?php

  KErnel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**  Cover controll class for main page
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class SelectedFotoControl extends XMLControl {

    var $ClassName = "SelectedFotoControl";
    var $Version = "2.0";

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {
            DataFactory::GetStorage($this, "FotosTable", "fotoStorage");
            if($this->Page->Kernel->Package->Settings->HasItem("FOTOSETTINGS", "INTERVAL_SETTING_ID")){
                $fotosetting_id = $this->Page->Package->GetItem("FOTOSETTINGS", "INTERVAL_SETTING_ID");
            } else {
                $fotosetting_id = 0;
            }

            if($fotosetting_id > 0){
                $interval = $this->Page->GetSetting($fotosetting_id);
            } else {
                $interval = 60;
            }

            $foto = $this->fotoStorage->GetNewFoto($interval);
            if(!empty($foto)){
               $this->data = DataManipulator::StripLanguageVersions($foto, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
               $this->XmlTag = "data";
               //prn($this->data);
               RecordControl::StaticXmlControlOnRender(&$this, $xmlWriter);
            }
   }

 }// class
?>