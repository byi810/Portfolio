<?
include_once "include/inc.php";

$sql = " 
	delete from odtSmsSetting where uid = '".$_REQUEST['uid']."'
";
$res = mysql_query($sql);

	if($res){
		alert("SMS가 삭제되었습니다.");
	}else{
		alert("SMS 삭제에 실패하였습니다.");
	}


?>