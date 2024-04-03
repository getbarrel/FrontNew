<?php /* Template_ 2.2.8 2021/07/22 17:02:29 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput.htm 000034288 */ 
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


<section class="fb__infoinput fb__shop">
    <div class="wrap-cart next-step">
        <div class="fb__shop__title-area">
            <h2 class="fb__shop__title">Check Out</h2>
            <ul class="fb__shop__step-area">
                <li class="fb__shop__step"><em>01</em> Cart</li>
                <li class="fb__shop__step fb__shop__step--on"><em>02</em> Check Out</li>
                <li class="fb__shop__step"><em>03</em> Order Completed</li>
            </ul>
        </div>

<?php if($TPL_VAR["topBanner"]){?>
        <div class="fb__infoinput__banner">
            <img src="<?php echo $TPL_VAR["topBanner"]["imgSrc"]?>" alt="<?php echo trans($TPL_VAR["topBanner"]["banner_name"])?>">
        </div>
<?php }?>

        <section class="fb__infoinput__order-info order-info">
            <h3 class="order-info__title">Check your items</h3>
<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
                <table class="order-table order-info__table">
                    <colgroup>
                        <col width="*">
                        <col width="145px">
                        <col width="145px">
                        <col width="145px">
                        <col width="145px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Item Name/Option</th>
                            <th>Quantities of order</th>
                            <th>Subtotal</th>
                            <th>Savings</th>
                            <th>Estimated Total</th>
                        </tr>
                    </thead>
                    <tbody>
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
                        <tr>
                            <td class="item-info">
                                <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
                                    <div class="item-info__thumb">
                                        <img src="<?php echo $TPL_V3["image_src"]?>">
                                    </div>
                                    <div class="item-info__info">
                                        <!--<li class="cart-item__pre">-->
                                            <?php echo $TPL_VAR["preface"]?>

                                        <!--</li>-->
                                        <p class="item-info__title">
<?php if($TPL_V3["brand_name"]){?>[<?php echo $TPL_V3["brand_name"]?>] <?php }?><?php echo $TPL_V3["pname"]?>

                                        </p>
<?php if($TPL_V3["set_group"]> 0){?>
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
                                            <span class="item-info__option"><?php echo $TPL_V4["options_text"]?></span>
<?php }}?>
<?php }else{?>
                                            <p class="item-info__option">
                                                <?php echo $TPL_V3["options_text"]?>

                                            </p>
<?php }?>
<?php if(!empty($TPL_V3["add_info"])){?>
                                        <span class="item-info__option"><?php echo $TPL_V3["add_info"]?></span>
<?php }?>
                                    </div>
                                </a>
                            </td>
                            <td><em><?php echo $TPL_V3["pcount"]?></em>ltem(s)</td>
                            <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        </tr>
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
                        <!--//추가구성상품기획미정//-->
                        <tr class="add-product">
                            <td>
                                <div class="item-info__info">
                                    <p class="item-info__title">Additional configuration product</p>
                                    <p class="item-info__option"><?php echo $TPL_V4["opn_text"]?></p>
                                </div>
                            </td>
                            <td><em><?php echo $TPL_V4["opn_count"]?></em>ltem(s)</td>
                            <td></td>
                            <td></td>
                            <td class="due-amount"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V4["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        </tr>
<?php }}?>
<?php if(count($TPL_V3["giftItem"])> 0){?>
                        <tr class="product-gift-wrap">
                            <td colspan="5">
                                <div class="product-gift">
                                    <p class="product-gift__title"><span>GIft</span> <!--배럴 스위머즈 페스티벌--></p>
                                    <ul class="product-gift__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
                                        <li class="product-gift__box inner-gift devGiftList">
                                            <figure class="product-gift__thumb">
                                                <img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>" data-devpid="<?php echo $TPL_V4["pid"]?>" data-devpcount="<?php echo $TPL_V4["cnt"]?>">
                                            </figure>
                                            <div class="product-gift__info">
                                                <span class="product-gift__info__pname"><?php echo $TPL_V4["gift_name"]?></span>
                                                <span class="product-gift__info__count"><?php echo $TPL_V4["cnt"]?> ltem(s)</span>
                                            </div>
                                        </li>
<?php }}?>

                                        <!-- 사은품 선택 안했을 경우 (개별 상품은 사은품 선택안함 표기 하지 않음)-->
                                        <!--
                                        <li class="product-gift__box inner-gift">
                                            <figure class="product-gift__thumb">
                                                <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_no-freebie.png" alt="">
                                            </figure>
                                            <div class="product-gift__info">
                                                <span class="product-gift__info__pname">사은품 선택 안함</span>
                                            </div>
                                        </li>
                                        -->
                                        <!-- // 사은품 선택 안했을 경우 -->
                                    </ul>
                                </div>
                            </td>
                        </tr>
