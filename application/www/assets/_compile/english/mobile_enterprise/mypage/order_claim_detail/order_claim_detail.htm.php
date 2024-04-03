<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim_detail/order_claim_detail.htm 000030365 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);
$TPL_deny_1=empty($TPL_VAR["deny"])||!is_array($TPL_VAR["deny"])?0:count($TPL_VAR["deny"]);?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="br__order-detail br__order-claim-detail">
    <h2 class="br__order-detail__title">Application details inquiry</h2>
    <section class="br__odhistory__each wrap-mypage wrap-order-claim">
        <div class="odeach order-detail">
            <header class="odeach__top ">
                <h3 class="br__hidden">Your Orders</h3>
                <p class="odeach__top__text">Order Date <span><?php echo str_replace('-','.',$TPL_VAR["order"]["order_date"])?></span></p>
                <p class="odeach__top__text">Order No. <span><?php echo $TPL_VAR["order"]["oid"]?></span></p>
            </header>
            <div class="order-detail__goods">
                <h3 class="br__hidden">Cancellation product information</h3>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                    <ul class="odeach__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
                            <li class="odeach__item">
                                <div class="odeach__item__inner">
                                    <figure class="odeach__item__thumb">
                                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                            <img src="<?php echo $TPL_V2["pimg"]?>">
                                        </a>
                                    </figure>
                                    <div class="odeach__item__info">
                                        <p class="odeach__item__title">
                                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
                                        </p>
                                        <p class="odeach__item__option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                        <p class="odeach__item__option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                                        <p class="odeach__item__option counting"><?php echo $TPL_VAR["claimTypeName"]?>Quantity <?php echo $TPL_V2["pcnt"]?> items</p>
                                        <div class="odeach__item__bottom">
                                            <span class="odeach__item__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
                                            <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                        </div>
                                    </div>
                                </div>
                            </li>
<?php if($TPL_V2["product_gift"]){?>
                                <div class="odeach__gift product-gift-wrap">
                                    <h4 class="odeach__gift__title">GIft</h4> <!-- <span>Gift Title</span> -->
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
                                    <div class="odeach__gift__inner inner-gift order_list_gift" id="devPgItem">
                                        <figure class="odeach__gift__thumb img">
                                            <img src="<?php echo $TPL_V3["image_src"]?>" alt="">
                                        </figure>
                                        <div class="odeach__gift__info">
                                            <p class="odeach__gift__name"><?php echo $TPL_V3["pname"]?></p>
                                            <span class="odeach__gift__option"><em>/1ltem(s)</em></span>
                                        </div>
                                    </div>
<?php }}?>
                                </div>
<?php }?>
                            <!--<div class="wrap-sect"></div>-->
                            <section class="order-detail__wrap claim-reason">
                                <h4 class="order-detail__wrap__title"><?php echo $TPL_VAR["claimTypeName"]?>Reason</h4>
                                <div class="layout-padding">
                                    <p class="tit"><?php echo $TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['reason_text']?></p>
                                    <p class="cont"><?php echo $TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['status_message']?></p>
                                </div>
                            </section>
<?php }}?>
                    </ul>
<?php }}?>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
                <div class="odeach__gift-buyprice">
                    <!--<h3 class="odeach__gift-buyprice__title">Gift by purchase amount</h3>-->
                    <div class="odeach__gift product-gift-wrap">
                        <h4 class="odeach__gift__title"><?php echo trans($TPL_V1["freegift_condition_text"])?></h4><!-- Gift <span>Gift Title </span> -->
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <div class="odeach__gift__inner inner-gift order_list_gift" id="devPgItem">
                            <figure class="odeach__gift__thumb img">
                                <img src="<?php echo $TPL_V2["image_src"]?>" alt="">
                            </figure>
                            <div class="odeach__gift__info">
                                <p class="odeach__gift__name"><?php echo $TPL_V2["pname"]?></p>
                                <span class="odeach__gift__option"><em>/<?php echo $TPL_V2["pcnt"]?>ltem(s)</em></span>
                            </div>
                        </div>
