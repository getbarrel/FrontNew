<?php /* Template_ 2.2.8 2020/11/09 14:47:57 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/index/index.htm 000022105 */ 
$TPL_order_data_1=empty($TPL_VAR["order_data"])||!is_array($TPL_VAR["order_data"])?0:count($TPL_VAR["order_data"]);
$TPL_historyList_1=empty($TPL_VAR["historyList"])||!is_array($TPL_VAR["historyList"])?0:count($TPL_VAR["historyList"]);
$TPL_wishList_1=empty($TPL_VAR["wishList"])||!is_array($TPL_VAR["wishList"])?0:count($TPL_VAR["wishList"]);
$TPL_cartList_1=empty($TPL_VAR["cartList"])||!is_array($TPL_VAR["cartList"])?0:count($TPL_VAR["cartList"]);?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


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
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/init.js');
    
</script>

<div class="fb__mypage wrap-mypage">
    <section class="fb__mypage__shortcut">
        <!---->
        <h2 class="fb__mypage__title">Menu</h2>
        <div class="shortcut">
            <ul class="shortcut__flex">
                <li class="shortcut__each">
                    <a href="/mypage/orderHistory">
                        <span class="shortcut__each__icon--order">아이콘</span>
                        <p>
                            Your Orders
                        </p>
                    </a>
                </li>
                <li class="shortcut__each">
                    <a href="/mypage/returnHistory">
                        <span class="shortcut__each__icon--claim">아이콘</span>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <p>Return/Cancellation</p>
<?php }else{?>
                        <p>Return<br>Cancellation</p>
<?php }?>
                    </a>
                </li>
                <li class="shortcut__each">
                    <a href="/mypage/profile">
                        <span class="shortcut__each__icon--myinfo">아이콘</span>
                        <p>
                            My Account
                        </p>
                    </a>
                </li>
                <!--<li class="shortcut__each">
                    <a href="/mypage/stockAlarm">
                        <span class="shortcut__each__icon&#45;&#45;alarm">아이콘</span>
                        <p>
                            Restock Notification breakdown
                        </p>
                    </a>
                </li>
                <li class="shortcut__each">
                    <a href="/mypage/myInquiry">
                        <span class="shortcut__each__icon&#45;&#45;inquiry">아이콘</span>
                        <p>
                            1:1 Inquiry
                        </p>
                    </a>
                </li>-->
            </ul>
        </div>
    </section>
    <section>
        <h2 class="fb__mypage__title">Order Status</h2>
        <div class="fb__mypage__overview">
            <ul class="fb__mypage__overview-list">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="devOrderStatusCnt" data-status="<?php echo ORDER_STATUS_INCOM_READY?>">
                    <em class="my-order__seq__count <?php if(g_price($TPL_VAR["incom_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></em>
                    <p>Ordered</p>
                </li>
<?php }?>
                <li class="devOrderStatusCnt" data-status="<?php echo ORDER_STATUS_INCOM_COMPLETE?>">
                    <em class="my-order__seq__count <?php if(g_price($TPL_VAR["incom_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></em>
                    <p>Ordered</p>
                </li>
                <li class="devOrderStatusCnt" data-status="<?php echo ORDER_STATUS_DELIVERY_READY?>">
                    <em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></em>
                    <p>Preparing</p>
                </li>
                <li class="devOrderStatusCnt" data-status="<?php echo ORDER_STATUS_DELIVERY_ING?>">
                    <em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_ing_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></em>
                    <p>Shipped</p>
                </li>
                <li class="devOrderStatusCnt" data-status="<?php echo ORDER_STATUS_DELIVERY_COMPLETE?>">
                    <em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></em>
                    <p>Out for delivery</p>
                </li>
            </ul>
            <div class="fb__mypage__overview-claim">
                <dl class="devReturnStatusCnt" data-status="<?php echo ORDER_STATUS_CANCEL_APPLY?>" class="my-order__seq__link">
                    <dt class="my-order__seq__kind">Cancel Order</dt>
                    <dd class="my-order__seq__count <?php if(g_price($TPL_VAR["cancel_apply_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["cancel_apply_cnt"])?></dd>
                </dl>
                <!--<dl class="devReturnStatusCnt" data-status="<?php echo ORDER_STATUS_EXCHANGE_APPLY?>">-->
                    <!--<dt>Request Exchange</dt>-->
                    <!--<dd class="my-order__seq__count <?php if(g_price($TPL_VAR["exchange_apply_cnt"])> 0){?> my-order__seq__count&#45;&#45;point<?php }?>"><?php echo number_format($TPL_VAR["exchange_apply_cnt"])?></dd>-->
                <!--</dl>-->
                <dl class="devReturnStatusCnt" data-status="<?php echo ORDER_STATUS_RETURN_APPLY?>">
                    <dt>Request Return</dt>
                    <dd class="my-order__seq__count <?php if(g_price($TPL_VAR["return_apply_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["return_apply_cnt"])?></dd>
                </dl>
            </div>
        </div>
    </section>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Recent Orders</h2>
