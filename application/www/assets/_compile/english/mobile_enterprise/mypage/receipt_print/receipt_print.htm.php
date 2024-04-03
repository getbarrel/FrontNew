<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/receipt_print/receipt_print.htm 000007218 */ ?>
<section class="br__order-detail receipt-print">
    <h2 class="br__order-detail__title">Payment Receipt</h2>
    <div class="order-detail" id="js__capture">
        <section class="br__odhistory__each order-detail">
            <div class="odeach">
                <header class="odeach__top ">
                    <h3 class="br__hidden">Your Orders</h3>
                    <p class="odeach__top__text">Order Date <span><?php echo $TPL_VAR["order"]["order_date"]?></span></p>
                    <p class="odeach__top__text">Order No. <span><?php echo $TPL_VAR["order"]["oid"]?></span></p>
                    <p class="odeach__top__text">Name <span><?php echo $TPL_VAR["order"]["bname"]?></span></p>
                </header>
                <h3 class="receipt-print__title">Purchase History

<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(($TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE||$TPL_V1["method"]==ORDER_METHOD_ASCROW)&&$TPL_V1["receipt_yn"]=='Y'){?>
<?php if($TPL_V1["tid"]){?>
                                <button class="receipt-print__title__btn devCachInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">영문몰해당없음</button>
<?php }?>
<?php }elseif($TPL_V1["method"]==ORDER_METHOD_CARD){?>
<?php if($TPL_V1["tid"]){?>
                            <button class="receipt-print__title__btn devCardInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">Credit card slip</button>
<?php }?>
<?php }?>
<?php }}?>

                </h3>
                <div class="order-detail__goods">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <ul class="odeach__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);?>
                        <li class="odeach__item">
                            <div class="odeach__item__inner">
                                <figure class="odeach__item__thumb">
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                        <img src="<?php echo $TPL_V2["pimg"]?>" data-protocol="<?php echo IMAGE_SERVER_DOMAIN?>" >
                                        <!--<img src="https://image.getbarrel.com/data/barrel_data/images/product/00/00/00/04/52/m_0000000452.gif" alt="">-->
                                    </a>
                                </figure>
                                <div class="odeach__item__info"><!--contents-->
                                    <p class="odeach__item__title">
                                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
                                    </p>
<?php if($TPL_V2["set_group"]> 0){?>                                    <?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
                                    <p class="odeach__item__option"><?php echo $TPL_V3["option_text"]?> (구성수량:<?php echo $TPL_V3["pcnt"]?>개)</p>
<?php }}?>
<?php }else{?>
                                    <p class="odeach__item__option"><?php echo $TPL_V2["option_text"]?></p>
<?php }?>
<?php if($TPL_V2["add_info"]){?>
                                    <p class="odeach__item__option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                    <div class="odeach__item__bottom">
                                        <span class="odeach__item__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
                                        <!-- <?php echo g_price($TPL_V2["pt_dcprice"])?> -->
                                        <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                    </div>
                                </div>
                            </div>
                        </li>
<?php }}?>
                    </ul>
<?php }}?>
                </div>
            </div>
        </section>
        <div class="wrap-sect"></div>
        <!-- [S] 결제내역 -->
        <section class="order-detail__wrap">
        <h3 class="order-detail__wrap__title">Estimated Total</h3>
        <div class="order-payment">
            <div class="order-payment__wrap">
                <p class="order-payment__title">Payment Method <span><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></span></p>
            </div>
            <div class="order-payment__wrap">
                <p class="order-payment__title">Item Total <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["total_listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span></p>
                <dl class="order-payment__list">
                    <dt class="order-payment__list__title">Savings :</dt>
                    <dd class="order-payment__list__text"><?php if($TPL_VAR["paymentInfo"]["total_dc"]> 0){?>-<?php }?><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["total_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt class="order-payment__list__title">Mileage :</dt>
                    <dd class="order-payment__list__text"><?php if($TPL_VAR["paymentInfo"]["use_reserve"]> 0){?>-<?php }?><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["use_reserve"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt class="order-payment__list__title">Shipping :</dt>
                    <dd class="order-payment__list__text"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["order"]["delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
            <div class="order-payment__wrap order-payment__wrap--total">
                <p class="order-payment__title">Total <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["pt_dcprice"]+$TPL_VAR["order"]["delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["f"]?></span></p>
            </div>
        </div>
    </section>
    </div>
    <div class="receipt-print__btn">
        <button class="js__receipt__print receipt-print__btn__capture">Image storage</button>
        <p class="receipt-print__notice">This receipt cannot be used as an income deduction or purchase statement. It is only for proof of payment.</p>
    </div>
</section>