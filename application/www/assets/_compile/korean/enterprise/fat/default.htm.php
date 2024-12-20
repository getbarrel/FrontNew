<?php /* Template_ 2.2.8 2023/07/18 10:20:01 /home/barrel-stage/application/www/assets/templet/enterprise/fat/default.htm 000024936 */ ?>
<div id="fb__fat__wrapper" class="fb__fat">
    <div class="fat">
        <div class="fat__content">
            <header class="fat__header">
                <h2 class="fat__title">
                    상품별 통계 분석
                </h2>
                <a href="javascript:void(0);" class="fat__close">close</a>
            </header>
            <div class="fat__goods">
                <figure>
                    <img id="fat__content__goods__thumbnail" class="fat__content__goods__thumbnail" src="" alt="">
                </figure>
                <h3 id="fat__content__goods__title" class="fat__goods__title">
                    <!-- 우먼 네오프렌 후디 집업 자켓 -->
                </h3>
                <p class="fat__goods__option">
                    <!-- 브라이드 핑크 -->
                </p>
                <p id="fat__content__goods__price" class="fat__goods__price">
					<b id="fat__content__goods__price"></b>
					<!-- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo $TPL_VAR["fbUnit"]["b"]?> -->
				</p>
            </div>
            <div class="fat__tap">
                <ul class="tap">
                    <li>
                        <a href="javascript:void(0);" class="tap__list tap__list--active" data-active-type="orderByOption" data-type="orderByOption">
                            옵션별 주문 분석
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="tap__list" data-active-type="orderTracking" data-type="orderTracking">
                            주문/조회 분석
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="tap__list" data-active-type="orderPattern" data-type="orderPattern">
                            구매패턴 분석
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="tap__list" data-active-type="orderTogether" data-type="orderTogether">
                            함께 주문한 상품
                        </a>
					</li>
                </ul>
            </div>
            <div id="fat_order_by_option" class="fat__filter">
                <div class="filter">
                    <div class="filter__calendar">
                        <span class="filter__calendar__title">
                            분석기간
                        </span>
                        <div class="filter__calendar__input">
                            <input type="date" id="fat_order_by_option_start_date">
                        </div>
                        <span class="filter__calendar__gap">~</span>
                        <div class="filter__calendar__input ">
                            <input type="date" id="fat_order_by_option_end_date">
                        </div>
                    </div>
					<nav id="fat_order_by_option_date_btn_group" class="filter__btn">
						<input id="fat_order_by_option_date_today" class="rectangle-radio-input" type="radio" name="fat_order_by_option_date" value="today" checked/>
						<label for="fat_order_by_option_date_today" class="rectangle-radio-label">오늘</label>

						<input id="fat_order_by_option_date_yesterday" class="rectangle-radio-input" type="radio" name="fat_order_by_option_date" value="yesterday"/>
						<label for="fat_order_by_option_date_yesterday" class="rectangle-radio-label">어제</label>

						<input id="fat_order_by_option_date_week" class="rectangle-radio-input" type="radio" name="fat_order_by_option_date" value="week"/>
						<label for="fat_order_by_option_date_week" class="rectangle-radio-label">1주일</label>

						<input id="fat_order_by_option_date_halfmonth" class="rectangle-radio-input" type="radio" name="fat_order_by_option_date" value="halfmonth"/>
						<label for="fat_order_by_option_date_halfmonth" class="rectangle-radio-label">15일</label>

						<input id="fat_order_by_option_date_month" class="rectangle-radio-input" type="radio" name="fat_order_by_option_date" value="month"/>
						<label for="fat_order_by_option_date_month" class="rectangle-radio-label">1개월</label>
                    </nav>
                </div>
                <div id="fat__tab__filters__order__pattern__group" class="fat__fn__filter">
					<input id="fat_tab_filters_order_pattern_age" class="ellipse-radio-input" type="radio" name="fat_tab_filters_order_pattern" value="orderPatternAge" checked/>
					<label for="fat_tab_filters_order_pattern_age" class="ellipse-radio-label">성별+연령대별</label>
					<input id="fat_tab_filters_order_pattern_week" class="ellipse-radio-input" type="radio" name="fat_tab_filters_order_pattern" value="orderPatternWeek"/>
					<label for="fat_tab_filters_order_pattern_week" class="ellipse-radio-label">요일별</label>
					<input id="fat_tab_filters_order_pattern_time" class="ellipse-radio-input" type="radio" name="fat_tab_filters_order_pattern" value="orderPatternHour"/>
					<label for="fat_tab_filters_order_pattern_time" class="ellipse-radio-label">시간대별</label>
					<input id="fat_tab_filters_order_pattern_together" class="ellipse-radio-input" type="radio" name="fat_tab_filters_order_pattern" value="orderPatternPayment"/>
					<label for="fat_tab_filters_order_pattern_together" class="ellipse-radio-label">결제수단별</label>
                </div>
            </div>
            <div class="fat__option position__relative">
                <h4 id="fat__content__option__chart__title" class="fat__option__title">
                    옵션항목
				</h4>
				<div id="syn__content__order__tracking__type__area" class="syn__content__order__tracking__type__area position__absolute top--0 right--0 z-index--max display__none">
					<input id="order__tracking__type" type="checkbox">
					<label for="order__tracking__type" class="color__grey">상세항목 모두 확인</label>
				</div>
				<div id="fat__content__option__chart__wrapper" class="fat__option__content wrap-loading"><span class="loading"></span></div>
			</div>
			<div id="fat__content__option__sub__chart" class="fat__option display__none">
				<h4 id="fat__content__option__sub__chart__title" class="fat__option__title">
                    기간별 옵션 주문수
				</h4>
				<div id="fat__content__option__sub__chart__wrapper" class="fat__option__content wrap-loading"><span class="loading"></span></div>
			</div>
        </div>
        <div class="fat__bg"></div>
    </div>
