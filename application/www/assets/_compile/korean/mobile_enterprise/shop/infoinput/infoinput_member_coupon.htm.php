<?php /* Template_ 2.2.8 2024/03/27 11:35:30 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_member_coupon.htm 000003313 */ ?>
<div class="page-title">
    <div class="title-md">쿠폰 / 적립금</div>
</div>
<div class="info-discount">
    <div class="info-discount__item">
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
        <div class="info-discount__title">
            <div>이벤트 기간에는 쿠폰 사용이 불가능합니다.</div>
        </div>
<?php }else{?>
        <div class="info-discount__title">
            <div class="title-sm">쿠폰</div>
            <div class="info-discount__count">보유 쿠폰 <em><?php echo $TPL_VAR["userCouponCnt"]?></em>개</div>
        </div>
        <div class="info-discount__cont">
            <input type="text" class="br__form-input" value="0" id="devUseCouponInputText" readonly placeholder="" />
            <button type="button" class="btn-lg btn-dark-line" id="devUseCouponButton">쿠폰 선택</button>
        </div>
<?php }?>
    </div>
<?php if($TPL_VAR["userDeliveryCouponCnt"]> 0){?>
    <div class="info-discount__item">
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
        <div class="info-discount__title">
            <div>이벤트 기간에는 쿠폰 사용이 불가능합니다.</div>
        </div>
<?php }else{?>
        <div class="info-discount__title">
            <div class="title-sm">배송비 쿠폰</div>
            <div class="info-discount__count">보유 쿠폰 <em><?php echo $TPL_VAR["userDeliveryCouponCnt"]?></em>개</div>
        </div>
        <div class="info-discount__cont">
            <input type="text" class="br__form-input" value="0" id="devUseDeliveryCouponInputText" readonly placeholder="" />
            <button type="button" class="btn-lg btn-dark-line" id="devUseDeliveryCouponButton">쿠폰 선택</button>
        </div>
<?php }?>
    </div>
<?php }?>
    <div class="info-discount__item">
        <div class="info-discount__title">
            <div class="title-sm"><?php echo $TPL_VAR["mileageName"]?></div>
            <div class="info-discount__count">사용가능 적립금 <em><?php echo g_price($TPL_VAR["userMileage"])?></em><?php echo $TPL_VAR["mileageUnit"]?></div>
        </div>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
        <div class="discount-box__cont">
            <span>이벤트 기간에는 적립금 사용이 불가능합니다.</span>
        </div>
<?php }else{?>
        <div class="info-discount__cont">
            <input type="hidden" id="mileageConditionMinBuyAmt" value="<?php echo $TPL_VAR["mileageConditionMinBuyAmt"]?>" />
            <input type="text" id="devUseMileage" class="br__form-input" value="0" placeholder="" />
            <button type="button" class="btn-lg btn-dark-line" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>">전체 사용</button>
        </div>
<?php }?>
    </div>
    <dl class="info-discount__total">
        <dt>구매 시 예상 적립금</dt>
        <dd><em devprice="mileage"><?php echo g_price($TPL_VAR["cartSummary"]["mileage"])?></em><?php echo $TPL_VAR["mileageUnit"]?></dd>
    </dl>
</div>