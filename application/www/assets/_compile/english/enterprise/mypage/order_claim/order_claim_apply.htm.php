<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_apply.htm 000043532 */ 
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);
$TPL_nation_1=empty($TPL_VAR["nation"])||!is_array($TPL_VAR["nation"])?0:count($TPL_VAR["nation"]);
$TPL_regional_information_1=empty($TPL_VAR["regional_information"])||!is_array($TPL_VAR["regional_information"])?0:count($TPL_VAR["regional_information"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__mypage__order-claim">
    <div class="claim">
        <h2 class="fb__title--hidden"><?php echo $TPL_VAR["claimTypeName"]?></h2>


        <form id="devClaimApplyForm" method="post">
            <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
            <section class="claim__list claim__able exchange-apply">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <table class="claim__list__table table-default order-table">
                    <colgroup>
                        <col width="*"/>
                        <col width="100px"/>
                        <col width="100px"/>
                        <col width="110px"/>
                        <col width="100px"/>
                        <col width="130px"/>
                    </colgroup>
                    <thead>
                        <th>Item Name/Option</th>
                        <th>Order Status</th>
                        <th>Quantities of order</th>
                        <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                        <th>Estimated Total</th>
                        <th><?php echo $TPL_VAR["claimTypeName"]?>Add item</th>
                    </thead>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <tr class="devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?><?php }else{?>none<?php }?>">
                            <td>
                                <input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' style="display:none" <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >
                                <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                    <div class="thumb">
                                        <img src="<?php echo $TPL_V2["pimg"]?>">
                                    </div>
                                    <div class="info">
                                        <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                        <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                        <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                    </div>
                                </a>
                            </td>
                            <td><?php echo trans($TPL_V2["status_text"])?></td>
                            <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                            <td>

                                <select class="devClaimCntCls" id="devClaimCnt<?php echo $TPL_V2["od_ix"]?>" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                    <option value="<?php echo $TPL_V2["pcnt"]?>"><?php echo $TPL_V2["pcnt"]?></option>
<?php if(false){?>
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                    <option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option>
<?php }}?>
<?php }?>
                                </select>
                            </td>
                            <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td>
                                <button type="button" class="claim__list__icon" data-odix="<?php echo $TPL_V2["od_ix"]?>">마이너스버튼</button>
                            </td>
                        </tr>
                        <tr class="devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])){?><?php }else{?>none<?php }?>">
                            <td colspan="6" style="padding-top:0;">
                                <div class="reason-box claim__list__reason">
                                    <dl class="reason-box__inner">
                                        <dt class="reason-box__title">
                                            <?php echo $TPL_VAR["claimTypeName"]?> Reason
                                        </dt>
                                        <dd class="reason-box__cont js__counting">
                                            <div class="devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                            <select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>" class="devCcReason" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
                                                <option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>">Others</option>
<?php }else{?>
                                                <option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
                                            </select>
                                            </div>
                                            <textarea class="js__counting__textarea devCcMsg" name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder="<?php echo $TPL_VAR["claimTypeName"]?>사유를 입력해 주세요." maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
                                            <div class="counting">
                                                <span><em class="js__counting__num" id="devClaimMsgLength">0</em>/100 자</span>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </td>
                        </tr>
<?php }}?>
                    </tbody>
                </table>
                <div class="claim__list__empty" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>" >
                    <span>No product <?php echo $TPL_VAR["claimTypeName"]?>selected.</span>
                </div>
<?php }}?>
            </section>



            <!--[S] 교환/반품 취소 상품 신청 (하단)-->
            <div id="devClaimItemSec1" style="display:<?php if($TPL_VAR["claimAbleCnt"]> 1){?>block<?php }else{?>none<?php }?>">
            <section class="claim__list claim__disable fb__mypage__section" >
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <h3 class="fb__mypage__title claim__disable__title"><?php echo $TPL_VAR["claimTypeName"]?> Add Items for Cancellation</h3>
                <table class="claim__list__table table-default order-table">
                    <colgroup>
                        <col width="*"/>
                        <col width="100px"/>
                        <col width="100px"/>
                        <col width="110px"/>
                        <col width="100px"/>
                        <col width="130px"/>
                    </colgroup>
                    <thead>
                        <th>Item Name/Option</th>
                        <th>Order Status</th>
                        <th>Quantities of order</th>
                        <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                        <th>Estimated Total</th>
                        <th><?php echo $TPL_VAR["claimTypeName"]?>Add item</th>
                    </thead>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <tr class="devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"])||($TPL_VAR["odIx"]=='')){?><?php }else{?>none<?php }?>">
                            <td>
                                <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                    <div class="thumb">
                                        <img src="<?php echo $TPL_V2["pimg"]?>">
                                    </div>
                                    <div class="info">
                                        <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                        <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                        <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                    </div>
                                </a>
                            </td>
                            <td><?php echo trans($TPL_V2["status_text"])?></td>
                            <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                            <td>
                                <select class="devCancelCntCls" disabled>
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option><?php }}?>
                                </select>
                            </td>
                            <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td><button type="button" class="claim__list__icon" data-odix="<?php echo $TPL_V2["od_ix"]?>">플러스버튼</button></td>
                        </tr>
