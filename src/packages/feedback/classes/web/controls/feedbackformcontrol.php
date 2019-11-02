<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");
$this->ImportClass("system.web.validate", "Validate");

/** Banners control class
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Banner
* @subpackage classes.web.controls
* @access public
*/
class FeedbackFormControl extends XmlControl {
    var $ClassName = "FeedbackFormControl";
    var $Version = "1.0";

    /**
    * Method executes on control load
    * @access   public
    **/
    function ControlOnLoad(){
        DataFactory::GetStorage($this, "FeedbackFormTable", "formStorage", true, "feedback");
        DataFactory::GetStorage($this, "DepartmentsTable", "departmentsStorage", true, "feedback");
        DataFactory::GetStorage($this, "SubjectsTable", "subjectsStorage", true, "feedback");
        $this->_fields = $this->GetFormFields();
        $this->_request_fields = $this->GetRequestFields();
        $this->_departments = $this->departmentsStorage->GetDepartmentSubjects();

    }

    /**
    * Method returns form fields
    * @return    array   Array with form fields
    * @access    public
    */

    function GetFormFields(){
        $_tmp = array(array("field_id" => 0,
                            "caption_".$this->Page->Kernel->Language => $this->Page->Kernel->Localization->GetItem("MAIN", "_caption_reply_to"),
                            "field_type" => "email",
                            "not_null" => 1

                            ));
        $_reader = $this->formStorage->GetList(array("active" => 1), array("_priority" => 1));
        for($i=0; $i<$_reader->RecordCount; $i++){
            $_tmp[] = $_reader->Read();
        }
        return $_tmp;
    }

    /**
    * Method draws departments and subjects nodes
    * @param    XMLWriter   $xmlWriter   Instance of XMLWriter
    * @access   public
    ***/
    function DrawDepartments(&$xmlWriter){
        //echo pr($this->_departments);
        $_selected_department = $this->Page->Request->ToNumber("department_id", 0);
        $_selected_subject = $this->Page->Request->ToNumber("subject_id", 0);
        $xmlWriter->WriteStartElement("departments");
            $size = sizeof($this->_departments);
            //echo pr($size);
            for($i=0; $i<$size; $i++){
                $xmlWriter->WriteStartElement("department");
                    $xmlWriter->WriteAttributeString("id", $this->_departments[$i]["department_id"]);
                    if($_selected_department == 0){
                        $_selected_department = $this->_departments[$i]["department_id"];
                    }
                    $xmlWriter->WriteAttributeString("selected", ($this->_departments[$i]["department_id"] == $_selected_department ? "1":"0"));
                    $xmlWriter->WriteElementString("caption", $this->_departments[$i]["caption_".$this->Page->Kernel->Language]);
                    $xmlWriter->WriteElementString("description", $this->_departments[$i]["description_".$this->Page->Kernel->Language]);
                    $_subjects = $this->subjectsStorage->GetDepartmentSubjects($this->_departments[$i]["department_id"]);
                    for($j=0; $j<$_subjects->RecordCount; $j++){
                        $_tmp = $_subjects->Read();
                        $xmlWriter->WriteStartElement("subject");
                            $xmlWriter->WriteAttributeString("id", $_tmp["subject_id"]);
                            $xmlWriter->WriteAttributeString("selected", ($_tmp["subject_id"] == $_selected_subject ? "1":"0"));

                            $xmlWriter->WriteElementString("caption", str_replace("'", "`", $_tmp["subject_".$this->Page->Kernel->Language]));
                        $xmlWriter->WriteEndElement("subject");
                    }
                $xmlWriter->WriteEndElement("department");
            }
        $xmlWriter->WriteEndElement("departments");
    }


    /**
    * Method draws field content
    * @param    XMLWriter   $xmlWriter   Instance of XMLWriter
    * @param    array       $_field      Array with field data
    *
    **/
    function DrawField($xmlWriter, $_field){
        $field_value = $this->_request_fields["field_".$_field["field_id"]];
        $xmlWriter->WriteStartElement("field");
            $xmlWriter->WriteAttributeString("id" , $_field["field_id"]);
            $xmlWriter->WriteAttributeString("name" , "field_".$_field["field_id"]);
            $xmlWriter->WriteAttributeString("type" , $_field["field_type"]);
            $xmlWriter->WriteAttributeString("not_null" , $_field["not_null"]);
            $xmlWriter->WriteAttributeString("error" , (isset($this->errors["field_".$_field["field_id"]]) ? "1": "0"));

        $xmlWriter->WriteElementString("caption", $_field["caption_".$this->Page->Kernel->Language]);
        $xmlWriter->WriteElementString("value", $field_value);
        $xmlWriter->WriteElementString("default_value",$_field["default_value_".$this->Page->Kernel->Language]);
        $xmlWriter->WriteEndElement("field");
    }


