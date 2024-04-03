<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_complete.htm 000002465 */ ?>
<section class="br__return-complete">
    <h2 class="fb__title--hidden">주문취소완료페이지</h2>
    <div class="wrap-claim-complete">
        <h3>The request [Cancellation] for the order has been completed.</h3>
        <p class="desc">Your <?php echo $TPL_VAR["claimTypeName"]?> status is possible to check in My page > Return/Cancellation.</p>
    </div>
    <section>
        <table class="table-default order-table claim-complete">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="110px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
                <th>Item Name/Option</th>
                <th>Quantities of order</th>
                <th><?php echo $TPL_VAR["claimTypeName"]?> Quantity</th>
                <th>Estimated Total</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <tr>
                    <td>
                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                            <div class="thumb">
                                <img src="<?php echo $TPL_V2["pimg"]?>">
                            </div>
                            <div class="info">
                                <p class="title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                                <p class="option"><?php echo $TPL_V2["option_text"]?></p>
<?php if($TPL_V2["add_info"]){?>
                                <p class="option"><?php echo $TPL_V2["add_info"]?></p>
<?php }?>
                            </div>
                        </a>
                    </td>
                    <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                    <td><em><?php echo $TPL_VAR["claimCnt"][$TPL_V2["od_ix"]]?></em>ltem(s)</td>
                    <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                </tr>
<?php }}?>
<?php }}?>
            </tbody>
        </table>
    </section>
</section>