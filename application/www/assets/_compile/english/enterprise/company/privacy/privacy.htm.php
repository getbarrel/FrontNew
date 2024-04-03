<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/company/privacy/privacy.htm 000001427 */ 
$TPL_policy_1=empty($TPL_VAR["policy"])||!is_array($TPL_VAR["policy"])?0:count($TPL_VAR["policy"]);?>
<div class="wrap-window-popup company-popup">
    <p class="popup-title">
<?php if($TPL_VAR["type"]=='sprint'){?>
        <span>Collection and utilization of personal information</span>
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
                <option value="">History for term change</option>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["pi_ix"]?>"><?php echo $TPL_V1["regdate"]?> conduct</option>
<?php }}?>
            </select>
<?php }?>
        </div>
    </div>
</div>