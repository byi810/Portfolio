<?

function setSmsContent_jooyon($sms_type, $sms_value){
   $return['result'] = false;
   if ($sms_type == '') return $return;

   //db에 세팅된 내역 가져오기
   $SQL = " SELECT * FROM jooyon_db.ecm_sms_setting WHERE sms_type = '$sms_type' and jooyon_gubun = 'Y'";
   $res = mysql_query($SQL);
   while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
      $sms_set_site = $row['sms_set_site'];
      $sms_set[$sms_set_site] = $row;
   }

   //주문내역의 주문사이트
   $now_site = $sms_value['check_site'];
   $setting = ($sms_set[$now_site]) ? $sms_set[$now_site] : $sms_set['allsite'];

   //문자열 치환
   $sms_content = $setting['sms_set_content'];
   $sms_content = str_replace('{주문번호}', $sms_value['buyer_sess'], $sms_content);
   $sms_content = str_replace('{접수자}', $sms_value['order_manager'], $sms_content);
   $sms_content = str_replace('{입금정보}', $sms_value['order_bankinfo'], $sms_content);
   $sms_content = str_replace('{주문금액}', $sms_value['order_price'], $sms_content);
   $sms_content = str_replace('{송장정보}', $sms_value['order_delivery'], $sms_content);
   $sms_content = str_replace('{주문사이트}', $sms_value['order_site'], $sms_content);
   $sms_content = str_replace('{밴드명}', $sms_value['band_name'], $sms_content);
   $sms_content = str_replace('{승인번호}', $sms_value['password_apply'], $sms_content);
   $sms_content = str_replace('{상품URL}', $sms_value['product_url'], $sms_content);
   $sms_content = str_replace('{상품명}', $sms_value['product_subject'], $sms_content);
   $sms_content = str_replace('{배송확인}', $sms_value['order_confirm'], $sms_content);//배송확인링크 추가 2017-03-07 byi
   $sms_content = str_replace('{답변URL}', $sms_value['reply_url'],$sms_content);
   $sms_content = str_replace('{주문확인URL}', $sms_value['confirm_order'], $sms_content);

   $return['result'] = true;
   $return['length'] = strlen($sms_content);
   $return['content'] = $sms_content;
   $return['template'] = $setting['etc']; //템플릿코드 때문에 추가함. 2016.07.18 by lysunu

   return $return;
}


function kakaotalk_Conn(){
   $hostname = "192.168.0.3";
   $userName = "mpush_agent";
   $userPassword = "mpush!@#";
   $dbName = "mpush_agent";

   $conn_mpush = @mysql_connect($hostname, $userName, $userPassword);
   if (!$conn_mpush){
      Alert("DB에 연결되지 않았습니다.");
   }

   $db_mpush = mysql_select_db($dbName);
   if (!$db_mpush){
      Alert("선택하신 디비가 없습니다. 디비 생성후 다시 시도하십시요");
   }

   return $conn_mpush;
}

//카카오알림톡 보내기 2016.07.07 by lysunu
// 카카오알림톡은 지정된 문자체계(템플릿)로 밖에 문자를 보낼수밖에 없기 때문에 CRM에서의 문자발송 시스템은 사용할수없음.
function kakaotalk_Send($tel, $template_code, $subject, $body){
   $tel = str_replace('-','',$tel); //수신자 전화번호
   $from = str_replace('-','',$fromnum); //발신자 번호 (알림톡은 미리 지정된 옐로아이디로 발송되기 때문에 발신자 전화번호는 사실 필요없는 정보임)
   $SDATE = date("YmdHis"); //전송 일시
   $SERVICE_SEQNO = "1000052700";

   $query = " INSERT INTO tsms_agent_message SET "       # 카카오알림톡 에이전트 테이블
           ."    SERVICE_SEQNO = '$SERVICE_SEQNO', "     # 카카오알림톡 서비스No - 고정값
           ."    MESSAGE_SEQNO =  GET_MESSAGE_SEQNO(), " # 시스템 일련번호(함수처리) - 고정값
           ."    SEND_MESSAGE = '$body', "               # 메시지 내용 - 변수값
           ."    SUBJECT = '$subject', "                 # 메시지 제목 (테플릿 제목으로 응용)  - 변수값
           ."    BACKUP_MESSAGE = '$body', "             # 부달시 문자로 발송될 메시지 내용(기본적으로 메시지제목과 동일) - 변수값
           ."    BACKUP_PROCESS_CODE = '003', "          # 부달처리방법 (SMS : 000, MMS : 001, 부달없음 : 003) - 고정값
           ."    SEND_FLAG = 'N', "                      # 발송여부 (Default 'N'-수정불가) - 고정값
           ."    MESSAGE_TYPE = '002', "                 # 요청메시지Type (SMS : 001, PUSH : 002 PUSH(IMAGE) : 003, PUSH(MULTIMEDIA) : 004) - 고정값
           ."    CONTENTS_TYPE = '004', "                # 컨텐츠Type (영수증: 001, 알리미(html형): 003, 알리미(텍스트형): 004) - 고정값
           ."    RECEIVE_MOBILE_NO = '$tel', "           # 수신자 휴대폰 번호 - 변수값
           ."    JOB_TYPE = 'R00', "                     # 발신처리 (실시간 : R00, 배치 : B00) - 고정값
           ."    COLOR_TYPE = 'C01', "                   # 컬러타입 (기본 : C01, 주황 : C02, 자주색 : C03)
           ."    REGISTER_DATE = now(), "                # 등록 일시 - 시스템날짜
           ."    REGISTER_BY = 'jooyonshop', "           # 등록자(jooyon) - 어떤값을 쓰던 사실 상관없음.
           ."    RESERVE7 = '$template_code' ";          # 카카오템플릿 코드 - 변수값
   return $result = @mysql_query($query);
}

?>