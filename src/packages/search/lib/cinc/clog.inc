<?
 /**
   * class for loggin messages to file
   * Copyright (c) 2001 Sergey Frolovithev (siteindexer@idesign.ru). All rights reserved.
   * @package Search
   * @subpackage lib.cinc
   * @access  public
   **/

 class cLOG
  { var $logFile;
    var $mType=array("OK","ER");

    // функция инициализирует лог-файл и возвращает
    function cLOG($File)
     { $this->logFile=$File;
       //error_reporting(1+4+16);
     }

    // функция записи сообщения в лог файл, с указанным аттрибутом
    // type=0 - good
    // type=1 - error
    function write($message,$type=0)
     { global $PHP_SELF;

       $message=ereg_replace("\n","",$message);
       $message=ereg_replace("\r","",$message);
       $message.="\n";

       $fp=fopen($this->logFile,"a");
       $time=date("H:i:s d-m-Y");
       fputs($fp,"[".$time."] {".$this->mType[$type]."} <".$PHP_SELF."> ".$message);
       fclose($fp);
     }

  }
?>