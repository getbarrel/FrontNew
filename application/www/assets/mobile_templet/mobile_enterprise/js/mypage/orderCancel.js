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
    odIx: {},
    ccReason: {},
    ccReasonMsg: {},
    claimOnly:true,

    setOdix: function () {
        var self = this;
        var ccReason = "";
        var selectedCnt = 0;


        $(".devCancelArea").each(function () {
            var od_ix = $(this).val();

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
            // ***  취소 수량 input박스가 노출되면 취소 선택한 것으로 한다.
            //부분취소 오픈 처리 2020-01-08
            if ($("input[data-odix='" + od_ix + "']").is(":visible")) {
            //if ($("input[data-odix='" + od_ix + "']")) {
                // console.log($("input[data-odix='" + od_ix + "']").val());
                self.odIx[od_ix] = $("input[data-odix='" + od_ix + "']").val();
                ccReason = $(".devCcReason").filter(":visible").val();
                self.ccReason = ccReason;
                var ccReasonMsg = $("textarea[data-odix='" + od_ix + "']").filter(":visible").val();
                self.ccReasonMsg[od_ix] = ccReasonMsg;
                selectedCnt++;
            } else {
                self.odIx[od_ix] = 0;
            }
            */
        });


        if(self.odIx == "" || selectedCnt == 0 || self.ccReason == ""){

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
                    console.clear();
                     console.log(data.data);
                    if (data.result == 'success') {
                        var priceDatas = data.data;
                        var product = data.data.product;
                        var delivery = data.data.delivery;

                        if (priceDatas.length == 0) {

                            $('#devCancelProductPrice').html(0);
                            $('#devDeliveryDcPrice').html(0);
                            $('#devCancelTotalPrice').html(0);
                            $('#devCancelTotalReturnPrice').html(0);
                            $('#devCancelDeliveryReceivePrice').html(0);
                            return;

                        } else {

                            $('#devCancelProductPrice').html(common.util.numberFormat(product.product_dc_price)); // 취소할 상품 금액
                            $('#devDeliveryDcPrice').html(common.util.numberFormat(delivery.delivery_dc_price)); // 환불 예정 배송비
                            $('#devCancelTotalReturnPrice').html(common.util.numberFormat(priceDatas.price));     //환불 예정 금액

                            if (delivery.delivery_dc_price > 0) {
                                $('#devDeliveryDcPrice').html(common.util.numberFormat(delivery.delivery_dc_price)); // 환불 예정 배송비
                                $('#devCancelTotalPrice').html(common.util.numberFormat(priceDatas.price ));         // 취소할 상품 총 금액
                                $('#devCancelDeliveryReceivePrice').html(0);                                         //차감해야할 배송비
                            } else {
                                $('#devDeliveryDcPrice').html(0);                                                               // 환불 예정 배송비
                                $('#devCancelTotalPrice').html(common.util.numberFormat(product.product_dc_price));             // 취소할 상품 총 금액
                                $('#devCancelDeliveryReceivePrice').html(common.util.numberFormat(delivery.delivery_dc_price)); //차감해야할 배송비
                            }
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

            if($('#devOid').data('claimstatus') == 'IB'){
                var pcnt = $("input[data-odix='" + od_ix + "']").val();
            }else{
                var pcnt = $("input[data-odix='" + od_ix + "']").val();
            }

            var ccReason = $("select[name='cc_reason']").val();
            var ccReasonMsg = $("textarea[data-odix='" + od_ix + "']").filter(":visible").val();

            self.odIx[od_ix] = pcnt;                // 취소 수량
            self.ccReason = ccReason;               // 취소 사유코드
            self.ccReasonMsg[od_ix] = ccReasonMsg;  // 취소 내용
        });

        common.ajax(
            common.util.getControllerUrl('updateCancelStatus', 'mypage'),
            {
                oid: $('#devOid').data('oid'),
                odIxs: this.odIx,
                claimStatus: $('#devOid').data('claimstatus'),
                ccReason: self.ccReason,
                ccReasonMsg: self.ccReasonMsg,
                bankCode: $('#devBankCode').val(),
                bankOwner: $('#devBankOwner').val(),
                bankNumber: $('#devBankNumber').val()
            },
            // before
            function () {
                return common.noti.confirm(common.lang.get('mypage.apply.confirm', ''), '', function (){
                    self.claimOnly = true;
                });
            },
            // success
            function (data) {
                if (data.result == 'success') {
                    console.log(data.data);
                    common.noti.alert(common.lang.get('mypage.cancel.complete'), function () {
                        if(data.data.odixs){
                            document.location.href = '/mypage/orderCancelComplete/'+$('#devOid').data('oid')+'/'+data.data.odixs;
                        }else{
                            document.location.href = '/mypage/orderCancelComplete/'+$('#devOid').data('oid');
                        }
                    });
                }else {
                    alert(data.data);
                    location.href='/mypage';
                }
            }
        );
    },

    cntMinus: function (odix) {
        var self = this;

        $(".devPcnt").each(function () {
            if ($(this).data('odix') == odix) {
                var cnt = parseInt($(this).val()) - 1;
                if (cnt > 0) {
                    $(this).val(cnt);
                }
            }
        });

        self.setOdix();
    },

    cntPlus: function (odix) {
        var self = this;

        $(".devPcnt").each(function () {
            if ($(this).data('odix') == odix) {
                var ocnt = parseInt($(this).data('ocnt'));
                var cnt = parseInt($(this).val()) + 1;
                if (ocnt >= cnt) {
                    $(this).val(cnt);
                }
            }
        });

        self.setOdix();
    },


    setCancelCodeArea: function () {
        var self = this;
        var no = 0;
        var firstOdix = "";
        var lastOdix = "";
        var orderStatus = $("#devOid").data("status");

        $(".devCancelBoxOn").each(function () {
            lastOdix = $(this).data("odix");
            if($(this).is(":visible") && no == 0){
                firstOdix = $(this).data("odix");
                no++;
            }
        });

        // 입금 대기시 마지막 취소사유 선택/입력 노출
        if(orderStatus == "IR"){
            $(".devCancelCodeArea, .devCcMsg").each(function () {
                if($(this).data('odix') == lastOdix){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });

        // 그 외 첫번째 취소사유 선택, 각각 입력 노출
        }else{
            $(".devCancelCodeArea").each(function () {
                if($(this).data('odix') == firstOdix){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
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

        $("#devCancelItemSec1").show();
        $(".order-claim__disable").show();
        if($("li.devCancelBoxOff").filter(":visible").length == 0){
            $(".order-claim__disable").hide();
        }
        self.setCancelCodeArea();
    },

    calRefundAmount: function(){
        $(".devCancelBoxOn").filter(":visible").each(function () {
            var od_ix = $(this).data('odix');
            var pcnt = $("input[data-odix='" + od_ix + "']").filter(":visible").val();
            var cancel_code = $("select[data-odix='" + od_ix + "']").filter(":visible").val();
            var cancel_msg = $("textarea[data-odix='" + od_ix + "']").filter(":visible").val();
        });
    },

    initEvent: function () {
        var self = this;

        var orderStatus = $("#devOid").data("status");

        // *** 취소 수량 증가
        $('.devCntMinus').on('click', function () {
            if(orderStatus != 'IR') {
                self.cntMinus($(this).data('odix'));
            }
        });

        // *** 취소 수량 감소
        $('.devCntPlus').on('click', function () {
            if(orderStatus != 'IR') {
                self.cntPlus($(this).data('odix'));
            }
        });

        // *** 주문취소 신청/해제
        $(".order-claim__goods__toggle").on('click', function () {
            self.cancelBoxOnOff($(this).data('odix'));
        });


        // 취소사유, 취소수량  선택 이벤트
        $('.devCcReason').on('change', function () {
            var selectIdx = $(this).data('odix');
            var option = $(this).val();

            $(".devCcReason").each(function(){
                if($(this).data('odix') != selectIdx){
                    $(this).val(option);
                }
            });

            self.setOdix();
        });

        // 주문 선택 이벤트
        $('.devOdIxCls').on('click', function () {
            self.setOdix();
        });

        // 취소 상세 글자수 표시 이벤트
        $('#devCcMsg').on('keyup', function () {
            $('#devMsgLength').text($(this).val().length);
        });

        // 취소신청 취소
        $('#devClaimCancel').on('click', function () {
            document.location.href = '/mypage/orderHistory';
        });


        // *** 취소신청
        $('#devClaimApply').on('click', function () {

            var ckCodeCnt = $(".devCcReason").filter(":visible").length; // (노출된)신청 아이템 수
            var ckMsgCnt = $(".devCcMsg").filter(":visible").filter(function() { return $(this).val(); }).length; // 사유내용 입력 수
            var ckPass = true;

            // *** 취소 선택 아이템 없을시
            if(ckCodeCnt == 0){
                common.noti.alert(common.lang.get('mypage.cancel.noitem'));
                return false;
            }

            // *** 취소 사유 코드는 모두 필수
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
            if ($("#devRefundMethod").is(":visible") == true && ckPass) {
                if ($("#devBankCode").val() == '') {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankCode").focus();
                    return false;

                } else if ($("#devBankOwner").val() == '' && ckPass) {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankOwner").focus();
                    return false;

                } else if ($("#devBankNumber").val() == '' && ckPass) {
                    common.noti.alert(common.lang.get('mypage.refund.reson.alert'));
                    $("#devBankNumber").focus();
                    return false;
                }
            }

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
        // 취소사유 UI
        self.setCancelCodeArea();
    }
};

$(function () {
    devOrderCancel.run();
});