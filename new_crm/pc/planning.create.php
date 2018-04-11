<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bplanning\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

$_code = ($_REQUEST[_code])?$_REQUEST[_code]:"";
$_mode = ($_REQUEST[_mode])?$_REQUEST[_mode]:"add";
$_mode_txt = ($_REQUEST[_mode] == 'modify')?"수정":"등록";


if($_mode == "modify"){
	$sql = "
		select * from odtPlanning where uid = '".$_code."'
	";
	$row_modify = mysql_fetch_array(mysql_query($sql));
}
?>
<style>
.button_pack .btn_md_black:hover {
    background: #111 !important;
    border: 1px solid #111;
}
</style>

<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/skin/pc/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt>기획전 <?=$_mode_txt?></dt>
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>
<div class="common_page">
	<div class="layout_fix">
		<form name="frm" id="planning_frm" method="post" enctype="multipart/form-data" action="planning.pro.php">
			<input type="hidden" name="mode" value="<?=$_mode?>"/>
			<input type="hidden" name="code" value="<?=$_code?>"/>
			<div class="cm_member_title">
					<strong>기본</strong> 정보
					<div class="explain"><img src="/skin/pc/images/cm_images/member_form_bullet2.png" alt="필수" /> 표시된 것은 필수 항목입니다.</div>
				</div>
				<div class="cm_member_form">
					<ul>
						<li class="ess">
							<span class="opt">기획전 제목</span>
							<div class="value">
								<input type="text" name="mp_subject" id="mp_subject" value="<?=$row_modify[mp_subject]?>" class="input_design" />
							</div>
						</li>
						<li class="ess double">
							<span class="opt">기획전 기간</span>
							<div class="value" style="">
								
								<div class="sale_type">
									<input type="text" name="sale_date" id="sale_date" value='<?=$row_modify[mp_sdate]?>' class="input_design" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
									<input type="hidden" name="sale_dateh" id="sale_dateh" value='<?=sprintf("%02d" , $row['sale_dateh'])?>' class="input_design" style="width:20px;"  /><!-- 시 -->
									<input type="hidden" name="sale_datem" id="sale_datem" value='<?=sprintf("%02d" , $row['sale_datem'])?>' class="input_design" style="width:20px;"  /><!-- 분 -->
									<span class="dash" style="background:none;margin:0 9px;">~</span>
									<input type="text" name="sale_enddate" id="sale_enddate" value='<?=$row_modify[mp_edate]?>' class="input_design" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
									<input type="hidden" name="sale_enddateh" id="sale_enddateh" value='<?=($row['sale_enddateh'] ? sprintf("%02d" , $row['sale_enddateh']) : "23")?>' class="input_design" style="width:20px;"  /><!-- 시 -->
									<input type="hidden" name="sale_enddatem" id="sale_enddatem" value='<?=($row['sale_enddatem'] ? sprintf("%02d" , $row['sale_enddatem']) : "59")?>' class="input_design" style="width:20px;"  /><!-- 분 -->
								</div>
							</div>
						</li>
						<li class="ess double">
							<span class="opt">노출여부</span>
							<div class="value">
								<label><input type="radio" name="mp_open" id="mp_open" value="Y" <?=($row_modify[mp_open] == 'Y')?"checked":"";?> />노출</label>
								<label><input type="radio" name="mp_open" id="mp_open" value="N" <?=($row_modify[mp_open] == 'N' || !$row_modify[mp_open])?"checked":"";?> />숨김</label>
							</div>
						</li>
						<li class="ess double">
							<span class="opt">노출사이트</span>
							<div class="value" style="padding:14.5px;">
								<select name="mp_category" id="mp_category" class='add_option add_option_chk' style='width:150px;height:30px;float:left;margin-right:10px;'>
									<option value="">:::::선택:::::</option>
									<option value="band09" <?=($row_modify[mp_category] == 'band09')?"selected":"";?>>모닝몰</option>
									<option value="wagol" <?=($row_modify[mp_category] == 'wagol')?"selected":"";?>>와골</option>
									<option value="momshild" <?=($row_modify[mp_category] == 'momshild')?"selected":"";?>>맘쉴드</option>
								</select>
							</div>
						</li>
						<li class="ess double">
							<span class="opt">다이렉트링크(와골)</span>
							<div class="value">
								<input type="text" name="mp_direct_link" id="mp_direct_link" value="<?=$row_modify[mp_direct_link]?>" class="input_design" />
							</div>
						</li>


						<li class="ess double">
						<span class="opt">배너 이미지(PC)</span>
						<div class="value" style="padding:14.5px;">
							<span class='button_pack' style='margin-left:0;'>
								<input type='file' name='mp_banner_image' id='mp_banner_image' class='btn_md_white' style='opacity:100;height:20px;padding:0 !important;width:65px;'>
								<? if($row_modify[mp_banner_image]){?>
								<input type="hidden" name="mp_banner_image_old" value="<?=$row_modify[mp_banner_image]?>">
								<label style="margin-left:14px;"><input type='checkbox' name="mp_banner_image_del" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
								<?=str_replace("/home/jooyon/CRM/uploads/productimg", "", $row_modify[mp_banner_image])?>
								<?}?>
							</span>
						</div>
					</li>
					<li class="ess double">
						<span class="opt">배너 이미지(모바일)</span>
						<div class="value" style="padding:14.5px;">
							<span class='button_pack' style='margin-left:0;'>
								<input type='file' name='mp_banner_image_m' id='mp_banner_image_m' class='btn_md_white' style='opacity:100;height:20px;padding:0 !important;width:65px;'>
								<? if($row_modify[mp_banner_image_m]){?>
								<input type="hidden" name="mp_banner_image_m_old" value="<?=$row_modify[mp_banner_image_m]?>">
								<label style="margin-left:14px;"><input type='checkbox' name="mp_banner_image_m_del" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
								<?=str_replace("/home/jooyon/CRM/uploads/productimg", "", $row_modify[mp_banner_image_m])?>
								<?}?>
							</span>
						</div>
					</li>

					<li class="ess double">
						<span class="opt">상세 이미지(PC)</span>
						<div class="value" style="padding:14.5px;">
							<span class='button_pack' style='margin-left:0;'>
								<input type='file' name='mp_detail_image' id='mp_detail_image' class='btn_md_white' style='opacity:100;height:20px;padding:0 !important;width:65px;'>
								<? if($row_modify[mp_detail_image]){?>
								<input type="hidden" name="mp_detail_image_old" value="<?=$row_modify[mp_detail_image]?>">
								<label style="margin-left:14px;"><input type='checkbox' name="mp_detail_image_del" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
								<?=str_replace("/home/jooyon/CRM/uploads/productimg", "", $row_modify[mp_detail_image])?>
								<?}?>
							</span>
						</div>
					</li>
					<li class="ess double">
						<span class="opt">상세 이미지(모바일)</span>
						<div class="value" style="padding:14.5px;">
							<span class='button_pack' style='margin-left:0;'>
								<input type='file' name='mp_detail_image_m' id='mp_detail_image_m' class='btn_md_white' style='opacity:100;height:20px;padding:0 !important;width:65px;'>
								<? if($row_modify[mp_detail_image_m]){?>
								<input type="hidden" name="mp_detail_image_m_old" value="<?=$row_modify[mp_detail_image_m]?>">
								<label style="margin-left:14px;"><input type='checkbox' name="mp_detail_image_m_del" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
								<?=str_replace("/home/jooyon/CRM/uploads/productimg", "", $row_modify[mp_detail_image_m])?>
								<?}?>
							</span>
						</div>
					</li>
						<li class="ess">
							<span class="opt">상품검색</span>
							<div class="value">
								<input type="text" id="keyword" class="input_design" style="width:150px"/>
								<span class="button_pack btn_close_conts"  style="">
									<a href="#none" onclick="goSearch('<?=$row_modify[mp_product]?>');" class="btn_md_black" style="float:none;">찾기</a>
								</span>
							</div>
						</li>	
						<li class="ess">
							<span class="opt">상품코드</span>
							<div class="value">
								<textarea name="pcode" class="textarea_design" id="pcode_value" style="height:150px" readonly><?=$row_modify[mp_product]?></textarea>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="cm_bottom_button">
				<ul>
					<li><span class="button_pack"><a href="#none" onclick="planning_submit();return false;" class="btn_lg_color"><?=$_mode_txt?></a></span></li>
					<li><span class="button_pack"><a href="planning.list.php" class="btn_lg_black">목록</a></span></li>
				</ul>
			</div>
		</form>
	</div>
