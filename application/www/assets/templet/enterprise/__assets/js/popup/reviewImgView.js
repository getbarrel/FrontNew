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
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        initialSlide : curPage
    });
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/