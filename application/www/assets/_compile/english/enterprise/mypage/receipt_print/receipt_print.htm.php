<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/receipt_print/receipt_print.htm 000006927 */ ?>
<div class="wrap-window-popup receipt-popup">
    <p class="popup-title">
        <span>Payment Receipt</span>
        <!--<span class="close" onclick="window.close();"></span>-->
    </p>

    <div class="popup-content">
        <p class="desc">This receipt cannot be used as an income deduction or purchase statement. It is only for proof of payment.</p>

        <div class="wrap-order-num">
            <div class="top-area">
                <span class=" float-l">Order No. <em><?php echo $TPL_VAR["order"]["oid"]?></em></span>

<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(($TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE||$TPL_V1["method"]==ORDER_METHOD_ASCROW)&&$TPL_V1["receipt_yn"]=='Y'){?>
<?php if($TPL_V1["tid"]){?>
                        <button class="btn-s btn-white float-r devCachInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">영문몰해당없음</button>
<?php }?>
<?php }elseif($TPL_V1["method"]==ORDER_METHOD_CARD){?>
<?php if($TPL_V1["tid"]){?>
                        <button class="btn-s btn-dark-line float-r devCardInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">Credit card slip</button>
<?php }?>
<?php }?>
<?php }}?>

            </div>
            <dl>
                <dt>Order date</dt>
                <dd class="font-rb"><?php echo $TPL_VAR["order"]["bdatetime"]?></dd>
            </dl>
            <dl>
                <dt>Name</dt>
                <dd><?php echo $TPL_VAR["order"]["bname"]?></dd>
            </dl>
        </div>


        <h1>Purchase History</h1>
        <table class="table-default">
            <colgroup>
                <col width="*"/>
                <col width="16%"/>
                <col width="16%"/>
                <col width="16%"/>
            </colgroup>
            <thead>
            <tr>
                <th>Item Name/Option</th>
                <th>Quantities of order</th>
                <th>Estimated Total</th>
                <th>Taxation/Tax Free</th>
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

        <h1>Payment History</h1>
        <table class="join-table type02 fb__mypage__odtable--border">
            <colgroup>
                <col width="160px"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>Payment Method</th>
                <td><?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?><?php echo $TPL_V1["method_text"]?> <?php }}?></td>
            </tr>
            <tr>
                <th>Item Total</th>
                <td><em><?php echo number_format($TPL_VAR["paymentInfo"]["total_listprice"])?></em>원</td>
            </tr>
            <tr>
                <th>Savings</th>
                <td><em><?php if($TPL_VAR["paymentInfo"]["total_dc"]> 0){?>-<?php }?><?php echo number_format($TPL_VAR["paymentInfo"]["total_dc"])?></em>원</td>
            </tr>
            <tr>
                <th>Mileage</th>
                <td><em><?php if($TPL_VAR["paymentInfo"]["use_reserve"]> 0){?>-<?php }?><?php echo number_format($TPL_VAR["paymentInfo"]["use_reserve"])?></em>원</td>
            </tr>
            <tr>
                <th>Shipping</th>
                <td><em><?php echo number_format($TPL_VAR["order"]["delivery_price"])?></em>원</td>
            </tr>
            <tr class="total-price">
                <th>Total Payment</th>
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
                        <th scope="row">Business Name</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_name"]?></td>
                    </tr>
                    <tr>
                        <th scope="row">Business number</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_number"]?></td>
                    </tr>

                    <tr>
                        <th scope="row">Representative</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></td>
                    </tr>
                    <tr>
                        <th scope="row">Address</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></td>
                    </tr>
                    <tr>
                        <th  scope="row">Representative telephone number</th>
                        <td><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></td>
                    </tr>
                    </tbody>
                </table>
            </li>
        </ul>

        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" onclick="javascript:window.close();">Cancel</button>
            <button class="btn-default btn-dark" onclick="javascript:window.print();">Print Receipt</button>
        </div>
    </div>
</div>