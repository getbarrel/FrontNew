<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_read.htm 000002805 */ 
$TPL_before_record_1=empty($TPL_VAR["before_record"])||!is_array($TPL_VAR["before_record"])?0:count($TPL_VAR["before_record"]);
$TPL_next_record_1=empty($TPL_VAR["next_record"])||!is_array($TPL_VAR["next_record"])?0:count($TPL_VAR["next_record"]);?>
<?php $this->print_("customerTop",$TPL_SCP,1);?>

<section class="fb__bbs__detail">
    <input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
    <h2 class="fb__bbs__detail__title">Notice</h2>
    <section class="fb__bbs__detail-content">
        <div class="detail">
            <header class="detail__header">
                <h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
                <span class="date detail__date"><?php echo $TPL_VAR["reg_date"]?></span>
            </header>
            <div class="content-area detail__content">
                <?php echo nl2br($TPL_VAR["bbs_contents"])?>

<?php if($TPL_VAR["bbs_file_1"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></div><?php }?>
            </div>
            <nav class="detail__nav">
                <ul>
                    <li class="detail__nav-prev">
                        <span>
                           Previous
                        </span>
<?php if($TPL_before_record_1){foreach($TPL_VAR["before_record"] as $TPL_V1){?>
                        <a href="<?php echo $TPL_V1["link"]?>">Notice<?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
                        No previeous content
<?php }?>
                    </li>
                    <li class="detail__nav-next">
                        <span>
                            Next
                        </span>
<?php if($TPL_next_record_1){foreach($TPL_VAR["next_record"] as $TPL_V1){?>
                        <a href="<?php echo $TPL_V1["link"]?>">[Notice]<?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
                        None
<?php }?>
                    </li>

                </ul>
                <button class="btn-default btn-dark-line" onclick="location.href = '/customer/notice'">List</button>
            </nav>
        </div>
    </section>
</section>