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

		// - 상품 토크 등록 ---
		case "add":

			$que = "
				insert odtTt set
					ttProCode	= '". $pcode ."'
					,ttID		= '".$g_check_id."'
					,ttName		= '".$m_name."'
					,ttContent	= '".$_content."'
					,ttIsReply	= 0
					,ttSNo		= 0
					,ttRegidate	= now()
					,eventYN = '".$eventYN."'
			";
			//_MQ_noreturn($que);
         mysql_query($que);

        $_content = "[상품문의글]\n".$_content."\n m.jooyonshop.com/index.php?spage=goods_qna";
        //$_content = "[상품문의글]\n".$_content;
        $_content_len = strlen($_content);
		
		if($eventYN != "Y"){
			 SmsConn_LG();
			 if ($_content_len > 80){
				MMSSend_LG("01082346334", "15444904", '', $_content);
			 } else {
				SmsSend_LG("01082346334",  "15444904", $_content);
			 }
		}


			break;
		// - 상품 댓글 등록 ---

		// - 상품 토크 리플 등록 ---
		case "reply":

			$que = "
				insert odtTt set
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
				$tt_info = _MQ("select m.name,m.htel1,m.htel2,m.htel3 from odtTt as tt left join odtMember as m on (tt.ttID = m.id) where ttNo = '".$ttNo."'");
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
			$r = mysql_fetch_array(mysql_query(" select count(*) as cnt from odtTt where ttNo = '".$uid."' and ttID = '".$g_check_id."' "));
			if( $r['cnt'] == 0 ) {
				echo "no data";//error_alt("등록하신 글이 아닙니다.");
            //echo "<SCRIPT>alert('등록하신 글이 아닙니다.');</SCRIPT>";
				exit;
			}

			// 댓글있는 상품 댓글인지 확인
			$r = mysql_fetch_array(mysql_query(" select count(*) as cnt from odtTt where ttSNo = '".$uid."'    "));
			if( $r['cnt'] > 0 ) {
				echo "is reply";//error_alt("댓글이 있으므로 삭제가 불가합니다.");
            //echo "<SCRIPT>alert('댓글이 있으므로 삭제가 불가합니다.');</SCRIPT>";
				exit;
			}

			$que = " delete from odtTt where ttNo = '".$uid."' and ttID='".$g_check_id."'   ";
			mysql_query($que);
			break;
		// - 상품 댓글 삭제 ---


		// - 댓글 갯수 추출 ---
		case "getcnt":
			echo "(".get_talk_total($pcode,"normal").")";
			break;

		// - 상품 댓글 보기 ---
		case "view":

			echo "<div class='list_area'><ul>";

			$s_query = " from odtTt
                        where ttIsReply=0 and ttProCode = '".$pcode."'";

         
         //debug($s_query);


			// 페이징을 위한 작업
			$listmaxcount = 10;																		// $view_cnt
			$listpg = $listpg ? $listpg : 1;														// $page_num
			$count = ($listpg-1) * $listmaxcount;													// $limit_start_num
			$res = mysql_fetch_array(mysql_query("select count(*) as cnt ".$s_query));
			$TotalCount = $res['cnt'];
			$Page = $TotalCount ? ceil($TotalCount / $listmaxcount) : 1;
			$page_num = $TotalCount-$count;

         //debug("select count(*) as cnt ".$s_query);

			// - 상품 댓글 목록 ---
			$que = " 
				select 
					*
				".$s_query."
				order by  ttNo desc limit  $count , $listmaxcount
			";

         //debug($que);
			$res = mysql_query($que);

			if(sizeof($res) < 1 ) { echo "<div class='cm_no_conts'><div class='no_icon'></div><div class='gtxt'>등록된 내용이 없습니다.</div></div>"; }
			while($v = mysql_fetch_array($res)){
				unset($talk_btn,$reply_content);


				$talk_name = $v['ttName'];
				$talk_rdate = date('Y-m-d',strtotime($v['ttRegidate']));
				$talk_content = nl2br(htmlspecialchars($v['ttContent']));
				$talk_btn = $v['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v['ttNo']."');return false;\" title='' class='btn_sm_black' style='z-index:9999; float:left; width:80px;'>삭제</a>" : NULL;
				$talk_reply = $g_check_id ? "<a href='#none' title='' onclick=\"view_reply_form('".$v['ttNo']."');return false;\" class='btn_sm_black'>댓글</a>" : NULL;
				$talk_show = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_white'>내용보기</a>";
				$talk_close = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_black'>닫기</a>";

				// 리플 추출
				unset($reply_content);
				$reply_r = mysql_query("select * from odtTt where ttIsReply='1' and ttSNo = '".$v['ttNo']."'");
            $reply_num = mysql_num_rows($reply_r);


            //debug("select * from odtTt where ttIsReply='1' and ttSNo = '".$v['ttNo']."'");
				while($v2 = mysql_fetch_array($reply_r)){
					$talk_name2 = $v2['ttName'] ? $v2['ttName'] : $v2['ttID'];
					$talk_rdate2 = date('Y-m-d',strtotime($v2['ttRegidate']));
					$talk_content2 = nl2br(($v2['ttContent']));
					$talk_btn2 = $v2['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v2['ttNo']."');return false;\" title='댓글삭제' class='btn_delete'><span class='shape'></span></a>" : NULL;

					$reply_content .= "			
						<div class='reply' style='background:#eee; margin-top:0px; '>
							<span class='shape_ic'></span>
							<div class='conts_txt'>
								<span class='admin'>
									<span class='name'>"."관리자"."</span>
									<span class='bar'></span><span class='date'>".$talk_rdate2."</span>
									".$talk_btn2."
								</span>
								".$talk_content2."
							</div>									
						</div>
					";
				}

				// 리플 폼.
				unset($reply_form);
				if($g_check_id) {
					$reply_form = "	
						<div class='form_area reply_form' id='reply_form_".$v['ttNo']."'>
							<div class='inner'>
								<div class='form_conts'>
									<div class='textarea_box'>
										<textarea id='_content_".$v['ttNo']."' cols='' rows='' class='textarea_design' placeholder='이 글에 관한 댓글을 남겨주세요.'></textarea>
									</div>
									<input type='button' onclick='talk_reply_add(".$v['ttNo'].")' class='btn_ok' name='' class='' value='등록'>
								</div>
							</div>
						</div>
					";
				}
				echo "	
					<li id='".$v['ttNo']."'>
						<div class='post_box'>
							<a href='#none' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='upper_link'></a>
							".($reply_num>0?"<span class='texticon_pack'><span class='red'>답변완료</span></span>":"<span class='texticon_pack'><span class='light'>답변대기</span></span>")."
							<span class='' style='margin-left:23%; height:auto; min-height:30px; margin-bottom:5px;'>".strip_tags($talk_content)."</span>
							<span class='title_icon'>".(strtotime($v['ttRegidate'])-time()<3600*2?"N":"")."</span>
							<span class='writer'>
								<span class='name'>".$talk_name."</span>
								<span class='bar'></span>
								<span class='date'>".$talk_rdate."</span>
							</span>

                     <span class='button_pack' style='margin-top:0px; float:left; height:15px;'>".$talk_btn."</span>


						</div>
						<div class='open_box' style='display:block;'>
							".$reply_content."
						</div>
					</li>

				";
			}

	$for_start_num = $Page <= 10 || $listpg <= 5 ? 1 : (($Page - $listpg) < 5 ? $Page-9 : $listpg-5);
	$for_end_num = $Page < ($for_start_num + 9) ? $Page : ($for_start_num + 9) ;
	$first	= "1";
	$prev		= $listpg > 1 ? $listpg-1 : 1;
	$next		= $listpg < $Page ? $listpg+1 : $Page;
	$last		= $Page;

