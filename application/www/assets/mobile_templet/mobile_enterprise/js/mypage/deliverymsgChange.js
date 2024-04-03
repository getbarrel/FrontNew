"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(function(){
    $(document).on("change", ".devDeliveryMessageSelectBox", function(){
        var _value = $(this).val();
        var $directContents = $('.devDeliveryMessageDirectContents');
        var $textarea = $(".order-msg__request__textarea");
        if ( _value== "direct") {
            $textarea.val("");
            $directContents.show();
        } else {
            $textarea.val(_value);
            $directContents.hide();
        }
    });
});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devAddressBookRequestObj = {
    callbackSelect: false,
    initEvent: function () {
        var self = this;

        // 배송지 변경
        $('#devDeliveryMsgForm').on('click', '#devMsgSubmitBtn', function () {

            var oid = $('#oid').val();
            var isSuccess = true;
            $("textarea[name^='deliveryMsg']").each(function () {
                var msgIx = $(this).data('ix');
                var msgType = $(this).data('msgtype');
                var deliveryMsg = $(this).val();
                common.ajax(
                    common.util.getControllerUrl('deliveryMsgModify', 'mypage'),
                    {oId: oid, msgType: msgType, msgIx: msgIx, deliveryMsg: deliveryMsg},
                    '',
                    function (data) {
                        if (data.result == 'success') {
                            console.log(data);
                        } else {
                            isSuccess = false;
                            console.log(data);
                        }
                    }
                );
            });

            setTimeout(function () {
                if (isSuccess) {
                    document.location.href = '/mypage/orderDetail?oid=' + $('#oid').val();
                } else {
                    alert('메시지 수정에 실패했습니다.');
                }
            }, 1000)

        });

        // 취소
        $('#devMsgCancelBtn').on('click', function () {
            document.location.href = '/mypage/orderDetail?oid=' + $('#oid').val();
        });
    },
    run: function () {
        var self = this;
        self.initEvent();
    }
}
$(function () {
    console.clear();
    devAddressBookRequestObj.run()
});