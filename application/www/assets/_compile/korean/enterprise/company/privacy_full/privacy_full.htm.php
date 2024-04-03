<?php /* Template_ 2.2.8 2024/02/27 16:02:02 /home/barrel-stage/application/www/assets/templet/enterprise/company/privacy_full/privacy_full.htm 000001442 */ 
$TPL_policy_1=empty($TPL_VAR["policy"])||!is_array($TPL_VAR["policy"])?0:count($TPL_VAR["policy"]);?>
<div class="wrap-window-popup company-popup">
<?php if($TPL_VAR["piTitle"]=="이용약관"){?>
    <p class="popup-title">
        <span><?php echo $TPL_VAR["piTitle"]?></span>
    </p>
    <div style="padding-bottom:25px;"></div>
<?php }else{?>
    <p class="popup-title" style="border-bottom:0px solid #fff;">
        <!--<span><?php echo $TPL_VAR["piTitle"]?></span>-->
    </p>
<?php }?>

    <div class="popup-content">
        <div class="prev-agreement devContents" style="padding-bottom:50px;">
<?php if($TPL_policy_1){$TPL_I1=-1;foreach($TPL_VAR["policy"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
            <div class='devPolicyContentsClass' id='devPolicyContentsId<?php echo $TPL_V1["pi_ix"]?>'>
                <?php echo $TPL_V1["pi_contents"]?>

            </div>
<?php }?>
<?php }}?>
            <br>
            <select id="devPolicyHistory">
                <option value="">약관 변경 이력 보기</option>
<?php if($TPL_policy_1){foreach($TPL_VAR["policy"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["pi_ix"]?>"><?php echo $TPL_V1["regdate"]?> 시행</option>
<?php }}?>
            </select>
        </div>
    </div>
</div>