<?php }}?>
                    </tbody>
                </table>

                <div class="claim__list__empty" id="devArea2" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>" >
                    <span><?php echo $TPL_VAR["claimTypeName"]?>There are no additional items to cancel.</span>
                </div>

<?php }}?>
            </section>
            </div>
            <!-- [E] -->



            <section class="exchange-method fb__mypage__section">
                <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>
                <ul class="exchange-method__box">
                    <li class="exchange-method__list">
                        <span class="exchange-method__title exchange-method__title--required">
                            <?php echo $TPL_VAR["claimTypeName"]?> Shipping method
                        </span>
                        <div class="exchange-method__cont">
                            <div class="exchange-method__cont-list">
                                <input type="radio" name="send_type" value="1" class="devSendTypeCls" id="send_type_1" checked>
                                <label for="send_type_1">Sending in Person(If the buyer sent the item individually)</span></label>
                            </div>
                            <div class="exchange-method__cont-list">
                                <input type="radio" name="send_type" value="2" class="devSendTypeCls" id="send_type_2">
                                <label for="send_type_2">Request visit to designated shipping company</span></label>
                            </div>
                        </div>
                    </li>

                    <!--직접발송 선택시-->
                    <li class="exchange-method__list self-type"  id="devDirectDelivery">
                        <span class="exchange-method__title">
                            Shipping information for <?php echo $TPL_VAR["claimTypeName"]?>

                        </span>
                        <div class="exchange-method__cont">
                            <div class="exchange-method__cont-list">
                                <select name="quick" id="devQuick" class="devClaimDeliveryCls" title="배송업체">
                                    <option value="">Select a shipping company</option>
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option><?php }}?>
                                </select>
                                <input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="‘-’을 제외한 송장번호를 입력해주세요." title="송장번호">

                                <input type="checkbox" name="quick_info" value="N" id="devDcompnyApplyChk"><label for="devDcompnyApplyChk">Do not enter an information of a shipping company</label>
                            </div>

                            <input type="hidden" name="delivery_pay_type" value="1">

                            <!--<div class="exchange-method__cont-list">-->
                                <!--shipping fee for delivery-->
                                <!--<span class="radio-area mal10">-->
                                    <!--<input type="radio" name="delivery_pay_type" value="1" id="devDpayType1" checked>-->
                                    <!--<label>Pre-paid</label>-->
                                <!--</span>-->
                                <!--<span class="radio-area">-->
                                    <!--<input type="radio" name="delivery_pay_type" value="2" id="devDpayType2">-->
                                    <!--<label>Collect on delivery</label>-->
                                <!--</span>-->
                            <!--</div>-->

                            <!--<p class="exchange-method__cont-annc">* <?php echo $TPL_VAR["claimTypeName"]?> Enter your shipping information for faster and more accurate processing.</p>-->
                            <p class="exchange-method__cont-annc">Prepaid shipping fee is required</p>
                        </div>
                    </li>

                    <!--지정택배 선택시-->
                    <li class="exchange-method__list"  id="devClaimAdressForm1" style="display:none;">
                        <span class="exchange-method__title">
                            Pick up address
                        </span>

                        <ul class="my-info">
                            <li class="my-info__list my-info__list-name">
                                <span class="my-info__title my-info__title--required">
                                    Name
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" name="cname" id="devCname" title="수거지의 이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-address">
                                <span class="my-info__title my-info__title--required">
                                    Address
                                </span>
                                <div class="my-info__cont form-info-wrap">
                                    <input type="text" class="zipcode dim" name="czip" id="devClaim1Zip" readonly title="수거지 우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>">
                                    <button type="button" class="search-btn btn-default btn-dark" id="devClaim1ZipPopupButton">Find Address</button>
                                    <input type="text" class="address-text dim mat10" name="caddr1" id="devClaim1Address1" readonly title="수거지 주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>">
                                    <input type="text" class="address-text mat10" name="caddr2" id="devClaim1Address2" title="수거지 상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-mobile">
                                <span class="my-info__title my-info__title--required">
                                    Tel
                                </span>
                                <div class="my-info__cont selectWrap">
                                    <select name="cmobile1"  id="devCmobile1">
                                        <option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="cmobile2" id="devCmobile2" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" title="수거지 휴대폰번호 가운데자리">
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="cmobile3" id="devCmobile3" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" title="수거지 휴대폰번호 끝자리">
                                </div>
                            </li>

                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title">
                                    Shipping comment
                                </span>
                                <div class="my-info__cont selectWrap">
                                    <input type="text" name="cmsg">
                                </div>
                            </li>
                        </ul>

                    </li>

