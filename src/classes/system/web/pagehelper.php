<?php
/** Page Helper class
    * Provides routines to manipulate data for page classes
    * @author Konstantin  Matsebora <kmatsebora@activemedia.com.ua>
    * @version 1.0
    * @package  Framework
    * @access public
    * @subpackage classes.system.web
    * @static
    **/
class PageHelper  {

   /**
     * Method create request_uri attribute value for page node
     * @param     string    $url        site url
     * @param     string    $host       host name
     * @param     int       $lang_count Count of site languages
     * @param     string    $language   Current language prefix
     * @return    array                 Array(PageURI,QueryString,RequestURI)
     * @access    public
     **/
    static function CreateRequestURI(&$object, $url,$host,$lang_count,$language)  {
       //--if site have not a one language
       if ($lang_count!=1) {
        $pos=strpos($_SERVER["REQUEST_URI"],"/".$language."/");
          if ($pos!==false)  {
            $request_uri=substr($_SERVER["REQUEST_URI"],($pos+1), strlen($_SERVER["REQUEST_URI"]));
          } else {
          	if ($object->Kernel->Settings)
          		$settings=$object->Kernel->Settings;
          	elseif ($object->Page->Kernel->Settings)
          		$settings=$object->Page->Kernel->Settings;
            $request_uri=substr($_SERVER["REQUEST_URI"],(strlen($settings->GetItem('MODULE', 'RelativeURL'))+1), strlen($_SERVER["REQUEST_URI"]));
          }
       }   else  { //-- else (one language)
          $seek=strlen($url)-strlen($host);
          $request_uri=substr($_SERVER["REQUEST_URI"],$seek, strlen($_SERVER["REQUEST_URI"]));
        }

        if (substr($request_uri,0,1)=="/")  $request_uri=substr($request_uri,1, strlen($request_uri));
        if(substr($request_uri,strlen($request_uri)-1,1)=="/")  {
            $request_uri.="?";
        }
       if (strpos($request_uri,"?")===false) {
          $request_uri.="?";
       }  else {
         $darray=explode("/",$_SERVER["PHP_SELF"]);

       }
       //list($PageURI,$QueryString)=split("[?]",$request_uri);
       list($PageURI,$QueryString)=preg_split("/[?]/",$request_uri);
       return array($PageURI,$QueryString,$request_uri);
    }


}   //--end of class

?>