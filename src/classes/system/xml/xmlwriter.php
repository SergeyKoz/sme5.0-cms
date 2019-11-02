<?php
/** @const XML_WRITER_ENCODING_DEFAULT XML WRITER ENCODING DEFAULT value **/
define("XML_WRITER_ENCODING_DEFAULT", "windows-1251");

/** Class represents single web page writer
 * @author Sergey Grishko <sgrishko@reaktivate.com>
 * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.system.xml
 * @access public
 **/
class SMEXmlWriter {

    // Class information
    var $className = "SMEXmlWriter";
    var $version = "1.0";

    /** Public. current encoding
     * @var  string $Encoding
     **/
    var $Encoding;

    var $xw=null;

    /**
     * Public. stream with xml data
     * @var  string  $Strean
     **/
    var $Stream;

    /**
     * Templates directories array
     * @var  array $TemplateDirs
     **/
    var $TemplateDirs = array();

    /**
     * XSLT data array
     * @var  array $XSLT
     **/
    var $XSLT = array();

    /**
     * XSL template name
     * @var  string $XSLTemplate
     **/
    var $XSLTemplate = "";

    /**
     * XSL transformation renderer info array
     * @var array $renderer
     **/
    var $renderer = array();

    var $TemplatesHash;

    /** Constructor. Creates new XmlWriter with default or specified encoding
     * @param     array     $TemplateDirs  Template directories array
     * @param     string    $Language      Current language prefix
     * @param     string    $TemplateExt   Template extension
     * @param     string    $encoding      Encoding-specification (utf-8, windows-1251, koi8-r...)
     * @access    public
     **/
    function SMEXmlWriter($TemplateDirs, $Language, $renderer = array(), $TemplateExt = ".xsl",
        $encoding = XML_WRITER_ENCODING_DEFAULT){
        $this->Encoding = $encoding;
        $this->TemplateDirs = $TemplateDirs;
        $this->Language = $Language;
        $this->TemplateExt = $TemplateExt;

        $this->xw = new XmlWriter();
        $this->xw->openMemory();
		$this->xw->setIndent(true);

        //$this->renderer = $renderer;
    }

    /** Closes this stream and the underlying stream.
     *  @access   public  (prototype)
     */
    function Close(){
    }

    /** Writes an attribute with the specified value.
     * @param    string   $name   Name of the attribute
     * @param    string   $value  Value ot the attribute
     * @access   public
     */
    function WriteAttributeString($name, $value){
    	$this->xw->writeAttribute($name, SMEXmlWriter::utf8($value));
    }

    /** Writes out a <![CDATA[...]]> block containing the specified text.
     * @param     string   $text   Text to write in
     * @access    public
     */
    function WriteCData($text){
    	$this->xw->writeCData(SMEXmlWriter::utf8($text));
    }

    function getXSLT($fname, &$Debug, $Language = ""){
        $xslt = Path::buildPathString($fname, $this->TemplateDirs, $this->TemplateExt, $Language);

        $this->TemplatesHash=md5(implode($this->TemplateDirs));

        //set path for xsl-include nodes
        $this->Debug = &$Debug;
        $this->XSLT = preg_replace_callback("/<xsl:include\s*href=\"([^\"]*)\"\s*\/>/", array(
            $this, "replaceTemplatePath"
        ), file_get_contents($xslt));
    }

