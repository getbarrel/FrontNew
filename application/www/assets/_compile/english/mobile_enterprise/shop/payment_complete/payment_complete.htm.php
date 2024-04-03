<?php /* Template_ 2.2.8 2020/08/31 15:57:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/payment_complete/payment_complete.htm 000027354 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);
$TPL_freeGiftG_1=empty($TPL_VAR["freeGiftG"])||!is_array($TPL_VAR["freeGiftG"])?0:count($TPL_VAR["freeGiftG"]);
$TPL_freeGiftC_1=empty($TPL_VAR["freeGiftC"])||!is_array($TPL_VAR["freeGiftC"])?0:count($TPL_VAR["freeGiftC"]);
$TPL_freeGiftP_1=empty($TPL_VAR["freeGiftP"])||!is_array($TPL_VAR["freeGiftP"])?0:count($TPL_VAR["freeGiftP"]);?>
<script>
	var emnet_tagm_products=[];
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


<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__pay-comp">
    <div class="pay-comp__top">
        <h2 class="pay-comp__top__title">Order completed successfully</h2>
        <p class="pay-comp__top__desc">Order status is able to be checked in <span>My Page<em></em>Your Orders</span></p>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
        <div class="pay-comp__top__virtual">
            <p>
                <span><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</span> <?php echo $TPL_VAR["paymentData"]["bank"]?><br> (계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> / 예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>) 으로 <br> 결제 예정금액 <span><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?>원</span>을 입금해 주시기 바랍니다.
            </p>
        </div>
<?php }?>
    </div>

    <div class="wrap-sect"></div>

    <section class="pay-comp__wrap">
        <h3 class="pay-comp__wrap__title">Check your items</h3>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
        <ul class="pay-comp__detail__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
            <li class="pay-comp__detail__box">
                <figure class="pay-comp__detail__thumb">
                    <img src="<?php echo $TPL_V2["pimg"]?>">
                </figure>
                <div class="pay-comp__detail__info">
                    <p class="pay-comp__detail__title"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></p>
<?php if($TPL_V2["add_info"]){?>
                    <p class="pay-comp__detail__option"><span><?php echo $TPL_V2["add_info"]?></span></p>
<?php }?>
                    <p class="pay-comp__detail__option">
<?php if($TPL_V2["set_group"]> 0){?>                        <span>
<?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo $TPL_V3["option_text"]?> (수량:<?php echo $TPL_V3["pcnt"]?>개)
<?php }}?>
                        </span>
<?php }else{?>                        <span><?php echo $TPL_V2["option_text"]?> / <strong>Quantity <?php echo $TPL_V2["pcnt"]?> items</strong></span>
<?php }?>
                    </p>
                    <div class="pay-comp__detail__pay">
                        <dl>
                            <dt><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated Total <?php }else{?>Total Amount<?php }?></dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="sub">
                            <dt>Subtotal</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="sub">
                            <dt>Savings</dt>
                            <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
<?php if(count($TPL_V2["product_gift"])> 0){?>                <div class="pay-comp__detail__freebie">
                    <p class="detail__freebie__title">사은품</p>
                    <ul class="detail__freebie__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                        <li class="detail__freebie__box">
                            <div class="detail__freebie__thumb">
                                <figure>
                                    <img src="<?php echo $TPL_V3["image_src"]?>">
                                </figure>
                            </div>
                            <div class="detail__freebie__info">
                                <p class="detail__freebie__text"><?php echo $TPL_V3["pname"]?> / <?php echo $TPL_V3["pcnt"]?> 개</p>
                            </div>

                        </li>
<?php }}?>
                    </ul>
                </div>
<?php }?>
            </li>
<?php }}?>
        </ul>

        <div class="pay-comp__detail__delivery">
            <dl>
                <dt>Shipping fee</dt>
                <dd>
                    <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                </dd>
            </dl>
            <p class="delivery-fee">
                Overseas shipping fee will be charged
            </p>
        </div>

<?php }}?>
        <div>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
            <div class="pay-comp__detail__freebie">
                <p class="detail__freebie__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></p>
                <ul class="detail__freebie__list">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="detail__freebie__box">
                        <div class="detail__freebie__thumb">
                            <figure>
                                <img src="<?php echo $TPL_V2["image_src"]?>">
                            </figure>
                        </div>
                        <div class="detail__freebie__info">
                            <p class="detail__freebie__text"><?php echo $TPL_V2["pname"]?> / <?php echo $TPL_V2["pcnt"]?>개 </p>
                        </div>

                    </li>
<?php }}?>
                </ul>
            </div>
<?php }?>
<?php }}?>
<?php }?>
        </div>
    </section>
    <div class="wrap-sect"></div>


    <section class="pay-comp__wrap">
        <h2 class="pay-comp__wrap__title"><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated Total <?php }else{?>Total Amount<?php }?></h2>
        <div class="pay-comp__payment">
            <div class="pay-comp__payment__list">
                <dl class="pay-comp__payment__box">
                    <dt>Item Total</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt>Savings</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt><?php echo $TPL_VAR["mileageName"]?></dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt>(english)배송비 할인금액</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["dcp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt>Shipping</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
            <dl class="pay-comp__payment__total">
                <dt><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated Total <?php }else{?>Total<?php }?></dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
        </div>
    </section>
    <div class="wrap-sect"></div>

    <section class="pay-comp__wrap">
        <div class="pay-comp__wrap__title">Payment Information</div>
        <dl class="pay-comp__payinfo">
            <dt class="pay-comp__payinfo__title">Payment Method</dt>
            <dd class="pay-comp__payinfo__desc">
                <?php echo $TPL_VAR["paymentData"]["method_text"]?>

<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
                <span>deadline for the deposit : <?php echo $TPL_VAR["paymentData"]["bank_input_date"]?></span>
<?php }?>
            </dd>
            <dt class="pay-comp__payinfo__title">Order No.</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            <dt class="pay-comp__payinfo__title">Order date</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["order"]["bdatetime"]?></dd>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
            <dt class="pay-comp__payinfo__title">Account information</dt>
            <dd class="pay-comp__payinfo__desc">
                <?php echo $TPL_VAR["paymentData"]["bank"]?>(예금주:<?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>)<br>
                <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?>

            </dd>
<?php }else{?>
            <dt class="pay-comp__payinfo__title">Payment Information</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["paymentData"]["memo"]?></dd>
<?php }?>
        </dl>
    </section>
    <div class="wrap-sect"></div>
    <section class="pay-comp__wrap">
        <div class="pay-comp__wrap__title">Shipping Information</div>
        <dl class="pay-comp__payinfo">
            <dt class="pay-comp__payinfo__title">Name</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></dd>
            <dt class="pay-comp__payinfo__title">Address</dt>
            <dd class="pay-comp__payinfo__desc">[<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>] <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?> <?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></dd>
            <dt class="pay-comp__payinfo__title">Tel</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></dd>
            <dt class="pay-comp__payinfo__title">Shipping comment</dt>
            <dd class="pay-comp__payinfo__desc">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["msg"]){?>
<?php if($TPL_I1!= 0){?><br><?php }?><?php echo $TPL_V1["msg"]?>

<?php }?>
<?php }}?>
            </dd>
        </dl>
    </section>

    <div class="pay-comp__btn__wrap">
        <a href="/" class="pay-comp__btn__link pay-comp__btn__link--home">Home</a>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        <a href="/mypage/orderHistory" class="pay-comp__btn__link pay-comp__btn__link--order">Order Inquiry</a>
<?php }else{?>
        <a href="/member/login" class="pay-comp__btn__link pay-comp__btn__link--order">Order Inquiry</a>
<?php }?>
    </div>

</section>
<?php }else{?>
<section class="br__pay-comp">
    <div class="pay-comp__top">
        <h2 class="pay-comp__top__title">Order completed successfully</h2>
        <p class="pay-comp__top__desc">Order status is able to be checked in <span>My Page<em></em>Your Orders</span></p>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
        <div class="pay-comp__top__virtual">
            <p>
                <span><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</span> <?php echo $TPL_VAR["paymentData"]["bank"]?><br> (계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> / 예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>) 으로 <br> 결제 예정금액 <span><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?>원</span>을 입금해 주시기 바랍니다.
            </p>
        </div>
<?php }?>
    </div>

    <div class="wrap-sect"></div>

    <section class="pay-comp__wrap">
        <h3 class="pay-comp__wrap__title">Check your items</h3>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
        <ul class="pay-comp__detail__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
            <li class="pay-comp__detail__box">
                <figure class="pay-comp__detail__thumb">
                    <img src="<?php echo $TPL_V2["pimg"]?>">
                </figure>
                <div class="pay-comp__detail__info">
                    <p class="pay-comp__detail__title"><?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?></p>
                    <p class="pay-comp__detail__option">
<?php if($TPL_V2["set_group"]> 0){?>                        <span>
<?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo $TPL_V3["option_text"]?> (구성수량:<?php echo $TPL_V3["pcnt"]?>ltem(s))
<?php }}?>
                        </span>
<?php }else{?>                        <span><?php echo $TPL_V2["option_text"]?> / <strong>Quantity <?php echo $TPL_V2["pcnt"]?> items</strong></span>
<?php }?>
                    </p>
                    <div class="pay-comp__detail__pay">
                        <dl>
                            <dt><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated Total <?php }else{?>Total Amount<?php }?></dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="sub">
                            <dt>Subtotal</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="sub">
                            <dt>Savings</dt>
                            <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
<?php if(count($TPL_V2["product_gift"])> 0){?>                <div class="pay-comp__detail__freebie">
                    <p class="detail__freebie__title">GIft</p>
                    <ul class="detail__freebie__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                        <li class="detail__freebie__box">
                            <div class="detail__freebie__thumb">
                                <figure>
                                    <img src="<?php echo $TPL_V3["image_src"]?>">
                                </figure>
                            </div>
                            <div class="detail__freebie__info">
                                <p class="detail__freebie__text"><?php echo $TPL_V3["pname"]?> / <?php echo $TPL_V3["pcnt"]?> ltem(s)</p>
                            </div>

                        </li>
<?php }}?>
                    </ul>
                </div>
<?php }?>

            </li>
<?php }}?>
        </ul>
        <div class="pay-comp__detail__delivery">
            <dl>
                <dt>Shipping fee</dt>
                <dd>
                    <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                </dd>
            </dl>
            <p class="delivery-fee">
                Overseas shipping fee will be charged
            </p>
        </div>
<?php }}?>
        <div>
<?php if(count($TPL_VAR["freeGiftG"])> 0){?>            <div class="pay-comp__detail__freebie">
                <p class="detail__freebie__title">Free gifts by purchase amount</p>
                <ul class="detail__freebie__list">
<?php if($TPL_freeGiftG_1){foreach($TPL_VAR["freeGiftG"] as $TPL_V1){?>
                    <li class="detail__freebie__box">
                        <div class="detail__freebie__thumb">
                            <figure>
                                <img src="<?php echo $TPL_V1["image_src"]?>">
                            </figure>
                        </div>
                        <div class="detail__freebie__info">
                            <p class="detail__freebie__text"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s) </p>
                        </div>

                    </li>
<?php }}?>
                </ul>
            </div>
<?php }?>
<?php if(count($TPL_VAR["freeGiftC"])> 0){?>            <div class="pay-comp__detail__freebie">
                <p class="detail__freebie__title">카테고리별 사은품</p>
                <ul class="detail__freebie__list">
<?php if($TPL_freeGiftC_1){foreach($TPL_VAR["freeGiftC"] as $TPL_V1){?>
                    <li class="detail__freebie__box">
                        <div class="detail__freebie__thumb">
                            <figure>
                                <img src="<?php echo $TPL_V1["image_src"]?>">
                            </figure>
                        </div>
                        <div class="detail__freebie__info">
                            <p class="detail__freebie__text"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s) </p>
                        </div>

                    </li>
<?php }}?>
                </ul>
            </div>
<?php }?>
<?php if(count($TPL_VAR["freeGiftP"])> 0){?>            <div class="pay-comp__detail__freebie">
                <p class="detail__freebie__title">특정상품포함 금액합계별 사은품</p>
                <ul class="detail__freebie__list">
<?php if($TPL_freeGiftP_1){foreach($TPL_VAR["freeGiftP"] as $TPL_V1){?>
                    <li class="detail__freebie__box">
                        <div class="detail__freebie__thumb">
                            <figure>
                                <img src="<?php echo $TPL_V1["image_src"]?>">
                            </figure>
                        </div>
                        <div class="detail__freebie__info">
                            <p class="detail__freebie__text"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s) </p>
                        </div>

                    </li>
<?php }}?>
                </ul>
            </div>
<?php }?>
        </div>
    </section>
    <div class="wrap-sect"></div>


    <section class="pay-comp__wrap">
        <h2 class="pay-comp__wrap__title">Estimated Total</h2>
        <div class="pay-comp__payment">
            <div class="pay-comp__payment__list">
                <dl class="pay-comp__payment__box">
                    <dt>Item Total</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt>Savings</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt><?php echo $TPL_VAR["mileageName"]?></dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="pay-comp__payment__box">
                    <dt>Shipping</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
            <dl class="pay-comp__payment__total">
                <dt><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated Total <?php }else{?>Total<?php }?></dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
        </div>
    </section>
    <div class="wrap-sect"></div>

    <section class="pay-comp__wrap">
        <div class="pay-comp__wrap__title">Payment Information</div>
        <dl class="pay-comp__payinfo">
            <dt class="pay-comp__payinfo__title">Payment Method</dt>
            <dd class="pay-comp__payinfo__desc">
                <?php echo $TPL_VAR["paymentData"]["method_text"]?>

<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
                <span>deadline for the deposit : <?php echo $TPL_VAR["paymentData"]["bank_input_date"]?></span>
<?php }?>
            </dd>
            <dt class="pay-comp__payinfo__title">Order No.</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            <dt class="pay-comp__payinfo__title">Order date</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["order"]["bdatetime"]?></dd>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
            <dt class="pay-comp__payinfo__title">Account information</dt>
            <dd class="pay-comp__payinfo__desc">
                <?php echo $TPL_VAR["paymentData"]["bank"]?>(예금주:<?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>)<br>
                <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?>

            </dd>
<?php }else{?>
            <dt class="pay-comp__payinfo__title">Payment Information</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["paymentData"]["memo"]?></dd>
<?php }?>
        </dl>
    </section>
    <div class="wrap-sect"></div>
    <section class="pay-comp__wrap">
        <div class="pay-comp__wrap__title">Shipping Information</div>
        <dl class="pay-comp__payinfo">
            <dt class="pay-comp__payinfo__title">Name</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></dd>
            <dt class="pay-comp__payinfo__title">country</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["country_full"]?></dd>
            <dt class="pay-comp__payinfo__title">Zip/Postal Code</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></dd>
            <dt class="pay-comp__payinfo__title">Address line 1</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></dd>
            <dt class="pay-comp__payinfo__title">Address line 2</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></dd>
            <dt class="pay-comp__payinfo__title">CIty</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["city"]?></dd>
            <dt class="pay-comp__payinfo__title">State/Province</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["state"]?></dd>
            <dt class="pay-comp__payinfo__title">Tel</dt>
            <dd class="pay-comp__payinfo__desc"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></dd>
            <dt class="pay-comp__payinfo__title">Shipping comment</dt>
            <dd class="pay-comp__payinfo__desc">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["msg"]){?>
<?php if($TPL_I1!= 0){?><br><?php }?><?php echo $TPL_V1["msg"]?>

<?php }?>
<?php }}?>
            </dd>
        </dl>
    </section>

    <div class="pay-comp__btn__wrap">
        <a href="/" class="pay-comp__btn__link pay-comp__btn__link--home">Home</a>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        <a href="/mypage/orderHistory" class="pay-comp__btn__link pay-comp__btn__link--order">Order Inquiry</a>
<?php }else{?>
        <a href="/member/login" class="pay-comp__btn__link pay-comp__btn__link--order">Order Inquiry</a>
<?php }?>
    </div>

</section>
<?php }?>
<?php echo $TPL_VAR["payMentScript"]?>