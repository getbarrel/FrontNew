"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var extmMileageList = common.ajaxList();

    extmMileageList
        .setUseHash(false)
        .setRemoveContent(false)
        .setLoadingTpl('#devMileageLoading')
        .setListTpl('#devMileageList')
        .setEmptyTpl('#devMileageListEmpty')
        .setContainerType('ul')
        .setContainer('#devMileageContent')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devExtMileageForm')
        .setController('extMileageList', 'mypage')
        .init(function (data) {
            extmMileageList.setContent(data.data.list, data.data.paging);
        });



    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        extmMileageList.getPage(pageNum);
    });

});