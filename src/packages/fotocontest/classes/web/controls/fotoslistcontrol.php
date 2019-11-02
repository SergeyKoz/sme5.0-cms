<?php

  KErnel::ImportClass("system.web.xmlcontrol", "XMLControl");
  /**  Cover controll class for main page
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package Polls
   * @access public
   * class for poll controll attached to page
   **/
  class FotosListControl extends XMLControl {

    var $ClassName = "FotosListControl";
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
       if($contest_id == 0){
          $__tmp_contest = $this->contestStorage->Get(array("is_default" => 1));
          $contest_id = $__tmp_contest["contest_id"];
       } else {
          $__tmp_contest = $this->contestStorage->Get(array("contest_id" => $contest_id));
       }

       if($__tmp_contest["disable_voting"] == 1){
         $sort_order = 0;
         $enabled_sorting = 0;
       }  else {
         $sort_order = $this->Page->Request->ToNumber("sort", 0, 0, 1);
         $enabled_sorting = 1;
       }

       $xmlWriter->WriteElementString("sort_enabled", $enabled_sorting);
       $xmlWriter->WriteElementString("sort_order", $sort_order);
       $xmlWriter->WriteElementString("contest_id", $contest_id);

       $total = $this->fotoStorage->GetCount(array("contest_id" => $contest_id));

       $this->_RPP = $__tmp_contest["rpp"] or 10;
       $this->_PPD = $__tmp_contest["ppd"] or 10;

       $this->_START = $this->Page->Request->ToNumber("start", 0);

       $this->_TOTAL = $total;

       if($this->_START*$this->_RPP >= $this->_TOTAL)  {
          $this->_START = ceil($this->_TOTAL/$this->_RPP)-1;
       }
       if($this->_START<0)$this->_START=0;

       if($sort_order == 0){
            $sort_array = array("date_posted" => 0);
       } else {
            $sort_array = array("votes_count" => 0);
       }

       $_list = $this->fotoStorage->GetList(array("contest_id" => $contest_id, "active" => 1),
                                            $sort_array,
                                            $this->_RPP, $this->_RPP*$this->_START);

       $xmlWriter->WriteStartElement("list");
       $this->XmlTag="row";
       for($i=0; $i<$_list->RecordCount; $i++){
            $_tmp = $_list->Read();
            $_tmp["date_posted"] = Component::dateconv( $_tmp["date_posted"]);
            $this->data = DataManipulator::StripLanguageVersions($_tmp, $this->Page->Kernel->Languages, $this->Page->Kernel->Language);
            RecordControl::StaticXmlControlOnRender(&$this, $xmlWriter);

       }
       $xmlWriter->WriteEndElement("list");


       $this->AddControl(new NavigationControl("navigator","navigator"));
       $this->Controls["navigator"]->SetData(array(
                        "prefix" => "",
                        "start"=>$this->_START,
                        "total"=>$this->_TOTAL,
                        "ppd"  =>$this->_PPD,
                        "rpp"  =>$this->_RPP,
                        "url"  =>"?contest_id=" .$contest_id.($sort_order != 0 ? "&amp;sort=".$sort_order : ""),
                        "order_by" =>  ""
                        ));


   }


 }// class
?>