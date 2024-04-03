<?php /* Template_ 2.2.8 2024/02/12 01:11:04 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_non_member.htm 000013862 */ 
$TPL_cartProductList_1=empty($TPL_VAR["cartProductList"])||!is_array($TPL_VAR["cartProductList"])?0:count($TPL_VAR["cartProductList"]);?>
<!-- 비회원 주문용 - 배송지  S -->
<section class="fb__infoinput__nonmember">
    <section class="fb__infoinput__customer-info customer-info">
        <div class="fb__infoinput-title">
            <div class="title-md">주문 고객 정보</div>
        </div>

        <ul class="customer-info__box">
            <li class="customer-info__item delivery-info__list-name">
                <div class="customer-info__list">
                    <div class="fb__form-item">
                        <label for="devBuyerName" class="delivery-info__label hide">이름</label>
                        <input type="text" id="devBuyerName" name="devBuyerName" class="fb__form-input" title="주문자 이름" placeholder="이름" value="" />
                    </div>
                </div>
                <div class="customer-info__list">
                    <div class="selectWrap delivery-info__list-phone">
                        <div class="fb__form-item">
                            <label for="devBuyerMobile1" class="delivery-info__label hide">휴대폰</label>
                            <select id="devBuyerMobile1" class="fb__form-select">
                                <option>010</option>
                                <option>011</option>
                                <option>016</option>
                                <option>017</option>
                                <option>018</option>
                                <option>019</option>
                            </select>
                            <input type="text" id="devBuyerMobile2" class="fb__form-input" name="devBuyerMobile2" title="휴대폰 번호" placeholder="0000" value="" />
                            <input type="text" id="devBuyerMobile3" class="fb__form-input" name="devBuyerMobile3" title="휴대폰 번호" placeholder="0000" value="" />
                        </div>
                    </div>
                </div>
                <!-- 오류/안내 메시지 S -->
                <p class="customer-info__list__desc txt-error">SMS 및 이메일로 주문 진행상황을 안내해드립니다.</p>
                <!-- 오류/안내 메시지 E -->
            </li>
            <li class="customer-info__item">
                <div class="title-sm">이메일</div>
                <div class="customer-info__list customer-info__list-email">
                    <div class="fb__form-item">
                        <label for="devBuyerEmailId" class="delivery-info__label hide">이메일 주소</label>
                        <input type="text" id="devBuyerEmailId" class="fb__form-input" name="devBuyerEmailId" title="주문자 이메일" placeholder="이메일" value="" />
                        <input type="text" id="devBuyerEmailHost" class="fb__form-input js__infoinput__email-target" name="devBuyerEmailHost" placeholder="도메인" value="" />
                    </div>
                    <div class="fb__form-item">
                        <select name="" id="" class="js__infoinput__email-select">
                            <option value="">직접입력</option>
                            <option value="naver.com">naver.com</option>
                            <option value="gmail.com">gmail.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                            <option value="nate.com">nate.com</option>
                        </select>
                    </div>
                </div>
                <div class="customer-info__list customer-info__list-pw">
                    <div class="fb__form-item">
                        <label for="devOrderPassword" class="delivery-info__label hide">주문 비밀번호</label>
                        <input type="password" id="devOrderPassword" class="fb__form-input" name="devOrderPassword" title="주문 비밀번호" maxlength="16" placeholder="주문 비밀번호" value="" />
                    </div>
                </div>
                <div class="customer-info__list customer-info__list-pw">
                    <div class="fb__form-item">
                        <label for="devOrderPasswordCompare" class="delivery-info__label hide">주문 비밀번호 확인</label>
                        <input type="password" id="devOrderPasswordCompare" class="fb__form-input" name="devOrderPasswordCompare" title="주문 비밀번호 확인" maxlength="16" placeholder="주문 비밀번호 확인" value="" />
                    </div>
                    <div class="customer-info__list__guide">
                        <p>영문 + 숫자 + 특수문자 2가지 이상 조합 및 8~16자리 입력 필수.</p>
                        <p>비밀번호 확인을 위해 다시 한번 입력해 주세요.</p>
                    </div>
                </div>
                <div class="customer-info__list customer-info__radio">
                    <div class="title-sm">[미성년확인] 만14세 이상입니까?</div>
                    <div class="fb__form-item">
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
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__delivery-info delivery-info devRecipientContents">
        <div class="fb__infoinput-title">
            <div class="title-md">배송 정보</div>
        </div>

        <ul class="delivery-info__box">
            <li class="delivery-info__item delivery-info__list-name">
                <div class="delivery-info__list">
                    <div class="fb__form-item">
                        <label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
                        <input type="text" class="fb__form-input devRecipientName" name="devRecipientName" id="devRecipientName" title="받는 분 이름" placeholder="이름" value="" />
                    </div>
                </div>
                <div class="delivery-info__list">
                    <div class="selectWrap delivery-info__list-phone">
                        <div class="fb__form-item">
                            <label for="devRecipientMobile1" class="delivery-info__label hide">휴대폰</label>
                            <select class="fb__form-select devRecipientMobile1" name="devRecipientMobile1" id="devRecipientMobile1">
                                <option>010</option>
                                <option>011</option>
                                <option>016</option>
                                <option>017</option>
                                <option>018</option>
                                <option>019</option>
                            </select>
                            <input type="text" name="devRecipientMobile2" class="fb__form-input devRecipientMobile2" title="받는 분 휴대폰 번호2" placeholder="0000" value="" />
                            <input type="text" name="devRecipientMobile3" class="fb__form-input devRecipientMobile3" title="받는 분 휴대폰 번호3" placeholder="0000" value="" />
                        </div>
                    </div>
                </div>
                <div class="check-area delivery-info__check-area">
                    <div class="check-area__item fb__form-item">
                        <input type="checkbox" class="devSameBuyerInfo" id="sam-buyer-checkbox" />
                        <label for="sam-buyer-checkbox" class="txt-dark">주문 고객 정보와 동일</label>
                    </div>
                </div>
            </li>
            <li class="delivery-info__item">
                <div class="title-sm">주소</div>
                <div class="delivery-info__list delivery-info__list-address">
                    <div class="form-info-wrap delivery-info__list-group">
                        <div class="fb__form-item">
                            <label for="devRecipientZip" class="delivery-info__label hide">주소</label>
                            <input type="text" class="fb__form-input zip-code devRecipientZip" name="devRecipientZip" id="devRecipientZip" title="받는 분 주소" placeholder="우편번호" value="" readonly />
                            <button class="btn-s btn-dark-line devRecipientZipPopupButton">검색</button>
                        </div>
                        <div class="fb__form-item">
                            <input type="text" class="fb__form-input input-address devRecipientAddr1" name="devRecipientAddr1" title="받는 분 주소" placeholder="주소" value="" readonly />
                        </div>
                        <div class="fb__form-item">
                            <input type="text" class="fb__form-input input-add-detail devRecipientAddr2" name="devRecipientAddr2" title="받는 분 상세주소" placeholder="상세주소" value="" />
                        </div>
                    </div>
                </div>
                <div class="delivery-info__list delivery-info__list-request">
                    <div class="delivery-request nonmember delivery-info__list__input-area input-area">
                        <div class="devDeliveryMessageContents option-box">
                            <div class="fb__form-item">
                                <label for="devDeliveryMessageSelectBox" class="delivery-info__label hide">배송요청사항</label>
                                <select class="fb__form-select devDeliveryMessageSelectBox" name="devDeliveryMessageSelectBox" id="devDeliveryMessageSelectBox">
                                    <option value="">배송요청사항 선택</option>
                                    <option>부재 시 경비실에 맡겨주세요.</option>
                                    <option>부재 시 휴대폰으로 연락주세요.</option>
                                    <option>집 앞에 놓아주세요.</option>
                                    <option>배송 전에 연락주세요.</option>
                                    <option value="direct">직접입력</option>
                                </select>
                            </div>
                            <div class="devDeliveryMessageDirectContents write-area">
                                <div class="fb__form-item">
                                    <label for="devDeliveryMessage1" class="hide">배송 요청사항 입력</label>
                                    <input type="text" class="fb__form-input devDeliveryMessage" name="devDeliveryMessage" id="devDeliveryMessage1" placeholder="배송 요청사항을 입력해 주세요." value="" />
                                </div>
                                <div class="counting" style="display:block;">
                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                </div>
                            </div>
                        </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                        <div class="devEachDeliveryMessageContents option-box-each">
                            <div class="fb__form-item">
                                <label for="devDeliveryMessageSelectBox1" class="delivery-info__label hide">배송요청사항</label>
                                <select class="fb__form-select devDeliveryMessageSelectBox" id="devDeliveryMessageSelectBox1">
                                    <option value="">배송요청사항 선택</option>
                                    <option>부재 시 경비실에 맡겨주세요.</option>
                                    <option>부재 시 휴대폰으로 연락주세요.</option>
                                    <option>집 앞에 놓아주세요.</option>
                                    <option>배송 전에 연락주세요.</option>
                                    <option value="direct">직접입력</option>
                                </select>
                            </div>
                            <div class="devDeliveryMessageDirectContents write-area">
                                <div class="fb__form-item">
                                    <label for="devDeliveryMessage2" class="hide">배송 요청사항 입력</label>
                                    <input type="text" class="fb__form-input devDeliveryMessage" id="devDeliveryMessage2" placeholder="배송 요청사항을 입력해 주세요." value="" />
                                </div>
                                <div class="counting" style="display:block;">
                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                </div>
                            </div>
                        </div>
<?php }}?>
                    </div>
                </div>
            </li>
        </ul>
    </section>
</section>
<!-- 비회원 주문용 - 배송지  E -->