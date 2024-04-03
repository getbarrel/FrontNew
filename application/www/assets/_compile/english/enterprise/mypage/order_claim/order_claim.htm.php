<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_claim.htm 000002839 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>

<div class="wrap-mypage wrap-order-claim fb__order-claim">
    <ul class="claim-step mat50">
        <li <?php if($TPL_VAR["claimStep"]=='apply'){?>class="on"<?php }?>><?php echo $TPL_VAR["claimTypeName"]?>Enter information</li>
        <li <?php if($TPL_VAR["claimStep"]=='confirm'){?>class="on"<?php }?>><?php echo $TPL_VAR["claimTypeName"]?>Confirm information</li>
        <li <?php if($TPL_VAR["claimStep"]=='complete'){?>class="on"<?php }?>><?php echo $TPL_VAR["claimTypeName"]?> Request completed</li>
    </ul>

    <h2 class="fb__mypage__title">Request <?php echo $TPL_VAR["claimTypeName"]?> Item</h2>


<?php if($TPL_VAR["claimStep"]!='complete'){?>
    <!--<div class="desc">-->
    <!--텍스트 빼기로 기획 요청-->
        <!--<p>Before requesting a <?php echo $TPL_VAR["return"]?>, please make sure to discuss the matter with the seller for smooth service.</p>-->
        <!--<p>Additional shipping fee may be required when the buyer is at fault. However, when the seller is at fault, such as a product defect, there is no additional shipping fee.</p>-->
        <!--<p>You might not be able to exchange without contact with the seller.(if there is no exchangeable stock, only refund is possible.)</p>-->
    <!--</div>-->
<?php }?>

    <div class="order-number-box">
        <span class="tit">Order No.</span>
        <span class="order-num" id="devOid" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-status="<?php echo $TPL_VAR["order"]["status"]?>" data-claimstatus="<?php echo $TPL_VAR["claimstatus"]?>"><?php echo $TPL_VAR["order"]["oid"]?></span>
        <span class="tit">Order Date</span>
        <span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>
    </div>

<?php $this->print_("claimPage",$TPL_SCP,1);?>


<?php if($TPL_VAR["claimStep"]!='complete'){?>
    <section class="fb__mypage__section">
        <div class="wrap-btn-area">
            <button class="btn-lg btn-dark-line" id="devPrevBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">Previous</button>
            <button class="btn-lg btn-dark" id="devNextBtn" data-claim="<?php echo $TPL_VAR["claimType"]?>">Next</button>
        </div>
    </section>
<?php }else{?>
    <section class="fb__mypage__section">
        <div class="wrap-btn-area">
            <button class="btn-lg btn-dark-line" id="devFineshOrderBtn">Your Orders</button>
            <button class="btn-lg btn-dark" id="devFineshBtn">Return/Cancellation</button>
        </div>
    </section>
<?php }?>

</div>