<?php /* Template_ 2.2.8 2024/03/20 23:38:42 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_inquiry/my_inquiry.htm 000006680 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__myInquiry">
	<div class="page-title my-title">
		<div class="title-sm">1:1 문의</div>
	</div>
	<div class="br__myInquiry-wrap">
		<form id="devMyInquiryForm">
			<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
			<input type="hidden" name="page" id="devPage" value="1"/>
			<input type="hidden" name="max" id="devMax" value="1"/>
			<input type="hidden" name="mypageQnaYn" id="mypageQnaYn" value="Y"/>
			<input type="hidden" name="state" value="" id="state"/>
			<input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["oneMonth"]?>"/>
			<input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["today"]?>"/>
			<section class="br__myInquiry-search">
				<div class="search">
					<div class="br-tab__nav">
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
						<button type="button" title="조회" id="devBtnSearch" class="btn-lg btn-gray-line">조회</button>
					</div>
				</div>
			</section>
		</form>
			<!-- 주문 내역 - 리스트 S -->
			<section class="board-inquiry">
				<div class="board-inquiry__wrap">
					<ul class="board-inquiry__list" id="devMyInquiryContent">
						<li class="board-inquiry__item no-data devForbizTpl" id="devMyInquiryLoading">
							<div class="wrap-loading"><div class="loading"></div></div>
						</li>
						<li class="board-inquiry__item no-data devForbizTpl" id="devMyInquiryEmpty">
							<p class="empty-content">1:1 문의 내역이 없습니다.</p>
						</li>

						<li class="board-inquiry__item devForbizTpl {[#if res_count]}complete{[/if]}"  id="devMyInquiryList">
							<a href="/mypage/myInquiryDetail/{[bbs_ix]}" class="board-inquiry__link">
								<dl class="board-inquiry__group">
									<dt>
										<div class="day">{[reg_date]}</div>
										<div class="category">{[div_name]}</div>
									</dt>
									<dd>
										<div class="state">{[qna_status]}</div>
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
		</form>
	</div>
</section>
<!-- 컨텐츠 E -->

<!-- 1:1 문의 list -- 
<section class="br__mypage br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">1:1 문의</p>
    </div>
    <form id="devMyInquiryForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="20"/>
        <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
        <input type="hidden" name="qType" value="" id="devQnaType"/>
        <div class="br__myInquiry__opt">
            <select id="devQnaType" class="devQnaTypeSelect">
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>-- 
                <option value="<?php echo $TPL_V1["div_ix"]?>"><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>-- 
            </select>
        </div>

        <div class="br__goods-view__tabs">
            <ul class="goods-qna__list list" id="devMyInquiryContent">
                <li id="devMyInquiryLoading">
                    <p class="qna-no-data">Loading...</p>
                </li>
                <li class="empty-content devForbizTpl" id="devMyInquiryEmpty">
                    <p class="qna-no-data">문의 내역이 없습니다.</p>
                </li>

                <li class="goods-qna__box devForbizTpl" id="devMyInquiryList">
                    <a href="/mypage/myInquiryDetail/{[bbs_ix]}" class="qna-info">
                        <div class="qna-info__info">
                            {[#if res_count]}
                            <span class="qna-info__state qna-info__state--point">{[qna_status]}</span>
                            {[else]}
                            <span class="qna-info__state">{[qna_status]}</span>
                            {[/if]}
                            <span class="qna-info__type">[{[div_name]}]</span>
                            <span class="qna-info__date">{[reg_date]}</span>
                        </div>
                        <p class="qna-info__title">{[bbs_subject]}</p>
                    </a>
                </li>
            </ul>
        </div>
        <div id="devPageWrap"></div>
        <div class="br__login__info">
            <div class="information__btn">
                <a href="/customer/qna" class="information__btn__nomem">
                    1:1 문의하기
                </a>
            </div>
        </div>
    </form>
</section>
<!-- EOD : 1:1 문의 list -->