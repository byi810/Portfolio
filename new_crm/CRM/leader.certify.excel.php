<?php
include_once "include/inc.php";

//header( "Content-type: application/vnd.ms-excel; charset=UTF-8");  
//header( "Content-type: application/vnd.ms-excel" );   
//header( "Content-Disposition: attachment; filename = 사전등록 번호관리_".date("Y-m-d H-m-s").".xls" );   
//header( "Content-Description: PHP4 Generated Data" );   

$file_name = iconv("utf-8","euc-kr","사전등록 승인대기_");

header( "Content-type: application/vnd.ms-excel" );
header( "Content-type: application/vnd.ms-excel; charset=utf-8" ); 
header( "Content-Disposition: attachment; filename=".$file_name.date("YmdHis").".xls" ); 
header( "Content-Description: PHP4 Generated Data" ); 
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");


$where = "where 1=1 and application = 'N'";
if($_REQUEST[skey] && $_REQUEST[sval]){
	if($_REQUEST[skey] == 'name') $where .= "and name like '%$_REQUEST[sval]%'";
	if($_REQUEST[skey] == 'number') $where .= "and phone_num like '%".$_REQUEST[sval]."%'";
}

?>

<table width="80%" cellpadding="0" cellspacing="0" style="font-size:9pt;" border="1"> 
	<tr bgcolor="#000" height="30" style="text-align:center; color:#000;">
		<td width="20%">소속밴드</td>
		<td width="20%">이름</td>
		<td width="20%">휴대폰번호</td>
		<td width="20%">관계</td>
		<td width="20%">등록일자</td>
	</tr>
<? 
$sql = "
	select * from reader_certify_beforehand_table $where order by uid desc 
";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs)){
?>
<tr height="30" style="text-align:center;">
	<td><?=$row['band_code']?></td> 
	<td><?=$row['name']?></td>
	<td><?=$row['phone_num']?></td>
	<td><?=$row['relation']?></td>
	<td><?=date("Y-m-d",$row['register_date'])?></td>
 </tr>

 <?

}

?>
</table>