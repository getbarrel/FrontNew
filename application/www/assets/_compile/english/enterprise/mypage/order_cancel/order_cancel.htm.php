<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_cancel/order_cancel.htm 000020330 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<?php if(!$TPL_VAR["nonMemberOid"]){?><?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>


<div class="fb__mypage__order-claim wrap-mypage wrap-order-claim">
    <div class="claim">

        <!-- 입금완료시 (전체취소 or 부분취소)-->
        <section class="cancel-area">
            <header class="order-number-box">
                <h2 class="fb__mypage__title">Cancel order</h2>
                <span class="tit">Order No.</span>
                <span class="order-num" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-allselected="<?php echo $TPL_VAR["allSelected"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></span>
                <span class="tit">Order Date</span>
                <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
            </header>

            <!--[S] 주문 취소 상품 상단-->
            <section class="claim__list claim__able">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
                <h3 class="fb__title--hidden">주문취소 신청 상품 상단</h3>
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
                        <th>Quantity</th>
                        <th>Estimated Total</th>
                        <th>Add Items for Cancellation</th>
                    </thead>
                    <tbody>

<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <tr class="devCancelBoxOn devCancelArea" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-pcnt="<?php echo $TPL_V2["pcnt"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["allSelected"]=='Y')){?><?php }else{?>none<?php }?>">
                            <td>
                                <input type="hidden" class="devOdIxCls" id="devOdIx<?php echo $TPL_V2["od_ix"]?>" value='<?php echo $TPL_V2["od_ix"]?>'>
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
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
                                    <em class="devCancelCntCls devPcnt" data-odix="<?php echo $TPL_V2["od_ix"]?>"><?php echo $TPL_V2["pcnt"]?></em>ltem(s)
<?php }else{?>
                                <select class="devCancelCntCls devPcnt" name="pcnt[<?php echo $TPL_V2["od_ix"]?>]" data-odix="<?php echo $TPL_V2["od_ix"]?>" data-ocnt="<?php echo $TPL_V2["pcnt"]?>" data-dcprice="<?php echo $TPL_V2["dcprice"]?>">
<?php if(is_array($TPL_R3=range($TPL_V2["pcnt"], 1, - 1))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?><option value="<?php echo $TPL_V3?>"><?php echo $TPL_V3?></option><?php }}?>
                                </select>
<?php }?>
                            </td>
                            <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td>
<?php if($TPL_VAR["partCancelBool"]==true&&$TPL_VAR["order"]["status"]!='IR'){?>
                                <button class="claim__list__icon devCancelMinus" data-odix="<?php echo $TPL_V2["od_ix"]?>">마이너스버튼</button>
<?php }?>
                            </td>
                        </tr>
                        <tr class="devCancelBoxOn devCancelTr" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]==$TPL_VAR["odIx"]||$TPL_VAR["allSelected"]=='Y')){?><?php }else{?>none<?php }?>">
                            <td colspan="6">
                                <div class="claim__list__reason reason-box">
                                    <dl class="reason-box__inner">
                                        <dt class="reason-box__title">
                                            Reason
                                        </dt>
                                        <dd class="reason-box__cont js__counting">
                                            <div class="devCancelCodeArea" data-odix="<?php echo $TPL_V2["od_ix"]?>">
                                            <select name="cc_reason" class="devCcReason" data-odix="<?php echo $TPL_V2["od_ix"]?>">
<?php if(is_array($TPL_R3=($TPL_VAR["cancelReason"]))&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_K3=>$TPL_V3){?>
<?php if($TPL_VAR["langType"]=='english'&&$TPL_K3=='ETC'){?>
                                                <option value="<?php echo $TPL_K3?>">Others</option>
<?php }else{?>
                                                <option value="<?php echo $TPL_K3?>"><?php echo trans($TPL_V3["title"])?></option>
<?php }?>
<?php }}?>
                                            </select>
                                            </div>
                                            <textarea class="js__counting__textarea devCcMsg" placeholder="Write the reason for cancellation(Maximum 100 letters.)" text="취소사유" name="cc_msg[<?php echo $TPL_V2["od_ix"]?>]" data-odIx="<?php echo $TPL_V2["od_ix"]?>" maxlength="100"></textarea>
                                            <div class="counting">
                                                <span><em class="js__counting__num" id="devMsgLength">0</em>/100 <span class="eng-hidden">영문몰해당없음</span></span>
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </td>
                        </tr>
<?php }}?>
                    </tbody>
                </table>
                <!--상품없을때 display:none상태입니다. claim__list__empty--show 클래스 추가하면 보입니다.-->
                <div class="claim__list__empty" id="devArea1" style="display:<?php if($TPL_VAR["odIx"]==''&&$TPL_VAR["allSelected"]!='Y'){?>block<?php }else{?>none<?php }?>" >
                    <span>No ongoing cancellation lists were found.</span>
                </div>

                <div class="claim__list__delivery">
                    <span>Shipping fee <em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?><?php echo $TPL_VAR["fbUnit"]["b"]?></em> (<?php echo $TPL_VAR["order"]["deliveryPricePolicyText"][$TPL_K1]?>)</span>
                </div>
<?php }}?>
            </section>
            <!--[E]-->




            <!--[S] 주문 취소 상품 신청 (하단)-->
