<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_inquiry_detail/my_inquiry_detail.htm 000004332 */ 
$TPL_oInfo_1=empty($TPL_VAR["oInfo"])||!is_array($TPL_VAR["oInfo"])?0:count($TPL_VAR["oInfo"]);
$TPL_cInfo_1=empty($TPL_VAR["cInfo"])||!is_array($TPL_VAR["cInfo"])?0:count($TPL_VAR["cInfo"]);?>
<section class="br__mypage br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">1:1 Inquiry</p>
    </div>
    <form id="devMyInquiryDetailForm">
        <input type="hidden" name="bType" id="bType" value="qna"/>
        <input type="hidden" name="bbsIx" id="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>"/>
    </form>
    <div class="my-inquiry">
        <div class="my-inquiry__info">
<?php if($TPL_VAR["status"]=='1'){?>
            <span class="my-inquiry__info__state">Pending</span>
<?php }elseif($TPL_VAR["status"]=='5'){?>
            <span class="my-inquiry__info__state my-inquiry__info__state--point">Completed</span>
<?php }?>
            <span class="my-inquiry__info__type">[<?php echo $TPL_VAR["div_name"]?>]</span>
           <!-- <span class="my-inquiry__info__name">천세원</span>-->
            <span class="my-inquiry__info__date"><?php echo $TPL_VAR["regdate"]?></span>
            <p class="my-inquiry__info__title"><?php echo $TPL_VAR["bbs_subject"]?></p>
        </div>
        <div class="my-inquiry__content">
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
                        <p class="detail__item__info-title"><?php echo $TPL_V1["pname"]?> <?php if($TPL_VAR["oInfoCnt"]> 1){?><span>외 <?php echo $TPL_VAR["oInfoCnt"]?>개 상품</span><?php }else{?><?php }?></p>
                    </div>
                </div>
            </a>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>
            <div class="my-inquiry__content__desc"><?php echo nl2br($TPL_VAR["bbs_contents"])?></div>
            <ul class="my-inquiry__content__file">
<?php if($TPL_VAR["bbs_file_1"]!=''){?>
                <p class="file"><a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a></p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_2"]!=''){?>
                <p class="file"><a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a></p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_3"]!=''){?>
                <p class="file"><a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a></p><!--파일링크 추가 필요-->
<?php }?>

<?php if($TPL_VAR["bbs_file_4"]!=''){?>
                <p class="file"><a href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a></p><!--파일링크 추가 필요-->
<?php }?>
            </ul>
<?php if($TPL_cInfo_1){foreach($TPL_VAR["cInfo"] as $TPL_V1){?>
            <div class="my-inquiry__answer">
                <span class="my-inquiry__answer__name">BARREL</span>
                <span class="my-inquiry__answer__date"><?php echo $TPL_V1["resdate"]?></span>
                <p class="my-inquiry__answer__desc"><?php echo nl2br($TPL_V1["cmt_contents"])?></p>
            </div>
<?php }}?>
        </div>
    </div>
<?php if($TPL_VAR["status"]== 1){?>
    <div class="my-inquiry__btns">
        <a href="/customer/qna/<?php echo $TPL_VAR["bbsIx"]?>" class="my-inquiry__btns__mod">Edit</a>
        <button class="my-inquiry__btns__del" id="devDeleteInquiry">Delete</button>
    </div>
<?php }?>
</section>