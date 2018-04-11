<?
include(dirname(__FILE__)."/include/inc.php");

$mode = $_REQUEST[mode];

switch($mode){

	case "download" :
		$path = $_SERVER["DOCUMENT_ROOT"]."/upfiles/sample/";
		 
		$fullPath = $path."sample_sms_send.xls";
		 
		if ($fd = fopen ($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			switch ($ext) {
				case "pdf":
					header("Content-type: application/pdf");
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); 
				break;
				default;
					header("Content-type: application/octet-stream");
					header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
				break;
			}
			header("Content-length: $fsize");
			header("Cache-control: private");
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose ($fd);
		exit;
	break;

	case "multi_send_pro" :
		if($_FILES['multi_upload']['size'] > 0) {
			# Error Reproting level modify
			error_reporting(E_ALL ^ E_NOTICE);

			# Excel Class Load
			require_once($_SERVER[DOCUMENT_ROOT]."/include/reader.php");


			# 첨부파일 확장자 검사
			$ext = '';
			$ext = substr(strrchr($_FILES['multi_upload']['name'],"."),1);	//확장자앞 .을 제거하기 위하여 substr()함수를 이용
			$ext = strtolower($ext); //확장자를 소문자로 변환

			if($ext != 'xls'){
				$return = "xls형식의 파일이 아닙니다.";
			}

			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($_FILES['multi_upload']['tmp_name']);
			
			$phone_num = array();
			for ($i=2; $i<=$data->sheets[0]['numRows']; $i++) {
				$r = $data->sheets[0]['cells'][$i];
				$phone_num[] = trim($r[1]);
			}

			echo json_encode($phone_num);
		}
	break;
}