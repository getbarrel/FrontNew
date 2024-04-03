<?php /* Template_ 2.2.8 2024/02/22 17:09:12 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_claim/order_claim.htm 000000652 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>

<?php $this->print_("claimPage",$TPL_SCP,1);?>


<?php }else{?>
<script>var devClaimType = '<?php echo $TPL_VAR["claimType"]?>', devClaimStep = '<?php echo $TPL_VAR["claimStep"]?>';</script>
<section class="br__order-claim br__infoinput">

<?php $this->print_("claimPage",$TPL_SCP,1);?>


</section>
<?php }?>