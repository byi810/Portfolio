<?php
/*
	 - FILE NAME : join.php
	 - 회원가입 액션 페이지
	 - 작성자 : OWEN
	 - 작성일 : 2017-07-27
*/
include_once "inc.header.php";
?>

<style>
body {background:#cccccc}

.common_page .title_box {
    margin: 20px 0 20px 0;
    overflow: hidden;
    font-family: calibri;
    font-size: 50px;
    color: #fff;
    letter-spacing: -1px;
    font-weight: 600;
    text-align: center;
}

.body_title{
    font-family: calibri;
    font-size: 50px;
    color: #646464;
    letter-spacing: -1px;
    font-weight: 600;
}
</style>


<div class="common_page" style="margin:0 auto; margin-top:100px;">
	<div class="layout_fix">
	 
	 <div class="title_box"><span class="body_title">CRM 회원가입</span></div>
	<form name="join_frm" id="join_frm" method="post" action="join.pro.php" target="common_frame">
		<!-- ●●●●●●●●●● 회원기본정보 -->
		<div class="cm_member_form">
			<ul>
				<!-- 클래스값 추가/// ess:필수요소, 두칸으로 쓸 경우 : double -->
				<!--
				<li class="ess double">
					<span class="opt">아이디</span>
					<div class="value">
						<input type="text" name="_id" id="_id" class="input_design" style="width:160px" onchange="this.form.idCheck1.value=''" maxlength="12"/>
						<span class="button_pack"><a href="#none" onclick="idCheck()" class="btn_md_white">아이디 중복체크<span class="edge"></span></a></span>
						<div class="tip_txt">
							<dl>
								<dt>아이디는 한번 가입한 이후에는 변경이 불가능합니다.</dt>
								<dd>영문, 숫자로 4자~12자 이내로 입력해주세요.</dd>
							</dl>
						</div>
					</div>
				</li>
				-->
				<li class="ess double">
					<span class="opt">아이디</span>
					<div class="value">
						<input type="text" name="j_id" id="j_id" class="input_design" style="width:60%;"/>
						<div>
							<span class="button_pack"><a href="#none" onclick="idCheck()" class="btn_md_white">ID 중복체크<span class="edge"></span></a></span>
						</div>
						<div class="tip_txt">
							<dl>
								<dd>영문, 숫자를 포함해 12자 이내로 입력해주세요.</dd>
							</dl>
						</div>
					</div>					
				</li>
				<li class="ess double">
					<span class="opt">이름</span>
					<div class="value">
					<input type="text" name="j_name" id="j_name" class="input_design" value=""/>
						<div class="tip_txt">
							<dl>
								<dd>실명 한글 이름을 입력해주세요.</dd>
							</dl>
						</div>
					</div>
				</li>
				<li class="ess double">
					<span class="opt">비밀번호</span>
					<div class="value">
						<input type="password" name="j_passwd" id="j_passwd" class="input_design" />
						<div class="tip_txt">
							<dl>
								<dd>영문, 숫자로 6자이상 입력해주세요.</dd>
							</dl>
						</div>
					</div>					
				</li>
				<li class="ess double">
					<span class="opt">비밀번호 확인</span>
					<div class="value"><input type="password" type="password" name="j_repasswd" id="j_repasswd" class="input_design" />
						<div class="tip_txt">
							<dl>
								<dd>동일하게 다시 한번 입력해주세요.</dd>
							</dl>
						</div>
					</div>
				</li>
				<li class="ess double">
					<span class="opt">E-mail</span>
					<div class="value" >
						<input type="text" name="j_email" id="j_email" class="input_design" value=""/>
					</div>
				</li>
				<!--<li class="ess double">
					<span class="opt">닉네임</span>
					<div class="value">
						<input type="text" name="j_nickname" id="j_nickname" class="input_design" value=""/>
					</div>
				</li>-->
				<li class="ess double">
                  <span class="opt">연락처</span>
                  <div class="value">
                     <input type="tel" name="j_tel1" id="j_tel1" value="" class="input_design" style="width:80px" maxlength="3" /><span class="dash"></span>
                     <input type="tel" name="j_tel2" id="j_tel2" value="" class="input_design" style="width:80px" maxlength="4" /><span class="dash"></span>
                     <input type="tel" name="j_tel3" id="j_tel3" value="" class="input_design" style="width:80px" maxlength="4" />
                  </div>
               </li>
			   <li class="ess double">
					<span class="opt">소속부서</span>
					<div class="value" style="padding-bottom:14px;">
						<select name="j_department" id="j_department" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::소속 부서를 선택해주세요::::::</option>
							<?foreach($staff_department as $key => $val){?>
									<option value="<?=$val?>"><?=$key?></option>
							<?}?>
						</select>
					</div>
				</li>
				<li class="ess double">
					<span class="opt">소속팀</span>
					<div class="value">
						<select name="j_team" id="j_team" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::소속 팀을 선택해주세요::::::</option>
							<? foreach($staff_team as $key2 => $val2){?>
								<option value="<?=$val2?>"><?=$key2?></option>
							<? } ?>
						</select>
						<select name="j_position" id="j_position" class="add_option add_option_chk" style="height:30px;">
							<option value="">::::::직급을 선택해주세요::::::</option>
							<? foreach($staff_position as $key => $val){?>
								<option value="<?=$val?>"><?=$key?></option>
							<? } ?>
						</select>
					</div>
				</li>
				<li class="">
					<span class="opt">MD 여부</span>
					<div class="value">
						<label><input type="checkbox" name="j_md" id="j_md" value="Y" />MD입니다.</label>
						<div class="tip_txt">
							<dl>
								<dd>MD일 경우에만 체크 해주세요.</dd>
							</dl>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<!-- / 회원기본정보 -->

		<!-- 가운데정렬버튼 -->
		<div class="cm_bottom_button">
			<span class="lineup">				
				<span class="button_pack"><a onclick="return confirm('회원가입을 취소하고 메인으로 이동합니다. 계속하시겠습니까?');" href="/" title="" class="btn_lg_black">회원가입 취소<span class="edge"></span></a></span>
				<span class="button_pack"><a href="#none" title="" onclick="join_submit();return false;" class="btn_lg_color">회원가입 완료<span class="edge"></span></a></span>
			</span>
		</div>
		<!-- / 가운데정렬버튼 -->

	</form>
	
	</div>
</div>

<script type="text/javascript">
	function join_submit() {

		var kor_check = /[ㄱ-ㅗ|ㅏ-ㅣ|가-힣]/;
		var id_chk = $('#j_id').val();
		var pw_chk = $('#j_passwd').val();
		var repw_chk = $('#j_repasswd').val();

		if(kor_check.test(id_chk)){
			alert("아이디에 한글은 포함할 수 없습니다.");
			
		}

		if ($('#j_id').val() == ""){
			alert("아이디를 입력하세요.");
			$('#j_id').focus();
			return;
		}
		
		if ($('#j_passwd').val() == ""){
			alert("비밀번호를 입력하세요.");
			$('#j_passwd').focus();
			return;
		}
		if ($('#j_repasswd').val() == ""){
			alert("비밀번호 확인을 입력하세요.");
			$('#j_repasswd').focus();
			return;
		}
		if(pw_chk != repw_chk){
			alert("비밀번호가 일치하지 않습니다.");
			$('#j_repasswd').focus();
			return;
		}
		if ($('#j_name').val() == ""){
			alert("이름을 입력하세요.");
			$('#j_name').focus();
			return;
		}
		if ($('#j_email').val() == ""){
			alert("E-mail을 입력하세요.");
			$('#j_email').focus();
			return;
		}
		if ($('#j_nickname').val() == ""){
			alert("닉네임을 입력하세요.");
			$('#j_nickname').focus();
			return;
		}		
		if ($('#j_tel1').val() == ""){
			alert("핸드폰 번호를 완전히 입력하세요.");
			$('#j_tel1').focus();
			return;
		}
		if ($('#j_tel2').val() == ""){
			alert("핸드폰 번호를 완전히 입력하세요.");
			$('#j_tel2').focus();
			return;
		}
		if ($('#j_tel3').val() == ""){
			alert("핸드폰 번호를 완전히 입력하세요.");
			$('#j_tel3').focus();
			return;
		}
		if ($('#j_department').val() == ""){
			alert("소속부서를 선택해주세요.");
			$('#j_department').focus();
			return;
		}
		if ($('#j_team').val() == ""){
			alert("소속팀을 선택해주세요.");
			$('#j_team').focus();
			return;
		}
		if ($('#j_position').val() == ""){
			alert("직급을 선택해주세요.");
			$('#j_position').focus();
			return;
		}
		$('#join_frm').submit();
		
	}

function idCheck(){
	var j_id = $("#j_id").val();
	if(j_id == "") {
		alert('아이디를 먼저 입력하세요.'); 
		$("#j_id").focus();
		return false;
	}else{
		$.post("member.id.check.php", {j_id:j_id}, function(data){
				if(data == 'ok'){
					alert("사용가능한 아이디 입니다.");
				}else{
					alert("이미 사용중인 아이디 입니다.");
				}
		});
	}

}
</script>

<?
include_once "inc.footer.php";
?>