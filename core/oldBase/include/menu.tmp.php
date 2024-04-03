<?php


function product_search()
{
	return	"<script>
		function CheckSearch(frm){
			
			if(frm.search_str.value.length < 1){
				alert('검색어를 넣어주세요..!!');	
				frm.search_str.focus();
				return false;
			}	
		}
		</script>
	
		<form name=minisearchform action='search_detail.php' onsubmit='return CheckSearch(this) '>
		<table cellpadding=0 cellspacing=0 border=0 style='font-size:9pt;' align=left background='/img/left_bg01.gif' style='background-repeat:repeat-y;'>
			<tr><td align=center style='padding:5px;' bgcolor='silver' colspan=2><a href='/shop/ms_product.list.php?cid=001001001001000&depth=3'><img src='/img/middle_banner.gif' border=0></a></td></tr>
			<tr><td align=left colspan=2><a href='/shop/search.php'><img src='/img/title_product_search.gif' border=0></a></td></tr>
			<tr align=center>
				<td width=80>검색</td>
				<td>".CategoryList(0,"",$category)."</td>
			</tr>
			<tr align=right >
				<td  style='padding:5px;' colspan=2>".PriceSelect($selectPrice)."</td>
			</tr>
			<tr align=center><td>검색어</td><td><input name='search_str' size=15></td></tr>
			<tr align=center><td colspan=2 style='padding:8px;'><input type='image' src='/img/btn_product_search.gif' style='border:0px;'></td></tr>
			<tr><td align=left colspan=2><img src='/img/left_notice.gif'></td></tr>		
			<tr><td bgcolor=#efefef align=center colspan=2><a href='http://www.inicis.com/Custom/Custom_CardApprovalLog.jsp' target=_blank><img src='/img/inicis.jpg' border=0></a></td></tr>
		</table></form>";
}

function main_product_search()
{
	return	"
		<script>
		function search_check(frm){
			if(frm.category.value == ''&& frm.price.value == '' && frm.search_str.value < 1){
				alert('검색조건이나 검색어를 입력하세요');
				return false;
			}
			return true;
		}
		
		</script>
		<form name=minisearchform action='/shop/search_detail.php' onsubmit='return search_check(this)'>
		<table cellpadding=0 cellspacing=0 border=0 style='font-size:9pt;' align=left >
			<tr align=center>
				<td width=80><img src='/main_img/search_require.gif' width='51' height='19'> </td>
				<td>
				".CategoryList(0,"",$category)."
				</td>
				<td rowspan=3><input type='image' src='/main_img/search_go.gif' style='border:0px;'></td>
			</tr>
			<tr align=right >
				<td  style='padding:5px;' colspan=2>
				".PriceSelect($selectPrice)."
				</td>
			</tr>
			<tr align=center><td>검색어</td><td><input name='search_str' size=15></td></tr>
			<tr align=center><td colspan=2 style='padding:8px;'></td></tr>
			
		</table></form>";
}	

function KnownMenu()
{
	return	"<table cellpadding=0 cellspacing=0 border=0 style='font-size:9pt;' align=left>
			<tr><td align=center style='padding:5px;'><img src='/img/title_knowshop.gif'></td></tr>
			<tr bgcolor='#ffffff' align=center><td><a href='/shop/ms_product.list.php?cid=004001000000000&depth=1'><img src='/img/banner08.gif' border=0></a></td></tr>
			<tr bgcolor='#ffffff' align=center><td><a href='/shop/ms_product.list.php?cid=000002001001000&depth=3'><img src='/img/banner02.gif' border=0></a></td></tr>
			<tr bgcolor='#ffffff' align=center><td><a href='/shop/ms_product.list.php?cid=003003000000000&depth=1'><img src='/img/banner03.gif' border=0></a></td></tr>
			<tr bgcolor='#ffffff' align=center><td><a href='/shop/ms_product.list.php?cid=003005000000000&depth=1'><img src='/img/banner07.gif' border=0></a></td></tr>
		</table>";
}	


