<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/mileage_decimation/mileage_decimation.htm 000001844 */ ?>
<form id="devExtMileageForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
    <input type="hidden" name="month" value="<?php echo $TPL_VAR["extDate"]?>" />
</form>
<section class="br__mileage-decimation">
    <h2 class="br__cs__title">소멸예정 적립금</h2>
    <dl class="mileage-deci__total">
        <dt class="mileage-deci__total__title">소멸 예정 적립금</dt>
        <dd class="mileage-deci__total__money"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["ext_mileage_amount"]?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
    </dl>

    <p class="mileage-deci__desc">이후 <strong>3개월(당월 포함)</strong>동안의 소멸예정 금액입니다.</p>
    <div class="mileage-deci__wrap" id="devMileageContent">
        <ul class="mileage-deci__list" >
            <li class="devForbizTpl" id="devMileageLoading"></li>
            <li class="mileage-deci__box mileage-deci__box--empty devForbizTpl" id="devMileageListEmpty">
                소멸예정 적립금이 없습니다.
            </li>
            <li class="mileage-deci__box" id="devMileageList">
                <span class="mileage-deci__box__date">{[extinction_date]}</span>
                <dl class="mileage-deci__box__info">
                    <dt class="mileage-deci__box__title">소멸예정 적립금</dt>
                    <dd class="mileage-deci__box__money">-<?php echo $TPL_VAR["fbUnit"]["f"]?>{[extinction_mileage]}<?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="br__more" id="devPageWrap"></div>
</section>