"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var myInquiryList = common.ajaxList();

    myInquiryList.setContainerType('div')
                .setContainer('#devMyInquiryContent')
                .setListTpl('#devMyInquiryList')
                .setLoadingTpl('#devMyInquiryLoading')
                .setEmptyTpl('#devMyInquiryEmpty')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devMyInquiryForm')
                .setUseHash(true)
                .setPaginationTpl(common.boardPagination)
                .setController('myInquiryList', 'mypage')
                .init(function (data) {
                    $("#devTotal").text(data.data.total);
                    myInquiryList.setContent(data.data.list, data.data.paging);
                });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        myInquiryList.getPage(pageNum);
    });

    $('#devMyInquiryForm').on('change', '#devQnaType', function () {
        $('#devQnaType').val($(this).val());
        myInquiryList.getPage(1);
    });

    if($('#devQnaType').val() != ''){
        var qnaType = $('#devQnaType').val();
        $('.devQnaTypeSelect option[value='+qnaType+']').attr('selected','selected');
    }
    $('#devMyInquiryForm').on('click', '#devBtnSearch', function () {
        myInquiryList.getPage(1);
    });


});