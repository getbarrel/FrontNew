<?php /* Template_ 2.2.8 2021/07/22 16:54:47 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput.htm 000029864 */ 
$TPL_cart_1=empty($TPL_VAR["cart"])||!is_array($TPL_VAR["cart"])?0:count($TPL_VAR["cart"]);
$TPL_firstCartDeliveryTemplateData_1=empty($TPL_VAR["firstCartDeliveryTemplateData"])||!is_array($TPL_VAR["firstCartDeliveryTemplateData"])?0:count($TPL_VAR["firstCartDeliveryTemplateData"]);
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<script>
	var emnet_tagm_products=[];
    window.onpageshow = function(event) {
        if ( event.persisted || (window.performance && window.performance.navigation.type == 2)) {
            window.location.reload();
        }
    };
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


<section class="br__infoinput">
    <div class="infoinput__header">
        <a href="javascript:history.back();" class="infoinput__header__btn">뒤로가기 버튼</a>
        <h2 class="infoinput__header__title">Check Out</h2>
    </div>
<?php if($TPL_VAR["topBanner"]){?>
    <div class="br__infoinput__banner">
        <img src="<?php echo $TPL_VAR["topBanner"]["imgSrc"]?>" alt="<?php echo trans($TPL_VAR["topBanner"]["banner_name"])?>">
    </div>
<?php }?>
    <!-- [S] 주문 상품 -->
    <section class="br__infoinput__goods">
        <div class="infoinput__toggle">
            <h3 class="infoinput__toggle__title">
                Item
                <span class="infoinput__toggle__sub"><?php if($TPL_VAR["langType"]=='korean'){?>Items<?php }?> <span id="devOrderTotalCnt"><?php echo $TPL_VAR["cartSummary"]["product_total_count"]?></span>ltem(s)</span>
                <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
            </h3>
            <div class="infoinput__toggle__content">
                <div class="info-goods">
                    <ul class="info-goods__list">
