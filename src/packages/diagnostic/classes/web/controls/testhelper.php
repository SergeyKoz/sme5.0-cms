<?php
$this->ImportClass("web.controls.testconstructor", "TestConstructor"); 
/** Test helper class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  LIbraries
   * @access public
   **/
class TestHelper {
   /**
   * Method draws response in xml
   * @param     XMLWriter   $xmlWriter  Writer Object
   * @param     string      $response   Response string
   * @param     array       $tests      Array with tests data
   * @access    public
   **/
   function DrawResponse(&$xmlWriter, $response, $tests){
     $result = 0;
     $has_errors = 0;
     if(strlen($response) > 0){ // Get some usefull response
         $responses = explode("\n", chop($response));
        //echo pr($response);
        foreach($responses as $_r){
            preg_match("/RES\[(\d+)\]:(STATUS|STRING|ERROR)=([\.\w\-]+)/", $_r, $m);
            //echo pr($m);
            $resp_array[$m[1]] = array("status" => $m[2], "value" => $m[3]);
            if($m[1]==0){ 
                $result = array("status" => $m[2], "value" => $m[3]);
            }
            //echo pr($m);
            if(($m[3] == 0) && (($m[2] == "STATUS") || ($m[2] == "ERROR"))){
                $has_errors = 1;
            }
        }
     
        foreach($tests as $test){
            $xmlWriter->WriteStartElement("response");
                $xmlWriter->WriteAttributeString("test_id", $test["test_id"]);
                $xmlWriter->WriteAttributeString("type", $resp_array[$test["test_id"]]["status"]);
                $xmlWriter->WriteString($resp_array[$test["test_id"]]["value"]);
            $xmlWriter->WriteEndElement("response");
        
        }
        return array($result, $has_errors);
     } else {// tester gateway not found
        return array(array("status" => 0, "value" => -20), 1);   
     }    
     //echo pr($result);  
     
   }

   /**
   * Method gets response from specified url
   * @param     string  $url    URL to get response from
   * @param     string  $constructor_url    Tests constructor script url
   * @param     int     $site_id    Site ID
   * @param     int     $transport  Transport type (0 = push, 1 = pull)
   * @param     int     $emails     Select only tests for emails
   * @result    string  Script response
   * @access    public
   ***/
   function GetResponse($url, $constructor_url, $site_id, $passwd, $transport, $emails = false){
       $chunks = parse_url($url);
       $tests_content  = "";
       //echo pr($chunks);
       ini_set("display_errors", "0");
       $saved_error_reporting = error_reporting(E_NONE);
       $fp = @fsockopen ($chunks["host"], 80, $errno, $errstr, 3); 
       error_reporting($saved_error_reporting);
       ini_set("display_errors", "1");
        if (!$fp) { 
        return "RES[0]:ERROR=-10\n"; 
        } else { 
        $tests_content = ""; 
        $constructor = base64_encode($constructor_url."?id=".$site_id);
        //echo pr("GET ".$chunks["path"]."?constructor=".$constructor."&hash=".md5($passwd)." HTTP/1.0\r\nHost: ".$chunks["host"]."\r\n\r\n");
        //die();
        if($transport == 1){ // sending GET request
            fputs ($fp, "GET ".$chunks["path"]."?constructor=".$constructor."&hash=".md5($passwd)." HTTP/1.0\r\nHost: ".$chunks["host"]."\r\n\r\n"); 
        } else {
           $tests = TestConstructor::GetTests($this->Kernel, $site_id, $emails);
           //echo pr($tests); 
           $poststring = "test_content=".urlencode($tests)."&hash=".md5($passwd);
           fputs($fp, "POST ".$chunks["path"]." HTTP/1.1\r\n");
           fputs($fp, "Host: ".$chunks["host"]."\r\n");
           fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
           fputs($fp, "Content-length: ".strlen($poststring)."\r\n");
           fputs($fp, "Connection: close\r\n\r\n");
           fputs($fp, $poststring . "\r\n\r\n");
        }
        while (!feof($fp)) { 
            $tests_content .= fgets ($fp,128); 
        } 
        //echo pr($tests_content); 
        $headers_limit_pos = strpos($tests_content, "\r\n\r\n")+4;    
        $headers = substr($tests_content, 0, $headers_limit_pos);
        if(strpos($headers, "404") === false){// tester gateway found
            $tests_content = substr($tests_content, $headers_limit_pos);
        } else {// tester gateway NOT found
            $tests_content = "";
        }    
     }  
    //echo pr($tests_content); 
    return $tests_content;
    
   }
   
}

?>