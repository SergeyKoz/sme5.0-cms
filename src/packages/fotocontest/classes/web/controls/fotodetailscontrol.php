<?php

  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class FotoDetailsControl extends XMLControl {

    var $ClassName = "FotoDetailsControl";
    var $Version = "2.0";



    function OnFotoVote(){
       $contest_id = $this->Page->Request->ToNumber("contest_id", 0);
       $sort_order = $this->Page->Request->ToNumber("sort", 0, 0, 1);
       $foto_id = $this->Page->Request->ToNumber("foto_id", 0);

       if(isset($_COOKIE["f".$foto_id])){
           $this->Page->Response->Redirect("?contest_id=".$contest_id."&foto_id=".$foto_id."&sort=".$sort_order."&MESSAGE[]=ALREADY_VOTED");
       } else {
           setcookie("f".$foto_id, 1, time()+3600);
           DataFactory::GetStorage($this, "FotosTable", "fotoStorage");
           DataFactory::GetStorage($this, "FotoContestsTable", "contestStorage");
           $this->fotoStorage->UpdateCounter($foto_id, "votes_count", 1);
           $this->contestStorage->UpdateCounter($contest_id, "total_voted", 1);

           $this->Page->Response->Redirect("?contest_id=".$contest_id."&foto_id=".$foto_id."&sort=".$sort_order."&MESSAGE[]=VOTE_OK");

       }
    }


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

       $__tmp_contest = $this->contestStorage->Get(array("contest_id" => $contest_id));
       $xmlWriter->WriteElementString("votes_enabled", ($__tmp_contest["disable_voting"] == 1 ? "0": "1"));
       $xmlWriter->WriteElementString("contest_finished", $__tmp_contest["contest_finished"]);

       if($sort_order == 0){
            $sort_array = array("date_posted" => 0);
       } else {
            $sort_array = array("votes_count" => 0);
       }

       $_reader = $this->fotoStorage->GetList(array("contest_id" => $contest_id,

                                              "active" => 1
                                                ),
                                               $sort_array
                                                );

       $_prev = 0;
       $_next = 0;
       for($i=0; $i< $_reader->RecordCount; $i++){
           $_tmp = $_reader->Read();

           if($_tmp["foto_id"] == $foto_id){
                $_tmp["date_posted"] = Component::dateconv($_tmp["date_posted"]);
                $this->data = DataManipulator::StripLanguageVersions($_tmp, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
                $this->XmlTag = "foto";
                RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);
                $_tmp = $_reader->Read();
                $_next = $_tmp["foto_id"];
                break;
           }
           $_prev = $_tmp["foto_id"];
       }

       if($_prev != 0){
            $_prev_foto = $this->fotoStorage->Get(array("contest_id" => $contest_id,
                                              "foto_id" => $_prev,
                                              "active" => 1
                                                ));
                $this->data = DataManipulator::StripLanguageVersions($_prev_foto, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
                $this->XmlTag = "prev";
                RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);

       }
       if($_next != 0){
            $_next_foto = $this->fotoStorage->Get(array("contest_id" => $contest_id,
                                              "foto_id" => $_next,
                                              "active" => 1
                                                ));
                $this->data = DataManipulator::StripLanguageVersions($_next_foto, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
                $this->XmlTag = "next";
                RecordControl::StaticXmlControlOnRender(&$this, &$xmlWriter);

       }


       $xmlWriter->WriteElementString("sort_order", $sort_order);
       $xmlWriter->WriteElementString("contest_id", $contest_id);
       $xmlWriter->WriteElementString("prev_foto", $_prev);
       $xmlWriter->WriteElementString("next_foto", $_next);

   }


 }// class
?>