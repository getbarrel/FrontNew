<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim_detail/order_claim_detail.htm 000038990 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);
$TPL_deny_1=empty($TPL_VAR["deny"])||!is_array($TPL_VAR["deny"])?0:count($TPL_VAR["deny"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>

<div class="fb__return-history wrap-mypage wrap-order-detail">
    <section>
        <h2 class="fb__mypage__title">Application details inquiry</h2>
        <div class="order-number-box">
            <span class="tit">Order No.</span>
            <span class="order-num"><?php echo $TPL_VAR["order"]["oid"]?></span>
            <span class="tit">Order Date</span>
            <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
        </div>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="80px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>Item Name/Option</th>
            <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
            <th>Estimated Total</th>
            <th>Order Status</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
<?php if($TPL_V2["set_group"]> 0){?>
                <tr>
                    <td colspan="4">
<?php if(is_array($TPL_R3=$TPL_V2["setData"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?>
<?php if($TPL_I3== 0){?>
                        <table class="inner-set">
                            <colgroup>
                                <col width="*"/>
                                <col width="80px"/>
                                <col width="100px"/>
                                <col width="100px"/>
                            </colgroup>
                            <tr>
                                <td>
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                        <div class="thumb">
                                            <img src="<?php echo $TPL_V2["pimg"]?>">
                                        </div>
                                        <div class="info">
                                            <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                            <p class="option"><?php echo $TPL_V3["option_text"]?></p>
<?php if($TPL_V3["add_info"]){?>
                                            <p class="option"><?php echo $TPL_V3["add_info"]?></p>
<?php }?>
                                        </div>
                                    </a>
                                </td>
                                <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                                <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                                <td>
                                    <p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
                                </td>
                            </tr>
                        </table>
<?php }else{?>
                        <table class="inner-set">
                            <colgroup>
                                <col width="*"/>
                                <col width="80px"/>
                                <col width="100px"/>
                                <col width="100px"/>
                            </colgroup>
                            <tr>
                                <td>
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                        <div class="thumb">
                                            <img src="<?php echo $TPL_V2["pimg"]?>">
                                        </div>
                                        <div class="info">
                                            <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                            <p class="option"><?php echo $TPL_V3["option_text"]?></p>
<?php if($TPL_V3["add_info"]){?>
                                            <p class="option"><?php echo $TPL_V3["add_info"]?></p>
<?php }?>
                                        </div>
                                    </a>
                                </td>
                                <td><em><?php echo $TPL_V3["pcnt"]?></em>ltem(s)</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
<?php }?>
<?php }}?>
                    </td>
                </tr>
<?php }else{?>
                <tr>
                    <td>
                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                            <div class="thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>">
                            </div>
                            <div class="info">
                                <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                            </div>
                        </a>
                    </td>
                    <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                    <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    <td>
                        <p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
                    </td>
                </tr>
<?php }?>
<?php if($TPL_V2["product_gift"]){?>
                <tr class="product-gift__wrap">
                    <td colspan="4">
                        <div class="product-gift">
                            <p class="product-gift__title"><span>GIft</span> <!--배럴 스위머즈 페스티벌--></p>
                            <ul class="product-gift__list">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                                <li class="product-gift__box" id="devPgItem">
                                    <div class="product-gift__thumb">
                                        <img src="<?php echo $TPL_V3["image_src"]?>" alt="product-gift">
                                    </div>
                                    <div class="product-gift__info">
                                        <span class="product-gift__info__pname"><?php echo $TPL_V3["pname"]?></span>
                                        <span class="product-gift__info__count">1ltem(s)</span>
                                    </div>
                                </li>
<?php }}?>
                            </ul>
                        </div>
                    </td>
                </tr>
<?php }?>
<?php }}?>
            </tbody>
        </table>
        <div class="delivery-area">
            <span>Shipping fee <em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?><?php echo $TPL_VAR["fbUnit"]["b"]?></em> (<?php echo $TPL_VAR["order"]["deliveryPricePolicyText"][$TPL_K1]?>)</span>
        </div>
<?php }}?>
    </section>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
    <section class="product-gift__wrap product-gift__wrap--full">
        <h3 class="fb__mypage__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></h3>
        <div class="product-gift">
            <ul class="product-gift__list">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <li class="product-gift__box">
                    <div class="product-gift__thumb">
                        <img src="<?php echo $TPL_V2["image_src"]?>" alt="">
                    </div>
                    <div class="product-gift__info">
                        <span class="product-gift__info__pname"><?php echo $TPL_V2["pname"]?></span>
                        <span class="product-gift__info__count"><?php echo $TPL_V2["pcnt"]?>ltem(s)</span>
                    </div>
                </li>

<?php }}?>
            </ul>
        </div>
    </section>
<?php }?>
<?php }}?>
<?php }?>
    <section class="fb__mypage__section">
        <table class="join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tr>
                <th rowspan="2"><?php echo $TPL_VAR["claimTypeName"]?> reason</th>
                <td><?php echo $TPL_VAR["reason"]["type_text"]?></td>
            </tr>
            <tr>
                <td><?php echo $TPL_VAR["reason"]["detail_text"]?></td>
            </tr>
        </table>
    </section>

