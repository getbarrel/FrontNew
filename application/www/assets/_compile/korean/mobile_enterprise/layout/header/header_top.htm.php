<?php /* Template_ 2.2.8 2024/03/19 10:50:14 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_top.htm 000008756 */ 
$TPL_topBeltBanner_1=empty($TPL_VAR["topBeltBanner"])||!is_array($TPL_VAR["topBeltBanner"])?0:count($TPL_VAR["topBeltBanner"]);?>
<?php if($TPL_VAR["topBeltBanner"]){?>
<section class="header__banner swiper-container" style="display:none;">
    <div class="swiper-wrapper">
<?php if($TPL_topBeltBanner_1){foreach($TPL_VAR["topBeltBanner"] as $TPL_V1){?>
        <div class="swiper-slide">
            <a href="<?php echo $TPL_V1["bannerLink"]?>" class="header__banner__link">
                <figure class="header__banner__image">
                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                    <!--<img src="//getbarrel.com/data/barrel_data/images/banner/798/상단띠배너.jpg" alt="<?php echo $TPL_V1["banner_name"]?>">-->
                </figure>
            </a>
        </div>
<?php }}?>
    </div>
    <button type="button" class="header__banner__close">상단 띠배너 닫기</button>
</section>
<?php }?>
<section class="br__header__inner">
	<div class="inner">
		<div class="br__header-right">
			<a href="javascript:history.back()" class="btn-prev"><i class="ico ico-arrow-left-big"></i>이전으로</a>
		</div>
		<h1 class="inner__logo">
			<a href="/">BARREL</a>
		</h1>
		<div class="br__header-left">
			<button id="icon_search" class="inner__search btn-search" onclick="searchLayerJS();"><i class="ico ico-search"></i>search</button>
			<a href="/shop/cart" class="inner__cart btn-cart"><i class="ico ico-cart"></i>cart<em class="inner__cart__count"><?php echo number_format($TPL_VAR["layoutCommon"]["userInfo"]["cartCnt"])?></em></a>
		</div>
	</div>
</section>

<!-- 상단 검색 레이어 S -->
<section class="br__search" style="display:none;">
	<div class="br__search-inner">
        <script type="text/javascript">
            function igChk(){
                var ig_chkVal = document.getElementById("devHeaderSearchText").value;
                if(ig_chkVal == "") {
                    $(".br__search__layer").css("display", "none");
                }
            }
        </script>
		<div class="br__search__title">
			<div class="wrap_search-bar">
				<label for="devHeaderSearchText" class="hide">검색어 입력 영역</label>
				<input class="search-input br__form-input devAutoComplete" type="text" id="devHeaderSearchText" placeholder="검색어를 입력해 주세요." onblur="removeHeaderTag(this.value);" onkeyup="igChk()" data-id="devHeaderSearchText"/>
				<button class="search-btn" id="devHeaderSearchButton">
					<i class="ico ico-search"></i>
				</button>
			</div>
			<div class="wrap_search-close">
				<button class="search-close" title="닫기" onclick="searchLayerClose()">닫기</button>
			</div>
		</div>

		<!-- 검색 자동완성 S -->
		<article class="br__search__layer" style="display:none;">
			<div class="auto-complete">
				<ul class="auto-complete__list">
					<!--<li><a href="#"><em>Rashguard</em></a><button></button></li>
					<li><a href="#">Bra-top <em>Rashguard</em></a><button></button></li>
					<li><a href="#">ODD <em>Rashguard</em></a><button></button></li>
					<li><a href="#">Loose fit <em>Rashguard</em></a><button></button></li>
					<li><a href="#">Zip-up <em>Rashguard</em></a><button></button></li>-->
				</ul>
			</div>
		</article>
		<!-- 검색 자동완성 E -->

		<!-- 최근검색어, 인기검색어 리스트 S -->
		<div class="br__search__content">
			<!-- 최근 검색어 S -->
			<div class="late__word">
				<div class="search-title">
					<div class="titls-md">최근 검색어</div>
					<!-- 최근 검색 내역이 있을 경우 노출 S -->
					<!-- 현재 숨김처리 -->
					<button type="button" class="btn-del-all" id="devRecentKeyWordDeleteAll" <?php if($TPL_VAR["headerTop"]["recentKeyword"]){?>style="display:none;"<?php }?>>전체삭제</button>
					<!-- 최근 검색 내역이 있을 경우 노출 E -->
				</div>
				<div id="tab2" class="tab-recent">
