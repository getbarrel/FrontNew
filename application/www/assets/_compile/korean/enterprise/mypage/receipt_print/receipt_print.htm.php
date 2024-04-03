<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/receipt_print/receipt_print.htm 000006956 */ ?>
<div class="wrap-window-popup receipt-popup">
    <p class="popup-title">
        <span>결제영수증</span>
        <!--<span class="close" onclick="window.close();"></span>-->
    </p>

    <div class="popup-content">
        <p class="desc">본 영수증은 소득공제 및 매입 계산서로 사용 할 수 없으며, 결제된 내역을 증명하는 용도입니다.</p>

        <div class="wrap-order-num">
            <div class="top-area">
                <span class=" float-l">주문번호 <em><?php echo $TPL_VAR["order"]["oid"]?></em></span>

<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(($TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE||$TPL_V1["method"]==ORDER_METHOD_ASCROW)&&$TPL_V1["receipt_yn"]=='Y'){?>
<?php if($TPL_V1["tid"]){?>
                        <button class="btn-s btn-white float-r devCachInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">현금영수증 조회</button>
<?php }?>
<?php }elseif($TPL_V1["method"]==ORDER_METHOD_CARD){?>
<?php if($TPL_V1["tid"]){?>
                        <button class="btn-s btn-dark-line float-r devCardInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">신용카드 전표</button>
<?php }?>
<?php }?>
<?php }}?>

            </div>
            <dl>
                <dt>주문일시</dt>
                <dd class="font-rb"><?php echo $TPL_VAR["order"]["bdatetime"]?></dd>
            </dl>
            <dl>
                <dt>주문자</dt>
                <dd><?php echo $TPL_VAR["order"]["bname"]?></dd>
            </dl>
        </div>


        <h1>구매내역</h1>
        <table class="table-default">
            <colgroup>
                <col width="*"/>
                <col width="16%"/>
                <col width="16%"/>
                <col width="16%"/>
            </colgroup>
            <thead>
            <tr>
                <th>상품명/옵션</th>
                <th>주문수량</th>
                <th>결제금액</th>
                <th>과세/면세</th>
            </tr>
            </thead>
            <tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <tr>
                <td>
                    <div class="item">
                        <div class="thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>">
                        </div>
                        <p class="tit"><?php echo $TPL_V2["pname"]?> <br><?php echo $TPL_V2["option_text"]?> <?php if($TPL_V2["add_info"]){?><br><?php echo $TPL_V2["add_info"]?> <?php }?></p>

                    </div>
                </td>
                <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                <td><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em>원</td>
                <td><?php if($TPL_V2["surtax_yorn"]=='N'){?>과세<?php }else{?>면세<?php }?></td>
            </tr>
<?php }}?>
<?php }}?>

            </tbody>
        </table>

        <h1>결제내역</h1>
        <table class="join-table type02 fb__mypage__odtable--border">
            <colgroup>
                <col width="160px"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>결제수단</th>
                <td><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></td>
            </tr>
            <tr>
                <th>총 상품금액</th>
                <td><em><?php echo number_format($TPL_VAR["paymentInfo"]["total_listprice"])?></em>원</td>
            </tr>
            <tr>
                <th>총 할인금액</th>
                <td><em><?php if($TPL_VAR["paymentInfo"]["total_dc"]> 0){?>-<?php }?><?php echo number_format($TPL_VAR["paymentInfo"]["total_dc"])?></em>원</td>
            </tr>
            <tr>
                <th>적립금 사용</th>
                <td><em><?php if($TPL_VAR["paymentInfo"]["use_reserve"]> 0){?>-<?php }?><?php echo number_format($TPL_VAR["paymentInfo"]["use_reserve"])?></em>원</td>
            </tr>
            <tr>
                <th>총 배송비</th>
                <td><em><?php echo number_format($TPL_VAR["order"]["delivery_price"])?></em>원</td>
            </tr>
            <tr class="total-price">
                <th>총 결제금액</th>
                <td class="total-price-point"><em><?php echo number_format($TPL_VAR["paymentInfo"]["pt_dcprice"]+$TPL_VAR["order"]["delivery_price"])?></em>원</td>
            </tr>
        </table>

        <ul class="wrap-receipt-bottom">
            <li class="logo-area">
                <div class="logo">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/shop_logo.png" alt="">
                </div>
            </li>
            <li class="list-area">
                <table>
                    <colgroup>
                        <col width="25%">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상호명</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_name"]?></td>
                    </tr>
                    <tr>
                        <th scope="row">사업자번호</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_number"]?></td>
                    </tr>

                    <tr>
                        <th scope="row">대표자명</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></td>
                    </tr>
                    <tr>
                        <th  scope="row">대표전화번호</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></td>
                    </tr>
                    </tbody>
                </table>
            </li>
        </ul>

        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" onclick="javascript:window.close();">취소</button>
            <button class="btn-default btn-dark" onclick="javascript:window.print();">영수증 출력</button>
        </div>
    </div>
</div>