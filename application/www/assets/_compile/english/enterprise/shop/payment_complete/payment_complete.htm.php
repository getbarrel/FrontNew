<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/payment_complete/payment_complete.htm 000035382 */ 
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
<section class="wrap-cart next-step fb__shop fb__payment-complete">
    <section class="fb__shop__title-area">
        <h2 class="fb__shop__title">Order Completed</h2>
        <ul class="fb__shop__step-area">
            <li class="fb__shop__step"><em>01</em> Cart</li>
            <li class="fb__shop__step"><em>02</em> Check Out</li>
            <li class="fb__shop__step fb__shop__step--on"><em>03</em> Order Completed</li>
        </ul>
    </section>

    <section class="fb__payment-complete__msg complete-msg">
        <h2 class="complete-msg__title">
            Order completed successfully
        </h2>
        <p class="complete-msg__subtit">
            Order status is able to be checked in <span>My Page<em></em>Your Orders</span>
        </p>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
        <div class="complete-msg__virtual">
            <span><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</span>
            <?php echo $TPL_VAR["paymentData"]["bank"]?> (계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> / 예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>) 으로 결제 예정금액
            <span><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em>원</span>을 입금해 주시기 바랍니다.
        </div>
<?php }?>
    </section>

    <section class="fb__infoinput__order-info order-info">
        <h2 class="order-info__title">Order Information</h2>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
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
                <th><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated total <?php }else{?>Estimated Total<?php }?></th>
            </tr>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
            <table class="order-table order-info__table">
                <colgroup>
                    <col width="*">
                    <col width="145px">
                    <col width="145px">
                    <col width="145px">
                    <col width="145px">
                </colgroup>
                <tbody>

                <tr>
                    <td class="item-info">
                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                            <div class="item-info__thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>">
                            </div>
                            <div class="item-info__info">
                                <!--<li class="cart-item__pre">-->
                                    <?php echo $TPL_VAR["preface"]?>

                                <!--</li>-->
                                <p class="item-info__title">
<?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?>

                                </p>
<?php if($TPL_V2["add_info"]){?>
                                <p><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
<?php if($TPL_V2["set_group"]> 0){?>                                <?php if(is_array($TPL_R3=$TPL_V2["setData"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                <span class="item-info__option"><?php echo $TPL_V3["option_text"]?></span>
<?php }}?>
<?php }else{?>
                                <p class="item-info__option">
                                    <?php echo $TPL_V2["option_text"]?>

                                </p>
<?php }?>
                            </div>
                        </a>
                    </td>
                    <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                    <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    <td>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                </tr>
<?php if(count($TPL_V2["product_gift"])> 0){?>
                <tr class="product-gift-wrap">
                    <td colspan="5">
                        <div class="product-gift">
                            <p class="product-gift__title"><span>사은품</span> </p>
                            <ul class="product-gift__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                                <li class="product-gift__box inner-gift devGiftList">
                                    <figure class="product-gift__thumb">
                                        <img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["pname"]?>" data-devpid="<?php echo $TPL_VAR["giftItem"]["pid"]?>" data-devpcount="<?php echo $TPL_VAR["giftItem"]["cnt"]?>">
                                    </figure>
                                    <div class="product-gift__info">
                                        <span class="product-gift__info__pname"><?php echo $TPL_V3["pname"]?></span>
                                        <span class="product-gift__info__count"><?php echo $TPL_V3["pcnt"]?>ltem(s)</span>
                                    </div>
                                </li>
<?php }}?>
                            </ul>
                        </div>
                    </td>
                </tr>
<?php }?>
                </tbody>
            </table>
<?php }}?>
            <div class="delivery-area order-info__delivery-area">
                <span>Shipping <em><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?>$</em></span>
            </div>
            </tbody>
        </table>
<?php }}?>
    </section>

<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
    <section class="wrap-gift-area fb__infoinput">
        <h3><?php echo trans($TPL_V1["freegift_condition_text"])?></h3>
        <div class="product-gift order-info__pricegift">
            <div class="product-gift__list">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <div class="product-gift__box devGiftListByOrder">
                    <figure class="product-gift__thumb">
                        <img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>"
                             data-devpid="<?php echo $TPL_V2["pid"]?>" data-devpcount="<?php echo $TPL_V2["pcnt"]?>">
                    </figure>
                    <div class="product-gift__info">
                        <p class="product-gift__info__pname"><?php echo $TPL_V2["pname"]?> / <?php echo $TPL_V2["pcnt"]?>ltem(s)</p>
                    </div>
                </div>
<?php }}?>
            </div>
        </div>
    </section>
