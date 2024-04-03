"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {
/*

    // REVIEW List
    var myReviewList = common.ajaxList();

    myReviewList
            .setLoadingTpl('#devMyReviewLoading')
            .setListTpl('#devMyReviewList')
            .setEmptyTpl('#devMyReviewListEmpty')
            .setContainerType('table')
            .setContainer('#devMyReviewContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyReviewForm')
            .setController('myReviewList', 'mypage')
            .init(function (data) {
                console.log(data);
                $("#devTotal").text(data.data.total);
                myReviewList.setContent(data.data.list, data.data.paging);
            });
*/


    $("[id^=mltab_]").on('click', function () {
        var tmp = (this.id).split("_");
        $("#devState").val(tmp['1']);
        myReviewList.reload();
    });

    $('#devBtnSearch').on('click', function () {
        myReviewList.reload();
    });

    $('#devBtnReset').on('click', function () {
        $("#sDate").val("");
        $("#eDate").val("");
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        $('#devPage').val(pageNum);
        myReviewList.getPage(pageNum);
    });

    $('#devMyReviewContent').on('click', '.devReviewModifyBtnCls', function () {
        //common.util.modal.open('ajax', '상품 후기 내역', '/shop/reviewDetail.php?mode=read');
        common.util.popup('/shop/reviewBbsPop', 720, 870, '상품 후기 내역',true);
        //alert($(this).data('bbsidx'));
    });
/*
    $('#devMyReviewContent').on('click', '.devReviewDeleteBtnCls', function () {
        //common.util.modal.open('ajax', '상품 후기 수정', '/shop/review_detail.php?mode=upt');
        // common.util.popup('/shop/review_detail', 720, 870, '상품 후기 수정');
        alert($(this).data('bbsidx'));
    });
*/    
});