"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devEventObj = {
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
                .setLoadingTpl('#devEventLoading')
                .setListTpl('#devEventList')
                .setEmptyTpl('#devEventListEmpty')
                .setContainerType('ul')
                .setContainer('#devEventContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devEventForm')
                .setController('getEventListNew', 'event')
                .init(function (data) {

					for(let i=0; i < data.data.list.length; i++) {
						//data.data.list[i]['explanation'] = data.data.list[i]['explanation'].replace("\r\n", "<br>");
					}
			
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
    devEventObj.run()
});