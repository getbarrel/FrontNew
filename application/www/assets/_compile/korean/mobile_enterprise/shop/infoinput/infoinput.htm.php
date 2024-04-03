<?php /* Template_ 2.2.8 2024/03/26 16:54:33 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput.htm 000048159 */ 
$TPL_cart_1=empty($TPL_VAR["cart"])||!is_array($TPL_VAR["cart"])?0:count($TPL_VAR["cart"]);
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$TPL_cartCouponList_1=empty($TPL_VAR["cartCouponList"])||!is_array($TPL_VAR["cartCouponList"])?0:count($TPL_VAR["cartCouponList"]);
$TPL_deliveryCouponList_1=empty($TPL_VAR["deliveryCouponList"])||!is_array($TPL_VAR["deliveryCouponList"])?0:count($TPL_VAR["deliveryCouponList"]);?>
<script>
    //레이아웃 인클로드 js (퍼블리싱)
    $(document).ready(function () {
        //결제방법 선택 JS
        $(".info-paytype__btn").on("click", function () {
            var mathodItem = $(this).index();
            $(".info-paytype__btn").removeClass("info-paytype__btn--active");
            $(this).addClass("info-paytype__btn--active");
            $(".info-paytype__notice__list").hide();
            $(".info-paytype__notice__list").eq(mathodItem).show();
        });
    });
</script>
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

<script>
    function medthChange(val){
        $('#devPaymentMethod').val(val);
    }
</script>


<!-- 컨텐츠 S -->
<section class="br__infoinput" id="devPaymentContents">
<?php $this->print_("userTemplate",$TPL_SCP,1);?>


    <!-- 주문 상품 S -->
    <section class="br__infoinput__goods">
        <div class="infoinput-goods">
            <div class="page-title">
                <div class="title-md">주문 상품 정보</div>
                <!--<span class="total-count">총 <em>4</em>개</span>-->
            </div>
            <div class="product-list">
<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
                <ul class="product-list__wrap">
                    <li class="product-list__item">
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
                        <!-- 상품 영역 S -->
                        <dl class="product-list__group">
                            <dt class="product-list__group-left">
                                <figure class="product-list__thumb">
                                    <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
                                        <img src="<?php echo $TPL_V3["image_src"]?>" alt="" />
                                    </a>
                                </figure>
                            </dt>
                            <dd class="product-list__group-right">
                                <div class="product-list__info">
                                    <div class="product-list__info__title"><?php if($TPL_V3["brand_name"]){?>[<?php echo $TPL_V3["brand_name"]?>] <?php }?><?php echo $TPL_V3["pname"]?></div>
                                    <div class="product-list__info__option">
<?php if($TPL_V3["set_group"]> 0){?>
                                        <!-- 세트 상품 S -->
                                        <input type="hidden" name="cartType" class="cartType" value="set" />
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
                                            <div class="product-list__info__option-item">

                                                <span><?php echo $TPL_V4["options_text"]?></span>

<?php if(!empty($TPL_V3["add_info"])){?>
                                                <span><?php echo $TPL_V3["add_info"]?></span>
<?php }?>
                                                <span><?php echo $TPL_V3["pcount"]?>개</span>
                                            </div>
<?php }}?>
                                        <!-- 세트 상품 E -->
<?php }else{?>
                                        <!-- 일반상품 상품 S -->
                                            <div class="product-list__info__option-item">
<?php if(!empty($TPL_V3["add_info"])){?>
                                                <span><?php echo $TPL_V3["add_info"]?></span>
<?php }?>
                                                <span><?php echo str_replace("사이즈:","",$TPL_V3["options_text"])?></span>
                                                <span><?php echo $TPL_V3["pcount"]?>개</span>
                                            </div>
                                        <!-- 일반상품 상품 E -->
<?php }?>
                                    </div>


                                    <div class="product-list__info__price">
