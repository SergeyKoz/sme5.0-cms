<?php
 $this->ImportClass("module.web.modulepage", "ModulePage");
 $this->ImportClass("web.controls.testconstructor", "TestConstructor");
 $this->ImportClass("web.controls.testhelper", "TestHelper");
 $this->Import("system.mail.emailtemplate");
 $this->Import("system.web.controls.recordcontrol");


 /** Mailing page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Diagnostic
   * @access public
   **/
    class NotifierPage extends ModulePage  {

        var $ClassName="NotifierPage";
        var $Version="2.0";
        var $PageMode="Frontend";

  /** Method creates child controls
   * @access public
   **/
   function CreateChildControls(){
        parent::CreateChildControls();
        DataFactory::GetStorage($this, "SitesTable", "sitesStorage", false);
        DataFactory::GetStorage($this, "TestsTable", "testsStorage", false);
        DataFactory::GetStorage($this, "SiteEmailsTable", "emailStorage", false);
        set_time_limit(0);
        $this->emails = $this->emailStorage->GetEmails();
        //echo pr($this->emails);

        $renderer = $this->GetRenderer();
        //$__xmlWriter = new XmlWriter($this->Kernel->TemplateDirs,$this->Kernel->Language, $renderer, $this->Kernel->TemplateExt);
        $this->DrawTests();
        $this->DrawXML();
        $this->SendEmails();
        $this->XmlTag = "content";
   }

   /**
   * Method draws frame xml content
   * @param     XMLWriter   $xmlWriter  Writer object
   * @return    string      XML Frame
   * @access    public
   **/
   function ConstructMailFrame(){
         $xmlWriter = new XmlWriter($this->Kernel->TemplateDirs,$this->Kernel->Language, $renderer, $this->Kernel->TemplateExt);
          $xmlWriter->WriteStartDocument();
              $xmlWriter->WriteStartElement("page");
                  $xmlWriter->WriteStartElement("content");
                       $xmlWriter->WriteString("__%%CONTENT%%__");
                       $this->RenderLocalization($xmlWriter);
                  $xmlWriter->WriteEndElement();
              $xmlWriter->WriteEndElement();
          $xmlWriter->WriteEndDocument();
          return $xmlWriter->Stream;
   }

    /**
    * Method sends emails
    * @access   public
    **/
    function SendEmails(){
        $xmlWriter = new XmlWriter($this->Kernel->TemplateDirs,$this->Kernel->Language, $renderer, $this->Kernel->TemplateExt);
        $xmlWriter->getXSLT("emails.sites_notify",&$this->Page->Kernel->Debug);
        $_tpl = $this->ConstructMailFrame();
        $subject = $this->Page->Kernel->Package->Settings->GetItem("EMAIL", "EMAIL_NOTIFY_SUBJECT");
        if(!empty($this->chunks)){
            foreach($this->chunks as $email => $sites){
                $content = $this->_tests_xml.implode("", $sites);
                $xmlWriter->Stream = str_replace("__%%CONTENT%%__", $content, $_tpl);
                //echo pr($xmlWriter->Stream);

                $html = $xmlWriter->ProcessXSLT();
                $emailSender    =& new EmailTemplate(null, $email, "windows-1251", "text/html");
                $res = $emailSender->sendEmail($email, $subject, $html);
            }
        }
    }

   /**
   * Method draws XML content of tests
   * @param     XMLWriter       $xmlWriter      Writer object
   * @access    public
   ***/
   function DrawTests(){
       $_tests = $this->testsStorage->GetList(array("active" => 1, "site_id" => $sites));
        $xmlWriter = new XmlWriter($this->Kernel->TemplateDirs,$this->Kernel->Language, $renderer, $this->Kernel->TemplateExt);
        $xmlWriter->WriteStartElement("tests");
        for($i=0; $i<$_tests->RecordCount; $i++){
            $_tmp = $_tests->Read();
            $this->_tests_info[$_tmp["test_id"]] = $_tmp;
            $this->data = $_tmp;
            $this->XmlTag="test";

                RecordControl::StaticXMLControlOnRender(&$this, &$xmlWriter);

        }
        $xmlWriter->WriteEndElement("tests");
        $this->_tests_xml = $xmlWriter->Stream;
   }

   /**
   * Method draws XML content of a page
   * @param     XMLWriter       $xmlWriter      Writer object
   * @access    public
   ***/
   function DrawXML(){
       //return;


        $_reader = $this->sitesStorage->GetList(array("site_id" => $sites, "active" => 1), array("caption" => 1));
        //$constructor_url = $this->GetSetting(1);
        for($i=0; $i<$_reader->RecordCount; $i++){
            $xmlWriter = new XmlWriter($this->Kernel->TemplateDirs,$this->Kernel->Language, $renderer, $this->Kernel->TemplateExt);
            $_tmp = $_reader->Read();
            //echo pr($_tmp);
            $xmlWriter->WriteStartElement("site");
               $xmlWriter->WriteStartElement("data");
                    $xmlWriter->WriteElementString("caption", $_tmp["caption"]);
                    $xmlWriter->WriteElementString("url", $_tmp["url"]);
                    $xmlWriter->WriteElementString("tester", $_tmp["tester_url"]);
               $xmlWriter->WriteEndElement("data");



               $_resp = TestHelper::GetResponse($_tmp["tester_url"], "", $_tmp["site_id"], $_tmp["site_password"], $_tmp["transport_method"], true);
               //echo pr($this->GetResponse($_tmp["tester_url"], $_tmp["site_id"]));
               $xmlWriter->WriteStartElement("tests");
                   list($code, $has_errors) = TestHelper::DrawResponse($xmlWriter, $_resp, $this->_tests_info);
                   //echo pr($has_errors);
               $xmlWriter->WriteEndElement("tests");

               if($code !== 0){
                   $this->data = $code;
                   $this->XmlTag="result";
                   RecordControl::StaticXMLControlOnRender(&$this, &$xmlWriter);
               }

            $xmlWriter->WriteEndElement("site");
            //$sizeof = sizeof($this->emails[$_tmp["site_id"]]);
            if(!empty($this->emails[$_tmp["site_id"]])){
                foreach($this->emails[$_tmp["site_id"]] as $email => $data){

                    if($has_errors || ($data["errors_only"]==0)){
                        $this->chunks[$email][] = $xmlWriter->Stream;
                    }
                }
            }

        }
        //echo pr($this->chunks);
   }

   /**
   * Method draws XML content of a page
   * @param     XMLWriter       $xmlWriter      Writer object
   * @access    public
   ***/
   function XMLControlOnRender(&$xmlWriter){
       die();
   }




}
?>