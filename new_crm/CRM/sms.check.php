<?
include_once "include/inc.php";
$sql = "select * from odtSmsSetting order by uid";
$todate = date("Y-m-d", mktime());
$sms_set_time = mktime();

$sql = "select * from odtSmsSetting where uid = '".$_REQUEST[uid]."'";
$rs_del_query = mysql_query($sql);
$row_del_query=mysql_fetch_array($rs_del_query);

switch ($_REQUEST[mode]){
	case "create":
	$html = "
		<input type='hidden' name='' id='' value=''>
		<input type='hidden' name='' id='' value=''>
		<input type='hidden' name='sms_set_time' id='sms_set_time' value='".$sms_set_time."''>
		<div class='cm_user_guide' style='padding:10px; margin-top:5px; margin-bottom:5px;'>
			<dl style='margin-left: 125px;padding-left: 15px;'>
				<dt>알려드립니다!</dt>
				<dd><strong>예약어는 하단에 명시된 예약어들로만 사용하실 수 있습니다.</strong></dd>
				<dd style='line-height: 15px;'>{주문번호}, {접수자}, {입금정보}, {주문금액}, {송장정보}, {주문사이트}, {밴드명}
				{승인번호}, {상품URL}, {상품명}, {배송확인}</dd>
			</dl>
		</div>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>작성자</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>".$_REQUEST['uid']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 타입</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_type' id='sms_type' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 타입을 선택해주세요::::::</option>
							<option value='주문완료'>주문완료</option>
							<option value='주문접수'>주문접수</option>
							<option value='주문취소'>주문취소</option>
							<option value='결제완료'>결제완료</option>
							<option value='상품스크랩'>상품스크랩</option>
							<option value='송장등록'>송장등록</option>
							<option value='송장대량등록'>송장대량등록</option>
							<option value='송장수정'>송장수정</option>
							<option value='출고발조'>출고발조</option>
						</select>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 세부타입</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_type_sub' id='sms_type_sub' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 세부타입을 선택해주세요::::::</option>
							<option value='결제완료/무통장'>결제완료/무통장</option>
							<option value='결제완료/전화카드'>결제완료/전화카드</option>
							<option value='결제완료/즉시결제'>결제완료/즉시결제</option>
							<option value='주문완료/입금'>주문완료/입금</option>
							<option value='주문완료/전화카드'>주문완료/전화카드</option>
							<option value='출고발주/무통장'>출고발주/무통장</option>
							<option value='출고발주/즉시결제'>출고발주/즉시결제</option>
						</select>
					</div>
				</li> 
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 적용 사이트</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_set_site' id='sms_set_site' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 세부타입을 선택해주세요::::::</option>
							<option value='통합사이트'>통합사이트</option>
							<option value='밴드주문'>밴드주문</option>
							<option value='기본설정'>기본설정</option>
						</select>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>템플릿 코드</span>
					<div class='value' style='text-align: center;'>
						<input type='text' name='sms_template' id='sms_template' value='' class='input_date' style='width: 90%;padding: 0 5px;border: 1px;border-color: black;height: 25px;background: #fafafa;' />
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>sms 발송 내용</span>
					<div class='value' style='text-align: center;'>
						<textarea name='sms_set_content' id='sms_set_content' value='' class='input_date' style='width: 90%;padding: 0 5px;border: 1px;border-color: black;height: 250px;background: #fafafa;'>[주연홈쇼핑]
						</textarea>
					</div>
				</li>
			</ul>
		</div>
	";		
	break;

	case "show" :
	$html = "
		<input type='hidden' name='' id='' value=''>
		<input type='hidden' name='' id='' value=''>
		<input type='hidden' name='sms_set_time' id='sms_set_time' value='".$sms_set_time."''>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:37px'>항목</span>
					<div class='value' style='background:#fbfbfb;text-align: center;'>내용</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>주문완료-입금</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>쇼핑몰에서 입금주문 완료시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>주문완료-전화카드</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>어베이직에서 전화카드 접수 완료시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>결제완료-무통장</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>입금주문 입금확인후 결제 완료로 액션시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>결제완료-전화카드</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>전화카드 카드승인후 결제 완료로 액션시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>결제완료-즉시결제</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>PG(신용카드,계좌이체, 핸드폰결제) 주문 및 결제완료시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>주문취소</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>모든 주문 주문 취소 액션시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>송장등록</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>송장번호 등록시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>송장대량등록</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>송장번호 대량등록시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>송장정보수정</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>등록된 송장번호를 수정했을때</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>상품스크랩</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>쇼핑몰에서 고객이 상품URL 문자전송시</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>패스워드찾기 인증번호</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>패스워드찾기 인증문자</span>
					</div>
				</li>
			</ul>
		</div>
	";
	break;
	

	case "delete":
	$html = "
		<input type='hidden' name='' id='' value=''>`
		<input type='hidden' name='uid' id='uid' value='".$row_del_query['uid']."'>
		<input type='hidden' name='mod_date' id='mod_date' value='".$sms_set_time."''>
		<div class='cm_user_guide' style='padding:10px; margin-top:5px; margin-bottom:5px;'>
			<dl style='margin-left: 125px;padding-left: 15px;'>
				<dt>알려드립니다!</dt>
				<dd><strong>예약어는 하단에 명시된 예약어들로만 사용하실 수 있습니다.</strong></dd>
				<dd style='line-height: 15px;'>{주문번호}, {접수자}, {입금정보}, {주문금액}, {송장정보}, {주문사이트}, {밴드명}
				{승인번호}, {상품URL}, {상품명}, {배송확인}</dd>
			</dl>
		</div>
		<div class='cm_member_form'>
			<ul>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>UID</span>
					<div class='value' style='text-align: center;'>
						<span class='texticon_pack' name='register_date' id='register_date'>".$row_del_query['uid']."</span>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 타입</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_type' id='sms_type' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 타입을 선택해주세요::::::</option>
							<option value='OC'>주문완료</option>
							<option value='OR'>주문접수</option>
							<option value='OF'>주문취소</option>
							<option value='PO'>결제완료</option>
							<option value='PS'>상품스크랩</option>
							<option value='IR'>송장등록</option>
							<option value='MIR'>송장대량등록</option>
							<option value='IM'>송장수정</option>
							<option value='RO'>출고발조</option>
						</select>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 세부타입</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_type_sub' id='sms_type_sub' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 세부타입을 선택해주세요::::::</option>
							<option value='PNB'>결제완료/무통장</option>
							<option value='PPC'>결제완료/전화카드</option>
							<option value='PIP'>결제완료/즉시결제</option>
							<option value='OCD'>주문완료/입금</option>
							<option value='OPC'>주문완료/전화카드</option>
							<option value='RNB'>출고발주/무통장</option>
							<option value='RIP'>출고발주/즉시결제</option>
						</select>
					</div>
				</li> 
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>SMS 적용 사이트</span>
					<div class='value' style='text-align: center;'>
						<select name='sms_set_site' id='sms_set_site' class='add_option add_option_chk' style='height:30px;'>
							<option value=''>::::::SMS 세부타입을 선택해주세요::::::</option>
							<option value='AS'>통합사이트</option>
							<option value='BD'>밴드주문</option>
							<option value='BS'>기본설정</option>
						</select>
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>템플릿 코드</span>
					<div class='value' style='text-align: center;'>
						<input type='text' name='sms_template' id='sms_template' value='".$row_del_query[sms_template]."' class='input_date' style='width: 90%;padding: 0 5px;border: 1px;border-color: black;height: 25px;background: #fafafa;' />
					</div>
				</li>
				<li class=''>
					<span class='opt' style='background:none;padding-left:0px'>sms 발송 내용</span>
					<div class='value' style='text-align: center;'>
						<textarea name='sms_set_content' id='sms_set_content' value='' class='input_date' style='width: 90%;padding: 0 5px;border: 1px;border-color: black;height: 250px;background: #fafafa;'>".$row_del_query[sms_set_content]."
						</textarea>
					</div>
				</li>
			</ul>
		</div>
	";		
	break;
}
	echo $html;
?>