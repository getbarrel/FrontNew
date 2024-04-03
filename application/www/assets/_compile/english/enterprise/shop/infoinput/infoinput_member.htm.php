<?php /* Template_ 2.2.8 2021/11/08 17:09:12 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_member.htm 000028699 */ 
$TPL_cartProductList_1=empty($TPL_VAR["cartProductList"])||!is_array($TPL_VAR["cartProductList"])?0:count($TPL_VAR["cartProductList"]);?>
<section class="fb__infoinput__member">
    <section class="fb__infoinput__discount-area">
        <h2 class="fb__infoinput__discount-area__title">Coupons / Reward</h2>
        <ul class="discount-box">
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    Coupons
                </span>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
                <div class="discount-box__cont">
                    <span>이벤트 기간에는 쿠폰 사용이 불가능합니다.</span>
                </div>
<?php }else{?>
                <div class="discount-box__cont">
                    <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" class="discount-box__amount dim" id="devUseCouponInputText" readonly> <span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    <span class="discount-box__cont__span">
                        My Coupons
                        <em class="fb__point-color"><?php echo $TPL_VAR["userCouponCnt"]?></em>  
                    </span>
<?php if($TPL_VAR["userCouponCnt"]> 0){?>
                    <button class="btn-default btn-dark discount-box__btn" id="devUseCouponButton">Valid Coupons</button>
                    <button class="btn-default btn-dark-line discount-box__btn discount-box__btn-cancel" id="devCouponButtonCancel">Cancel</button>
<?php }?>
                    <!--<p>Only one coupon can be used per option</p>-->
                </div>
<?php }?>
            </li>
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    (english)배송비쿠폰할인
                </span>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
                <div class="discount-box__cont">
                    <span>이벤트 기간에는 쿠폰 사용이 불가능합니다.</span>
                </div>
<?php }else{?>
                <div class="discount-box__cont">
                    <span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" class="discount-box__amount dim" id="devUseDeliveryCouponInputText" readonly> <span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    <span class="discount-box__cont__span">
                        My Coupons
                        <em class="fb__point-color"><?php echo $TPL_VAR["userDeliveryCouponCnt"]?></em>  
                    </span>
<?php if($TPL_VAR["userDeliveryCouponCnt"]> 0){?>
                    <button class="btn-default btn-dark discount-box__btn" id="devUseDeliveryCouponButton">Valid Coupons</button>
                    <button class="btn-default btn-dark-line discount-box__btn discount-box__btn-cancel" id="devDeliveryCouponButtonCancel">Cancel</button>
<?php }?>
                    <!--<p>Only one coupon can be used per option</p>-->
                </div>
<?php }?>
            </li>
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    Reward
                </span>
