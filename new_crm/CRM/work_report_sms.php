<?php
include_once "include/inc.php";

$whereTxt = "";

switch($row_member[mb_position]){
	case "IT" :
		//인턴
		$whereTxt .= "";
	break;

	case "CT" :
		//계약
		$whereTxt .= "";
	break;

	case  "TM" :
		//팀원
		$whereTxt .= "";
	break;
		
	case "TL" :
		//팀장
		$whereTxt .= "";
	break;
		
	case "DH" :
		//본부장
		$whereTxt .= "";
	break;

	case "CM" :
		//이사
		$whereTxt .= "";
	break;

	case "VP" :
		//부사장
		$whereTxt .= "";
	break;
}
$sql = "
	select
		*
	from
		jy_staff
	where
		$where
";
debug($sql);

?>