    /**
     * Method adds extra includes in main XSL template
     * @param  array     $includes_array     Array with includes
     * @access   public
     **/
    function AddExtraIncludes($includes_array, &$Debug){
        if (! empty($includes_array)) {
            $_includes = array();
            foreach ($includes_array as $include_path) {
                if (! file_exists($include_path)) { //if path is not absolute
                    $__len = strlen(strrchr($include_path, "."));
                    if ($__len) {
                        $include_path = substr($include_path, 0, (- 1) * $__len);
                    }

                    $__xslt = Path::buildPathString($include_path, $this->TemplateDirs, $this->TemplateExt, $Language);

                    if (! file_exists($__xslt)) {
                        die("Can't find XSL template: " . $__xslt);
                    }
                    else {
                        $Debug->AddDebugItem("templates", array(
                            "name" => "<i>" . $include_path . $this->TemplateExt . "</i>",
                            "description" => $__xslt,
                            "error" => "OK"
                        ));
                        $converted_include_path = $this->ConvertPath($__xslt);
                        if (false === strpos($this->XSLT, $converted_include_path)) {
                            $_includes[] = "<xsl:include href=\"" . $converted_include_path . "\" />";
                        }

                    }
                }
                else { // if path is absolute
                    $converted_include_path = $this->ConvertPath($include_path);
                    if (false === strpos($this->XSLT, $converted_include_path)) {
                        $_includes[] = "<xsl:include href=\"" . $converted_include_path . "\" />";
                    }
                }
            }
            $include_str = "\n\n<!-- ADDED BY ENGINE IN " . __FILE__ . " AT LINE " . __LINE__ . "-->\n\n" . implode("\n", $_includes) . "\n\n<!-- /ADDED BY ENGINE IN " . __FILE__ . " AT LINE " . __LINE__ . "-->\n\n";

            $insertPos = strpos($this->XSLT, '<xsl:template');
            //$insertPos = false;
            if (false === $insertPos) {
                $insertPos = strpos($this->XSLT, '<xsl:include');
            }
            if (false === $insertPos) {
                $insertPos = strpos($this->XSLT, '</xsl:stylesheet');
            }
            $this->XSLT = substr($this->XSLT, 0, $insertPos) .
                $include_str .
                substr($this->XSLT, $insertPos);
        }

    }

    /**
     * Callback method for preg replace path to template
     * Return include string of template or nothing (if not found in filesystem generate E_USER_ERROR)
     * @param      array   $matches        reg. expression search result matches
     * @return     string                  include string\
     * @acess      private
     **/
    function replaceTemplatePath($matches){


        list ($template, $ext) = preg_split("/[.]/", $matches[1]);
        if (!defined("NO_ENGINE_CACHE") || (NO_ENGINE_CACHE == 0)){
        	$include=$this->CheckCachedTemplatePaths($template);
        	if ($include!="") return $include;
    	}

        $_include = Path::buildPathString($template, $this->TemplateDirs, $this->TemplateExt, $this->Language);
        if (file_exists($_include)) {
            $is_found = true;
            $status = "OK";
        }
        else {
            $is_found = false;
            $status = "<b>Not found</b>";
            user_error("Template <b>$matches[1]</b> not  found", E_USER_ERROR);
        }
        $this->Debug->AddDebugItem("templates", array(
            "name" => $matches[1],
            "description" => $_include,
            "error" => $status
        ));

        $_include = $this->ConvertPath($_include);
        if ($is_found){
        	if ( (!defined("NO_ENGINE_CACHE") || (NO_ENGINE_CACHE == 0)))
        		$this->SaveTemplatePathData($template, $_include);
            return "<xsl:include href=\"" . $_include . "\" />";
        }
    }

    /**
     * Method returns patched path for current renderer
     * @param     string  $_path  path to patch
     * @return    string  PAtched path
     * @access    public
     **/
    function ConvertPath($_path)
    {
        //--check for local Win32 drives (like D:) in path
        if (strpos($_path, ":") !== false) {
            $_path = substr($_path, strpos($_path, ":"), strlen($_path));
        }
        else {
            $_path = htmlspecialchars($_path);
        }
        return $_path;
    }

    /** Method processes XSLT templates
     * @param     string   $xslt   Template name
     * @param     Debug      $Debug  Debug object
     * @return    string   Processed html
     * @access    public
     */
    function ProcessXSLT(){
        $xmldoc = new DOMDocument();
		$xmldoc->loadXML($this->Stream);
		$xsldoc = new DOMDocument();
		$xsldoc->loadXML($this->XSLT);

		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsldoc);
		$result=$proc->transformToXML($xmldoc);

