<?php /* Template_ 2.2.8 2024/04/02 09:25:43 /home/barrel-qa/application/www/assets/templet/enterprise/layout/header/header_menu.htm 000023801 */ 
$TPL_displayContentClassList_1=empty($TPL_VAR["displayContentClassList"])||!is_array($TPL_VAR["displayContentClassList"])?0:count($TPL_VAR["displayContentClassList"]);
$TPL_displayContentClassDepthList_1=empty($TPL_VAR["displayContentClassDepthList"])||!is_array($TPL_VAR["displayContentClassDepthList"])?0:count($TPL_VAR["displayContentClassDepthList"]);?>
<!-- .fb__sns-modal .sns__inner {width:580px;}-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<nav id="navigation" class="fb__main_nav">
	<div class="header__topMenu">
		<div class="header__topMenu__menu">
			<nav class="header__topMenu__myMenu">
				<ul>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
						<li><a class="log devLogout">로그아웃</a></li>
						<li class="mypage">
							<a href="/mypage/" class="mypage__link">마이페이지</a>
							<ul class="mypage__detail-menu">
								<li><a href="/mypage/orderHistory">주문내역 조회</a></li>
								<li><a href="/mypage/returnHistory">반품/취소 내역</a></li>
								<li><a href="/mypage/myInquiry">1:1 문의</a></li>
								<li><a href="/mypage/mileage">적립금</a></li>
								<li><a href="/mypage/coupon">쿠폰</a></li>
							</ul>
						</li>
<?php }else{?>
						<li><a href="/member/login?url=<?php echo urlencode($_GET['url'])?>" class="log">로그인</a></li>
						<li><a href="/member/login?kakao=one" class="join">회원가입</a></li>
						<li class="mypage">
							<!-- <a href="/mypage/" class="mypage__link">마이페이지</a> -->
							<ul class="mypage__detail-menu">
								<li><a href="/mypage/orderHistory">주문내역 조회</a></li>
								<li><a href="/mypage/returnHistory">반품/취소 내역</a></li>
								<li><a href="/mypage/myInquiry">1:1 문의</a></li>
								<li><a href="/mypage/mileage">적립금</a></li>
								<li><a href="/mypage/coupon">쿠폰</a></li>
							</ul>
						</li>
<?php }?>
					<li><a href="/customer/" class="customer">고객센터</a></li>
					<li><a href="/customer/storeInformation" class="eng-hidden">매장안내</a></li>
				</ul>
			</nav>
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
	<!-- 검색 창 레이어 S-->
	<div class="wrap_sch">
		<div id="sch_mask"></div>
		<div class="sch_window">
			<div class="sch_box">
				<div class="ipt_sch">
					<fieldset class="search-area">
						<div class="search-area__inner">
							<label for="devHeaderSearchText" class="hide">검색텍스트</label>
							<input type="text" class="header-input-search search-area__text devAutoComplete" id="devHeaderSearchText" devTagUrl="<?php if(is_array($TPL_R1=$TPL_VAR["layoutCommon"]["headerTopSearchesTags"]["searchesTag"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["st_url"]?><?php }}?>" placeholder="검색어를 입력해주세요." value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);">
							<i class="search_close_btn" id="devSearchCloseBtn" style="display:none;"></i>
							<button class="search-area__del">삭제버튼</button>
							<input type="submit" id="devHeaderSearchButton" class="btn_sch_submit">
							<!-- 텍스트 입력시 자동 완성 텍스트 레이어 S 
							<div class="search-area__layer">
								<ul class="search-area__auto-text">
									<li>
										<a href="javascript:void(0);"> <span>래</span>쉬가드 </a>
									</li>
									<li>
										<a href="javascript:void(0);"> 오션 <span>래</span>쉬가드 </a>
									</li>
									<li>
										<a href="javascript:void(0);"> 남자 <span>래</span>쉬가드 </a>
									</li>
									<li>
										<a href="javascript:void(0);"> 여자 <span>래</span>쉬가드 </a>
									</li>
									<li>
										<a href="javascript:void(0);"> 키즈 <span>래</span>쉬가드 </a>
									</li>
								</ul>
							</div>
							 텍스트 입력시 자동 완성 텍스트 레이어 E -->
						</div>
					</fieldset>
					<div class="wrap_sch_close">
						<a href="javascript:void(0);" class="btn_sch_close">닫기</a>
					</div>
				</div>
				<div class="wrap_sch_scroll">
					<!--div class="wrap_sch_result">
						<h2 class="tit">‘<strong>래쉬가드</strong>’의 검색 결과</h2>
						-- 가장 인기있는 상품 없을 경우 S--
						<div class="empty-content no-data">검색어와 일치하는 상품이 없습니다.</div>
						-- 가장 인기있는 상품 없을 경우 E--
					</div-->
					<div class="wrap_sch_txt">
						<div class="tab_box2">
							<h2 class="tit">최근검색어<a href="javascript:void(0);" id="devRecentKeyWordDeleteAll" class="btn_sch_alldel">전체삭제</a></h2>
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
								<div class="empty-content no-data">
									최근 입력한 검색어가 없습니다.
								</div>
