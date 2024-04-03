<?php /* Template_ 2.2.8 2024/03/20 23:38:23 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_goods_inquiry/my_goods_inquiry.htm 000007492 */ ?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__myInquiry">
	<div class="page-title my-title">
		<div class="title-sm">상품 Q&A</div>
	</div>
	<div class="br__myInquiry-wrap">
		<form id="devMyGoodsForm">
			<input type="hidden" name="type" value="mine"/>
			<input type="hidden" name="page" value="1" id="devPage"/>
			<input type="hidden" name="max" value="20"/>
			<input type="hidden" name="sDate" value="" id="devStartDate"/>
			<input type="hidden" name="eDate" value="" id="devEndDate"/>
			<input type="hidden" name="state" value="" id="devState"/>
			<section class="br__myInquiry-search">
				<div class="search">
					<div class="br-tab__nav">
						<ul>
							<li id="tab01" devFilterState="" class="active">
								<a href="#;">전체</a>
							</li>
							<li id="tab02" devFilterState="N">
								<a href="#;">답변대기</a>
							</li>
							<li id="tab03" devFilterState="Y">
								<a href="#;">답변완료</a>
							</li>
						</ul>
					</div>
					<div class="br-tab__slide swiper-container">
						<ul class="swiper-wrapper">
							<li class="swiper-slide active">
								<a href="#;" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근 <em>1</em>개월</a>
							</li>
							<li class="swiper-slide">
								<a href="#;" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>3</em>개월</a>
							</li>
							<li class="swiper-slide">
								<a href="#;" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
							</li>
							<li class="swiper-slide">
								<a href="#;" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
							</li>
						</ul>
					</div>
					<div class="search__item">
						<div class="br__form-item">
							<label for="devSdate" class="hide">조회기간</label>
							<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick br__form-input" title="조회시작기간" />
							<span>-</span>
							<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick br__form-input" title="조회종료기간" />
						</div>
						<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-gray-line">조회</button>
					</div>
				</div>
			</section>
			<!-- 주문 내역 - 리스트 S -->
			<section class="board-inquiry">
				<div class="board-inquiry__wrap">
					<ul class="board-inquiry__list" id="devMyGoodsContent">
					
						<li class="board-inquiry__item no-data" id="devMyGoodsLoading">
							<p class="qna-no-data">Loading...</p>
						</li>
						<li class="board-inquiry__item no-data devForbizTpl" id="devMyGoodsEmpty">
							<p class="empty-content">상품 문의 내역이 없습니다.</p>
						</li>
						
						<li class="board-inquiry__item {[#if isResponse ]}complete{[/if]} devForbizTpl" id="devMyGoodsList">
							<a href="/mypage/myGoodsInquiryDetail/{[bbs_ix]}" class="board-inquiry__link">
								<dl class="board-inquiry__group">
									<dt>
										<div class="day">[{[regdate]}]</div>
										<div class="category">[{[div_name]}]</div>
									</dt>
									<dd>
										{[#if isResponse ]}
										<div class="state complete">답변완료</div>
										{[else]}
										<span class="state">답변대기</span>
										{[/if]}
										<div class="subject">{[bbs_subject]}</div>
									</dd>
								</dl>
							</a>
						</li>
						<!-- <li class="board-inquiry__item complete">
							<a href="#;" class="board-inquiry__link">
								<dl class="board-inquiry__group">
									<dt>
										<div class="day">2024-12-31</div>
										<div class="category">사이즈 문의</div>
									</dt>
									<dd>
										<div class="state complete">답변 완료</div>
										<div class="subject">질문있어요!</div>
									</dd>
								</dl>
							</a>
						</li> -->
					</ul>
					<div class="board-footer">
						<button type="button" class="btn-lg btn-dark-line">1:1 문의하기</button>
					</div>
				</div>
			</section>
			<!-- 주문 내역 - 리스트 E -->
		</form>
	</div>
</section>
<!-- 컨텐츠 E -->
<!--
<section class="br__mypage br__myInquiry">
	<div class="br__mypage__pass">
		<p class="pass-title">상품 Q&A</p>
	</div>
	<form id="devMyGoodsForm">
		<input type="hidden" name="type" value="mine"/>
		<input type="hidden" name="page" value="1" id="devPage"/>
		<input type="hidden" name="max" value="20"/>
		<input type="hidden" name="sDate" value="" id="devStartDate"/>
		<input type="hidden" name="eDate" value="" id="devEndDate"/>
		<input type="hidden" name="state" value="" id="devState"/>

		<div class="br__myInquiry__opt br__myInquiry__opt--two">
			<select class="opt__date" id="devDateSelect">
				<option value="" disabled selected>조회기간</option>
				<option value="1">1개월</option>
				<option value="3">3개월</option>
				<option value="6">6개월</option>
				<option value="12">1년</option>
				<option value="timeSelect" class="op__date--set">기간설정</option>
			</select>
			<select id="devStateSelect">
				<option value="" disabled selected>전체 진행상태</option>
				<option value="">전체</option>
				<option value="N">답변대기</option>
				<option value="Y">답변완료</option>
			</select>
			<!--<div class="br__sort__date br__myInquiry__date">-->
				<!--<input type="date" id="devSelectStartDate" placeholder="YYMMDD">-->
				<!--<span class="hyphen">-</span>-->
				<!--<input type="date" id="devSelectEndDate" placeholder="YYMMDD">-->

				<!--<div class="search__btn" id="devSearch">조회하기</div>-->
			<!--</div>-- 
			<div class="br__sort__timeselect">
				<div class="br__sort__date">
					<input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devSelectStartDate">
					<span class="br__sort__date--hyphen">-하이픈</span>
					<input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devSelectEndDate">
				</div>
				<button class="br__sort__search" id="devSearch">조회하기</button>
			</div>
		</div>

		<div class="br__goods-view__tabs">
			<ul class="goods-qna__list list" id="devMyGoodsContent">
				<li id="devMyGoodsLoading">
					<p class="qna-no-data">Loading...</p>
				</li>
				<li class="empty-content devForbizTpl" id="devMyGoodsEmpty">
					<p class="qna-no-data">문의 내역이 없습니다.</p>
				</li>

				<li class="goods-qna__box devForbizTpl" id="devMyGoodsList">
					<a href="/mypage/myGoodsInquiryDetail/{[bbs_ix]}" class="qna-info">
						<div class="qna-info__info">
							{[#if isResponse ]}
							<span class="qna-info__state qna-info__state--point">답변완료</span>
							{[else]}
							<span class="qna-info__state">답변대기</span>
							{[/if]}
							<span class="qna-info__type">[{[div_name]}]</span>
							<span class="qna-info__date">[{[regdate]}]</span>
						</div>
						<p class="qna-info__title">{[bbs_subject]}</p>
					</a>
				</li>
			</ul>
		</div>

		<div id="devPageWrap"></div>
	</form>
</section>
-->