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
        $('.popup-layout .close').trigger('click');
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
                    self.addressTotal = data.data.total;
                    self.addressBookList.setContent(data.data.list, data.data.paging);
                    popupCenter();
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

        self.callbackSelect(deliveryIx, oid);
        self.clsoeWindow();
    },
    initEvent: function () {
        var self = this;

        // 페이징 버튼 이벤트 설정
        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            self.addressBookList.getPage($(this).data('page'));
        });

        // 선택버튼 이벤트
        $('#devAddressBooKContent').on('click', '.devAddressBookItemSelect', function () {
            var oid = $(this).data('oid');
            var deliveryIx = $(this).data('ix');

            if(oid){
                self.chkAddressChange(oid, deliveryIx, '');
            }else {
                self.callbackSelect($(this).data('ix'), $(this).data('oid'));
                self.clsoeWindow();
            }
        });

        $('#devAddressBookAddBtn').on('click',function(){
            if(self.addressTotal < 10) {
                location.href='/mypage/addressbookManage?url='+$(location).attr('href');
            }else{
                common.noti.alert(common.lang.get('addressbook.totalOver.alert'));
            }
        });

    },
    selectGuestButtonEvent : function (oid, deliveryInfo) {
        var self = this;
        opener.runCallback(false, oid, deliveryInfo);
        self.clsoeWindow();
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initAjaxList();
        self.initEvent();
    }
}
$(function () {
    devAddressBookPopObj.run();
});