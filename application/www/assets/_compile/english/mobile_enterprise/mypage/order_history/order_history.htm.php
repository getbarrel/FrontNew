<?php /* Template_ 2.2.8 2020/11/09 14:57:08 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_history/order_history.htm 000017518 */ 
$TPL_status_1=empty($TPL_VAR["status"])||!is_array($TPL_VAR["status"])?0:count($TPL_VAR["status"]);?>
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
<section class="br__odhistory">
    <div class="odhistory">
        <!--<h2 class="br__cs__title">-->
            <!--Your Orders-->
        <!--</h2>-->
        <nav class="br__odhistory__tab">
            <ul>
                <li class="br__odhistory__tab-menu br__odhistory__tab-menu--active">
                    <a href="/mypage/orderHistory">Your Orders</a>
                </li>
                <li class="br__odhistory__tab-menu">
                    <a href="/mypage/returnHistory">Returns/ Cancellations</a>
                </li>
            </ul>
        </nav>
        <header class="br__odhistory__top br__sort">
            <!--[S]os picker안할 경우 > 기획 확정되면 지워도 됨.-->
            <div class="br__sort__select" style="display: none;">
                <div class="br__select-box">
                    <div class="select-box">
                        <button class="select-box__title"><span>Period</span></button>
                        <div class="select-box__layer">
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="" checked>
                                <span>1 month</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="">
                                <span>3 months</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="">
                                <span>6 months</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="">
                                <span>1 year</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="">
                                <span>Setting period</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="br__select-box">
                    <div class="select-box">
                        <button class="select-box__title"><span>Order Status</span></button>
                        <div class="select-box__layer">
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc" checked>
                                <span>All</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
                                <span>Ordered</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
                                <span>Ordered</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="highPrice">
                                <span>Preparing</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="5">
                                <span>Shipped</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="5">
                                <span>Out for delivery</span>
                            </label>
                            <label class="select-box__layer__label">
                                <input type="radio" class="devSortTab" name="filterRadio" value="5">
                                <span>Order accepted</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!--[E]-->
            <div class="br__sort__select wrap-sorting">
                <form id="devOrderHistoryForm">
                    <input type="hidden" name="page" value="1" id="devPage" />
                    <input type="hidden" name="max" value="10"/>
                    <input type="hidden" name="eDate" value="<?php echo $TPL_VAR["today"]?>" id="devEdate" />
