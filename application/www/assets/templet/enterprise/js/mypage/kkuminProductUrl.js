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
            .setUseHash(false)
            .setController('getKkuminProducts', 'product')
            .init(function (response) {
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.kkuminProductListAjax.setContent(response.data.list, response.data.paging);
                lazyload();//퍼블 레이지로드 삽입

                var searchText = $('#devSearchText').val();
                $('#devNonSearch').html(searchText);

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

        $('#devSelectCategory').on('change', function(){
            $('#devCid').val($(this).val());
        });

        $('#devSearchBtn').on('click',function(){
            var searchText = $('#devSearchText').val();
            if(!searchText){
                common.noti.alert('상품명을 입력해 주세요.');
                return false;
            }
            $('#devFilterPname').val(searchText);
            self.kkuminProductListAjax.getPage(1);
        });

        $('#devSearchInitBtn').on('click',function(){
            $('#devSearchText').val('');
            $("#devSelectCategory").find("option").attr("selected",false).first().attr("selected",true);
            var firstCid = $('#devSelectCategory').find('option:first').val();
            $('#devCid').val(firstCid);
            $('#devFilterPname').val('');
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
