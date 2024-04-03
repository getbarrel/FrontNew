<?php /* Template_ 2.2.8 2020/08/31 15:57:08 /home/barrel-stage/application/www/assets/templet/enterprise/event/promotion/promotion.htm 000004284 */ ?>
<section class="fb__exhibition-list">
    <h2 class="fb__main__title--hidden">이벤트1</h2>
    <div class="exhibition-list">
        <div>
            <div class="exhibition-list__slider slick-initialized slick-slider"><div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 0px; transform: translate3d(0px, 0px, 0px);"></div></div></div>
            <div class="list__banner__slider-nav slider-btn">
                <div class="slider-btn__box">
                    <div class="slider-btn__inner">
                        <a href="#" class="slider-btn__left slick-arrow slick-hidden" style="" aria-disabled="true" tabindex="-1">
                            left
                        </a>
                        <a href="#" class="slider-btn__right slick-arrow slick-hidden" style="" aria-disabled="true" tabindex="-1">
                            right
                        </a>
                        <div class="slider-btn__pageing">
                            <span class="slider-btn__paging--now">1</span><span class="slider-btn__paging--all">/ 0</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <section class="exhibition-bbs">
        <form id="devEventForm" action="/controller/event/getEventList">
            <input type="hidden" name="orderBy" value="startDate">
            <input type="hidden" name="orderByType" value="desc">
            <input type="hidden" name="page" value="1" id="devPage">
            <input type="hidden" name="max" value="10" id="devMax">
            <input type="hidden" name="type" value="P" id="devType">
            <input type="hidden" name="ForbizCsrfTestName" class="clsForbizCsrfId" value="07c885755827195e35805bacc87f7700"></form>
        <h2 class="fb__main__title">기획전</h2>
        <ul id="devEventContent" class="exhibition-bbs__box"><li class="exhibition-bbs__list">
            <a href="/event/eventDetail/16">
                <figure class="exhibition-bbs__img">
                    <div class="exhibition-bbs__inner">
                        <img src="/assets/templet/enterprise/images/common/loading.gif" data-src="" alt="세종기획전1">
                    </div>
                </figure>
                <div class="exhibition-bbs__info">
                    <p class="exhibition-bbs__title">
                        세종기획전1
                    </p>
                    <p class="exhibition-bbs__date">
                        2019-04-01 - 2020-01-31
                        <span class="fb__event-detail__date__d-day">
                                D<em>-252</em>
                            </span>
                    </p>
                </div>
            </a>
        </li><li class="exhibition-bbs__list">
            <a href="/event/eventDetail/15">
                <figure class="exhibition-bbs__img">

                    <div class="exhibition-bbs__inner exhibition-bbs__inner__end">
                        <img src="/assets/templet/enterprise/images/common/loading.gif" data-src="" alt="[0325] 모바일 이벤트/기획전 제목">
                    </div>
                </figure>
                <div class="exhibition-bbs__info">
                    <p class="exhibition-bbs__title exhibition-bbs__title__end">
                        [0325] 모바일 이벤트/기획전 제목
                    </p>
                    <p class="date exhibition-bbs__end">
                        2019-03-25 - 2019-03-25
                    </p>
                </div>
            </a>
        </li></ul>
        <div id="devPageWrap"><div class="wrap-pagination"><button class="first devPageBtnCls" data-page="1" disabled=""><i>paging first</i></button><button class="prev devPageBtnCls" data-page="1" disabled=""><i>under</i></button><a href="javascript:void(0)" class="devPageBtnCls on" data-page="1">1</a><button class="next devPageBtnCls" data-page="1" disabled=""><i>next</i></button><button class="last devPageBtnCls" data-page="1" disabled=""><i>paging last</i></button></div></div>
    </section>
</section>