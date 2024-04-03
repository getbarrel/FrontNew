<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_goods_inquiry_detail/my_goods_inquiry_detail.htm 000003369 */ 
$TPL_comments_1=empty($TPL_VAR["comments"])||!is_array($TPL_VAR["comments"])?0:count($TPL_VAR["comments"]);?>
<div class="fb__myGoodsInquiryDetail">
    <div class="detail">
        <div class="wrap-bbs-view">
            <div class="top-area">
                <span>Date : <em class="font-rb"><?php echo $TPL_VAR["regdate"]?></em></span>
<?php if($TPL_VAR["isResponse"]){?>
                <span class="status complete">Completed</span>
<?php }else{?>
                <span class="status">Pending</span>
<?php }?>
            </div>

            <div class="bbs-title">
                <?php echo $TPL_VAR["bbs_subject"]?>

            </div>
            <div class="wrap-question">
                <a href="/shop/goodsView/<?php echo $TPL_VAR["pid"]?>">
                    <div class="item">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["image_src"]?>">
                        </div>
                        <div class="info">
                            <p class="title"><?php echo $TPL_VAR["pname"]?></p>
<?php if($TPL_VAR["add_info"]){?>
                            <p class="color">Color : <?php echo $TPL_VAR["add_info"]?></p>
<?php }?>
                        </div>
                    </div>
                </a>
                <p class="question"><?php echo $TPL_VAR["bbs_contents"]?></p>
            </div>

<?php if($TPL_VAR["isResponse"]&&false){?>
            <div class="wrap-answer">
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
                <div class="top-area">
                    <span class="float-l"><?php echo $TPL_V1["cmt_name"]?></span>
                    <span class="float-r">Answered date: <em class="font-rb"><?php echo $TPL_V1["regdate"]?></em></span>
                </div>
                <p class="answer">
                    <?php echo $TPL_V1["cmt_contents"]?>

                </p>
<?php }}?>
            </div>
<?php }?>
<?php if($TPL_VAR["isResponse"]){?>
            <div class="detail__answer">
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
                <div class="detail__answer-list">
                    <header class="detail__answer-header">
                        <h3 class="detail__answer-title">
                            BARREL
                        </h3>
                        <span class="detail__answer-day">
                            Answered date : <?php echo $TPL_V1["regdate"]?>

                        </span>
                    </header>
                    <p  class="detail__answer-info">
                        <?php echo nl2br($TPL_V1["cmt_contents"])?>

                    </p>
                </div>
<?php }}?>
            </div>
<?php }?>

            <div class="popup-btn-area">
<?php if($TPL_VAR["isResponse"]){?>

<?php }else{?>
                <button class="btn-default btn-dark-line devDeleteQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>">Delete</button>
                <button class="btn-default btn-dark devModifyQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>" data-pid="<?php echo $TPL_VAR["pid"]?>">Edit</button>
<?php }?>
            </div>
        </div>
    </div>
</div>