<?php

   $this->ImportClass("web.editpage", "EditPage");
   $this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
   $this->ImportClass("web.controls.securecode2","SecureCode2Control", "system");

  /** CatalogPage page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   **/
   class ProfilePage extends EditPage  {

       var $ClassName="ProfilePage";
       var $Version="1.0";
       var $moder_page = false;
       var $access_id = array();
       var $PageMode = "Frontend";
       var $LogonPage;
       var $ProfilePage;

   function ControlOnLoad(){
       $this->Request->SetValue("library", "profileedit");

       if ($this->Kernel->Settings->HasItem("DEFAULT", "MultiLanguage"))
	   		if ($this->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1)
	   			$prefix=$this->Page->Kernel->Language."/";

	   DataFactory::GetStorage($this, "ContentTable", "contentStorage", false);
       $record=$this->contentStorage->Get(array("point_page"=>"system|userlogon"));
       $this->LogonPage=$prefix.$record["path"]."/";

       $record=$this->contentStorage->Get(array("point_page"=>"system|registration"));
       $this->ProfilePage=$prefix.$record["path"]."/";

       parent::ControlOnLoad();
   }

   function ProcessMainSection(){
		parent::ProcessMainSection();
   }

   function CheckLibraryAccess(){
	 	if (!isset($this->Page->Auth->UserId))
            $this->listSettings->SetItem("FIELD_0", "EDIT_CONTROL", "text");

		parent::CheckLibraryAccess();
	}

  /** Method creates child controls
  * @access public
  */
   function CreateChildControls(){
        ControlsProvider::AddControls($this);
        parent::CreateChildControls();
        if (!isset($this->Page->Auth->UserId)){
	        $this->AddControl(new SecureCode2Control("secure_code", "secure_code"));
	        $data = array('notnull' => 1, 'name' => 'securecode');
	        $this->Controls["secure_code"]->SetData($data);
        }
   }

   function OnBeforeCreateEditControl(){
   		parent::OnBeforeCreateEditControl();
   }

    function OnDefault(){
    	if (isset($this->Page->Auth->UserId)){
        	$this->OnEditItem();
     	}else{
     		$this->OnAddItem();
     	}
    }

    function OnEditItem(){
        $this->item_id=$this->Auth->userData["user_id"];
        parent::OnEditItem();
    }
      function OnBeforeEdit(){
      	  parent::OnBeforeEdit();
      	  $this->old_user=$this->Storage->Get(array("user_id"=>$this->item_id));
      	  unset($this->_data["group_id"]);
      	  $this->CheckPassword();
      }

      function OnBeforeAdd(){
		parent::OnBeforeAdd();

		$this->CheckPassword();
      }

      function CheckPassword(){
		$flg_md5_password=$this->Kernel->Package->Settings->GetItem("AUTHORIZATION", "FLG_MD5_PASSWORD");
		$fld_password=$this->Kernel->Package->Settings->GetItem("AUTHORIZATION", "FLD_password");
        $this->_data["user_password_email"]=$this->_data[$fld_password];
		if ($flg_md5_password==1){
			$this->_data[$fld_password]=md5($this->_data[$fld_password]);
		}
      }

      function OnAfterEdit(){
			//create and send mail
          $from= $this->Kernel->Settings->GetItem("EMAIL", "FROM");
          $Language=$this->Page->Kernel->Language;
          $email_data["site"]=$this->Kernel->Settings->GetItem("MODULE", "Url");
          $email_data["name"] = $this->_data["name"];
          $email_data["email"]=$this->_data["email"];
          $email_data["password"]=$this->_data["user_password_email"];

          if ($email_data["password"]==$this->old_user["user_password"]){
          		$email_data["password"]=$this->Page->Kernel->Localization->GetItem("main", "_pass_not_changed");
          		$uri=$this->ProfilePage."?MESSAGE[]=USER_PROFILE_CHANGE";
          } else {
                $uri=$this->LogonPage."?MESSAGE[]=USER_PROFILE_CHANGE_PASS";
          }
          $email_data["login"]=$this->_data["user_login"];

          $this->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
          $emailSender = new EmailTemplate(null, $from, null, null);
          $path = $this->Kernel->Package->Settings->GetItem("PATH", "TemplatePath");

          $message = $emailSender->Render($email_data, "", $path[1]."emails/change_template.".$Language.".txt");

   		  $subject=$this->Page->Kernel->Localization->GetItem("main", "_mail_edit_title");
   		  $emailSender->sendEmail($email_data["email"], $subject, $message);
       	  $url=$email_data["site"].$uri;

		  $this->AfterSubmitRedirect($url);

          parent::OnAfterEdit();
      }

      function OnAfterAdd(){

		  //create and send mail
          $from = $this->Kernel->Settings->GetItem("EMAIL", "FROM");
          $Language=$this->Page->Kernel->Language;
          $email_data["site"]=$this->Kernel->Settings->GetItem("MODULE", "Url");

          $email_data["name"]=$this->_data["name"];
          $email_data["email"]=$this->_data["email"];
          $email_data["password"]=$this->_data["user_password"];
          $email_data["login"]=$this->_data["user_login"];

          $this->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
          $emailSender = new EmailTemplate(null, $from, null, null);
          $path = $this->Kernel->Package->Settings->GetItem("PATH", "TemplatePath");
          $message = $emailSender->Render($email_data, "", $path[1]."emails/confirmation_template.".$Language.".txt");

   		  $subject=$this->Page->Kernel->Localization->GetItem("main", "_mail_reg_title");
   		  $emailSender->sendEmail($email_data["email"], $subject, $message);
       	  $url=$email_data["site"].$this->LogonPage."?MESSAGE[]=USER_REGISTERED";

		  $this->AfterSubmitRedirect($url);

          parent::OnAfterEdit();
      }

	   function ValidateBeforeAdd(){
		   if (!isset($this->Page->Auth->UserId)){
			   if (!$this->Controls["secure_code"]->Check($this->Page->Request->ToString("securecode"))){
		           $this->AddErrorMessage("MESSAGES", "INVALID_CODE");
		           $this->validator->formerr_arr["securecode"]=1;
		       }
		 	}

	   	   parent::ValidateBeforeAdd();
	   }

	   function XmlControlOnRender(&$xmlWriter){
           if (!isset($this->Page->Auth->UserId))
	           if ($this->validator->formerr_arr["securecode"]==1)
	           		$xmlWriter->WriteElementString("securecode_error", 1);

	   	   parent::XmlControlOnRender($xmlWriter);
	   }

}
?>