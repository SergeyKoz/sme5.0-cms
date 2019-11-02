<?php
$this->ImportClass("web.editpage", "EditPage", "libraries");
$this->ImportClass("web.controls.securecode2","SecureCode2Control", "system");
$this->ImportClass("web.controls.controlsprovider", "ControlsProvider");

/** Feedback page class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package  System
 * @access public
 **/
class Feedback_SysPage extends EditPage
{

    var $ClassName = "Feedback_SysPage";
    var $Version = "1.0";
    var $moder_page = false;
    var $id = 50;
    var $access_id = array();
    var $PageMode = "Frontend";

    //var $debug_mode = 1;

    function ControlOnLoad(){
        $this->Request->SetValue("library", "feedback_sys");
        if (((! in_array($this->Event, array("AddItem", "DoAddItem"))) && ($this->Event != "")) || ($this->Event == "")) {
            $this->Event = "AddItem";
        }

        parent::ControlOnLoad();
    }

    /** Method creates child controls
     * @access public
     */
    function CreateChildControls(){
        parent::CreateChildControls();
        ControlsProvider::AddControls($this);

        $this->AddControl(new SecureCode2Control("secure_code", "secure_code"));
        $data = array( 'notnull' => 1, 'name' => 'securecode');
        $this->Controls["secure_code"]->SetData($data);
    }


    function checkCaptcha()
    {
        if ($_POST['securecode'] == '' || $_SESSION['SECURE_CODE'] != $_POST['securecode']) {
            $this->AddErrorMessage('FEEDBACK_SYS', 'INVALID_CODE');
            return false;
        }
        return true;
    }


    /** Method handles DoAddItem event
     * @access public
     */
    function OnDoAddItem()
    {
        if (! $this->error) {
            $this->_data = $this->GetFieldsData();

            $this->ValidateBeforeAdd();
            if (empty($this->validator->formerr_arr)) {
                $administrator=$this->Kernel->AdminSettings["email"];

                $subject=$this->Kernel->Localization->GetItem("feedback_sys", "_Subject");
              	$subject=sprintf($subject, $this->Kernel->Settings->GetItem("MODULE", "Url"));

                $body="From: ".$this->_data["author"]." (".$this->_data["email"].")\n\n".
          			"Theme: ".$this->_data["subject"]."\n\n".
          			"Message: ".$this->_data["message"];


                $local_from = $this->Page->Kernel->Settings->GetItem("EMAIL", "FROM");
                $this->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
                $emailSender = new EmailTemplate(null, $local_from, null, null);
                $res = $emailSender->sendEmail($administrator, $subject, $body, $this->_data["email"]);

                if ($res) {
                    $msg = "?MESSAGE[]=FEEDBACK_SENT";
                }
                else {
                    $msg = "?MESSAGE[]=FEEDBACK_NOT_SENT";
                }
                $this->AfterSubmitRedirect($msg);

            }
            else {

                $this->event = "AddItem";
            }

            if (is_object($this->Controls["ItemsEdit"]))
                $this->Controls["ItemsEdit"]->InitControl(array(
                    "form_fields" => $this->form_fields,
                    "item_id" => $this->item_id,
                    "key_field" => $this->key_field,
                    "event" => $this->event,
                    "handler" => $this->handler,
                    "data" => $this->_data,
                    "start" => $this->start,
                    "order_by" => $this->order_by,
                    "library" => $this->library_ID,
                    "restore" => $this->restore,
                    "parent_id" => $this->parent_id,
                    "custom_var" => $this->custom_var,
                    "custom_val" => $this->custom_val,
                    "host_library_ID" => $this->host_library_ID
                )
                );

        }
    }

    function ValidateBeforeAdd(){
          parent::ValidateBeforeAdd();
          if (!isset($this->Page->Auth->UserId))
	          if (!$this->Controls["secure_code"]->Check($this->Page->Request->ToString("securecode"))){
		           $this->AddErrorMessage("MESSAGES", "INVALID_CODE");
		           $this->validator->formerr_arr["securecode"]=1;
		      }

      }

      function XmlControlOnRender(&$xmlWriter)  {
          parent::XmlControlOnRender($xmlWriter);
          if ($this->validator->formerr_arr["securecode"]==1)
	      	$xmlWriter->WriteElementString("securecode_error", 1);
      }
}
?>