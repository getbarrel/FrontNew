<?php /* Template_ 2.2.8 2024/03/19 13:32:09 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_list/goods_list.htm 000010455 */ 
$TPL_bannerInfo_1=empty($TPL_VAR["bannerInfo"])||!is_array($TPL_VAR["bannerInfo"])?0:count($TPL_VAR["bannerInfo"]);?>
<script>
    var productList = [];
</script>

<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" id="devMax" />
    <input type="hidden" name="filterCid" value="<?php echo $TPL_VAR["cid"]?>" id="devCid"/>
<?php if($TPL_VAR["category_sort"]==""){?>
	<input type="hidden" name="orderBy" value="viewOrder" id="devSort"/>
<?php }else{?>
    <input type="hidden" name="orderBy" value="<?php echo $TPL_VAR["category_sort"]?>" id="devSort"/>
<?php }?>
    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
</form>
<!-- 컨텐츠 영역 S -->
<!-- 상품 리스트 S -->
<!-- 대분류 배너 영역 S -->
<?php if($TPL_VAR["bannerInfo"]){?>
<section class="fb__goods-list__banner">
	<section class="fb__subGoods-list" style="min-height:0px;">
		<div class="banner">
			<div class="banner__sliderWrap fb__main__slider fb__subGoods-list__slider">
				<div class="banner__slider swiper-container">
					<div class="swiper-wrapper">
<?php if($TPL_bannerInfo_1){foreach($TPL_VAR["bannerInfo"] as $TPL_V1){?>
						<div class="banner__sliderList swiper-slide">
							<div class="banner__sliderList-group">
								<div class="banner__sliderList-brand"><?php echo $TPL_V1["shot_title"]?></div>
								<div class="banner__sliderList-title" style="text-align:<?php if($TPL_V1["s_name"]=='L'){?>left<?php }elseif($TPL_V1["s_name"]=='C'){?>center<?php }elseif($TPL_V1["s_name"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_name"]?>;<?php if($TPL_V1["b_name"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_name"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_name"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo $TPL_V1["banner_name"]?>

								</div>
								<p style="text-align:<?php if($TPL_V1["s_desc"]=='L'){?>left<?php }elseif($TPL_V1["s_desc"]=='C'){?>center<?php }elseif($TPL_V1["s_desc"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_desc"]?>;<?php if($TPL_V1["b_desc"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_desc"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_desc"]=='Y'){?>text-decoration-line: underline;<?php }?>">
									<?php echo $TPL_V1["banner_desc"]?>

								</p>
							</div>
							<div class="banner__sliderList-img">
								<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="" />
							</div>
						</div>
<?php }}?>
					</div>
					<div class="banner__slider-nav">
						<div class="swiper-control-group">
							<div class="swiper-scrollbar"></div>
							<div class="swiper-pagination"></div>
							<button type="button" class="swiper-button swiper-button-prev"></button>
							<button type="button" class="swiper-button swiper-button-next"></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<?php }?>
