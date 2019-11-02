<?php

/**
  * Global functions definitions
  * @module         functions.php
  * @package        Loader
  * @subpackage     modules
  * @access         public
  * @modulegroup    Loader
  **/

/**
  * Function return variable  dump
  *  @param  mixed  $object    variable or array
  *  @return  string    dump
 **/
function vd($object)
{
   ob_start();
   var_dump($object);
   $buffer = ob_get_contents();
   ob_end_clean();
   return "<pre>".$buffer."</pre>";

}
/**
  * Function return object/array    dump
    *   @param  mixed   $object     object or array
  * @return string      dump
    **/
function pr($object)
{
   ob_start();
   print_r($object);
   $buffer = ob_get_contents();
   ob_end_clean();
   return "<pre>".$buffer."</pre>";

}

function dump($var)
{
    print "<pre>";
    var_dump($var);
    print "</pre>";
}

function prn($object)
{
    print pr($object);
}

 function handler_output($buffer)   {
    return $buffer;
 }

  /**
    * Function remove language prefix from string  (fieldname)
    * @return       string      string without language definition
    **/
 function removeLangPrefix($field,$language="")  {
        if (strlen($language)==0)   {
            return substr($field,0,strlen($field)-3);
    }       else    {
        if (substr($field,strlen($field)-3,strlen($field))=="_".$language)  {
        return  substr($field,0,strlen($field)-3);
      } else  {
        return  $field;
        }
    }
 }

/**
*  Function acts as a user-defined error-handler for running scripts
*  @param      int          $errno    Error number
*  @param      string       $errstr   Error description
*  @param      string       $errfile  Filename where an error ocurred
*  @param      int          $errline  Line number where an error ocurred
*  @access     private
**/
function ErrorLogger ($errno, $errstr, $errfile, $errline)
{
 global $Loader, $suppress_errors;
 if ($suppress_errors)
 {
     return;
 }
 $send_email = 1;
  switch ($errno) {
 case E_ERROR:
   $error_type = "E_ERROR";
   break;
 case E_WARNING:
   $error_type = "E_WARNING";
   break;
 case E_PARSE:
   $error_type = "E_PARSE";
   break;
 case E_NOTICE:
   $error_type = "E_NOTICE";
   $send_email = 0;
   break;
 case E_CORE_ERROR:
   $error_type = "E_CORE_ERROR";
   break;
 case E_CORE_WARNING :
   $error_type = "E_CORE_WARNING ";
   break;
 case E_COMPILE_ERROR :
   $error_type = "E_COMPILE_ERROR ";
   break;
 case E_COMPILE_WARNING :
   $error_type = "E_COMPILE_WARNING ";
   break;
 case E_USER_ERROR :
   $error_type = "E_USER_ERROR ";
   $error_type_message = "<font color=\"red\">Engine error</font>";
   break;
 case E_USER_WARNING:
   $error_type = "E_USER_WARNING";
   $error_type_message = "<font color=\"green\">Engine warning</font>";
   break;
 case E_USER_NOTICE:
   $error_type = "E_USER_NOTICE";
   $send_email = 0;
   $error_type_message = "<font color=\"blue\">Engine notice</font>";
   break;
 default:
   $error_type = "UNKNOWN";
   break;
 }

  if($send_email){
    global $logfile_path;
    global $email_to, $email_from, $project_url, $show_errors;
    if ($errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE) {
      $pattern = "[".date("d-m-Y H:i:s")."] ".$error_type.": <b>".$errstr."</b> in file ".$errfile." at line <b>".$errline."</b>\n";
    } else  {
      $pattern = "<b>$error_type_message: </b>".$errstr."\n";
    }
    if($show_errors){
        echo "&nbsp;".$pattern."<br>";
    }
    $fp = @fopen($logfile_path, "a");
    @chmod($logfile_path, 0777);
    if ($fp) {
      @fwrite($fp, $pattern);
      @fclose($fp);
      @chmod($logfile_path, 0777);
    }
    $pattern .= pr($Loader->Page->Kernel->Debug->Sections) . "\n\n";
    $pattern .= pr($_SERVER) . "\n\n";
    $pattern .= "\n url:\n"."http://".rawurldecode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
    if($email_to!=""){
         mail($email_to, "SITE ERROR at http://".rawurldecode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]), $pattern, "FROM: ".$email_from."\n");
    }
  }

} //--end of class

