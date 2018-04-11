<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bstaff_supervise\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}
?>
<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="member.list.php">직원관리</a></dt>
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
				<form name="staff_search_form" id="staff_search_form">
					<select name="skey" id="skey" class="add_option add_option_chk" style="height: 34px;float: left;margin-right: 10px;">
						<option value="">::선택::</option>
						<option value="name" <?=($_REQUEST[skey] == 'name')?"selected":"";?>>이름</option>
						<option value="nick" <?=($_REQUEST[skey] == 'nick')?"selected":"";?>>닉네임</option>
					</select>
					<input type="text" name="sval" id="sval" value="<?=$_REQUEST['sval']?>" class="input_date" style="background:none;width:150px;padding:0 5px"/>
					<span class="button_pack"><a href="#none" onclick="staff_search();" class="btn_md_black">검색</a></span>
					<span class="button_pack" style="margin-left:0;"><a href="staff.list.php" class="btn_md_white">초기화</a></span>
				</form>
			</div>
		</div>

		<div class="cm_mypage_list list_posting">
			<?
			$where = "";

			if($_REQUEST[skey] && $_REQUEST[sval]){
				if($_REQUEST[skey] == 'name') $where = "where mb_name like '%$_REQUEST[sval]%'";
				if($_REQUEST[skey] == 'nick') $where = "where mb_nick like '%$_REQUEST[sval]%'";
			}

			$listmaxcount = 50; // 미입력시 20개 출력
			if( !$_REQUEST[listpg] ) {$_REQUEST[listpg] = 1 ;}
			$count = $_REQUEST[listpg] * $listmaxcount - $listmaxcount;

			$res = mysql_fetch_array(mysql_query(" select count(*) as cnt from jy_staff ".$where.""));
			$TotalCount = $res['cnt'];
			$Page = ceil($TotalCount / $listmaxcount);

			$request_assoc = mysql_query("select * from jy_staff ".$where." order by mb_name asc limit ".$count.", ".$listmaxcount." ");

			if( count($request_assoc)==0 ) {
			?>
			<!-- 내용없을경우 모두공통 -->
			<div class="cm_no_conts"><div class="no_icon"></div><div class="gtxt">등록된 직원이 없습니다.</div></div>
			<!-- // 내용없을경우 모두공통 -->
			<? } else { ?>
			<table summary="내가쓴글목록">
			<colgroup>
				<col width="100"/>
				<col width="100"/>
				<col width="100"/>
				<col width="100"/>
				<col width="100"/>
				<col width="70"/>
				<?if($row_authority[authorized_set]=='Y'){?>
				<col width="100"/>
				<?}?>
			</colgroup>
			<thead>
				<tr>
					<th scope="col">아이디</th>
					<th scope="col">이름</th>
					<!--<th scope="col">닉네임</th>	-->
					<th scope="col">연락처</th>
					<th scope="col">부서/팀</th>
					<th scope="col">직급</th>
					<?if($row_authority[authorized_set]=='Y'){?>
					<th scope="col">관리</th>
					<?}?>
				</tr>
			</thead> 
			<tbody>
				<?
					while($v = mysql_fetch_array($request_assoc)) {

					switch($v[mb_department]){
						case "BS" : $department = "영업부"; break;
						case "MG" : $department = "관리부"; break;
						case "DV" : $department = "개발부"; break;
					}

					switch($v[mb_team]){
						/*case "DT" : $team = "개발팀"; break;
						case "OCT" : $team = "온라인커머스팀"; break;
						case "MT" : $team = "마케팅팀"; break;
						case "AT" : $team = "회계팀"; break;
						case "OT" : $team = "발주팀"; break;
						case "CT" : $team = "정산팀"; break;*/
						case "CST" : $team = "고객만족팀"; break;
					}

					switch($v[mb_position]){
						case "RS" : $position = "대표"; break;
						case "VP" : $position = "부사장"; break;
						case "CM" : $position = "이사"; break;
						case "HD" : $position = "부장"; break;
						case "DH" : $position = "차장"; break;
						case "SC" : $position = "과장"; break;
						case "DS" : $position = "대리"; break;
						case "CH" : $position = "주임"; break;
						case "MS" : $position = "사원"; break;
						case "IT" : $position = "인턴"; break;
						case "CT" : $position = "계약"; break;
					}
				?>
				<tr class="open_full">
					<td class=""><span class="texticon_pack"><?=$v[mb_id]?></span></td>
					<td class=""><span class="texticon_pack"><?=$v[mb_name]?></span></td>
					<!--<td class=""><span class="texticon_pack"><?=$v[mb_nick]?></span></td>-->
					<td class=""><span class="texticon_pack"><?=$v[mb_htel]?></span></td>
					<td class=""><span class="texticon_pack"><?=$department?> <?=($v[mb_team] == "CST")?"/ ".$team:""?></span></td>
					<td class=""><span class="texticon_pack"><?=$position?></span></td>
					<?if($row_authority[authorized_set]=='Y'){?>
					<td>
						<?if($v[mb_login_authority] == 'N'){?>
						<span class="button_pack btn_close_conts"><a href="#none" onclick="login_authority('<?=$v[uid]?>','access_limit');" class="btn_sm_black" style="float:none;">로그인 제한</a></span>
						<?}else{?>
						<span class="button_pack btn_close_conts"><a href="#none" onclick="login_authority('<?=$v[uid]?>','access_release');" class="btn_sm_black" style="float:none;">로그인 제한해제</a></span>
						<?}?>
						<span class="button_pack btn_close_conts"><a href="#none" onclick="authorized_popup('<?=$v[mb_id]?>')" class="btn_sm_color" style="float:none;">권한설정</a>&nbsp;
						<a href="#none" onclick="staff_out('<?=$v[uid]?>')" class="btn_sm_white" style="float:none;">퇴사</a></span>
					</td>
					<?}?>
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


<div class="cm_ly_pop_tp" id="product_cancel_view_pop" style="display:none;width:500px;">

<form name="authorized_frm" id="authorized_frm" method="post" action="authorized.pro.php">
	<input type="hidden" name="authorized_mb_id" id="authorized_mb_id" value="">
	<input type="hidden" name="mode" value="add">
	
	<!--  레이어팝업 공통타이틀 영역 -->
	<div class="title_box">직원권한설정<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>


	<div class="inner_box">
		
				<div class="cm_member_form" style="border-top:0;">
					<ul>
						<li class="ess" style="border-bottom:0;">
							<select name="staff_authorized" id="staff_authorized" class='add_option add_option_chk' style='width:310px;height:30px;float:left;margin-right:10px;'>
								<option value="">::::: 선택 :::::</option>
								<? foreach($staff_authorized as $key => $val) { ?>
								<option value="<?=$key?>"><?=$val?></option>
								<? } ?>
							</select>
							<span class="button_pack" style="margin-left:0;margin-top:0;"><a href="#none" onclick="authorized_add();" class="btn_md_white" style="height:29px;line-height:29px;"><span style="color:red;font-weight:bold">+</span> 추가</a></span>
						</li>
					</ul>
				</div>
				<div class="cm_mypage_list" id="popup_area" style="border:0"></div>

		<!-- 레이어팝업 버튼공간 -->
		<div class="cm_bottom_button">
		    <ul>
		        <li><span class="button_pack"><a href="#none" onclick="authorized_submit();" title="" class="btn_md_color">설정하기</a></span></li>
				<li><span class="button_pack"><a href="#none" class="btn_md_black close">닫기</a></span></li>
			</ul>
		</div>
		<!-- / 레이어팝업 버튼공간 -->

	</div>
	<!-- / 하얀색박스공간 -->
</form>
</div>

<script>
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

	$.post("staff.authorized.check.php",{mode:"staff_authorized",mb_id:uid}, function(data){
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

function login_authority(uid, access){
	$.post("login_authority.php", {uid:uid,access:access}, function(data){
		if(data == 'limit'){
			alert("로그인 제한 되었습니다.");
			location.reload();
		}else if(data == 'release'){
			alert("로그인 제한해제를 하였습니다.");
			location.reload();
		}else{
			alert('실패하였습니다.');
			location.reload();
		}
	});
}

function staff_out(uid){
	var result = confirm('정말로 퇴사하셨나요?\n퇴사처리 후에는 복구가 불가능합니다.');
	if(result){
		$.post("login_authority.php", {uid:uid,access:"staff_out"}, function(data){
			if(data == 'ok'){
				alert("퇴사처리가 완료되었습니다.");
				location.reload();
			}else{
				alert("퇴사처리에 실패하였습니다.");
				location.reload();
			}
		});
	}
}

function authorized_add(){
	var staff_authorized = $('#staff_authorized option:selected').val();

	if(staff_authorized == ''){
		alert("추가할 권한을 선택해주세요.");
		$('#staff_authorized').focus();
		return false;
	}

	$.post("staff.authorized.check.php",{mode:"authorized_add",authorized:staff_authorized},function(data){
		if(data){
			$('#popup_area').append(data);
		}
	});
}

function authority_del(e){
	if(confirm('정말로 삭제 하시겠습니까?\n삭제이후 반드시 적용버튼을 눌러주세요.')){
		$("."+e).detach();		
	}
}

function authorized_submit(){

	$('#authorized_frm').submit();

}
</script>

<?
include_once "wrap.footer.php";
?>