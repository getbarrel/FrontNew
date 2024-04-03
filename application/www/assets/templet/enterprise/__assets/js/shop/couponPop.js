"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('coupon.invalid.msg', "상품 금액 보다 쿠폰 적용 금액이 커서 쿠폰적용이 불가합니다.");

var devCouponPopObj = {
    getCouponInfoBySelect: function ($select) {
        var cartIx = $select.attr('devCouponSelect');
        var $checkedOption = $select.find('option:checked');
        var registIx = $checkedOption.val();
        var totalCouponWithDcprice = $checkedOption.attr('devTotalCouponWithDcprice');
        var discountAmount = $checkedOption.attr('devDiscountAmount');
        return {cartIx: cartIx, registIx: registIx, totalCouponWithDcprice: totalCouponWithDcprice, discountAmount: discountAmount}
    },
    changeCouponText: function (cartIx, totalCouponWithDcprice, discountAmount) {
        if (totalCouponWithDcprice >= 0) {
            $('[devTotalCouponWithDcpriceText="' + cartIx + '"]').text(common.util.numberFormat(totalCouponWithDcprice));
            $('[devDiscountAmountText="' + cartIx + '"]').text(common.util.numberFormat(discountAmount));
        } else {
            common.noti.alert(common.lang.get('coupon.invalid.msg'));
            $('select[devCouponSelect]').val('');
        }
    },
    run: function () {
        var self = this;
        //쿠폰 선택
        $('select[devCouponSelect]').change(function () {
            var data = self.getCouponInfoBySelect($(this));
            if (data.registIx > 0) {
                self.changeCouponText(data.cartIx, data.totalCouponWithDcprice, data.discountAmount);

                //다른 선택 사항 초기화
                $('select[devCouponSelect]:not([devCouponSelect="' + data.cartIx + '"]) option[value="' + data.registIx + '"]:checked').closest('select').each(function () {
                    $(this).val('');
                    var cartIx = $(this).attr('devCouponSelect');
                    self.changeCouponText(cartIx, 0, 0);
                });
            } else {
                self.changeCouponText(data.cartIx, 0, 0);
            }
        });

        //쿠폰 적용
        $('#devApplyCouponButton').click(function () {
            var useData = {};
            $('select[devCouponSelect]').each(function () {
                var data = self.getCouponInfoBySelect($(this));
                useData[data.cartIx] = data.registIx;
            });
            devInfoinputObj.setUseCouponData(useData);
            $('#devCouponCancelButton').trigger('click');
        });

        //취소
        $('#devCouponCancelButton').click(function () {
            $('.popup-layout .close').trigger('click');
        });
    }
}

$(function () {
    devCouponPopObj.run();
    $('select[devCouponSelect]').trigger('change');
});

