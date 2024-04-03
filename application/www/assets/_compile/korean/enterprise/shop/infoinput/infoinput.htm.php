<?php /* Template_ 2.2.8 2024/03/20 16:53:27 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput.htm 000035270 */ 
$TPL_cart_1=empty($TPL_VAR["cart"])||!is_array($TPL_VAR["cart"])?0:count($TPL_VAR["cart"]);
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<script>
	var emnet_tagm_products=[];
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
</script>
<?php }}?>
<?php }}?>
<?php }}?>

<!-- 주문서 작성 dataLayer -->
<script>
dataLayer.push({
    'event': 'checkout',
    'ecommerce': {
        'checkout': {
            'actionField': {'step': 1},
            'products' : emnet_tagm_products
        }
    }
});
</script>

<script>
	//레이아웃 인클로드 js (퍼블리싱)
	$(document).ready(function () {
		//약관 전체 선택 JS
		$("#area-terms-All").on("click", function () {
			if ($("#area-terms-All").is(":checked")) $(this).parents(".agree-content").find(".agree-content__item").find("input[type='checkbox']").prop("checked", true);
			else $(this).parents(".agree-content").find(".agree-content__item").find("input[type='checkbox']").prop("checked", false);
		});

		$(".agree-content")
			.find(".agree-content__item")
			.find("input[type='checkbox']")
			.on("click", function () {
				var total = $(".agree-content").find(".agree-content__item").find("input[type='checkbox']").length;
				var checked = $(".agree-content").find(".agree-content__item").find("input[type='checkbox']:checked").length;

				if (total != checked) $("#area-terms-All").prop("checked", false);
				else $("#area-terms-All").prop("checked", true);
			});
		//결제방법 선택 JS
		$(".pmt-method")
			.find("input[type='radio']")
			.on("click", function () {
				var methodType = $(this).parent("li").index();
				$(".pmt-method-annc__list").hide();
				$(".pmt-method-annc__list").eq(methodType).show();
			});

		//팝업 js
		$("#devUseCouponButton").on("click", function () {
			$(".popup-mask").addClass("popup-mask--show");
			$(".popup-layout").not(".terms-layer-pop").show();
		});
		//배송메세지 셀렉트박스 js
		$(".delivery-request select").change(function () {
			var result = $(this).find("option:selected").val();
			if (result == "direct") {
				$(this).parents(".delivery-request").find(".write-area").show();
			} else {
				$(this).parents(".delivery-request").find(".write-area").hide();
			}
		});
	});
</script>

<!-- 컨텐츠 영역 S -->
<section class="fb__infoinput fb__shop">
	<div class="fb__shop__title-area">
		<h2 class="fb__shop__title">주문</h2>
		<ul class="fb__shop__step-area">
			<li class="fb__shop__step"><em>01.</em> 장바구니</li>
			<li class="fb__shop__step fb__shop__step--on"><em>02.</em> 주문</li>
			<li class="fb__shop__step"><em>03.</em> 주문 완료</li>
		</ul>
	</div>

<?php if($TPL_VAR["topBanner"]){?>
	<div class="fb__infoinput__banner">
		<img src="<?php echo $TPL_VAR["topBanner"]["imgSrc"]?>" alt="<?php echo trans($TPL_VAR["topBanner"]["banner_name"])?>">
	</div>
<?php }?>

	<div class="layout-section fb__shop__layout-section" id="devPaymentContents">
		<div class="layout-left">
<?php $this->print_("userTemplate",$TPL_SCP,1);?>


			<!-- 공통 - 상품리스트 S -->
			<section class="fb__infoinput__order-info order-info">
				<div class="fb__infoinput-title">
					<div class="title-md">주문 상품 정보</div>
					<!--<p>총 <span>4</span>개</p>-->
				</div>
<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
				<ul class="product-item__wrap">
					<li class="product-item__list">
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
						<!-- 상품 영역 S -->
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
										<img src="<?php echo $TPL_V3["image_src"]?>" alt="" />
									</a>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title c-pointer">
<?php if($TPL_V3["brand_name"]){?>[<?php echo $TPL_V3["brand_name"]?>] <?php }?><?php echo $TPL_V3["pname"]?>

									</div>
									<div class="product-item__option">
										<input type="hidden" name="cartType" class="cartType" value="set" />
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
										<span><?php echo $TPL_V4["options_text"]?></span>
