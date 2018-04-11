<?PHP
include_once "include/inc.php";
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="kr" lang="kr" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>통합관리자 페이지</title>
	<link href="/skin/pc/css/adm_style.css" rel="stylesheet" type="text/css" />
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<SCRIPT src="../../include/js/default.js"></SCRIPT>

    <script type="text/javascript" src="/skin/pc/js/category.js"></script>
	<style>body {margin:0; padding:0; background:#fff; min-width:10px; height:90%;}</style>
</head>
<body>
	<input type="hidden" name="check_trigger" value="1"/>
		<!-- 내용 -->
		<div class="content_section">
			<div class="content_section_fix">
	';
//-----------------------------------------------------------------------------
// 1차 카테고리
//-----------------------------------------------------------------------------
if ("1" == $_REQUEST[depth]) {
    echo "
	<div class='content_section_inner'>
		<table class='list_TB' summary='리스트기본'>
			<colgroup><col width='*'/><col width='120px'/></colgroup>
			<tbody>
	";

    $res = mysql_query("select * from odtCategory where catedepth=1 order by cateidx asc , catecode asc");
	while($r = mysql_fetch_array($res)){

		echo "
			<tr>
				<td 
					onClick=\"
						parent.list2.location.href='product.category.pro.php?depth=2&catecode=".$r[catecode]."'; 
						parent.list3.location.href='product.category.pro.php?depth=3&catecode=0';
						parent.list4.location.href='product.category.pro.php?depth=4&catecode=0';
						parent.PUBLIC_FORM.chk_list2.value='".$r[catecode]."';
						parent.PUBLIC_FORM.chk_list3.value='';
						parent.PUBLIC_FORM.chk_list4.value='';
						\$('.app_tr').css('background','#fff');
						\$(this).css('background','#cfcfcf');
					\"
					class='app_tr'
					style='cursor:pointer;text-align:left;'
				>" . $r[catename]."</td>
				<td>
					<div class='btn_line_up_center'>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vup' value='△' data-serialnum='".$r[serialnum]."' data-framename='list1' onClick='return false' alt='상위로 이동'></span>
						<span class='shop_btn_pack'><span class='blank_1'></span></span>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vdown' value='▽' data-serialnum='".$r[serialnum]."' data-framename='list1' onClick='return false' alt='하위로 이동'></span>
						<span class='shop_btn_pack'><span class='blank_1'></span></span>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='수정' onClick=\"f_add2('1', '".$r[serialnum]."', 'list1');\"></span>
					</div>
				</td>
			</tr>
		";
	}

    echo "</tbody></table></div>";
}

//-----------------------------------------------------------------------------
// 2차 코드목록
//-----------------------------------------------------------------------------
if ("2" == $_REQUEST[depth]) {
    $catecode = trim($_REQUEST[catecode]);

    echo "
	<div class='content_section_inner'>
		<table class='list_TB' summary='리스트기본'>
			<colgroup><col width='*'/><col width='120px'/></colgroup>
			<tbody>
	";

    $res = mysql_query(" select * from odtCategory where find_in_set('$catecode',parent_catecode) > 0 and catedepth=2 order by cateidx asc , catecode asc");
    while($r = mysql_fetch_array($res)){

        echo "
			<tr>
				<td
					onClick=\"
						parent.list3.location.href='product.category.pro.php?depth=3&catecode=$r[catecode]'; 
						parent.list4.location.href='product.category.pro.php?depth=4&catecode=0';
						parent.PUBLIC_FORM.chk_list3.value='$r[catecode]';
						parent.PUBLIC_FORM.chk_list4.value='';
						\$('.app_tr').css('background','#fff');
						\$(this).css('background','#cfcfcf');
					\"
					class='app_tr'
					style='cursor:pointer;text-align:left;'
				>" . $r[catename] . "</td>
				<td>
					<div class='btn_line_up_center'>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vup' value='△' data-serialnum='".$r[serialnum]."' data-framename='list2' onClick='return false' alt='상위로 이동'></span>
						<span class='shop_btn_pack'><span class='blank_1'></span></span>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vdown' value='▽' data-serialnum='".$r[serialnum]."' data-framename='list2' onClick='return false' alt='하위로 이동'></span>
						<span class='shop_btn_pack'><span class='blank_1'></span></span>
						<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='수정' onClick=\"f_add2('2', '$r[serialnum]', 'list2');\"></span>
					</div>
				</td>
			</tr>
		";
    }

    echo "</tbody></table></div>";
}


//-----------------------------------------------------------------------------
// 3차 코드목록
//-----------------------------------------------------------------------------
if ("3" == $_REQUEST[depth]) {
    $catecode = trim($_REQUEST[catecode]);
    if($catecode <> 0) {

		echo "
		<div class='content_section_inner'>
			<table class='list_TB' summary='리스트기본'>
				<colgroup><col width='*'/><col width='120px'/></colgroup>
				<tbody>
		";

			$res = mysql_query(" select * from odtCategory where find_in_set('$catecode',parent_catecode) > 0 and catedepth=3 order by cateidx asc , catecode asc");
			while($r = mysql_fetch_array($res)){

            echo "
				<tr>
					<td style='text-align:left;'>" . $r[catename] . "</td>
					<td>
						<div class='btn_line_up_center'>
							<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vup' value='△' data-serialnum='".$r[serialnum]."' data-framename='list3' onClick='return false' alt='상위로 이동'></span>
							<span class='shop_btn_pack'><span class='blank_1'></span></span>
							<span class='shop_btn_pack'><input type='button' name='' class='input_small gray f_vdown' value='▽' data-serialnum='".$r[serialnum]."' data-framename='list3' onClick='return false' alt='하위로 이동'></span>
							<span class='shop_btn_pack'><span class='blank_1'></span></span>
							<span class='shop_btn_pack'><input type='button' name='' class='input_small blue' value='수정' onClick=\"f_add2('3', '$r[serialnum]', 'list3');\"></span>
						</div>
					</td>
				</tr>
            ";
        }
        echo "</tbody></table></div>";
    }
}

?>
<script>
	$('.f_vup').on('click',function(){
		var serialnum = $(this).data('serialnum'), framename = $(this).data('framename');
		//serialnum = 인덱스넘버, framename은 카테고리 depth
		$.post( "product.category.ajax.php", { serialnum: serialnum, framename: framename, status: 'view_up'}); 
		var thisRow = $(this).closest('tr');
		var prevRow = thisRow.prev();
		if (prevRow.length) { prevRow.before(thisRow); } else { alert('더이상 상위로 이동할 수 없습니다.'); }
	});
	$('.f_vdown').on('click',function(){
		var serialnum = $(this).data('serialnum'), framename = $(this).data('framename');
		$.post( "product.category.ajax.php", { serialnum: serialnum, framename: framename, status: 'view_down'}); 
		var thisRow = $(this).closest('tr');
		var nextRow = thisRow.next();
		if (nextRow.length) { nextRow.after(thisRow); } else { alert('더이상 하위로 이동할 수 없습니다.'); }
	});
</script>
<?

// 순서변경 기능 _category.ajax.php 로 이동 // 2014-09-26


//-----------------------------------------------------------------------------
// 메뉴 추가
//-----------------------------------------------------------------------------
if ("menu_add" == $_REQUEST[status]) {
	
    $catedepth = trim($_REQUEST[catedepth]);
    $parent_catecode = trim($_REQUEST[parent_catecode]);

	$subMode = $_REQUEST[serialnum] ? "edt" : "ins";
	if($subMode == "edt") {
		$row = mysql_fetch_array(mysql_query("select * from odtCategory where serialnum = '".$_REQUEST[serialnum] ."'"));
	}
    else {
		$sr = mysql_fetch_array(mysql_query("select ifnull(max(catecode),0) as max_catecode from odtCategory"));
		$row[catecode] = $sr[max_catecode] * 1 + 1;

        // 순위정하기
        if($parent_catecode) {
            $sque = " where find_in_set('${parent_catecode}',parent_catecode) > 0 and catedepth='${catedepth}' ";
        }
        else{
            $sque = " where catedepth='${catedepth}' ";
        }

		$s2r = mysql_fetch_array(mysql_query("select ifnull(max(cateidx),0) as max_cateidx from odtCategory $sque "));
        $row[cateidx] = $s2r[max_cateidx] + 1;

	}


echo "
<form name='PUBLIC_FORM' method='post' action='$PHP_SELF'  enctype='multipart/form-data'>
<input type='hidden' name='status' value='menu_add_tran' />
<input type='hidden' name='catedepth'    value='$catedepth' />
<input type='hidden' name='catecode'    value='$row[catecode]' />
<input type='hidden' name='cateidx'    value='$row[cateidx]' />
<input type='hidden' name='subMode'    value='$subMode' />
<input type='hidden' name='serialnum'    value='$_GET[serialnum]' />
<input type='hidden' name='framename'    value='$_GET[framename]' />


	<!-- 검색영역 -->
	<div class='form_box_area'>

		<table class='form_TB' summary='검색항목'>
			<colgroup><col width='100px'/><col width='*'/></colgroup>
			<tbody> 
    ";

    if( $catedepth > 1 ) {

        // 부모 카테고리 불러오기
        $sque = " select * from odtCategory where catecode='${parent_catecode}' and catedepth='".($catedepth - 1)."'  ";
		$sr=mysql_fetch_array(mysql_query($sque));
		$ex = explode("," , $sr[parent_catecode]);
		$ex[] = $sr[catecode];
		$app_parent_catecode = implode("," , array_filter(array_unique($ex)));
        echo "
			<tr>
				<td class='article'>부모카테고리</td>
				<td class='conts'>$sr[catename]<input type='hidden' name='parent_catecode' value='{$app_parent_catecode}' /></td>
			</tr>
        ";
    }
    else {
        //최상위의 경우 parent_catecode는 0
        echo "<input type='hidden' name='parent_catecode' value='0' />";
    }



    if($row[cHidden] == "no") {
        $cHidden_select1 = "selected";
        $cHidden_select2 = "";
    }
    else {
        $cHidden_select1 = "";
        $cHidden_select2 = "selected";
    }

    echo "
		<tr>
			<td class='article'>카테고리명</td>
			<td class='conts'><input type='text' name='catename' class='input_text' style='width:150px;' value=\"" . $row[catename] . "\" /></td>
		</tr>
		<tr>
			<td class='article'>노출여부</td>
			<td class='conts'>" . _InputSelect( "cHidden" , array("no" , "yes"), $row[cHidden] , "" , array("노출" , "숨김") , "") . "</td>
		</tr>
    ";

    
    echo "
				</tbody> 
			</table>
	</div>

	<!-- 버튼영역 -->
	<div class='bottom_btn_area'>
		<div class='btn_line_up_center'>
			<span class='shop_btn_pack'>
				<input type='button' name='' class='input_large blue' value='저장' onClick='f_add_Save(\"".$row_admin[id]."\")'>
				<input type='button' name='' class='input_large red' value='삭제' onClick='f_add_Del()'>
				<input type='button' name='' class='input_large gray' value='닫기' onClick='self.close();'>
			</span>
		</div>
	</div>
	<!-- 버튼영역 -->

</form>
    ";
    exit;
}



//-----------------------------------------------------------------------------
// 메뉴추가 처리
//-----------------------------------------------------------------------------
if ("menu_add_tran" == $_REQUEST[status]) {

    if( in_array($_REQUEST[subMode] , array("ins" , "edt")) ) {

		if( in_array($$_REQUEST[subMode] , array("ins")) ) {

            // 등록전에 해당 catecode로 등록정보가 있는지 체킹함
			$sr = mysql_fetch_array(mysql_query("select count(*) as cnt from odtCategory where catecode='${catecode}'"));
            if( $sr[cnt] > 0 ) {
				alert("동시에 등록된 다른정보가 있으니 다시한번 등록하시기 바랍니다.");
            }

        }

        $sque = "
				catename				=	'".$_REQUEST[catename]."'
				,catecode				=	'".$_REQUEST[catecode]."'
				,cateidx				=	'".$_REQUEST[cateidx]."'
				,cHidden				=	'".$_REQUEST[cHidden]."'
				,catedepth				=   '".$_REQUEST[catedepth]."'
				,parent_catecode		=   '".$_REQUEST[parent_catecode]."'
		";
    }


	switch( $_REQUEST[subMode] ){

        // 등록
		case "ins" :
			mysql_query(" insert odtCategory set $sque ");
			break;



        // 수정
		case "edt" :
			mysql_query("update odtCategory set $sque where serialnum = '".$_REQUEST[serialnum]."'");
			break;


        // 삭제
		case "del" :

            // 해당 카테고리를 부모로 가진 카테고리 있을 경우 삭제 불가 => 하위카테고리가 있을경우 
            //$sr = mysql_fetch_array(mysql_query("select count(*) as cnt from odtCategory where find_in_set('${catecode}' , parent_catecode) > 0 "));

			$sql = "select count(*) as cnt from odtCategory where find_in_set('".$_REQUEST[catecode]."' , '".$_REQUEST[parent_catecode]."') > 0 ";
			//catecode가 parent_catecode안에 들어있으면 삭제 불가 
			$rs_del_chk = mysql_query($sql);
			$row_del_chk = mysql_fetch_row($rs_del_chk);
			
			$sql = "select count(*) as cnt from odtCategory where parent_catecode like '%".$_REQUEST[catecode]."%'";
			$rs_child_cate = mysql_query($sql);
			$row_child_cate = mysql_fetch_row($rs_child_cate);
			//자식코드 찾기

            if( $row_child_cate[0] > 0 ) {
				alert("하위 카테고리가 있어 삭제할 수 없습니다.");
            }else{
				$sql = " 
					delete from odtCategory where serialnum = '".$_REQUEST['serialnum']."'
				";
				mysql_query($sql);
			}
            break;

    }


    if($framename &&  $_POST[subMode] == "ins") {
        echo "<script>opener.${framename}.location.reload(true);self.close();</script>";
        exit; 
    }
    else {
        echo "<script>opener.location.reload(true);self.close();</script>";
        exit;    
    }

}
?>

<script>

   function f_add2(catedepth,serialnum,framename,mall)
   {
       var rtn_cd = true;
       var parent_catecode = "";

       if( catedepth == 2 ) {
           parent_catecode = parent.document.PUBLIC_FORM.chk_list2.value;
           if( !parent_catecode ) {
               alert('1차 카테고리를 선택하세요.');
               return false;
           }
       }
       else if( catedepth == 3 ) {
           parent_catecode = parent.document.PUBLIC_FORM.chk_list3.value;
           if( !parent_catecode ) {
               alert('2차 카테고리를 선택하세요.');
               return false;
           }
       }

       window.open('product.category.pro.php?status=menu_add&mall='+mall+'&catedepth=' + catedepth + '&parent_catecode=' + parent_catecode + '&serialnum=' + serialnum + '&framename=' + framename,'메뉴추가','width=500,height=400,toolbar=no,scrollbars=no,top=0,left=0');
       return rtn_cd;
   }

</script>