<?php if($TPL_V3["discount_rate"]){?>
                                        <span class="product-list__info__price--discount">[<?php echo $TPL_V3["discount_rate"]?>%]</span>
<?php }?>
<?php if($TPL_V3["discount_rate"]){?>
                                        <del class="product-list__info__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></del>
<?php }?>
                                        <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                    </div>
                                </div>
                            </dd>
                        </dl>

                        <!-- 상품 영역 E -->
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
<?php }}?>
<?php if(count($TPL_V3["giftItem"])> 0){?>

                        <!-- 사은품 S -->
                        <div class="product-list__freebie">
                            <div class="product-list__freebie__title"><span>구매 사은품</span></div>
                            <ul class="product-list__freebie__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
                                <li class="product-list__freebie__box">
                                    <div class="product-list__freebie__thumb">
                                        <figure>
                                            <img src="<?php echo $TPL_V4["image_src"]?>" alt="" data-devpid="<?php echo $TPL_V4["pid"]?>" data-devpcount="<?php echo $TPL_V4["cnt"]?>" />
                                        </figure>
                                    </div>
                                    <div class="product-list__freebie__info">
                                        <div class="product-list__freebie__name"><?php echo $TPL_V4["gift_name"]?></div>
                                        <div class="product-list__freebie__option">
                                            <div class="product-list__freebie__option-item">
                                                <!--<span>페일네온옐로우</span>
                                                <span>OS</span>-->
                                                <span><?php echo $TPL_V4["cnt"]?>개</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
<?php }}?>
                            </ul>
                        </div>
<?php }?>
<?php }}?>
                        <!-- 사은품 E -->
                    </li>
                    <!--<li class="product-list__item">
                        <dl class="product-list__group">
                            <dt class="product-list__group-left">
                                <figure class="product-list__thumb">
                                    <a href="#;">
                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                    </a>
                                </figure>
                            </dt>
                            <dd class="product-list__group-right">
                                <div class="product-list__info">
                                    <div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>

                                     세트 상품 S
                                     숨김처리
                                    <div class="product-list__info__option set">
                                        <div class="product-list__info__option-item">
                                            <span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
                                            <span class="color">블랙</span>
                                            <span class="size">M</span>
                                            <span class="count">1개</span>
                                        </div>
                                        <div class="product-list__info__option-item">
                                            <span class="set-tit">유니섹스 트랙 셋업 팬츠</span>
                                            <span class="color">블랙</span>
                                            <span class="size">M</span>
                                            <span class="count">1개</span>
                                        </div>
                                    </div>
                                     세트 상품 E

                                    <div class="product-list__info__price">
                                        <span class="product-list__info__price&#45;&#45;cost"><em>1,265,550</em>원</span>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </li>
                    <li class="product-list__item">
                        <dl class="product-list__group">
                            <dt class="product-list__group-left">
                                <figure class="product-list__thumb">
                                    <a href="#;">
                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                    </a>
                                </figure>
                            </dt>
                            <dd class="product-list__group-right">
                                <div class="product-list__info">
                                    <div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>
                                     일반상품 상품 S
                                    <div class="product-list__info__option">
                                        <div class="product-list__info__option-item">
                                            <span class="color">미드나잇</span>
                                            <span class="size">95</span>
                                            <span class="count">1개</span>
                                        </div>
                                    </div>
                                     일반상품 상품 E

                                    <div class="product-list__info__price">
                                        <span class="product-list__info__price&#45;&#45;discount">10%</span>
                                        <del class="product-list__info__price&#45;&#45;strike"><em>1,405,550</em>원</del>
                                        <span class="product-list__info__price&#45;&#45;cost"><em>1,265,550</em>원</span>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </li>
                    <li class="product-list__item">
                        <dl class="product-list__group">
                            <dt class="product-list__group-left">
                                <figure class="product-list__thumb">
                                    <a href="#;">
                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                    </a>
                                </figure>
                            </dt>
                            <dd class="product-list__group-right">
                                <div class="product-list__info">
                                    <div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>
                                     일반상품 상품 S
                                    <div class="product-list__info__option">
                                        <div class="product-list__info__option-item">
                                            <span class="color">미드나잇</span>
                                            <span class="size">95</span>
                                            <span class="count">1개</span>
                                        </div>
                                    </div>
                                     일반상품 상품 E

                                    <div class="product-list__info__price">
                                        <span class="product-list__info__price&#45;&#45;cost"><em>1,265,550</em>원</span>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </li>-->
                </ul>