<?php if($TPL_VAR["isOnlineBarrelDay"]){?>
                <div class="discount-box__cont">
                    <span>이벤트 기간에는 적립금 사용이 불가능합니다.</span>
                </div>
<?php }else{?>
                <div class="discount-box__cont">
                    <input type="hidden" id="mileageConditionMinBuyAmt" value="<?php echo $TPL_VAR["mileageConditionMinBuyAmt"]?>" />
                    <input type="text" id="devUseMileage" value="0"> <span class="text_p"><?php echo $TPL_VAR["mileageUnit"]?></span>
                    <input type="checkbox" id="devAllUseMileageCheckBox" devAllUseMileage="<?php echo $TPL_VAR["maxUseMileage"]?>" devMileageTargetPrice="<?php echo $TPL_VAR["mileageTargetPrice"]?>" devTotalPrice="<?php echo $TPL_VAR["cartSummary"]["product_listprice"]?>">
                    <label for="devAllUseMileageCheckBox"><?php echo $TPL_VAR["mileageName"]?> use all</label>
                    <span>
                        (Valid Reward <em class="fb__point-color"><?php echo g_price($TPL_VAR["userMileage"])?></em><?php echo $TPL_VAR["mileageUnit"]?>)
                    </span>
                    <!--<p>-->
                        <!--· <?php if($TPL_VAR["mileageConditionMinMileage"]> 0){?><?php echo $TPL_VAR["mileageName"]?>은 '<?php echo g_price($TPL_VAR["mileageConditionMinMileage"])?>' <?php echo $TPL_VAR["mileageName"]?> 이상 보유한 경우에만 사용 가능하며 <?php }?>'<?php echo $TPL_VAR["mileageConditionUseUnit"]?>'&nbsp;<?php echo $TPL_VAR["mileageName"]?> 단위로 사용 가능합니다.-->
                    <!--</p>-->
                    <!--<p>-->
                        <!--· <?php if($TPL_VAR["mileageConditionMinBuyAmt"]> 0){?>상품 구매금액 합계가 ‘<?php echo g_price($TPL_VAR["mileageConditionMinBuyAmt"])?>’원 이상인 경우<?php }else{?>상품 구매금액과 상관없이<?php }?> <?php if($TPL_VAR["mileageConditionUseLimitType"]=='noLimit'){?>사용가능 합니다.<?php }else{?>최대 ‘<?php echo g_price($TPL_VAR["mileageConditionUseLimitValue"])?>’ <?php if($TPL_VAR["mileageConditionUseLimitType"]=='price'){?><?php echo $TPL_VAR["mileageName"]?><?php }else{?>%<?php }?>까지 사용 가능합니다.<?php }?>
                    <!--</p>-->
                    <!--<p>-->
                        <!--· <?php echo $TPL_VAR["mileageName"]?>로 배송비 사용은 <?php if($TPL_VAR["mileageConditionUseDeliverypriceYn"]=='Y'){?>가능<?php }else{?>불가<?php }?> 합니다.-->
                    <!--</p>-->
                </div>
<?php }?>
            </li>
            <li class="discount-box__list">
                <span class="discount-box__tit">
                    Expected reward
                </span>
                <div class="discount-box__cont">
                    <span class="discount-box__cont--em font-rb" devPrice="mileage">
                        <?php echo g_price($TPL_VAR["cartSummary"]["mileage"])?>

                    </span>
                    <?php echo $TPL_VAR["mileageUnit"]?> expected to save
                </div>
            </li>
        </ul>
    </section>

    <section  class="fb__infoinput__customer-info customer-info">
        <h2 class="customer-info__title">Orderer Information</h2>

        <ul class="customer-info__box">
            <li class="customer-info__list customer-info__list-name">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Name
                </span>
                <input type="text" id="devBuyerName" name="devBuyerName" value="<?php echo $TPL_VAR["buyerName"]?>" title="주문자 이름">
            </li>
            <li class="customer-info__list customer-info__list-cp">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Tel
                </span>
                <div class="selectWrap customer-info__list__input-area">
                    <select id="devBuyerMobile1" name="devBuyerMobile1">
                        <option <?php if($TPL_VAR["buyerMobile1"]=='010'){?>selected<?php }?>>010</option>
                        <option <?php if($TPL_VAR["buyerMobile1"]=='011'){?>selected<?php }?>>011</option>
                        <option <?php if($TPL_VAR["buyerMobile1"]=='016'){?>selected<?php }?>>016</option>
                        <option <?php if($TPL_VAR["buyerMobile1"]=='017'){?>selected<?php }?>>017</option>
                        <option <?php if($TPL_VAR["buyerMobile1"]=='018'){?>selected<?php }?>>018</option>
                        <option <?php if($TPL_VAR["buyerMobile1"]=='019'){?>selected<?php }?>>019</option>
                    </select>
                    -
                    <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" value="<?php echo $TPL_VAR["buyerMobile2"]?>" title="Tel">
                    -
                    <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" value="<?php echo $TPL_VAR["buyerMobile3"]?>" title="Tel">
                </div>
            </li>
            <li class="customer-info__list customer-info__list-email">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Email
                </span>
                <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" value="<?php echo $TPL_VAR["buyerEmailId"]?>" title="Orderer E-mail">
                <span>@</span>
                <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" value="<?php echo $TPL_VAR["buyerEmailHost"]?>" title="Orderer E-mail" class="js__infoinput__email-target">
                <select id="" name="devEmailHostSelect" class="js__infoinput__email-select">
                    <option value="" selected>Direct input.</option>
                    <option value="naver.com">naver.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="hotmail.com">hotmail.com</option>
                    <option value="hanmail.net">hanmail.net</option>
                    <option value="daum.net">daum.net</option>
                    <option value="nate.com">nate.com</option>
                </select>
                <span class="customer-info__list__desc">SMS and e-mail us the progress of your order.</span>
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__delivery-info delivery-info wrap-delivery-info">
        <h2 class="delivery-info__title">Shipping Information</h2>
        <div class="tab-control mat20">
            <ul class="tab-link">
                <li class="active" style="width:33.3%;"><a href="#tab01" devRecipientTypeSelect="address">기본 배송지</a></li>
				<li class="active1" style="width:33.3%;"><a href="#tab03" devRecipientTypeSelect="addressOrder">Recent shipping address</a></li>
                <li class="" style="width:33.3%;"><a href="#tab02" devRecipientTypeSelect="input">New Shipping address</a></li>
            </ul>
            <div class="tab-contents delivery-info__tab-contents delivery-info__tab-contents-choice">
                <div id="tab01" class="tab devRecipientContents tab-choice active">
                    <p class="delivery-list"><button class="btn-s btn-dark-line" id="devAddressListButton">List of shipping address</button></p>

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
                                <p class="list-info__default">address</p>
                                {[/if]}
                            </div>
                        </li>

                        <li id="devOrderAddressListEmpty" class="tab-choice__list devForbizTpl">
                            <div class="list-info">
                                <p class="name">
                                    <strong>No shipping address</strong>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <div class="delivery-request delivery-info__list-request">
                        <p class="delivery-info__list__title">Shipping comment</p>
                        <div class="delivery-info__list__input-area input-area">
                            <div class="devDeliveryMessageContents option-box">
                                <!--<p class="product-name"><?php echo $TPL_VAR["contractionProductName"]?></p>-->
                                <select class="devDeliveryMessageSelectBox" >
                                    <option value="">Select shiping request</option>
                                    <option>Please leave it to the security office if unavailable</option>
                                    <option>Please contact me by cell phone if unavailable</option>
                                    <option>Place in fron to the porch</option>
                                    <option>Please contact before shipping</option>
                                    <option value="direct">Direct input.</option>
                                </select>
                                <div class="mat10 devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                    </div>
                                </div>
                            </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                            <div class="devEachDeliveryMessageContents option-box-each" devCartIx="<?php echo $TPL_V1["cart_ix"]?>">
                                <p class="product-name"><?php echo $TPL_V1["pname"]?> <?php echo $TPL_V1["options_text"]?></p>
                                <select class="devDeliveryMessageSelectBox">
                                    <option value="">Select shiping request</option>
                                    <option>Please leave it to the security office if unavailable</option>
                                    <option>Please contact me by cell phone if unavailable</option>
                                    <option>Place in fron to the porch</option>
                                    <option>Please contact before shipping</option>
                                    <option value="direct">Direct input.</option>
                                </select>
                                <div class="mat10 devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                    </div>
                                </div>
                            </div>
