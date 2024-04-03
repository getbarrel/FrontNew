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
    addressTotal:0,
    addressBookList: common.ajaxList(),
    clsoeWindow: function () {
        top.window.close();
    },
    initLang: function () {
        common.lang.load('addressbook.popup.add.title', '배송지 추가');
        common.lang.load('addressbook.totalOver.alert', '최대 10개까지 등록 가능합니다.');
        common.lang.load('addressbook.notChange.alert', '현재 주문이 주소변경 불가능한 상태입니다.');

    },
    initAjaxList: function () {
        var self = this;

        // 배송지 리스트 설정
        self.addressBookList
            .setLoadingTpl('#devAddressBooKLoading')
            .setListTpl('#devAddressBooKList')
            .setEmptyTpl('#devAddressBooKEmpty')
            .setContainerType('table')
            .setContainer('#devAddressBooKContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devAddressBookForm')
            .setUseHash(true)
            .setController('addressBook', 'mypage')
            .init(function (data) {
                self.addressTotal = data.data.total;
                self.addressBookList.setContent(data.data.list, data.data.paging);
            });
    },
    chkAddressChange: function(oid, deliveryIx, deliveryInfo) {
        var self = this;

        common.ajax(
            common.util.getControllerUrl('checkAddressChange', 'mypage'),
            {
                'oid': oid,
                'deliveryIx' : deliveryIx,
                'deliveryInfo' : deliveryInfo
            },
            "",
            function(response) {
                if(response.data == 'OK') {
                    if(deliveryIx != '') {
                        self.selectButtonEvent(oid, deliveryIx);
                    }else {
                        self.selectGuestButtonEvent(oid,deliveryInfo);
                    }
                }else {
                    common.noti.alert(common.lang.get("addressbook.notChange.alert"));
                }
            }
        );
    },
    selectButtonEvent: function (oid, deliveryIx) {
        var self = this;

        if (self.callbackSelect) {
            self.callbackSelect(deliveryIx);
        } else {
            opener.runCallback(deliveryIx, oid, '');
        }
        self.clsoeWindow();
    },
    initMemberEvent: function () {
        var self = this;

        // 페이징 버튼 이벤트 설정
        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            self.addressBookList.getPage($(this).data('page'));
        });

        // 배송지 추가 버튼 이벤트
        $('#devAddressBookAddBtn').on('click', function () {
            if(self.addressTotal < 10) {
                var popWindow = common.util.popup('/mypage/addressbookManage', 600, 700, common.lang.get('addressbook.popup.add.title'), true);
                $(popWindow).on('load', function () {
                    popWindow.devAddressBookAddPopObj.callbackAdd = function () {
                        self.addressBookList.getPage(1);
                    };
                });
            }else{
                common.noti.alert(common.lang.get('addressbook.totalOver.alert'));
            }
        });

        // 선택버튼 이벤트
        $('#devAddressBooKContent').on('click', '.devAddressBookItemSelect', function () {
            var oid = $(this).data('oid');
            var deliveryIx = $(this).data('ix')
            if(oid){
                self.chkAddressChange(oid, deliveryIx, '');
            }else{
                if (self.callbackSelect) {
                    self.callbackSelect($(this).data('ix'));
                } else {
                    opener.runCallback($(this).data('ix'), $(this).data('oid'), '');
                }
                self.clsoeWindow();
            }

        });

        // 창닫기 버튼
        $('#devAddressBookPopColseBtn').on('click', function () {
            self.clsoeWindow();
        });
    },
    selectGuestButtonEvent : function (oid, deliveryInfo) {
        var self = this;
        opener.runCallback(false, oid, deliveryInfo);
        self.clsoeWindow();
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

            if (chk) {
                var oid = $(this).data('oid');
                var deliveryInfo = {
                    recipient: $('#devRecipient').val(),
                    zip: $('#devZip').val(),
                    addr1: $('#devAddress1').val(),
                    addr2: $('#devAddress2').val(),
                    pcs1: $('#devPcs1').val(),
                    pcs2: $('#devPcs2').val(),
                    pcs3: $('#devPcs3').val(),
                    tel1: $('#devTel1').val(),
                    tel2: $('#devTel2').val(),
                    tel3: $('#devTel3').val()
                };
                self.chkAddressChange(oid, '', deliveryInfo);
            }

        });

        // 창닫기 버튼
        $('#devAddressBookPopColseBtn').on('click', function () {
            self.clsoeWindow();
        });

    },
    run: function () {
        var self = this;

        if (addressPopMode == 'guest') {
            self.initGuestEvent();
        } else {
            self.initLang();
            self.initAjaxList();
            self.initMemberEvent();
        }
    }
}

function cbReload() {
    devAddressBookPopObj.addressBookList.reload();
}

$(function () {
    devAddressBookPopObj.run()
});