<?php }}?>
<?php }}?>
            </div>
        </div>

        <!-- 사은품 S -->
<?php if($TPL_VAR["freeGift"]){?>        <?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
        <div class="infoinput-goods__gifts devOrderGiftArea devOrderGiftArea_<?php echo $TPL_V1["freegift_condition"]?>" data-freegift_condition = '<?php echo $TPL_V1["freegift_condition"]?>'>
            <div class="page-title">
                <div class="title-md"><?php echo trans($TPL_V1["freegift_condition_text"])?></div>
                <span class="total-count"><em><?php echo trans($TPL_V1["gift_cnt"])?></em>개 선택 가능.</span>
            </div>
            <div class="product-list">
                <ul class="product-list__wrap">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="product-list__item devOrderGiftList" id="devOrderGiftList_<?php echo $TPL_V1["freegift_condition"]?>">
                        <div class="product-list__item-top">
                            <label class="product-list__check">
                                <input type="checkbox" id="giftCheckbox" class="cart_product_check" value="<?php echo $TPL_V2["pid"]?>" />
                            </label>
                        </div>
                        <dl class="product-list__group devGiftListByOrder">
                            <dt class="product-list__group-left">
                                <figure class="product-list__thumb">
                                    <img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>" data-devpid="<?php echo $TPL_V2["pid"]?>" data-devpcount="<?php echo $TPL_V1["gift_cnt"]?>" data-fg_ix="<?php echo $TPL_V1["fg_ix"]?>" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>"/>
                                </figure>
                            </dt>
                            <dd class="product-list__group-right">
                                <div class="product-list__info">
                                    <div class="product-list__info__title"><?php echo trans($TPL_V2["pname"])?></div>
                                    <!--<div class="product-list__info__option">
                                        <div class="product-list__info__option-item">
                                            <span class="color">페일네온옐로우</span>
                                        </div>
                                    </div>-->

                                    <!-- 갯수 S --
                                    <div class="control">
                                        <ul class="option-up-down">
                                            <li><button class="down devAddCountDownButton"></button></li>
                                            <li><input type="text" value="1" class="br__form-input devAddCount" /></li>
                                            <li><button class="up devAddCountUpButton"></button></li>
                                        </ul>
                                        -- 수량 초과 시 노출 S --
                                        <div class="cart-item__warning" style="display: none">
                                            <p class="txt-error">주문 가능한 수량은 최대 <em>999</em>개입니다.</p>
                                        </div>
                                        -- 수량 초과 시 노출 E --
                                    </div>
                                    -- 갯수 E -->
                                </div>
                            </dd>
                        </dl>
                    </li>
<?php }}?>
                    <li class="product-list__item">
                        <div class="product-list__item-top">
                            <label class="product-list__check">
                                <input type="checkbox" class="cart_product_check" id="giftNoCheckbox" value="Y" />
                                <span style="color:#000;margin-left:0rem;">사은품 선택 안함.</span>
                            </label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
<?php }?>
<?php }}?>
<?php }?>
        <!-- 사은품 S -->
    </section>
    <!-- 주문 상품 E -->

    <!-- 쿠폰/적립금 S -->
    <section class="br__infoinput__discount">
<?php $this->print_("userTemplateCoupon",$TPL_SCP,1);?>

    </section>
    <!-- 쿠폰/적립금 E -->

    <!-- 결제 수단 S -->
    <section class="br__infoinput__pay-type">
        <div class="page-title">
            <div class="title-md">결제 방법</div>
        </div>
        <div class="info-paytype">
            <div class="info-paytype__list">
