<?php /* Template_ 2.2.8 2024/03/26 15:47:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/payment_complete/payment_complete.htm 000016919 */ 
$TPL_freeGiftG_1=empty($TPL_VAR["freeGiftG"])||!is_array($TPL_VAR["freeGiftG"])?0:count($TPL_VAR["freeGiftG"]);?>
<script>
    var emnet_tagm_products=[];
    var criteoList = [];
</script>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<script>
    emnet_tagm_products.push({
        'name': '<?php echo $TPL_V2["pname"]?>',
        'id': '<?php echo $TPL_V2["pid"]?>',
        'price': '<?php echo intval($TPL_V2["pt_dcprice"])?>',
        'quantity': '<?php echo $TPL_V2["pcnt"]?>'
    });


    criteoList.push({
        'id': '<?php echo $TPL_V2["pid"]?>',
        'price': '<?php echo intval($TPL_V2["pt_dcprice"])?>',
        'quantity': '<?php echo $TPL_V2["pcnt"]?>'
    });
</script>
<?php }}?>
<?php }}?>

<!-- 구매 완료 dataLayer -->
<script>
    dataLayer.push({
        'event':'purchase',
        'ecommerce': {
            'purchase': {
                'actionField': {
                    'id': '<?php echo $TPL_VAR["order"]["oid"]?>',
                    'affiliation': '',
                    'revenue': '<?php echo intval($TPL_VAR["paymentData"]["payment_price"])?>'
                },
                'products': emnet_tagm_products
            }
        }
    });
</script>

<!-- Criteo 세일즈 태그 23.06.29-->
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 104564},
        { event: "setEmail", email: "", hash_method: "" },
        { event: "setZipcode", zipcode: "" },
        { event: "setSiteType", type: deviceType},
        { event: "trackTransaction", id: '<?php echo $TPL_VAR["order"]["oid"]?>', item: criteoList}
    );
</script>
<!-- END Criteo 세일즈 태그 -->
    <!-- 컨텐츠 S -->
    <section class="br__pay-comp">
        <div class="pay-comp__top">
            <div class="page-title">
                <div class="title-md">주문이 완료되었습니다.</div>
            </div>
            <div class="pay-comp__top__desc">
                배럴 공식 홈페이지를 이용해 주셔서 감사합니다.<br />
                주문하신 내역은 <a href="#;">마이페이지 > 주문 내역</a>에서 확인하실 수 있습니다.
            </div>
            <div class="pay-comp__order-number">
                <dl class="pay-comp__order-number__item">
                    <dt>주문번호</dt>
                    <dd>
                        <div class="order-number"><?php echo $TPL_VAR["order"]["oid"]?></div>
                    </dd>
                </dl>
                <dl class="pay-comp__order-number__item">
                    <dt>주문일자</dt>
                    <dd><?php echo $TPL_VAR["order"]["bdatetime"]?></dd>
                </dl>
            </div>

            <!-- 가상 계좌 결제 시 노출 S -->
            <!-- 숨김 처리 -->
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?>
            <div class="pay-comp__top__virtual">
                <div class="title-sm">입금 정보</div>
                <div class="pay-comp__top__virtual-text">
                    <?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> /<br />
                    예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>

                </div>
                <div class="layout-flex txt-red">
                    <span>입금 기한</span>
                    <span>
                        <?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_ASCROW))){?><br>에스크로[가상계좌] 주문 시 부분 취소가 불가하여 전체 취소만 가능합니다. 입금 전 구매하실 제품을 다시 한번 확인해 주시기 바랍니다.<?php }?>
                    </span>
                </div>
            </div>
<?php }?>
            <!-- 가상 계좌 결제 시 노출 E -->
        </div>
        <section class="pay-comp__wrap">
            <div class="pay-comp__product">
                <div class="page-title">
                    <div class="title-sm">주문 상품</div>
                </div>
                <div class="product-list">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <ul class="product-list__wrap">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
                        <li class="product-list__item">
                            <dl class="product-list__group">
                                <dt class="product-list__group-left">
                                    <figure class="product-list__thumb">
                                        <img src="<?php echo $TPL_V2["pimg"]?>" alt="" />
                                    </figure>
                                </dt>
                                <dd class="product-list__group-right">
                                    <div class="product-list__info">
                                        <div class="product-list__info__title"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></div>
<?php if($TPL_V2["set_group"]> 0){?>
                                        <!-- 세트 상품 S -->
<?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
                                        <div class="product-list__info__option-item">
<?php if(!empty($TPL_V2["add_info"])){?>
                                            <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                            <span><?php echo str_replace("사이즈:","",$TPL_V3["option_text"])?></span>
                                            <span><?php echo $TPL_V3["pcnt"]?>개</span>
                                        </div>
<?php }}?>
                                        <!-- 세트 상품 E -->
