<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");
$this->ImportClass("system.web.validate", "Validate");
$this->ImportClass("system.web.controls.navigationcontrol","NavigationControl");

define('GUESTBOOK_SIGNATURE_FIELD_ID', 1);
define('GUESTBOOK_MESSAGE_FIELD_ID', 2);
define('GUESTBOOK_EMAIL_FIELD_ID', 3);

define('GUESTBOOK_RPP', 5);
/**
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Guestbook
 * @subpackage classes.web.controls
 * @access public
 */
class GuestbookFormControl extends XmlControl {
    var $ClassName = "GuestbookFormControl";
    var $Version = "1.0";
    /**
    * Method executes on control load
    * @access   public
    **/
    function ControlOnLoad(){
        DataFactory::GetStorage($this, "GuestbookMessagesTable", "messagesStorage", true, "guestbook");
        DataFactory::GetStorage($this, "GuestbookFormTable", "formStorage", true, "guestbook");
        $_start_page = isset($this->Page->Request->QueryString['start']) ? $this->Page->Request->QueryString['start'] * GUESTBOOK_RPP : 0;
		$this->_messages_count = $this->messagesStorage->GetMessagesCount();
		if ($_start_page * GUESTBOOK_RPP > $this->_messages_count)
		{
			$_start_page = floor($this->_messages_count / GUESTBOOK_RPP);
		}
        $this->_messages = $this->messagesStorage->GetMessagesList($_start_page, GUESTBOOK_RPP);
        $this->_fields = $this->GetFormFields(); 
        $this->_fields = $this->GetFormFields(); 
        $this->_request_fields = $this->GetRequestFields(); 
    }

    /**
    * Method returns form fields
    * @return    array   Array with form fields
    * @access    public
    */

    function GetFormFields(){
        $_reader = $this->formStorage->GetList(array("active" => 1), array("_priority" => 1));
        for($i=0; $i<$_reader->RecordCount; $i++){
            $_tmp[] = $_reader->Read();
        }
        return $_tmp;
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
            $_field_id = $this->_fields[$i]["field_id"];
			$_field_name = "field_$_field_id";
            $allow_null = ($this->_fields[$i]["not_null"] ? 0:1);
            $type = "string";
            if($this->_fields[$i]["field_type"] == "email"){
                $type = "email";
            } else {
                $type = "string";
            }
//			$this->Page->Request->Form[$_field_name] = 'zzz';
//			//	substr($this->Page->Request->Form[$_field_name], 0, $this->_fields[$i]["max_length"] - 1);
//			print "$_field_name : " . $this->_fields[$i]["max_length"];
//			echo pr($this->Page->Request->Form);
            $_form_descr[] = array(
            	"name" => $_field_name,
            	"dtype" => $type, 
            	"notnull"=> $this->_fields[$i]["not_null"], 
            	"length"=> $this->_fields[$i]["max_length"]);
            $this->Page->Kernel->Localization->SetItem("__FORM", "field_".$_field_id, $this->_fields[$i]["caption_".$this->Page->Kernel->Language], true);
        }
        $validator = new Validate($this->Page, $_form_descr, "GB_MESSAGE_FORM");     
        $validator->ValidateForm($fields, true);
        
        return $validator->formerr_arr;
    }
    
    /**
    * Method handles feedback sending
    * @access   public  
    **/
    function OnGuestbookAddMessage(){
        $this->errors = $this->ValidateFields();
        //echo pr($this->Page->Request->Form);
        if(empty($this->errors))
        {
			$message = '';
			$signature = '';
			$email = '';
	        foreach($this->_fields as $field)
	        {
 				$tmp = $this->Page->Request->ToString("field_{$field['field_id']}", "", null, $field['max_length']);
	          	switch ($field['field_id'])
	          	{
					case GUESTBOOK_SIGNATURE_FIELD_ID:
						$signature = $tmp;
						break;
					  
					case GUESTBOOK_MESSAGE_FIELD_ID:
						$message = $tmp;
						break;
					case GUESTBOOK_EMAIL_FIELD_ID:
						$email = $tmp;
						break;
	          	}
	        }
			$data = array(
				"message" => $message,
				"signature" => $signature,
				"email" => $email,
				"active" => 1,
				"posted_date" => date("Y-m-d H:i:s", time()),
				"language" => $this->Page->Kernel->Language
            );
            $this->messagesStorage->Insert($data);
	        $msg = "?MESSAGE[]=MESSAGE_ADDED";
	        $this->Page->Response->Redirect($msg);
        }
    
    }

    /**
    * Method draw XML data of messages
    * @access   public  
    **/
    function DrawMessages(&$xmlWriter)
    {
		$xmlWriter->WriteStartElement("messages");
        if ($this->_messages->RecordCount)
        {
			while ($record = $this->_messages->Read())
			{
				$xmlWriter->WriteStartElement("msg");
				$xmlWriter->WriteAttributeString("id", $record['message_id']);
					$xmlWriter->WriteElementString("posted_date", $record['posted_date']);
					$xmlWriter->WriteElementString("email", $record['email']);
					$xmlWriter->WriteElementString("signature", $record['signature']);
					$xmlWriter->WriteElementString("text", $record['message']);
					$xmlWriter->WriteElementString("comment", $record['comment']);
				$xmlWriter->WriteEndElement("msg");
			}
        }
		$xmlWriter->WriteElementString("count", $this->_messages->RecordCount);
		$xmlWriter->WriteEndElement("messages");

		$this->AddControl(new NavigationControl("navigator","navigator"));
		$this->Controls["navigator"]->SetData(
			array(
				"prefix" => "",
				"start"  => 0,
				"total"  => $this->_messages_count,
				"ppd"    => 8,
				"rpp"    => GUESTBOOK_RPP,
				"url"    => "?" . $SERVER['PHP_SELF'],
				"order_by" =>  ""
            ));
    }


    /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
		$this->DrawMessages($xmlWriter);
        // draw input form
        $sizeof = sizeof($this->_fields);
        for($i=0; $i<$sizeof; $i++){
            $this->DrawField(&$xmlWriter, $this->_fields[$i]);
        }
    }// function

} // class

?>