</div>

<div id="fb__fat__excel__wrapper" class="fb__fat__excel">
    <div class="fat">
        <div class="fat__content">
            <header class="fat__header">
                <h2 class="fat__title">
                    엑셀 다운로드
                </h2>
                <a href="javascript:void(0);" class="fat__close">close</a>
            </header>
            <div class="fat__excel">
				<div class="filter">
					<nav class="filter__btn">
						<input id="fat__excel__date__today" class="rectangle-radio-input" type="radio" name="fat__excel__filter__date" value="today" checked/>
						<label for="fat__excel__date__today" class="rectangle-radio-label">오늘</label>
						<input id="fat__excel__date__yesterday" class="rectangle-radio-input" type="radio" name="fat__excel__filter__date" value="yesterday"/>
						<label for="fat__excel__date__yesterday" class="rectangle-radio-label">어제</label>
						<input id="fat__excel__date__week" class="rectangle-radio-input" type="radio" name="fat__excel__filter__date" value="week"/>
						<label for="fat__excel__date__week" class="rectangle-radio-label">1주일</label>
						<input id="fat__excel__date__halfmonth" class="rectangle-radio-input" type="radio" name="fat__excel__filter__date" value="halfmonth"/>
						<label for="fat__excel__date__halfmonth" class="rectangle-radio-label">15일</label>
						<input id="fat__excel__date__month" class="rectangle-radio-input" type="radio" name="fat__excel__filter__date" value="month"/>
						<label for="fat__excel__date__month" class="rectangle-radio-label">1개월</label>
					</nav>
				</div>
                <div class="filter__calendar">
                    <div class="filter__calendar__input">
						<input type="date" id="fat__excel__start__date">
                    </div>
                    <span class="filter__calendar__gap">~</span>
                    <div class="filter__calendar__input filter__calendar__input--end">
                        <input type="date" id="fat__excel__end__date" >
                    </div>
				</div>
				<div class="menu__btn">
					<button id="download__excel__period__btn" class="button__default bg__lightblue color__white button__loading__left">
						다운로드 하기
					</button>
				</div>
            </div>
        </div>
        <div class="fat__bg"></div>
    </div>
