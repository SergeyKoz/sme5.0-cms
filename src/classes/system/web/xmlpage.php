<?php
$this->ImportClass("system.web.page", "ControlPage");
$this->ImportClass("system.web.pagehelper", "PageHelper");
$this->ImportClass("system.data.datamanipulator","datamanipulator");
$this->ImportClass("system.xml.xmlwriter", "SMEXmlWriter");
/** Class represents single xml-based web page
   * @author Sergey Grishko <sgrishko@reaktivate.com>
   * @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.1
   * @package   Framework
   * @subpackage classes.system.web
   * @access public
   **/
class XmlPage extends ControlPage {
    // Class information
    var $ClassName = "XmlPage";
    var $Version = "2.0";

    var $XmlTag;

    var $XslTemplate = "";

    var $PageType = "default";
    /**
          * Page URL without query string and language version
          * @var    string $PageURI
          **/
    var $PageURI ="";

    /**
          * Query string
          * @var  string $QueryString
          **/
    var $QueryString="";
    /**
          * Request URI
          * @var  string $RequestURI
          **/
    var $RequestURI="";
    /**
          * Frontend menu ini filename
          * @var  string $MenuFile
          **/
    var $MenuFile="menu.ini.php";
    /**
          * Render menu always flag
          * @var  boolean $MenuRoot
          **/
    var $MenuRoot=false;
    /**
          * Render menu as one level menu flag
          * @var  boolean $MenuOneLevel
          **/
    var $MenuOneLevel=false;

    /**
          * Array of extra templates to include in main xsl file
          * @var  array $include_extra_templates
        **/
    var $ExtraIncludesArray=array();
    var $ScriptsIncludesArray=array();
    var $LinksIncludesArray=array();

    /** Constructor. Makes initialization
            * @param   string   $name   name of control
            * @param   string   $xmlTag  Name of XML tag
            * @param   string   $xslTemplate   Name of xsl-template
            * @access  public
            **/
    function XmlPage($name, $xmlTag, $xslTemplate) {
        ControlPage::ControlPage($name);
        $this->XmlTag = $xmlTag;
        if (strlen($this->XslTemplate)==0)
        $this->XslTemplate = $xslTemplate;
    }

    /**
      * Method render "page" node of this object
      * @param  XmlWriter $xmlWriter    Instance ow xmlWriter
      * @access private
      * @abstract
      **/
    function RenderObjectNode(&$xmlWriter)  {
    }

    function CreateChildControls(){
    	parent::CreateChildControls();
    }

    /**
        * Method render menu nodes using PageURI and menu.ini.php file
      * @access private
      **/
    function RenderMenuNode(&$xmlWriter)    {
    }


    /**
      * Method render title node
      * @access private
      **/
    function RenderTitleNode(&$xmlWriter)   {
        $titles = DataDispatcher::Get("page_titles");
        if (is_array($titles))
        {
            $titles = array_reverse($titles);
        }
        XmlHelper::DrawArray($xmlWriter, $titles, "titles", "title");
    }


    /**
      * Method render additional system nodes
      * @param    object $xmlWriter    Instance ow xmlWriter
      * @access private
      **/
    function RenderAdditionalNodes($xmlWriter)  {
        //write languages
        $xmlWriter->WriteStartElement("languages");
        for ($i=0;$i<sizeof($this->Kernel->Languages);$i++)   {
            $xmlWriter->WriteStartElement("language");
            $xmlWriter->WriteElementString("prefix",$this->Kernel->Languages[$i]);
            $xmlWriter->WriteElementString("shortname",$this->Kernel->LangShortNames[$i]);
            $xmlWriter->WriteElementString("longname",$this->Kernel->LangLongNames[$i]);
            $xmlWriter->WriteEndElement();
        }
        $xmlWriter->WriteEndElement();
        //write additional page settings
        if($this->Kernel->Package->Settings->HasSection("settings")){
            $this->Kernel->Settings->mergeSection($this->Kernel->Package->Settings->Sections["settings"],"settings","a+");
        }

        if (sizeof($this->Kernel->Settings->Sections["settings"])!=0)   {
            $xmlWriter->WriteStartElement("settings");
            foreach ($this->Kernel->Settings->Sections["settings"] as $node =>  $value)
            $xmlWriter->WriteElementString(strtolower($node),$value);
            $xmlWriter->WriteEndElement();
        }
        $this->RenderTitleNode($xmlWriter);
    }

