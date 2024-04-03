"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('product.SearchPriceFail.alert', "최소금액이 최대금액보다 크게 검색할 수 없습니다.");

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
                if(response.result == 'emptySearchFilter'){
                    $('.devListLoading').css('display','none');
                    $('#devListContents').css('display','none');
                    $('#devFilterEmpty').css('display','');
                }else{
                    $('.devListLoading').css('display','none');
                    $('#devFilterEmpty').css('display','none');
                    $('#devListContents').css('display','');
                }
                // 전체 상품 수
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.goodsListAjax.setContent(response.data.list, response.data.paging);
                // lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            $(window).scrollTop(0);
            self.goodsListAjax.getPage($(this).data('page'));

        });
    },
    initEvent: function() {
        var self = this;

        var devSort = $('#devSort').val();
        $('#devSortTab').val(devSort).prop('select',true);

        $('#devSortTab').on('change', function(){
            $('#devSort').val($(this).val());
            self.goodsListAjax.setRemoveContent(true);
            self.goodsListAjax.getPage(1);
        });

        $('#devMaxTab').on('change', function(){
            $('#devMax').val($(this).val());
            self.goodsListAjax.setRemoveContent(true);
            self.goodsListAjax.getPage(1);
        });

        //$('#devFilterSubmit').on('click',function(){
        $('.devFilterItem').on('click',function(){
            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function(){
                if($(this).is(':checked') == true){
                    fillterData.push($(this).val());
                }
            });
            if(fillterData.length > 0){
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            }else{
                $('#devListForm #devProductFilter').val('');
            }



            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if(searchPriceArea.length){
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if(sprice == ''&& eprice == ''){
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                if(sprice > eprice){
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            }else{
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }

            self.goodsListAjax.getPage(1);

        });

        $('.devFilterItemPrice').on('click',function(){
            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function(){
                if($(this).is(':checked') == true){
                    fillterData.push($(this).val());
                }
            });

            if(fillterData.length > 0){
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            }else{
                $('#devListForm #devProductFilter').val('');
            }



            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if(searchPriceArea.length){
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if(sprice == ''&& eprice == ''){
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                if(sprice > eprice){
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            }else{
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }

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