<?php if($TPL_VAR["langType"]=='english'){?>
                    <button class="info-paytype__btn info-paytype__btn--active">Eximbay</button>
                    <input type="hidden" name="devPaymentMethod" value="<?php echo ORDER_METHOD_EXIMBAY?>">
<?php }else{?>
                    <input type="hidden" name="devPaymentMethod" id="paymentMethod" value="<?php echo ORDER_METHOD_CARD?>">
                    <button devPaymentMethod="<?php echo ORDER_METHOD_CARD?>" class="info-paytype__btn info-paytype__btn--active" onclick="medthChange('<?php echo ORDER_METHOD_CARD?>');">신용카드</button>
<?php if($TPL_VAR["add_sattle_module_naverpay_pg"]=='Y'){?>
                        <button devPaymentMethod="<?php echo ORDER_METHOD_NPAY?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_NPAY?>');">네이버페이</button>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_kakao"]=='Y'){?>
                        <button devPaymentMethod="<?php echo ORDER_METHOD_KAKAOPAY?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_KAKAOPAY?>');">카카오페이</button>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_toss"]=='Y'){?>
                        <button devPaymentMethod="<?php echo ORDER_METHOD_TOSS?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_TOSS?>');">토스페이</button>
<?php }?>
<?php if($TPL_VAR["add_sattle_module_payco"]=='Y'){?>
                        <button devPaymentMethod="<?php echo ORDER_METHOD_PAYCO?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_PAYCO?>');">페이코</button>
<?php }?>
                    <button devPaymentMethod="<?php echo ORDER_METHOD_VBANK?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_VBANK?>');">가상계좌</button>
                    <button devPaymentMethod="<?php echo ORDER_METHOD_ASCROW?>" class="info-paytype__btn" onclick="medthChange('<?php echo ORDER_METHOD_ASCROW?>');">에스크로(가상계좌)</button>
<?php }?>

            </div>
            <div class="info-paytype__notice">
                <!-- 카드결제 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_CARD?>" style="display: block">
                    <li class="info-paytype__notice__title">카드결제 이용안내</li>
                    <li class="info-paytype__notice__desc">고객이 온라인 쇼핑몰에서 상품 및 서비스를 신용카드로 진행하는 결제 서비스입니다.</li>
                    <li class="info-paytype__notice__desc">카드번호 유효기간 등의 신용정보는 안전하게 암호화되어 해당 신용카드사로 전달됩니다.</li>
                </ul>
                <!-- 네이버페이 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_NPAY?>">
                    <li class="info-paytype__notice__title">네이버페이 이용안내</li>
                    <li class="info-paytype__notice__desc">주문 변경 시 카드사 혜택 및 할부 적용 여부는 해당 카드사 정책에 따라 변경될 수 있습니다.</li>
                    <li class="info-paytype__notice__desc">네이버페이는 네이버ID로 별도 앱 설치 없이 신용카드 또는 은행계좌 정보를 등록하여 네이버페이 비밀번호로 결제할 수 있는 간편결제 서비스입니다.</li>
                    <li class="info-paytype__notice__desc">결제 가능한 신용카드: 신한, 삼성, 현대, BC, 국민, 하나, 롯데, NH농협, 씨티, 카카오뱅크</li>
                    <li class="info-paytype__notice__desc">결제 가능한 은행: NH농협, 국민, 신한, 우리, 기업, SC제일, 부산, 경남, 수협, 우체국, 미래에셋대우, 광주, 대구, 전북, 새마을금고, 제주은행, 신협, 하나은행, 케이뱅크, 카카오뱅크, 삼성증권</li>
                    <li class="info-paytype__notice__desc">네이버페이 카드 간편결제는 네이버페이에서 제공하는 카드사 별 무이자, 청구할인 혜택을 받을 수 있습니다.</li>
                </ul>
                <!-- 카카오페이 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_KAKAOPAY?>">
                    <li class="info-paytype__notice__title">카카오페이 이용안내</li>
                    <li class="info-paytype__notice__desc">고객이 온라인 쇼핑몰에서 상품 및 서비스를 카카오페이로 진행하는 결제 서비스 입니다.</li>
                    <li class="info-paytype__notice__desc">카드번호 유효기간 등의 신용정보는 안전하게 암호화되어 해당 신용카드사로 전달됩니다.</li>
                </ul>
                <!-- 토스 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_TOSS?>">
                    <li class="info-paytype__notice__title">토스페이 이용안내</li>
                    <li class="info-paytype__notice__desc">Toss에 등록된 계좌와 신용/체크카드로 쉽고 편리하게 결제하세요.</li>
                    <li class="info-paytype__notice__desc">이용가능 카드사 : 비씨, 삼성, 롯데, 하나, 신한, 현대카드 (KB카드, NH농협 준비중)</li>
                    <li class="info-paytype__notice__desc">이용가능 은행 : 20개 은행과 8개 증권사</li>
                    <li class="info-paytype__notice__desc">토스 간편결제시 토스에서 제공하는 카드사별 무이자, 청구할인, 결제이벤트만 제공됩니다.</li>
                    <li class="info-paytype__notice__desc">토스머니 결제시 현금영수증은 자동으로 신청됩니다.</li>
                </ul>
                <!-- 페이코 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_PAYCO?>">
                    <li class="info-paytype__notice__title">페이코 이용안내</li>
                    <li class="info-paytype__notice__desc">PAYCO는 NHN엔터테인먼트가 만든 안전한 간편결제 서비스입니다.</li>
                    <li class="info-paytype__notice__desc">휴대폰과 카드 명의자가 동일해야 결제 가능하며, 결제금액 제한은 없습니다.</li>
                    <li class="info-paytype__notice__desc">결제 가능 수단 : 모든 국내 신용/체크카드(씨티카드 제외)</li>
                </ul>
                <!-- 가상 계좌 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_VBANK?>">
                    <li class="info-paytype__notice__title">가상계좌 이용안내</li>
                    <li class="info-paytype__notice__desc">주문완료 후 <em>2</em>일 이내 입금완료 하셔야 상품이 발송됩니다.</li>
                </ul>
                <!-- 에스크로 -->
                <ul class="info-paytype__notice__list" devPaymentDescription="<?php echo ORDER_METHOD_ASCROW?>">
                    <li class="info-paytype__notice__title">에스크로(가상계좌) 이용안내</li>
                    <li class="info-paytype__notice__desc">주문완료 후 <?php echo $TPL_VAR["cancelAutoDay"]?>일 이내 입금완료 하셔야 상품이 발송됩니다.</li>
                    <li class="info-paytype__notice__desc">에스크로[가상계좌] 주문 시 부분 취소가 불가하여 전체 취소만 가능합니다. 입금 전 구매하실 제품을 다시 한번 확인해 주시기 바랍니다.</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- 결제 수단 E -->

    <!-- 결제예정금액 S -->
    <section class="br__infoinput__payment">
        <div class="use-notice">
            <h3 class="use-notice__title">구매 시 유의사항</h3>
            <ul class="use-notice__list">
                <li class="use-notice__desc">주문 상태가 ‘배송 준비’ 및 ‘배송 중’일 경우 취소처리가 불가합니다.</li>
                <li class="use-notice__desc">반품 신청 시 쿠폰은 재발급 되지 않습니다.</li>
                <li class="use-notice__desc">가상계좌로 주문 시 주문 상태가 ‘입금대기’일 경우 마이페이지에서 취소를 직접 신청 하셔야 처리할 수 있습니다.</li>
                <li class="use-notice__desc">주문하신 제품을 반품하시는 경우 사은품 혜택을 받으신 고객님께서는 반드시 지급된 사은품을 동봉해 주셔야 반품 처리가 됩니다.</li>
                <li class="use-notice__desc">겟배럴닷컴에서 구매하신 제품은 오프라인 매장에서 반품 및 주문 취소가 불가합니다.</li>
                <li class="use-notice__desc">적립금은 구매금액 3만원 이상부터 사용가능합니다.</li>
            </ul>
        </div>
        <div class="info-payment">
            <dl class="info-payment__total">
                <dt>총 결제 예정 금액</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <div class="info-payment__list">
                <!--<dl class="info-payment__box">
                    <dt>결제방법</dt>
                    <dd>신용카드 / 국민카드(00**)</dd>
                </dl>-->
                <dl class="info-payment__box">
                    <dt>총 상품금액</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <!--<dl class="info-payment__box">
                    <dt>총 할인금액</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_discount_amount"><?php echo g_price($TPL_VAR["cartSummary"]["product_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>-->
                <dl class="info-payment__box">
                    <dt>상품할인</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em ><?php echo g_price($TPL_VAR["cartSummary"]["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <dl class="info-payment__box">
                    <dt>등급 할인</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["cartSummary"]["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="info-payment__box">
                    <dt>쿠폰 할인</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="info-payment__box">
                    <dt>배송비쿠폰 할인</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_delivery_cupon">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
<?php }?>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <dl class="info-payment__box">
                    <dt><?php echo $TPL_VAR["mileageName"]?> 사용</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="use_mileage">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
<?php }?>
                <dl class="info-payment__box">
                    <dt>총 배송비</dt>
                    <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["cartSummary"]["delivery_price"]?>">
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>(기본)<em devPrice="delivery_add_price"></em></dd>
                </dl>
            </div>
        </div>
        <div class="info-submit__check-box">
            <label class="info-submit__check">
                <input type="checkbox" class="devTerms" name="all_terms" id="all_terms_check" title="결제에 동의" />
                <span style="margin-left:0px;">주문 약관 동의(필수)</span>
            </label>
            <div class="txt-desc">주문하는 상품의 상품명, 상품가격, 상품수량, 할인, 배송정보 등 주문 정보를 확인하였으며, 결제 및 배럴에서 제공하는 서비스 정책에 동의합니다.</div>
        </div>
    </section>
    <!-- 결제예정금액 E -->

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
<?php }else{?>
    <!-- 비회원 약관 동의 S -->
    <section class="br__infoinput__non-agree">
        <div class="agree-content">
            <div class="agree-content__inner">
                <div class="br__form-item">
                    <input type="checkbox" id="area-terms-All" class="devTerms" name="termsAll" />
                    <label for="agree-all">모두 동의합니다.</label>
                </div>
            </div>
            <!--<div class="agree-content__inner">
                <div class="br__form-item">
                    <input type="checkbox" id="area-terms-2" class="js__check-porsonal" name="terms-2" />
                    <label for="agree-porsonal1">만 14세 이상입니다. (필수)</label>
                </div>
            </div>-->
            <div class="agree-content__inner">
                <dt class="br__form-item">
                    <input type="checkbox" id="area-terms-1" class="js__check-porsonal devTerms" name="terms-1" title="비회원 구매 이용 약관 동의 (필수)" />
                    <label for="agree-porsonal2">비회원 구매 이용 약관 동의 (필수)</label>
                    <button type="button" class="btn-md btn-toggle btn-gray">내용보기</button>
                </dt>
                <dd class="agree-content__inner__cont">
<?php if(!$TPL_VAR["layoutCommon"]["isLogin"]){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <?php echo $TPL_VAR["use"]["contents"]?>

<?php }else{?>
                            <?php echo $TPL_VAR["use"]?>

<?php }?>
<?php }?>
                </dd>
            </div>
            <div class="agree-content__inner">
                <dt class="br__form-item">
                    <input type="checkbox" id="area-terms-2" class="js__check-porsonal devTerms" name="terms-2" title="비회원 개인정보 수집 및 이용 동의 (필수)" />
                    <label for="agree-porsonal3">비회원 개인정보 수집 및 이용 동의 (필수)</label>
                    <button type="button" class="btn-md btn-toggle btn-gray">내용보기</button>
                </dt>
                <dd class="agree-content__inner__cont">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <?php echo $TPL_VAR["non_collection"]["contents"]?>

