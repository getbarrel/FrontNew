<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/review_img_view/review_img_view.htm 000000858 */ 
$TPL_imgs_1=empty($TPL_VAR["imgs"])||!is_array($TPL_VAR["imgs"])?0:count($TPL_VAR["imgs"]);?>
<div class="popup-img-view">

    <div class="review-detail-img">
        <div class="swiper-container">
            <div class="swiper-wrapper">
<?php if($TPL_imgs_1){$TPL_I1=-1;foreach($TPL_VAR["imgs"] as $TPL_V1){$TPL_I1++;?>
                <div class="swiper-slide <?php if($TPL_I1==$TPL_VAR["selectIndex"]){?>curpage<?php }?>"><img src="<?php echo $TPL_V1?>" width="600px"></div>
<?php }}?>
            </div>
            <div class="swiper-pagination"></div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </div>
</div>