<?php }else{?>
                                        <!-- 일반상품 상품 S -->
                                        <div class="product-list__info__option-item">
<?php if(!empty($TPL_V2["add_info"])){?>
                                            <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                            <span><?php echo str_replace("사이즈:","",$TPL_V2["option_text"])?></span>
                                            <span><?php echo $TPL_V2["pcnt"]?>개</span>
                                        </div>
                                        <!-- 일반상품 상품 E -->
<?php }?>
                                    </div>
                                </dd>
                            </dl>

                            <!-- 사은품 S -->
<?php if(count($TPL_V2["product_gift"])> 0){?>                            <div class="product-list__freebie">
                                <div class="product-list__freebie__title"><span>구매 사은품</span></div>
                                <ul class="product-list__freebie__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                                    <li class="product-list__freebie__box">
                                        <div class="product-list__freebie__thumb">
                                            <figure>
                                                <img src="<?php echo $TPL_V3["image_src"]?>" alt="" />
                                            </figure>
                                        </div>
                                        <div class="product-list__freebie__info">
                                            <div class="product-list__freebie__name"><?php echo $TPL_V3["pname"]?></div>
                                            <div class="product-list__freebie__option">
                                                <div class="product-list__freebie__option-item">
                                                    <!--<span>페일네온옐로우</span>
                                                    <span>OS</span>-->
                                                    <span><?php echo $TPL_V3["pcnt"]?>개</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
<?php }}?>
                                </ul>
                            </div>
<?php }?>
                            <!-- 사은품 E -->
                        </li>
<?php }}?>
                    </ul>
<?php }}?>
                </div>
            </div>

            <!-- 구매금액별 사은품 S -->
<?php if($TPL_VAR["freeGiftG"]){?>
            <div class="pay-comp__product">
                <div class="page-title">
                    <div class="title-sm">구매금액별 사은품</div>
                </div>
                <div class="product-list">
                    <ul class="product-list__wrap">
<?php if($TPL_freeGiftG_1){foreach($TPL_VAR["freeGiftG"] as $TPL_V1){
$TPL_gift_products_2=empty($TPL_V1["gift_products"])||!is_array($TPL_V1["gift_products"])?0:count($TPL_V1["gift_products"]);?>
<?php if($TPL_gift_products_2){foreach($TPL_V1["gift_products"] as $TPL_V2){?>
                        <li class="product-list__item">
                            <dl class="product-list__group">
                                <dt class="product-list__group-left">
                                    <figure class="product-list__thumb">
                                        <img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
                                    </figure>
                                </dt>
                                <dd class="product-list__group-right">
                                    <div class="product-list__info">
                                        <div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>
                                        <!-- 일반상품 상품 S -->
                                        <div class="product-list__info__option">
                                            <div class="product-list__info__option-item">
                                                <!--<span class="color">페일네온옐로우</span>
                                                <span class="size">OS</span>-->
                                                <span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
                                            </div>
                                        </div>
                                        <!-- 일반상품 상품 E -->
                                    </div>
                                </dd>
                            </dl>
                        </li>
<?php }}?>
<?php }}?>
                    </ul>
                </div>
            </div>
<?php }?>
            <!-- 사은품 E -->
        </section>

        <section class="pay-comp__wrap">
            <div class="page-title">
                <div class="title-sm">배송 정보</div>
            </div>
            <div class="pay-comp__address">
                <div class="name"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></div>
                <div class="address">
                    <p>[<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>] / <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?> <?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></p>
                    <p><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></p>
                </div>
                <div class="title">배송 요청사항</div>
                <div class="message">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["msg"]){?>
<?php if($TPL_I1!= 0){?><br><?php }?><?php echo $TPL_V1["msg"]?>

<?php }?>
<?php }}?>
                </div>
            </div>
        </section>

        <section class="pay-comp__wrap">
            <div class="page-title">
                <div class="title-sm">결제 정보</div>
            </div>
            <div class="pay-comp__payment">
                <dl class="pay-comp__payment__total">
                    <dt>총 결제 예정 금액</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>

                <!-- 가상 계좌 결제 시 노출 S -->
                <!-- 숨김 처리 -->
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK,ORDER_METHOD_ASCROW))){?>
                <div class="pay-comp__payment__virtual">
                    <div class="title-sm">입금 정보</div>
                    <div class="pay-comp__payment__virtual-text">
                        <?php echo $TPL_VAR["paymentData"]["bank"]?> / 계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> /<br />
                        예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>

                    </div>
                    <div class="layout-flex txt-red">
                        <span>입금 기한</span>
                        <span><?php echo $TPL_VAR["paymentData"]["bank_input_date"]?></span>
                    </div>
                </div>
<?php }?>
                <!-- 가상 계좌 결제 시 노출 E -->

                <div class="pay-comp__payment__list">
                    <dl class="pay-comp__payment__box">
                        <dt>결제방법</dt>
                        <dd><?php echo $TPL_VAR["paymentData"]["method_text"]?></dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>총 상품금액</dt>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>총 할인금액</dt>
                        <dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <!--<dl class="pay-comp__payment__box">
                        <dt>등급 할인</dt>
                        <dd>-<em>405,550</em>원</dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>쿠폰 할인</dt>
                        <dd>-<em>405,550</em>원</dd>
                    </dl>-->
                    <dl class="pay-comp__payment__box">
                        <dt><?php echo $TPL_VAR["mileageName"]?> 사용</dt>
                        <dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="pay-comp__payment__box">
                        <dt>총 배송비</dt>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
                <dl class="pay-comp__payment__benefits">
                    <dt>적립 혜택</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?> 적립</dd>
                </dl>
            </div>
        </section>

        <div class="pay-comp__btn__wrap">
            <a href="/" class="pay-comp__btn__link pay-comp__btn__link--home">홈으로</a>
        </div>
    </section>
    <!-- 컨텐츠 E -->
<?php echo $TPL_VAR["payMentScript"]?>

<?php echo $TPL_VAR["mobionScript"]?>