<?php /* Template_ 2.2.8 2021/11/09 15:38:14 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_member_global.htm 000020628 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<!-- [S] 주문자 정보 -->
<section class="br__infoinput__buyer">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            Orderer Information
            <span class="infoinput__toggle__sub">
<?php if($TPL_VAR["buyerName"]){?><span><?php echo $TPL_VAR["buyerName"]?></span><?php }?>
<?php if($TPL_VAR["buyerMobile2"]){?><span><?php echo $TPL_VAR["buyerMobile1"]?>-<?php echo $TPL_VAR["buyerMobile2"]?>-<?php echo $TPL_VAR["buyerMobile3"]?></span><?php }?>
                </span>
            <button type="button" class="infoinput__toggle__btn">View/hide information button</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-buyer">
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">Name</label>
                    <input type="text" id="devBuyerName" name="devBuyerName" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerName"]?>" title="Name">
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
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="Phone Number">
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">Email</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="E-mail address">
                        <span class="hyphen_2">@</span>
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" title="E-mail address">
                    </div>
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
                        <button type="button" class="br__tabs__btn br__tabs__btn--active" data-target="list" devRecipientTypeSelect="address"><?php if($TPL_VAR["langType"]=='korean'){?>기본 배송지<?php }else{?>Default address<?php }?></button>
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
                            <div class="info-addr__recent__select devDeliveryMessageContents">
                                <div class="info-buyer__form info-buyer__form--request">
                                    <div class="info-buyer__form">
                                        <label class="info-buyer__form__label">Shipping comment</label>
                                    </div>
                                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents">
                                        <input type="text" class="info-buyer__form__input devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
							<div class="info-addr__recent__select devDeliveryMessageContents">
                                <div class="info-buyer__form info-buyer__form--request">
                                    <div class="info-buyer__form">
                                        <label class="info-buyer__form__label">Shipping comment</label>
                                    </div>
                                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents">
                                        <input type="text" class="info-buyer__form__input devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="br__tabs__content devRecipientContents" data-target="new">
                    <div class="info-buyer">
                        <div class="info-buyer__form">
                            <label for="devRecipientName" class="info-buyer__form__label">Name</label>
                            <input type="text" id="devRecipientName" name="devRecipientName" class="devRecipientName" title="받는 분 이름">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="devCountry" class="info-buyer__form__label">Country</label>
                            <select name="country" id="devCountry" class="buyer__form__select devNationArea">
                                <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                            </select>
                        </div>

                        <!-- @TODO 주소 입력 형식 변경 -->
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="address_zip" class="info-buyer__form__label">Zip/Postal Code</label>
                            <input type="text" id="address_zip" class="devRecipientZip" name="devRecipientZip" title="Zip/Postal Code">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="address_line1" class="info-buyer__form__label">Address line 1</label>
                            <input type="text" id="address_line1" class="devRecipientAddr1" name="devRecipientAddr1" title="Address line 1">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="address_line2" class="info-buyer__form__label">Address line 2</label>
                            <input type="text" id="address_line2" class="devRecipientAddr2" name="devRecipientAddr2" title="Address line 2">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="devCity" class="info-buyer__form__label">City</label>
                            <input type="text"  title="City" name="city" id="devCity" >
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label for="devStateSelect" class="info-buyer__form__label">State/Province</label>
                            <select id="devStateSelect" name="devStateSelect">
                                <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                            </select>

                            <input type="text" style="display:none;" id="devStateText"  name="state" title="State/Province" >
                        </div>
                        <!--<div class="info-buyer__form info-buyer__form&#45;&#45;addr">
                            <label for="address_state2" class="info-buyer__form__label">State/Province</label>
                            <select name="" id="address_state2" class="buyer__form__select">
                                <option value="">Country</option>
                                <option value="">USA</option>
                            </select>
                        </div>-->
                        <!-- @TODO 휴대폰 입력 형식 변경 -->
                        <div class="info-buyer__form info-buyer__form--phone">
                            <label for="devRecipientMobile1" class="info-buyer__form__label"> Tel</label>
                            <div class="flexWrap">
                                <select id="devRecipientMobile1" name="devRecipientMobile1" class="info-buyer__form__select devRecipientMobile1 devNationArea">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                                </select>
                                <input type="text" name="devRecipientMobile2" class="info-buyer__form__input devRecipientMobile2" title="Orderer Phone">
                            </div>
                        </div>
                        <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContentsNew">
                            <div class="info-buyer__form__direct devDeliveryMessageDirectContents">
                                <input type="text" class="info-buyer__form__input devDeliveryMessage" name="devDeliveryMessage">
                                <div class="counting">
                                    <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-buyer__form">
                            <input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check" checked><label for="devBasicAddressBookCheckBox">Set as default</label>
                            <br>
                            <input type="checkbox" id="devAddAddressBookCheckBox" class="info-buyer__form__check" checked><label for="devAddAddressBookCheckBox">Add to shipping list</label>
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
<?php if($TPL_VAR["langType"]=='korean'){?>
            Coupons/Mileage
<?php }else{?>
            Coupons/Reward
<?php }?>
            <span class="infoinput__toggle__sub">
<?php if($TPL_VAR["langType"]=='korean'){?>
                Apply coupons <span id=""devUseCouponCntView"">0</span> / Mileage $<span id=""devUseMileageView"">0</span></span>
<?php }else{?>
                 Apply coupons <span id="devUseCouponCntView">0</span> / Reward $<span id="devUseMileageView">0</span>
<?php }?>
            <button type="button" class="infoinput__toggle__btn">View/hide information button</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-benefit">
                <div class="info-benefit__form info-benefit__form--coupon">
                    <label class="info-benefit__form__label">Coupons: <span>(holding coupon(s): <?php echo $TPL_VAR["userCouponCnt"]?>)</span></label>
                    <div class="info-benefit__form__inner">
                        <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" id="devUseCouponInputText" readonly><span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        <button type="button" id="devUseCouponButton" class="info-benefit__form--coupon__valid">Valid Coupons</button>
                        <button type="button" id="devCancelCouponButton"  class="info-benefit__form--coupon__cancel">Cancel</button>
                    </div>
                </div>
                <div class="info-benefit__form info-benefit__form--mileage">
                    <label class="info-benefit__form__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <?php echo $TPL_VAR["mileageName"]?>

<?php }else{?>
                        Reward
<?php }?>
                        <span>(Valid Reward <?php echo $TPL_VAR["mileageUnit"]?><?php echo g_price($TPL_VAR["userMileage"])?>)</span>
                    </label>
                    <div class="info-benefit__form__inner">
                        <span><?php echo $TPL_VAR["mileageUnit"]?></span><input type="text" id="devUseMileage">
                        <div class="info-benefit__form__btn">
                            <input type="checkbox" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>">
                            <label for="devAllUseMileageCheckBox">use all</label>
                        </div>
                    </div>
                </div>
                <div class="info-benefit__form">
                    <p class="info-benefit__form__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        Expected Mileage
<?php }else{?>
                        Expected Reward
<?php }?>
                        <span class="info-benefit__form__value">+<?php echo $TPL_VAR["fbUnit"]["f"]?><span  devPrice="companySumMileagePrice"><?php echo g_price($TPL_VAR["cartSummary"]["companySumMileagePrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [E] 쿠폰/적립금 정보 -->