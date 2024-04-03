<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_complete.htm 000002905 */ ?>
<div class="order-complete">
    <div class="order-complete__ment">
        <p class="order-complete__ment__desc">The request [Cancellation] for the order has been completed.</p>
    </div>


    <!-- [S] 주문 취소 상품 -->
    <section class="order-claim__able">
        <h3 class="order-claim__title br__hidden">items for cancellation</h3>
        <div class="order-claim__content">
            <dl class="order-claim__number">
                <dt class="order-claim__number__title">Order Date</dt>
                <dd class="order-claim__number__text"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
                <dt class="order-claim__number__title">Order No.</dt>
                <dd class="order-claim__number__text" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            </dl>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <li class="order-claim__box">
                    <div class="order-claim__goods">
                        <figure class="order-claim__goods__thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                        </figure>
                        <div class="order-claim__goods__info">
                            <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                            <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>

                                <span style="margin-top: 20px"><em>Quantity : <?php echo $TPL_VAR["claimCnt"][$TPL_V2["od_ix"]]?>ltem(s)</em></span>
                            </p>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo number_format($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button class="order-claim__goods__toggle">Order cancellation apply/cancel button</button>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
</div>