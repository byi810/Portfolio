<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bwork_report\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

/*
	* 페이지 : 업무일지 게시 페이지
	* 작성자 : 배영일(owen)
	* 작성일 : 2017-08-01
*/ 
?>
<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="work.report.php">업무일지 작성</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>
	</div>
	<!-- / 타이틀상단 -->
</div>

<!-- 업무일지 작성 폼 -->
<div class="common_page" style="margin:0 auto;border-bottom:0px;">
	<div class="layout_fix" style="margin:0;">
		<div class="cm_order_search" style="margin-top:20px;padding:15px">
			<div class="detail">
				<span class="button_pack"><a href="#none" onclick="work_popup('<?=$_REQUEST['AuthID']?>', 'create');" class="btn_md_black">작성</a></span>
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
						<th scope="col">제목</th>
						<th scope="col">날짜</th>
						<th scope="col">결제확인</th>	
						<th scope="col">보기</th>
						<th scope="col">수정</th>
						<th scope="col">삭제</th>
					</tr>
				</thead> 
				<tbody>
					<?
					$SQL = "
						select 
							*
						from
							jy_work
						where
							wr_id = '".$_REQUEST['AuthID']."'
						order by uid desc
					";
					
					$res_wreport = mysql_query($SQL);
					$rs = mktime();
					while($v = mysql_fetch_array($res_wreport)) {
					$wr_date = date('Y-m-d', $v[register_date]);
					$wr_uid = $v[uid];
					if($v[wr_approval_state] == 'Y'){
						$state = "승인완료";	
					}elseif($v[wr_approval_state] == 'S'){
						$state = "대기중";
					}else{
						$state = "반려";
					}
					?>
					<tr class="open_full">
						<td class=""><span class="texticon_pack"><?=$v[wr_title]?></span></td>
						<td class=""><span class="texticon_pack"><?=$wr_date?></span></td>
						<td class=""><span class="texticon_pack"><?=$state?></span></td>
						<td class="">
							<span class="button_pack btn_close_conts"  style="padding-top: 10px;">
								<a href="#none" onclick="work_popup('<?=$wr_uid?>','show');" class="btn_sm_black" style="float:none;">보기</a>
							</span>
						</td>
						<td class="">
							<span class="button_pack btn_close_conts" style="padding-top: 10px;">
								<a href="#none" onclick="work_popup('<?=$wr_uid?>', 'modify')" class="btn_sm_color" style="float:none;">수정</a>&nbsp;
							</span>
						</td>
						<td>
						<?if($row_authority[authorized_set]=='Y'){?>
							<span class="button_pack btn_close_conts">
								<a href="#none" onclick="work_del('<?=$v[uid]?>')" class="btn_sm_white" style="float:none;">삭제</a>
							</span>
						<?}?>
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

<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:800px;">

	<form name="wreport_frm" id="wreport_frm" method="post" action="work.report.pro.php" enctype="multipart/form-data">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">업무일지 작성<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
								
									<a href="#none" onclick="wreport_submit();" title="" class="btn_md_color">제출하기</a>
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

<div class="cm_ly_pop_tp" id="product_cancel_view_pop2" style="display:none;width:800px;">

	<form name="wreport_frm2" id="wreport_frm2" method="post" action="work.report.pro.php" enctype="multipart/form-data">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">업무일지 작성<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>
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
<script type="text/javascript">
function work_popup(uid, mode){
	$('#authorized_mb_id').val(uid);
	
	if(mode == 'show'){
		$.post("work.report.check.php",{mb_id:uid, mode:mode}, function(data){
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
	}else{
		$.post("work.report.check.php",{mb_id:uid, mode:mode}, function(data){
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
}

function wreport_submit(){
	if ($('#wr_title').val() == ""){
		alert("제목을 입력하세요.");
		$('#wr_title').focus();
		return;
	}
	if ($('#wr_comment').val() == ""){
		alert("업무일지 내용을 입력하세요.");
		$('#wr_comment').focus();
		return;
	}
	$('#wreport_frm').submit();
}

function work_del(uid){

	if(confirm("정말 삭제하시겠습니까?") == true){
		$.post("work.report.del.php", {uid:uid}, function(data){
			if(data == "ok"){
				alert("성공적으로 삭제되었습니다.");
				location.reload();
			}else{
				alert("업무일지 삭제 실패, 개발팀에 문의해주세요.");
			}
		});
	}else{
		return;
	}
}
function self_close(){
	self.close();
}
</script>