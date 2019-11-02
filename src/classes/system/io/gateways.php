<?php
/**
  * Gateway processor
  * @author    Konstantin Matsebora    <kmatsebora@activemedia.com.ua>
  * @package   Framework
  * @subpackage classes.system.io
  * @access    public
  **/

  class GatewayProcessor    {

      /**
      * Protocol wrapper
      * @var    string    $wrapper
      **/
    var $wrapper;

    /**
      * GAteway host
      * @var  string  $host
      **/
    var $host;

    /**
      * GAteway port
      * @var  int  $port
      **/
    var $port;

    /**
      * Gateway path
      * @var  string  $path
      **/
    var $path;

    /**
      * Socket error
      * @var  string  $error
      **/
    var $error;

    /**
      * Socket error number
      * @var  string  $errorno
      **/
    var $errorno;

    /**
      * Socket timeout
      * @var  string  $timeout
      **/
    var $timeout;


    /**
        * Class constructor
      * @param        string    $number        Credit card number
      * @param        string    $expdate  Expiration date
      * @param        string    $owner        Credit card owner
      * @param        string    $type            Credit card type
      **/
    function GatewayProcessor($host,$port,$path,$wrapper="ssl", $timeout=30) {
      $this->host     =    $host;
      $this->port     =    $port;
      $this->path     =    $path;
      $this->wrapper  =    $wrapper;
      $this->timeout  =    $timeout;

    }

    /**
    * Method sends secure SSL POST request to Authorize.NET processing gateway
    * Returns response result array

    * @param    array    $data    Array with request data
    * @param    string    $delimiter    Records delimiter
    * @param    string    $response_header_delimeter_count    Headers repeat count
    * @return   array    Array with response fields
    */
    function GetGateWayResponse($data, $delimiter=",", $response_header_delimeter_count=2){
        $response = "";
        //$host = "secure.authorize.net";
        //$port = 443;
        //$path = "/gateway/transact.dll";
        //you will need to setup an array of fields to post with
        //then create the post string
        //build the post string
        foreach($data as $key => $val){
           $poststring .= urlencode($key) . "=" . urlencode($val) . "&";
        }
        // strip off trailing ampersand
        $poststring = substr($poststring, 0, -1);
        $fp = fsockopen($this->wrapper."://".$this->host, $this->port, $errno, $errstr, $this->timeout);
        if(!$fp){
        //error tell us
        $this->error = $errstr;
        $this->errorno = $errno;
        return false;
        //echo "$errstr ($errno)\n";

        }else{
	        $this->error = "";
    	    $this->errorno = 0;

           //send the server request
           fputs($fp, "POST ".$this->path." HTTP/1.1\r\n");
           fputs($fp, "Host: ".$this->host."\r\n");
           fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
           fputs($fp, "Content-length: ".strlen($poststring)."\r\n");
           fputs($fp, "Connection: close\r\n\r\n");
           fputs($fp, $poststring . "\r\n\r\n");
           //loop through the response from the server
           while(!feof($fp)) {
             $response .= @fread($fp, 1024);// Ugly terrible IIS HACK
          }
          //close fp - we are done with it
         fclose($fp);
      }
      //$fp = fopen("/usr/home/amikhmel/public_html/test/ssl.txt","w");
      //fputs($fp, $response);
      //fclose($fp);
      for($i=1; $i<$response_header_delimeter_count; $i++){
         $response = substr($response, strpos($response,"\r\n\r\n")+4);
      }
      return  explode($delimiter, substr($response, strpos($response,"\r\n\r\n")+4));
    }

//end of class
}
?>