</div>
<div id="fb__fat__syn__wrapper" class="fb__fat__syn">
    <div class="fat">
        <div class="fat__content">
            <header class="fat__header">
                <h2 class="fat__title">
                    종합분석
                </h2>
                <a href="javascript:void(0);" class="fat__close">close</a>
            </header>
            <div class="syn">
                <nav class="syn__nav">
					<input id="syn_nav_today" class="bottom__line__radio__input" type="radio" name="syn_nav" value="orderToday" checked/>
					<label for="syn_nav_today" class="bottom__line__radio__label syn__nav__label">오늘주문 분석</label>
					<input id="syn_nav_order_pattern" class="bottom__line__radio__input" type="radio" name="syn_nav" value="orderPattern"/>
					<label for="syn_nav_order_pattern" class="bottom__line__radio__label syn__nav__label">구매패턴 분석</label>
					<input id="syn_nav_order_option" class="bottom__line__radio__input" type="radio" name="syn_nav" value="orderOption"/>
					<label for="syn_nav_order_option" class="bottom__line__radio__label syn__nav__label">구매옵션 분석</label>
                </nav>
                <div class="syn__content syn__today">
                    <div id="syn__content__today__wrapper" class="syn__option syn__content__wrapper syn__content__today__wrapper syn__option__today">
                        <div class="syn__today__search">
                            <div id="syn__today__summary__wrapper" class="syn__today__box syn__today__summary__wrapper display__flex"></div>
                        </div>
                        <div class="fat__option">
                            <h4 id="syn__today__chart__title" class="fat__option__title">
                                오늘 주문/조회 분석
							</h4>
							<div id="syn__today__chart__wrapper" class="fat__option__content syn__today__chart__wrapper wrap-loading"><span class="loading"></span></div>
							<div id="syn__content__today__table__wrapper" class="syn__content__today__table__wrapper wrap-loading"><span class="loading"></span></div>
                        </div>
                    </div>
                    <div id="syn__order__pattern__wrapper" class="syn__content__wrapper syn__option syn__option__order">
                        <div class="fat__filter">
                            <div class="filter">
                                <div class="filter__calendar">
                                    <span class="filter__calendar__title">
                                        분석기간
                                    </span>
                                    <div class="filter__calendar__input">
                                        <input type="date" id="syn__order__pattern__start__date">
                                    </div>
                                    <span class="filter__calendar__gap">~</span>
                                    <div class="filter__calendar__input ">
                                        <input type="date" id="syn__order__pattern__end__date">
                                    </div>
								</div>
								<nav class="filter__btn">
									<input id="syn__order__pattern__filter__date__today" class="rectangle-radio-input" type="radio" name="syn__order__pattern__filter__date" value="today" checked/>
									<label for="syn__order__pattern__filter__date__today" class="rectangle-radio-label">오늘</label>
									<input id="syn__order__pattern__filter__date__yesterday" class="rectangle-radio-input" type="radio" name="syn__order__pattern__filter__date" value="yesterday"/>
									<label for="syn__order__pattern__filter__date__yesterday" class="rectangle-radio-label">어제</label>
									<input id="syn__order__pattern__filter__date__week" class="rectangle-radio-input" type="radio" name="syn__order__pattern__filter__date" value="week"/>
									<label for="syn__order__pattern__filter__date__week" class="rectangle-radio-label">1주일</label>
									<input id="syn__order__pattern__filter__date__halfmonth" class="rectangle-radio-input" type="radio" name="syn__order__pattern__filter__date" value="halfmonth"/>
									<label for="syn__order__pattern__filter__date__halfmonth" class="rectangle-radio-label">15일</label>
									<input id="syn__order__pattern__filter__date__month" class="rectangle-radio-input" type="radio" name="syn__order__pattern__filter__date" value="month"/>
									<label for="syn__order__pattern__filter__date__month" class="rectangle-radio-label">1개월</label>
								</nav>
                            </div>
						</div>
                        <nav class="syn__order__filter">
							<input id="syn__order__pattern__deatil__filter__gender__age" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="ageAndSex" checked/>
							<label for="syn__order__pattern__deatil__filter__gender__age" class="ellipse-radio-label">성별+연령대별</label>
							<input id="syn__order__pattern__deatil__filter__gender" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="sex"/>
							<label for="syn__order__pattern__deatil__filter__gender" class="ellipse-radio-label">성별</label>
							<input id="syn__order__pattern__deatil__filter__age" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="age"/>
							<label for="syn__order__pattern__deatil__filter__age" class="ellipse-radio-label">연령대별</label>
							<input id="syn__order__pattern__deatil__filter__week" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="week"/>
							<label for="syn__order__pattern__deatil__filter__week" class="ellipse-radio-label">요일별</label>
							<input id="syn__order__pattern__deatil__filter__time" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="hour"/>
							<label for="syn__order__pattern__deatil__filter__time" class="ellipse-radio-label">시간대별</label>
							<input id="syn__order__pattern__deatil__filter__payment" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="payment"/>
							<label for="syn__order__pattern__deatil__filter__payment" class="ellipse-radio-label">결제수단별</label>
							<input id="syn__order__pattern__deatil__filter__device" class="ellipse-radio-input" type="radio" name="syn__order__pattern__deatil__filter" value="device"/>
							<label for="syn__order__pattern__deatil__filter__device" class="ellipse-radio-label">디바이스별</label>
                        </nav>
                        <div class="fat__syn__option fat__syn__option__order">
                            <h4 id="syn__order__pattern__chart__title" class="fat__option__title"></h4>
                            <div id="syn__order__pattern__chart__wrapper" class="syn__order__pattern__chart__wrapper fat__option__content wrap-loading" id="order_chart"><span class="loading"></span></div>
                            <div id="syn__order__target__goods__wrapper" class="syn__order__target__goods__wrapper syn__content__today__table__wrapper">

                        </div>
                        </div>
                    </div>
                    <div id="syn__order__option__wrapper" class="syn__content__wrapper syn__option syn__option__part fat__option">
                        <div class="fat__filter">
                            <div class="filter">
                                <div class="filter__calendar">
                                    <span class="filter__calendar__title">
                                        분석기간
                                    </span>
                                    <div class="filter__calendar__input">
                                        <input type="date" id="syn__order__option__start__date">
                                    </div>
                                    <span class="filter__calendar__gap">~</span>
                                    <div class="filter__calendar__input ">
                                        <input type="date" id="syn__order__option__end__date">
                                    </div>
                                </div>
                                <nav class="filter__btn">
									<input id="syn__order__option__filter__date__today" class="rectangle-radio-input" type="radio" name="syn__order__option__filter__date" value="today" checked/>
									<label for="syn__order__option__filter__date__today" class="rectangle-radio-label">오늘</label>
									<input id="syn__order__option__filter__date__yesterday" class="rectangle-radio-input" type="radio" name="syn__order__option__filter__date" value="yesterday"/>
									<label for="syn__order__option__filter__date__yesterday" class="rectangle-radio-label">어제</label>
									<input id="syn__order__option__filter__date__week" class="rectangle-radio-input" type="radio" name="syn__order__option__filter__date" value="week"/>
									<label for="syn__order__option__filter__date__week" class="rectangle-radio-label">1주일</label>
									<input id="syn__order__option__filter__date__halfmonth" class="rectangle-radio-input" type="radio" name="syn__order__option__filter__date" value="halfmonth"/>
									<label for="syn__order__option__filter__date__halfmonth" class="rectangle-radio-label">15일</label>
									<input id="syn__order__option__filter__date__month" class="rectangle-radio-input" type="radio" name="syn__order__option__filter__date" value="month"/>
									<label for="syn__order__option__filter__date__month" class="rectangle-radio-label">1개월</label>
                                </nav>
                            </div>
                            <div class="filter filter__category">
								<div class="width__full height__full display__flex flex__align__items__center">
									<div class="filter__calendar__title">
										카테고리
									</div>
									<div id="syn__order__option__categories__area" class="syn__order__option__categories__area filter__select loading__message"></div>
                                </div>
                            </div>
                            <div class="filter__btn__search">
                                <button id="syn__order__option__filter__select__button" disabled>조회</button>
                            </div>
                        </div>
                        <div class="fat__syn__orderaword">
                            카테고리를 선택해 주세요.
                        </div>
                        <div id="syn__order__option__result__wrapper" class="syn__order__option__result__wrapper fat__syn__orderOption"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fat__bg"></div>
    </div>