<?php }}?>
										<span><?php echo $TPL_V3["options_text"]?></span>
<?php if(!empty($TPL_V3["add_info"])){?>
										<span><?php echo $TPL_V3["add_info"]?></span>
<?php }?>
										<span><?php echo $TPL_V3["pcount"]?>개</span>
									</div>
									<div class="product-item__price-group">
										<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
									</div>
									<!-- 품절 문구 숨김 S -->
									<div class="product-item__status" style="display: none">판매중지/판매예정/판매종료</div>
									<!-- 품절 문구 숨김 E -->
								</div>
							</dd>
						</dl>
						<!-- 상품 영역 E -->
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
						<!-- 추가구성상품 영역 S -->
						<div class="add-product" style="display: none">
							<div class="add-product__title">추가구성 상품</div>
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
						<!-- 추가구성상품 영역 E -->
<?php }}?>
<?php if(count($TPL_V3["giftItem"])> 0){?>
						<!-- 사은품 영역 S -->
						<div class="product-gift-wrap">
							<div class="product-gift__title">
								<strong>구매 사은품</strong>
							</div>
							<ul class="product-gift__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
								<li class="product-gift__box inner-gift devGiftList">
									<figure class="product-gift__thumb">
										<img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>" data-devpid="<?php echo $TPL_V4["pid"]?>" data-devpcount="<?php echo $TPL_V4["cnt"]?>"/>
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
						<!-- 사은품 영역 E -->
<?php }?>
<?php }}?>
					</li>
					<!--
					<li class="product-item__list">
						-- 상품 영역 S --
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<a href="">
										<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
									</a>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title c-pointer">
										<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<input type="hidden" name="cartType" class="cartType" value="set" />
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__price-group">
										<div class="product-item__price-percent">30%</div>
										<div class="product-item__price price"><em>10,000</em>원</div>
										<div class="product-item__noprice"><del>1,405,550</del>원</div>
									</div>
								</div>
							</dd>
						</dl>
						-- 상품 영역 E -->

						<!-- 사은품 영역 S -- 
						<div class="product-gift-wrap">
							<div class="product-gift__title">
								<strong>구매 사은품</strong>
								<span class="product-gift__not-selected">사은품 선택 안함</span>
							</div>
						</div>
						-- 사은품 영역 E --
					</li>
					<li class="product-item__list">
						-- 상품 영역 S --
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<a href="">
										<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
									</a>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title c-pointer">
										<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<input type="hidden" name="cartType" class="cartType" value="set" />
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__price-group">
										<div class="product-item__price price"><em>10,000</em>원</div>
									</div>
								</div>
							</dd>
						</dl>
						-- 상품 영역 E --
					</li>
					<li class="product-item__list">
						-- 상품 영역 S --
						<dl class="product-item">
							<dt class="product-item__thumbnail-box">
								<div class="product-item__thumb">
									<a href="">
										<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
									</a>
								</div>
							</dt>
							<dd class="product-item__infobox">
								<div class="product-item__info">
									<div class="product-item__title c-pointer">
										<a href="#;">우먼 피쉬백 스트랩 스윔 브라탑</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<input type="hidden" name="cartType" class="cartType" value="set" />
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__option">
										<a href="#;">
											<span>미드나잇</span>
											<span>95</span>
											<span>1개</span>
										</a>
									</div>
									<div class="product-item__price-group">
										<div class="product-item__price-percent">30%</div>
										<div class="product-item__price price"><em>10,000</em>원</div>
										<div class="product-item__noprice"><del>1,405,550</del>원</div>
									</div>
								</div>
							</dd>
						</dl>
						-- 상품 영역 E --
					</li>
					-->
				</ul>
<?php }}?>
<?php }}?>
			</section>
			<!-- 공통 - 상품리스트 S -->

			<!-- 사은품 S 실 확인 시 !freeGift -> freeGift 로 변경 -->