    /**
      * Method render "http" node
      * @param  object $xmlWriter  Instance ow xmlWriter
      * @access private
      **/
    function RenderHTTPNode(&$xmlWriter)    {

        $_http_vars=array("POST"    =>  $_POST,
        "GET"     =>  $_GET,
        "FILES"   =>  $_FILES,
        "SESSION" =>  $_SESSION
        );
        //render HTTP request
        $xmlWriter->WriteStartElement("http");
        foreach ($_http_vars as $_varname => $_vars)  {
            if (count($_vars))  {
                $xmlWriter->WriteStartElement("row");
                $xmlWriter->WriteAttributeString("name",$_varname);
                foreach  ($_vars as $_name => $_value){
                    if (preg_match("/^\w+?$/", $_name,$m))   {
                        $xmlWriter->WriteStartElement($_name);
                        $xmlWriter->WriteElementString("name",$_name);
                        if (!is_array($_value))   {
                            $xmlWriter->WriteElementString("value",(is_array($_value) ? pr($_value):$_value));
                        }    else    {
                            foreach ($_value as $i=>$_valitem)  {
                                $xmlWriter->WriteStartElement("value");
                                $xmlWriter->WriteAttributeString("name",$i);
                                $xmlWriter->WriteString($_valitem);
                                $xmlWriter->WriteEndElement();
                            }
                        }
                        $xmlWriter->WriteEndElement();
                    }
                }
                $xmlWriter->WriteEndElement();
            }
        }
        $xmlWriter->WriteEndElement();
    }

    /**
        * Method render localization xml-data
      * @param  XmlWriter   $xmlWriter      xmlWriter object
      * @access private
      **/
    function RenderLocalization(&$xmlWriter)    {
        //Get localization messages
        $xmlWriter->WriteStartElement("localization");
        //write page localization settings
        $this->RenderPageLocalization($xmlWriter);
        //write main localization settings
        $_mainSection=$this->Kernel->Localization->GetSection("main");
        if (count($_mainSection) && $_mainSection !== false) {
            foreach($_mainSection as $_messageName=>$_messageVal)
            if (strlen(trim($_messageName))!=0) {
                if (!is_array($_messageVal))  {
                    $xmlWriter->WriteStartElement($_messageName);
                    $xmlWriter->WriteAttributeString("section", "main");
                    $xmlWriter->WriteString($_messageVal);
                    $xmlWriter->WriteEndElement();
                }  else  {
                    $count = count($_messageVal);
                    for ($i=0;$i < $count;$i++)  {
                        $xmlWriter->WriteStartElement($_messageName);
                        $xmlWriter->WriteAttributeString("section", "main");
                        $xmlWriter->WriteString($_messageVal[$i]);
                        $xmlWriter->WriteEndElement();
                    }
                }
            }
        }
        $xmlWriter->WriteEndElement();
    }
    /** Method renders controls to web-page
        * @param   string   $xmlWriter   Instance ow xmlWriter
        * @access  public
        */
    function renderXmlInternal(&$xmlWriter) {

        $xmlWriter->WriteStartDocument();

        //--render page node
        $this->RenderObjectNode($xmlWriter);

        //--render package node
        $this->Kernel->Package->RenderObjectNode($xmlWriter);

        //-- render additional system nodes
        $this->RenderAdditionalNodes($xmlWriter);

        //-- render content
        $xmlWriter->WriteStartElement($this->XmlTag);
        $this->XmlControlOnRender($xmlWriter);

        //--render XML for all childs controls
        if ($this->HasControls()) {
            foreach($this->Controls as $control) {
                if (method_exists($control, "renderXmlInternal"))       $control->renderXmlInternal($xmlWriter);
            }
        }

        $this->RenderScripts($xmlWriter);

        //render localization
        $this->RenderLocalization($xmlWriter);

        //render messages nodes
        $this->RenderMessages($xmlWriter);

        //render debug
        $this->RenderHTTPNode($xmlWriter);

        //render menu
        $this->RenderMenuNode($xmlWriter);

        //render page information
        if ($this->Kernel->ShowDebug)     {
            $this->Kernel->Debug->page_info=array(
            "class"               =>  $this->ClassName,
            "version"           =>    $this->Version,
            "template_name"   =>      $this->XslTemplate,
            "template_path"   =>      $xmlWriter -> XSLTemplate,
            "package"           =>    $this->Kernel->Package->PackageName,
            "lib"                 =>  (is_array($this->library_ID)? @array_pop($this->library_ID): $this->library_ID)
            );
            $this->Kernel->Debug->Render($xmlWriter,$this->Kernel);

        }

        //-- render page title
        $xmlWriter->WriteEndDocument();

    }

