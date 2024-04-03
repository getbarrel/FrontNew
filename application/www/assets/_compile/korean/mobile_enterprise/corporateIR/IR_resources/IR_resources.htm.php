<?php /* Template_ 2.2.8 2024/02/02 12:07:34 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/corporateIR/IR_resources/IR_resources.htm 000002739 */ ?>
<!-- 컨텐츠 영역 S -->
<section class="br__ir">
	<div class="br__ir__top">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide"><a href="/corporateIR/financialInfo/">재무상태표</a></li>
				<li class="swiper-slide"><a href="/corporateIR/financialProfit/">손익계산서</a></li>
				<li class="swiper-slide"><a href="/corporateIR/disclosureNoti/">공고</a></li>
				<li class="swiper-slide active"><a href="/corporateIR/IRResources/">IR 자료</a></li>
			</ul>
		</div>
	</div>
	<section class="br__ir__content">
		<div class="page-title">
			<div class="title-md">IR 자료</div>
		</div>
		<form id="devBbsForm">
			  <input type="hidden" name="page" value="1" id="devPage"/>
			  <input type="hidden" name="max" value="5" id="devMax"/>
			  <input type="hidden" name="bType" value="ir" id="bType"/>
			  <input type='hidden' name='isList' value ='Y' id='isList'/>
			  <input type='hidden' name='isMobile' value ='Y' id='isMobile'/>
		</form>		
		<div class="br__ir__detail">
			<section class="br__ir__noti board-bbs__wrap">
				<ul class="board-bbs__list" id="devBbsContent">
					<!-- 게시글이 없을 경우 S -->
					<!-- 숨김 처리 -->
					<li class="board-bbs__item no-data">
						<p class="empty-content">등록된 공지사항이 없습니다.</p>
					</li>
					<!-- 게시글이 없을 경우 E -->
					<li class="board-bbs__item" id="devBbsList" devBbsIx="{[bbs_ix]}">
						<div class="board-bbs__title-group">
							<div class="board-bbs__title-sub">
								<span class="board-bbs__category">[BARREL]</span>
								<span class="board-bbs__day">{[reg_date2]}</span>
							</div>
							<div class="board-bbs__title">
								<a class="board-bbs__link" href="#;">
									{[bbs_subject]}
									<i class="ico ico-arrow-right"></i>
								</a>
							</div>
						</div>
						{[#if bbs_file_1]}
						<div class="board-bbs__btn">
							<a href="<?php echo $TPL_VAR["download_path"]?>/{[bbs_ix]}/{[bbs_file_1]}" download>
							<button type="button" class="btn-md btn-gray-line btn-download" onclick="alert('다운받기')">다운받기</button>
                            </a>
						</div>
						{[/if]}
					</li>

					<li id="devBbsLoading" class="board-bbs__item no-data">
						  <p>Loading...</p>
					</li>
					<li id="devBbsEmpty" class="board-bbs__item no-data">
						  <p>등록된 공지사항이 없습니다.</p>
					</li>

					<div id="devPageWrap"></div>
				</ul>
			</section>
		</div>
	</section>
</section>
<!-- 컨텐츠 영역 E -->