<?php if($TPL_VAR["deny"]){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> rejection/avoidable details</h2>
        <table class="join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
            <tr>
                <th>Product Information</th>
                <td><?php echo $TPL_V1["pname"]?><br/>Option : <?php echo $TPL_V1["option_text"]?></td>
            </tr>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>disavowal<?php }else{?>Impossible<?php }?> Reason</th>
                <td><?php echo $TPL_V1["deny_message"]?></td>
            </tr>
<?php }}?>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["returnMethod"]){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>
        <table class="join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?> Shipping method</th>
                <td>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>direct transmission <span>(when the purchaser has already sent the goods individually]<?php }else{?>Request for visit by designated courier <span>(collects visiting receipt from the courier contracted with the vendor)</span><?php }?>
                </td>
            </tr>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>

            <tr>
                <th>Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></th>
                <td>
<?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>
                    <?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?> <span>(Tracking No.:<?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</span> <br>
<?php }?>
                    Shipping Fee <span><?php if($TPL_VAR["returnMethod"]["returnData"]["delivery_pay_type"]== 1){?>Pre-paid<?php }else{?>Collect on delivery<?php }?></span>
                </td>
            </tr>

<?php }else{?>
            <tr>
                <th rowspan="5">Pick up address</th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["caddr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
<?php if($TPL_VAR["claimType"]=='E'){?>
            <tr>
                <th rowspan="5">Address to exchange<br>
                    <span>(purchaser address)</span>
                </th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["zip"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rmobile"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rtel"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["returnMethod"]["reDeliveryData"]["msg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
            </tbody>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">The cost of change</h2>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>Total amount of goods applied for exchange</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["productPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl>
                    <dtAdditional shipping fee for exchange</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <dt>Estimate amount for additional paymet</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["addPaymentPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            <?php echo trans('결제수단 중 가상계좌 외 모든 결제수단은 자동 환불 처리되며 가상계좌로 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리 됩니다.<br>
            결제 시 사용한 쿠폰 및 적립금은 내부정책에 따라 취소신청 완료 후 환불됩니다.
            ')?>

        </div>
    </section>
<?php }else{?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Return Information</h2>
        <div class="refund-list">
            <div class="clearfix devCancelPriceContents">
                <div class="col">
                    <div class="row-top">
                        <p class="tit">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></p>
                        <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt><?php echo $TPL_VAR["claimTypeName"]?>할 item amount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
<?php if($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"]){?>
                        <dl class="fb__mypage__icon--desc">
                            <dt>(english)배송비쿠폰할인(차감)</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
<?php }?>
                        <!--
                        <dl class="fb__mypage__icon--desc">
                            <dt>Item-discount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["dr_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>Membership-discount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["mg_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>Coupons</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl>
                            <dt>Mileage</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["use_reserve"]* - 1)?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        -->
                        <dl>
                            <dt>Estimated shipping fee</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["deliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
                <div class="pay-info__box col">
                    <div class="row-top">
                        <p class="tit"><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</p>
                        <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
                    <!--@TODO 개발확인 반품시에 노출-->
                    <!--
                    <div class="pay-info__bottom">
                        <dl>
                            <dt>Shipping fee for order cancellation</dt>
                            <dd>
                                <?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                            </dd>
                        </dl>
                    </div>
                    -->
                </div>
                <div class="pay-info__box col">
                    <div class="row-top">
                        <p class="tit">Expected refund amount</p>
                        <p class="price fb__point-color2"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
                    <!--@TODO 개발확인 반품시에 노출-->
                    <div class="pay-info__bottom pay-info__bottom__text">
                        <span>estimate refund amount may be different from actual refund amount</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <dl>
                    <dt>Payment Method</dt>
                    <dd><?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?> <?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                </dl>
<?php if($TPL_VAR["expectedRefund"]["returnBankBool"]){?>
                <dl>
                    <dt>Payment Method</dt>
                    <dd><?php echo $TPL_VAR["expectedRefund"]["refundBankName"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankOwner"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankNumber"]?></dd>
                </dl>
<?php }?>
            </div>
        </div>
        <div class="desc">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
            Paymentable Bank: NH Nonghyup, Kookmin, Shinhan, Woori, Corporate, SC, Busan, Kyongnam, Suhyup, Post Office
<?php }else{?>
            It will be autometically refunded to the means of payment used when items had been ordered.
<?php }?>
            <!--결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.<br>-->
            <!--결제 시 사용한 쿠폰 및 적립금는 내부정책에 따라 취소신청 완료 후 환불되며, 적립금 환불 내역은 취소신청 최종 승인 후 변경될 수 있습니다.-->
        </div>
    </section>
<?php }?>
<?php }?>

    <div class="wrap-btn-area">
        <button class="btn-lg btn-dark" onclick="parent.history.back(-1);">Previous</button>
    </div>
</div>

<?php }else{?>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>

<div class="fb__return-history wrap-mypage wrap-order-detail">
    <section>
        <h2 class="fb__mypage__title">Application details inquiry</h2>
        <div class="order-number-box">
            <span class="tit">Order No.</span>
            <span class="order-num"><?php echo $TPL_VAR["order"]["oid"]?></span>
            <span class="tit">Order Date</span>
            <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
        </div>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="80px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>Item Name/Option</th>
            <!--<th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>-->
            <th>Quantities</th>
            <th>Estimated Total</th>
            <th>Order Status</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <tr>
                <td>
                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                        <div class="thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>">
                        </div>
                        <div class="info">
                            <p class="title"><?php echo $TPL_V2["pname"]?></p>
                            <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                            <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                        </div>
                    </a>
                </td>
                <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                <td>
                    <p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
                </td>
            </tr>
<?php }}?>
            </tbody>
        </table>
        <div class="delivery-area">
            <span>Shipping fee <em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?><?php echo $TPL_VAR["fbUnit"]["b"]?></em> (<?php echo $TPL_VAR["order"]["deliveryPricePolicyText"][$TPL_K1]?>)</span>
        </div>
<?php }}?>
    </section>

    <section class="fb__mypage__section">
        <table class="join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tr>
                <th rowspan="2">Reason</th>
                <td><?php echo trans($TPL_VAR["reason"]["type_text"])?></td>
            </tr>
            <tr>
                <td><?php echo $TPL_VAR["reason"]["detail_text"]?></td>
            </tr>
        </table>
    </section>

