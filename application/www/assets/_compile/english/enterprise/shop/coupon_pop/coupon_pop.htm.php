<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/coupon_pop/coupon_pop.htm 000011171 */ 
$TPL_deliveryCouponList_1=empty($TPL_VAR["deliveryCouponList"])||!is_array($TPL_VAR["deliveryCouponList"])?0:count($TPL_VAR["deliveryCouponList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$TPL_cartCouponList_1=empty($TPL_VAR["cartCouponList"])||!is_array($TPL_VAR["cartCouponList"])?0:count($TPL_VAR["cartCouponList"]);?>
<section class="wrap-window-popup coupon-popup fb__shop__coupon-popup">
    <div class="couponpop">
        <h2 class="fb__title--hidden">주문결제 - 쿠폰 적용 팝업</h2>
        <p class="fb__shop__coupon-popup__noti">
            Coupon list can be found under <span class="fb__shop__coupon-popup--em">My page <em></em> My coupon</span>
        </p>
<?php if($TPL_VAR["couponDiv"]=='D'){?>
        <section class="couponpop__cart">
            <h3 class="couponpop__title">(english)배송비 쿠폰<span class="js__coupon__fold couponpop__fold-icon">접기버튼</span></h3>
            <dl class="couponpop__cart__inner js__coupon__fold-target" >
                <dt class="couponpop__cart__title">Coupon Selection</dt>
                <dd class="couponpop__cart__select js__coupon__target">
                    <select devDeliveryCouponSelect>
                        <option value="">Select</option>
<?php if($TPL_deliveryCouponList_1){foreach($TPL_VAR["deliveryCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
                        <option value="<?php echo $TPL_V1["regist_ix"]?>"
                                devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
                                devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
                    </select>
                    <button type="button" class="js__coupon__cancel couponpop__cancel devCouponCancel">취소</button>
                </dd>
            </dl>
        </section>
        <section class="couponpop__summary">
            <h3 class="fb__title--hidden">요약본</h3>
            <dl class="couponpop__summary__each">
                <dt class="couponpop__summary__title">Shipping fee</dt>
                <input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
                <input type="hidden" id="devTotalDeliveryPrice" value="<?php echo $TPL_VAR["totalDeliveryPrice"]?>" />
                <dd class="couponpop__summary__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["totalDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="couponpop__summary__each">
                <dt class="couponpop__summary__title">Coupons-discount</dt>
                <dd class="couponpop__summary__price"><span id='tot_discount'>-</span><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponDiscountAmount">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="couponpop__summary__bottom">
                <input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
                <dt class="couponpop__summary__title--big">Total coupon application amount</dt>
                <dd class="couponpop__summary__price--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["totalDeliveryPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
        </section>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" id="devCouponCancelButton">Cancel</button>
            <button class="btn-default btn-dark" id="devApplyDeliveryCouponButton">
<?php if($TPL_VAR["langType"]=='korean'){?>
                Valid Coupons
<?php }else{?>
                Apply
<?php }?>
            </button>
        </div>
<?php }else{?>
        <section>
            <h3 class="couponpop__title">Product Coupon<span class="js__coupon__fold couponpop__fold-icon">접기버튼</span></h3>
            <table class="coupon-box table-default js__coupon__fold-target">
                <colgroup>
                    <col width="24%">
                    <col width="10%">
                    <col width="30%">
                    <col width="14%">
                    <col width="16%">
                    <col width="*">
                </colgroup>
                <thead>
                    <th>Item Name/Option</th>
                    <th>Quantities of order</th>
                    <th>Coupon Selection</th>
                    <th>Subtotal</th>
                    <th>Coupon used amount</th>
                    <th></th>
                </thead>
                <tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_setData_2=empty($TPL_V1["setData"])||!is_array($TPL_V1["setData"])?0:count($TPL_V1["setData"]);
$TPL_couponList_2=empty($TPL_V1["couponList"])||!is_array($TPL_V1["couponList"])?0:count($TPL_V1["couponList"]);?>
                    <tr class="js__coupon__target">
                        <td>
                            <p class="tit"><?php if($TPL_V1["brand_name"]){?>[<?php echo $TPL_V1["brand_name"]?>] <?php }?><?php echo $TPL_V1["pname"]?></p>
<?php if($TPL_V1["set_group"]> 0){?>
<?php if($TPL_setData_2){foreach($TPL_V1["setData"] as $TPL_V2){?>
                            <p class="option"><?php echo $TPL_V2["options_text"]?></p>
<?php }}?>
<?php }else{?>                            <p class="option"><?php echo $TPL_V1["options_text"]?></p>
<?php }?>
                        </td>
                        <td><em><?php echo $TPL_V1["pcount"]?></em>ltem(s)</td>
                        <td>
                            <select devCouponSelect="<?php echo $TPL_V1["cart_ix"]?>">
                                <option value="">Select</optoin>
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
                            <span devCartOverlapNoText="<?php echo $TPL_V1["cart_ix"]?>" style="color:red;display:none;">Cart coupon is not applicable</span>
                        </td>
                        <td>
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                        </td>
                        <td class="price">
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><em devTotalCouponWithDcpriceText="<?php echo $TPL_V1["cart_ix"]?>">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                            <p>(-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devDiscountAmountText="<?php echo $TPL_V1["cart_ix"]?>">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?> Sale)</p>
                        </td>
                        <td class="coupon-box__choice-cancel">
                            <a href="#" class="js__coupon__cancel">Cancel</a>
                        </td>
                    </tr>
<?php }}?>
                </tbody>
            </table>
        </section>
        <section class="couponpop__cart">
            <h3 class="couponpop__title">shopping card coupon<span class="js__coupon__fold couponpop__fold-icon">접기버튼</span></h3>
            <dl class="couponpop__cart__inner js__coupon__fold-target" >
                <dt class="couponpop__cart__title">Coupon Selection</dt>
                <dd class="couponpop__cart__select js__coupon__target">
                    <select devCartCouponSelect>
                        <option value="">Select</option>
<?php if($TPL_cartCouponList_1){foreach($TPL_VAR["cartCouponList"] as $TPL_V1){?>
<?php if($TPL_V1["activeBool"]){?>
                        <option value="<?php echo $TPL_V1["regist_ix"]?>"
                                devTotalCouponWithDcprice="<?php echo $TPL_V1["total_coupon_with_dcprice"]?>"
                                devDiscountAmount="<?php echo $TPL_V1["discount_amount"]?>"
<?php if($TPL_V1["isSelected"]){?>selected<?php }?>><?php echo $TPL_V1["publish_name"]?></option>
<?php }?>
<?php }}?>
                    </select>
                    <button type="button" class="js__coupon__cancel couponpop__cancel devCouponCancel">취소</button>
                </dd>
            </dl>
        </section>
        <section class="couponpop__summary">
            <h3 class="fb__title--hidden">요약본</h3>
            <dl class="couponpop__summary__each">
                <dt class="couponpop__summary__title">Item Total</dt>
                <input type="hidden" id="devSelectedCartCouponIx" value="<?php echo $TPL_VAR["selectedCartCouponIx"]?>" />
                <input type="hidden" id="devTotalProductDcprice" value="<?php echo $TPL_VAR["totalProductDcprice"]?>" />
                <dd class="couponpop__summary__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["totalProductDcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="couponpop__summary__each">
                <dt class="couponpop__summary__title">Coupons-discount</dt>
                <dd class="couponpop__summary__price"><span id='tot_discount'>-</span><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponDiscountAmount">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="couponpop__summary__bottom">
                <input type="hidden" id="devTotalCouponWithProductDcpriceFloat" value="<?php echo $TPL_VAR["productDcprice"]?>" />
                <dt class="couponpop__summary__title--big">Total coupon application amount</dt>
                <dd class="couponpop__summary__price--point"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devTotalCouponWithProductDcprice"><?php echo g_price($TPL_VAR["productDcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
        </section>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" id="devCouponCancelButton">Cancel</button>
            <button class="btn-default btn-dark" id="devApplyCouponButton">
<?php if($TPL_VAR["langType"]=='korean'){?>
                Valid Coupons
<?php }else{?>
                Apply
<?php }?>
            </button>
        </div>
<?php }?>
    </div>
</section>