<?php }else{?>
                    <?php echo $TPL_VAR["collection"]?>

<?php }?>
                </dd>
            </div>
        </div>
    </section>
<?php }?>
    <!-- 비회원 약관 동의 E -->

    <!-- 결제하기 S -->
    <section class="br__infoinput__submit">
        <dl class="info-submit__footer">
            <dt>
                총 <span class="info-submit__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_VAR["cartSummary"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
            </dt>
            <dd><button type="button" class="btn-lg btn-dark info-submit__btn" id="devPaymentButton">결제하기</button></dd>
        </dl>
    </section>
    <!-- 결제하기 E -->
</section>
<!-- 컨텐츠 E -->

<!-- modal S -->
<div class="popup-mask" id="mask"></div>
<div class="popup-layout popup-layout__full" id="coupon-pop">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-md">쿠폰 선택</div>
            <a href="javascript:void(0);" class="btn-close" onclick="couponClose()">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="coupon-sel br__infoinput">
                    <div class="coupon-sel__haed">
                        <div class="coupon-sel__title">
                            <div class="title-sm">상품 쿠폰</div>
                        </div>
                    </div>
                    <div class="coupon-sel__cont">
                        <div class="coupon-sel__item">
                            <ul class="product-list">
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_setData_2=empty($TPL_V1["setData"])||!is_array($TPL_V1["setData"])?0:count($TPL_V1["setData"]);
$TPL_couponList_2=empty($TPL_V1["couponList"])||!is_array($TPL_V1["couponList"])?0:count($TPL_V1["couponList"]);?>
                                <li class="product-list__item">
                                    <dl class="product-list__group">
                                        <dt class="product-list__group-left">
                                            <figure class="product-list__thumb">
                                                <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?>">
                                            </figure>
                                        </dt>
                                        <dd class="product-list__group-right">
                                            <div class="product-list__info">
                                                <div class="product-list__info__title"><?php echo $TPL_V1["brand_name"]?> <?php echo $TPL_V1["pname"]?></div>