<?php if($TPL_VAR["deny"]){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> rejection/avoidable details</h2>
        <table class="join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
            <tr>
                <th>Product Information</th>
                <td><?php echo $TPL_V1["pname"]?><br/>Option : <?php echo $TPL_V1["option_text"]?></td>
            </tr>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>disavowal<?php }else{?>Impossible<?php }?> Reason</th>
                <td><?php echo $TPL_V1["deny_message"]?></td>
            </tr>
<?php }}?>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["returnMethod"]&&false){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>
        <table class="join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?> Shipping method</th>
                <td>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>direct transmission <span>(when the purchaser has already sent the goods individually]<?php }else{?>Request for visit by designated courier <span>(collects visiting receipt from the courier contracted with the vendor)</span><?php }?>
                </td>
            </tr>
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>

            <tr>
                <th>Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></th>
                <td>
<?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>
                    <?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?> <span>(Tracking No.:<?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</span> <br>
<?php }?>
                    Shipping Fee <span><?php if($TPL_VAR["returnMethod"]["returnData"]["delivery_pay_type"]== 1){?>Pre-paid<?php }else{?>Collect on delivery<?php }?></span>
                </td>
            </tr>

<?php }else{?>
            <tr>
                <th rowspan="5">Pick up address</th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["caddr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
<?php if($TPL_VAR["claimType"]=='E'){?>
            <tr>
                <th rowspan="5">Address to exchange<br>
                    <span>(purchaser address)</span>
                </th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["zip"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rmobile"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rtel"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["returnMethod"]["reDeliveryData"]["msg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
            </tbody>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]&&false){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">The cost of change</h2>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>Total amount of goods applied for exchange</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["productPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl>
                    <dtAdditional shipping fee for exchange</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <dt>Estimate amount for additional paymet</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["addPaymentPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            Shipping fee for exchange may change after the seller&#39;s final approval.
        </div>
    </section>
<?php }else{?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Return Information</h2>
        <div class="refund-list">
            <div class="clearfix devCancelPriceContents">
                <div class="col">
                    <div class="row-top">
                        <p class="tit">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></p>
                        <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt><?php echo $TPL_VAR["claimTypeName"]?>할 item amount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>Item-discount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["dr_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>Membership-discount</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["mg_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>Coupons</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="fb__mypage__icon--desc">
                            <dt>(english)배송비쿠폰할인</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl>
                            <dt>Mileage</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_VAR["expectedRefund"]["paymentInfo"]["use_reserve"]* - 1)?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl>
                            <dt>Estimated shipping fee</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["deliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                </div>
                <div class="pay-info__box col">
                    <div class="row-top">
                        <p class="tit"><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</p>
                        <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
                </div>
                <div class="pay-info__box col">
                    <div class="row-top">
                        <p class="tit">Expected refund amount</p>
                        <p class="price fb__point-color2"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                    </div>
<?php if($TPL_VAR["claimType"]=='R'){?>
                    <div class="pay-info__bottom pay-info__bottom__text">
                        <span>estimate refund amount may be different from actual refund amount</span>
                    </div>
<?php }?>
                </div>
            </div>
            <div class="row">
                <dl>
                    <dt>Payment Method</dt>
                    <dd><?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                </dl>
            </div>
        </div>
        <div class="desc">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
            The coupons and rewards used for payment will be refunded after request of cancellation is accepted according to our policy.
<?php }?>
        </div>
    </section>
<?php }?>
<?php }?>

    <div class="wrap-btn-area">
        <button class="btn-lg btn-dark" onclick="parent.history.back(-1);">Previous</button>
    </div>
</div>



<?php }?>