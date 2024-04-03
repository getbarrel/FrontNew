<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_apply.htm 000050676 */ 
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<form id="devClaimApplyForm" method="post">
    <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">

    <!-- [S] 상품 교환/반품 상품 -->
    <section class="order-claim__able">
        <h3 class="order-claim__title br__hidden"><span id="devTitle" data-claimtypetext="<?php echo $TPL_VAR["claimTypeName"]?>"><?php echo $TPL_VAR["claimTypeName"]?> an Application product</span></h3>
        <div class="order-claim__content">
            <dl class="order-claim__number">
                <dt class="order-claim__number__title">Order Date</dt>
                <dd class="order-claim__number__text"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
                <dt class="order-claim__number__title">Order No.</dt>
                <dd class="order-claim__number__text" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            </dl>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <li class="order-claim__box devBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_VAR["odIx"]==''||$TPL_VAR["odIx"]==$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">

                    <input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' style="display:none" <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >

                    <div class="order-claim__goods">
                        <figure class="order-claim__goods__thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                        </figure>
                        <div class="order-claim__goods__info">
                            <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                            <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                            </p>
                            <span class="order-claim__goods__state">Out for delivery</span>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button type="button" class="order-claim__goods__toggle" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> Apply/cancel button</button>
                        </div>
                    </div>
                    <div class="order-claim__form">
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Quantity</span>
                            <div class="order-claim__form__input">
                                <div class="control">
                                    <ul class="option-up-down devControlCntBox">
<?php if(false){?>
                                        <li class="devCntMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="down"></button></li>
<?php }?>
                                        <li><input type="text" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devPcnt" readonly></li>
<?php if(false){?>
                                        <li class="devCntPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="up"></button></li>
<?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 교환/반품 사유 상위 1개 고정 -->
                        <div class="order-claim__form__box devExchangeCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Reason</span>
                            <div class="order-claim__form__input" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                <select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]"  class="devClaimReason" data-odix="<?php echo $TPL_V2["od_ix"]?>" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
                                    <option value="<?php echo $TPL_K3?>"><?php echo $TPL_V3["title"]?></option>
<?php }}?>
                                </select>
                            </div>
                        </div>

                        <div class="order-claim__form__box">
                            <div class="order-claim__form__input">
                                <textarea name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="<?php echo $TPL_VAR["claimTypeName"]?>사유를 입력해주세요.(최대 100자)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>" class="devCcMsg" title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
                            </div>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
    <!-- [E] 주문 교환/반품 상품 -->
    <div id="devClaimItemSec1" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
        <div class="wrap-sect"></div>
        <!-- [S] 주문 교환/반품 상품 추가 -->
        <section class="order-claim__disable">
            <h3 class="order-claim__title">Add items for <?php echo $TPL_VAR["claimTypeName"]?></h3>
            <div class="order-claim__content">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="order-claim__box  devBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>"  style="display:<?php if(($TPL_VAR["odIx"]!=''&&$TPL_VAR["odIx"]!=$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
                        <div class="order-claim__goods">
                            <figure class="order-claim__goods__thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                            </figure>
                            <div class="order-claim__goods__info">
                                <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                                <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                    <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                    <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                                </p>
                                <span class="order-claim__goods__state">Out for delivery</span>
                                <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                <button type="button" class="order-claim__goods__toggle" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> 신청/취소 버튼</button>
                            </div>
                        </div>
                    </li>
<?php }}?>
                </ul>