<?php if($TPL_VAR["order_data"]&&!empty($TPL_VAR["order_data"])){?>
<?php if($TPL_order_data_1){foreach($TPL_VAR["order_data"] as $TPL_K1=>$TPL_V1){?>
        <div class="wrap-recently-order">
            <div class="title-area">
                <p class="float-l">Order Date  &nbsp;<span class="number__font"><?php echo $TPL_V1["order_date"]?></span> <span> (Order No. <span class="number__font"><?php echo $TPL_V1["oid"]?></span>)</span></p>
                <a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>" class="btn-order-detail float-r">View Details</a>
            </div>
            <div class="order-list">
                <table>
                    <colgroup>
                        <col width="*">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <col width="11%">
                        <col width="15%">
<?php }else{?>
                        <col width="12%">
                        <col width="20%">
<?php }?>
                    </colgroup>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1["orderDetail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
                    <tr> <!--tr class="other"--> <!--배송지가 다른 경우-->
                        <td>
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" target="_blank">
                                <div class="thumb">
                                    <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["pname"]?>">
                                </div>
                                <div class="info">
                                    <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                    <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                    <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                    <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V2["listprice"])?></strong> <?php echo $TPL_VAR["fbUnit"]["b"]?>/ <span><?php echo $TPL_V2["pcnt"]?></span>ltem(s)</p>
                                </div>
                            </a>
                        </td>
                        <td class="fb__mypage__odtable--center">
                            <!--@TODO 2. 배송완료일때는 "fb__mypage__odtable--bold "이 클래스를 추가해 주세요.-->
                            <?php echo $TPL_V2["status_text"]?>

<?php if($TPL_V2["status"]==ORDER_STATUS_DELIVERY_ING||$TPL_V2["status"]==ORDER_STATUS_DELIVERY_COMPLETE||$TPL_V2["status"]==ORDER_STATUS_BUY_FINALIZED){?>
<?php if($TPL_V2["quick"]&&$TPL_V2["invoice_no"]){?>
                            <p>
                                <a href="javascript:void(0);" class="fb__mypage__odtable--trace devInvoice" data-quick="<?php echo $TPL_V2["quick"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">Tracking</a>
                            </p>
<?php }?>
<?php }?>
                        </td>
                        <td class="td-btn-area">
                            <!--@TODO 이부분은 orderhistory.htm 132번 줄을 확인해주세요-->
<?php if($TPL_V2["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
<?php if(false){?><button class="fb__mypage__btn--lightgray devOrderCancelBtn" data-oid="<?php echo $TPL_V2["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">주문취소</button><?php }?>
<?php }elseif($TPL_V2["status"]==ORDER_STATUS_DELIVERY_ING){?>
                            <button class="fb__mypage__btn--lightgray devOrderComplateBtn" data-oid="<?php echo $TPL_V2["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Out for delivery</button>
<?php }elseif($TPL_V2["status"]==ORDER_STATUS_DELIVERY_COMPLETE){?>
<?php if(false){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <button class="fb__mypage__btn--lightgray devOrderExchangeBtn" data-oid="<?php echo $TPL_V2["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Request Exchange</button>
<?php }?>
<?php }?>
                            <button class="fb__mypage__btn--lightgray devOrderReturnBtn" data-oid="<?php echo $TPL_V2["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Request Return</button>
                            <button class="fb__mypage__btn--lightgray devBuyFinalizedBtn" data-oid="<?php echo $TPL_V2["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">Order accepted</button>
<?php }elseif(($TPL_V2["status"]==ORDER_STATUS_BUY_FINALIZED&&$TPL_V2["after_cnt"]== 0)){?>
                            <!--<button class="fb__mypage__btn--lightgray devByFinalized" data-oid="<?php echo $TPL_V2["oid"]?>" data-pid="<?php echo $TPL_V2["pid"]?>" data-odeix="<?php echo $TPL_V2["ode_ix"]?>">Write a review</button>-->
                            <a class="crema-new-review-link fb__mypage__btn--lightgray" data-product-code="<?php echo $TPL_V2["co_no"]?>" widget-id="100" >Write a review</a>
<?php }?>
                        </td>
                    </tr>

<?php if($TPL_V2["exchageDetail"]){?>                    <?php if(is_array($TPL_R3=$TPL_V2["exchageDetail"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                    <tr class="change-product-detail devEcDetail<?php echo $TPL_K1?>-<?php echo $TPL_K2?>">
                        <td>
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" target="_blank">
                                <div class="thumb">
                                    <img src="<?php echo $TPL_V3["pimg"]?>" alt="<?php echo $TPL_V3["pname"]?>">
                                </div>
                                <div class="info">
                                    <p class="title"><?php echo $TPL_V3["pname"]?></p>
                                    <p class="option"><?php echo $TPL_V3["option_text"]?></p>
                                    <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V3["pt_dcprice"])?></strong> <?php echo $TPL_VAR["fbUnit"]["b"]?>/ <span><?php echo $TPL_V3["pcnt"]?></span>ltem(s)</p>
                                </div>
                            </a>
                        </td>
                        <td class="status">
                            <p><?php echo $TPL_V3["status_text"]?></p>
                        </td>

                        <td class="td-btn-area">
                            <!--@TODO 교환일때는 배송준비중 ~ 구매확정까지만 노출됩니다. 각각 주문상태별 버튼은 orderhistory.htm 142번 줄을 확인해주세요.-->
<?php if($TPL_V3["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
                            <button class="fb__mypage__btn--lightgray devOrderCancelBtn" data-oid="<?php echo $TPL_V3["oid"]?>" data-odix="<?php echo $TPL_V3["od_ix"]?>">Cancel Order</button>
<?php }elseif($TPL_V3["status"]==ORDER_STATUS_DELIVERY_ING){?>
                            <button class="fb__mypage__btn--lightgray devOrderComplateBtn" data-oid="<?php echo $TPL_V3["oid"]?>" data-odix="<?php echo $TPL_V3["od_ix"]?>">Out for delivery</button>
<?php }elseif($TPL_V3["status"]==ORDER_STATUS_DELIVERY_COMPLETE){?>
<?php if(false){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <button class="fb__mypage__btn--lightgray devOrderExchangeBtn" data-oid="<?php echo $TPL_V3["oid"]?>" data-odix="<?php echo $TPL_V3["od_ix"]?>">Request Exchange</button>
<?php }?>
<?php }?>
                            <button class="fb__mypage__btn--lightgray devOrderReturnBtn" data-oid="<?php echo $TPL_V3["oid"]?>" data-odix="<?php echo $TPL_V3["od_ix"]?>">Request Return</button>
                            <button class="fb__mypage__btn--lightgray devBuyFinalizedBtn" data-oid="<?php echo $TPL_V3["oid"]?>" data-odix="<?php echo $TPL_V3["od_ix"]?>">Order accepted</button>
<?php }elseif($TPL_V2["status"]==ORDER_STATUS_BUY_FINALIZED){?>
                            <button class="fb__mypage__btn--lightgray devByFinalized" data-oid="<?php echo $TPL_V3["oid"]?>" data-pid="<?php echo $TPL_V3["pid"]?>" data-odeix="<?php echo $TPL_V3["ode_ix"]?>">Write a review</button>
<?php }?>
                        </td>
                    </tr>
<?php }}?>
<?php }?>

<?php }}?>
                    </tbody>
                </table>
            </div>
        </div>
<?php }}?>
<?php }else{?>
        <li class="empty-content order-list">
            <p>You have not placed any orders for last 1 month.</p>
        </li>
<?php }?>


    </section>

    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Product information of interest</h2>
        <div class="tab-control type-third">
            <ul class="tab-link">
                <li class="active"><a href="#tab1">Recently Viewed Products</a></li>
                <li><a href="#tab2">Wish list</a></li>
                <li class="tab3"><a href="#tab3">Cart</a></li>
            </ul>
            <div class="tab-contents">
                <div id="tab1" class="tab active">
                    <form name='devRecentViewForm' id="devRecentViewForm" method='post'>
                        <ul class="mypage-bottom-list">