    /**
    *   Method executes if no event assigned
    *   @access public
    **/
    function OnDefault(){
        $this->default = true;
    }

    /**
    * Method gets all fields from request
    * @access public
    * @return array     Array with request data
    **/
    function GetRequestFields(){
        $size = sizeof($this->_fields);
        for($i=0; $i<$size; $i++){
            $_tmp["field_".$this->_fields[$i]["field_id"]] = $this->Page->Request->Value("field_".$this->_fields[$i]["field_id"]);
        }
        return $_tmp;
    }

    /**
    * Method validates request data
    * @param    array   Array with request data
    * @return   bool    Validation status
    * @access   public
    **/
    function ValidateFields(){
        $fields = $this->_request_fields;
        $size = sizeof($this->_fields);


        for($i=0; $i<$size; $i++){
            $type = "string";
            if($this->_fields[$i]["field_type"] == "email"){
                $type = "email";
            } else {
                $type = "string";
            }
            $_field_id = $this->_fields[$i]["field_id"];
            $allow_null = ($this->_fields[$i]["not_null"] ? 0:1);
            $_form_descr[] = array("name" => "field_".$_field_id, "dtype" => $type, "notnull"=> $this->_fields[$i]["not_null"], "length"=>$this->_fields[$i]["max_length"]);
            $this->Page->Kernel->Localization->SetItem("__FORM", "field_".$_field_id, $this->_fields[$i]["caption_".$this->Page->Kernel->Language], true);
        }
        //echo pr($this->Page->Kernel->Localization->Sections["__form"]);

        $validator = new Validate($this->Page, $_form_descr, "__FORM");
        $validator->ValidateForm($fields, true);

        return $validator->formerr_arr;
    }

    /**
    * Method returns selected department array
    * @return array     Array with selected department data
    * @access   public
    **/
    function GetSelectedDepartment(){
        $_selected_department_id = $this->Page->Request->ToNumber("department_id");
        if(!empty($this->_departments)){
            foreach($this->_departments as $department){
                if($department["department_id"] == $_selected_department_id){
                    return $department;
                }

            }
        }
        return array();
    }

    /**
    * Method returns formatted emails list
    * @param    string  $emails Raw emails string
    * @return   string  formatted emails list
    * @access   public
    **/
    function PrepareEmailsList($emails){
        $cleaned_emails_arr = array();
        $emails_arr = explode("\n", $emails);
        //echo pr($emails);
        if(!empty($emails_arr)){
            foreach($emails_arr as $email){
                $email = trim($email);
                if($email != ""){
                    $cleaned_emails_arr[] = $email;
                }
            }
        }
        return implode(", ", $cleaned_emails_arr);
    }

    /**
    * Method Returns template for feedback form
    * @param    array   Array with department data
    * @return
    *
    **/
    function RenderEmailTemplate(){
        $department = $this->GetSelectedDepartment();
        $this->selected_department = $department;
        //echo pr($this->selected_department);
        $subject = $this->subjectsStorage->Get(array("subject_id" => $this->Page->Request->ToNumber("subject_id"), "active" => 1));
        $this->selected_subject = $subject;
        //echo pr($this->Page->Kernel->TemplateDirs);
        $this->Page->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");

        //echo pr($department);
        if(!empty($department)){
            if($department["content_type"]==0){ // Plain text
                return $this->GetPlainEmail($department, $subject);
            } else { // HTML
                return $this->GetXMLEmail($department, $subject);
            }
        }
    }

    /**
    * Method Returns rendered Plain email body
    * @param    array   $department   Department data array
    * @param    array   $subject      Subject data array
    * @return   string  Rendered Email string
    * @access   public
    **/
    function GetPlainEmail($department, $subject){
                $xmlWriter = new SMEXmlWriter($this->Page->Kernel->TemplateDirs,$this->Page->Kernel->Language, $this->Page->getRenderer());
                $xmlWriter->getXSLT("emails.feedback_template_txt",&$this->Page->Kernel->Debug, $this->Page->Kernel->Language);
                $template = $xmlWriter->XSLT;
                //echo pr($template);
                $xmlWriter->getXSLT("emails.feedback_field",&$this->Page->Kernel->Debug, $this->Page->Kernel->Language);
                $field = $xmlWriter->XSLT;
                //echo pr($field);

                $emailSender    = new EmailTemplate();//null, $this->_request_fields["field_0"], $department["encoding"], ($department["content_type"]==0 ? "text/plain":"text/html"));
                $fields_str = "";
                $size = sizeof($this->_fields);
                for($i=1; $i<$size; $i++){
                    $data = array("CAPTION" => $this->_fields[$i]["caption_".$this->Page->Kernel->Language],
                                  "VALUE"   => $this->_request_fields["field_".$this->_fields[$i]["field_id"]]
                    );
                    $fields_str .= $emailSender->Render_Tag($field, $data, true);
                }
                $data = array("TO"  => $department["caption_".$this->Page->Kernel->Language],
                              "FROM" => $this->_request_fields["field_0"],
                              "SUBJECT" => $subject["subject_".$this->Page->Kernel->Language],
                              "DATE"    => date("d.m.Y H:i:s", time()),
                              "FIELDS" => $fields_str,
                              "SITE"   => $this->Page->Kernel->Settings->GetItem("MODULE", "Url")
                );
                return $emailSender->Render_Tag($template, $data, true);

    }


