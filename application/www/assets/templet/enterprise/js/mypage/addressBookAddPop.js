"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devAddressBookAddPopObj = {
    callbackUpdate: false,
    callbackAdd: false,
    addressBookform: $('#devAddressBookAddForm'),
    initForm: function () {
        var self = this;

        //-----set input format
        common.inputFormat.set($('#devRecipient,#devShippingName'), {'maxLength': 20});
        common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});

        //-----set validation
        common.validation.set($('#devRecipient,#devPcs1,#devPcs2,#devPcs3'), {'required': true});

        common.form.init(
                self.addressBookform,
                common.util.getControllerUrl('addressBookReplace', 'mypage'),
                function (formObj) {
                    var msg = common.lang.get('addressbook.add.confirm');
                    if(common.langType=='english'){
                        msg = 'Do you want to save your shipping address?';
                    }
                    if (common.validation.check(formObj, 'alert', false) && confirm(msg)) {
                        return true;
                    } else {
                        return false;
                    }
                },
                function (res) {
                    if (res.data.mode == 'update') {
                        self.callbackUpdate();
                    } else {
                        self.callbackAdd();
                    }
                    window.close();
                }
        );
    },
    initLang: function () {
        //-----load language
        common.lang.load('addressbook.add.cancel.confirm', '배송지 추가를 취소하시겠습니까?');
        common.lang.load('addressbook.modify.cancel.confirm', '배송지 수정을 취소하시겠습니까?');
        common.lang.load('addressbook.add.confirm', '배송지를 저장하시겠습니까?');
    },
    initEvent: function () {
        var self = this;
        // 배송지 저장
        $('#devAddressBookAddBtn').on('click', function () {
            self.addressBookform.submit();
        });

        // 배송지 창 닫기
        $('#devAddressBookAddCancelBtn').on('click', function () {
            var msg;

            if ($('#devMode').val() == 'insert') {
                msg = common.lang.get('addressbook.add.cancel.confirm');
                if(common.langType=='english'){
                    msg = 'Are you sure you want to cancel adding shipping destinations?';
                }
            } else {
                msg = common.lang.get('addressbook.modify.cancel.confirm');
                if(common.langType=='english'){
                    msg = 'Do you want to cancel the shipping edit?';
                }
            }

            if (confirm(msg)) {
                window.close();
            }
        });

        //주소 찾기
        $('#devZipPopupButton').on('click', function (e) {
            e.preventDefault();
            common.util.zipcode.popup(function (response) {
                $('#devZip').val(response.zipcode);
                $('#devAddress1').val(response.address1);
            });
        });
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initForm();
        self.initEvent();
    }
}

$(function () {
    devAddressBookAddPopObj.run();
});