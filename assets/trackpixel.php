<?php
//IP y Timestamp
$date=date("Y-m-d H:i:s");
$ip  =$_SERVER['REMOTE_ADDR'];

$encrypted = $_GET['token'];
$decrypted = base64_decode($encrypted);

$token = explode('|',$decrypted);
$template = $token[0];
$mail = $token[1];

$hostname = 'localhost';
$database = 'bf_framework';
$username = 'root';
$password = '';

$db 	  = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database, $db);
$sql = "INSERT INTO bf_track (ip, timestamp,template_id,mail_id) VALUES ('$ip','$date','$template','$mail')";
mysql_query($sql,$db);



header("content-type: image/gif");
//43byte 1x1 transparent pixel gif
echo base64_decode("R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");

?>