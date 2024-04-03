<?php /* Template_ 2.2.8 2021/03/04 13:45:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/header/header_menu_bak.htm 000015167 */ ?>
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
								<a href="https://www.instagram.com/barrel.lifestyle/?hl=ko" class="header__sns__link header__sns__link--official" target="_blank">Barrel Official</a>
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
		<div class="header__campaign">
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
							<span class="header__sns__link ">
								<!--@TODO 오픈 이후 URL 확인 필요 -->
								<a href="/brand/cheering" target="_blank">Cheering Your Sweat</a>
							</span>
				</li>
			</ul>
		</div>
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
			<a href="/member/joinInput" class="join">Join</a>
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
				<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ko.gif" alt="korea">
<?php }elseif($TPL_VAR["langType"]=='english'){?>
				<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt="english">
<?php }else{?>
				<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ch.gif" alt="chinese">
<?php }?>
			</button>
			<ul class="header__topMenu__global__list">
				<li>
					<a href="//www.getbarrel.com/" class="global__btn__list ">
						<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ko.gif" alt=""><span class="global__btn <?php if($TPL_VAR["langType"]=='korean'){?>global__btn--active<?php }?>">KO</span>
					</a>
				</li>
				<li>
					<a href="//en.getbarrel.com/" class="global__btn__list">
						<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt=""><span class="global__btn <?php if($TPL_VAR["langType"]=='english'){?>global__btn--active<?php }?>">US</span>
					</a>
					<!--<a href="javascript:alert('영문몰 오픈 준비중입니다.');" class="global__btn__list">-->
						<!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt=""><span class="global__btn <?php if($TPL_VAR["langType"]=='english'){?>global__btn&#45;&#45;active<?php }?>">US</span>-->
					<!--</a>-->
				</li>
				<li>
					<a href="/event/eventDetail/12" class="global__btn__list ">
						<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ch.gif" alt=""><span class="global__btn">CH</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="header__topMenu__layout">
<div class="fb__headerMenu">
	<div class="header">
		<h1 class="header__logo">
			<a href="/"><img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/shop_logo.png"></a>
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
		<div class="header__menu ">
<?php if($TPL_V1["cname"]=="라이프 스타일"){?>
                <a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" <?php if($TPL_I1== 0){?> <?php }?>  style="font-weight: 700;"><?php echo $TPL_V1["cname"]?> <font style="color:#00BCE7">*</font></a>
<?php }else{?>
    			<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" <?php if($TPL_I1== 0){?> <?php }?>><?php echo $TPL_V1["cname"]?></a>
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
								<a href="/shop/subGoodsList/<?php echo $TPL_V2["cid"]?>">
									<?php echo $TPL_V2["cname"]?>

								</a>
							</h2>
							<ul class="sub__menu__inner">
<?php if(is_array($TPL_R3=$TPL_V2["subCateList"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
								<li class="sub__menu__list"><a href="/shop/subGoodsList/<?php echo $TPL_V3["cid"]?>"><?php echo $TPL_V3["cname"]?></a></li>
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
            <style>
                .fb__header .wrap-search-layer .wrap-tab-cont .tab-hot .ul-hot-search li a, .fb__header .wrap-search-layer .wrap-tab-cont .tab-hot .ul-hot-search li div {
                    color:#000;
                }
            </style>
			<button class="header__search__opener">검색열기/닫기 버튼</button>
			<fieldset class="search-area">
				<div class="search-area__inner">
					<input type="text" class="header-input-search search-area__text devAutoComplete" id="devHeaderSearchText" devTagUrl="<?php if(is_array($TPL_R1=$TPL_VAR["layoutCommon"]["headerTopSearchesTags"]["searchesTag"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["st_url"]?><?php }}?>" placeholder="<?php if(is_array($TPL_R1=$TPL_VAR["layoutCommon"]["headerTopSearchesTags"]["searchesTag"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> #<?php echo $TPL_V1["st_title"]?> <?php }}?>" value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);">
					<i class="search_close_btn" id="devSearchCloseBtn" style="display:none;"></i>
					<button class="search-area__del">삭제버튼</button>
					<input type="submit" id="devHeaderSearchButton">
				</div>
				<div class="wrap-search-layer">
					<ul class=" search-tab">
						<a href="#tab1" class="active">Popular Search</a>
						<a href="#tab2">Recent Search</a>
					</ul>
					<div class="wrap-tab-cont">
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
							<!--<ul  class="ul-hot-search">-->
								<!--&lt;!&ndash;<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["popularKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>&ndash;&gt;-->
<?php if($TPL_K1>= 10){?>
								<!--<li>-->
									<!--<a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1["keyword"])?>">-->
										<!--<div><em>&lt;!&ndash;<?php echo $TPL_K1+ 1?>&ndash;&gt;</em>&lt;!&ndash;<?php echo $TPL_V1["keyword"]?>&ndash;&gt;</div>-->
									<!--</a>-->
								<!--</li>-->
<?php }?>
								<!--&lt;!&ndash;<?php }}?>&ndash;&gt;-->
							<!--</ul>-->
						</div>
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
					<div class="wrap-search-layer__info">
						<!--<p>2019.04.23 화요일 15:00 기준</p>-->
						<a href="#" id="devRecentKeyWordDeleteAll">Delete all</a>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>
</div>
<!--<a href="#" class="nav__all-btn" >Menu</a>-->
<!--<a href="/event/eventList" class="font-en">EVENT</a>-->
<!--<a href="/event/promotion/" class="font-en">Special deal</a>-->
<!--<a href="/best/best" class="font-en">Best</a>-->