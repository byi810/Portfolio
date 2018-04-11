<?
include_once "include/inc.php";

$_mode = $_REQUEST[mode];


switch($_mode){

	case "staff_authorized" :
		$sql = "select * from jy_authority where mb_id = '".$_REQUEST[mb_id]."'";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res);
		$cnt = ($res)?mysql_num_rows($res):0;

		$html = "
			<input type='hidden' name='authority_old' value='".$row[authority]."'>
			<input type='hidden' name='data_cnt' value='".$cnt."'>
		";
		
		if(preg_match("/\bclassify\b/i",$row[authority])){
			$html .= "
				<div class='authority_1'>
					<table>
						<input type='hidden' name='authority[]' value='classify'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품분류관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_1\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bproductlist\b/i",$row[authority])){
			$html .= "
				<div class='authority_2'>
					<table>
						<input type='hidden' name='authority[]' value='productlist'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품리스트
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_2\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bproduct_notify\b/i",$row[authority])){
			$html .= "
				<div class='authority_3'>
					<table>
						<input type='hidden' name='authority[]' value='product_notify'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품공지사항
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_3\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bplanning\b/i",$row[authority])){
			$html .= "
				<div class='authority_4'>
					<table>
						<input type='hidden' name='authority[]' value='planning'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 기획전
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_4\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bevent\b/i",$row[authority])){
			$html .= "
				<div class='authority_5'>
					<table>
						<input type='hidden' name='authority[]' value='event'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 이벤트
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_5\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\borderinfo\b/i",$row[authority])){
			$html .= "
				<div class='authority_6'>
					<table>
						<input type='hidden' name='authority[]' value='orderinfo'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주문정보
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_6\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bdelivery\b/i",$row[authority])){
			$html .= "
				<div class='authority_7'>
					<table>
						<input type='hidden' name='authority[]' value='delivery'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 발주
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_7\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\binvoice\b/i",$row[authority])){
			$html .= "
				<div class='authority_8'>
					<table>
						<input type='hidden' name='authority[]' value='invoice'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 송장등록
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_8\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\brelease\b/i",$row[authority])){
			$html .= "
				<div class='authority_9'>
					<table>
						<input type='hidden' name='authority[]' value='release'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 출고중지
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_9\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bexchange_refund\b/i",$row[authority])){
			$html .= "
				<div class='authority_10'>
					<table>
						<input type='hidden' name='authority[]' value='exchange_refund'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 교환/반품
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_10\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bordercancel\b/i",$row[authority])){
			$html .= "
				<div class='authority_11'>
					<table>
						<input type='hidden' name='authority[]' value='ordercancel'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주문취소
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_11\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsales_status\b/i",$row[authority])){
			$html .= "
				<div class='authority_12'>
					<table>
						<input type='hidden' name='authority[]' value='sales_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_12\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\boption_status\b/i",$row[authority])){
			$html .= "
				<div class='authority_13'>
					<table>
						<input type='hidden' name='authority[]' value='option_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 옵션별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_13\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bcategory_status\b/i",$row[authority])){
			$html .= "
				<div class='authority_14'>
					<table>
						<input type='hidden' name='authority[]' value='category_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 카테고리별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_14\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bpartner_status\b/i",$row[authority])){
			$html .= "
				<div class='authority_15'>
					<table>
						<input type='hidden' name='authority[]' value='partner_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업체별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_15\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsite_status\b/i",$row[authority])){
			$html .= "
				<div class='authority_17'>
					<table>
						<input type='hidden' name='authority[]' value='site_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 사이트별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_17\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\btotal_data\b/i",$row[authority])){
			$html .= "
				<div class='authority_18'>
					<table>
						<input type='hidden' name='authority[]' value='total_data'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 통합자료
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_18\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bduty_data\b/i",$row[authority])){
			$html .= "
				<div class='authority_19'>
					<table>
						<input type='hidden' name='authority[]' value='duty_data'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 면세자료
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_19\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bcalculate_condition\b/i",$row[authority])){
			$html .= "
				<div class='authority_20'>
					<table>
						<input type='hidden' name='authority[]' value='calculate_condition'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 정산현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_20\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bpenalty\b/i",$row[authority])){
			$html .= "
				<div class='authority_21'>
					<table>
						<input type='hidden' name='authority[]' value='penalty'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 패널티
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_21\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\btax_invoice\b/i",$row[authority])){
			$html .= "
				<div class='authority_22'>
					<table>
						<input type='hidden' name='authority[]' value='tax_invoice'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 세금계산서
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_22\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\badd_give\b/i",$row[authority])){
			$html .= "
				<div class='authority_23'>
					<table>
						<input type='hidden' name='authority[]' value='add_give'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 추가지급
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_23\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\btotal_calculate\b/i",$row[authority])){
			$html .= "
				<div class='authority_24'>
					<table>
						<input type='hidden' name='authority[]' value='total_calculate'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 통합정산내역
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_24\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsales_list\b/i",$row[authority])){
			$html .= "
				<div class='authority_25'>
					<table>
						<input type='hidden' name='authority[]' value='sales_list'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 매출내역
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_25\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bgive_defer\b/i",$row[authority])){
			$html .= "
				<div class='authority_26'>
					<table>
						<input type='hidden' name='authority[]' value='give_defer'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 지급보류
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_26\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsales_declaration\b/i",$row[authority])){
			$html .= "
				<div class='authority_27'>
					<table>
						<input type='hidden' name='authority[]' value='sales_declaration'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 매출/매입신고
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_27\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bpayment_examination\b/i",$row[authority])){
			$html .= "
				<div class='authority_28'>
					<table>
						<input type='hidden' name='authority[]' value='payment_examination'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 결제수단별검수
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_28\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bcard_examination\b/i",$row[authority])){
			$html .= "
				<div class='authority_29'>
					<table>
						<input type='hidden' name='authority[]' value='card_examination'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 카드결제검수
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_29\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bcash_receipt_error\b/i",$row[authority])){
			$html .= "
				<div class='authority_30'>
					<table>
						<input type='hidden' name='authority[]' value='cash_receipt_error'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 현금영수증에러
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_30\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bweek_calculate\b/i",$row[authority])){
			$html .= "
				<div class='authority_31'>
					<table>
						<input type='hidden' name='authority[]' value='week_calculate'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주정산입금
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_31\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bstock\b/i",$row[authority])){
			$html .= "
				<div class='authority_32'>
					<table>
						<input type='hidden' name='authority[]' value='stock'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 재고관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_32\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bstaff_supervise\b/i",$row[authority])){
			$html .= "
				<div class='authority_33'>
					<table>
						<input type='hidden' name='authority[]' value='staff_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 직원관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_33\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bband_cass\b/i",$row[authority])){
			$html .= "
				<div class='authority_34'>
					<table>
						<input type='hidden' name='authority[]' value='band_cass'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_34\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bmember_supervise\b/i",$row[authority])){
			$html .= "
				<div class='authority_35'>
					<table>
						<input type='hidden' name='authority[]' value='member_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· Mall회원관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_35\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\benterprise_supervise\b/i",$row[authority])){
			$html .= "
				<div class='authority_36'>
					<table>
						<input type='hidden' name='authority[]' value='enterprise_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업체관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_36\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\badvance_registration_standby\b/i",$row[authority])){
			$html .= "
				<div class='authority_37'>
					<table>
						<input type='hidden' name='authority[]' value='advance_registration_standby'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더사전등록승인대기
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_37\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\badvance_registration_supervision\b/i",$row[authority])){
			$html .= "
				<div class='authority_38'>
					<table>
						<input type='hidden' name='authority[]' value='advance_registration_supervision'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더사전등록번호관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_38\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bcertify_supervision\b/i",$row[authority])){
			$html .= "
				<div class='authority_39'>
					<table>
						<input type='hidden' name='authority[]' value='certify_supervision'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더인증관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_39\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsms\b/i",$row[authority])){
			$html .= "
				<div class='authority_40'>
					<table>
						<input type='hidden' name='authority[]' value='sms'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· SMS
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_40\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bsms_send\b/i",$row[authority])){
			$html .= "
				<div class='authority_41'>
					<table>
						<input type='hidden' name='authority[]' value='sms_send'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· SMS발송
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_41\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}
		if(preg_match("/\bwork_report\b/i",$row[authority])){
			$html .= "
				<div class='authority_42'>
					<table>
						<input type='hidden' name='authority[]' value='work_report'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업무일지
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_42\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}

		echo $html;

	break;

	case "authorized_add" :
		

		if($_REQUEST[authorized] == '1'){
			$html = "
				<div class='authority_1'>
					<table>
						<input type='hidden' name='authority[]' value='classify'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품분류관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_1\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '2'){
			$html = "
				<div class='authority_2'>
					<table>
						<input type='hidden' name='authority[]' value='productlist'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품리스트
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_2\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '3'){
			$html = "
				<div class='authority_3'>
					<table>
						<input type='hidden' name='authority[]' value='product_notify'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품공지사항
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_3\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '4'){
			$html = "
				<div class='authority_4'>
					<table>
						<input type='hidden' name='authority[]' value='planning'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 기획전
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_4\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '5'){
			$html = "
				<div class='authority_5'>
					<table>
						<input type='hidden' name='authority[]' value='event'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 이벤트
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_5\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '6'){
			$html = "
				<div class='authority_6'>
					<table>
						<input type='hidden' name='authority[]' value='orderinfo'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주문정보
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_6\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '7'){
			$html = "
				<div class='authority_7'>
					<table>
						<input type='hidden' name='authority[]' value='delivery'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 발주
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_7\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '8'){
			$html = "
				<div class='authority_8'>
					<table>
						<input type='hidden' name='authority[]' value='invoice'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 송장등록
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_8\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '9'){
			$html = "
				<div class='authority_9'>
					<table>
						<input type='hidden' name='authority[]' value='release'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 출고중지
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_9\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '10'){
			$html = "
				<div class='authority_10'>
					<table>
						<input type='hidden' name='authority[]' value='exchange_refund'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 교환/반품
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_10\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '11'){
			$html = "
				<div class='authority_11'>
					<table>
						<input type='hidden' name='authority[]' value='ordercancel'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주문취소
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_11\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '12'){
			$html = "
				<div class='authority_12'>
					<table>
						<input type='hidden' name='authority[]' value='sales_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 상품별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_12\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '13'){
			$html = "
				<div class='authority_13'>
					<table>
						<input type='hidden' name='authority[]' value='option_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 옵션별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_13\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '14'){
			$html = "
				<div class='authority_14'>
					<table>
						<input type='hidden' name='authority[]' value='category_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 카테고리별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_14\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '15'){
			$html = "
				<div class='authority_15'>
					<table>
						<input type='hidden' name='authority[]' value='partner_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업체별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_15\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '17'){
			$html = "
				<div class='authority_17'>
					<table>
						<input type='hidden' name='authority[]' value='site_status'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 사이트별판매현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_17\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '18'){
			$html = "
				<div class='authority_18'>
					<table>
						<input type='hidden' name='authority[]' value='total_data'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 통합자료
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_18\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '19'){
			$html = "
				<div class='authority_19'>
					<table>
						<input type='hidden' name='authority[]' value='duty_data'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 면세자료
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_19\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '20'){
			$html = "
				<div class='authority_20'>
					<table>
						<input type='hidden' name='authority[]' value='calculate_condition'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 정산현황
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_20\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '21'){
			$html = "
				<div class='authority_21'>
					<table>
						<input type='hidden' name='authority[]' value='penalty'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 패널티
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_21\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '22'){
			$html = "
				<div class='authority_22'>
					<table>
						<input type='hidden' name='authority[]' value='tax_invoice'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 세금계산서
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_22\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '23'){
			$html = "
				<div class='authority_23'>
					<table>
						<input type='hidden' name='authority[]' value='add_give'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 추가지급
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_23\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '24'){
			$html = "
				<div class='authority_24'>
					<table>
						<input type='hidden' name='authority[]' value='total_calculate'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 통합정산내역
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_24\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '25'){
			$html = "
				<div class='authority_25'>
					<table>
						<input type='hidden' name='authority[]' value='sales_list'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 매출내역
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_25\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '26'){
			$html = "
				<div class='authority_26'>
					<table>
						<input type='hidden' name='authority[]' value='give_defer'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 지급보류
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_26\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '27'){
			$html = "
				<div class='authority_27'>
					<table>
						<input type='hidden' name='authority[]' value='sales_declaration'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 매출/매입신고
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_27\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '28'){
			$html = "
				<div class='authority_28'>
					<table>
						<input type='hidden' name='authority[]' value='payment_examination'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 결제수단별검수
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_28\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '29'){
			$html = "
				<div class='authority_29'>
					<table>
						<input type='hidden' name='authority[]' value='card_examination'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 카드결제검수
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_29\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '30'){
			$html = "
				<div class='authority_30'>
					<table>
						<input type='hidden' name='authority[]' value='cash_receipt_error'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 현금영수증에러
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_30\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '31'){
			$html = "
				<div class='authority_31'>
					<table>
						<input type='hidden' name='authority[]' value='week_calculate'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 주정산입금
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_31\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '32'){
			$html = "
				<div class='authority_32'>
					<table>
						<input type='hidden' name='authority[]' value='stock'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 재고관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_32\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '33'){
			$html = "
				<div class='authority_33'>
					<table>
						<input type='hidden' name='authority[]' value='staff_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 직원관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_33\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '34'){
			$html = "
				<div class='authority_34'>
					<table>
						<input type='hidden' name='authority[]' value='band_cass'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_34\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '35'){
			$html = "
				<div class='authority_35'>
					<table>
						<input type='hidden' name='authority[]' value='member_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· Mall회원관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_35\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '36'){
			$html = "
				<div class='authority_36'>
					<table>
						<input type='hidden' name='authority[]' value='enterprise_supervise'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업체관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_36\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '37'){
			$html = "
				<div class='authority_37'>
					<table>
						<input type='hidden' name='authority[]' value='advance_registration_standby'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더사전등록승인대기
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_37\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '38'){
			$html = "
				<div class='authority_38'>
					<table>
						<input type='hidden' name='authority[]' value='advance_registration_supervision'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더사전등록번호관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_38\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '39'){
			$html = "
				<div class='authority_39'>
					<table>
						<input type='hidden' name='authority[]' value='certify_supervision'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 리더인증관리
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_39\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '40'){
			$html = "
				<div class='authority_40'>
					<table>
						<input type='hidden' name='authority[]' value='sms'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· SMS
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_40\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '41'){
			$html = "
				<div class='authority_41'>
					<table>
						<input type='hidden' name='authority[]' value='sms_send'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· SMS발송
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_41\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}elseif($_REQUEST[authorized] == '42'){
			$html = "
				<div class='authority_42'>
					<table>
						<input type='hidden' name='authority[]' value='work_report'>
						<tr style='border:0px;'>
							<td style='line-height: 10px;float:left;border:0px;padding: 22px 8px 22px 8px;font-size: 13px;font-weight: bold;'>
								· 업무일지
							</td>
							<td style='line-height: 10px;float:left;border:0px;'>
								<span class='button_pack' style='margin-left:0;'><a href='#none' onclick='authority_del(\"authority_42\");' class='btn_sm_black'>삭제</a></span>
							</td>
						</tr>
					</table>
				</div>
			";
		}

		echo $html;
		
	break;
}


?>