<?php }?>
<?php }}?>
<?php }?>


    <section class="fb__payment-complete__wrap-price wrap-price">
        <h2 class="wrap-price__title">Estimated Total</h2>
        <div class="wrap-price__box">
            <ul class="price-box">
                <li class="price-box__list price-box__list-sum">
                    <span class="price-box__tit">Item Total</span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-discount">
                    <span class="price-box__tit">Savings</span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-mileage">
                    <span class="price-box__tit"><?php echo $TPL_VAR["mileageName"]?></span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-delivery">
                    <span class="price-box__tit price-box__delivery__tit">Shipping fee</span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-due-amt">
                    <span class="price-box__tit">
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated total <?php }else{?>Total Amount<?php }?>
                    </span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
            </ul>

        </div>
    </section>

    <section class="fb__payment-complete__pmt-info pmt-info">
        <h2 class="pmt-info__title">Payment Information</h2>
        <ul class="pmt-info__box">
            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Order No.
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["order"]["oid"]?>

                </p>
            </li>

            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Order date
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["order"]["bdatetime"]?>

                </p>
            </li>

            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Payment Method
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["paymentData"]["method_text"]?>

                </p>
            </li>

<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Account information
                </span>
                <p class="pmt-info__cont">
                    <span>
                        Bank : <?php echo $TPL_VAR["paymentData"]["bank"]?>

                    </span>
                    <span>
                        Account number :
                        <em>
                            <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?>

                        </em>
                    </span>
                    <span>
                        deadline for the deposit :
                        <em class="fb__point-color">
                            <?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일
                        </em>
                        If you do not deposit by, your order will be cancelled.
                    </span>
                </p>
            </li>
<?php }else{?>
            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Account information
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["paymentData"]["memo"]?>

                </p>
            </li>
<?php }?>
        </ul>
    </section>

    <section class="fb__payment-complete__delivery-info delivery-info">
        <h2 class="delivery-info__title">Shipping Information</h2>
        <ul class="delivery-info__box">
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Name
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["rname"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Address
                </span>
                <p class="delivery-info__cont">
                    (<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>) <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?> <?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Tel
                </span>
                <p class="delivery-info__cont">
                    <em><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></em>
                </p>
            </li>
            <!--<li class="delivery-info__list">-->
                <!--<span class="delivery-info__cate">-->
                    <!--Tel-->
                <!--</span>-->
                <!--<p class="delivery-info__cont">-->
                    <!--<em><?php echo $TPL_VAR["deliveryInfo"]["rtel"]?></em>-->
                <!--</p>-->
            <!--</li>-->
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Shipping comment
                </span>
                <p class="delivery-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]){?>
                    <span>
                        <span class="tit"><?php echo $TPL_V1["pname"]?></span>
                        <?php echo $TPL_V1["msg"]?>

                    </span>
<?php }?>
<?php }}?>
                </p>
            </li>
        </ul>
    </section>
    <div class="fb__payment-complete__btn-area btn-area">
        <a href="/" class="btn-area__go-home">Home</a>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        <a href="/mypage/orderHistory" class="btn-area__go-rf">Your Orders</a>
<?php }else{?>
        <a href="/member/login" class="btn-area__go-rf">Your Orders</a>
<?php }?>
    </div>
</section>
<?php }else{?>
<section class="wrap-cart next-step fb__shop fb__payment-complete">
    <section class="fb__shop__title-area">
        <h2 class="fb__shop__title">Order Completed</h2>
        <ul class="fb__shop__step-area">
            <li class="fb__shop__step"><em>01</em> Cart</li>
            <li class="fb__shop__step"><em>02</em> Check Out</li>
            <li class="fb__shop__step fb__shop__step--on"><em>03</em> Order Completed</li>
        </ul>
    </section>

    <section class="fb__payment-complete__msg complete-msg">
        <h2 class="complete-msg__title">
            Order completed successfully
        </h2>
        <p class="complete-msg__subtit">
            Order status is able to be checked in <span>My Page<em></em>Your Orders</span>
        </p>
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
        <div class="complete-msg__virtual">
            <span><?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일까지</span>
            <?php echo $TPL_VAR["paymentData"]["bank"]?> (계좌번호 : <em><?php echo $TPL_VAR["paymentData"]["bank_account_num"]?></em> / 예금주 : <?php echo $TPL_VAR["paymentData"]["bank_input_name"]?>) 으로 결제 예정금액
            <span><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em>원</span>을 입금해 주시기 바랍니다.
        </div>
<?php }?>
    </section>

    <section class="fb__infoinput__order-info order-info">
        <h2 class="order-info__title">Order Information</h2>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
        <table class="order-table order-info__table">
            <colgroup>
                <col width="*">
                <col width="145px">
                <col width="145px">
                <col width="145px">
                <col width="145px">
                <col width="145px">
            </colgroup>
            <thead>
            <tr>
                <th>Item Name/Option</th>
                <th>Quantities of order</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Savings</th>
                <th><?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated total <?php }else{?>Estimated Total<?php }?></th>
            </tr>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
            <table class="order-table order-info__table">
                <colgroup>
                    <col width="*">
                    <col width="145px">
                    <col width="145px">
                    <col width="145px">
                    <col width="145px">
                </colgroup>
                <tbody>

                    <tr>
                        <td class="item-info">
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                <div class="item-info__thumb">
                                    <img src="<?php echo $TPL_V2["pimg"]?>">
                                </div>
                                <div class="item-info__info">
                                    <p class="item-info__title">