<?php if($TPL_firstCartDeliveryTemplateData_1){foreach($TPL_VAR["firstCartDeliveryTemplateData"] as $TPL_V1){
$TPL_productList_2=empty($TPL_V1["productList"])||!is_array($TPL_V1["productList"])?0:count($TPL_V1["productList"]);?>
<?php if($TPL_productList_2){foreach($TPL_V1["productList"] as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);
$TPL_addOptionList_3=empty($TPL_V2["addOptionList"])||!is_array($TPL_V2["addOptionList"])?0:count($TPL_V2["addOptionList"]);
$TPL_giftItem_3=empty($TPL_V2["giftItem"])||!is_array($TPL_V2["giftItem"])?0:count($TPL_V2["giftItem"]);?>
                        <li class="info-goods__box">
                            <figure class="info-goods__box__thumb">
                                <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>">
                                    <img src="<?php echo $TPL_V2["image_src"]?>" alt="[<?php echo $TPL_V2["brand_name"]?>] <?php echo $TPL_V2["pname"]?>">
                                </a>
                            </figure>
                            <div class="info-goods__box__info">
                                <p class="info-goods__box__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                                <p class="info-goods__box__option">
<?php if($TPL_V2["set_group"]> 0){?>                                    <?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
                                    <span><?php echo $TPL_V3["options_text"]?> / <em><?php echo $TPL_V2["pcount"]?></em></span>
<?php }}?>
<?php }else{?>                                    <span id="opt_idx_<?php echo $TPL_V2["cart_ix"]?>" data-val="<?php echo $TPL_V2["options_text"]?>"><?php echo $TPL_V2["options_text"]?> / <em><?php echo $TPL_V2["pcount"]?></em></span>
<?php }?>
<?php if(!empty($TPL_V2["add_info"])){?>
                                    <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                </p>

<?php if($TPL_addOptionList_3){foreach($TPL_V2["addOptionList"] as $TPL_V3){?>
                                <div class="contents">
                                    <p class="tit">Additional configuration product</p>
                                    <p class="option"><?php echo $TPL_V3["opn_text"]?> / <?php echo $TPL_V3["opn_count"]?>ltem(s)</p>
                                    <dl>
                                        <dt>Estimated Total</dt>
                                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                    </dl>
                                    <dl class="sub">
                                        <dt>Subtotal</dt>
                                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                    </dl>
                                </div>
<?php }}?>
                                <div class="info-goods__box__price">
<?php if($TPL_V2["discount_rate"]){?>
                                    <span class="info-goods__box__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["total_listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
                                    <span class="info-goods__box__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["total_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_V2["discount_rate"]){?>
                                    <span class="info-goods__box__price--discount">[<?php echo $TPL_V2["discount_rate"]?>%]</span>
<?php }?>
                                </div>

                            </div>
<?php if(count($TPL_V2["giftItem"])> 0){?>                            <div class="info-goods__freebie">
                                <p class="info-goods__freebie__title"><span>GIft</span> <?php echo $TPL_VAR["giftItem"]["gift_title"]?></p>
<?php if($TPL_giftItem_3){foreach($TPL_V2["giftItem"] as $TPL_V3){?>
                                <div class="info-goods__freebie__box devGiftList">
                                    <div class="info-goods__freebie__thumb">
                                        <figure>
                                            <img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["gift_name"]?>" data-devpid="<?php echo $TPL_V3["pid"]?>" data-devpcount="<?php echo $TPL_V3["cnt"]?>">
                                        </figure>
                                    </div>
                                    <div class="info-goods__freebie__info">
                                        <p class="info-goods__freebie__text"><?php echo $TPL_V3["gift_name"]?> / <?php echo $TPL_V3["cnt"]?>개</p>
                                    </div>
                                </div>
<?php }}?>

                                <!-- 사은품 선택 안했을 경우 (개별 상품은 사은품 선택안함 표기 하지 않음) -->
                                <!--
                                <div class="info-goods__freebie__box">
                                    <div class="info-goods__freebie__thumb">
                                        <figure>
                                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_no-freebie_mo.png" alt="">
                                        </figure>
                                    </div>
                                    <div class="info-goods__freebie__info">
                                        <p class="info-goods__freebie__text">사은품 선택 안함</p>
                                    </div>
                                </div>
                                -->
                                <!-- // 사은품 선택 안했을 경우 -->

                            </div>
<?php }?>
                        </li>
<?php }}?>
<?php }}?>
                    </ul>

                </div>
            </div>
        </div>
    </section>
    <!-- [E] 주문 상품 -->
    

    <div id="devPaymentContents">

<?php $this->print_("userTemplate",$TPL_SCP,1);?>


<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
    <section class="br__infoinput__freebie devOrderGiftArea devOrderGiftArea_<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition = '<?php echo $TPL_V1["freegift_condition"]?>'>
        <div class="infoinput__toggle">
            <h3 class="infoinput__toggle__title">
                <?php echo trans($TPL_V1["freegift_condition_text"])?>

                <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
            </h3>
            <div class="infoinput__toggle__content">
                <div class="info-goods__freebie-sel">
                    <button type="button" class="info-goods__freebie-sel__btn devGiftBox" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition_text="<?php echo trans($TPL_V1["freegift_condition_text"])?>"><?php echo trans($TPL_V1["freegift_condition_text_select"])?></button>
                    <p class="info-goods__freebie-sel__notice">If you do not return the item for exchange or refund, please note that cancellation is not possible.</p>
                    <div class="info-goods__freebie devOrderGift devOrderGift_<?php echo $TPL_V1["freegift_condition"]?>" style="display:none;">
                        <p class="info-goods__freebie__title"><span>GIft</span> <?php echo $TPL_VAR["orderGiftItem"]["gift_title"]?></p>
                        <div class="devOrderGiftList" id="devOrderGiftList_<?php echo $TPL_V1["freegift_condition"]?>">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>
