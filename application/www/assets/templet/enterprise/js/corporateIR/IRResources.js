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
        var bbsList = common.ajaxList2();
        // 페이지네이션 재정의
        bbsList
            .setContainerType('table')
            .setLoadingTpl('#devBbsLoading')
            .setListTpl('#devBbsList')
            .setEmptyTpl('#devBbsEmpty')
            .setContainer('#devBbsContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devBbsForm')
            .setController('customBbsData', 'customer')
            .setRemoveContent(false)
            .setUseHash(false)
            .init(function (data) {
                $("#devListTotal").text(data.data.total);
                bbsList.setContent(data.data.list, data.data.paging);
            });
    }

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        var bbs_ix = $(this).attr('devBbsIx');
        var bType = $('#bType').val();
        location.href = "/corporateIR/IRResources/read/" +bbs_ix;
    });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});