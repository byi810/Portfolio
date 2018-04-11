<?PHP
include_once "include/inc.php";

$no_gubun = $_REQUEST[gubun_mode];
$mmode = $_REQUEST[mmode];
$no_notify_title = $_REQUEST[no_notify_title_all];
$no_noti_text_all = $_REQUEST[no_noti_text_all];
$no_goods_code_indi = $_REQUEST[no_goods_code_indi];
$no_goods_code_indi = str_replace(",S","S",$no_goods_code_indi);
$no_goods_code_indi = str_replace("S",",S",$no_goods_code_indi);
$no_goods_code_indi = mb_substr($no_goods_code_indi,1);
$no_notify_title_indi = $_REQUEST[no_notify_title_indi];
$no_noti_text_indi = $_REQUEST[no_noti_text_indi];
$no_enterprise_code = $_REQUEST[no_goods_code_enter];
$no_notify_title_enter = $_REQUEST[no_notify_title_enter];
$no_noti_text_enter = $_REQUEST[no_noti_text_enter];
$no_mb_id = $row_staff[mb_id];
$no_mb_name = $row_staff[mb_name];
$uid = $_REQUEST[uid];
if($no_gubun == "A"){
	$no_notify_title = $_REQUEST[no_notify_title_all];
	$no_notify_text = $_REQUEST[no_noti_text_all];
	$no_sdate = $_REQUEST[noti_date_all]." ".$_REQUEST[noti_dateh_all].":".$_REQUEST[noti_datem_all].":00";
	$no_edate = $_REQUEST[noti_enddate_all]." ".$_REQUEST[noti_enddateh_all].":".$_REQUEST[noti_enddatem_all].":59";
}elseif($no_gubun == "I"){
	$no_notify_title = $_REQUEST[no_notify_title_indi];
	$no_notify_text = $_REQUEST[no_noti_text_indi];
	$no_sdate = $_REQUEST[noti_date_indi]." ".$_REQUEST[noti_dateh_indi].":".$_REQUEST[noti_datem_indi].":00";
	$no_edate = $_REQUEST[noti_enddate_indi]." ".$_REQUEST[noti_enddateh_indi].":".$_REQUEST[noti_enddatem_indi].":59";
}elseif($no_gubun == "E"){
	$no_notify_title = $_REQUEST[no_notify_title_enter];
	$no_notify_text = $_REQUEST[no_noti_text_enter];
	$no_sdate = $_REQUEST[noti_date_enter]." ".$_REQUEST[noti_dateh_enter].":".$_REQUEST[noti_datem_enter].":00";
	$no_edate = $_REQUEST[noti_enddate_enter]." ".$_REQUEST[noti_enddateh_enter].":".$_REQUEST[noti_enddatem_enter].":59";
}
$detail_info_img_name = $_REQUEST[detail_info_img_old];


if($_REQUEST['detail_info_img_del']){//삭제 체크한 변수들 1.삭제
	foreach($_REQUEST['detail_info_img_del'] as $key => $val){ //삭제 체크한 변수들(파일명)을 키값으로 
		if($key){
			$detail_info_img_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/notiimg/"; // 이미지 저장 경로
			$detail_info_img_name = str_replace($key."|","",$detail_info_img_name); //
			$detail_info_img = ", no_noti_image1 = '".$detail_info_img_name."'";//DB 업데이트위한 쿼리
			@unlink($detail_info_img_dir.$key); //파일삭제
			//debug($detail_info_img_name);
		}
	}
}
//이미지등록 공통
if(count($_FILES['detail_info_img']['name'])>0){
	foreach($_FILES['detail_info_img']['name'] as $key => $val){
		if($_FILES['detail_info_img']['size'][$key] > 0){
			$detail_info_img_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/notiimg/";
			if(!is_dir($detail_info_img_dir)){
				@mkdir($detail_info_img_dir, true);
				@chmod($detail_info_img_dir,0777);
			}
			$ex_image_name = explode(".",$_FILES['detail_info_img']['name'][$key]);//저장할 이미지 이름
			$app_ext = strtolower($ex_image_name[(sizeof($ex_image_name)-1)]); // 확장자
			if( !preg_match("/gif|jpg|bmp|png/i" , $app_ext) ) {
				alert("업로드를 할 수 없는 파일형식입니다.");
			}
			$detail_info_img22 = sprintf("%u",crc32($_FILES['detail_info_img']['name'][$key].time().rand())).".".$app_ext ;
			
			$detail_info_img_upload_file = $detail_info_img_dir.$detail_info_img22;
			$detail_info_img_real .= $detail_info_img22."|";
			
			if(!move_uploaded_file($_FILES['detail_info_img']['tmp_name'][$key], $detail_info_img_upload_file)){
				alert("파일 업로드에 실패하였습니다.");
			}else{
				if($_REQUEST[detail_info_img_old]){
					if($_REQUEST[detail_info_img_del]){
						$detail_info_img = ", no_noti_image1 = '".$detail_info_img_real."'";
					}else{
						$detail_info_img = ", no_noti_image1 = '".$_REQUEST[detail_info_img_old].$detail_info_img_real."'";
					}
				}else{
					$detail_info_img = ", no_noti_image1 = '".$detail_info_img_real."'";
				}
			}
		}
	}
}
$que = "
	no_gubun = '".$no_gubun."',
	no_goods_code = '".$no_goods_code_indi."',
	no_enterprise_code = '".$no_enterprise_code."',
	no_notify_title = '".$no_notify_title."',
	no_notify_text = '".$no_notify_text."',
	no_mb_id = '".$row_staff[mb_id]."',
	no_mb_name = '".$row_staff[mb_name]."',
	no_sdate = '".$no_sdate."',
	no_edate = '".$no_edate."',
	no_registerdate = '".date("Y-m-d H:m:s",mktime())."'
	".$detail_info_img."
";

switch ($mmode){
	case "create" :
		$sql = "insert into odtNotification set $que";
		$rs = mysql_query($sql);
	break;

	case "modify" : 
		$sql = "update odtNotification set $que where uid = '".$uid."'";
		$rs = mysql_query($sql);		
	break;

	case "delete" :
		$sql = "update odtNotification set no_del_chk = 'Y' where uid = '".$_REQUEST[code]."'";
		$rs = mysql_query($sql);
	break;
}

if($rs){
	alert("요청 사항 처리 완료");
}else{
	alert("요청 사항 처리 실패,\n\n 개발팀에 문의해주세요.");
}
?>