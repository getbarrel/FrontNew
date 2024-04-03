"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var goodsList = {
    goodsListAjax: false,
    init: function () {
        var self = this;
        self.goodsListAjax = common.ajaxList();
        self.goodsListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getGoodsList', 'product')
            .init(function (response) {
                self.goodsListAjax.setContent(response.data.list, response.data.paging);
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.goodsListAjax.getPage($(this).data('page'));
        });
    }
}

$(function () {
    goodsList.init();
});