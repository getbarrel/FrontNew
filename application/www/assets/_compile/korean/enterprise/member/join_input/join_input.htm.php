<?php /* Template_ 2.2.8 2023/12/07 17:29:37 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_input/join_input.htm 000000410 */ ?>
<?php if($TPL_VAR["joinType"]=='C'){?>
<?php $this->print_("joinCompany",$TPL_SCP,1);?>

<?php }elseif($TPL_VAR["joinType"]=='F1'){?>
<?php $this->print_("joinGlobal",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("joinBasic",$TPL_SCP,1);?>

<?php }?>