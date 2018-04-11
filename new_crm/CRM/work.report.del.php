<?php
include_once "include/inc.php";

$sql = "select * from jy_work where uid = '".$_REQUEST['uid']."'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

if($row['wr_file_root']){
	unlink($row['wr_file_root']);
}

$sql = " 
	delete from jy_work where uid = '".$_REQUEST['uid']."'
";
$res = mysql_query($sql);

if($res) {
		echo "ok";
	} else {
		echo "fail";
	}

?>