/**
 * Created by moon on 2019-08-14.
 */

$(function () {

    var isAjaxList = $("#isList").val();

    if (isAjaxList == 'Y') {

        var bbsList = common.ajaxList();

        bbsList
            .setContainer('#devMyContent')
            .setLoadingTpl('#devMyLoading')
            .setListTpl('#devMyList')
            .setEmptyTpl('#devMyListEmpty')
            .setContainerType('table')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devIrFrom')
            .setController('customBbsData', 'customer')
            .setRemoveContent(false)
            .setUseHash(false)
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

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});