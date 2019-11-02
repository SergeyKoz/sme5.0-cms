<?php
//INIT string format:
//host=hostname&user=db_user&password=db_password
$chunks = explode("&",$INIT);
foreach($chunks as $chunk){
$fields = explode("=", $chunk);
$data[$fields[0]] = $fields[1];
}
$link = @mysql_connect($data["host"], $data["user"], $data["password"]);
if($link){
  echo "RES[".$TEST_ID."]:STATUS=1\n";
} else {
  echo "RES[".$TEST_ID."]:STATUS=0\n";
}

?>