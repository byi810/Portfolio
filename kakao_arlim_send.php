 <?php
 
 if ($xpay->Response("LGD_PAYTYPE",0) == 'SC0040'){            
               $sms_value = array('product_subject' => cut_str($all_purchase_subject, 25), //�ֹ� ��ǰ
                                  'buyer_sess' => $OrdNo,                     //�ֹ� ��ȣ
                                  'order_manager' => $buyer_name1,            //�����ڸ�
                                  'order_bankinfo' => $virtual_bank_account, //�Ҵ���� �Ա��������
                                  'order_price' => $buyer_price,              //�ֹ� �ݾ�
                                  'order_site' => $site_nm,
								  'confirm_order' => $confirm_order	  
								  );                  //�ֹ� ����Ʈ
                //����ڵ尡 jooyon�� ��������� �ֿ����� �˸������� 2018-03-22 byi
				if(in_array($bandCd, $arr_kakao_jooyon)){
					   $smsContent = setSmsContent_jooyon('�ֹ��Ϸ�-�Ա�', $sms_value);
				}else{
					  $smsContent = setSmsContent_test('�ֹ��Ϸ�-�Ա�', $sms_value);
				}
			   //$smsContent = setSmsContent_test('�ֹ��Ϸ�-�Ա�', $sms_value);


               //0���� ��ǰ�� �������̺� INSERT
               dbconn();

               //�����Ϸ� �����϶�..
               //���ϸ�����Ȳ
               $store = $bu_list["buyer_store"];
               $delivery = $bu_list["buyer_delivery"];
               $discount = $bu_list["buyer_discount"];
               

               //��������̸鼭 �ݾ��� 0���϶� ����ó�� 
               if($buyer_price == "0"){
                  //���� ���� ���
                  UserDirect_saleDo($OrdNo, $store, $delivery, $discount);
                  UserDirect_saleDoOLD($OrdNo, $store, $delivery, $discount);
               }
               


            }
            else { //�� ���� �������� ��� �����Ϸ� ���ڹ߼�   
                //(2015.06.10 ���� - lysunu) 
               $sms_value = array('product_subject' => $all_purchase_subject, 'buyer_sess' => $OrdNo, 'order_price' => $buyer_price, 'order_site' => $site_nm, 'confirm_order' => $confirm_order);
               
			   //����ڵ尡 jooyon�� ��������� �ֿ����� �˸������� 2018-03-22 byi
				if(in_array($bandCd, $arr_kakao_jooyon)){
					   $smsContent = setSmsContent_jooyon('�����Ϸ�-��ð���', $sms_value);
				}else{
					  $smsContent = setSmsContent_test('�����Ϸ�-��ð���', $sms_value);
				}
			   //$smsContent = setSmsContent_test('�����Ϸ�-��ð���', $sms_value);
            }

            kakaotalk_Conn();

			$smsFromNum = str_replace("-", "", trim($formTel));
			
			if(in_array($bandCd, $arr_kakao_jooyon)){
				$result = kakaotalk_jooyon_Send($tel, $smsContent['template'], '', $smsContent['content']);
			}else{
				$result = kakaotalk_Send($tel, $smsContent['template'], '', $smsContent['content']);
			}

?>