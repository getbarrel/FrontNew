"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devGoodsList = {
    goodsListAjax: false,
    init: function () {
        var self = this;
        self.goodsListAjax = common.ajaxList();
        self.goodsListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getGoodsList', 'product')
            .init(function (response) {
                // 전체 상품 수
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.goodsListAjax.setContent(response.data.list, response.data.paging);
                lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.goodsListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('.devSortTab').on('click', function(){
            $('#devSort').val($(this).data('sort'));
            $(this).addClass('b2b-content__nav--active').siblings().removeClass('b2b-content__nav--active');
            self.goodsListAjax.getPage(1);
        });

        $('.devSubCategoryTab').on('click', function(){
            $('#devCid').val($(this).attr('devSubCategory'));
            $('.devSubCategoryTab').removeClass('nav-menu__list--active');
            $(this).addClass('nav-menu__list--active');
            self.goodsListAjax.getPage(1);
        });


        $('.devPageSubSelect').on('change', function(){
            $('#devCid').val($(this).val());
            self.goodsListAjax.getPage(1);

        });

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devGoodsList.run();
});
