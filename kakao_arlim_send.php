 <?php
 
 if ($xpay->Response("LGD_PAYTYPE",0) == 'SC0040'){            
               $sms_value = array('product_subject' => cut_str($all_purchase_subject, 25), //주문 상품
                                  'buyer_sess' => $OrdNo,                     //주문 번호
                                  'order_manager' => $buyer_name1,            //접수자명
                                  'order_bankinfo' => $virtual_bank_account, //할당받은 입금은행계좌
                                  'order_price' => $buyer_price,              //주문 금액
                                  'order_site' => $site_nm,
								  'confirm_order' => $confirm_order	  
								  );                  //주문 사이트
                //밴드코드가 jooyon에 속했을경우 주연전용 알림톡으로 2018-03-22 byi
				if(in_array($bandCd, $arr_kakao_jooyon)){
					   $smsContent = setSmsContent_jooyon('주문완료-입금', $sms_value);
				}else{
					  $smsContent = setSmsContent_test('주문완료-입금', $sms_value);
				}
			   //$smsContent = setSmsContent_test('주문완료-입금', $sms_value);


               //0원인 상품도 매출테이블 INSERT
               dbconn();

               //결제완료 상태일때..
               //일일매출현황
               $store = $bu_list["buyer_store"];
               $delivery = $bu_list["buyer_delivery"];
               $discount = $bu_list["buyer_discount"];
               

               //가상계좌이면서 금액이 0원일때 매출처리 
               if($buyer_price == "0"){
                  //일일 매출 등록
                  UserDirect_saleDo($OrdNo, $store, $delivery, $discount);
                  UserDirect_saleDoOLD($OrdNo, $store, $delivery, $discount);
               }
               


            }
            else { //그 외의 결재방식일 경우 결제완료 문자발송   
                //(2015.06.10 수정 - lysunu) 
               $sms_value = array('product_subject' => $all_purchase_subject, 'buyer_sess' => $OrdNo, 'order_price' => $buyer_price, 'order_site' => $site_nm, 'confirm_order' => $confirm_order);
               
			   //밴드코드가 jooyon에 속했을경우 주연전용 알림톡으로 2018-03-22 byi
				if(in_array($bandCd, $arr_kakao_jooyon)){
					   $smsContent = setSmsContent_jooyon('결제완료-즉시결제', $sms_value);
				}else{
					  $smsContent = setSmsContent_test('결제완료-즉시결제', $sms_value);
				}
			   //$smsContent = setSmsContent_test('결제완료-즉시결제', $sms_value);
            }

            kakaotalk_Conn();

			$smsFromNum = str_replace("-", "", trim($formTel));
			
			if(in_array($bandCd, $arr_kakao_jooyon)){
				$result = kakaotalk_jooyon_Send($tel, $smsContent['template'], '', $smsContent['content']);
			}else{
				$result = kakaotalk_Send($tel, $smsContent['template'], '', $smsContent['content']);
			}

?>