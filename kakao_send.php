<?

function setSmsContent_jooyon($sms_type, $sms_value){
   $return['result'] = false;
   if ($sms_type == '') return $return;

   //db�� ���õ� ���� ��������
   $SQL = " SELECT * FROM jooyon_db.ecm_sms_setting WHERE sms_type = '$sms_type' and jooyon_gubun = 'Y'";
   $res = mysql_query($SQL);
   while ($row = mysql_fetch_array($res, MYSQL_ASSOC)){
      $sms_set_site = $row['sms_set_site'];
      $sms_set[$sms_set_site] = $row;
   }

   //�ֹ������� �ֹ�����Ʈ
   $now_site = $sms_value['check_site'];
   $setting = ($sms_set[$now_site]) ? $sms_set[$now_site] : $sms_set['allsite'];

   //���ڿ� ġȯ
   $sms_content = $setting['sms_set_content'];
   $sms_content = str_replace('{�ֹ���ȣ}', $sms_value['buyer_sess'], $sms_content);
   $sms_content = str_replace('{������}', $sms_value['order_manager'], $sms_content);
   $sms_content = str_replace('{�Ա�����}', $sms_value['order_bankinfo'], $sms_content);
   $sms_content = str_replace('{�ֹ��ݾ�}', $sms_value['order_price'], $sms_content);
   $sms_content = str_replace('{��������}', $sms_value['order_delivery'], $sms_content);
   $sms_content = str_replace('{�ֹ�����Ʈ}', $sms_value['order_site'], $sms_content);
   $sms_content = str_replace('{����}', $sms_value['band_name'], $sms_content);
   $sms_content = str_replace('{���ι�ȣ}', $sms_value['password_apply'], $sms_content);
   $sms_content = str_replace('{��ǰURL}', $sms_value['product_url'], $sms_content);
   $sms_content = str_replace('{��ǰ��}', $sms_value['product_subject'], $sms_content);
   $sms_content = str_replace('{���Ȯ��}', $sms_value['order_confirm'], $sms_content);//���Ȯ�θ�ũ �߰� 2017-03-07 byi
   $sms_content = str_replace('{�亯URL}', $sms_value['reply_url'],$sms_content);
   $sms_content = str_replace('{�ֹ�Ȯ��URL}', $sms_value['confirm_order'], $sms_content);

   $return['result'] = true;
   $return['length'] = strlen($sms_content);
   $return['content'] = $sms_content;
   $return['template'] = $setting['etc']; //���ø��ڵ� ������ �߰���. 2016.07.18 by lysunu

   return $return;
}


function kakaotalk_Conn(){
   $hostname = "192.168.0.3";
   $userName = "mpush_agent";
   $userPassword = "mpush!@#";
   $dbName = "mpush_agent";

   $conn_mpush = @mysql_connect($hostname, $userName, $userPassword);
   if (!$conn_mpush){
      Alert("DB�� ������� �ʾҽ��ϴ�.");
   }

   $db_mpush = mysql_select_db($dbName);
   if (!$db_mpush){
      Alert("�����Ͻ� ��� �����ϴ�. ��� ������ �ٽ� �õ��Ͻʽÿ�");
   }

   return $conn_mpush;
}

//īī���˸��� ������ 2016.07.07 by lysunu
// īī���˸����� ������ ����ü��(���ø�)�� �ۿ� ���ڸ� �������ۿ� ���� ������ CRM������ ���ڹ߼� �ý����� ����Ҽ�����.
function kakaotalk_Send($tel, $template_code, $subject, $body){
   $tel = str_replace('-','',$tel); //������ ��ȭ��ȣ
   $from = str_replace('-','',$fromnum); //�߽��� ��ȣ (�˸����� �̸� ������ ���ξ��̵�� �߼۵Ǳ� ������ �߽��� ��ȭ��ȣ�� ��� �ʿ���� ������)
   $SDATE = date("YmdHis"); //���� �Ͻ�
   $SERVICE_SEQNO = "1000052700";

   $query = " INSERT INTO tsms_agent_message SET "       # īī���˸��� ������Ʈ ���̺�
           ."    SERVICE_SEQNO = '$SERVICE_SEQNO', "     # īī���˸��� ����No - ������
           ."    MESSAGE_SEQNO =  GET_MESSAGE_SEQNO(), " # �ý��� �Ϸù�ȣ(�Լ�ó��) - ������
           ."    SEND_MESSAGE = '$body', "               # �޽��� ���� - ������
           ."    SUBJECT = '$subject', "                 # �޽��� ���� (���ø� �������� ����)  - ������
           ."    BACKUP_MESSAGE = '$body', "             # �δ޽� ���ڷ� �߼۵� �޽��� ����(�⺻������ �޽�������� ����) - ������
           ."    BACKUP_PROCESS_CODE = '003', "          # �δ�ó����� (SMS : 000, MMS : 001, �δ޾��� : 003) - ������
           ."    SEND_FLAG = 'N', "                      # �߼ۿ��� (Default 'N'-�����Ұ�) - ������
           ."    MESSAGE_TYPE = '002', "                 # ��û�޽���Type (SMS : 001, PUSH : 002 PUSH(IMAGE) : 003, PUSH(MULTIMEDIA) : 004) - ������
           ."    CONTENTS_TYPE = '004', "                # ������Type (������: 001, �˸���(html��): 003, �˸���(�ؽ�Ʈ��): 004) - ������
           ."    RECEIVE_MOBILE_NO = '$tel', "           # ������ �޴��� ��ȣ - ������
           ."    JOB_TYPE = 'R00', "                     # �߽�ó�� (�ǽð� : R00, ��ġ : B00) - ������
           ."    COLOR_TYPE = 'C01', "                   # �÷�Ÿ�� (�⺻ : C01, ��Ȳ : C02, ���ֻ� : C03)
           ."    REGISTER_DATE = now(), "                # ��� �Ͻ� - �ý��۳�¥
           ."    REGISTER_BY = 'jooyonshop', "           # �����(jooyon) - ����� ���� ��� �������.
           ."    RESERVE7 = '$template_code' ";          # īī�����ø� �ڵ� - ������
   return $result = @mysql_query($query);
}

?>