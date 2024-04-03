<?php /* Template_ 2.2.8 2020/08/31 15:57:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_review/read.htm 000002688 */ 
$TPL_anotherImgs_1=empty($TPL_VAR["anotherImgs"])||!is_array($TPL_VAR["anotherImgs"])?0:count($TPL_VAR["anotherImgs"]);
$TPL_cList_1=empty($TPL_VAR["cList"])||!is_array($TPL_VAR["cList"])?0:count($TPL_VAR["cList"]);?>
<div class="wrap-window-popup review-popup">
    <p class="popup-title">
        <span>상품 후기 내역</span>
        <span class="close" onclick="window.close();"></span>
    </p>
    <div class="popup-content">
        <div class="item">
            <div class="thumb">
                <img src="<?php echo $TPL_VAR["thumb"]?>">
            </div>
            <div class="info">
                <p class="title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></p>
                <p class="option"><?php echo $TPL_VAR["option_name"]?></p>
            </div>
<?php if($TPL_VAR["buy_date"]){?>
            <p class="date">구매일:<?php echo $TPL_VAR["buy_date"]?></p>
<?php }?>
        </div>
        <div class="score">
            <span>상품평가</span>
            <img src="/assets/templet/enterprise/img/common/star_s_<?php echo $TPL_VAR["valuation_goods"]?>.png">
            <em><?php echo $TPL_VAR["valuation_goods"]?>.0</em>
            <span>배송평가</span>
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
                <p><em>댓글</em> <?php echo $TPL_VAR["bbs_name"]?> <span>등록일:<?php echo $TPL_VAR["reg_date"]?></span></p>
                <div class="comment-content">
                    <?php echo $TPL_V1["cmt_contents"]?>

                </div>
            </section>
<?php }}?>
        </div>
        <div class="popup-btn-area">
            <button class="btn-default btn-dark-line" onclick="window.close();">닫기</button>
            <!--  <button class="btn-default btn-point">저장</button> -->
        </div>
    </div>
</div>