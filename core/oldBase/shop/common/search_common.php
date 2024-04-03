<?		
function SearchDetail($path)
{	
	global $brand,$category, $search_str, $sprice, $eprice;
	return "			<form name=searchform action='search_detail.php'>
					<table cellpadding=5 border=0 cellspacing=0 width=100% align=center background='/shop/img/search_bg.gif' style='background-repeat:no-repeat;background-position: 0% 0%'>
					<tr height=40>
						<td colspan=4 style='padding-left:10px;'><img src='/shop/img/title_searchdetail.gif' align=absmiddle><b style='color:gray'>조건별 제품검색</b> 검색어를 입력하시면 필요한 정보를 빠르게 보실수 있습니다.</td>
					</tr>
					<tr>
						<td width=100></td><td width=180><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>검색어 입력</b></td><td width=250><input type='text' name='search_str' value='$search_str'></td><td width=300 rowspan=8 valign=middle align=center><input type='image' src='/shop/img/search_go.gif' style='border:0px;'></td>
					</tr>
					<tr height=1><td></td><td colspan=2 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>
					<tr>
						<td></td><td><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>카테고리선택</b></td><td>".CategoryList(0,"",$category)."</td>
					</tr>
					<tr height=1><td></td><td colspan=2 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>
					<tr>
						<td></td><td><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>브랜드</b></td><td>".BrandList($brand)."</td>
					</tr>
					<tr height=1><td></td><td colspan=2 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>
					<tr>
						<td></td><td><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>가격대</b></td><td><input type='text' name='sprice' size=12 value='$sprice'> ~ <input type='text' name='eprice' size=12 value='$eprice'></td>
					</tr>
					<tr height=1><td></td><td colspan=2 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>
					</table>
					</form>
					";
					
}


function SearchAuto($path,$search_id="")
{
	global $brand,$category, $search_str, $sprice, $eprice;
	return "			
					<table cellpadding=5 border=0 cellspacing=0 width=100% align=center background='/shop/img/search_bg.gif' style='background-repeat:no-repeat;background-position: 0% 0%'>
					<tr height=40>
						<td colspan=4 style='padding-left:10px;' nowrap><img src='/shop/img/title_auto.gif' align=absmiddle><b style='color:gray'>이런제품이 필요하세요?</b> 여러분을 위해 제안합니다.</td>
					</tr>
					<form name=searchform1 action='search_well.php'>
					<tr>
						<td width=10 rowspan=12></td><td width=480 colspan=4><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>[영상촬영장비] 나의 맞춤상품은? &nbsp;&nbsp;</b><b style='color:purple;cursor:hand' onclick='document.searchform1.submit();'>▶ 검색하기 </b></td><td width=50 rowspan=5></td>
					</tr>					
					<tr>
						<td style='padding-left:20px;'>".CategoryList(1,"000000000000000",$category)." </td><td>".UseSelect($selectUse)."</td><td>".BrandList($brand)."</td><td>".PriceSelect($selectPrice)."</td>
					</tr>
					</form>
					<tr height=1><td colspan=4 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>
					<form name=searchform2 action='search_well.php'>
					<tr>
						<td width=480 colspan=4><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>[영상편집장비] 나의 맞춤상품은? &nbsp;&nbsp;</b><b style='color:purple;cursor:hand' onclick='document.searchform2.submit();'>▶ 검색하기 </b></td>
					</tr>
					<tr>
						<td style='padding-left:20px;'>".CategoryList(1,"001000000000000",$category)." </td><td>".UseSelect($selectUse)."</td><td>".BrandList($brand)."</td><td>".PriceSelect($selectPrice)."</td>
					</tr>
					</form>
					<tr height=1><td colspan=4 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr>					
					<tr>
						<td width=480 colspan=4><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray'>[CD/DVD 제작] 나의 맞춤상품은? &nbsp;&nbsp;</b></td>
					</tr>
					<tr><td style='padding-left:20px;' colspan=4>".search_list($search_id)." </td></tr>					
					<!--tr height=1><td></td><td colspan=4 background='/img/dot.gif' style='background-repeat:repeat-x;'></td></tr-->
					</table>";
	
}

function search_list($search_id=""){
$listdb = new Database;

$listdb->query("SELECT *  FROM myshopping order by vieworder asc limit 0,10");

	$mstr = "	<table cellpadding=0 cellspacing=0 bgcolor=#ffffff width=100% align=center>";
				
	
	for($i=0;$i < $listdb->total;$i++){
	$listdb->fetch($i);
	if($search_id == $listdb->dt[id]) {$strStyle="style='font-weight:bold;color:purple'";} else {$strStyle="";};		
	$mstr = $mstr."		<tr height=26>
					<td $strStyle >".($i+1).". ".$listdb->dt[myshopping_desc]." <a href='/shop/search_well.php?search_id=".$listdb->dt[id]."'><b style='color:purple'>▶ 검색하기 </b></a></td>
				</tr>										
				<tr height=1><td background='/img/dot.gif' colspan=2></td></tr>";
	}
	
	$mstr = $mstr."  </table>";
	
	return $mstr;
	
}

