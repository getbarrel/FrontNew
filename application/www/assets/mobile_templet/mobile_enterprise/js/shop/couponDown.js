"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

common.lang.load('coupon.download.fail', '쿠폰 다운로드에 실패하였습니다');
common.lang.load('coupon.download.success', '쿠폰이 정상적으로 다운로드 되었습니다.');

$(function () {
    $('.devCouponContents').on('click', '[devPublishIx]', function () {
        var self = $(this);
        var publishIx = $(this).attr('devPublishIx');
        common.ajax(common.util.getControllerUrl('downCoupon', 'product'), {publishIx: publishIx}, "", function (result) {
            if (result.result == 'success') {
                self.prop('disabled', true);
                self.html('다운로드 완료');
                common.noti.alert(common.lang.get('coupon.download.success'));
            } else {
                common.noti.alert(common.lang.get('coupon.download.fail'));
            }
        })
    });
});