<?php if($TPL_V1["set_group"]> 0){?>
                                                <!-- 세트 상품 S -->
                                                    <input type="hidden" name="cartType" class="cartType" value="set" />
                                                    <div class="product-list__info__option set">
<?php if($TPL_setData_2){foreach($TPL_V1["setData"] as $TPL_V2){?>
                                                        <div class="product-list__info__option-item">
<?php if(!empty($TPL_V1["add_info"])){?>
                                                            <span><?php echo $TPL_V1["add_info"]?></span>
<?php }?>
                                                            <span class="set-tit"><?php echo str_replace("사이즈:","",$TPL_V2["options_text"])?></span>
                                                            <!--<span class="color">블랙</span>
                                                            <span class="size">M</span>-->
                                                            <span class="count"><?php echo $TPL_V1["pcount"]?>개</span>
                                                        </div>
<?php }}?>
                                                    </div>
                                                <!-- 세트 상품 E -->
<?php }else{?>
                                                    <div class="product-list__info__option-item">
<?php if(!empty($TPL_V1["add_info"])){?>
                                                        <span><?php echo $TPL_V1["add_info"]?></span>
<?php }?>
                                                        <span><?php echo str_replace("사이즈:","",$TPL_V1["options_text"])?></span>
                                                        <span><?php echo $TPL_V1["pcount"]?>개</span>
                                                    </div>
<?php }?>


                                                <div class="product-list__info__price">
                                                    <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["total_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                                    <span class="product-list__info__price--sale"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devDiscountAmountText="<?php echo $TPL_V1["cart_ix"]?>">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?> 할인</span>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                    <div class="product-list__select">
                                        <div class="br__form-item">
                                            <label class="hidden">쿠폰 선택</label>
                                            <select devCouponSelect="<?php echo $TPL_V1["cart_ix"]?>" class="js__couponpop__select cupon_select">
                                                <option value="">쿠폰선택</option>
<?php if($TPL_couponList_2){foreach($TPL_V1["couponList"] as $TPL_V2){?>
<?php if($TPL_V2["activeBool"]){?>
                                                <option value="<?php echo $TPL_V2["regist_ix"]?>"
                                                        devTotalCouponWithDcprice="<?php echo $TPL_V2["total_coupon_with_dcprice"]?>"
                                                        devDiscountAmount="<?php echo $TPL_V2["discount_amount"]?>"
                                                        devCartOverlapUseYn="<?php echo $TPL_V2["overlap_use_yn"]?>"
                                                        devPaymentMethod="<?php echo $TPL_V2["payment_method"]?>"
<?php if($TPL_V2["isSelected"]){?>selected<?php }?>><?php echo $TPL_V2["publish_name"]?></option>
<?php }?>
<?php }}?>
                                            </select>
                                        </div>
                                    </div>
                                </li>
<?php }}?>
                            </ul>
                        </div>
                        <div class="coupon-sel__item">
                            <div class="coupon-sel__title">
                                <div class="title-sm">장바구니 쿠폰</div>
                                <div class="count"><em devCartDiscountAmountText>0</em>원 할인</div>
                            </div>
                            <div class="br__form-item">
                                <select devCartCouponSelect class="br__form-select">
                                    <option value="">선택안함</option>
