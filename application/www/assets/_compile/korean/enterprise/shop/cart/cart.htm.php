<?php /* Template_ 2.2.8 2024/03/19 10:50:20 /home/barrel-stage/application/www/assets/templet/enterprise/shop/cart/cart.htm 000022780 */ 
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

<!-- Criteo 장바구니 태그 23.06.29-->
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
	enp('create', 'conversion', 'barrel', { device: 'W', paySys: 'naverPay' }); // W:웹, M: 모바일, B: 반응형
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
<input type="hidden" id="devShopName" value="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>"/>
<!-- 컨텐츠 영역 S -->
<section class="wrap-cart fb__shop fb__cart">
	<div class="fb__shop__title-area">
		<h2 class="fb__shop__title">장바구니</h2>
		<ul class="fb__shop__step-area">
			<li class="fb__shop__step fb__shop__step--on"><em>01.</em> 장바구니</li>
			<li class="fb__shop__step"><em>02.</em> 주문</li>
			<li class="fb__shop__step"><em>03.</em> 주문 완료</li>
		</ul>
	</div>

	<!-- 장바구니 있을 경우 S -->
<?php if($TPL_VAR["cart"]){?>
	<div class="layout-section fb__cart__layout-section fb__shop__layout-section">
<?php if($TPL_cart_1){$TPL_I1=-1;foreach($TPL_VAR["cart"] as $TPL_V1){$TPL_I1++;
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
		<div class="layout-left">
			<div class="top-area fb__cart__top">
				<div class="check-area fb__check-area">
					<input type="checkbox" id="cart_all_check" class="devChangePriceEvent" checked />
					<label for="cart_all_check">전체선택 <em class="fb__cart__total"><?php echo $TPL_VAR["cartCnt"]?></em>개</label>
				</div>
				<div class="btn-group">
					<button class="fb__cart__top-delete btn-s btn-white btn-line-no" id="devSelectDeleteButton">선택삭제</button>
					<!-- <button class="fb__cart__top-soldDel btn-s btn-white btn-line-no" id="">품절삭제</button> -->
				</div>
			</div>
			
			<section class="fb__cart__seller-box seller-box">
				<p class="fb__cart__soldout" id="devSoldOutProductView" style="display: none;">장바구니에 <em>품절된 상품</em>이 있습니다.</p>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
				<ul class="product-item__wrap">
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
					<li class="product-item__list devProductContents <?php if($TPL_V3["status"]=='soldout'){?>sold-out<?php }elseif($TPL_V3["status"]=='stop'){?>sold-stop<?php }?>">
						<!-- sold-out / sold-stop-->
						<!-- 상품 영역 S -->
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__checkbox">
									<input type="checkbox" class="cart_product_check devChangePriceEvent devCartIx" <?php if($TPL_V3["status"]=='sale'){?>checked<?php }else{?>disabled<?php }?> value="<?php echo $TPL_V3["cart_ix"]?>">
								</div>
								<div class="product-item__thumb">
									<a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
										<img src="<?php echo $TPL_V3["image_src"]?>">
<?php if($TPL_V3["status"]=='soldout'){?>
										<div class="sold-out-txt">일시품절</div>
<?php }?>
									</a>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title c-pointer">
										<a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>"><?php if($TPL_V3["brand_name"]){?>[<?php echo $TPL_V3["brand_name"]?>] <?php }?><?php echo $TPL_V3["pname"]?></a>
									</div>
									<div class="product-item__option">

<?php if($TPL_V3["set_group"]> 0){?>
											<input type="hidden" name="cartType" class="cartType" value="set" />
											<p class="cart-item__option">
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo str_replace("사이즈:","",$TPL_V4["options_text"])?><br>
<?php }}?>
											</p>
<?php }else{?>
											<span><?php echo $TPL_V3["add_info"]?></span>
											<span><?php echo str_replace("사이즈:","",$TPL_V3["options_text"])?></span>
											<span><?php echo $TPL_V3["pcount"]?></span>
<?php }?>

									</div>
									<div class="product-item__price-group">
										<div class="product-item__price price">
											<?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

										</div>
									</div>
									<!-- 품절 문구 숨김 S -->
									<div class="product-item__status" style="display: none">
<?php if($TPL_V3["status"]=='sale'){?>
<?php }elseif($TPL_V3["status"]=='stop'){?>
										<p class="cart-item__status">판매중지</p>
<?php }elseif($TPL_V3["status"]=='ready'){?>
										<p class="cart-item__status">판매예정</p>
<?php }elseif($TPL_V3["status"]=='end'){?>
										<p class="cart-item__status">판매종료</p>
<?php }?>	
									</div>
									<!-- 품절 문구 숨김 E -->
								</div>
								<div class="product-item__btn-area">
									<button class="btn-xs btn-white btn-line-no devDeleteButton cart-item__btn-area-del">삭제</button>
<?php if($TPL_V3["status"]=='soldout'){?><p class="product-item__btn-soldText">선택하신 사이즈가 품절되었습니다.</p><?php }?>
									<div class="btn-group">
										<button type="button" class="cart-item__change__btn btn-s btn-gray-line" data-pid="<?php echo $TPL_V3["id"]?>" data-cart_ix="<?php echo $TPL_V3["cart_ix"]?>" data-title="옵션변경" data-opt="<?php echo $TPL_V3["select_option_id"]?>"  data-pcount="<?php echo $TPL_V3["pcount"]?>" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>>옵션 변경</button>
<?php if($TPL_V3["status"]=='soldout'){?>
										<button class="btn-s btn-dark-line devDirectBuyButton" disabled>구매불가</button>
<?php }else{?>
										<button class="btn-s btn-dark-line devDirectBuyButton">바로구매</button>
<?php }?>
									</div>
								</div>
							</dd>
						</dl>
						<!-- 상품 영역 E -->
						
						<!-- 추가구성상품 영역 S -->
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
						<!-- 기존 배럴 html 에 있어서 추가했습니다. 일단 숨김처리 해놨습니다.-->
						<div class="fb__cart__add-product add-product" style="display: none">
							<div class="cart-item__title add-product__title">추가구성 상품</div>
							<div class="bg-none"><input type="hidden" class="devCartOptionIx" value="" /></div>
							<div class="td-btn-area add-product__del-area">
								<button class="item-del-btn devAddOptionDeleteButton">삭제</button>
							</div>
							<dl class="product-quantity">
								<dt class="product-quantity__title">수량</dt>
								<dd>
									<div class="product-quantity__control control">
										<ul class="option-up-down">
											<li>
												<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus"></i>DOWN</button>
											</li>
											<li><input type="text" value="1" class="devCount option-text" /></li>
											<li>
												<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus"></i>UP</button>
											</li>
										</ul>
										<!-- 주문 횟수 텍스트 S -->
										<div class="txt-error mat10" style="display: none">주문 가능한 수량은 최대 5개입니다.</div>
										<!-- 주문 횟수 텍스트 E -->
									</div>
								</dd>
							</dl>
							<div class="product-quantity__price">
								<dt>총 상품 금액</dt>
								<dd class="product-item__price-group">
									<div class="product-item__price price"><em>10,000</em>원</div>
									<!-- 품절일 경우 S -->
									<div class="product-item__soldText" style="display: none">일시품절</div>
									<!-- 품절일 경우 E -->
								</dd>
							</div>
						</div>
<?php }}?>
						<!-- 추가구성상품 영역 E -->

						<!-- 사은품 영역 S -->
