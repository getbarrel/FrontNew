<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_inquiry_detail/my_inquiry_detail.htm 000004437 */ 
$TPL_oInfo_1=empty($TPL_VAR["oInfo"])||!is_array($TPL_VAR["oInfo"])?0:count($TPL_VAR["oInfo"]);
$TPL_cInfo_1=empty($TPL_VAR["cInfo"])||!is_array($TPL_VAR["cInfo"])?0:count($TPL_VAR["cInfo"]);?>
<form id="devMyInquiryDetailForm">
    <input type="hidden" name="bType" id="bType" value="qna"/>
    <input type="hidden" name="bbsIx" id="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>"/>
</form>
<div class="fb__my-inquiry-detail br__inquiry-detail">
    <div class="detail">
        <div class="detail__top">
            <span class="detail__top__date">Date : <em class="font-rb"><?php echo $TPL_VAR["regdate"]?></em></span>
<?php if($TPL_VAR["status"]=='1'){?>
            <span class="status--normal">Inquiry</span>
<?php }elseif($TPL_VAR["status"]=='2'){?>
            <span class="status--normal">Checking</span>
<?php }elseif($TPL_VAR["status"]=='5'){?>
            <span class="status--complete">Completed</span>
<?php }?>
        </div>

        <div class="detail__title">
            <?php echo $TPL_VAR["bbs_subject"]?>

        </div>
        <div class="detail__content wrap-question">
            <!-- 주문번호 존재시 -->
<?php if($TPL_VAR["bbs_etc4"]!=''){?>
<?php if($TPL_oInfo_1){$TPL_I1=-1;foreach($TPL_VAR["oInfo"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
            <a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>">
                <div class="detail__item">
                    <div class="detail__item__thumb">
                        <img src="<?php echo $TPL_V1["pimg"]?>" alt="img">
                    </div>
                    <div class="detail__item__info">
                        <p class="detail__item__info-num order-num">Order No. <span><?php echo $TPL_V1["oid"]?></span></p>
                        <p class="detail__item__info-title"><?php echo $TPL_V1["pname"]?> <?php if($TPL_VAR["oInfoCnt"]> 1){?>외 <?php echo $TPL_VAR["oInfoCnt"]?>개 상품<?php }else{?><?php }?></p>
                    </div>
                </div>
            </a>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>

            <div class="detail__question question"><?php echo nl2br($TPL_VAR["bbs_contents"])?></div>
<?php if($TPL_VAR["bbs_file_1"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a>
            </p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_2"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a>
            </p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_3"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a>
            </p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_4"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a>
            </p><!--파일링크 추가 필요-->
<?php }?>

        </div>

<?php if($TPL_cInfo_1){foreach($TPL_VAR["cInfo"] as $TPL_V1){?>
        <div class="detail__answer ">
            <div class="detail__answer__info">
                <span class="detail__answer__info-name">BARREL</span>
                <span class="detail__answer__info-date">Answered date: <em><?php echo $TPL_V1["resdate"]?></em></span>
            </div>
            <div class="detail__answer__content answer"><?php echo nl2br($TPL_V1["cmt_contents"])?></div>
        </div>
<?php }}?>
<?php if($TPL_VAR["status"]== 1){?>
        <div class="my-inquiry__btns">
            <button class="my-inquiry__btns__del" id="devDeleteInquiry">삭제</button>
            <a href="/customer/qna/<?php echo $TPL_VAR["bbsIx"]?>" class="my-inquiry__btns__mod">수정</a>
        </div>
<?php }?>
    </div>
</div>