<?php if($TPL_cartCouponList_1){foreach($TPL_VAR["cartCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
                                    <option value="<?php echo $TPL_V1["regist_ix"]?>"
                                            devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
                                            devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
                                </select>
                            </div>
                        </div>
                        <!--<div class="coupon-sel__item">
                            <div class="coupon-sel__title">
                                <div class="title-sm">배송비 쿠폰</div>
                                <div class="count"><em>0</em>원 할인</div>
                            </div>
                            <div class="br__form-item">
                                <select class="br__form-select" disabled>
                                    <option>쿠폰 선택</option>
                                </select>
                            </div>
                        </div>-->
                        <dl class="coupon-sel__total">
                            <input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
                            <input type="hidden" id="devTotalProductDcprice" value="<?php echo $TPL_VAR["totalProductDcprice"]?>" />
                            <input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
                            <dt>총 쿠폰 할인 금액</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["productDcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line btn-close" id="devCouponCancelButton">취소</button>
                <button type="button" class="btn-lg btn-dark" id="devApplyCouponButton">쿠폰적용</button>
            </div>
        </div>
    </div>
</div>


<div class="popup-layout popup-layout__full" id="coupon-deily-pop">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-md">쿠폰 선택</div>
            <a href="javascript:void(0);" class="btn-close" onclick="couponClose()">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="coupon-sel br__infoinput">
                    <div class="coupon-sel__cont">
                        <select devDeliveryCouponSelect>
                            <option value="">선택</option>
<?php if($TPL_deliveryCouponList_1){foreach($TPL_VAR["deliveryCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
                            <option value="<?php echo $TPL_V1["regist_ix"]?>"
                                    devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
                                    devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
                        </select>
                        <dl class="coupon-sel__total">

                            <input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
                            <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["totalDeliveryPrice"]?>" />
                            <input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
                            <dt>총 쿠폰 할인 금액</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span id="devTotalCouponDiscountAmount">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line btn-close" id="devCouponCancelButton">취소</button>
                <button type="button" class="btn-lg btn-dark" id="devApplyDeliveryCouponButton">쿠폰적용</button>
            </div>
        </div>
    </div>
</div>
<!-- modal E -->


<?php echo $TPL_VAR["paymentIncludeJavaScript"]?>

<div id="devPaymentGatewayContents">
</div>