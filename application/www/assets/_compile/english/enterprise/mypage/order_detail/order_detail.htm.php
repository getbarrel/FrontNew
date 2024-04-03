<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_detail/order_detail.htm 000027221 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
<script>var orderDetailMode = 'member';</script>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }else{?>
<script>var orderDetailMode = 'guest';</script>
<?php }?>

<div class="fb__od-detail wrap-mypage wrap-order-detail" id="devOrderDetailContent">
    <section>
        <h2 class="fb__mypage__title">Order Detail</h2>
        <!--취소교환반품 신청내역조회일 때-->
        <header class="order-number-box">
            <span class="tit">Order No.</span>
            <span class="order-num"><?php echo $TPL_VAR["order"]["oid"]?></span>
            <span class="tit">Order Date</span>
            <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
            <button type="button" class="btn-xs btn-dark-line mal10 devOrderCancelAllBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">Cancel Order</button>
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'&&$TPL_VAR["order"]["status"]!='IR'){?>
            <button class="fb__mypage__btn--black receipt-btn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">Print receipt</button>
<?php }?>
        </header>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="80px"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
                <th>Item Name/Option</th>
                <th>Quantities of order</th>
                <th>Subtotal</th>
                <th>Savings</th>
                <th>Estimated Total</th>
                <th>Order Status</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