<?php if($TPL_VAR["freeGift"]){?>			<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
			<section class="fb__infoinput__gift order-info__pricegift warp_gift_list devOrderGiftArea devOrderGiftArea_<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition = '<?php echo $TPL_V1["freegift_condition"]?>'">
				<div class="fb__infoinput-title">
					<div class="title-md"><?php echo trans($TPL_V1["freegift_condition_text"])?></div>
					<p><span><?php echo trans($TPL_V1["gift_cnt"])?></span>개 선택 가능.</p>
				</div>

				<div class="gift-list">
					<ul class="product-item__wrap">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li class="product-item__list devOrderGiftList" id="devOrderGiftList_<?php echo $TPL_V1["freegift_condition"]?>"">
							<dl class="product-item">
								<dt class="product-item__thumbnail-box devGiftListByOrder">
									<div class="product-item__checkbox">
										<input type="checkbox" id="giftCheckbox" class="cart_product_check" value="<?php echo $TPL_V2["pid"]?>" />
									</div>
									<div class="product-item__thumb">
										<img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>" data-devpid="<?php echo $TPL_V2["pid"]?>" data-devpcount="<?php echo $TPL_V1["gift_cnt"]?>" data-fg_ix="<?php echo $TPL_V1["fg_ix"]?>" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>"/>
									</div>
								</dt>
								<dd class="product-item__infobox">
									<div class="product-item__info">
										<div class="product-item__title"><?php echo trans($TPL_V2["pname"])?></div>
										<!-- <div class="product-item__option">
											<span>페일네온옐로우</span>
										</div> -->
									</div>
								</dd>
							</dl>
							<!-- 상품 영역 E --> 
						</li>
<?php }}?>
						<li class="gift-list__checkbox">
							<div class="fb__form-input">
								<input type="checkbox" id="giftNoCheckbox" value="Y" />
								<label for="giftCheckbox">사은품 선택 안함.</label>
							</div>
						</li>
					</ul>
				</div>
			</section>
<?php }?>
<?php }}?>
<?php }?>
			<!-- 사은품 E -->

			<!-- 회원 주문용 - 쿠폰 / 적립금 S -->
			<section class="fb__infoinput__discount-area">
<?php $this->print_("userTemplateCoupon",$TPL_SCP,1);?>

			</section>
			<!-- 회원 주문용 - 쿠폰 / 적립금 E -->


			<!-- 결제 방법 S -->
			<section class="fb__infoinput__payment-method payment-method">
				<div class="fb__infoinput-title">
					<div class="title-md">결제 방법</div>
				</div>
				<ul class="pmt-method">
<?php if($TPL_VAR["langType"]=='english'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_EXIMBAY?>" id="pay-method-<?php echo ORDER_METHOD_EXIMBAY?>" checked>
							<label for="pay-method-<?php echo ORDER_METHOD_EXIMBAY?>">Eximbay</label>
						</li>
<?php }else{?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_CARD?>" id="pay-method-<?php echo ORDER_METHOD_CARD?>" checked>
							<label for="pay-method-<?php echo ORDER_METHOD_CARD?>">신용카드</label>
						</li>
<?php if($TPL_VAR["add_sattle_module_naverpay_pg"]=='Y'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_NPAY?>" id="pay-method-<?php echo ORDER_METHOD_NPAY?>">
							<label for="pay-method-<?php echo ORDER_METHOD_NPAY?>">네이버페이</label>
						</li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_kakao"]=='Y'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_KAKAOPAY?>" id="pay-method-<?php echo ORDER_METHOD_KAKAOPAY?>">
							<label for="pay-method-<?php echo ORDER_METHOD_KAKAOPAY?>">카카오페이</label>
						</li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_toss"]=='Y'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_TOSS?>" id="pay-method-<?php echo ORDER_METHOD_TOSS?>">
							<label for="pay-method-<?php echo ORDER_METHOD_TOSS?>">토스페이</label>
						</li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_payco"]=='Y'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_PAYCO?>" id="pay-method-<?php echo ORDER_METHOD_PAYCO?>">
							<label for="pay-method-<?php echo ORDER_METHOD_PAYCO?>">페이코</label>
						</li>
<?php }?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_VBANK?>" id="pay-method-<?php echo ORDER_METHOD_VBANK?>">
							<label for="pay-method-<?php echo ORDER_METHOD_VBANK?>">가상계좌</label>
						</li>
<?php if(false){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_ICHE?>" id="pay-method-<?php echo ORDER_METHOD_ICHE?>">
							<label for="pay-method-<?php echo ORDER_METHOD_ICHE?>">실시간 계좌이체</label>
						</li>
<?php }?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_ASCROW?>" id="pay-method-<?php echo ORDER_METHOD_ASCROW?>">
							<label for="pay-method-<?php echo ORDER_METHOD_ASCROW?>">에스크로(가상계좌) 결제</label>
						</li>
<?php }?>
<?php if(DB_CONNECTION_DIV=='development'){?>
						<li class="pmt-method__list">
							<input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_BANK?>" id="pay-method-<?php echo ORDER_METHOD_BANK?>">
							<label for="pay-method-<?php echo ORDER_METHOD_BANK?>">무통장(TEST용)</label>
						</li>
<?php }?>
				</ul>
				<ul class="pmt-method-annc">
