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
        .setLoadingTpl('#devRecentViewLoading')
        .setListTpl('#devRecentViewList')
        .setEmptyTpl('#devRecentViewEmpty')
        .setContainer('#devRecentViewContent')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devRecentViewForm')
        .setGotoTop(500)
        .setUseHash(true)
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

    // 관심상품 일괄삭제
    $('#devBtnDelRecent').on('click', function () {

        var $form1 = $('#devRecentViewForm');
        var url = common.util.getControllerUrl('deleteRecentView', 'mypage');
        var beforeCallback = function ($form1) {
            return true;
        };
        var successCallback = function (response) {
            if (response.result == "success") {
                location.reload();
            } else {
                common.noti.alert('삭제 처리에 실패했습니다.');
            }
        };
        common.form.init($form1, url, beforeCallback, successCallback);

        var searchIDs = $("#devRecentViewContent input:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        if (searchIDs == "") {
            common.noti.alert(common.lang.get("recentview.delete.alert"));
            return false;
        } else {
            if (common.noti.confirm(common.lang.get('recentview.delete.confirm'))) {
                $form1.submit();
            }
        }
    });
});