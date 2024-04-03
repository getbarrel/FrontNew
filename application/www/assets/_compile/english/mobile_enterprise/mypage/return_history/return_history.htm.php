<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/return_history/return_history.htm 000006044 */ 
$TPL_status_1=empty($TPL_VAR["status"])||!is_array($TPL_VAR["status"])?0:count($TPL_VAR["status"]);?>
<section class="br__odhistory br__return">
    <div class="odhistory">
        <!--<h2 class="br__cs__title">-->
            <!--Return/Cancel History-->
        <!--</h2>-->
        <nav class="br__odhistory__tab">
            <ul>
                <li class="br__odhistory__tab-menu">
                    <a href="/mypage/orderHistory">Your Orders</a>
                </li>
                <li class="br__odhistory__tab-menu br__odhistory__tab-menu--active">
                    <a href="/mypage/returnHistory">Returns/ Cancellations</a>
                </li>
            </ul>
        </nav>

        <header class="br__odhistory__top br__sort" style="display:<?php if($TPL_VAR["nonMemberOid"]!=''){?>none<?php }?>">
            <form id="devReturnHistoryForm">
            <div class="br__sort__select wrap-sorting">
                <input type="hidden" name="page" value="1" id="devPage" />
                <input type="hidden" name="max" value="10"/>
                <input type="hidden" name="eDate" value="<?php echo $TPL_VAR["today"]?>" id="devEdate" />
                <select class="js__sDate" name="sDate" id="devSdate">
                    <option value="<?php echo $TPL_VAR["oneMonth"]?>" selected>1 month</option>
                    <option value="<?php echo $TPL_VAR["threeMonth"]?>">3 months</option>
                    <option value="<?php echo $TPL_VAR["sixMonth"]?>" >6 months</option>
                    <option value="<?php echo $TPL_VAR["oneYear"]?>">1 year</option>
                    <option value="timeSelect">Setting period</option>
                </select>
                <select  name="status" id="devStatus">
                    <option value="all">Order Status</option>
<?php if($TPL_status_1){foreach($TPL_VAR["status"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                </select>
                <script>
                    $(function () {
                        $('#devStatus').val('<?php echo $TPL_VAR["orderStatus"]?>');
                    });
                </script>
            </div>
            <div class="br__sort__timeselect">
                <div class="br__sort__date">
                    <input type="date" name="sel_sdate" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devStartDate">
                    <span class="br__sort__date--hyphen">-hyphen</span>
                    <input type="date" name="sel_edate" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devEndDate">
                </div>
                <button class="br__sort__search" id="devSearch">Inquiry</button>
            </div>
            </form>
        </header>


        <div class="br__odhistory__content wrap-order-list" id="devReturnHistoryContent">
            <div class="empty-content devForbizTpl" id="devReturnHistoryLoading">
                <p>Loading...</p>
            </div>

            <div class="br__odhistory__empty-content devForbizTpl" id="devReturnHistoryEmpty">
                <p>There is no return/cancellation history.</p>
            </div>

            <div class="br__odhistory__each wrap-recently-order cancel devForbizTpl" id="devReturnHistoryList">
                <div class="odeach wrap-recently-order">
                    <header class="odeach__top order-number-box">
                        <p class="odeach__top__text">Order No.
                            <a href="/mypage/orderDetail?oid={[oid]}"><span>{[oid]}</span></a>
                        </p>
                        <p class="odeach__top__text">Request date <span>{[claim_date]}</span></p>
                        <a class="odeach__top__detailbtn" href="/mypage/orderClaimDetail/{[oid]}/{[claim_group]}">
                            <span>View Details</span>
                        </a>
                    </header>
                </div>
                <ul class="odeach__list" id="devOrderDetailContent">
                    <li class="odeach__item devForbizTpl" id="devReturnProduct">
                        <div class="odeach__item__inner item">
                            <figure class="odeach__item__thumb">
                                <a href="/shop/goodsView/{[pid]}">
                                    <img src="{[pimg]}">
                                </a>
                            </figure>
                            <div class="odeach__item__info">
                                <p class="odeach__item__title">{[pname]}</p>
                                <p class="odeach__item__option">{[{option_text}]} / Quantity {[pcnt]}</p>
                                <p class="odeach__item__option">{[add_info]}</p>
                                <div class="odeach__item__bottom">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <span class="odeach__item__status ">{[status_text]}{[#if refund_status_text]} / {[refund_status_text]}{[/if]}</span>
<?php }else{?>
                                    <span class="odeach__item__status ">(english){[status_text]}{[#if refund_status_text]} /<br>{[refund_status_text]}{[/if]}</span>
<?php }?>
                                    <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="br__more" id="devPageWrap"></div>
        <section class="br__claim">
            <h3 class="br__return__sub-title">Returns / Refunds</h3>
<?php $this->print_("content",$TPL_SCP,1);?>

        </section>
    </div>
</section>