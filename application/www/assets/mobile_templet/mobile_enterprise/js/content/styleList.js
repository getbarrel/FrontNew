"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devStyleObj = {
    ajaxEventList: common.ajaxList(),
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.ajaxEventList.getPage(pageNum);
        });
    },
    initAjaxEventList: function () {
        var self = this;

        // 이벤트 설정
        self.ajaxEventList
                .setUseHash(false)
                .setRemoveContent(false)
                .setLoadingTpl('#devEventLoading')
                .setListTpl('#devEventList')
                .setEmptyTpl('#devEventListEmpty')
                .setContainerType('ul')
                .setContainer('#devEventContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devEventForm')
                .setController('getSpecialListNew', 'display')
                .init(function (data) {
                    self.ajaxEventList.setContent(data.data.list, data.data.paging);
                });

    },
    run: function () {
        var self = this;
        self.initEvent();
        self.initAjaxEventList();
    }
};
$(function () {
    devStyleObj.run()
});