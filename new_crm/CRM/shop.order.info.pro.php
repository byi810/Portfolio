<?PHP

// 주문자 정보 복사 기능

@extract($_POST);
@extract($_GET);

include_once "include/inc.php";

$sql = "
	select
		*
	from 
		odtOrder a
		left join odtDeliveryAddress b on a.ordernum=b.ordernum
	where
		a.ordernum = '".$sess."'
";

$res = mysql_query($sql);

if($res){
	while($row = mysql_fetch_array($res)){
		SetCookie("OrderName",$row[ordername],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("OrderEmail",$row[orderemail],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("OrderHtel1",$row[orderhtel1],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("OrderHtel2",$row[orderhtel2],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("OrderHtel3",$row[orderhtel3],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecName",$row[recname],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecEmail",$row[recemail],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecHtel1",$row[rechtel1],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecHtel2",$row[rechtel2],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecHtel3",$row[rechtel3],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecZip1",$row[reczip1],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecZip2",$row[reczip2],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecZonecode",$row[reczonecode],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecAddress",$row[recaddress],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecAddress1",$row[recaddress1],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
		SetCookie("RecAddressDoro",$row[recaddress_doro],time()+60*10,"/","." . str_replace("crm." , "" , $_SERVER['HTTP_HOST']));
	}
	echo "주문자 정보를 복사하였습니다.";
}else{
	echo "주문자 정보 복사에 실패하였습니다.";
}
?>