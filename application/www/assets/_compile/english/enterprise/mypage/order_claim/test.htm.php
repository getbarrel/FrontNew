<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/test.htm 000031173 */ 
$TPL_claimReason_1=empty($TPL_VAR["claimReason"])||!is_array($TPL_VAR["claimReason"])?0:count($TPL_VAR["claimReason"]);
$TPL_cancelReason_1=empty($TPL_VAR["cancelReason"])||!is_array($TPL_VAR["cancelReason"])?0:count($TPL_VAR["cancelReason"]);
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);?>
<section class="fb__mypage__order-claim">
      <h2 class="fb__title--hidden">교환신청 apply</h2>
      <form id="devClaimApplyForm" method="post">
            <input type="hidden" name="oid" value="<?php echo $TPL_VAR["order"]["oid"]?>">
            <section class="claim__list claim__able exchange-apply">
                  <!--기존s-->
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
                        <tr>
                              <td>
                                    <a href="#">
                                          <div class="thumb">
                                                <img src="<?php echo $TPL_V2["pimg"]?>">
                                          </div>
                                          <div class="info">
                                                <p class="title">[<?php echo $TPL_V2["brand_name"]?>] <?php echo $TPL_V2["pname"]?></p>
                                                <p class="option"><?php echo $TPL_V2["option_text"]?></p>
                                          </div>
                                    </a>
                              </td>
                              <td>주문상태</td>
                              <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                              <td>
                                    <select class="devClaimCntCls" id="devClaimCnt<?php echo $TPL_V2["od_ix"]?>" name="claim_cnt[<?php echo $TPL_V2["od_ix"]?>]">
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option><?php }}?>
                                    </select>
                              </td>
                              <td class="price"><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em>원</td>
                              <td><button type="button" class="claim__list__icon">마이너스버튼</button></td>
                        </tr>
<?php }}?>
                        </tbody>
                  </table>
<?php }}?>
                  <!--상품없을때 / display:none상태입니다. claim__list__empty--show 클래스 추가하면 보입니다.-->
                  <div class="claim__list__empty">
                        <span>No ongoing cancellation lists were found.</span>
                  </div>
                  <div class="claim__list__reason reason-box">
                        <dl class="reason-box__inner">
                              <dt class="reason-box__title">
                                    <?php echo $TPL_VAR["claimTypeName"]?> Reason
                              </dt>
                              <dd class="reason-box__cont">
                                    <select name="claim_reason" id="devClaimReason" title="<?php echo $TPL_VAR["claimTypeName"]?>사유">
<?php if($TPL_claimReason_1){foreach($TPL_VAR["claimReason"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" data-type="<?php echo $TPL_V1["type"]?>"><?php echo $TPL_V1["title"]?></option><?php }}?>
                                    </select>
                                    <textarea name="claim_msg" placeholder="<?php echo $TPL_VAR["claimTypeName"]?>사유를 입력해 주세요." maxlength="100" id="devClaimMsg" title="<?php echo $TPL_VAR["claimTypeName"]?>사유"></textarea>
                                    <div class="counting">
                                          <span><em id="devClaimMsgLength">0</em>/100 자</span>
                                    </div>
                              </dd>
                        </dl>
                  </div>
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
                        <tr>
                              <td>
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                          <div class="thumb">
                                                <img src="<?php echo $TPL_V2["pimg"]?>">
                                          </div>
                                          <div class="info">
                                                <p class="title">[<?php echo $TPL_V2["brand_name"]?>] <?php echo $TPL_V2["pname"]?></p>
                                                <p class="option"><?php echo $TPL_V2["option_text"]?></p>
                                          </div>
                                    </a>
                              </td>
                              <td>주문상태</td>
                              <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                              <td>
                                    <!--@TODO 개발확인 ID-->
                                    <select class="devCancelCntCls" id="">
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option><?php }}?>
                                    </select>
                              </td>
                              <td class="price"><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em>원</td>
                              <td><button type="button" class="claim__list__icon">플러스버튼</button></td>
                        </tr>
<?php }}?>
                        </tbody>
                  </table>
<?php }}?>
                  <!--상품 없을 때 / claim__list__empty--show 클래스 추가하면 보입니다.-->
                  <div class="claim__list__empty">
                        <span><?php echo $TPL_VAR["claimTypeName"]?>There are no additional items to cancel.</span>
                  </div>
                  <!--주문취소상품신청에서는 display none상태입니다.-->
                  <div class="claim__list__reason reason-box">
                        <dl class="reason-box__inner">
                              <dt class="reason-box__title">
                                    Reason
                              </dt>
                              <dd class="reason-box__cont">
                                    <select name="cc_reason" id="devCcReason">
