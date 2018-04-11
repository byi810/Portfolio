<?php
include_once "include/inc.php";

$j_tel = $_REQUEST['j_tel1']."-".$_REQUEST['j_tel2']."-".$_REQUEST['j_tel3'];

$mb_passwd = "";
$mb_passwd_real = "";

if($_REQUEST['j_passwd']){
	$mb_passwd = ", mb_passwd = password('".$_REQUEST['j_passwd']."')";
	$mb_passwd_real = ", mb_passwd_real = '".$_REQUEST['j_passwd']."'";
}

$sql = "
	update jy_staff set
		mb_name = '".$_REQUEST['j_name']."',
		mb_htel = '".$j_tel."',
		mb_nick = '".$_REQUEST['j_nick']."',
		mb_team = '".$_REQUEST['j_team']."',
		mb_email = '".$_REQUEST['j_email']."',
		mb_md = '".$_REQUEST['j_md']."',
		mb_department = '".$_REQUEST['j_department']."',
		mb_position = '".$_REQUEST['j_position']."'
		$mb_passwd
		$mb_passwd_real
	where
		uid = '".$_REQUEST['_uid']."'
		
";

$rs = mysql_query($sql);

if($rs){
		if($_REQUEST[j_passwd]){
			alert("비밀번호를 변경했습니다.\\n\\n다시 로그인해주세요.", "logout.php");
		}else{
			alert("정보수정을 완료했습니다.", "/");
		}
	}else{
		alert("정보수정에 실패 하였습니다.\\n\\n개발팀에 문의해 주세요.");
	}
exit;
?>