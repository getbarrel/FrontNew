"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var myGoodsList = common.ajaxList();

    myGoodsList.setContainerType('div')
                .setContainer('#devMyGoodsContent')
                .setListTpl('#devMyGoodsList')
                .setLoadingTpl('#devMyGoodsLoading')
                .setEmptyTpl('#devMyGoodsEmpty')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devMyGoodsForm')
                .setUseHash(true)
                .setPaginationTpl(common.boardPagination)
                .setController('myGoodsInquiryList', 'mypage')
                .init(function (data) {
                    $("#devTotal").text(data.data.total);
                    myGoodsList.setContent(data.data.list, data.data.paging);

                    // if(data.data.total <= 10){
                    //     $('#devPageWrap').hide();
                    // }
                });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        myGoodsList.getPage(pageNum);
        $('#devPage').val(pageNum);
    });

    $('#devDateSelect').on('change', function () {
        var sdate = $(this).val();
        $('#devStartDate').val(sdate);
        if(sdate != '') {
            $('#devMyGoodsContent > li').remove();
            myGoodsList.getPage(1);
        }
    });

    //기간설정 후 조회버튼 클릭시
    $('#devSearch').on('click', function() {
        var sdate = $('#devSelectStartDate').val();
        var edate = $('#devSelectEndDate').val();

        $('#devStartDate').val(sdate);
        $('#devEndDate').val(edate);

        $('#devMyGoodsContent > li').remove();
        myGoodsList.getPage(1);
    });

    $('#devStateSelect').on('change', function() {
        $('#devState').val($(this).val());
        $('#devMyGoodsContent > li').remove();
        myGoodsList.getPage(1);
    });

    if($('#devStartDate').val() != ''){
        var sdate = $('#devStartDate').val();
        var edate = $('#devEndDate').val();
        if(edate){
            $('#devDateSelect option[value=timeSelect]').attr('selected','selected');
            $(".br__sort__timeselect").addClass("br__sort__timeselect--show");
            $('#devSelectStartDate').val(sdate);
            $('#devSelectStartDate').addClass('has-value')
            $('#devSelectEndDate').val(edate);
            $('#devSelectEndDate').addClass('has-value')
        }else{
            $('#devDateSelect option[value='+sdate+']').attr('selected','selected');
        }
    }
    if($('#devState').val() != ''){
        var state = $('#devState').val();
        $('#devStateSelect option[value='+state+']').attr('selected','selected');

    }

    $('#devMyGoodsForm').on('click', '#devBtnSearch', function () {
        myGoodsList.getPage(1);
    });


});