<?php if($TPL_cancelReason_1){foreach($TPL_VAR["cancelReason"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["title"]?></option><?php }}?>
                                    </select>
                                    <textarea placeholder="취소사유를 입력해 주세요." maxlength="100" id="devCcMsg" text="취소사유"></textarea>
                                    <div class="counting">
                                          <span><em id="devMsgLength">0</em>/100 자</span>
                                    </div>
                              </dd>
                        </dl>
                  </div>
            </section>
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
                                          <input type="text" name="invoice_no" id="devInvoiceNo" class="devClaimDeliveryCls" placeholder="" title="송장번호">
                                          <!--<input type="checkbox" name="quick_info" value="N" id="devDcompnyApplyChk"><label for="devDcompnyApplyChk">Do not enter an information of a shipping company</label>-->
                                    </div>

                                    <!--<div class="exchange-method__cont-list">-->
                                    <!--shipping fee for delivery-->
                                    <!--<span class="radio-area mal10">-->
                                    <!--<input type="radio" name="delivery_pay_type" value="1" id="devDpayType1" checked>-->
                                    <!--<label for="devDpayType1">Pre-paid</label>-->
                                    <!--</span>-->
                                    <!--<span class="radio-area">-->
                                    <!--<input type="radio" name="delivery_pay_type" value="2" id="devDpayType2">-->
                                    <!--<label for="devDpayType2">Collect on delivery</label>-->
                                    <!--</span>-->
                                    <!--</div>-->

                                    <!--<p class="exchange-method__cont-annc">* <?php echo $TPL_VAR["claimTypeName"]?> Enter your shipping information for faster and more accurate processing.</p>-->
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
                                    <li class="my-info__list my-info__list-tel">
                            <span class="my-info__title">
                                Tel
                            </span>
                                          <div class="my-info__cont selectWrap">
                                                <select name="ctel1">
                                                      <option value="02" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='02'){?>selected<?php }?>>02</option>
                                                      <option value="031" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='031'){?>selected<?php }?>>031</option>
                                                      <option value="032" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='032'){?>selected<?php }?>>032</option>
                                                      <option value="041" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='041'){?>selected<?php }?>>041</option>
                                                      <option value="042" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='042'){?>selected<?php }?>>042</option>
                                                      <option value="043" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='043'){?>selected<?php }?>>043</option>
                                                      <option value="051" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='051'){?>selected<?php }?>>051</option>
                                                      <option value="052" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='052'){?>selected<?php }?>>052</option>
                                                      <option value="053" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='053'){?>selected<?php }?>>053</option>
                                                      <option value="054" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='054'){?>selected<?php }?>>054</option>
                                                      <option value="055" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='055'){?>selected<?php }?>>055</option>
                                                      <option value="061" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='061'){?>selected<?php }?>>061</option>
                                                      <option value="062" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='062'){?>selected<?php }?>>062</option>
                                                      <option value="063" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='063'){?>selected<?php }?>>063</option>
                                                      <option value="064" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='064'){?>selected<?php }?>>064</option>
                                                      <option value="070" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='070'){?>selected<?php }?>>070</option>
                                                      <option value="080" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='080'){?>selected<?php }?>>080</option>
                                                      <option value="090" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='090'){?>selected<?php }?>>090</option>
                                                </select>
                                                <span class="hyphen">-</span>
                                                <input type="number" name="ctel2" id="devCtel2" value="<?php echo $TPL_VAR["deliveryInfo"]["rt2"]?>">
                                                <span class="hyphen">-</span>
                                                <input type="number" name="ctel3" id="devCtel3" value="<?php echo $TPL_VAR["deliveryInfo"]["rt3"]?>">
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
                                    <li class="my-info__list my-info__list-tel">
                            <span class="my-info__title">
                                Tel
                            </span>
                                          <div class="my-info__cont selectWrap">
                                                <select name="rtel1">
                                                      <option value="02" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='02'){?>selected<?php }?>>02</option>
                                                      <option value="031" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='031'){?>selected<?php }?>>031</option>
                                                      <option value="032" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='032'){?>selected<?php }?>>032</option>
                                                      <option value="041" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='041'){?>selected<?php }?>>041</option>
                                                      <option value="042" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='042'){?>selected<?php }?>>042</option>
                                                      <option value="043" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='043'){?>selected<?php }?>>043</option>
                                                      <option value="051" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='051'){?>selected<?php }?>>051</option>
                                                      <option value="052" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='052'){?>selected<?php }?>>052</option>
                                                      <option value="053" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='053'){?>selected<?php }?>>053</option>
                                                      <option value="054" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='054'){?>selected<?php }?>>054</option>
                                                      <option value="055" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='055'){?>selected<?php }?>>055</option>
                                                      <option value="061" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='061'){?>selected<?php }?>>061</option>
                                                      <option value="062" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='062'){?>selected<?php }?>>062</option>
                                                      <option value="063" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='063'){?>selected<?php }?>>063</option>
                                                      <option value="064" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='064'){?>selected<?php }?>>064</option>
                                                      <option value="070" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='070'){?>selected<?php }?>>070</option>
                                                      <option value="080" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='080'){?>selected<?php }?>>080</option>
                                                      <option value="090" <?php if($TPL_VAR["deliveryInfo"]["rt1"]=='090'){?>selected<?php }?>>090</option>
                                                </select>
                                                <span class="hyphen">-</span>
                                                <input type="number" name="rtel2" id="devRtel2" value="<?php echo $TPL_VAR["deliveryInfo"]["rt2"]?>">
                                                <span class="hyphen">-</span>
                                                <input type="number" name="rtel3" id="devRtel3" value="<?php echo $TPL_VAR["deliveryInfo"]["rt3"]?>">
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

</section>