<?php }?>
<?php }}?>
                    </tbody>
                </table>
<?php }}?>
                <div class="delivery-area">
                    <span>Shipping fee <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["deliveryTemplateList"]["total_delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></em> Overseas shipping fee will be charged</span>
                </div>
<?php }}?>

           
        </section>
        <div class="layout-section fb__shop__layout-section" id="devPaymentContents">
            <div class="layout-left">
<?php $this->print_("userTemplate",$TPL_SCP,1);?>


<?php if($TPL_VAR["freeGift"]){?>				<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
				<div class="order-info__pricegift warp_gift_list devOrderGiftArea devOrderGiftArea_<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition = '<?php echo $TPL_V1["freegift_condition"]?>'>
					<div class="gift_list">
						<h3 class="order-info__pricegift__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></h3>
						<ul style="display:none;">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<li>
								<img src="<?php echo $TPL_V2["image_src"]?>" data-devpid="<?php echo $TPL_V2["pid"]?>" alt="">
								<p><?php echo $TPL_V2["pname"]?></p>
							</li>
<?php }}?>
						</ul>
					</div>
					<button class="order-info__pricegift__btn btn-default devGiftBox" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition_text="<?php echo trans($TPL_V1["freegift_condition_text"])?>"><span><?php echo trans($TPL_V1["freegift_condition_text_select"])?></span></button>
					<div class="product-gift devOrderGift_<?php echo $TPL_V1["freegift_condition"]?>" style="display:none;">
						<div class="product-gift__list devOrderGiftList" id="devOrderGiftList_<?php echo $TPL_V1["freegift_condition"]?>">

						</div>
					</div>
				</div>
<?php }?>
<?php }}?>
<?php }?>

                <section class="fb__infoinput__payment-method payment-method">
                    <h2 class="payment-method__title">Method of payment</h2>
                    <ul class="pmt-method">