    /**
        * Method render messages nodes
      * @access private
      **/
    function RenderMessages(&$xmlWriter)    {
        $errortypes_arr=array(
        "error-messages"        => "GetErrorMessages",
        "warning-messages"  =>    "GetWarningMessages"
        );
        foreach($errortypes_arr  as $type    => $method) {
            //Get error messages from Error class
            @$messages = $this->$method();

            if (count($messages)) {
                $xmlWriter->WriteStartElement($type);
                foreach ($messages as $sectionName => $sectionErrors) {
                    foreach ($sectionErrors as $message) {
                        $xmlWriter->WriteStartElement("message");
                        $xmlWriter->WriteAttributeString("section", $sectionName);
                        $xmlWriter->WriteString($message);
                        $xmlWriter->WriteEndElement();
                    }
                }
                $xmlWriter->WriteEndElement();
            }
        }
    }

    /**
        * Method render page localization nodes
      * @param  xmlWriter       $xmlWriter      xmlWriter object
      * @access private
      **/
    function RenderPageLocalization(&$xmlWriter)    {
        //write page localization settings
        if ($this->Kernel->Localization->HasSection($this->ClassName))
        $_curPageSection=$this->Kernel->Localization->GetSection($this->ClassName);
        //write page localization settings
        if (($_curPageSection !== false) && sizeof($_curPageSection)) {
            foreach($_curPageSection as $_messageName=>$_messageVal)
            if (strlen(trim($_messageName))!=0) {
                if (!is_array($_messageVal))    {
                    $xmlWriter->WriteStartElement($_messageName);
                    $xmlWriter->WriteAttributeString("section", $this->ClassName);
                    $xmlWriter->WriteString($_messageVal);
                    $xmlWriter->WriteEndElement();
                }   else    {
                    for ($i=0;$i<sizeof($_messageVal);$i++)   {
                        $xmlWriter->WriteElementString($_messageName,$_messageVal[$i]);
                    }
                }
            }
        }
    }

    /**
        *  Method executes some actions on controlrender event
        * @param   string   $xmlWriter   Instance ow xmlWriter
    * @abstract
        * @access   public
        */
    function XmlControlOnRender(&$xmlWriter) {
        $this->safeMethodCall("on{$this->Event}XmlRender", array(&$xmlWriter));
    }

    /**
        *  Method adds extra templates to include in main xsl template
        * @param    string   $template      relative path from templates root to specified template
        * @access  public
        ***/
    function IncludeTemplate($template){
        if(!in_array($template, $this->ExtraIncludesArray)){
            $this->ExtraIncludesArray[] = $template;
        }
    }

    function IncludeScript($script, $module="", $extension=".js", $type="text/javascript"){
        if(!is_array($this->ScriptsIncludesArray[$script]))
            $this->ScriptsIncludesArray[$script] = array("script"=>$script, "extension"=>$extension, "type"=>$type, "module"=>$module);
    }

    function IncludeLink($document, $module="", $extension=".css", $rel="stylesheet", $type="text/css", $media=""){
        if(!is_array($this->LinksIncludesArray[$document]))
            $this->LinksIncludesArray[] = array("document"=>$document, "extension"=>$extension, "type"=>$type, "rel"=>$rel, "media"=>$media, "module"=>$module);
    }


    /**
       * Method returns an array with xslt processor settings
       * @return    array   Array with processor settings
       * @access    public
       **/
    function getRenderer(){
        $__tmp = array();
        if($this->Kernel->Settings->HasItem("XSLT_PROCESSOR", "OMIT_HTML_DECLARATION")){
            $__tmp["omit_html_declaration"] = $this->Kernel->Settings->GetItem("XSLT_PROCESSOR", "OMIT_HTML_DECLARATION");
        }
        return $__tmp;
    }


