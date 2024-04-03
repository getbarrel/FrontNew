<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_non_member_global.htm 000011065 */ 
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<section class="fb__infoinput__nonmember">

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

    <section class="fb__infoinput__customer-info customer-info">
        <h2 class="customer-info__title">주문자 정보</h2>

        <ul class="customer-info__box">
            <li class="customer-info__list customer-info__list-name">
                <span class="customer-info__list__title customer-info__list__title-required">
                    이름
                </span>
                <input type="text" id="devBuyerName" name="devBuyerName" title="주문자 이름">
            </li>
            <li class="customer-info__list customer-info__list-cp">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Tel
                </span>
                <div class="selectWrap customer-info__list__input-area">
                    <select id="devBuyerMobile1" name="devBuyerMobile1">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]=='US'){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                    </select>
                    -
                    <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" value="" title="휴대폰 번호">

                </div>
            </li>
            <li class="customer-info__list customer-info__list-email">
                <span class="customer-info__list__title customer-info__list__title-required">
                    이메일 주소
                </span>
                <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" title="주문자 이메일">
                <span>@</span>
                <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" value="" class="js__infoinput__email-target">
            </li>
            <li class="customer-info__list customer-info__list-pw">
                <span class="customer-info__list__title customer-info__list__title-required">
                    주문 비밀번호
                </span>
                <input type="password" id="devOrderPassword" name="devOrderPassword" title="주문 비밀번호">
                <span class="customer-info__list__guide">영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 6~20자리로 입력해 주세요.</span>
            </li>
            <li class="customer-info__list customer-info__list-pw">
                <span class="customer-info__list__title customer-info__list__title-required">
                    주문 비밀번호 확인
                </span>
                <input type="password" id="devOrderPasswordCompare" name="devOrderPasswordCompare" title="주문 비밀번호 확인">
                <span class="customer-info__list__guide">비밀번호 확인을 위해 다시 한번 입력해 주세요.</span>
            </li>
        </ul>

    </section>

    <section class="fb__infoinput__delivery-info delivery-info devRecipientContents">
        <h2 class="delivery-info__title">배송지 정보</h2>

        <div class="check-area delivery-info__check-area">
            <input type="checkbox" class="devSameBuyerInfo" id="sam-buyer-checkbox">
            <label for="sam-buyer-checkbox">주문자 정보와 동일</label>
        </div>

        <ul class="delivery-info__box">
            <li class="delivery-info__list delivery-info__list-name">
                <span class="delivery-info__list__title delivery-info__list__title-required">
                    받는 분
                </span>
                <input type="text" class="devRecipientName" name="devRecipientName" title="받는 분">
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
                    <select class="devRecipientMobile1 devNationArea" name="devRecipientMobile1">
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
                <div class="delivery-request nonmember delivery-info__list__input-area input-area">
                    <div class="devDeliveryMessageContents option-box">
                        <div class="mat10 devDeliveryMessageDirectContents write-area">
                            <input type="text" class="devDeliveryMessage" name="devDeliveryMessage">
                            <div class="counting">
                                <span><em class="devDeliveryMessageByte">0</em>/60 byte</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__nonmember-agreement nonmember-agreement">
        <h2 class="nonmember-agreement__title">비회원 약관동의</h2>
        <div class="nonmember-agreement__cont">
            <p class="nonmember-agreement__cont-tit">비회원 구매 이용 약관 <span>((필수))</span></p>
            <div class="nonmember-agreement__cont-input">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo $TPL_VAR["use"]['contents']?>

<?php }else{?>
                <?php echo $TPL_VAR["use"]?>

<?php }?>
            </div>
            <div class="nonmember-agreement__agree">
                <input type="checkbox" id="wrap-terms-30" class="devTerms" name="term30" value="30" title="비회원 구매 이용 약관" devvalidation="{&quot;required&quot;:true,&quot;requiredMessageTag&quot;:&quot;infoinput.paymentRequest.validation.fail.terms&quot;}">
                <label for="wrap-terms-30">동의</label>
            </div>
        </div>
    </section>

</section>