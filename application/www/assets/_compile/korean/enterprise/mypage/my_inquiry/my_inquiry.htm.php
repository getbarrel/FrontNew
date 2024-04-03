<?php /* Template_ 2.2.8 2024/03/19 15:05:14 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_inquiry/my_inquiry.htm 000004149 */ ?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">

<!-- 컨텐츠 S -->
<section class="fb__mypage fb__mypage-board">
	<div class="fb__mypage-title">
		<div class="title-md">1:1 문의</div>
	</div>
	<section class="fb__mypage__search">
		<form id="devMyInquiryForm">
		<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
		<input type="hidden" name="page" id="devPage" value="1"/>
		<input type="hidden" name="max" id="devMax" value="1"/>
		<input type="hidden" name="mypageQnaYn" id="mypageQnaYn" value="Y"/>
		<input type="hidden" name="state" value="" id="state"/>
		<input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["oneMonth"]?>"/>
		<input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["today"]?>"/>
		<div class="search">
			<div class="fb-tab__nav">
				<ul>
					<li devFilterState="" class="active">
						<a href="#;">전체</a>
					</li>
					<li devFilterState="1">
						<a href="#;">답변대기</a>
					</li>
					<li devFilterState="5">
						<a href="#;">답변완료</a>
					</li>
				</ul>
			</div>
			<div class="search__row">
				<div class="search__col">
					<div class="fb__form-item">
						<label for="devSdate" class="hide">조회기간</label>
						<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
						<span>-</span>
						<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
						<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-dark-line">조회</button>
					</div>
				</div>
				<div class="search__col">
					<div class="search__day">
						<div class="day-radio">
							<a href="#;" class="day-radio__btn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근 <em>1</em>개월</a>
							<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>3</em>개월</a>
							<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
							<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</section>
	<!-- 주문 내역 - 리스트 S -->
	<section class="board-inquiry">
		<div class="board-inquiry__wrap">
			<ul class="board-inquiry__list devForbizTpl"  id="devMyInquiryContent">
				<li id="devMyInquiryLoading" class="board-inquiry__item no-data devForbizTpl">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </li>
				<li id="devMyInquiryEmpty" class="board-inquiry__item no-data devForbizTpl">
					<p class="empty-content">1:1 문의 내역이 없습니다.</p>
				</li>
				<li  id="devMyInquiryList" class="board-inquiry__item devForbizTpl">
					<a href="/mypage/myInquiryDetail/?bbs_ix={[bbs_ix]}" class="board-inquiry__link">
						<dl class="board-inquiry__group">
							<dt>
								<div class="day">{[reg_date]}</div>
								<div class="category">{[div_name]}</div>
							</dt>
							<dd>
								<div class="state {[#if complete_status ]} complete {[/if]}">{[qna_status]}</div>
								<div class="subject">{[short_subject]}</div>
							</dd>
						</dl>
					</a>
				</li>
			</ul>
			<div class="board-footer">
				<button type="button" class="btn-lg btn-dark-line" onClick="location.href='/customer/qna'">1:1 문의하기</button>
			</div>
		</div>
	</section>
	<!-- 주문 내역 - 리스트 E -->
</section>
<!-- 컨텐츠 E -->