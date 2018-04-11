<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/product.notify.list.php";
}else{
	include_once $redirection."pc/product.notify.list.php";
}
?>