<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/return_history/return_history.htm 000009696 */ 
$TPL_status_1=empty($TPL_VAR["status"])||!is_array($TPL_VAR["status"])?0:count($TPL_VAR["status"]);?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">
<?php if(!$TPL_VAR["nonMemberOid"]){?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>
<section class="fb__return-history">
    <h2 class="fb__title--hidden">반품/취소 내역 페이지</h2>
    <div class="fb__mypage wrap-mypage">
<?php if(!$TPL_VAR["nonMemberOid"]){?>
        <section class="fb__mypage__search">

            <h2 class="fb__mypage__title">Search Return/Cancellation</h2>

            <form id="devReturnHistoryForm">
                <input type="hidden" name="page" value="1" id="devPage" />
                <input type="hidden" name="max" value="10"/>

                <div class="search">
                    <div class="search__row">
                        <div class="search__col">
                            <span class="search__col-title">Period</span>
                            <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick " title="Search begin period">
                            ~
                            <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick " title="Search end period">
                        </div>
                        <div class="search__col__day">
                            <div class="day-radio">
                                <a href="#"  class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em> month</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id=""><em>3</em> months</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em> months</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> year</a>
                            </div>
                        </div>
                    </div>

                    <div class="search__row order">
                        <div class="search__col">
                            <span class="search__col-title">Order Status</span>
                            <select class="search__select" name="status" id="devStatus" title="(english)주문상태 선택">
                                <option value="all">All</option>
<?php if($TPL_status_1){foreach($TPL_VAR["status"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                            </select>
                        </div>
                        <script>$(function () {
                            $('#devStatus').val('<?php echo $TPL_VAR["orderStatus"]?>');
                        });</script>

                        <div class="search__col search__col__pname">
                            <label class="search__col-title search__col__pname-title" for="devPname">Product Name</label>
                            <input type="text" name="pname" class="search__pname-input" id="devPname">
                        </div>
                    </div>
                </div>
                <div class="search__btn">
                    <button type="button" id="devSearchInitBtn" class="search__btn--cancel" data-sDate="<?php echo $TPL_VAR["oneMonth"]?>" data-eDate="<?php echo $TPL_VAR["today"]?>">Reset</button>
                    <button type="button" id="devSearchBtn" title="검색" class="search__btn--search">Search</button>
                </div>
            </form>

        </section>
<?php }else{?>
        <form id="devReturnHistoryForm">
            <input type="hidden" name="page" value="1" id="devPage" />
            <input type="hidden" name="max" value="1"/>
        </form>
<?php }?>


        <!--취소교환반품내역-->
        <section class="fb__mypage__section">
            <h2 class="fb__mypage__title">Return/Cancellation</h2>
            <div id="devReturnHistoryContent">
                <div class="devForbizTpl" id="devReturnHistoryLoading">
                    <div class=" empty-content order-list">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </div>
                </div>

                <div class="devForbizTpl" id="devReturnHistoryEmpty">
                    <div class="fb__mypage__empty">
                        <p class="fb__mypage__empty-text">There is no return/cancellation history.</p>
                    </div>
                </div>

                <div class="wrap-recently-order devForbizTpl" id="devReturnHistoryList">
                    <div class="title-area">
                        <p class="float-l">Request date <em class="fb__n">{[claim_date]}</em> <span>(Order No. <a href="/mypage/orderDetail?oid={[oid]}"><span class="fb__n">{[oid]}</span><!--</a>-->)</span>
                        </p>
                        <a href="/mypage/orderClaimDetail/{[oid]}/{[claim_group]}" class="btn-order-detail float-r">View Details</a>
                    </div>

                    <div class="order-list">
                        <table>
                            <colgroup>
                                <col width="*">
                                <col width="13%">
                                <!-- <col width="15%"> -->
                            </colgroup>
                            <tbody id="devOrderDetailContent">
                            <tr class="devForbizTpl" id="devReturnProduct">
                                <td>
                                    <a href="/shop/goodsView/{[pid]}" target="_blank">
                                        <div class="thumb">
                                            <img src="{[pimg]}" alt="{[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}">
                                        </div>
                                        <div class="info">
                                            <p class="title"> {[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}</p>
                                            <p class="option">{[option_text]}</p>
                                            {[#if add_info]}
                                            <p class="option">Color : {[add_info]}</p>
                                            {[/if]}
                                            <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong class="fb__n">{[listprice]}</strong><?php echo $TPL_VAR["fbUnit"]["b"]?> / <span class="fb__n">{[pcnt]}</span>ltem(s)</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="status">
                                    <p>{[status_text]}</p>
                                    {[#if refund_status_text]}<p>{[refund_status_text]}</p>{[/if]}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="devPageWrap"></div>
        </section>

<?php if(!$TPL_VAR["nonMemberOid"]){?>
        <!--교환반품 환불안내-->
        <section class="fb__cosmetics">
            <div class="cosmetics">
                <h2 class="cosmetics__title">Returns / Refunds</h2>
                <ul class="cosmetics__wrap br__cliamGuide">
<?php $this->print_("content",$TPL_SCP,1);?>

                </ul>
            </div>
        </section>
<?php }else{?>
        <!--비회원 교환반품환불내역-->
        <section class="fb__mypage__section fb__cosmetics">
            <h2 class="cosmetics__title">Return/Cancellation</h2>
            <div class="cosmetics">
                <ul class="cosmetics__wrap">
                    <li class="cosmetics__list">
                        <a href="#" class="cosmetics__link">
                            <h3 class="cosmetics__category">Refund by payment method</h3>
                        </a>
                        <ul class="cosmetics__info">
                            <li class="cosmetics__infoList">
                                Card cancellation: When you cancel the entire return item or partial cancellation, only the actual payment amount, excluding partial cancellation amount, will take three to five days depending on the payment processing/card company.
                            </li>
                            <li class="cosmetics__infoList">
                                Deposit without bankbook: refund by refund account amount of returned product
                            </li>
                            <li class="cosmetics__infoList">
                                Real-time account transfer: Full cancellation only/partial cancellation is refunded to refund account amount of returned product
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
<?php }?>
    </div>
</section>