<?php if($TPL_VAR["langType"]=='english'){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_EXIMBAY?>" id="pay-method-<?php echo ORDER_METHOD_EXIMBAY?>" checked>
                                <label for="pay-method-<?php echo ORDER_METHOD_EXIMBAY?>">Eximbay</label>
                            </li>
<?php }else{?>

                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_CARD?>" id="pay-method-<?php echo ORDER_METHOD_CARD?>" checked>
                                <label for="pay-method-<?php echo ORDER_METHOD_CARD?>">Credit Card</label>
                            </li>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_VBANK?>" id="pay-method-<?php echo ORDER_METHOD_VBANK?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_VBANK?>">Virtual account payment</label>
                            </li>
<?php if(false){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_ICHE?>" id="pay-method-<?php echo ORDER_METHOD_ICHE?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_ICHE?>">Real-time account transfer</label>
                            </li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_payco"]=='Y'){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_PAYCO?>" id="pay-method-<?php echo ORDER_METHOD_PAYCO?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_PAYCO?>">Payco</label>
                            </li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_kakao"]=='Y'){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_KAKAOPAY?>" id="pay-method-<?php echo ORDER_METHOD_KAKAOPAY?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_KAKAOPAY?>">kakao pay</label>
                            </li>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_naverpay_pg"]=='Y'){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_NPAY?>" id="pay-method-<?php echo ORDER_METHOD_NPAY?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_NPAY?>">Naver Pay</label>
                            </li>
<?php }?>

<?php if($TPL_VAR["add_sattle_module_toss"]=='Y'){?>
                            <li class="pmt-method__list">
                                <input type="radio" name="devPaymentMethod" value="<?php echo ORDER_METHOD_TOSS?>" id="pay-method-<?php echo ORDER_METHOD_TOSS?>">
                                <label for="pay-method-<?php echo ORDER_METHOD_TOSS?>">토스</label>
                            </li>
<?php }?>

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
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                                <span class="pmt-method-annc__cont">
                                · This payment service is a credit card service for customers to use online shopping malls for goods and services.<br>
                                · Credit information such as credit card number validity period is securely encrypted and passed to the credit card company.
                            </span>
                        </li>
                        <!--@TODO 휴대폰 결제 안내문구-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_PHONE?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                            <span class="pmt-method-annc__cont">
                                · Member&#39;s mobile phone limitiation is depends on mobile carrier limit<br>
                                · No separate documentation is applied and issued. You can check the billing request for the mobile phone service of the carrier.
                            </span>
                        </li>
                        <!--가상계좌-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_VBANK?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                                <span class="pmt-method-annc__cont">
                                · deposit muste be placed in days <?php echo $TPL_VAR["cancelAutoDay"]?> after completion of order for shipment
                            </span>
                        </li>
                        <!--페이코-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_PAYCO?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                            <span class="pmt-method-annc__cont">
                                · PAYCO is a secure and simple payment service made by NHN Entertainment.<br>
                                · Credit Card and Mobile Phone holders should be matched for the pament and there is no limit for payment<br>
                                · Paymentable Method: All overseas credit/check cards
                            </span>
                        </li>
                        <!--네이버페이-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_NPAY?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                            <span class="pmt-method-annc__cont">
                                · (english)주문 변경 시 카드사 혜택 및 할부 적용 여부는 해당 카드사 정책에 따라 변경될 수 있습니다.<br>
                                · Naver Pay is a simple payment service that allows users to register their credit card or bank account information with their Naver ID without installing a separate app.<br>
                                · (english)결제 가능한 신용카드: 신한, 삼성, 현대, BC, 국민, 하나, 롯데, NH농협, 씨티, 카카오뱅크<br>
                                · (english)결제 가능한 은행: NH농협, 국민, 신한, 우리, 기업, SC제일, 부산, 경남, 수협, 우체국, 미래에셋대우, 광주, 대구, 전북, 새마을금고, 제주은행, 신협, 하나은행, 케이뱅크, 카카오뱅크, 삼성증권<br>
                                · Naver Pay card simple payment can receive interest-free and billing-in benefits for each credit card company provided by Naver Pay.
                            </span>
                        </li>
                        <!--토스-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_TOSS?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                            <span class="pmt-method-annc__cont">
                                · (english)Toss에 등록된 계좌와 신용/체크카드로 쉽고 편리하게 결제하세요.<br>
                                · (english)이용가능 카드사 : 비씨, 삼성, 롯데, 하나, 신한, 현대카드 (KB카드, NH농협 준비중)<br>
                                · (english)이용가능 은행 : 20개 은행과 8개 증권사<br>
                                · (english)토스 간편결제시 토스에서 제공하는 카드사별 무이자, 청구할인, 결제이벤트만 제공됩니다.<br>
                                · (english)토스머니 결제시 현금영수증은 자동으로 신청됩니다.
                            </span>
                        </li>
                        <!--@TODO 카카오페이안내문구-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_KAKAOPAY?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                            <span class="pmt-method-annc__cont">
                                · This payment service is a payment service that enables customers to use Kakao Pay for products and services in online shopping malls.<br>
                                · Credit information such as credit card number validity period is securely encrypted and passed to the credit card company.
                            </span>
                        </li>
                        <!--실시간 계좌이체-->
                        <li class="pmt-method-annc__list" devPaymentDescription="<?php echo ORDER_METHOD_ICHE?>">
                            <span class="pmt-method-annc__tit">
                                Payment Guide
                            </span>
                                <span class="pmt-method-annc__cont">
                                · This is a payment method that allows payment of goods and services to be paid out in real time from the account bank account entered by the customer.<br>
                                · (english)&lsqb;마이페이지 > 환불계좌관리&rsqb; 혹은 환불신청 시 입력한 환불계좌로 입금됩니다.
                            </span>
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
            </div>

            <div class="layout-right">
                <div class="shop-right-area fb__infoinput__right-area">
                    <div class="shop-total-price">
                        <h2 class="shop-total-price__title">Total Amount</h2>
                        <dl class="shop-total-price__cate">
                            <dt class="shop-total-price__cate__title">Item Total</dt>
                            <dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="shop-total-price__cate">
                            <dt class="shop-total-price__cate__title">Savings</dt>
                            <dd class="shop-total-price__cate__price">
                                <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_discount_amount"><?php echo g_price($TPL_VAR["cartSummary"]["product_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                            </dd>
                        </dl>
                        <div class="disc-list">
                            <dl>
                                <dt>Item-discount</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                            <dl>
                                <dt>Membership-discount</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Coupons</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>(english)배송비쿠폰할인</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_delivery_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
<?php }?>
                        </div>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                        <dl class="shop-total-price__cate">
                            <dt class="shop-total-price__cate__title">Reward</dt>
                            <dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_mileage">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
