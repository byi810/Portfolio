<?
include_once "include/inc.php";

switch($_REQUEST['mode']){

	case "create":
	$file_name = "";
	if($_FILES['wr_file']['name']){

		$file_format = array("jpg", "gif", "png", "JPEG", "JPG", "PNG");
		$path = $_SERVER[DOCUMENT_ROOT].'/uploads/saveimg/';
		//upload 파일 경로는 절대 경로로 올려야함
		$tmp_name = $_FILES['wr_file']['tmp_name'];
		$file_name = $_FILES['wr_file']['name'];
		$filesize = $_FILES['wr_file']['size'];
		$filetype = $_FILES['wr_file']['type'];
		//파일명을 숫자로 변경
		$f_nm = explode(".", $file_name);
		$f_rand = rand(100,999);
		$file_name = $f_rand . "_" . mktime() ."." . $f_nm[1];
		$register_date = mktime();

		if(!in_array($f_nm[1], $file_format)){
			alert("사용할수없는 이미지 파일 입니다.", "work.report.php");
		}
		$temp_filename =  $path.$file_name;

		
			$rs = @move_uploaded_file($tmp_name, $temp_filename);
			$wr_file_name = "wr_file_name = '".$temp_filename."'";
		}else{
			$wr_file_name = "";
		}
		
	$sql = " 
		INSERT INTO 
			jy_work
		SET
			wr_id = '".$row_staff[mb_id]."',
			wr_name = '".$row_staff[mb_name]."',
			wr_nick = '".$row_staff[mb_nick]."',
			wr_team = '".$row_staff[mb_team]."',
			wr_department = '".$row_staff[mb_department]."',
			wr_file_name = '".$file_name."',
			wr_file_root = '".$temp_filename."',
			wr_title = '".$_REQUEST[wr_title]."',
			wr_comment = '".$_REQUEST[wr_comment]."',
			register_date = '".$register_date."'
	";

	$res = mysql_query($sql);
		
	if($res){
		$_name = ($row_staff[mb_nick])?$row_staff[mb_nick]:$row_staff[mb_name];

		$report_res = report_sms($row_staff[mb_id], $_name, $row_staff[mb_team], $row_staff[mb_position],$row_staff[mb_department], $_REQUEST[wr_comment]);

		alert("업무일지가 작성되었습니다.");
	}else{
		alert("업무일지 작성에 실패하였습니다.");
	}
	break;

	case "modify":
	$file_name = "";
	$register_date = mktime();

	if($_FILES['wr_file']['name']){
		
		$sql = "select * from jy_work where uid = '".$_REQUEST[uid]."'";
		$rs_wrp = mysql_query($sql);
		$row_wrp = mysql_fetch_array($rs_wrp);
		if($row_wrp[wr_file_root]){
			unlink($row_wrp['wr_file_root']);
		}
		$file_format = array("jpg", "gif", "png", "JPEG", "JPG", "PNG");
		$path = $_SERVER[DOCUMENT_ROOT].'/uploads/saveimg/';
		//upload 파일 경로는 절대 경로로 올려야함
		$tmp_name = $_FILES['wr_file']['tmp_name'];
		$file_name = $_FILES['wr_file']['name'];
		$filesize = $_FILES['wr_file']['size'];
		$filetype = $_FILES['wr_file']['type'];
		//파일명을 숫자로 변경
		$f_nm = explode(".", $file_name);
		$f_rand = rand(100,999);
		$file_name = $f_rand . "_" . mktime() ."." . $f_nm[1];
		

		if(!in_array($f_nm[1], $file_format)){
			alert("사용할수없는 이미지 파일 입니다.", "work.report.php");
		}
		$temp_filename =  $path.$file_name;

		
			$rs = @move_uploaded_file($tmp_name, $temp_filename);
			$wr_file_name = "wr_file_name = '".$temp_filename."'";
		}else{
			$wr_file_name = "";
		}
		
	$sql = " 
		UPDATE
			jy_work
		SET
			wr_id = '".$row_staff[mb_id]."',
			wr_name = '".$row_staff[mb_name]."',
			wr_nick = '".$row_staff[mb_nick]."',
			wr_team = '".$row_staff[mb_team]."',
			wr_department = '".$row_staff[mb_department]."',
			
			wr_title = '".$_REQUEST[wr_title]."',
			wr_comment = '".$_REQUEST[wr_comment]."',
			register_date = '".$register_date."'
		WHERE
			uid = '".$_REQUEST[uid]."'
	";
	$res = mysql_query($sql);
		
	if($res){
		//$_name = ($row_staff[mb_nick])?$row_staff[mb_nick]:$row_staff[mb_name];

		//$report_res = report_sms($row_staff[mb_id], $_name, $row_staff[mb_team], $row_staff[mb_position],$row_staff[mb_department], $_REQUEST[wr_comment]);

		alert("업무일지가 수정되었습니다.");
	}else{
		alert("업무일지 수정에 실패하였습니다.");
	}

	break;

	case "show":

	break;

}	
?>