</div>


<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:500px;">
	<div class="title_box">기획전 상품 선택<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
		<div class="inner_box">

			<div id="popup_area"></div>

			<div class="cm_bottom_button">
				<ul>
					<li>
						<span class="button_pack">
							<input type="button" onclick="apply_input();" value="적용" class="close btn_md_color"> 
						</span>
					</li>
				</ul>
			</div>
			</div>
		</div> 
	</div>
</div>

<?
include_once "wrap.footer.php";
?>
<script language="JavaScript" src="/skin/pc/js/product.js"></script>
<link rel="stylesheet" href="/include/js/jquery/jqueryui/jquery-ui.min.css" type="text/css">
<script src="/include/js/jquery/jqueryui/jquery-ui.min.js"></script>
<script src="/include/js/jquery/jqueryui/jquery.ui.datepicker-ko.js"></script>
<script>
$(function() {
    $("#sale_date").datepicker({changeMonth: true, changeYear: true });
    $("#sale_date").datepicker( "option", "dateFormat", "yy-mm-dd" );
    $("#sale_date").datepicker( "option",$.datepicker.regional["ko"] );

    $("#sale_enddate").datepicker({changeMonth: true, changeYear: true });
    $("#sale_enddate").datepicker( "option", "dateFormat", "yy-mm-dd" );
    $("#sale_enddate").datepicker( "option",$.datepicker.regional["ko"] );

    $("#id_expire").datepicker({changeMonth: true, changeYear: true });
    $("#id_expire").datepicker( "option", "dateFormat", "yy-mm-dd" );
    $("#id_expire").datepicker( "option",$.datepicker.regional["ko"] );
});


