<?php /* Template_ 2.2.8 2020/12/15 16:22:19 /home/barrel-stage/application/www/assets/templet/enterprise/shop/infoinput/infoinput_non_member.htm 000014552 */ 
$TPL_cartProductList_1=empty($TPL_VAR["cartProductList"])||!is_array($TPL_VAR["cartProductList"])?0:count($TPL_VAR["cartProductList"]);?>
<section class="fb__infoinput__nonmember">

<?php if($TPL_VAR["freeGift"]["gift_products"]){?>    <div class="order-info__pricegift warp_gift_list devOrderGiftArea">
        <div class="gift_list">
            <h3 class="order-info__pricegift__title">Gift by purchase amount</h3>
            <ul style="display:none;">
<?php if(is_array($TPL_R1=$TPL_VAR["freeGift"]["gift_products"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <li>
                    <img src="<?php echo $TPL_VAR["freeGift"]["image_src"]?>" data-devpid="<?php echo $TPL_VAR["freeGift"]["pid"]?>" alt="">
                    <p><?php echo $TPL_VAR["freeGift"]["pname"]?></p>
                </li>
<?php }}?>
            </ul>
        </div>
        <button class="order-info__pricegift__btn btn-default devGiftBox"><span>Gift by purchase amount</span></button>
        <div class="product-gift devOrderGift" style="display:none;">
            <div class="product-gift__list" id="devOrderGiftList">

            </div>
        </div>
    </div>
<?php }?>
    
    <section class="fb__infoinput__customer-info customer-info">
        <h2 class="customer-info__title">Orderer Information</h2>

        <ul class="customer-info__box">
            <li class="customer-info__list customer-info__list-name">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Name
                </span>
                <input type="text" id="devBuyerName" name="devBuyerName" title="주문자 이름">
            </li>
            <li class="customer-info__list customer-info__list-cp">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Tel
                </span>
                <div class="selectWrap customer-info__list__input-area">
                    <select id="devBuyerMobile1">
                        <option>010</option>
                        <option>011</option>
                        <option>016</option>
                        <option>017</option>
                        <option>018</option>
                        <option>019</option>
                    </select>
                    -
                    <input type="text" id="devBuyerMobile2" name="devBuyerMobile2" value="" title="휴대폰 번호">
                    -
                    <input type="text" id="devBuyerMobile3" name="devBuyerMobile3" value="" title="휴대폰 번호">
                </div>
            </li>
            <li class="customer-info__list customer-info__list-email">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Email
                </span>
                <input type="text" id="devBuyerEmailId" name="devBuyerEmailId" title="Orderer E-mail">
                <span>@</span>
                <input type="text" id="devBuyerEmailHost" name="devBuyerEmailHost" value="" class="js__infoinput__email-target">
                <select name="" id="" class="js__infoinput__email-select">
                    <option value="">Direct input.</option>
                    <option value="naver.com">naver.com</option>
                    <option value="gmail.com">gmail.com</option>
                    <option value="hotmail.com">hotmail.com</option>
                    <option value="hanmail.net">hanmail.net</option>
                    <option value="daum.net">daum.net</option>
                    <option value="nate.com">nate.com</option>
                </select>
                <span class="customer-info__list__desc">SMS and e-mail us the progress of your order.</span>
            </li>
            <li class="customer-info__list customer-info__list-pw">
                <span class="customer-info__list__title customer-info__list__title-required">
                    Order Password
                </span>
                <input type="password" id="devOrderPassword" name="devOrderPassword" title="주문 비밀번호" maxlength="16">
                <span class="customer-info__list__guide">Combination with at least 2 of upper and lower case letters, numbers, and special characters, 8 ~ 16 digits.</span>
            </li>
            <li class="customer-info__list customer-info__list-pw">
                <span class="customer-info__list__title customer-info__list__title-required">
                    order password comfirmation
                </span>
                <input type="password" id="devOrderPasswordCompare" name="devOrderPasswordCompare" title="주문 비밀번호 확인" maxlength="16">
                <span class="customer-info__list__guide">Enter again to confirm your password.</span>
            </li>
            <li class="customer-info__list customer-info__list" style="padding-left:24px;">
                <span class="customer-info__list__title customer-info__list__title-required" style="text-indent: 0px;width: 135px;    line-height: 25px;">
                    [미성년확인]<br>만14세 이상입니까?
                </span>
                <label class="inputs__label" style="display: inline-block;    width: 50px;    padding-bottom: 20px;"><input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="Y"> <span style="vertical-align: middle; margin-left:3px;">Yes</span></label>
                <label class="inputs__label" style="display: inline-block;    width: 100px;    padding-bottom: 20px;"><input type="radio" title="미성년확인" name="underAge" id="devBuyUnderAge" value="N"> <span style="vertical-align: middle; margin-left:3px;">No</span></label>
            </li>
        </ul>

    </section>

    <section class="fb__infoinput__delivery-info delivery-info devRecipientContents">
        <h2 class="delivery-info__title">Shipping Information</h2>

        <div class="check-area delivery-info__check-area">
            <input type="checkbox" class="devSameBuyerInfo" id="sam-buyer-checkbox">
            <label for="sam-buyer-checkbox">Same as the orderer</label>
        </div>

        <ul class="delivery-info__box">
            <li class="delivery-info__list delivery-info__list-name">
                <span class="delivery-info__list__title delivery-info__list__title-required">
                    Name
                </span>
                <input type="text" class="devRecipientName" name="devRecipientName" title="받는 분 이름">
            </li>
            <li class="delivery-info__list delivery-info__list-address">
                <span class="delivery-info__list__title delivery-info__list__title-required">
                    Address
                </span>
                <div class="form-info-wrap delivery-info__list__input-area">
                    <input type="text" class="zip-code  devRecipientZip" name="devRecipientZip" title="Orderer Address 1" readonly>
                    <button class="btn-default btn-dark devRecipientZipPopupButton">Zip code search</button>
                    <input type="text" class="input-address  devRecipientAddr1" name="devRecipientAddr1" title="Orderer Address 1" readonly>
                    <input type="text" class="input-add-detail devRecipientAddr2" name="devRecipientAddr2" title="Orderer Address 2">
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
                    <input type="text" name="devRecipientMobile2" class="devRecipientMobile2" title="Orderer Phone">
                    -
                    <input type="text" name="devRecipientMobile3" class="devRecipientMobile3" title="Orderer Phone">
                </div>
            </li>
            <!--<li class="delivery-info__list">-->
                <!--<span class="delivery-info__list__title">-->
                    <!--Tel-->
                <!--</span>-->
                <!--<div class="selectWrap delivery-info__list__input-area">-->
                    <!--<select class="devRecipientTel1">-->
                        <!--<option value="02">02</option>-->
                        <!--<option value="031">031</option>-->
                        <!--<option value="032">032</option>-->
                        <!--<option value="041">041</option>-->
                        <!--<option value="042">042</option>-->
                        <!--<option value="043">043</option>-->
                        <!--<option value="051">051</option>-->
                        <!--<option value="052">052</option>-->
                        <!--<option value="053">053</option>-->
                        <!--<option value="054">054</option>-->
                        <!--<option value="055">055</option>-->
                        <!--<option value="061">061</option>-->
                        <!--<option value="062">062</option>-->
                        <!--<option value="063">063</option>-->
                        <!--<option value="064">064</option>-->
                        <!--<option value="070">070</option>-->
                        <!--<option value="080">080</option>-->
                        <!--<option value="090">090</option>-->
                    <!--</select>-->
                    <!-- - -->
                    <!--<input type="text" class="devRecipientTel2" title="받는 분 전화번호">-->
                    <!-- - -->
                    <!--<input type="text" class="devRecipientTel3" title="받는 분 전화번호">-->
                <!--</div>-->
            <!--</li>-->
            <li class="delivery-info__list delivery-info__list-request">
                <span class="delivery-info__list__title">
                    Shipping comment
                </span>
                <div class="delivery-request nonmember delivery-info__list__input-area input-area">
                    <div class="devDeliveryMessageContents option-box">
                        <!--<p class="product-name"><?php echo $TPL_VAR["contractionProductName"]?></p>-->
                        <select class="devDeliveryMessageSelectBox" name="devDeliveryMessageSelectBox">
                            <option value="">Select shiping request</option>
                            <option>Please leave it to the security office if unavailable</option>
                            <option>Please contact me by cell phone if unavailable</option>
                            <option>Place in fron to the porch</option>
                            <option>Please contact before shipping</option>
                            <option value="direct">Direct input.</option>
                        </select>
                        <div class="mat10 devDeliveryMessageDirectContents write-area">
                            <input type="text" class="devDeliveryMessage" name="devDeliveryMessage">
                            <div class="counting">
                                <span><em class="devDeliveryMessageByte">0</em>/30 영문몰해당없음</span>
                            </div>
                        </div>
                    </div>
<?php if($TPL_cartProductList_1){foreach($TPL_VAR["cartProductList"] as $TPL_V1){?>
                    <div class="devEachDeliveryMessageContents option-box-each" devCartIx="<?php echo $TPL_V1["cart_ix"]?>">
                        <p class="product-name"><?php echo $TPL_V1["pname"]?></p>
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
            </li>
        </ul>
    </section>

    <section class="fb__infoinput__nonmember-agreement nonmember-agreement">
        <h2 class="nonmember-agreement__title">Term Agreement for Non-Member</h2>
        <div class="nonmember-agreement__cont">
            <p class="nonmember-agreement__cont-tit">Term of use for non member purchase <span>(Required)</span></p>
            <div class="nonmember-agreement__cont-input">
                <?php echo $TPL_VAR["use"]['contents']?>

            </div>
            <div class="nonmember-agreement__agree">
                <input type="checkbox" id="wrap-terms-30" class="devTerms" name="term30" value="30" title="비회원 구매 이용 약관" devvalidation="{&quot;required&quot;:true,&quot;requiredMessageTag&quot;:&quot;infoinput.paymentRequest.validation.fail.terms&quot;}">
                <label for="wrap-terms-30">Agree</label>
            </div>
        </div>
    </section>

</section>