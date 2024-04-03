"use strict";

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('recentview.delete.confirm', "선택한 상품을 삭제하시겠습니까?"); //Confirm_12
common.lang.load('recentview.delete.alert', "삭제할 상품을 선택해 주세요."); //Alert_47

$(function () {

    var myRecentList = common.ajaxList();

    myRecentList.setContainerType('div')
        .setRemoveContent(false)
        .setLoadingTpl('#devRecentViewLoading')
        .setListTpl('#devRecentViewList')
        .setEmptyTpl('#devRecentViewEmpty')
        .setContainer('#devRecentViewContent')
        .setPageNum('#devPage')
        .setForm('#devRecentViewForm')
        .setUseHash(false)
        .setController('recentView', 'mypage')
        .init(function (data) {


            if (data.data.list.length > 0) {
                $('#devRecentViewSelector').show();
            } else {
                $('#devRecentViewSelector').hide();
            }
            myRecentList.setContent(data.data.list, data.data.paging);
        });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        myRecentList.getPage(pageNum);
    });

    // $('#devModalContent').scroll(function(){
    //     var max_height = $(this).height();
    //     var now_height = $(this).scrollTop() + $(this).height();
    //     if ((max_height <= now_height + 800) ) {
    //         var page = $('.devPageBtnCls').data('page');
    //         myRecentList.getPage(page);
    //     }
    // });

    $(document).on('click', '.recent__goods__thumb', function(){
        location.href = '/shop/goodsView/'+$(this).parent().data('id');
    });

    // 관심상품 일괄삭제
    // $('#devBtnDelRecent').on('click', function () {
    //
    //     var $form1 = $('#devRecentViewForm');
    //     var url = common.util.getControllerUrl('deleteRecentView', 'mypage');
    //     var beforeCallback = function ($form1) {
    //         return true;
    //     };
    //     var successCallback = function (response) {
    //         if (response.result == "success") {
    //             location.reload();
    //         } else {
    //             common.noti.alert('삭제 처리에 실패했습니다.');
    //         }
    //     };
    //     common.form.init($form1, url, beforeCallback, successCallback);
    //
    //     var searchIDs = $("#devRecentViewContent input:checkbox:checked").map(function () {
    //         return $(this).val();
    //     }).get();
    //
    //     if (searchIDs == "") {
    //         common.noti.alert(common.lang.get("recentview.delete.alert"));
    //         return false;
    //     } else {
    //         if (common.noti.confirm(common.lang.get('recentview.delete.confirm'))) {
    //             $form1.submit();
    //         }
    //     }
    // });

    //최근본 상품 선택 삭제
    $('#devRecentViewContent').on('click','.devRecentDel',function(){
        var recentList = [];
        var pid = $(this).data('pid');
        if(pid){
            recentList.push(pid);
            common.ajax(common.util.getControllerUrl('deleteRecentView', 'mypage'), {recentList: recentList}, "", function (result) {
                if (result.result == "success") {
                    myRecentList.getPage(1);
                } else {
                    common.noti.alert('삭제 처리에 실패했습니다.');
                }
            })
        }

    });

    $('#all-check').on('click', function(){
        var ck = $(this).is(':checked');
        if(ck){
            $("#devRecentViewContent input[name=recentList\\[\\]]").prop('checked',true);
        }else{
            $("#devRecentViewContent input[name=recentList\\[\\]]").prop('checked',false);
        }
    });
    // $(document).on('click', devRightRecentViewDetail)
});