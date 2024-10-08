<?php /* Template_ 2.2.8 2024/03/04 01:31:35 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_list.htm 000003603 */ ?>
<!-- 컨텐츠 S -->
<section class="br__cs-noti br__cs">
	<div class="cs__noti__wrap">
		<section class="cs__menu">
			<div class="br-tab__slide swiper-container">
				<ul class="swiper-wrapper">
					<li class="swiper-slide ">
						<a href="/customer">고객센터 홈</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/faq">자주 묻는 질문</a>
					</li>
					<li class="swiper-slide active">
						<a href="/customer/notice">공지사항</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/memberBenefit">회원혜택</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/storeInformation">매장안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/bestReview">제품후기</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/benefitsGuide/">적립금 / 쿠폰 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/cliamGuide">반품 / 환불 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/shippingGuide">배송 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/productPrecautions">제품 주의사항</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/contactUs">제휴 문의</a>
					</li>
				</ul>
			</div>
		</section>
		<div class="page-title">
			<div class="title-md">공지사항</div>
		</div>
		<section class="board-bbs__wrap">
			<div class="board-search__form">
			<form id="devBbsForm" name="devBbsForm">
				<input type="hidden" name="page" value="1" id="devPage"/>
				<input type="hidden" name="max" value="10" id="devMax"/>
				<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
				<input type='hidden' name='isList' value ='Y' id='isList'/>
				<input type='hidden' name='isMobile' value ='Y' id='isMobile'/>
				<label for="" class="hide">게시글 검색 입력창</label>
				<input type="text" id="searchText" name="searchText" class="fb__form-input" placeholder="검색어를 입력하세요."  value="<?php echo $TPL_VAR["searchText"]?>" />
				<button type="button" id="btnSearch" class="btn-search"><i class="ico ico-search"></i></button>
			</form>
			</div>
			<ul class="board-bbs__list" id="devBbsContent">
				<li id="devBbsLoading" class="board-bbs__item no-data">
					<p>Loading...</p>
				</li>
				<li id="devBbsEmpty" class="board-bbs__item no-data">
					<p class="empty-content">등록된 공지사항이 없습니다.</p>
				</li>
				
				<li class="board-bbs__item"  id="devBbsList">
					<div class="board-bbs__title-group">
						<div class="board-bbs__title-sub">
							<a class="board-bbs__link" href="javascript:void(0)" devBbsIx="{[bbs_ix]}">
							<span class="board-bbs__category">{[#if is_notice]}<span class="cs__noti__badge">공지</span>{[/if]}</span>
							<span class="board-bbs__day">{[reg_date]}</span>
							</a>
						</div>
						<div class="board-bbs__title">
							<a class="board-bbs__link" href="javascript:void(0)" devBbsIx="{[bbs_ix]}">
								{[bbs_subject]}
								<i class="ico ico-arrow-right"></i>
							</a>
						</div>
					</div>
				</li>
			</ul>

			<div id="devPageWrap" class="board-footer">
				<button type="button" class="btn-lg btn-dark-line">더보기</button>
			</div>
			<!-- <div class="board-footer" id="devPageWrap"></div> -->
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->