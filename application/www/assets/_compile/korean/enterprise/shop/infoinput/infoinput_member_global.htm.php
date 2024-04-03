<?php /* Template_ 2.2.8 2021/11/09 15:25:59 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_member_global.htm 000022264 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<section class="fb__infoinput__member">
    <section class="fb__infoinput__discount-area">
        <h2 class="fb__infoinput__discount-area__title">할인/혜택 적용</h2>
        <ul class="discount-box">
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    쿠폰할인
                </span>
                <div class="discount-box__cont">
                    <span><?php echo $TPL_VAR["fbUnit"]["f"]?> </span><input type="text" class="discount-box__amount dim" id="devUseCouponInputText" readonly> <span> <?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    <span class="discount-box__cont__span">
                        보유쿠폰
                        <em class="fb__point-color"><?php echo $TPL_VAR["userCouponCnt"]?></em>장
                    </span>
<?php if($TPL_VAR["userCouponCnt"]> 0){?>
                    <button class="btn-default btn-dark discount-box__btn" id="devUseCouponButton">쿠폰적용</button>
                    <button class="btn-default btn-dark-line discount-box__btn discount-box__btn-cancel" id="devCouponButtonCancel">적용취소</button>
<?php }?>
                    <!--<p>쿠폰은 옵션당 1매만 사용 가능합니다.</p>-->
                </div>
            </li>
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    <?php echo $TPL_VAR["mileageName"]?> 사용
                </span>
                <div class="discount-box__cont">
                    <span class="text_p"><?php echo $TPL_VAR["mileageUnit"]?></span> <input type="text" id="devUseMileage" value="0"">
                    <input type="checkbox" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>">
                    <label for="devAllUseMileageCheckBox"><?php echo $TPL_VAR["mileageName"]?> 전체 사용</label>
                    <span>
                        (사용가능 적립금 <em class="fb__point-color"><?php echo $TPL_VAR["mileageUnit"]?> <?php echo g_price($TPL_VAR["userMileage"])?></em>)
                    </span>
                    <!--<p>-->
                    <!--· <?php if($TPL_VAR["mileageConditionMinMileage"]> 0){?><?php echo $TPL_VAR["mileageName"]?>은 '<?php echo number_format($TPL_VAR["mileageConditionMinMileage"])?>' <?php echo $TPL_VAR["mileageName"]?> 이상 보유한 경우에만 사용 가능하며 <?php }?>'<?php echo $TPL_VAR["mileageConditionUseUnit"]?>'&nbsp;<?php echo $TPL_VAR["mileageName"]?> 단위로 사용 가능합니다.-->
                    <!--</p>-->
                    <!--<p>-->
                    <!--· <?php if($TPL_VAR["mileageConditionMinBuyAmt"]> 0){?>상품 구매금액 합계가 ‘<?php echo number_format($TPL_VAR["mileageConditionMinBuyAmt"])?>’원 이상인 경우<?php }else{?>상품 구매금액과 상관없이<?php }?> <?php if($TPL_VAR["mileageConditionUseLimitType"]=='noLimit'){?>사용가능 합니다.<?php }else{?>최대 ‘<?php echo number_format($TPL_VAR["mileageConditionUseLimitValue"])?>’ <?php if($TPL_VAR["mileageConditionUseLimitType"]=='price'){?><?php echo $TPL_VAR["mileageName"]?><?php }else{?>%<?php }?>까지 사용 가능합니다.<?php }?>
                    <!--</p>-->
                    <!--<p>-->
                    <!--· <?php echo $TPL_VAR["mileageName"]?>로 배송비 사용은 <?php if($TPL_VAR["mileageConditionUseDeliverypriceYn"]=='Y'){?>가능<?php }else{?>불가<?php }?> 합니다.-->
                    <!--</p>-->
                </div>
            </li>
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    적립금 적립
                </span>
                <div class="discount-box__cont">
                    Expected to save <?php echo $TPL_VAR["mileageUnit"]?>

                    <span class="discount-box__cont--em font-rb" devPrice="mileage">
                        <?php echo g_price($TPL_VAR["cartSummary"]["mileage"])?>

                    </span>
                </div>
            </li>
        </ul>
    </section>

<?php if($TPL_VAR["freeGift"]["gift_products"]){?>    <div class="order-info__pricegift warp_gift_list devOrderGiftArea">
        <div class="gift_list">
            <h3 class="order-info__pricegift__title">구매금액별 사은품</h3>
            <ul style="display:none;">
<?php if(is_array($TPL_R1=$TPL_VAR["freeGift"]["gift_products"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <li>
                    <img src="<?php echo $TPL_VAR["freeGift"]["image_src"]?>" data-devpid="<?php echo $TPL_VAR["freeGift"]["pid"]?>" alt="">
                    <p><?php echo $TPL_VAR["freeGift"]["pname"]?></p>
                </li>
<?php }}?>
            </ul>
        </div>
        <button class="order-info__pricegift__btn btn-default devGiftBox"><span>구매금액별 사은품 선택</span></button>
        <div class="product-gift devOrderGift" style="display:none;">
            <div class="product-gift__list" id="devOrderGiftList">

            </div>
        </div>
    </div>
<?php }?>

    <section  class="fb__infoinput__customer-info customer-info">
        <h2 class="customer-info__title">주문자 정보</h2>

        <ul class="customer-info__box">
            <li class="customer-info__list customer-info__list-name">
                <span class="customer-info__list__title customer-info__list__title-required">
                    이름
                </span>
                <input type="text" id="devBuyerName" name="devBuyerName" value="<?php echo $TPL_VAR["buyerName"]?>" title="주문자 이름">
            </li>
            <li class="customer-info__list customer-info__list-cp">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Tel
                </span>
                <div class="selectWrap customer-info__list__input-area">
                    <select id="devBuyerMobile1" name="devBuyerMobile1">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                    </select>
                    <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="휴대폰 번호">
                </div>
            </li>
            <li class="customer-info__list customer-info__list-email">
                <span class="customer-info__list__title customer-info__list__title-required">
                    이메일 주소
                </span>
                <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="주문자 이메일">
                <span>@</span>
                <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" class="js__infoinput__email-target">
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__delivery-info delivery-info wrap-delivery-info">
        <h2 class="delivery-info__title">배송지 정보</h2>
        <div class="tab-control mat20">
            <ul class="tab-link">
                <li class="active" style="width:33.3%;"><a href="#tab01" devRecipientTypeSelect="address"><?php if($TPL_VAR["langType"]=='korean'){?>기본 배송지<?php }else{?>Default address<?php }?></a></li>
				<li class="active1" style="width:33.3%;"><a href="#tab03" devRecipientTypeSelect="addressOrder">최근 배송지</a></li>
                <li class="" style="width:33.3%;"><a href="#tab02" devRecipientTypeSelect="input">새로운 배송지</a></li>
            </ul>
            <div class="tab-contents delivery-info__tab-contents delivery-info__tab-contents-choice">
                <div id="tab01" class="tab devRecipientContents tab-choice active">
                    <p class="delivery-list"><button class="btn-s btn-dark-line" id="devAddressListButton">배송지 목록</button></p>

                    <form id="devOrderAddressListForm"></form>

                    <ul class="tab-choice__box" id="devOrderAddressListContent">

                        <li id="devOrderAddressListLoading" class="devForbizTpl tab-choice__list">
                            <div class="list-info">
                                <p class="list-info__name">
                                    <strong>등록된 기본 배송지가 없습니다.</strong>
                                </p>
                            </div>
                        </li>

                        <li class="tab-choice__list devOrderAddress devForbizTpl" id="devOrderAddressList">
                            <input type="radio" name="orderAddress" class="devOrderAddressRadio" value="{[index]}"/>
                            <div class="list-info">
                                <p class="list-info__name">
                                    <strong>{[recipient]}</strong> ({[shipping_name]})
                                </p>
                                <p class="list-info__address">
                                    {[address1]} {[address2]}
                                </p>
                                <p class="list-info__number">
                                    <em>{[mobile]}</em>
                                </p>
                                {[#if isBasic]}
                                <p class="list-info__default">기본배송지</p>
                                {[/if]}
                            </div>
                        </li>

                        <li id="devOrderAddressListEmpty" class="tab-choice__list devForbizTpl">
                            <div class="list-info">
                                <p class="name">
                                    <strong>등록된 배송지가 없습니다.</strong>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <div class="delivery-request delivery-info__list-request">
                        <p class="delivery-info__list__title">배송요청사항</p>
                        <div class="delivery-info__list__input-area input-area" style="margin-bottom:0;">
                            <div class="devDeliveryMessageContents option-box">
                                <div class="devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                    </div>
                                </div>
                            </div>
<?php if($TPL_VAR["productKindCount"]> 1){?>
                            <!--<span class="check">-->
                            <!--<input type="checkbox" class="devDeliveryMessageIndividualCheckBox" id="messge-checkbox">-->
                            <!--<label for="messge-checkbox">개별입력</label>-->
                            <!--</span>-->
<?php }?>
                        </div>
                    </div>
                </div>
				<div id="tab03" class="tab devRecipientContents tab-choice active1">

                    <form id="devOrderAddressListOrderForm"></form>

                    <ul class="tab-choice__box" id="devOrderAddressListOrderContent">

                        <li id="devOrderAddressListOrderLoading" class="devForbizTpl tab-choice__list">
                            <div class="list-info">
                                <p class="list-info__name">
                                    <strong>등록된 최근 배송지가 없습니다.</strong>
                                </p>
                            </div>
                        </li>

                        <li class="tab-choice__list devOrderAddress devForbizTpl" id="devOrderAddressListOrder">
                            <input type="radio" name="orderAddress" class="devOrderAddressOrderRadio" value="{[index]}"/>
                            <div class="list-info">
                                <p class="list-info__name">
                                    <strong>{[recipient]}</strong>
                                </p>
                                <p class="list-info__address">
                                    {[address1]} {[address2]}
                                </p>
                                <p class="list-info__number">
                                    <em>{[mobile]}</em>
                                </p>
                            </div>
                        </li>

                        <li id="devOrderAddressListOrderEmpty" class="tab-choice__list devForbizTpl">
                            <div class="list-info">
                                <p class="name">
                                    <strong>등록된 배송지가 없습니다.</strong>
                                </p>
                            </div>
                        </li>
                    </ul>
					<div class="delivery-request delivery-info__list-request">
                        <p class="delivery-info__list__title">배송요청사항</p>
                        <div class="delivery-info__list__input-area input-area" style="margin-bottom:0;">
                            <div class="devDeliveryMessageContents option-box">
                                <div class="devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                    </div>
                                </div>
                            </div>
<?php if($TPL_VAR["productKindCount"]> 1){?>
                            <!--<span class="check">-->
                            <!--<input type="checkbox" class="devDeliveryMessageIndividualCheckBox" id="messge-checkbox">-->
                            <!--<label for="messge-checkbox">개별입력</label>-->
                            <!--</span>-->
<?php }?>
                        </div>
                    </div>
                </div>
                <div id="tab02" class="tab devRecipientContents tab-new">

                    <ul class="delivery-info__box">
                        <li class="delivery-info__list delivery-info__list-name">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                받는 분
                            </span>
                            <input type="text" name="devRecipientName" class="devRecipientName" title="받는 분">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Country
                            </span>
                            <select class="devNationArea"  name="country" id="devCountry">
                                <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                            </select>
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Zip/Postal Code
                            </span>
                            <input type="text" title="Zip/Postal Code" name="devRecipientZip" class="devRecipientZip">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Address line 1
                            </span>
                            <input type="text" title="Address line 1" name="devRecipientAddr1" class="devRecipientAddr1">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title">
                                Address line 2
                            </span>
                            <input type="text" title="Address line 2" name="devRecipientAddr2" class="devRecipientAddr2">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                City
                            </span>
                            <input type="text" title="City" name="city" id="devCity" value="">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                State/Province
                            </span>
                            <select id="devStateSelect" name="devStateSelect">
                                <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["reg_name"]?>"><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                            </select>

                            <input type="text" style="display:none;" id="devStateText"  name="state" title="State/Province" >
                            <!--<input type="text" title="State/Province">-->
                            <!--<select>-->
                                <!--<option value="">Country</option>-->
                                <!--<option value="">USA</option>-->
                            <!--</select>-->
                        </li>

                        <li class="delivery-info__list">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Tel
                            </span>
                            <div class="selectWrap delivery-info__list__input-area">
                                <select name="devRecipientMobile1" class="devRecipientMobile1 devNationArea">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                    <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                                </select>
                                <input type="text" name="devRecipientMobile2" class="devRecipientMobile2" title="받는 분 휴대폰 번호">
                            </div>
                        </li>
                        <li class="delivery-info__list delivery-info__list-request">
                            <span class="delivery-info__list__title">
                                배송요청사항
                            </span>
                            <div class="delivery-request member delivery-info__list__input-area input-area">
                                <div class="devDeliveryMessageContents option-box">
                                    <!--<p class="product-name"><?php echo $TPL_VAR["contractionProductName"]?></p>-->
                                    <div class="mat10 devDeliveryMessageDirectContents write-area">
                                        <input type="text"  class="devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="tab-new__check-area">
                        <span class="tab-new__check">
                            <input type="checkbox" id="devAddAddressBookCheckBox" checked>
                            <label for="devAddAddressBookCheckBox">배송지 목록에 추가</label>
                        </span>
                        <span class="tab-new__check">
                            <input type="checkbox" id="devBasicAddressBookCheckBox" checked>
                            <label for="devBasicAddressBookCheckBox">기본 배송지로 선택</label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>