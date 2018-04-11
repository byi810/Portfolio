<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/leader.certify.approve.php";
}else{
	include_once $redirection."pc/leader.certify.approve.php";
}
?>