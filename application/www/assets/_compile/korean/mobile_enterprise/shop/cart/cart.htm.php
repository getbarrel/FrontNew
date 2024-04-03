<?php /* Template_ 2.2.8 2024/03/19 10:50:12 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/cart/cart.htm 000025309 */ 
$TPL_cart_1=empty($TPL_VAR["cart"])||!is_array($TPL_VAR["cart"])?0:count($TPL_VAR["cart"]);
$TPL_wishList_1=empty($TPL_VAR["wishList"])||!is_array($TPL_VAR["wishList"])?0:count($TPL_VAR["wishList"]);
$TPL_historyList_1=empty($TPL_VAR["historyList"])||!is_array($TPL_VAR["historyList"])?0:count($TPL_VAR["historyList"]);?>
<!-- 2023.06.30 PlayD-->
<script>
    var emnet_tagm_products=[];
    var criteoList = [];
</script>

<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){?>
<script>
    emnet_tagm_products.push({
        'name': '<?php echo $TPL_V3["pname"]?>',
        'id': '<?php echo $TPL_V3["id"]?>',
        'price': '<?php echo $TPL_V3["total_dcprice"]?>',
        'quantity': '<?php echo $TPL_V3["pcount"]?>'
    });

    criteoList.push({
        'id': '<?php echo $TPL_V3["id"]?>',
        'price': '<?php echo $TPL_V3["total_dcprice"]?>',
        'quantity': '<?php echo $TPL_V3["pcount"]?>'
    });
</script>

<?php }}?>
<?php }}?>
<?php }}?>

<!-- Criteo 장바구니 태그  23.06.29 -->
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 104564},
        { event: "setEmail", email: "", hash_method: "" },
        { event: "setZipcode", zipcode: "" },
        { event: "setSiteType", type: deviceType},
        { event: "viewBasket", item: criteoList}
    );
</script>
<!-- END Criteo 장바구니 태그 -->
<!-- Enliple Tracker Start_모비온 -->
<script type="text/javascript">
var ENP_VAR = { conversion: { product: [] } };