<?php if($TPL_VAR["headerTop"]["recentKeyword"]){?>
					<ul class="search__list" id="devRecent">
						<!-- 검색어가 없을 경우 E -->
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["recentKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
						<li devDelKey="<?php echo $TPL_K1?>">
							<a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1)?>"><?php echo $TPL_V1?></a>
							<button class="search__word-del btn-del devRecentKeyWordDelete" devDelText="<?php echo $TPL_V1?>"><i class="ico ico-del"></i>삭제</button>
						</li>
<?php }}?>
					</ul>
<?php }else{?>
					<div class="empty-content no-data" style="padding:20px 0 0 0">
						최근 입력한 검색어가 없습니다.
					</div>
<?php }?>
				</div>
			</div>
			<!-- 최근 검색어 E -->

			<!-- 인기 검색어 S -->
			<div class="popularity__word">
				<div class="search-title">
					<div class="titls-md">인기 검색어</div>
				</div>
				<ul class="search__list">
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["popularKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 10){?>
					<li>
						<a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1["keyword"])?>"><?php echo $TPL_V1["keyword"]?></a>
					</li>
<?php }?>
<?php }}?>
				</ul>
			</div>
			<!-- 인기 검색어 E -->

			<!-- 가장 인기 있는 상품 S -->
			<div class="search-goods" style="display:none;">
				<div class="search-title">
					<div class="titls-md">가장 인기있는 상품</div>
				</div>
				<div class="search-goods__slide">
					<div class="goods-list goods-list__slide swiper-container">
						<ul class="goods-list__list swiper-wrapper">
							<li class="goods-list__box swiper-slide">
								<a href="#;" class="goods-list__link">
									<div class="goods-list__thumb">
										<div class="goods-list__thumb-slide swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
												</div>
												<div class="swiper-slide">
													<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
												</div>
												<div class="swiper-slide">
													<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
												</div>
											</div>
											<div class="swiper-control-group">
												<div class="swiper-scrollbar"></div>
											</div>
										</div>
										<!-- 버튼으로 할 경우 S -->
										<!-- 숨김처리 -->
										<button type="button" class="btn-wishlist" style="display: none">
											<!-- 선택시 button class = active 추가-->
											<i class="ico ico-wishlist"></i>위시리스트
										</button>
										<!-- 버튼으로 할 경우 E -->

										<!-- 체크 박스로 할 경우 S -->
										<label class="goods-list__wish">
											<input type="checkbox" class="goods-list__wish__btn" />
										</label>
										<!-- 체크 박스로 할 경우 E -->
									</div>
									<div class="goods-list__info">
										<div class="goods-list__pre br__goods__pre">친환경 소재</div>
										<div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
										<div class="goods-list__color">아쿠아블루</div>
										<div class="goods-list__price">
											<div class="goods-list__price__percent"><span>40</span>%</div>
											<div class="goods-list__price__discount"><span>265,550</span></div>
											<div class="goods-list__price__cost"><del>405,550</del></div>
											<!-- 품절일 경우 S -->
											<!-- 숨김 처리 -->
											<div class="goods-list__price__state" style="display: none">품절</div>
											<!-- 품절일 경우 E -->
										</div>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- 가장 인기 있는 상품 E -->
		</div>
		<!-- 최근검색어, 인기검색어 리스트 E -->
	</div>
</section>
<!-- 상단 검색 레이어 E -->

<?php if($TPL_VAR["headerTop"]["randomCoupon"]){?>
<div id="devRandomCouponArea" class="randomCoupon"  data-percent="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["percentage"]?>">
	<img src="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gift_file_path"]?>" alt="쿠폰이미지">
	<input type="button" value="쿠폰발행" id="devRandomCouponIssue" data-gcix="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gc_ix"]?>" />
</div>
<?php }?>