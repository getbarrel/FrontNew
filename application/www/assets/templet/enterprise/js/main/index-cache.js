"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
// common.lang.load('main.updateDeliveryComplete.confirm', "배송완료로 상태변경하시겠습니까?");
var getMainProductList = {
    mainProductListAjax: [],
    initPromotionProduct: function (group_code) {
        var self = this;
        self.mainProductListAjax[group_code] = common.moreArrayList();
        self.mainProductListAjax[group_code]
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading_'+group_code)
            .setListTpl('#devListDetail_'+group_code)
            .setEmptyTpl('#devListEmpty_'+group_code)
            .setContainerType('ul')
            .setContainer('#devListContents_'+group_code)
            .setPagination('#devPageWrap_'+group_code)
            .setPageNum('#devPage_'+group_code)
            .setForm('#devListForm_'+group_code)
            .setUseHash(false)
            .setResponseData(mainDisplayGroupData[group_code])
            .init(function (response) {
                // 전체 상품 수
                if(typeof response.data.list !== 'undefined' && response.data.list.length > 0) {
                    self.mainProductListAjax[group_code].setContent(response.data.list, response.data.paging);
                }else{
                    $('.devDisplayGroup').each(function(){
                        if($(this).data('group_code') == group_code){
                            $(this).hide();
                        }
                    });
                }
            });

        $('#devPageWrap_'+group_code).on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.mainProductListAjax[group_code].getPage($(this).data('page'));
        });
        
        const mainGoodsPage = self.mainProductListAjax;
        window.mainGoodsPage = mainGoodsPage;
    },
    initEvent: function() {
        var self = this;

    },
    run: function(){
        var self = this;

        $('.devDisplayGroup').each(function(){
            var groupCode = $(this).data('group_code');
            self.initPromotionProduct(groupCode);
        })

        self.initEvent();
    }
}


$(function () {
    getMainProductList.run();
});