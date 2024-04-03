<?php /* Template_ 2.2.8 2024/02/02 11:54:37 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/custom/bbs_list.htm 000002892 */ ?>
<!-- 컨텐츠 영역 S -->
<form id="devIrFrom">
    <input type="hidden" name="bType" id="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
    <input type="hidden" name="page" id="devPage" value="1"/>
    <input type="hidden" name="max" id="devMax" value="10"/>
    <input type='hidden' name='isList' value ='Y' id='isList'/>
</form>
<section class="br__ir">
	<div class="br__ir__top">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide"><a href="/corporateIR/financialInfo/">재무상태표</a></li>
				<li class="swiper-slide"><a href="/corporateIR/financialProfit/">손익계산서</a></li>
				<li class="swiper-slide active"><a href="/corporateIR/disclosureNoti/">공고</a></li>
				<li class="swiper-slide"><a href="/corporateIR/IRResources/">IR 자료</a></li>
			</ul>
		</div>
	</div>
	<section class="br__ir__content">
		<div class="page-title">
<?php if($TPL_VAR["bType"]=='announce'){?>
			<div class="title-md">기업 공고</div>
<?php }?>
		</div>
		<div class="br__ir__detail">
			<section class="br__ir__noti board-bbs__wrap">
				<ul class="board-bbs__list" id="devMyContent">
					<li id="devMyLoading" class="devForbizTpl"></li>
					<!-- 게시글이 없을 경우 S -->
					<!-- 숨김 처리 -->
					<li class="board-bbs__item no-data" id="devMyListEmpty">
						<p class="empty-content">
<?php if($TPL_VAR["bType"]=='announce'){?>
						<p>등록된 공시공고가 없습니다.</p>
<?php }else{?>
						<p>등록된 보도자료가 없습니다.</p>
<?php }?>					
						</p>
					</li>
					<!-- 게시글이 없을 경우 E -->
<?php if($TPL_VAR["bType"]=='announce'){?>
					<li class="board-bbs__item"  id="devMyList">
						<div class="board-bbs__title-group" devBbsIx="{[bbs_ix]}">
							<div class="board-bbs__title-sub">
								<span class="board-bbs__category">[BARREL]</span>
								<span class="board-bbs__day">{[reg_date]}</span>
							</div>
							<div class="board-bbs__title">
								<a class="board-bbs__link" href="#;">
									{[short_subject]}
									<i class="ico ico-arrow-right"></i>
								</a>
							</div>
						</div>
					</li>
<?php }else{?>
					<li class="board-bbs__item"  id="devMyList">
						<div class="board-bbs__title-group" devBbsIx="{[bbs_ix]}">
							<span class="irlist__each__num">{[no]}</span>
							<p class="irlist__each__title">{[short_subject]}</p>
						</div>
						<span class="irlist__each__date">{[reg_date]}</span>
					</li>
<?php }?>
				</ul>
				<div id="devPageWrap"></div>
				<div class="board-footer">
					<button type="button" class="btn-lg btn-dark-line">목록으로</button>
				</div>
			</section>
		</div>
	</section>
</section>
<!-- 컨텐츠 영역 E -->