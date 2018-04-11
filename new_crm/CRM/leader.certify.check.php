<?
include_once "include/inc.php";
$now=date("Y.m.d");

if($_REQUEST['mode'] == "approve"){
$sql = "select * from reader_certify_beforehand_table where uid='".$_REQUEST['uid']."'";
$res = mysql_query($sql);
$row = mysql_fetch_row($res);
$row_band_code = str_replace("band89", "",$row[1]);
$todate = date("Y-m-d", mktime());
$html = "
	<input type='hidden' name='_mode' value='modify'>
	<input type='hidden' name='uid' value='".$row[0]."'>
	<div class='cm_member_form'>
		<ul>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>밴드코드</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='band_code_se' id='band_code_se' value=".$row_band_code."  class='input_design'/>
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>성함</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='name' id='name' value=".$row[2]." class='input_design' />
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>번호</span>
				<div class='value' style='text-align: center;'>
					<input type='tel' name='phone_num' id='phone_num' value=".$row[3]." class='input_design' style='width:100%' maxlength='13' />
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>관계</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='relation' id='relation' value=".$row[5]." class='input_design' />
				</div>
			</li>
		</ul>
	</div>
";		
}else if ($_REQUEST['mode'] == "holding"){
$sql = "select * from reader_certify_num_table where uid='".$_REQUEST['uid']."'";
$res = mysql_query($sql);
$row = mysql_fetch_row($res);
$row_band_code = str_replace("band89", "",$row[1]);
$todate = date("Y-m-d", mktime());

$html = "
	<input type='hidden' name='_mode' value='modify'>
	<input type='hidden' name='uid' value='".$row[0]."'>
	<div class='cm_member_form'>
		<ul>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>밴드코드</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='band_code_se' id='band_code_se' value=".$row_band_code."  class='input_design'/>
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>성함</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='name' id='name' value=".$row[2]." class='input_design' />
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>번호</span>
				<div class='value' style='text-align: center;'>
					<input type='tel' name='phone_num' id='phone_num' value=".$row[3]." class='input_design' style='width:100%' maxlength='13' />
				</div>
			</li>
			<li class=''>
				<span class='opt' style='background:none;padding-left:0px'>관계</span>
				<div class='value' style='text-align: center;'>
					<input type='text' name='relation' id='relation' value=".$row[6]." class='input_design' />
				</div>
			</li>
		</ul>
	</div>
";		

}
echo $html;
?>