function SearchCompare($path)
{
	global $HISTORY;
	$mstring = "			<table cellpadding=5 border=0 cellspacing=0 width=100% align=center background='/shop/img/search_bg.gif' style='color:gray;background-repeat:no-repeat;background-position: 0% 0%'>
					<tr >
						<td colspan=5 style='padding-left:10px;'><img src='/shop/img/title_compare.gif' align=absmiddle><b style='color:gray'>오늘본 제품 ".count($HISTORY)." 개</b> 같은 카테고리의 제품 중 3개까지 비교가 가능합니다.</td>
					</tr>";		
	if(count($HISTORY)==0){
		$mstring .= "		<tr height=50>
						<td width=10></td><td width=580 colspan=4 align=center><b>쇼핑내역이 없습니다.</b></td>
					</tr>
					</table>";
	}else{
		$mstring .= "		<tr>
						<td width=10></td><td width=580 colspan=4 align=left>".HistoryDisplay('000000000000000')."</td>
					</tr>
					<tr>
						<td width=10></td><td width=580 colspan=4 align=left>".HistoryDisplay('001000000000000')."</td>
					</tr>
					<tr>
						<td width=10></td><td width=580 colspan=4 align=left>".HistoryDisplay('002000000000000')."</td>
					</tr>
					<tr>
						<td width=10></td><td width=580 colspan=4 align=left>".HistoryDisplay('003000000000000')."</td>
					</tr>
					<tr>
						<td width=10></td><td width=580 colspan=4 align=left>".HistoryDisplay('004000000000000')."</td>
					</tr>
					</table>";
	}
	
	return $mstring;
	
}


function HistoryDisplay($vcid){
	global $HISTORY;
					
if ($HISTORY)
{	
	
	$sum = 0;
	$num = count($HISTORY);
	$disp_id = 1;
	
	$mContents = "		<table cellpadding=5 cellspacing=0 border=0 bgcolor=#ffffff>
				<tr>
					<td width=530 colspan=4 align=left><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray;'> ".GetThisCategory($vcid,0)."</b> <b style='color:purple;cursor:hand' onclick=\"CompareSubmit(document.c$vcid);\"><제품비교하기></b></td>
				</tr>
				</table>
				<table cellpadding=5 cellspacing=0 border=0 bgcolor=#ffffff>
				<tr>
				<script >
				function CompareSubmit(frm)
				{
				var true_num=0;	
					
					for(i=0;i<frm.elements.length;i++){
						if(frm.elements[i].checked)
							true_num = true_num + 1;
					}
					
					if(true_num < 3){
						alert('같은 카테고리에서 비교할 제품이 2개 이상 선택되어야 합니다.');
					}else{ 
						PoPWindow('prd_compare.php',820,800,'comparewindow');
						frm.submit();
					}
				}
				</script>
				<form name='c$vcid' action='prd_compare.php' method=get target='comparewindow'>
				";
	
	$mContents = $mContents."<tr height=80>";
	for ( reset($HISTORY); $key = key($HISTORY); next($HISTORY) )
	{
			
		$value = pos($HISTORY);
		$cid = $value[0];	
		$pname = $value[1];		
		$price = $value[2];
		
		$total = $price * $count;
		$sum += $total;
		
		if (substr($vcid,0,3) == substr($cid,0,3)){
		$mContents = $mContents."<td align=center  valign=top width=110>
						<table cellpadding=0 cellspacing=0 border=0 height=100%>
						<tr>
						    <td nowrap align='center'><a href='/pinfo.php?cid=$cid&id=".$key."'><img src='/shop/images/product/c_".$key.".gif' border=0 width=50 align=absmiddle> </a></td>
						</tr>
						<tr>
						    <td><div align='center'>".$pname."</div></td>
						</tr>
						<tr>
						    <td align='center'>".number_format($price)." <input type='checkbox' name='pid[]' style='border:0px;' value=$key></td>
						</tr>
						</table>
					</td>";
			if($disp_id != 1 && $disp_id%5 ==0){
			$mContents = $mContents."</tr><tr height=80>";	
			}
		$disp_id++;
		}
		$num--;
	}
	$mContents = $mContents."</form></tr>";
	
	if ($disp_id == 1){
	return "";
	$mContents = $mContents." <tr height=50>
				    <td align='center' style='padding-left:100px;'>상품조회 내역이 없습니다.</td>
				  </tr>
				  ";
	}
	unset($disp_id);
	
}else{
	
			
	$mContents = $mContents."<table cellpadding=0 cellspacing=0>
				<tr>
					<td width=530 colspan=4 align=left><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray;'> ".GetThisCategory($vcid,0)."</b> <b style='color:purple;cursor:hand' onclick='document.c$vcid.submit();'><제품비교하기></b></td>
				</tr>
			  	<tr height=50>
				    <td colspan='6' align='center'>쇼핑내역이 없습니다.</td>
				  </tr>
				  <tr height=1><td background='/img/dot.gif' colspan=6></td></tr>
				  ";
					
}				
	$mContents = $mContents."</table>";
	return 	$mContents;			
}