<?php }}?>

<?php if($TPL_VAR["productKindCount"]> 1){?>
                            <!--<span class="check">-->
                                <!--<input type="checkbox" class="devDeliveryMessageIndividualCheckBox" id="messge-checkbox">-->
                                <!--<label for="messge-checkbox">Individual input</label>-->
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
                                    <strong>No shipping address</strong>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <div class="delivery-request delivery-info__list-request">
                        <p class="delivery-info__list__title">Shipping comment</p>
                        <div class="delivery-info__list__input-area input-area">
                            <div class="devDeliveryMessageContents option-box">
                                <!--<p class="product-name"><?php echo $TPL_VAR["contractionProductName"]?></p>-->
                                <select class="devDeliveryMessageSelectBox" >
                                    <option value="">Select shiping request</option>
                                    <option>Please leave it to the security office if unavailable</option>
                                    <option>Please contact me by cell phone if unavailable</option>
                                    <option>Place in fron to the porch</option>
                                    <option>Please contact before shipping</option>
                                    <option value="direct">Direct input.</option>
                                </select>
                                <div class="mat10 devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                    </div>
                                </div>
                            </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                            <div class="devEachDeliveryMessageContents option-box-each" devCartIx="<?php echo $TPL_V1["cart_ix"]?>">
                                <p class="product-name"><?php echo $TPL_V1["pname"]?> <?php echo $TPL_V1["options_text"]?></p>
                                <select class="devDeliveryMessageSelectBox">
                                    <option value="">Select shiping request</option>
                                    <option>Please leave it to the security office if unavailable</option>
                                    <option>Please contact me by cell phone if unavailable</option>
                                    <option>Place in fron to the porch</option>
                                    <option>Please contact before shipping</option>
                                    <option value="direct">Direct input.</option>
                                </select>
                                <div class="mat10 devDeliveryMessageDirectContents write-area">
                                    <input type="text" class="devDeliveryMessage">
                                    <div class="counting">
                                        <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                    </div>
                                </div>
                            </div>
<?php }}?>