<?php if(empty($TPL_VAR["nonMemberOid"])){?>
                    <select class="js__sDate" name="sDate" id="devSdate">
                        <option value="<?php echo $TPL_VAR["oneMonth"]?>" selected>1 month</option>
                        <option value="<?php echo $TPL_VAR["threeMonth"]?>">3 months</option>
                        <option value="<?php echo $TPL_VAR["sixMonth"]?>" >6 months</option>
                        <option value="<?php echo $TPL_VAR["oneYear"]?>">1 year</option>
                        <option value="timeSelect">Setting period</option>
                    </select>
                    <select name="status" id="devStatus">
                        <option value="all" selected>Order Status</option>
<?php if($TPL_status_1){foreach($TPL_VAR["status"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                    </select>
<?php }?>
                    <script>$(function(){$('#devStatus').val('<?php echo $TPL_VAR["orderStatus"]?>');});</script>
                </form>
            </div>
            <!--기간설정-->
            <div class="br__sort__timeselect">
                <div class="br__sort__date">
                    <input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devStartDate">
                    <span class="br__sort__date--hyphen">-hyphen</span>
                    <input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devEndDate">
                </div>
                <button class="br__sort__search" id="devSearch">Inquiry</button>
            </div>
            <p class="br__odhistory__desc">You can request within <em>3 weeks</em> from the delivery completion date.</p>
        </header>

        <div class="br__odhistory__content" id="devOrderHistoryContent">
            <div class="empty-content devForbizTpl" id="devOrderHistoryLoading">
                <p>Loading...</p>
            </div>

            <div class="br__odhistory__empty-content devForbizTpl" id="devOrderHistoryEmpty">
                <p>No detail</p>
            </div>

            <section class="br__odhistory__each wrap-recently-order devForbizTpl" id="devOrderHistoryList">
                <div class="odeach wrap-recently-order">
                    <header class="odeach__top order-number-box">
                        <p class="odeach__top__text">Order Date <span>{[order_date]}</span></p>
                        <p class="odeach__top__text">Order No. <span>{[oid]}</span></p>
                        <a class="odeach__top__detailbtn" href="/mypage/orderDetail?oid={[oid]}">
                            <span>View Details</span>
                        </a>
                    </header>
                    <ul class="odeach__list" id="devOrderDetailContent">
                        <li class="devForbizTpl odeach__item {[#if isExchangeDetail]}odeach__exchange-detail {[/if]} {[#if orderItemId]}{[orderItemId]}{[/if]}"  id="devOrderDetailProduct">
                            <!--li 클래스에 붙어있던 것들
                            {[#if isExchange]}
                                change-product
                                {[#if isExchangeDetail]}
                                     change-product-detail
                                     {[#if orderItemId]}
                                        {[orderItemId]}
                                     {[/if]}
                                {[/if]}
                            {[/if]}
                            {[#if isOther]}   other   {[/if]}
                            -->
                            {[#if isExchangeDetail]}
                            <div class="odeach__exchange-detail__top">
                                <span class="odeach__exchange-detail__title">item for exchange</span>
                                <span class="odeach__exchange-detail__fold">{=trans('접기 화살표')</span>
                            </div>
                            {[/if]}
                            <div class="odeach__item__inner">
                                <figure class="odeach__item__thumb">
                                    <a href="/shop/goodsView/{[pid]}">
                                        <img src="{[pimg]}">
                                    <!-- <?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/sample/sample2.jpg -->
                                    </a>
                                </figure>
                                <div class="odeach__item__info">
                                    <p class="odeach__item__title">
                                        <a href="/shop/goodsView/{[pid]}">{[pname]}</a>
                                    </p>
                                    <p class="odeach__item__option odeach__item__option--add">
                                        {[add_info]}
                                    </p>
                                    <p class="odeach__item__option">
                                        {[option_text]}&nbsp;/&nbsp;<em>Quantities&nbsp;{[pcnt]}ltem(s)</em>
                                    </p>
                                    <div class="odeach__item__bottom">
<?php if($TPL_VAR["langType"]=='english'){?>
                                        <span class="odeach__item__status ">{[status_text]}{[#if refund_status_text]}<br>/ {[refund_status_text]}{[/if]}</span>
<?php }else{?>
                                        <span class="odeach__item__status ">{[status_text]}{[#if refund_status_text]} / {[refund_status_text]}{[/if]}</span>
<?php }?>
                                        <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                    </div>
                                </div>
                            </div>

                            <!--상품별로 각각 들어가야하는 버튼-->
                            <div class="odeach__btn odeach__btn--each">
                                <!-- {[#if isIncomeComplate]} -->
                                <button class="odeach__btn--wt odeach__btn--space devOrderCancelBtn" data-oid="{[oid]}" data-part_cancel="{[partCancelBool]}" data-odix="{[od_ix]}">Cancel Order</button>
                                <!-- {[/if]} -->

                                {[#if isDeliveryIng]}
                                <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</button>
                                <button class="odeach__btn--bk devOrderComplateBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Out for delivery</button>
                                {[/if]}

                                {[#if isDeliveryComplate]}
                                <!--<button class="odeach__btn&#45;&#45;wt devOrderExchangeBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[exchangeable_yn]}">Request Exchange</button>-->
                                <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</button>
                                <button class="odeach__btn--wt devOrderReturnBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[returnable_yn]}">Request Return</button>
                                <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</button>
                                <button class="odeach__btn--bk odeach__btn--all devBuyFinalizedBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Order accepted</button>
                                {[/if]}

                                {[#if isDeleveryTrace]}
                                <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</button>
                                {[/if]}
                                {[#if isByFinalized]}
                                <button class="odeach__btn--wt devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</button>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                <a class="crema-new-review-link odeach__btn--bk" data-product-code="{[co_no]}" widget-id="100" >Write a review</a>
<?php }else{?>
<?php if(false){?>
                                    <button class="odeach__btn--bk devByFinalized" data-pid="{[pid]}" data-oid="{[oid]}" data-odix="{[ode_ix]}">Write a review</button>
<?php }?>
<?php }?>
<?php }?>
                                {[/if]}
                            </div>
                        </li>
                    </ul>
                    <!--주문별 전체버튼-->
                    {[#if isAllCancel]}
                    <div class="odeach__btn odeach__btn--all">
                        <button class="odeach__btn--bk devOrderCancelAllBtn" data-oid="{[oid]}">Cancel Order</button>
                    </div>
                    {[/if]}
                </div>
            </section>
        </div>
        <div class="br__more" id="devPageWrap"></div>



        <!--(주문상태 레이어) *배럴에서 사용하지 않습니다. 참고하시라고 남겨두었습니다. display: none 상태입니다.-->
        <div class="devForbizTpl" id="devMorePopup" style="display: none">
            <div id="layer_status">
                <div class="img-area">
                    <img src="{[pimg]}">
                </div>
                <div class="content-area">
                    <div class="title-area">
                        <p class="tit">{[pname]}</p>
                        <p class="option">{[{option_text}]}</p>
                    </div>
                    <ul>
                        {[#if isDeleveryTrace]}<li onclick="javascirt:void(0);" class="devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</li>{[/if]}
                        {[#if isDeliveryIng]}<li class="devOrderComplateBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Out for delivery</li>{[/if]}
                        {[#if isDeliveryComplate]}
                        {[#if isExchangeDetail]}
                        {[else]}
                        <!--<li class="devOrderExchangeBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Request Exchange</li>-->
                        <li class="devOrderReturnBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Request Return</li>
                        {[/if]}
                        <li class="devBuyFinalizedBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Order accepted</li>{[/if]}
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                        {[#if isByFinalized]}<li class="devByFinalized" data-pid="{[pid]}" data-oid="{[oid]}" data-odix="{[ode_ix]}">Write a review</li>{[/if]}
<?php }?>
                    </ul>
                    <button type="button" class="close" id="devMorePopupCloseBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</section>