<?php /* Template_ 2.2.8 2023/07/18 10:19:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/company/privacy/privacy.htm 000001476 */ 
$TPL_policy_1=empty($TPL_VAR["policy"])||!is_array($TPL_VAR["policy"])?0:count($TPL_VAR["policy"]);?>
<div class="wrap-window-popup company-popup">
    <h2 class="br__cs__title">
        <span>개인 정보 처리방침</span>
    </h2>

    <div class="popup-content br__cs__layout">
        <!--<p class="prev-agreement_title"><?php echo $TPL_VAR["piTitle"]?></p>-->
        <div class="prev-agreement devContents">
<?php if($TPL_VAR["type"]=='sprint'){?>
            <div style="line-height:1.4;white-space: pre-line;">
<?php $this->print_("sprintPrivacy",$TPL_SCP,1);?>

            </div>
<?php }else{?>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
            <div class='devPolicyContentsClass prev-agreement-content' id='devPolicyContentsId<?php echo $TPL_V1["pi_ix"]?>'>
                <?php echo $TPL_V1["pi_contents"]?>

            </div>
<?php }}?>
            <br>
            <select id="devPolicyHistory" style="line-height: initial;">
                <option value="">개인 정보 처리방침 변경이력 보기</option>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["pi_ix"]?>"><?php echo $TPL_V1["regdate"]?> 시행</option>
<?php }}?>
            </select>
<?php }?>
        </div>
    </div>
</div>