<?php if($TPL_historyList_1){$TPL_I1=-1;foreach($TPL_VAR["historyList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 4){?>
                            <li>
                                <div class="check-area">
                                    <input type="checkbox" id="historyList_<?php echo $TPL_I1?>" name="recentList[]" value="<?php echo $TPL_V1["id"]?>">
                                    <label for="historyList_<?php echo $TPL_I1?>"></label>
                                </div>
                                <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                                    <div class="item">
                                        <div class="thumb">
                                            <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                                        </div>
                                        <div class="info">
                                            <p class="title"><?php echo $TPL_V1["pname"]?></p>
                                            <p class="price">
                                                <?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["dcprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
<?php }?>
<?php }}else{?>
                            <li class="empty-content">
                                <p>No Recently Viewed Items</p>
                            </li>
<?php }?>
                        </ul>
                    </form>
                    <div class="wrap-btn-area">
                        <a href="javascript:void(0)"  class='rgb_buttom2 buttom_p_s deletion_class'> <!--기능확인 필요-->
                            <button id="devBtnDelRecent" class="fb__mypage__btn--black float-r">Delete Selectied item</button>
                        </a>
                    </div>
                </div>

                <div id="tab2" class="tab">
                    <form name='wishlist_bottom_frm' id="wishlist_bottom_frm" method='get' target='act'>
                        <ul class="mypage-bottom-list">
<?php if($TPL_wishList_1){$TPL_I1=-1;foreach($TPL_VAR["wishList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 4){?>
                            <li>
                                <div class="check-area">
                                    <input type="checkbox" id="historyList_2<?php echo $TPL_I1?>" name="wishList[]" value="<?php echo $TPL_V1["id"]?>">
                                    <label for="historyList_2<?php echo $TPL_I1?>"></label>
                                </div>
                                <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                                    <div class="item">
                                        <div class="thumb">
                                            <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                                        </div>
                                        <div class="info">
                                            <p class="title"><?php echo $TPL_V1["pname"]?></p>
                                            <p class="price">
                                                <?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["dcprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
<?php }?>
<?php }}else{?>
                            <li class="empty-content">
                                <p>Your Wish list is empty.</p>
                            </li>
<?php }?>
                        </ul>
                    </form>
                    <div class="wrap-btn-area">
                        <a href="javascript:FavoriteDelete(document.wishlist_bottom_frm,'20');" class='rgb_buttom2 buttom_p_s deletion_class'> <!--기능확인 필요-->
                            <button id="devBtnDelRecent2" class="fb__mypage__btn--black float-r">Delete Selectied item</button>
                        </a>
                    </div>
                </div>

                <div id="tab3" class="tab">
                    <ul class="mypage-bottom-list">
<?php if($TPL_cartList_1){$TPL_I1=-1;foreach($TPL_VAR["cartList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 4){?>
                        <li>
                            <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                                <div class="item">
                                    <div class="thumb">
                                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                                    </div>
                                    <div class="info">
                                        <p class="title"><?php echo $TPL_V1["pname"]?></p>
                                        <p class="price">
                                            <?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["dcprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
<?php }?>
<?php }}else{?>
                        <li class="empty-content">
                            <p>No items in cart.</p>
                        </li>
<?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

</div>