// 주문한 각 제품들을 배열에 저장
	ENP_VAR.conversion.product.push(
<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
<?php if($TPL_productList_3){$TPL_I3=-1;foreach($TPL_V2["productList"] as $TPL_V3){$TPL_I3++;?>
			if('<?php echo $TPL_I3+ 1?>' == '<?php echo $TPL_VAR["cartCnt"]?>'){
				{
					productCode : '<?php echo $TPL_V3["id"]?>',
					productName : '<?php echo $TPL_V3["pname"]?>',
					price : '<?php echo $TPL_V3["listprice"]?>',
					dcPrice : '<?php echo $TPL_V3["dcprice"]?>',
					qty : '<?php echo $TPL_V3["pcount"]?>'
				}
			}else{
				{
					productCode : '<?php echo $TPL_V3["id"]?>',
					productName : '<?php echo $TPL_V3["pname"]?>',
					price : '<?php echo $TPL_V3["listprice"]?>',
					dcPrice : '<?php echo $TPL_V3["dcprice"]?>',
					qty : '<?php echo $TPL_V3["pcount"]?>'
				},
			}
<?php }}?>
<?php }}?>
<?php }}?>
	);

	ENP_VAR.conversion.totalPrice = '<?php echo $TPL_VAR["cartSummary"]["product_dcprice"]?>';  // 없는 경우 단일 상품의 정보를 이용해 계산
	ENP_VAR.conversion.totalQty = '<?php echo $TPL_VAR["cartSummary"]["product_total_count"]?>';  // 없는 경우 단일 상품의 정보를 이용해 계산

	(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
	enp('create', 'conversion', 'barrel', { device: 'M', paySys: 'naverPay' }); // W:웹, M: 모바일, B: 반응형
</script>
<!-- Enliple Tracker End_모비온 -->

<!-- 장바구니 dataLayer -->
<script>
 dataLayer.push({
     'event': 'addToCart',
     'ecommerce': {
         'currencyCode': 'KRW',
         'add': {
         'products': emnet_tagm_products
         }
     }
 });
</script>


<input type="hidden" class="devProductSoldOut" value="<?php echo $TPL_VAR["isPrdSoldOut"]?>" />
<p class="br__cart__has-soldout" id="devSoldOutProductView" style="display: none;">장바구니에 품절된 상품이 있습니다.</p>
<!-- 컨텐츠 S -->
<section class="br__cart">
	<div class="br__cart__content">
		<!-- 장바구니 있을 경우 S -->
<?php if($TPL_cart_1){$TPL_I1=-1;foreach($TPL_VAR["cart"] as $TPL_V1){$TPL_I1++;
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
		<div class="br__cart__section">
			<div class="page-title">
				<div class="title-md">장바구니</div>
			</div>
			<div class="cart">
				<div class="cart-top">
					<div class="cart-top__info">
						<div class="br__form-item">
							<input type="checkbox" id="cart_all_check" class="br__from-checkbox devChangePriceEvent" checked/>
							<label for="cart_all_check">전체선택 <em class="cart-top__info__total"><?php echo $TPL_VAR["cartCnt"]?></em></label>
						</div>
					</div>
					<div class="cart-top__del">
						<button class="cart-top__del__btn" id="devSelectDeleteButton">선택삭제</button>
						<!--<button class="cart-top__del__btn">품절삭제</button>-->
					</div>
				</div>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
				<div class="cart-item">
					<ul class="cart-item__list">
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
						<li class="cart-item__box devProductContents">
							<!-- 품절일 경우 class = sold-out 추가-->
							<!-- 첫 li에 모든 상태의 html 포함되어 있음-->
							<div class="cart-item__box-top">
								<label class="cart-item__check">
									<input type="checkbox" class="cart_product_check devChangePriceEvent devCartIx" <?php if($TPL_V3["status"]=='sale'){?>checked<?php }else{?>disabled<?php }?> value="<?php echo $TPL_V3["cart_ix"]?>">
								</label>
								<button class="btn-sm btn-line-no devDeleteButton">삭제</button>
							</div>
							<dl class="cart-item__group">
								<dt class="cart-item__group-left">
									<figure class="cart-item__thumb">
										<a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
											<img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["brand_name"]?> <?php echo $TPL_V3["pname"]?>" />
										</a>
									</figure>
								</dt>
								<dd class="cart-item__group-right">
									<div class="cart-item__info">
										<div class="cart-item__info__title"><?php echo $TPL_V3["brand_name"]?> <?php echo $TPL_V3["pname"]?></div>

<?php if($TPL_V3["set_group"]> 0){?>										<input type="hidden" name="cartType" class="cartType" value="set" />
										<div class="cart-item__info__option set" style="display: none">
											
											<div class="cart-item__info__option-item">
<?php if(!empty($TPL_V3["add_info"])){?><span class="set-tit"><?php echo $TPL_V3["add_info"]?></span><?php }?>
												<span class="color">
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo $TPL_V4["options_text"]?>

<?php }}?>
												</span>
											</div>
										</div>
<?php }else{?>										<input type="hidden" name="cartType" class="cartType"  value="" />
										<div class="cart-item__info__option">
											<div class="cart-item__info__option-item">
												<span class="color"><?php echo $TPL_V3["add_info"]?></span>
												<span class="size"><?php echo str_replace("사이즈:","",$TPL_V3["options_text"])?></span>
												<span class="count"><?php echo $TPL_V3["pcount"]?>개</span>
											</div>
										</div>
<?php }?>

										<div class="cart-item__info__price">
<?php if($TPL_V3["discount_rate"]){?>
											<span class="cart-item__info__price--discount"><?php echo $TPL_V3["discount_rate"]?>%</span>
<?php }?>
<?php if($TPL_V3["listprice"]>$TPL_V3["dcprice"]){?>
											<del class="cart-item__info__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></del>
<?php }?>
											<span class="cart-item__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>

<?php if($TPL_V3["status"]=='stop'){?>
											<span class="cart-item__info__price--stop">판매중지</span>
<?php }elseif($TPL_V3["status"]=='ready'){?>
											<span class="cart-item__info__price--stop">판매예정</span>
<?php }elseif($TPL_V3["status"]=='end'){?>
											<span class="cart-item__info__price--stop">판매종료</span>
<?php }?>
											<!-- 판매중지 / 판매예정 / 판매종료 E -->

<?php if($TPL_V3["status"]=='soldout'){?>
											<span class="cart-item__info__price--soldout">[품절]</span>
<?php }?>
										</div>
									</div>
								</dd>
							</dl>

<?php if($TPL_V3["addOptionList"]){?>
							<div class="add-product__wrap">
								<div class="add-product__title">추가구성 상품</div>
								<div class="add-product devAddOptionContents">
									<input type="hidden" class="devCartOptionIx" value="<?php echo $TPL_VAR["addOptionList"]["cart_option_ix"]?>"/>
									<button class="item-del-btn devAddOptionDeleteButton">삭제</button>
									<div class="add-product__info">
<?php if($TPL_VAR["addOptionList"]["stock"]> 0){?>
										<div class="add-product__name"><?php echo $TPL_VAR["addOptionList"]["opn_text"]?></div>
										<div class="add-product__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["addOptionList"]["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
<?php }else{?>
										<div class="add-product__price"><span class="txt-error">일시품절</span></div>
<?php }?>
									</div>
									<div class="control">
										<div class="control-group">
											<div class="control-title">수량</div>
											<ul class="option-up-down">
												<li><button class="down devAddCountDownButton"></button></li>
												<li><input type="text" value="<?php echo $TPL_VAR["addOptionList"]["opn_count"]?>" class="br__form-input devAddCount" /></li>
												<li><button class="up devAddCountUpButton"></button></li>
												<li class="control-box">
													<button type="button" class="btn-sm btn-dark-line add-product__change devAddOptionCountUpdateButton">변경</button>
												</li>
											</ul>
										</div>
<?php if($TPL_VAR["addOptionList"]["stock"]<$TPL_VAR["addOptionList"]["opn_count"]){?>
										<div class="cart-item__warning">
											<p class="txt-error">주문 가능한 수량은 최대 <?php echo $TPL_VAR["addOptionList"]["stock"]?>개입니다.</div>
										</div>
<?php }?>
									</div>
								</div>
							</div>
<?php }?>

<?php if(count($TPL_V3["giftItem"])> 0){?>							<div class="cart-item__freebie">
								<div class="cart-item__freebie__title"><span>구매 사은품</span> <?php echo $TPL_VAR["giftItem"]["gift_title"]?></div>
								<ul class="cart-item__freebie__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
									<li class="cart-item__freebie__box devGiftList" data-status="<?php echo $TPL_V4["status"]?>">
										<div class="cart-item__freebie__thumb">
											<figure>
												<img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>">
											</figure>
										</div>
										<div class="cart-item__freebie__info">
											<p class="cart-item__freebie__text"><?php echo $TPL_V4["gift_name"]?> / <?php echo $TPL_V4["cnt"]?>개 <?php if($TPL_V4["status"]=='soldout'){?> <?php if($TPL_VAR["langType"]=='korean'){?>[품절]<?php }else{?>[Out of stock]<?php }?> <?php }?></p>
											<!-- <div class="cart-item__freebie__name">[사은품] 키즈 데이지 튜브</div>
											<div class="cart-item__freebie__option">
												<div class="cart-item__freebie__option-item">
													<span>페일네온옐로우</span>
													<span>OS</span>
													<span>1개</span>
												</div>
											</div> -->
										</div>
									</li>
<?php }}?>
								</ul>
							</div>
