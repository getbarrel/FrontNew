<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/mileage/mileage.htm 000005918 */ ?>
<section class="br__mileage">
    <p class="br__mileage__description"><?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?> <em>Valid Reward is</em> <span><strong><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["myMileAmount"]?><?php echo $TPL_VAR["fbUnit"]["b"]?></strong></span></p>
    

    <article class="br__mileage__info">
        <dl class="mileage__state">
            <dt class="mileage__state__title">Total</dt>
            <dd class="mileage__state__money"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["availMileAmount"]?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
        </dl>
        <dl class="mileage__state">
            <dt class="mileage__state__title">Unvalid</dt>
            <dd class="mileage__state__money"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["myMileageWaitAmount"]?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
        </dl>
        <dl class="mileage__state">
            <dt class="mileage__state__title">Expiring</dt>
            <dd class="mileage__state__money"><a href="/mypage/mileageDecimation" class="mileage__state__link">Inquiry</a></dd>
        </dl>
    </article>

    <section class="br__mileage__inquiry">
        <form id="devMileageForm" name="devMileageForm">
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="20" id="devMax"/>
            <input type="hidden" name="state" value="" id="state"/>
            <input type="hidden" name="sDate" id="devSDate" value="<?php echo $TPL_VAR["sDate"]?>" />
            <input type="hidden" name="eDate" id="devEDate" value="<?php echo $TPL_VAR["eDate"]?>" />
            <div class="mileage-folding">
                <h2 class="mileage-folding__title">Reward History</h2>
                <div class="mileage-folding__box">
                    <p class="mileage-folding__text">Total <span id="devTotal"></span> <span id="devComment" style="color:black;"></span></p>
                    <button type="button" class="mileage-folding__btn" id="devFilter">(english)날짜별 조회 열기/닫기 버튼</button>
                </div>
            </div>
            <div class="mileage-inquiry" style="display:none">
                <p class="mileage-inquiry__notice">Search history within <strong>the last 3 years</strong></p>
                <div class="mileage-inquiry__form mileage-inquiry__form--months">
                    <button type="button" class="mileage-inquiry__form__btn devSelectDate" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">1 month</button>
                    <button type="button" class="mileage-inquiry__form__btn mileage-inquiry__form__btn--active devSelectDate" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">3 months</button><!-- threeMonth 임시값 -->
                    <button type="button" class="mileage-inquiry__form__btn devSelectDate" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">6 months</button>
                    <button type="button" class="mileage-inquiry__form__btn devSelectDate" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">1 year</button>
                </div>
                <div class="mileage-inquiry__form">
                    <input type="date" class="mileage-inquiry__form__input" id="sDateStr" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}" placeholder="YYMMDD" value="<?php echo $TPL_VAR["sDate"]?>">
                    <span class="hyphen">-</span>
                    <input type="date" class="mileage-inquiry__form__input" id="eDateStr" placeholder="YYMMDD" value="<?php echo $TPL_VAR["eDate"]?>">
                </div>
                <div class="mileage-inquiry__form mileage-inquiry__form--state">
                    <span class="mileage-inquiry__form__text">Category</span>
                    <div class="mileage-inquiry__form__radio">
                        <label><input type="radio" name="state" value="" devFilterState="" checked><span>All</span></label>
                        <label><input type="radio" name="state" value="1" devFilterState="1"><span>Saving</span></label>
                        <label><input type="radio" name="state" value="2" devFilterState="2"><span>Use</span></label>
                    </div>
                </div>
                <button type="button" class="mileage-inquiry__btn" id="devSubmit">Search</button>
            </div>
        </form>
        <div class="mileage-history">
            <ul class="mileage-history__list" id="devMileageContent">
                <li class="mileage-history__box--loading" id="devMileageLoading" class="devForbizTpl">
                    <p>loading...</p>
                </li>

                <li class="mileage-history__box--empty" id="devMileageListEmpty" class="devForbizTpl">
                    <p>There is no reward history.</p>
                </li>
                <li class="mileage-history__box devForbizTpl" id="devMileageList">
                    <p class="mileage-history__box__date"><span class="br__hidden">Date : </span>{[date]}</p>
                    {[#if oid]}<p class="mileage-history__box__order-number devLocationOrder" data-oid="{[oid]}">Order No. {[oid]}</p>{[/if]}
                    <p class="mileage-history__box__title"><span class="br__hidden">Point name : </span>{[message]}</p>
                    <p class="mileage-history__box__mileage"><span class="br__hidden">Reward : </span>{[mileage_desc]}</p> <?php if($TPL_VAR["langType"]=="english"){?><span>(USD)</span><?php }?>
                </li>
            </ul>
        </div>
        <div class="br__more" id="devPageWrap"></div>
    </section>
</section>