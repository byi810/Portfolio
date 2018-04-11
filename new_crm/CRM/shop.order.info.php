<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/shop.order.info.php";
}else{
	include_once $redirection."pc/shop.order.info.php";
}
?>