"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(function () {
    $('.receipt-btn').click(function () {
        common.util.popup('/mypage/receiptPrint?oid=' + $(this).data('oid'), 660, 1000, '결제영수증',true);
    });
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devOrderDetailObj = {
    callback:function(deliveryIx, oId, deliveryInfo){this.deliveryAddressChange(deliveryIx, oId, deliveryInfo);},
    deliveryMsgModify: function () {
        var msgIx = $(this).data('msgix');
        var msgType = $(this).data('msgtype');
        var oId = $(this).data('oid');

        var msgText = $('#devDeliveryMsgText' + msgIx);
        var msgInput = $('#devDeliveryMsg' + msgIx);

        // Ajax Call
        common.ajax(
            common.util.getControllerUrl('deliveryMsgModify', 'mypage'),
            {
                oId: oId,
                msgIx: msgIx,
                msgType: msgType,
                deliveryMsg: msgInput.val()
            },
            function () {
                if (msgInput.val().length == 0) {
                    common.noti.alert('요청사항을 입력해 주세요.');
                    return false;

                }
                return true;
            },
            function (data) {
                if (data.result == 'success') {
                    msgText.text(data.data);
                    msgInput.val('');
                    $('#devMsgLength' + msgIx).text(0);
                } else {
                    alert(data.result);
                }
            }
        );
    },
    deliveryAddressChange: function (deliveryIx, oId, deliveryInfo) {
        common.ajax(
            common.util.getControllerUrl('deliveryAddressChange', 'mypage'),
            {
                oId: oId,
                deliveryIx: deliveryIx,
                deliveryInfo: deliveryInfo
            },
            function () {
                return oId && (deliveryIx || deliveryInfo);
            },
            function (ret) {
                if (ret.result == 'success') {
                    $('#devRnameTxt').text(ret.data.rname);
                    $('#devZipTxt').text(ret.data.zip);
                    $('#devAddr1Txt').text(ret.data.addr1);
                    $('#devAddr2Txt').text(ret.data.addr2);
                    $('#devRmobileTxt').text(ret.data.rmobile);
                    $('#devRtelTxt').text(ret.data.rtel);
                } else if (ret.result == 'differentPrice') {
                    common.noti.alert(common.lang.get('mypage.differentDeliveryPrice.alert'));
                } else {
                    common.noti.alert(common.lang.get('mypage.notExists.alert'));
                }
            }
        );
    },
    initLang: function () {
        common.lang.load('addressbook.popup.change.title', '배송지 변경');
        common.lang.load('mypage.differentDeliveryPrice.alert', "선택하신 지역은 배송정책이 다른 지역이므로 주문 전체 취소 후 재 주문해 주세요.");
        common.lang.load('mypage.notExists.alert', "배송지 선택이 잘못되었습니다.");
    },
    initEvent: function () {
        var self = this;

        // 배송 메시지 더보기 버튼
        $('#devDeliveryMsgMoreBtn').on('click', function () {
            $('.devDeliveryMsgBox').toggle();
        });

        // 배송 메시지 길이 표시
        $('.devDeliveryMsgInputBox').on('keyup', function () {
            var msgIx = $(this).data('msgix');
            $('#devMsgLength' + msgIx).text($(this).val().length);
        });

        // 배송 메시지 수정
        $('.devDeliveryMsgModifyBtn').on('click', self.deliveryMsgModify);

        $('#devDeliveryChangeBtn').click(function () {
            var height = orderDetailMode == 'guest' ? 620 : 520;
            var width = orderDetailMode == 'guest' ? 640 : 800;
            var popWinodw = common.util.popup('/mypage/addressbookSelect/' + $(this).data('oid'), width, height, common.lang.get('addressbook.popup.change.title'));
        });

        // 전체취소
        $('#devOrderDetailContent').on('click', '.devOrderCancelAllBtn', function () {
            location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
        });

    },
    run: function () {
        this.initLang();
        this.initEvent();
    }
};

function runCallback(deliveryIx, oId) {
    devOrderDetailObj.callback(deliveryIx, oId);
}

// Script run
$(function () {
    devOrderDetailObj.run();
});