<?php }}?>
                    </div>
                </div>
<?php }?>
<?php }}?>
<?php }?>
                <div class="odeach__btn odeach__btn--all">
                </div>
            </div>

            <div class="wrap-sect"></div>


<?php if($TPL_VAR["deny"]){?>
            <section class="order-detail__wrap claim-reason">
                <h4 class="order-detail__wrap__title"><?php echo $TPL_VAR["claimTypeName"]?>Denial History</h4>
                <div class="layout-padding">
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
                    <p class="tit">Product Information</p>
                    <p class="cont"><?php echo $TPL_V1["pname"]?><br/>Option : <?php echo $TPL_V1["option_text"]?></p>
                    <p class="tit"><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>disavowal<?php }else{?>Impossible<?php }?> Reason</p>
                    <p class="cont"><?php echo $TPL_V1["deny_message"]?></p>
<?php }}?>
                </div>
            </section>
            <div class="wrap-sect"></div>
<?php }?>

<?php if($TPL_VAR["returnMethod"]){?>
            <section>
                <h4 class="order-detail__wrap__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h4>

                <div class="layout-padding">
                    <h2><?php echo $TPL_VAR["claimTypeName"]?> Shipping method</h2>
                    <p class="cont"><?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>(english)직접 발송<?php }else{?>지정택배 방문요청<?php }?></p>

<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>                    <?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>                    <h2><?php echo $TPL_VAR["claimTypeName"]?> Shipping information</h2>
                    <p class="cont"><?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?>(Tracking No.:<?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</p>
<?php }?>
                    <h2>Shipping Fee</h2>
                    <p class="cont paddingb20"><?php if($TPL_VAR["returnMethod"]["returnData"]["delivery_pay_type"]== 1){?>(english)선불<?php }else{?>착불<?php }?></p>

<?php }else{?>                    <h2>Pick up address</h2>
                    <div class="cont">
                        <table>
                            <colgroup>
                                <col width="175px">
                                <col width="*">
                            </colgroup>
                            <tbody><tr>
                                <th>Name</th>
                                <td><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>
                                    [<?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?>] <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr2"]?>

                                </td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></em></td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></em></td>
                            </tr>
                            <tr>
                                <th>Shipping comment</th>
                                <td class="request">
                                    <div><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<?php }?>

<?php if($TPL_VAR["claimType"]=='E'){?>
                    <h2><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소 (구매자 주소지)</h2>
                    <div class="cont">
                        <table>
                            <colgroup>
                                <col width="175px">
                                <col width="*">
                            </colgroup>
                            <tbody><tr>
                                <th>성명</th>
                                <td><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td>
                                    [<?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["zip"]?>] <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr2"]?>

                                </td>
                            </tr>
                            <tr>
                                <th>휴대폰번호</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rmobile"]?></em></td>
                            </tr>
                            <tr>
                                <th>전화번호</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rtel"]?></em></td>
                            </tr>
                            <tr>
                                <th>배송요청사항</th>
                                <td class="request">
                                    <div><?php echo nl2br($TPL_VAR["returnMethod"]["reDeliveryData"]["msg"])?></div> <!--클레임시 배송요청메세지는 한 번만 입력 가능-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<?php }?>
                </div>
            </section>
            <div class="wrap-sect"></div>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
            <section class="wrap-refund-list">
                <h4 class="order-detail__wrap__title">변동내역</h4>
                <div class="order-payment__list">
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?> 신청 총 결제금액</dt>
                        <dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
                    </dl>
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?> 시 추가 배송비</dt>
                        <dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em>원</dd>
                    </dl>
                    <dl class="order-payment__list__total">
                        <dt>추가 결제 예정 금액</dt>
                        <dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["addPaymentPrice"])?></em>원</dd>
                    </dl>
                </div>
                <div class="desc">
                    <?php echo $TPL_VAR["claimTypeName"]?> 배송비는 판매자가 <?php echo $TPL_VAR["claimTypeName"]?>상품 최종 승인 후 변경될 수 있습니다.
                </div>
            </section>