<?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>] <?php }?><?php echo $TPL_V2["pname"]?>

                                    </p>
<?php if($TPL_V2["set_group"]> 0){?>                                    <?php if(is_array($TPL_R3=$TPL_V2["setData"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                    <span class="item-info__option"><?php echo $TPL_V3["option_text"]?></span>
<?php }}?>
<?php }else{?>
                                    <p class="item-info__option">
                                        <?php echo $TPL_V2["option_text"]?>

                                    </p>
<?php }?>
                                </div>
                            </a>
                        </td>
                        <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                        <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        <td>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    </tr>
<?php if(count($TPL_V2["product_gift"])> 0){?>
                    <tr class="product-gift-wrap">
                        <td colspan="5">
                            <div class="product-gift">
                                <p class="product-gift__title"><span>GIft</span> </p>
                                <ul class="product-gift__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                                    <li class="product-gift__box inner-gift devGiftList">
                                        <figure class="product-gift__thumb">
                                            <img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["pname"]?>" data-devpid="<?php echo $TPL_VAR["giftItem"]["pid"]?>" data-devpcount="<?php echo $TPL_VAR["giftItem"]["cnt"]?>">
                                        </figure>
                                        <div class="product-gift__info">
                                            <span class="product-gift__info__pname"><?php echo $TPL_V3["pname"]?></span>
                                            <span class="product-gift__info__count"><?php echo $TPL_V3["pcnt"]?>{=trans('개')]</span>
                                        </div>
                                    </li>
<?php }}?>
                                </ul>
                            </div>
                        </td>
                    </tr>
<?php }?>
                </tbody>
            </table>
            <div class="delivery-area order-info__delivery-area">
                <span>Shipping fee <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
            </div>
<?php }}?>
            </tbody>
        </table>
<?php }}?>
    </section>

<?php if($TPL_VAR["freeGiftG"]){?>    <section class="wrap-gift-area fb__infoinput">
        <h3>Gift by purchase amount</h3>
        <div class="product-gift order-info__pricegift">
            <div class="product-gift__list">
<?php if($TPL_freeGiftG_1){foreach($TPL_VAR["freeGiftG"] as $TPL_V1){?>
                <div class="product-gift__box devGiftListByOrder">
                    <figure class="product-gift__thumb">
                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>"
                             data-devpid="<?php echo $TPL_V1["pid"]?>" data-devpcount="<?php echo $TPL_V1["pcnt"]?>">
                    </figure>
                    <div class="product-gift__info">
                        <p class="product-gift__info__pname"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s)</p>
                    </div>
                </div>
<?php }}?>
            </div>
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["freeGiftC"]){?>    <section class="wrap-gift-area fb__infoinput">
        <h3>카테고리포함 사은품</h3>
        <div class="product-gift order-info__pricegift">
            <div class="product-gift__list">
<?php if($TPL_freeGiftC_1){foreach($TPL_VAR["freeGiftC"] as $TPL_V1){?>
                <div class="product-gift__box devGiftListByOrder">
                    <figure class="product-gift__thumb">
                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>"
                             data-devpid="<?php echo $TPL_V1["pid"]?>" data-devpcount="<?php echo $TPL_V1["pcnt"]?>">
                    </figure>
                    <div class="product-gift__info">
                        <p class="product-gift__info__pname"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s)</p>
                    </div>
                </div>
<?php }}?>
            </div>
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["freeGiftP"]){?>    <section class="wrap-gift-area fb__infoinput">
        <h3>특정상품포함 금액합계별 사은품</h3>
        <div class="product-gift order-info__pricegift">
            <div class="product-gift__list">
<?php if($TPL_freeGiftP_1){foreach($TPL_VAR["freeGiftP"] as $TPL_V1){?>
                <div class="product-gift__box devGiftListByOrder">
                    <figure class="product-gift__thumb">
                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>"
                             data-devpid="<?php echo $TPL_V1["pid"]?>" data-devpcount="<?php echo $TPL_V1["pcnt"]?>">
                    </figure>
                    <div class="product-gift__info">
                        <p class="product-gift__info__pname"><?php echo $TPL_V1["pname"]?> / <?php echo $TPL_V1["pcnt"]?>ltem(s)</p>
                    </div>
                </div>
<?php }}?>
            </div>
        </div>
    </section>
<?php }?>

    <section class="fb__payment-complete__wrap-price wrap-price">
        <h2 class="wrap-price__title">Estimated Total</h2>
        <div class="wrap-price__box">
            <ul class="price-box">
                <li class="price-box__list price-box__list-sum">
                    <span class="price-box__tit">Item Total</span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-discount">
                    <span class="price-box__tit">Savings</span>
                    <p class="price-box__amt">- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-mileage">
                    <span class="price-box__tit"><?php echo $TPL_VAR["mileageName"]?></span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-delivery">
                    <span class="price-box__tit price-box__delivery__tit">Shipping fee</span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
                <li class="price-box__list price-box__list-due-amt">
                    <span class="price-box__tit">
