<?php
//Init settings:
//<path>[=SIZE[M|K]]
//<path> absolute | relative
//SIZE      number
function convert($size){
    return str_replace(array("M", "K"),array("000000", "000"), $size);
} 

 list($path, $size_limit) = explode("=", $INIT);
 $size_limit = convert($size_limit);
 $path = realpath($path);
 $response = exec("du -h $path");
 preg_match("/\w+/", $response, $m);
 $result = convert($m[0]);
 if(((int)$size_limit > (int)$result) || ((int)$size_limit == 0) ){
     echo"RES[".$TEST_ID."]:STRING=".$m[0]."\n";
 } else {
     echo"RES[".$TEST_ID."]:STATUS=0\n";
 
 }

?>
