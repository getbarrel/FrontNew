"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var storeGuide = {
    ajaxOptionList: false,
    ajaxStoreList: false,
    initEvent: function () {
        var self = this;
    },
    initAjaxOptionList: function () {

    },
    initAjaxStoreList: function () {
        var self = this;
        self.ajaxStoreList = common.ajaxList();

        self.ajaxStoreList
            .setUseHash(false)
            .setRemoveContent(true)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devStoreGuideForm')
            .setController('searchStore', 'product');

        $('#devSearch').on('click', function() {
            if($('#devOptionSelect').length > 0){
                $('#devItem').val($('#devOptionSelect').val());
            }else {
                $('#devItem').val($('#devStyleSelect').val());
            }
            $('#devCity').val($('#devCitySelect').val());

            self.ajaxStoreList.init(function (response) {
                var data = $.parseJSON(response.data);
                $('#devLoading').hide();
                if(data.res_cd == '0000') {
                    $('#devListCount').text(data.stock_list.length);
                    self.ajaxStoreList.setContent(data.stock_list);
                }else {
                    alert('매장정보조회 API에 문제가 생겼습니다.');
                }
            });
        });
    },
    run: function () {
        var self = this;
        self.initEvent();
        self.initAjaxStoreList();
    }
};

$(function () {
    storeGuide.run();
});