/**
* Set of profiling functions
* This function saves tagged starting time of executing some block of code
* Used in conjunction with __end() function
* Example of calling:
*                 some_func();
*                 __start();
*                 // a lot of code here
*                 __end();
*
* If called with no parameters, saves startinmg time under tag "default" in not incremental mode
*
* @param    string    $tag           Name of tag  to save starting time with
* @param    bool      $incremental   Incremental mode of accumulating starting times
* @access   public
**/
function __start($tag="default", $incremental=false){
    global $timer;
    list($__mseconds, $__seconds) = explode(" ", microtime());
    if(($incremental) || (is_array($timer[$tag]["start"]))){
        $timer[$tag]["start"][] = ((double)$__seconds + (double)$__mseconds);
    } else {
        $timer[$tag]["start"] = ((double)$__seconds + (double)$__mseconds);

    }
}


/**
* Set of profiling functions
* This function saves tagged ending time of executing some block of code
* Used in conjunction with __end() function
* Example of calling:
*                 some_func();
*                 __start();
*                 // a lot of code here
*                 __end();
*
* If called with no parameters, saves ending time under tag "default" in not incremental mode
* __start() and __end() may be called in different ways, but number of calls of __start() and __end()
* for a tag MUST be equal
* EXAMPLE of measuring of executing a part of loop in incremental mode
*    for($i=0; $i<1000; $i++){
*        calls_of_some_not_measured_functions();
*
*        _start("loop", 1);    // tags measurement with "loop" and start incremental mode
*        calls_of_measured_funcs();
*        __end("loop",0);      // saves ending time for tag "loop" with no results shown
*        calls_of_some_not_measured_functions();
*    }
*    __show("loop", 6); // shows accumulated time of executing of block of code tagged with "loop"
*    with precision of 6 digits
*
*   This example will measure total time of executing a part of a loop
*
*
* @param    string    $tag           Name of tag  to save starting time with
* @param    bool      $show_result   Show or not results
* @param    int       $precision     Precision of result to show
* @access   public
**/
function __end($tag = "default", $show_result = 1, $precision=6){
   global $timer;
   list($__mseconds, $__seconds) = explode(" ", microtime());
   if(is_array($timer[$tag]["start"])){
        $timer[$tag]["end"][] = ((double)$__seconds + (double)$__mseconds);
   } else {
        $timer[$tag]["end"] = ((double)$__seconds + (double)$__mseconds);
   }
   if($show_result){
      __show($tag, $precision);
   }
}


/**
* Function shows results of measerement of time for specified tad
* @param    string      $tag        Tag name
* @param    int         $precision  Results precision
* @access   public
**/
function __show($tag = "default", $precision=6){
   global $timer;
   if(is_array($timer[$tag]["start"])){
       $sizeof = sizeof($timer[$tag]["start"]);
       $inc = 0;
       for($i=0; $i<$sizeof; $i++){
          $inc += $timer[$tag]["end"][$i]-$timer[$tag]["start"][$i];
       }
       echo "<br>Tag = ".$tag.": <b>".number_format($inc,$precision,".","")."</b>c total<br>";
   } else {
       echo "<br>Tag = ".$tag.": <b>".number_format(($timer[$tag]["end"] - $timer[$tag]["start"]),$precision,".","")."</b>c<br>";
   }
}

/**
* Function returns time im msecs since start of UNIX epoch
* @access   public
* @return   double  Seconds passed
**/
function __microtime(){
   list($__mseconds, $__seconds) = explode(" ", microtime());
   return ((double)$__seconds + (double)$__mseconds);
}
/**
* Function trimming element of array
* @param        mixed       $item       value of item
* @param        mixed       $key        key of item
* @return   mixed       trimmed item of array
* @access   public
**/
function trim_item(&$item, $key)    {
    $item =  trim($item);
}