<?php }}?>
<?php }?>

    <!-- [S] 결제예정금액 -->
    <section class="br__infoinput__payment">
        <div class="infoinput__toggle">
            <h3 class="infoinput__toggle__title">
                Estimated Total
                <span class="infoinput__toggle__sub infoinput__toggle__sub--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><span devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
            </h3>
            <div class="infoinput__toggle__content">
                <div class="info-payment">
                    <dl class="info-payment__box">
                        <dt class="info-payment__title">Item Total</dt>
                        <dd class="info-payment__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="info-payment__box">
                        <dt class="info-payment__title">Savings</dt>
                        <dd class="info-payment__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span devPrice="product_discount_amount"><?php echo g_price($TPL_VAR["cartSummary"]["product_discount_amount"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <ul class="info-payment__detail">
                        <li class="info-payment__detail__box">
                            <span class="info-payment__detail__title">Item-discount : </span>
                            <span class="info-payment__detail__pay">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["cartSummary"]["product_basic_discount_amount"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
<?php if(is_login()){?>
                        <li class="info-payment__detail__box">
                            <span class="info-payment__detail__title">Membership-discount : </span>
                            <span class="info-payment__detail__pay">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["cartSummary"]["product_mem_discount_amount"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
<?php }?>
                        <!--<li class="info-payment__detail__box">-->
                            <!--<span class="info-payment__detail__title">special discount : </span>-->
                            <!--<span class="info-payment__detail__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>- <?php echo g_price($TPL_VAR["cartSummary"]["product_Special_discount_amount"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>-->
                        <!--</li>-->
<?php if(is_array($TPL_R1=$TPL_VAR["cartSummary"]["productDiscountList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                        <!--<li class="info-payment__detail__box">-->
                        <!--<span class="info-payment__detail__title"><?php echo $TPL_V1["title"]?> : </span>-->
                        <!--<span class="info-payment__detail__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["discount_amount"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>-->
                        <!--</li>-->
<?php }}?>
<?php if(is_login()){?>
                        <li class="info-payment__detail__box">
                            <span class="info-payment__detail__title">Coupons : </span>
                            <span class="info-payment__detail__pay">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span  devPrice="use_cupon">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
                        <li class="info-payment__detail__box">
                            <span class="info-payment__detail__title">(english)배송비쿠폰할인 : </span>
                            <span class="info-payment__detail__pay">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span  devPrice="use_delivery_cupon">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
<?php }?>
<?php if(is_login()){?>
                        <li class="info-payment__detail__box">
                            <span class="info-payment__detail__title">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                <?php echo $TPL_VAR["mileageName"]?>Use :
<?php }else{?>
                                Reward Use :
<?php }?>
                            </span>
                            <span class="info-payment__detail__pay">- <?php echo $TPL_VAR["fbUnit"]["f"]?><span devPrice="use_mileage">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
<?php }?>
                    </ul>
                    <dl class="info-payment__box">
                        <dt class="info-payment__title">Shipping fee
                            <div class="br__delivery-desc">
                                <span><?php echo $TPL_VAR["deliveryTemplateList"]["delivery_text"]?></span>
                            </div>
                        </dt>
                        <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["cartSummary"]["delivery_price"]?>">
                        <dd class="info-payment__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span  devPrice="total_delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["total_delivery_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="info-payment__result">
                        <dt class="info-payment__result__title">Estimated Total</dt>
                        <dd class="info-payment__result__pay"><?php echo $TPL_VAR["fbUnit"]["f"]?><span devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </section>
    <!-- [E] 결제금액 -->

    <!-- [S] 결제수단 -->
    <section class="br__infoinput__pay-type">
        <div class="infoinput__toggle">
            <h3 class="infoinput__toggle__title">
                method of payment
<?php if($TPL_VAR["langType"]=='english'){?>
                    <span class="infoinput__toggle__sub" id="devPayTypeView">Eximbay</span>
<?php }else{?>
                    <span class="infoinput__toggle__sub" id="devPayTypeView">Credit Card</span>
<?php }?>
                <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
            </h3>
            <div class="infoinput__toggle__content">
                <div class="info-paytype">
                    <div class="info-paytype__list devPayTypeArea">
<?php if($TPL_VAR["langType"]=='english'){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_EXIMBAY?>" class="info-paytype__btn info-paytype__btn--active">Eximbay</button>
<?php }else{?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_CARD?>"  class="info-paytype__btn info-paytype__btn--active">Credit card slip</button>

<?php if(false){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_ICHE?>"  class="info-paytype__btn">Real-time account transfer</button>
<?php }?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_VBANK?>"  class="info-paytype__btn">Virtual account payment</span></button>
<?php if($TPL_VAR["add_sattle_module_payco"]=='Y'){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_PAYCO?>" class="info-paytype__btn">Payco <span>(Simple payment)</span></button>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_kakao"]=='Y'){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_KAKAOPAY?>" class="info-paytype__btn">kakao pay</button>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_naverpay_pg"]=='Y'){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_NPAY?>" class="info-paytype__btn">Naver Pay</button>
<?php }?>

<?php if($TPL_VAR["add_sattle_module_toss"]=='Y'){?>
                            <button devPaymentMethod="<?php echo ORDER_METHOD_TOSS?>" class="info-paytype__btn">토스</button>
<?php }?>

<?php }?>

<?php if(DB_CONNECTION_DIV=='development'){?>
                        <button devPaymentMethod="<?php echo ORDER_METHOD_BANK?>" class="info-paytype__btn">without bankbook (for TEST)</button>
<?php }?>
                    </div>
                    <div class="info-paytype__notice">
                        <!-- 카드결제 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_CARD?>">
                            <li class="info-paytype__notice__desc">This payment service is a credit card service for customers to use online shopping malls for goods and services.</li>
                            <li class="info-paytype__notice__desc">Credit information such as credit card number validity period is securely encrypted and passed to the credit card company.</li>
                        </ul>
                        <!-- 실시간계좌이체 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_ICHE?>">
                            <li class="info-paytype__notice__desc">This is a payment method that allows payment of goods and services to be paid out in real time from the account bank account entered by the customer.</li>
                            <li class="info-paytype__notice__desc">(english)&lsqb;마이페이지 > 환불계좌관리&rsqb; 혹은 환불신청 시 입력한 환불계좌로 입금됩니다.</li>
                        </ul>
                        <!-- 휴대폰결제 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_PHONE?>">
                            <li class="info-paytype__notice__desc">The member&#39;s mobile payment limit is applied according to the service limit by carrier.</li>
                            <li class="info-paytype__notice__desc">No separate documentation is applied and issued. You can check the billing request for the mobile phone service of the carrier.</li>
                        </ul>
                        <!-- 가상 계좌 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_VBANK?>">
                            <li class="info-paytype__notice__desc">You must deposit within <?php echo $TPL_VAR["cancellAutoDay"]?> days of order completion to send the product.</li>
                        </ul>
                        <!-- 페이코 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_PAYCO?>">
                            <li class="info-paytype__notice__desc">-PAYCO is a secure and simple payment service made by NHN Entertainment.</li>
                            <li class="info-paytype__notice__desc">-Credit Card and Mobile Phone holders should be matched for the pament and there is no limit for payment</li>
                            <li class="info-paytype__notice__desc">-Paymentable Method: All overseas credit/check cards</li>
                        </ul>
                        <!-- 네이버페이 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_NPAY?>">
                            <li class="info-paytype__notice__desc">-(english)주문 변경 시 카드사 혜택 및 할부 적용 여부는 해당 카드사 정책에 따라 변경될 수 있습니다.</li>
                            <li class="info-paytype__notice__desc">-Naver Pay is a simple payment service that allows users to register their credit card or bank account information with their Naver ID without installing a separate app.</li>
                            <li class="info-paytype__notice__desc">-(english)결제 가능한 신용카드: 신한, 삼성, 현대, BC, 국민, 하나, 롯데, NH농협, 씨티, 카카오뱅크</li>
                            <li class="info-paytype__notice__desc">-(english)결제 가능한 은행: NH농협, 국민, 신한, 우리, 기업, SC제일, 부산, 경남, 수협, 우체국, 미래에셋대우, 광주, 대구, 전북, 새마을금고, 제주은행, 신협, 하나은행, 케이뱅크, 카카오뱅크, 삼성증권</li>
                            <li class="info-paytype__notice__desc">-Naver Pay card simple payment can receive interest-free and billing-in benefits for each credit card company provided by Naver Pay.</li>
                        </ul>
                        <!-- 토스 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_TOSS?>">
                            <li class="info-paytype__notice__desc">-(english)Toss에 등록된 계좌와 신용/체크카드로 쉽고 편리하게 결제하세요.</li>
                            <li class="info-paytype__notice__desc">-(english)이용가능 카드사 : 비씨, 삼성, 롯데, 하나, 신한, 현대카드 (KB카드, NH농협 준비중)</li>
                            <li class="info-paytype__notice__desc">-(english)이용가능 은행 : 20개 은행과 8개 증권사</li>
                            <li class="info-paytype__notice__desc">-(english)토스 간편결제시 토스에서 제공하는 카드사별 무이자, 청구할인, 결제이벤트만 제공됩니다.</li>
                            <li class="info-paytype__notice__desc">-(english)토스머니 결제시 현금영수증은 자동으로 신청됩니다.</li>
                        </ul>
                        <!-- 카카오페이 -->
                        <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_KAKAOPAY?>">
                            <li class="info-paytype__notice__desc">-This payment service is a payment service that enables customers to use Kakao Pay for products and services in online shopping malls.</li>
                            <li class="info-paytype__notice__desc">Credit information such as credit card number validity period is securely encrypted and passed to the credit card company.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [E] 결제수단 -->

    <!-- [S] 비회원 약관동의-->
<?php if(!$TPL_VAR["layoutCommon"]["isLogin"]){?>
    <section class="br__infoinput__non-agree">
        <div class="infoinput__toggle">
            <h3 class="infoinput__toggle__title">
                Term Agreement for Non-Member
                <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
            </h3>
            <div class="infoinput__toggle__content">
                <div class="agree-area js__check-wrap">
                    <div class="agree-content">
                        <!--@TODO 비회원 이용약관 확인 필요-->
                        <div class="agree-content__inner">
                            <input type="checkbox" class="js__check-all">
                            <label>Agree all</label>
                        </div>
                        <div class="agree-content__inner">
                            <div class="agree-content__inner__title agree-content__inner__title--active">
                                <input type="checkbox" class="js__check-porsonal devTerms" name="terms-1" title="Term of use for non member purchase (Required)">
                                <label>Term of use for non member purchase (Required)</label>
                            </div>
                            <div class="agree-content__inner__cont">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                <?php echo $TPL_VAR["use"]["contents"]?>

<?php }else{?>
                                <?php echo $TPL_VAR["use"]?>

<?php }?>
                            </div>
                        </div>
<?php if(true){?>
                        <div class="agree-content__inner">
                            <div class="agree-content__inner__title">
                                <input type="checkbox" class="js__check-porsonal devTerms" name="terms-2" title="Terms and conditions of personal information collection and utilization">
                                <label>Terms and Conditions (Required) Privacy Policy Recieve Email (Optional)</label>
                            </div>
                            <div class="agree-content__inner__cont">
                                <?php echo $TPL_VAR["non_collection"]["contents"]?>

                            </div>
                        </div>
<?php }?>
                        <!--<div class="agree-content__inner">-->
                            <!--<div class="agree-content__inner__title">-->
                                <!--<input type="checkbox" class="js__check-porsonal devTerms" name="terms-3" title="Consent of consignment for handling personal information">-->
                                <!--<label>Consent of consignment for handling personal information (Required)</label>-->
                            <!--</div>-->
                            <!--<div class="agree-content__inner__cont">-->
                                <!-- <?php echo $TPL_VAR["consign"]["contents"]?> -->
                            <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [E] 비회원 약관동의-->
<?php }?>
    <!-- [S] 결제하기 -->
    <div class="br__infoinput__submit">
        <div class="info-submit">
            <label class="info-submit__check">
                <input type="checkbox" class="devTerms" name="terms-1" title='결제에 동의'>
                <span class="info-submit__check__text">위 주문의 상품,가격,할인,배송정보를 확인하였으며,<br>결제 및 배럴에서 제공하는 서비스 정책에 동의합니다. (필수)</span>
            </label>
            <button class="info-submit__btn" id="devPaymentButton"><em><?php echo $TPL_VAR["fbUnit"]["f"]?></em><span devprice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></span> Place Order</button>
        </div>
    </div>
    <!-- [E] 결제하기 -->

    </div>
</section>
<?php echo $TPL_VAR["paymentIncludeJavaScript"]?>

<div id="devPaymentGatewayContents">
</div>