<?php
class TestConstructor {

function Crypt($key, $data){
          
        $len = strlen($data);  
        $key_len = strlen($key);
        for($i=0; $i<$len; $i++){
            $k = ($i % $key_len);
            $_tmp.=chr(ord($data{$i}) ^ ord($key{$k}));
        }
        
        return $_tmp;
      }    
    
    function GetTests(&$Kernel, $site_id, $emails = false){
        $result = "";
              
	          $Kernel->Import("data.siteteststable");
              $settings = &$Kernel->Settings;
              $testsStorage = new SiteTestsTable($Kernel->Connection, $settings->GetItem("database", "SiteTestsTable"));
              $_reader = $testsStorage->getSiteTests($site_id, $emails);
              for($i=0; $i<$_reader->RecordCount; $i++){
                  $_tmp = $_reader->Read();
                  //echo pr($_tmp);
                  $_file = $settings->GetItem("settings", "FileStoragePath").$_tmp["test_file"];
                  //echo $_file;
                  if(file_exists($_file)){
                    $_test = file_get_contents($_file);
                    $_test ="\$INIT = '".$_tmp["init"]."';\n\$TEST_ID='".$_tmp["test_id"]."';\n?>".$_test."\n<?";
                  }  else {
                    $_test = "echo 'RES[".$_tmp["test_id"]."]:ERROR=-2'.\"\n\";\n";  // NO TEST FILE FOUND
                  }
                  $result .=  $_test;

                  
              }
              
          return base64_encode(TestConstructor::Crypt($_tmp["site_password"], $result));    
    }
    
}

?>