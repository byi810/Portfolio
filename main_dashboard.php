<style>
.main_center {font-family:Gothic;font-size:30px;font-weight:bold;text-align:center;padding:70px 100px 100px 100px;}
</style>
<script>
function popupOpen(){

	var popUrl = "http://cs.jooyonshop.com/spage/my_cs_manager.php";
	var popOption = "width=670, height=360, resizable=no, scrollbars=no, status=no;";    //�˾�â �ɼ�(optoin)
	window.open(popUrl,"",popOption);
}
function popupOpen2(){

	var popUrl = "http://cs.jooyonshop.com/spage/my_cs_manager.php?p_uid=&p_view=rec&p_search=";
	var popOption = "width=670, height=360, resizable=no, scrollbars=no, status=no;";    //�˾�â �ɼ�(optoin)
	window.open(popUrl,"",popOption);
}

function cs_popup(){

window.open("http://cs.jooyonshop.com/spage/my_cs_manager.php", "pop", "width=400,height=500,history=no,resizable=no,status=no,scrollbars=yes,menubar=no")

}
</script>
<!--
<table>
	<tr style="text-align:center;">
		<div align="center" style="padding-top:40px; margin-bottom:-40px;float: left; width: 15%; margin-left:13%;">
			<span style="font-family: ��Noto Sans KR��; margin-left:-53%;">����, �������� CS <?=$row_cs_cnt[0]?>��</span><br><br>
			<span  style="font-family: ��Noto Sans KR��; padding-top:5%">���� CS �ǵ��<?=$row_fb_cnt[0]?>��</span>
		</div>
	</tr>
</table>
-->
<?
	//�������� cs count ����
$SQL = "
	SELECT
		count(*)
	FROM
		ecm_memo_cs_new 
	WHERE
		reg_member = '".$zb_logged_no."'
		AND (status_accept = 'ING' OR status_accept = '') 
";
$rs_cs_cnt = mysql_query($SQL);
$row_cs_cnt = mysql_fetch_row($rs_cs_cnt);
//cs �ǵ�� ����
$SQL = "
	 SELECT
		count(*) 
	 FROM 
		ecm_memo_cs_feedback  
	 WHERE
		member_no = '".$zb_logged_no."'
";
$rs_fb_cnt = mysql_query($SQL);
$row_fb_cnt = mysql_fetch_row($rs_fb_cnt);

/*
if($member['user_id'] == "stylehy1016"){
	$member['user_id'] = "lyslys10";
	debug($member);
}
*/
$today = date("d");
$tomon = date("m");
$total_day = $band_sell[8] + $erpia_sum_daily[8] + $shop_sell[8];
	$cs_team_id =Array('lyslys10', 'alryddl', 'norajulgga', 'dsandsk', 'alwlsdlek', 'kamba', 'roies2', 'rock582');
	//$cs_team_id =Array( 'lysunu', 'gkskfh', 'stylehy1016', 'itslikeyoungg');
	if(in_array($member['user_id'],$cs_team_id)){
	?>
	<body onload="javascript:cs_popup();">
		<div align="center" style="margin-top:1%; padding: 10px; margin-bottom:-40px;width: 10%; margin-left:45%;background: #eaeaea; border-radius:10px;">
			<span style="font-family: ��Noto Sans KR��; font-size:11pt;">���� : <?=$member['name']?></span><br><br>
			<span style="font-family: ��Noto Sans KR��; font-size:11pt;">����, �������� CS : </span><span style="font-size:11pt;"><a href="javascript:popupOpen();" style="font-size:11pt;"><?=$row_cs_cnt[0]?>��</a></span>
			<?
			if($row_cs_cnt2[0] > 0){
			?>
			<span style="color:red;">new</span>
			<?
			}
			?>
			<br><br>
			<span  style="font-family: ��Noto Sans KR��; font-size:11pt;">���� CS �ǵ�� : <span><a href="javascript:popupOpen2();"  style="font-size:11pt;"><?=$row_fb_cnt[0]?>��</a></span>
			<?
			if($row_fb_cnt2[0] > 0){
			?>
			<span style="color:red;">new</span>
			<?
				}
			?>
		</div>
	</body>
	<? if($member['user_id'] == 'lyslys10') { ?>
	<div align="center" style="margin-top:4%; padding: 10px; margin-bottom:-40px;float: left; width: 130px; margin-left:4%;background: #eaeaea; border-radius:10px;">
	<span  style="font-family: ��Noto Sans KR��; font-size:11pt;">���� <?=$today-1?>�� ����</span>
	</div>
	<? } ?>
		<?
		}else{
			?>
		<div align="center" style="margin-top:4%; padding: 10px; margin-bottom:-40px;float: left; width: 7%; margin-left:4%;background: #eaeaea; border-radius:10px;">
			<span  style="font-family: ��Noto Sans KR��; font-size:11pt;">���� <?=$today-1?>�� ����</span>
		</div>
		<?
		}
		?>
		
