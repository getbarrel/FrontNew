<?php /* Template_ 2.2.8 2020/08/31 15:56:57 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/event/event_list/event_list.htm 000001733 */ ?>
<h1 class="wrap-title">
    이벤트<i></i>
    <button class="back"></button>
</h1>

<div class="wrap_event">

    <form id="devEventForm">
        <input type="hidden" name="orderBy" value="startDate"/>
        <input type="hidden" name="orderByType" value="desc"/>
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="20" id="devMax"/>
    </form>

    <div class="event_list">
        <ul id="devEventContent">
            <li id="devEventLoading" class="devForbizTpl">
                <div class="wrap-loading">
                    <div class="loading"></div>
                </div>
            </li>

            <li id="devEventListEmpty" class="devForbizTpl">등록된 이벤트가 없습니다.</li>

            <li class="event_contents devForbizTpl" id="devEventList">
                <a href="/event/eventDetail/{[event_ix]}">
                    <img src="{[imgPath]}" alt="">
                    <div class="txt">
                        <p class="title">{[event_title]}</p>
                        {[#if onOff]}
                        <p class="date">{[startDate]} - {[endDate]}</p>
                        {[else]}
                        <p class="date end">이벤트 종료</p>
                        {[/if]}
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div id="devPageWrap"></div>
</div>


<style>
    .wrap-category nav{width:100%;}
    .wrap-category nav a{display:block; width:100%;text-align:center; line-height:24px;}
</style>