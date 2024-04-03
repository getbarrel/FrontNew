<?php /* Template_ 2.2.8 2024/03/20 23:10:45 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_goods_inquiry/my_goods_inquiry.htm 000004042 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__mypage-board">
	<div class="fb__mypage-title">
		<div class="title-md">상품 Q&A</div>
	</div>
	<section class="fb__mypage__search">
        <form id="devMyGoodsInquiryForm">
            <input type="hidden" name="type" value="mine"/>
            <input type="hidden" name="page" id="devPage" value="1"/>
            <input type="hidden" name="max" id="devMax" value="10"/>
			<input type="hidden" name="state" value="" id="state"/>
            <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
            <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />
			<div class="search">
				<div class="fb-tab__nav">
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
				<div class="search__row">
					<div class="search__col">
						<div class="fb__form-item">
							<label for="devSdate" class="hide">조회기간</label>
							<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간">
							<span>-</span>
							<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick" fb__form-input  title="조회종료기간">
							<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-dark-line">조회</button>
						</div>
					</div>
					<div class="search__col">
						<div class="search__day">
							<div class="day-radio">
								<a href="#"  class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근<em>1</em>개월</a>
								<a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근<em>3</em>개월</a>
								<a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근<em>6</em>개월</a>
								<a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근<em>12</em>년</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>

	<section class="board-inquiry">
		<div class="board-inquiry__wrap">
			<ul class="board-inquiry__list" id="devMyContent">
				<li class="board-inquiry__item" id="devMyLoading">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
				</li>
				
				<li class="board-inquiry__item devForbizTpl" id="devMyListEmpty">
					<p class="empty-content">상품 문의 내역이 없습니다.</p>
				</li>
			
				<li class="board-inquiry__item devForbizTpl {[#if isResponse ]} complete {[/if]}"  id="devMyList" devBbsIx="{[bbs_ix]}">
					<a href="/mypage/myGoodsInquiryDetail/{[bbs_ix]}" class="board-inquiry__link" >
						<dl class="board-inquiry__group">
							<dt>
								<div class="day">{[regdate]}</div>
								<div class="category">{[div_name]}</div>
							</dt>
							<dd>
								<div class="state  {[#if isResponse ]} complete {[/if]}">
									{[#if isResponse ]}
										답변 완료
									{[else]}
										답변 대기중
									{[/if]}
								
								</div>
								<div class="subject">{[bbs_subject]}</div>
							</dd>
						</dl>
					</a>
				</li>
			</ul>
		</div>
    <div id="devPageWrap"></div>
	</section>
</section>
<!-- 컨텐츠 E -->