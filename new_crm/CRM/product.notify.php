<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/product.notify.php";
}else{
	include_once $redirection."pc/product.notify.php";
}
?>