</div>

<article class="fb__fat__menu fat__menu">
    <section class="menu">
        <header class="menu__header">
            <h2 class="menu__title">
                FAT
            </h2>
            <a href="javascript:void(0);" class="menu__close">
                CLOSE
            </a>
            <div class="menu__is__inner">
                <label>
                    <input type="radio" name="fat_menu_filter_view_counting" value="on" checked>
                    <span>
                        ON
                    </span>
                </label>
                <label>
                    <input type="radio" name="fat_menu_filter_view_counting" value="off">
                    <span>
                        OFF
                    </span>
                </label>
            </div>
        </header>
        <section class="menu__day">
            <h3 class="menu__title">
                집계기간
            </h3>
            <nav id="fat_filter_date_btn_group" class="filter__btn">
				<input id="fat_side_filter_date_today" class="rectangle-radio-input" type="radio" name="fat_side_filter_date" value="today" checked/>
				<label for="fat_side_filter_date_today" class="rectangle-radio-label">오늘</label>

				<input id="fat_side_filter_date_yesterday" class="rectangle-radio-input" type="radio" name="fat_side_filter_date" value="yesterday"/>
				<label for="fat_side_filter_date_yesterday" class="rectangle-radio-label">어제</label>

				<input id="fat_side_filter_date_week" class="rectangle-radio-input" type="radio" name="fat_side_filter_date" value="week"/>
				<label for="fat_side_filter_date_week" class="rectangle-radio-label">1주일</label>

				<input id="fat_side_filter_date_halfmonth" class="rectangle-radio-input" type="radio" name="fat_side_filter_date" value="halfmonth"/>
				<label for="fat_side_filter_date_halfmonth" class="rectangle-radio-label">15일</label>

				<input id="fat_side_filter_date_month" class="rectangle-radio-input" type="radio" name="fat_side_filter_date" value="month"/>
				<label for="fat_side_filter_date_month" class="rectangle-radio-label">1개월</label>
            </nav>
            <div class="filter__calendar">
                <div class="filter__calendar__input">
                    <input type="date" id="fat_menu_filter_start_date">
                </div>
                <span class="filter__calendar__gap">~</span>
                <div class="filter__calendar__input filter__calendar__input--end">
                    <input type="date" id="fat_menu_filter_end_date">
                </div>
            </div>
        </section>
        <section class="menu__view">
            <h3 class="menu__title">
                집계 대상 화면
            </h3>
            <nav class="menu__view__munu">
				<!--
					TODO: 현재화면 개발 전까진 전체화면만 보이게
					현재화면 적용 되면 style 제거할 것
				-->
                <label class="menu__view__all">
                    <input type="radio" name="fat_menu_filter_counting_screen" value="all" checked>
                    <span>
                        전체화면
                    </span>
                </label>
                <label class="menu__view__now ">
                    <input type="radio" name="fat_menu_filter_counting_screen" value="current">
                    <span>
                        현재화면
                    </span>
                </label>
            </nav>
        </section>
        <section class="menu__system">
            <h3 class="menu__title">
                집계 보기 방식
            </h3>
            <nav class="menu__view__munu">
                <label class="menu__system__divide">
                    <input type="radio" name="fat_menu_filter_counting_system" value="division">
                    <span>
                         PC/MOBILE 구분
                    </span>
                </label>
                <label class="menu__system__all">
                    <input type="radio" name="fat_menu_filter_counting_system" value="total" checked>
                    <span>
                         PC/MOBILE 통합
                    </span>
                </label>
            </nav>
        </section>
        <div class="menu__btn">
            <button id="fat_filter_apply" class="menu__btn__tag button__loading__left" disabled>
                설정 적용하기
            </button>
        </div>
    </section>
    <nav class="menu__order">
        <button id="comprehensive_analysis_btn" class="button__default menu__order__all">
            종합분석
        </button>
		<button id="download__excel__btn" class="excel button__default">
			엑셀 다운로드
		</button>
    </nav>
    <a id="fat__side__open__button" class="fat__btn opacity--05" href="javascript:void(0);">
        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/btns/icon-fat.gif" alt="fat">
	</a>
</article>