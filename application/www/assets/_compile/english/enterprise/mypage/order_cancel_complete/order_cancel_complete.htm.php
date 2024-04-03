<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_cancel_complete/order_cancel_complete.htm 000003536 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

<div class="order-number-box">
      <span class="tit">Order No.</span>
      <span class="order-num" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></span>
      <span class="tit">Order Date</span>
      <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
</div>
<div class="wrap-claim-complete">
      <h2><span>The request Cancellation</span> for the order has been completed.</h2>
      <p class="desc">Your cancellation status is possible to check in My page > Return/Cancellation.</p>
</div>

<section>
      <table class="table-default order-table claim-complete">
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
            <th>Quantity</th>
            <th>Estimated Total</th>
            </thead>
            <tbody>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='CC'||$TPL_V2["status"]=='IB'){?>
                        <tr>
                              <td>
                                    <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
                                          <div class="thumb">
                                                <img src="<?php echo $TPL_V2["pimg"]?>">
                                          </div>
                                          <div class="info">
                                                <p class="title"><?php echo $TPL_V2["pname"]?></p>
                                                <p class="option"><?php echo $TPL_V2["option_text"]?></p>
                                          </div>
                                    </a>
                              </td>
                              <td><?php echo trans($TPL_V2["status_text"])?></td>
                              <td><em><?php echo number_format($TPL_VAR["restOrderDetail"][$TPL_V2["pid"]]['rest_cnt']+$TPL_V2["pcnt"])?></em>ltem(s)</td>
                              <td><em><?php echo $TPL_V2["pcnt"]?></em>ltem(s)</td>
                              <!--<td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>-->
                              <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                        </tr>
<?php }?>
<?php }}?>
<?php }}?>
            </tbody>
      </table>
</section>
<section class="fb__mypage__section">
      <div class="wrap-btn-area">
            <a href="/mypage/orderHistory/" class="btn-lg btn-dark-line">Your Orders</a>
            <a href="/mypage/returnHistory/" class="btn-lg btn-dark">Return/Cancellation</a>
      </div>
</section>