<?php if($TPL_VAR["claimType"]=='change'){?>
                    <li class="exchange-method__list exchange-method__list-myaddress"  id="devClaimAdressForm2">
                        <span class="exchange-method__title">
                            Address to exchange
                            <span class="exchange-method__title-sub">
                                (Address)
                            </span>
                        </span>

                        <ul class="my-info">
                            <li class="my-info__list my-info__list-name">
                                <span class="my-info__title my-info__title--required">
                                    Name
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" name="rname" id="devRname" title="받으실분 이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-address">
                                <span class="my-info__title my-info__title--required">
                                    Address
                                </span>
                                <div class="my-info__cont form-info-wrap">
                                    <input type="text" class="zipcode dim" name="rzip" id="devClaim2Zip" readonly title="받으실곳 우편번호" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>">
                                    <button type="button" class="search-btn btn-default btn-dark" id="devClaim2ZipPopupButton">Find Address</button>
                                    <input type="text" class="address-text dim mat10" name="raddr1" id="devClaim2Address1" readonly title="받으실 곳 주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>">
                                    <input type="text" class="address-text mat10" name="raddr2" id="devClaim2Address2" title="받으실곳 상세주소" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-mobile">
                                <span class="my-info__title my-info__title--required">
                                    Tel
                                </span>
                                <div class=" my-info__cont selectWrap">
                                    <select name="rmobile1"  id="devRmobile1">
                                        <option value="010" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='010'){?>selected<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='011'){?>selected<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='016'){?>selected<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='017'){?>selected<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='018'){?>selected<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["deliveryInfo"]["rm1"]=='019'){?>selected<?php }?>>019</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="rmobile2" id="devRmobile2" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" title="받으실분 휴대폰번호 가운데자리">
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="rmobile3" id="devRmobile3" value="<?php echo $TPL_VAR["deliveryInfo"]["rm3"]?>" title="받으실분 휴대폰번호 끝자리">
                                </div>
                            </li>

                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title">
                                    Shipping comment
                                </span>
                                <div class="my-info__cont selectWrap">
                                    <input type="text" name="rmsg">
                                </div>
                            </li>
                        </ul>
                    </li>
<?php }?>
                </ul>

<?php if($TPL_VAR["claimType"]=='change'){?>
                <p class="exchange-method__annc">
                    Additional shipping charges may apply.
                </p>
<?php }?>

            </section>
        </form>
    </div>
</section>