<?php }?>

							<div class="cart-item__btn">
								<button type="button" class="btn-default btn-gray-line devCartChange" data-pid="<?php echo $TPL_V3["id"]?>" data-cart_ix="<?php echo $TPL_V3["cart_ix"]?>" data-pcount="<?php echo $TPL_V3["pcount"]?>" data-opt="<?php echo $TPL_V3["select_option_id"]?>" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>>옵션 변경</button>
								<!--<button type="button" class="btn-default btn-gray-line" onclick="DownLayerJSNew('cart-option')" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>>옵션 변경</button>-->
<?php if($TPL_V3["status"]=='soldout'){?>
								<button type="button" class="btn-default btn-dark-line devDirectBuyButton" disabled>구매불가</button>
<?php }else{?>
								<button type="button" class="btn-default btn-dark-line devDirectBuyButton">바로구매</button>
<?php }?>
							</div>
							<dl class="cart-item__info__price--total">
								<dt>합계</dt>
								<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V3["total_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?> </dd>
							</dl>
							<!-- 품절일 경우에 노출 S -->
							<!-- 숨김 처리 -->
							<div class="cart-item__warning" style="display: none">
								<p class="txt-red">선택하신 사이즈가 품절되었습니다.</p>
							</div>
							<!-- 품절일 경우에 노출 E -->
						</li>
<?php }}?>
					</ul>
				</div>
