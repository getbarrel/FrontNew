<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim_complete.htm 000002529 */ ?>
<section class="br__return-complete">
    <h2 class="fb__title--hidden">주문취소완료페이지</h2>
    <div class="wrap-claim-complete">
        <h3>주문상품의 <span><?php echo $TPL_VAR["claimTypeName"]?>신청이 완료</span>되었습니다.</h3>
        <p class="desc"><?php echo $TPL_VAR["claimTypeName"]?>처리 현황은 <span>마이페이지 <em></em> 반품/취소 내역</span>에서 확인하실 수 있습니다.</p>
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
                <th>상품명/옵션</th>
                <th>주문수량</th>
                <th><?php echo $TPL_VAR["claimTypeName"]?>수량</th>
                <th>결제금액</th>
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
                    <td><em><?php echo $TPL_V2["pcnt"]?></em>개</td>
                    <td><em><?php echo $TPL_VAR["claimCnt"][$TPL_V2["od_ix"]]?></em>개</td>
                    <td class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></td>
                </tr>
<?php }}?>
<?php }}?>
            </tbody>
        </table>
    </section>
</section>