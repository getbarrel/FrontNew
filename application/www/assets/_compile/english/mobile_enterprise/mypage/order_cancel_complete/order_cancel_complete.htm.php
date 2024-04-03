<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_cancel_complete/order_cancel_complete.htm 000005364 */ ?>
<!-- 주문취소신청완료 -->
<section class="br__order-claim">
    <h2 class="br__order-claim__title">Cancel Order</h2>
    <div class="order-claim order-complete">
        <div class="order-complete__ment">
            <p class="order-complete__ment__desc"><span>The request Cancellation</span> for the order has been completed.</p>
        </div>
        <!-- [S] 주문 취소 상품 -->
        <section class="order-claim__able">
            <h3 class="order-claim__title br__hidden">items for cancellation</h3>
            <div class="order-claim__content">
                <dl class="order-claim__number">
                    <dt class="order-claim__number__title">Order Date</dt>
                    <dd class="order-claim__number__text"><?php echo str_replace('-','.',$TPL_VAR["order"]["order_date"])?></dd>
                    <dt class="order-claim__number__title">Order No.</dt>
                    <dd class="order-claim__number__text" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
                </dl>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='CC'||$TPL_V2["status"]=='IB'){?>
                    <li class="order-claim__box">
                        <div class="order-claim__goods">
                            <figure class="order-claim__goods__thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                            </figure>
                            <div class="order-claim__goods__info">
                                <p class="order-claim__goods__title"><?php echo $TPL_V2["pname"]?></p>
                                <p class="order-claim__goods__option">
                                    <!-- <span>블랙/네온 옐로우/네온 핑크</span> -->
                                    <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo number_format($TPL_VAR["restOrderDetail"][$TPL_V2["pid"]]['rest_cnt']+$TPL_V2["pcnt"])?>ltem(s)</em></span>
                                </p>
                                <span class="order-claim__goods__state"><?php echo trans($TPL_V2["status_text"])?></span>
                                <!-- <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span> -->
                                <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                <button class="order-claim__goods__toggle">Order cancellation apply/cancel button</button>
                            </div>
                        </div>
                        <div class="order-claim__form">
                            <div class="order-claim__form__box">
                                <span class="order-claim__form__title">Quantity</span>
                                <div class="order-claim__form__input">
                                    <p class="order-claim__form__text"><?php echo $TPL_V2["pcnt"]?></p>
                                </div>
                            </div>
                            <div class="order-claim__form__box">
                                <span class="order-claim__form__title">Reason</span>
                                <div class="order-claim__form__input">
                                    <p class="order-claim__form__text"><?php echo trans($TPL_VAR["reason_data"][$TPL_V2["pid"]]['reason_text'])?></p>
                                </div>
                            </div>
                            <div class="order-claim__form__box">
                                <div class="order-claim__form__input">
                                    <p class="order-claim__form__text"><?php echo nl2br($TPL_VAR["reason_data"][$TPL_V2["pid"]]['status_message'])?></p>
                                </div>
                            </div>
                        </div>
                    </li>
<?php }?>
<?php }}?>
                </ul>
<?php }}?>
            </div>
        </section>
        <!-- [E] 주문 취소 상품 -->
        <div class="wrap-sect"></div>

        <div class="order-complete__notice">
            <p class="order-complete__notice__desc">Cancellation processing status can be found in <span>My Page > Return/Cancellation</span]></p>
        </div>
        <div class="br__order-claim__btn order-cancel-complete-button">
            <a href="/mypage/orderHistory" class="br__order-claim__btn--link">Your Orders</a>
            <a href="/mypage/returnHistory" class="br__order-claim__btn--link">Return/Cancellation</a>
        </div>
    </div>
</section>