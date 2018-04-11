<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bproduct_notify\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

$_code = ($_REQUEST[_code])?$_REQUEST[_code]:"";
$_mode = ($_REQUEST[_mode])?$_REQUEST[_mode]:"add";
$_mode_txt = ($_REQUEST[_mode] == 'modify')?"수정":"등록";

?>
<style>
.button_pack .btn_md_black:hover {
    background: #111 !important;
    border: 1px solid #111;
}
.cm_mypage_list .input_design {
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    height: 34px;
    line-height: 33px;
    text-indent: 10px;
    float: left;
    color: #666;
    border-radius: 5px;
    letter-spacing: 0px;
}
.cm_mypage_list {
    border-top: 0px solid #333;
    border-left: 0px;
    border-right: 0px;
}
.cm_mypage_list .input_design {
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    height: 34px;
    line-height: 33px;
    text-indent: 10px;
    float: left;
    color: #666;
    border-radius: 5px;
    letter-spacing: 0px;
}

.cm_mypage_list .btn_hide {
    right: 10px;
    bottom: 10px;
    width: 36px;
    height: 22px;
    text-align: center;
    background: transparent url("/skin/pc/images/addoption_ckecked.png") left bottom no-repeat;
}

.cm_mypage_list .if_option_hide .btn_hide {
    background-position: left top;
}

.cm_mypage_list .btn_hide input {
    margin-top: 4px;
    width: 0;
    height: 0
}
</style>

