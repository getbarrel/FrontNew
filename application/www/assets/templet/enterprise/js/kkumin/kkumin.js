"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devKkuminProductList = {
    kkuminProductListAjax: false,
    init: function () {
        var self = this;
        self.kkuminProductListAjax = common.ajaxList();
        self.kkuminProductListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getKkuminProducts', 'product')
            .init(function (response) {
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.kkuminProductListAjax.setContent(response.data.list, response.data.paging);
                lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.kkuminProductListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('.devSortTab').on('click', function(){
            $('#devSort').val($(this).data('sort'));
            $(this).addClass('list-contents__nav--avtive').siblings().removeClass('list-contents__nav--avtive');
            self.kkuminProductListAjax.getPage(1);
        });

        $('.devSubCategoryTab').on('click', function(){
            $('#devCid').val($(this).attr('devSubCategory'));
            $('.devSubCategoryTab').removeClass('list-menu__list--active');
            $(this).addClass('list-menu__list--active');
            self.kkuminProductListAjax.getPage(1);
        });


        $('.devPageSubSelect').on('change', function(){
            $('#devCid').val($(this).val());
            self.kkuminProductListAjax.getPage(1);

        });

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devKkuminProductList.run();
});
