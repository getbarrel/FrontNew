<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_confirm.htm 000025487 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
    <section class="fb__order-claim-confirm">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="110px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
                <th>Item Name/Option</th>
                <th>Order Status</th>
                <th>Quantities of order</th>
                <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                <th>Estimated Total</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <tr class="devOdIxCls" devOdIx="<?php echo $TPL_V2["od_ix"]?>" devClaimCnt="<?php echo $TPL_V2["claim_cnt"]?>">
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
                <td>
                    <!--@TODO 개발확인-->
                    <?php echo trans($TPL_V2["status_text"])?>

                </td>
                <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                <td><em><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></em>개</td>
                <td class="price"><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em>원</td>
            </tr>
            <tr class="devCancelBoxOn">
                <td colspan="5" style="padding:0;">
                    <table class="reason-box__table">
                        <colgroup>
                            <col width="180px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th rowspan="2"><?php echo $TPL_VAR["claimTypeName"]?> Reason</th>
                            <td><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $TPL_VAR["applyData"]["claim_msg"][$TPL_V2["od_ix"]]?>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
<?php }}?>
            </tbody>
        </table>
<?php }}?>
    </section>

    <!--
    <section class="fb__mypage__section">
        <table class="fb__mypage__odtable--border join-table type02 cancel-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="2"><?php echo $TPL_VAR["claimTypeName"]?> Reason</th>
                <td><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></td>
            </tr>
            <tr>
                <td>
<?php if(is_array($TPL_R1=$TPL_VAR["applyData"]["claim_msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                        <?php echo nl2br($TPL_V1)?><BR>
<?php }}?>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    -->

    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>
        <table class="fb__mypage__odtable--border join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th><?php echo $TPL_VAR["claimTypeName"]?> Shipping method</th>
                <td>
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>직접발송 <span>(구매자께서 개별로 상품을 이미 발송한 경우)</span><?php }else{?>지정택배 방문요청 <span>(판매사와 계약된 택배업체에서 방문수령 수거)</span><?php }?>
                </td>
            </tr>
