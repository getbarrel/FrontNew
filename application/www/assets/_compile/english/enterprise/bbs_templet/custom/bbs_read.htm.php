<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/custom/bbs_read.htm 000003764 */ 
$TPL_next_record_1=empty($TPL_VAR["next_record"])||!is_array($TPL_VAR["next_record"])?0:count($TPL_VAR["next_record"]);
$TPL_before_record_1=empty($TPL_VAR["before_record"])||!is_array($TPL_VAR["before_record"])?0:count($TPL_VAR["before_record"]);?>
<section class="fb__bbs__detail">
    <input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
    <h2 class="fb__bbs__detail__title"><?php echo $TPL_VAR["board_name"]?></h2>
    <section class="fb__bbs__detail-content">
        <div class="detail">
            <header class="detail__header">
                <h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
                <span class="date detail__date"><?php echo $TPL_VAR["reg_date"]?></span>
            </header>
<?php if($TPL_VAR["bType"]=='announce'){?>
            <div class="content-area detail__content type2">
                <div class="cont-area">
                    <?php echo nl2br($TPL_VAR["bbs_contents"])?>

                </div>
<?php if($TPL_VAR["bbs_file_1"]!=""){?><div class="file">첨부파일<a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><div class="file">첨부파일<a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><div class="file">첨부파일<a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></div><?php }?>
            </div>
<?php }else{?>
            <div class="content-area detail__content">
                <?php echo nl2br($TPL_VAR["bbs_contents"])?>

<?php if($TPL_VAR["bbs_file_1"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></div><?php }?>
            </div>
<?php }?>
            <nav class="detail__nav">
                <ul>
                    <li class="detail__nav-next">
                        <span>
                            Next
                        </span>
<?php if($TPL_next_record_1){foreach($TPL_VAR["next_record"] as $TPL_V1){?>
                        <a href="<?php echo $TPL_V1["link"]?>"><?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
                        None
<?php }?>
                    </li>
                    <li class="detail__nav-prev">
                        <span>
                           Previous
                        </span>
<?php if($TPL_before_record_1){foreach($TPL_VAR["before_record"] as $TPL_V1){?>
                        <a href="<?php echo $TPL_V1["link"]?>"><?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
                        No previeous content
<?php }?>
                    </li>
                </ul>
                <button class="btn-default btn-dark-line" onclick="location.href = '/corporateIR/disclosureNoti/<?php echo $TPL_VAR["bType"]?>'">List</button>
            </nav>
        </div>
    </section>
</section>