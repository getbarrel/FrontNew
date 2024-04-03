<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/mileage_decimation/mileage_decimation.htm 000004403 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage wrap-mypage fb__mileage fb__mileage-zero">
    <div class="mileage">
        <section class="mileage__top">
            <h2 class="fb__mypage__title">Expiring</h2>
            <div class="mileage__inner">
                <div class="float-l">
                    <dl>
                        <dt>
                        <p class="mileage__usable-point-text">Expiring</p>
                        </dt>
                        <span class="fb__mileage-zero__subtext">Estimated expiring mileage within 3 months. (Including the current month)</span>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo $TPL_VAR["ext_mileage_amount"]?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
            </div>
        </section>

        <section class="mileage__detail">
            <h2 class="fb__mypage__title">Reward History</h2>


            <form id="devExtMileageForm">
                <input type="hidden" name="page" value="1" id="devPage"/>
                <input type="hidden" name="max" value="10" id="devMax"/>
                <input type="hidden" name="state" value="" id="state"/>
                <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
                <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />


            <div class="mileage__detail-box type-third"><!--tab-control-->
                <div class="mileage__detail__content"> <!--tab-contents-->
                    <div id="tab1"> <!-- class="tab active"-->
                        <table class="table-default mileage-table" id="tplMileage">
                            <colgroup>
                                <col width="14%">
                                <col width="*">
                                <col width="14%">
                            </colgroup>
                            <thead>
                            <th>Effective date</th>
                            <th>Detail</th>
                            <th>Mileage</th>
                            </thead>

                            <tbody id="devMileageContent">

                            <tr id="devMileageLoading" class="devForbizTpl">
                                <td colspan="3">
                                    <div class="wrap-loading">
                                        <div class="loading"></div>
                                    </div>
                                </td>
                            </tr>

                            <tr id="devMileageList" class="devForbizTpl {[#if soldoutClassName]}showBg{[else]}hideBg{[/if]}">
                                <td><span class="font-rb">{[extinction_date]}</span></td>
                                <td class="detail">{[message]}
                                    {[#if oid]}
                                    <span class="devLocationOrder" data-oid="{[oid]}">({[oid]})</span>
                                    {[/if]}
                                </td>
                                <td class="mileage mileage__list">
                                    <span class="fb__n  {[log_type]}">-<?php echo $TPL_VAR["fbUnit"]["f"]?>{[extinction_mileage]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                </td>
                            </tr>

                            <tr id="devMileageListEmpty" class="devForbizTpl">
                                <td colspan="3">
                                    <div class="empty-content">
                                        <p>There is no reward history.</p>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div id="devPageWrap"></div>
                    </div>
                </div>
            </div>
            </form>
        </section>
        <div class="fb__mileage-zero__btn">
            <a href="/mypage/mileage" class="fb__mileage-zero__btn--black">List</a>
        </div>
    </div>
</div>