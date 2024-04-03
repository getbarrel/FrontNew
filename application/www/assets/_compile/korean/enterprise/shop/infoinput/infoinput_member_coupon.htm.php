<?php /* Template_ 2.2.8 2024/03/26 16:04:55 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_member_coupon.htm 000004873 */ ?>
<div class="fb__infoinput-title">
    <div class="title-md">쿠폰 / 적립금</div>
</div>
<ul class="discount-box">
    <li class="discount-box__list">
        <div class="discount-box__item">
            <div class="discount-box__tit">쿠폰할인</div>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
            <div class="discount-box__cont">
                <span>이벤트 기간에는 쿠폰 사용이 불가능합니다.</span>
            </div>
<?php }else{?>
            <div class="discount-box__cont">
                <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" class="discount-box__amount fb__form-input dim"  id="devUseCouponInputText" readonly /><span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_VAR["userCouponCnt"]> 0){?>
                <button class="btn-default btn-dark-line discount-box__btn" id="devUseCouponButton">쿠폰 선택</button>
                <button class="btn-default btn-dark-line discount-box__btn discount-box__btn-cancel" id="devCouponButtonCancel">적용 취소</button>
<?php }?>
            </div>
            <div class="discount-box__number">보유 쿠폰 <span><?php echo $TPL_VAR["userCouponCnt"]?></span>개</div>
<?php }?>
        </div>
        <p class="discount-box__important" style="display: none"><!-- 오류 / 특이사항 메시지 영역(숨김처리 되어 있음/ 사용시 숨김처리 삭제) --></p>
    </li>
    <li class="discount-box__list">
        <div class="discount-box__item">
            <div class="discount-box__tit">배송비 할인 쿠폰</div>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
            <div class="discount-box__cont">
                <span>이벤트 기간에는 쿠폰 사용이 불가능합니다.</span>
            </div>
<?php }else{?>
            <div class="discount-box__cont">
                <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" class="discount-box__amount fb__form-input dim" id="devUseDeliveryCouponInputText" readonly /> <span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_VAR["userDeliveryCouponCnt"]> 0){?>
                <button class="btn-default btn-dark-line discount-box__btn" id="devUseDeliveryCouponButton">배송비쿠폰 선택</button>
                <button class="btn-default btn-dark-line discount-box__btn discount-box__btn-cancel" id="devDeliveryCouponButtonCancel">적용 취소</button>
<?php }?>
            </div>
            <div class="discount-box__number">보유 쿠폰 <span><?php echo $TPL_VAR["userDeliveryCouponCnt"]?></span>개</div>
<?php }?>
        </div>
        <p class="discount-box__important" style="display: none"><!-- 오류 / 특이사항 메시지 영역(숨김처리 되어 있음/ 사용시 숨김처리 삭제) --></p>
    </li>
    <li class="discount-box__list">
        <div class="discount-box__item">
            <div class="discount-box__tit"><?php echo $TPL_VAR["mileageName"]?></div>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
            <div class="discount-box__cont">
                <span>이벤트 기간에는 적립금 사용이 불가능합니다.</span>
            </div>
<?php }else{?>
            <div class="discount-box__cont">
                <input type="hidden" id="mileageConditionMinBuyAmt" value="<?php echo $TPL_VAR["mileageConditionMinBuyAmt"]?>" />
                <input type="text" id="devUseMileage" class="fb__form-input dim" value="0" /><span class="text_p"><?php echo $TPL_VAR["mileageUnit"]?></span>

                <div class="fb__form-item fb__form-btn">
                    <input type="checkbox" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>" />
                    <label class="btn-default btn-dark-line" for="devAllUseMileageCheckBox"><?php echo $TPL_VAR["mileageName"]?> 전체 사용</label>
                </div>
            </div>
            <div class="discount-box__number">(사용가능 적립금<span><?php echo g_price($TPL_VAR["userMileage"])?></span><?php echo $TPL_VAR["mileageUnit"]?>)</div>
<?php }?>
        </div>
        <p class="discount-box__important" style="display: none"><!-- 오류 / 특이사항 메시지 영역(숨김처리 되어 있음/ 사용시 숨김처리 삭제) --></p>
    </li>
    <li class="discount-box__list-total">
        <div class="discount-box__list-total__tit">구매 시 예상 적립금</div>
        <div class="discount-box__list-total__cont"><span devprice="mileage"><?php echo g_price($TPL_VAR["cartSummary"]["mileage"])?></span><?php echo $TPL_VAR["mileageUnit"]?></div>
    </li>
</ul>