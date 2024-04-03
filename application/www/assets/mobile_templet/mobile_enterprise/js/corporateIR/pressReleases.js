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
            .setContainer('#devMyContent')
            .setLoadingTpl('#devMyLoading')
            .setListTpl('#devMyList')
            .setEmptyTpl('#devMyListEmpty')
            .setContainerType('li')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devIrFrom')
            .setController('customBbsData', 'customer')
            .setUseHash(true)
            .setPaginationTpl(common.boardPagination)
            .init(function (data) {
                $("#devListTotal").text(data.data.total);
                bbsList.setContent(data.data.list, data.data.paging);

            });
    }

    $('#devMyContent').on('click', '[devBbsIx]', function () {
        var bbs_ix = $(this).attr('devBbsIx');
        var bType = $('#bType').val();
        location.href = "/corporateIR/disclosureNoti/"+bType+"/read/" +bbs_ix;
    });

    $('.devBoardTab').on('click',function(){
        var board = $(this).data('board');
        $('#bType').val(board);
        bbsList.getPage(1);
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});