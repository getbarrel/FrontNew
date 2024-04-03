<?php /* Template_ 2.2.8 2024/02/19 17:12:52 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/recent_view/recent_view.htm 000003848 */ ?>
<!-- 컨텐츠 S -->
<section class="br__recent">
<form id="devRecentViewForm">
	<input type="hidden" name="page" value="1" id="devPage"/>
	<input type="hidden" name="max" value="50"/>
	<input type="hidden" name="order" value="50"/>
	<div id="devRecentViewSelector"></div>
	<div class="page-title my-title">
		<div class="title-sm">최근 본 상품</div>
	</div>
	<!-- 상품 리스트 S -->
	<div class="br__goods-list__wrap br__goods-list__wrap--normal">
		<div class="goods-list">
			<ul class="goods-list__list" id="devRecentViewContent">

				<li class="goods-list__box devForbizTpl" id="devRecentViewList">
					<a href="/shop/goodsView/{[id]}" class="goods-list__link">
						<div class="goods-list__thumb">
							<div class="goods-list__thumb-slide swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<img src="{[image_src]}" alt="{[pname]}">
									</div>
									<!-- <div class="swiper-slide">
										<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
									</div>
									<div class="swiper-slide">
										<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
									</div> -->
								</div>
								<div class="swiper-control-group">
									<div class="swiper-scrollbar"></div>
								</div>
							</div>

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
							<!-- <div class="goods-list__pre br__goods__pre">친환경 소재</div> -->
							<div class="goods-list__title">{[pname]}</div>
							<div class="goods-list__color">{[add_info]}</div>
							<div class="goods-list__price">
								{[#if isDiscount]}
								<div class="goods-list__price__percent"><span>{[discount_rate]}</span>%</div>
								<div class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								<div class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><del>{[listprice]}</del><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								{[else]}
								<div class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								{[/if]}
								{[#if state_soldout ]}
								<div class="goods-list__price__state">[품절]</div>
								{[/if]}
							</div>
						</div>
					</a>
				</li>
				<li class="goods-list__box" id="devRecentViewLoading">
					<div class="empty-content">
						<div class="wrap-loading">
							<div class="loading"> <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" alt=""></div>
						</div>
					</div>
				</li>

				<li  class="goods-list__box devForbizTpl" id="devRecentViewEmpty">최근 본 상품이 없습니다.</li>
			</ul>
		</div>
	</div>
	<!-- 상품 리스트 E -->
	<div class="use-notice">
		<h3 class="use-notice__title">최근 본 상품 안내</h3>
		<ul class="use-notice__list">
			<li class="use-notice__desc">최근 본 상품은 30개까지 저장되며 순차적으로 삭제되며, 상품 보존 기간은 30일입니다.</li>
		</ul>
	</div>
</form>
</section>
<!-- 컨텐츠 E -->