<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/skin/pc/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt>상품공지사항 <?=$_mode_txt?></dt>
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>
<div class="common_page">
	<div class="layout_fix">
		<div class="cm_member_title">
				<strong>기본</strong> 정보
				<div class="explain"><img src="/skin/pc/images/cm_images/member_form_bullet2.png" alt="필수" /> 표시된 것은 필수 항목입니다.</div>
			</div>
			<div class="cm_member_form">
			<? 
			$sql = "select * from odtNotification where uid = '".$_REQUEST[_code]."'";
			$row = mysql_fetch_array(mysql_query($sql));
			if($row[no_gubun] == "A"){
				$option_gubun = "1depth";
			}elseif($row[no_gubun] == "I"){
				$option_gubun = "2depth";
			}elseif($row[no_gubun] == "E"){
				$option_gubun = "3depth";
			}		
			?>
			<ul>
				<li class="ess">
					<span class="opt">공지 구분</span>
					<div class="value">
						<label><input type="radio" id = "option_type_chk"  name="option_type_chk" class="option_type_chk_value" value="1depth" <?=($option_gubun == '1depth')?"checked":"";?> />전체</label>
						<label><input type="radio" id = "option_type_chk"  name="option_type_chk" class="option_type_chk_value" value="2depth" <?=($option_gubun == '2depth')?"checked":"";?> />개별</label>
						<label><input type="radio" id = "option_type_chk"  name="option_type_chk" class="option_type_chk_value" value="3depth" <?=($option_gubun == '3depth')?"checked":"";?> />업체별</label>
					</div>
				</li>
			</ul>
		</div>

	<form name="frm" id="notify_frm" method="post" enctype="multipart/form-data" action="product.notify.pro.php/">
	<input type="hidden" id="gubun_mode" name = "gubun_mode" value="">
	<input type="hidden" id="mmode" name = "mmode" value="modify">
		<!-- 전체 공지 시작 -->
		<div class="cm_mypage_list list_posting" id="option_area1" <?=($row[no_gubun] == 'A')?"style='display:block'":"style='display:none'";?> style="border-left:0px; border-right:0px;">
			<div class="common_page" style="width:100%; border:0px; margin: 0 auto -30px auto;" >
				<div class="layout_fix">
					<div class="cm_member_form">
						<ul>

							<li class="ess">
								<span class="opt">공지사항 제목</span>
								<div class="value">
									<input type="text" name="no_notify_title_all" id="no_notify_title_all" value="<?=$row[no_notify_title]?>" class="input_design" />
								</div>
							</li>
							<li>
								<span class="opt">공지사항 내용</span>
								<div class="value">
									<textarea name="no_noti_text_all" id="no_noti_text_all" class="textarea_design" style="height:150px"><?=$row[no_noti_text]?></textarea>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- 전체 공지 끝 -->

		<!-- 개별 공지 시작 -->
		<div class="cm_mypage_list list_posting" id="option_area2" <?=($row[no_gubun] == 'I')?"style='display:block'":"style='display:none'";?> style="border-left:0px; border-right:0px;">
			<div class="common_page" style="width:100%; border:0px; margin: 0 auto -30px auto;" >
				<div class="layout_fix">
					<div class="cm_member_form">
						<ul>
							<li class="ess">
								<span class="opt">상품검색</span>
								<div class="value">
									<input type="text" id="keyword" class="input_design" style="width:150px"/>
									<span class="button_pack"  style="">
										<a href="#none" onclick="goSearch();" class="btn_md_black" style="float:none;">찾기</a>
									</span>
								</div>
							</li>	
							<li class="ess">
								<span class="opt">상품코드</span>
								<div class="value">
									<textarea name="no_goods_code_indi" id="no_goods_code_indi" class="textarea_design" style="height:50px" rows="3" placeholder="<?=$row[no_goods_code]?>"></textarea>
								</div>
							</li>
							<li class="ess">
								<span class="opt">공지사항 제목</span>
								<div class="value">
									<input type="text" name="no_notify_title_indi" id="no_notify_title_indi" value="<?=$row[no_notify_title]?>" class="input_design" />
								</div>
							</li>
							<li>
								<span class="opt">공지사항 내용</span>
								<div class="value">
									<textarea name="no_noti_text_indi" id="no_noti_text_indi" class="textarea_design" style="height:150px"><?=$row[no_noti_text]?></textarea>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- 개별 공지 끝 -->

		<!-- 업체 공지 시작 -->
		<div class="cm_mypage_list list_posting" id="option_area3" <?=($row[no_gubun] == 'E')?"style='display:block'":"style='display:none'";?> style="border-left:0px; border-right:0px;">
			<div class="common_page" style="width:100%; border:0px; margin: 0 auto -30px auto;" >
				<div class="layout_fix">
					<div class="cm_member_form">
						<ul>
							<li class="ess">
								<span class="opt">업체검색</span>
								<div class="value">
									<input type="text" id="keyword_enterprise" class="input_design" style="width:150px;"/>
									<span class="button_pack"  style="">
										<a href="#none" onclick="goSearch_enterprise();" class="btn_md_black" style="float:none;">찾기</a>
									</span>
								</div>
							</li>	
							<li class="ess">
								<span class="opt">업체코드</span>
								<div class="value">
									<textarea name="no_goods_code_enter" id="no_goods_code_enter" class="textarea_design"  style="height:50px" placeholder="<?=$row[no_enterprise_code]?>"></textarea>
								</div>
							</li>
							<li class="ess">
								<span class="opt">공지사항 제목</span>
								<div class="value">
									<input type="text" name="no_notify_title_enter" id="no_notify_title_enter" value="<?=$row[no_notify_title]?>" class="input_design" />
								</div>
							</li>
							<li>
								<span class="opt">공지사항 내용</span>
								<div class="value">
									<textarea name="no_noti_text_enter" class="textarea_design" id="no_noti_text_enter" style="height:150px"><?=$row[no_noti_text]?></textarea>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- 업체 공지 끝 -->

		<!-- 이미지 시작 -->

		
		<div id="notify_image" style="display:none;">
			<div class="cm_member_title">
				<strong>상품공지</strong> 이미지
				<div class="explain"><img src="/skin/pc/images/cm_images/member_form_bullet2.png" alt="필수" /> 표시된 것은 필수 항목입니다.</div>
			</div>
			<div class = "cm_member_form">
				<ul>
					<li class="ess" id="detail_info_img_area">
						<span class="opt">상품 공지 이미지</span>
						<?
						if($row[detail_info_img]){ 
							$detail_info_img = explode("|",$row[detail_info_img]);
							$j = 1;
							for($i=0;$i<count($detail_info_img)-1;$i++){
						?>
							<div class="value detail_info_img" style="margin-left:220px;padding:14.5px;" id="detail_info_img_<?=$j?>">
								<span class='button_pack' style='margin-left:0;'>
									<a href='#none' class='btn_md_white' style='position:absolute;left: 236px;height:29px;corson:hand'>
										<span style='color:red;font-weight:bold'>+</span> 첨부
									</a>
									<input type='file' name='detail_info_img[]' id='detail_info_img' class='btn_md_white' style='opacity:0;height:29px;padding:0 !important;width: 75px;'>
								</span>
								<label style="margin-left:14px;"><input type='checkbox' name="detail_info_img_del[<?=$detail_info_img[$i]?>]" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
								<?=$detail_info_img[$i]?>

							</div>
						<?
							$j++;
							}
						?>
							<div class="value detail_info_img" style="margin-left:220px;padding:14.5px;" id="detail_info_img_<?=$j?>" >
								<span class='button_pack' style='margin-left:0;'><a href='#none' class='btn_md_white' style='position:absolute;left: 236px;height:29px;corson:hand'><span style='color:red;font-weight:bold'>+</span> 첨부</a><input type='file' name='detail_info_img[]' id='detail_info_img' class='btn_md_white' style='opacity:0;height:29px;padding:0 !important;width: 75px;'></span><span class="button_pack"><a href="#none" onclick="detail_img_add();return false;" style="height:29px;" class="btn_md_white">추가<span class="edge"></span></a></span>
							</div>	
						<?}else{?>
						<div class="value detail_info_img" style="margin-left:220px;padding:14.5px;" id='detail_info_img_1'>
							<span class='button_pack' style='margin-left:0;'><a href='#none' class='btn_md_white' style='position:absolute;left: 236px;height:29px;corson:hand'><span style='color:red;font-weight:bold'>+</span> 첨부</a><input type='file' name='detail_info_img[]' id='detail_info_img' class='btn_md_white' style='opacity:0;height:29px;padding:0 !important;width: 75px;'></span><span class="button_pack"><a href="#none" onclick="detail_img_add();return false;" style="height:29px;" class="btn_md_white">추가<span class="edge"></span></a></span>
						<? if($row[no_noti_image1]){ ?>
							<input type="hidden" name="no_banner_image_old" value="<?=$row[no_noti_image1]?>">
							<label style="margin-left:14px;"><input type='checkbox' name="no_banner_image_del" value="Y" style="margin: 10px 5px 0 0 !important;">삭제</label>
							<?=str_replace("/home/jooyon/CRM/uploads/productimg", "", $row[no_noti_image1])?>
						<?}?>
						</div>
						<?}?>
					</li>
				</ul>
			</div>
		</div>
		<!-- 이미지 끝 -->
	</form>
