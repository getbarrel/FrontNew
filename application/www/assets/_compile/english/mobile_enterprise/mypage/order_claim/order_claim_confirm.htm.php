<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_confirm.htm 000027793 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
    <!-- [S] 상품 교환/반품 상품 -->
    <section class="order-claim__able order-complete">
        <h3 class="order-claim__title br__hidden"><?php echo $TPL_VAR["claimTypeName"]?> an Application product</h3>
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
                            </p>
                            <span class="order-claim__goods__state"><?php echo trans($TPL_V2["status_text"])?></span>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button type="button" class="order-claim__goods__toggle"><?php echo $TPL_VAR["claimTypeName"]?> Apply/cancel button</button>
                        </div>
                    </div>
                    <div class="order-claim__form">
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Quantity</span>
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></p>
                            </div>
                        </div>
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Reason</span>
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></p>
                            </div>
                        </div>
                        <div class="order-claim__form__box">
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?></p>
                            </div>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
    <!-- [E] 주문 교환/반품 상품 -->



    <div class="wrap-sect"></div>
    <!-- [S] 교환/반품 방법 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h3>
        <div class="order-claim__content">
            <div class="claim-pay">
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title"><?php echo $TPL_VAR["claimTypeName"]?> Shipping method</dt>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>(english)직접 발송<?php }else{?>지정 택배 발송<?php }?>
                        </p>
                    </dd>
                </dl>
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__detail">
<?php if($TPL_VAR["applyData"]["quick_info"]!='N'){?>
                        <p class="claim-pay__text">
                            Logistics :
                            <em><?php echo $TPL_VAR["applyData"]["quickText"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Tracking No. :
                            <em><?php echo $TPL_VAR["applyData"]["invoice_no"]?></em>
                        </p>
<?php }?>

                        <p class="claim-pay__text">
                            Shipping :
                            <em>
<?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>
                                    Pre-paid
<?php }else{?>
                                    Collect on delivery
<?php }?>
                            </em>
                        </p>
                    </dd>
                </dl>