function topemenu(){
global $user;
$mstring =  "	<table width='635' border='0' cellspacing='0' cellpadding='0'>
              <tr> 
                <td width='417'></td>";
if($user[code] == ""){                
	$mstring .=  "  <td ><a href='/login.php'><img src='/img/top_m_login.gif'  border='0'></a></td>";
}else{
	$mstring .=  "  <td ><a href='/logout.php'><img src='/img/top_m_logout.gif'  border='0'></a></td>";
}

$mstring .=  "  <td ><a href='/cart.php'><img src='/img/top_m_shoppingbag.gif'  border='0'></a></td>
				<td ><a href='/mypage.php'><img src='/img/top_m_mypage.gif'  border='0'></a></td>
                <td ><a href='/help.php'><img src='/img/top_m_notice.gif'  border='0'></a></td>
                <!--td ><a href='/help.php'><img src='/img/top_m_help.gif'  border='0'></a></td-->
                
                <!--td ><a href='/member.php'><img src='/img/top_m_members.gif'  border='0'></a></td-->
                
                <!--td ><a href='/tesorostory.php'><img src='img/top_m_tesorostory.gif'  border='0'></a></td-->
                <td ><a href='/useinfo.php'><img src='/img/top_m_useinfo.gif'  border='0'></a></td>
                
              </tr>
              <tr hegiht=1><td colspan=10 background='/manage/image/dot.gif'></td></tr>
              <tr height=1 background='img/silverdot.gif'><td style='padding-bottom:2px;' colspan=10 align=right><img src='/img/top_squares.gif'></td></tr>
            </table>";
            
	return $mstring;
}


function LoginMenu($div, $engdiv, $color){	
global $user;

if ($user[id] == ""){
		$m_string = "<a href='/mypage/login.php'>로그인</a>/<a href='/member/member.php'>회원가입</a>";
	}else{
		$m_string = "<a href='/mypage/logout.php'>로그아웃</a>/<a href='/mypage/profile.php'>회원정보수정</a>";
	}		
if ($engdiv == "shop"){
	//$imgstr = "<a href='/shop/index.php'><img src='/img/mall_maintitle.gif' border=0></a>";
	$imgstr = "<a href='/shop/index.php'><img src='/img/mall_maintitle_l.gif' border=0></a>";
	
}
if ($engdiv == "ACADEMY"){
	$imgstr = "<a href='/academy/education.php'><img src='/img/academy_maintitle.gif' border=0></a>";
}
if ($engdiv == "HELP"){
	$imgstr = "<a href='/service/news.php'><img src='/img/service_maintitle.gif' border=0></a>";
}
if ($engdiv == "solution"){
	$imgstr = "<a href='/solution/solution.php'><img src='/img/solution_maintitle.gif' border=0></a>";
}

if ($engdiv == "main"){
	$imgstr = "<img src='/main_img/mainl_maintitle.gif' border=0>";
}

if ($engdiv == "community"){
	$imgstr = "<img src='/img/community_maintitle.gif' border=0>";
}
	
return "	<table cellpadding=0 cellspacing=0 border=0 width=100% >
		<tr>
			<td width=100><a href='/'><img src='/shop/img/logo.gif' border=0></a></td>
			<td style='padding-left:4px;' valign='bottom' nowrap>$imgstr</td>			
			<td width=70% style='font-size:8pt;padding-right:70px;' align=right valign=bottom>
			".$m_string."&nbsp;&nbsp; | &nbsp;&nbsp;<a href='/mypage/shopping_history.php'>주문배송조회</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href='/shop/cart.php'>쇼핑카트</a>&nbsp;&nbsp;  | &nbsp;&nbsp;<a href='/mypage/profile.php'>마이페이지</a>
			</td>
		</tr>
		</table>";
				
}

function LoginBool($point="")
{
	global $user;
	if ($user[id] == ""){
		return "로그인을 해주세요";
	}else{
		//return $user[id]."님 포인트 ".myPoint()." 점 ";
		return $user[name]."님 적립금 ".getReserve("0 원")." ";
		
	}
}

