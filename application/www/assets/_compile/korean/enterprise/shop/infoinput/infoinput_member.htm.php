<?php /* Template_ 2.2.8 2024/02/25 17:59:14 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_member.htm 000019419 */ 
$TPL_cartProductList_1=empty($TPL_VAR["cartProductList"])||!is_array($TPL_VAR["cartProductList"])?0:count($TPL_VAR["cartProductList"]);?>
<!-- 회원 주문용 - 배송지  S -->
<section class="fb__infoinput__member">
    <section class="fb__infoinput__customer-info customer-info">
        <div class="fb__infoinput-title">
            <div class="title-md">주문 고객 정보</div>
        </div>

        <ul class="customer-info__box">
            <li class="customer-info__item">
                <div class="customer-info__list">
                    <div class="fb__form-item">
                        <label for="devBuyerName" class="delivery-info__label hide">이름</label>
                        <input type="text" id="devBuyerName" name="devBuyerName" class="fb__form-input" title="주문자 이름" placeholder="이름" value="<?php echo $TPL_VAR["buyerName"]?>" />
                    </div>
                </div>
                <div class="customer-info__list">
                    <div class="selectWrap delivery-info__list-phone">
                        <div class="fb__form-item">
                            <label for="devBuyerMobile1" class="delivery-info__label hide">휴대폰</label>
                            <select id="devBuyerMobile1" class="fb__form-select" name="devBuyerMobile1">
                                <option <?php if($TPL_VAR["buyerMobile1"]=='010'){?>selected<?php }?>>010</option>
                                <option <?php if($TPL_VAR["buyerMobile1"]=='011'){?>selected<?php }?>>011</option>
                                <option <?php if($TPL_VAR["buyerMobile1"]=='016'){?>selected<?php }?>>016</option>
                                <option <?php if($TPL_VAR["buyerMobile1"]=='017'){?>selected<?php }?>>017</option>
                                <option <?php if($TPL_VAR["buyerMobile1"]=='018'){?>selected<?php }?>>018</option>
                                <option <?php if($TPL_VAR["buyerMobile1"]=='019'){?>selected<?php }?>>019</option>
                            </select>
                            <input type="text" id="devBuyerMobile2" class="fb__form-input" name="devBuyerMobile2" title="휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["buyerMobile2"]?>" />
                            <input type="text" id="devBuyerMobile3" class="fb__form-input" name="devBuyerMobile3" title="휴대폰 번호" placeholder="0000" value="<?php echo $TPL_VAR["buyerMobile3"]?>" />
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
                        <input type="text" id="devBuyerEmailId" class="fb__form-input" name="devBuyerEmailId" title="주문자 이메일" placeholder="이메일" value="<?php echo $TPL_VAR["buyerEmailId"]?>" />
                        <input type="text" id="devBuyerEmailHost" class="fb__form-input js__infoinput__email-target" name="devBuyerEmailHost" placeholder="도메인" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" />
                    </div>
                    <div class="fb__form-item">
                        <select name="devEmailHostSelect" id="devEmailHostSelect" class="js__infoinput__email-select fb__form-select">
                            <option value="" selected>직접입력</option>
                            <option value="naver.com">naver.com</option>
                            <option value="gmail.com">gmail.com</option>
                            <option value="hotmail.com">hotmail.com</option>
                            <option value="hanmail.net">hanmail.net</option>
                            <option value="daum.net">daum.net</option>
                            <option value="nate.com">nate.com</option>
                        </select>
                    </div>
                </div>
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__delivery-info delivery-info wrap-delivery-info">
        <div class="fb__infoinput-title">
            <div class="title-md">배송 정보</div>
        </div>
        <div class="fb-tab__wrap">
            <div class="fb-tab__nav">
                <ul>
                    <li class="active"><a href="javascript:void(0);" devRecipientTypeSelect="address">기본 배송지</a></li>
                    <li class=""><a href="javascript:void(0);" devRecipientTypeSelect="input">신규 배송지</a></li>
                </ul>
            </div>
            <div class="fb-tab__contents-wrap">
                <div class="fb-tab__contents devRecipientContents tab-choice active">
                    <form id="devOrderAddressListForm"></form>
                    <ul class="address-list">
                        <li class="address-list__item devOrderAddress">
                            <button type="button" class="btn-link btn-modify" id="devAddressListButton">변경</button>
                        </li>
                    </ul>
                    <ul class="address-list" id="devOrderAddressListContent" style="width:97%;">
                        <li id="devOrderAddressList" class="address-list__item devOrderAddress" style="padding-bottom:25px;">
                            <div class="list-info">
                                <div class="list-info__name">
                                    <input type="radio" name="orderAddress" class="devOrderAddressRadio" value="{[index]}"/>
                                    <strong>{[recipient]}</strong> ({[shipping_name]})
                                </div>
                                <div class="list-info__address">
                                    <!--<span>04366</span>-->
                                    <span>{[address1]} {[address2]}</span>
                                </div>
                                <div class="list-info__number">{[mobile]}</div>
                            </div>
                        </li>
                        <!-- 등록된 배송지가 없을 경우/숨김처리 S -->
                        <li id="devOrderAddressListLoading" class="address-list__item no-data" style="display: none">
                            <div class="list-info">
                                <p class="txt-guide">등록된 기본 배송지가 없습니다.</p>
                            </div>
                        </li>
                        <li id="devOrderAddressListEmpty" class="address-list__item no-data" style="display: none">
                            <div class="list-info">
                                <p class="txt-guide">등록된 배송지가 없습니다.</p>
                            </div>
                        </li>
                        <!-- 등록된 배송지가 없을 경우/숨김처리 E -->
                    </ul>
                    <ul class="address-list">
                        <li class="address-list__item devOrderAddress">
                            <div class="list-info">
                                <div class="delivery-request delivery-info__list-request">
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
                                                    <label for="devDeliveryMessage3" class="hide">배송 요청사항 입력</label>
                                                    <input type="text" class="fb__form-input devDeliveryMessage" name="devDeliveryMessage" id="devDeliveryMessage3" placeholder="배송 요청사항을 입력해 주세요." />
                                                </div>
                                                <div class="counting" style="display:block;">
                                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="fb-tab__contents devRecipientContents tab-new">
                    <ul class="delivery-info__box">
                        <li class="delivery-info__item delivery-info__list-name">
                            <div class="delivery-info__list">
                                <div class="fb__form-item">
                                    <label for="devRecipientName" class="delivery-info__label hide">받는 분</label>
                                    <input type="text" class="fb__form-input devRecipientName" name="devRecipientName" id="devRecipientName" title="받는 분 이름" placeholder="이름" />
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
                                        <input type="text" name="devRecipientMobile2" class="fb__form-input devRecipientMobile2" title="받는 분 휴대폰 번호2" placeholder="0000" />
                                        <input type="text" name="devRecipientMobile3" class="fb__form-input devRecipientMobile3" title="받는 분 휴대폰 번호3" placeholder="0000" />
                                    </div>
                                </div>
                            </div>
                            <div class="check-area delivery-info__check-area">
                                <div class="check-area__item fb__form-item">
                                    <input type="checkbox" id="devBasicAddressBookCheckBox" checked/>
                                    <label for="devBasicAddressBookCheckBox">기본 배송지로 지정</label>
                                </div>
                                <div class="check-area__item fb__form-item">
                                    <input type="checkbox" id="devAddAddressBookCheckBox" checked/>
                                    <label for="devAddAddressBookCheckBox">배송지 목록에 추가</label>
                                </div>
                            </div>
                        </li>
                        <li class="delivery-info__item">
                            <div class="title-sm">주소</div>
                            <div class="delivery-info__list delivery-info__list-address">
                                <div class="form-info-wrap delivery-info__list-group">
                                    <div class="fb__form-item">
                                        <label for="devRecipientZip" class="delivery-info__label hide">주소</label>
                                        <input type="text" class="fb__form-input zip-code devRecipientZip" name="devRecipientZip" id="devRecipientZip" title="받는 분 주소" placeholder="우편번호" readonly />
                                        <button class="btn-s btn-dark-line devRecipientZipPopupButton">검색</button>
                                    </div>
                                    <div class="fb__form-item">
                                        <input type="text" class="fb__form-input input-address devRecipientAddr1" name="devRecipientAddr1" title="받는 분 주소" placeholder="주소" readonly />
                                    </div>
                                    <div class="fb__form-item">
                                        <input type="text" class="fb__form-input input-add-detail devRecipientAddr2" name="devRecipientAddr2" title="받는 분 상세주소" placeholder="상세주소" />
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
                                                <label for="devDeliveryMessage5" class="hide">배송 요청사항 입력</label>
                                                <input type="text" class="fb__form-input devDeliveryMessage" name="devDeliveryMessage" id="devDeliveryMessage5" placeholder="배송 요청사항을 입력해 주세요." />
                                            </div>
                                            <div class="counting" style="display:block;">
                                                <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                            </div>
                                        </div>
                                    </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                                    <div class="devEachDeliveryMessageContents option-box-each" devCartIx="<?php echo $TPL_V1["cart_ix"]?>">
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
                                                <label for="devDeliveryMessage6" class="hide">배송 요청사항 입력</label>
                                                <input type="text" class="fb__form-input devDeliveryMessage" id="devDeliveryMessage6" placeholder="배송 요청사항을 입력해 주세요." />
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
                </div>
            </div>
        </div>
    </section>
</section>
<!-- 회원 주문용 - 배송지  E -->