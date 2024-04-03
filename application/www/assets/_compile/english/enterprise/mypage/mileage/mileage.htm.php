<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/mileage/mileage.htm 000008248 */ ?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">

<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage wrap-mypage fb__mileage">
    <div class="mileage">
        <section class="mileage__top">
            <h2 class="fb__mypage__title">Reward</h2>
            <div class="mileage__inner">
                <div class="float-l">
                    <dl>
                        <dt>
                            <p class="mileage__usable-point-text">Valid Reward</p>
                        </dt>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo $TPL_VAR["myMileAmount"]?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
                <div class="float-r">
                    <dl>
                        <dt>Total</dt>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo $TPL_VAR["availMileAmount"]?></strong> <?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl>
                        <dt>Unvalid</dt>
                        <dd>
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo $TPL_VAR["myMileageWaitAmount"]?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?>

                        </dd>
                    </dl>
                    <dl>
                        <dt>
                            <a href="/mypage/mileageDecimation">
                                Expiring<span class="light">(Expire within 3 month.)</span>
                            </a>
                        </dt>
                        <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo $TPL_VAR["ext_mileage_amount"]?></strong> <?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                </div>
            </div>
        </section>

        <section class="fb__mypage__search">
            <h2 class="fb__mypage__title">Search Reward History</h2>

            <form id="devMileageForm">
                <input type="hidden" name="page" value="1" id="devPage"/>
                <input type="hidden" name="max" value="10" id="devMax"/>
                <input type="hidden" name="state" value="" id="state"/>
                <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
                <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />

                <div class='search'>
                    <div class="search__row">
                        <div class="search__col">
                            <span class="search__col-title">Period</span>
                            <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick" title="조회시작기간">
                            ~
                            <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick"  title="조회종료기간">
                        </div>
                        <div class="search__col__day">
                            <div class="day-radio">
                                <a href="#" class="day-radio__btn today devDateBtn" data-sdate="<?php echo $TPL_VAR["today"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">Today</a>
                                <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneWeek"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em>Week</a>
                                <a href="#" class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em>Month</a>
                                <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em>Month</a>
                                <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em>Year</a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="search__btn">
                    <a href="#" id="devBtnReset" class="search__btn--cancel">Reset</a>
                    <input type="button" id="devBtnSearch" value="Search" title="Search" alt="Search" class="search__btn--search">
                </div>
            </form>

        </section>

        <section class="mileage__detail">
            <h2 class="fb__mypage__title">Reward History</h2>
            <div class="mileage__detail-box type-third"><!--tab-control-->
                <ul class=" fb__mypage__tab">
                    <li devFilterState="" class="fb__mypage__tab-menu fb__mypage__tab-menu--active">
                        <a href="#">All</a>
                    </li>
                    <li devFilterState="1" class="fb__mypage__tab-menu">
                        <a href="#">Saved</a>
                    </li>
                    <li devFilterState="2" class="fb__mypage__tab-menu">
                        <a href="#">Used</a>
                    </li>
                </ul>
                <p class="fb__mileage__total">Total <span id="devMileageTotal"></span></p>
                <div class="mileage__detail__content"> <!--tab-contents-->
                    <div id="tab1"> <!-- class="tab active"-->
                        <table class="table-default mileage-table" id="tplMileage">
                            <colgroup>
                                <col width="14%">
                                <col width="*">
                                <col width="20%">
                                <col width="12%">
                            </colgroup>
                            <thead>
                            <th>Effective date</th>
                            <th>Detail</th>
                            <th>Reward<?php if($TPL_VAR["langType"]=="english"){?>(USD)<?php }?></th>
                            <th>Status</th>
                            </thead>

                            <tbody id="devMileageContent">

                            <tr id="devMileageLoading" class="devForbizTpl">
                                <td colspan="4">
                                    <div class="wrap-loading">
                                        <div class="loading"></div>
                                    </div>
                                </td>
                            </tr>

                            <tr id="devMileageList" class="devForbizTpl {[#if soldoutClassName]}showBg{[else]}hideBg{[/if]}">
                                <td><span class="font-rb">{[date]}</span></td>
                                <td class="detail">{[message]}
                                    {[#if oid]}
                                    <span class="devLocationOrder" data-oid="{[oid]}">({[oid]})</span>
                                    {[/if]}
                                </td>
                                <td class="mileage mileage__list">
                                    <span class="fb__n  {[log_type]}">{[mileage_desc]}</span>
                                </td>
                                <td><strong>{[state_desc]}</strong></td>
                            </tr>

                            <tr id="devMileageListEmpty" class="devForbizTpl">
                                <td colspan="4">
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
        </section>
    </div>
</div>