<?php if(count($TPL_V3["giftItem"])> 0){?>
						<div class="product-gift-wrap">
							<div class="product-gift__title">
								<strong>구매 사은품</strong>
							</div>
							<ul class="product-gift__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
								<li class="product-gift__box inner-gift devGiftList">
									<figure class="product-gift__thumb">
										<img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>"/>
									</figure>
									<div class="product-gift__info">
										<div class="product-gift__info__pname"><?php echo $TPL_V4["gift_name"]?></div>
										<div class="product-gift__info__count">
											<!--<span>페일네온옐로우</span>
											<span>OS</span>-->
											<span><?php echo $TPL_V4["cnt"]?>개</span>
										</div>
									</div>
								</li>
<?php }}?>
							</ul>
						</div>
<?php }?>
						<!-- 사은품 영역 E -->
						<dl class="product-item__total-price">
							<dt>합계</dt>
							<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V3["total_dcprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
						</dl>
					</li>
<?php }}?>
				</ul>
<?php }}?>
			</section>
			
			<div class="fb__cart__noti fb__cart-info">
				<h4>구매 시 유의사항</h4>
				<p>주문 상태가 ‘배송 준비’ 및 ‘배송 중’일 경우 취소처리가 불가합니다.</p>
				<p>무통장 입금 주문시 24시간 내로 입금이 안 될 경우 주문이 자동으로 취소됩니다.</p>
				<p>최종 결제금액은 주문결제 시 쿠폰 및 적립금 적용 등에 따라 달라질 수 있습니다.</p>
			</div>
		</div>

		<div class="layout-right">
			<div class="shop-right-area">
				<div class="shop-total-price" devCartCompanyPriceContents="<?php echo $TPL_V1["company_id"]?>" id="devCartPriceContents">
					<h2 class="shop-total-price__title">결제 정보</h2>
					<dl class="shop-total-price__cate-total">
						<dt class="shop-total-price__cate-total__title">결제 예정 금액</dt>
						<dd class="shop-total-price__cate-total__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_V1["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>

					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 주문 상품 수</dt>
						<dd class="shop-total-price__cate__price"><em id="devSelectItemCnt">0</em>개</dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 상품금액</dt>
						<dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_listprice"><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">상품 할인</dt>
						<dd class="shop-total-price__cate__price">-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_basic_discount_amount"><?php echo g_price($TPL_V1["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">등급 할인</dt>
						<dd class="shop-total-price__cate__price">-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_mem_discount_amount"><?php echo g_price($TPL_V1["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">
							<span>기본 배송비</span>
							<span class="js__cart__delivery-icon shop-total-price__cate__icon">느낌표 아이콘</span>
						</dt>
						<dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="total_delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["total_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){?>
<?php if($TPL_V2["delivery_text"]){?>
                        <dd class="fb__cart__layer-delivery">
                            <span>
                                <?php echo $TPL_V2["delivery_text"]?>

                            </span>
                        </dd>
<?php }?>
<?php }}?>
					</dl>
				</div>

                <button class="btn-lg btn-dark fb__shop__buy-btn" id="devBuyButton">주문하기</button>
			</div>
		</div>
