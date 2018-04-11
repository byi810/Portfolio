<?
	// - 넘길 변수 설정하기 ---
	$_PVS = ""; // 링크 넘김 변수
	//foreach(array_filter(array_merge($_POST,$_GET)) as $key => $val) { $_PVS .= "&$key=$val"; }
	//$_PVSC = enc('e' , $_PVS);
	// - 넘길 변수 설정하기 ---

	//$row_product;	// 상품정보
	$code = $row_product[code];
	if(!$g_check_id) {
		$talk_content = "<div class='textarea_box'><textarea name='_content' id='_content' class='textarea_design' onclick=\"login_alert2()\">로그인을 하시면 상품문의를 남기실 수 있습니다.</textarea></div>";
	} else {
		$talk_content = "<div class='textarea_box'><textarea name='_content' id='_content' class='textarea_design' placeholder='문의 내용을 입력해주세요.'></textarea></div>";
	}


$m_name = $_SESSION['morning_sess_name'];
?>
<div class="inner_board">

	<div class="guide">
		<dl>
         <!--
			<dt>본 상품에 관해 궁금하신 점이나 다양한 의견/후기를 남겨주세요</dt>
         -->
         <dt>본 상품에 관해 궁금하신 문의사항을 남겨주세요</dt>
         <!--
			<dd><span class="ic_bullet"></span><div class="txt">주문하기 전에 궁금하신 점이 있으면 1:1온라인문의나 상품문의를 남겨주세요.</div></dd>
			<dd><span class="ic_bullet"></span><div class="txt">환불/취소에 대한 문의는 고객센터 1:1온라인문의를 이용해주세요.</div></dd>
			<dd><span class="ic_bullet"></span><div class="txt">상품과 관계없는 글이나 광고, 비방글은 사전 고지없이 삭제 될 수 있습니다.</div></dd>
         -->
		</dl>			
	</div>
	<?
	$sql = "select * from jooyon_band_banner_table where banner_url = '".$_REQUEST[ps_goid]."'";
	$row_banner_url = mysql_fetch_array(mysql_query($sql));

	if($row_banner_url[eventYN] == "Y"){
		$eventYN = "Y";
	}else{
		$eventYN= "N";
	}
	//debug($eventYN);
	?>
	<div class="cm_shop_inner">
		<!-- 등록폼 -->
		<div class="form_area">
			<div class="form_conts" style="padding-bottom: 24px;">
				<?=$talk_content?>
				<? if($g_check_id){ ?>
				<input type="button" class="btn_ok" onclick="talk_add('<?=$eventYN?>')" value="등록"/>
				<? } else { ?>
				<input type="button" class="btn_ok" onclick="login_alert2()" value="등록"/>
				<? } ?>
			</div>
			<div style="clear: both;"></div>
			<div id="ID_talk_list"></div>
		</div>
		<!-- //등록폼 -->

		

	</div><!-- .cm_shop_inner -->

</div><!-- .inner_board -->


<script>
function talk_add(eventYN) {

	if(!$("#_content").val()) {	alert("내용을 입력하세요."); $("#_content").focus(); return; }
	if(!confirm("글을 등록하시겠습니까?")) return false;

	$.ajax({
		url: "product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=add&m_name=<?=$m_name?>&pcode=<?=$ps_goid?>&eventYN="+eventYN+"&_content=" + $("#_content").val() ,
		success: function(data){ talk_view(); $("#_content").val('');  alert("상품문의의 답변시간은 평일 09:00~18:00 까지입니다.");
         //console.log(data);
      }
	});
	return false;
}

var old_view_ttNo = "";
function view_reply_form(ttNo) {
	$(".reply_form").hide();
	if(old_view_ttNo == ttNo) { $("#reply_form_"+ttNo).hide(); old_view_ttNo = ""; } 
	else { $("#reply_form_"+ttNo).show(); old_view_ttNo = ttNo; }	
}

function talk_reply_add(ttNo) {
	if(!$("#_content_"+ttNo).val()) { alert("내용을 입력하세요."); $("#_content_"+ttNo).focus(); return; }
	if(!confirm("글을 등록하시겠습니까?")) return false;
	$.ajax({
		url: "/m/product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=reply&ttNo="+ttNo+"&pcode=<?=$pcode?>&_content=" + encodeURIComponent($("#_content_"+ttNo).val()) ,
		success: function(data){ talk_view(); $("#_content_"+ttNo).val(''); }
	});
	return false;
}

// 갯수 추출
function talk_get_cnt() {
	$.ajax({
		url: "/m/product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=getcnt&pcode=<?=$pcode?>",
		success: function(data){
			//$(".talk_cnt").html(data);
		}
	});
}

// 리뷰 삭제
function talk_del(uid) {
	if(confirm("정말 삭제하시겠습니까?")) {
		$.ajax({
			url: "product.talk.pro.php",
			cache: false,
			type: "POST",
			data: "_mode=delete&uid=" + uid ,
			success: function(data){
				if( data == "no data" ) {
					alert('본인이 등록하신 글이 아닙니다.');
				}
				else if( data == "is reply" ) {
					alert('댓글이 있으므로 삭제가 불가합니다.');
				}
				else {
					alert('정상적으로 삭제하였습니다.');
					talk_view();
				}
			}
		});
	}
}

// 리뷰 보기
function talk_view(listpg) {
	if(listpg == undefined) listpg = 1;
	$.ajax({
		url: "product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=view2&pcode=<?=$ps_goid?>&listpg="+listpg,
		success: function(data){
			$("#ID_talk_list").html(data);
		}
	});
	//talk_get_cnt();
}

var old_talk_id;
function talk_show(id) {
	$("#ID_talk_list .list_area li").removeClass('open');

	// 열려있는걸 다시 클릭했을때는 닫기만 처리한다.
	if(old_talk_id == id) {this.old_talk_id = 0;return;}
	$("#"+id).addClass('open');
	old_talk_id = id;
}


function login_alert2(){
    alert("로그인 후 이용할수 있습니다.");
    top.location.href='/m_login.php';
}

function del_comment(uid){

	$.ajax({
		url : "product.talk.pro.php",
		cache : false,
		type : "POST",
		data : "_mode=del_comment&uid="+uid,
		success:function(data){
			if(data == "ok"){
				alert("삭제처리 완료되었습니다.");
				location.reload();
			}else{
				alert("요청작업실패, 1544-4904로 문의해주세요");
				location.reload();
			}
		}
	});
}
// 댓글 목록 onload -> loading
$(document).ready(function() { talk_view(); });
</script>