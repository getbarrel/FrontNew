<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_cancel/order_cancel.htm 000016716 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!-- 주문취소신청 -->
<section class="br__order-claim">
    <h2 class="br__order-claim__title">Cancel Order</h2>
    <div class="order-claim">


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
                    <li class="order-claim__box devCancelBoxOn devCancelArea" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-pcnt="<?php echo $TPL_V2["pcnt"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["allSelected"]=='Y')){?>block<?php }else{?>none<?php }?>">

                        <input type="hidden" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" value='<?php echo $TPL_V2["od_ix"]?>'>
                        <div class="order-claim__goods">
                            <figure class="order-claim__goods__thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["pname"]?>">
                            </figure>
                            <div class="order-claim__goods__info">
                                <p class="order-claim__goods__title"><?php echo $TPL_V2["pname"]?></p>
                                <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                    <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                    <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                                </p>
                                <span class="order-claim__goods__state"><?php echo trans($TPL_V2["status_text"])?></span>
                                <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                <!-- 부분 취소 일시 정지 : 2019-10-16 부분취소 재사용 처리 2020-01-08 -->
<?php if($TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["cancelAbleCnt"]> 1){?>
                                    <!--사은품 포함 시 부분취소 불가 처리 를 위한 버튼 노출 제어 2020-01-08 -->
<?php if($TPL_VAR["partCancelBool"]==true){?>
                                    <button class="order-claim__goods__toggle devCancelMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-cancel="Y">Order cancellation apply/cancel button</button>
<?php }?>
<?php }?>
                            </div>
                        </div>

                        <div class="order-claim__form">
                            <div class="order-claim__form__box">
                                <span class="order-claim__form__title">Quantity</span>
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
                                <div class="order-claim__form__input">
                                    <p class="order-claim__form__text"><?php echo $TPL_V2["pcnt"]?></p>
                                    <input type="hidden" name="pcnt" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devPcnt">
                                </div>
<?php }else{?>
                                <div class="order-claim__form__input">
                                    <div class="control">
                                        <ul class="option-up-down devControlCntBox">
                                            <li class="devCntMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>" <?php if($TPL_VAR["order"]["status"]!='IC'){?> disabled="true" <?php }?>><button class="down"></button></li>
                                            <li><input type="text" name="pcnt" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devPcnt" readonly></li>
                                            <li class="devCntPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>" <?php if($TPL_VAR["order"]["status"]!='IC'){?> disabled="true" <?php }?>><button class="up"></button></li>
                                        </ul>
                                    </div>
                                </div>
<?php }?>
                            </div>
                            <div class="order-claim__form__box devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                <span class="order-claim__form__title">Reason</span>
                                <div class="order-claim__form__input">
                                    <select name="cc_reason" class="devCcReason" data-odix="<?php echo $TPL_V2["od_ix"]?>">
<?php if(is_array($TPL_R3=($TPL_VAR["cancelReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
                                        <option value="<?php echo $TPL_K3?>">Others</option>
<?php }else{?>
                                        <option value="<?php echo $TPL_K3?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
                                    </select>
                                </div>
                            </div>
                            <div class="order-claim__form__box">
                                <div class="order-claim__form__input">
                                    <textarea placeholder="Please enter reasons for cancellation (100 word max)" name="cc_msg[<?php echo $TPL_V2["od_ix"]?>]" data-odIx="<?php echo $TPL_V2["od_ix"]?>" maxlength="100" class="devCcMsg"></textarea>
                                </div>
                            </div>
                        </div>
                    </li>
<?php }}?>
                </ul>

<?php }}?>
            </div>
        </section>
        <!-- [E] 주문 취소 상품 -->




        <!-- 부분취소 임시 중지 처리 : 2019-10-16 부분취소 재사용 처리 2020-01-08 -->

        <div id="devCancelItemSec1" style="display:<?php if($TPL_VAR["cancelAbleCnt"]> 1&&$TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["partCancelBool"]==true){?>block<?php }else{?>none<?php }?>">

        <!--<div id="devCancelItemSec1" style="display:none">-->
        <div class="wrap-sect"></div>

        <!-- [S] 주문취소 신청 상품 추가 -->

        <section class="order-claim__disable">
            <h3 class="order-claim__title">Add items for cancellation</h3>
            <div class="order-claim__content">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="order-claim__box devCancelBoxOff"  data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_VAR["odIx"]!=''&&$TPL_VAR["odIx"]!=$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
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
                                </p>
                                <span class="order-claim__goods__state"><?php echo trans($TPL_V2["status_text"])?></span>
                                <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                <button class="order-claim__goods__toggle devCancelPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-cancel="Y">Order cancellation apply/cancel button</button>
                            </div>
                        </div>
                    </li>
