<?
include_once "include/inc.php";
$sql = "
select * from jy_work where uid = '".$_REQUEST['mb_id']."'
";
$rs_work = mysql_query($sql);
$row_work = mysql_fetch_array($rs_work);
$todate = date("Y-m-d", mktime());
	switch ($_REQUEST[mode]){
	case "show":
	$html = "
		<input type='hidden' name='wr_team' id='wr_team' value='".$row_staff['mb_team']."'>
		<input type='hidden' name='wr_department' id='wr_department' value='".$row_staff['mb_department']."'>
		<input type='hidden' name='mode' id='mode' value='show'>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>날짜</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='register_date' id='register_date'>".$todate."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>담당자</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='wr_name' id='wr_name'>".$row_staff['mb_name']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>파일</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='wr_name' id='wr_name'>".$row_work['wr_file_name']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>제목</span>
					<div class='value' style='text-align: left;'>
						<input type='text' name='wr_title' id='wr_title' value=".$row_work['wr_title']." class='input_design' readonly />
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>내용</span>
					<div class='value' style='text-align: left;'>
						<textarea name='wr_comment' id='wr_comment'  class='textarea_design' style='height:200px' readonly>".$row_work['wr_comment']."</textarea>
					</div>
				</li>
			</ul>
		</div>
	";		
	break;

	case "create":
	$html = "
		<input type='hidden' name='wr_team' id='wr_team' value='".$row_staff['mb_team']."'>
		<input type='hidden' name='wr_department' id='wr_department' value='".$row_staff['mb_department']."'>
		<input type='hidden' name='mode' id='mode' value='create'>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>날짜</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='register_date' id='register_date'>".$todate."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>담당자</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='wr_name' id='wr_name'>".$row_staff['mb_name']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>파일</span>
					<div class='value' style='text-align: left;'>
						<input type='file' name='wr_file' id='wr_file'class=input>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>제목</span>
					<div class='value' style='text-align: left;'>
						<input type='text' name='wr_title' id='wr_title' value='' class='input_design' />
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>내용</span>
					<div class='value' style='text-align: left;'>
						<textarea name='wr_comment' id='wr_comment' value='' class='textarea_design' style='height:200px' /></textarea>
					</div>
				</li>
			</ul>
		</div>
	";		
	break;

	case "modify":
	$html = "
		<input type='hidden' name='wr_team' id='wr_team' value='".$row_staff['mb_team']."'>
		<input type='hidden' name='wr_department' id='wr_department' value='".$row_staff['mb_department']."'>
		<input type='hidden' name='mode' id='mode' value='modify'>
		<input type='text' name='uid' id='uid' value='".$_REQUEST['mb_id']."'>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>날짜</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='register_date' id='register_date'>".$todate."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>담당자</span>
					<div class='value' style='text-align: left;'>
						<span class='texticon_pack' name='wr_name' id='wr_name'>".$row_staff['mb_name']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>파일</span>
					<div class='value' style='text-align: left;'>
						<input type='file' name='wr_file' id='wr_file'class=input>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>제목</span>
					<div class='value' style='text-align: left;'>
						<input type='text' name='wr_title' id='wr_title' value=".$row_work['wr_title']." class='input_design' />
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>내용</span>
					<div class='value' style='text-align: left;'>
						<textarea name='wr_comment' id='wr_comment' class='textarea_design' style='height:200px'>".$row_work['wr_comment']."</textarea>
					</div>
				</li>
			</ul>
		</div>
		
	";		
	break;
}

echo $html;
?>