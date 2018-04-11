<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/sms.send.php";
}else{
	include_once $redirection."pc/sms.send.php";
}
?>