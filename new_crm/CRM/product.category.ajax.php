<?

include_once "include/inc.php";

//-----------------------------------------------------------------------------
// 상위로 순서변경
//-----------------------------------------------------------------------------
switch($_REQUEST[status]){

	case "view_up" :

    // 정보 불러오기
    //$Result  = mysql_fetch_array(mysql_query(" SELECT cateidx , catedepth , parent_catecode FROM odtCategory WHERE serialnum = '$serialnum' "));
	$sql = "
		SELECT cateidx , catedepth , parent_catecode FROM odtCategory WHERE serialnum = '".$_REQUEST[serialnum]."' 
	";
	$rs_sum_info = mysql_query($sql);
	$row_sum_info = mysql_fetch_array($rs_sum_info);

    $cateidx = $row_sum_info[cateidx];
    $catedepth = $row_sum_info[catedepth];
    $parent_catecode = $row_sum_info[parent_catecode];

    // 최소 순위  찾기 //////////////////////////////////////////
    //$Result  = mysql_fetch_array(mysql_query(" SELECT ifnull(MIN(cateidx),0) as min_cateidx FROM odtCategory WHERE parent_catecode='$parent_catecode' "));
	$sql = "
		SELECT ifnull(MIN(cateidx),0) as min_cateidx FROM odtCategory WHERE parent_catecode='".$parent_catecode."'
	";
	$rs_min_idx = mysql_query($sql);
	$row_min_idx = mysql_fetch_array($rs_min_idx);
    $mincateidx = $row_min_idx[min_cateidx];

    if ($mincateidx == $cateidx) {
		error_alt("더 이상 상위로 변경할 수 없습니다.");
    }
    else {
		
		$sr = mysql_fetch_array(mysql_query("select cateidx , serialnum from odtCategory WHERE parent_catecode='$parent_catecode' and cateidx < '$cateidx' order by cateidx desc limit 1"));

        mysql_query(" UPDATE odtCategory SET cateidx = $cateidx WHERE serialnum='$sr[serialnum]'");

        // 순서값 제거 - 자신의 순서값
        mysql_query(" UPDATE odtCategory SET cateidx = $sr[cateidx] WHERE serialnum = '$_REQUEST[serialnum]' ");

    }

    break;


//-----------------------------------------------------------------------------
// 하위로 순서변경
//-----------------------------------------------------------------------------
	case "view_down" :

    // 정보 불러오기
    //$Result  = mysql_fetch_array(mysql_query(" SELECT cateidx , catedepth , parent_catecode FROM odtCategory WHERE serialnum = '$serialnum' "));
	$sql = "
		SELECT cateidx , catedepth , parent_catecode FROM odtCategory WHERE serialnum = '".$_REQUEST[serialnum]."'
	";
	$rs_sum_info = mysql_query($sql);
	$row_sum_info = mysql_fetch_array($rs_sum_info);

    $cateidx = $row_sum_info[cateidx];
    $catedepth = $row_sum_info[catedepth];
    $parent_catecode = $row_sum_info[parent_catecode];

    // 최소 순위  찾기 //////////////////////////////////////////
	$Result  = mysql_fetch_array(mysql_query(" SELECT ifnull(MAX(cateidx),0) as max_cateidx FROM odtCategory WHERE parent_catecode='$parent_catecode' "));
    $maxcateidx = $Result[max_cateidx];

	if ($maxcateidx == $cateidx) {
		error_alt("더 이상 하위로 변경할 수 없습니다.");
    }
    else {

        // 바로 한단계 아래 데이터와 cateidx 값 바꿈
        $sr = mysql_fetch_array(mysql_query("select cateidx , serialnum from odtCategory WHERE parent_catecode='$parent_catecode' and cateidx > '$cateidx' order by cateidx asc limit 1"));

        mysql_query(" UPDATE odtCategory SET cateidx = $cateidx WHERE serialnum='$sr[serialnum]'");

        // 순서값 제거 - 자신의 순서값
        mysql_query(" UPDATE odtCategory SET cateidx = $sr[cateidx] WHERE serialnum = '$_REQUEST[serialnum]' ");

    }

	break;
}


?>