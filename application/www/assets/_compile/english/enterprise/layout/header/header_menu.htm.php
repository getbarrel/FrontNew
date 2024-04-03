<?php /* Template_ 2.2.8 2021/10/13 10:40:16 /home/barrel-stage/application/www/assets/templet/enterprise/layout/header/header_menu.htm 000021843 */ ?>
<style>
	
	.fb__header .header__topMenu {padding:0 70px;}
	.fb__header .header__topMenu__etcMenu > a, .fb__header .header__topMenu__etcMenu .header__sns, .fb__header .header__topMenu__etcMenu .header__campaign {padding:0 15px;}
	.fb__header .header__name {font-family:'Malgun Gothic'; font-weight:bold;}
	.fb__header .header__name span.eng-hidden {margin-right:0;}
	.fb__header .header__topMenu__myMenu .log {width:60px; color:#666; font-size:11px; line-height:20px; margin:9px 12px 0 0;}
	.fb__header .header__topMenu__myMenu .mypage__link {width:22px; height:23px; background:url('/assets/templet/enterprise/images/common/icon_mypage.png') 0 0 no-repeat; margin-right:15px; top:-6px;}
	.fb__header .header__topMenu__myMenu .cart {width:22px; height:22px; background:url('/assets/templet/enterprise/images/common/icon_cart.png') 0 0 no-repeat; margin-right:27px; top:-6px;}
	.fb__header .header__topMenu__myMenu .customer {margin-right:40px;}
	.fb__header .header__topMenu__global {margin-top:10px;}
	.fb__header .header__topMenu__global__btn {background:url('/assets/templet/enterprise/images/common/icon-heaerTop-arrow2.png') right center no-repeat; color:#444; font-size:12px; padding-right:16px;}
	.fb__header .header__topMenu__global__list {width:60px; height:93px; left:-18px; top:29px;}

	.fb__header .header__topMenu__layout {padding:0 70px;}
	.fb__headerMenu {height:64px; padding-left:360px;}
	.fb__headerMenu .header__logo {top:17px;}
	.fb__headerMenu .header__menu {font-size:16px; line-height:64px;}
	.fb__headerMenu .header__menu .header__sub {width:calc(100% + 140px); margin-left:-70px; padding:40px 60px; top:64px;}
	.fb__headerMenu .header__menu .header__sub--brand {padding:40px 60px 0;}
	.fb__sns__inner {line-height:84px;}


	.fb__sns-modal .sns__inner {width:1445px;}
	.fb__sns-modal .sns__inner nav a {width:289px; padding-top:208px;}

</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="header__topMenu">
	<nav class="header__topMenu__etcMenu">
		<div class="header__sns">
			Social Media
			<ul class="header__sns__list">
				<li class="header__sns__box">
					<span class="header__sns__link header__sns__link--instagram">
						<span>Instagram</span>
						<ul class="header__sns__list header__sns__list--insta">
							<li class="header__sns__box">
								<a href="https://www.instagram.com/getbarrel" class="header__sns__link header__sns__link--official" target="_blank">Barrel Official</a>
							</li>
							<li class="header__sns__box">
								<a href="https://www.instagram.com/barrel.lifestyle" class="header__sns__link header__sns__link--official" target="_blank">배럴 라이프 스타일</a>
							</li>
							<li class="header__sns__box">
								<a href="https://www.instagram.com/barrel.swim" class="header__sns__link header__sns__link--swim" target="_blank">Barrel Swim</a>
							</li>
							<li class="header__sns__box">
								<a href="https://www.instagram.com/barrel.fit" class="header__sns__link header__sns__link--fit" target="_blank">BARREL-FIT</a>
							</li>
							<li class="header__sns__box">
							<a href="https://www.instagram.com/barrel.cosmetics" class="header__sns__link header__sns__link--cosmetics" target="_blank">Barrel Cosmetics</a>
							</li>
						</ul>
					</span>
				</li>
				<li class="header__sns__box">
					<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="header__sns__link header__sns__link--facebook" target="_blank">Facebook</a>
				</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<li class="header__sns__box">
					<a href="https://pf.kakao.com/_VxfxjDd" class="header__sns__link header__sns__link--kakao" target="_blank">(english)카카오플친</a>
				</li>
				<li class="header__sns__box">
					<a href="http://blog.naver.com/socal_kr" class="header__sns__link header__sns__link--blog" target="_blank">Blog</a>
				</li>
<?php }?>
				<li class="header__sns__box">
					<a href="https://www.youtube.com/c/getbarrel" class="header__sns__link header__sns__link--youtube" target="_blank">Youtube</a>
				</li>
			</ul>
		</div>
		<a href="/brand/visual">
			VISUAL
		</a>
		<a href="/brand/sponsorship">
			BARREL TEAM
		</a>
		
		<a href="/brand/teacherMember" class="eng-hidden">
			Teacher member recruitment
		</a>
<?php if($TPL_VAR["langType"]=='korean'){?>
		<a href="/customer/bestReview">
			Shipping & Cancel Guide 
		</a>
<?php }else{?>
		<!--<a href="/customer/shippingGuide">-->
			<!--Shipping & Cancel Guide -->
		<!--</a>-->
<?php }?>
		<a href="/event/eventDetail/47">Sprint Championship</a>
		<!-- <div class="header__campaign">
			<span>SPORTS CAMPAIGN</span>
			<ul class="header__sns__list">
				<li class="header__sns__box">
							<span class="header__sns__link ">
								<a href="/event/eventDetail/47">Sprint Championship</a>
							</span>
				</li>
				<li class="header__sns__box">
							<span class="header__sns__link ">
								<a href="/event/eventDetail/208" >SOS Campaign</a>
							</span>
				</li>
				<li class="header__sns__box">
							<span class="header__sns__link "> -->
								<!--@TODO 오픈 이후 URL 확인 필요 -->
								<!-- <a href="/brand/cheering" target="_blank">Cheering Your Sweat</a>
							</span>
				</li>
			</ul>
		</div> -->
		<a href="/customer/storeInformation" class="eng-hidden">
			Membership Guide
		</a>
	</nav>
	<div class="header__topMenu__menu">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
		<p class="header__name">
			<span><?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?></span><span class="eng-hidden">없음 </span>
		</p>
<?php }?>
		<nav class="header__topMenu__myMenu">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
			<a class="log devLogout">Logout</a>
			<div class="mypage">
				<a href="/mypage/" class="mypage__link">My page</a>
				<ul class="mypage__detail-menu">
					<li><a href="/mypage/orderHistory">Your Orders</a></li>
					<li><a href="/mypage/returnHistory">Return/Cancellation</a></li>
					<li><a href="/mypage/myInquiry">1:1 Inquiry</a></li>
					<li><a href="/mypage/mileage">Reward</a></li>
					<li><a href="/mypage/coupon">Coupons</a></li>
				</ul>
			</div>
