<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bsms_send\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}
?>

<script>
!function(e){var t,o={className:"autosizejs",id:"autosizejs",append:"\n",callback:!1,resizeDelay:10,placeholder:!0},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',a=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent","whiteSpace"],n=e(i).data("autosize",!0)[0];n.style.lineHeight="99px","99px"===e(n).css("lineHeight")&&a.push("lineHeight"),n.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),n.parentNode!==document.body&&e(document.body).append(n),this.each(function(){function o(){var t,o=window.getComputedStyle?window.getComputedStyle(u,null):null;o?(t=parseFloat(o.width),("border-box"===o.boxSizing||"border-box"===o.webkitBoxSizing||"border-box"===o.mozBoxSizing)&&e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){t-=parseFloat(o[i])})):t=p.width(),n.style.width=Math.max(t,0)+"px"}function s(){var s={};if(t=u,n.className=i.className,n.id=i.id,d=parseFloat(p.css("maxHeight")),e.each(a,function(e,t){s[t]=p.css(t)}),e(n).css(s).attr("wrap",p.attr("wrap")),o(),window.chrome){var r=u.style.width;u.style.width="0px";{u.offsetWidth}u.style.width=r}}function r(){var e,a;t!==u?s():o(),n.value=!u.value&&i.placeholder?p.attr("placeholder")||"":u.value,n.value+=i.append||"",n.style.overflowY=u.style.overflowY,a=parseFloat(u.style.height)||0,n.scrollTop=0,n.scrollTop=9e4,e=n.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=z,Math.abs(a-e)>.01&&(u.style.height=e+"px",n.className=n.className,w&&i.callback.call(u,u),p.trigger("autosize.resized"))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==b&&(b=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),z=0,w=e.isFunction(i.callback),f={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},b=p.width(),g=p.css("resize");p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(z=p.outerHeight()-p.height()),c=Math.max(parseFloat(p.css("minHeight"))-z||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word"}),"vertical"===g?p.css("resize","none"):"both"===g&&p.css("resize","horizontal"),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(f).removeData("autosize")}),r())})):this}}(jQuery||$);
</script>

<div class="common_page common_none">
	<!-- ●●●●●●●●●● 타이틀상단 -->
	<div class="cm_common_top">
		<div class="commom_page_title">
			<span class="icon_img"></span>
			<dl>
				<dt><a href="sms.send.php">SMS 발송</a></dt>
				<!--<dd>나의 쇼핑정보 및 사이트 이용정보를 관리할 수 있습니다.</dd>-->
			</dl>
		</div>

	</div>
	<!-- / 타이틀상단 -->
</div>
<div class="content_section" style="width:68%; margin: 0 auto;">
	<div class="content_section_fix">
		<form name="form_sms" method="post" action="sms.send.pro.php" enctype="multipart/form-data">
			<input type="hidden" name="form" id="form" value="sendform">
			<input type="hidden" name="send_list_serial" id="send_list_serial">
			<input type="hidden" name="message_len_id" id="message_len_id" value=<?=$message_len_id?>>
			<!-- 문자내용 세부설정 -->
			<div class="new_sms_form freeHeight">
				
				<!-- 문자항목들 -->
				<div class="aside_send_box">
					
					<!-- 받는 사람 입력부분 -->
					<div class="send_to">
						<div class="title">받는 사람</div>
						<div class="phone_number">
							<input name="send_to_num1" tabindex="1" id="send_to_num1" type="text" maxlength="3" class="input_design"><span class="unit">-</span>
							<input name="send_to_num2" tabindex="2" id="send_to_num2" type="text" maxlength="4" class="input_design" ><span class="unit">-</span>
							<input name="send_to_num3" tabindex="3" id="send_to_num3" type="text" maxlength="4" class="input_design">
						</div>
						<script>
						$(document).ready(function(){
							$('#send_to_num1').on('keyup',function(){ if($(this).val().length == 3) { $('#send_to_num2').focus(); } });
							$('#send_to_num2').on('keyup',function(){ if($(this).val().length == 4) { $('#send_to_num3').focus(); } });
							$('#send_to_num3').on('keyup',function(){ if($(this).val().length == 4) { $('.add_to .btn_add').focus(); } });
						});
						</script>		
						<input type="button" name="" tabindex="4" class="btn_add" value="+받는사람 추가하기" onclick="send_list_add(form_sms)"/>
						<input type="button" class="btn_add" value="+일괄등록" onclick="multi_send_list()" style="background:purple" />

						<div class="list">
							<select name="send_list" id="send_list" multiple class="" ></select>
						</div>
						<div class="total">
							받는 사람 총 <b id="slt_phonecnt">0</b></span>명
							<a href="#none" onclick="send_list_delete(form_sms);return false;" class="btn_delete">선택삭제</a>
						</div>
					</div>
					
					<div class="send_from">
						<div class="title">보내는 사람</div>
						<div class="phone_number">
							<input name="send_from_num" id="send_from_num" class="input_design" type="text" value="1544-4904">
						</div>
					</div>

					<div class="button_box">
						<span class="shop_btn_pack btn_input_red"><input type="button" name="" onclick="send_ok(form_sms)" class="input_large" value="문자 전송하기" /></span>
					</div>
				</div>
				<!-- 휴대폰한번감싸기 -->
				<div class="new_sms_send_wrap">
					<!-- 휴대폰폼 -->
					<div class="new_sms_phone">
						<div class="body" style="margin-top:10px;">
							<div class="inner">
								<!-- 제목 lms, mms : placeholder ie하위버전 체크바랍니다 -->
								<div class="title_box"><input type="text" class="input_design a_title" style="outline:0;" name="send_title" placeholder="문자메세지의 제목을 입력하세요." /></div>
								<!-- 이 상자가 스크롤이 생기는 부분입니다 -->
								<div class="fix_box a_box textarea_wrap" style="cursor:text;">								
									<!-- 메세지내용 -->
									<div class="message_box">
										<!-- 이미지첨부 들어갈 위치 -->
										<div class="textarea" style="border:0;cursor: text;">
											<textarea name="message" id="message" tabindex="1" rows="4" data-ma="a" style="display:block;resize:none;width:100%;outline:0;" class="textarea_content chk_length"></textarea>
										</div>
										<div class="bubble_bottom"></div>
									</div>
								</div>
								<!-- byte검사 문자구분 -->
								<div class="total_box"><span style="color:inherit;" id="message_len_id" class="a_len">0</span> byte <b id="sms_type" class="a_type">SMS</b></div>
							</div>
						</div>
						<div class="bottom"></div>
					</div>

					<!-- 2015-09-15 SMS발송옵션 설정 LDD006 {-->
					<div style="clear:both;"></div>
					<div class="new_send_type_set lms_msg" style="left:666px; display:none">
						<dl>
							<dt>LMS발송옵션 설정</dt>
							<dd>
								<label>
									<input type="radio" name="m_send_type" class="m_send_type" value="D" checked>
									<span class="txt">일반발송</span>
									<span class="exp">LMS발송: 최대 2,000Byte</span>
								</label>
							</dd>
							<dd>
								<label>
									<input type="radio" name="m_send_type" class="m_send_type" value="S">
									<span class="txt">SMS 단일발송</span>
									<span class="exp">90byte를 초과하는<br/>내용을 제외하고 발송</span>
								</label>
							</dd>
						</dl>
					</div>
				</div>
				<!-- / 휴대폰한번감싸기 -->
			</div>
		</form>
	</div>
</div>

<div class="cm_ly_pop_tp" id="multi_send_list_view_pop" style="display:none;width:450px;">
	<form name="multi_send_frm" id="multi_send_frm" method="post" action="sms.multi.pro.php" enctype="multipart/form-data">
		
		<div class="title_box">일괄등록<a href="#none" onclick="return false;" class="close btn_close" title="닫기"></a></div>

		<div class="inner_box">

			
			<div class="cm_order_form">
				<ul>
					<li class="ess" style="border:1px solid #dedede;width:99%">
						<span class="opt" style="top:40%">엑셀파일</span>
						<div class="value" style="margin-left: 90px;">
							<input type="file" name="multi_upload">
						</div>
					</li>
				</ul>
			</div>
			<div>
				<span class="button_pack" style="margin-top:10px"><a href="#none" onclick="sample_file_download();" title="" class="btn_md_white" style="float:none">샘플양식다운로드</a></span></li>
			</div>
								
			
			<div class="cm_bottom_button" style="padding:0">
				<ul>
					<li><span class="button_pack" style="margin-top:10px"><a href="#none" onclick="multi_send_submit();" title="" class="btn_md_color">등록</a></span></li>
					<li><span class="button_pack" style="margin-top:10px"><a href="#none" class="close btn_md_black">닫기</a></span></li>
				</ul>
			</div>
			<!-- / 레이어팝업 버튼공간 -->

		</div>
		<!-- / 하얀색박스공간 -->
	</form>
</div>


<script>
	// detect IE version ( returns false for non-IE browsers )
	var ie = function(){for(var e=3,n=document.createElement("div"),r=n.all||[];n.innerHTML="<!--[if gt IE "+ ++e+"]><br><![endif]-->",r[0];);return e>4?e:!e}();
	if(ie!==false && ie<10) { $('.input_file_sms').addClass('old-ie'); } else { $('.input_file_sms').removeClass('old-ie'); }

	// lastIndexOf function
	Array.prototype.lastIndexOf||(Array.prototype.lastIndexOf=function(r){"use strict";if(null==this)throw new TypeError;var t=Object(this),e=t.length>>>0;if(0===e)return-1;var a=e;arguments.length>1&&(a=Number(arguments[1]),a!=a?a=0:0!=a&&a!=1/0&&a!=-(1/0)&&(a=(a>0||-1)*Math.floor(Math.abs(a))));for(var n=a>=0?Math.min(a,e-1):e-Math.abs(a);n>=0;n--)if(n in t&&t[n]===r)return n;return-1});

	// 글자 바이트수로 자르기
	function cutByte(r,t){var e=r,n=0,c=r.length;for(i=0;c>i;i++){if(n+=chr_byte(r.charAt(i)),n==t-1){e=2==chr_byte(r.charAt(i+1))?r.substring(0,i+1):r.substring(0,i+2);break}if(n==t){e=r.substring(0,i+1);break}}return e}function chr_byte(r){return escape(r).length>4?2:1}

	// 숫자에 콤마 추가
	String.prototype.comma=function(){var r=this.replace(/,/g,"");if("0"==r)return"0";var t=/^(-?\d+)(\d{3})($|\..*$)/;return t.test(r)&&(r=r.replace(t,function(r,t,e,n){return t.comma()+(","+e+n)})),r};

		
	function send_list_add(form){
		
		var send_list_count = document.getElementById("send_list").options.length;

		var send_to_num1 = document.getElementById("send_to_num1").value;
		var send_to_num2 = document.getElementById("send_to_num2").value;
		var send_to_num3 = document.getElementById("send_to_num3").value;

		if(!send_to_num1) { alert("받는사람 번호를 입력하세요."); $('#send_to_num1').focus(); return false; }
		if(!send_to_num2) { alert("받는사람 번호를 입력하세요."); $('#send_to_num2').focus(); return false; }
		if(!send_to_num3) { alert("받는사람 번호를 입력하세요."); $('#send_to_num3').focus(); return false; }

		if(send_to_num1 && send_to_num2 && send_to_num3) {

			var send_to_new = send_to_num1+"-"+send_to_num2+"-"+send_to_num3;

			document.getElementById("send_list").options[send_list_count] = new Option(send_to_new,send_to_new);	

			document.getElementById("send_to_num1").value="";
			document.getElementById("send_to_num2").value="";
			document.getElementById("send_to_num3").value="";

			document.getElementById("slt_phonecnt").innerHTML=document.getElementById("send_list").options.length;

			document.getElementById("send_to_num1").focus();
		}
	}

	function send_list_delete(form){
		var send_list_count = document.getElementById("send_list").options.length;
		
		for(i=0;i<send_list_count;i++){
			if(document.getElementById("send_list").options[i].selected == true){
				document.getElementById("send_list").options[i] = null;
				send_list_count--;
				i--;
			}
		}
		document.getElementById("slt_phonecnt").innerHTML=document.getElementById("send_list").options.length;
		document.getElementById("send_to_num1").focus();
	}


	function send_ok(form){

		if(document.getElementById("message").value=="메세지를 입력하세요" || document.getElementById("message").value==""){
			alert("메시지를 입력하세요.");
			document.getElementById("message").value="";
			document.getElementById("message_len_id").innerHTML="0";
			//document.getElementById("message").focus();
			$('.textarea_content').focus();
		}
		else{
			var send_list_count = document.getElementById("send_list").options.length;
			var send_list_value = "";
			
			for(i=0;i<send_list_count;i++){
				if(i==0) send_list_value += document.getElementById("send_list").options[i].value;
				else send_list_value += "/" + document.getElementById("send_list").options[i].value;
			}

			if(send_list_value == ""){
				alert("메시지를 받을 전화번호를 추가하세요");
				document.getElementById("send_to_num1").focus();
			}
			else{
				document.getElementById("send_list_serial").value = send_list_value;
				document.form_sms.submit();
			}
		}
	}

	function str_length(form) {

		if ( navigator.appCodeName != 'Mozilla' ) {
			return document.getElementById("message").value.length;
		}
	   
		var len = 0; 

		for (var i=0; i<document.getElementById("message").value.length; i++) {
		 
			if ( document.getElementById("message").value.substr(i, 1) > '~' ) {
				len+=2;
			} 
			else {
				len++;
			}
		}
	  
		return len;
	}

	function str_prev() {
		if ( navigator.appCodeName != 'Mozilla' ) {
			return document.SEND.h_content.value.length;
		}
		var len = 0; 
	  
		for (var i=0; i<document.SEND.h_content.value.length; i++) {
			if ( document.SEND.h_content.value.substr(i, 1) > '~' ) {
				len+=2;
			} 
			else {
				len++;
			}
		
			if (len > 200) {
				return i;
			}
		}
	  
		return len;
	}

	$(document).ready(function(){

		// 문자입력 폼
		$('.textarea_content').autosize();
		$('.textarea_wrap').on('click',function(){ $(this).find('.textarea_content').focus(); });

		// 파일업로드 처리
		$(".realFile").change(function(){ 
			var ma = $(this).data('ma');
			if($(this).val().length > 0) {
				// 사이즈 체크
				if(this.files && this.files[0].size > 60*1024) { alert("업로드한 파일 크기가 너무 큽니다.\n60KB 이하로 등록하세요."); $(this).val(''); return false; }
				// 확장자 체크
				var validExtensions = ['jpg','jpeg']; 
				var fileName = (ie!==false&&ie<10)?$(this).val().match(/[^\/\\]+$/):this.files[0].name;
				var fileNameExt = (/[.]/.exec(fileName)) ? /[^.]+$/.exec(fileName) : undefined; fileNameExt = $.trim(fileNameExt);
				if($.inArray(fileNameExt, validExtensions) == -1){ alert('JPG 파일만 등록할 수 있습니다.'); $(this).val(''); return false; }
			}
			readURL(ma,this); $('.'+ma+'_box textarea').focus();
		});

		// 업로드한 파일 취소
		$('.textarea_wrap').on('click','.realFile_delete',function(){
			var ma = $(this).data('ma'), del = $(this).data('delete');
			if(confirm("이미지를 삭제하시겠습니까?")) { 
				if(del == 'Y') { $('.'+ma+'_file_OLD').val('').trigger('change'); }
				$('.'+ma+'_file').val('').trigger('change'); $('#'+ma+'_fakeFileTxt').val('');
			} else { return false; }
		});

		// 업로드한 파일 취소 (ie8)
		$('.input_file_sms').on('click','.realFile_delete',function(){
			var ma = $(this).data('ma'), del = $(this).data('delete');
			if($('#'+ma+'_fakeFileTxt').val().length == 0) {
				alert('삭제할 이미지가 없습니다.'); return false;
			} else {
				if(confirm("이미지를 삭제하시겠습니까?")) { 
					if(del == 'Y') { $('.'+ma+'_file_OLD').val('').trigger('reset').trigger('change'); }
					$('.'+ma+'_file').val('').trigger('reset').trigger('change'); $('#'+ma+'_fakeFileTxt').val('');
				} else { return false; }
			}
		});


		// 문구 작성할때 길이 체크
		$('.chk_length').on('keyup',function() { check_length(); });

	});



	// 문자 타입 체크 (sms / lms / mms)
	function check_length(onoff) {
		$('.chk_length').each(function(){
			var len = 0, ma = $(this).data('ma'), height = $('.'+ma+'_box').height(), val = $(this).val();
			var current_type = $('.'+ma+'_type').text(), do_not_alert = onoff===true?true:false;
			
			// 글자수 계산
			if("Mozilla"!=navigator.appCodeName)len=$(this).val().length;else for(var i=0;i<$(this).val().length;i++)$(this).val().substr(i,1)>"~"?len+=2:len++;

			if(len > 2000) { 
				alert('최대 2,000 바이트까지 보내실 수 있습니다.'); val = cutByte(val,1990); $(this).val(val); len = 0;
				// 글자수 재계산
				if("Mozilla"!=navigator.appCodeName)len=$(this).val().length;else for(var i=0;i<$(this).val().length;i++)$(this).val().substr(i,1)>"~"?len+=2:len++;
			}

			$('.'+ma+'_len').text(String(len).comma());
			if($.trim($('.'+ma+'_file').val()).length == 0 && $.trim($('.'+ma+'_file_OLD').val()).length == 0)  {
				if(len > 90) {
					// LMS
					//if(current_type=='SMS' && do_not_alert===false) { alert('LMS로 전환되며 추가요금이 발생합니다.'); }
					$('.'+ma+'_type').text('LMS'); 
					//$('.lms_msg').show(); // LMS를 SMS 규격으로 분할 발송 LDD006
				} else {
					// SMS
					$('.'+ma+'_type').text('SMS');
					//$('.lms_msg').hide(); // LMS를 SMS 규격으로 분할 발송 LDD006
				}
			} else {
				// MMS
				//if(current_type!='MMS' && do_not_alert===false) { alert('MMS로 전환되며 추가요금이 발생합니다.'); }
				$('.'+ma+'_type').text('MMS'); 
				//$('.lms_msg').hide(); // LMS를 SMS 규격으로 분할 발송 LDD006
			}
		});
	}

	// 파일업로드 처리
	function readURL(ma,input) { 
		if(ie!==false&&ie<10) { 
			//alert($('.'+ma+'_file').val());
			if($('.'+ma+'_file').val().length > 0) {
				$('.'+ma+'_img').remove();
				$('.'+ma+'_text').focus();
				check_length();
			} else { $('.'+ma+'_img').remove(); check_length(); }
		} else {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('.'+ma+'_img').remove();
					$('.'+ma+'_box .message_box').prepend('<div class="img_box '+ma+'_img"><a href="#none" onclick="return false;" data-ma="'+ma+'" class="realFile_delete btn_delete" title="이미지삭제"><img src="./images/new_sms/btn_img_delete.png" alt="" /></a><img src="'+e.target.result+'" alt="" /></div>');
					$('.'+ma+'_text').focus();
				}
				reader.readAsDataURL(input.files[0]);
				check_length();
			} else { $('.'+ma+'_img').remove(); check_length(); }
		}
	}


function multi_send_list(){
	$('#multi_send_list_view_pop').lightbox_me({
		centered: true, closeEsc: false,
		onLoad: function() { },
		onClose: function(){ }
	});
}

function sample_file_download(){
	location.href = "sms.multi.pro.php?mode=download";
}

function multi_send_submit(){
	var formData = new FormData();
	formData.append("multi_upload",$("input[name=multi_upload]")[0].files[0]);
	formData.append("mode","multi_send_pro");

	$.ajax({
		url: 'sms.multi.pro.php',
		contentType: false,
		type: 'POST',
		dataType: "json",
		data: formData,  
		cache: false,
		contentType: false,
		processData: false,
		success: function(data){
			var send_list_count = data.length;
			for(i=0;i<send_list_count;i++){
				var send_to_new = data[i];
				document.getElementById("send_list").options[i] = new Option(send_to_new,send_to_new);
			}
			document.getElementById("slt_phonecnt").innerHTML=send_list_count;

			$('#multi_send_list_view_pop').hide();
			$('.lb_overlay').css("background","none");
			$("input[name=multi_upload]").val('');
			document.getElementById("send_to_num1").focus();
		},error : function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
	});

}
</script>

<?
include_once "wrap.footer.php";
?>