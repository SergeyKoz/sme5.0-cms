<?php
//Init settings note: absolute path to the must-be-included file
//(i.e. /usr/home/dir/file.php)
$fp=@fopen($INIT, "r");
if($fp){ echo "RES[".$TEST_ID."]:STATUS=1\n";}
else {echo "RES[".$TEST_ID."]:STATUS=0\n";}
?>