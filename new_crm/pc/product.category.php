<?
include_once "wrap.header.php";

if(!$_COOKIE[AuthID]) alert("로그인 후에 이용해주세요.","login.php");

if(!preg_match("/\bclassify\b/i",$row_authority[authority])){
	alert("권한이 없습니다.","/");
}
?>

<div class="content_section">
	<div class="content_section_fix">
		<script type="text/javascript" src="/skin/pc/js/category.js"></script>
		
		<form name="PUBLIC_FORM" method="post">
		<input type="hidden" name="chk_list2" value="">
		<input type="hidden" name="chk_list3" value="">
		<input type="hidden" name="chk_list4" value="">
		<!-- 검색영역 -->
		<div class="form_box_area">

			<table class="form_TB" summary="검색항목">
				<colgroup>
				<col width="33%"><col width="33%"><col width="33%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col" class="colorset">
							<div class="btn_line_up_center">
								<span class="shop_btn_pack">1차 카테고리</span>
								<span class="shop_btn_pack"><span class="blank_3"></span></span>
								<span class="shop_btn_pack"><input type="button" name="" class="input_small blue" value="추가" onclick="f_add2('1','','list1');"></span>
							</div>
						</th>
						<th scope="col" class="colorset">
							<div class="btn_line_up_center">
								<span class="shop_btn_pack">2차 카테고리</span>
								<span class="shop_btn_pack"><span class="blank_3"></span></span>
								<span class="shop_btn_pack"><input type="button" name="" class="input_small blue" value="추가" onclick="f_add2('2','','list2');"></span>
							</div>
						</th>
						<th scope="col" class="colorset">
							<div class="btn_line_up_center">
								<span class="shop_btn_pack">3차 카테고리</span>
								<span class="shop_btn_pack"><span class="blank_3"></span></span>
								<span class="shop_btn_pack"><input type="button" name="" class="input_small blue" value="추가" onclick="f_add2('3','','list3');"></span>
							</div>
						</th>
					</tr>
				</thead> 
				<tbody> 
					<tr>
						<td class="conts">
							<iframe name="list1" src="product.category.pro.php?depth=1" width="100%" height="400" align="center" marginwidth="0" marginheight="0" scrolling="yes" frameborder="0" style="border:2px solid #c1c1c1;"></iframe>
						</td>
						<td class="conts">
							<iframe name="list2" src="product.category.pro.php?depth=2" width="100%" height="400" align="center" marginwidth="0" marginheight="0" scrolling="yes" frameborder="0" style="border:2px solid #c1c1c1;"></iframe>
						</td>
						<td class="conts">
							<iframe name="list3" src="" width="100%" height="400" align="center" marginwidth="0" marginheight="0" scrolling="yes" frameborder="0" style="border:2px solid #c1c1c1;"></iframe>
						</td>
					</tr>
				</tbody> 
			</table>

		</div>
		<iframe name="list4" src="" width="0" height="0" align="center" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
		<iframe name="set" src="" width="0" height="0" align="center" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>

		<div style="height:30px;"></div>

		</form>
	</div>
</div>

<script>
function f_add2(catedepth,serialnum,framename)
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

    window.open('product.category.pro.php?status=menu_add&catedepth=' + catedepth + '&parent_catecode=' + parent_catecode + '&serialnum=' + serialnum + '&framename=' + framename,'메뉴추가','width=500,height=400,toolbar=no,scrollbars=no,top=0,left=0');
    return rtn_cd;
}

</script>


<?
include_once "wrap.footer.php";
?>