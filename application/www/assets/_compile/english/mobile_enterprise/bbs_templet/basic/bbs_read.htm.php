<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_read.htm 000003436 */ ?>
<!--공지사항 상세-->
<section class="br__cs-noti br__cs">
    <h2 class="br__cs__title">
        Notice
    </h2>
    <div class="read ">
        <input type="hidden" id="isList" value="N" />
        <div class="read__header">

<?php if($TPL_VAR["is_notice"]=='Y'){?>
            <span class="read__noti-badge">Notice</span>
<?php }?>

            <p class="read__title">
                <span class="read__date"><?php echo $TPL_VAR["reg_date"]?></span><?php echo $TPL_VAR["bbs_subject"]?>

                <span class="read__barrel">BARREL</span>
            </p>

        </div>
        <div class="read__content">
            <?php echo $TPL_VAR["bbs_contents"]?>

<?php if($TPL_VAR["bbs_file_1"]!=""||$TPL_VAR["bbs_file_2"]!=""||$TPL_VAR["bbs_file_3"]!=""||$TPL_VAR["bbs_file_4"]!=""){?>
            <div class="read__file ">
<?php if($TPL_VAR["bbs_file_1"]!=""){?><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>"><?php echo $TPL_VAR["bbs_file_1"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>"><?php echo $TPL_VAR["bbs_file_2"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>"><?php echo $TPL_VAR["bbs_file_3"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_4"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_4"]?>"><?php echo $TPL_VAR["bbs_file_4"]?></a><?php }?>
            </div>
<?php }?>
        </div>
        <ul class="cs__noti__wrap">
            <li class="cs__noti__list">
               <span class="cs__noti__prev">Previous</span>
                <div class="cs__noti__list--middle">
<?php if($TPL_VAR["beforeRecord"]['bbs_subject']!=''){?>
                    <span class="cs__noti__subject" onclick="javascript:location.href='/customer/notice/read/<?php echo $TPL_VAR["beforeRecord"]['bbs_ix']?>'"><?php echo $TPL_VAR["beforeRecord"]['bbs_subject']?></span>
                    <span class="cs__noti__date"><?php echo $TPL_VAR["beforeRecord"]['reg_date']?></span>
<?php }else{?>
                    <span class="cs__noti__subject">No previeous content</span>
<?php }?>
                </div>
                <span class="cs__noti__barrel">BARREL</span>
            </li>
        </ul>
        <ul class="cs__noti__wrap">
            <li class="cs__noti__list">
                <span class="cs__noti__next">Next</span>
                <div class="cs__noti__list--middle">
<?php if($TPL_VAR["nextRecord"]['bbs_subject']!=''){?>
                    <span class="cs__noti__subject" onclick="javascript:location.href='/customer/notice/read/<?php echo $TPL_VAR["nextRecord"]['bbs_ix']?>'"><?php echo $TPL_VAR["nextRecord"]['bbs_subject']?></span>
                    <span class="cs__noti__date"><?php echo $TPL_VAR["nextRecord"]['reg_date']?></span>
<?php }else{?>
                    <span class="cs__noti__subject">None</span>
<?php }?>
                </div>
                <span class="cs__noti__barrel">BARREL</span>
            </li>
        </ul>
    </div>
    <div class="read__btn--wrap">
        <a class="read__btn__list" href="/customer/notice">List</a>
    </div>
</section>