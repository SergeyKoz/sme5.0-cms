<?php
   /**
     * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
     * @version 1.0
     * @package wizard
     **/
$this->ImportClass("project", "ProjectPage");
$this->ImportClass("web.controls.securecode2","SecureCode2Control", "system");

 class PasswordReminderPage extends ProjectPage
 {
    var $ClassName = "PasswordReminderPage";
    var $Version = "1.0";
    var $login;
    var $email;
    var $errors=array();
    var $LogonPage ="registration/logon/";
    var $ProfilePage="profile/";

    function CreateChildControls(){
        parent::CreateChildControls();
        $this->AddControl(new SecureCode2Control("secure_code", "secure_code"));
        $data = array('notnull' => 1,'name' => 'securecode');
        $this->Controls["secure_code"]->SetData($data);

        if (isset($this->Page->Auth->UserId)){
        	$url=$this->Kernel->Settings->GetItem("MODULE", "Url").$this->ProfilePage;
        	$this->Response->Redirect($url);
        }
    }

    function OnProcess() {
        $this->login = trim($this->Request->ToString("login", "", 1, 30));
        $this->email = trim($this->Request->ToString("email", "", 1, 200));
        $Language=$this->Kernel->Language;

        if (strlen($this->login) == 0){
            $this->AddErrorMessage("PASSWORD_REMINDER", "LOGIN_IS_EMPTY");
            $this->errors["login"]=1;
        }

        if (strlen($this->email) == 0){
            $this->AddErrorMessage("PASSWORD_REMINDER", "EMAIL_IS_EMPTY");
            $this->errors["email"]=1;
        }

        if (!$this->Controls["secure_code"]->Check($this->Request->ToString("securecode"))){
            $this->AddErrorMessage("PASSWORD_REMINDER", "INVALID_CODE");
            $this->errors["code"]=1;
        }

        DataFactory::GetStorage($this, "UsersTable", "storageUsers");
        $data = $this->storageUsers->Get(array(
            "user_login" => $this->login,
            "email" => $this->email
        ));

        if (!count($data) && !count($this->errors)){
            $this->AddErrorMessage("PASSWORD_REMINDER", "INVALID_DATA");
            $this->errors["email"]=1;
            $this->errors["login"]=1;
            $this->email=$this->login="";
        }

        if (!count($this->errors)){
	        $this->Page->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
	        $administrator = $this->Kernel->Settings->GetItem("EMAIL", "FROM");
	        $template = new EmailTemplate(null, $administrator);
	        $path = $this->Kernel->Package->Settings->GetItem("PATH", "TemplatePath");
	        if (!is_array($path))$path = array($path);
	        $dataset = array("password" => $data["user_password"]);

	        $dataset["name"] = ($data["name"]=="" ? $data["user_login"] : $data["name"]);
	        $dataset["site"] = $this->Kernel->Settings->GetItem("MODULE", "Url");

	        $TemplatePaths=$this->Kernel->Package->Settings->GetItem("PATH", "TemplatePath");
			$f=false;
			foreach($TemplatePaths as $path){
				if (!$f){
					$Path=$path."emails/passwordreminder_template.".$Language.".txt";
				}
				if (file_exists($Path) && !$f){
					$f=true;
				}
			}

	        $message = $template->Render($dataset, "", $Path);

	        $res = $template->sendEmail(
	            $this->email,
	            $this->Page->Kernel->Localization->GetItem("main", "_rem_mail_title"),
	            $message);
	        // -----------

	        $site=$this->Kernel->Settings->GetItem("MODULE", "Url");
	        $this->Response->Redirect($site.$this->LogonPage."?MESSAGE[]=USER_REMINDER_SENT");
        }
    }

    function OnSent()
    {
        $this->XslTemplate = "passwordreminder_sent";

    }

    function XmlControlOnRender(&$xmlWriter)
    {
        $xmlWriter->WriteElementString("email", $this->email);
        $xmlWriter->WriteElementString("login", $this->login);

        $this->XmlTag = "errors";
        $this->data=$this->errors;
        RecordControl::StaticXmlControlOnRender($this, $xmlWriter);

        parent::XmlControlOnRender($xmlWriter);
    }

 }

?>