    /**
    * Method Returns rendered HTML email body
    * @param    array   $department   Department data array
    * @param    array   $subject      Subject data array
    * @return   string  Rendered Email string
    * @access   public
    **/
    function GetXMLEmail($department, $subject){
          $xmlWriter = new SMEXmlWriter($this->Page->Kernel->TemplateDirs,$this->Page->Kernel->Language, $this->Page->getRenderer());
          $xmlWriter->getXSLT("emails.feedback_template",&$this->Page->Kernel->Debug, $this->Page->Kernel->Language);
          $xmlWriter->WriteStartDocument();
              $xmlWriter->WriteStartElement("page");
                  $xmlWriter->WriteStartElement("content");
                       $xmlWriter->WriteElementString("department", $department["caption_".$this->Page->Kernel->Language]);
                       $xmlWriter->WriteElementString("from", $this->_request_fields["field_0"]);
                       $xmlWriter->WriteElementString("subject", $subject["subject_".$this->Page->Kernel->Language]);
                       $xmlWriter->WriteElementString("date", date("d.m.Y H:i:s", time()));
                       $xmlWriter->WriteElementString("site", $this->Page->Kernel->Settings->GetItem("MODULE", "Url"));
                       $xmlWriter->WriteElementString("charset", $department["encoding"]);
                       $xmlWriter->WriteStartElement("fields");
                            $size = sizeof($this->_fields);
                            for($i=1; $i<$size; $i++){
                                $xmlWriter->WriteStartElement("field");
                                    $xmlWriter->WriteElementString("caption", $this->_fields[$i]["caption_".$this->Page->Kernel->Language]);
                                    $xmlWriter->WriteElementString("value", $this->_request_fields["field_".$this->_fields[$i]["field_id"]]);
                                $xmlWriter->WriteEndElement();
                            }

                       $xmlWriter->WriteEndElement();
                  $xmlWriter->WriteEndElement();
              $xmlWriter->WriteEndElement();
          $xmlWriter->WriteEndDocument();
          return $xmlWriter->ProcessXSLT();

    }

    /**
    * Method handles feedback sending
    * @access   public
    **/
    function OnSendFeedback(){
        $this->errors = $this->ValidateFields();
        if(empty($this->errors)){
             $mail_body = $this->RenderEmailTemplate();
             if($this->selected_department["encoding"]=="koi8-r"){
                if($this->selected_department["content_type"]==1){// if html
                     $mail_body = str_replace("text/html; charset=windows-1251", "text/html; charset=koi8-r", $mail_body);
                }
                $mail_body = convert_cyr_string($mail_body, "w", "k");
             }
             $local_from = $this->_request_fields["field_0"] .
                " <" . $this->Page->Kernel->Settings->GetItem("EMAIL", "FROM") . ">";
             $emailSender    =new EmailTemplate(null, $local_from, $this->selected_department["encoding"], ($this->selected_department["content_type"]==0 ? "text/plain":"text/html"));
             $res = $emailSender->sendEmail($this->PrepareEmailsList($this->selected_department["emails"]), $this->selected_subject["internal_subject"], $mail_body, $this->_request_fields["field_0"]);

        if($res){
             $msg = "?MESSAGE[]=FEEDBACK_SENT";
        } else {
             $msg = "?MESSAGE[]=FEEDBACK_NOT_SENT";
        }
        $this->Page->Response->Redirect($msg);

        }

    }

    /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
        $this->DrawDepartments($xmlWriter);
        $sizeof = sizeof($this->_fields);
        for($i=0; $i<$sizeof; $i++){
            $this->DrawField(&$xmlWriter, $this->_fields[$i]);
        }


    }// function

} // class

?>