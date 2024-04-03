"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var isAjaxList = $("#isAjaxList").val();

    if (isAjaxList == 'undefined' || isAjaxList != 'N') {

        var bbsList = common.ajaxList();
        bbsList.setLoadingTpl('#devBbsLoading')
                .setListTpl('#devBbsList')
                .setEmptyTpl('#devBbsListEmpty')
                .setContainerType('table')
                .setContainer('#devBbsContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devBbsForm')
                .setController('noticeList', 'customer')
                .setGotoTop(200)
                .init(function (data) {

                    if (!(data.data.list).isNull && !(data.data.paging).isNull) {
                        var c = data.data.paging.cur_page;
                        var p = data.data.paging.per_page;
                        var t = data.data.total;
                        var no = t - (p * (c - 1));
                        for (var i = 0; i < (data.data.list).length; i++) {
                            data.data.list[i].idx = no;
                            no--;
                        }
                    }

                    $(".count").empty("");
                    $(".count").append("<em id='keyword'></em> <em id='devTotal'></em>");

                    if (data.data.searchText != "") {
                        $("#keyword").text(data.data.searchText);
                        $("#keyword").after("에 대한 검색 결과 ");
                    }

                    $("#devTotal").text(data.data.total);
                    $("#devTotal").before("총 ");
                    $("#devTotal").after("개");

                    bbsList.setContent(data.data.list, data.data.paging);

                    if (data.data.searchText != "" && data.data.total == 0) {
                        $("#emptyMsg em").text(data.data.searchText);
                        $("#emptyMsg").append("에 대한 검색 결과가 없습니다.");
                    } else {
                        $("#emptyMsg").text("등록된 공지사항이 없습니다");
                    }
                });
    }

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        location.href = "/customer/notice/read/" + $(this).attr('devBbsIx');
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});