<?php }}?>
                </ul>
<?php }}?>
            </div>
        </section>
        <!-- [E] 주문취소 신청 상품 추가 -->

        </div>


<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
        <div class="wrap-sect"></div>
        <!-- [S] 주문취소 결제정보 -->
        <section class="order-claim__payment">
            <h3 class="order-claim__title">Cancellation Information</h3>
            <div class="order-claim__content">
                <div class="claim-pay">
                    <dl class="claim-pay__info">
                        <dt class="claim-pay__title">method of payment</dt>
                        <dd class="claim-pay__detail">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["method"]!=ORDER_METHOD_SAVEPRICE&&$TPL_V1["method"]!=ORDER_METHOD_RESERVE&&$TPL_V1["method"]!=ORDER_METHOD_CART_COUPON&&$TPL_V1["method"]!=ORDER_METHOD_DELIVERY_COUPON){?>
                            <p class="claim-pay__text">
                                <?php echo $TPL_V1["method_text"]?>

<?php if(($TPL_V1["payment_price"]> 0)){?>
                                : <span class="point"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["payment_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
                            </p>
<?php }?>
<?php }}?>
                        </dd>
                    </dl>
                    <dl class="claim-pay__info">
                        <dt class="claim-pay__title">Payment Information</dt>
                        <dd class="claim-pay__detail">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                            <p class="claim-pay__text">
                                total for Cancellation :
                                <span><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelProductPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </p>
<?php }}?>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["deliveryPrice"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                            <p class="claim-pay__text">
                                Estimated shipping fee :
                                <span><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devDeliveryDcPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </p>
<?php }}?>
                        </dd>
                    </dl>
                    <dl class="claim-pay__info">
                        <dt class="claim-pay__title">Total Cancellation</dt>
                        <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelTotalPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <dl class="claim-pay__info">
                        <dt class="claim-pay__title">Additional Shipping fee</dt>
                        <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelDeliveryReceivePrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
<?php }?>
                    <dl class="claim-pay__info claim-pay__info--total">
                        <dt class="claim-pay__title">Expected refund amount</dt>
                        <dd class="claim-pay__result claim-pay__result--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelTotalReturnPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
            </div>
        </section>
        <!-- [E] 주문취소 결제정보 -->
<?php }?>




<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
            <!-- 환불 수단 -->
<?php if($TPL_VAR["langType"]=='korean'){?>
            <div class="wrap-sect"></div>
            <!-- [S] 주문취소 결제정보 -->
            <section class="order-claim__payment" id="devRefundMethod" style="display:none">
                <h3 class="order-claim__title br__hidden">Refund account information</h3>
                <div class="order-claim__content">
                    <div class="cancel-account">
<?php if($TPL_VAR["refundInfo"]["method"]=='4'){?>
                        <p class="cancel-account__title">Payment Method :Deposit without bankbook: refund by refund account amount of returned product:</p>
                        <div class="cancel-account__box">
                            <select name="bankCode" title="Bank" id="devBankCode">
                                <option value="">Select</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
                            </select>
                        </div>
                        <div class="cancel-account__box">
                            <input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="account holder" id="devBankOwner" placeholder="please enter accont holder">
                        </div>
                        <div class="cancel-account__box">
                            <input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="Account number" id="devBankNumber" placeholder="Pleasen enter account number">
                        </div>
<?php }else{?>
                        <p class="cancel-account__title">Payment Method :Refund as payment method</p>
<?php }?>
                    </div>
                </div>
            </section>
<?php }?>

<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php switch($TPL_V1["method"]){case ORDER_METHOD_BANK:case ORDER_METHOD_VBANK:case ORDER_METHOD_ASCROW:case ORDER_METHOD_CASH:case ORDER_METHOD_ICHE:?><script>$(function(){$('#devRefundMethod').show();});</script><?php }?><?php }}?>

        <ul class="br__order-claim__notice">
<?php if($TPL_VAR["langType"]=='korean'){?>
            <li class="br__order-claim__desc">· It will be autometically refunded to the means of payment used when items had been ordered.</li>
<?php }?>
            <li class="br__order-claim__desc">· The coupons and mileage used for payment will be refunded after request of cancellation is accepted according to our policy.</li>
        </ul>
<?php }?>

        <div class="br__order-claim__btn">
            <button type="button" class="br__order-claim__btn--cancel" id="devClaimCancel">Cancel</button>
            <button type="button" class="br__order-claim__btn--submit" id="devClaimApply">Cancel order</button>
        </div>
    </div>
</section>