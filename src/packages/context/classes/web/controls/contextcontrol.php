<?php
  $this->ImportClass("system.web.xmlcontrol", "XMLControl");
  $this->ImportClass("web.configmenu", "ConfigMenuControl", "extranet");


/** DateTime control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class ContextControl extends XMLControl {
		var $ClassName = "ContextControl";
		var $Version = "1.0";

        var $data = array();
        var $iniFile = "Menu_IniFile";
        var $Menu;
        var $ContextMenu = array();
        var $Mode;

        function ControlOnLoad(){
        	$this->user_id=$this->Page->Auth->UserId;
        	//get package
        	$contextSettings=$this->Page->Kernel->getPackage("context");
        	$this->ContextPackageUrl=$contextSettings->Settings->GetItem("PACKAGE", "PackageURL");
        	$contextTemplateDirs=$contextSettings->Settings->GetItem("PATH", "TemplatePath");
        	$this->Page->Kernel->TemplateDirs=array_values(array_unique(array_merge($this->Page->Kernel->TemplateDirs, $contextTemplateDirs)));


            // include template
	        $this->Page->IncludeTemplate("controls/contextcontrol");

            if ($this->user_id>0){

            	$this->GetLanguages();
                $l=$this->Page->Kernel->Language;

                $this->Page->IncludeScript("scripts.jqueryui");
                $this->Page->IncludeScript("js.ddsmoothmenu", "context");
                $this->Page->IncludeLink("css.smecontrolpanelui", "context");
        		$this->Page->IncludeLink("css.smecontrolpanel", "context");

	            // set mode
	        	$Mode=$this->Page->Request->Value("mode");
	        	if (in_array($Mode, array("view", "edit"))){
	       			$this->Mode=$Mode;
	       			setcookie("context_mode", $Mode, time()+3600*24*365, '/');
	        	} else{
	        		$Mode=$_COOKIE["context_mode"];
	        		if (in_array($Mode, array("view", "edit")))
	                    $this->Mode=$Mode;
	        	}
	        	if (!in_array($this->Mode, array("view", "edit")))$this->Mode="view";

	            // get menu
		        $this->Menu = &ConfigFile::GetInstance($this->iniFile, $contextSettings->Settings->GetItem("MAIN", $this->iniFile));
	            ConfigMenuControl::GetPackagesMenu($this->Page, $this->Menu, "extranet.topmenu.ini.php");
	            ConfigMenuControl::GetPackagesMenu($this->Page, $this->Menu, "extranet.leftmenu.ini.php");

				// get localization
	            $ResourcePath=$contextSettings->Settings->GetItem("package", "ResourcePath");
	        	$ContextLocalization=ConfigFile::GetInstance("ContextLocalization", $ResourcePath[0]."localization.".$l.".php");
	            $GlobalLocalization=&$this->Page->Kernel->Localization;
	        	$GlobalLocalization->Sections["main"]=array_merge($GlobalLocalization->Sections["main"], $ContextLocalization->GetSection("CONTEXT"));

	        	//set context messages
	        	$GlobalErrors=&$this->Page->Kernel->Errors;
	        	$packages=$this->Page->Kernel->Settings->GetSection("packages");
	        	foreach($packages as $name => $PackagePath){
	        		$package = Engine::getPackageSettings($this->Page->Kernel,$name);
	                $ResourcePath=$package->GetItem("PACKAGE", "ResourcePath");
	        		if (!is_array($ResourcePath))$ResourcePath=array($ResourcePath);
	        		foreach($ResourcePath as $path){
	        			$ContextErrors=ConfigFile::GetInstance("ContextErrors", $path."errors.".$l.".php");
	        			$context_messages=$ContextErrors->Sections["context_messages"];
	        			if (!empty($context_messages)){
	                        $GlobalErrors->Sections["messages"]=array_merge($GlobalErrors->Sections["messages"], $context_messages);
	        			}
	        			ConfigFile::emptyInstance("ContextErrors");
	        		}
	        	}
        	}

        	parent::ControlOnLoad();
        }

        function CreateChildControls(){
        }

   		function AddContextMenu($mode, $package, &$parameters){
   			if ($this->Mode=="edit" && $this->user_id>0){
	            $contextSettings = Engine::getLibrary($this->Page->Kernel, $mode.".context", "ContextMenuInstance", true, $package);
	            foreach ($parameters as $key=>$parameter)
	            	if (is_string($parameter) || is_int($parameter))
	            		$contextSettings->SetItem("MAIN", $key, $parameter);

	            $contextSettings->reParse();
	            $commands=$contextSettings->GetItem("MAIN", "COMMANDS_COUNT");
	            if ($commands>0){
	            	$HelperClassName=ucfirst($package)."ContextHelper";
	            	$this->Page->Kernel->ImportClass(strtolower($HelperClassName), $HelperClassName, $package);
	            	$contextHelper = new $HelperClassName;
	                $menu_items=array();
		            for ($i=0; $i<$commands; $i++){
		            	$item=$contextSettings->GetSection("COMMAND_".$i);

	              		$granted=false;
	              		if ($contextSettings->HasItem("COMMAND_".$i, "ACCESS")){
	              			$roles=$contextSettings->GetItem("COMMAND_".$i, "ACCESS");
	              			if ($this->CheckAccess($roles, "Frontend") || $this->CheckAccess($roles, "Backend")){
	              				$granted=true;
	              			}
	              		}else{
	              			$granted=true;
	              		}

	              		$package=true;
	              		if ($contextSettings->HasItem("COMMAND_".$i, "PACKAGE")){
                  			$package=$contextSettings->GetItem("COMMAND_".$i, "PACKAGE");
                  			$package=Engine::isPackageExists($this->Page->Kernel, $package);
	              		}

	             		if ($granted && $package){
			            	$checkMethod=ucfirst($mode).ucfirst($item["NAME"]);
			            	if ($contextHelper->$checkMethod($parameters)){
			            		list($caption, $confirm)=$this->GetContextLocalization($item, $mode, $package);
			            		$params=array();
                                if (is_array($item["PARAMETER"]))
				            		foreach($item["PARAMETER"] as $param)
		                                if ($param!=""){
		                                	$param=explode("|", $param);
		                                    $params[$param[0]]=$param[1];
		                                }

			            		if ($params["page"]==""){
			            			$params["actionpackage"]=$params["package"];
	                                $params["package"]="context";
	                                $params["page"]="contextaction";
			            		}

			            		$type=($item["TYPE"]!="" ? $item["TYPE"] : "item");

	            				$menu_item=array("name"=>$item["NAME"],
		            							"url"=>$item["URL"],
		            							"mode"=>$item["MODE"],
		            							"type"=>$type,
		            							"caption"=>$caption,
		            							"confirm"=>$confirm,
		            							"params"=>$params);

		            			if ($item["MODE"]="ajax")
		            				$menu_item["params"]["mode"]=$mode.".".$item["NAME"];
                                //get item icon
		            			if ($item["ICON_PACKAGE"]!="" && $item["ICON_PATH"]!="" && Engine::isPackageExists($this->Page->Kernel, $item["ICON_PACKAGE"])){
                                    $package = Engine::getPackageSettings($this->Page->Kernel, $item["ICON_PACKAGE"]);
                					$PackageUrl=$package->GetItem("PACKAGE", "PackageURL");
                					$menu_item["icon_url"]=$PackageUrl.$item["ICON_PATH"];
			            		}
			            		if ($item["ICON_CLASS"]!="") $menu_item["icon_class"]=$item["ICON_CLASS"];
			            		$menu_items[]=$menu_item;
			            	}
		            	}
		            }
		            $this->ContextMenu[$mode][$parameters["item_id"]]=$menu_items;
		            unset($contestHelper);
	            }
	            ConfigFile::emptyInstance("ContextMenuInstance");
            }
   		}

   		function GetContextLocalization(&$item, $mode, $package){
             $l=$this->Page->Kernel->Language;
             $caption=$confirm="";
             if ($item["CAPTION_".strtoupper($l)]!="") $caption=$item["CAPTION_".strtoupper($l)];
             if ($item["CONFIRM_".strtoupper($l)]!="") $confirm=$item["CONFIRM_".strtoupper($l)];
             return array($caption, $confirm);
   		}

   		function CheckAccess($roles, $pageMode){
            return $this->Page->Auth->isRoleExists($roles, $pageMode);
   		}

   		/**
		* Method sets initial data for control
		*  @param 	array	$data	Array with initial data
		*  @access public
		*/
		function XmlControlOnRender(&$xmlWriter) {
            if ($this->user_id>0){
				ConfigMenuControl::RenderPackagesMenu($this->Page->Kernel, $this->Menu, $this->Page->Auth, $xmlWriter, "Backend");
                if (!empty($this->Languages)){
					$xmlWriter->WriteStartElement("languages");
			        for ($i=0;$i<sizeof($this->Languages);$i++)   {
			            $xmlWriter->WriteStartElement("language");
			            $xmlWriter->WriteElementString("prefix",$this->Languages[$i]);
			            $xmlWriter->WriteElementString("shortname",$this->LangShortNames[$i]);
			            $xmlWriter->WriteElementString("longname",$this->LangLongNames[$i]);
			            $xmlWriter->WriteEndElement();
			        }
			        $xmlWriter->WriteEndElement();
		        }


				$xmlWriter->WriteElementString("context_mode", $this->Mode);
				$xmlWriter->WriteElementString("context_url", $this->ContextPackageUrl);
	            if (is_array($this->ContextMenu)){
	            	$xmlWriter->WriteStartElement("contextmenu");
					foreach ($this->ContextMenu as $mode=>$items){
	                    if (is_array($items)){
	                    	foreach ($items as $item => $menu){
		                        $xmlWriter->WriteStartElement("menu");
		                        $xmlWriter->WriteAttributeString("mode", $mode);
		                        $xmlWriter->WriteAttributeString("item_id", $item);

		                        $prev_type="";
		                        $c=0;

		                        if (is_array($menu)){
		                        	foreach($menu as $menu_item){


			                        	$BrakeSeparator=false;
		                        		$ItemType=$menu_item["type"];
		                                   $c++;
		                        		if ($ItemType=="separator")
		                        			if ($prev_type=="" || $prev_type=="separator" || count($menu)==$c)
		                        				$BrakeSeparator=true;
		                        		$prev_type=$ItemType;

	                                    if (!($ItemType=="separator" && $BrakeSeparator)){
		                                    $xmlWriter->WriteStartElement("item");
		                                    $xmlWriter->WriteElementString("url", $menu_item["url"]);
		                                    $xmlWriter->WriteElementString("mode", $menu_item["mode"]);
		                                    $xmlWriter->WriteElementString("type", $menu_item["type"]);
		                                    $xmlWriter->WriteElementString("caption", $menu_item["caption"]);
		                                    if ($menu_item["confirm"]!="")
		                                        $xmlWriter->WriteElementString("confirm", $menu_item["confirm"]);
		                                    if ($menu_item["icon_url"]!="")
		                                        $xmlWriter->WriteElementString("icon_url", $menu_item["icon_url"]);
		                                    if ($menu_item["icon_class"]!="")
		                                        $xmlWriter->WriteElementString("icon_class", $menu_item["icon_class"]);
		                                    if (!empty($menu_item["params"])){
			                                    $xmlWriter->WriteStartElement("params");
			                                    foreach($menu_item["params"] as $key=>$val){
			                                    	 $xmlWriter->WriteStartElement("param");
			                                    	 $xmlWriter->WriteAttributeString("key", $key);
			                                    	 $xmlWriter->WriteString($val);
			                                    	 $xmlWriter->WriteEndElement("param");
			                                    }
			                                    $xmlWriter->WriteEndElement("params");
		                                    }
		                                    $xmlWriter->WriteEndElement("item");
	                                    }
		                        	}
		                        }
		                        $xmlWriter->WriteEndElement("menu");
	                        }
	                    }
					}
					$xmlWriter->WriteEndElement("contextmenu");
				}
			}

			parent::XmlControlOnRender($xmlWriter);
   		}

        function GetLanguages(){
        	$Settings=$this->Page->Kernel->Settings;
        	$MultiLanguage=$Settings->GetItem("DEFAULT", "MultiLanguage");

            if ($MultiLanguage==1){
		        $this->Languages = $Settings->GetItem("language", "_Language");
		        if (!is_array($this->Languages)){
		            $this->Languages = array($this->Languages);
		     	}

		        $this->LangShortNames = $Settings->GetItem("language", "_LangShortName");
		        if (! is_array($this->LangShortNames)){
		            $this->LangShortNames = array($this->LangShortNames);
		     	}

		        $this->LangLongNames = $Settings->GetItem("language", "_LangLongName");
		        if (! is_array($this->LangLongNames)){
		            $this->LangLongNames = array($this->LangLongNames);
		     	}
	     	}
        }
 }// class
?>