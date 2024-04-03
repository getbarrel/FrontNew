<?php /* Template_ 2.2.8 2024/03/18 19:02:42 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_list/goods_list.htm 000009954 */ 
$TPL_bannerInfo_1=empty($TPL_VAR["bannerInfo"])||!is_array($TPL_VAR["bannerInfo"])?0:count($TPL_VAR["bannerInfo"]);?>
<!-- 변수 선언 23.06.29 -->
<script>
    var productList = [];
</script>
<!-- 변수 선언 23.06.29 -->

<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" />
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
<section class="br__goods-list">
	<div class="br__goods-tab">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide <?php if($TPL_VAR["cid"]==$TPL_VAR["topCateCid"]){?>active<?php }?>">
<?php if($TPL_VAR["cateDepth"]== 0){?>
						<a href="/shop/goodsList/<?php echo $TPL_VAR["topCateCid"]?>"><?php echo $TPL_VAR["cateName"]?></a>
<?php }else{?>
						<a href="/shop/goodsList/<?php echo $TPL_VAR["topCateCid"]?>">상위</a>
<?php }?>
				</li>
<?php if(is_array($TPL_R1=$TPL_VAR["cateArrList"]["subCate"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<li class="swiper-slide <?php if($TPL_VAR["cid"]==$TPL_V1["cid"]){?>active<?php }?>">
						<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["cname"]?></a>
					</li>
<?php }}?>
			</ul>
		</div>
	</div>

	<!--<div class="br__goods-banner">
		<div class="br__slide swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<a href=""><img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_banner_img.png" alt="" /></a>
					<div class="br__goods-banner&#45;&#45;title">
						<div class="title-md">
							우먼 리플렉션 아쿠아<br />
							브릿지백 스트랩 스윔슈트
						</div>
						<p>
							온/오프라인 배럴 전 제품 15만원 이상 구매 시<br />
							스페셜 기프트 증정!
						</p>
					</div>
				</div>
				<div class="swiper-slide">
					<a href=""><img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_banner_img.png" alt="" /></a>
					<div class="br__goods-banner&#45;&#45;title">
						<div class="title-md">
							우먼 리플렉션 아쿠아<br />
							브릿지백 스트랩 스윔슈트
						</div>
						<p>
							온/오프라인 배럴 전 제품 15만원 이상 구매 시<br />
							스페셜 기프트 증정!
						</p>
					</div>
				</div>
			</div>
			<div class="br__slide-control" style="padding:165px 1.8rem;">
				<div class="swiper-control-group">
					<div class="swiper-scrollbar popup-swiper-scrollbar"></div>
					<div class="swiper-pagination popup-swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>-->

<?php if($TPL_VAR["bannerInfo"]){?>
	<div class="br__goods-banner">
		<div class="br__slide swiper-container">
			<div class="swiper-wrapper">
<?php if($TPL_bannerInfo_1){foreach($TPL_VAR["bannerInfo"] as $TPL_V1){?>
				<div class="swiper-slide">
					<a href=""><img src="<?php echo $TPL_V1["imgSrcOn"]?>" alt="" /></a>
					<div class="br__goods-banner--title">
						<div class="title-md" style="text-align:<?php if($TPL_V1["s_name_m"]=='L'){?>left<?php }elseif($TPL_V1["s_name_m"]=='C'){?>center<?php }elseif($TPL_V1["s_name_m"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_name_m"]?>;<?php if($TPL_V1["b_name_m"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_name_m"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_name_m"]=='Y'){?>text-decoration-line: underline;<?php }?>">
							<?php echo $TPL_V1["banner_name_m"]?>

						</div>
						<p style="text-align:<?php if($TPL_V1["s_desc_m"]=='L'){?>left<?php }elseif($TPL_V1["s_desc_m"]=='C'){?>center<?php }elseif($TPL_V1["s_desc_m"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_desc_m"]?>;<?php if($TPL_V1["b_desc_m"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_desc_m"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_desc_m"]=='Y'){?>text-decoration-line: underline;<?php }?>">
							<?php echo nl2br($TPL_V1["banner_desc_m"])?>

						</p>
					</div>
				</div>
<?php }}?>
			</div>
			<div class="br__slide-control" style="padding:168px 1.8rem;">
				<div class="swiper-control-group">
					<div class="swiper-scrollbar popup-swiper-scrollbar"></div>
					<div class="swiper-pagination popup-swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>
<?php }?>

	<!-- 상품 리스트 S -->
	<div class="br__goods-list__wrap br__goods-list__wrap--normal">
		<div class="goods-list">
			<ul class="goods-list__list" id="devListContents">
				<li id="devListLoading" class="br-loading devForbizTpl">
					Loading...
				</li>


				<li id="devListEmpty" class="goods-list__box no-data devForbizTpl">
					<p class="empty-content">등록된 상품이 없습니다.</p>
				</li>
				<li class="goods-list__box" id="devListDetail">
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
					<div class="goods-list__thumb">
						<a href="/shop/goodsView/{[id]}" class="goods-list__link">
							<div class="goods-list__thumb-slide swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}" alt="{[pname]}">
									</div>
									<div class="swiper-slide">
										<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src2]}" alt="{[pname]}">
									</div>
								</div>
								<div class="swiper-control-group">
									<div class="swiper-scrollbar"></div>
								</div>
							</div>
						</a>
						<!-- 버튼으로 할 경우 S -->
						<!-- 숨김처리 -->
						<button type="button" class="btn-wishlist {[#if alreadyWish]}active{[/if]}" data-devWishBtn="{[id]}" style="display: none">
							<!-- 선택시 button class = active 추가-->
							<i class="ico ico-wishlist"></i>위시리스트
						</button>
						<!-- 버튼으로 할 경우 E -->

						<!-- 체크 박스로 할 경우 S -->
						<label class="goods-list__wish" devwishbtn="{[id]}">
							{[#if alreadyWish]}
							<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[id]}" onclick="productWish('{[id]}')" checked>
							{[else]}
							<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[id]}" onclick="productWish('{[id]}')">
							{[/if]}
						</label>
						<!-- 체크 박스로 할 경우 E -->
					</div>
					<a href="/shop/goodsView/{[id]}" class="goods-list__link">
						<div class="goods-list__info">
							{[#if prefaceName]}<div class="goods-list__pre br__goods__pre" style="color:{[prefaceColor]};{[b_preface]}{[i_preface]}{[u_preface]}">{[prefaceName]}</div>{[/if]}
							<div class="goods-list__title">{[pname]}</div>
							<div class="goods-list__color">{[add_info]}</div>
							<div class="goods-list__price">
								{[#if is_soldout]}
									<div class="goods-list__price__state">[품절]</div>
								{[else]}
									{[#if isPercent]}
									<div class="goods-list__price__percent"><span>{[discount_rate]}</span>%</div>
									{[/if]}
									<div class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></div>
									{[#if isDiscount]}
									<div class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><del>{[listprice]}</del><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></div>
									{[/if]}
								{[/if]}
							</div>
						</div>
					</a>
				</li>
			</ul>
            <div id="devPageWrap">
                <div class="br__more devPageBtnCls"></div>
            </div>
			<div id="devListLoading" class="br-loading">
				<!-- 로딩 아이콘 S -->
				<span class="ico ico-loading">
					<span></span>
					<span></span>
					<span></span>
				</span>
				<!-- 로딩 아이콘 S -->
			</div>

		</div>
	</div>
	<!-- 상품 리스트 E -->
</section>
<!-- 컨텐츠 영역 S -->