<?php if($TPL_VAR["langType"]=='korean'){?>
					<!--신용카드-->
					<li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_CARD?>">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">신용카드 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>고객이 온라인 쇼핑몰에서 상품 및 서비스를 신용카드로 진행하는 결제 서비스입니다.</p>
								<p>카드번호 유효기간 등의 신용정보는 안전하게 암호화되어 해당 신용카드사로 전달됩니다.</p>
							</dd>
						</dl>
					</li>
					<!--네이버페이-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_NPAY?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">네이버페이 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>주문 변경 시 카드사 혜택 및 할부 적용 여부는 해당 카드사 정책에 따라 변경될 수 있습니다.</p>
								<p>네이버페이는 네이버ID로 별도 앱 설치 없이 신용카드 또는 은행계좌 정보를 등록하여 네이버페이 비밀번호로 결제할 수 있는 간편결제 서비스입니다.</p>
								<p>결제 가능한 신용카드: 신한, 삼성, 현대, BC, 국민, 하나, 롯데, NH농협, 씨티, 카카오뱅크</p>
								<p>결제 가능한 은행: NH농협, 국민, 신한, 우리, 기업, SC제일, 부산, 경남, 수협, 우체국, 미래에셋대우, 광주, 대구, 전북, 새마을금고, 제주은행, 신협, 하나은행, 케이뱅크, 카카오뱅크, 삼성증권</p>
								<p>네이버페이 카드 간편결제는 네이버페이에서 제공하는 카드사 별 무이자, 청구할인 혜택을 받을 수 있습니다.</p>
							</dd>
						</dl>
					</li>
					<!-- 카카오페이안내문구 -->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_KAKAOPAY?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">카카오페이 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>고객이 온라인 쇼핑몰에서 상품 및 서비스를 카카오페이로 진행하는 결제 서비스 입니다.</p>
								<p>카드번호 유효기간 등의 신용정보는 안전하게 암호화되어 해당 신용카드사로 전달됩니다.</p>
							</dd>
						</dl>
					</li>
					<!--토스페이-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_TOSS?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">토스페이 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>Toss에 등록된 계좌와 신용/체크카드로 쉽고 편리하게 결제하세요.</p>
								<p>이용가능 카드사 : 비씨, 삼성, 롯데, 하나, 신한, 현대카드 (KB카드, NH농협 준비중)</p>
								<p>이용가능 은행 : 20개 은행과 8개 증권사</p>
								<p>토스 간편결제시 토스에서 제공하는 카드사별 무이자, 청구할인, 결제이벤트만 제공됩니다.</p>
								<p>토스머니 결제시 현금영수증은 자동으로 신청됩니다.</p>
							</dd>
						</dl>
					</li>
					<!--페이코-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_PAYCO?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">페이코 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>PAYCO는 NHN엔터테인먼트가 만든 안전한 간편결제 서비스입니다.</p>
								<p>휴대폰과 카드 명의자가 동일해야 결제 가능하며, 결제금액 제한은 없습니다.</p>
								<p>결제 가능 수단 : 모든 국내 신용/체크카드(씨티카드 제외)</p>
							</dd>
						</dl>
					</li>
					<!--가상계좌-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_VBANK?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">가상계좌 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>주문완료 후 1 일 이내 입금완료 하셔야 상품이 발송됩니다.</p>
							</dd>
						</dl>
					</li>
					<!--실시간 계좌이체-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_ICHE?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">실시간 계좌이체 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>상품 및 서비스 대금을 고객이 입력한 본인의 계좌통장에서 실시간으로 출금지불하는 결제 수단입니다.</p>
								<p>&lsqb;마이페이지 > 환불계좌관리&rsqb; 혹은 환불신청 시 입력한 환불계좌로 입금됩니다.</p>
							</dd>
						</dl>
					</li>
					<!--에스크로-->
					<li class="pmt-method-annc__list" devpaymentdescription="<?php echo ORDER_METHOD_ASCROW?>" style="display: none">
						<dl class="pmt-method-annc__item">
							<dt class="pmt-method-annc__tit">에스크로 (가상계좌) 이용안내</dt>
							<dd class="pmt-method-annc__cont">
								<p>주문완료 후 1 일 이내 입금완료 하셔야 상품이 발송됩니다.</p>
								<p>에스크로[가상계좌] 주문 시 부분 취소가 불가하여 전체 취소만 가능합니다. 입금 전 구매하실 제품을 다시 한번 확인해 주시기 바랍니다.</p>
							</dd>
						</dl>
					</li>
<?php }else{?>
					<!--EXIMBAY-->
					<li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_EXIMBAY?>">
						<span class="pmt-method-annc__tit">
							Eximbay
						</span>
						<span class="pmt-method-annc__cont">
							· In the case of a small payment, there may be a limit depending on the PG company's policy.<br>
							· Pay by credit card WITHOUT eximbay account.<br>
							· When you are directed to eximbay Payment page, click on the "Don't have a eximbay account?" link and go to credit card information<br>
							· input page.Or, if you cannot find this link on your screen, you may find links such as "Buy as a guest, Pay with a debit or credit card" or "Continue checkout". Click on the link and you will be able to pay without logging into eximbay.
						</span>
					</li>
<?php }?>
				</ul>
			</section>
			<!-- 결제 방법 E -->
			
			<!-- 구매 시 유의사항 S -->
			<section class="fb__infoinput-info">
				<div class="fb__infoinput-title">
					<div class="title-sm">구매 시 유의사항</div>
				</div>
				<ul class="fb__infoinput-info--list">
					<li>주문 상태가 ‘배송 준비’ 및 ‘배송 중’일 경우 취소처리가 불가합니다.</li>
					<li>반품 신청 시 쿠폰은 재발급 되지 않습니다.</li>
					<li>가상계좌로 주문 시 주문 상태가 ‘입금대기’일 경우 마이페이지에서 취소를 직접 신청 하셔야 처리할 수 있습니다.</li>
					<li>주문하신 제품을 반품하시는 경우 사은품 혜택을 받으신 고객님께서는 반드시 지급된 사은품을 동봉해 주셔야 반품 처리가 됩니다.</li>
					<li>겟배럴닷컴에서 구매하신 제품은 오프라인 매장에서 반품 및 주문 취소가 불가합니다.</li>
					<li>적립금은 구매금액 3만원 이상부터 사용가능합니다.</li>
				</ul>
			</section>
			<!-- 구매 시 유의사항 E -->
		</div>

		<div class="layout-right">

			<div class="shop-right-area fb__infoinput__right-area">
				<div class="shop-total-price2">
					<h2 class="shop-total-price__title">결제 정보</h2>
					<dl class="shop-total-price__cate-total">
						<dt class="shop-total-price__cate-total__title">총 주문금액</dt>
						<dd class="shop-total-price__cate-total__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 상품금액</dt>
						<dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_listprice"><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<!--<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 할인금액</dt>
						<dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_discount_amount"><?php echo g_price($TPL_VAR["cartSummary"]["product_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>-->
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">상품할인</dt>
						<dd class="shop-total-price__cate__price">- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">등급할인</dt>
						<dd class="shop-total-price__cate__price">- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">쿠폰할인</dt>
						<dd class="shop-total-price__cate__price">- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">배송비쿠폰할인</dt>
						<dd class="shop-total-price__cate__price">- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_delivery_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