		return $result;

    }

    /** Writes out a comment <!--...--> containing the specified text.
     * @param    string   $text   Comment text to write in
     * @access   public
     */
    function WriteComment($text){
    	$this->xw->writeComment(SMEXmlWriter::utf8($text));
    }

    /** Writes the DOCTYPE declaration with the specified name and optional attributes.
     * @param  string  $name   Name of DOCTYPE
     * @param  mixed   $pubid   Pub Id
     * @param  mixed   $sysid   Sys Id
     * @param  mixed   $subset   Subset
     * @access public
     */
    function WriteDocType($name, $pubid = null, $sysid = null, $subset = null){
    }

    /** Writes an element containing a string value.
     * @param   string   $name   Name of an element
     * @param   string   $value  Value of an element
     * @access  public
     */
  	function WriteElementString($name, $value){
        $this->xw->writeElement($name, SMEXmlWriter::utf8($value));
    }

    /** Closes the previous WriteStartAttribute call.
     * @access   public
     */
    function WriteEndAttribute(){
    	$this->xw->endAttribute();
    }

    /** Closes any open elements or attributes and puts the writer back in the Start state.
     *  @access public
     */
    function WriteEndDocument(){
        $this->xw->endDocument();
        $this->Stream = $this->xw->outputMemory(true);
        $this->xw->flush();
    }

    /** Closes one element.
     * @access public
     */
    function WriteEndElement(){
    	$this->xw->endElement();
    }

    /** Writes out an entity reference as follows: & name;.
     * @param    string   $name   Name of an entity
     * @access   public
     */
    function WriteEntityRef($name){
    }


    /** Writes the start of an attribute.
     * @param     string   $name   Name of the attribute
     * @access    public
     */
    function WriteStartAttribute($name){
    	$this->xw->startAttribute($name);
    }

    /** Writes raw markup manually from a string.
     * @param   string   $data  Raw data
     * @access  public
     */
    function WriteRaw($data){
    	$this->xw->writeRaw($data);
    }

    /** Writes the XML declaration with the version "1.0" and the standalone attribute.
     * @param    string   $standalone   Standalone attribute
     * @access   public
     */
    function WriteStartDocument($standalone = null){
    	$this->xw->startDocument('1.0', $this->Encoding);
    }

    /** Writes out a start tag with the specified local name.
     * @param   string   $name   NAme of the element
     * @access  public
     */
    function WriteStartElement($name){
    	$this->xw->startElement($name);
    }

    /** Writes the given text content.
     * @param     string    $text   Text content
     * @access    public
     */
    function WriteString($text){
    	$this->xw->text(SMEXmlWriter::utf8($text));
    }

    static function utf8($text){
    	return iconv('CP1251', 'UTF-8', (string)$text);
    }

    function CheckCachedTemplatePaths($template){
    	$res="";

    	if (DataDispatcher::isExists('CachedTemplatesPathsData')){
    		$CachedTemplatesPathes=DataDispatcher::get('CachedTemplatesPathsData');
    	}else{
    		$file_name = CACHE_ROOT.'engine/template_pathes';
    		if (is_readable($file_name)){
    			$CachedTemplatesPathes=unserialize_file($file_name);
	   		}else
                $CachedTemplatesPathes=array();
    		DataDispatcher::set('CachedTemplatesPathsData', $CachedTemplatesPathes);
    		DataDispatcher::set('CachedTemplatesHash', $CachedTemplatesPathes);
    	}
    	$hash=$template.'|'.$this->Language.'|'.$this->TemplatesHash;
    	if ($CachedTemplatesPathes[$hash]!="")
    		$res=$CachedTemplatesPathes[$hash];

        return $res;
    }

    function SaveTemplatePathData($template, $path){
        if (DataDispatcher::isExists('CachedTemplatesPathsData')){
    		$CachedTemplatesPathes=DataDispatcher::get('CachedTemplatesPathsData');
    		$hash=$template.'|'.$this->Language.'|'.$this->TemplatesHash;
    		if (!($CachedTemplatesPathes[$hash]!='')){
    			$CachedTemplatesPathes[$hash]='<xsl:include href=\''.$path.'\' />';
    			$file_name = CACHE_ROOT.'engine/template_pathes';
    			DataDispatcher::set('CachedTemplatesPathsData', $CachedClasses);
    			if (is_writable($file_name) || !file_exists($file_name))
    				serialize_data($file_name, $CachedTemplatesPathes);
    		}
    	}
    }
}
?>