<?php if($TPL_VAR["productKindCount"]> 1){?>
                            <!--<span class="check">-->
                                <!--<input type="checkbox" class="devDeliveryMessageIndividualCheckBox" id="messge-checkbox">-->
                                <!--<label for="messge-checkbox">Individual input</label>-->
                            <!--</span>-->
<?php }?>
                        </div>
                    </div>
                </div>
                <div id="tab02" class="tab devRecipientContents tab-new">

                    <ul class="delivery-info__box">
                        <li class="delivery-info__list delivery-info__list-name">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Name
                            </span>
                            <input type="text" name="devRecipientName" class="devRecipientName" title="Recipient Name">
                        </li>
                        <li class="delivery-info__list delivery-info__list-address">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Address
                            </span>
                            <div class="form-info-wrap delivery-info__list__input-area">
                                <input type="text" name="devRecipientZip" class="zip-code  devRecipientZip" title="Orderer Address 1" readonly>
                                <button class="btn-default btn-dark devRecipientZipPopupButton">Zip code</button>
                                <input type="text" name="devRecipientAddr1" class="input-address  mat10 devRecipientAddr1" title="Orderer Address 1" readonly>
                                <input type="text" name="devRecipientAddr2" class="input-add-detail mat10 devRecipientAddr2" title="Orderer Address 2">
                            </div>
                        </li>
                        <li class="delivery-info__list">
                            <span class="delivery-info__list__title delivery-info__list__title-required">
                                Tel
                            </span>
                            <div class="selectWrap delivery-info__list__input-area">
                                <select class="devRecipientMobile1" name="devRecipientMobile1">
                                    <option>010</option>
                                    <option>011</option>
                                    <option>016</option>
                                    <option>017</option>
                                    <option>018</option>
                                    <option>019</option>
                                </select>
                                -
                                <input type="text" class="devRecipientMobile2" name="devRecipientMobile2" title="Orderer Phone">
                                -
                                <input type="text" class="devRecipientMobile3" name="devRecipientMobile3" title="Orderer Phone">
                            </div>
                        </li>
                        <li class="delivery-info__list delivery-info__list-request">
                            <span class="delivery-info__list__title">
                                Shipping comment
                            </span>
                            <div class="delivery-request member delivery-info__list__input-area input-area">
                                <div class="devDeliveryMessageContents option-box">
                                    <select class="devDeliveryMessageSelectBox" name="devDeliveryMessageSelectBox">
                                        <option value="">Select shiping request</option>
                                        <option>Please leave it to the security office if unavailable</option>
                                        <option>Please contact me by cell phone if unavailable</option>
                                        <option>Place in fron to the porch</option>
                                        <option>Please contact before shipping</option>
                                        <option value="direct">Direct input.</option>
                                    </select>
                                    <div class="mat10 devDeliveryMessageDirectContents write-area">
                                        <input type="text"  class="devDeliveryMessage" name="devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                        </div>
                                    </div>
                                </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                                <div class="devEachDeliveryMessageContents option-box-each" devCartIx="<?php echo $TPL_V1["cart_ix"]?>">
                                    <p class="product-name"><?php echo $TPL_V1["pname"]?> <?php echo $TPL_V1["options_text"]?></p>
                                    <select class="devDeliveryMessageSelectBox">
                                        <option value="">Select shiping request</option>
                                        <option>Please leave it to the security office if unavailable</option>
                                        <option>Please contact me by cell phone if unavailable</option>
                                        <option>Place in fron to the porch</option>
                                        <option>Please contact before shipping</option>
                                        <option value="direct">Direct input.</option>
                                    </select>
                                    <div class="mat10 devDeliveryMessageDirectContents write-area">
                                        <input type="text" class="devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                                        </div>
                                    </div>
                                </div>
<?php }}?>

<?php if($TPL_VAR["productKindCount"]> 1){?>
                                <!--<span class="check">-->
                                    <!--<input type="checkbox" class="devDeliveryMessageIndividualCheckBox" id="messge-checkbox-sub">-->
                                    <!--<label for="messge-checkbox-sub">Individual input</label>-->
                                <!--</span>-->
<?php }?>
                            </div>
                        </li>
                    </ul>

                    <div class="tab-new__check-area">
                        <span class="tab-new__check">
                            <input type="checkbox" id="devAddAddressBookCheckBox" checked>
                            <label for="devAddAddressBookCheckBox">Add to shipping list</label>
                        </span>
                        <span class="tab-new__check">
                            <input type="checkbox" id="devBasicAddressBookCheckBox" checked>
                            <label for="devBasicAddressBookCheckBox">Set as default</label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>