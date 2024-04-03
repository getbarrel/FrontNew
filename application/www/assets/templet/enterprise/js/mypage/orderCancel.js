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
common.lang.load('mypage.cancel.noitem', "주문취소 신청상품을 1개 이상 선택해 주세요");

var devOrderCancel = {
    odIx: {},       // 취소 선택된 상품
    ccReason: {},
    ccReasonMsg: {},
    claimOnly:true,

    setOdix: function () {
        var self = this;
        var ccReason = "";
        var selectedCnt = 0;

        $(".devCancelArea").each(function () {
            var od_ix = $(this).data('odix');
            var pcnt = $(this).data('pcnt');
            // ***  취소 수량 input박스가 노출되면 취소 선택한 것으로 한다.

            if ($(this).is(":visible")) {
                self.odIx[od_ix] = pcnt;
                ccReason = $(".devCcReason").filter(":visible").val();
                self.ccReason = ccReason;
                selectedCnt++;
            }else{
                self.odIx[od_ix] = 0;
            }

            /*
            if ($("select[name='pcnt[" + od_ix + "]']").length > 0) {
                self.odIx[od_ix] = $("select[name='pcnt[" + od_ix + "]']").val();
            } else if ($(".devPcnt[data-odix='" + od_ix + "']").length > 0) {
                self.odIx[od_ix] = $(".devPcnt[data-odix='" + od_ix + "']").text(); // 부분 취소 임시 중지 처리
            } else {
                self.odIx[od_ix] = 0;
            }
            */
        });

        if(self.odIx == "" || selectedCnt == 0 || self.ccReason == ''){

            $('#devCancelProductPrice').html(0);
            $('#devCancelTotalPrice').html(0);
            $('#devCancelTotalReturnPrice').html(0);
            $('#devCancelDeliveryReceivePrice').html(0);

        }else {

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
                    //  console.log(data.data);

                    if (data.result == 'success') {
                        var priceDatas = data.data;
                        var product = data.data.product;
                        var delivery = data.data.delivery;

                        if (priceDatas.length == 0) {
                            $('.devCancelPriceContents').find('em').html(0);
                            return;
                        } else {

                            $('#devCancelTotalPrice').html(product.product_dc_price); // 취소신청 총 결제금액
                            $('#devCancelProductPrice').html(product.product_dc_price); //총 금액
                            $('#devCancelDcPrice').html(product.dc_price + product.change_coupon_dcprice); //총 할인금액
                            $('#devCancelSpecialDiscount').html(product.special_discount); //즉시할인=특별할인
                            $('#devCancelPromotionDiscount').html(product.promotion_discount); //특별할인
                            $('#devCancelCouponDiscount').html(product.change_coupon_dcprice); //쿠폰할인
                            //alert(common.util.numberFormat(delivery.delivery_dc_price))
                            if (delivery.delivery_dc_price > 0) {
                                $('#devCancelDeliveryReceivePrice, #devCancelTotalReceivePrice').html(0); //차감해야할 배송비
                                $('#devCancelDeliveryReturnPrice').html(delivery.delivery_dc_price); //고객이 환불받아야할 배송비
                            } else {
                                $('#devCancelDeliveryReceivePrice, #devCancelTotalReceivePrice').html(Math.abs(delivery.delivery_dc_price));//차감해야할 배송비
                                $('#devCancelDeliveryReturnPrice').html(0);//고객이 환불받아야할 배송비
                            }

                            $('#devCancelTotalReturnPrice').html(common.util.numberFormat(priceDatas.price)); //환불 예정 금액
                        }
                    }
                }
            );


        }
    },
    submitCancelApply: function () {
        var self = this;

        $(".devCancelBoxOn").filter(":visible").each(function () {
            var od_ix = $(this).data('odix');

            if($('#devOid').data('claimstatus') == 'IB' || $('#devOid').data('claimstatus') == 'CC'){
                var pcnt = $(".devCancelCntCls[data-odix='" + od_ix + "']").filter(":visible").text();
            }else{
                var pcnt = $("select[data-odix='" + od_ix + "']").filter(":visible").val();
            }
console.log(pcnt);
            var ccReason = $("select[name='cc_reason']").val();
            var ccReasonText = $("select[name='cc_reason']:visible :selected").text();
            var ccReasonMsg = $("textarea[data-odix='" + od_ix + "']").filter(":visible").val();

            self.odIx[od_ix] = pcnt;                    // 취소 수량
            self.ccReason = ccReason;                   // 취소 사유코드
            self.ccReasonText = ccReasonText;           // 취소 사유 텍스트
            self.ccReasonMsg[od_ix] = ccReasonMsg;      // 취소 내용
        });


        common.ajax(
            common.util.getControllerUrl('updateCancelStatus', 'mypage'),
            {
                oid: $('#devOid').data('oid'),
                odIxs: self.odIx,
                claimStatus: $('#devOid').data('claimstatus'),
                ccReason: self.ccReason,
                ccReasonMsg: self.ccReasonMsg,
                ccReasonText: self.ccReasonText,
                bankCode: $('#devBankCode').val(),
                bankOwner: $('#devBankOwner').val(),
                bankNumber: $('#devBankNumber').val()
            },
            function () {
                return common.noti.confirm(common.lang.get('mypage.apply.confirm', ''), '', function (){
                    self.claimOnly = true;
                });
            },
            function (data) {
                if (data.result == 'success') {
                    common.noti.alert(common.lang.get('mypage.cancel.complete'), function () {
                        if(data.data.odixs){
                            document.location.href = '/mypage/orderCancelComplete/'+$('#devOid').data('oid')+'/'+data.data.odixs;
                        }else{
                            document.location.href = '/mypage/orderCancelComplete/'+$('#devOid').data('oid');
                        }
                        // document.location.href = '/mypage/returnHistory';
                    });
                }else {
                    alert(data.data);
                    location.href='/mypage';
                }
            }
        );
    },

    setCancelCodeArea: function () {
        var self = this;
        var firstOdix = "";
        var lastOdix = "";
        var orderStatus = $("#devOid").data("status");

        $(".devCancelBoxOn").each(function(){
            lastOdix = $(this).data("odix");
            if(firstOdix == ''){
                firstOdix = lastOdix;
            }
        });

        // *** 입금대기시, 마지막 '취소사유'만 노출
        if(orderStatus == 'IR') {

            $(".devCancelTr").each(function () {
                if ($(this).data("odix") == lastOdix) {
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
            $(".devCancelCodeArea").each(function () {
                if ($(this).data('odix') == lastOdix) {
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });

        // *** 노출된 아이템 중 첫 번째 취소사유만 노출
        }else {

            var firstOdix = ""; // 노출된 것중 첫번째 아이템
            $(".devCancelBoxOn").each(function () {
                var tmpIx = $(this).data("odix");
                if ($(this).is(":visible") && firstOdix == '') {
                    firstOdix = tmpIx;
                }
            });

            $(".devCancelCodeArea").each(function () {
                if ($(this).data('odix') == firstOdix) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }


        // *** 모두 취소 미선택했을 시
        if($(".devCancelBoxOn").filter(":visible").length == 0){
            $("#devArea1").show();
        }else{
            $("#devArea1").hide();
        }

        // *** 모두 취소 선택했을 시
        if($(".devCancelBoxOff").filter(":visible").length == 0){
            $("#devArea2").show();
        }else{
            $("#devArea2").hide();
        }

        self.setOdix();
    },

    cancelBoxOnOff: function (odix) {
        var self = this;

        $(".devCancelBoxOff").each(function () {
            if ($(this).data('odix') == odix) {
                $(this).toggle();
            }
        });
        $(".devCancelBoxOn").each(function () {
            if ($(this).data('odix') == odix) {
                $(this).toggle();
            }
        });
        $(".order-claim__disable").show();
        if($("li.devCancelBoxOff").filter(":visible").length == 0){
            $(".order-claim__disable").hide();
        }
        self.setCancelCodeArea();
    },

    initEvent: function () {
        var self = this;
        var orderStatus = $("#devOid").data("status");

        if(orderStatus == 'IR'){
            $(".devCancelCntCls").attr('disabled',true);
        }

        // *** 주문취소 신청/해제
        $(".devCancelMinus, .devCancelPlus").on('click', function () {

            var allselected = $("#devOid").data('allselected');
            if(orderStatus != 'IR' ) {
                self.cancelBoxOnOff($(this).data('odix'));
            }
        });

        // *** 취소 사유 변경
        $('.devCcReason').on('change', function () {
            var selectIdx = $(this).data('odix');
            var option = $(this).val();
            // 취소 사유 모두 동일하게 처리
            $(".devCcReason").each(function(){
                if($(this).data('odix') != selectIdx){
                    $(this).val(option);
                }
            });
            self.setOdix();
        });

        // *** 취소수량  변경
        $('.devCancelCntCls').on('change', function () {
            self.setOdix();
        });

        // *** 취소신청 취소
        $('#devClaimCancel').on('click', function () {
            common.noti.confirm(common.lang.get('mypage.cancel.confirm', ''), function () {
                document.location.href = '/mypage/orderHistory';
            });
        });

        // 취소신청
        $('#devClaimApply').on('click', function () {
            var ckCodeCnt = $(".devCcReason").filter(":visible").length; // (노출된)신청 아이템 수
            var ckMsgCnt = $(".devCcMsg").filter(":visible").filter(function() { return $(this).val(); }).length; // 사유내용 입력 수
            var ckPass = true;

            // *** 취소할 상품을 선택해주세요.
            if(ckCodeCnt == 0){
                common.noti.alert(common.lang.get('mypage.cancel.noitem'));
                return false;
            }

            // *** 취소 사유를 선택해주세요.
            $(".devCcReason").filter(":visible").each(function () {
                if ($(this).val() == '') {
                    ckPass = false;
                    common.noti.alert(common.lang.get('mypage.cancel.select'));
                    return false;
                }
            });

            // *** 취소 사유 입력은 1개 이상 입력 유도
            if(ckMsgCnt != $(".devCcMsg").filter(":visible").length && ckPass){
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
            if(ckPass && self.claimOnly) {
                self.claimOnly = false;
                self.submitCancelApply();
            }
        });
    },
    run: function () {
        var self = this;

        // 이벤트
        self.initEvent();
        // 가격점검
        self.setOdix();
        self.setCancelCodeArea();
    }
};

$(function () {
    devOrderCancel.run();
});