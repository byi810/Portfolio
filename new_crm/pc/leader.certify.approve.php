<?php
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\badvance_registration_standby\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

$order_by = "order by band_code asc, register_date desc"; 

$where = "";
if($skey && $sval){
	switch($skey){
		case "name" :
			$where = " and name like '%$sval%'";
			break;
		case "phone" :
			$where = " and phone_num = '$sval'";
			break;
	}
}

if($band_code_se != "ALL" and $band_code_se != ""){
  $band_code_se_val = "band".$band_code_se;
  $where_site = " AND band_code = '$band_code_se_val'";
}else{
  $where_site = "";
}


$order_q = "
	SELECT 
		*
	FROM
		reader_certify_beforehand_table
	WHERE
		1=1
		and application = 'N'
		$where
		$where_site
		$order_by
";
$order=mysql_query($order_q);

if($order){
	$total_count = mysql_num_rows($order);
}else{
	$total_count = 0;
}
?>
<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="work.report.php">사전등록 승인대기</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>
	</div>
	<!-- / 타이틀상단 -->
</div>

<div class="common_page" style="margin:0 auto;border-bottom:0px;">
	<div class="layout_fix" style="margin:0;">
	<div class="cm_order_search" style="margin-top:20px;padding:15px">

			<div class="detail">
				<form name="staff_search_form" id="staff_search_form" action="<?=$PHP_SELF?>">
					<select name="skey" id="skey" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
						<option value="">::선택::</option>
						<option value="name" <?=($_REQUEST[skey] == 'name')?"selected":"";?>>이름</option>
						<option value="number" <?=($_REQUEST[skey] == 'number')?"selected":"";?>>전화번호</option>
					</select>
					<input type="text" name="sval" id="sval" value="<?=$_REQUEST['sval']?>" class="input_date" style="background:none;width:150px;padding:0 5px"/>
					<span class="button_pack"><a href="#none" onclick="staff_search();" class="btn_md_black">검색</a></span>
					<span class="button_pack" style="margin-left:0;"><a href="leader.certify.approve.php" class="btn_md_white">초기화</a></span>
					<span class="button_pack" style="margin-left:0;"><a href="#none" onclick="go_excel();" class="btn_md_color">엑셀다운</a></span>
				</form>
			</div>
		</div>
		<div class="cm_mypage_list list_posting">
			<table>
				<colgroup>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
				</colgroup>
				<thead>
					<tr>
						<th scope="col">소속밴드</th>
						<th scope="col">이름</th>
						<th scope="col">휴대폰번호</th>	
						<th scope="col">관계</th>
						<th scope="col">등록일자</th>
						<th scope="col">관리</th>
					</tr>
				</thead> 
				<tbody>
					<?
					while ($row=mysql_fetch_array($order)){
					$ld_date = date('Y-m-d', $v[register_date]);
					$ld_uid = $v[uid];
					?>
					<tr class="open_full">
						<td class=""><span class="texticon_pack"><?=$row[band_code]?></span></td>
						<td class=""><span class="texticon_pack"><?=$row[name]?></span></td>
						<td class=""><span class="texticon_pack"><?=$row[phone_num]?></span></td>
						<td class=""><span class="texticon_pack"><?=$row[relation]?></span></td>
						<td class=""><span class="texticon_pack"><?=date("Y-m-d",$row[register_date])?></span></td>
						<td class="">
							<span class="button_pack btn_close_conts"  style="padding-top: 10px;">
								<!--
								<a href="#none" onclick="approval_submit('<?=$ld_uid?>','approval', '<?=$v[band_code]?>', '<?=$v[name]?>', '<?=$v[phone_num]?>', '<?=$v[relation]?>');" class="btn_sm_color" style="float:none;">승인</a>
								<a href="#none" onclick="work_popup('<?=$ld_uid?>','modify');" class="btn_sm_white" style="float:none;">수정</a>
								<a href="#none" onclick="delete_submit('<?=$ld_uid?>','delete');" class="btn_sm_black" style="float:none;">삭제</a>
								-->
								<? if($row['application'] == "N"){?>
								<a href="#none" onclick="goHolding('<?=$row['uid']?>');" class="btn_sm_color" style="float:none;">승인</a>
								<? } else { ?>
								<a href="#none" onclick="goHolding_Clear('<?=$row['uid']?>');" class="btn_sm_color" style="float:none;">승인보류</a>
								<? } ?>
								<a href="#none" onclick="leader_Modify('<?=$row['uid']?>', 'approve');" class="btn_sm_black" style="float:none;">수정</a>
								<a href="#none" onclick="goDelete('<?=$row['uid']?>');" class="btn_sm_white" style="float:none;">삭제</a>
							</span>
						</td>
					</tr>
					<? } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="cm_paginate">
			<?=pagelisting($_REQUEST[listpg], $Page, $listmaxcount," ?${_PVS}&listpg=" , "Y")?>
		</div>
</div>

<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:500px;">
	
	<form name="work_write" method="post" action="leader.certify.beforehand.pro.php">">
	<input type="hidden" name="mode" id="mode" value="modify">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">업무일지 작성<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
								
									<input type="submit" title="" class="btn_md_color">
								</span>
							</li>
						</ul>
					</div>
				<!-- / 레이어팝업 버튼공간 -->

				</div>
			</div> 
		</div>
	<!-- / 하얀색박스공간 -->
	</form>
</div>

<script type="text/javascript">
function goHolding(uid){
	if(confirm("해당 계정을 승인 하시겠습니까?") == true){
		location.href="leader.certify.beforehand.pro.php?_mode=holding&uid="+uid;
	}
}
function goDelete(uid){
	if(confirm("해당 계정을 삭제 하시겠습니까?") == true){
		location.href="leader.certify.beforehand.pro.php?_mode=delete&uid="+uid;
	}
}
function goHolding_Clear(uid){
	if(confirm("해당 계정을 승인보류 하시겠습니까?") == true){
		location.href="leader.certify.beforehand.pro.php?_mode=holding_clear&uid="+uid;
	}
}
function leader_Modify(uid, mode){

	$('#authorized_mb_id').val(uid);
		$.post("leader.certify.check.php",{uid:uid, mode:mode}, function(data){
			if(data){
				console.log(data);
				$('#popup_area').html(data);
			}
		});
		$('#product_cancel_view_pop').lightbox_me({
			centered: true, closeEsc: false,
			onLoad: function() { },
			onClose: function(){ }
		});
}
function go_excel(){
	$('#staff_search_form').attr("action","leader.certify.excel.php");
	$('#staff_search_form').submit();
}

function staff_search(){
	$('#staff_search_form').attr("action","leader.certify.approve.php");
	$('#staff_search_form').submit();

}
</script>
<?
include_once "wrap.footer.php";
?>