<?
	// - �ѱ� ���� �����ϱ� ---
	$_PVS = ""; // ��ũ �ѱ� ����
	//foreach(array_filter(array_merge($_POST,$_GET)) as $key => $val) { $_PVS .= "&$key=$val"; }
	//$_PVSC = enc('e' , $_PVS);
	// - �ѱ� ���� �����ϱ� ---

	//$row_product;	// ��ǰ����
	$code = $row_product[code];
	if(!$g_check_id) {
		$talk_content = "<div class='textarea_box'><textarea name='_content' id='_content' class='textarea_design' onclick=\"login_alert2()\">�α����� �Ͻø� ��ǰ���Ǹ� ����� �� �ֽ��ϴ�.</textarea></div>";
	} else {
		$talk_content = "<div class='textarea_box'><textarea name='_content' id='_content' class='textarea_design' placeholder='���� ������ �Է����ּ���.'></textarea></div>";
	}


$m_name = $_SESSION['morning_sess_name'];
?>
<div class="inner_board">

	<div class="guide">
		<dl>
         <!--
			<dt>�� ��ǰ�� ���� �ñ��Ͻ� ���̳� �پ��� �ǰ�/�ı⸦ �����ּ���</dt>
         -->
         <dt>�� ��ǰ�� ���� �ñ��Ͻ� ���ǻ����� �����ּ���</dt>
         <!--
			<dd><span class="ic_bullet"></span><div class="txt">�ֹ��ϱ� ���� �ñ��Ͻ� ���� ������ 1:1�¶��ι��ǳ� ��ǰ���Ǹ� �����ּ���.</div></dd>
			<dd><span class="ic_bullet"></span><div class="txt">ȯ��/��ҿ� ���� ���Ǵ� ������ 1:1�¶��ι��Ǹ� �̿����ּ���.</div></dd>
			<dd><span class="ic_bullet"></span><div class="txt">��ǰ�� ������� ���̳� ����, ������ ���� �������� ���� �� �� �ֽ��ϴ�.</div></dd>
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
		<!-- ����� -->
		<div class="form_area">
			<div class="form_conts" style="padding-bottom: 24px;">
				<?=$talk_content?>
				<? if($g_check_id){ ?>
				<input type="button" class="btn_ok" onclick="talk_add('<?=$eventYN?>')" value="���"/>
				<? } else { ?>
				<input type="button" class="btn_ok" onclick="login_alert2()" value="���"/>
				<? } ?>
			</div>
			<div style="clear: both;"></div>
			<div id="ID_talk_list"></div>
		</div>
		<!-- //����� -->

		

	</div><!-- .cm_shop_inner -->

</div><!-- .inner_board -->


<script>
function talk_add(eventYN) {

	if(!$("#_content").val()) {	alert("������ �Է��ϼ���."); $("#_content").focus(); return; }
	if(!confirm("���� ����Ͻðڽ��ϱ�?")) return false;

	$.ajax({
		url: "product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=add&m_name=<?=$m_name?>&pcode=<?=$ps_goid?>&eventYN="+eventYN+"&_content=" + $("#_content").val() ,
		success: function(data){ talk_view(); $("#_content").val('');  alert("��ǰ������ �亯�ð��� ���� 09:00~18:00 �����Դϴ�.");
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
	if(!$("#_content_"+ttNo).val()) { alert("������ �Է��ϼ���."); $("#_content_"+ttNo).focus(); return; }
	if(!confirm("���� ����Ͻðڽ��ϱ�?")) return false;
	$.ajax({
		url: "/m/product.talk.pro.php",
		cache: false,
		type: "POST",
		data: "_mode=reply&ttNo="+ttNo+"&pcode=<?=$pcode?>&_content=" + encodeURIComponent($("#_content_"+ttNo).val()) ,
		success: function(data){ talk_view(); $("#_content_"+ttNo).val(''); }
	});
	return false;
}

// ���� ����
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

// ���� ����
function talk_del(uid) {
	if(confirm("���� �����Ͻðڽ��ϱ�?")) {
		$.ajax({
			url: "product.talk.pro.php",
			cache: false,
			type: "POST",
			data: "_mode=delete&uid=" + uid ,
			success: function(data){
				if( data == "no data" ) {
					alert('������ ����Ͻ� ���� �ƴմϴ�.');
				}
				else if( data == "is reply" ) {
					alert('����� �����Ƿ� ������ �Ұ��մϴ�.');
				}
				else {
					alert('���������� �����Ͽ����ϴ�.');
					talk_view();
				}
			}
		});
	}
}

// ���� ����
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

	// �����ִ°� �ٽ� Ŭ���������� �ݱ⸸ ó���Ѵ�.
	if(old_talk_id == id) {this.old_talk_id = 0;return;}
	$("#"+id).addClass('open');
	old_talk_id = id;
}


function login_alert2(){
    alert("�α��� �� �̿��Ҽ� �ֽ��ϴ�.");
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
				alert("����ó�� �Ϸ�Ǿ����ϴ�.");
				location.reload();
			}else{
				alert("��û�۾�����, 1544-4904�� �������ּ���");
				location.reload();
			}
		}
	});
}
// ��� ��� onload -> loading
$(document).ready(function() { talk_view(); });
</script>