<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?> Estimated total <?php }else{?>Estimated Total<?php }?>
                    </span>
                    <p class="price-box__amt"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentData"]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </li>
            </ul>

        </div>
    </section>

    <section class="fb__payment-complete__pmt-info pmt-info">
        <h2 class="pmt-info__title">Payment Information</h2>
        <ul class="pmt-info__box">
            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Order No.
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["order"]["oid"]?>

                </p>
            </li>

            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Order date
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["order"]["bdatetime"]?>

                </p>
            </li>

            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Payment Method
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["paymentData"]["method_text"]?>

                </p>
            </li>

<?php if(in_array($TPL_VAR["paymentData"]["method"],array(ORDER_METHOD_BANK,ORDER_METHOD_VBANK))){?>
            <li class="pmt-info__list eng-hidden">
                <span class="pmt-info__cate">
                    Account information
                </span>
                <p class="pmt-info__cont">
                    <span>
                        Bank : <?php echo $TPL_VAR["paymentData"]["bank"]?>

                    </span>
                    <span>
                        Account number :
                        <em>
                            <?php echo $TPL_VAR["paymentData"]["bank_account_num"]?>

                        </em>
                    </span>
                    <span>
                        deadline for the deposit :
                        <em class="fb__point-color">
                            <?php echo $TPL_VAR["paymentData"]["bank_input_date_yyyy"]?>년 <?php echo $TPL_VAR["paymentData"]["bank_input_date_mm"]?>월 <?php echo $TPL_VAR["paymentData"]["bank_input_date_dd"]?>일
                        </em>
                        If you do not deposit by, your order will be cancelled.
                    </span>
                </p>
            </li>
<?php }else{?>
            <li class="pmt-info__list">
                <span class="pmt-info__cate">
                    Account information
                </span>
                <p class="pmt-info__cont">
                    <?php echo $TPL_VAR["paymentData"]["memo"]?>

                </p>
            </li>
<?php }?>
        </ul>
    </section>

    <section class="fb__payment-complete__delivery-info delivery-info">
        <h2 class="delivery-info__title">Shipping Information</h2>
        <ul class="delivery-info__box">
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Name
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["rname"]?>

                </p>
            </li>
            <!-- @TODO 주소 데이터 매칭 필요 -->
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Country
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["country_full"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Zip/Postal Code
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["zip"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Address Line 1
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Address Line 2
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    City
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["city"]?>

                </p>
            </li>
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    State/Province
                </span>
                <p class="delivery-info__cont">
                    <?php echo $TPL_VAR["deliveryInfo"]["state"]?>

                </p>
            </li>

            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Tel
                </span>
                <p class="delivery-info__cont">
                    <em><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></em>
                </p>
            </li>
            <!--<li class="delivery-info__list">-->
                <!--<span class="delivery-info__cate">-->
                    <!--Tel-->
                <!--</span>-->
                <!--<p class="delivery-info__cont">-->
                    <!--<em><?php echo $TPL_VAR["deliveryInfo"]["rtel"]?></em>-->
                <!--</p>-->
            <!--</li>-->
            <li class="delivery-info__list">
                <span class="delivery-info__cate">
                    Shipping comment
                </span>
                <p class="delivery-info__cont">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]){?>
                    <span>
                        <span class="tit"><?php echo $TPL_V1["pname"]?></span>
                        <?php echo $TPL_V1["msg"]?>

                    </span>
<?php }?>
<?php }}?>
                </p>
            </li>
        </ul>
    </section>
    <div class="fb__payment-complete__btn-area btn-area">
        <a href="/" class="btn-area__go-home">Home</a>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        <a href="/mypage/orderHistory" class="btn-area__go-rf">Your Orders</a>
<?php }else{?>
        <a href="/member/login" class="btn-area__go-rf">Your Orders</a>
<?php }?>
    </div>
</section>
<?php }?>
<?php echo $TPL_VAR["payMentScript"]?>