<?php }else{?>
			<a href="/member/login?url=<?php echo urlencode($_GET['url'])?>" class="log">Sign in</a>
			<!-- <a href="/member/joinInput" class="join">Join</a> -->
			<a href="/member/login?kakao=one" class="join">Join</a>
			<div class="mypage">
				<a href="/mypage/" class="mypage__link">My page</a>
				<ul class="mypage__detail-menu">
					<li><a href="/mypage/orderHistory">Your Orders</a></li>
					<li><a href="/mypage/returnHistory">Return/Cancellation</a></li>
					<li><a href="/mypage/myInquiry">1:1 Inquiry</a></li>
					<li><a href="/mypage/mileage">Reward</a></li>
					<li><a href="/mypage/coupon">Coupons</a></li>
				</ul>
			</div>
<?php }?>
			<a href="/shop/cart" class="cart">Cart<em id='cart_total_cnt' class='cart_total_cnt'><?php echo $TPL_VAR["layoutCommon"]["userInfo"]["cartCnt"]?></em></a>
			<a href="/customer/" class="customer">CS Center</a>
		</nav>
		<div class="header__topMenu__global">
			<button class="header__topMenu__global__btn  header__topMenu__global__btn--ko">
<?php if($TPL_VAR["langType"]=='korean'){?>
				KR<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ko.gif" alt="korea"> -->
<?php }elseif($TPL_VAR["langType"]=='english'){?>
				EN<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt="english"> -->
<?php }else{?>
				CN<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ch.gif" alt="chinese"> -->
<?php }?>
			</button>
			<ul class="header__topMenu__global__list">
				<li>
					<a href="//www.getbarrel.com/" class="global__btn__list ">
						<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ko.gif" alt=""> --><span class="global__btn <?php if($TPL_VAR["langType"]=='korean'){?>global__btn--active<?php }?>">KR</span>
					</a>
				</li>
				<li>
					<a href="//en.getbarrel.com/" class="global__btn__list">
						<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt=""> --><span class="global__btn <?php if($TPL_VAR["langType"]=='english'){?>global__btn--active<?php }?>">EN</span>
					</a>
					<!--<a href="javascript:alert('영문몰 오픈 준비중입니다.');" class="global__btn__list">-->
						<!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt=""><span class="global__btn <?php if($TPL_VAR["langType"]=='english'){?>global__btn&#45;&#45;active<?php }?>">US</span>-->
					<!--</a>-->
				</li>
				<li>
					<a href="/event/eventDetail/12" class="global__btn__list ">
						<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ch.gif" alt=""> --><span class="global__btn">CN</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript"> 