function goSearch(goods_code){

	var keyword = $('#keyword').val();
		$.post("product.search.check.php",{keyword:keyword, goods_code:goods_code}, function(data){
			if(data){
				$('#popup_area').html(data);
			}
		});
		$('#product_cancel_view_pop').lightbox_me({
			centered: true, closeEsc: false,
			onLoad: function() { },
			onClose: function(){ }
		});
}

function apply_input(){
	var checked = [];

	$("input[name='check_code[]']:checked").each(function ()
	{
		checked.push($(this).val());
	});

	var res = checked.join('');
	$('#pcode_value').append(res);
}

function planning_submit(){

	if($('#mp_subject').val() == ''){
		alert("기획전 제목을 입력해주세요.");
		$('#mp_subject').focus();
		return;
	}

	if($('#sale_date').val() == ''){
		alert("기획전 시작일을 입력해주세요.");
		$('#sale_date').focus();
		return;
	}
	
	if($('#sale_enddate').val() == ''){
		alert("기획전 종료일을 입력해주세요.");
		$('#sale_enddate').focus();
		return;
	}

	if($('#mp_category').val() == ''){
		alert("노출 사이트를 선택해주세요.");
		$('#mp_category').focus();
		return;
	}
	if($('#mp_direct_link').val() == ''){
		alert("다이렉트 링크를 입력해주세요.");
		$('#mp_direct_link').focus();
		return;
	}
	/*
	if($('#mp_banner_image').val() == ''){
		alert("배너이미지(PC)를 등록해주세요.");
		$('#mp_banner_image').focus();
		return;
	}
	if($('#mp_banner_image_m').val() == ''){
		alert("배너이미지(모바일)를 등록해주세요.");
		$('#mp_banner_image_m').focus();
		return;
	}
	if($('#mp_detail_image').val() == ''){
		alert("상세이미지(PC)를 등록해주세요.");
		$('#mp_detail_image').focus();
		return;
	}
	if($('#mp_detail_image_m').val() == ''){
		alert("상세이미지(모바일)를 등록해주세요.");
		$('#mp_detail_image_m').focus();
		return;
	}
	*/
	if($('#pcode_value').val() == ''){
		alert("상품코드를 입력해주세요.");
		$('#pcode_value').focus();
		return;
	}
	$('#planning_frm').submit();
}

</script>