<!-- 대분류 배너 영역 E -->
<section class="fb__goods-list">

	<section class="fb__goods-list__contents">
		<div class="list-contents">
			<div class="list-contents__header">
				<h3 class="fb__main__title--hidden">상품 리스트</h3>
				<nav class="list-contents__nav">
					<div class="filter">
                        <select name="count" class="fb__select" id="devMaxTab">
                            <option value="20" selected="selected">20개씩 보기</option>
                            <option value="40">40개씩 보기</option>
                            <option value="60" >60개씩 보기</option>
                        </select>
                        <select name="sort" class="fb__select" id="devSortTab">
                            <option value="regdateDesc" >최신상품순</option>
                            <option value="orderCnt" >인기상품순</option>
                            <option value="lowPrice" >낮은가격순</option>
                            <option value="highPrice" >높은가격순</option>
                            <option value="afterCnt" >상품후기순</option>
                            <option value="viewOrder" selected="selected" >배럴추천순</option>
                        </select>
					</div>
				</nav>
			</div>
			<div class="fb__main__goods fb__main__goodsInner">
				<!--필터 검색 시 검색 결과가 없을 시 S -->
				<div id="devFilterEmpty" class="empty-content" style="display: none">
					<p>검색어가 올바르게 입력되었는지 확인해 주세요.</p>
					<span>일반적인 검색어로 다시 검색해 주세요<br>감색어의 띄어쓰기를 다르게 해보세요.</span>
					<!-- <p>선택하신 조건에 대한 검색 결과가 없습니다.<br><br><span>다른 옵션을 선택하여 검색해 보세요.</span></p> -->
				</div>
				<!--필터 검색 시 검색 결과가 없을 시 E -->
				<ul class="fb__goods three-boxes-wrap" id="devListContents">
					<!--상품 로딩 시 S -->
					<li class="empty-content devListLoading" id="devListLoading">loading...</li>
					<!--상품 로딩 시 S -->

					<!--등록된 상품이 없을 시 S -->
					<li class="empty-content" id="devListEmpty" style="display: none">등록된 상품이 없습니다.</li>
					<!--등록된 상품이 없을 시 E -->

                    <li class="fb__goods__list" id="devListDetail" data-fatid="{[id]}">
						<script> productList.push("{[id]}"); </script>
                        <!-- Criteo 카테고리/검색/리스팅 태그 23.06.29-->
                        <script type="text/javascript">
                            if (productList.length == 4) {
                                window.criteo_q = window.criteo_q || [];
                                var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
                                window.criteo_q.push(
                                    { event: "setAccount", account: 104564},
                                    { event: "setEmail", email: "", hash_method: "" },
                                    { event: "setZipcode", zipcode: "" },
                                    { event: "setSiteType", type: deviceType},
                                    { event: "viewList",
                                        item: [productList[1], productList[2], productList[3]],
                                        category: "<?php echo $TPL_VAR["cid"]?>"
                                    });
                            }
                        </script>
                        <!-- END Criteo 카테고리/검색/리스팅 태그 -->
						<a href="/shop/goodsView/{[id]}" class="fb__goods__link">
							<figure class="fb__goods__img">
                                {[#if timeSaleIconView]}
                                <img src="{[timeSaleIcon]}" class="product-box__time-deal" >
                                {[/if]}
								<div>
                                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}" onmouseover="this.src='{[image_src2]}'" onmouseout="this.src='{[image_src]}'">
								</div>
							</figure>
							<div class="fb__goods__info">
                                <div class="fb__badge">
                                    {[#each icons_path]}
                                    <span class="fb__badge--water">
                                        {[{this}]}
                                    </span>
                                    {[/each]}
                                </div>
                                <ul class="fb__goods__infoBox">
                                    {[#if prefaceName]}
									<li class="fb__goods__etc" style="color:{[prefaceColor]};{[b_preface]}{[i_preface]}{[u_preface]}">
                                      {[prefaceName]}
                                    </li>
									{[/if]}
                                    <li class="fb__goods__name">
                                        {[pname]}
                                    </li>
                                    <li class="fb__goods__option">
                                        {[add_info]}
                                    </li>
                                    <li class="fb__goods__brand">
                                        {[brand_name]}
                                    </li>
                                </ul>
							</div>
							<div class="fb__goods__important">
								<!-- 품절일 경우 노출 S -->
								{[#if is_soldout]}
									<!--span class="fb__goods__price__state" style="color:#ff4e00;font-size:10px;">[품절]</span-->
									<span class="goods-list__price__state" style="color:#ff4e00;font-size:12px;">[품절]</span>
								{[else]}
									{[#if discount_rate]}
									<span class="fb__goods__sale">
											<p class="per"><em>{[discount_rate]}</em>%</p>
										</span>
									{[/if]}
									<span class="fb__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[dcprice]}<?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></span>
									<span class="fb__goods__noprice">{[#if isDiscount]}<?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?>{[/if]}</span>
								{[/if]}
								<!-- 품절일 경우 노출 S -->
							</div>
							<p class="fb__goods__condition">{[#if deliveryText]}<p class="per"><em>{[discount_rate]}</em>%</p>{[else]} 배송정보 정책 미입력 {[/if]}</p>
						</a>
						<a href="javascript:void(0);" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]}" data-devWishBtn="{[id]}">hart</a>
					</li>
				</ul>
			</div>
		</div>
	</section>
</section>
<!-- 상품 리스트 E -->

<div id="devPageWrap"></div>
<!-- 페이지네이션 S -->
<div id="devPageWrap">
	<div class="wrap-pagination"></div>
</div>
<!-- 페이지네이션 E -->

<!-- 컨텐츠 영역 E -->