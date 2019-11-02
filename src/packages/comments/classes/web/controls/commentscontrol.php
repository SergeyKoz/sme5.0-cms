<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("web.controls.securecode2","SecureCode2Control", "system");
$this->ImportClass("web.controls.commentslistcontrol","CommentsListControl");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class CommentsControl extends XmlControl {
        var $ClassName = "CommentsControl";
        var $Version = "1.0";

        var $comments_auto_publishing;
        var $comments_length;
        var $comments_emails;
        var $comments_only_register;
        var $comments_voting;
        var $comments_enable_discussion;

        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            $s=&$this->Page->Kernel->AdminSettings;
            $l=$this->Page->Kernel->Language;

	        $this->comments_auto_publishing=$s["comments_auto_publishing"];
	        $this->comments_length=$s["comments_length"];
	        $this->comments_emails=$s["comments_emails"];
	        $this->comments_only_register=$s["comments_only_register"];
	        $this->comments_voting=$s["comments_voting"];
	        $this->comments_enable_discussion=$s["comments_enable_discussion"];

            DataFactory::GetStorage($this, "CommentsTable", "commentsStorage");
            DataFactory::GetStorage($this, "CommentGroupsTable", "commentGroupsStorage");
            $this->Page->IncludeTemplate("blocks/commentscontrol");

            // get localization
            $commentsSettings=$this->Page->Kernel->getPackage("comments");
            $ResourcePath=$commentsSettings->Settings->GetItem("package", "ResourcePath");

        	$CommentsLocalization=ConfigFile::GetInstance("CommentsLocalization", $ResourcePath[0]."localization.".$l.".php");
            $GlobalLocalization=&$this->Page->Kernel->Localization;
        	$GlobalLocalization->Sections["main"]=array_merge($GlobalLocalization->Sections["main"], $CommentsLocalization->GetSection("MAIN"));
            ConfigFile::emptyInstance("CommentsLocalization");

            $CommentsErrors=ConfigFile::GetInstance("CommentsErrors", $ResourcePath[0]."errors.".$l.".php");
            $GlobalErrors=&$this->Page->Kernel->Errors;
            $GlobalErrors->Sections["messages"]=array_merge($GlobalErrors->Sections["messages"], $CommentsErrors->Sections["comments_messages"]);
            ConfigFile::emptyInstance("CommentsErrors");
        }

        function CreateChildControls(){
        	parent::CreateChildControls();

        	if (!($this->Page->Auth->UserId>0)){
		        $this->AddControl(new SecureCode2Control("secure_code", "secure_code"));
		        $data = array('notnull' => 1, 'name' => 'securecode');
		        $this->Controls["secure_code"]->SetData($data);
	        }

	        $comment=DataDispatcher::Get("comments");
        	if (is_array($comment)){
        		if ($this->Page->Kernel->Settings->HasItem("TINYMCE", "Dir")){
	                $this->editor_url=$tiny=$this->Page->Kernel->Settings->GetItem("TINYMCE", "Dir");
	            	$this->Page->IncludeScript($this->editor_url."tiny_mce.js");
            	}

	            foreach($comment as $group=>$item){
	            	$this->AddControl(new CommentsListControl("commments_list_".$item,"commments_list"));
	            	$this->Controls["commments_list_".$item]->SetData(array( "group"=>$group, "item"=>$item, "enable_voting"=>$this->comments_voting));
	            }
            }

        }


        /**
        * Method mails comments if nesessary
        * @param    array   $data   Comment data
        * @param    array   $group  group data
        * @access   public
        **/
        function MailComment($data){
            $user_fld=$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_user_id");
        	$emails=array();
            $settings_emails=explode("\n", $this->comments_emails);
            foreach($settings_emails as $item)
                $emails[]=trim($item);

            $SQL=sprintf(	"SELECT email FROM %s AS u JOIN %s AS ur ON (u.%s=ur.%s) WHERE u.active=1 AND ur.role_name='COMMENTS_MODERATOR'",
            				$this->commentsStorage->getTable("UsersTable"), $this->commentsStorage->getTable("UserRolesTable"), $user_fld, $user_fld);
            $reader=$this->commentsStorage->Connection->ExecuteReader($SQL);
            for ($i=0; $i<$reader->RecordCount; $i++){
            	$record=$reader->read();
            	$emails[]=$record["email"];
            }

            $emails=array_unique($emails);

            if (count($emails)){
	        	$l=$this->Page->Kernel->Language;
	        	$ls=$this->Page->Kernel->Languages;
	        	$site=$this->Page->Kernel->Settings->GetItem("MODULE", "Url");
	        	$sitename=$this->Page->Kernel->AdminSettings["title_".$ls[0]];

	        	$commentsSettings=$this->Page->Kernel->getPackage("comments");
	            $ResourcePath=$commentsSettings->Settings->GetItem("package", "ResourcePath");
	            $CommentsLocalization=ConfigFile::GetInstance("CommentsLocalization", $ResourcePath[0]."localization.".$ls[0].".php");

	            if ($data["published"]==1)
	                $publish_url=$CommentsLocalization->GetItem("MAIN", "comment_published_automaticaly");
	        	else
	                $publish_url=$site."?event=PublishComment&id=".$data["uni_id"]."&MESSAGES[]=COMMENT_PUBLISHED";
	        	$delete_url=$site."?event=DeleteComment&id=".$data["uni_id"]."&MESSAGES[]=COMMENT_DELETED";

	            if($data["user_id"]>0){
		        	DataFactory::GetStorage($this, "UsersTable", "usersStorage");
		        	$record=$this->usersStorage->Get(array($user_fld=>$data["user_id"]));
		        	$userlogin=$record[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_login")];
	        	}

	        	$sign=(strpos($data["article_url"], "?") !== false ? "&" : "?");
      			$link=$this->Page->Kernel->Settings->GetItem("MODULE", "Url").$data["article_url"].$sign.$data["module"].$data["article_id"]."comment=".$data["comment_id"]."#comment_".$data["comment_id"];

	        	$email_data=array(	"site_name"=>$sitename,
	        						"site"=>$site,
									"group_name"=>$data["group_name"],
									"article_title"=>$data["article_title"],
									"link"=>$link,
									"comment"=>$data["comment"],
									"user_login"=>$userlogin,
									"author_name"=>$data["author_name"],
									"author_email"=>$data["author_email"],
									"publish_url"=>$publish_url,
									"delete_url"=>$delete_url,
									"extranet"=>$site."extranet/",
									"datatime"=>date("Y-m-d H:i:s", time()));
			    $from= $this->Page->Kernel->Settings->GetItem("EMAIL", "FROM");
	        	$subject=sprintf($CommentsLocalization->GetItem("MAIN", "comment_email_title"), $sitename);

				$this->Page->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
				$emailSender = new EmailTemplate(null, $from, null, null);
				$path = $commentsSettings->Settings->GetItem("PATH", "TemplatePath");

				$message = $emailSender->Render($email_data, "", $path[1]."emails/comments_moderation.".$ls[0].".txt");


	            foreach ($emails as $email)
	           		$emailSender->sendEmail($email, $subject, $message);
           	}
        }

        /**
        * Method adds coments to an item
        * @access   public
        *
        **/
        function OnAddComment(){
        	$this->CommentForm = array(
       			"article"=>$this->Page->Request->ToNumber("article"),
       			"url"=>$this->Page->Request->Value("url"),
       			"parent" => $this->Page->Request->ToNumber("parent"),
       			"comment" => $this->Page->Request->Value("comment"),
       			"name" => $this->Page->Request->Value("name"),
       			"module" => $this->Page->Request->Value("module"),
       			"email" => $this->Page->Request->Value("email")
       		);

       		$this->ValidateForm();

       		$module=$this->CommentForm["module"];

			if (empty($this->errs)){
				$comment=DataDispatcher::Get("comments");
	        	if (is_array($comment))
		            foreach($comment as $group=>$item)
	                    if ($item==$this->CommentForm["article"])
	                    	$group_id=substr($group, strlen($module)+1, strlen($group)-strlen($module)+1);
                $HelperClassName=ucfirst($module)."CommentsHelper";
                $this->Page->Kernel->ImportClass(strtolower($HelperClassName), $HelperClassName, $module);
                $commentsHelper = new $HelperClassName;

                $group_name=$commentsHelper->UpdateCommentsGroup($this, $group_id);
                $article_title=$commentsHelper->GetArticleTitle($this, $this->CommentForm["article"], $group_id);

                $nodes=array();
		  		TableHelper::GetRecursiveNodeLevels($this->commentsStorage, $this->CommentForm["parent"], "comment_id", "parent_id", $nodes);

       			//save comment
       			$insert_data = array("group_id" => $module.$group_id,
		                          "parent_id" => $this->CommentForm["parent"],
		                          "comment" => $this->CommentForm["comment"],
		                          "author_name" => $this->CommentForm["name"],
		                          "author_email" => $this->CommentForm["email"],
		                          "posted" => date("Y-m-d H:i:s", time()),
		                          "uni_id"=>md5(uniqid(rand(),true)),
		                          "published" => ($this->comments_auto_publishing ? 1 : 0),
		                          "article_id"=> $this->CommentForm["article"],
		                          "article_title"=>$article_title,
		                          "article_url"=>$this->CommentForm["url"],
		                          "level"=>count($nodes),
		                          "module"=>$module,
		                          "user_id"=>$this->Page->Auth->UserId);

		  		$this->commentsStorage->Insert($insert_data);

		  		$comment_id=$this->commentsStorage->getInsertId();
		  		$update_data=array("comment_id"=>$comment_id, "_priority"=>$comment_id);
		  		$this->commentsStorage->Update($update_data);

		  		if ($this->CommentForm["parent"]>0){
		  			$data=array("group_id"=>$insert_data["group_id"],
		  						"article_id"=>$insert_data["article_id"]);
		  			$this->commentsStorage->UpdatePriority($comment_id, $this->CommentForm["parent"], $data);
				}

                $insert_data["comment_id"]=$comment_id;
                $insert_data["group_name"]=$group_name;
                $insert_data["module"]=$module;

				$this->MailComment($insert_data);

		  		if ($this->comments_auto_publishing == 1)
                    $message = "MESSAGE[]=COMMENT_ADDED";
                else
                    $message = "MESSAGE[]=COMMENT_PREMODERATED";

                $sign=(strpos($_SERVER["REQUEST_URI"], "?") !== false ? "&" : "?");
		  		$this->Page->Response->Redirect(preg_replace("/MESSAGE\[\]=.?/", "", $_SERVER["REQUEST_URI"]).$sign.$message);
         	}

        }


        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {


            if($this->editor_url!="")
            	$xmlWriter->WriteElementString("editor_url", $this->editor_url);

            $xmlWriter->WriteElementString("comments_length", $this->comments_length);
            $xmlWriter->WriteElementString("comments_only_register", $this->comments_only_register);
            $xmlWriter->WriteElementString("comments_voting", $this->comments_voting);
            $xmlWriter->WriteElementString("action_uri", preg_replace("/\?{0,1}\&{0,1}MESSAGE\[\]=.*/","", $_SERVER["REQUEST_URI"]));

            if (empty($this->CommentForm)) $this->CommentForm["parent"]=0;
			$this->XmlTag = "form_data";
			$this->data = $this->CommentForm;
			RecordControl::StaticXmlControlOnRender($this, $xmlWriter);

			$this->XmlTag = "err_data";
			$this->data = $this->errs;
			RecordControl::StaticXmlControlOnRender($this, $xmlWriter);



        }// function

	function ValidateForm(){
		$comment=DataDispatcher::Get("comments");
		if (!is_array($comment))die();
		if ($this->CommentForm["article"]==0 || $this->CommentForm["module"]=="" || !in_array($this->CommentForm["article"], $comment)) die();

		if (!isset($this->Page->Auth->UserId)){
			if (!$this->Controls["secure_code"]->Check($this->Page->Request->ToString("securecode"))){
				$this->AddErrorMessage("MESSAGES", "INVALID_CODE");
				$this->errs["securecode"]=1;
			}

			if ($this->CommentForm["name"]==""){
				$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_NAME_ISNULL");
				$this->errs["name"]=1;
			} elseif (strlen($this->CommentForm["name"])>255){
				$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_NAME_LENGTH_ERROR");
				$this->errs["name"]=1;
			}

			preg_match("~[a-zA-Z][a-zA-Z0-9]{3,}~", $this->CommentForm["email"], $exp);

			if ($this->CommentForm["email"]==""){
				$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_EMAIL_ISNULL");
				$this->errs["email"]=1;
			} else {
				if (strlen($this->CommentForm["email"])>255){
					$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_EMAIL_LENGTH_ERROR");
					$this->errs["email"]=1;
				} elseif (sizeof($exp) == 0) {
					$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_EMAIL_INVALID");
					$this->errs["email"]=1;
				}
			}
		}

		if ($this->CommentForm["comment"]==""){
			$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_COMMENT_ISNULL");
			$this->errs["comment"]=1;
		} elseif (strlen($this->CommentForm["comment"])>$this->comments_length) {
			$this->AddErrorMessage("MESSAGES", "COMMENTS_FORM_COMMENT_LENGTH_ERROR{".$this->comments_length."}");
			$this->errs["comment"]=1;
		}

	}

	function OnPublishComment(){
        $id=$this->Page->Request->Value("id");
        if (trim($id)!=""){
			$record=$this->commentsStorage->Get(array("uni_id"=>$id, "published"=>0));
			if ($record["comment_id"]>0){
				$update_data=array("comment_id"=>$record["comment_id"], "published"=>1);
				$this->commentsStorage->Update($update_data);
			}
		}
	}

	function OnDeleteComment(){
        $id=$this->Page->Request->Value("id");
        if (trim($id)!=""){
			$record=$this->commentsStorage->Get(array("uni_id"=>$id));
			if ($record["comment_id"]>0){
				$delete_data=array("comment_id"=>$record["comment_id"]);
				$this->commentsStorage->Delete($delete_data);
			}
		}
	}

} // class

?>