<?php }}?>
	</div>
	<!-- 장바구니 있을 경우 E -->
<?php }else{?>
	<!-- 장바구니 없을 경우 S -->
	<div class="fb__cart-no--data">
		<div class="empty-content">
			<p>장바구니에 담긴 상품이 없습니다.</p>
			<div class="btn-group">
				<button class="btn-default btn-dark-line"><a href="javascript:history.back()" >이전 페이지</a></button>
				<button class="btn-default btn-gray-line"><a href="/">홈으로</a></button>
			</div>
		</div>
	</div>
	<!-- 장바구니 없을 경우 E -->
<?php }?>

	<!-- 장바구니 추천 상품 영역 S -->
	<div class="fb__cart-goods">
		<div class="fb__cart-goods--item">
			<div class="fb__cart-goods--slider swiper swiper-goods-default">
				<div class="fb__cart-goods--title">
					<h3>위시 리스트 상품</h3>
				</div>
				<ul class="fb__goods swiper-wrapper">
<?php if($TPL_wishList_1){$TPL_I1=-1;foreach($TPL_VAR["wishList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 10){?>
					<li class="fb__goods__list swiper-slide">
						<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
							<figure class="fb__goods__img">
								<div>
									<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
								</div>
							</figure>
							<div class="fb__goods__info">
								<ul class="fb__goods__infoBox">
									<!-- <li class="fb__goods__etc">친환경 소재</li> -->
									<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
									<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
									<li class="fb__goods__brand"><?php echo $TPL_V1["brand_name"]?></li>
								</ul>
							</div>
							<div class="fb__goods__important">
<?php if($TPL_V1["state_soldout"]){?>
								<span class="fb__goods__price__state" style="display: none">[품절]</span>
<?php }else{?>	
<?php if($TPL_V1["isPercent"]){?>
								<div class="fb__goods__sale"><p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p></div>
<?php }?>
<?php }?>
								<span class="fb__goods__price"><?php echo $TPL_V1["dcprice"]?></span>
<?php if($TPL_V1["isDiscount"]){?>
								<span class="fb__goods__noprice"><?php echo $TPL_V1["listprice"]?></span>
<?php }?>
							</div>
							<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
						</a>
						<a href="#" class="product-box__heart  <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?> " data-devWishBtn='<?php echo $TPL_V1["id"]?>'">hart</a>
					</li>
<?php }?>
<?php }}else{?>
					<!--등록된 상품이 없을 시 S -->
					<li class="empty-content swiper-slide" id="devListEmpty" style="display: none !important">등록된 상품이 없습니다.</li>
					<!--등록된 상품이 없을 시 E -->
<?php }?>
				</ul>
				<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
				<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
			</div>
		</div>
		<div class="fb__cart-goods--item">
			<div class="fb__cart-goods--slider swiper swiper-goods-default">
				<div class="fb__cart-goods--title">
					<h3>최근 본 상품</h3>
				</div>
				<ul class="fb__goods swiper-wrapper">