function AcademyLoginBool()
{
	global $user;
	if ($user[id] == ""){
		return "로그인을 해주세요";
	}else{
		//return $user[id]."님 포인트 ".myPoint()." 점 ";
		return $user[name]."님 적립금 ".getReserve("0 원")." ";
	}
}

function CommunityLoginBool()
{
	global $user;
	if ($user[id] == ""){
		return "로그인을 해주세요";
	}else{
		return $user[name]."님 포인트 ".myPoint()." 점 "; 
		//return $user[id]."님 적립금 ".getReserve("0 원")." "; 
	}
}

function BottomMenu()
{
$mstring = "<table cellpadding=0 cellspacing=0 align=center>
		<tr><td  align=center><map name='FPMap0'>
		<area href='/' shape='rect' coords='28, 1, 123, 35'>
		<area href='/company/company.php' shape='rect' coords='123, 2, 210, 35'>
		<area href='/company/aaa.php' shape='rect' coords='210, 2, 297, 35'>
		<area href='/service/etcqna.php' shape='rect' coords='297, 2, 384, 35'>
		<area href='/company/security.php' shape='rect' coords='505, 1, 634, 36'>
		<area href='/company/point.php' shape='rect' coords='386, 2, 504, 35'>
		<area href='#top' shape='rect' coords='727, 3, 803, 36'></map><img border='0' src='/shop/img/bottom_bar.gif' usemap='#FPMap0' width='860' height='42'></td></tr>
		<tr><td align=center><img border='0' src='/img/support.gif' ></td></tr>
		</table>";
		
return $mstring;		
	
}

function displaydoumi(){

return "<div id='divMenu' style='width:72px; height:118px; position:relative; left:1px; top:100px; z-index:1;'>
	<table cellpadding=0 cellspacing=0 width=72 height=108 background='/shop/img/doumi.gif' style='background-repeat:no-repeat;'>
		<tr><td style='padding-top:35px;padding-left:7px;'><a href='/mypage/reservecupon.php'>적립금</a> ".getReserve()."</td></tr>
		<tr><td style='padding-left:7px;'><a href='/shop/search.php'>오늘본제품</a></td></tr>
		<tr><td style='padding-left:7px;'><a href='/shop/event.php'>이벤트</a></td></tr>
		<tr height=15><td></td></tr>
	</table>
	</div>";		
}

function NoticeLeftMenu(){

	
	$mstring = "
		<table cellpadding=2 cellspacing=0 style='font-size:9pt;' width=100% bgcolor=#ffffff border=0>			
			<tr>
				<td style='padding-left:0px;color:#000000;padding-top:30px;' bgcolor='#ffffff'>
				<b><img src='/img/tit_community.gif'></b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:20px'></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:5px'><a href='/news.php'>notice</a></td>
			</tr>			
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:5px'>Q & A</td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:10px'><a href='/qna.php'>재입고 관련 및 코디 문의</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:10px'><a href='/qna.php?ctgr=".TBL_SHOP_QNA."'>반품 및 교환 배송 관련 질문 </a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:5px'><a href='/bbs.php'>Blah Blah</a></td>
			</tr>
			<!--tr bgcolor='#ffffff' height=25>
				<td style='padding-left:5px'><a href='/faq.php'>FAQ</a></td>
			</tr-->
		</table>";
		
		return $mstring;
}


