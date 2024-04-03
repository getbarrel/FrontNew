"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var myReviewList = common.ajaxList();

    myReviewList.setContainerType('div')
        .setContainer('#devMyReviewContent')
        .setRemoveContent(false)
        .setListTpl('#devMyReviewList')
        .setLoadingTpl('#devMyReviewLoading')
        .setEmptyTpl('#devMyReviewEmpty')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devMyReviewForm')
        .setUseHash(true)
        .setController('myReviewList', 'mypage')
        .init(function (data) {
            $("#devTotal").text(data.data.total);
            myReviewList.setContent(data.data.list, data.data.paging);
        });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        myReviewList.getPage(pageNum);
    });
});