?>
</ul></div>

<div class='cm_paginate'>
	<span class="inner">

		<? if($listpg == $prev){ ?>
		<a href="#none" onclick="return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
		<? } else { ?>
		<a href="#none" onclick="talk_view(<?=$prev?>);return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
		<? } ?>

		<?
			for($ii=$for_start_num;$ii<=$for_end_num;$ii++) {
				if($ii != $listpg) { echo "<a href='#none' class='number' onclick=\"talk_view(".$ii.");return false;\">$ii</a>"; }
				else { echo "<a href='#none' onclick='return false;' class='number hit'>$ii</a>"; }
			}
		?>

		<? if($listpg == $next){ ?>
		<a href="#none" onclick="return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
		<? } else { ?>
		<a href="#none" onclick="talk_view(<?=$next?>);return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
		<? } ?>

	</span>
</div>
<?
			// - 상품 댓글 목록 ---
		break;
		
		case "view2" :
			$input = array("spring_icon1.png", "spring_icon2.png", "spring_icon3.png", "spring_icon4.png", "spring_icon5.png");
			$input2 = $input3 = $input4 = $input5 = $input;
			$rand_keys = array_rand($input, 3);
			$rand_keys2 = array_rand($input2, 3);
			$rand_keys3 = array_rand($input3, 3);
			$rand_keys4 = array_rand($input4, 3);
			$rand_keys5 = array_rand($input5, 3);
			echo "
				<style>
					.cm_shop_inner .form_area .message {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message .profile {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: left;top: 0px;left: 0px;background-image: url(/common/mobile/images/".$input[$rand_keys[0]].")}
					.cm_shop_inner .form_area .message .msgball {position: absolute;top: 12px;left: 45px;width: 0;height: 0;border-top: 13px solid #eee;border-left: 13px solid transparent;}
					.cm_shop_inner .form_area .message .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#eee;position: relative;float: left;top: 0px;left: 12px;}
					.cm_shop_inner .form_area .message .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}

					.cm_shop_inner .form_area .message_reply {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message_reply .profile {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: right;top: 0px;right: 0px;background-image: url(/common/mobile/images/jooyon_icon.png)}
					.cm_shop_inner .form_area .message_reply .msgball {position: absolute;top: 12px;right: 56px;width: 0;height: 0;border-top: 13px solid #cedae6;border-right: 13px solid transparent;}
					.cm_shop_inner .form_area .message_reply .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#cedae6;position: relative;float: left;top: 0px;left: 0px;}
					.cm_shop_inner .form_area .message_reply .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message_reply .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}
				</style>
			";
			$s_query = "from odtTt where ttIsReply=0 and ttProCode = '".$pcode."' and ttIsDel = 'N'";

			// 페이징을 위한 작업
			$listmaxcount = 10;																		// $view_cnt
			$listpg = $listpg ? $listpg : 1;														// $page_num
			$count = ($listpg-1) * $listmaxcount;													// $limit_start_num
			$res = mysql_fetch_array(mysql_query("select count(*) as cnt ".$s_query));
			$TotalCount = $res['cnt'];
			$Page = $TotalCount ? ceil($TotalCount / $listmaxcount) : 1;
			$page_num = $TotalCount-$count;

			$que = "select * ".$s_query." order by  ttNo desc limit  $count , $listmaxcount";
			
			debug($que);
			$res = mysql_query($que);

			if(sizeof($res) < 1 ) { echo "<div class='cm_no_conts'><div class='no_icon'></div><div class='gtxt'>등록된 내용이 없습니다.</div></div>"; }
			
			while($v = mysql_fetch_array($res)){
				unset($talk_btn,$reply_content);

				$talk_name = $v['ttName'];
				$talk_id = substr($v[ttID], '0', '-3')."****";
				$talk_rdate = date('Y-m-d H:i:s',strtotime($v['ttRegidate']));
				$talk_content = nl2br(htmlspecialchars($v['ttContent']));
				if($v['ttCS'] == "Y"){
				$talk_content = "해당 댓글은 고객센터 CS담당부서로 이관되어 처리되었습니다.";
				}
				if($v['ttID'] == $_SESSION[morning_sess_id]){
				$talk_content = nl2br(htmlspecialchars($v['ttContent']));
				}
				$talk_btn = $v['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v['ttNo']."');return false;\" title='' class='btn_sm_black' style='z-index:9999; float:left; width:80px;'>삭제</a>" : NULL;
				$talk_reply = $g_check_id ? "<a href='#none' title='' onclick=\"view_reply_form('".$v['ttNo']."');return false;\" class='btn_sm_black'>댓글</a>" : NULL;
				$talk_show = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_white'>내용보기</a>";
				$talk_close = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_black'>닫기</a>";
				
				unset($reply_content);
				$reply_r = mysql_query("select * from odtTt where ttIsReply='1' and ttSNo = '".$v['ttNo']."' order by ttNo asc ");
				$reply_num = mysql_num_rows($reply_r);


				while($v2 = mysql_fetch_array($reply_r)){
					$talk_name2 = $v2['ttName'] ? $v2['ttName'] : $v2['ttID'];
					$talk_rdate2 = date('Y-m-d H:i:s',strtotime($v2['ttRegidate']));
					$talk_content2 = nl2br(($v2['ttContent']));
					if($v['ttCS'] == "Y"){
					$talk_content2 = "해당 댓글은 고객센터 CS담당부서로 이관되어 처리되었습니다.";	
					}
					if($v['ttID'] == $_SESSION[morning_sess_id]){
					$talk_content2 = nl2br(htmlspecialchars($v2['ttContent']));
					}
					$talk_btn2 = $v2['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v2['ttNo']."');return false;\" title='댓글삭제' class='btn_delete'><span class='shape'></span></a>" : NULL;

					$reply_content .= "			
						<div class='message_reply'>
							<div class='profile'></div>
							<div class='msgball'></div>
							<div class='subject'>
								<div class='name'>주연홈쇼핑 <span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".$talk_rdate2."</span></div>
								<div class='comment'>".strip_tags($talk_content2)."</div>
							</div>
							<div style='clear:both'></div>
						</div>
					";
				}
				
				echo "
					<div class='message'>
						<div class='profile'></div>
						<div class='msgball'></div>
						<div class='subject'>
							<div class='name'>".$talk_id." <span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".$talk_rdate."</span>
							<img src='/common/mobile/images/del_comment.png' style='float:right; font-weight:bold;     width: 5%;' onclick='del_comment(".$v[ttNo].")'></img>
							</div>
							<div class='comment'>".strip_tags($talk_content)."</div>
						</div>
						<div style='clear:both'></div>
					</div>
					".$reply_content."
				";
			}

			$for_start_num = $Page <= 10 || $listpg <= 10 ? 1 : (($Page - $listpg) < 10 ? $Page-10 : $listpg-9);
			$for_end_num = $Page < ($for_start_num + 9) ? $Page : ($for_start_num + 9) ;
			$first	= "1";
			$prev		= $listpg > 1 ? $listpg-1 : 1;
			$next		= $listpg < $Page ? $listpg+1 : $Page;
			$last		= $Page;
?>
			<div class='cm_paginate'>
				<span class="inner">

					<? if($listpg == $prev){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view(<?=$prev?>);return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } ?>

					<?
						for($ii=$for_start_num;$ii<=$for_end_num;$ii++) {
							if($ii != $listpg) { echo "<a href='#none' class='number' onclick=\"talk_view(".$ii.");return false;\">$ii</a>"; }
							else { echo "<a href='#none' onclick='return false;' class='number hit'>$ii</a>"; }
						}
					?>

					<? if($listpg == $next){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view(<?=$next?>);return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } ?>

				</span>
			</div>
<?

		break;
		

		case "del_comment" :
			$sql = "select * from odtTt where ttNo = '".$uid."'";
			$row_delcomment = mysql_num_rows(mysql_query($sql));
			if($row_delcomment > 0){
				$sql = "
				update odtTt set ttIsDel = 'Y' where ttNo = '".$uid."'
				";
				$rs_del = mysql_query($sql);

				$sql = "select * from odtTt where ttSNo = '".$uid."'";
				$row_delcomments = mysql_num_rows(mysql_query($sql));

				if($row_delcomments > 0){
					$sql = "update odtTt set ttIsDel = 'Y' where ttSNo = '".$uid."'";
					$rs_del2 = mysql_query($sql);
				}
			}
		if($rs_del || $rs_del2){
			echo "ok";
		}else{
			echo "nok";
		}
		break;


		case "review_view" :

			if($ttID){
				   $list = morning_fetch_array(morning_query_error("select * from $morning_member_table where member_id = '$_COOKIE[AuthID]' and member_pass = '$_COOKIE[AuthPW]'"));
				   $m_homepage  = str_replace("www.", "",strtolower($list["member_homepage"]));
				   $sv_class   = "";
				   if ($list[member_class] < 7){
					  //1년된 포인트 제거...
					  $now_s = mktime(23,59,59,date("m"), date("d"), date("Y"))-(86400*365);
					  $SQL = " SELECT sum(point_add) FROM morning_point_table
							   WHERE point_id = '$list[member_id]'
								 AND register_date < '$now_s'
								 AND approval_date > 0
								 AND point_minus  = 0     ";
					  $p_result = morning_query_error($SQL);

					  if ($p_row = morning_fetch_array($p_result)){         
						 if ($p_row[0] < 0)
							$p_row[0]    = $p_row[0] * -1;

						 if ($p_row[0] > $list[member_point])
							$p_row[0]    = $list[member_point];

						 if($p_row[0] > 0){
							$query = "insert $morning_point_table set
										 point_id       = '$list[member_id]',
										 point_add      = '-$p_row[0]',
										 point_minus    = '1',
										 point_reason   = '1년이상 적립금 소멸',
										 point_category = '1',
										 modify_id      = '$list[member_id]',
										 modify_ip      = '$g_user_ip',
										 register_date  = '$g_now_time',
										 approval_date  = '$g_now_time'";
							morning_query_error($query);

							//회원T Update
							$SQL = "";
							$SQL = " UPDATE $morning_member_table SET
										member_point = member_point - $p_row[0]
									 WHERE member_id = '$list[member_id]' ";
							morning_query_error($SQL);

							$SQL = " UPDATE morning_point_table
									 SET point_minus = '1'
									 WHERE point_id = '$list[member_id]'
										AND register_date < '$now_s'
										AND approval_date > 0
										AND point_minus  = 0 ";
							morning_query_error($SQL);
						 }
					  }

					  //실버/골드사용사이트라면.. 회원 등급 되는지 검색..
					  if ($cf_member_svclass == 1){
						 $sv_class = setSVClass($list[member_id]);
					  }
				  
					  //장바구니 아이디가 있으면 장바구니에 아이디 update
					  if ($g_check_cart != ""){
						 morning_query_error("update $morning_cart_table set cart_id = '$list[member_id]' where cart_sess = '$g_check_cart'");
					  }
					  morning_query_error("update $morning_member_table set member_login = member_login + 1 where member_id = '$login_id' and member_pass = '$login_pass1'");

					  // 로그인 기록 저장 하기
					  morning_query_error("insert $morning_login_table set login_id = '$list[member_id]',login_ip = '$g_user_ip',login_referer = '$g_check_referer',register_date  = '$g_now_time'");

					  $_SESSION['morning_sess_id']         = $list[member_id];
					  $_SESSION['morning_sess_rank']       = $list[member_class];
					  $_SESSION['morning_sess_svclass']    = $sv_class;
					  $_SESSION['morning_sess_pass']       = $list[member_pass];
					  $_SESSION['morning_sess_name']       = $list[member_name];
					  $_SESSION['morning_sess_tel1']       = $list[member_tel1];
					  $_SESSION['morning_sess_tel2']       = $list[member_tel2];
					  $_SESSION['morning_sess_zip']        = $list[member_zip];
					  $_SESSION['morning_sess_address']    = $list[member_address];
					  $_SESSION['morning_sess_address2']   = $list[member_address2];
					  $_SESSION['morning_sess_email']      = $list[member_email];
					  $_SESSION['morning_sess_point']      = $list[member_point];
					  $_SESSION['morning_sess_image']      = $list[member_image];
					  $_SESSION['morning_sess_home']       = $list[member_homepage];
					  $_SESSION['morning_sess_ordermail']  = $list[member_ordermail];
					  $_SESSION['morning_sess_orderstore'] = $list[member_store];    // 회원테이블에 저장된 밴드코드 

				   }
			}

			echo "
				<style>
					.cm_shop_inner .form_area .message {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message .profile {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: left;top: 0px;left: 0px;background-image: url(/common/mobile/images/no_icon.png)}
					.cm_shop_inner .form_area .message .msgball {position: absolute;top: 12px;left: 45px;width: 0;height: 0;border-top: 13px solid #eee;border-left: 13px solid transparent;}
					.cm_shop_inner .form_area .message .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#eee;position: relative;float: left;top: 0px;left: 12px;}
					.cm_shop_inner .form_area .message .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}

					.cm_shop_inner .form_area .message_reply {width: 100%;height: auto;padding-right: 12px;position: relative;margin-bottom: 12px;}
					.cm_shop_inner .form_area .message_reply .profile {width: 45px;height: 45px;border-radius: 22.5px;background-color:#efefef;background-size: cover;background-position: center;position: relative;float: right;top: 0px;right: 0px;background-image: url(/common/mobile/images/jooyon_icon.png)}
					.cm_shop_inner .form_area .message_reply .msgball {position: absolute;top: 12px;right: 56px;width: 0;height: 0;border-top: 13px solid #cedae6;border-right: 13px solid transparent;}
					.cm_shop_inner .form_area .message_reply .subject {width: calc(100% - 29px - 48px);height: auto;max-width: 400px;min-height: 45px;padding: 8px 10px;border-radius: 8px;background-color:#cedae6;position: relative;float: left;top: 0px;left: 0px;}
					.cm_shop_inner .form_area .message_reply .subject .name {width: 100%;height: 24px;font-size: 15px;font-weight: bold;color: #000D19;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;overflow: hidden;}
					.cm_shop_inner .form_area .message_reply .subject .comment {margin-top: 1px;font-size: 14px;font-weight: normal;color: #333;}
				</style>
			";
			if($_REQUEST[gubun]=="review"){
				$s_query = "from odtTt2 where ttIsReply=0 and ttID = '".$ttID."' and ttProCode = '".$pcode."'";
			}else{
				$s_query = "from odtTt where ttIsReply=0 and ttID = '".$ttID."' and ttProCode = '".$pcode."'";
			}
			// 페이징을 위한 작업
			$listmaxcount = 10;																		// $view_cnt
			$listpg = $listpg ? $listpg : 1;														// $page_num
			$count = ($listpg-1) * $listmaxcount;													// $limit_start_num
			$res = mysql_fetch_array(mysql_query("select count(*) as cnt ".$s_query));
			$TotalCount = $res['cnt'];
			$Page = $TotalCount ? ceil($TotalCount / $listmaxcount) : 1;
			$page_num = $TotalCount-$count;

			$que = "select * ".$s_query." order by  ttNo desc limit  $count , $listmaxcount";
			
			$res = mysql_query($que);
			$res_cnt = mysql_num_rows($res);
			if($res_cnt == "0"){
			$no_review = "<div class='cm_no_conts' style='border: 0.5px dashed;'><div class='no_icon'></div><div class='gtxt'>등록된 리뷰가 없습니다.</div></div>";
			
			echo $no_review;
			}
			if(sizeof($res) < 1 ) { echo "<div class='cm_no_conts'><div class='no_icon'></div><div class='gtxt'>등록된 내용이 없습니다.</div></div>"; }
			while($v = mysql_fetch_array($res)){
				//debug($v[0]);
				unset($talk_btn,$reply_content);
				
				$talk_name = $v['ttName'];
				$talk_rdate = date('Y-m-d H:i:s',strtotime($v['ttRegidate']));
				$talk_content = nl2br(htmlspecialchars($v['ttContent']));
				$talk_btn = $v['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v['ttNo']."');return false;\" title='' class='btn_sm_black' style='z-index:9999; float:left; width:80px;'>삭제</a>" : NULL;
				$talk_reply = $g_check_id ? "<a href='#none' title='' onclick=\"view_reply_form('".$v['ttNo']."');return false;\" class='btn_sm_black'>댓글</a>" : NULL;
				$talk_show = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_white'>내용보기</a>";
				$talk_close = "<a href='#none' title='' onclick=\"talk_show('".$v['ttNo']."');return false;\" class='btn_sm_black'>닫기</a>";

				unset($reply_content);
				if($_REQUEST[gubun] == "review"){
				$reply_r = mysql_query("select * from odtTt2 where ttIsReply='1' and ttSNo = '".$v['ttNo']."' order by ttNo asc ");
				}else{
				$reply_r = mysql_query("select * from odtTt where ttIsReply='1' and ttSNo = '".$v['ttNo']."' order by ttNo asc ");
				}
				$reply_num = mysql_num_rows($reply_r);


				while($v2 = mysql_fetch_array($reply_r)){
					$talk_name2 = $v2['ttName'] ? $v2['ttName'] : $v2['ttID'];
					$talk_rdate2 = date('Y-m-d H:i:s',strtotime($v2['ttRegidate']));
					$talk_content2 = nl2br(($v2['ttContent']));
					$talk_btn2 = $v2['ttID'] == $g_check_id ? "<a href='#none' onclick=\"talk_del('".$v2['ttNo']."');return false;\" title='댓글삭제' class='btn_delete'><span class='shape'></span></a>" : NULL;

					$reply_content .= "			
						<div class='message_reply'>
							<div class='profile'></div>
							<div class='msgball'></div>
							<div class='subject'>
								<div class='name'>주연홈쇼핑 <span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".$talk_rdate2."</span></div>
								<div class='comment'>".strip_tags($talk_content2)."</div>
							</div>
							<div style='clear:both'></div>
						</div>
					";
				}
				
				echo "
					<div class='message'>
						<div class='profile'></div>
						<div class='msgball'></div>
						<div class='subject'>
							<div class='name'>".$talk_name." <span style='font-size:12px;padding-left:5px;vertical-align: bottom;'>".$talk_rdate."</span></div>
							<div class='comment'>".strip_tags($talk_content)."</div>
						</div>
						<div style='clear:both'></div>
					</div>
					".$reply_content."
				";
			}

			$for_start_num = $Page <= 10 || $listpg <= 10 ? 1 : (($Page - $listpg) < 10 ? $Page-10 : $listpg-9);
			$for_end_num = $Page < ($for_start_num + 9) ? $Page : ($for_start_num + 9) ;
			$first	= "1";
			$prev		= $listpg > 1 ? $listpg-1 : 1;
			$next		= $listpg < $Page ? $listpg+1 : $Page;
			$last		= $Page;
?>
			<div class='cm_paginate'>
				<span class="inner">

					<? if($listpg == $prev){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view(<?=$prev?>);return false;" class="prevnext" title="이전"><span class="arrow"></span></a>
					<? } ?>

					<?
						for($ii=$for_start_num;$ii<=$for_end_num;$ii++) {
							if($ii != $listpg) { echo "<a href='#none' class='number' onclick=\"talk_view(".$ii.");return false;\">$ii</a>"; }
							else { echo "<a href='#none' onclick='return false;' class='number hit'>$ii</a>"; }
						}
					?>

					<? if($listpg == $next){ ?>
					<a href="#none" onclick="return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } else { ?>
					<a href="#none" onclick="talk_view(<?=$next?>);return false;" class="prevnext" title="다음"><span class="arrow"></span></a>
					<? } ?>

				</span>
			</div>
<?
		break;
	}	
?>