function CommunityLeftMenu($mP){
global $DOCUMENT_ROOT;
//$ms_template = $_SERVER["DOCUMENT_ROOT"]."/shop_templete/basic/ms_community_leftmenu.htm";
$ms_template = $mP->ms_template_path."/ms_community_leftmenu.htm";

//echo $ms_template;
$tcontent = load_template($ms_template);
$community_menu_tmp   = get_tags("{{MALLSTORY_BBS_MENU_LOOP_START}}","{{MALLSTORY_BBS_MENU_LOOP_END}}",$tcontent);
$loop_tmp = $community_menu_tmp["re-content"];

$mdb = new Database;
$mdb->query("SELECT * FROM bbs_manage_config order by regdate");
	

	for($i=0;$i < $mdb->total;$i++){
		$mdb->fetch($i);
		
		$loop_tmp_ing = $loop_tmp;
	        
		$loop_tmp_ing = eregi_replace("{{MALLSTORY_BBS_MENU_NAME}}",$mdb->dt[board_name], $loop_tmp_ing);
		$loop_tmp_ing = eregi_replace("{{MALLSTORY_BBS_MENU_ENGLISH_NAME}}",$mdb->dt[board_ename], $loop_tmp_ing);
		
		$loop_tmp_result .= $loop_tmp_ing;
	}
	
	$tcontent = substr($tcontent,0,$community_menu_tmp["ab-begin"]).$loop_tmp_result.substr($tcontent,$community_menu_tmp["ab-end"],strlen($tcontent));
	$tcontent = eregi_replace("{{MALLSTORY_TEMPLET_PATH}}",$mP->ms_template_webpath, $tcontent);
	
	return $tcontent;
	
}

function MypageLeftMenu($mP){
global $DOCUMENT_ROOT;
//$ms_template = $_SERVER["DOCUMENT_ROOT"]."/shop_templete/basic/ms_mypage_leftmenu.htm";
$ms_template = $mP->ms_template_path."/ms_mypage_leftmenu.htm";

$tcontent = load_template($ms_template);
$tcontent = eregi_replace("{{MALLSTORY_TEMPLET_PATH}}",$mP->ms_template_webpath, $tcontent);

return $tcontent;
}


function EstimateLeftMenu($mP){
global $DOCUMENT_ROOT;

$ms_template = $mP->ms_template_path."/ms_estimate_leftmenu.htm";

$tcontent = load_template($ms_template);
$tcontent = eregi_replace("{{MALLSTORY_TEMPLET_PATH}}",$mP->ms_template_webpath, $tcontent);

return $tcontent;
}