<?php }else{?>

<section class="fb__mypage__order-claim">
    <div class="claim">
        <h2 class="fb__title--hidden"><?php echo $TPL_VAR["claimTypeName"]?></h2>


        <form id="devClaimApplyForm" method="post">
            <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
            <section class="claim__list claim__able exchange-apply">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <table class="claim__list__table table-default order-table">
                    <colgroup>
                        <col width="*"/>
                        <col width="100px"/>
                        <col width="100px"/>
                        <col width="110px"/>
                        <col width="100px"/>
                        <col width="130px"/>
                    </colgroup>
                    <thead>
                    <th>Item Name/Option</th>
                    <th>Order Status</th>
                    <th>Quantities of order</th>
                    <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                    <th>Estimated Total</th>
                    <th><?php echo $TPL_VAR["claimTypeName"]?>Add item</th>
                    </thead>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <tr class="devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?><?php }else{?>none<?php }?>">
                        <td>
                            <input type="checkbox" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" name="od_ix[]" value='<?php echo $TPL_V2["od_ix"]?>' <?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])||$TPL_VAR["odIx"]==''){?>checked<?php }?> >
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                <div class="thumb">
                                    <img src="<?php echo $TPL_V2["pimg"]?>">
                                </div>
                                <div class="info">
                                    <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                    <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                    <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                </div>
                            </a>
                        </td>
                        <td><?php echo trans($TPL_V2["status_text"])?></td>
                        <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                        <td>
                            <select class="devClaimCntCls" id="devClaimCnt<?php echo $TPL_V2["od_ix"]?>" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                <option value="<?php echo $TPL_V2["pcnt"]?>"><?php echo $TPL_V2["pcnt"]?></option>
<?php if(false){?>
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                <option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option>
<?php }}?>
<?php }?>
                            </select>
                        </td>
                        <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        <td>
                            <button type="button" class="claim__list__icon" data-odix="<?php echo $TPL_V2["od_ix"]?>">마이너스버튼</button>
                        </td>
                    </tr>
                    <tr class="devCancelBoxOn" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"])){?><?php }else{?>none<?php }?>">
                        <td colspan="6">
                            <div class="reason-box claim__list__reason">
                                <dl class="reason-box__inner">
                                    <dt class="reason-box__title">
                                        <?php echo $TPL_VAR["claimTypeName"]?> Reason
                                    </dt>
                                    <dd class="reason-box__cont">
                                        <div class="devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                            <select name="claim_reason[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>" class="devCcReason" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if(is_array($TPL_R3=($TPL_VAR["claimReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
                                                <option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>">Others</option>
<?php }else{?>
                                                <option value="<?php echo $TPL_K3?>" data-type="<?php echo $TPL_V3["type"]?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
                                            </select>
                                        </div>
                                        <textarea name="claim_msg[<?php echo $TPL_V2["od_ix"]?>]" placeholder=" Please enter a <?php echo $TPL_VAR["claimTypeName"]?> reason." maxlength="100" data-odIx="<?php echo $TPL_V2["od_ix"]?>" class="devCcMsg"  title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
                                        <div class="counting">
                                            <span><em id="devClaimMsgLength">0</em>/100 <span class="eng-hidden">자</span></span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </td>
                    </tr>
<?php }}?>
                    </tbody>
                </table>
                <div class="claim__list__empty" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>" >
                    <span>No product <?php echo $TPL_VAR["claimTypeName"]?>selected.</span>
                </div>
<?php }}?>
            </section>




            <!--[S] 교환/반품 취소 상품 신청 (하단)-->
            <section class="claim__list claim__disable fb__mypage__section">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <h3 class="fb__mypage__title claim__disable__title"><?php echo $TPL_VAR["claimTypeName"]?> Add Items for Cancellation</h3>
                <table class="claim__list__table table-default order-table">
                    <colgroup>
                        <col width="*"/>
                        <col width="100px"/>
                        <col width="100px"/>
                        <col width="110px"/>
                        <col width="100px"/>
                        <col width="130px"/>
                    </colgroup>
                    <thead>
                    <th>Item Name/Option</th>
                    <th>Order Status</th>
                    <th>Quantities of order</th>
                    <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                    <th>Estimated Total</th>
                    <th><?php echo $TPL_VAR["claimTypeName"]?>Add item</th>
                    </thead>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <tr class="devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"])||($TPL_VAR["odIx"]=='')){?><?php }else{?>none<?php }?>">
                        <td>
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                <div class="thumb">
                                    <img src="<?php echo $TPL_V2["pimg"]?>">
                                </div>
                                <div class="info">
                                    <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                    <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                    <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                </div>
                            </a>
                        </td>
                        <td><?php echo trans($TPL_V2["status_text"])?></td>
                        <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                        <td>
                            <select class="devCancelCntCls" disabled>
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option><?php }}?>
                            </select>
                        </td>
                        <td class="price"><?php echo $TPL_VAR["fbUnit"]["ㄹ"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        <td><button type="button" class="claim__list__icon" data-odix="<?php echo $TPL_V2["od_ix"]?>">플러스버튼</button></td>
                    </tr>
<?php }}?>
                    </tbody>
                </table>

                <div class="claim__list__empty" id="devArea2" style="display:<?php if($TPL_VAR["odIx"]==''){?>block<?php }else{?>none<?php }?>" >
                    <span><?php echo $TPL_VAR["claimTypeName"]?>There are no additional items to cancel.</span>
                </div>

<?php }}?>
            </section>
            <!-- [E] -->




