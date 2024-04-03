"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('product.qnaCancel.confirm', "상품 문의 작성을 취소하시겠습니까?"); //Confirm_01
common.lang.load('product.qnaSubmit.confirm', "상품 문의를 등록하시겠습니까?"); //Confirm_01

//-----set validation
common.validation.set($('#devQnaDiv'), {'required': true});
common.validation.set($('#devQnaSubject'), {'required': true});
common.validation.set($('#devQnaContents'), {'required': true});
common.validation.set($('#devEmailId,#devEmailHost'), {
    'required': true,
    'dataFormat': 'email',
    'getValueFunction': 'goodsQnaWrite.getEmail'
});

var goodsQnaWrite = {
    form: $('#devGoodsQnaFrom'),
    url: common.util.getControllerUrl('qnaWrite', 'product'),
    submitBool: false,
    getEmail: function () {
        return $('#devEmailId').val().trim() + '@' + $('#devEmailHost').val().trim();
    },
    getPid: function () {
        return $('#devPid').val();
    },
    run: function () {
        var self = this;
        var BeforeCallback = function ($form) {
            return true;
        };
        var SuccessCallback = function (response) {
            if (response.result == "success") {
               // document.location.href = '/shop/goodsView/' + self.getPid();
                document.location.reload();
            } else {
                common.noti.alert('error');
            }
        };

        common.form.init(self.form, self.url, BeforeCallback, SuccessCallback);

        $('#devSubmitBtn').on('click', function () {
            if (!common.validation.check(self.form, 'alert', false)) {
                return false;
            }

            if(common.noti.confirm(common.lang.get('product.qnaSubmit.confirm'))){
                self.form.submit();
            }
            return false;
        });

        $('#devCancelBtn').on('click', function () {
            common.noti.confirm(common.lang.get('product.qnaCancel.confirm'), function () {
                document.location.href = '/shop/goodsView/' + self.getPid();
            });
        });

        $('#devEmailHostSelect').on('change', function() {
            $('#devEmailHost').val(this.value);
        });

        $('#devDirectInputEmailCheckBox').click(function() {
            if($(this).is(":checked") == true) {
                $('#devEmailHost').val('');
                $('#devEmailHost').show();
                $('#devEmailHostSelect').hide();
            } else {
                $('#devEmailHost').hide();
                $('#devEmailHost').val($('#devEmailHostSelect').val());
                $('#devEmailHostSelect').show();
            }
        });
    }
}

$(function () {
    goodsQnaWrite.run();
});