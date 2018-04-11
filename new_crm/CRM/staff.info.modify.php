<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/staff.info.modify.php";
}else{
	include_once $redirection."pc/staff.info.modify.php";
}
?>