<?php }}?>
            </div>
        </section>
    </div>
    <!-- [E] 주문 교환/반품 상품 추가 -->




    <div class="wrap-sect"></div>
    <section class="order-claim__howto">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?>방법</h3>
        <p class="order-claim__sub"><?php echo $TPL_VAR["claimTypeName"]?>발송 방법</p>
        <div class="claim-howto__btn__wrap">
            <input type="hidden" name="send_type" value="1">
            <div class="claim-howto__btn">
                <input type="radio" class="devSendTypeCls" id="send_type_1" name="send_type" data-type="1" value="1" checked>
                <label for="send_type_1">직접발송</label>
            </div>
            <div class="claim-howto__btn">
                <input type="radio" class="devSendTypeCls" id="send_type_2" name="send_type" data-type="2" value="2">
                <label for="send_type_2">지정택배 방문 요청</label>
            </div>
        </div>
        <ul class="br__order-claim__notice">
            <li class="br__order-claim__desc" id="devMethod1">·직접발송: 구매자께서 개별로 상품을 이미 발송한 경우 <br>(직접발송 시 배송비는 선불결제만 가능)</li>
            <li class="br__order-claim__desc" id="devMethod2" style="display:none;">·지정택배 방문 요청: 판매사와 계약된 택배업체에서 방문하여 수거하는 경우</li>
        </ul>
    </section>
    <section class="order-claim__self active" id="devDirectDelivery">
        <p class="order-claim__sub"><?php echo $TPL_VAR["claimTypeName"]?>발송 정보</p>
        <div class="claim-howto__btn__wrap">
            <input type="hidden" name="quick_info" value="">
            <div class="claim-howto__btn">
                <input type="radio" class="devSelectDeliveryInfo" id="devSelectDeliveryInfo1" data-type="1" name="SelectDeliveryInfo" checked>
                <label for="devSelectDeliveryInfo1">발송업체 정보 입력</label>
            </div>
            <div class="claim-howto__btn">
                <input type="radio" class="devSelectDeliveryInfo" id="devSelectDeliveryInfo2" data-type="2" name="SelectDeliveryInfo">
                <label for="devSelectDeliveryInfo2">배송업체 정보 미기재</label>
            </div>
        </div>
        <div class="order-claim__self__form active" id="devDeliveryInfo">
            <select name="quick" id="devQuick" class="mat20 devClaimDeliveryCls" title="배송업체">
                <option value="">배송업체 선택</option>
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option><?php }}?>
            </select>
            <input type="text" name="invoice_no" id="devInvoiceNo" class="mat20 devClaimDeliveryCls" placeholder="송장번호 입력" title="송장번호">
        </div>
        <div style="width:0;height:0;overflow:hidden;opacity:0;">
            <!-- 기존 데이터기준 다음스텝을 위해 임시로 살려 놓은 소스 -->
            <!-- 개발시 불필요할 경우 삭제해주세요. -->
            <input type="hidden" name="delivery_pay_type" value="1">
            <div class="radio-tab jq-radio">
                <span class="on devPayType" id="devPayType1" data-type="1">선불</span>
                <span class="devPayType" id="devPayType2" data-type="2">착불</span>
            </div>
        </div>
    </section>


    <!-- 상품 수거지 주소 -->
    <section clas="claim-claim__return" id="devClaimAdressForm" style="display:none;">
        <div class="wrap-sect"></div>
        <h3 class="order-claim__title">상품 수거지 주소</h3>
        <div class="br__infoinput__address">
            <div class="br__tabs">
                <ul class="br__tabs__list">
                    <li class="br__tabs__box" data-target="list">
                        <button type="button" id="collect_address_type1" class="br__tabs__btn br__tabs__btn--active" data-target="list" devRecipientTypeSelect="address">최근 배송지</button>
                    </li>
                    <li class="br__tabs__box" data-target="new">
                        <button type="button" id="collect_address_type2" class="br__tabs__btn" data-target="new"  devRecipientTypeSelect="input">새로운 배송지</button>
                    </li>
                </ul>
                <div class="br__tabs__content br__tabs__content--show devRecipientContents" data-target="list">
                    <div class="info-addr">
                        <div class="info-addr__recent">

                            <!-- 상품 수거지 주소 -->
                            <button type="button" class="info-addr__recent__btn" id="devCollectAddressListButton">배송 주소록</button>

                            <ul id="devCollectAddressListContent" class="info-addr__recent__list">
                                <li id="devCollectAddressListLoading" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>Loading ...</strong></p>
                                    </div>
                                </li>

                                <li id="devCollectAddressListEmpty" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>등록된 배송지가 없습니다.</strong></p>
                                    </div>
                                </li>

                                <?php echo '<script type="text/x-forbiz-template" id="devCollectAddressList">'?>

                                <li class="info-addr__recent__box devOrderAddress">
                                    <label class="info-addr__recent__label">
                                        <div class="info-addr__recent__info">
                                            <span class="info-addr__recent__name">{[recipient]} {[#if isBasic]}<span>(기본)</span>{[/if]}</span>
                                            <span class="info-addr__recent__addr">{[address1]} {[address2]}</span>
                                            <span class="info-addr__recent__phone">{[mobile]}</span>
                                        </div>
                                        <input type="radio" class="devOrderAddressRadio" name="orderCAddress" data-rname="{[recipient]}" data-address1="{[address1]}" data-address2="{[address2]}" data-mobile="{[mobile]}" data-zipcode="{[zipcode]}" value="{[index]}" {[#if isBasic]} checked {[/if]}>
                                    </label>
                                </li>
                                <?php echo '</script>'?>

                            </ul>
                            <div class="info-addr__recent__select devDeliveryMessageContents">
                                <div class="info-buyer__form info-buyer__form--request">
                                    <select class="devDeliveryMessageSelectBox">
                                        <option value="">배송요청사항 선택</option>
                                        <option>Please leave it to the security office if unavailable</option>
                                        <option>Please contact me by cell phone if unavailable</option>
                                        <option>Place in fron to the porch</option>
                                        <option>Please contact before shipping</option>
                                        <option value="direct">직접입력</option>
                                    </select>
                                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                        <input type="text" name="cmsg_list" class="info-buyer__form__input devDeliveryMessage">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="br__tabs__content devRecipientContents" data-target="new">
                    <div class="info-buyer">
                        <div class="info-buyer__form">
                            <label for="devCname" class="info-buyer__form__label">이름</label>
                            <input type="text" id="devCname" name="cname" title="수거지의 이름" value="">
                        </div>
                        <div class="info-buyer__form info-buyer__form--phone">
                            <label for="devCmobile1" class="info-buyer__form__label">연락처</label>
                            <select id="devCmobile1" name="cmobile1" class="info-buyer__form__select devRecipientMobile1">
                                <option value="" selected>선택</option>
                                <option value="010" >010</option>
                                <option value="011" >011</option>
                                <option value="016" >016</option>
                                <option value="017" >017</option>
                                <option value="018" >018</option>
                                <option value="019" >019</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="cmobile2" id="devCmobile2" value="" title="휴대폰번호">
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="cmobile3" id="devCmobile3" value="" title="휴대폰번호">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label class="info-buyer__form__label">주소</label>
                            <div class="info-buyer__form__find-addr">
                                <input type="text" class="info-buyer__form__input"  name="czip" id="devClaim1Zip" title="수거지 우편번호" value=""  readonly>
                                <button type="button" class="info-buyer__form__btn" id="devClaim1ZipPopupButton">우편번호 검색</button>
                            </div>
                            <input type="text" class="info-buyer__form__input devRecipientAddr1" name="caddr1" id="devClaim1Address1" readonly title="수거지 주소" value="" readonly>
                            <input type="text" class="info-buyer__form__input devRecipientAddr2" name="caddr2" id="devClaim1Address2" title="수거지 상세주소" value="">
                        </div>
                        <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
                            <select class="devDeliveryMessageSelectBox">
                                <option value="">배송요청사항 선택</option>
                                <option>Please leave it to the security office if unavailable</option>
                                <option>Please contact me by cell phone if unavailable</option>
                                <option>Place in fron to the porch</option>
                                <option>Please contact before shipping</option>
                                <option value="direct">직접입력</option>
                            </select>
                            <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                <input type="text" name="cmsg" class="info-buyer__form__input devDeliveryMessage">
                                <div class="counting">
                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-buyer__form"><input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check"><label for="devBasicAddressBookCheckBox">기본배송지로 설정</label> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




<?php if($TPL_VAR["claimType"]=='change'){?>
    <div class="wrap-sect"></div>
    <section class="order-claim__delivery">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소</h3>
        <div class="br__infoinput__address">
            <div class="br__tabs">
                <ul class="br__tabs__list">
                    <li class="br__tabs__box" data-target="list">
                        <button type="button" id="address_type1" class="br__tabs__btn br__tabs__btn--active" data-target="list" devRecipientTypeSelect="address">최근 배송지</button>
                    </li>
                    <li class="br__tabs__box" data-target="new">
                        <button type="button" id="address_type2" class="br__tabs__btn" data-target="new"  devRecipientTypeSelect="input">새로운 배송지</button>
                    </li>
                </ul>

                <!-- 최근 배송지 -->
                <div class="br__tabs__content br__tabs__content--show devRecipientContents" data-target="list">
                    <div class="info-addr">
                        <div class="info-addr__recent">

                            <button type="button" class="info-addr__recent__btn" id="devChangeAddressListButton">배송 주소록</button>
                            <ul id="devChangeAddressListContent" class="info-addr__recent__list">
                                <?php echo '<script type="text/x-forbiz-template" id="devChangeAddressList">'?>

                                <li class="info-addr__recent__box devOrderAddress">
                                    <label class="info-addr__recent__label">
                                        <div class="info-addr__recent__info">
                                            <span class="info-addr__recent__name">{[recipient]} {[#if isBasic]}<span>(기본)</span>{[/if]}</span>
                                            <span class="info-addr__recent__addr">{[address1]} {[address2]}</span>
                                            <span class="info-addr__recent__phone">{[mobile]}</span>
                                        </div>
                                        <input type="radio" class="devOrderAddressRadio" name="orderRAddress" value="{[index]}" data-rname="{[recipient]}" data-address1="{[address1]}" data-address2="{[address2]}" data-mobile="{[mobile]}" data-zipcode="{[zipcode]}" data-type="{[type]}" data-isBasic="{[isBasic]}" {[#if isBasic]} checked {[/if]} >
                                    </label>
                                </li>
                                <?php echo '</script>'?>


                                <li id="devChangeAddressListLoading" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>Loading ...</strong></p>
                                    </div>
                                </li>

                                <li id="devChangeAddressListEmpty" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>등록된 배송지가 없습니다.</strong></p>
                                    </div>
                                </li>
                            </ul>
                            <div class="info-addr__recent__select devDeliveryMessageContents">
                                <div class="info-buyer__form info-buyer__form--request">
                                    <select class="devDeliveryMessageSelectBox devAddressInfo" >
                                        <option value="">배송요청사항 선택</option>
                                        <option>Please leave it to the security office if unavailable</option>
                                        <option>Please contact me by cell phone if unavailable</option>
                                        <option>Place in fron to the porch</option>
                                        <option>Please contact before shipping</option>
                                        <option value="direct">직접입력</option>
                                    </select>
                                    <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                        <input type="text" name="rmsg_list" class="info-buyer__form__input devDeliveryMessage" maxlength="30">
                                        <div class="counting">
                                            <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 새로운 배송지 -->
                <div class="br__tabs__content devRecipientContents" data-target="new">
                    <div class="info-buyer">
                        <div class="info-buyer__form">
                            <label for="devRname" class="info-buyer__form__label">이름</label>
                            <input type="text" name="rname" id="devRname" title="수거지의 이름" value="">
                        </div>
                        <div class="info-buyer__form info-buyer__form--phone">
                            <label for="devRmobile1" class="info-buyer__form__label">연락처</label>
                            <select id="devRmobile1" name="rmobile1" class="info-buyer__form__select devRecipientMobile1">
                                <option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="rmobile2" id="devRmobile2" value="" title="휴대폰번호">
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="rmobile3" id="devRmobile3" value="" title="휴대폰번호">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label class="info-buyer__form__label">주소</label>
                            <div class="info-buyer__form__find-addr">
                                <input type="text" class="info-buyer__form__input"  name="rzip" id="devClaim2Zip" title="받으실곳 우편번호" value="" readonly>
                                <button type="button" class="info-buyer__form__btn" id="devClaim2ZipPopupButton">우편번호 검색</button>
                            </div>
                            <input type="text" class="info-buyer__form__input devRecipientAddr1" name="raddr1" id="devClaim2Address1" readonly title="수거지 주소" value="" readonly>
                            <input type="text" class="info-buyer__form__input devRecipientAddr2" name="raddr2" id="devClaim2Address2" title="받으실곳 상세주소" value="">
                        </div>

                        <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
                            <select class="devDeliveryMessageSelectBox">
                                <option value="">배송요청사항 선택</option>
                                <option>Please leave it to the security office if unavailable</option>
                                <option>Please contact me by cell phone if unavailable</option>
                                <option>Place in fron to the porch</option>
                                <option>Please contact before shipping</option>
                                <option value="direct">직접입력</option>
                            </select>

                            <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                <input type="text" name="rmsg" class="info-buyer__form__input devDeliveryMessage">
                                <div class="counting">
                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-buyer__form"><input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check"><label for="devBasicAddressBookCheckBox">기본배송지로 설정</label> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

</form>



<form id="devCollectAddressListForm"></form>
<form id="devChangeAddressListForm"></form>




































<!-- 글로벌 -->
<?php }else{?>

<form id="devClaimApplyForm" method="post">
    <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">


    <!-- [S] 상품 교환/반품 상품 -->
    <section class="order-claim__able">
        <h3 class="order-claim__title br__hidden"><span id="devTitle"><?php echo $TPL_VAR["claimTypeName"]?> an Application product</span></h3>
        <div class="order-claim__content">
            <dl class="order-claim__number">
                <dt class="order-claim__number__title">Order Date</dt>
                <dd class="order-claim__number__text"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
                <dt class="order-claim__number__title">Order No.</dt>
                <dd class="order-claim__number__text" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            </dl>

<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <li class="order-claim__box devBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_VAR["odIx"]==''||$TPL_VAR["odIx"]==$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
                    <input type="hidden" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>'>
                    <div class="order-claim__goods">
                        <figure class="order-claim__goods__thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                        </figure>
                        <div class="order-claim__goods__info">
                            <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                            <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                            </p>
                            <span class="order-claim__goods__state">Out for delivery</span>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button type="button" class="order-claim__goods__toggle" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> Apply/cancel button</button>
                        </div>
                    </div>
                    <div class="order-claim__form">
                        <div class="order-claim__form__box">
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Quantity</span>
                            <div class="order-claim__form__input">
                                <div class="control">
                                    <ul class="option-up-down devControlCntBox">
<?php if(false){?>
                                        <li class="devCntMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="down"></button></li>
<?php }?>
                                        <li><input type="text" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" value="<?php echo $TPL_V2["pcnt"]?>"  data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>" class="devPcnt" readonly></li>
<?php if(false){?>
                                        <li class="devCntPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>"><button type="button" class="up"></button></li>
<?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 교환/반품 사유 1개 고정 -->
                        <div class="order-claim__form__box devExchangeCodeArea" >
                            <span class="order-claim__form__title"><?php echo $TPL_VAR["claimTypeName"]?> Reason</span>
                            <div class="order-claim__form__input " data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                <select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]" class="devClaimReason" data-odix="<?php echo $TPL_V2["od_ix"]?>" title="<?php echo $TPL_VAR["claimTypeName"]?> Reason">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
                                    <option value="<?php echo $TPL_K3?>"><?php echo $TPL_V3["title"]?></option>
<?php }}?>
                                </select>
                            </div>
                        </div>

                        <div class="order-claim__form__box">
                            <div class="order-claim__form__input">
                                <textarea name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="Please enter reasons for cancellation (100 word max)" maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>" class="devCcMsg" title="<?php echo $TPL_VAR["claimTypeName"]?> Reason"></textarea>
                            </div>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
    <!-- [E] 주문 교환/반품 상품 -->

    <div id="devClaimItemSec1" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
        <div class="wrap-sect"></div>
        <!-- [S] 주문 교환/반품 상품 추가 -->
        <section class="order-claim__disable">
            <h3 class="order-claim__title">Add items for <?php echo $TPL_VAR["claimTypeName"]?></h3>
            <div class="order-claim__content">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="order-claim__box  devBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>"  style="display:<?php if(($TPL_VAR["odIx"]!=''&&$TPL_VAR["odIx"]!=$TPL_V2["od_ix"])){?>block<?php }else{?>none<?php }?>">
                        <div class="order-claim__goods">
                            <figure class="order-claim__goods__thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                            </figure>
                            <div class="order-claim__goods__info">
                                <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                                <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                    <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                    <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                                </p>
                                <span class="order-claim__goods__state">Out for delivery</span>
                                <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                <button type="button" class="order-claim__goods__toggle" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_VAR["claimTypeName"]?> Apply/cancel button</button>
                            </div>
                        </div>
                    </li>
<?php }}?>
                </ul>
<?php }}?>
            </div>
        </section>
    </div>

    <!-- [E] 주문 교환/반품 상품 추가 -->







<?php if(false){?>
    <div class="wrap-sect"></div>
    <section class="order-claim__howto">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h3>

    </section>

    <section class="order-claim__self active" id="devDirectDelivery">
        <p class="order-claim__sub"><?php echo $TPL_VAR["claimTypeName"]?>Shipping information</p>

        <div class="order-claim__self__form active" id="devDeliveryInfo">
            <input type="text" name="quick" id="devQuick" class="mat20 devClaimDeliveryCls" placeholder="Please enter the name of logistics." title="Logistics">
            <input type="text" name="invoice_no" id="devInvoiceNo" class="mat20 devClaimDeliveryCls" placeholder="Enter the Tracking No. without &#39;-&#39;." title="Tracking No.">
        </div>

        <div style="width:0;height:0;overflow:hidden;opacity:0;">
            <!-- 기존 데이터기준 다음스텝을 위해 임시로 살려 놓은 소스 -->
            <!-- 개발시 불필요할 경우 삭제해주세요. -->
            <input type="hidden" name="delivery_pay_type" value="1">
            <div class="radio-tab jq-radio">
                <span class="on devPayType" id="devPayType1" data-type="1">선불</span>
                <span class="devPayType" id="devPayType2" data-type="2">착불</span>
            </div>
        </div>
    </section>

<?php }?>

<?php if($TPL_VAR["claimType"]=='change'&&false){?>
    <div class="wrap-sect"></div>
    <section class="order-claim__delivery">
        <h3 class="order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소</h3>
        <div class="br__infoinput__address">
            <div class="br__tabs">

                <ul class="br__tabs__list">
                    <li class="br__tabs__box" data-target="list">
                        <button type="button" id="address_type1" class="br__tabs__btn br__tabs__btn--active" data-target="list" devRecipientTypeSelect="address">최근 배송지</button>
                    </li>
                    <li class="br__tabs__box" data-target="new">
                        <button type="button" id="address_type2" class="br__tabs__btn" data-target="new"  devRecipientTypeSelect="input">새로운 배송지</button>
                    </li>
                </ul>

                <div class="br__tabs__content br__tabs__content--show devRecipientContents" data-target="list">
                    <div class="info-addr">
                        <div class="info-addr__recent">

                            <button type="button" class="info-addr__recent__btn" id="devChangeRAddressListButton">배송 주소록</button>
                            <ul id="devChangeRAddressListContent" class="info-addr__recent__list">
                                <?php echo '<script type="text/x-forbiz-template" id="devChangeAddressList">'?>

                                <li class="info-addr__recent__box devOrderAddress ">
                                    <label class="info-addr__recent__label">
                                        <div class="info-addr__recent__info">
                                            <span class="info-addr__recent__name">{[recipient]} {[#if isBasic]}<span>(기본)</span>{[/if]}</span>
                                            <span class="info-addr__recent__addr">{[address1]} {[address2]}</span>
                                            <span class="info-addr__recent__phone">{[mobile]}</span>
                                        </div>
                                        <input type="radio" class="devOrderAddressRadio" name="orderAddress" value="{[index]}" {[#if isBasic]} checked {[/if]}>
                                        <div class="info-addr__recent__select devDeliveryMessageContents">
                                            <div class="info-buyer__form info-buyer__form--request">
                                                <select class="devDeliveryMessageSelectBox devAddressInfo" >
                                                    <option value="">배송요청사항 선택</option>
                                                    <option>Please leave it to the security office if unavailable</option>
                                                    <option>Please contact me by cell phone if unavailable</option>
                                                    <option>Place in fron to the porch</option>
                                                    <option>Please contact before shipping</option>
                                                    <option value="direct">직접입력</option>
                                                </select>
                                                <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                                    <input type="text" class="info-buyer__form__input devDeliveryMessage" maxlength="30">
                                                    <div class="counting">
                                                        <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                                <?php echo '</script>'?>


                                <li id="devChangeAddressListLoading" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>Loading ...</strong></p>
                                    </div>
                                </li>

                                <li id="devChangeAddressListEmpty" class="devForbizTpl">
                                    <div class="info">
                                        <p class="name"><strong>등록된 배송지가 없습니다.</strong></p>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>


                <div class="br__tabs__content devRecipientContents" data-target="new">
                    <div class="info-buyer">
                        <div class="info-buyer__form">
                            <label for="devRname" class="info-buyer__form__label">이름</label>
                            <input type="text" name="rname" id="devRname" title="수거지의 이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>">
                        </div>
                        <div class="info-buyer__form info-buyer__form--phone">
                            <label for="devRmobile1" class="info-buyer__form__label">연락처</label>
                            <select id="devRmobile1" name="rmobile1" class="info-buyer__form__select devRecipientMobile1">
                                <option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
                            </select>
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="rmobile2" id="devRmobile2" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" title="휴대폰번호">
                            <span class="hyphen">-</span>
                            <input  type="number" class="info-buyer__form__input" name="rmobile3" id="devRmobile3" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" title="휴대폰번호">
                        </div>
                        <div class="info-buyer__form info-buyer__form--addr">
                            <label class="info-buyer__form__label">주소</label>
                            <div class="info-buyer__form__find-addr">
                                <input type="text" class="info-buyer__form__input"  name="rzip" id="devClaim2Zip" title="받으실곳 우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>" readonly>
                                <button type="button" class="info-buyer__form__btn" id="devClaim2ZipPopupButton">우편번호 검색</button>
                            </div>
                            <input type="text" class="info-buyer__form__input devRecipientAddr1" name="raddr1" id="devClaim2Address1" readonly title="수거지 주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>" readonly>
                            <input type="text" class="info-buyer__form__input devRecipientAddr2" name="raddr2" id="devClaim2Address2" title="받으실곳 상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>">
                        </div>

                        <div class="info-buyer__form info-buyer__form--request devDeliveryMessageContents">
                            <select class="devDeliveryMessageSelectBox">
                                <option value="">배송요청사항 선택</option>
                                <option>Please leave it to the security office if unavailable</option>
                                <option>Please contact me by cell phone if unavailable</option>
                                <option>Place in fron to the porch</option>
                                <option>Please contact before shipping</option>
                                <option value="direct">직접입력</option>
                            </select>
                            <div class="info-buyer__form__direct devDeliveryMessageDirectContents" style="display:none;">
                                <input type="text" name="rmsg" class="info-buyer__form__input devDeliveryMessage">
                                <div class="counting">
                                    <span><em class="devDeliveryMessageByte">0</em>/30 자</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-buyer__form"><input type="checkbox" id="devBasicAddressBookCheckBox" class="info-buyer__form__check"><label for="devBasicAddressBookCheckBox">기본배송지로 설정</label> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

</form>

<form id="devCollectAddressListForm"></form>
<form id="devChangeAddressListForm"></form>

<?php }?>