<?php }?>
							</div>
						</div>
						<div class="tab_box1">
							<h2 class="tit">인기 검색어</h2>
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
<?php }}else{?>
									<!-- 검색어 없을 경우 S-->
									<div class="empty-content no-data">최근 인기 검색어가 없습니다.</div>
									<!-- 검색어 없을 경우 E-->
<?php }?>
								</ul>
							</div>
						</div>
					</div>
					<div class="wrap_sch_best" style="display:none;">
						<h2 class="tit">가장 인기있는 상품</h2>
						<div class="wrap_sch_goods swiper swiper-goods">
							<ul class="fb__goods swiper-wrapper">
								<!--등록된 상품이 없을 시 S -->
								<li class="empty-content swiper-slide" id="devListEmpty" style="display: none !important">등록된 상품이 없습니다.</li>
								<!--등록된 상품이 없을 시 E -->
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart product-box__heart--active">hart</a>
								</li>
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart">hart</a>
								</li>
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart">hart</a>
								</li>
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart">hart</a>
								</li>
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart">hart</a>
								</li>
								<li class="fb__goods__list swiper-slide">
									<a href="javascript:void(0);" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">친환경 소재</li>
												<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
												<li class="fb__goods__option">아쿠아블루</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											<div class="fb__goods__sale">
												<p class="per"><em>10</em>%</p>
											</div>
											<span class="fb__goods__price">265,550</span>
											<span class="fb__goods__noprice">405,550</span>
											<!-- 품절일 경우 노출 S -->
											<span class="fb__goods__price__state" style="display: none">품절</span>
											<!-- 품절일 경우 노출 S -->
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>
									<a href="#" class="product-box__heart">hart</a>
								</li>
							</ul>
						</div>
						<button type="button" class="swiper-button swiper-goods-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
						<button type="button" class="swiper-button swiper-goods-button-next"><i class="ico ico-arrow-right"></i>다음</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 검색 창 레이어 E-->


	<div class="header__topMenu__layout">
		<div class="fb__headerMenu">
			<div class="header__logo">
				<a href="/"><img src="/assets/templet/enterprise/assets/img/shop_logo.svg" alt="BARREL" /></a>
			</div>
			<!-- 카테고리 S -->
			<div class="header__menu-group">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
				<div class="header__menu">
