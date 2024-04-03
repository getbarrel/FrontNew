<?php /* Template_ 2.2.8 2024/02/02 13:44:44 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/custom/bbs_read.htm 000003031 */ ?>
<!-- 컨텐츠 영역 S -->
<section class="br__ir">
	<div class="br__ir__top">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide"><a href="/corporateIR/financialInfo/">재무상태표</a></li>
				<li class="swiper-slide"><a href="/corporateIR/financialProfit/">손익계산서</a></li>
				<li class="swiper-slide <?php if($TPL_VAR["bType"]=='announce'){?> active <?php }?>"><a href="/corporateIR/disclosureNoti/">공고</a></li>
				<li class="swiper-slide <?php if($TPL_VAR["bType"]=='ir'){?> active <?php }?>"><a href="/corporateIR/IRResources/">IR 자료</a></li>
			</ul>
		</div>
	</div>
	<section class="br__ir__content board-detail__wrap">
		<section class="board-detail__header">
			<div class="page-title">
				<div class="title-md"><?php echo $TPL_VAR["board_name"]?></div>
			</div>
		</section>
		<section class="board-detail__content">
			<div class="detail-bbs__wrap">
				<div class="detail-bbs__header">
					<div class="detail-bbs__header-sub">
						<span class="detail-bbs__category category">[BARREL]</span>
						<span class="detail-bbs__date date"><?php echo $TPL_VAR["reg_date"]?></span>
					</div>
					<div class="detail-bbs__header-group">
						<h3 class="detail-bbs__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
					</div>
				</div>
				<div class="detail-bbs__content">
					<div class="cont-area"><?php echo $TPL_VAR["bbs_contents"]?></div>
<?php if($TPL_VAR["bbs_file_1"]!=""||$TPL_VAR["bbs_file_2"]!=""||$TPL_VAR["bbs_file_3"]!=""){?>
					<dl class="file">
						<dt>첨부파일</dt>
						<dd>
<?php if($TPL_VAR["bbs_file_1"]!=""){?><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>"><?php echo $TPL_VAR["bbs_file_1"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>"><?php echo $TPL_VAR["bbs_file_2"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>"><?php echo $TPL_VAR["bbs_file_3"]?></a><?php }?>						
						</dd>
					</dl>
<?php }?>
				</div>
				<div class="detail-bbs__footer">
					<!--<nav class="detail-bbs__nav">
						<ul>
							<li class="detail-bbs__nav-prev">
								<span> 이전글 </span>
								이전글이 존재하지 않습니다.
							</li>
							<li class="detail-bbs__nav-next">
								<span> 다음글 </span>
								다음글이 존재하지 않습니다.
							</li>
						</ul>
					</nav>-->
					<button type="button" class="btn-default btn-dark-line"><a class="read__btn__list" href="/corporateIR/<?php if($TPL_VAR["bType"]=='announce'){?>disclosureNoti/<?php }else{?>IRResources/<?php }?>">목록으로</a></button>
				</div>
			</div>
		</section>
	</section>
</section>
<!-- 컨텐츠 영역 E -->