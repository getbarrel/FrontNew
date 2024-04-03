<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_goods_inquiry/my_goods_inquiry.htm 000003069 */ ?>
<section class="br__mypage br__myInquiry">
	<div class="br__mypage__pass">
		<p class="pass-title">Customer Q&A</p>
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
				<option value="" disabled selected>Period</option>
				<option value="1">1 month</option>
				<option value="3">3 months</option>
				<option value="6">6 months</option>
				<option value="12">1 year</option>
				<option value="timeSelect" class="op__date--set">Setting period</option>
			</select>
			<select id="devStateSelect">
				<option value="" disabled selected>Overall Progress</option>
				<option value="">All</option>
				<option value="N">Pending</option>
				<option value="Y">Completed</option>
			</select>
			<!--<div class="br__sort__date br__myInquiry__date">-->
				<!--<input type="date" id="devSelectStartDate" placeholder="YYMMDD">-->
				<!--<span class="hyphen">-</span>-->
				<!--<input type="date" id="devSelectEndDate" placeholder="YYMMDD">-->

				<!--<div class="search__btn" id="devSearch">Inquiry</div>-->
			<!--</div>-->
			<div class="br__sort__timeselect">
				<div class="br__sort__date">
					<input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devSelectStartDate">
					<span class="br__sort__date--hyphen">-hyphen</span>
					<input type="date" placeholder="YYMMDD" onchange="this.className=(this.value!=''?'has-value':'')" id="devSelectEndDate">
				</div>
				<button class="br__sort__search" id="devSearch">Inquiry</button>
			</div>
		</div>

		<div class="br__goods-view__tabs">
			<ul class="goods-qna__list list" id="devMyGoodsContent">
				<li id="devMyGoodsLoading">
					<p class="qna-no-data">Loading...</p>
				</li>
				<li class="empty-content devForbizTpl" id="devMyGoodsEmpty">
					<p class="qna-no-data">No inquiry history</p>
				</li>

				<li class="goods-qna__box devForbizTpl" id="devMyGoodsList">
					<a href="/mypage/myGoodsInquiryDetail/{[bbs_ix]}" class="qna-info">
						<div class="qna-info__info">
							{[#if isResponse ]}
							<span class="qna-info__state qna-info__state--point">Completed</span>
							{[else]}
							<span class="qna-info__state">Pending</span>
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