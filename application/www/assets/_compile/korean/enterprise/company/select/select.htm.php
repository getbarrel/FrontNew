<?php /* Template_ 2.2.8 2024/02/27 15:10:47 /home/barrel-stage/application/www/assets/templet/enterprise/company/select/select.htm 000001416 */ 
$TPL_policy_1=empty($TPL_VAR["policy"])||!is_array($TPL_VAR["policy"])?0:count($TPL_VAR["policy"]);?>
<div class="wrap-window-popup company-popup">
    <p class="popup-title">
<?php if($TPL_VAR["type"]=='sprint'){?>
        <span>개인정보 수집 및 이용(선택)</span>
<?php }else{?>
        <span><?php echo $TPL_VAR["piTitle"]?></span>
<?php }?>
    </p>

    <div class="popup-content">
        <div class="prev-agreement devContents">
<?php if($TPL_VAR["type"]=='sprint'){?>
            <div style="line-height:1.4;white-space: pre-line;">
<?php $this->print_("sprintPrivacy",$TPL_SCP,1);?>

            </div>
<?php }else{?>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
            <div class='devPolicyContentsClass' id='devPolicyContentsId<?php echo $TPL_V1["pi_ix"]?>'>
                <?php echo $TPL_V1["pi_contents"]?>

            </div>
<?php }}?>
            <br>
            <select id="devPolicyHistory">
                <option value="">약관 변경 이력 보기</option>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["pi_ix"]?>"><?php echo $TPL_V1["regdate"]?> 시행</option>
<?php }}?>
            </select>
<?php }?>
        </div>
    </div>
</div>