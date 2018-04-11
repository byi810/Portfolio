<?
include_once "inc.header.php";
?>

<style>
body {background:#414143}

.common_page .title_box {
    margin-bottom: 20px;
    overflow: hidden;
    font-family: calibri;
    font-size: 50px;
    color: #fff;
    letter-spacing: -1px;
    font-weight: 600;
    text-align: center;
}

.body_title{
	margin-bottom: 20px;
    font-family: calibri;
    font-size: 50px;
    color: #daff01;
    letter-spacing: -1px;
    font-weight: 600;
}
</style>


<div class="common_page common_only" style="border-left:0px;border-right:0px;">
	<div class="title_box"><span class="body_title">CRM</span> LOGIN</div>
	<form name="login_frm" id="login_frm" method="post" action="login.check.php">
	
	<!-- ●●●●●●●●●● 로그인 -->
	<div class="cm_member_login">	
			
		<div class="form_box">
			<ul>
				<li class="login_id"><input type="text" name="mb_id" id="input_id" class="input_design" placeholder="아이디" value=""/></li>
				<li class="login_pw"><input type="password" name="mb_password" id="input_pw" class="input_design" value="" placeholder="비밀번호"/></li>
			</ul>			
			<input type="button" onclick="submitForm()" class="btn_login" value="LOGIN"/>
		</div>	
		
		<div class="btn_box">
			<ul>
				<li style="letter-spacing:0px">주연직원이시나 회원가입을 아직 하지 않으셨나요?<span class="button_pack"><a href="/?pn=join" class="btn_md_black">회원가입</a></span></li>
			</ul>
		</div>
	
	</div>	
	<!-- / 로그인 -->

	</form>

</div>

<script type="text/javascript">

	$('#input_pw').keyup(han_keyup_mb_password);

	function submitForm() {
		if ($('#input_id').val() == ""){
			alert("아이디를 입력하세요.");
			$('#input_id').focus();
			return;
		}
		
		if ($('#input_pw').val() == ""){
			alert("비밀번호를 입력하세요.");
			$('#input_pw').focus();
			return;
		}

		$('#login_frm').submit();
		
	}

	function han_keyup_mb_password() {
		if (event.keyCode == 13){
			submitForm();
		}
	}
</script>
