<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/member/authentication/authentication.htm 000000324 */ ?>
<?php if($TPL_VAR["joinType"]=='C'){?>
<?php $this->print_("joinCompany",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("joinBasic",$TPL_SCP,1);?>

<?php }?>