function MypageLeftMenuBackup($div="myinfo")
{
if($div == "myinfo"){
	$myinfoimg = "blue_head.gif";
	$chuinfoimg = "gray_head.gif"; 
	$shoppinginfoimg = "gray_head.gif"; 
	$academyinfoimg = "gray_head.gif";
	$communityinfoimg = "gray_head.gif";
}else if($div == "chuinfo"){
	$myinfoimg = "gray_head.gif";
	$chuinfoimg = "blue_head.gif"; 
	$shoppinginfoimg = "gray_head.gif"; 
	$academyinfoimg = "gray_head.gif";
	$communityinfoimg = "gray_head.gif";
}else if($div == "shoppinginfo"){
	$myinfoimg = "gray_head.gif";
	$chuinfoimg = "gray_head.gif"; 
	$shoppinginfoimg = "blue_head.gif"; 
	$academyinfoimg = "gray_head.gif";
	$communityinfoimg = "gray_head.gif";
}else if($div == "academyinfo"){
	$myinfoimg = "gray_head.gif";
	$chuinfoimg = "gray_head.gif"; 
	$shoppinginfoimg = "gray_head.gif"; 
	$academyinfoimg = "blue_head.gif";
	$communityinfoimg = "gray_head.gif";
}else if($div == "communityinfo"){
	$myinfoimg = "gray_head.gif";
	$chuinfoimg = "gray_head.gif"; 
	$shoppinginfoimg = "gray_head.gif"; 
	$academyinfoimg = "gray_head.gif";
	$communityinfoimg = "blue_head.gif";
}else if($div == "recommendinfo"){
	$myinfoimg = "gray_head.gif";
	$chuinfoimg = "gray_head.gif"; 
	$shoppinginfoimg = "gray_head.gif"; 
	$academyinfoimg = "gray_head.gif";
	$communityinfoimg = "blue_head.gif";
}
	
	$mstring = "
		<table cellpadding=2 cellspacing=0 style='font-size:9pt;' width=95% bgcolor=#ffffff border=0 bordercolor=red>
			<tr><td><img src='/mypage/img/mypage_lefttop.gif'></td></tr>
			<tr bgcolor='#ffffff'>
				<td >
				<table cellpadding=2 cellspacing=0 width='100%'>
					<tr><td colspan=2 style='color:blue;border:1px solid #efefef'>쇼핑혜택</td></tr>
					<!--<tr><td>쿠폰</td><td>3장</td></tr>-->
					<tr><td>적립금</td><td>".getReserve("0 원","")."</td></tr>
					
					<!--
					<tr><td colspan=2 style='color:blue;border:1px solid #efefef'>커뮤니티 활동</td></tr>
					<tr><td>레벨</td><td>골드</td></tr>
					<tr><td>포인트</td><td>".mypoint()."점</td></tr>
					-->

				</table>
				</td>
			</tr>
			<tr>
				<td style='padding-left:5px;color:#000000;padding-top:30px;' bgcolor='#ffffff'>
				<img src='/mypage/img/$myinfoimg' align=absmiddle> <b>나만의정보</b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:25px'></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/profile.php'>기본정보수정</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/profile_add.php'>추가정보수정</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/change_password.php'>비밀번호수정</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/member_drop.php'>회원탈퇴</a></td>
			</tr>
			

			<tr>
				<td style='padding-left:5px;color:#000000;padding-top:30px;' bgcolor='#ffffff'>
				<img src='/mypage/img/$chuinfoimg' align=absmiddle> <b>추천인메뉴</b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:25px'></td>
			</tr>";
			
	if(RecommendBool()){
	$mstring .= "
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/recommend.php'>추천인관리</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/recommend_product.php'>추천가능품목</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/recommend_levelintro.php'>추천인등급안내</a></td>
			</tr>";
	}else{		
	$mstring .= "		
			<!--추천인 가입하기 '' 추천인에 가입한 후에는 추천인 메뉴가 출력됩니다.-->
			<tr bgcolor='#ffffff' height=5>
				<td style='padding-left:25px'></td>
			</tr>			
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:1px'><img src='/mypage/img/button_chu.gif' style='cursor:hand;' onclick=\"PoPWindow('chu_join.php',620,500,'priceinfo')\"></td>
			</tr>";
	}		
				
	$mstring .= "
			<tr>
				<td style='padding-left:5px;color:#000000;padding-top:30px;' bgcolor='#ffffff'><img src='/mypage/img/$shoppinginfoimg' align=absmiddle> <b>쇼핑이용내역</b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:25px'></td>
			</tr>			
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/shopping_history.php'>주문/배송 조회</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/shopping_history_past.php'>구 홍일 구매내역 조회</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/reservecupon.php'>적립금 조회</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/wishlist.php'>찜바구니</a></td>
			</tr>
			<tr>
				<td style='padding-left:5px;color:#000000;padding-top:30px;' bgcolor='#ffffff'><img src='/mypage/img/$academyinfoimg' align=absmiddle> <b>아카데미</b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:25px'></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/education_history.php'>수강중인강좌</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/education_history_past.php'>지난 수강 내역</a></td>
			</tr>
			<tr>
				<td style='padding-left:5px;color:#000000;padding-top:30px;' bgcolor='#ffffff'><img src='/mypage/img/$communityinfoimg' align=absmiddle> <b>커뮤니티</b></td>
			</tr>
			<tr height=2><td class=color4 ></td></tr>
			<tr bgcolor='#ffffff' height=3>
				<td style='padding-left:25px'></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/point_history.php'>포인트 조회</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'><a href='/mypage/point_useintro.php'>포인트 이용안내</a></td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'>영상전시/ 토론조회</td>
			</tr>
			<tr bgcolor='#ffffff' height=25>
				<td style='padding-left:25px'>사용자평가단</td>
			</tr>
			<tr height=100><td></td></tr>
			
		</table>";
		
		return $mstring;
}
?>
