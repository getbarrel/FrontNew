"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/


var orderList = {
    orderListAjax: false,
    init: function (){
        var self = this;
        self.orderListAjax = common.ajaxList();
        self.orderListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('tr')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(false)
            .setRemoveContent(false)
            .setController('getOrderList', 'order')
            .init(function (response) {
                self.orderListAjax.setContent(response.data.list, response.data.paging);
                popupCenter();
                // lazyload();//퍼블 레이지로드 삽입

            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.orderListAjax.getPage($(this).data('page'));
        });





    },
    initEvent: function (){
        var self = this;

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();

        popupCenter();
    }
}

$(function(){
    orderList.run();
});