//<![CDATA[
    function wrapWindowByMask(){
 
        //화면의 높이와 너비를 구한다.
        var maskHeight = $(document).height();  
        var maskWidth = $(window).width();  
 
        //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
        $("#sch_mask").css({"width":maskWidth,"height":maskHeight});  
 
        //애니메이션 효과 - 일단 0초동안 까맣게 됐다가 60% 불투명도로 간다.
 
        $("#sch_mask").fadeIn(0);      
        $("#sch_mask").fadeTo("slow",0.6);    
 
        //윈도우 같은 거 띄운다.
        $(".sch_window").show();
 
    }
 
    $(document).ready(function(){
        //검은 막 띄우기
        $(".openMask").click(function(e){
            e.preventDefault();
            wrapWindowByMask();
        });
 
        //닫기 버튼을 눌렀을 때
        $(".sch_window .btn_sch_close").click(function (e) {  
            //링크 기본동작은 작동하지 않도록 한다.
            e.preventDefault();  
            $("#sch_mask, .sch_window").hide();  
        });       
 
        //검은 막을 눌렀을 때
        $("#sch_mask").click(function () {  
            $(this).hide();  
            $(".sch_window").hide();  
 
        });      
 
    });
 
//]]>
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap');

	.wrap-header-search {width:23px; height:25px;}
	.btn_comm_sch {position:absolute; right:0; top:-5px;}

	.wrap_sch {width:100%; background-color:#fff; left:0; position:absolute; top:0;}

	.wrap_sch #sch_mask {background-color:transparent; display:none; left:0; position:absolute; top:0; z-index:9000;} 
	.wrap_sch .sch_window {width:100%; height:1000px; background-color:#FFF; display:none; left:0; position:absolute; top:0; z-index:10000;}

	.wrap_sch .sch_box {width:1444px; margin:0 auto; padding-top:250px; position:relative;}

	.wrap_sch .sch_box .ipt_sch {width:900px; float:left; margin-right:100px;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner {border-bottom:#000 5px solid; }
	.wrap_sch .sch_box .ipt_sch .search-area__text {width:760px; border:none; font-size:40px; font-weight:bold; line-height:44px;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner {padding:0 0 40px 31px; position:relative;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner input[type="text"] {padding:0;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner input[type="text"]::placeholder {color:#E9E9E9;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner input[type="text"]:focus {outline:none;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner .search-area__del {display:none;}
	.wrap_sch .sch_box .ipt_sch .search-area__inner .btn_sch_submit {width:45px; height:45px; background:#fff url('/assets/templet/enterprise/images/common/icon_sch2.png') 0 0 no-repeat; font-size:0; position:absolute; right:29px; top:-1px;}
	
	.wrap_sch .sch_box .wrap_sch_txt {float:left;}
	.wrap_sch .sch_box .wrap_sch_txt h2.tit {color:#000; display:block; font-family:'Noto Sans KR'; font-size:26px; font-weight:500; line-height:44px; margin:-4px 0 30px; position:relative;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box1 {width:225px; float:left;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box1 li a {color:#000; font-size:16px; line-height:40px;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box1 li a em {display:none;}
	
	.wrap_sch .sch_box .wrap_sch_txt .tab_box2 {width:219px; float:left;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box2 .btn_sch_alldel {bottom:7px; color:#666; font-size:16px; font-weight:400; line-height:20px; position:absolute; right:0;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box2 li {position:relative;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box2 li a {color:#000; font-size:16px; line-height:40px;}
	.wrap_sch .sch_box .wrap_sch_txt .tab_box2 .search-word-del {width:12px; height:12px; background:url('/assets/templet/enterprise/images/common/icon_sch_del.png') 0 0 no-repeat; display:inline-block; font-size:0; margin-top:-6px; position:absolute; right:0; top:50%;}





	.wrap_sch_close {display:inline-block; position:absolute; right:0; top:80px;}
 
</style>
<div class="wrap_sch"> 
    <div id="sch_mask"></div>
    <div class="sch_window">
        <div class="sch_box">

			<div class="ipt_sch">
				<fieldset class="search-area">
					<div class="search-area__inner">
						<input type="text" class="header-input-search search-area__text devAutoComplete" id="devHeaderSearchText" devTagUrl="<?php if(is_array($TPL_R1=$TPL_VAR["layoutCommon"]["headerTopSearchesTags"]["searchesTag"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["st_url"]?><?php }}?>" placeholder="검색어를 입력해주세요." value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);">
						<i class="search_close_btn" id="devSearchCloseBtn" style="display:none;"></i>
						<button class="search-area__del">삭제버튼</button>
						<input type="submit" id="devHeaderSearchButton" class="btn_sch_submit">
					</div>
				</fieldset>
		        <div class="wrap_sch_close"><a href="#" class="btn_sch_close"><img src="/assets/templet/enterprise/images/common/icon_close.png" /></a></div>
			</div>

			<div class="wrap_sch_txt">
				<div class="tab_box1">
					<h2 class="tit">Popular Search</h2>
					<div id="tab1" class="tab-hot active">
						<ul class="ul-hot-search">
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["popularKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 10){?>
							<li>
								<a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1["keyword"])?>">
									<div><em><?php echo $TPL_K1+ 1?></em><?php echo $TPL_V1["keyword"]?></div>
								</a>
							</li>
<?php }?>
<?php }}?>
						</ul>
					</div>
				</div>
				<div class="tab_box2">
					<h2 class="tit">Recent Search<a href="#" id="devRecentKeyWordDeleteAll" class="btn_sch_alldel">Delete All</a></h2>
					<div id="tab2" class="tab-recent">
<?php if($TPL_VAR["headerTop"]["recentKeyword"]){?>
						<ul class="ul-recent-search" id="devRecent">
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["recentKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 10){?>
							<li devDelKey="<?php echo $TPL_K1?>">
								<a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1)?>" class="devSearchKeyWord" data-text="<?php echo $TPL_V1?>">
									<?php echo $TPL_V1?>

								</a>
								<button class="search-word-del devRecentKeyWordDelete"  devDelText="<?php echo $TPL_V1?>">del</button>
							</li>
<?php }?>
<?php }}?>
						</ul>
<?php }else{?>
						<div class="empty-content">
							No recent searches.
						</div>
<?php }?>
					</div>
				</div>

			</div>

        </div>

    </div>
</div>



<div class="header__topMenu__layout">
	<div class="fb__headerMenu">
		<div class="header">
			<h1 class="header__logo">
				<a href="/"><img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/shop_logo2.png"></a>
			</h1>
			<div class="header__menu">
				<a href="#">
					About Us
				</a>
				<div class="header__sub header__sub--brand">

					<div class="brand">
						<ul class="brand__menu">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["leftBrandStory"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li class="brand__list">
								<a href="<?php echo $TPL_V1["bannerLink"]?>" class="brand__list__link">
									<figure class="brand__list__thumb">
										<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
									</figure>
									<p class="brand__list__title"><?php echo $TPL_V1["banner_name"]?> <span class="brand__list__sub"><?php echo $TPL_V1["shot_title"]?></span>
									</p>
								</a>
							</li>
<?php }}?>
						</ul>
					</div>

					<div class="fb__sns">
						<div class="fb__sns__inner">
							<h3 class="fb__sns__title">Social Media</h3>
							<div class="sns-btn">
								<a href="#" class="fb__sns--instagram">
									인스타그램
								</a>
								<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="fb__sns--facebook">
									페이스북
								</a>
								<a href="https://pf.kakao.com/_VxfxjDd" class="fb__sns--kakao">
									카카오톡
								</a>
								<a href="http://blog.naver.com/socal_kr" class="fb__sns--blog">
									블로그
								</a>
								<a href="https://www.youtube.com/c/getbarrel" class="fb__sns--youtube">
									유튜브
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
			<div class="header__menu" <?php if($TPL_V1["cname"]=="B.LAB"||$TPL_V1["cname"]=="BARREL ISSUE"){?>style="margin-top:-3px;"<?php }?>>
<?php if($TPL_V1["category_type"]=="C"){?>
	    			<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" <?php if($TPL_I1== 0){?> <?php }?><?php if($TPL_V1["is_layout_emphasis"]=="Y"){?> style="font-weight: 700;" <?php }?>><?php echo $TPL_V1["cname"]?> <?php if($TPL_V1["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }else{?>
					<a href="<?php echo $TPL_V1["category_link"]?>" <?php if($TPL_I1== 0){?> <?php }?><?php if($TPL_V1["is_layout_emphasis"]=="Y"){?> style="font-weight: 700;" <?php }?>><?php echo $TPL_V1["cname"]?> <?php if($TPL_V1["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }?>

				<div class="header__sub">
					<div class="sub">
						<!--<div class="sub__banner">
							<figure class="sub__banner__big">
								<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/img-subMenu-1.jpg" alt="">
							</figure>
							<figure class="sub__banner__small">
								<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/img-subMenu-2.jpg" alt="">
							</figure>
						</div>-->
						<div class="sub__issue">
							<h2 class="sub__issue__title">BARREL ISSUE</h2>
							<ul class="sub__issue__list">
<?php if(is_array($TPL_R2=$TPL_VAR["headerMenu"]["customCategoryMenu"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<li class="sub__issue__box">
									<a href="<?php echo $TPL_V2["category_link"]?>"><?php echo $TPL_V2["cname"]?></a>
								</li>
<?php }}?>
								<!--<li class="sub__issue__box">-->
									<!--<a href="#">오예 커플의 썸머 브레이크!</a>-->
								<!--</li>-->
								<!--<li class="sub__issue__box">-->
									<!--<a href="#">워터 시스터즈 영상 오픈EVENT</a>-->
								<!--</li>-->
								<!--<li class="sub__issue__box">-->
									<!--<a href="#">2019 BARREL GIRL RISABAE</a>-->
								<!--</li>-->
								<!--<li class="sub__issue__box">-->
									<!--<a href="#">제주의 특별한 삼남매 이야기</a>-->
								<!--</li>-->
							</ul>
						</div>
						<ul class="sub__menu">
<?php if(is_array($TPL_R2=$TPL_V1["subCateList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<li class="sub__list">
								<h2 class="sub__title">
<?php if($TPL_V2["category_type"]=="C"){?>
									<a href="/shop/subGoodsList/<?php echo $TPL_V2["cid"]?>">
<?php }else{?>
									<a href="<?php echo $TPL_V2["category_link"]?>">
<?php }?>
										<?php echo $TPL_V2["cname"]?> <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?>
									</a>
								</h2>
								<ul class="sub__menu__inner">
<?php if(is_array($TPL_R3=$TPL_V2["subCateList"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["category_type"]=="C"){?>
										<li class="sub__menu__list"><a href="/shop/subGoodsList/<?php echo $TPL_V3["cid"]?>"><?php echo $TPL_V3["cname"]?></a></li>
<?php }else{?>
										<li class="sub__menu__list"><a href="<?php echo $TPL_V3["category_link"]?>"><?php echo $TPL_V3["cname"]?></a></li>
<?php }?>
<?php }}?>
								</ul>
							</li>
<?php }}?>
						</ul>
					</div>
				</div>
			</div>
<?php }}?>
			<div class='header__search wrap-header-search'>
				<div class="btn_comm_sch"><a href="#" class="openMask"><img src="/assets/templet/enterprise/images/common/icon_sch.png" /></a></div>
			</div>
		</div>
	</div>
</div>
<!--<a href="#" class="nav__all-btn" >Menu</a>-->
<!--<a href="/event/eventList" class="font-en">EVENT</a>-->
<!--<a href="/event/promotion/" class="font-en">Special deal</a>-->
<!--<a href="/best/best" class="font-en">Best</a>-->