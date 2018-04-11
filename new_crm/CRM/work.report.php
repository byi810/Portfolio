<?
include_once "include/inc.php";

if(is_mobile()){
	include_once $redirection."mobile/work.report.php";
}else{
	include_once $redirection."pc/work.report.php";
}
?>