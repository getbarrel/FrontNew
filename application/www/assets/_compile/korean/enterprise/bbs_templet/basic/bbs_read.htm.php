<?php /* Template_ 2.2.8 2024/01/30 13:56:03 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_read.htm 000002777 */ 
$TPL_before_record_1=empty($TPL_VAR["before_record"])||!is_array($TPL_VAR["before_record"])?0:count($TPL_VAR["before_record"]);
$TPL_next_record_1=empty($TPL_VAR["next_record"])||!is_array($TPL_VAR["next_record"])?0:count($TPL_VAR["next_record"]);?>
<!-- 컨텐츠 S -->
<section class="fb__bbs__detail">
	<input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
	<div class="fb__bbs__detail__title">
		<div class="title-md">공지사항</div>
	</div>
	<section class="fb__bbs__detail-content">
		<div class="detail">
			<div class="detail__header">
				<div class="detail__header-group">
					<div class="detail__header-sub">
						<span class="detail__category category">[배송]</span>
						<span class="detail__date date"><?php echo $TPL_VAR["reg_date"]?></span>
					</div>
				</div>
				<div class="detail__header-group">
					<h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
				</div>
			</div>
			<div class="content-area detail__content">
                <?php echo nl2br($TPL_VAR["bbs_contents"])?>

<?php if($TPL_VAR["bbs_file_1"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></div><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><div class="file"><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></div><?php }?>
			</div>
			<div class="detail__footer">
				<nav class="detail__nav">
					<ul>
						<li class="detail__nav-prev">
							<span> 이전글 </span>
<?php if($TPL_before_record_1){foreach($TPL_VAR["before_record"] as $TPL_V1){?>
							<a href="<?php echo $TPL_V1["link"]?>">[공지]<?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
							이전글이 존재하지 않습니다.
<?php }?>
						</li>
						<li class="detail__nav-next">
							<span> 다음글 </span>
<?php if($TPL_next_record_1){foreach($TPL_VAR["next_record"] as $TPL_V1){?>
							<a href="<?php echo $TPL_V1["link"]?>">[공지]<?php echo $TPL_V1["bbs_subject"]?></a>
<?php }}else{?>
							다음글이 존재하지 않습니다.
<?php }?>
						</li>
					</ul>
				</nav>
				<button type="button" class="btn-default btn-dark-line" onclick="location.href = '/customer/notice'">목록으로</button>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->