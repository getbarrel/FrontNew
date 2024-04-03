<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_goods_inquiry_detail/my_goods_inquiry_detail.htm 000002774 */ 
$TPL_comments_1=empty($TPL_VAR["comments"])||!is_array($TPL_VAR["comments"])?0:count($TPL_VAR["comments"]);?>
<section class="br__mypage br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">Customer Q&A</p>
    </div>

    <div class="my-inquiry">
        <div class="my-inquiry__info">
<?php if($TPL_VAR["isResponse"]){?>
            <span class="my-inquiry__info__state my-inquiry__info__state--point">Completed</span>
<?php }else{?>
            <span class="my-inquiry__info__state">Pending</span>
<?php }?>
            <span class="my-inquiry__info__type"><?php echo $TPL_VAR["div_name"]?></span>
            <span class="my-inquiry__info__date"><?php echo $TPL_VAR["regdate"]?></span>
            <!--<span class="my-inquiry__info__name">천세원</span>-->
            <p class="my-inquiry__info__title my-inquiry__info__title--secret">
                <span><?php echo $TPL_VAR["bbs_subject"]?></span>
            </p>
        </div>
        <div class="my-inquiry__content">
            <div class="my-inquiry__goods">
                <a href = '/shop/goodsView/<?php echo $TPL_VAR["pid"]?>'>
                    <figure class="my-inquiry__goods__thumb">
                        <img src="<?php echo $TPL_VAR["image_src"]?>" alt="<?php echo $TPL_VAR["pname"]?>">
                    </figure>
                    <div class="my-inquiry__goods__info">
                        <p class="my-inquiry__goods__title"><?php echo $TPL_VAR["pname"]?></p>
                        <p class="my-inquiry__goods__option"><?php echo $TPL_VAR["add_info"]?></p>
                    </div>
                </a>
            </div>
            <div class="my-inquiry__content__desc"><?php echo nl2br($TPL_VAR["bbs_contents"])?></div>
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
            <div class="my-inquiry__answer">
                <span class="my-inquiry__answer__name">BARREL</span>
                <span class="my-inquiry__answer__date"><?php echo $TPL_V1["regdate"]?></span>
                <p class="my-inquiry__answer__desc"><?php echo nl2br($TPL_V1["cmt_contents"])?></p>
            </div>
<?php }}?>
        </div>
    </div>

<?php if($TPL_comments_1== 0){?>
    <div class="my-inquiry__btns">
        <a href="javascript:void(0);" class="my-inquiry__btns__mod devModifyQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>" data-pid="<?php echo $TPL_VAR["pid"]?>">Edit</a>
        <button class="my-inquiry__btns__del devDeleteQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>">Delete</button>
    </div>
<?php }?>
</section>