<?php }?>
                        <dl class="shop-total-price__cate">
                            <dt class="shop-total-price__cate__title">Shipping</dt>
                            <dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="total_delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["total_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <div class="disc-list delivery">
                            <dl>
                                <dt>Total shipping cost by product</dt>
                                <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["cartSummary"]["delivery_price"]?>">
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Regional Additional Shipping Costs</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="delivery_add_price"><?php echo g_price($TPL_VAR["cartSummary"]["delivery_add_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                        </div>
                        <dl class="total shop-total-price__cate-total">
                            <dt class="shop-total-price__cate-total__title">Estimated Total</dt>
                            <dd class="shop-total-price__cate-total__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                    <div class="agree-area">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                        <div class="agree-top on">
                            <p>위 주문의 상품,가격,할인,배송정보를 확인하였으며, 결제 및 배럴에서 제공하는 서비스 정책에 동의합니다. (필수)</p>
                            <div class="agree-area">
                                <input type="checkbox" class="devTerms" name="all_terms" id="all_terms_check"><label for="all_terms_check">Agree</label>
                            </div>
                        </div>
<?php }else{?>
                        <div class="agree-top toggle on">
                            <p>위 주문의 상품,가격,할인,배송정보를 확인하였으며, 결제 및 배럴에서 제공하는 서비스 정책에 동의합니다. (필수)</p>
                            <div class="check-area">
                                <input type="checkbox" class="devTerms" name="all_terms" id="all_terms_check"><label for="all_terms_check">Agree</label>
                            </div>
                        </div>
                        <div class="agree-content">
                            <!--<div class="top">-->
                                <!--<p>-->
                                    <!--We have confirmed the product, price, shipping information, discount details, etc. to order, and do you agree with the purchase?-->
                                <!--</p>-->
                                <!--<input type="checkbox" id="area-terms-1" class="devTerms" name="terms-1" title='구매에 동의'><label for='area-terms-1'>Agree. <span></span> </label>-->
                            <!--</div>-->
                            <!--@TODO 비회원 이용약관 확인 필요-->
                            <div>
                                <input type="checkbox" id="area-terms-1" class="devTerms" name="terms-1" title="Term of use for non member purchase (Required)">
                                <label for='area-terms-1'>Term of use for non member purchase (Required)</label>
                                <button class="term-content" name="terms-1">Detail</button>
                            </div>
                            <div>
                                <input type="checkbox" id="area-terms-2" class="devTerms" name="terms-2" title="Terms and conditions of personal information collection and utilization">
                                <label for='area-terms-2'>Privacy Policy (Required)</label>
                                <button class="term-content" name="terms-2">Detail</button>
                            </div>
<?php if(false){?>
                            <div>
                                <input type="checkbox" id="area-terms-3" class="devTerms" name="terms-3" title="Consent of consignment for handling personal information">
                                <label for='area-terms-3'>Consent of consignment for handling personal information (Required)</label>
                                <button class="term-content" name="terms-3">Detail</button>
                            </div>
<?php }?>
<?php if($TPL_VAR["isThirdBool"]){?>
                            <div>
                                <input type="checkbox" id="area-terms-4" class="devTerms" name="terms-4" title="Consent on the provision of third-party personal information">
                                <label for='area-terms-4'>Consent on the provision of third-party personal information</label>
                                <button class="term-content" name="terms-4">Detail</button>
                            </div>
<?php }?>
                        </div>
<?php }?>
                    </div>
                    <button class="btn-lg fb__btn-point fb__shop__pay-btn" id="devPaymentButton">Place order</button>
                    <button class="btn-lg btn-dark fb__shop__cancel-btn" id="devPaymentCancelButton">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="infoinput-layer-pop terms-layer-pop popup-layout">
        <p class="popup-title">
            <span>to view the Term</span>
            <span class="close"></span>
        </p>
        <div class="pop-cont clearfix popup-content">
            <!--<h2 id="agree_title">Term of use for non member purchase</h2>-->

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