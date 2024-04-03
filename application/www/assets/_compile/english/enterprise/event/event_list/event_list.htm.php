<?php /* Template_ 2.2.8 2020/08/31 15:57:08 /home/barrel-stage/application/www/assets/templet/enterprise/event/event_list/event_list.htm 000004036 */ 
$TPL_displayBanner_1=empty($TPL_VAR["displayBanner"])||!is_array($TPL_VAR["displayBanner"])?0:count($TPL_VAR["displayBanner"]);?>
<section class="fb__event-list">
    <h2 class="fb__main__title--hidden">EVENT</h2>
    <div class="event-list">
        <div>
            <div class="event-list__slider">
<?php if($TPL_VAR["displayBanner"]){?>
<?php if($TPL_displayBanner_1){foreach($TPL_VAR["displayBanner"] as $TPL_V1){?>
                <div class="event-list__item">
                    <img src="<?php echo $TPL_V1["banner_img"]?>">
                </div>
<?php }}?>
<?php }?>
            </div>
            <div class="list__banner__slider-nav slider-btn">
                <div class="slider-btn__box">
                    <div class="slider-btn__inner">
                        <a href="#" class="slider-btn__left slick-arrow" style="">
                            left
                        </a>
                        <a href="#" class="slider-btn__right slick-arrow" style="">
                            right
                        </a>
                        <div class="slider-btn__pageing">
                            <span class="slider-btn__paging--now">1</span><span class="slider-btn__paging--all">/ 2</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <section class="event-bbs">
        <form id="devEventForm">
            <input type="hidden" name="orderBy" value="startDate"/>
            <input type="hidden" name="orderByType" value="desc"/>
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="10" id="devMax"/>
            <input type="hidden" name="type" value="E" id="devType"/>
        </form>
        <h2 class="fb__main__title">EVENT</h2>
        <ul id="devEventContent" class="event-bbs__box">
            <li id="devEventLoading" class="devForbizTpl">
                <div class="wrap-loading">
                    <div class="loading"></div>
                </div>
            </li>

            <li id="devEventListEmpty" class="devForbizTpl">There are no registered events.</li>


            <li class="devForbizTpl event-bbs__list" id="devEventList">
                <a href="/event/eventDetail/{[event_ix]}">
                    <figure class="event-bbs__img">
                        {[#if onOff]}
                        <div class="event-bbs__inner">
                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[imgPath]}" alt="">
                        </div>
                        {[else]}
                        <div class="event-bbs__inner event-bbs__inner__end">
                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[imgPath]}" alt="">
                        </div>
                        {[/if]}
                    </figure>
                    <div class="event-bbs__info">
                        {[#if onOff]}
                        <p class="event-bbs__title">{[event_title]}</p>
                        <p class="event-bbs__date">
                            {[startDate]} - {[endDate]}
                            <span class="fb__event-detail__date__d-day">
                                D<em>{[dDay]}</em>
                            </span>
                        </p>
                        {[else]}
                        <p class="event-bbs__title event-bbs__title__end">{[event_title]}</p>
                        <p class="date event-bbs__end">
                            {[startDate]} - {[endDate]}
                        </p>
                        {[/if]}
                    </div>
                </a>
            </li>

        </ul>
        <div id="devPageWrap"></div>
    </section>
</section>