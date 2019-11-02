<?php
  $this->ImportClass("web.editpage", "EditPage", "libraries");
  $this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
  $this->ImportClass("web.controls.subscribeselectcontrol", "SubscribeSelectControl");
  $this->ImportClass("web.controls.securecode2","SecureCode2Control", "system");
 /** RegSubscribeUserPage page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   * class registration for user
   **/
    class RegSubscribeUserPage extends EditPage  {

        var $ClassName="RegSubscribeUserPage";
        var $Version="1.0";
        var $moder_page = false;
        var $access_id = array();
        var $PageMode = "Frontend";

  	function ControlOnLoad(){
		DataFactory::GetStorage($this, "SubscribeUserTable", "subUsersStorage", false);
		DataFactory::GetStorage($this, "SubscribeThemesTable", "subThemesStorage", false);
		DataFactory::GetStorage($this, "SubscribeRelationTable", "subRelationStorage", false);
		DataFactory::GetStorage($this, "SubscribeTemplateTable", "subTemplateStorage", false);

        $this->AddControl(new SubscribeSelectControl("subscribeselect", "subscribeselect"));

		parent::ControlOnLoad();
		$this->Themes=$this->Request->value("theme");
		$page_data=DataDispatcher::Get("PAGE_DATA");

		$this->entry=$page_data["path"]."/";
	}

	function CreateChildControls(){
        ControlsProvider::AddControls(&$this);
        parent::CreateChildControls();


        $this->entry=DataDispatcher::Get("page_point_url")."/";//, $this->Kernel->Language);
        if ($this->Kernel->Settings->HasItem("DEFAULT", "MultiLanguage"))
	        if ($this->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1)
	            $this->entry=$this->Kernel->Language."/".$this->entry;

        $this->AddControl(new SecureCode2Control("secure_code", "secure_code"));
        $data = array( 'notnull' => 1, 'name' => 'securecode');
        $this->Controls["secure_code"]->SetData($data);

   }

      function OnDefault(){
        $this->OnAddItem();
      }

      function ValidateBeforeAdd(){
          parent::ValidateBeforeAdd();
          if (!isset($this->Page->Auth->UserId))
	          if (!$this->Controls["secure_code"]->Check($this->Page->Request->ToString("securecode"))){
		           $this->AddErrorMessage("MESSAGES", "INVALID_CODE");
		           $this->validator->formerr_arr["securecode"]=1;
		      }

	      if (!count($this->Themes)){
	      	  $this->AddErrorMessage("MESSAGES", "THEMES_NOT_SELECTED");
	      	  $this->validator->formerr_arr["themes"]=1;
	      }

      }

      function OnDoAddItem(){

         if(!$this->error){
            $this->_data = $this->GetFieldsData();
            //validate form
            $this->ValidateBeforeAdd();

            if ($this->listSettings->HasItem("MAIN", "UNIQUE_FIELDS"))
                $this->checkForDuplicateUnique();

            if(empty($this->validator->formerr_arr)){


              $uni_id=md5(uniqid(rand(), true));
              //add user to database
              $insert_data = array( "parent_id" => 0,
                                    "first_name"=>$this->_data["first_name"],
                                    "last_name"=>$this->_data["last_name"],
                                    "organization"=>$this->_data["organization"],
                                    "post"=>$this->_data["post"],
                                    "email"=>$this->_data["email"],
                                    "active" => 0,
                                    "uni_id" => $uni_id);

              $this->subUsersStorage->Insert($insert_data);
              $inserted_user=$this->subUsersStorage->getInsertId();

              $themes=array();
              $reader = $this->subThemesStorage->GetList(array("theme_id"=>$this->Themes, "active"=>1));
              for ($i=0; $i<$reader->RecordCount; $i++)
              	  $themes[]=$reader->read();

              $Radio=$this->Request->value("lang", REQUEST_ALL, false);

              foreach ($themes as $theme){
              		$insert_data1 = array(	"user_id"=> $inserted_user,
		                                    "theme_id" => $theme["theme_id"],
		                                    "uni_id" => md5(uniqid(rand(),true)),
		                                    "lang_ver" => $Radio[$theme["theme_id"]],
		                                    "active" => 1);

                   $this->subRelationStorage->Insert($insert_data1);
              }

              //send mail for confirmation
              $from = $this->Kernel->Settings->GetItem("EMAIL", "FROM");

              $tpl=$this->subTemplateStorage->GetTemplate(1);
              $template_data["URL"] = $this->Kernel->Settings->GetItem("Module", "SiteURL").$this->entry."?event=ConfirmSubscribe&uni_id=".$insert_data["uni_id"];
              $template_data["email"]=$this->_data["email"];
              $this->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");

              $subject=$this->subTemplateStorage->GetTemplate(4);

              $emailSender = new EmailTemplate(null, $from, null, null);
              $message = $emailSender->Render_Tag($tpl, $template_data, true);
              $message=str_replace("src=\"/", "src=\"".$this->Kernel->Settings->GetItem("Module", "Host"), $message);

              $emailSender->sendEmail($this->_data["email"], $subject, $message);

              $this->AfterSubmitRedirect("?event=DoRegistration&MESSAGE[]=SUBSCRIBE_REGISTRATION");

            } else {
              $this->event = "AddItem";
            }


           if (is_object($this->Controls["ItemsEdit"]))
                $this->Controls["ItemsEdit"]->InitControl(array("form_fields" => $this->form_fields,
                                                           "item_id" => $this->item_id,
                                                           "key_field" => $this->key_field,
                                                           "event"   => $this->event,
                                                           "handler" =>$this->handler,
                                                           "data" => $this->_data,
                                                           "start" => $this->start,
                                                           "order_by" => $this->order_by,
                                                           "library" => $this->library_ID,
                                                           "restore" => $this->restore,
                                                           "parent_id" => $this->parent_id,
                                                           "custom_var" => $this->custom_var,
                                                           "custom_val" => $this->custom_val,
                                                           "host_library_ID" => $this->host_library_ID                                                      )
                                                    );

       }
      }

      function DoRegistration(){
          $this->XslTemplate = "project";
      }

   /**
    *  Method - event for activate user for subscribe
    **/
    function OnConfirmSubscribe(){
    	$this->XslTemplate = "project";
        $uni_id=$this->Request->ToString("uni_id");

        if ($uni_id!=""){
            $user = $this->subUsersStorage->Get( array("uni_id" => $uni_id));
            $user_id=$user["user_id"];
            $update_data = array("user_id" => $user_id, "active" => 1);
            $this->subUsersStorage->Update(&$update_data);
            $this->AddErrorMessage("MESSAGES", "SUBSCRIBE_CONFIRMED");
    	}

    }


    /**
     *  Method - event for unsubscribe user for $uni_id team and redirect to message page
     **/
    function OnUnSubscribeTheme(){
        $uni_id=$this->Request->ToString("uni_id");
        $this->XslTemplate = "project";
        if ($uni_id!=""){
            DataFactory::GetStorage($this, "SubscribeRelationTable", "relationStorage", false);
            $record = $this->relationStorage->Get( array("uni_id" => $uni_id) );
            $delete_data=array("relation_id" => $record["relation_id"]);
            $this->relationStorage->Delete($delete_data);

            $count = $this->relationStorage->GetCount( array("user_id" => $record["user_id"]) );
            if ($count==0){
            	DataFactory::GetStorage($this, "SubscribeUserTable", "subsctibeUsersStorage", false);
            	$update_data=array("user_id" => $record["user_id"], "active"=>0);
            	$this->subsctibeUsersStorage->Update(&$update_data);
            }
            $this->AddErrorMessage("MESSAGES", "SUBSCRIBE_DELETED");
        }
    }

  /**
 *  Method builds rows of a list
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 */
      function XmlControlOnRender(&$xmlWriter)  {
          parent::XmlControlOnRender(&$xmlWriter);
          if ($this->validator->formerr_arr["securecode"]==1)
	      	$xmlWriter->WriteElementString("securecode_error", 1);

	      if ($this->validator->formerr_arr["themes"]==1)
	      	$xmlWriter->WriteElementString("themes_error", 1);
      }



}
?>