<?php if($TPL_VAR["applyData"]["send_type"]== 1){?>

            <tr>
                <th>Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></th>
                <td>
<?php if($TPL_VAR["applyData"]["quick_info"]!='N'){?>
                    <?php echo $TPL_VAR["applyData"]["quickText"]?> <span>(송장번호:<?php echo $TPL_VAR["applyData"]["invoice_no"]?>)</span> <br>
<?php }?>
                    상품 발송 시 배송비 <span><?php if($TPL_VAR["applyData"]["delivery_pay_type"]== 1){?>선불<?php }else{?>착불<?php }?></span>
                </td>
            </tr>

<?php }else{?>
            <tr>
                <th rowspan="4">Pick up address</th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["cname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["czip"]?> <?php echo $TPL_VAR["applyData"]["caddr1"]?> <?php echo $TPL_VAR["applyData"]["caddr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["applyData"]["cmobile1"]?>-<?php echo $TPL_VAR["applyData"]["cmobile2"]?>-<?php echo $TPL_VAR["applyData"]["cmobile3"]?></em></dd>
                    </dl>
                </td>
            </tr>
             <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["applyData"]["cmsg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>



<?php if($TPL_VAR["claimType"]=='change'){?>
            <tr>
                <th rowspan="4">Address to exchange<br>
                    <span>(Address)</span>
                </th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["rzip"]?> <?php echo $TPL_VAR["applyData"]["raddr1"]?> <?php echo $TPL_VAR["applyData"]["raddr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?>-<?php echo $TPL_VAR["applyData"]["rmobile3"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
            </tbody>
        </table>
    </section>

<?php if($TPL_VAR["claimType"]=='change'){?>

    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">The cost of change</h2>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>Total for exchange</dt>
                    <dd><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em>원</dd>
                </dl>
                <dl>
                    <dt>Additional shipping fee</dt>
                    <dd><em><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></em>원</dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <!--<dt>추가 결제 예정 금액</dt>-->
                    <!--<dd><em><?php echo g_price($TPL_VAR["delivery"]["claim_delivery_price"])?></em>원</dd>-->
                </dl>
            </div>
        </div>
        <div class="desc">
            (english)· 단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.<br>
            No extra shipping costs will be incurred if the seller is at fault.<br>
            (english)· 판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.
        </div>
    </section>

    <form id="devClaimConfirmForm" method="post">
        <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
    </form>
<?php }else{?>


        <br>
        <section class="fb__mypage__section refund-area">
            <h2 class="fb__mypage__title">Return Information</h2>
            <div class="refund-area__inner">
                <div class="pay-info">
                    <div class="pay-info__box">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Total for return</p>
                            <p class="pay-info__top__price"><em><?php echo g_price($TPL_VAR["view_total_price"])?></em>원</p>
                        </div>
                        <div class="pay-info__bottom">
                            <dl>
                                <dt>Return total</dt>
                                <dd><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em>원</dd>
                            </dl>
                            <dl>
                                <dt>Estimated shipping fee</dt>
                                <dd><em><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?></em>원</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="pay-info__box pay-info__box-delivery">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Estimated return shipping fee</p>
                            <p class="pay-info__top__price"><em><?php echo g_price($TPL_VAR["view_claim_delivery_price"])?></em>원</p>
                        </div>
                    </div>
                    <div class="pay-info__box pay-info__box-sum">
                        <div class="pay-info__top">
                            <p class="pay-info__top__tit">Expected refund amount</p>
                            <p class="pay-info__top__price fb__point-color"><em><?php echo g_price($TPL_VAR["view_price"])?></em>원</p>
                        </div>
                    </div>
                </div>
                <form id="devClaimConfirmForm" method="post">
                    <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
                    <div class="refund-info">
                        <dl class="refund-info__box">
                            <dt>Payment Method</dt>
                            <dd><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                                <?php echo $TPL_V1["method_text"]?>

                                <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
                                <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
                            </dd>

                        </dl>
                        <dl class="refund-info__box refund-info__box-account" id="devInfoBankNumber">
                            <dt>Refund method *</dt>
<?php if($TPL_VAR["refundInfo"]){?>
                            <input type="hidden" id="devRefundBankIx" value="<?php echo $TPL_VAR["refundInfo"]["bank_ix"]?>">
                            <dd>
                                <select name="bankCode" title="은행명" id="devBankCode">
                                    <option value="">Select bank</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
                                </select>
                                <input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
                                <input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
                            </dd>
<?php }else{?>
                            <dd>
                                <select name="bankCode" title="은행명" id="devBankCode">
                                    <option value="">Select</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["refundInfo"]["bank_code"]){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
                                </select>
                                <input type="text" name="bankOwner" value="<?php echo $TPL_VAR["refundInfo"]["bank_owner"]?>" title="예금주" id="devBankOwner" placeholder="예금주">
                                <input type="text" name="bankNumber" value="<?php echo $TPL_VAR["refundInfo"]["ori_bank_number"]?>" title="계좌번호" id="devBankNumber" placeholder="계좌번호">
                            </dd>
<?php }?>
                        </dl>
                    </div>
                </form>
            </div>


        <div class="refund-area__annc">
            <?php echo trans('결제수단 중 가상계좌 외 모든 결제수단은 자동 환불 처리되며 가상계좌로 결제하신 고객님은 환불수단에 입력된 환불계좌로 송금처리 됩니다.<br>
            결제 시 사용한 쿠폰 및 적립금은 내부정책에 따라 취소신청 완료 후 환불됩니다.')?>

        </div>
        <div class="refund-area__annc desc">
            <h3>반품 시 유의사항</h3>
            (english)· 단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.<br>
            No extra shipping costs will be incurred if the seller is at fault.<br>
            (english)· 판매자와 협의 없이 신청 시에는 환불 처리가 안될 수 있습니다.
        </div>
    </section>
<?php }?>

<?php }else{?>
    <section class="fb__order-claim-confirm">
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="110px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>Item Name/Option</th>
            <th>Order Status</th>
            <th>Quantities of order</th>
            <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
            <th>Estimated Total</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <tr class="devOdIxCls" devOdIx="<?php echo $TPL_V2["od_ix"]?>" devClaimCnt="<?php echo $TPL_V2["claim_cnt"]?>">
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
                <td>
                    <!--@TODO 개발확인-->
                    <?php echo trans($TPL_V2["status_text"])?>

                </td>
                <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                <td><em><?php echo $TPL_VAR["applyData"]["claim_cnt"][$TPL_V2["od_ix"]]?></em>ltem(s)</td>
                <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
            </tr>
<?php }}?>
            </tbody>
        </table>
<?php }}?>
    </section>

    <section class="fb__mypage__section">
        <table class="fb__mypage__odtable--border join-table type02 cancel-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="2"><?php echo $TPL_VAR["claimTypeName"]?> Reason</th>
                <td><?php echo $TPL_VAR["applyData"]["claimReasonText"]?></td>
            </tr>
            <tr>
                <td>
<?php if(is_array($TPL_R1=$TPL_VAR["applyData"]["claim_msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <?php echo nl2br($TPL_V1)?><BR>
<?php }}?>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
<?php if(false){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h2>
        <table class="fb__mypage__odtable--border join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>

            <tr>
                <th>Shipping information for <?php echo $TPL_VAR["claimTypeName"]?></th>
                <td>
                    <?php echo $TPL_VAR["applyData"]["quickText"]?> <span>(송장번호:<?php echo $TPL_VAR["applyData"]["invoice_no"]?>)</span> <br>
                </td>
            </tr>

<?php if($TPL_VAR["claimType"]=='change'){?>
            <tr>
                <th rowspan="9">Address to exchange<br>
                    <span>(Address)</span>
                </th>
                <td>
                    <dl>
                        <dt>Name</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["rname"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Country</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["country_full"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Zip/Postal Code</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["rzip"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address line 1</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["raddr1"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Address line 2</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["raddr2"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>City</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["city"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>State/Province</dt>
                        <dd><?php echo $TPL_VAR["applyData"]["state"]?></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Tel</dt>
                        <dd><em><?php echo $TPL_VAR["applyData"]["rmobile1"]?>-<?php echo $TPL_VAR["applyData"]["rmobile2"]?></em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>Shipping comment</dt>
                        <dd><?php echo nl2br($TPL_VAR["applyData"]["rmsg"])?></dd>
                    </dl>
                </td>
            </tr>
<?php }?>
            </tbody>
        </table>
    </section>
<?php }?>
<?php if($TPL_VAR["claimType"]=='change'){?>
<?php if(false){?>
    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">The cost of change</h2>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>Total for exchange</dt>
                    <dd><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em>원</dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <!--<dt>추가 결제 예정 금액</dt>-->
                    <!--<dd><em><?php echo g_price($TPL_VAR["delivery"]["claim_delivery_price"])?></em>원</dd>-->
                </dl>
            </div>
        </div>
        <div class="desc">
            Shipping fee for exchange may change after the seller&#39;s final approval.
        </div>
    </section>
<?php }?>

    <form id="devClaimConfirmForm" method="post">
        <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
    </form>
<?php }else{?>
<?php if(false){?>
    <section class="refund-area">
        <h2 class="fb__mypage__title">Return Information</h2>
        <div class="refund-area__inner">
            <div class="pay-info">
                <div class="pay-info__box">
                    <div class="pay-info__top">
                        <p class="pay-info__top__tit">Total for return</p>
                        <p class="pay-info__top__price"><em><?php echo g_price($TPL_VAR["view_total_price"])?></em>원</p>
                    </div>
                    <div class="pay-info__bottom">
                        <dl>
                            <dt>Return total</dt>
                            <dd><em><?php echo g_price($TPL_VAR["product"]["product_dc_price"])?></em>원</dd>
                        </dl>
                        <dl>
                            <dt>Estimated shipping fee</dt>
                            <dd><em><?php echo g_price($TPL_VAR["delivery"]["change_delivery_price"])?></em>원</dd>
                        </dl>
                    </div>
                </div>
                <div class="pay-info__box pay-info__box-sum">
                    <div class="pay-info__top">
                        <p class="pay-info__top__tit">Expected refund amount</p>
                        <p class="pay-info__top__price fb__point-color"><em><?php echo g_price($TPL_VAR["view_price"])?></em>원</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="refund-area__annc">
            <?php echo trans('결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.<br>
            결제 시 사용한 쿠폰 및 포인트는 내부정책에 따라 취소신청 완료 후 환불됩니다.')?>

        </div>
    </section>
<?php }?>
    <form id="devClaimConfirmForm" method="post" style="display: none;">
        <input type="hidden" name="confirm_key" value="<?php echo $TPL_VAR["confirmKey"]?>" />
        <div class="refund-info">
            <dl class="refund-info__box">
                <dt>Payment Method</dt>
                <dd><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <?php echo $TPL_V1["method_text"]?>

                    <input type="hidden" id="devMethod" value="<?php echo $TPL_V1["method"]?>" />
                    <input type="hidden" id="devInfoType" value="<?php echo $TPL_V1["method_text"]?>" />
<?php }}?>
                </dd>

            </dl>

        </div>
    </form>
<?php }?>

<?php }?>