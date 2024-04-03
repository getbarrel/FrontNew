<?php /* Template_ 2.2.8 2024/02/15 17:04:09 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/wishlist/wishlist.htm 000006140 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage wrap-mypage fb__wishlist">
	<div class="fb__mypage-title">
		<div class="title-md">위시리스트</div>
	</div>
	<section class="fb__wishlist-wrap">
		<div class="fb-tab__wrap fb-tab__col">
			<div class="fb-tab__nav">
				<ul>
					<li class="active">
						<a href="javascript:void(0);">상품 (<span id="devTotal">0</span>)</a>
					</li>
					<li>
						<a href="javascript:void(0);">컨텐츠 (<span><?php echo $TPL_VAR["ContentWishList"]["total"]?></span>)</a>
					</li>
				</ul>
			</div>
			<form id="devMyWishForm">
			<input type="hidden" name="page" id="devPage" value="1"/>
			<input type="hidden" name="max" id="devMax" value="20"/>
			<div class="fb-tab__contents-wrap">
				<div class="fb-tab__contents active">
					<div class="fb__wishlist-list">
						<ul class="fb__goods col-3" id="devMyWishContent">

							<li id="devMyWishList" class="fb__goods__list">
								<a href="/shop/goodsView/{[id]}" class="fb__goods__link">
									<figure class="fb__goods__img">
										<div>
											<img src="{[image_src]}" alt="{[pname]}">
										</div>
									</figure>
									<div class="fb__goods__info">
										<ul class="fb__goods__infoBox">
											<li class="fb__goods__etc">
												{[#each icons_path]}
												<span class="fb__badge--water">
													{[{this}]}
												</span>
												{[/each]}
											</li>
											<li class="fb__goods__name">{[pname]}</li>
											<li class="fb__goods__option">{[add_info]}</li>
											<li class="fb__goods__brand"></li>
										</ul>
									</div>
									<div class="fb__goods__important">
										{[#if state_soldout]}
										<span class="fb__goods__price__state" style="display: none">[품절]</span>
										{[else]}
										{[#if isPercent]}
										<div class="fb__goods__sale"><p class="per"><em>{[discount_rate]}</em>%</p></div>
										{[/if]}
										{[/if]}
										<span class="fb__goods__price">{[dcprice]}</span>
										{[#if isDiscount]}
										<span class="fb__goods__noprice">{[listprice]}</span>
										{[/if]}
									</div>
									<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
								</a>

								<a href="javascript:void(0);" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]} " data-devWishBtn='{[id]}'>hart</a>
							</li>

							<li id="devMyWishLoading" class="devForbizTpl empty-content">
								<div class="wrap-loading">
									<div class="loading"></div>
								</div>
							</li>
							<li id="devMyWishEmpty" class="devForbizTpl empty-content">
								<p>위시리스트가 없습니다.</p>
							</li>
						</ul>
					</div>
					<!--<div id="devPageWrap"></div>-->
				</div>
				</form>
				<div class="fb-tab__contents">
					<div class="fb__wishlist-list">
						<ul class="fb__goods col-3">
<?php if($TPL_VAR["ContentWishList"]["total"]== 0){?>
								<li class="devForbizTpl">
									<p>컨텐츠 위시리스트가 없습니다.</p>
								</li>
<?php }else{?>
<?php if(is_array($TPL_R1=$TPL_VAR["ContentWishList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<li class="fb__goods__list">
										<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }elseif($TPL_V1["display_gubun"]=='M'){?>/content/focusNow4/<?php }elseif($TPL_V1["display_gubun"]=='S'){?>/content/styleDetail/<?php }elseif($TPL_V1["display_gubun"]=='E'){?>/event/eventDetail/<?php }?><?php echo $TPL_V1["con_ix"]?>">
											<figure class="fb__goods__img">
												<div>
													<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="<?php echo $TPL_V1["title"]?>">
												</div>
											</figure>
										</a>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__name"><?php if($TPL_V1["display_gubun"]=='E'){?>[이벤트]<?php }else{?>[기획전]<?php }?><?php echo $TPL_V1["title"]?></li>
												<li class="fb__goods__option"><?php echo $TPL_V1["explanation"]?></li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<a href="javascript:void(0);" class="product-box__heart product-box__heart--active " onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>', this)">hart</a>
									</li>
<?php }}?>
								<!--li class="fb__goods__list">
									<a href="/shop/goodsView/{[id]}" class="fb__goods__link">
										<figure class="fb__goods__img">
											<div>
												<img src="{[image_src]}" alt="{[pname]}">
											</div>
										</figure>
										<div class="fb__goods__info">
											<ul class="fb__goods__infoBox">
												<li class="fb__goods__etc">
													{[#each icons_path]}
													<span class="fb__badge--water">
													{[{this}]}
												</span>
													{[/each]}
												</li>
												<li class="fb__goods__name">{[pname]}</li>
												<li class="fb__goods__option">{[add_info]}</li>
												<li class="fb__goods__brand"></li>
											</ul>
										</div>
										<div class="fb__goods__important">
											{[#if state_soldout]}
											<span class="fb__goods__price__state" style="display: none">[품절]</span>
											{[else]}
											{[#if isPercent]}
											<div class="fb__goods__sale"><p class="per"><em>{[discount_rate]}</em>%</p></div>
											{[/if]}
											{[/if]}
											<span class="fb__goods__price">{[dcprice]}</span>
											{[#if isDiscount]}
											<span class="fb__goods__noprice">{[listprice]}</span>
											{[/if]}
										</div>
										<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
									</a>

									<a href="javascript:void(0);" class="product-box__heart product-box__heart--active " data-devWishBtn='{[id]}'>hart</a>
								</li-->
<?php }?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->