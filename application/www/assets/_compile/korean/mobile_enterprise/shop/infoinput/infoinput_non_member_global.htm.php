<?php /* Template_ 2.2.8 2020/08/31 15:57:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_non_member_global.htm 000009809 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<!-- [S] 주문자 정보 -->
<section class="br__infoinput__buyer">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            주문자 정보
            <span class="infoinput__toggle__sub">
                    <span id="devMiniViewName"></span>
                    <span id="devMiniViewPhone"></span>
                </span>
            <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-buyer">
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">주문자</label>
                    <input type="text" id="devBuyerName" name="devBuyerName" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerName"]?>" title="주문자">
                </div>
                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devBuyerMobile1" class="info-buyer__form__label">Tel</label>
                    <div class="flexWrap">
                        <select id="devBuyerMobile1" name="devBuyerMobile1" class="info-buyer__form__select">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                        </select>
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="Tel">
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">이메일 주소</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="이메일 주소">
                        <span class="hyphen_2">@</span>
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" title="이메일 주소">
                    </div>
                </div>
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">주문 비밀번호</label>
                    <input id="devOrderPassword" name="devOrderPassword" class="info-buyer__form__input"  type="password"  title="주문 비밀번호" maxlength="16">
                    <p class="info-buyer__form__notice">영문 대소문자/숫자/특수문자 중 2가지 이상 조합, <br>최소 8자~최대 16자 입력</p>
                </div>
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">주문 비밀번호 확인</label>
                    <input id="devOrderPasswordCompare" name="devOrderPasswordCompare" class="info-buyer__form__input"  type="password"  title="주문 비밀번호 확인" maxlength="16">
                    <p class="info-buyer__form__notice">비밀번호 확인을 위해 다시 한번 입력해 주세요.</p>
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
            배송지 정보
            <span class="infoinput__toggle__sub" id="devMiniAddress"></span>
            <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-buyer devRecipientContents">
                <div class="info-buyer__form">
                    <input type="checkbox" class="info-buyer__form__check devSameBuyerInfo" id="sam-buyer-checkbox"><label for="sam-buyer-checkbox">주문자 정보와 동일</label>
                </div>
                <div class="info-buyer__form">
                    <label for="devRecipientName" class="info-buyer__form__label">이름</label>
                    <input type="text" id="devRecipientName" name="devRecipientName" class="devRecipientName" title="받는 분 이름">
                </div>
                <!-- @TODO 주소 입력 형식 변경 -->
                <div class="info-buyer__form info-buyer__form--addr">
                    <label for="devCountry" class="info-buyer__form__label">Country</label>
                    <select name="country" id="devCountry" class="buyer__form__select devNationArea">
                        <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                    </select>
                </div>
                <div class="info-buyer__form info-buyer__form--addr">
                    <label for="address_zip" class="info-buyer__form__label">Zip/Postal Code</label>
                    <input type="text" id="address_zip" name="devRecipientZip" class="devRecipientZip" title="Zip/Postal Code">
                </div>
                <div class="info-buyer__form info-buyer__form--addr">
                    <label for="address_line1" class="info-buyer__form__label">Address line 1</label>
                    <input type="text" id="address_line1" name="devRecipientAddr1" class="devRecipientAddr1" title="Address line 1">
                </div>
                <div class="info-buyer__form info-buyer__form--addr">
                    <label for="address_line2" class="info-buyer__form__label">Address line 2</label>
                    <input type="text" id="address_line2" name="devRecipientAddr2" class="devRecipientAddr2" title="Address line 2">
                </div>
                <div class="info-buyer__form info-buyer__form--addr">
                    <label for="devCity" class="info-buyer__form__label">City</label>
                    <input type="text" title="City" name="city" id="devCity">
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

                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devRecipientMobile1" class="info-buyer__form__label">Tel</label>
                    <div class="flexWrap">
                        <select id="devRecipientMobile1" name="devRecipientMobile1" class="info-buyer__form__select devRecipientMobile1 devNationArea">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                        </select>
                        <input type="text" name="devRecipientMobile2" class="info-buyer__form__input devRecipientMobile2" title="Tel">
                    </div>
                </div>


                <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents">
                        <input type="text" class="info-buyer__form__input devDeliveryMessage" name="devDeliveryMessage">
                        <div class="counting">
                            <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [E] 배송지 정보 -->