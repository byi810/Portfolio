<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bproduct_notify\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}

/*******************변수정리시작************************/
$today = date("Y-m-d");
$ago_1day = date("Y-m-d", strtotime("-1day"));
$ago_2day = date("Y-m-d", strtotime("-2day"));
$ago_3day = date("Y-m-d", strtotime("-3day"));
$ago_1week = date("Y-m-d", strtotime("-1week"));
$ago_1month = date("Y-m-d", strtotime("-1month"));

$sale_date = $_REQUEST[sale_date];
$sale_enddate = $_REQUEST[sale_enddate];
$planning_val = $_REQUEST[planning_val];
$align_method = $_REQUEST[align_method];
$store_gubun = $_REQUEST[store_gubun];
$submit_gubun = $_REQUEST[submit_gubun];
/**********************변수정리끝***************************/
$sd_time = strtotime($sale_date);
$sed_time = strtotime($sale_enddate);
$time_cal = ($sed_time - $sd_time)/86400;

$skey = $_REQUEST[skey];
$sval = $_REQUEST[sval];

switch($sval){
	case "전체" : 
		$sval = "A";
	break;
	case "업체별":
		$sval = "E";
	break;
	case "상품별":
		$sval = "I";
	break;
}
$listmaxcount = 10; // 미입력시 50개 출력
if( !$_REQUEST[listpg] ) {$_REQUEST[listpg] = 1 ;}
$count = $_REQUEST[listpg] * $listmaxcount - $listmaxcount;
$where = "where 1=1 and no_del_chk = 'N'";
$res = mysql_fetch_array(mysql_query(" select count(*) as cnt from odtNotification ".$where.""));
$TotalCount = $res['cnt'];
$Page = ceil($TotalCount / $listmaxcount);

$whereTxt = "where 1=1 and no_gubun != '' and no_del_chk = 'N'";

if($sval && $skey){
	if($skey == 'no_gubun') $whereTxt .= " and ".$skey." like '%".$sval."%'";
	if($skey == 'no_notify_title') $whereTxt .= " and ".$skey." like '%".$sval."%'";
	if($skey == 'no_mb_name') $whereTxt .= " and ".$skey." like '%".$sval."%'";
}
if($sale_date && $sale_enddate){
	$whereTxt .= " and no_registerdate between '".$sale_date."' and '".$sale_enddate."'";
}
$sql = "
	select * from odtNotification $whereTxt order by uid desc limit ".$count.", ".$listmaxcount." ";
$rs_notify = mysql_query($sql);
$rs = mktime();
$i = 1;
?>
<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="product.notify.list.php">상품공지사항</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>
	</div>
	<!-- / 타이틀상단 -->
</div>
<!-- 
********데이터 검색 변리*********
1. 기간 - sale_date, sale_dateh, sale_datem
   기간(끝) - sale_enddate, sale_enddateh, sale_enddatem
2. 밴드구분 - 
3. 상품명 - planning_val
4. 정렬 - align_method
5. 상점 - store_gubun
-->

