<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/wishlist/wishlist.htm 000002685 */ ?>
<section class="br__wishlist">
	<h2 class="br__cs__title">
		Wish list
	</h2>
	<span class="br__wishlist__desc">Option items can be selected on the product details page.</span>
	<div class="wish wrap-mypage js__check-wrap">
		<form id="devMyWishForm">
			<input type="hidden" name="page" value="1" id="devPage"/>
			<input type="hidden" name="max" value="10"/>
			<div class="wish__top clearfix">
				<label class="wish__check--all" for="all_check">
					<input type="checkbox" class="js__check-all" id="all_check">
					<span>Select All </span>
				</label>
				<span class="wish__total">Total <em id="devTotal">0</em></span>
				<button class="wish__del" id='devBtnDelWish'>Delete Selection</button>
			</div>
			<ul class="wish__list " id="devMyWishContent">
				<li class="wish__each devForbizTpl" id="devMyWishList">
					<label class="wish__check--each" for="wishList_{[index_]}" >
						<input type="checkbox" id="wishList_{[index_]}" name="wishList[]" value="{[id]}"  class="js__check-porsonal item-check">
					</label>
					<a href="/shop/goodsView/{[id]}">
						<div class="wish__each__item">
							<figure class="wish__each__thumb">
								<img src="{[image_src]}" alt="{[pname]}">
							</figure>
							<div class="wish__each__info">
								<p class="wish__each__title">{[pname]}</p>
								<p class="wish__each__option">{[add_info]}</p>
								<div class="wish__each__price">
									{[#if state_soldout]}
										<p class="wish__each__soldout">Out of stock</p>
									{[/if]}
									{[#if isDiscount]}
									<span class="wish__each__price--ori"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									{[/if]}
									<span class="wish__each__price--now"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									<!--개발확인필요-->
									{[#if isPercent]}
									<span class="wish__each__price--perc">[<em>{[discount_rate]}</em>%]</span>
									{[/if]}

								</div>
							</div>
						</div>
					</a>
					<span devWishBtn='{[id]}' class="wish__each__wish on">wish아이콘</span>
				</li>
				<li class="devForbizTpl" id="devMyWishLoading">
					<div class="empty-content order-list">
						<div class="wrap-loading">
							<div class="loading"></div>
						</div>
					</div>
				</li>
				<li class="empty-content devForbizTpl" id="devMyWishEmpty">No item of interest</li>
			</ul>
		</form>
	</div>
	<div id="devPageWrap" class="br__more"></div>
</section>