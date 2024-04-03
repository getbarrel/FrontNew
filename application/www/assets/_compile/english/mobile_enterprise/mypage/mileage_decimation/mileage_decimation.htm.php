<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/mileage_decimation/mileage_decimation.htm 000001804 */ ?>
<form id="devExtMileageForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
    <input type="hidden" name="month" value="<?php echo $TPL_VAR["extDate"]?>" />
</form>
<section class="br__mileage-decimation">
    <h2 class="br__cs__title">Expiring</h2>
    <dl class="mileage-deci__total">
        <dt class="mileage-deci__total__title">Expiring</dt>
        <dd class="mileage-deci__total__money"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["ext_mileage_amount"]?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
    </dl>

    <p class="mileage-deci__desc"><strong>Estimated expiring reward</strong> within 3 months. (Including the current month)</p>
    <div class="mileage-deci__wrap" id="devMileageContent">
        <ul class="mileage-deci__list" >
            <li class="devForbizTpl" id="devMileageLoading"></li>
            <li class="mileage-deci__box mileage-deci__box--empty devForbizTpl" id="devMileageListEmpty">
                There is no estimated expiring reward.
            </li>
            <li class="mileage-deci__box" id="devMileageList">
                <span class="mileage-deci__box__date">{[extinction_date]}</span>
                <dl class="mileage-deci__box__info">
                    <dt class="mileage-deci__box__title">Expiring</dt>
                    <dd class="mileage-deci__box__money">-<?php echo $TPL_VAR["fbUnit"]["f"]?>{[extinction_mileage]}<?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="br__more" id="devPageWrap"></div>
</section>