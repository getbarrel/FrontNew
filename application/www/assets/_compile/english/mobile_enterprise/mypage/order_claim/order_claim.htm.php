<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim.htm 000003913 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>
<section class="br__order-claim br__infoinput">
    <h2 class="br__order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Request</h2>
    <div class="order-claim">

<?php $this->print_("claimPage",$TPL_SCP,1);?>


        <div class="wrap-sect"></div>

<?php if($TPL_VAR["claimStep"]!='complete'){?>
        <ul class="br__order-claim__notice">
            <li class="br__order-claim__desc">· (english)단순변심 등 구매자의 사유로 반품할 경우 왕복 배송비가 발생합니다.</li>
            <li class="br__order-claim__desc">· when the seller is at fault, such as a product defect, there is no additional shipping fee.</li>
            <li class="br__order-claim__desc">· (english)판매자와 협의없이 신청 시에는 환불 처리가 안될 수 있습니다.</li>
        </ul>
        <div class="br__order-claim__btn">
            <button type="button" class="br__order-claim__btn--cancel" id="devPrevBtn">Cancel</button>
            <button type="button" class="br__order-claim__btn--submit" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>"><?php if($TPL_VAR["claimStep"]=='confirm'){?><?php echo $TPL_VAR["claimTypeName"]?>Application<?php }else{?>Next<?php }?></button>
        </div>
<?php }else{?>
        <div class="order-complete__notice">
            <p class="order-complete__notice__desc">Cancellation processing status can be found in <span>My Page > Return/Cancellation</span]></p>
        </div>
        <div class="br__order-claim__btn">
            <a href="/mypage/orderHistory" id="devFineshOrderBtn" class="br__order-claim__btn--link">Your Orders</a>
            <a href="/mypage/returnHistory" id="devFineshBtn" class="br__order-claim__btn--link">Return/Cancellation</a>
        </div>
<?php }?>
    </div>
</section>
<?php }else{?>
<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>
<section class="br__order-claim br__infoinput">
    <h2 class="br__order-claim__title"><?php echo $TPL_VAR["claimTypeName"]?> Request</h2>
    <div class="order-claim">

<?php $this->print_("claimPage",$TPL_SCP,1);?>


        <div class="wrap-sect"></div>

<?php if($TPL_VAR["claimStep"]!='complete'){?>
        <ul class="br__order-claim__notice">
            <li class="br__order-claim__desc">· If you request a return without consultation with the seller, the return may not be processed.</li>
            <!--<li class="br__order-claim__desc">· If no stock is available for exchange, it can only be processed as a refund.</li>-->
        </ul>
        <div class="br__order-claim__btn">
            <button type="button" class="br__order-claim__btn--cancel" id="devPrevBtn">Cancel</button>
            <button type="button" class="br__order-claim__btn--submit" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>"><?php if($TPL_VAR["claimStep"]=='confirm'){?><?php echo $TPL_VAR["claimTypeName"]?>Application<?php }else{?>Next<?php }?></button>
        </div>
<?php }else{?>
        <div class="order-complete__notice">
            <p class="order-complete__notice__desc">Cancellation processing status can be found in <span>My Page > Return/Cancellation</span]></p>
        </div>
        <div class="br__order-claim__btn">
            <a href="/mypage/orderHistory" id="devFineshOrderBtn" class="br__order-claim__btn--link">Your Orders</a>
            <a href="/mypage/returnHistory" id="devFineshBtn" class="br__order-claim__btn--link">Return/Cancellation</a>
        </div>
<?php }?>
    </div>
</section>
<?php }?>