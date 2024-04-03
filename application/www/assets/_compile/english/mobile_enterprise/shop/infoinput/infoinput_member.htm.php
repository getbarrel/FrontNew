<?php /* Template_ 2.2.8 2021/08/23 18:00:14 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_member.htm 000018577 */ ?>
<!-- [S] 주문자 정보 -->
<section class="br__infoinput__buyer">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            Orderer Information
            <span class="infoinput__toggle__sub">
<?php if($TPL_VAR["buyerName"]){?><span><?php echo $TPL_VAR["buyerName"]?>&nbsp;</span><?php }?>
<?php if($TPL_VAR["buyerMobile2"]){?><span><?php echo $TPL_VAR["buyerMobile1"]?>-<?php echo $TPL_VAR["buyerMobile2"]?>-<?php echo $TPL_VAR["buyerMobile3"]?></span><?php }?>
                </span>
            <button type="button" class="infoinput__toggle__btn">View/hide information button</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-buyer">
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">Name</label>
                    <input type="text" id="devBuyerName" name="devBuyerName" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerName"]?>" title="Orderer Name">
                </div>
                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devBuyerMobile1" class="info-buyer__form__label">Tel</label>

                    <div class="flexWrap">
                        <select id="devBuyerMobile1" name="devBuyerMobile1" class="info-buyer__form__select">
                            <option <?php if($TPL_VAR["buyerMobile1"]=='010'){?>selected<?php }?>>010</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='011'){?>selected<?php }?>>011</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='016'){?>selected<?php }?>>016</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='017'){?>selected<?php }?>>017</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='018'){?>selected<?php }?>>018</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='019'){?>selected<?php }?>>019</option>
                        </select>
                        <span class="hyphen">-</span>
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="Tel">
                        <span class="hyphen">-</span>
                        <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile3"]?>" title="Tel">
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">Email</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="Orderer E-mail">
                        <span class="hyphen_2">@</span>
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" title="Orderer E-mail">
                    </div>
                    <select id="devEmailHostSelect" name="devEmailHostSelect" class="info-buyer__form__select">
                        <option value="" selected>Direct input.</option>
                        <option value="naver.com">naver.com</option>
                        <option value="gmail.com">gmail.com</option>
                        <option value="hotmail.com">hotmail.com</option>
                        <option value="hanmail.net">hanmail.net</option>
                        <option value="daum.net">daum.net</option>
                        <option value="nate.com">nate.com</option>
                    </select>
                    <p class="info-buyer__form__notice">SMS and e-mail us the progress of your order.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [E] 주문자 정보 -->

