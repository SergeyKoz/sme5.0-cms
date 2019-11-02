<?php
  $this->ImportClass('system.web.xmlpage', 'XmlPage');
  $this->ImportClass('system.data.datafactory', 'DataFactory');
  $this->ImportClass('module.web.authentication.authenticationfactory', 'AuthenticationFactory');
 /**
   * Base class for all module pages.
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 2.0
   * @package Framework
   * @subpackage classes.module.web
   * @access public
   **/
 class ModulePage extends XmlPage {

  /**
    * Class name
    * @var    string  $ClassName
    **/
    var $ClassName = 'ModulePage';

  /**
    * Class version
    * @var    string  $Version
    **/
      var $Version = '3.0';

   /**
     * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
     * @var string    $PageMode
     **/
    var $PageMode='Frontend';

  /**
      * package name using in smart redirect (overwrite  current package name)
    * @var    string  $packagefrom
    **/
    var $packagefrom = '';

   /**
     * Page name using in smart redirect (overwrite  current page name)
     * @var    string  $page_uri
     **/
    var $pagefrom = '';

  /**
    * Page ID
    * @var  mixed       page ID
    **/
    var $id='';
    /**
      * Authentication object
      * @var  Authentication    $Auth
      **/
    var $Auth = null;

    /**
      * Access user groups array
      * @var  array    $access_id
      **/
    var $access_id = array();

    /**
      * Access users array
      * @var  array    $access_user_id
      **/
    var $access_user_id = array();

    /**
      * Access roles array
      * @var  array    $access_role_id
      **/
    var $access_role_id = array();



  /**
    *Class constructor
    * @param    string     name of current page
    * @param    string      name of XML Tag where content been added
    * @param    string      name of XSL template file
    * @param    int         pointer to Kernel object
    * @param    string      Cookie name
    * @access   public
    **/
     function ModulePage($name, $xmlTag, $xslTemplate,$CookieName="") {
            //-- get xslTemplate from global variables
            $template = Request::StaticValue($this, "template");
            //global $template;
            if (strlen($template) !== 0 ) $xslTemplate = $template;

            //Call parent constructor
            XmlPage::XmlPage($name, $xmlTag, $xslTemplate);
     }

     /**
       * Method add messages, defined in request url
       * @access    private
       **/
     function AddRequestMessages()  {
          $message = $this->Request->Value("MESSAGE");
          $message_data =  $this->Request->Value("MESSAGE_DATA");
          $message_section =  $this->Request->Value("MESSAGE_SECTION");
          if (!$message_section)    {
              $message_section = "MESSAGES";
          }
          if (!$message_data)   {
              $message_data = null;
          }  else   {
              $message_data = explode("|",$message_data);
          }

            if($message){
                if(!is_array($message)){
                    $message = array($message);
                }
                for($i=0; $i<sizeof($message); $i++){
                    $this->AddWarningMessage($message_section, $message[$i],$message_data);
                }  // for
            }
     }

      /**
        * Method authenticates a user
        * @access public
        **/
        function Authenticate() {
            $this->Auth->Page = &$this;
            $this->Auth->Authenticate();
        }

 /**
 *  Method draws control content
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 */
  function XmlControlOnRender(&$xmlWriter){
  	//Add request messages
  	$this->AddRequestMessages();

    xmlPage::XmlControlOnRender($xmlWriter);
  }

 /**
   * Control unload event handler
   * @access public
   **/
  function ControlOnUnload() {
    // Close session
    if($this->Kernel->useAuthentication && is_object($this->Session))   $this->Session->Close();
    // Close connection to database
    if($this->Kernel->useDB) $this->Kernel->Connection->Close();
  }


  /**
  * Function merges current localizations and errors  with specified by path
  * @param    string    $path
  * @access    public
  **/
  function MergeConfigs($path){
     $lib_ini = &ConfigFile::GetInstance("tmp", $path);
     $lib_ini->SetItem("module","ModulePath",$this->Kernel->Settings->GetItem("module", "ModulePath"));
     $lib_ini->SetItem("module","FrameworkPath",$this->Kernel->Settings->GetItem("module", "FrameworkPath"));
     $lib_ini->reParse();
     $lib_ini->reParse();
     $locale = &ConfigFile::GetInstance("localization_".$this->Kernel->Package->PackageName,$lib_ini->GetItem("Package", "ResourcePath")."localization.".$this->Kernel->Language.".php");

     if(!is_object($locale)){
        die("No Merge config found: ".$lib_ini->GetItem("Package", "ResourcePath")."localization.".$this->Kernel->Language.".php");
     }

     $errors = ConfigFile::GetInstance("errors_".$this->Kernel->Package->PackageName,$lib_ini->GetItem("Package", "ResourcePath")."errors.".$this->Kernel->Language.".php");
     $locale->MergeSections($this->Kernel->Localization);
     $this->Kernel->Localization = &$locale;
     $errors->MergeSections(ConfigFile::GetInstance("errorMessages",""));
     ConfigFile::SetInstance("errorMessages",$errors);
  }

  /**
  * Method rewrites session variables with values from Request Query, if any exists
  * @access public
  */
  function RewriteSessionVarsFromRequest(){
    if($this->Kernel->Settings->HasItem("SESSION", "REWRITE_VAR")){
     $rewrite_vars = $this->Kernel->Settings->GetItem("SESSION", "REWRITE_VAR");
     if(!is_array($rewrite_vars)){
        $rewrite_vars = array($rewrite_vars);
     }
     for($i=0; $i<sizeof($rewrite_vars); $i++){
        $value = $this->Request->Value($rewrite_vars[$i]);
        if($value != ""){
           $this->Session->Set($rewrite_vars[$i], $value);
        }
     }
   }
  }


  /**
    *  Method redirect when page not found in structure
    *  @access  private
    **/
   function redirectNotFound()  {
       $this->Response->Redirect(sprintf($this->Kernel->Settings->GetItem("AUTHORIZATION","Frontend_HREF_PageNotFound_Redirect_project"),$this->Kernel->Language));
   }


   function SmartRedirect($redirect_URI, $eval_flag=0, $query="")  {
       $this->Auth->SmartRedirect($redirect_URI, $eval_flag, $query);
   }

   /**
   * Method dinamicaly sets page title
   * @param     string    $tableClass        Table class name
   * @param     int       $id                ID of a record in Table
   * @param     string    $caption_field     Name of field with caption
   * @access    public
   **/
   function SetPageTitle($tableClass, $id, $caption_field, $defaultTitle=""){

             DataFactory::GetStorage($this, $tableClass, "storage");
             $key_columns = $this->storage->getKeyColumns();
             $_record = $this->storage->Get(array($key_columns[0]["name"]=>$id));
             if($this->Kernel->Localization->HasItem($this->ClassName, "_PageTitle")){
                        //$_pattern = $this->Kernel->Localization->GetItem($this->ClassName, "_PageTitle");
             } else {
                        $_pattern = "%s";
             }



             if(!empty($_record)){
                $this->Kernel->Localization->SetItem($this->ClassName, "_PageTitle", sprintf($_pattern, $_record[$caption_field]), true);

             } else {
                $this->Kernel->Localization->SetItem($this->ClassName, "_PageTitle", sprintf($_pattern, $defaultTitle), true);
             }

   }

    /**
      * Method render "page" node of this object
      * @param  XmlWriter $xmlWriter    Instance ow xmlWriter
      * @access private
      **/
    function RenderObjectNode(&$xmlWriter)  {
      global $HTTP_SERVER_VARS;
      $xmlWriter->WriteStartElement("page");

      $global_page_id = $this->Request->globalValue("_page_id");
      if(isset($global_page_id))
          $this->id = $global_page_id;
      if(isset($this->id)){$xmlWriter->WriteAttributeString("id", $this->id);}

      $print_version = $this->Request->ToNumber("print",0);
      if($print_version){$xmlWriter->WriteAttributeString("print", 1);}

      $context = $this->Request->ToNumber("contextframe",0);
      if($context){$xmlWriter->WriteAttributeString("contextframe", 1);}

      $xmlWriter->WriteAttributeString("name", $this->Name);
      $xmlWriter->WriteAttributeString("type", $this->PageType);
      $xmlWriter->WriteAttributeString("language", $this->Kernel->Language);
      $xmlWriter->WriteAttributeString("host", $this->Kernel->Settings->GetItem("Module","Host"));
      $xmlWriter->WriteAttributeString("url",  $this->Kernel->Settings->GetItem("Module","SiteURL"));
      $xmlWriter->WriteAttributeString("secure_url",  str_replace("http://","https://",$this->Kernel->Settings->GetItem("Module","SiteURL")));
      $xmlWriter->WriteAttributeString("sources_url",  $this->Kernel->Settings->GetItem("Module","ModuleURL"));

      if ($this->Kernel->MultiLanguage){
          $xmlWriter->WriteAttributeString("lng_url_prefix",  $this->Kernel->Language . "/");
      } else {
          $xmlWriter->WriteAttributeString("lng_url_prefix",  "");
      }
      $xmlWriter->WriteAttributeString("framework_url", $this->Kernel->Settings->GetItem("Module","FrameworkURL"));

      //generate user info
      if ($this->Kernel->useAuthentication) {
            $xmlWriter->WriteAttributeString("user_name",  $this->Auth->UserLogin);
            $xmlWriter->WriteAttributeString("user_groupid",  $this->Auth->UserGroupId);
            $xmlWriter->WriteAttributeString("user_id",  $this->Auth->UserId);
      }
      $xmlWriter->WriteAttributeString("session_id", $this->Session->SessionID());
      list($this->PageURI,$this->QueryString,$this->RequestURI) =  PageHelper::CreateRequestURI($this,
                                                                                  $this->Kernel->Settings->GetItem("module","SiteURL"),
                                                                                  $this->Kernel->Settings->GetItem("module","Host"),
                                                                                  count($this->Kernel->Languages),
                                                                                  $this->Kernel->Language
                                                                                  );
      $xmlWriter->WriteAttributeString("request_uri",$this->RequestURI);
      $xmlWriter->WriteAttributeString("request_url",$this->PageURI);
      $xmlWriter->WriteAttributeString("debug", $this->Kernel->ShowDebug);
   }


}//end of class
?>