<?php if($TPL_V2["set_group"]> 0){?>
                <!--@TODO 세트상품은 일반상품처럼 나옵니다-->
                <tr class="set-product">
                    <td colspan="6">
<?php if(is_array($TPL_R3=$TPL_V2["setData"])&&!empty($TPL_R3)){$TPL_I3=-1;foreach($TPL_R3 as $TPL_V3){$TPL_I3++;?><?php if($TPL_I3== 0){?>
                        <table class="inner-set">
                            <colgroup>
                                <col width="*"/>
                                <col width="80px"/>
                                <col width="100px"/>
                                <col width="100px"/>
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
                                            <p class="option"><?php echo $TPL_V3["add_info"]?></p>
                                        </div>
                                    </a>
                                </td>
                                <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                                <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                                <td>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php if($TPL_V2["total_dc"]> 0){?>
                                    <span class="tooltip">
                                        <div class="tooltip-layer">
                                            <dl>
                                                <dt>Item-discount</dt>
                                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["dr_dc"]+$TPL_V2["gp_dc"]+$TPL_V2["sp_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                            </dl>
                                            <dl>
                                                <dt>Membership-discount</dt>
                                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["mg_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                            </dl>
                                            <dl>
                                                <dt>Coupons</dt>
                                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["cp_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                            </dl>
                                            <dl class="total">
                                                <dt>Savings</dt>
                                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["total_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                            </dl>
                                        </div>
                                    </span>
<?php }?>
                                </td>
                                <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
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
                                            <p class="option"><?php echo $TPL_V3["add_info"]?></p>
                                        </div>
                                    </a>
                                </td>
                                <td><em><?php echo $TPL_V3["pcnt"]?></em>개</td>
                                <td></td>
                                <td></td>
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
                    <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                    <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    <td>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php if($TPL_V2["total_dc"]> 0){?>
                        <span class="tooltip">
                            <div class="tooltip-layer">
                                 <dl>
                                    <dt>Item-discount</dt>
                                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["dr_dc"]+$TPL_V2["gp_dc"]+$TPL_V2["sp_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                </dl>
                                <dl>
                                    <dt>Membership-discount</dt>
                                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["mg_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                </dl>
                                <dl>
                                    <dt>Coupons</dt>
                                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["cp_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                </dl>
                                <dl class="total">
                                    <dt>Savings</dt>
                                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V2["total_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                                </dl>
                            </div>
                        </span>
<?php }?>
                    </td>
                    <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                    <td>
                        <p><?php echo $TPL_V2["status_text"]?></p>
<?php if($TPL_V2["refund_status"]){?><p><?php echo $TPL_V2["refund_status_text"]?></p><?php }?>
                    </td>
                </tr>
<?php }?>
<?php if($TPL_V2["product_gift"]){?>
                <tr class="product-gift__wrap">
                    <td colspan="6">
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
            <span>Shipping fee <em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?><?php echo $TPL_VAR["fbUnit"]["b"]?></em> (<?php echo $TPL_VAR["order"]["deliveryPricePolicyText"][$TPL_K1]?>)</span>
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
        <h2 class="fb__mypage__title">Order Payment History</h2>
        <div class="order-payment-list">
            <div class="section">
                <div class="sec">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php switch($TPL_V1["method"]){case ORDER_METHOD_BANK:case ORDER_METHOD_VBANK:case ORDER_METHOD_ICHE:?>
                    <h2>Payment Method</h2>
                    <p class="tit"><?php echo $TPL_V1["method_text"]?></p>
                    <dl>
                        <dt>Bank</dt>
                        <dd><?php echo $TPL_V1["bank"]?></dd>
                    </dl>
                    <dl>
                        <dt>account holder</dt>
                        <dd><?php echo $TPL_V1["bank_input_name"]?></dd>
                    </dl>
                    <dl>
                        <dt>Account number</dt>
                        <dd><?php echo $TPL_V1["bank_account_num"]?></dd>
                    </dl>
                    <dl>
                        <dt>deadline for the deposit</dt>
                        <dd><?php echo date('Y-m-d',strtotime($TPL_V1["bank_input_date"]))?></dd>
                    </dl>
<?php break;default:?>
                    <h2>Payment Method</h2>
                    <dl>
                        <dt><?php echo $TPL_V1["method_text"]?></dt>
                        <dd><?php echo $TPL_V1["memo"]?></dd>
                    </dl>
<?php }?>
<?php }}?>
                </div>

                <div class="sec">
                    <h2>Expected reward</h2>
                    <p><?php echo $TPL_VAR["fbUnit"]["f"]?> <?php echo g_price($TPL_VAR["paymentInfo"]["total_reserve"])?> <?php echo $TPL_VAR["fbUnit"]["b"]?>Reward (Purcahsing a product)</p>
                </div>
            </div>
            <div class="section price">
                <dl>
                    <dt>Item Total</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl>
                    <dt>Savings</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="disc-list">
                    <dt>Item-discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="disc-list">
                    <dt>Membership-discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["mg_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="disc-list">
                    <dt>Coupons</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl>
                    <dt>Mileage</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="mat10">
                    <dt>Shipping</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="total-price">
                    <dt>
<?php if($TPL_VAR["order"]["status"]=='IR'){?>
                        Estimated Total
<?php }else{?>
                        Total
<?php }?>
                    </dt>
                    <dd class="point-color"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["payment"][ 0]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
    </section>

<?php if($TPL_VAR["claimData"]["cancelData"]){?><!--취소완료이면-->
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Cancel & Refund History</h2>
        <table class="table-default refund-table">
            <colgroup>
                <col width="*">
                <!-- <col width="155px">
                <col width="145px"> -->
                <col width="145px">
                <col width="145px">
            </colgroup>
            <thead>
            <th>items for cancellation</th>
            <!--<th>주문취소 상품 총 금액</th>
            <th>주문취소 배송비</th> -->
            <th>Total Refund Amount</th>
            <th>Refund Processing Date</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["claimData"]["cancelData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <tr>
                <td class="product">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["brand_name"]){?>
                            [<?php echo $TPL_V2["brand_name"]?>]
<?php }?>
                        <?php echo $TPL_V2["pname"]?> <br>
<?php }}?>
                </td>
                <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["totReturnPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                <td><em><?php echo $TPL_V1["refundDate"]?></em></td>
            </tr>
<?php }}?>
            </tbody>
        </table>
    </section>
<?php }?>

<?php if($TPL_VAR["claimMergedData"]["returnData"]){?> <!--반품완료-->
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Return & Refund History</h2>
        <table class="table-default refund-table">
            <colgroup>
                <col width="*">
                <!--<col width="155px">
                <col width="145px">-->
                <col width="145px">
                <col width="160px">
            </colgroup>
            <thead>
            <th>Product name for return</th>
            <!--<th>반품신청 상품 총 금액</th>
            <th>반품 배송비</th>-->
            <th>Total Refund Amount</th>
            <th>Refund Processing Date</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["claimMergedData"]["returnData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <tr>
                <td class="product">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["brand_name"]){?>
                            [<?php echo $TPL_V2["brand_name"]?>]
<?php }?>
                        <?php echo $TPL_V2["pname"]?> <br>
<?php }}?>
                </td>
                <td><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["totReturnPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                <td><em><?php echo $TPL_V1["refundDate"]?></em></td>
            </tr>
<?php }}?>
            </tbody>
        </table>
    </section>
<?php }?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title clearfix">
            Shipping Information
<?php if($TPL_VAR["order"]["deliveryChange"]> 0){?>
            <button class="fb__mypage__btn--lightgray float-r address-link" id="devDeliveryChangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">Change shipping address</button>
<?php }?>
        </h2>

        <table class="fb__mypage__odtable--border join-table type02 shipping-info-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tr>
                <th>Name</th>
                <td><span id="devRnameTxt"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?></span></td>
            </tr>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <tr>
                <th>Address</th>
                <td>
                    <p><span id="devZipTxt"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span></p>
                    <p><span id="devAddr1Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span> <span id="devAddr2Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span></p>
                </td>
            </tr>
            <tr>
                <th>Tel</th>
                <td><span id="devRmobileTxt"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></span></td>
            </tr>
            <tr>
                <th>Tel</th>
                <td><span id="devRtelTxt"><?php echo $TPL_VAR["deliveryInfo"]["rtel"]?></span></td>
            </tr>
<?php }else{?>
            <tr>
                <th>Country</th>
                <td><span id=""><?php echo $TPL_VAR["deliveryInfo"]["country_full"]?></span></td>
            </tr>
            <tr>
                <th>Zip/Postal Code</th>
                <td><p><span id="devZipTxt"><?php echo $TPL_VAR["deliveryInfo"]["zip"]?></span></p></td>
            </tr>
            <tr>
                <th>Address line 1</th>
                <td><span id="devAddr1Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr1"]?></span></td>
            </tr>
            <tr>
                <th>Address line 2</th>
                <td><span id="devAddr2Txt"><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?></span></td>
            </tr>
            <tr>
                <th>City</th>
                <td><span><?php echo $TPL_VAR["deliveryInfo"]["city"]?></span></td>
            </tr>
            <tr>
                <th>State/Province
                </th>
                <td><span><?php echo $TPL_VAR["deliveryInfo"]["state"]?></td>
            </tr>
<?php }?>

            <tr>
                <th>Shipping comment</th>
                <td class="request">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
                    <div <?php if($TPL_I1> 0&&$TPL_VAR["deliveryInfo"]["pcnt"]> 5){?>class="section devDeliveryMsgBox" style="display:none"<?php }else{?>class="section"<?php }?>>
<?php if($TPL_VAR["deliveryInfo"]["pcnt"]> 1){?><p class="product"><?php if($TPL_V1["brand_name"]){?>[<?php echo $TPL_V1["brand_name"]?>]<?php }?><?php echo $TPL_V1["pname"]?></p><?php }?>
                        <p id="devDeliveryMsgText<?php echo $TPL_V1["msg_ix"]?>"><?php echo $TPL_V1["msg"]?></p>
<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_READY||$TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <div class="mat10">
                            <input type="text" class="devDeliveryMsgInputBox" id="devDeliveryMsg<?php echo $TPL_V1["msg_ix"]?>" maxlength="30" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" />
<?php if(false){?>
                            <button class="btn-default btn-dark-line devDeliveryMsgModifyBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>">Change request</button>
<?php }?>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error" style="display:none;">Please enter your request</em>
                                <span><em id="devMsgLength<?php echo $TPL_V1["msg_ix"]?>">0</em>/30 자</span>
                            </div>
                        </div>
<?php }else{?>
                        <div class="mat10">
                            <input type="text" class="devDeliveryMsgInputBox" id="devDeliveryMsg<?php echo $TPL_V1["msg_ix"]?>" maxlength="60" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" />
<?php if(false){?>
                            <button class="btn-default btn-dark-line devDeliveryMsgModifyBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-msgix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>">Change request</button>
<?php }?>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error" style="display:none;">Please enter your request</em>
                                <span><em id="devMsgLength<?php echo $TPL_V1["msg_ix"]?>">0</em>/60 byte</span>
                            </div>
                        </div>
<?php }?>

<?php }?>
                    </div>
<?php if($TPL_VAR["deliveryInfo"]["msg_type"]=='P'&&$TPL_VAR["deliveryInfo"]["pcnt"]> 5&&$TPL_I1== 0){?>
                    <div class="section more-btn toggle" id="devDeliveryMsgMoreBtn">
                        <span>View more</span>
                    </div>
<?php }?>
<?php }}?>
                </td>
            </tr>
        </table>
    </section>

    <div class="wrap-btn-area">
        <button class="btn-lg btn-dark" onclick="parent.history.back(-1);">Previous</button>
    </div>
</div>