<?php }}?>
				<div class="cart-item__result" devCartCompanyPriceContents="<?php echo $TPL_V1["company_id"]?>" id="devCartPriceContents">
					<dl class="cart-item__result__total">
						<dt>결제 예정금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_V1["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="cart-item__result__part">
						<dt>총 주문 상품 수</dt>
						<dd><em id="devSelectItemCnt">0</em>개</dd>
					</dl>
					<dl class="cart-item__result__part">
						<dt>총 상품금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_listprice"><?php echo g_price($TPL_V1["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="cart-item__result__part">
						<dt>상품 할인</dt>
						<dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_basic_discount_amount"><?php echo g_price($TPL_V1["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="cart-item__result__part">
						<dt>등급 할인</dt>
						<dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_mem_discount_amount"><?php echo g_price($TPL_V1["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="cart-item__result__part">
						<dt>총 배송비</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="total_delivery_price"><?php echo g_price($TPL_V1["total_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?><!-- <em>3,000</em>원(기본) + <em>3,000</em>원(도서산간) --></dd>
					</dl>
				</div>
				<div class="cart-footer">
					<dl class="cart-item__payment">
						<dt>
							<div class="cart-item__payment__quantity">총 <em id="devSelectItemCnt2">0</em>개</div>
						</dt>
						<dd>
							<button type="button" class="btn-lg btn-dark cart-item__payment__btn" id="devBuyButton">주문하기</button>
						</dd>
					</dl>
				</div>
			</div>
			<div class="use-notice">
				<div class="use-notice__title">구매 시 유의사항</div>
				<ul class="use-notice__list">
					<li class="use-notice__desc">주문 상태가 ‘배송 준비’ 및 ‘배송 중’일 경우 취소처리가 불가합니다.</li>
					<li class="use-notice__desc">무통장 입금 주문시 24시간 내로 입금이 안 될 경우 주문이 자동으로 취소됩니다.</li>
					<li class="use-notice__desc">최종 결제금액은 주문결제 시 쿠폰 및 적립금 적용 등에 따라 달라질 수 있습니다.</li>
				</ul>
			</div>
		</div>
<?php }}else{?>
		<!-- 장바구니 있을 경우 E -->

		<!-- 장바구니 없을 경우 S -->
		<!-- 숨김 처리 -->
		<div class="br__cart__section no-data">
			<p class="empty-content">
				장바구니에<br />
				담긴 상품이 없습니다.
			</p>
			<div class="btn-group col">
				<button type="button" class="btn-lg btn-dark-line">이전 페이지</button>
				<button type="button" class="btn-lg btn-gray-line" id="devHomeButton">홈으로</button>
			</div>
		</div>
		<!-- 장바구니 없을 경우 E -->
<?php }?>

		<!-- 위시리스트 / 최근 본 상품 S -->
		<div class="br__cart-goods">
			<!-- 위시리스트 S -->
			<div class="br__cart-goods--item">
				<div class="br__cart-goods--slider">
					<div class="br__cart-goods--title">
						<div class="title-sm">위시 리스트 상품</div>
					</div>
					<div class="goods-list goods-list__slide swiper-container">
						<ul class="goods-list__list swiper-wrapper">
<?php if($TPL_wishList_1){$TPL_I1=-1;foreach($TPL_VAR["wishList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 10){?>
							<li class="goods-list__box swiper-slide">
								<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
									<div class="goods-list__thumb">
										<div class="goods-list__thumb-slide swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
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

										<!-- 버튼으로 할 경우 S -->
										<!-- 숨김처리 -->
										<button type="button" class="btn-wishlist {[#if alreadyWish]}active{[/if]}" data-devWishBtn="<?php echo $TPL_V1["id"]?>" style="display: none">
											<!-- 선택시 button class = active 추가-->
											<i class="ico ico-wishlist"></i>위시리스트
										</button>
										<!-- 버튼으로 할 경우 E -->

										<!-- 체크 박스로 할 경우 S -->
										<label class="goods-list__wish" devwishbtn="<?php echo $TPL_V1["id"]?>">
<?php if($TPL_V1["alreadyWish"]){?>
											<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" checked/>
<?php }else{?>
											<input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" />
<?php }?>
										</label>
										<!-- 체크 박스로 할 경우 E -->
									</div>
									<div class="goods-list__info">
										<!-- <div class="goods-list__pre br__goods__pre">친환경 소재</div> -->
										<div class="goods-list__title"><?php echo $TPL_V1["pname"]?></div>
										<div class="goods-list__color"><?php echo $TPL_V1["add_info"]?></div>
										<div class="goods-list__price">
<?php if($TPL_V1["isPercent"]){?>
											<div class="goods-list__price__percent"><span><?php echo $TPL_V1["discount_rate"]?></span>%</div>
<?php }?>
											<div class="goods-list__price__discount"><span><?php echo $TPL_V1["dcprice"]?></span></div>
<?php if($TPL_V1["isDiscount"]){?>
											<div class="goods-list__price__cost"><del><?php echo $TPL_V1["listprice"]?></del></div>
<?php }?>
<?php if($TPL_V1["state_soldout"]){?>
											<div class="goods-list__price__state">품절</div>
<?php }?>
										</div>
									</div>
								</a>
							</li>
<?php }?>
<?php }}else{?>
							<!--등록된 상품이 없을 시 S -->
							<li class="goods-list__box no-data" id="devListEmpty">등록된 상품이 없습니다.</li>
							<!--등록된 상품이 없을 시 E -->
<?php }?>
						</ul>
					</div>
				</div>
			</div>
			<!-- 위시리스트 E -->
			<!-- 최근 본 상품 S -->
			<div class="br__cart-goods--item">
				<div class="br__cart-goods--slider">
					<div class="br__cart-goods--title">
						<div class="title-sm">최근 본 상품</div>
					</div>
					<div class="goods-list goods-list__slide swiper-container">
						<ul class="goods-list__list swiper-wrapper">
<?php if($TPL_historyList_1){$TPL_I1=-1;foreach($TPL_VAR["historyList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 10){?>
							<li class="goods-list__box swiper-slide">
								<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
									<div class="goods-list__thumb">
										<div class="goods-list__thumb-slide swiper-container">
											<div class="swiper-wrapper">
												<div class="swiper-slide">
													<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
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
										<!-- 버튼으로 할 경우 S -->
										<!-- 숨김처리 -->
										<button type="button" class="btn-wishlist {[#if alreadyWish]}active{[/if]}" data-devWishBtn="<?php echo $TPL_V1["id"]?>" style="display: none">
											<!-- 선택시 button class = active 추가-->
											<i class="ico ico-wishlist"></i>위시리스트
										</button>
										<!-- 버튼으로 할 경우 E -->

										<!-- 체크 박스로 할 경우 S -->
										<label class="goods-list__wish" devwishbtn="<?php echo $TPL_V1["id"]?>">
<?php if($TPL_V1["alreadyWish"]){?>
											<input type="checkbox" class="goods-list__wish__btn" id="historyCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish2('<?php echo $TPL_V1["id"]?>')" checked/>
<?php }else{?>
											<input type="checkbox" class="goods-list__wish__btn" id="historyCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish2('<?php echo $TPL_V1["id"]?>')" />
<?php }?>
										</label>

										<!-- <label class="goods-list__wish">
											<input type="checkbox" class="goods-list__wish__btn" />
										</label> -->
										<!-- 체크 박스로 할 경우 E -->
									</div>
									<div class="goods-list__info">
										<!-- <div class="goods-list__pre br__goods__pre">친환경 소재</div> -->
										<div class="goods-list__title"><?php echo $TPL_V1["pname"]?></div>
										<div class="goods-list__color"><?php echo $TPL_V1["add_info"]?></div>
										<div class="goods-list__price">
<?php if($TPL_V1["isPercent"]){?>
											<div class="goods-list__price__percent"><span><?php echo $TPL_V1["discount_rate"]?></span>%</div>
<?php }?>
											<div class="goods-list__price__discount"><span><?php echo $TPL_V1["dcprice"]?></span></div>
<?php if($TPL_V1["isDiscount"]){?>
											<div class="goods-list__price__cost"><del><?php echo $TPL_V1["listprice"]?></del></div>
<?php }?>
<?php if($TPL_V1["state_soldout"]){?>
											<div class="goods-list__price__state">품절</div>
<?php }?>
										</div>
									</div>
								</a>
							</li>
<?php }?>
<?php }}else{?>
							<!--등록된 상품이 없을 시 S -->
							<li class="goods-list__box no-data" id="devListEmpty" >등록된 상품이 없습니다.</li>
							<!--등록된 상품이 없을 시 E -->
<?php }?>
						</ul>
					</div>
				</div>
			</div>
			<!-- 최근 본 상품 E -->
		</div>
		<!-- 위시리스트 / 최근 본 상품 E -->
	</div>
</section>
<!-- 컨텐츠 E -->