<?php
 $this->ImportClass("module.web.modulepage", "ModulePage");
 $this->ImportClass("web.controls.testconstructor", "TestConstructor");
 $this->ImportClass("web.controls.testhelper", "TestHelper");
 $this->Import("system.web.controls.recordcontrol");


 /** Mailing page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Diagnostic
   * @access public
   **/
    class StatusPage extends ModulePage  {

        var $ClassName="StatusPage";
        var $Version="2.0";
        var $PageMode="Backend";

  /** Method creates child controls
   * @access public
   **/
   function CreateChildControls(){
        parent::CreateChildControls();
        DataFactory::GetStorage($this, "SitesTable", "sitesStorage", false);
        DataFactory::GetStorage($this, "TestsTable", "testsStorage", false);
        set_time_limit(0);

   }


   /**
   * Method draws XML content of a page
   * @param     XMLWriter       $xmlWriter      Writer object
   * @access    public
   ***/
   function XMLControlOnRender(&$xmlWriter){
        $sites = $this->Request->Value("id");
        if(empty($sites)){
            $sites = null;
        }
        $_tests = $this->testsStorage->GetList(array("active" => 1, "site_id" => $sites));

        $xmlWriter->WriteStartElement("tests");
        for($i=0; $i<$_tests->RecordCount; $i++){
            $_tmp = $_tests->Read();
            $_tests_info[$_tmp["test_id"]] = $_tmp;
            $this->data = $_tmp;
            $this->XmlTag="test";

                RecordControl::StaticXMLControlOnRender(&$this, &$xmlWriter);

        }
        $xmlWriter->WriteEndElement("tests");

        $_reader = $this->sitesStorage->GetList(array("site_id" => $sites, "active" => 1), array("caption" => 1));
        //$constructor_url = $this->GetSetting(1);
        for($i=0; $i<$_reader->RecordCount; $i++){
            $_tmp = $_reader->Read();
            //echo pr($_tmp);
            $xmlWriter->WriteStartElement("site");
               $xmlWriter->WriteStartElement("data");
                    $xmlWriter->WriteElementString("caption", $_tmp["caption"]);
                    $xmlWriter->WriteElementString("url", $_tmp["url"]);
                    $xmlWriter->WriteElementString("tester", $_tmp["tester_url"]);
               $xmlWriter->WriteEndElement("data");



               $_resp = TestHelper::GetResponse($_tmp["tester_url"], "", $_tmp["site_id"], $_tmp["site_password"], $_tmp["transport_method"]);
               //echo pr($this->GetResponse($_tmp["tester_url"], $_tmp["site_id"]));
               $xmlWriter->WriteStartElement("tests");
                   list($code, $has_errors) = TestHelper::DrawResponse($xmlWriter, $_resp, $_tests_info);
               $xmlWriter->WriteEndElement("tests");

               if($code !== 0){
                   $this->data = $code;
                   $this->XmlTag="result";
                   RecordControl::StaticXMLControlOnRender(&$this, &$xmlWriter);
               }

            $xmlWriter->WriteEndElement("site");
        }
   }




}
?>