<?

//���� �����̻� ����
$SQL = "
	select 
		count(*) as cnt 
	from 
		jooyonshop_staff_info
	where 
		staff_member_id = '".$member['user_id']."'
		and staff_position in (1,7,5,11)
		";
$rss = mysql_query($SQL);
$rows = mysql_fetch_array($rss);

//$member['user_id'] = 'gkskfh';
//$dash_board_member = array('�迵��', '���ر�', 'Ȳ�Ѽ�', '����ȯ', '�̼���', '������', '������', '������', '�ŵ���', '�̱Ա�', '������', '�̿���', 'Ȳ����'); 
if($rows['cnt'] == 1 || in_array($member['user_id'], array('stylehy1016','gkskfh', 'wizard4266', 'itslikeyoungg', 'qhfk011', 'rhkwk', 'lyslys10'))){


$year_s = ($_REQUEST["year_s"] == "") ? date("Y") : $_REQUEST["year_s"];
$month_s = ($_REQUEST["month_s"] == "") ? date("n") : $_REQUEST["month_s"];
$day_s = ($_REQUEST["day_s"] == "") ? 1 : $_REQUEST["day_s"];

$year_e = ($_REQUEST["year_e"] == "") ? date("Y") : $_REQUEST["year_e"];
$month_e = ($_REQUEST["month_e"] == "") ? date("n") : $_REQUEST["month_e"];
$day_e = ($_REQUEST["day_e"] == "") ? date("j") : $_REQUEST["day_e"];

$s_date = mktime(0,0,0,$month_s,$day_s,$year_s);
$e_date = mktime(0,0,0,$month_e,$day_e,$year_e);
$p_viewMonth = $_REQUEST["p_viewMonth"];

?>
<?

include("erpi_daily_sale_170427.php"); //�׷��� ����

$now_time = mktime();
$last_time = $now_time - 432000;
$band_sell = Array();
$erpia_sell = Array();
$openmarket_sell = Array();

$band_sell_M = Array();
$erpia_sell_M = Array();
$openmarket_sell = Array();

//���ں� where ���� �ֱ� ���� 
for($a = 0; $a < 10; $a++){

	include("chart_switch.php"); //��Ʈ ��¥ ���а�

//�ֱ� 10�ϰ� ������� or ���������ʰ� �ֹ��� �س��� ��ǰ

//��� �Ϻ�����
	$SQL = " 
		SELECT 
			sum(order_tprice) AS order_tprice
		FROM 
			ecm_daily_order_price_table
		WHERE 
			reg_date BETWEEN '".$aa."' AND '".$bb."' AND order_site >= 89
		LIMIT 1 ";
$rsa = mysql_query($SQL);
$rowws = mysql_fetch_array($rsa);
$band_sell[] = $rowws[order_tprice];

//��� ��������
	$SQL = "
		SELECT 
			order_site,
			SUM(if(order_tprice >= 0, order_tprice, 0)) AS order_ptprice,
			SUM(if(order_tprice <= 0, order_tprice, 0)) AS order_mtprice,
			FROM_UNIXTIME(reg_date, '%Y-%m')
		FROM 
			ecm_daily_order_price_table
		WHERE     
			reg_date BETWEEN '".$baaM."' AND '".$bbbM."'	
	";
 $rsa_month = mysql_query($SQL);
$rowws_month = mysql_fetch_array($rsa_month);
$band_sell_m[] = $rowws_month[order_ptprice] + $rowws_month[order_mtprice];

//FROM_UNIXTIME(reg_date,'%Y %m') -> unixtime to date
//UNIX_TIMESTAMP('2010-12-25 12:30:25') -> date to unixtime

//����Ŀ �ϸ���
	$SQL = "
		SELECT  
			SUM(jooyon_tprice) AS jooyon_price
		FROM 
			openmarket_daily_sale
		WHERE 
			register_date = '".$shop_bb."'
		LIMIT 1
	";

$rsshop = mysql_query($SQL);
$rowshop = mysql_fetch_array($rsshop);
$shop_sell[] = $rowshop[jooyon_price];
if($shop_sell[$a] == ""){
	$shop_sell[$a] = '0';
}
//����Ŀ ������
	$SQL = "
		SELECT  
			SUM(jooyon_tprice) AS jooyon_price
		FROM 
			openmarket_daily_sale
		WHERE 
			register_date BETWEEN '".$aaM."' AND '".$bbM."'
		LIMIT 1
	";
$rsshop_m = mysql_query($SQL);
$rowshop_m = mysql_fetch_array($rsshop_m);
$shop_sell_m[] = $rowshop_m[jooyon_price];
if($shop_sell_m[$a] == ""){
	$shop_sell_m[$a] = '0';
}


	if($a < 10){
		$comm = ", ";
	}else if($a == 10){
		$comm = "";
	}


$daily_sell .=  "['".date("d", $bb)."��', ".$band_sell[$a].", ".$erpia_sum_daily[$a].", ".$shop_sell[$a]."]".$comm;
$daily_sell_month .= "['".date("m", $mmonth)."��', ".$band_sell_m[$a].", ".$erpia_sum_month[$a].", ".$shop_sell_m[$a]."]".$comm;
}
//1�Ϻ��� ������� �� ����
$SQL = " 
		SELECT 
			sum(order_tprice) AS order_tprice
		FROM 
			ecm_daily_order_price_table
		WHERE 
			reg_date BETWEEN '".$s_date."' AND '".$e_date."' AND order_site >= 89
		LIMIT 1 ";
$rs_total_band =  mysql_query($SQL);
$row_total_band = mysql_fetch_row($rs_total_band);

$SQL = "
		SELECT  
			SUM(jooyon_tprice) AS jooyon_price
		FROM 
			openmarket_daily_sale
		WHERE 
			register_date BETWEEN FROM_UNIXTIME('".$s_date."') AND FROM_UNIXTIME('".$e_date."')
		LIMIT 1
	";
$rs_total_shop = mysql_query($SQL);
$row_total_shop = mysql_fetch_row($rs_total_shop);



$today = date("d");
$tomon = date("m");
$total_day = $band_sell[8] + $erpia_sum_daily[8] + $shop_sell[8];


$total_mon = $row_total_band[0] + $row_total_erpia['panAmt'] + $row_total_shop[0];

//���� ���� ���

$SQL = "
	SELECT 
		(time_hit_00+time_hit_01+time_hit_02+time_hit_03) as time_hit00_04,
		(time_hit_05+time_hit_06+time_hit_07+time_hit_08) as time_hit00_08,
		(time_hit_09+time_hit_10+time_hit_11+time_hit_12) as time_hit08_12,
		(time_hit_13+time_hit_14+time_hit_15+time_hit_16) as time_hit12_16,
		(time_hit_17+time_hit_18+time_hit_19+time_hit_20) as time_hit16_20,
		(time_hit_21+time_hit_22+time_hit_23) as time_hit20_24
	FROM 
		morning_time_table
	WHERE 
		time_regdate = '".$aa_a."'
";

$rs_visit_weekly = mysql_query($SQL);
$row_visit_weekly = mysql_fetch_row($rs_visit_weekly);


$visit_weekly .= 
	"["."'00:00 - 04:00��', ".$row_visit_weekly[0]."], 
	"."['04:00 - 08:00��', ".$row_visit_weekly[1]."], 
	"."['08:00 - 12:00��', ".$row_visit_weekly[2]."], 
	"."['12:00 - 16:00��', ".$row_visit_weekly[3]."], 
	"."['16:00 - 20:00��', ".$row_visit_weekly[4]."], 
	"."['20:00 - 24:00��', ".$row_visit_weekly[5]."]";

$now_30m = $now_time - 1600;

$SQL = "
	SELECT
		count(*)
	FROM
		ecm_memo_cs_new 
	WHERE
		reg_member = '".$zb_logged_no."'
		AND (status_accept = 'ING' OR status_accept = '') 
		AND reg_date BETWEEN '".$now_30m."' AND '".$now_time."'
";

$rs_cs_cnt2 = mysql_query($SQL);
$row_cs_cnt2 = mysql_fetch_row($rs_cs_cnt2);
//$zb_logged_no

?>


<script src="//www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.load('visualization', '1.0', {packages: ['corechart']}); 
</script> 
<script type="text/javascript"> 
	//�ϰ���������
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Day', '������', 'ERPIa', '������'],
				<?=$daily_sell?>
			]);
	var options = {
		  title: '�ϰ� ���� ����',
		  curveType: 'string',
		  legend: { position: 'bottom' }
	};

	var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

	chart.draw(data, options);

	//������������
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Day', '������', 'ERPIa', '������'],
			<?=$daily_sell_month?>
        ]);

        var options = {
          title: '���� ���� ����',
          curveType: 'string',
		  
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart.draw(data, options);
      }
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart2);
function drawChart2() {

        var data = google.visualization.arrayToDataTable([
          ['00:00 - 04:00', 'Hours per Day'],
          <?=$visit_weekly?>
        ]);

        var options = {
          title: '�ְ� ��� ���� �ð���',
			  chartArea:{left:20,top:70,width:'100%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

</script>
<style>
@import url(http://fonts.googleapis.com/earlyaccess/notosanskr.css);
</style>
<div style="margin-bottom:40px">
	<div>
		<div style="padding-top:40px;margin-top:20px;margin-bottom:-40px;float: left; width: 250px; margin-left:2%;text-align:center">
			<span style="font-family: ��Noto Sans KR��; font-size:15pt; margin-left:-53%;">��� ����</span><br><br>
			<span  style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%">��<?=number_format( $band_sell[8])?></span>
			<?
			if($band_sell[8] > $band_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#59DA50;"> �� </span>
			<?
			}else if($band_sell[8] == $band_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#8C8C8C;"> - </span>
			<?
			}else if($band_sell[8] < $band_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#FF3636;"> �� </span>
			<?
			}
			?>
		</div>
		<div align="center" style="padding-top:40px;margin-top:20px; margin-bottom:-40px;float: left; width: 300px;">
			<span style="font-family: ��Noto Sans KR��; font-size:15pt; padding-left:25px; padding-right:25px;  margin-left:-50%">ERPIa ����</span><br><br>
			<span  style="font-family: ��Noto Sans KR��; font-size:25pt;">��<?=number_format($erpia_sum_daily[8])?></span>
			<?
			if($erpia_sum_daily[8] > $erpia_sum_daily[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#59DA50;">  �� </span>
			<?
			}else if($erpia_sum_daily[8] == $erpia_sum_daily[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#8C8C8C;">  - </span>
			<?
			}else if($erpia_sum_daily[8] < $erpia_sum_daily[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#FF3636;">  �� </span>
			<?
			}
			?>
		</div>
		<div align="center" style="padding-top:40px;margin-top:20px; margin-bottom:-40px;float: left; width: 300px;">
			<span style="font-family: ��Noto Sans KR��; font-size:15pt;  margin-left:-22%">������ ����</span><br><br>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt;">��<?=number_format($shop_sell[8])?></span>
			<?
			if($shop_sell[8] > $shop_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#59DA50;">  �� </span>
			<?
			}else if($shop_sell[8] == $shop_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#8C8C8C;">  - </span>
			<?
			}else if($shop_sell[8] < $shop_sell[7]){
			?>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt; padding-top:5%; color:#FF3636;"> �� </span>
			<?
			}
			?>
		</div>
		<div align="center" style="padding-top:40px;margin-top:20px; margin-bottom:-40px;float: left; width: 300px;">
			<span style="font-family: ��Noto Sans KR��; font-size:15pt;  margin-left:-30%">���� �� ����</span><br><br>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt;">��<?=number_format($total_day)?></span>
		</div>
		<div align="center" style="padding-top:40px;margin-top:20px; margin-bottom:-40px;float: left; width: 300px;">
			<span style="font-family: ��Noto Sans KR��; font-size:15pt;  margin-left:-5%">������� <?=$tomon?>�� �� ����</span><br><br>
			<span style="font-family: ��Noto Sans KR��; font-size:25pt;">��<?=number_format($total_mon)?></span>
		</div>
	</div>

	<table>
		<tr>
			<td>
				<div id="curve_chart" style="width: 650px; height: 400px; margin-top:60px; margin-left:10%;"></div>
			</td>
			<td>
				<div id="curve_chart2" style="width: 650px; height: 400px; margin-top:60px; margin-left:-20%;"></div>
			</td>
			<td>
				<div id="piechart" style="width: 400px; height: 400px; margin-top:60px; margin-left:-20%;"></div>
			</td>
		</tr>
		<tr>
			<td style="padding-left: -20pt;">
				<div class="main_center" style="width: 600px; height:300px; margin-top: -7%;">
				<div>
					<div style= "text-align:center;">
						<span style="margin: 0 auto; font-size:15pt;font-family: ��Noto Sans KR�� ;">��ǰ�� �Ǹ� Top 10 �ֹ��Ǽ�/�����</span><br>
						<span style="margin: 0 auto; font-size:10pt;font-family: ��Noto Sans KR�� ;">������(<?=$today?>)�κ��� 7���������� �������Դϴ�.</span>
						<!-- ����Ʈ ���� ���� -->
					</div>
				<table>
					<thead>
						<tr>
							<th style="padding-top:15px; padding-bottom:15px;  padding-left: 15px;padding-right: 15px; font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">No</th>
							<th style="padding-top:15px; padding-bottom:15px;font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">��ǰ��</th>
						</tr>
					</thead> 
				<tbody style="font-family: ��Noto Sans KR�� ; "> 
				<?
					$sql = 
					"
					SELECT 
					b.*
					FROM
					(select x.*, y.sum_order_count,(select goods_name from morning_cost_price_table where goods_code = x.goods_code) as goods_name2 from morning_goods_table x join (select order_code, sum(order_count) as sum_order_count from ecm_daily_order_price_table where reg_date > (unix_timestamp(now()) - 604800) group by order_code order by sum_order_count desc limit 100 ) y on x.goods_code = y.order_code
					WHERE
					x.goods_class = 0 
					and (x.goods_category = '01040000'  or x.goods_category = '100000000' )
					and x.approval_date > 9) b
					LEFT OUTER JOIN (select goods_code, max(inventory_cnt) as inventory_cnt from morning_goods_option_table group by goods_code) a on b.goods_code = a.goods_code where (a.inventory_cnt > 0 or a.inventory_cnt is null)
					and goods_category <> '01080000' 
					ORDER BY b.sum_order_count desc
					LIMIT 10
					";
					$rs_top_goods = mysql_query($sql);
					$i = 1;
					while($row_top_goods = mysql_fetch_row($rs_top_goods)){	
						if($i %2 == 0){
					?>
						<tr style="background: #fdf3f5;">
							<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$i?></span></td>
							<td style="padding-top:10px;"><span style="font-size:10pt;"><?=$row_top_goods["20"]?></span></td>
						</tr>
					<?
					}else{
						?>
						<tr style="font-family: ��Noto Sans KR�� ;">
							<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$i?></span></td>
							<td style="padding-top:10px;"><span style="font-size:10pt;"><?=$row_top_goods["20"]?></span></td>
						</tr>
							<?
								}
									$i++;
								}
							?>
						</tbody>		
					</table>
					</div>
				</div>
			</td>
			<td>
			<div class="main_center">
				<div style="width:100%;">
					<div style= "text-align:center;">
						<span style="margin: 0 auto; font-size:15pt;font-family: ��Noto Sans KR�� ;">��庰 ������ Top 5</span>
					<!-- ����Ʈ ���� ���� -->
					</div>
			<table  style="width: 500px; height:300px;">
				<thead>
					<tr>
						<th style="padding-top:15px; padding-bottom:15px;  padding-left: 15px;padding-right: 15px; font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">No</th>
						<th style="padding-top:15px; padding-bottom:15px;  padding-left: 15px;padding-right: 15px; font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">����</th>
						<th style="padding-top:15px; padding-bottom:15px;  padding-left: 15px;padding-right: 15px; font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">����ڵ�</th>
						<th style="padding-top:15px; padding-bottom:15px;  padding-left: 15px;padding-right: 15px; font-family: ��Noto Sans KR�� ; color: #fff; background: #8C8C8C;">�������</th>
					</tr>
				</thead> 
				<tbody  style="font-family: ��Noto Sans KR�� ; "> 
				<?

				$sql = 
					"
					SELECT order_site,
					   SUM(if(order_tprice >= 0, order_tprice, 0)) AS order_ptprice,
					   SUM(if(order_tprice < 0, order_tprice, 0)) AS order_mtprice,
					   FROM_UNIXTIME(reg_date,'%Y %m') as reg_date
				FROM 
					ecm_daily_order_price_table
				WHERE 
					reg_date BETWEEN '$s_date'
					AND '$e_date'
					AND order_site >= 89
				GROUP BY order_site
				ORDER BY order_ptprice desc
				LIMIT 5	
					";


				$rs_top_band = mysql_query($sql);
				$i = 1;
				while($row_top_band = mysql_fetch_row($rs_top_band)){	
				
					$SQL = "
					SELECT 
						name, user_id 
					FROM 
						zetyx_member_table 
					WHERE user_id like '%".$row_top_band[0]."%' 
					ORDER BY user_id
					";
					$rs_find_band = mysql_query($SQL);
					$row_find_band = mysql_fetch_array($rs_find_band);
					
					$monthly_sell = $row_top_band["1"] + $row_top_band["2"];
					if($i %2 == 0){
				?>
				<tr style="background: #fdf3f5;">
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$i?></span></td>
					<td style="padding-top:10px;"><span style="font-size:10pt;"><?=$row_find_band["name"]?></span></td>
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$row_top_band["0"]?></span></td>
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=number_format($monthly_sell)?></span></td>
				</tr>
				<?
					}else{
					?>
				<tr>
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$i?></span></td>
					<td style="padding-top:10px;"><span style="font-size:10pt;"><?=$row_find_band["name"]?></span></td>
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=$row_top_band["0"]?></span></td>
					<td style="text-align:center;padding-top:10px;"><span style="font-size:10pt;"><?=number_format($monthly_sell)?></span></td>
				</tr>
					<?
				}
				$i++;
				}
				?>
						</tbody>		
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<?}else{?>
<?
//������������ ���� ����� ������ cs�� ���������� ��������..
MainConn();
?>
<table width=100% cellspacing=0 cellpadding=5 style="margin-top:70px;">
  <tr>
    <td>
      <!-- 2015.09.22 (lysunu) �ù�����ȸ �߰� -->
      <table width=100% cellspacing=0 cellpadding=0 style="border:1 solid black">
        <tr height=25>
          <td style="background:url('/img/_bar_bg.gif') repeat-x" align=center class="bold white">�ù� �����ȸ</td>
        </tr>
      </table>
      <table width=100% cellspacing=0 cellpadding=0 bgcolor="white" border=0 class=fixed>
        <tr>
          <!-- CJ ���� ��� -->
          <td>
            <form method="GET" action="http://nexs.cjgls.com/web/tracking_auoction.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="https://www.doortodoor.co.kr/main/index.jsp" target="_blank"><img src="/img/parcel_cj.png" height="30"></td>
                <td>
                  <input type=text name=slipno class=input style="width:100"> <input type=image src="/img/b_find.gif" align=absmiddle>
                  ������ȣ�� ��������.
                </td>
              </tr>
            </table>
            </form>
          </td>
          <!-- �����ù� -->
          <td>
            <form method="GET" action="http://www.hlctos.co.kr/if/trace_auction.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="https://www.hlc.co.kr/home/personal/inquiry/track" target="_blank"><img src="/img/parcel_hyundae.gif" height="30"></td>
                <td>
                  <input type=text name=invno class=input style="width:100"> <input type=image src="/img/b_find.gif" align=absmiddle>
                  ������ȣ�� ��������.
                </td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
      </table>
      <br>      

      <!-- 2015.05.18 (lysunu) �ּ�ó������ ���� -->
      <table width=100% cellspacing=0 cellpadding=0 style="border:1 solid black">
        <tr height=25>
          <td style="background:url('/img/_bar_bg.gif') repeat-x" align=center class="bold white">��� �ٷΰ���</td>
        </tr>
      </table>

      <table width=100% cellspacing=0 cellpadding=0 bgcolor="white" border=0 class=fixed>
        <tr valign=top>
          <td><a href="http://www.allthegate.com/login/r_login.jsp" target="_blank"><img src="/img/bn_allthegate.gif"></a></td>
          <td><a href="http://banking.nonghyup.com/" target="_blank"><img src="/img/bn_nonghyup.gif"></a></td>
          <td><a href="https://login42.marketingsolutions.overture.com/" target="_blank"><img src="/img/bn_overture.gif"></a></td>
          <td><a href="http://cyber.kepco.co.kr/cyber/01_personal/01_payment/payment_calculate/payment_calculate.jsp" target="_blank"><img src="/img/bn_kepco.gif"></a></td>
        </tr>
        <tr>
          <td>
            <form method="GET" action="http://jooyonshop.com/m_search.php" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.jooyonshop.com" target="_blank"><img src="/img/bn_jooyonshop.gif"></td>
                <td><input type=text name=ps_search class=input style="width:100"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <form method="GET" action="http://search.daum.net/cgi-bin/nsp/search.cgi" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.daum.net/" target="_blank"><img src="/img/bn_daum.gif"></a></td>
                <td><input type=text name=q class=input style="width:100"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <form method="GET" action="http://search.auction.co.kr/search/search.aspx" target="_blank">
            <input type="hidden" name="yid" value="guest">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.auction.co.kr/" target="_blank"><img src="/img/bn_auction.gif"></a></td>
                <td><input type=text name=keyword class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <form method="get" action="http://www.gmarket.co.kr/challenge/neo_search/search_total.asp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.gmarket.co.kr/" target="_blank"><img src="/img/bn_gmarket.gif"></a></td>
                <td><input type=text name=keyword class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- 11���� //-->
            <form action="http://search.11st.co.kr/SearchPrdAction.tmall" target="_blank">
            <input type="hidden" name="method" value="getTotalSearchSeller" />
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.11st.co.kr/html/main.html" target="_blank"><img src="/img/bn_11st.gif"></a></td>
                <td><input type=text name=kwd class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
        <tr>
          <td>
            <!-- ������ũ //-->
            <form method="get" action="http://search.interpark.com/dsearch/total.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.interpark.com" target="_blank"><img src="/img/bn_interpark.gif"></a></td>
                <td><input type=text name=tq class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- dnshop //-->
            <form method="get" action="http://www.dnshop.com/front/search/DnshopSearchResult" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.dnshop.com" target="_blank"><img src="/img/bn_dnshop.gif"></a></td>
                <td><input type=text name=SEARCH_KEYWORD class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- NS�̼� //-->
            <form method="post" action="http://www.nseshop.com/jsp/item/search.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.nseshop.com" target="_blank"><img src="/img/bn_nseshop.gif"></a></td>
                <td><input type=text name=searchTerm class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- �Ե����� //-->
            <form name="form_lotte" method="get" onsubmit="return false">
            <input type="hidden" name="init"      value="Y" />
            <input type="hidden" name="MULTISHOPCATES" value="LVL2_CATE_NO" />
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.lotte.com" target="_blank"><img src="/img/bn_lotte.gif"></a></td>
                <td><input type=text name=query class=input style="width:95px" onkeypress="if(event.keyCode == '13'){goLTSearch()};"> <img src="/img/b_find.gif" align=absmiddle class="hand" onclick="goLTSearch();"></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- �Ե����̸� //-->
            <form method="get" action="http://www.lotteimall.com/search/search.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.lotteimall.com" target="_blank"><img src="/img/bn_lotteimall.gif"></a></td>
                <td><input type=text name=headerquery class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
        <tr>
          <td>
            <!-- ����Ȩ���� //-->
            <form method="get" action="http://www.hyundaihmall.com/front/scSearchL.do" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.hyundaihmall.com" target="_blank"><img src="/img/bn_hmall.gif"></a></td>
                <td><input type=text name=tq class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- CJȨ���� //-->
            <form method="get" action="http://www.cjmall.com/prd/front/search/search_main.jsp" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://www.cjmall.com" target="_blank"><img src="/img/bn_cjmall.gif"></a></td>
                <td><input type=text name=srch_value class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </table>
            </form>
          </td>
          <td>
            <!-- gsȨ���� //-->
            <form method="get" action="http://with.gsshop.com/search/main.gs" target="_blank">
            <table cellspacing=0 cellpadding=0>
              <tr>
                <td width="95"><a href="http://with.gsshop.com/index.gs" target="_blank"><img src="/img/bn_gsshop.gif"></a></td>
                <td><input type=text name=tq class=input style="width:95px"> <input type=image src="/img/b_find.gif" align=absmiddle></td>
              </tr>
            </form>
            </table>
          </td>
        </tr>
      </table>
      <script type="text/javascript">
      function goLTSearch(){
         var f = document.form_lotte;

         var newWin = window.open('about:blank');
         newWin.location.href="http://www.lotte.com/search/searchMain.lotte?init=Y&MULTISHOPCATES=LVL2_CATE_NO&query="+encodeURIComponent(f.query.value);
      }
      </script>
      <br>
      
      <table width=100% cellspacing=0 cellpadding=0 style="border:1 solid black">
        <tr height=25>
          <td style="background:url('/img/_bar_bg.gif') repeat-x" align=center class="bold white">����ǥ</td>
        </tr>
      </table>

      <table width=100% cellspacing=1 cellpadding=5 bgcolor="white">
        <tr>
          <td align="center">
            <iframe id="MainCalendar" src="/spage/iframe.fullcalendar.php" width="750" height="500" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
      </table>

      <br>
      
      <table width=100% cellspacing=0 cellpadding=0 style="border:1 solid black">
        <tr height=25>
          <td style="background:url('/img/_bar_bg.gif') repeat-x" align=center class="bold white">�ǸŻ���Ʈ</td>
        </tr>
      </table>

      <table width=100% cellspacing=1 cellpadding=5 bgcolor="white">
        <col><col><col><col><col>
        <?
           $tr_cnt=1;
           $site=mysql_query("SELECT * FROM ecm_site ORDER BY sitename");
           while ($row=mysql_fetch_array($site)){
             if ($tr_cnt%2==1) $bgcolor="#FAFAFA";
             else $bgcolor="#EEEEEE";

             if ($tr_cnt%5==1) echo ('
                <tr bgcolor="'.$bgcolor.'" align=center>');

             echo ('<td><a href="http://'.$row[siteurl1].'" target="_blank">'.$row[sitename].'<br><font class="ver10px gray">'.$row[siteurl1].'</font></a></td>');

             if ($tr_cnt%5==0) echo ('
                </tr>');

             $tr_cnt++;
           }

           for ($i=0; $i<5-(($tr_cnt-1)%5); $i++){
              echo ('<td></td>');
           }

           if ($i>0) echo ('</tr>');

        ?>
      </table>
    </td>
  </tr>
</table>


<?}?>