<?php }else{?>
            <section class="wrap-refund-list">
                <h4 class="order-payment__title">환불내역</h4>
                <div class="order-payment__list">
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>신청 총 결제금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
                    </dl>
                    <dl class="needL">
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>할 상품금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></em>원</dd>
                    </dl>
                    <dl class="needL">
                        <dt>환불 예정 배송비</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["deliveryPrice"])?></em>원</dd>
                    </dl>
<?php if($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"]> 0){?>
                    <dl class="needL">
                        <dt>배송비쿠폰할인(차감)</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["paymentInfo"]["dcp_dc"])?></em>원</dd>
                    </dl>
<?php }?>
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>시 추가 배송비(차감)</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["claimDeliveryPrice"])?></em>원</dd>
                    </dl>
                    <dl class="order-payment__list__total">
                        <dt>환불 예정 금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></em>원</dd>
                    </dl>
                </div>
                <div class="">
                    <dl>
                        <dt>결제수단(상품 구매 시)</dt>
                        <dd><?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                    </dl>
<?php if($TPL_VAR["expectedRefund"]["returnBankBool"]){?>
                    <dl>
                        <dt>환불수단</dt>
                        <dd><?php echo $TPL_VAR["expectedRefund"]["refundBankName"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankOwner"]?> / <?php echo $TPL_VAR["expectedRefund"]["refundBankNumber"]?></dd>
                    </dl>
<?php }?>
                </div>

                <div class="desc">
                    <p>결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.</p>
                    <p>결제 시 사용한 쿠폰 및 적립금는 내부정책에 따라 취소신청 완료 후 환불됩니다.</p>
                </div>
            </section>
<?php }?>
            <div class="wrap-sect"></div>
<?php }?>

            <div class="layout-padding">
                <div class="wrap-btn-area">
                    <button class="btn-lg br__order-claim-detail__btn" id="devPrevBtn">이전</button>
                </div>
            </div>
        </div>
    </section>
</section>
<?php }else{?><!-- 글로벌 -->
<section class="br__order-detail br__order-claim-detail">
    <h2 class="br__order-detail__title">Application details inquiry</h2>
    <section class="br__odhistory__each wrap-mypage wrap-order-claim">
        <div class="order-detail">
            <header class="odeach__top ">
                <h3 class="br__hidden">Your Orders</h3>
                <p class="odeach__top__text">Order Date <span><?php echo str_replace('-','.',$TPL_VAR["order"]["order_date"])?></span></p>
                <p class="odeach__top__text">Order No. <span><?php echo $TPL_VAR["order"]["oid"]?></span></p>
            </header>
            <div class="order-detail__goods">
                <h3 class="br__hidden">Cancellation product information</h3>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
                <ul class="odeach__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="odeach__item">
                        <div class="odeach__item__inner">
                        <figure class="odeach__item__thumb">
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                <img src="<?php echo $TPL_V2["pimg"]?>">
                            </a>
                        </figure>
                        <div class="odeach__item__info">
                            <p class="odeach__item__title">
                                <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a>
                            </p>
                            <p class="odeach__item__option"><?php echo $TPL_V2["option_text"]?> / <?php echo $TPL_V2["pcnt"]?>ltem(s)</p>
<?php if($TPL_V2["add_info"]){?>
                            <p class="odeach__item__option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                            <p class="odeach__item__option counting"><?php echo trans($TPL_VAR["claimTypeName"])?> Quantity <?php echo $TPL_V2["pcnt"]?> items</p>
                            <div class="odeach__item__bottom">
                                <span class="odeach__item__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
                                <span class="odeach__item__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </div>
                            <!--@TODO 프론트 - 기획서 나오면 확인.....!!!!-->
<?php if(!$TPL_VAR["order"]["status"]=='CC'||$TPL_VAR["order"]["status"]=='IC'||$TPL_VAR["order"]["status"]=='IR'){?>
                            <!--<div class="content-btn-area">-->
                            <!--<a href="/customer/qna?oid=<?php echo $TPL_VAR["order"]["oid"]?>"><button class="btn-s btn-white">1:1 문의</button></a>-->
                            <!--</div>-->
<?php }?>
                        </div>
                        </div>
                    </li>
                    <li>
                        <section class="order-detail__wrap claim-reason">
                            <h4 class="order-detail__wrap__title"><?php echo trans($TPL_VAR["claimTypeName"])?> Reason</h4>
                            <div class="layout-padding">
                                <p class="tit"><?php echo trans($TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['reason_text'])?></p>
                                <p class="cont"><?php echo $TPL_VAR["reason_data"][$TPL_V2["od_ix"]]['status_message']?></p>
                            </div>
                        </section>
                    </li>
<?php }}?>
                </ul>
            </div>

            <div class="wrap-sect"></div>
            <!--@TODO 프론트 - 기획서 나오면 확인.....!!!!-->
            <!--<div class="delivery-area">-->
                <!--<dl>-->
                    <!--<dt>배송비</dt>-->
                    <!--<dd><em><?php echo number_format($TPL_VAR["order"]["deliveryPrice"][$TPL_K1])?></em>원</dd>-->
                 <!--</dl>-->
            <!--<span><?php echo $TPL_VAR["order"]["deliveryPricePolicyText"][$TPL_K1]?></span>-->
            <!--</div>-->
            <div class="wrap-sect"></div>
