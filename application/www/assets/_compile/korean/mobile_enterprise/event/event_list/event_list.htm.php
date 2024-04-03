<?php /* Template_ 2.2.8 2024/03/22 10:58:28 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/event/event_list/event_list.htm 000005843 */ ?>
<style>
#outputDiv {
    white-space: pre-wrap; /* 공백 유지 */
}
</style>
<script>
// 텍스트 내용을 수정하는 함수
function modifyText() {
    var elements = document.querySelectorAll(".output-text"); // 모든 요소 선택
    elements.forEach(function(element) {
        var textContent = element.textContent.trim(); // 앞뒤 공백 제거
        var modifiedContent = textContent.replace(/\r?\n/g, "<br>"); // \r\n을 <br>로 변경
        element.innerHTML = modifiedContent; // 결과를 HTML로 반영
    });
}

// 페이지 로드 시 텍스트 수정 함수 호출
window.onload = modifyText;
</script>
<section id="container" class="br__layout">
    <form id="devEventForm">
        <input type="hidden" name="orderBy" value="display_start"/>
        <input type="hidden" name="orderByType" value="desc"/>
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="9" id="devMax"/>
        <input type="hidden" name="type" value="E" id="devType"/>
        <input type="hidden" name="state" value="<?php echo $TPL_VAR["state"]?>" id="state"/>
    </form>
    <!-- 컨텐츠 영역 S -->
    <section class="br__event-bbs">
        <section class="event-bbs">
            <div class="event-bbs__header">
                <div class="title-lg"><?php if($TPL_VAR["state"]=="I"){?>진행 중 이벤트<?php }elseif($TPL_VAR["state"]==""){?>진행 중 이벤트<?php }elseif($TPL_VAR["state"]=="E"){?>종료 이벤트<?php }elseif($TPL_VAR["state"]=="A"){?>전체 이벤트<?php }?></div>
                <div class="event-bbs__tab">
                    <div class="br-tab__slide swiper-container">
                        <ul class="swiper-wrapper">
                            <li class="swiper-slide <?php if($TPL_VAR["state"]=='I'||$TPL_VAR["state"]==''){?>active<?php }?>"><a href="/event/eventList/I">진행중</a></li>
                            <li class="swiper-slide <?php if($TPL_VAR["state"]=='E'){?>active<?php }?>"><a href="/event/eventList/E">종료</a></li>
                            <li class="swiper-slide <?php if($TPL_VAR["state"]=='A'){?>active<?php }?>"><a href="/event/eventList/A">전체</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="event-bbs__box" id="devEventContent">
                <!-- 등록된 게시글이 없을 경우 S -->
                <li class="event-bbs__list no-data" id="devEventListEmpty">
                    <p class="empty-content">등록된 이벤트가 없습니다.</p>
                </li>
                <!-- 등록된 게시글이 없을 경우 E -->

                <li id="devEventLoading" class="devForbizTpl">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </li>

                <li class="event-bbs__list" id="devEventList">
                    <!-- 이벤트 종료시 class = event-end-->
                    <div class="event-bbs__category" style="color:{[c_preface]};{[b_preface]}{[i_preface]}{[u_preface]}">{[onOff]}</div>
                    <!--<a href="/event/eventDetail/{[event_ix]}">-->
                    <a href="{[#if display_gubun]}/content/focusNow2/{[else]}/content/focusNow4/{[/if]}{[event_ix]}">
                        <div class="event-bbs__img-box">
                            <figure class="event-bbs__img">
                                <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[imgPath]}" alt="" />
                            </figure>
                        </div>
                    </a>
                    <div class="event-bbs__info">
                        <!-- 버튼으로 할 경우 S -->
                        <!-- 숨김처리 -->
                        <button type="button" class="btn-wishlist {[#if alreadyWishContent]}active{[/if]}" onclick="contentWish('{[event_ix]}', 'E', this)">
                            <!-- 선택시 button class = active 추가-->
                            <i class="ico ico-wishlist"></i>위시리스트
                        </button>
                        <!-- 버튼으로 할 경우 E -->

                        <!-- 체크 박스로 할 경우 S -->
                        <label class="event-bbs__wish" style="display: none">
                            <input type="checkbox" class="event-bbs__wish-btn" />
                        </label>
                        <!-- 체크 박스로 할 경우 E -->
                        <!--<a href="/event/eventDetail/{[event_ix]}">-->
                        <a href="{[#if display_gubun]}/content/focusNow2/{[else]}/content/focusNow4/{[/if]}{[event_ix]}">
                            <div class="event-bbs__title output-text" style="color:{[c_title]};{[s_title]}{[b_title]}{[i_title]}{[u_title]}">
                                {[event_title]}
                            </div>
                            <div class="event-bbs__title-sub output-text" style="margin-top:19px;white-space: pre-line;color:{[c_explanation]};{[b_explanation]}{[i_explanation]}{[u_explanation]}">
                                {[explanation]}
                            </div>
                            {[#if display_date_use]}
                            <div class="event-bbs__date">{[startDate]} - {[endDate]}</div>
                            {[/if]}
                        </a>
                    </div>
                </li>
            </ul>
            <div id="devPageWrap"></div>
        </section>
    </section>
    <!-- 컨텐츠 영역 E -->
</section>