<div class="cm_bottom_button">
	<ul>
		<li><span class="button_pack"><a href="#none" onclick="notify_submit();return false;" class="btn_lg_color"><?=$_mode_txt?></a></span></li>
		<li><span class="button_pack"><a href="product.notify.list.php" class="btn_lg_black">목록</a></span></li>
	</ul>
</div>



<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:500px;">
	<div class="title_box">공지사항 개별 상품 선택<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
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


<div class="cm_ly_pop_tp" id="product_cancel_view_pop2" style="display:none;width:500px;">
	<div class="title_box">공지사항 업체 상품 선택<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
		<div class="inner_box">
			<div id="popup_area2"></div>
			<div class="cm_bottom_button">
				<ul>
					<li>
						<span class="button_pack">
							<input type="button" onclick="apply_input_enterprise();" value="적용" class="close btn_md_color"> 
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
// 옵션 타이별로 보이기
//$('.option_type_chk_value').click(function(){
	var otc = $('.option_type_chk_value:checked').val();

	if(otc == '1depth'){
		//1depth일때 mode값 넣기
		$('#gubun_mode').val("all");
		$('#option_area1').show();
		$('#depth_1_area').show();
		$('#notify_image').show();
		$('#depth_2_area').hide();
		$('#depth_3_area').hide();
	}else if(otc == '2depth'){
		$('#gubun_mode').val("individual");
		$('#option_area2').show();
		$('#depth_1_area').hide();
		$('#depth_2_area').show();
		$('#notify_image').show();
		$('#depth_3_area').hide();
	}else{
		$('#gubun_mode').val("enterprise");
		$('#option_area3').show();
		$('#depth_1_area').hide();
		$('#depth_2_area').hide();
		$('#depth_3_area').show();
		$('#notify_image').show();
	}
