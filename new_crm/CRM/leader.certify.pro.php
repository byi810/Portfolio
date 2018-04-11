<?
include_once "include/inc.php";

/*
if($_REQUEST[mode] == "approval"){
	$sql = "update reader_certify_beforehand_table set application = 'Y' where uid = '".$_REQUEST[uid]."'";
	$rs = mysql_query($sql);
}elseif($_REQUEST[mode] == "delete"){
	$sql = "delete from reader_certify_beforehand_table where uid = '".$_REQUEST[uid]."'";
	$rs = mysql_query($sql);
}elseif($_REQUEST[mode] == "modify"){
	$sql = "
	update 
		reader_certify_beforehand_table 
	set 
		name = '".$_REQUEST[ld_name]."',
		phone_num = '".$_REQUEST[ld_phone]."',
		relation= '".$_REQUEST[ld_relation]."',
		modify_date = '".mktime()."'
	where
		uid = '".$_REQUEST[uid]."'	
	";
	$rs = mysql_query($sql);
}
*/

switch($_REQUEST['mode']){

	case "approval":
	$sql = "update reader_certify_beforehand_table set application = 'Y' where uid = '".$_REQUEST[uid]."'";
	$rs = mysql_query($sql);

	$sql_num = "
	insert into 
		reader_certify_num_table 
	set
		band_code = '".$_REQUEST[bandcode]."',
		name = '".$_REQUEST[name]."',
		phone_num = '".$_REQUEST[phonenum]."',
		register_date = '".mktime()."',
		holding = 'N',
		relation = '".$_REQUEST[relation]."'
	";
	$rss = mysql_query($sql_num);
	/*
	$sql_leader_select = "select count(*) from jy_leader where ld_id = '".$_REQUEST[bandcode]."' and ld_name='".$_REQUEST[name]."'";
	$rs_leader_select = mysql_query($sql_leader_select);
	$row_leader_select = mysql_fetch_array($rs_leader_select);

	if($row_leader_select[0] < 1 && $_REQUEST[relation] == "본인"){
		$sql_leader = "
			insert into
				jy_leader
			set
				ld_id = '".$_REQUEST[bandcode]."',
				ld_passwd = password('".$_REQUEST[bandcode]."'),
				ld_passwd_real = '".$_REQUEST[bandcode]."',
				ld_name = '".$_REQUEST[name]."',
				ld_htel = '".$_REQUEST[phonenum]."',
				ld_email = '".$_REQUEST[email]."',
				ld_login_authority = 'N',
				register_date = '".mktime()."'
		";
		mysql_query($sql_leader);
	}
	*/
	break;

	case "modify":
	$ld_phone = $_REQUEST[ld_phone1]."-".$_REQUEST[ld_phone2]."-".$_REQUEST[ld_phone3];
	$sql = "
	update 
		reader_certify_beforehand_table 
	set 
		name = '".$_REQUEST[ld_name]."',
		phone_num = '".$ld_phone."',
		relation= '".$_REQUEST[ld_relation]."',
		modify_date = '".mktime()."'
	where
		uid = '".$_REQUEST[uid]."'	
	";
	$rs = mysql_query($sql);
	break;

	case "delete":
	$sql = "delete from reader_certify_beforehand_table where uid = '".$_REQUEST[uid]."'";
	$rs = mysql_query($sql);
	break;
}
if($_REQUEST['mode'] != "modify"){
	if($rs){
		echo "ok";
	}else{
		echo "nok";
	}
}else{
	if($rs){
		alert("요청 작업 완료");
	}else{
		alert("요청 작업 실패");
	}
}

?>