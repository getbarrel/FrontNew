"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('mypage.cancel.confirm', "취소 신청을 취소하시겠습니까?");
common.lang.load('mypage.apply.confirm', "취소 신청하시겠습니까?");
common.lang.load('mypage.cancel.reson', "취소사유를 입력해 주세요.");
common.lang.load('mypage.refund.reson.alert', "환불정보를 입력해 주세요.");
common.lang.load('mypage.cancel.complete', "취소 신청 완료 되었습니다.");
common.lang.load('mypage.cancel.select', "취소 사유를 선택하세요.");

var devOrderCancel = {
    odIx: {},
    setOdix: function () {
        var self = this;
        var ccReason = $('#devCcReason').val();

        $(".devOdIxCls").each(function () {
            var od_ix = $(this).val();

            if ($('#devOdIx' + od_ix).is(':checked')) {
                self.odIx[od_ix] = $('#devCancelCnt' + od_ix).val();
            } else {
                self.odIx[od_ix] = 0;
            }
        });

        common.ajax(
            common.util.getControllerUrl('claimConfirm', 'mypage'),
            {
                oid: $('#devOid').data('oid'),
                status: $('#devOid').data('status'),
                claimStatus: $('#devOid').data('claimstatus'),
                odIx: this.odIx,
                ccReason: ccReason
            },
            function () {
                return true;
            },
            function (data) {
                if (data.result == 'success') {
                    var priceDatas = data.data;
                    var product = data.data.product;
                    var delivery = data.data.delivery;

                    if (priceDatas.length == 0) {
                        $('.devCancelPriceContents').find('em').html(0);
                        return;
                    } else {
                        $('#devCancelTotalPrice').html(common.util.numberFormat(product.product_dc_price + delivery.delivery_dc_price)); //상품 총 금액
                        $('#devCancelProductPrice').html(common.util.numberFormat(product.product_dc_price)); //총 금액
                        $('#devCancelDcPrice').html(common.util.numberFormat(product.dc_price + product.change_coupon_dcprice)); //총 할인금액
                        $('#devCancelSpecialDiscount').html(common.util.numberFormat(product.special_discount)); //즉시할인=특별할인
                        $('#devCancelPromotionDiscount').html(common.util.numberFormat(product.promotion_discount)); //특별할인
                        $('#devCancelCouponDiscount').html(common.util.numberFormat(product.change_coupon_dcprice)); //쿠폰할인

                        if (delivery.delivery_dc_price > 0) {
                            $('#devCancelDeliveryReceivePrice, #devCancelTotalReceivePrice').html(0); //차감해야할 배송비
                            $('#devCancelDeliveryReturnPrice').html(common.util.numberFormat(delivery.delivery_dc_price)); //고객이 환불받아야할 배송비
                        } else {
                            $('#devCancelDeliveryReceivePrice, #devCancelTotalReceivePrice').html(common.util.numberFormat(delivery.delivery_dc_price));//차감해야할 배송비
                            $('#devCancelDeliveryReturnPrice').html(0);//고객이 환불받아야할 배송비
                        }

                        $('#devCancelTotalReturnPrice').html(common.util.numberFormat(priceDatas.price)); //환불 예정 금액
                    }
                }
            }
        );
    },
    submitCancelApply: function () {
        var self = this;

        $(".devOdIxCls").each(function () {
            var od_ix = $(this).val();

            if ($('#devOdIx' + od_ix).is(':checked')) {
                self.odIx[od_ix] = $('#devCancelCnt' + od_ix).val();
            } else {
                self.odIx[od_ix] = 0;
            }
        });

        common.ajax(
            common.util.getControllerUrl('updateCancelStatus', 'mypage'),
            {
                oid: $('#devOid').data('oid'),
                odIxs: self.odIx,
                claimStatus: $('#devOid').data('claimstatus'),
                ccReason: $('#devCcReason').val(),
                ccReasonMsg: $('#devCcMsg').val(),
                bankCode: $('#devBankCode').val(),
                bankOwner: $('#devBankOwner').val(),
                bankNumber: $('#devBankNumber').val()
            },
            function () {

                if ($("select[name=cc_reason]").val() == '') {
                    common.noti.alert(common.lang.get('mypage.cancel.select'));
                    return false;
                }

                if ($('#devCcMsg').val() == '') {
                    common.noti.alert(common.lang.get('mypage.cancel.reson'));
                    return false;
                }

                return common.noti.confirm(common.lang.get('mypage.apply.confirm', ''));
            },
            function (data) {
                if (data.result == 'success') {
                    common.noti.alert(common.lang.get('mypage.cancel.complete'), function () {
                        document.location.href = '/mypage/returnHistory';
                    });
                }
            }
        );
    },
    initEvent: function () {
        var self = this;

        // 취소사유, 취소수량  선택 이벤트
        $('#devCcReason,.devCancelCntCls').on('change', function () {
            self.setOdix();
        });

        // 주문 선택 이벤트
        $('.devOdIxCls').on('click', function () {
            self.setOdix();
        });

        // 전체 주문 선택 이벤트
        $('#devOdIxAll').on('click', function () {
            if ($(this).is(':checked')) {
                $(".devOdIxCls").prop('checked', true);
                $(".devOdIxCls").attr('checked', true);
            } else {
                $(".devOdIxCls").prop('checked', false);
                $(".devOdIxCls").attr('checked', false);
            }

            self.setOdix();
        });

        // 취소신청 취소
        $('#devClaimCancel').on('click', function () {
            common.noti.confirm(common.lang.get('mypage.cancel.confirm', ''), function () {
                document.location.href = '/mypage/returnHistory';
            });
        });

        // 취소신청
        $('#devClaimApply').on('click', function () {

            if ($("select[name=cc_reason]").val() == '') {
                common.noti.alert(common.lang.get('mypage.cancel.select'));
                return false;
            }

            if ($('#devCcMsg').val() == '') {
                common.noti.alert(common.lang.get('mypage.cancel.reson'));
                return false;
            }

            // 계좌이체 결제는 제외
            if ($("#devRefundMethod").is(":visible") == true) {
                if ($("#devBankCode").val() == '') {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankCode").focus();
                    return false;
                } else if ($("#devBankOwner").val() == '') {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankOwner").focus();
                    return false;
                } else if ($("#devBankNumber").val() == '') {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankNumber").focus();
                    return false;
                }
            }

            // 취소신청
            self.submitCancelApply();
        });
    },
    run: function () {
        var self = this;

        // 이벤트
        self.initEvent();
        // 가격점검
        self.setOdix();
    }
};

$(function () {
    devOrderCancel.run();
});