<?php if(false){?>
            <section class="exchange-method fb__mypage__section">
                <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>

                    <!--직접발송 선택시-->
                    <li class="exchange-method__list self-type"  id="devDirectDelivery">
                        <span class="exchange-method__title">
                            Shipping information for <?php echo $TPL_VAR["claimTypeName"]?>

                        </span>
                        <div class="exchange-method__cont">
                            <div class="exchange-method__cont-list">
                                <input type="text" name="quick" placeholder="Logistics" title="Logistics"><!-- 배송업체 입력필드 -->
                                <input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="Enter the Tracking No. without &#39;-&#39;." title="Tracking No.">
                            </div>
                            <input type="hidden" name="delivery_pay_type" value="1">
                            <p class="exchange-method__cont-annc">Prepaid shipping fee is required</p>
                        </div>
                    </li>

<?php if($TPL_VAR["claimType"]=='change'){?>
                    <li class="exchange-method__list exchange-method__list-myaddress"  id="devClaimAdressForm2">
                        <span class="exchange-method__title">
                            Address to exchange
                            <span class="exchange-method__title-sub">
                                (Address)
                            </span>
                        </span>

                        <ul class="my-info">
                            <li class="my-info__list my-info__list-name">
                                <span class="my-info__title my-info__title--required">
                                    Name
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" name="rname" id="devRname" title="받으실분 이름" value="<?php echo $TPL_VAR["deliveryInfo"]["rname"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title my-info__title--required">
                                    Country
                                </span>
                                <div class="my-info__cont">
                                    <select class="devNationArea"  name="country">
                                        <option value="">Select</option>
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["nation_code"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["deliveryInfo"]["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?></option>
<?php }}?>
                                    </select>
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-name">
                                <span class="my-info__title my-info__title--required">
                                    Zip/Postal Code
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" class="zipcode" name="rzip" id="devClaim2Zip" title="Zip/Postal Code" value="<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title my-info__title--required">
                                    Address line 1
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" class="address-text" name="raddr1" id="devClaim2Address1" title="Address line 1" value="<?php echo $TPL_VAR["deliveryInfo"]["addr1"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title my-info__title--required">
                                    Address line 2
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" class="address-text" name="raddr2" id="devClaim2Address2" title="Address line 2" value="<?php echo $TPL_VAR["deliveryInfo"]["addr2"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title my-info__title--required">
                                    City
                                </span>
                                <div class="my-info__cont">
                                    <input type="text" name="city" id="" title="City" value="<?php echo $TPL_VAR["deliveryInfo"]["city"]?>">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title my-info__title--required">
                                    State/Province
                                </span>
                                <div class="my-info__cont">
<?php if($TPL_VAR["country"]=='US'){?>
                                    <select id="devStateSelect">
                                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["deliveryInfo"]["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                                    </select>
                                    <input type="text" class="mat10" style="display:none;" id="devStateText" name="state" value="<?php echo $TPL_VAR["deliveryInfo"]["state"]?>" title="State/Province" >
<?php }else{?>
                                    <select style="display: none;" id="devStateSelect">
                                        <option value="">Select</option>
<?php if($TPL_regional_information_1){foreach($TPL_VAR["regional_information"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["reg_name"]?>" <?php if($TPL_V1["reg_name"]==$TPL_VAR["deliveryInfo"]["state"]){?> selected <?php }?>><?php echo $TPL_V1["reg_name"]?></option>
<?php }}?>
                                    </select>
                                    <input type="text" class="mat10" id="devStateText" name="state" value="<?php echo $TPL_VAR["deliveryInfo"]["state"]?>" title="State/Province" >
<?php }?>
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-mobile">
                                <span class="my-info__title my-info__title--required">
                                    Tel
                                </span>
                                <div class=" my-info__cont selectWrap">
                                    <select name="rmobile1" class="devNationArea"  id="devRmobile1">
<?php if($TPL_nation_1){foreach($TPL_VAR["nation"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["national_phone"]?>" data-nation_code="<?php echo $TPL_V1["nation_code"]?>" <?php if($TPL_V1["nation_code"]==$TPL_VAR["deliveryInfo"]["country"]){?> selected <?php }?>><?php echo $TPL_V1["nation_name"]?>(+<?php echo $TPL_V1["national_phone"]?>)</option>
<?php }}?>
                                    </select>
                                    <input type="number" name="rmobile2" id="devRmobile2" value="<?php echo $TPL_VAR["deliveryInfo"]["rm2"]?>" title="phone numer">
                                </div>
                            </li>
                            <li class="my-info__list my-info__list-ask">
                                <span class="my-info__title">
                                    Shipping comment
                                </span>
                                <div class="my-info__cont selectWrap">
                                    <input type="text" name="rmsg">
                                </div>
                            </li>
                        </ul>
                    </li>
<?php }?>
                </ul>

<?php if($TPL_VAR["claimType"]=='change'){?>
                <p class="exchange-method__annc">
                    Additional shipping charges may apply.
                </p>
<?php }?>

            </section>
<?php }?>
        </form>
    </div>
</section>
<?php }?>