<?php }?>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 사용 <?php echo $TPL_VAR["mileageName"]?></dt>
						<dd class="shop-total-price__cate__price">-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_mileage">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
<?php }?>
					<dl class="shop-total-price__cate">
						<dt class="shop-total-price__cate__title">총 배송비</dt>
                        <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["cartSummary"]["delivery_price"]?>">
						<dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>(기본)<em devPrice="delivery_add_price"></em></dd>
					</dl>
				</div>
				<button class="btn-lg btn-dark fb__shop__buy-btn" id="devPaymentButton">주문하기</button>

				<!-- 정책 체크박스 S -->
				<div class="agree-area">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
					<div class="agree-top">
						<div class="agree-area">
							<input type="checkbox" class="devTerms" name="all_terms" id="all_terms_check" />
							<label for="all_terms_check">주문 약관 동의(필수)</label>
						</div>
						<p>주문하는 상품의 상품명, 상품가격, 상품수량, 할인, 배송정보 등 주문 정보를 확인하였으며, 결제 및 배럴에서 제공하는 서비스 정책에 동의합니다.</p>
					</div>
<?php }else{?>
					<!-- 비회원 주문시 S -->
					<!-- 숨김처리 되어 있음 -->
					<div class="agree-top">
						<div class="check-area">
							<input type="checkbox" class="devTerms" name="all_terms" id="all_terms_check" />
							<label for="all_terms_check">주문 약관 동의(필수)</label>
						</div>
						<p>주문하는 상품의 상품명, 상품가격, 상품수량, 할인, 배송정보 등 주문 정보를 확인하였으며, 결제 및 배럴에서 제공하는 서비스 정책에 동의합니다.</p>
					</div>
					<div class="agree-content">
						<!-- 전체 체크 박스 S -->
						<div class="agree-content__All">
							<input type="checkbox" id="area-terms-All" class="devTerms" name="termsAll" title="모두 동의합니다." />
							<label for="area-terms-All"><strong>모두 동의합니다.</strong></label>
						</div>
						<!-- 전체 체크 박스 E -->
						<!--<div class="agree-content__item">
							<input type="checkbox" id="area-terms-2" class="devTerms" name="terms-2" title="만 14세 이상입니다. (필수)" />
							<label for="area-terms-2">만 14세 이상입니다. (필수)</label>
						</div>-->
						<div class="agree-content__item">
							<input type="checkbox" id="area-terms-1" class="devTerms" name="terms-1" title="비회원 구매 이용 약관 동의 (필수)" />
							<label for="area-terms-1">비회원 구매 이용 약관 동의 (필수)</label>
							<button type="button" class="btn-s btn-term term-content" name="terms-1">내용보기</button>
						</div>
						<div class="agree-content__item">
							<input type="checkbox" id="area-terms-2" class="devTerms" name="terms-2" title="비회원 개인정보 수집 및 이용 동의 (필수)" />
							<label for="area-terms-2">비회원 개인정보 수집 및 이용 동의 (필수)</label>
							<button type="button" class="btn-s btn-term term-content" name="terms-2">내용보기</button>
						</div>
					</div>
					<!-- 비회원 주문시 E -->
<?php }?>
				</div>
				<!-- 정책 체크박스 E -->
			</div>
		</div>
	</div>
	<div class="infoinput-layer-pop terms-layer-pop popup-layout">
		<p class="popup-title">
			<span>약관 전체보기</span>
			<span class="close"></span>
		</p>
		<div class="pop-cont clearfix popup-content">
			<!--<h2 id="agree_title">비회원 구매 이용약관</h2>-->

			<!-- 개인정보 수집 및 이용 동의 -->
			<div class="pop-cont-detail" id="terms-2">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<?php echo $TPL_VAR["non_collection"]["contents"]?>

