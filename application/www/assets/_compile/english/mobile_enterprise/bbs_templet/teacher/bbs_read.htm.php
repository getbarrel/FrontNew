<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/teacher/bbs_read.htm 000003555 */ 
$TPL_comment_loop_1=empty($TPL_VAR["comment_loop"])||!is_array($TPL_VAR["comment_loop"])?0:count($TPL_VAR["comment_loop"]);?>
<!--공지사항 상세-->
<section class="br__cs-noti br__cs">
    <input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
    <input type='hidden' name='bType' id='devBType' value ='<?php echo $TPL_VAR["bType"]?>' />
    <input type='hidden' name='bbsIx' id='devBbsIx' value ='<?php echo $TPL_VAR["bbs_ix"]?>' />
    <h2 class="br__cs__title">
        Teacher member recruitment
    </h2>
    <div class="read ">
        <input type="hidden" id="isList" value="N" />
        <div class="read__header">
            <p class="read__status">[<?php if(empty($TPL_VAR["comment_loop"])){?>답변대기<?php }else{?>답변완료<?php }?>] [<?php echo $TPL_VAR["div_name"]?>]</p>
            <span class="read__date"><?php echo $TPL_VAR["reg_date"]?></span>
            <p class="read__title">
                <?php echo $TPL_VAR["bbs_subject"]?>

                <span class="read__barrel">
<?php if($_SESSION['user']['code']==$TPL_VAR["mem_ix"]){?>
                    <?php echo $TPL_VAR["writer"]?>

<?php }else{?>
                    <?php echo $TPL_VAR["short_bbs_name"]?>

<?php }?>
                </span>
            </p>

        </div>
        <div class="read__content">
            <?php echo $TPL_VAR["bbs_contents"]?>

<?php if($TPL_VAR["bbs_file_1"]!=""||$TPL_VAR["bbs_file_2"]!=""||$TPL_VAR["bbs_file_3"]!=""||$TPL_VAR["bbs_etc1"]!=""){?>
            <div class="read__file ">
<?php if($TPL_VAR["bbs_file_1"]!=""){?><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>"><?php echo $TPL_VAR["bbs_file_1"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><br> <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>"><?php echo $TPL_VAR["bbs_file_2"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><br> <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>"><?php echo $TPL_VAR["bbs_file_3"]?></a><?php }?>
<?php if($TPL_VAR["bbs_etc1"]!=""){?><br> <a href="<?php echo $TPL_VAR["bbs_etc1"]?>"><?php echo $TPL_VAR["bbs_etc1"]?></a><?php }?>
            </div>
<?php }?>

        </div>
<?php if($TPL_VAR["comment_loop"]){?>
        <ul class="cs__noti__wrap">
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
        </ul>
<?php }?>
    </div>
<?php if(empty($TPL_VAR["comment_loop"])){?>
    <div class="read__btn--wrap" style="text-align: center;">
        <a class="read__btn__list" href="javascript:void(0);" id="devDeleteInquiry">Delete</a>
        <a class="read__btn__list" style="color: #fff; background: #000;" href="/brand/teacherMember/write/<?php echo $TPL_VAR["bbs_ix"]?>">Edit</a>
        <a class="read__btn__list" href="/brand/teacherMember">List</a>
    </div>
<?php }?>
</section>