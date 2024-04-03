<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/teacher/bbs_read.htm 000003690 */ 
$TPL_comment_loop_1=empty($TPL_VAR["comment_loop"])||!is_array($TPL_VAR["comment_loop"])?0:count($TPL_VAR["comment_loop"]);?>
<section class="fb__bbs__detail">
    <input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
    <input type='hidden' name='bType' id='devBType' value ='<?php echo $TPL_VAR["bType"]?>' />
    <input type='hidden' name='bbsIx' id='devBbsIx' value ='<?php echo $TPL_VAR["bbs_ix"]?>' />
    <h2 class="fb__bbs__detail__title " style="margin-top: 80px;">Teacher member recruitment</h2>
    <section class="fb__bbs__detail-content">
        <div class="detail">
            <header class="detail__header">
                <p class="detail__status">[<?php if(empty($TPL_VAR["comment_loop"])){?>답변대기<?php }else{?>답변완료<?php }?>] [<?php echo $TPL_VAR["div_name"]?>]</p>
                <h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
                <span class="date detail__date"><?php echo $TPL_VAR["reg_date"]?></span>
            </header>
            <div class="content-area detail__content">
                <?php echo nl2br($TPL_VAR["bbs_contents"])?>


<?php if($TPL_VAR["bbs_file_1"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_etc1"]!=""){?>
                <div class="file file__video"><a href="<?php echo $TPL_VAR["bbs_etc1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_etc1"]?></a></div>
<?php }?>
            </div>
<?php if($TPL_VAR["comment_loop"]){?>
            <div class="qna-detail">
                <div class="cs__noti__wrap">
<?php if($TPL_comment_loop_1){foreach($TPL_VAR["comment_loop"] as $TPL_V1){?>
                    <div class="qna-detail__answer">
                        <div class="qna-detail__answer__info">
                            <header>
                                <h4 class="qna-detail__answer__name">BARREL</h4>
                                <span>답변일시 : <?php echo $TPL_V1["regdate"]?></span>
                            </header>
                            <p class="qna-detail__answer__desc">
                                <?php echo $TPL_V1["cmt_contents"]?>

                            </p>
                        </div>
                    </div>
<?php }}?>
                </div>
            </div>
<?php }?>
            <!--<nav class="detail__nav">-->
                <!--<button class="btn-default btn-dark-line" onclick="location.href = '/brand/teacherMember'">List</button>-->
            <!--</nav>-->
        </div>
    </section>
<?php if(empty($TPL_VAR["comment_loop"])){?>
    <div class="wrap-btn-area mat40 fb__teacher__btn">
        <button type="button" class="btn-lg btn-dark-line" id="devDeleteInquiry">Delete</button>
        <a href="/brand/teacherMember/write/<?php echo $TPL_VAR["bbs_ix"]?>" ><button type="button" class="btn-lg fb__btn-black">Edit</button></a>
        <a href="/brand/teacherMember/" class="fb__teacher__list btn-lg btn-dark-line">List</a>
    </div>
<?php }?>
</section>