<div class="common_page" style="margin:0 auto;border-bottom:0px;">
	<div class="layout_fix" style="margin:0;">
		<div class="cm_order_search" style="margin-top:20px;padding:15px">
			<div class="detail">
				<form name="notify_search_form" id="notify_search_form" method="post" action="<?=$PHP_SELF?>">
					<span style="float:left;padding:10px 10px 0 10px">게시 기간</span>
					<div style="float:left">
						<input type="text" name="sale_date" id="sale_date" value='<?=$_REQUEST['sale_date']?>' class="input_date" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
						<input type="hidden" name="sale_dateh" id="sale_dateh" value='<?=sprintf("%02d" , $_REQUEST['sale_dateh'])?>' class="input_date" style="width:20px;"  /><!-- 시 -->
						<input type="hidden" name="sale_datem" id="sale_datem" value='<?=sprintf("%02d" , $_REQUEST['sale_datem'])?>' class="input_date" style="width:20px;"  /><!-- 분 -->
						<span class="dash" style="background:none;margin:0 9px;">~</span>
						<input type="text" name="sale_enddate" id="sale_enddate" value='<?=$_REQUEST['sale_enddate']?>' class="input_date" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
						<input type="hidden" name="sale_enddateh" id="sale_enddateh" value='<?=($_REQUEST['sale_enddateh'] ? sprintf("%02d" , $_REQUEST['sale_enddateh']) : "23")?>' class="input_date" style="width:20px;"  /><!-- 시 -->
						<input type="hidden" name="sale_enddatem" id="sale_enddatem" value='<?=($_REQUEST['sale_enddatem'] ? sprintf("%02d" , $_REQUEST['sale_enddatem']) : "59")?>' class="input_date" style="width:20px;"  /><!-- 분 -->
					</div>
					<span style="float:left;padding:10px 10px 0 10px; margin-left:10px;">검색 조건</span>
					<select name="skey" id="skey" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
						<option value="">::::::::선택::::::::</option>
						<option value="no_gubun" <?=($skey == 'no_gubun')?"selected":"";?>>구분</option>
						<option value="no_notify_title" <?=($skey == 'no_notify_title')?"selected":"";?>>제목</option>
						<option value="no_mb_name" <?=($skey == 'no_mb_name')?"selected":"";?>>올린사람</option>
					</select>
					<span style="float:left;padding:10px 10px 0 10px">검색어</span>
					<input type="text" name="sval" id="sval" value="<?=$_REQUEST['sval']?>" class="input_date" style="background:none;width:100px;padding:0 5px"/>
					<span class="button_pack"><a href="#none" onclick="notify_search();" class="btn_md_color">검색</a></span>
					<span class="button_pack"><a href="product.notify.php" onclick="" class="btn_md_black">등록하기</a></span>
				</form>
			</div>
		</div>
		</div>

		<div class="cm_mypage_list list_posting">
			<table>
				<colgroup>
					<col width="30"/>
					<col width="50"/>
					<col width="150"/>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
					<col width="100"/>
				</colgroup>
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">구분</th>
						<th scope="col">제목</th>	
						<th scope="col">공지 게시 기간</th>
						<th scope="col">올린 사람</th>
						<th scope="col">상세보기</th>
						<th scope="col">관리</th>
					</tr>
				</thead> 
				<tbody>
					<?
					while($v = mysql_fetch_array($rs_notify)) {
						if($v[no_gubun] == "A"){
							$gubun = "전체";	
						}else if($v[no_gubun] == "I"){
							$gubun = "상품별";
						}else if($v[no_gubun] == "E"){
							$gubun = "업체별";
						}else if($v[no_gubun] == ""){
							$gubun = "정보없음";
						}
					?>
					<tr class="open_full">
						<td class=""><span class="texticon_pack"><?=$i?></span></td>
						<td class=""><span class="texticon_pack"><?=$gubun?></span></td>
						<td class=""><span class="texticon_pack"><?=$v[no_notify_title]?></span></td>
						<td class=""><span class="texticon_pack"><?=$v[no_sdate]." ~ ".$v[no_edate]?></span></td>
						<td class=""><span class="texticon_pack"><?=$v[no_mb_name]?></span></td>
						<td class="">
							<span class="button_pack btn_close_conts"  style="padding-top: 10px;">
								<a href="#none" onclick="work_popup('<?=$v[uid]?>','show');" class="btn_sm_black" style="float:none;">보기</a>
							</span>
						</td>
						<td>
							<span class="button_pack btn_close_conts"><a href="product.notify.php?_mode=modify&_code=<?=$v[uid]?>" class="btn_sm_color" style="float:none;">수정</a>
							<a href="#none" onclick="notify_del('<?=$v[uid]?>')" class="btn_sm_white" style="float:none;">삭제</a></span>
						</td>
					</tr>
					<? $i++; } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="cm_paginate">
		<?=pagelisting($_REQUEST[listpg], $Page, $listmaxcount," ?${_PVS}&listpg=" , "Y")?>
	</div>
</div>

<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:1500px;">

	<form name="wreport_frm" id="wreport_frm" method="post" action="work.report.pro.php" enctype="multipart/form-data">
	<!--  레이어팝업 공통타이틀 영역 -->
		<div class="title_box">공지사항 상세<a href="#none" class="close btn_close" title="닫기"></a></div>
			<div class="inner_box">

				<div id="popup_area"></div>

				<!-- 레이어팝업 버튼공간 -->
					<div class="cm_bottom_button">
						<ul>
							<li>
								<span class="button_pack">
								
									<a href="#none"  title="" class="close btn_md_color">닫기</a>
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

function staff_search(){
	var skey = $('#skey').val();
	var sval = $('#sval').val();

	if(skey == ''){
		alert("검색조건을 선택해주세요.");
		$('#skey').focus();
		return;
	}

	if(sval == ''){
		alert("검색어를 입력해주세요.");
		$('#sval').focus();
		return;
	}

	$('#staff_search_form').submit();

}

function authorized_submit(){

	$('#authorized_frm').submit();

}

function change_time(date){
	//sale_date, sale_enddate로 받음 
	var today = "<?=$today?>";
	var ago_1day = "<?=$ago_1day?>";
	var ago_2day = "<?=$ago_2day?>";
	var ago_3day = "<?=$ago_3day?>";
	var ago_1week = "<?=$ago_1week?>";
	var ago_1month = "<?=$ago_1month?>";

	if(date == "1day"){
		document.getElementById("sale_date").value = ago_1day;
		document.getElementById("sale_enddate").value = today;
	}else if(date == "2day"){
		document.getElementById("sale_date").value = ago_2day;
		document.getElementById("sale_enddate").value = today;
	}else if(date == "3day"){
		document.getElementById("sale_date").value = ago_3day;
		document.getElementById("sale_enddate").value = today;
	}else if(date == "1week"){
		document.getElementById("sale_date").value = ago_1week;
		document.getElementById("sale_enddate").value = today;
	}else if(date == "1month"){
		document.getElementById("sale_date").value = ago_1month;
		document.getElementById("sale_enddate").value = today;
	}
}

function notify_search(){
	$('#notify_search_form').attr("action","product.notify.list.php");
   $('#notify_search_form').submit();

}

function event_del(uid){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href="event.pro.php?mode=delete&code="+uid;
	}
}

function work_popup(uid){

		$.post("product.notify.check2.php",{uid:uid}, function(data){
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

function self_close(){
	self.close();
}

function notify_del(uid){
	if(confirm("선택한 공지사항을 삭제하시겠습니까?")){
		location.href="product.notify.pro.php?mmode=delete&code="+uid;
	}
}
</script>

<?
include_once "wrap.footer.php";
?>