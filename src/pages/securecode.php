<?php

/**
  * Secure code generator and processor page (require installed GD lib)
  * @package Framework
  * @subpackage pages
  * @access public
  */
    class SecureCodePage {

    function GetRandomizedColor(&$im, $colors){
        return imagecolorallocate ($im, $colors["r"]+(rand(-1*$colors["d"], $colors["d"])),
                                        $colors["g"]+(rand(-1*$colors["d"], $colors["d"])),
                                        $colors["b"]+(rand(-1*$colors["d"], $colors["d"])));

    }

    function DrawNoisedNumbers($number){

        header ("Content-type: image/png");

        $i_width=81;
        $i_height=33;
        $i_bg_color = array("r"=>212,"g"=>212,"b"=>212,"d"=>5);
        $i_border_color = array("r"=>0,"g"=>0,"b"=>0,"d"=>0);

        $i_ln_color = array("r"=>172,"g"=>172,"b"=>172, "d"=>5);
        $i_text_color = array("r"=>128,"g"=>128,"b"=>128, "d"=>20);
        $i_noise = array("r"=>192,"g"=>192,"b"=>192,"d"=>40,"back"=>100, "front"=>100);

        $v_lines_count = 5;
        $v_lines_dist = ceil($i_height/$v_lines_count);

        $h_lines_count = 15;
        $h_lines_dist = ceil($i_width/$h_lines_count);

        $im = @imagecreate ($i_width, $i_height)
           or die ("Cannot Initialize new GD image stream");


        $background_color = $this->GetRandomizedColor($im, $i_bg_color);

        // Drawing horizontal lines
        for($i=0; $i<$v_lines_count; $i++){
            $lines_color = $this->GetRandomizedColor($im, $i_ln_color);
            $rln_1 = rand(0,4);
            $rln_2 = rand(0,4);
            imageline ($im, 0, $v_lines_dist*$i+($rln_1-2), $i_width, $v_lines_dist*$i+($rln_2-2) , $lines_color);
        }

        // Drawing vertical lines
        for($i=0; $i<$h_lines_count; $i++){
            $lines_color = $this->GetRandomizedColor($im, $i_ln_color);
            $rln_1 = rand(0,6);
            $rln_2 = rand(0,6);
            imageline ($im, $h_lines_dist*$i+($rln_1-3), 0, $h_lines_dist*$i+($rln_2-3), $i_height , $lines_color);
        }

        // Drawing random noise over background
        for($i=0; $i<$i_noise["back"]; $i++){
            $_x = rand(0,$i_width);
            $_y = rand(0,$i_height);
            $_color = $this->GetRandomizedColor($im, $i_noise);
            imageline ($im, $_x, $_y, $_x+1, $_y+1, $_color);
        }

        // drawing number
        $x_rnd = rand(0,10);
        $rnd = $number;
        for($i=0; $i<strlen($rnd); $i++){
            $text_color = $this->GetRandomizedColor($im, $i_text_color);
            imagestring ($im, rand(9,9), $x_rnd+5+$i*10,5+(rand(1,10)-5), substr($rnd,$i,1) , $text_color);

        }

        // Drawing random noise over foreground
        for($i=0; $i<$i_noise["front"]; $i++){
            $_x = rand(0,$i_width);
            $_y = rand(0,$i_height);
            $_color = $this->GetRandomizedColor($im, $i_noise);

            imageline ($im, $_x, $_y, $_x+1, $_y+1, $_color);
        }
        //drawind border
        $bordercolor = $this->GetRandomizedColor($im, $i_border_color);
        imageline ($im, 0, 0, 0, $i_height-1, $bordercolor);
        imageline ($im, 0,$i_height-1, $i_width-1, $i_height-1, $bordercolor);
        imageline ($im, $i_width-1, $i_height-1, $i_width-1, 0, $bordercolor);
        imageline ($im, $i_width-1, 0, 0, 0, $bordercolor);


        imagepng ($im);
        imagedestroy ($im);
    }


       function ProcessRequest(){
          $this->Kernel->ShowDebug=false;
          //global $HTTP_GET_VARS;
          if(isset($_GET["sid"])){
              $this->Kernel->ImportClass("module.data.securecodestable", "SecureCodesTable");
              $settings = &$this->Kernel->Settings;
              $securecodestable = new SecureCodesTable($this->Kernel->Connection, $settings->GetItem("database", "SecureCodesTable"));
              $data = $securecodestable->GetByFields(array("hash"=>$_GET["sid"]));
              $this->DrawNoisedNumbers($data["number"]);
          }


       }

    }
?>
