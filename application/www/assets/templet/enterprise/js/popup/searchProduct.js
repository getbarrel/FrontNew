"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var devSearchProductsList = {
    searchProductsListAjax: false,
    init: function () {
        var self = this;
        self.searchProductsListAjax = common.ajaxList();
        self.searchProductsListAjax
            .setLoadingTpl('#devSearchProductListLoading')
            .setListTpl('#devSearchProductListDetail')
            .setEmptyTpl('#devSearchProductListEmpty')
            .setContainerType('div')
            .setContainer('#devSearchProductListContents')
            .setPagination('#devSearchProductPageWrap')
            .setPageNum('#devSearchProductPage')
            .setForm('#devSearchProductListForm')
            .setUseHash(false)
            .setController('getGoodsList', 'product')
            .init(function (response) {
                self.searchProductsListAjax.setContent(response.data.list, response.data.paging);
                // lazyload();//퍼블 레이지로드 삽입
            });

        $('#devSearchProductPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.searchProductsListAjax.getPage($(this).data('page'));
        });

        $('#devSelectProducts').on('click',function(){
            var searchProductCheckBool = false;
            $('.devSearchProductSelectItem').each(function(){
                if($(this).is(':checked') == true){
                    var pid = $(this).data('goods-id');

                    var chkPid = $('input[name]:input[value='+pid+']').val();
                    if(!chkPid){
                        var item = "<input type='hidden' name='pid[]' class='devPidArea' value='"+pid+"' />";
                        $('#devMatchingProducts').append(item);
                    }
                    searchProductCheckBool = true;
                }
            });
            
            if(searchProductCheckBool == true){
                devMatchProduct.matchProductListReload();
                $('.popup-layout .close').trigger('click');
            }else{
                common.noti.alert('상품을 선택해 주세요');
            }
            
        });
    },
    initEvent: function() {
        var self = this;

        $('#devSearchSubmit').on('click', function(){
            $('#devSearchTextFrom').val($('#devSearchText').val());
            self.searchProductsListAjax.getPage(1);
        });


        $('#devCidSelect').on('change', function(){
            $('#devCid').val($(this).val());
        });

        $('#devSearchInitBtn').on('click',function(){

            $('#devCidSelect option:eq(0)').prop("selected", true);
            $('#devSearchText').val('');
            $('#devCid').val($('#devCidSelect').find('option:selected').val());
        })


    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}


$(function () {
    devSearchProductsList.run();

});