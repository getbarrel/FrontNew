<?php /* Template_ 2.2.8 2023/07/18 10:19:58 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim_complete.htm 000002937 */ ?>
<div class="order-complete">
    <div class="order-complete__ment">
        <p class="order-complete__ment__desc">주문상품의 <span><?php echo $TPL_VAR["claimTypeName"]?>신청이 완료</span>되었습니다.</p>
    </div>


    <!-- [S] 주문 취소 상품 -->
    <section class="order-claim__able">
        <h3 class="order-claim__title br__hidden">주문취소 상품</h3>
        <div class="order-claim__content">
            <dl class="order-claim__number">
                <dt class="order-claim__number__title">주문일자</dt>
                <dd class="order-claim__number__text"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
                <dt class="order-claim__number__title">주문번호</dt>
                <dd class="order-claim__number__text" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></dd>
            </dl>
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <ul class="order-claim__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                <li class="order-claim__box">
                    <div class="order-claim__goods">
                        <figure class="order-claim__goods__thumb">
                            <img src="<?php echo $TPL_V2["pimg"]?>" alt="<?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?>">
                        </figure>
                        <div class="order-claim__goods__info">
                            <p class="order-claim__goods__title"><?php echo $TPL_V2["brand_name"]?> <?php echo $TPL_V2["pname"]?></p>
                            <p class="order-claim__goods__option">
<?php if($TPL_V2["add_info"]){?>
                                <span><?php echo $TPL_V2["add_info"]?></span>
<?php }?>
                                <span><?php echo $TPL_V2["option_text"]?> / <em><?php echo $TPL_V2["pcnt"]?>개</em></span>

                                <span style="margin-top: 20px"><em>반품수량 : <?php echo $TPL_VAR["claimCnt"][$TPL_V2["od_ix"]]?>개</em></span>
                            </p>
                            <span class="order-claim__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo number_format($TPL_V2["pt_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            <button class="order-claim__goods__toggle">주문취소 신청/취소 버튼</button>
                        </div>
                    </div>
                </li>
<?php }}?>
            </ul>
<?php }}?>
        </div>
    </section>
</div>