<!-- [S] 배송지 정보 -->
<section class="br__infoinput__address">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            Shipping Information
            <span class="infoinput__toggle__sub" id="devMiniAddress"></span>
            <button type="button" class="infoinput__toggle__btn">View/hide information button</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="br__tabs">
                <ul class="br__tabs__list">
                    <li class="br__tabs__box" data-target="list">
                        <button type="button" class="br__tabs__btn br__tabs__btn--active" data-target="list" devRecipientTypeSelect="address">기본 배송지</button>
                    </li>
					<li class="br__tabs__box" data-target="list1">
                        <button type="button" class="br__tabs__btn" data-target="list1" devRecipientTypeSelect="addressOrder">Recent shipping address</button>
                    </li>
                    <li class="br__tabs__box" data-target="new">
                        <button type="button" class="br__tabs__btn" data-target="new"  devRecipientTypeSelect="input">New Shipping address</button>
                    </li>
                </ul>
                <div class="br__tabs__content br__tabs__content--show devRecipientContents" data-target="list">
                    <div class="">
                        <div class="info-addr__recent">
                            <form id="devOrderAddressListForm"></form>

                            <button class="info-addr__recent__btn" id="devAddressListButton">Shpping address list</button>

                            <ul  id="devOrderAddressListContent" class="info-addr__recent__list">
                                <li id="devOrderAddressListLoading" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>Loading ...</strong></p>
                                    </div>
                                </li>

                                <li id="devOrderAddressListEmpty" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>No shipping address</strong></p>
                                    </div>
                                </li>

                                <li class="info-addr__recent__box devOrderAddress devForbizTpl"  id="devOrderAddressList">
                                    <label class="info-addr__recent__label">
                                        <div class="info-addr__recent__info">
                                            <span class="info-addr__recent__name">{[recipient]} ({[shipping_name]}){[#if isBasic]}<span> - Default</span>{[/if]}</span>
                                            <span class="info-addr__recent__addr">{[address1]} {[address2]}</span>
                                            <span class="info-addr__recent__phone">{[mobile]}</span>
                                        </div>
                                        <input type="radio" class="devOrderAddressRadio" name="orderAddress" data-address1="{[address1]}" value="{[index]}">

                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
				<div class="br__tabs__content devRecipientContents" data-target="list1">
                    <div class="">
                        <div class="info-addr__recent">
                            <form id="devOrderAddressListOrderForm"></form>

                            <ul  id="devOrderAddressListOrderContent" class="info-addr__recent__list">
                                <li id="devOrderAddressListOrderLoading" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>Loading ...</strong></p>
                                    </div>
                                </li>

                                <li id="devOrderAddressListOrderEmpty" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>No shipping address</strong></p>
                                    </div>
                                </li>

                                <li class="info-addr__recent__box devOrderAddress devForbizTpl"  id="devOrderAddressListOrder">
                                    <label class="info-addr__recent__label">
                                        <div class="info-addr__recent__info">
                                            <span class="info-addr__recent__name">{[recipient]}</span>
                                            <span class="info-addr__recent__addr">{[address1]} {[address2]}</span>
                                            <span class="info-addr__recent__phone">{[mobile]}</span>
                                        </div>
                                        <input type="radio" class="devOrderAddressOrderRadio" name="orderAddress" data-address1="{[address1]}" value="{[index]}">

                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="br__tabs__content devRecipientContents" data-target="new">
                    <div class="info-buyer">
                        <div class="info-buyer__form">
                            <label for="devRecipientName" class="info-buyer__form__label">Name</label>
                            <input type="text" id="devRecipientName" class="devRecipientName" name="devRecipientName" title="받는 분 이름">
                        </div>
                        <div class="info-buyer__form info-buyer__form--phone">
                            <label for="devRecipientMobile1" class="info-buyer__form__label">Tel</label>
                            <div class="flexWrap">
                                <select id="devRecipientMobile1" name="devRecipientMobile1" class="info-buyer__form__select devRecipientMobile1">                                           <option>010</option>
                                    <option>011</option>
                                    <option>016</option>
                                    <option>017</option>
                                    <option>018</option>
                                    <option>019</option>
                                </select>
                                <span class="hyphen">-</span>
                                <input type="text" class="info-buyer__form__input devRecipientMobile2" name="devRecipientMobile2" title="Orderer Phone">
                                <span class="hyphen">-</span>
                                <input type="text" class="info-buyer__form__input devRecipientMobile3" name="devRecipientMobile3" title="Orderer Phone">
                            </div>
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label class="info-buyer__form__label">Address</label>
                            <div class="info-buyer__form__find-addr">
                                <input type="text" class="info-buyer__form__input devRecipientZip" name="devRecipientZip" title="Orderer Address 1" readonly>
                                <button class="info-buyer__form__btn devRecipientZipPopupButton">Zip code search</button>
                            </div>
                            <input type="text" class="info-buyer__form__input devRecipientAddr1" name="devRecipientAddr1" title="Orderer Address 1" readonly>
                            <input type="text" class="info-buyer__form__input devRecipientAddr2" name="devRecipientAddr2" title="Orderer Address 2" placeholder="Orderer detail Address">
                        </div>

                        <div class="info-buyer__form">
                            <input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check" checked><label for="devBasicAddressBookCheckBox">Set as default</label>
                            <input type="checkbox" id="devAddAddressBookCheckBox" class="info-buyer__form__check" checked><label for="devAddAddressBookCheckBox">Add to shipping list</label>
                        </div>
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents info-addr">
                    <div class="info-buyer__form">
                        <label class="info-buyer__form__label">Shipping comment</label>
                    </div>
                    <select class="devDeliveryMessageSelectBox" name="devDeliveryMessageSelectBox">
                        <option value="">Select shiping request</option>
                        <option>Please leave it to the security office if unavailable</option>
                        <option>Please contact me by cell phone if unavailable</option>
                        <option>Place in fron to the porch</option>
                        <option>Please contact before shipping</option>
                        <option value="direct">Direct input.</option>
                    </select>
                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                        <input type="text" class="info-buyer__form__input devDeliveryMessage" name="devDeliveryMessage">
                        <div class="counting">
                            <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [E] 배송지 정보 -->

<!-- [S] 쿠폰/적립금 정보 -->
<section class="br__infoinput__benefit">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            Coupons/Mileage
            <span class="infoinput__toggle__sub">Apply coupons <span id=""devUseCouponCntView"">0</span> / Mileage $<span id=""devUseMileageView"">0</span></span>
            <button type="button" class="infoinput__toggle__btn">View/hide information button</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-benefit">
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
                <div class="info-benefit__form info-benefit__form--coupon">
                    <label class="info-benefit__form__label"><span>이벤트 기간에는 쿠폰 사용이 불가능합니다.</span></label>
                </div>
<?php }else{?>
                <div class="info-benefit__form info-benefit__form--coupon">
                    <label class="info-benefit__form__label">Coupons: <span>(holding coupon(s): <?php echo $TPL_VAR["userCouponCnt"]?>)</span></label>
                    <div class="info-benefit__form__inner">
                        <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" id="devUseCouponInputText" readonly><span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        <button type="button" id="devUseCouponButton">Valid Coupons</button>
                        <button type="button" id="devCancelCouponButton">Cancel</button>
                    </div>
                </div>

                <div class="info-benefit__form info-benefit__form--coupon">
                    <label class="info-benefit__form__label">(english)배송비쿠폰 할인 <span>(english)(보유 쿠폰: <?php echo $TPL_VAR["userDeliveryCouponCnt"]?>장)</span></label>
                    <div class="info-benefit__form__inner">
                        <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" id="devUseDeliveryCouponInputText" readonly><span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        <button type="button" id="devUseDeliveryCouponButton">Valid Coupons</button>
                        <button type="button" id="devDeliveryCouponButtonCancel">Cancel</button>
                    </div>
                </div>
<?php }?>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
                <div class="info-benefit__form info-benefit__form--mileage">
                    <label class="info-benefit__form__label"><span>이벤트 기간에는 적립금 사용이 불가능합니다.</span></label>
                </div>
<?php }else{?>
                <div class="info-benefit__form info-benefit__form--mileage">
                    <label class="info-benefit__form__label"><?php echo $TPL_VAR["mileageName"]?> <span>(Valid Reward<?php echo g_price($TPL_VAR["userMileage"])?><?php echo $TPL_VAR["mileageUnit"]?>)</span></label>
                    <div class="info-benefit__form__inner">
                        <input type="hidden" id="mileageConditionMinBuyAmt" value="<?php echo $TPL_VAR["mileageConditionMinBuyAmt"]?>" />
                        <input type="text" id="devUseMileage"><span><?php echo $TPL_VAR["mileageUnit"]?></span>
                        <div class="info-benefit__form__btn">
                            <input type="checkbox" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>">
                            <label for="devAllUseMileageCheckBox">use all</label>
                        </div>
                    </div>
                </div>
<?php }?>
                <div class="info-benefit__form">
                    <p class="info-benefit__form__label">Expected Mileage<span class="info-benefit__form__value">+ <?php echo $TPL_VAR["fbUnit"]["f"]?><span  devPrice="mileage"><?php echo g_price($TPL_VAR["cartSummary"]["companySumMileagePrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [E] 쿠폰/적립금 정보 -->