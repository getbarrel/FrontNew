<?php /* Template_ 2.2.8 2024/03/25 11:45:21 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_non_member.htm 000009331 */ ?>
<div class="br__infoinput__order">
    <!-- 비회원 주문 S -->
    <div class="br__infoinput__non-member">
        <!-- 주문자 정보 S -->
        <section class="br__infoinput__buyer">
            <div class="page-title">
                <div class="title-md">주문 고객 정보</div>
            </div>
            <div class="info-buyer">
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">주문자</label>
                    <input type="text" id="devBuyerName" name="devBuyerName" class="info-buyer__form__input" value="" placeholder="이름" title="주문자 이름" />
                </div>
                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devBuyerMobile1" class="info-buyer__form__label">휴대폰</label>
                    <div class="flexWrap">
                        <select id="devBuyerMobile1" name="devBuyerMobile1" class="info-buyer__form__select">
                            <option>010</option>
                            <option>011</option>
                            <option>016</option>
                            <option>017</option>
                            <option>018</option>
                            <option>019</option>
                        </select>
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="" placeholder="0000" title="휴대폰 번호" />
                        <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" class="info-buyer__form__input" value="" placeholder="0000" title="휴대폰 번호" />
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">이메일</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="" placeholder="이메일 아이디" title="주문자 이메일" />
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="" placeholder="이메일 도메인" title="주문자 이메일" />
                    </div>
                    <select id="devEmailHostSelect" class="info-buyer__form__select">
                        <option value="">직접 입력</option>
                        <option value="naver.com">naver.com</option>
                        <option value="gmail.com">gmail.com</option>
                        <option value="hotmail.com">hotmail.com</option>
                        <option value="hanmail.net">hanmail.net</option>
                        <option value="daum.net">daum.net</option>
                        <option value="nate.com">nate.com</option>
                    </select>
                    <p class="info-buyer__form__notice txt-red">SMS 및 이메일로 주문 진행상황을 안내해드립니다.</p>
                </div>
                <div class="info-buyer__form info-buyer__form--password">
                    <div class="br__form-item">
                        <label for="devBuyerName" class="info-buyer__form__label">주문 비밀번호</label>
                        <input id="devOrderPassword" name="devOrderPassword" class="info-buyer__form__input br__form-input" type="password" title="주문 비밀번호" placeholder="주문 비밀번호" value="" maxlength="16" />
                    </div>
                    <div class="br__form-item">
                        <label for="devBuyerName" class="info-buyer__form__label">주문 비밀번호 확인</label>
                        <input id="devOrderPasswordCompare" name="devOrderPasswordCompare" class="info-buyer__form__input br__form-input" type="password" title="주문 비밀번호 확인" placeholder="주문 비밀번호 확인" value="" maxlength="16" />
                    </div>
                    <p class="info-buyer__form__notice">영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>
                </div>
                <div class="info-buyer__form info-buyer__form--check">
                    <label for="devBuyerName" class="info-buyer__form__label">[미성년확인] 만 14세 이상입니까?</label>
                    <label class="inputs__label">
                        <input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="Y" />
                        <span>예</span>
                    </label>
                    <label class="inputs__label">
                        <input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="N" />
                        <span>아니오</span>
                    </label>
                </div>
            </div>
        </section>
        <!-- 주문자 정보 E -->

        <!-- 배송 정보 S -->
        <section class="br__infoinput__address">
            <div class="page-title">
                <div class="title-md">배송 정보</div>
            </div>
            <div class="info-buyer devRecipientContents">
                <div class="info-buyer__form info-buyer__form--check">
                    <div class="flexWrap">
                        <input type="checkbox" class="info-buyer__form__check devSameBuyerInfo" id="sam-buyer-checkbox" />
                        <label for="sam-buyer-checkbox">주문 고객 정보와 동일</label>
                    </div>
                </div>
                <div class="info-buyer__form">
                    <label for="devRecipientName" class="info-buyer__form__label">이름</label>
                    <input type="text" id="devRecipientName" name="devRecipientName" class="devRecipientName" title="받는 분 이름" placeholder="이름" value="" />
                </div>
                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devRecipientMobile1" class="info-buyer__form__label">휴대폰</label>
                    <div class="flexWrap">
                        <select id="devRecipientMobile1" name="devRecipientMobile1" class="info-buyer__form__select devRecipientMobile1">
                            <option>010</option>
                            <option>011</option>
                            <option>016</option>
                            <option>017</option>
                            <option>018</option>
                            <option>019</option>
                        </select>
                        <input type="text" name="devRecipientMobile2" class="info-buyer__form__input devRecipientMobile2" title="받는 분 휴대폰 번호" placeholder="0000" value="" />
                        <input type="text" name="devRecipientMobile3" class="info-buyer__form__input devRecipientMobile3" title="받는 분 휴대폰 번호" placeholder="0000" value="" />
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--addr">
                    <label class="info-buyer__form__label">주소</label>
                    <div class="info-buyer__form__find-addr">
                        <input type="text" class="info-buyer__form__input devRecipientZip" name="devRecipientZip" title="받는 분 주소" placeholder="우편번호" value="" readonly />
                        <button class="info-buyer__form__btn devRecipientZipPopupButton">검색</button>
                    </div>
                    <input type="text" class="info-buyer__form__input devRecipientAddr1" name="devRecipientAddr1" title="받는 분 주소" placeholder="" value="" readonly />
                    <input type="text" class="info-buyer__form__input devRecipientAddr2" name="devRecipientAddr2" title="받는 분 상세주소" placeholder="상세주소" />
                </div>
                <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
                    <select class="devDeliveryMessageSelectBox" name="devDeliveryMessageSelectBox">
                        <option value="">배송요청사항 선택</option>
                        <option>부재 시 경비실에 맡겨주세요.</option>
                        <option>부재 시 휴대폰으로 연락주세요.</option>
                        <option>집 앞에 놓아주세요.</option>
                        <option>배송 전에 연락주세요.</option>
                        <option value="direct">직접입력</option>
                    </select>
                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="">
                        <input type="text" class="info-buyer__form__input devDeliveryMessage" name="devDeliveryMessage" placeholder="배송 메시지 입력" value="문 앞에 놔주세요." devmaxlength="30" />
                    </div>
                </div>
            </div>
        </section>
        <!-- 배송 정보 E -->
    </div>
    <!-- 비회원 주문 E -->
</div>