<?php }else{?>                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Pick up address</dt>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            Name :
                            <em><?php echo $TPL_VAR["applyData"]["cname"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Address :
                            <em>[<?php echo $TPL_VAR["applyData"]["czip"]?>] <?php echo $TPL_VAR["applyData"]["caddr1"]?> <?php echo $TPL_VAR["applyData"]["caddr2"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Tel :
                            <em><?php echo $TPL_VAR["applyData"]["cmobile1"]?>-<?php echo $TPL_VAR["applyData"]["cmobile2"]?>-<?php echo $TPL_VAR["applyData"]["cmobile3"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Shipping comment :
                            <em><?php echo nl2br($TPL_VAR["applyData"]["cmsg"])?></em>
                        </p>
                    </dd>
                </dl>
<?php }?>


<?php if($TPL_VAR["claimType"]=='change'){?>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Address for exchange</dt>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            Name :
                            <em><?php echo $TPL_VAR["applyData"]["rname"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Address :
                            <em>[<?php echo $TPL_VAR["applyData"]["rzip"]?>] <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Tel :
                            <em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Shipping comment :
                            <em><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></em>
                        </p>
                    </dd>
                </dl>
<?php }?>
            </div>
        </div>
    </section>
    <!-- [E] 교환/반품 방법 -->




<?php if($TPL_VAR["claimType"]=='change'){?>
    <div class="wrap-sect"></div>
    <!-- [S] 변동내역 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title">The cost of change</h3>
        <div class="order-claim__content">
            <div class="claim-pay">
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Additional shipping fee for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result claim-pay__result--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["delivery"]["claim_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <ul class="br__order-claim__notice">
                    <li class="br__order-claim__desc"><?php echo $TPL_VAR["claimTypeName"]?>  Shipping costs may change <?php echo $TPL_VAR["claimTypeName"]?>after sellers finalize the item.</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- [E] 변동내역 -->
<?php }else{?>
    <div class="wrap-sect"></div>
    <!-- [S] 환불내역 -->

    <!-- 반품일 때 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Information</h3>
        <div class="order-claim__content">
            <div class="claim-pay">
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            return total :
                            <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </p>
                        <p class="claim-pay__text">
                            Estimated shipping fee :
                            <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </p>
                    </dd>
                </dl>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Additional shipping fee for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result claim-pay__result--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Expected refund amount</dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["view_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
    </section>
    <!-- [E] 환불내역 -->
<?php }?>



<?php if($TPL_VAR["claimType"]=='change'){?>
    <!-- [S] 환불수단 외 -->
    <section class="order-claim__payment">
        <form id="devClaimConfirmForm" method="post">
            <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
            <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
        </form>
    </section>
    <!-- [E] 환불수단 외-->
<?php }?>


<?php if($TPL_VAR["claimType"]=='return'){?>
    <div class="wrap-sect"></div>
    <!-- [S] 환불수단 -->
    <section class="order-claim__payment">
        <form id="devClaimConfirmForm" method="post">
            <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
            <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
            <h3 class="order-claim__title br__hidden">Refund account information</h3>
            <div class="order-claim__content" id="devInfoBankNumber" style="padding-bottom:50px;">
<?php if($TPL_VAR["refundInfo"]){?>
                <input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
                <div class="cancel-account">
                    <p class="cancel-account__title">Refund method: Make a deposit (Virtual account)</p>
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
                </div>
<?php }else{?>
                <div class="cancel-account">
                    <p class="cancel-account__title">Payment Method: Deposit without bankbook: refund by refund account amount of returned product</p>
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
                        <input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["ori_bank_number"]?>" title="Account number" id="devBankNumber" placeholder="Pleasen enter account number">
                    </div>
                </div>
<?php }?>
                <ul class="br__order-claim__notice">
                    <li class="br__order-claim__desc">· <?php echo trans('결제수단 중 가상계좌 외 모든 결제수단은 자동 환불 처리되며 가상계좌로 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리 됩니다.')?></li>
                    <li class="br__order-claim__desc">· <?php echo trans('결제 시 사용한 쿠폰 및 마일리지는 내부정책에 따라 취소신청 완료 후 환불됩니다.')?></li>
                </ul>
            </div>
        </form>
    </section>
    <!-- [E] 환불수단 -->
<?php }?>







<?php }else{?>
<!-- 글로벌 -->

    <!-- [S] 상품 교환/반품 상품 -->
    <section class="order-claim__able order-complete">
        <h3 class="order-claim__title br__hidden"><?php echo $TPL_VAR["claimTypeName"]?> an Application product</h3>
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
                            <p class="order-claim__goods__title"><?php if($TPL_V2["brand_name"]){?><?php echo $TPL_V2["brand_name"]?> <?php }?><?php echo $TPL_V2["pname"]?></p>
                            <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                            </p>
                            <span class="order-claim__goods__state"><?php echo trans($TPL_V2["status_text"])?></span>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button type="button" class="order-claim__goods__toggle"><?php echo $TPL_VAR["claimTypeName"]?> Apply/cancel button</button>
                        </div>
                    </div>
                    <div class="order-claim__form">
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Quantity</span>
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></p>
                            </div>
                        </div>
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Reason</span>
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></p>
                            </div>
                        </div>
                        <div class="order-claim__form__box">
                            <div class="order-claim__form__input">
                                <p class="order-claim__form__text"><?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?></p>
                            </div>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
    <!-- [E] 주문 교환/반품 상품 -->


<?php if(false){?>
    <div class="wrap-sect"></div>
    <!-- [S] 교환/반품 방법 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h3>
        <div class="order-claim__content">
            <div class="claim-pay">

                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            Logistics :
                            <em><?php echo $TPL_VAR["applyData"]["quickText"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Tracking No. :
                            <em><?php echo $TPL_VAR["applyData"]["invoice_no"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Shipping :
                            <em>
<?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>
                                Pre-paid
<?php }else{?>
                                Collect on delivery
<?php }?>
                            </em>
                        </p>
                    </dd>
                </dl>


<?php if($TPL_VAR["claimType"]=='change'){?>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Address for exchange</dt>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            Name :
                            <em><?php echo $TPL_VAR["applyData"]["rname"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Address :
                            <em>[<?php echo $TPL_VAR["applyData"]["rzip"]?>] <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Tel :
                            <em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em>
                        </p>
                        <p class="claim-pay__text">
                            Shipping comment :
                            <em><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></em>
                        </p>
                    </dd>
                </dl>
<?php }?>
            </div>
        </div>
    </section>
    <!-- [E] 교환/반품 방법 -->




<?php if($TPL_VAR["claimType"]=='change'){?>
    <div class="wrap-sect"></div>
    <!-- [S] 변동내역 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title">The cost of change</h3>
        <div class="order-claim__content">
            <div class="claim-pay">
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <ul class="br__order-claim__notice">
                    <li class="br__order-claim__desc"><?php echo $TPL_VAR["claimTypeName"]?>  Shipping costs may change <?php echo $TPL_VAR["claimTypeName"]?>after sellers finalize the item.</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- [E] 변동내역 -->


<?php }else{?>
    <div class="wrap-sect"></div>
    <!-- [S] 환불내역 -->
    <section class="order-claim__payment">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Information</h3>
        <div class="order-claim__content">
            <div class="claim-pay">
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Total payment for <?php echo $TPL_VAR["claimTypeName"]?></dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dd class="claim-pay__detail">
                        <p class="claim-pay__text">
                            return total :
                            <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </p>
                    </dd>
                </dl>
                <dl class="claim-pay__info">
                    <dt class="claim-pay__title">Expected refund amount</dt>
                    <dd class="claim-pay__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["view_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
    </section>
    <!-- [E] 환불내역 -->
<?php }?>

<?php }?>

<?php if($TPL_VAR["claimType"]=='change'){?>
    <!-- [S] 환불수단 외 -->
    <section class="order-claim__payment">
        <form id="devClaimConfirmForm" method="post">
            <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
            <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
        </form>
    </section>
    <!-- [E] 환불수단 외-->
<?php }?>

<?php if($TPL_VAR["claimType"]=='return'){?>
    <div class="wrap-sect"></div>
    <!-- [S] 환불수단 -->
    <section class="order-claim__payment" style="display:none;">
        <form id="devClaimConfirmForm" method="post">
            <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
            <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
        </form>
    </section>
    <!-- [E] 환불수단 -->
<?php }?>

<?php }?>