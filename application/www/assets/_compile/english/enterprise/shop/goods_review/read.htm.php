<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_review/read.htm 000002612 */ 
$TPL_anotherImgs_1=empty($TPL_VAR["anotherImgs"])||!is_array($TPL_VAR["anotherImgs"])?0:count($TPL_VAR["anotherImgs"]);
$TPL_cList_1=empty($TPL_VAR["cList"])||!is_array($TPL_VAR["cList"])?0:count($TPL_VAR["cList"]);?>
<div class="wrap-window-popup review-popup">
    <p class="popup-title">
        <span>Review History</span>
        <span class="close" onclick="window.close();"></span>
    </p>
    <div class="popup-content">
        <div class="item">
            <div class="thumb">
                <img src="<?php echo $TPL_VAR["thumb"]?>">
            </div>
            <div class="info">
                <p class="title"><?php echo $TPL_VAR["pname"]?></p>
                <p class="option"><?php echo $TPL_VAR["option_name"]?></p>
            </div>
<?php if($TPL_VAR["buy_date"]){?>
            <p class="date">purchase date:<?php echo $TPL_VAR["buy_date"]?></p>
<?php }?>
        </div>
        <div class="score">
            <span>Product evaluation</span>
            <img src="/assets/templet/enterprise/img/common/star_s_<?php echo $TPL_VAR["valuation_goods"]?>.png">
            <em><?php echo $TPL_VAR["valuation_goods"]?>.0</em>
            <span>Shipping Evaluation</span>
            <img src="/assets/templet/enterprise/img/common/star_s_<?php echo $TPL_VAR["valuation_delivery"]?>.png">
            <em><?php echo $TPL_VAR["valuation_delivery"]?>.0</em>
        </div>
        <div class="review-content">
            <p class="tit"><?php echo $TPL_VAR["bbs_subject"]?></p>
            <p class="content"><?php echo $TPL_VAR["bbs_contents"]?></p>
            <div class="img-area">
<?php if($TPL_anotherImgs_1){foreach($TPL_VAR["anotherImgs"] as $TPL_V1){?>
                <img src="<?php echo $TPL_V1?>"><br/>
<?php }}?>
            </div>
        </div>
        <div class="review-comment-area">
<?php if($TPL_cList_1){foreach($TPL_VAR["cList"] as $TPL_V1){?>
            <section>
                <p><em>Comment</em> <?php echo $TPL_VAR["bbs_name"]?> <span>Registraiton date:<?php echo $TPL_VAR["reg_date"]?></span></p>
                <div class="comment-content">
                    <?php echo $TPL_V1["cmt_contents"]?>

                </div>
            </section>
<?php }}?>
        </div>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" onclick="window.close();">Cancel</button>
            <!--  <button class="btn-default btn-point">저장</button> -->
        </div>
    </div>
</div>