<?php if($TPL_historyList_1){$TPL_I1=-1;foreach($TPL_VAR["historyList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 10){?>
					<li class="fb__goods__list swiper-slide">
						<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
							<figure class="fb__goods__img">
								<div>
									<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
								</div>
							</figure>
							<div class="fb__goods__info">
								<ul class="fb__goods__infoBox">
									<!-- <li class="fb__goods__etc">친환경 소재</li> -->
									<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
									<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
									<li class="fb__goods__brand"><?php echo $TPL_V1["brand_name"]?></li>
								</ul>
							</div>
							<div class="fb__goods__important">
<?php if($TPL_V1["state_soldout"]){?>
								<span class="fb__goods__price__state" style="display: none">[품절]</span>
<?php }else{?>	
<?php if($TPL_V1["isPercent"]){?>
								<div class="fb__goods__sale"><p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p></div>
<?php }?>
<?php }?>
								<span class="fb__goods__price"><?php echo $TPL_V1["dcprice"]?></span>
<?php if($TPL_V1["isDiscount"]){?>
								<span class="fb__goods__noprice"><?php echo $TPL_V1["listprice"]?></span>
<?php }?>
							</div>
							<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
						</a>
						<a href="#" class="product-box__heart  <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?> " data-devWishBtn='<?php echo $TPL_V1["id"]?>'">hart</a>
					</li>
<?php }?>
<?php }}else{?>
					<!--등록된 상품이 없을 시 S -->
					<li class="empty-content swiper-slide" id="devListEmpty" style="display: none !important">등록된 상품이 없습니다.</li>
					<!--등록된 상품이 없을 시 E -->
<?php }?>
				</ul>
				<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
				<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
			</div>
		</div>
	</div>
	<!-- 장바구니 추천 상품 영역 E -->
</section>
<!-- 컨텐츠 영역 E -->