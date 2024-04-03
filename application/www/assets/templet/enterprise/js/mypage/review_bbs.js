"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
var reviewSwiper = new Swiper('.review-img-area .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 20,
    pagination: {
        clickable: true,
    },
});

$(function(){
    // $('.read-link').click(function(){
    //     common.util.modal.open('ajax', '상품 후기 내역', '/shop/review_detail.php?mode=read');
    // });
    // $('.modify-link').click(function(){
    //     common.util.modal.open('ajax', '나의 후기 수정', '/shop/review_detail.php?mode=modify');
    //     //common.util.popup ('/shop/review_detail.php?mode=modify',  '나의 후기 수정', true);
    // });
    // $('.detail-link').click(function(){
    //     common.util.modal.open('ajax', '', '/popup/img_view.php');
    // });
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
