<?php /* Template_ 2.2.8 2021/03/31 14:07:55 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_history/order_history.htm 000012795 */ 
$TPL_status_1=empty($TPL_VAR["status"])||!is_array($TPL_VAR["status"])?0:count($TPL_VAR["status"]);?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">
<?php if(!$TPL_VAR["nonMemberOid"]){?><?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>
<div class="fb__mypage wrap-mypage">
<?php if(!$TPL_VAR["nonMemberOid"]){?>    <section class="fb__mypage__search"> <!-- mypage-order-section-->
        <h2 class="fb__mypage__title">Search your orders</h2>

        <form id="devOrderHistoryForm">
            <input type="hidden" name="page" value="1" id="devPage" />
            <input type="hidden" name="max" value="5"/>

            <div class="search"> <!--wrap-sort-->
                <div class="search__row">
                    <div class="search__col">
                        <span class="search__col-title">Period</span>

                        <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick " title="조회시작기간">
                        ~
                        <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick "  title="조회종료기간">
                    </div>
                    <div class="search__col__day">
                        <div class="day-radio">
                            <a href="#" class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em> month</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>3</em> months</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em> months</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> year</a>
                        </div>
                    </div>
                </div>

                <div class="search__row  order">
                    <div class="search__col">
                        <span class="search__col-title ">Order Status</span>
                        <select class="search__select" name="status" id="devStatus" title="주문상태 선택">
                            <option value="all">All</option>
<?php if($TPL_status_1){foreach($TPL_VAR["status"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                        </select>
                    </div>
                    <script>
                        $(function () {
                            $('#devStatus').val('<?php echo $TPL_VAR["orderStatus"]?>');
                        });
                    </script>

                    <div class="search__col search__col__pname">
                        <label class="search__col-title search__col__pname-title" for="devPname">Product Name</label>
                        <input class="search__pname-input" type="text" name="pname" id="devPname">
                    </div>
                </div>
            </div>
            <div class="search__btn"> <!--wrap-btn-area-->
                <button type="button" id="devSearchInitBtn" class="search__btn--cancel" data-sDate="<?php echo $TPL_VAR["oneMonth"]?>" data-eDate="<?php echo $TPL_VAR["today"]?>">Reset</button>
                <button type="button" id="devSearchBtn" title="검색" class="search__btn--search">Search</button>
            </div>
        </form>
    </section>
<?php }else{?>    <form id="devOrderHistoryForm">
        <input type="hidden" name="page" value="1" id="devPage" />
        <input type="hidden" name="max" value="1"/>
    </form>
<?php }?>


    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">Your orders</h2>
        <div id="devOrderHistoryContent">
            <div class="devForbizTpl" id="devOrderHistoryLoading">
                <div class="fb__mypage__empty">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </div>
            </div>

            <div class="devForbizTpl" id="devOrderHistoryEmpty">
                <div class="fb__mypage__empty">
                    <p class="fb__mypage__empty-text">No ongoing orders were found.</p>
                </div>
            </div>


            <div class="fb__mypage__list wrap-recently-order devForbizTpl" id="devOrderHistoryList">
                <div class="list">
                    <div class="list__top title-area">
                        <p class="list__top__ float-l">Order Date <em class="fb__n">{[order_date]}</em> <span>(Order No. <span class="fb__n">{[oid]}</span>)</span>
                            {[#if isAllCancel]}<button type="button" class="fb__mypage__btn--lightgray mal10 devOrderCancelAllBtn" data-oid="{[oid]}">Cancel Order</button>{[/if]}
                        </p>
                        <a href="/mypage/orderDetail?oid={[oid]}" class="btn-order-detail float-r">View Details</a>
                    </div>

                    <div class="order-list">
                        <table>
                            <colgroup>
                                <col width="*">
                                <col width="13%">
                                <col width="18%">
                            </colgroup>
                            <tbody id="devOrderDetailContent">
                                <tr class="{[#if isExchange]}change-product{[/if]} {[#if isExchangeDetail]}change-product-detail devEcDetail{[exKey]}{[/if]} {[#if isOther]}other{[/if]} devForbizTpl" id="devOrderDetailProduct">
                                    <td>
                                        <a href="/shop/goodsView/{[pid]}" target="_blank">
                                            <div class="thumb">
                                                <img src="{[pimg]}" alt="{[#if brand_name]}[{[brand_name]}] {[/if]} {[pname]}">
                                                <!-- {[#if isExchange]} -->
                                                <!--<span class="mypage__badge-exchange">Replacement</span>-->
                                                <!-- {[/if]} -->
                                            </div>
                                            <div class="info">
                                                <p class="title">{[#if brand_name]}[{[brand_name]}] {[/if]} {[pname]}</p>
                                                <p class="option">Option : {[option_text]}</p>
                                                {[#if add_info]}
                                                <p class="option">Color : {[add_info]}</p>
                                                {[/if]}
                                                <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong class="fb__n">{[listprice]}</strong><?php echo $TPL_VAR["fbUnit"]["b"]?> / <span class="fb__n">{[pcnt]}</span>ltem(s)</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="status">
                                        <p class="{[#if isDeliveryComplate]} fb__mypage__odtable--bold {[/if]}">{[status_text]}</p>
                                        {[#if refund_status_text]}<p>{[refund_status_text]}</p>{[/if]}
                                        {[#if isDeleveryTrace]}
                                        <p><a href="javascirt:void(0);" class="fb__mypage__odtable--trace devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</a></p>
                                        {[/if]}


                                        {[#if isDeliveryIng]}
                                        <p><a href="javascirt:void(0);" class="fb__mypage__odtable--trace devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</a></p>
                                        {[/if]}

                                        {[#if isDeliveryComplate]}
                                        <p><a href="javascirt:void(0);" class="fb__mypage__odtable--trace devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</a></p>
                                        {[/if]}

                                        {[#if isByFinalized]}
                                        <p><a href="javascirt:void(0);" class="fb__mypage__odtable--trace devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">Tracking</a></p>
                                        {[/if]}
                                    </td>
                                    <td class="td-btn-area">

                                        {[#if isIncomeComplate]}
                                            <button class="fb__mypage__btn--lightgray devOrderCancelBtn" data-oid="{[oid]}" data-part_cancel="{[partCancelBool]}" data-odix="{[od_ix]}">Cancel Order</button>
                                        {[/if]}

                                        {[#if isDeliveryIng]}
                                            <button class="fb__mypage__btn--lightgray devOrderComplateBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Out for delivery</button>
                                        {[/if]}

                                        {[#if isDeliveryComplate]}
                                            {[#if isExchangeDetail]}
                                            {[else]}
                                                <!--<button class="fb__mypage__btn&#45;&#45;lightgray devOrderExchangeBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[exchangeable_yn]}">Request Exchange</button>-->
                                                <button class="fb__mypage__btn--lightgray devOrderReturnBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[returnable_yn]}">Request Return</button>
                                            {[/if]}
                                            <button class="fb__mypage__btn--lightgray devBuyFinalizedBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">Order accepted</button>
                                        {[/if]}

<?php if(is_login()){?>
                                        {[#if isByFinalized]}                                            
<?php if($TPL_VAR["langType"]=='korean'){?>
                                            <a class="crema-new-review-link fb__mypage__btn--lightgray" data-product-code="{[co_no]}" widget-id="100" >Write a review</a>
<?php }else{?>
<?php if(false){?>
                                                <button class="fb__mypage__btn--lightgray devByFinalized" data-pid="{[pid]}" data-oid="{[oid]}" data-odeix="{[ode_ix]}">Write a review</button>
<?php }?>
<?php }?>
                                        {[/if]}

                                        {[#if isExchangeToggle]}
                                            <button data-exkey="{[exKey]}" class="btn-toggle devEcDetailToggleBtn">V</button>
                                        {[/if]}
<?php }?>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="devPageWrap"></div>
    </section>
</div>


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