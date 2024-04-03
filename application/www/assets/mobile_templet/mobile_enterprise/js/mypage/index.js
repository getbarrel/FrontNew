"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devObj = {
    eventInit: function () {
        // 주문조회
        $('.devOrderStatusCnt').on('click', function () {
            location.href = '/mypage/orderHistory?order_status=' + $(this).data('status');
        });
        // 취소/반품/교환 조회
        $('.devReturnStatusCnt').on('click', function () {
            location.href = '/mypage/returnHistory?order_status=' + $(this).data('status');
        });
    },
    run: function () {
        var self = this;

        self.eventInit();
    }
}

$(function () {
    devObj.run();
});

//window.addEventListener('load', function () {
//    cremaAsyncInit();
//});