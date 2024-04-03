<?php /* Template_ 2.2.8 2024/02/23 11:05:48 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim.htm 000001180 */ ?>
<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>
<div class="wrap-mypage wrap-order-claim fb__order-claim">
<?php if($TPL_VAR["claimStep"]!='complete'){?>
<?php }?>
<?php $this->print_("claimPage",$TPL_SCP,1);?>

</div>
<!--
<?php if($TPL_VAR["claimStep"]!='complete'){?>
    <section class="fb__mypage__section">
        <div class="wrap-btn-area">
            <button class="btn-lg btn-dark-line" id="devPrevBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">이전</button>
            <button class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">다음</button>
        </div>
    </section>
<?php }else{?>
    <section class="fb__mypage__section">
        <div class="wrap-btn-area">
            <button class="btn-lg btn-dark-line" id="devFineshOrderBtn">주문내역조회</button>
            <button class="btn-lg btn-dark" id="devFineshBtn">반품/취소 내역</button>
        </div>
    </section>
<?php }?>
-->