<?php if($TPL_V1["category_type"]=="C"){?>
						<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" <?php if($TPL_I1== 0){?> <?php }?><?php if($TPL_V1["is_layout_emphasis"]=="Y"){?> style="font-weight: 700;" <?php }?>><?php echo $TPL_V1["cname"]?> <?php if($TPL_V1["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }else{?>
						<a href="<?php echo $TPL_V1["category_link"]?>" <?php if($TPL_I1== 0){?> <?php }?><?php if($TPL_V1["is_layout_emphasis"]=="Y"){?> style="font-weight: 700;" <?php }?>><?php echo $TPL_V1["cname"]?> <?php if($TPL_V1["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }?>
					<!-- 서브 메뉴 레이어 S -->
					<div class="header__sub">
						<div class="sub">
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
<?php }}?>
								</li>
							</ul>
						</div>
					</div>
					<!-- 서브 메뉴 레이어 E -->
				</div>
<?php }}?>
			</div>
			<!-- 카테고리 E -->
		</div>
		<div class="header__topMenu__etcMenu">
			<ul>
				<li class="btn-inside">
					<a href="/content/specialList">배럴 인사이드</a>
					<div class="header__sub-inside" style="padding:80px 20px 80px 50px">
						<div class="sub__inside" style="height:100%;overflow:hidden;overflow-y:auto;padding-right:10px;">
							<ul class="sub__inside-menu">
								<li class="sub__inside-list">
									<h2 class="sub__inside-title">
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]=='001001000000000'){?>
											<a href="/content/specialList" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
<?php }?>
<?php }}?>
									</h2>
									<ul class="sub__inside-inner">
										<li class="sub__inside-item">
											<a href="/content/specialList">전체</a>
										</li>
<?php if($TPL_displayContentClassDepthList_1){foreach($TPL_VAR["displayContentClassDepthList"] as $TPL_V1){?>
											<li class="sub__inside-item">
												<a href="/content/specialList/<?php echo $TPL_V1["cid"]?>" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
											</li>
<?php }}?>
										<!--<li class="sub__inside-item">
											<a href="/content/focusNow2">배럴 저널</a>
										</li>
										<li class="sub__inside-item">
											<a href="/content/focusNow3">캠패인</a>
										</li>
										<li class="sub__inside-item">
											<a href="/content/focusNow4">브랜드 스토리</a>
										</li>-->
									</ul>
								</li>
							</ul>
							<ul class="sub__inside-menu">
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]!='001001000000000'){?>
										<li class="sub__inside-list">
											<h2 class="sub__inside-title"><a href="<?php if($TPL_V1["cid"]=='001002000000000'){?>/content/styleList<?php }elseif($TPL_V1["cid"]=='001003000000000'){?>/content/teamList<?php }elseif($TPL_V1["cid"]=='001004000000000'){?>/customer/bestReview<?php }?>" class="brandNav__main-link"><?php echo $TPL_V1["cname"]?></a></h2>
										</li>
<?php }?>
<?php }}?>
								<!--<li class="sub__inside-list">
									<h2 class="sub__inside-title"><a href="/content/specialList">스타일 큐레이션</a></h2>
								</li>
								<li class="sub__inside-list">
									<h2 class="sub__inside-title"><a href="/content/teamList">팀 배럴</a></h2>
								</li>
								<li class="sub__inside-list">
									<h2 class="sub__inside-title"><a href="/content/teamDetail">베스트 리뷰</a></h2>
								</li>-->
							</ul>
						</div>
						<div class="header__sub-inside--foot">
							<ul class="fb__header-sns">
								<li>
									<a href="https://www.instagram.com/getbarrel.official/">
										<i class="ico ico-instagram">인스타그램</i>
									</a>
								</li>
								<li>
									<a href="https://pf.kakao.com/_VxfxjDd" class="fb__sns--kakao">
										<i class="ico ico-KakaoTalk">카카오톡</i>
									</a>
								</li>
								<!--<li>
									<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="fb__sns&#45;&#45;facebook">
										<i class="ico ico-facebook">페이스북</i>
									</a>
								</li>-->
								<li>
									<a href="https://www.youtube.com/c/getbarrel" class="fb__sns--youtube">
										<i class="ico ico-youtube">유튜브</i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</li>
				<li><a href="/event/eventList">이벤트</a></li>
				<li class="btn-search">
					<a href="javascript:void(0);" class="btn_comm_sch openMask">
						<i class="ico ico-search">검색 버튼</i>
					</a>
				</li>
				<li class="btn-wishlist">
					<a href="/mypage/wishlist" class="wishlist">
						<i class="ico ico-wishlist">위시리스트</i>
					</a>
				</li>
				<li class="btn-cart">
					<a href="/shop/cart" class="cart">
						<i class="ico ico-cart">장바구니</i>
						<em id="cart_total_cnt" class="cart_total_cnt"><?php echo $TPL_VAR["layoutCommon"]["userInfo"]["cartCnt"]?></em>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>