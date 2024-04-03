<?php /* Template_ 2.2.8 2020/12/15 16:22:18 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_non_member.htm 000011390 */ ?>
<!-- [S] 주문자 정보 -->
<section class="br__infoinput__buyer">
    <div class="infoinput__toggle">
        <h3 class="infoinput__toggle__title">
            Orderer Information
            <span class="infoinput__toggle__sub">
                    <span id="devMiniViewName"></span>
                    <span id="devMiniViewPhone"></span>
                </span>
            <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
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
                        <span class="hyphen"></span>
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="휴대폰 번호">
                        <span class="hyphen"></span>
                        <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile3"]?>" title="휴대폰 번호">
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">Email</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="주문자 이메일">
                        <span class="hyphen_2">@</span>
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" title="주문자 이메일">
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
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">Order Password</label>
                    <input id="devOrderPassword" name="devOrderPassword" class="info-buyer__form__input"  type="password"  title="주문 비밀번호" maxlength="16">
                    <p class="info-buyer__form__notice">Two or more combinations of uppercase and lowercase letters/numeric/special characters; min. 8 to 16 characters maximum.</p>
                </div>
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">order password comfirmation</label>
                    <input id="devOrderPasswordCompare" name="devOrderPasswordCompare" class="info-buyer__form__input"  type="password"  title="주문 비밀번호 확인" maxlength="16">
                    <p class="info-buyer__form__notice">Enter again to confirm your password.</p>
                </div>
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">[미성년확인] 만 14세 이상입니까?</label>
                    <label class="inputs__label" style="margin-right: 20px;font-size: 15px;"><input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="Y"> <span style="vertical-align: middle">Yes</span></label>
                    <label class="inputs__label" style="font-size: 15px;"><input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="N"> <span style="vertical-align: middle">No</span></label>
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
            <button type="button" class="infoinput__toggle__btn">정보 보기/감추기 버튼</button>
        </h3>
        <div class="infoinput__toggle__content">
            <div class="info-buyer devRecipientContents">
                <div class="info-buyer__form">
                    <input type="checkbox" class="info-buyer__form__check devSameBuyerInfo" id="sam-buyer-checkbox"><label for="sam-buyer-checkbox">주문자 정보와 동일</label>
                </div>
                <div class="info-buyer__form">
                    <label for="devRecipientName" class="info-buyer__form__label">Name</label>
                    <input type="text" id="devRecipientName" name="devRecipientName" class="devRecipientName" title="받는 분 이름">
                </div>

                <div class="info-buyer__form info-buyer__form--addr">
                    <label class="info-buyer__form__label">Address</label>
                    <div class="info-buyer__form__find-addr">
                        <input type="text" class="info-buyer__form__input devRecipientZip" name="devRecipientZip" title="받는 분 주소" readonly>
                        <button class="info-buyer__form__btn devRecipientZipPopupButton">Zip code search</button>
                    </div>
                    <input type="text" class="info-buyer__form__input devRecipientAddr1" name="devRecipientAddr1" title="받는 분 주소" readonly>
                    <input type="text" class="info-buyer__form__input devRecipientAddr2" name="devRecipientAddr2" title="받는 분 상세주소" placeholder="상세주소를 입력해 주세요.">
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
                        <span class="hyphen"></span>
                        <input type="text" name="devRecipientMobile2" class="info-buyer__form__input devRecipientMobile2" title="받는 분 휴대폰 번호">
                        <span class="hyphen"></span>
                        <input type="text" name="devRecipientMobile3" class="info-buyer__form__input devRecipientMobile3" title="받는 분 휴대폰 번호">
                    </div>
                </div>

                <!-- 에러방지용 -->
                <!-- 개발 완료 후 불필요한 경우 삭제 -->
                <div class="info-buyer__form info-buyer__form--phone" style="display:none;">
                    <div class="flexWrap">
                        <label for="devBuyerTel1" class="info-buyer__form__label">Tel</label>
                        <select id="devBuyerTel1" class="info-buyer__form__select devRecipientMobile1" name="devRecipientMobile1">                                           <option>010</option>
                            <option>011</option>
                            <option>016</option>
                            <option>017</option>
                            <option>018</option>
                            <option>019</option>
                        </select>
                        <span class="hyphen"></span>
                        <input type="text" class="info-buyer__form__input" id="devBuyerTel2" name="devBuyerTel2" title="전화번호">
                        <span class="hyphen"></span>
                        <input type="text" class="info-buyer__form__input" id="devBuyerTel3" name="devBuyerTel3" title="전화번호">
                    </div>
                </div>

                <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
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