<?php }}?>


<?php if($TPL_VAR["deny"]){?>
            <section class="order-detail__wrap claim-reason">
                <h4 class="order-detail__wrap__title"><?php echo $TPL_VAR["claimTypeName"]?>Denial History</h4>
                <div class="layout-padding">
<?php if($TPL_deny_1){foreach($TPL_VAR["deny"] as $TPL_V1){?>
                    <p class="tit">Product Information</p>
                    <p class="cont"><?php echo $TPL_V1["pname"]?><br/>Option : <?php echo $TPL_V1["option_text"]?></p>
                    <p class="tit"><?php echo $TPL_VAR["claimTypeName"]?><?php if($TPL_V1["deny_type"]=='Y'){?>disavowal<?php }else{?>Impossible<?php }?> Reason</p>
                    <p class="cont"><?php echo $TPL_V1["deny_message"]?></p>
<?php }}?>
                </div>
            </section>
            <div class="wrap-sect"></div>
<?php }?>

<?php if($TPL_VAR["returnMethod"]&&false){?>
            <section>
                <h4 class="order-detail__wrap__title"><?php echo $TPL_VAR["claimTypeName"]?> Method</h4>

                <div class="layout-padding">
<?php if($TPL_VAR["returnMethod"]["returnData"]["send_type"]== 1){?>                    <?php if($TPL_VAR["returnMethod"]["returnData"]["invoice_no"]!=''){?>                    <h2><?php echo $TPL_VAR["claimTypeName"]?> Shipping information</h2>
                    <p class="cont"><?php echo $TPL_VAR["returnMethod"]["returnData"]["quickText"]?>(Tracking No.:<?php echo $TPL_VAR["returnMethod"]["returnData"]["invoice_no"]?>)</p>
<?php }?>

<?php }else{?>                    <h2>Pick up address</h2>
                    <div class="cont">
                        <table>
                            <colgroup>
                                <col width="175px">
                                <col width="*">
                            </colgroup>
                            <tbody><tr>
                                <th>Name</th>
                                <td><?php echo $TPL_VAR["returnMethod"]["returnData"]["rname"]?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>
                                    [<?php echo $TPL_VAR["returnMethod"]["returnData"]["zip"]?>] <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["returnData"]["addr2"]?>

                                </td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rmobile"]?></em></td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["returnData"]["rtel"]?></em></td>
                            </tr>
                            <tr>
                                <th>Shipping comment</th>
                                <td class="request">
                                    <div><?php echo nl2br($TPL_VAR["returnMethod"]["returnData"]["msg"])?></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<?php }?>

<?php if($TPL_VAR["claimType"]=='E'){?>
                    <h2><?php echo $TPL_VAR["claimTypeName"]?>상품 받으실 주소 (구매자 주소지)</h2>
                    <div class="cont">
                        <table>
                            <colgroup>
                                <col width="175px">
                                <col width="*">
                            </colgroup>
                            <tbody><tr>
                                <th>성명</th>
                                <td><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rname"]?></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td>
                                    [<?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["zip"]?>] <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr1"]?> <?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["addr2"]?>

                                </td>
                            </tr>
                            <tr>
                                <th>휴대폰번호</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rmobile"]?></em></td>
                            </tr>
                            <tr>
                                <th>전화번호</th>
                                <td><em><?php echo $TPL_VAR["returnMethod"]["reDeliveryData"]["rtel"]?></em></td>
                            </tr>
                            <tr>
                                <th>배송요청사항</th>
                                <td class="request">
                                    <div><?php echo nl2br($TPL_VAR["returnMethod"]["reDeliveryData"]["msg"])?></div> <!--클레임시 배송요청메세지는 한 번만 입력 가능-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
<?php }?>
                </div>
            </section>
            <div class="wrap-sect"></div>
<?php }?>

