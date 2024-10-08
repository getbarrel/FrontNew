<?php /* Template_ 2.2.8 2024/02/25 18:15:45 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/infoinput/infoinput_member.htm 000012520 */ ?>
<div class="br__infoinput__order">
    <div class="br__infoinput__non-member">
        <!-- 주문자 정보 S -->
        <section class="br__infoinput__buyer">
            <div class="page-title">
                <div class="title-md">주문 고객 정보</div>
            </div>
            <div class="info-buyer">
                <div class="info-buyer__form">
                    <label for="devBuyerName" class="info-buyer__form__label">주문자</label>
                    <input type="text" id="devBuyerName" name="devBuyerName" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerName"]?>" placeholder="이름" title="주문자" />
                </div>
                <div class="info-buyer__form info-buyer__form--phone">
                    <label for="devBuyerMobile1" class="info-buyer__form__label">휴대폰</label>
                    <div class="flexWrap">
                        <select id="devBuyerMobile1" name="devBuyerMobile1" class="info-buyer__form__select">
                            <option <?php if($TPL_VAR["buyerMobile1"]=='010'){?>selected<?php }?>>010</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='011'){?>selected<?php }?>>011</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='016'){?>selected<?php }?>>016</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='017'){?>selected<?php }?>>017</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='018'){?>selected<?php }?>>018</option>
                            <option <?php if($TPL_VAR["buyerMobile1"]=='019'){?>selected<?php }?>>019</option>
                        </select>
                        <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile2"]?>" placeholder="0000" title="휴대폰 번호" />
                        <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerMobile3"]?>" placeholder="0000" title="휴대폰 번호" />
                    </div>
                </div>
                <div class="info-buyer__form info-buyer__form--email">
                    <label for="devBuyerEmailId" class="info-buyer__form__label">이메일</label>
                    <div class="flexWrap">
                        <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailId"]?>" placeholder="이메일 아이디" title="주문자 이메일" />
                        <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" class="info-buyer__form__input" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" placeholder="이메일 도메인" title="주문자 이메일" />
                    </div>
                    <select id="devEmailHostSelect" name="devEmailHostSelect" class="info-buyer__form__select">
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
            </div>
        </section>
        <!-- 주문자 정보 E -->
    </div>

    <!-- 회원 주문 S -->
    <div class="br__infoinput__member">
        <!--회원일 경우엔 주문자 정보 없음-->
        <!-- 주문자 정보 / 배송지 S -->
        <section class="br__infoinput__address">
            <div class="page-title">
                <div class="title-md">배송 정보</div>
            </div>
            <div class="br-tab__wrap">
                <div class="br-tab__nav">
                    <ul>
                        <li class="active"><a href="javascript:void(0);" devRecipientTypeSelect="address">기본 배송지</a></li>
                        <li><a href="javascript:void(0);" devRecipientTypeSelect="input">신규 배송지</a></li>
                    </ul>
                </div>
                <div class="br-tab__contents-wrap">
                    <div class="br-tab__contents devRecipientContents active">
                        <form id="devOrderAddressListForm"></form>
                        <div style="padding-top: 25px;">
                            <button class="info-addr__recent__btn" id="devAddressListButton" style="display: block;width: 100%;height: 3rem;border: 1px solid #b5b5b6;color: #000;font-size: 1.1rem;line-height: 1.6rem;text-align: center;">배송 주소록</button>
                        </div>
                        <div class="info-addr">
                            <div class="info-addr__recent">
                                <ul id="devOrderAddressListContent" class="info-addr__recent__list">
                                    <!-- 리스트 로딩 S -->
                                    <li class="br-loading" id="devOrderAddressListLoading" style="display: none">
                                        <div class="info">
                                            <p class="name"><strong>Loading ...</strong></p>
                                        </div>
                                    </li>
                                    <!-- 리스트 로딩 E -->
                                    <!-- 등록된 배송지가 없을 경우 S -->
                                    <!-- 숨김 처리 -->
                                    <li class="info-addr__recent__box no-data" id="devOrderAddressListLoading" style="display: none">
                                        <p class="empty-content">등록된 기본 배송지가 없습니다.</p>
                                    </li>

                                    <li class="info-addr__recent__box no-data" id="devOrderAddressListEmpty" style="display: none">
                                        <p class="empty-content">등록된 배송지가 없습니다.</p>
                                    </li>
                                    <!-- 등록된 배송지가 없을 경우 E -->
                                    <li class="info-addr__recent__box devOrderAddress" id="devOrderAddressList">
                                        <div class="info-addr__recent__info">
                                            <div class="info-addr__recent__name devOrderAddress">
                                                <input type="radio" name="orderAddress" class="devOrderAddressRadio" value="{[index]}"/>
                                            </div>
                                            <span class="info-addr__recent__name">{[recipient]} ({[shipping_name]})</span>
                                            <div class="info-addr__recent__addr">{[address1]} / {[address2]}</div>
                                            <div class="info-addr__recent__phone">{[mobile]}</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="br-tab__contents devRecipientContents">
                        <div class="info-buyer">
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
                                    <input type="text" class="info-buyer__form__input devRecipientZip" name="devRecipientZip" title="받는 분 주소" placeholder="우편번호" value="" />
                                    <button class="info-buyer__form__btn devRecipientZipPopupButton">검색</button>
                                </div>
                                <input type="text" class="info-buyer__form__input devRecipientAddr1" name="devRecipientAddr1" title="받는 분 주소" placeholder="" value="" />
                                <input type="text" class="info-buyer__form__input devRecipientAddr2" name="devRecipientAddr2" title="받는 분 상세주소" placeholder="상세주소" />
                            </div>
                            <div class="info-buyer__form info-buyer__form--check">
                                <div class="flexWrap">
                                    <input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check" />
                                    <label for="devBasicAddressBookCheckBox" class="txt-gray">배송지로 지정</label>
                                    <input type="checkbox" id="devAddAddressBookCheckBox" class="info-buyer__form__check" />
                                    <label for="devAddAddressBookCheckBox" class="txt-gray">배송지 목록에 추가</label>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <input type="text" class="info-buyer__form__input devDeliveryMessage" name="devDeliveryMessage" id="devDeliveryMessage3" placeholder="배송 메시지 입력" value="문 앞에 놔주세요." devmaxlength="30" />
                    </div>
                </div>
            </div>
        </section>
        <!-- 주문자 정보 / 배송지 E -->
    </div>
    <!-- 회원 주문 E -->
</div>