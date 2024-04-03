<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_input/join_input.htm 000000424 */ ?>
<?php if($TPL_VAR["joinType"]=='C'){?>
<?php $this->print_("joinCompany",$TPL_SCP,1);?>

<?php }elseif($TPL_VAR["joinType"]=='F1'){?>
<?php $this->print_("joinGlobal",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("joinBasic",$TPL_SCP,1);?>

<?php }?>