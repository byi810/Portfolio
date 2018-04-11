<?
include_once "include/inc.php";

	$sql = " 
		INSERT INTO 
			odtSmsSetting
		SET
			sms_type = '".$_REQUEST['sms_type']."',
			sms_type_sub = '".$_REQUEST['sms_type_sub']."',
			sms_set_site = '".$_REQUEST['sms_set_time']."',
			sms_set_content = '".$_REQUEST['sms_set_content']."',
			sms_template = '".$_REQUEST['sms_template']."',
			reg_date = '".$_REQUEST['sms_set_time']."',
			reg_id = '".$_REQUEST['AuthID']."'

	";

	$res = mysql_query($sql);
	if($res){
		alert("SMS세팅이 저장되었습니다.");
	}else{
		alert("SMS세팅에 실패하였습니다.");
	}
	
?>