<?php /* Template_ 2.2.8 2023/07/18 10:19:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/company/agreement/agreement.htm 000001672 */ 
$TPL_policy_1=empty($TPL_VAR["policy"])||!is_array($TPL_VAR["policy"])?0:count($TPL_VAR["policy"]);
$TPL_policyHistory_1=empty($TPL_VAR["policyHistory"])||!is_array($TPL_VAR["policyHistory"])?0:count($TPL_VAR["policyHistory"]);?>
<div class="wrap-window-popup company-popup">
    <h2 class="br__cs__title">
<?php if($TPL_VAR["type"]=='sprint'){?>
        <span>대회 이용약관</span>
<?php }else{?>
        <span>이용약관</span>
<?php }?>
    </h2>

    <div class="popup-content br__cs__layout">
        <!--<p class="prev-agreement_title">약관내용</p>-->
        <div class="prev-agreement devContents">
<?php if($TPL_VAR["type"]=='sprint'){?>
            <div style="padding:0 0 10px;line-height:1.4;">
<?php $this->print_("sprintAgreement",$TPL_SCP,1);?>

            </div>
<?php }else{?>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
            <div class='devPolicyContentsClass prev-agreement-content' id='devPolicyContentsId<?php echo $TPL_V1["pi_ix"]?>'>
                <?php echo $TPL_V1["pi_contents"]?>

            </div>
<?php }}?>
            <br>
            <select id="devPolicyHistory" style="line-height: initial;">
                <option value="">약관 변경 이력 보기</option>
<?php if($TPL_policyHistory_1){foreach($TPL_VAR["policyHistory"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["pi_ix"]?>"><?php echo $TPL_V1["regdate"]?> 시행</option>
<?php }}?>
            </select>
<?php }?>
        </div>
    </div>
</div>