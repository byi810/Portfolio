<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bplanning\b/i",$row_authority[authority])){
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

$whereTxt = "where 1=1 and mp_del_chk = 'N'";

if($sale_date && $sale_enddate){
	$whereTxt .= " and mp_registerdate between '".$sale_date."' and '".$sale_enddate."'";
}
if($_REQUEST[planning_val]){
	$whereTxt .= " and mp_subject like '%".$_REQUEST[planning_val]."%'";
}
if($_REQUEST[approval]){
	$whereTxt .= " and mp_open = '".$_REQUEST[approval]."'";
}
if($_REQUEST[planning_name]){
	$whereTxt .= " and mp_name = '".$_REQUEST[planning_name]."'";
}

//debug($whereTxt);
//debug($_REQUEST);
?>
<div class="common_page common_none" style="width:1600px;"> 

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top" style="width:1600px;">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="planning.list.php">기획전 리스트</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>
<!-- 
********데이터 검색 변수정리*********
1. 기간 - sale_date, sale_dateh, sale_datem
   기간(끝) - sale_enddate, sale_enddateh, sale_enddatem
2. 밴드구분 - 
3. 상품명 - planning_val
4. 정렬 - align_method
5. 상점 - store_gubun
-->
<div class="common_page" style="width:1600px;">
	<div class="layout_fix"  style="width:1600px;">

		<div class="cm_order_search" style="margin-top:20px;padding:15px">

			<div class="detail">
				<form name="planning_search_form" id="planning_search_form" method="post" action="<?=$PHP_SELF?>">
					<span style="float:left;padding:10px 10px 0 10px">기획전 제목</span>
					<input type="text" name="planning_val" id="planning_val" value="<?=$_REQUEST['planning_val']?>" class="input_date" style="background:none;width:100px;padding:0 5px"/>
					<span style="float:left;padding:10px 10px 0 10px">기획전 게시 기간</span>
					<div style="float:left">
						<input type="text" name="sale_date" id="sale_date" value='<?=$_REQUEST['sale_date']?>' class="input_date" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
						<input type="hidden" name="sale_dateh" id="sale_dateh" value='<?=sprintf("%02d" , $_REQUEST['sale_dateh'])?>' class="input_date" style="width:20px;"  /><!-- 시 -->
						<input type="hidden" name="sale_datem" id="sale_datem" value='<?=sprintf("%02d" , $_REQUEST['sale_datem'])?>' class="input_date" style="width:20px;"  /><!-- 분 -->
						<span class="dash" style="background:none;margin:0 9px;">~</span>
						<input type="text" name="sale_enddate" id="sale_enddate" value='<?=$_REQUEST['sale_enddate']?>' class="input_date" style="width:90px;cursor:pointer;" readonly /><!-- 일 -->
						<input type="hidden" name="sale_enddateh" id="sale_enddateh" value='<?=($_REQUEST['sale_enddateh'] ? sprintf("%02d" , $_REQUEST['sale_enddateh']) : "23")?>' class="input_date" style="width:20px;"  /><!-- 시 -->
						<input type="hidden" name="sale_enddatem" id="sale_enddatem" value='<?=($_REQUEST['sale_enddatem'] ? sprintf("%02d" , $_REQUEST['sale_enddatem']) : "59")?>' class="input_date" style="width:20px;"  /><!-- 분 -->
					</div>
					<span style="float:left;padding:10px 10px 0 10px; margin-left:10px;">노출여부</span>
					<select name="approval" id="approval" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
						<option value="">::::::::선택::::::::</option>
						<option value="Y" <?=($_REQUEST['approval'] == 'Y')?"selected":""?>>노출</option>
						<option value="N" <?=($_REQUEST['approval'] == 'N')?"selected":""?>>노출안함</option>
					</select>
					<span style="float:left;padding:10px 10px 0 10px">등록자</span>
					<input type="text" name="planning_name" id="planning_name" value="<?=$_REQUEST['planning_name']?>" class="input_date" style="background:none;width:100px;padding:0 5px"/>
					<span class="button_pack"><a href="#none" onclick="planning_search();" class="btn_md_color">검색</a></span>
					<span class="button_pack"><a href="planning.create.php" onclick="" class="btn_md_black">기획전 등록하기</a></span>
				</form>
			</div>
		</div>

		<div class="cm_mypage_list list_posting">
			<?
			$request_assoc = mysql_query("select * from jy_staff ".$where." order by mb_name asc limit ".$count.", ".$listmaxcount." ");

			if( count($request_assoc)==0 ) {
			?>
			<!-- 내용없을경우 모두공통 -->
			<div class="cm_no_conts"><div class="no_icon"></div><div class="gtxt">등록된 직원이 없습니다.</div></div>
			<!-- // 내용없을경우 모두공통 -->
			<? } else { ?>
			<table summary="내가쓴글목록">
			<colgroup>
				<col width="30"/>
				<col width="90"/>
				<col width="90"/>
				<col width="180"/>
				<col width="140"/>
				<col width="70"/>
				<col width="100"/>
				<col width="100"/>
				<col width="100"/>
				<col width="100"/>
			</colgroup>
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">PC배너</th>
					<th scope="col">모바일 배너</th>
					<th scope="col">기획전 제목</th>	
					<th scope="col">기획전 기간</th>
					<th scope="col">노출관리</th>
					<th scope="col">노출사이트</th>
					<th scope="col">등록자</th>
					<th scope="col">등록일자</th>
					<th scope="col">관리</th>
				</tr>
			</thead> 
			<tbody>
				<?
				
				$sql = "
					select * from odtPlanning $whereTxt order by uid desc
				";
				$product_sell_rs = mysql_query($sql);

				while($v = mysql_fetch_array($product_sell_rs)) {
				
				$filename = str_replace("/home/jooyon/CRM/uploads/productimg/pc/", "", $v[mp_banner_image]);
				$filename2 = str_replace("/home/jooyon/CRM/uploads/productimg/mobile/", "", $v[mp_banner_image_m]);
				
				$images_pc = ($v[mp_banner_image])?"<img src='../../uploads/productimg/pc/".$filename."'>":"<img src='/skin/pc/images/noimage.png'>";
				$images_mobile= ($v[mp_banner_image])?"<img src='../../uploads/productimg/mobile/".$filename2."'>":"<img src='/skin/pc/images/noimage.png'>";
				
				if($v[mp_category] == "band09"){
					$category == "밴드";
				}elseif($v[mp_category] == "wagol"){
					$category == "와골";
				}elseif($v[mp_category] == "momshild"){
					$category == "맘쉴드";
				}

				if($v[mp_open] == "N"){
					$background = "#E8FFFF";
					$openYN = "비공개";
				}else{
					$background = "white";
					$openYN = "공개";
				}
				?>
				<tr class="open_full" style="background:<?=$background?>">
					<td><?=$v[uid]?></td>
					<td><?=$images_pc?></td>
					<td><?=$images_mobile?></td>
					<td><?=$v[mp_subject]?></td>
					<td><?=$v[mp_sdate]." ~ ".$v[mp_edate]?></td>
					<td><?=$openYN?></td>
					<td><?=$v[mp_category]?></td>
					<td><?=$v[mp_name]?></td>
					<td><?=$v[mp_registerdate]?></td>		
					<td>
						<span class="button_pack btn_close_conts"><a href="planning.create.php?_mode=modify&_code=<?=$v[uid]?>" class="btn_sm_color" style="float:none;">수정</a></span>
						<span class="button_pack btn_close_conts"><a href="#none" onclick="planning_del('<?=$v[uid]?>')" class="btn_sm_black" style="float:none;">삭제</a></span>
					</td>
				</tr>
				<? } ?>
			</tbody>
			</table>
			<? } ?>
		</div><!-- .cm_mypage_list -->

		<!-- 페이지네이트 -->
		<div class="cm_paginate">
			<?=pagelisting($_REQUEST[listpg], $Page, $listmaxcount," ?${_PVS}&listpg=" , "Y")?>
		</div>
		<!-- // 페이지네이트 -->

	</div><!-- .layout_fix -->
</div><!-- .common_page -->

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

function authorized_popup(uid){
	$('#authorized_mb_id').val(uid);

	$.post("staff.authorized.check.php",{mb_id:uid}, function(data){
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

function planning_search(){
	$('#planning_search_form').attr("action","planning.list.php");
	$('#planning_search_form').submit();

}
/*
function planning_del(uid){
	$.post("staff.authorized.check.php",{mb_id:uid}, function(data){
		if(data){
			$('#popup_area').html(data);
		}
	});
}
*/
function planning_del(uid){
	if(confirm("정말 삭제하시겠습니까?")){
		location.href="planning.pro.php?mode=delete&code="+uid;
	}
}
</script>

<?
include_once "wrap.footer.php";
?>