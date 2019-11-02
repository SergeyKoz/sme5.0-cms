<?php

/**
  * Secure code generator and processor page (require installed GD lib)
  * @package Framework
  * @subpackage pages
  * @access public  
  */

  class TestConstructorPage extends Component {

      
     /* function Crypt($key, $data){
          
        $len = strlen($data);  
        $key_len = strlen($key);
        for($i=0; $i<$len; $i++){
            $k = ($i % $key_len);
            $_tmp.=chr(ord($data{$i}) ^ ord($key{$k}));
        }
        
        return $_tmp;
      }
     */ 
      
       function ProcessRequest(){
          
          $this->Kernel->ShowDebug=false;
          $this->Kernel->QuietRems=1;
          $result="";
          
          $this->Kernel->Import("web.controls.testconstructor");
          
          echo TestConstructor::GetTests($this->Kernel, $_GET["id"]);

        
       }

    }
?>