<?php if($TPL_VAR["order"]["status"]!='IR'&&$TPL_VAR["partCancelBool"]==true){?>
            <section class="claim__list claim__disable fb__mypage__section">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <h3 class="fb__mypage__title claim__disable__title">Add items for cancellation</h3>
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
                        <th>Quantity</th>
                        <th>Estimated Total</th>
                        <th>Add Items for Cancellation</th>
                    </thead>
                    <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <tr class="devCancelBoxOff" data-odix="<?php echo $TPL_V2["od_ix"]?>" style="display:<?php if(($TPL_V2["od_ix"]!=$TPL_VAR["odIx"]&&$TPL_VAR["allSelected"]!='Y')){?><?php }else{?>none<?php }?>">
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
                            <!--@TODO 개발확인 -->
                            <td><?php echo trans($TPL_V2["status_text"])?></td>
                            <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                            <td></td>
                            <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                            <td><button class="claim__list__icon devCancelPlus" data-odix="<?php echo $TPL_V2["od_ix"]?>">플러스버튼</button></td>
                        </tr>
<?php }}?>
                    </tbody>
                </table>
<?php }}?>

                <!--상품 없을 때 / claim__list__empty--show 클래스 추가하면 보입니다.-->
                <div class="claim__list__empty" id="devArea2" style="display:<?php if($TPL_VAR["allSelected"]=='Y'){?>block<?php }else{?>none<?php }?>">
                    <span>There are no additional items to cancel.</span>
                </div>
            </section>
<?php }?>
            <!-- [E] -->
        </section>


<?php if($TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE){?>
        <section class="fb__mypage__section refund-area">
            <h2 class="fb__mypage__title">Return Information</h2>
            <div class="refund-area__inner">
                <div class="pay-info">
                    <div class="pay-info__box">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Total Cancellation</p>
                            <p class="pay-info__top__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelTotalPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                        </div>
                        <div class="pay-info__bottom">
                            <!--@TODO 개발확인 orderdetail.htm 에서 가져다 썼는데 금액 확인 부탁드립니다.-->
                            <dl>
                                <dt>Amount for cancellation products</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelProductPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Estimated shipping fee <!--결제 시 부과된 배송비, 즉 고객이 구매할 때 지불한 배송비--></dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelDeliveryReturnPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <!--
                            <dl>
                                <dt>Total savings</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelProductPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl class="fb__mypage__icon--desc">
                                <dt>Item-discount</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl class="fb__mypage__icon--desc">
                                <dt>Membership-discount</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl class="fb__mypage__icon--desc">
                                <dt>Coupons</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            <dl>
                                <dt>Mileage</dt>
                                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                            </dl>
                            -->
                        </div>
                    </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
                    <div class="pay-info__box pay-info__box-delivery">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Additional Shipping fee</p>
                            <p class="pay-info__top__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelTotalReceivePrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                        </div>
                        <!--@TODO 결제완료일때 모두-->
                        <div class="pay-info__bottom">
                            <dl>
                                <!--
                                <dt>취소 시 추가 배송비</dt>
                                <dd>
                                    <?php echo $TPL_VAR["fbUnit"]["f"]?><em>0</em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                </dd>
                                -->
                            </dl>
                        </div>
                    </div>
<?php }?>

                    <div class="pay-info__box pay-info__box-sum">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Expected refund amount</p>
                            <p class="pay-info__top__price fb__point-color2"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devCancelTotalReturnPrice">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                        </div>
                        <!--@TODO 결제완료 - 주문취소(부분/분할) 일 경우 노출 / 전체취소일때는 노출 X-->
                        <div class="pay-info__bottom pay-info__bottom__text">
                            <span>estimate refund amount may be different from actual refund amount</span>
                        </div>
                    </div>
                </div>


                <div class="refund-info">
                    <dl class="refund-info__box">
                        <dt>Payment Method</dt>
                        <dd><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                    </dl>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <dl class="refund-info__box refund-info__box-account" id="devRefundMethod" style="display: none">
                        <dt>Payment Method</dt>

<?php if($TPL_VAR["refundInfo"]){?>
<?php if($TPL_VAR["refundInfo"]["method"]=='4'){?>
                            <input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
                            <dd class="refund-info__input-area">
                                <label>Bank</label>
                                <select name="bankCode" title="은행명" id="devBankCode">
                                    <option value="">Select</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?>
                                    <option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>>
                                        <?php echo $TPL_V1?>

                                    </option>
<?php }}?>
                                </select>
                                <label>account holder</label>
                                <input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="account holder" id="devBankOwner">
                                <div class="refund-info__input-area__account">
                                    <label>Account number</label>
                                    <input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="Account number" id="devBankNumber">
                                </div>
                            </dd>
<?php }else{?>
                                Refund as payment method
<?php }?>
<?php }?>
                    </dl>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php switch($TPL_V1["method"]){case ORDER_METHOD_BANK:case ORDER_METHOD_VBANK:case ORDER_METHOD_ASCROW:case ORDER_METHOD_CASH:case ORDER_METHOD_ICHE:?><script>$(function(){$('#devRefundMethod').show();});</script><?php }?><?php }}?>
                </div>
            </div>
            <div class="refund-area__annc">
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <?php echo trans('결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금 처리됩니다.<br>
                         결제 시 사용한 쿠폰 및 적립금은 내부정책에 따라 취소신청 완료 후 환불됩니다.')?>

<?php }else{?>
                It will be autometically refunded to the means of payment used when items had been ordered.
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                The coupons and rewards used for payment will be refunded after request of cancellation is accepted according to our policy.
<?php }?>
<?php }?>
            </div>
        </section>
<?php }?>




        <div class="fb__mypage__order-claim-btn wrap-btn-area">
            <button class="btn-lg btn-dark-line" id="devClaimCancel">Cancel</button>
            <button class="btn-lg btn-dark" id="devClaimApply">Cancellation request</button>
        </div>
    </div>
</div>