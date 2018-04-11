<?php
include_once "include/inc.php";

	$arr_send = array();
	$arr_send = explode("/", $_REQUEST[send_list_serial]);

	$arr_send_cnt = count($arr_send);
	$byte_chk = iconv_strlen($_REQUEST[message]);

	$send_type = $_REQUEST[m_send_type];


	//////////////////////예약발송///////////////////////////
	if($_REQUEST[_reserv_chk] == "Y") {
		$app_resv_time = $_REQUEST[_reserv_y]."-".$_REQUEST[_reserv_m]."-".$_REQUEST[_reserv_d]." ".$_REQUEST[_reserv_h].":".$_REQUEST[_reserv_i].":00";
		$sql = "
			insert into 
				odtReservSms 
			set 
				sms_reserve_time = '".$app_resv_time."',
				sms_title = '".$_REQUEST[send_title]."',
				sms_comment = '".$_REQUEST[message]."',
				sms_send_member = '".$row_staff[5]."',
				sms_receive_customer = '".$_REQUEST[send_list]."',
				register_date = '".date("Y-m-d H:m:s")."'
			";
		$rs_reserv = mysql_query($sql);
	} else {
		$app_resv_time = "";
	}
	/////////////////////예약발송끝/////////////////////////
	if($send_type == "D"){//일반발송 LMS
		for($i=0; $i<$arr_send_cnt;$i++){
			SmsConn_LG();
			$return_value = MMSSend_LG($arr_send[$i], "15444904", $_REQUEST[send_title], $_REQUEST[message]);
			@mysql_close($conn);
		}
	}else if($send_type == "S"){ //단일발송 SMS
		for($i=0; $i<$arr_send_cnt;$i++){
			SmsConn_LG();
			$return_value = SmsSend_LG($arr_send[$i], "15444904", $_REQUEST[message]);
			@mysql_close($conn);
		}
	}
	$sms_result = ($return_value)?"OK":"NOK";	

	$sql_vars = "
		sms_result = '".$sms_result."',
		sms_gubun = '".$send_type."',
		sms_title = '".$_REQUEST[send_title]."',
		sms_comment = '".$_REQUEST[message]."',
		sms_receive_num = '".base64_encode($_REQUEST[send_list_serial])."',
		sms_send_id = '".$row_staff[mb_id]."',
		sms_send_member = '".$row_staff[mb_name]."',
		register_date = '".mktime()."'
	";

		$conn = @mysql_connect("211.115.80.69", "jooyonshop_id", "jooyonshop_jooyon4904");
		mysql_select_db("jooyonshop_db", $conn);
		mysql_query("set names 'utf8'",$conn);
		//위 반복문에서 mysql_conn을 닫아놨기때문에
		//다시 열어줘야함
	$sql = "insert into odtSmsLogTable SET ".$sql_vars."";
	$rs = mysql_query($sql);
	
	if($rs && $return_value){ 
		alert('메시지가 발송되었습니다.','sms.send.php');
	}else{
		alert('메세지 발송 실패, 개발팀에 문의해주세요.');	
	}// 전부성공sms.send.php
?>

