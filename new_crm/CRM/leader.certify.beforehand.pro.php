<?php
include "include/inc.php";
if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(in_array($row_authority[member_supervise], array('N',''))){
	alert("권한이 없습니다.","/");
}
$_mode = $_REQUEST["_mode"];
$_uid = $_REQUEST["uid"];
$band_code = "band".$_REQUEST["band_code_se"];
$name = $_REQUEST["name"];
$phone_num = $_REQUEST["phone_num"];
$relation = $_REQUEST["relation"];
$now = mktime();

switch($_mode){
	case "multiBeforehand":
		$faileData = "";
		$allCheck = 0;

		//모두 공백이면 그냥 넘어간다
		$end = count($_REQUEST["uid"]);
		for ($i=0; $i < $end; $i++){
			if (trim($_REQUEST["uid"][$i]) == ""){
				$allCheck++;
			}
		}

		if ($end > $allCheck){
			for ($j=0; $j < $end; $j++){

				$uno = explode("|", $_REQUEST["uid"][$j]);
				$uid = $uno[0];
				
				$sql = "select * from reader_certify_beforehand_table where uid = '".$uid."'";
				$res_t = mysql_query($sql);
				$data_array = mysql_fetch_row($res_t);
				$band_code = $data_array[1];
				$phone_num = str_replace("-","",$data_array[3]);
				$name = $data_array[2];
				$relation = $data_array[5];
		
				$sql = "
					select 
						count(*)
					from
						reader_certify_beforehand_table 
					where
						band_code = '".$band_code."'	
						and phone_num = '".$data_array[3]."'
						and application = 'Y'
					";
				$res = mysql_query($sql);
				$cnt = mysql_fetch_row($res);

				$sql = "
					select 
						count(*)
					from
						reader_certify_num_table 
					where
						band_code = '".$band_code."'	
						and phone_num = '".$phone_num."'
					";
				$res2 = mysql_query($sql);
				$cnt2 = mysql_fetch_row($res2);

				if($cnt[0] == 0 && $cnt2[0] == 0){
					$sql = "
						update reader_certify_beforehand_table set
							application = 'Y'
						where uid = '".$uid."'
					";	
					$result = mysql_query($sql);

					$sql = "
						insert into reader_certify_num_table set
							band_code = '".$band_code."',	
							name = '".$name."',
							phone_num = '".$phone_num."',
							relation = '".$relation."',
							register_date = '".$now."'
					";	
					
					$result = mysql_query($sql);

					if($result){
						$sql = "
						insert into reader_certify_num_log_table set
							band_code = '".$band_code."',	
							name = '".$name."',
							phone_num = '".$phone_num."',
							state = 'register',
							register_id = '".$member['user_id']."',
							register_name = '".$member['name']."',
							relation = '".$relation."',
							register_date = '".$now."'
						";	
						mysql_query($sql);
					}
					$overlapCnt++;
				}else{
					$faileCnt++;
				}
					
				
			}
		
		}

		if ($faileCnt > 0){
			$alertf1 = "fail: ".$faileCnt;
		}

		if ($overlapCnt > 0){
			$alertf2 = "success: ".$overlapCnt;
		}

?>
		<script>
		<?
		   if (trim($alertf1) != "" || trim($alertf2) != ""){
		?>
			  alert("<?= $alertf1 ?>\n<?= $alertf2 ?>");
		<?
		   }
		?>
		location.href="/index.php?spage=reader_certify_beforehand_list";
		</script>
<?		
		break;

	case "register" :
		$sql = "
			select 
				count(*)
			from
				reader_certify_beforehand_table 
			where
				band_code = '".$band_code."'	
				and phone_num = '".$phone_num."'
			";
		$res = mysql_query($sql);
		$cnt = mysql_fetch_row($res);

		$phone_num_t = str_replace("-","",$phone_num);

		$sql = "
			select 
				count(*)
			from
				reader_certify_num_table 
			where
				band_code = '".$band_code."'	
				and phone_num = '".$phone_num_t."'
			";
		$res2 = mysql_query($sql);
		$cnt2 = mysql_fetch_row($res2);
		
		if($cnt[0] == 0 && $cnt2[0] == 0){
			$sql = "
				insert into reader_certify_beforehand_table set
					band_code = '".$band_code."',	
					name = '".$name."',
					phone_num = '".$phone_num."',
					relation = '".$relation."',
					application = 'N',
					register_date = '".$now."'
			";	
			$result = mysql_query($sql);
			$txt = "등록하였습니다.";
			alert($txt);
		}else{
			$txt = "이미 등록되어 있습니다.";
			alert($txt);
		}
			TopR();
		break;

	case "modify" :
		$sql = "
			update reader_certify_beforehand_table set
				band_code = '".$band_code."',	
				name = '".$name."',
				phone_num = '".$phone_num."',
				relation = '".$relation."',
				register_date = '".$now."'
			where uid = '".$_uid."'
		";
		
		$result = mysql_query($sql);
		alert("수정하였습니다.");
		break;

	case "holding" :
		$sql = "
			update reader_certify_beforehand_table set
				application = 'Y'
			where uid = '".$_uid."'
		";	
		$result = mysql_query($sql);

		$sql = "
			select 
				*
			from
				reader_certify_beforehand_table 
			where
				uid = '".$_uid."'
			";
		$res = mysql_query($sql);
		$data = mysql_fetch_row($res);

		$phone = str_replace("-","",$data[3]);

		$sql = "select count(*) from reader_certify_beforehand_table where band_code = '".$data[1]."' and phone_num = '".$phone."'";
		$ress = mysql_query($sql);
		$certify_cnt = mysql_fetch_row($ress);

		$sql = "
			select 
				count(*)
			from
				reader_certify_num_table 
			where
				band_code = '".$data[1]."'	
				and phone_num = '".$phone_num."'
			";
		$res2 = mysql_query($sql);
		$cnt2 = mysql_fetch_row($res2);

		$sql = "select count(*) from reader_certify_num_table where name='".$data[2]."' and band_code = '".$data[1]."'";
			$rs_cnt = mysql_query($sql);
			$row_cnt = mysql_fetch_array($rs_cnt);

			if($data[5] == "본인" && $row_cnt[0] < 1){
				$sql = "
				insert into jy_leader set
				ld_id = '".$data[1]."',
				ld_passwd = password('".$data[1]."'),
				ld_passwd_real = '".$data[1]."',
				ld_name = '".$data[2]."',
				ld_htel = '".$phone."',
				ld_email = '이메일@.수정.com',
				register_date = '".mktime()."'
				";
				
				mysql_query($sql);
			}
		
		if($certify_cnt[0] == 0 && $cnt2[0] == 0){
			$sql = "
				insert into reader_certify_num_table set
					band_code = '".$data[1]."',	
					name = '".$data[2]."',
					phone_num = '".$phone."',
					relation = '".$data[5]."',
					register_date = '".$now."'
			";	
			$result = mysql_query($sql);

			if($result){
				$sql = "
				insert into reader_certify_num_log_table set
					band_code = '".$data[1]."',	
					name = '".$data[2]."',
					phone_num = '".$phone."',
					state = 'register',
					register_id = '".$member['user_id']."',
					register_name = '".$member['name']."',
					relation = '".$data[5]."',
					register_date = '".$now."'
				";	
				mysql_query($sql);
			}
			$txt = "승인하였습니다.";
			alert($txt);
		}else{
			$txt = "해당 계정 및 휴대폰 번호로 이미 등록되었습니다.\n리더CRM 본인인증 휴대폰번호 관리페이지에서 확인바랍니다.";
			alert($txt);
		}
?>
		<script>
		location.href="leader.certify.approve.php";
		</script>
<?
		break;
	
	case "holding_clear" :
		$sql = "
			update reader_certify_beforehand_table set
				application = 'N'
			where uid = '".$_uid."'
		";	
		$result = mysql_query($sql);

		$sql = "select * from reader_certify_beforehand_table where uid = '".$_uid."'";
		$ress = mysql_query($sql);
		$datas = mysql_fetch_row($ress);

		$sql = "
			update reader_certify_num_table set
				holding = 'Y'
			where
				band_code = '".$datas[1]."'
				and phone_num = '".$datas[3]."'
		";
		$txt = "승인보류 하였습니다.";
		alert($txt);
?>
		<script>
		location.href="/index.php?spage=reader_certify_beforehand_list";
		</script>
<?
		break;

	case "delete" :
		
		$sql = "
			delete from reader_certify_beforehand_table where uid = '".$_uid."'
		";	
		mysql_query($sql);
		$txt = "삭제하였습니다.";
		alert($txt);
?>
		<script>
		location.href="leader.certify.approve.php";
		</script>
<?
		break;
}
?>