<?php
 Kernel::ImportClass("project", "ProjectPage");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class ContextActionPage extends ProjectPage {
        var $ClassName = "ContextActionPage";
        var $Version = "1.0";
        var $ActionResult="";
        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            $actionpackage=$this->Request->Value("actionpackage");
            $mode=$this->Request->Value("mode");

            if ($this->Event!="" && $actionpackage!="" && $mode!=""){
                $HelperClassName=ucfirst($actionpackage)."ContextHelper";
            	$this->Kernel->ImportClass(strtolower($HelperClassName), $HelperClassName, $actionpackage);
            	$contextHelper = new $HelperClassName;

                $mode=explode(".", $mode);
            	$contextSettings = Engine::getLibrary($this->Page->Kernel, $mode[0].".context", "ContextMenuInstance", true, $actionpackage);
	            $commands=$contextSettings->GetItem("MAIN", "COMMANDS_COUNT");

	            for ($i=0; $i<$commands; $i++){
	            	if ($contextSettings->GetItem("COMMAND_".$i, "NAME")==$mode[1]){
		            	$granted=false;
	              		if ($contextSettings->HasItem("COMMAND_".$i, "ACCESS")){
	              			$roles=$contextSettings->GetItem("COMMAND_".$i, "ACCESS");
	              			if ($this->CheckAccess($roles, "Frontend") || $this->CheckAccess($roles, "Backend"))
	              				$granted=true;
	              		}else{
	              			$granted=true;
	              		}

	              		$package=true;
	              		if ($contextSettings->HasItem("COMMAND_".$i, "PACKAGE")){
                 			$package=$contextSettings->GetItem("COMMAND_".$i, "PACKAGE");
                 			$package=Engine::isPackageExists($this->Page->Kernel, $package);
	              		}

	             		if ($granted && $package){
		             		$event="On".$this->Event;
	            			$this->ActionResult=$contextHelper->$event($this);
	             		}
		            }
	            }
                ConfigFile::emptyInstance("ContextMenuInstance");
            }
            parent::ControlOnLoad();
        }

        function XmlControlOnRender(&$xmlWriter){
        	die($this->ActionResult);
        	//$xmlWriter->WriteElementString("actionresult", $this->ActionResult);
        	parent::XmlControlOnRender($xmlWriter);
        }

        function CheckAccess($roles, $pageMode){
            return $this->Page->Auth->isRoleExists($roles, $pageMode);
   		}

   		function SetMessages($messages){
			return "['".implode("', '", $messages)."']";
		}

} // class

?>