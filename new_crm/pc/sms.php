<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bsms\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

$wheretxt = "where 1=1";
if($_REQUEST['skey'] =="" && $_REQUEST['skey_sub'] ==""){
	$wheretxt .= " and sms_type = '결제완료' and sms_type_sub = '무통장'";
}elseif($_REQUEST['skey'] == "주문완료" && $_REQUEST['skey_sub'] == ""){
	$wheretxt .= " and sms_type = '주문완료' and sms_type_sub = '입금'";
}elseif($_REQUEST['skey'] == "출고/발주" && $_REQUEST['skey_sub'] == ""){
	$wheretxt .= " and sms_type = '출고/발주' and sms_type_sub = '무통장'";
}elseif($_REQUEST['skey'] && $_REQUEST['skey_sub']){
	if($_REQUEST['skey'] == "all" && $_REQUEST['skey_sub'] == "all"){
		$wheretxt .= "";
	}else{
	$wheretxt .= " and sms_type= '".$_REQUEST['skey']."' and sms_type_sub = '".$_REQUEST['skey_sub']."'
	";}
}elseif($_REQUEST['skey'] && !$_REQUEST['skey_sub']){
	$wheretxt .= " and sms_type= '".$_REQUEST['skey']."'
	";	
}
?>
<div class="common_page common_none">
	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="sms.php">SMS 세팅 관리 </a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>
<div class="common_page">
	<div class="layout_fix">
		<div class="cm_order_search" style="margin-top:20px;padding:15px">
			<div class="detail">
				<form name="sms_setting_search" id="sms_setting_search" action="<?=$PHP_SELF?>">
					<select name="skey" id="skey" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
					<option value="">전체보기</option>
					<? 
						//셀렉트박스 검색용
						$sql = "select * from odtSmsSetting group by sms_type order by sms_type";
						$rs_search_cate = mysql_query($sql);
						while($row_search_cate = mysql_fetch_array($rs_search_cate)){
					?>
					<option value="<?=$row_search_cate['sms_type']?>" <?=($_REQUEST[skey] == $row_search_cate['sms_type'])?"selected":""?> ><?=$row_search_cate['sms_type']?></option>
					<? } ?>
					</select>
					<select name="skey_sub" id="skey_sub" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
					<option value="">전체보기</option>
					<? 
						$sql = "select * from odtSmsSetting where sms_type_sub != '' group by sms_type_sub order by sms_type_sub";
						$rs_search_cate2 = mysql_query($sql);
						while($row_search_cate2 = mysql_fetch_array($rs_search_cate2)){
					?>
					<option value="<?=$row_search_cate2['sms_type_sub']?>" <?=($_REQUEST[skey_sub] == $row_search_cate2['sms_type_sub'])?"selected":""?> ><?=$row_search_cate2['sms_type_sub']?></option>
					<? } ?>
					</select>
					<!-- <input type="text" name="sval" id="sval" value="" class="input_date" style="background:none;width:150px;padding:0 5px"/> -->
					<span class="button_pack"><a href="#none" onclick="go_search();" class="btn_md_black">검색</a></span>
					<span class="button_pack" style="margin-left:10px;"><a href="#none " onclick="work_popup('<?=$_REQUEST['AuthID']?>', 'create');" class="btn_md_color">sms추가</a></span>
					<span class="button_pack" style="margin-left:10px;"><a href="#none " onclick="work_popup('<?=$_REQUEST['AuthID']?>', 'show');" class="btn_md_white">세팅정보 보기</a></span>
				</form>
			</div>
		</div>
	<!-- 글쓰기 -->
		<?
			$sql = "select * from odtSmsSetting $wheretxt";
			$rs_sms_type = mysql_query($sql);
			$row_sms_type = mysql_fetch_array($rs_sms_type);
		?>
		<form name="frm_request" id="frm_request" method=post action="/pages/mypage.request.pro.php" enctype="multipart/form-data" target="common_frame"  >
			<input type="hidden" name="_menu" value="request"/>
			<div class="cm_shop_title" style="border-bottom:0px;">
				<strong>발송SITE</strong> - 알림톡템플릿코드
			</div>
			<div class="cm_board_form">
				<ul>
					<li class="ess">
						<span class="opt">
							<?=$row_sms_type['sms_type']?>
							<?if($row_sms_type['sms_type_sub'] != ""){
							?> / <?=$row_sms_type['sms_type_sub']?>
							<? } ?>
						</span>
						<div class="value">
						<? 
							$rs_sms_default = mysql_query($sql);
							while($row_sms_default = mysql_fetch_array($rs_sms_default)){
						?>	
						<div style="float:left;width:30%;margin:15px">
							<span style="font-size:13pt;"><?=$row_sms_default[sms_set_site]?> - <?=$row_sms_default[sms_template]?></span>
							<textarea cols="" rows="" name="_content" class="textarea_design" style="font-size:11pt; height:150px; margin-top:20px;"><?=$row_sms_default[sms_set_content]?>
							</textarea>
							<div style="text-align:center">
								<span class="button_pack" style="margin-top:20px;">
									<a href="#none" onclick="sms_delete('<?=$row_sms_cancle['uid']?>', 'delete');" class="btn_lg_color" style="">상세보기
										<span class="edge"></span>
									</a>
								</span>
							</div>
						</div>
						<? } ?>
						</div>
					</li>
				</ul>
			</div>
		<!-- 가운데정렬버튼 -->
					<!-- / 가운데정렬버튼 -->
		</form>
	<!-- // 글쓰기 -->
	</div><!-- .layout_fix -->
</div><!-- .common_page -->

<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:500px;">

	<form name="sms_frm" id="sms_frm" method="post" action="sms.pro.php">

	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">SMS세팅 저장<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
								
									<a href="#none" onclick="sms_submit();" title="" class="btn_md_color">제출하기</a>
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

<div class="cm_ly_pop_tp" id="product_cancel_view_pop2" style="display:none;width:500px;">

	<form name="sms_frm1" id="sms_frm1">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">SMS세팅정보<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area2"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
								
									<a href="#none" onclick="self_close();" title="" class="btn_md_color">닫기</a>
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

<div class="cm_ly_pop_tp" id="sms_detail_pop" style="display:none;width:500px;">

	<form name="sms_defail_frm" id="sms_defail_frm" method="post" action="sms.pro.php">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">SMS세팅정보-수정,삭제<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area3"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
									<a href="#none" onclick="self_close();" title="" class="btn_md_color">수정</a>
								</span>
							</li>
							<li>
								<span class="button_pack">
									<a href="#none" onclick="self_close();" title="" class="btn_md_color">삭제</a>
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

function work_popup(uid, mode){
	if(mode == 'create'){
		$.post("sms.check.php",{uid:uid, mode:mode}, function(data){
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
	}else{
		$.post("sms.check.php",{uid:uid, mode:mode}, function(data){
			if(data){
				console.log(data);
				$('#popup_area2').html(data);
			}
		});
		$('#product_cancel_view_pop2').lightbox_me({
			centered: true, closeEsc: false,
			onLoad: function() { },
			onClose: function(){ }
		});
	}
}
function sms_delete(uid, mode){
	$.post("sms.check.php",{uid:uid, mode:mode}, function(data){
			if(data){
				console.log(data);
				$('#popup_area3').html(data);
			}
		});
		$('#sms_detail_pop').lightbox_me({
			centered: true, closeEsc: false,
			onLoad: function() { },
			onClose: function(){ }
		});
}
function sms_submit(){
		if ($('#sms_type').val() == ""){
			alert("SMS 타입을 선택해주세요.");
			$('#sms_type').focus();
			return;
		}
		if ($('#sms_set_site').val() == ""){
			alert("SMS 적용 사이트를 선택해주세요.");
			$('#sms_set_site').focus();
			return;
		}
		if ($('#sms_set_content').val() == ""){
			alert("SMS 내용을 입력해주세요.");
			$('#sms_set_content').focus();
			return;
		}
	$('#sms_frm').submit();
}
function self_close(){
	self.close();
}

function go_search(){
   $('#sms_setting_search').attr("action","sms.php");
   $('#sms_setting_search').submit();
}

</script>
<?
include_once "wrap.footer.php";
?>