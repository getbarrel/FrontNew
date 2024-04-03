<?php /* Template_ 2.2.8 2024/02/14 14:05:33 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/custom/bbs_read.htm 000003115 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__bbs__detail">
	<div class="fb__bbs__detail__title">
		<input type='hidden' name='isAjaxList' id='isAjaxList' value ='N' />
		<div class="title-md"><?php echo $TPL_VAR["board_name"]?></div>
	</div>
	<section class="fb__bbs__detail-content">
		<div class="detail">
			<div class="detail__header">
				<div class="detail__header-group">
					<div class="detail__header-sub">
						<span class="detail__category category">[BARREL]</span>
						<span class="detail__date date"><?php echo $TPL_VAR["reg_date"]?></span>
					</div>
				</div>
				<div class="detail__header-group">
					<h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
				</div>
			</div>
<?php if($TPL_VAR["bType"]=='announce'){?>
			<div class="content-area detail__content">
				<div class="cont-area"><?php echo nl2br($TPL_VAR["bbs_contents"])?></div>

<?php if($TPL_VAR["bbs_file_1"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></dd></dl><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></dd></dl><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></dd></dl><?php }?>
			</div>
<?php }else{?>
			<div class="content-area detail__content">
<?php if($TPL_VAR["bbs_file_1"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_1"]?></a></dd></dl><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_2"]?></a></dd></dl><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?><dl class="file"<dt>첨부파일</dt><dd><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>" target="_blank"><?php echo $TPL_VAR["bbs_file_3"]?></a></dd></dl><?php }?>
			</div>
<?php }?>
			<div class="detail__footer">
				<!--<nav class="detail__nav">
					<ul>
						<li class="detail__nav-prev">
							<span> 이전글 </span>
							이전글이 존재하지 않습니다.
						</li>
						<li class="detail__nav-next">
							<span> 다음글 </span>
							다음글이 존재하지 않습니다.
						</li>
					</ul>
				</nav>-->
				<button type="button" class="btn-default btn-dark-line" onclick="location.href = '/corporateIR/IRResources'">목록으로</button>
			</div>
		</div>
	</section>
</section>
<!-- 컨텐츠 E -->