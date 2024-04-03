"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devBrandProductList = {
    productListAjax: false,
    init: function () {
        var self = this;
        self.productListAjax = common.ajaxList();
        self.productListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getBrandProductList', 'brand')
            .init(function (response) {
                // 전체 상품 수
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.productListAjax.setContent(response.data.list, response.data.paging);
                lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.productListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('.devSortTab').on('click', function(){
            $('#devSort').val($(this).data('sort'));
            $(this).addClass('b2b-content__nav--active').siblings().removeClass('b2b-content__nav--active');
            self.productListAjax.getPage(1);
        });


        $('.devPageSubSelect').on('change', function(){
            $('#devCid').val($(this).val());
            self.productListAjax.getPage(1);

        });

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devBrandProductList.run();
});