function GetLocalizedDate($format, $language = 'en', $date = null)
{
    if ($date == null)
    {
        $date = time();
    }

    $month_name = array(
        'ru' => array('������', '�������', '����', '������', '���', '����',
                      '����', '������', '��������', '�������', '������', '�������'),
        'ru2' => array('������', '�������', '�����', '������', '���', '����',
                      '����', '�������', '��������', '�������', '������', '�������'),
        'ua' => array('ѳ����', '�����', '��������', '������', '�������', '�������',
                      '������', '�������', '��������', '�������', '��������', '�������'),
        'ua2' => array('����', '������', '�������', '�����', '������', '������',
                      '�����', '������', '�������', '������', '���������', '������')
    );
    $result = date($format, $date);
    $month_num = date('n', $date) - 1;
    switch ($language)
    {
        case 'ru':
        case 'ua':
            $m_pos = strpos($format, 'M');
            if ($m_pos !== false)
            {
                if ($m_pos > 0)
                {
                    $result = str_replace(date('M', $date), $month_name[$language . "2"][$month_num], $result);
                } else {
                    $result = str_replace(date('M', $date), $month_name[$language][$month_num], $result);
                }
            }
            $m_pos = strpos($format, 'F');
            if ($m_pos !== false)
            {
                if ($m_pos > 0)
                {
                    $result = str_replace(date('F', $date), $month_name[$language . "2"][$month_num], $result);
                } else {
                    $result = str_replace(date('F', $date), $month_name[$language][$month_num], $result);
                }
            }
        break;
        default:
    }
    return $result;
}

function unserialize_file($file_name){
    if(file_exists($file_name)){
        $data = unserialize(file_get_contents($file_name));
    } else {
        $data = null;
    }
  return $data;
}

function serialize_data($file_name, $data){
   $handle = fopen($file_name, 'w');
   fwrite($handle, serialize($data));
   fclose($handle);
   $mask = umask(0);
   @chmod($file_name, 0777);
   @umask($mask);
}

function getQueryArray($exclude = null)
{
    $exclude = (array)$exclude;
    $queryArray = array();
    foreach (explode('&', $_SERVER['QUERY_STRING']) as $queryItem) {
        list($queryParam, $queryValue) = explode('=', $queryItem, 2);
        if ($queryParam =='' || in_array($queryParam, $exclude)) {
            continue;
        }
        $queryArray[$queryParam] = $queryValue;
    }
    return $queryArray;
}

function makeQueryString($queryArray)
{
    $queryStr = '';
    foreach ((array)$queryArray as $key => $value) {
        if ($queryStr) {
            $queryStr .= '&';
        }
        $queryStr .= "$key=$value";
    }
    return $queryStr;
}


function timefromstr($timeStr, $sourceFormatStr = '%2d.%2m.%4y %2h:%2i:%2s')
{
    preg_match_all('/%\d(\S).*?/', $sourceFormatStr, $markers);
    $markers = $markers[1];
    if (!$markers) {
        return false;
    }
    $sourceFormatStr = preg_replace('/(%\d)\S/', '$1d', $sourceFormatStr);
    $data = sscanf($timeStr, $sourceFormatStr);
    $markers = array_flip($markers);
	return strtotime(sprintf('%d-%02d-%02d %02d:%02d:%02d',
	   $data[$markers['y']],
	   $data[$markers['m']],
	   $data[$markers['d']],
	   $data[$markers['h']],
	   $data[$markers['i']],
	   $data[$markers['s']]
	));
}


if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        $f = @fopen($filename, 'w');
        if (!$f) {
            return false;
        } else {
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}

function mkdir_r($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_r(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

function GetFileSize($file){
	if (file_exists($file)){
		$bytes=filesize($file);
		if ( $bytes/(1024*1024)>1)
			$size=(floor($bytes/(1024*1024)*10)/10)." MB";
		elseif ($bytes/1024>0.1)
			$size=(floor($bytes/1024*10)/10)." kb";
		else
			$size=$bytes." b";
	}
	return $size;
}

function resetRecursivePointer(&$array,$key) {
	reset($array);
	while (key($array) !== $key)
		next($array);
	unset($array[$key]);
}
?>