//});

function goSearch(){
	var mode = "Individual";
	var keyword = $('#keyword').val();
		$.post("product.notify.check.php",{keyword:keyword, mode:mode}, function(data){
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
function goSearch_enterprise(){

	var keyword = $('#keyword_enterprise').val();
	var mode = "Enterprise";

		$.post("product.notify.check.php",{keyword:keyword, mode:mode}, function(data){
			if(data){
				$('#popup_area2').html(data);
			}
		});
		$('#product_cancel_view_pop2').lightbox_me({
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
	$('#no_goods_code_indi').append(res);
}
function apply_input_enterprise(){
	var checked = [];
	
	$("input[name='check_code[]']:checked").each(function ()
	{
		checked.push($(this).val());
	});

	var res = checked.join('');
	$('#no_goods_code_enter').append(res);
}

function notify_submit(){
	var otc = $('.option_type_chk_value:checked').val();

	if(otc == "1depth"){
		if($('#no_notify_title_all').val() == ''){
			alert("공지사항 제목을 입력해주세요.");
			$('#no_notify_title_all').focus();
		return;
		}
		if($('#no_noti_text_all').val() == '' && $('#detail_info_img').val() == ''){
			alert("공지사항 내용 혹은 파일을 입력해주세요.");
			$('#no_noti_text_all').focus();
		return;
		}
	}else if(otc == "2depth"){
		if($('#no_goods_code_indi').val() == ''){
			alert("상품코드를 입력해주세요.");
			$('#keyword').focus();
		return;
		}
		if($('#no_notify_title_indi').val() == ''){
			alert("공지사항 제목을 입력해주세요.");
			$('#no_notify_title_indi').focus();
		return;
		}
		if($('#no_noti_text_indi').val() == '' && $('#detail_info_img').val() == ''){
			alert("공지사항 내용 혹은 파일을 입력해주세요.");
			$('#no_noti_text_indi').focus();
		return;
		}
	}else if(otc == "3depth"){
		no_goods_code_enter
		if($('#no_goods_code_enter').val() == ''){
			alert("업체코드를 입력해주세요.");
			$('#keyword_enterprise').focus();
		return;
		}
		if($('#no_notify_title_enter').val() == ''){
			alert("공지사항 제목을 입력해주세요.");
			$('#no_notify_title_enter').focus();
		return;
		}
		if($('#no_noti_text_enter').val() == '' && $('#detail_info_img').val() == ''){
			alert("공지사항 내용 혹은 파일을 입력해주세요.");
			$('#no_noti_text_enter').focus();
		return;
		}
	}
	$('#notify_frm').submit();
}

function detail_img_add(){
	var otc = $('.option_type_chk_value:checked').val();
		var NowCntNodes=eval($(".detail_info_img:last").attr('id').replace("detail_info_img_",""));
		if(NowCntNodes<1){NowCntNodes=0;}
		var AddCntNodes=NowCntNodes+1;
		$('#detail_info_img_area').append('<div class="value detail_info_img" style="margin-left:220px;padding:14.5px;" id="detail_info_img_'+AddCntNodes+'"></div>');
		$('#detail_info_img_'+AddCntNodes).append("<span class='button_pack' style='margin-left:0;'><a href='#none' class='btn_md_white' style='position:absolute;left: 236px;height:29px;corson:hand'><span style='color:red;font-weight:bold'>+</span> 첨부</a><input type='file' name='detail_info_img[]' id='detail_info_img' class='btn_md_white' style='opacity:0;height:29px;padding:0 !important;width: 75px;'></span>");
		$('#detail_info_img_'+AddCntNodes).append("<span class='button_pack'><a href='#none' style='height:29px;' onclick='delNotice(\"detail_info_img_"+AddCntNodes+"\");return false;' class='btn_md_white'>삭제<span class='edge'></span></a></span>");
}

// 상세설명이미지 삭제
function delNotice(id) {
	if(confirm('정말 삭제 하시겠습니까?')){
		$("#"+id).remove();
	}
}
</script>