    /**
      * @param  xmlWriter    $xmlWriter    xmlWriter object
      * @access   public
       **/
    function Render() {
        $renderer = $this->GetRenderer();
        $xmlWriter = new SMEXmlWriter(	$this->Kernel->TemplateDirs,
        								$this->Kernel->Language, $renderer,
        								$this->Kernel->TemplateExt);

        $this->renderXmlInternal($xmlWriter);

        $xmlWriter->getXSLT($this->XslTemplate,$this->Kernel->Debug);
        $xmlWriter->AddExtraIncludes($this->ExtraIncludesArray, $this->Kernel->Debug);

        //write XML-content to file
        if($this->Kernel->WriteLogs)  {
            $this->Kernel->Debug->ToFile("page.xml",$xmlWriter->Stream);
            $this->Kernel->Debug->ToFile("page.xsl",$xmlWriter->XSLT);
        }

        if ($this->Request->ToNumber("xml", 0, 0, 1) == 1) {
        	header("Content-type:text/xml; charset=".$xmlWriter->Encoding);
            echo($xmlWriter->Stream);
           die();
        } else {
	        $start_time = microtime();
	        $xhtml = $xmlWriter->ProcessXSLT();
	        $end_time = microtime();


	        $xhtml = trim(str_replace("&amp;", "&", $xhtml));

	        //-- Show processing info
	        if (!$xhtml) {
	            $this->ShowXSLTResultInfo(false,$start_time,$end_time, $xhtml);
	        } else  {
	            $this->ShowXSLTResultInfo(true,$start_time,$end_time, $xhtml);
		        //--show XHTML
                $compression=false;
		        if ($this->Kernel->Settings->HasItem("MAIN", "gzCompressionEnable") &&
		        	$this->Kernel->Settings->HasItem("MAIN", "gzCompressionLevel") &&
		        	strpos($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")!==false)
		   			if ($this->Kernel->Settings->GetItem("MAIN", "gzCompressionEnable")==1){
                        $compressionLevel=$this->Kernel->Settings->GetItem("MAIN", "gzCompressionLevel");
                        if ($compressionLevel>0 && $compressionLevel<=9) $compression=true;
        			}

	            if ($compression){
	            	$start_time = microtime();
	            	$xhtml=gzencode($xhtml, $compressionLevel);
	            	$end_time = microtime();
	            	header("Content-Encoding: gzip");
	            	header("Content-Length: ".strlen($xhtml));
	            }else{
	                header("Content-type:text/html; charset=".$xmlWriter->Encoding);
	            }
	            echo($xhtml);
	        }
        }
    }

    /**
    *  Method Show XSL transformation result information
    *  @param   boolean   $result       Result status
    *  @param   string    $start_time   Start time of processing
    *  @param   string    $end_time     End time of processing
    *  @access  private
    **/
    function ShowXSLTResultInfo($result, $start_time, $end_time, &$xhtml) {
        if (!$result)  {
            echo "
     <style>
    a:hover{
      color:FF0000;
      font-size:13px;
      text-decoration:underline;

    }
    a{
      color:900000;
      text-decoration:none;
      font-size:13px;
    }

     </style>
     <br><br>";
            echo "<a href='".$this->Kernel->Debug->DebugURL."page.xml' target='_blank' class='error'><b>XML content</b></a><br>";
            echo "<a href='".$this->Kernel->Debug->DebugURL."page.xsl' target='_blank' class='error'><b>XSL content</b></a><br>";

            echo "<br><h3>GET & POST Debug info: </h3>";
            echo "Page: ".$this->ClassName."<br>Event: ".$this->Event."<br>";
            echo "<b>_GET</b><BR>";
            echo pr($_GET);
            echo "<b>_POST</b><BR>";
            echo pr($_POST);
            echo "<b>_SESSION</b><BR>";
            echo pr($_SESSION);
        }  else  {
            if(!$this->Kernel->ShowDebug){
                //$xhtml.="<!-- XSLT processing time: ".$this->Get_Interval($start_time, $end_time)." sec -->\n";
            }  else  {
                //render debug info
                $xhtml.="<br>XSLT processing time: <b>".$this->Get_Interval($start_time, $end_time)."</b> sec";

                global $xml_processing_time;
                $xml_processing_time = $this->Get_Interval($start_time, $end_time);
            }
        }
    }

    /**
     * Method set template name of current page
     * @param   string  $template       Template name (warning!!! without exstensio!!!)
     * @access  public
     **/
    function setTemplate($template)   {
        $this->XslTemplate = $template;
    }

    function _hasDataInNode ($data)
    {
        if (is_array($data)) {
            foreach (array_values($data) as $item) {
                if ((bool) $item && $item !== false && $item !== 0) {
                    return true;
                }
            }
        } else {
            if (! is_null($data)) {
                return true;
            }
        }
        return false;
    }

    function renderDataToXml (&$xmlWriter, $data, $skipEmpty = true, $trim = true)
    {
        foreach ((array) $data as $name => $value) {
            if (is_numeric($name)) {
                $name = 'item';
            }
            if (is_array($value)) {
                if (! $this->_hasDataInNode($value) && $skipEmpty) {
                    continue;
                }
                // move attributes to begin of array
                $attrs = array();
                foreach (array_keys($value) as $index) {

                    if ($index{0} == '@') {
                        $attrs[$index] = &$value[$index];
                        unset($value[$index]);
                    }
                }
                $value = $attrs + $value;
                unset($attrs);

                $xmlWriter->WriteStartElement($name);
                $this->renderDataToXml($xmlWriter, $value, $skipEmpty, $trim);
                $xmlWriter->WriteEndElement();
            } else {
                if ($trim) {
                    $value = trim($value);
                }
                if ($value != '' || !$skipEmpty) {
                    if ($name == '') {
                        $xmlWriter->WriteString($value);
                    }
                    elseif (substr($name, 0, 1) == '@') {
                        $xmlWriter->WriteAttributeString(substr($name, 1), $value);
                    } else {
                        $xmlWriter->WriteElementString($name, $value);
                    }

                }
            }
        }
    }

    function RenderScripts(&$xmlWriter){
    	if (!empty($this->ScriptsIncludesArray)){
    		$settings=$this->Kernel->Settings->GetSection("MODULE");
            $pairs=array(	array("url"=>"SiteURL", "path"=>"SitePath", "modules"=>0),
				            array("url"=>"ModuleURL", "path"=>"ModulePath", "modules"=>1),
				            array("url"=>"FrameworkURL", "path"=>"FrameworkPath", "modules"=>1));

			foreach($pairs as $i=>$pair)
                $pairs[$i]=array("url"=>$settings[$pair["url"]], "path"=>$settings[$pair["path"]], "modules"=>$pair["modules"]);

            // render scripts
     		$scripts=array();
            foreach($this->ScriptsIncludesArray as $item){
            	if (substr($item["script"],0 , 7)=="http://"){
                    $scripts[]=array("src"=>$item["script"], "type"=>$item["type"]);
            	} else{
	                $script=str_replace(".", "/", $item["script"]);
	                foreach($pairs as $pair){
	                	if ($item["module"]!="" && $pair["modules"]==1){
	                		if (file_exists($pair["path"]."packages/".$item["module"]."/".$script.$item["extension"])){
		                		$scripts[]=array("src"=>$pair["url"]."packages/".$item["module"]."/".$script.$item["extension"], "type"=>$item["type"]);
		                		break;
		                	}
	                	}
	                	if (file_exists($pair["path"].$script.$item["extension"])){
	                		$scripts[]=array("src"=>$pair["url"].$script.$item["extension"], "type"=>$item["type"]);
	                		break;
	                	}
	                }
                }
            }
            if (!empty($scripts)){
	            $xmlWriter->WriteStartElement("scripts");
	            foreach($scripts as $script){
					$xmlWriter->WriteStartElement("script");
					$xmlWriter->WriteAttributeString("type", $script["type"]);
					$xmlWriter->WriteString($script["src"]);
					$xmlWriter->WriteEndElement("script");
	            }
	            $xmlWriter->WriteEndElement("scripts");
            }

            // render links
            $links=array();
            foreach($this->LinksIncludesArray as $item){
            	if (substr($item["document"],0 , 7)=="http://"){
                    $links[]=array("href"=>$item["document"], "type"=>$item["type"], "rel"=>$item["rel"], "media"=>$item["media"]);
            	} else{
	                $document=str_replace(".", "/", $item["document"]);
	                foreach($pairs as $pair){
	                	if ($item["module"]!="" && $pair["modules"]==1){
	                		if (file_exists($pair["path"]."packages/".$item["module"]."/".$document.$item["extension"])){
		                		$links[]=array("href"=>$pair["url"]."packages/".$item["module"]."/".$document.$item["extension"], "type"=>$item["type"], "rel"=>$item["rel"], "media"=>$item["media"]);
		                		break;
		                	}
	                	}
	                	if (file_exists($pair["path"].$document.$item["extension"])){
	                		$links[]=array("href"=>$pair["url"].$document.$item["extension"], "type"=>$item["type"], "rel"=>$item["rel"], "media"=>$item["media"]);
	                		break;
	                	}
	                }
                }
            }
            if (!empty($links)){
	            $xmlWriter->WriteStartElement("links");
	            foreach($links as $link){
					$xmlWriter->WriteStartElement("link");
					$xmlWriter->WriteAttributeString("type", $link["type"]);
					if ($link["rel"]!="")
						$xmlWriter->WriteAttributeString("rel", $link["rel"]);
					if ($link["media"]!="")
						$xmlWriter->WriteAttributeString("media", $link["media"]);
					$xmlWriter->WriteString($link["href"]);
					$xmlWriter->WriteEndElement("link");
	            }
	            $xmlWriter->WriteEndElement("links");
            }
    	}
    }
    //end of class
}