<?php }else{?>
				<?php echo $TPL_VAR["collection"]?>

<?php }?>
			</div>

			<!-- 개인정보 취급 위탁 동의 -->
			<div class="pop-cont-detail" id="terms-3">
				<?php echo $TPL_VAR["consign"]["contents"]?>

			</div>

<?php if($TPL_VAR["isThirdBool"]){?>
			<!-- 개인정보 제 3자 정보 제공 동의 -->
			<div class="pop-cont-detail" id="terms-4">
				<?php echo $TPL_VAR["third"]["contents"]?>

			</div>
<?php }?>

			<!-- 비회원 구매 이용약관 -->
<?php if(!$TPL_VAR["layoutCommon"]["isLogin"]){?>
			<!--<div class="pop-cont-detail" id="term<?php echo $TPL_VAR["use"]['ix']?>">-->
			<div class="pop-cont-detail" id="terms-1" style="max-width:800px">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<?php echo $TPL_VAR["use"]["contents"]?>

<?php }else{?>
				<?php echo $TPL_VAR["use"]?>

<?php }?>
			</div>
<?php }?>
		</div>
	</div>
	<?php echo $TPL_VAR["paymentIncludeJavaScript"]?>

	<div id="devPaymentGatewayContents">
	</div>
</section>
<!-- 컨텐츠 영역 E -->