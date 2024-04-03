"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
var curPage = $('.review-detail-img').find('div.swiper-slide.curpage').index();

$(function () {
    var imgLayerSwiper = new Swiper('.review-detail-img .swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
        },
        initialSlide : curPage
    });

    $('.back').on('click', function () {
        parent.history.back(-1);
        return false;
    });
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
