<?php /* Template_ 2.2.8 2020/11/09 15:19:16 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_detail/order_detail.htm 000025319 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<!-- crema load -->
<script>
    var crema_userId = null;
    var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
    crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
    crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>";
<?php }?>

    window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
        //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
        crema.init(crema_userId, crema_userNm);
        //console.log("[CREMA] crema.init() - EXECUTED!");
    };

    (function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<section class="br__order-detail" id="orderDetail">
    <h2 class="br__order-detail__title">Order Detail</h2>
    <section class="br__odhistory__each order-detail" id="devOrderDetailContent">
        <div class="odeach">
            <header class="odeach__top ">
                <h3 class="br__hidden">Your Orders</h3>
                <p class="odeach__top__text">Order Date <span><?php echo $TPL_VAR["order"]["order_date"]?></span></p>
                <p class="odeach__top__text">Order No. <span><?php echo $TPL_VAR["order"]["oid"]?></span></p>
            </header>
            <div class="order-detail__goods">
                <h3 class="br__hidden">Order Information</h3>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <ul class="odeach__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
                    <li class="odeach__item">
                        <div class="odeach__item__inner">
                            <figure class="odeach__item__thumb">
                                <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                    <img src="<?php echo $TPL_V2["pimg"]?>">
                                </a>
                            </figure>
                            <div class="odeach__item__info"><!--contents-->
                                <p class="odeach__item__title">
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
                                </p>
<?php if($TPL_V2["add_info"]){?>
                                <p class="odeach__item__option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
<?php if($TPL_V2["set_group"]> 0){?>                                <span class="odeach__item__option odeach__item__option--add">
<?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
                                            <?php echo $TPL_V3["option_text"]?>

<?php }}?>
                                        / Quantities&nbsp;<?php echo $TPL_V2["pcnt"]?>ltem(s)
                                </span>
<?php }else{?>                                <p class="odeach__item__option"><?php echo $TPL_V2["option_text"]?> / Quantities&nbsp;<?php echo $TPL_V2["pcnt"]?>ltem(s)</p>
<?php }?>

                                <div class="odeach__item__bottom">
                                    <span class="odeach__item__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
                                    <!-- <?php echo g_price($TPL_V2["pt_dcprice"])?> -->
                                    <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="odeach__btn odeach__btn--each">

<?php if($TPL_V2["isDeliveryIng"]){?>                            <button class="odeach__btn--wt devDeliveryTrace" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">Tracking</button>
                            <button class="odeach__btn--bk devOrderComplateBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Out for delivery</button>
<?php }?>

<?php if($TPL_V2["isDeliveryComplate"]){?>                            <!--<button class="odeach__btn&#45;&#45;wt devOrderExchangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Request Exchange</button>-->
                            <button class="odeach__btn--wt devOrderReturnBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Request Return</button>
                            <button class="odeach__btn--wt devDeliveryTrace" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">Tracking</button>
                            <button class="odeach__btn--bk odeach__btn--all devBuyFinalizedBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Order accepted</button>
<?php }?>

<?php if($TPL_V2["isByFinalized"]){?>                            <?php if($TPL_V2["quick"]&&$TPL_V2["invoice_no"]){?>
                            <!--<button class="odeach__btn--wt devDeliveryTrace" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">Tracking</button>-->

                            <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">Tracking</button>
<?php }?>
<?php if(is_login()){?>

<?php if($TPL_VAR["langType"]=='korean'){?>
                            <a class="crema-new-review-link odeach__btn--bk" data-product-code="<?php echo $TPL_V2["co_no"]?>" widget-id="100" >Write a review</a>
<?php }else{?>
<?php if(false){?>
                                <button class="odeach__btn--bk devByFinalized" data-pid="<?php echo $TPL_V2["pid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Write a review</button>
<?php }?>
<?php }?>
<?php }?>
<?php }?>
                        </div>
                    </li>
<?php if($TPL_V2["product_gift"]){?>
                    <div class="odeach__gift product-gift-wrap">
                        <h4 class="odeach__gift__title">GIft <span>Gift Title</span></h4>
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                        <div class="odeach__gift__inner inner-gift order_list_gift" id="devPgItem">
                            <figure class="odeach__gift__thumb img">
                                <img src="<?php echo $TPL_V3["image_src"]?>" alt="">
                            </figure>
                            <div class="odeach__gift__info">
                                <p class="odeach__gift__name"><?php echo $TPL_V3["pname"]?></p>
                                <span class="odeach__gift__option"><em>/1ltem(s)</em></span>
                            </div>
                        </div>
<?php }}?>
                    </div>
<?php }?>
<?php }}?>
                </ul>
<?php }}?>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
                <div class="odeach__gift-buyprice">
                    <h3 class="odeach__gift-buyprice__title"></h3>
                    <div class="odeach__gift product-gift-wrap">
                        <h4 class="odeach__gift__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></h4>
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <div class="odeach__gift__inner inner-gift order_list_gift" id="devPgItem">
                            <figure class="odeach__gift__thumb img">
                                <img src="<?php echo $TPL_V2["image_src"]?>" alt="">
                            </figure>
                            <div class="odeach__gift__info">
                                <p class="odeach__gift__name"><?php echo $TPL_V2["pname"]?></p>
                                <span class="odeach__gift__option"><em>/<?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                            </div>
                        </div>
<?php }}?>
                    </div>
                </div>
<?php }?>
<?php }}?>
<?php }?>
                <!--주문별 전체버튼-->
                <div class="odeach__btn odeach__btn--all">
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
                    <button class="odeach__btn--bk devOrderCancelAllBtn orderDetail_infi all_cancel" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">
                        Cancel Order
                    </button>
<?php }?>
                </div>
            </div>
        </div>
        <!---->
        <!---->
        <!-- 1-->
        <div class="wrap-sect"></div>

        <!-- [S] 배송지 정보 -->
        <section class="order-detail__wrap">
            <h3 class="order-detail__wrap__title">Shipping Information</h3>
<?php if($TPL_VAR["order"]["deliveryChange"]> 0){?>
            <button class="order-detail__wrap__btn devDeliveryChange" id="devDeliveryChangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-member="<?php echo $TPL_VAR["nonMemberOid"]?>">To change</button>
<?php }?>
            <div class="order-addr">
                <dl class="order-addr__info">
                    <dt class="order-addr__info__title">Name</dt>
                    <dd class="order-addr__info__text"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?> <span>(Basic)</span></dd>
                    <dt class="order-addr__info__title">Address</dt>
                    <dd class="order-addr__info__text">
<?php if($TPL_VAR["deliveryInfo"]["country_full"]){?>country : <?php echo $TPL_VAR["deliveryInfo"]["country_full"]?> <br> <?php }?>
                        [<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>] <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?> <br><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?> <br>
<?php if($TPL_VAR["deliveryInfo"]["city"]){?>city : <?php echo $TPL_VAR["deliveryInfo"]["city"]?> <br><?php }?>
<?php if($TPL_VAR["deliveryInfo"]["state"]){?>state: <?php echo $TPL_VAR["deliveryInfo"]["state"]?><?php }?>
                    </dd>
                    <dt class="order-addr__info__title">Tel</dt>
                    <dd class="order-addr__info__text"><?php echo $TPL_VAR["deliveryInfo"]["rmobile"]?></dd>
                    <!--<dt class="order-addr__info__title">전화번호</dt>-->
                    <!--<dd class="order-addr__info__text"><?php echo $TPL_VAR["deliveryInfo"]["rtel"]?></dd>-->
                </dl>
                <dl class="order-addr__name">
                    <dt class="order-addr__name__title">Name</dt>
                    <dd class="order-addr__name__text"><?php echo $TPL_VAR["order"]["bname"]?></dd>
                </dl>
            </div>

        </section>
        <!-- [E] 배송지 정보 -->
        <div class="wrap-sect"></div>

        <!-- 배송요청사항 -->
        <section class="order-detail__wrap">
            <h3 class="order-detail__wrap__title">Shipping comment</h3>
<?php if(false&&$TPL_VAR["order"]["status"]==(ORDER_STATUS_INCOM_READY||$TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE)){?>
            <button class="order-detail__wrap__btn" id="devDeliveryRequestChangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">To change</button>
<?php }?>
            <div class="order-request">
                <p class="order-request__desc">
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]!=''){?>
                    <span><?php echo $TPL_V1["msg"]?></span>
<?php }else{?>
                    <span>-</span>
<?php }?>
<?php }}?>
                </p>
            </div>
        </section>

        <div class="wrap-sect"></div>

              <!-- [S] 주문결제정보 -->
        <section class="order-detail__wrap">
            <h3 class="order-detail__wrap__title">order payment information</h3>
            <div class="order-payment">
                <div class="order-payment__wrap">
                    <p class="order-payment__title">Payment Method</p>
                    <dl class="order-payment__list">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["method"]==ORDER_METHOD_BANK||$TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE){?>
                        <dt class="order-payment__list__title"><?php echo $TPL_V1["method_text"]?></dt>
                        <dd class="order-payment__list__text order-payment__list__text--point"><?php echo $TPL_V1["vb_info"]?></dd>
                        <dt class="order-payment__list__title">Bank</dt>
                        <dd class="order-payment__list__text"><?php echo $TPL_V1["bank"]?></dd>
                        <dt class="order-payment__list__title">account holder</dt>
                        <dd class="order-payment__list__text"><?php echo $TPL_V1["bank_input_name"]?></dd>
                        <dt class="order-payment__list__title">Account number</dt>
                        <dd class="order-payment__list__text"><?php echo $TPL_V1["bank_account_num"]?></dd>
<?php }else{?>
                        <dt class="order-payment__list__title"><?php echo $TPL_V1["method_text"]?></dt>
                        <dd class="order-payment__list__text order-payment__text--point"><?php echo $TPL_V1["memo"]?></dd>
<?php }?>
<?php }}?>
                    </dl>

                    <!-- 참고용 -->
                    <div class="section" style="display:none;">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                        <div class="top-area clearfix">
                            <h2 class="float-l">Payment Method</h2>
                            <p class="float-r"><?php echo $TPL_V1["method_text"]?></p>
                        </div>

                        <div class="content">
<?php if($TPL_V1["method"]==ORDER_METHOD_BANK||$TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE){?>
                            <p><?php echo $TPL_V1["vb_info"]?><?php if($TPL_V1["bank_input_name"]!=''){?>(Account Holder:<?php echo $TPL_V1["bank_input_name"]?>)<?php }?></p>
                            <p><em><?php echo $TPL_V1["bank"]?> <?php echo $TPL_V1["bank_account_num"]?></em></p>
                            <p class="deadline">deadline for the deposit <em><?php echo date('Y-m-d',strtotime($TPL_V1["bank_input_date"]))?></em></p>
<?php }else{?>
                            <p><?php echo $TPL_V1["memo"]?></p>
<?php }?>
                        </div>
<?php }}?>
                    </div>
                </div>
                <div class="order-payment__wrap">
                    <p class="order-payment__title">reward <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["paymentInfo"]["total_reserve"])?><?php echo $TPL_VAR["fbUnit"]["b"]?>$</span></p>
                </div>
                <div class="order-payment__wrap">
                    <p class="order-payment__title">order payment</p>
                    <dl class="order-payment__list tooltip__wrap">
                        <dt class="order-payment__list__title">Total price</dt>
                        <dd class="order-payment__list__text"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        <dt class="order-payment__list__title">shipping fee</dt>
                        <dd class="order-payment__list__text"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["order"]["delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        <dt class="order-payment__list__title">
                            <span>Savings</span>
                            <span class="order-payment__list__tooltip tooltip__icon">느낌표아이콘</span>
                        </dt>
                        <dd class="tooltip__layer">
                            <h4 class="tooltip__layer__title">Savings</h4>
                            <span class="tooltip__layer__close">닫기 버튼</span>
                            <dl>
                                <dt>Item-discount</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Membership-discount</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["mg_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Coupons</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl class="tooltip__layer__total">
                                <dt>Savings</dt>
                                <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"]+$TPL_VAR["paymentInfo"]["mg_dc"]+$TPL_VAR["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                        </dd>
                        <dd class="order-payment__list__text">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"]+$TPL_VAR["paymentInfo"]["mg_dc"]+$TPL_VAR["paymentInfo"]["cp_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>

                        <dt class="order-payment__list__title">Use reward</dt>
                        <dd class="order-payment__list__text">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
                <div class="order-payment__wrap order-payment__wrap--total">
                    <p class="order-payment__title"><?php if($TPL_VAR["order"]["status"]=='IR'){?>Estimated Total<?php }else{?>Total<?php }?> <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["paymentInfo"]["payment"][ 0]["payment_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span></p>
                </div>

<?php if(is_login()){?>
<?php if($TPL_VAR["langType"]=='korean'&&$TPL_VAR["order"]["status"]!='IR'){?>
                <div class="order-detail__btn__wrap">
                    <button class="order-detail__btn order-detail__btn--type1  order-detail__btn--full receipt-btn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" >Payment Receipt</button>
                </div>
<?php }?>
<?php if($TPL_VAR["claimData"]["cancelData"]&&$TPL_VAR["claimData"]["returnData"]){?>
                <div class="order-detail__btn__wrap">
                    <button class="order-detail__btn order-detail__btn--type1 cancelBtn" >Cancel & Refund History</button>
                    <button class="order-detail__btn order-detail__btn--type1 bringBackBtn" >Return & Refund History</button>
                </div>
<?php }else{?>
<?php if($TPL_VAR["claimData"]["cancelData"]){?>
                    <div class="order-detail__btn__wrap">
                        <button class="order-detail__btn order-detail__btn--type1 order-detail__btn--full cancelBtn" >Cancel & Refund History</button>
                    </div>
<?php }?>
<?php if($TPL_VAR["claimData"]["returnData"]){?>
                    <div class="order-detail__btn__wrap">
                        <button class="order-detail__btn order-detail__btn--type1 order-detail__btn--full bringBackBtn" >Return & Refund History</button>
                    </div>
<?php }?>
<?php }?>
<?php }?>
            </div>
        </section>

        <div class="wrap-sect"></div>

        <div class="order-detail__btn__wrap">
            <a href="/" class="order-detail__btn order-detail__btn--type1">Main</a>
            <a href="/mypage/orderHistory" class="order-detail__btn order-detail__btn--type2">List</a>
        </div>
    </section>

</section>

<?php if($TPL_VAR["claimData"]["cancelData"]){?>
<section class="br__order-detail" id="orderCancel">
    <h2 class="br__order-detail__title">Cancel & Refund History</h2>

    <div class="order-detail__refund">
<?php if(is_array($TPL_R1=$TPL_VAR["claimData"]["cancelData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
        <div class="order-detail__refund__goods">
            <dl>
                <dt>items for cancellation</dt>
                <dd><?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?> <?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>]<?php }?><?php echo $TPL_V2["pname"]?> <br><?php }}?></dd>
            </dl>
        </div>
        <div class="order-detail__refund__amount">
            <dl>
                <dt>Total Refund Amount</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["totReturnPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                <dt>Refund Processing Date</dt>
                <dd><?php echo $TPL_V1["refundDate"]?></dd>
            </dl>
        </div>
<?php }}?>
    </div>
</section>
<?php }?>

<?php if($TPL_VAR["claimMergedData"]["returnData"]){?>
<section class="br__order-detail" id="orderReturn">
    <h2 class="br__order-detail__title">Return & Refund History</h2>

    <div class="order-detail__refund">
<?php if(is_array($TPL_R1=$TPL_VAR["claimMergedData"]["returnData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
        <div class="order-detail__refund__goods">
            <dl>
                <dt>Refund cancellation products</dt>
                <dd><?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?> <?php if($TPL_V2["brand_name"]){?>[<?php echo $TPL_V2["brand_name"]?>]<?php }?><?php echo $TPL_V2["pname"]?> <br><?php }}?></dd>
            </dl>
        </div>
        <div class="order-detail__refund__amount">
            <dl>
                <dt>Total Refund Amount</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["totReturnPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                <dt>Refund Processing Date</dt>
                <dd><?php echo $TPL_V1["refundDate"]?></dd>
            </dl>
        </div>
<?php }}?>
    </div>
</section>
<?php }?>

<script>

    function changeViewOrder() {
        if (window.location.hash == '#returnHistory') {
            $('#orderDetail').hide();
            $('#orderReturn').hide();
            $('#orderCancel').show();
        } else if (window.location.hash == '#returnHistoryV2') {
            $('#orderDetail').hide();
            $('#orderCancel').hide();
            $('#orderReturn').show();
        }
        else {
            $('#orderCancel, #orderReturn').hide();
            $('#orderDetail').show();
        }
        $(window).scrollTop(0);
        $('#header, .br__dockbar, .br__floating-btn').css({
            'margin-top' : '',
            'margin-bottom' : ''
        });

    }

    $('.cancelBtn').click(function () {
        window.location.hash = 'returnHistory';
    });

    $('.bringBackBtn').click(function () {
        window.location.hash = 'returnHistoryV2';
    });
    $(window).on('hashchange', function () {
        changeViewOrder();
    });
    $(document).ready(function(){
        changeViewOrder();
    });


        // 배송추적
        $(document).on('click', '.devInvoice', function () {
            var url = '/mypage/searchGoodsFlow/' + $(this).data('quick') + '/' + $(this).data('invoice_no');

            common.util.iframeModal.open('배송추적', url);
            //window.open(url);

        });
</script>