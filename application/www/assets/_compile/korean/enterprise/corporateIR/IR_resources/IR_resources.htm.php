<?php /* Template_ 2.2.8 2024/01/30 13:52:13 /home/barrel-stage/application/www/assets/templet/enterprise/corporateIR/IR_resources/IR_resources.htm 000002225 */ ?>
<form id="devBbsForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="5" id="devMax"/>
      <input type="hidden" name="bType" value="ir" id="bType"/>
      <input type='hidden' name='isList' value ='Y' id='isList'/>
      <input type='hidden' name='isMobile' value ='N' id='isMobile'/>
</form>
<!-- 컨텐츠 S -->
<section class="br__ir fb-corporateIR">
	<section class="br__ir__content-wrap fb-corporateIR__content-wrap">
		<div class="br__ir__header fb-corporateIR__header">
			<h2 class="title-md">IR 자료</h2>
		</div>
		<section class="br__ir__content fb-corporateIR__content">
			<section class="br__ir__noti fb-corporateIR__noti board-bbs__wrap">
				<ul id="devBbsContent" class="board-bbs__list">
					<li id="devBbsLoading"></li>
					<li id="devBbsEmpty" class="board-bbs__item devForbizTpl"><p class="empty-content">등록된 IR 자료가 없습니다.</p></li>

					<li id="devBbsList" class="board-bbs__item devForbizTpl">
						<div class="board-bbs__title-group">
							<div class="board-bbs__title-sub">
								<span class="board-bbs__category">[BARREL]</span>
								<span class="board-bbs__day">{[reg_date]}</span>
							</div>
							<div class="board-bbs__title" devBbsIx="{[bbs_ix]}">
								<a class="board-bbs__link" href="javascript:void(0);">
									{[bbs_subject]}
									<i class="ico ico-arrow-right"></i>
								</a>
							</div>
						</div>
						<div class="board-bbs__btn">
                            {[#if bbs_file_1]}
                            <a href="<?php echo $TPL_VAR["download_path"]?>/{[bbs_ix]}/{[bbs_file_1]}" download><button type="button" class="btn-lg btn-dark-line btn-download"><?php if($TPL_VAR["langType"]=='korean'){?>첨부파일<?php }else{?>다운로드버튼<?php }?></button></a>
                            {[/if]}
						</div>
					</li>
				</ul>

				<!-- 페이지네이션 S -->
				<div id="devPageWrap"></div>
				<!-- 페이지네이션 E -->
			</section>
		</section>
	</section>
</section>
<!-- 컨텐츠 E -->