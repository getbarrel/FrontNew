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
var devAddressBookPopObj = {
    callbackSelect: false,
    addressBookList: common.ajaxList(),
    clsoeWindow: function () {
        $('.popup-layout .close').trigger('click');
    },
    initLang: function () {
        common.lang.load('addressbook.popup.add.title', '배송지 추가');
    },
    initAjaxList: function () {
        var self = this;

        // 배송지 리스트 설정
        self.addressBookList
            .setRemoveContent(false)
            .setLoadingTpl('#devAddressBooKLoading')
            .setListTpl('#devAddressBooKList')
            .setEmptyTpl('#devAddressBooKEmpty')
            .setContainerType('ul')
            .setContainer('#devAddressBooKContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devAddressBookForm')
            .setUseHash(false)
            .setController('addressBook', 'mypage')
            .init(function (data) {
                self.addressBookList.setContent(data.data.list, data.data.paging);
                popupCenter();
            });
    },
    initGuestEvent: function () {
        var self = this;

        //-----set input format
        common.inputFormat.set($('#devRecipient'), {'maxLength': 20});
        common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});

        //-----set validation
        common.validation.set($('#devRecipient,#devZip,#devAddress1,#devAddress2,#devPcs1,#devPcs2,#devPcs3'), {'required': true});

        //주소 찾기
        $('#devZipPopupButton').on('click', function () {
            common.util.zipcode.popup(function (response) {
                $('#devZip').val(response.zipcode);
                $('#devAddress1').val(response.address1);
            });
        });

        // 배송지 변경
        $('#devAddressBookPopSaveBtn').on('click', function () {
            var chk = common.validation.check($('#devGuestAddressBookForm'), 'alert', false);
            var oid = $(this).data('oid');
            if (chk) {

                var deliveryInfo = {
                    'recipient' : $('#devRecipient').val(),
                    'pcs1' : $('#devPcs1').val(),
                    'pcs2' : $('#devPcs2').val(),
                    'pcs3' : $('#devPcs3').val(),
                    'zip' : $('#devZip').val(),
                    'addr1' : $('#devAddress1').val(),
                    'addr2' : $('#devAddress2').val(),
                    'tel1' : $('#devTel1').val(),
                    'tel2' : $('#devTel2').val(),
                    'tel3' : $('#devTel3').val(),

                };

                $('#devDeliveryInfo').val(JSON.stringify(deliveryInfo));

                self.addressBookList
                    .setForm('#devGuestAddressBookForm')
                    .setUseHash(false)
                    .setController('deliveryAddressChange', 'mypage')
                    .init(function (data) {
                        if(data.result == 'success') {
                            location.href = "/mypage/orderDetail?oid=" + oid;
                        }else {
                            alert('배송지 변경에 실패하였습니다.');
                        }
                    });
            }
        });

        // 창닫기 버튼
        $('#devAddressBookPopColseBtn').on('click', function () {
            location.href = "/mypage/orderDetail?oid="+$(this).data('oid');
        });

    },
    run: function () {
        var self = this;

        self.initLang();
        self.initAjaxList();
        self.initGuestEvent();
    }
}
$(function () {
    devAddressBookPopObj.run();
});