function RightHistoryDisplay(){
	global $HISTORY;
					
					
if ($HISTORY)
{	
	
	$sum = 0;
	$num = count($HISTORY);
	$disp_id = 1;
	
	$mContents = "
				<script >
				function CompareSubmit(frm)
				{
				var true_num=0;	
					
					for(i=0;i<frm.elements.length;i++){
						if(frm.elements[i].checked)
							true_num = true_num + 1;
					}
					
					if(true_num < 3){
						alert('같은 카테고리에서 비교할 제품이 2개 이상 선택되어야 합니다.');
					}else{ 
						PoPWindow('prd_compare.php',820,800,'comparewindow');
						frm.submit();
					}
				}
				</script>	
				<table cellpadding=2 cellspacing=0 border=0 >
				<form name='c$vcid' action='prd_compare.php' method=get target='comparewindow'>
				";
	
	$mContents = $mContents."<tr height=80>";
	for ( reset($HISTORY); $key = key($HISTORY); next($HISTORY) )
	{
			
		$value = pos($HISTORY);
		$cid = $value[0];	
		$pname = $value[1];		
		$price = $value[2];
		
		$total = $price * $count;
		$sum += $total;
		
		
		$mContents = $mContents."
					<tr>
					<td align=center  valign=top width=110>
						<table cellpadding=0 cellspacing=0 border=0 height=100%>
						<tr>
						    <td nowrap align='center'><a href='/pinfo.php?cid=$cid&id=".$key."'><img src='/shop/images/product/c_".$key.".gif' border=0 width=50 align=absmiddle> </a></td>
						</tr>
						<!--tr>
						    <td><div align='center'>".$pname."</div></td>
						</tr-->
						<tr>
						    <td align='center'>".number_format($price)." <input type='checkbox' name='pid[]' style='border:0px;' value=$key></td>
						</tr>
						</table>
					</td></tr>";
		if($disp_id == 5){
			break;
		}
		
		$disp_id++;
			
		$num--;
	}
	$mContents = $mContents."</form>";
/*	
	if ($disp_id == 1){
	return "";
	$mContents = $mContents." <tr height=50>
				    <td align='center' style='padding-left:100px;'>상품조회 내역이 없습니다.</td>
				  </tr>
				  ";
	}
	
	unset($disp_id);
*/	
}else{
	
			
	$mContents = $mContents."<table cellpadding=0 cellspacing=0>
				<tr>
					<td width=530 colspan=4 align=left><img src='/shop/img/silver_mpoint.gif' align=absmiddle><b style='color:gray;'> ".GetThisCategory($vcid,0)."</b> <b style='color:purple;cursor:hand' onclick='document.c$vcid.submit();'><제품비교하기></b></td>
				</tr>
			  	<tr height=50>
				    <td colspan='6' align='center'>쇼핑내역이 없습니다.</td>
				  </tr>
				  <tr height=1><td background='/img/dot.gif' colspan=6></td></tr>
				  ";
					
}				
	$mContents = $mContents."</table>";
	return 	$mContents;			
}



