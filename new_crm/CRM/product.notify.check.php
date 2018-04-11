<?php
include_once "include/inc.php";
if($_REQUEST[mode] == "I"){

	$sql = "select * from odtProduct where name like '%".$_REQUEST[keyword]."%'";
	$res = mysql_query($sql);
	$goods_code_arr = explode(",", $_REQUEST[goods_code]);
	$html ="<div class='cm_mypage_list list_posting'><table id='option_info' summary='배송비 정책'><colgroup><col width='30'/><col width='70'/><col width='200'/><col /></colgroup><tbody><tr><th>선택</th><th>상품코드</th><th>상품명</th></tr>";
	$i = 0;
	while($row = mysql_fetch_array($res)){
		
		if($row[code] == $goods_code_arr[$i]){
			$html .= "";	
		}else{
			$html .= "<tr class='item1 open_full'><td><input type='checkbox' name='check_code[]' id='check_code' value='".$row[code]."'></td><td>".$row[code]."</td><td>".$row[name]."</td></tr>";		
		}
		$i ++;
	}
	$html .= "</tbody></table></div>";

}else if($_REQUEST[mode] == "E"){

	$sql = "select * from jy_partner where pn_company_name like '%".$_REQUEST[keyword]."%'";
	$res = mysql_query($sql);
	$enterprise_code_arr = explode(",",$_REQUEST[enterprise_code]);
	$html ="<div class='cm_mypage_list list_posting'><table id='option_info' summary='배송비 정책'><colgroup><col width='50'/><col /></colgroup><tbody><tr><th>선택</th><th>업체명</th></tr>";
	$i = 0;
	while($row = mysql_fetch_array($res)){
		if($row[uid] == $enterprise_code_arr[$i]){
			$html .= "";
		}else{
			$html .= "<tr class='item1 open_full'><td><input type='checkbox' name='check_code[]' id='check_code' value='".$row[uid]."'></td><td>".$row[pn_company_name]."</td></tr>";		
		}
		$i++;
	}
	$html .= "</tbody></table></div>";

}
echo $html;
?>