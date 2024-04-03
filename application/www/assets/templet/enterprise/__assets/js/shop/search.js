"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

$(function () {
    $('.btn-dl-open').on('click', function () {
        $(this).parents('dl').toggleClass('on');
    });

});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var search = {
    seachAjax: false, //검색리스트 리로드
    selectedCategoryPath: false, //카테고리 경로 영역
    selectedCategorySubContents: false, //카테고리 리스트 영역
    selectedContents: false, //선택 옵션(필터) 영역
    selected: false, //선택 옵션(필터) 템플릿
    setCategory: function (pathId, subContentsId) {
        this.selectedCategoryPath = pathId;
        this.selectedCategorySubContents = common.ajaxList().compileTpl(subContentsId);
        return this;
    },
    setSelected: function (contentsId, selectedId) {
        this.selectedContents = contentsId;
        this.selected = common.ajaxList().compileTpl(selectedId);
        return this;
    },
    init: function () {
        var self = this;
        this.ajaxLoad(); //리스트 세팅
        this.categoryAjax(); //카테고리 세팅
        this.eventBind(); //이벤트 목록
    },
    ajaxLoad: function () { //검색리스트 ajax
        var self = this;
        self.seachAjax = common.ajaxList();
        self.seachAjax
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
                .init(function (data) {
                    self.seachAjax.setContent(data.data.list, data.data.paging);
                    $('#devSearchTotal').html(data.data.total); //검색결과 세팅
                });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.seachAjax.getPage($(this).data('page'));
        });
    },
    categoryAjax: function (cid) { //카테고리 ajax
        var self = this;
        common.ajax(common.util.getControllerUrl('getCategorySubList', 'product'), {cid: cid}, "", function (result) {
            if (result.result == 'success') {
                var datas = result.data;

                if (datas.length > 0) { //하위 카테고리가 있을 경우 영역 비우고 하위 카테고리로 영역 재세팅
                    $('#devSubCategorysContents').empty();
                    var subContents = [];
                    for (var i = 0; i < datas.length; i++) {
                        var pathArray = []; //카테고리 경로 데이터 생성
                        for(var i2 = 0; i2 < datas[i].pathArray.length; i2++){
                            pathArray.push(datas[i].pathArray[i2].cname);
                        }
                
                        datas[i].path = '전체 > ' + pathArray.join(' < ');
                        subContents.push(self.selectedCategorySubContents(datas[i]));
                    }
                    $('#devSubCategorysContents').append(subContents.join(''));
                } else { //하위 카테고리가 없을 경우 영역 그대로 둠
                    $('[class^=devCategorySelect]').removeClass('on');
                    $(this).addClass('on');
                }
                
                $('#devSubCategorysContents').removeClass('devForbizTpl');
                $('#devSubCategorysContents').show();
            }
        })
    },
    eventBind: function () {
        var self = this;
        
        //카테고리 클릭시
        $('#devSubCategorysContents').on('click', '[class^=devCategorySelect]', function () {
            var cid = $(this).data('cid');
            var path = $(this).data('path');
            $('input[name=filterCid]').val(cid);

            self.categoryAjax(cid); //카테고리 ajax 로드
            $(self.selectedCategoryPath).html(path); //카테고리 경로 영역 재설정

            //선택옵션 데이터 생성/추가 영역
            var selectedDatas = {selected: path, devFilter: 'devCategorySelect' + cid, kind: 'category'};
            $(self.selectedContents).find('[class^=devCategorySelect]').remove();
            $(self.selectedContents).append(self.selected(selectedDatas));

            self.seachAjax.reload();
            $('.dl-category').addClass('on');
        });

        //무료배송 클릭시
        $('.devFreeDelivery').on('click', function () {
            if ($(this).hasClass('on')) {
                $(this).removeClass('on');
                $('input[name=filterDeliveryFree]').val('');
            } else {
                $(this).addClass('on');
                $('input[name=filterDeliveryFree]').val(1);
            }

            self.seachAjax.reload();
        });

        //결과 내 재검색
        $('#devGoInsideSearch').on('click', function () {
            var val = $('.devInsideText').val();
            $('input[name=filterInsideText]').val(val);

            self.seachAjax.reload();
        });

        //브랜드 클릭
        $('[class^=devBrandSelect]').on('click', function () {
            var brandName = $(this).text();
            var selectedIx = $(this).data('ix'); //브랜드 키
            var selectedDatas = {selected: brandName, devFilter: 'devBrandSelect' + selectedIx, kind: 'brand'}; //선택 옵션(필터) 영역 설정할 정보들

            if ($(this).hasClass('on')) { //브랜드를 이미 선택했을 경우에는 재선택시 옵션(필터) 해제됨
                $(this).removeClass('on');
                $(self.selectedContents).find('.' + selectedDatas.devFilter).remove(); //선택 옵션(필터) 영역에서 삭제
            } else {
                $(this).addClass('on');
                if ($(self.selectedContents).find('.' + selectedDatas.devFilter).length == 0) {
                    $(self.selectedContents).append(self.selected(selectedDatas));
                }
            }

            //선택된 브랜드 리스트로 데이터 생성해서 form에 세팅 후 검색리스트 ajax 재로드
            var brands = $('[class^=devBrandSelect].on').map(function () {
                return $(this).data('ix');
            }).get().join(',');
            $('input[name=filterBrands]').val(brands);

            self.seachAjax.reload();
        });

        //선택 옵션(필터) 삭제시
        $('#devSelectedView').on('click', '.devRemoveSelected', function () {
            var filter = $(this).parent().attr('class');
            var kind = $(this).data('kind');

            $('.' + filter).removeClass('on');
            $(self.selectedContents).find('.' + filter).remove();

            if (kind == 'category') { //카테고리 삭제시
                $('input[name=filterCid]').val('');
                $(self.selectedCategoryPath).html('');
                self.categoryAjax();
                $('.dl-category').removeClass('on');
            } else if (kind == 'brand') { //브랜드 삭제시
                var brands = $('[class^=devBrandSelect].on').map(function () {
                    return $(this).data('ix');
                }).get().join(',');
                $('input[name=filterBrands]').val(brands);
            }

            self.seachAjax.reload();
        })
    }
}

$(function () {
    search
            .setCategory('#devCategoryPath', '#devSubCategorys')
            .setSelected('#devSelectedView', '#devSelected')
            .init();
});