function ProductList($listtype,$category_id,$depth,$brand = "",$search_str = "",$sprice="",$eprice=""){
global $db, $user;
global $start,$page;
global $search_id;

$max = 10;

if ($page == ''){
	$start = 0;
	$page  = 1;
}else{
	$start = ($page - 1) * $max;
}
if($depth == 0){	
	if ($listtype == "search"){
		if($search_str != ""){
			$where = $where." and p.pname LIKE '%".$search_str."%'";	
		}
		if($category_id != ""){
			$where = $where." and r.cid LIKE '".substr($category_id,0,3)."%'";
		}
		if ($brand != ""){
			$where = $where." and brand = '".$brand."'";
		}
		if ($sprice != "" && $eprice != ""){
			$where = $where." and  sellprice between ".$sprice." and $eprice";
		}
		if($where == ""){
			$where = $where." and p.pname = ''";
		}
		$db->query("SELECT distinct p.id, p.pname, p.shotinfo, p.reserve, p.noninterest FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 $where");
		
	
	}else if ($listtype == "search_auto"){	
		$db->query("SELECT distinct p.id, p.pname, p.shotinfo, p.reserve, p.noninterest FROM ".TBL_SHOP_PRODUCT." p, search_relation r where r.pid = p.id and p.disp = 1 and r.search_id = '".$search_id."'");
	}else{
		$db->query("SELECT distinct p.id, p.pname, p.shotinfo, p.reserve, p.noninterest FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,3)."%'");
	}
	
}else if($depth == 1){
	if ($listtype == "search"){
		
		if($search_str != ""){
			$where = $where." and p.pname LIKE '%".$search_str."%'";	
		}
		if($category_id != 0){
			$where = $where." and r.cid LIKE '".substr($category_id,0,3)."%'";
		}
		if ($brand != 0){
			$where = $where." and brand = '".$brand."'";
		}
		if ($sprice != "" && $eprice != ""){
			$where = $where." and sellprice = ".$sprice." and $eprice";
		}
		if($where == ""){
			$where = $where." and p.pname = ''";
		}
		
		$db->query("SELECT distinct p.id FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and p.pname LIKE '%".$search_str."%' $where");
		
	
	}else{
		$db->query("SELECT distinct p.id FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,6)."%'");		
	}
}else if($depth == 3){	
		$db->query("SELECT distinct p.id FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,12)."%'");
}

$ptotal = $db->total;

	$vContents =	"	<table width='650'><tr height=30><td align=left style='padding-left:10px'><img src='/img/title_product_list.gif'></td></tr></table>
				<table cellpadding=0 cellspacing=0 bgcolor=#ffffff width=650 align=center>
				<tr height=2 bgcolor=silver><td colspan=6></td></tr>";
	if ($listtype == "search"){
	$pagestring = page_bar($ptotal, $page, $max, $listtype,$search_str,$PHP_SELF);
	$vContents = $vContents."<tr>
					<td colspan=6>
					<table cellpadding=0 cellspacing=0 border=0 width='100%'>
						<tr height=30 bgcolor='#efefef' align=center>
							<td colspan=2 align=left style='padding-left:10px;'>총 ".$db->total." 개 제품이 있습니다.</td>				
							<td colspan=2>".$pagestring."</td>
							<td colspan=2 align=right nowrap><!--a href='$PHP_SELF?cid=$category_id&depth=$depth'><img src='/shop/img/viewlist.gif' border=0></a> <a href='$PHP_SELF?cid=$category_id&depth=$depth&listtype=catalog'><img src='/shop/img/viewcatalog.gif' border=0></a--></td>
						</tr>
					</table>
					</td>
				</tr>
				
				";
	}else{
	$pagestring = page_bar($ptotal, $page, $max, $listtype,$search_str,$PHP_SELF);
	$vContents = $vContents."
				<tr>
					<td colspan=6>
					<script >
					function CompareSubmit(frm)
					{
					var true_num=0;	
						
						for(i=0;i<frm.elements.length;i++){
							if(frm.elements[i].checked)
								true_num = true_num + 1;
						}
						
						if(true_num < 3){
							alert('같은 카테고리에서 비교할 제품이 2개 이상 선택되어야 합니다.');
						}else{ 
							PoPWindow('prd_compare.php',820,800,'comparewindow');
							frm.submit();
						}
					}
					</script>
					<form name='c001000000000000' action='prd_compare.php' method=get target='comparewindow'>
					<table cellpadding=0 cellspacing=0 border=0 width='100%'>
						<tr height=30 bgcolor='#efefef' align=left>
							<td onclick='CompareSubmit(document.c001000000000000);' style='cursor:hand'><img src='/shop/img/check01.gif' border=0></td>
							<td colspan=2 align=left style='padding-left:10px;'>총 ".$db->total." 개 제품이 있습니다.</td>				
							<td colspan=2>".$pagestring."</td>
							<td colspan=2 align=right  nowrap><a href='$PHP_SELF?cid=$category_id&depth=$depth'><img src='/shop/img/viewlist.gif' border=0></a> <a href='$PHP_SELF?cid=$category_id&depth=$depth&listtype=catalog'><img src='/shop/img/viewcatalog.gif' border=0></a></td>
						</tr>
					</table>
					</td>
				</tr>
				";
	}
				
	$vContents = $vContents."<tr align=center >
					<td width=32 style='border-right:1px solid gray;border-left:1px solid gray;font-size:13px;'><input type=checkbox class=nonborder checked disabled></td>				
					<td width=107 style='border-right:1px solid gray;font-size:13px;'>이미지</td>
					<td width=277 style='border-right:1px solid gray;font-size:13px;'>제품명</td>
					<td width=94 style='border-right:1px solid gray;font-size:13px;'>가격</td>
					<td width=73 style='border-right:1px solid gray;font-size:13px;' nowrap>무이자/적립금</td>
					<td width=77 style='border-right:1px solid gray;font-size:13px;'>쇼핑카트</td>
				</tr>
				";
	
	
if ($db->total){
	if($depth == 0){			
		if ($listtype == "search"){
			
			if($search_str != ""){
				$where = $where." and p.pname LIKE '%".$search_str."%'";	
			}
			if($category_id != ""){
				$where = $where." and r.cid LIKE '".substr($category_id,0,3)."%'";
			}
			if ($brand != ""){
				$where = $where." and brand = '".$brand."'";
			}
			if ($sprice != "" && $eprice != ""){
				$where = $where." and  sellprice between ".$sprice." and $eprice";
			}
			if($where == ""){
				$where = $where." and p.pname = ''";
			}
			
			$db->query("SELECT distinct(p.id), p.pname, p.shotinfo, p.reserve, p.new, p.hot, p.event, p.noninterest,p.sellprice, p.prd_member_price, p.prd_dealer_price, p.prd_agent_price, p.recomm_saveprice,  p.state, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 $where order by vieworder2 asc");
			
			
		}else if ($listtype == "search_auto"){	
			$db->query("SELECT distinct p.id, p.pname, p.shotinfo, p.reserve,  p.new, p.hot, p.event, p.noninterest,p.sellprice, p.prd_member_price, p.prd_dealer_price, p.prd_agent_price, p.recomm_saveprice,  p.state, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, search_relation r where r.pid = p.id and p.disp = 1 and r.search_id = '".$search_id."' order by vieworder2 asc");
		
		}else{
			$db->query("SELECT distinct(p.id), p.pname, p.shotinfo, p.reserve,  p.new, p.hot, p.event, p.noninterest,p.sellprice, p.prd_member_price, p.prd_dealer_price, p.prd_agent_price, p.recomm_saveprice,  p.state, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,3)."%' order by vieworder2 asc  LIMIT $start, $max");			
		}
	}else if($depth == 1){		
		$db->query("SELECT distinct(p.id), p.pname, p.shotinfo, p.reserve,  p.new, p.hot, p.event, p.noninterest,p.sellprice, p.prd_member_price, p.prd_dealer_price, p.prd_agent_price, p.recomm_saveprice,  p.state, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,6)."%' order by vieworder2 asc LIMIT $start, $max");
	}else if($depth == 3){
		$db->query("SELECT distinct(p.id), p.pname, p.shotinfo, p.reserve,  p.new, p.hot, p.event, p.noninterest,p.sellprice, p.prd_member_price, p.prd_dealer_price, p.prd_agent_price, p.recomm_saveprice,  p.state, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and p.disp = 1 and r.cid LIKE '".substr($category_id,0,12)."%' order by vieworder2 asc LIMIT $start, $max");		
	}
	$before_pid = -1;
	for ($i = 0; $i < $db->total; $i++)
	{
		$db->fetch($i);
		
		if ($db->dt["new"] == 1){
			$option = "<img src='/shop/img/icon_new.gif' border=0> ";
		}
		if ($db->dt[hot] == 1){
			$option = $option."<img src='/shop/img/icon_hot.gif' border=0> ";
		}
		
		if ($db->dt[event] == 1){
			$option = $option."<img src='/shop/img/icon_event.gif' border=0> ";
		}
		
		
		
		if($db->dt[state] == 0){
			$strState = "<b style='color:gray'>".($db->dt[sellprice] == 0 ? "문의 요망": DisplayRecommendPrice(DispalyProductPrice($db, "number"),$db->dt[recomm_saveprice])." 원")." </b><br><font color=red>일시품절</font>";
			$StateJavaScript = "JavaScript:alert('".$db->dt[pname]." 은 일시품절 상품 입니다.');";
		}else{			
			$strState = "<b>".($db->dt[sellprice] == 0 ? "문의 요망": DisplayRecommendPrice(DispalyProductPrice($db, "number"),$db->dt[recomm_saveprice])." 원")."</b> ";
			$StateJavaScript = "cart.php?act=add&id=".$db->dt[id]."&pcount=1";			
		}	
		
		if($user[code] == "fdda2172ef21c39c1db15f402cf5c50d"){				
			$StateJavaScript = "JavaScript:alert('시민기자 아이디는 여러명이 함께쓰는 아이디입니다. 개인정보 보호를 위해 회원가입후 제품을 구매해 주시기 바랍니다.');";
		}
		
		if($before_pid != $db->dt[id]){
		//$before_pid = $db->dt[id];
		$mrid = ReturnRid($db->dt[id],$category_id);
		$vContents = $vContents."	<tr bgcolor='#ffffff' height=100>
						<td align=center><input type=checkbox class=nonborder name='pid[]' value='".$db->dt[id]."'></td>
						<!--td nowrap><a href='product_input.php?id=".$db->dt[id]."'>".$db->dt[id]."</a></td-->
						<td ><a href='/pinfo.php?id=".$db->dt[id]."&cid=".$category_id."'><img src='/shop/images/product/s_".$db->dt[id].".gif' border=0></a></td>
						<td><a href='/pinfo.php?id=".$db->dt[id]."&cid=".$category_id."'><b>".$db->dt[pname]."</b><br>".$db->dt[shotinfo]."<br>".$option."</a></td>
						<td align=center>".$strState."</td>
						<td align=left style='line-height:150%'><img src='/shop/img/smallicon_reserve.gif' align=absmiddle> ".$db->dt[reserve]."<br><br><img src='/shop/img/smallicon_mu.gif' align=absmiddle> ".$db->dt[noninterest]."</td>
						<td align=center><a href=\"".$StateJavaScript."\"><img src='/shop/img/gocart.gif' border=0 align=absmiddle ></a> </td>
					</tr>
					<tr height=1><td colspan=6 background='/img/dot.gif'></td></tr>";
		}
		unset($option);
	}
	$vContents = $vContents."	<tr bgcolor='#efefef' height=28><td align=center colspan=6>".$pagestring."</td></tr>";
}else{
		$vContents = $vContents."	<tr bgcolor='#ffffff' height=50><td align=center colspan=6>등록된 상품이 없습니다.</td></tr>
						<tr height=1><td colspan=6 background='/img/dot.gif'></td></tr>";
}

	$vContents = $vContents."</form></table>";
	
	return $vContents;
}



function page_barx($total, $page, $max)
{
	$page_string;

	if ($total % $max > 0)
	{
		$total_page = floor($total / $max) + 1;
	}
	else
	{
		$total_page = floor($total / $max);
	}

	$next = $page + 1;
	$prev = $page - 1;

	if ($total)	{
		$prev_mark = ($prev > 0) ? "<a href='plist.php?page=$page'>◀</a> " : " &nbsp;◁ ";
		$next_mark = ($next <= $total_page) ? "<a href='plist.php?page=$next'> ▶</a> " : " &nbsp;▷";
	}

	$page_string = $prev_mark;

	for ($i = $page - 5; $i <= $page + 5; $i++)
	{
		if ($i > 0)
		{
			if ($i <= $total_page)
			{
				if ($i != $page){
					$page_string = $page_string.(" <a href=plist.php?page=$i>$i</a> &nbsp;");
				}else{
					$page_string = $page_string.("<font color=#FF0000>$i</font> &nbsp;");
				}
			}
		}
	}

	$page_string = $page_string.$next_mark;
	
	return $page_string;
}



function ProductCatalog($category_id,$depth,$search_str = "")
{
	global $db,$bid,$page,$start,$listtype;
	
	
	$max = 16;

	if ($page == '')
	{
		$start = 0;
		$page  = 1;
	}
	else
	{
		$start = ($page - 1) * $max;
	}	
	if($depth == 1){		
		if ($search_str == ""){
			$db->query("SELECT * FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,6)."%' and p.disp = 1");
		}else{
			$db->query("SELECT * FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (p.pname like '%$search_str%' or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1");			
		}	
		
	}elseif($depth == 0){
		if ($search_str == ""){			
			$db->query("SELECT * FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,3)."%' and p.disp = 1");
		}else{
			$db->query("SELECT distinct p.id, p.pname, p.shotinfo,p.sellprice FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (r.cid LIKE '".substr($category_id,0,3)."%'  or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1");
		}
	}elseif($depth == 3){
		if ($search_str == ""){			
			$db->query("SELECT * FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,12)."%' and p.disp = 1");
		}else{
			$db->query("SELECT distinct p.id, p.pname, p.shotinfo,p.sellprice FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (r.cid LIKE '".substr($category_id,0,12)."%'  or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1");
		}
	}
	
	$total_cnt = $db->total;
	
	if ($db->total){
		if($depth == 1){
			if ($search_str == ""){
				if ($listtype == "favorite"){
					$favorite_Select = " selected";
					$db->query("SELECT distinct p.* FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,6)."%' and p.disp = 1 order by viewcnt desc  LIMIT $start, $max");
				}else{
					$db->query("SELECT distinct p.*,case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,6)."%' and p.disp = 1 order by vieworder2 LIMIT $start, $max");
				}
			}else{
				
					$db->query("SELECT distinct p.*, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (p.pname like '%$search_str%' or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1 order by vieworder2");
			}		
			
		}elseif($depth == 0){	
			if ($search_str == ""){
				if ($listtype == "favorite"){
					$favorite_Select = " selected";
					$db->query("SELECT distinct p.* FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,3)."%' and p.disp = 1 order by viewcnt desc  LIMIT $start, $max");					
				}else{
					$db->query("SELECT distinct p.*,case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,3)."%' and p.disp = 1 order by vieworder2 LIMIT $start, $max");					
				}
			}else{
					$db->query("SELECT distinct p.*, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (p.pname like '%$search_str%' or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1 order by vieworder2");
			}	
			
		}elseif($depth == 3){	
			if ($search_str == ""){
				if ($listtype == "favorite"){
					$favorite_Select = " selected";
					$db->query("SELECT distinct p.* FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,12)."%' and p.disp = 1 order by viewcnt desc  LIMIT $start, $max");					
				}else{
					$db->query("SELECT distinct p.*,case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,12)."%' and p.disp = 1 order by vieworder2 LIMIT $start, $max");					
				//	echo("SELECT distinct p.*,case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and r.cid LIKE '".substr($category_id,0,12)."%' and p.disp = 1 order by vieworder2 LIMIT $start, $max");
				}
			}else{
					$db->query("SELECT distinct p.*, case when p.vieworder = 0 then 100000 else p.vieworder end as vieworder2 FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_PRODUCT_RELATION." r where r.pid = p.id and (p.pname like '%$search_str%' or p.shotinfo like '%$search_str%' or p.basicinfo like '%$search_str%') and p.disp = 1 order by vieworder2");
			}	
			
		} 
	
	$pagestring = page_bar($total_cnt, $page, $max,$listtype,$search_str,$PHP_SELF);	
	$m_brand_string = "<table cellpadding=0 cellspacing=0 border=0 width=660>
				<!--tr height=2 bgcolor=silver><td colspan=6></td></tr>
				<tr>
					<td colspan=4>
					<table cellpadding=0 cellspacing=0 width=100%>
					<tr height=30 bgcolor='#efefef' align=center>
						<td>총 ".$total_cnt." 개 제품이 있습니다.</td>				
						<td width=50% colspan=2>".$pagestring."</td>
						<td nowrap><a href='plist.php?cid=$category_id&depth=$depth'><img src='/shop/img/viewlist.gif' border=0></a> <a href='plist.php?cid=$category_id&depth=$depth&listtype=catalog'><img src='/shop/img/viewcatalog.gif' border=0></a></td>
					</tr>
					</table>
					</td>
				</tr-->				
				<tr height=20><td colspan=3></td></tr>
				";
		
		for ($i = 0; $i < $db->total; $i++)
		{
			$db->fetch($i);
			
			if ($db->dt["new"] == 1){
			//	$option = "<img src='/shop/img/icon_new.gif' border=0 align=absmiddle> ";
			}
			if ($db->dt[hot] == 1){
			//	$option = $option."<img src='/shop/img/icon_hot.gif' border=0 align=absmiddle> ";
			}
			
			if ($db->dt[event] == 1){
			//	$option = $option."<img src='/shop/img/icon_event.gif' border=0 align=absmiddle> ";
			}
			
			if($db->dt[state] == 0 || $db->dt[stock] == 0){
				$option = $option."<font color=red>sold out</font>";				
			}else{
				$option = $option."";
			}	
			
			//$option2 = "<img src='/shop/img/smallicon_mu.gif'> ".$db->dt[noninterest]." <img src='/shop/img/smallicon_reserve.gif'> ".$db->dt[reserve];
			
			if (($i % 4 == 0) && ($i != 0)){
				$m_brand_string = $m_brand_string."</tr>\n<tr>";
			}
			if (($i % 4 != 0) && ($i != 0)){
				$m_brand_string = $m_brand_string."	\n";
			}
				$m_brand_string = $m_brand_string."	<td valign=top align=center>".ProductStyle01($db->dt[id],$category_id,$db->dt[pname],DispalyProductPrice($db, "number"),$option,$option2)."</td>\n";	
			
			$option = "";
			$option2 = "";
		}
		
		if (($i % 4 == 0)){
			$m_brand_string = $m_brand_string."</tr>\n";
		}else{
			if ($i % 4 == 1){	
				$m_brand_string = $m_brand_string."\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>";
			}elseif ($i % 4 == 2){
				$m_brand_string = $m_brand_string."\n<td>&nbsp;</td>\n<td>&nbsp;</td>\n</tr>";
			}elseif ($i % 4 == 3){
				$m_brand_string = $m_brand_string."\n<td>&nbsp;</td>\n</tr>";
			}
		}
	
			
	
	$m_brand_string = $m_brand_string."	<tr bgcolor='#efefef' height=30><td align=center colspan=6>".$pagestring."</td></tr>";
	$m_brand_string = $m_brand_string."</table>";
			
		
	
	}else{
	$m_brand_string = "<table cellpadding=0 cellspacing=0 border=0 height=300  width=600>";
	$m_brand_string = $m_brand_string."	<tr bgcolor='#ffffff' height=50><td align=center colspan=6>nothing found.</td></tr>";
	$m_brand_string = $m_brand_string."</table>";		
	}
	
	
		
		return $m_brand_string;
}


function ProductStyle01($id,$cid,$pname,$price,$option,$option2){

	$m_string = "	<table cellpadding=3 cellspacing=0 width=140 border=0>
				<tr><td align=center><a href='./pinfo.php?id=$id&cid=$cid'><img src='/shop/images/product/ms_$id.gif' alt='".str_replace("<br>","",$pname)."'  border=0></a></td></tr>
				<tr><td align=center><a href='./pinfo.php?id=$id&cid=$cid'>$pname <br>$option</a></td></tr>
				<tr><td style='padding-bottom:10px;' align=center><b>".($price == 0 ? "문의 요망": number_format($price,0)." 원")."</b> ".$option2."</td></tr>
			</table>";
	return $m_string;
	
}

function page_bar($total, $page, $max,$listtype="",$search_str="",$link_URL="plist.php")
{
	if ($listtype == "search"){
		return "";	
	}
	
	$page_string;
	global $cid,$depth;

	if ($total % $max > 0)
	{
		$total_page = floor($total / $max) + 1;
	}
	else
	{
		$total_page = floor($total / $max);
	}

	$next = $page + 1;
	$prev = $page - 1;

	if ($total)
	{
		$prev_mark = ($prev > 0) ? "<a href='$link_URL?page=$page&cid=$cid&depth=$depth&listtype=$listtype'><img src='/img/btn_pre.gif' border=0 align=absmiddle></a> " : "<img src='/img/btn_pre_off.gif' border=0 align=absmiddle> ";
		$next_mark = ($next <= $total_page) ? "<a href='$link_URL?page=$next&cid=$cid&depth=$depth&listtype=$listtype'><img src='/img/btn_next.gif' border=0 align=absmiddle></a>" :  " <img src='/img/btn_next_off.gif' border=0 align=absmiddle>";
	}

	$page_string = $prev_mark;

	for ($i = $page - 5; $i <= $page + 5; $i++)
	{
		if ($i > 0)
		{
			if ($i <= $total_page)
			{
				if ($i != $page)
				{
					$page_string = $page_string.(" <a href=$link_URL?page=$i&cid=$cid&depth=$depth&listtype=$listtype> $i </a> | ");
				}
				else
				{
					$page_string = $page_string.("<font color=#FF0000>$i</font>");
				}
			}
		}
	}

	$page_string = $page_string.$next_mark;
	
	return $page_string;//." <a href=plist.php?page=$i&cid=$cid&depth=$depth&listtype=all>view all</a>";
}



function SortBy($select,$category_id,$depth){
	
if ($select == "catalog"){
	$catalog_Select = " selected";
}elseif($select == "list"){	
	$list_Select = " selected";
}elseif($select == "favorite"){
	$favorite_Select = " selected";
}elseif($select == "new"){
	$new_Select = " selected";
}elseif($select == "bundle"){
	$bundle_Select = " selected";
}elseif($select == "gift"){
	$gift_Select = " selected";
}elseif($select == "lowtohigh"){
	$LowToHigh_Select = " selected";
}elseif($select == "hightolow"){
	$HighToLow_Select = " selected";
}


$sort_string = "<font style='color:#BD7A9D'>sort results by </font>
			<select name='listtype' align=absmiddle onchange=\"document.location.href='/plist.php?cid=$category_id&depth=$depth&listtype='+this.value\">
				<option value='catalog' ".$catalog_Select.">catalog view</option>
				<!--option value='list' ".$list_Select.">list view</option-->
				<option value='favorite' ".$favorite_Select.">favorite view</option>
				<!--option value='new' ".$new_Select.">new ".TBL_SHOP_PRODUCT." view</option>
				<option value='bundle' ".$bundle_Select.">bundle prodcut view</option>
				<option value='gift' ".$gift_Select.">gift idea view</option-->
				<option value='lowtohigh' ".$LowToHigh_Select.">price (low to high)</option>
				<option value='hightolow' ".$HighToLow_Select.">price (high to low)</option>
			</select>";
	
return $sort_string;		
	
}
?>