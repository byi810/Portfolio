<?
include_once "include/inc.php";


if(is_login()){
	if(is_mobile()){
		include_once $redirection."mobile/staff.list.php";
	}else{
		include_once $redirection."pc/staff.list.php";
	}
}else{
	include_once "login.php";
}
?>