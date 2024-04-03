<?php /* Template_ 2.2.8 2024/03/20 09:54:49 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/wishlist/wishlist.htm 000005956 */ ?>
<!-- 컨텐츠 S -->
<section class="br__wishlist">
	<div class="page-title my-title">
		<div class="title-sm">위시리스트</div>
	</div>
	<div class="br-tab__wrap">
		<div class="br-tab__nav">
			<ul>
				<li class="active">
					<a href="#;">상품 (<em id="devTotal">0</em>)</a>
				</li>
				<li>
					<a href="#;">컨텐츠 <em>(<?php echo $TPL_VAR["ContentWishList"]["total"]?>)</em></a>
				</li>
			</ul>
		</div>
		<form id="devMyWishForm">
		<input type="hidden" name="page" id="devPage" value="1"/>
		<input type="hidden" name="max" id="devMax" value="20"/>
		<div class="br-tab__contents-wrap">
			<div class="br-tab__contents active">
				<!-- 상품 리스트 S -->
				<div class="br__goods-list__wrap br__goods-list__wrap--normal">
					<div class="goods-list">
						<ul class="goods-list__list" id="devMyWishContent">
							<li class="empty-content devForbizTpl" id="devMyWishEmpty">관심 상품이 없습니다.</li>
							
							<li id="devMyWishLoading" class="br-loading devForbizTpl">
								<div class="empty-content order-list">
									<div class="wrap-loading">
										<div class="loading"></div>
									</div>
								</div>
							</li>
							<!-- 로딩우 E -->


							<li class="goods-list__box"  id="devMyWishList">
								<a href="/shop/goodsView/{[id]}" class="goods-list__link">
									<div class="goods-list__thumb">
										<div class="goods-list__thumb-slide swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img src="{[image_src]}" alt="{[pname]}">
												</div>
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
											<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[id]}" onclick="productWish('{[id]}')"  devWishBtn='{[id]}' checked/>
										</label>
										<!-- 체크 박스로 할 경우 E -->
									</div>
									<div class="goods-list__info">
										<!-- <div class="goods-list__pre br__goods__pre">{[#each icons_path]}{[{this}]}{[/each]}</div> -->
										<div class="goods-list__title">{[pname]}</div>
										<div class="goods-list__color">{[add_info]}</div>
										<div class="goods-list__price">
											{[#if isPercent]}
											<div class="goods-list__price__percent"><span>{[discount_rate]}</span>%</div>
											{[/if]}
											<div class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
											{[#if isDiscount]}
											<div class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><del>{[listprice]}</del><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
											{[/if]}
											<!-- 품절일 경우 S -->
											{[#if state_soldout]}
											<div class="goods-list__price__state">[품절]</div>
											{[/if]}
										</div>
									</div>
								</a>
								<!-- <span devWishBtn='{[id]}' class="wish__each__wish on">wish아이콘</span> -->
							</li>
						</ul>
					</div>
				</div>
				<!-- 상품 리스트 E -->
			</div>

			<div class="br-tab__contents">
				<!-- 상품 리스트 S -->
				<div class="br__goods-list__wrap br__goods-list__wrap--normal">
					<div class="goods-list">
						<ul class="goods-list__list">
<?php if(is_array($TPL_R1=$TPL_VAR["ContentWishList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li class="goods-list__box" style="height:335px;">
							<div class="br-main__card-title--sm"><?php if($TPL_V1["display_gubun"]=='E'){?>[이벤트]<?php }else{?>[기획전]<?php }?></div>
								<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }elseif($TPL_V1["display_gubun"]=='M'){?>/content/focusNow4/<?php }elseif($TPL_V1["display_gubun"]=='S'){?>/content/styleDetail/<?php }elseif($TPL_V1["display_gubun"]=='E'){?>/event/eventDetail/<?php }?><?php echo $TPL_V1["con_ix"]?>">
									<div class="goods-list__thumb">
										<div class="goods-list__thumb-slide swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="<?php echo $TPL_V1["title"]?>" style="height:228px;">
												</div>
											</div>
										</div>
										
										<button type="button" class="btn-wishlist" style="display: none">
											<i class="ico ico-wishlist"></i>위시리스트
										</button>
										<!-- 체크 박스로 할 경우 S --> 
										<label class="goods-list__wish">
											<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["con_ix"]?>" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', 'C', this)"  devWishBtn='<?php echo $TPL_V1["con_ix"]?>' checked/>
										</label>

										<!-- 체크 박스로 할 경우 E -->
									</div>
									<div class="goods-list__info">
										<div class="goods-list__title"><?php echo $TPL_V1["title"]?>&nbsp;</div>
										<div class="goods-list__color"><?php echo $TPL_V1["explanation"]?>&nbsp;</div>
									</div>
								</a>
								<!-- <span devWishBtn='<?php echo $TPL_V1["con_ix"]?>' class="wish__each__wish on" style="margin-left:160px; margin-top:-8px; position:relative; z-index:9999">wish아이콘</span> -->
							</li>
<?php }}?>
						</ul>
					</div>
				</div>
				<!-- 상품 리스트 E -->
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->