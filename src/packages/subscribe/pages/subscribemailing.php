<?php
	Kernel::ImportClass("project", "ProjectPage");
        /**
         * Test class for edit pages.
         * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
         * @version 1.0
         * @package        Libraries
         * @subpackage pages
         * @access public
         * class for event OnApply and send mail
         **/
	class SubscribeMailingPage extends ProjectPage {
		// Class name
		var $ClassName = "SubscribeMailingPage";
		// Class version
		var $Version = "1.0";

        function ControlOnLoad(){

       		$pars=$this->Request->Form;

       		DataFactory::GetStorage($this, "UsersTable", "usersStorage", false);
			$UsersTable = new UsersTable($this->Kernel->Connection, $this->Kernel->Settings->GetItem("Authorization", "AuthorizeTable"));

	     	$data = $this->usersStorage->GetByFields(array($this->Kernel->Settings->GetItem("Authorization", "FLD_login") => $pars["login"]));

		    if (!count($data) || $data["active"]==0){
		    	die();
			}

		    $_pass = $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_password")];

		    if(!$this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD")){
		        $_pass = md5($_pass);
		  	}

		  	/*DataFactory::GetStorage($this, "UserRolesTable", "usersRolesStorage", false);
		  	$reader=$this->usersRolesStorage->GetList(array("user_id"=>$data["user_id"]));
		  	$frole=false;
		  	for ($i=0; $i<$reader->RecordCount; $i++){
		  		$record=$reader->read();
		  		if (in_array($record["role_name"], $this->__access_role_id)){
		  			$frole=true;
				}
		  	}  */

		    if ($_pass != $pars["password"]){
		    	die();
			}

			if ($pars["event"]="Mailing"){
				//mailing
                $r=DataFactory::GetStorage($this, "SubscribeContentTable", "contentstorage", false);
                $this->rt=DataFactory::GetStorage($this, "SubscribeTemplateTable", false);
                $this->tpl=$this->rt->Get( array( "template_id" => 3 ) );
                $this->tpl_team=$this->rt->Get( array( "template_id" => 5 ) );

		        $this->Kernel->ImportClass("system.mail.emailtemplate", "EmailTemplate");
		        $id=$pars["id"];

		        $this->administrator=$this->Kernel->Settings->GetItem("EMAIL", "FROM");

		        if (isset($id)){
		            $mailing_data=$r->GetMailContent($id, $pars["test"]);

		            if (count($mailing_data)){
		            	DataFactory::GetStorage($this, "ContentTable", "contentStorage", false);
		            	$page=$this->contentStorage->Get(array("point_page"=>"subscribe|regsubscribeuser"));
		            	$this->entry=$page["path"];
	            		if ($this->Kernel->Settings->HasItem("DEFAULT", "MultiLanguage"))
		            		if ($this->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1)
		            			$this->entry=$mailing_data[0]["lang_ver"]."/".$this->entry;
		            	$this->indicator_file_name=$this->Page->Kernel->Settings->GetItem("Module", "SitePath")."CACHE/subscribeprocess.txt";

		            	$label_step=(100/count($mailing_data));
	                    $this->WriteLabel(0);
	                    $label=0;

			            for ($i=0; $i<count($mailing_data); $i++){
		                    $this->CreateHTMLMail($mailing_data[$i]);
		               		$label+=$label_step;
							$this->WriteLabel($label);
		               	}
		               	$this->WriteLabel(100);
	              	}
		        }

				die("End of script.");
			}

        }

	function WriteLabel($label){
		$fp=fopen($this->indicator_file_name, "w");
		chmod($this->indicator_file_name, 0777);
		fwrite($fp, $label);
		fclose($fp);
	}

	function CreateHTMLMail($e){
		//generate and send mail for text/html type of mail
		$administrator = $this->administrator;
		$host=$this->Kernel->Settings->GetItem("Module", "Host");
		$url=$this->Kernel->Settings->GetItem("Module", "SiteURL");
		$tpl=$this->tpl["template_text_".$this->Kernel->Language];
		$tpl_team=$this->tpl_team["template_text_".$this->Kernel->Language];

		$template_data["url"] = $url.$this->entry."?event=UnSubscribeTheme&uni_id=".$e["uni_id"];
		$template_data["email"]=$e["email"];
		$e["content"]=str_replace("href=\"/", "href=\"".$host, $e["content"]);
		$template_data["content"]=str_replace("src=\"/", "src=\"".$host, $e["content"]);
		$template_data["date"] = substr($e["date"], 0, 10);
		$template_data["theme"]=$e["theme_title"];
		$template_data["title"]=$e["content_title"];
		$emailSender = new EmailTemplate(null, $administrator, null, "text/html");
		$_message_team = $emailSender->Render_Tag($tpl_team, $template_data, true);

		$_message = $emailSender->Render_Tag($tpl, $template_data, true);

		$emailSender->sendEmail($template_data["email"], $_message_team, $_message);
	}
}

?>