<?php if($TPL_VAR["expectedRefund"]&&false){?>
<?php if($TPL_VAR["claimType"]=='E'){?>
            <section class="wrap-refund-list">
                <h4 class="order-detail__wrap__title">변동내역</h4>
                <div class="order-payment__list">
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?> 신청 총 결제금액</dt>
                        <dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
                    </dl>
                    <dl class="order-payment__list__total">
                        <dt>추가 결제 예정 금액</dt>
                        <dd><em><?php echo number_format($TPL_VAR["expectedRefund"]["addPaymentPrice"])?></em>원</dd>
                    </dl>
                </div>
                <div class="desc">
                    <?php echo $TPL_VAR["claimTypeName"]?> 배송비는 판매자가 <?php echo $TPL_VAR["claimTypeName"]?>상품 최종 승인 후 변경될 수 있습니다.
                </div>
            </section>
<?php }else{?>
            <section class="wrap-refund-list">
                <h4 class="order-payment__title">환불내역</h4>
                <div class="order-payment__list">
                    <dl>
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>신청 총 결제금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["orderPrice"])?></em>원</dd>
                    </dl>
                    <dl class="needL">
                        <dt><?php echo $TPL_VAR["claimTypeName"]?>할 상품금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["productPrice"])?></em>원</dd>
                    </dl>
                    <dl class="order-payment__list__total">
                        <dt>환불 예정 금액</dt>
                        <dd><em><?php echo g_price($TPL_VAR["expectedRefund"]["expectedRefundPrice"])?></em>원</dd>
                    </dl>
                </div>
                <div class="">
                    <dl>
                        <dt>결제수단(상품 구매 시)</dt>
                        <dd><?php if(is_array($TPL_R1=$TPL_VAR["expectedRefund"]["paymentInfo"]["paymentInfo"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
                    </dl>

                </div>

                <div class="desc">
                    <p>결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.</p>
                    <p>결제 시 사용한 쿠폰 및 적립금는 내부정책에 따라 취소신청 완료 후 환불됩니다.</p>
                </div>
            </section>
<?php }?>
            <div class="wrap-sect"></div>
<?php }?>

            <div class="layout-padding">
                <div class="wrap-btn-area">
                    <button class="btn-lg br__order-claim-detail__btn" id="devPrevBtn">Previous</button>
                </div>
            </div>
        </div>
    </section>
</section>
<?php }?>