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
$register_date = date("Y-m-d H:i:s"); 


switch($_mode){
	case "register" :
		$sql = "
			select 
				count(*)
			from
				reader_certify_num_table 
			where
				band_code = '".$band_code."'	
				and phone_num = '".$phone_num."'
			";
		$res = mysql_query($sql);
		$cnt = mysql_fetch_row($res);
		
		if($cnt[0] == 0){
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
					relation = '".$relation."',
					state = 'register',
					register_id = '".$member['user_id']."',
					register_name = '".$member['name']."',
					register_date = '".$now."'
				";	
				mysql_query($sql);
			}

			alert("등록하였습니다.");
		}else{
			alert("이미 등록되어 있습니다.");
		}
			TopR();
		break;

	case "modify" :
		$sql = "
			update reader_certify_num_table set
				band_code = '".$band_code."',	
				name = '".$name."',
				phone_num = '".$phone_num."',
				relation = '".$relation."',
				register_date = '".$now."'
			where uid = '".$_uid."'
		";	
		$result = mysql_query($sql);

		if($result){
			$sql = "
			insert into reader_certify_num_log_table set
				band_code = '".$band_code."',	
				name = '".$name."',
				phone_num = '".$phone_num."',
				relation = '".$relation."',
				state = 'modify',
				register_id = '".$member['user_id']."',
				register_name = '".$member['name']."',
				register_date = '".$now."'
			";	
			mysql_query($sql);
		}

		alert("수정하였습니다.");
		TopR();
		break;

	case "holding" :
		
		$sql = "
			update reader_certify_num_table set
				holding = 'Y'
			where uid = '".$_uid."'
		";	
		$result = mysql_query($sql);

		if($result){
			
			$contents = $_REQUEST['contents']." - ".$register_date." [".$row_staff[mb_name]."]\n";

			$sql = "select count(*) from reader_certify_contents_table where parent_uid = '".$_uid."'";
			$res1 = mysql_query($sql);
			$cnt1 = mysql_fetch_row($res1);

			if($cnt1[0] == 0){
				$sql = "
					insert into reader_certify_contents_table set 
						parent_uid = '".$_uid."',
						contents = '".$contents."',
						register_date = '".$now."'
				";
				mysql_query($sql);
			}else{
				//$contents = $cnt1[2]."\n".$contents;
				$sql = "
					update reader_certify_contents_table set 
						contents = '".$contents."'
					where
						parent_uid = '".$_uid."'
				";
				mysql_query($sql);
			}

			$sql = "select * from reader_certify_num_table where uid = '".$_uid."'";
			$res = mysql_query($sql);
			$rows = mysql_fetch_row($res);
		
			$sql = "
			insert into reader_certify_num_log_table set
				band_code = '".$rows[1]."',	
				name = '".$rows[2]."',
				phone_num = '".$rows[3]."',
				relation = '".$rows[6]."',
				state = 'holding',
				holding = 'Y',
				register_id = '".$member['user_id']."',
				register_name = '".$member['name']."',
				register_date = '".$now."'
			";	
			mysql_query($sql);
		}

		alert("접속제한 하였습니다.");
		//TopR();
?>
		<script>
		//location.href="/index.php?spage=reader_certify_num_list";
		</script>
<?
		break;
	
	case "holding_clear" :
		$sql = "
			update reader_certify_num_table set
				holding = 'N'
			where uid = '".$_uid."'
		";	
		$result = mysql_query($sql);

		if($result){
			$contents = $_REQUEST['contents']." - ".$register_date." [".$row_staff[mb_name]."]\n";

			$sql = "select count(*) from reader_certify_contents_table where parent_uid = '".$_uid."'";
			$res2 = mysql_query($sql);
			$cnt2 = mysql_fetch_row($res2);

			if($cnt2[0] == 0){
				$sql = "
					insert into reader_certify_contents_table set 
						parent_uid = '".$_uid."',
						contents = '".$contents."',
						register_date = '".$now."'
				";
				mysql_query($sql);
			}else{
				//$contents = $cnt1[2]."\n".$contents;
				$sql = "
					update reader_certify_contents_table set 
						contents = '".$contents."'
					where
						parent_uid = '".$_uid."'
				";
				mysql_query($sql);
			}

			$sql = "select * from reader_certify_num_table where uid = '".$_uid."'";
			$res = mysql_query($sql);
			$rows = mysql_fetch_row($res);
		
			$sql = "
			insert into reader_certify_num_log_table set
				band_code = '".$rows[1]."',	
				name = '".$rows[2]."',
				phone_num = '".$rows[3]."',
				relation = '".$rows[6]."',
				state = 'holding_clear',
				holding = 'N',
				register_id = '".$member['user_id']."',
				register_name = '".$member['name']."',
				register_date = '".$now."'
			";	
			mysql_query($sql);
		}

		alert("접속제한을 해제하였습니다.");
		//TopR();
?>
		<script>
		//location.href="/index.php?spage=reader_certify_num_list";
		</script>
<?
		break;

	case "delete" :
		$sql = "select * from reader_certify_num_table where uid = '".$_uid."'";
		$res = mysql_query($sql);
		$rows = mysql_fetch_row($res);
	
		$sql = "
		insert into reader_certify_num_log_table set
			band_code = '".$rows[1]."',	
			name = '".$rows[2]."',
			phone_num = '".$rows[3]."',
			relation = '".$rows[6]."',
			state = 'delete',
			register_id = '".$member['user_id']."',
			register_name = '".$member['name']."',
			register_date = '".$now."'
		";	
		mysql_query($sql);

		$sql = "
			delete from reader_certify_num_table where uid = '".$_uid."'
		";	
		mysql_query($sql);

		alert("삭제하였습니다.");
?>
		<script>
		location.href="/index.php?spage=reader_certify_num_list";
		</script>
<?
		break;
}
?>