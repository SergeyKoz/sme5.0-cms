<?php

  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class ContestDetailsControl extends XMLControl {

    var $ClassName = "ContestDetailsControl";
    var $Version = "2.0";




    /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {
       DataFactory::GetStorage($this, "FotoContestsTable", "contestStorage");
       DataFactory::GetStorage($this, "FotosTable", "fotoStorage");


       $contest_id = $this->Page->Request->ToNumber("contest_id", 0);
       $sort_order = $this->Page->Request->ToNumber("sort", 0, 0, 1);
       $foto_id = $this->Page->Request->ToNumber("foto_id", 0);

       $_contest = $this->contestStorage->Get(array("contest_id" => $contest_id));

       $_contest["starts_from"] = Component::dateconv($_contest["starts_from"]);
       $_contest["ends_to"] = Component::dateconv($_contest["ends_to"]);

       $xmlWriter->WriteElementString("votes_enabled", ($_contest["disable_voting"] == 1 ? "0": "1"));
       $xmlWriter->WriteElementString("contest_finished", $_contest["contest_finished"]);

       $this->XmlTag = "contest";
       $this->data = DataManipulator::StripLanguageVersions($_contest, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
       RecordControl::StaticXmlControlOnRender(&$this, $xmlWriter);


       if(!empty($_contest)){

                $xmlWriter->WriteStartElement("result_list");
                //prn("+++".$_contest["show_results_count"]);
                $_reader = $this->fotoStorage->GetList(array("contest_id" => $contest_id, "active" => 1),
                                                       array("votes_count" => 0),
                                                       $_contest["show_results_count"], 0
                                                       );

                $this->XmlTag = "row";
                for($i=0; $i<$_reader->RecordCount; $i++){
                    $_tmp = DataManipulator::StripLanguageVersions($_reader->Read(), $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
                    $_tmp["date_posted"] = Component::dateconv($_tmp["date_posted"]);
                    $this->data =  $_tmp;
                    RecordControl::StaticXmlControlOnRender(&$this, $xmlWriter);
                }


                $xmlWriter->WriteEndElement("result_list");


       }

   }


 }// class
?>