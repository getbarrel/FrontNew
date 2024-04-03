<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release.htm 000000871 */ ?>
<?php if(empty($TPL_VAR["releaseStep"])){?>
<?php $this->print_("policy",$TPL_SCP,1);?><!--휴면회원 전환안내-->
<?php }elseif($TPL_VAR["releaseStep"]=='auth'){?>
<?php if($TPL_VAR["memType"]=='C'){?>
<?php $this->print_("authCompany",$TPL_SCP,1);?><!--사업자 휴면회원 본인인증 -->
<?php }else{?>
<?php $this->print_("authBasic",$TPL_SCP,1);?><!--일반 휴면회원 본인인증 -->
<?php }?>
<?php }elseif($TPL_VAR["releaseStep"]=='policy'){?>
<?php $this->print_("policy",$TPL_SCP,1);?><!--휴면회원 약관동의 -->

<?php }elseif($TPL_VAR["releaseStep"]=='complete'){?>
<?php $this->print_("complete",$TPL_SCP,1);?><!--휴면회원 계정 활성화 완료-->
<?php }?>