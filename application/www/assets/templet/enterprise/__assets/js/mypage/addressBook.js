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
var devAddressBookObj = {
    addressBookList: common.ajaxList(),
    initLang: function () {
        common.lang.load('addressbook.delete.confirm', '해당 배송지를 목록에서 삭제하시겠습니까?');
        common.lang.load('addressbook.popup.add.title', '배송지 추가');
        common.lang.load('addressbook.popup.modify.title', '배송지 수정');
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
                self.addressBookList.setContent(data.data.list, data.data.paging);
            });
    },
    initEvent: function () {
        var self = this;

        // 페이징 버튼 이벤트 설정
        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            self.addressBookList.getPage($(this).data('page'));
        });

        // 배송지 추가 버튼 이벤트
        $('.btn-add-pop').on('click', function () {
            var popWindow = common.util.popup('/mypage/addressbookManage', 580, 700, common.lang.get('addressbook.popup.add.title'));
            $(popWindow).on('load', function () {
                popWindow.devAddressBookAddPopObj.callbackAdd = function () {
                    self.addressBookList.getPage(1);
                };
            });
        });

        // 배송지 수정 버튼 이벤트
        $('#devAddressBooKContent').on('click', '.devAddressBookModify', function () {
            var popWindow = common.util.popup('/mypage/addressbookManage/' + $(this).data('ix'), 580, 700, common.lang.get('addressbook.popup.modify.title'));
            $(popWindow).on('load', function () {
                popWindow.devAddressBookAddPopObj.callbackUpdate = function () {
                    self.addressBookList.reload();
                };
            });
        });

        // 배송지 삭제
        $('#devAddressBooKContent').on('click', '.devAddressBookDelete', function () {
            if (confirm(common.lang.get('addressbook.delete.confirm'))) {
                common.ajax(
                    common.util.getControllerUrl('adreessBookDelete', 'mypage'),
                    {ix: $(this).data('ix')},
                    '',
                    function (data) {
                        if (data.result == 'success') {
                            self.addressBookList.reload();
                        } else {
                            console.log(data);
                        }
                    }
                );
            }
        });
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initAjaxList();
        self.initEvent();
    }
}

// reload function
function cbReload() {
    devAddressBookObj.addressBookList.reload();
}


$(function () {
    devAddressBookObj.run();
});