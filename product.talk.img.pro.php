<?PHP
include "func_ini.php";
session_start();
include "session.php";
include "func.php";

//header("Content-Type: text/html; charset=euc-kr");
//header("Content-Type: text/html; charset=UTF-8");


$m_name =  iconv("utf-8","euc-kr",$m_name);
$_content =  iconv("utf-8","euc-kr",$_content);

	// 모드별 처리
	switch( $_mode ){
		case "add":
			$que = "
				insert odtTt2_pic_review set
					ttProCode	= '". $pcode ."'
					,ttID		= '".$g_check_id."'
					,ttName		= '".$m_name."'
					,ttContent	= '".$_content."'
					,ttSess = '".$talk_sess."'
					,ttIsReply	= 0
					,ttSNo		= 0
					,ttRegidate	= now()
					,ttImage = '".$img_val."'
		
			";
			mysql_query($que);
		if($gubun_cnt != "over"){
            
            //현재 누적 적립금가져오기.
            $sql = " select ifnull(po_mb_point,0) as mileage from jooyon_mileage where member_id = '".$g_check_id."' order by uid desc limit 1";
            $rs  = mysql_query($sql);
            $row = mysql_fetch_array($rs);
            $current_mileage = $row['mileage'];
            $rs_mileage = $current_mileage + 100;

            $sql = " insert jooyon_mileage set 
                                member_id = '".$g_check_id."'
                               ,reg_date = now()
                               ,po_content = '포토후기작성300원지급'
                               ,po_point = 300
                               ,po_expire_date = date_add(now(), interval 90 day)
                               ,sess = '".$talk_sess."'
                               ,po_kind = 'A'
                               ,po_mb_point = ".$rs_mileage."
                               ,po_rel_id = '".$g_check_id."'
                               ,po_rel_action = '".date('Y-m-d')."'
                               ,po_type = 'COMMENT'

                   ";

				$rs = mysql_query($sql);

            if($rs){
               $up_sql = " update morning_member_table set 
                                   member_app_point = ".$rs_mileage." where member_id = '".$g_check_id."'
                                       
                         ";
               mysql_query($up_sql);
            }

		}
		break;
		// - 상품 토크 등록 ---

		// - 상품 토크 리플 등록 ---
		case "reply":

			$que = "
				insert odtTt2 set
					ttProCode	= '". $pcode ."'
					,ttID		= '".$g_check_id."'
					,ttName		= '".$row_member['name']."'
					,ttContent	= '".$_content."'
					,ttIsReply	= '1'
					,ttSNo		= '".$ttNo."'
					,ttRegidate	= now()
			";
			_MQ_noreturn($que);

			// 토크 작성자에게 문자 발송
			$smskbn = "talk_re";	// 문자 발송 유형
			if($row_sms[$smskbn]['smschk'] == "y") {
				unset($arr_send);
				$tt_info = _MQ("select m.name,m.htel1,m.htel2,m.htel3 from odtTt2 as tt left join odtMember as m on (tt.ttID = m.id) where ttNo = '".$ttNo."'");
				$sms_to		= phone_print($tt_info['htel1'],$tt_info['htel2'],$tt_info['htel3']);
				$sms_from	= $row_company['tel'];
				$sms_msg	= $row_sms[$smskbn]['smstext'];
				$sms_title  = $row_sms[$smskbn]['smstitle'];
				$sms_file   = $row_sms[$smskbn]['smsfile'];
				
				// 치환작업.
				// $sms_msg	= str_replace("{{회원명}}",$tt_info['name'],$sms_msg);
				// $sms_msg = str_replace("{{사이트명}}",$row_setup[site_name],$sms_msg);
				$sms_msg = sms_msg_replace($sms_msg); // LDD008
				
				# LDD006 2015-09-15 {
				//$arr_send[] = array('receive_num'=> $sms_to , 'send_num'=> $sms_from , 'msg'=> $sms_msg  , 'reserve_time'=>'' , 'title'=> $sms_title , 'image'=> $sms_file );
				if(!$sms_file) {

					$sms_msg = lms_string_build($sms_msg, $row_sms[$smskbn]['sms_send_type']);
					if(is_array($sms_msg)) {
						foreach($sms_msg as $kkk=>$vvv) {
							$arr_send[] = array('receive_num'=> $sms_to , 'send_num'=> $sms_from , 'msg'=> $vvv  , 'reserve_time'=>'' , 'title'=> $sms_title , 'image'=> $sms_file );
						}
					}
					else {
						$arr_send[] = array('receive_num'=> $sms_to , 'send_num'=> $sms_from , 'msg'=> $sms_msg  , 'reserve_time'=>'' , 'title'=> $sms_title , 'image'=> $sms_file );
					}
				}
				else {
					$arr_send[] = array('receive_num'=> $sms_to , 'send_num'=> $sms_from , 'msg'=> $sms_msg  , 'reserve_time'=>'' , 'title'=> $sms_title , 'image'=> $sms_file );
				}
				# } LDD006 2015-09-15
				//onedaynet_sms_multisend($arr_send);			
			}
			break;
		// - 상품 댓글 등록 ---


		// - 상품 댓글 삭제 ---
		case "delete":
			//$uid = nullchk($uid , "잘못된 접근입니다." , "" , "ALT");

         if(!$uid){
            echo "<SCRIPT>alert('잘못된 접근입니다.');</SCRIPT>";
            exit;
         }

			// 등록 상품 댓글 확인
			$r = mysql_fetch_array(mysql_query(" select count(*) as cnt from odtTt2 where ttNo = '".$uid."' and ttID = '".$g_check_id."' "));
			if( $r['cnt'] == 0 ) {
				echo "no data";//error_alt("등록하신 글이 아닙니다.");
            //echo "<SCRIPT>alert('등록하신 글이 아닙니다.');</SCRIPT>";
				exit;
			}

			// 댓글있는 상품 댓글인지 확인
			$r = mysql_fetch_array(mysql_query(" select count(*) as cnt from odtTt2 where ttSNo = '".$uid."'    "));
			if( $r['cnt'] > 0 ) {
				echo "is reply";//error_alt("댓글이 있으므로 삭제가 불가합니다.");
            //echo "<SCRIPT>alert('댓글이 있으므로 삭제가 불가합니다.');</SCRIPT>";
				exit;
			}

			$que = " delete from odtTt2 where ttNo = '".$uid."' and ttID='".$g_check_id."'   ";
			mysql_query($que);
			break;
		// - 상품 댓글 삭제 ---


		// - 댓글 갯수 추출 ---
		case "getcnt":
			echo "(".get_talk_total($pcode,"normal").")";
			break;		
         
         
         case "view" :

  			$input = array("no_icon2.png", "no_icon3.png", "no_icon4.png");
			$input2 = $input3 = $input4 = $input5 = $input;
			$rand_keys = array_rand($input, 3);
			$rand_keys2 = array_rand($input2, 3);
			$rand_keys3 = array_rand($input3, 3);
			$rand_keys4 = array_rand($input4, 3);
			$rand_keys5 = array_rand($input5, 3);
			echo "
				<style>
					.cm_shop_inner .form_area .message {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message .profile2 {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: left;top: 0px;left: 0px;background-image: url(/common/mobile/images/".$input[$rand_keys[0]].")}
					.cm_shop_inner .form_area .message .msgball {position: absolute;top: 12px;left: 45px;width: 0;height: 0;border-top: 13px solid #eee;border-left: 13px solid transparent;}
					.cm_shop_inner .form_area .message .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#eee;position: relative;float: left;top: 0px;left: 12px;}
					.cm_shop_inner .form_area .message .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}

					.cm_shop_inner .form_area .message_reply {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message_reply .profile2 {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: right;top: 0px;right: 0px;background-image: url(/common/mobile/images/jooyon_icon.png)}
					.cm_shop_inner .form_area .message_reply .msgball {position: absolute;top: 12px;right: 56px;width: 0;height: 0;border-top: 13px solid #cedae6;border-right: 13px solid transparent;}
					.cm_shop_inner .form_area .message_reply .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#cedae6;position: relative;float: left;top: 0px;left: 0px;}
					.cm_shop_inner .form_area .message_reply .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message_reply .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}

					.cm_shop_inner .form_area .message_greview {width: 100%;height: 75px;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message_greview .profile2 {width: 55px;height: 55px;border-radius: 30px;background-color:#efefef;background-size: cover;margin-right: 15px;margin-top: 15px;float: left;background-image: url(/common/mobile/images/profle-128.png)}
					.cm_shop_inner .form_area .message_greview .msgball {position: absolute;top: 12px;right: 56px;width: 0;height: 0;border-top: 13px solid #cedae6;border-right: 13px solid transparent;}
					.cm_shop_inner .form_area .message_greview .sub_title_review {width: 100%;height: 40px;padding-right: 12px;margin-bottom: 12px;position: absolute;top: -10px;}
				</style>
			";
			$s_query = "from odtTt2_pic_review where ttIsReply=0 and ttProCode = '".$pcode."' and ttIsDel = 'N' ";

			// 페이징을 위한 작업
			$listmaxcount = 5;																		// $view_cnt
			$listpg = $listpg ? $listpg : 1;														// $page_num
			$count = ($listpg-1) * $listmaxcount;													// $limit_start_num
			$res = mysql_fetch_array(mysql_query("select count(*) as cnt ".$s_query));
			$TotalCount = $res['cnt'];
			$Page = $TotalCount ? ceil($TotalCount / $listmaxcount) : 1;
			$page_num = $TotalCount-$count;

			$que = "select * ".$s_query." order by  ttNo desc limit  $count , $listmaxcount";

         //debug($que);
			$res = mysql_query($que);
			while($value = mysql_fetch_array($res)){
				unset($talk_btn,$reply_content);

				$talk_name = mb_substr($value['ttName'], '0', -2)."**";
				$talk_id = mb_substr($value[ttID], '0', -4)."****";
				$talk_rdate = date('Y-m-d H:i:s',strtotime($value['ttRegidate']));
				$talk_content = nl2br(htmlspecialchars($value['ttContent']));
				$gReview = $value[gReview];
				$talk_btn = $value['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$value['ttNo']."');return false;\" title='' class='btn_sm_black' style='z-index:9999; float:left; width:80px;'>삭제</a>" : NULL;
				$talk_reply = $g_check_id ? "<a href='#none' title='' onclick=\"view_reply_form('".$value['ttNo']."');return false;\" class='btn_sm_black'>댓글</a>" : NULL;
				$talk_show = "<a href='#none' title='' onclick=\"talk_show('".$value['ttNo']."');return false;\" class='btn_sm_white'>내용보기</a>";
				$talk_close = "<a href='#none' title='' onclick=\"talk_show('".$value['ttNo']."');return false;\" class='btn_sm_black'>닫기</a>";

				$reply_r = mysql_query("select * from odtTt2_pic_review where ttIsReply='1' and ttSNo = '".$value['ttNo']."' and ttIsDel = 'N' order by ttNo asc ");
				$reply_num = mysql_num_rows($reply_r);
				unset($reply_content);
				while($v2 = mysql_fetch_array($reply_r)){
					$talk_name2 = $v2['ttName'] ? $v2['ttName'] : $v2['ttID'];
					$talk_rdate2 = date('Y-m-d H:i:s',strtotime($v2['ttRegidate']));
					$talk_content2 = nl2br(($v2['ttContent']));
					$talk_btn2 = $v2['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v2['ttNo']."');return false;\" title='댓글삭제' class='btn_delete'><span class='shape'></span></a>" : NULL;

					$sql = "select * from odtTt2_pic_review where ttNo = '".$v2[ttSNo]."' and ttIsDel = 'N'";
					$row_parent = mysql_fetch_array(mysql_query($sql));
					

					$reply_content .= "			
						<div class='message_reply'>
							<div class='profile2'></div>
							<div class='msgball'></div>
							<div class='subject'>
								<div class='name'>주연홈쇼핑 <span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".$talk_rdate2."</span></div>
								<div class='comment'>To.".$talk_id."님! </br>".strip_tags($talk_content2)."</div>
							</div>
							<div style='clear:both'></div>
						</div>
					";
				}
				echo "
					<div class='message'>
						<div class='subject' style='width: 97%;padding: 5px;left: 0px;'>
							<div style='width:100%;'>
								<img src='".$value[ttImage]."' style='width:100%;border-radius: 5px;'>
							</div>
							<div class='name' style='padding-top:10px;'>
								".$talk_id." 
								<span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".substr($talk_rdate, 0, 10)."</span>
								".$gReview_img."
							</div>
							<div class='comment' style='padding-top:5px;'>".strip_tags($talk_content)."</div>
						</div>
						<div style='clear:both'></div>
					</div>
					".$reply_content."
				";
			}
        
         //echo $Page."<BR>";
         //echo $listpg."<BR>";
			$for_start_num = $Page <= 5 || $listpg <= 5 ? 1 : (($Page - $listpg) < 5 ? $Page-4 : $listpg-4);
			$for_end_num = $Page < ($for_start_num + 4) ? $Page : ($for_start_num + 4) ;
			$first	= "1";
			$prev		= $listpg > 1 ? $listpg-1 : 1;
			$next		= $listpg < $Page ? $listpg+1 : $Page;
			$last		= $Page;

         //echo $for_end_num;
?>
			<div class='cm_paginate'>
				<span class="inner">

					<? if($listpg == $prev){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view2(<?=$prev?>);return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } ?>

					<?
						for($ii=$for_start_num;$ii<=$for_end_num;$ii++) {
							if($ii != $listpg) { echo "<a href='#none' class='number' onclick=\"talk_view2(".$ii.");return false;\">$ii</a>"; }
							else { echo "<a href='#none' onclick='return false;' class='number hit'>$ii</a>"; }
						}
					?>

					<? if($listpg == $next){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view2(<?=$next?>);return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } ?>

				</span>
			</div>
      <?
	
			// - 상품 댓글 목록 ---

	}	
?>
<script>
function detail_review(ttNo){
	$("#refund_bank_view_pop").lightbox_me({
			centered: true, closeEsc: false,
			onLoad: function() { },
			onClose: function(){ }
		});
	$('input[name=ttNo]').attr('value', ttNo);
	
}
</script>