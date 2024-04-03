"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

$(function () {
    var isAjaxList = $("#isList").val();
    if (isAjaxList == 'Y') {
        var bbsList = common.ajaxList();
        bbsList
            .setContainerType('div')
            .setLoadingTpl('#devBbsLoading')
            .setListTpl('#devBbsList')
            .setEmptyTpl('#devBbsEmpty')
            .setContainer('#devBbsContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devBbsForm')
            .setController('noticeList', 'customer')
            .setGotoTop(100)
            .setUseHash(true)
            .setPaginationTpl(common.boardPagination)
            .init(function (data) {
                bbsList.setContent(data.data.list, data.data.paging);
                if (data.data.searchText != "" && data.data.total == 0) {
                    $("#emptyMsg").text("등록된 IR 자료가 없습니다");
                }
            });
    }

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        location.href = "/corporateIR/IRResources/read/" + $(this).attr('devBbsIx');
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});