<?php
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

$SQL = "
	select
		*
	from
		jy_staff
	where
		mb_id = '".$row_staff[mb_id]."'
";
$rs_member = mysql_query($SQL);
$row_member = mysql_fetch_array($rs_member);
?>

<div class="common_page common_none">

	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"><img src="/pages/images/cm_images/icon_top_my.png" alt="" /></span>
			<dl>
				<dt><a href="staff.list.php">정보수정</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>

<div class="common_page" style="margin:0 auto;border-bottom:0px;">
	<div class="layout_fix" style="margin:0;">
	 
	<form name="modify_frm" id="modify_frm" method="post" action="staff.info.modify.pro.php">
	<input type="hidden" name="_uid" value="<?=$row_member['uid']?>">
		<!-- ●●●●●●●●●● 회원기본정보 -->
		<div class="cm_member_form">
			<ul>
				<li class="ess double">
					<span class="opt" >아이디</span>
					<div class="value"  name="j_id" id="j_id" style="height: 35px;"><?=$row_member[mb_id]?></div>
				</li>
				<li class="ess double">
					<span class="opt">이름</span>
					<div class="value"><input type="text" name="j_name" id="j_name" class="input_design" value="<?=$row_member['mb_name']?>" /></div>
				</li>
				<li class="ess double">
					<span class="opt">비밀번호</span>
					<div class="value">
						<input type="password" name="j_passwd" id="j_passwd" class="input_design" value=""/>
						<div class="tip_txt">
							<dl>
								<dd>수정을 원할 경우에만 입력해주세요 (영문, 숫자 6자이상).</dd>
							</dl>
						</div>
					</div>					
				</li>
				<li class="ess double">
					<span class="opt">비밀번호 확인</span>
					<div class="value"><input type="password" name="j_repasswd" id="j_repasswd" class="input_design" value=""/>
						<div class="tip_txt">
							<dl>
								<dd>동일하게 다시 한번 입력해주세요.</dd>
							</dl>
						</div>
					</div>
				</li>
				<li class="ess double">
					<span class="opt">E-mail</span>
					<div class="value"><input type="text" name="j_email" id="j_email" class="input_design" value="<?=$row_member['mb_email']?>" /></div>
				</li>
				<!--<li class="ess double">
					<span class="opt">닉네임</span>
					<div class="value"><input type="text" name="j_nick" id="j_nick" class="input_design" value="<?=$row_member['mb_nick']?>" /></div>
				</li>-->
				<?
				$tel = explode("-", $row_member['mb_htel']);
				?>
				<li class="ess double">
					<span class="opt">휴대폰 번호</span>
					 <div class="value">
                     <input type="text" name = "j_tel1" id="j_tel1" class="input_design" value="<?=$tel['0']?>"  style="width:80px;"/><span class="dash"></span>
                    <input type="text" name = "j_tel2" id="j_tel2" class="input_design" value="<?=$tel['1']?>"  style="width:80px;"/><span class="dash"></span>
                    <input type="text" name = "j_tel3" id="j_tel3" class="input_design" value="<?=$tel['2']?>"  style="width:80px;"/>
                  </div>
				</li>
				 <li class="ess double">
					<span class="opt">소속부서</span>
					<div class="value">
						<select name="j_department" id="j_department" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::소속 부서를 선택해주세요::::::</option>
							<?foreach($staff_department as $key => $val){?>
								<option value="<?=$val?>" <?=($row_member[mb_department] == $val)?"selected":""?>><?=$key?></option>
							<?}?>
						</select>
					</div>
				</li>
				<li class="ess double">
					<span class="opt">소속팀</span>
					<div class="value" style="line-height:29px">
						<select name="j_team" id="j_team" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::소속 팀을 선택해주세요::::::</option>
							<? foreach($staff_team as $key2 => $val2){?>
								<option value="<?=$val2?>" <?=($row_member[mb_team] == $val2)?"selected":""?>><?=$key2?></option>
							<? } ?>
						</select>
						<select name="j_position" id="j_position" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::직급을 선택해주세요::::::</option>
							<? foreach($staff_position as $key => $val){?>
								<option value="<?=$val?>" <?=($row_member[mb_position] == $val)?"selected":""?>><?=$key?></option>
							<? } ?>
						</select>
					</div>
				</li>
				<li class="">
					<span class="opt">MD 여부</span>
					<div class="value"><label><input type="checkbox" name="j_md" id="j_md" value="Y" <?=($row_member['mb_md'] == "Y")?"checked":"";?>/>MD입니다.</label></div>
				</li>
			</ul>
		</div>
		<!-- / 회원기본정보 -->
	</form>
	
	</div>
</div>

<!-- 가운데정렬버튼 -->
<div class="cm_bottom_button">
	<span class="lineup">				
		<span class="button_pack"><a href="#none" title="" onclick="modify_submit();return false;" class="btn_lg_color">수정하기<span class="edge"></span></a></span>
	</span>
</div>
<!-- / 가운데정렬버튼 -->

<script>
function modify_submit() {
	var j_passwd = $('#j_passwd').val();
	var j_repasswd = $('#j_repasswd').val();

	if(j_passwd == j_repasswd){
		$("#modify_frm").submit();
	}else{
		alert('입력하신 비밀번호가 다릅니다.\n다시 한번 확인해 주세요.');
		$('#j_repasswd').val('');
		$('#j_repasswd').focus();
		return;
	}
}
</script>

<?
include_once "wrap.footer.php";
?>