"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devRefundAccountObj = {
    formTpl: false,
    ajaxList: common.ajaxList(),
    initLang: function () {
        //-----load language
        common.lang.load('refund.account.delete.confirm', "환불계좌를 삭제하시겠습니까?");
        common.lang.load('refund.account.replace.success', '환불 계좌가 정상적으로 등록되었습니다.');
    },
    initEvent: function () {
        var self = this;

        //-----set input format
        common.inputFormat.set($('#devBankNumber'), {'number': true, 'maxLength': 40});
        
        // 변경 버튼 이벤트
        $('#devRefundAccountForm').on('click', '#devRefundAccountItemModify', function () {
            self.ajaxList.removeContent();
            $(self.ajaxList.container).append(self.formTpl);
            $('#devRefundAccountModifyCancel').show();
            $('#devBankCode').val($(this).data('bankcode'));
            $('#devBankOwner').val($(this).data('bankowner'));
            $('#devRefundAccountItemSave').data('bankix', $(this).data('bankix'));
        });

        // 저장 버튼 이벤트
        $('#devRefundAccountForm').on('click', '#devRefundAccountItemSave', function () {
            common.ajax(
                    common.util.getControllerUrl('replaceRefundAccount', 'mypage'),
                    {
                        bank_ix: $(this).data('bankix'),
                        bank_code: $('#devBankCode').val(),
                        bank_owner: $('#devBankOwner').val(),
                        bank_number: $('#devBankNumber').val()
                    },
                    function () {
                        //-----set validation
                        common.validation.set($('#devBankCode,#devBankOwner,#devBankNumber'), {'required': true});
                        // Check Validation
                        return common.validation.check($('#devRefundAccountForm'), 'alert', false);
                    },
                    function (data) {
                        if (data.result == 'success') {
                            common.noti.alert(common.lang.get('refund.account.replace.success'));
                            self.ajaxList.reload();
                        }
                    }
            );
        });
        $(document).on({
            'input change': function (e) {

                if (!(e.keyCode >=37 && e.keyCode<=40)) {
                    var v = $(this).val();
                    $(this).val(v.replace(/[^a-z0-9.]/gi,''));
                }

                if (isEmailDoubleCheck == true) {
                    $('#devUserIdDoubleCheckButton').attr('disabled', false);
                }
                isEmailRegExp = false;
                isEmailDoubleCheck = false;

                if (common.validation.check($(this))) {

                    isEmailRegExp = true;
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.email.doubleCheck'));
                }

            }
        },'#devBankNumber');

        // 변경 취소 이벤트
        $('#devRefundAccountForm').on('click', '#devRefundAccountModifyCancel', function () {
            self.ajaxList.reload();
        });

        // 삭제 버튼 이벤트
        $('#devRefundAccountForm').on('click', '#devRefundAccountItemDelete', function () {
            if (confirm(common.lang.get('refund.account.delete.confirm'))) {
                common.ajax(
                        common.util.getControllerUrl('removeRefundAccount', 'mypage'),
                        {bank_ix: $(this).data('bankix')},
                        function () {
                            return true;
                        },
                        function (data) {
                            $('#devRefundAccountModifyCancel').hide();
                            $('#devRefundAccountItemSave').data('bankix', '');
                            self.ajaxList.reload();
                        }
                );
            }
        });
    },
    initAjaxList: function () {
        var self = this;
        
        self.formTpl = self.ajaxList.compileTpl('#devRefundAccountReplaceForm')
        
        // 환불계좌 리스트
        self.ajaxList
                .setLoadingTpl('#devRefundAccountLoading')
                .setListTpl('#devRefundAccountList')
                .setEmptyTpl(self.formTpl)
                .setContainerType('table')
                .setContainer('#devRefundAccountContent')
                .setForm('#devRefundAccountForm')
                .setUseHash(false)
                .setController('refundAccount', 'mypage')
                .init(function (data) {
                    self.ajaxList.setContent(data.data.list, data.data.paging);
                });
    },
    run: function () {
        var self = this;
        
        self.initLang();
        self.initEvent();
        self.initAjaxList();
    }
};

$(function () {
    devRefundAccountObj.run();
});