"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

$(function () {
    $('.btn-dl-open').on('click', function () {
        $(this).parents('dl').toggleClass('on');
    });
    $(document).on("click", ".fb__search .filter__btn", function () {
        const $this = $(this);
        $this.toggleClass("filter__btn--active");
        $this.parents(".list-contents__header").toggleClass("list-contents__header--open");
        $(".filter__content").toggleClass("filter__content--show");
    });

});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('product.SearchPriceFail.alert', "최소금액이 최대금액보다 크게 검색할 수 없습니다.");

common.inputFormat.set($('#devSpriceInput,#devEpriceInput'), {'number': true, 'maxLength': 10});

var totalSearchCnt = 0;
var search = {
    seachAjax: false, //검색리스트 리로드
    videoSeachAjax: false, //뷰티비 검색리스트 리로드
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
//console.log(common.ajaxList());
//console.log("====");
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
                .setController('getSearchGoodsList', 'product')
                .init(function (response) {
//console.log(response);
                    $('.devListLoading').css('display','none');
                    self.seachAjax.setContent(response.data.list, response.data.paging);
//                    $(".devColorCount").remove();
//                    $(".devFilterItemColor").each(function (item) {
//                        for (var i in response.data.filter) {
//                            var v = response.data.filter[i];
//                            if (item == v.key) {        
//                                console.log(item);
//                                $(this).after('<span class="devColorCount">' + v.value + '</span>');
//                                break;
//                            }
//                        }
//                    });
                    $('#devPrdSearchTotal').html(response.data.total); //상품 검색결과 세팅
                    $('#devSearchTotal').html(Number(response.data.total) + Number($('#devVideoSearchTotal').text())); //전체 검색결과 개수
                    lazyload();//퍼블 레이지로드 삽입
                });



        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            $(window).scrollTop(0);
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
                        for (var i2 = 0; i2 < datas[i].pathArray.length; i2++) {
                            pathArray.push(datas[i].pathArray[i2].cname);
                        }

                        datas[i].path = '전체 > ' + pathArray.join(' > ');
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


        //결과 내 재검색
        $('#devGoInsideSearch').on('click', function () {
            var val = $('.devInsideText').val();
            $('input[name=filterInsideText]').val(val);

            self.seachAjax.reload();
        });


        //선택 옵션(필터) 삭제시
        $('#devSelectedView').on('click', '.devRemoveSelected', function () {
            var filter = $(this).parent().attr('class');
            var kind = $(this).data('kind');

            if (kind == 'category') { //카테고리 삭제시
                var clickCid = $('input[name=filterCid]').val();
                var parentText = $(this).parent().text();

                if (clickCid == '000000000000000') {
                    $('.' + filter).removeClass('on');
                    $(self.selectedContents).find('.' + filter).remove();
                    $('input[name=filterCid]').val('');
                    $(self.selectedCategoryPath).html('');
                    $('.dl-category').removeClass('on');
                } else {
                    var delCid = delLastCategoryStep(clickCid);
                    var delPaths = parentText.split(' >');
                    delPaths.pop();
                    delPaths = delPaths.join(' > ');

                    $('input[name=filterCid]').val(delCid);
                    self.categoryAjax(delCid); //카테고리 ajax 로드
                    $(self.selectedCategoryPath).html(delPaths); //카테고리 경로 영역 재설정

                    //선택옵션 데이터 생성/추가 영역
                    var selectedDatas = {selected: delPaths, devFilter: 'devCategorySelect' + delCid, kind: 'category'};
                    $(self.selectedContents).find('[class^=devCategorySelect]').remove();
                    $(self.selectedContents).append(self.selected(selectedDatas));

                    self.seachAjax.reload();
                    $('.dl-category').addClass('on');

                }

                self.categoryAjax();


            } else if (kind == 'brand') { //브랜드 삭제시

                $('.' + filter).removeClass('on');
                $(self.selectedContents).find('.' + filter).remove();

                var brands = $('[class^=devBrandSelect].on').map(function () {
                    return $(this).data('ix');
                }).get().join(',');
                $('input[name=filterBrands]').val(brands);
            }

            self.seachAjax.reload();
        });

        //$('#devFilterSubmit').on('click',function(){
        $('.devFilterItem').on('click',function(){

            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function () {
                if ($(this).is(':checked') == true) {
                    fillterData.push($(this).val());
                }
            });
            if (fillterData.length > 0) {
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            } else {
                $('#devListForm #devProductFilter').val('');
            }


            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if (searchPriceArea.length) {
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if (sprice == '' && eprice == '') {
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                //NaN 체크
                if (isNaN(sprice)) {
                    sprice = null;
                }
                if (isNaN(eprice)) {
                    eprice = null;
                }

                if (sprice > eprice) {
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    $('#devListForm #devSprice').val('');
                    $('#devListForm #devEprice').val('');
                    $('#devListForm #devSprice').focus();
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            } else {
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }


            self.seachAjax.getPage(1);
            $('.br__filter-layer').removeClass('br__filter-layer--show');
        });

        $('.devFilterItemPrice').on('click',function(){

            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function () {
                if ($(this).is(':checked') == true) {
                    fillterData.push($(this).val());
                }
            });
            if (fillterData.length > 0) {
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            } else {
                $('#devListForm #devProductFilter').val('');
            }


            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if (searchPriceArea.length) {
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if (sprice == '' && eprice == '') {
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                //NaN 체크
                if (isNaN(sprice)) {
                    sprice = null;
                }
                if (isNaN(eprice)) {
                    eprice = null;
                }

                if (sprice > eprice) {
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    $('#devListForm #devSprice').val('');
                    $('#devListForm #devEprice').val('');
                    $('#devListForm #devSprice').focus();
                    return false;
                }

				if ($('#devListForm #devSprice').val() == sprice && $('#devListForm #devEprice').val() == eprice )
				{
					$('#devListForm #devSprice').val('');
					$('#devListForm #devEprice').val('');
					$(this).prop('checked', false);
				}else{
					$('#devListForm #devSprice').val(sprice);
					$('#devListForm #devEprice').val(eprice);
				}


                //$('#devListForm #devSprice').val(sprice);
                //$('#devListForm #devEprice').val(eprice);
            } else {
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }


            self.seachAjax.getPage(1);
            $('.br__filter-layer').removeClass('br__filter-layer--show');
        });

        $('#devFilterView').on('click', function () {
            var filterItem = $('#devListForm #devProductFilter').val();
            if (filterItem) {
                filterItem = JSON.parse(decodeURIComponent(filterItem));
                $(filterItem).each(function (i, e) {
                    var item = e;
                    $('class[name=devFilterItem], input[value=' + item + ']').attr('checked', true);
                })
            }
        });



        function delLastCategoryStep(cid) {
            var categoryStep = new Array();

            for (var step = 4; step >= 0; step--) {
                var ncid = cid.substr(step * 3, 3);
                if (ncid != '000') {
                    return common.util.rpad(cid.substr(0, step * 3), 15, '0');
                }
            }
            return cid;
        }


        //검색탭 클릭
        $('.devSearchTyep').on('click', function () {
            var self = this;
            var searchType = $(this).attr('devSearchType');
            var activeClass = 'sj__search--active';
            //중복클릭/동일재검색 방지
            if ($(this).attr('class').indexOf(activeClass) != -1) {
                return false;
            }

            $(this).addClass(activeClass).siblings().removeClass(activeClass);
            if (searchType == 'product') {
                $('#devVideoSearchSection').css('display', 'none');
                $('#devPrdSearchSection').css('display', '');
            } else if (searchType == 'video') {
                $('#devPrdSearchSection').css('display', 'none');
                $('#devVideoSearchSection').css('display', '');
            }
        });


        $('.devSortTab').on('change', function () {
            $('#devSort').val($(this).val());
            //$(this).addClass('list-contents__nav--avtive').siblings().removeClass('list-contents__nav--avtive');
            self.seachAjax.getPage(1);
        });
        $('.devChangeMax').on('change', function () {
            $('#devMax').val($(this).val());
            self.seachAjax.getPage(1);
        });


    }
}

$(function () {
    search
            .setCategory('#devCategoryPath', '#devSubCategorys')
            .setSelected('#devSelectedView', '#devSelected')
            .init();
});

var autoSearchDetail = {
    inAndSearch: function (){
        var self = search;
        $('input[name=filterInsideText]').val($('.devInsideText').val());
        self.seachAjax.reload();  
    },
    initClick: function (){
        var self = autoSearchDetail;
      $(document).on("click", ".in-item .ui-menu-item", function (){
          self.inAndSearch();
      });
    },
    initAuotcomplete: function () {
        var self = autoSearch;
        $(".devAutoCompleteDetail").autocomplete({
            source: self.searchAutocomplete,
            delay: 500,
            open: function () {
                $('.ui-menu-item span').removeClass('ui-menu-item-wrapper');
                $('.ui-menu-item div').removeClass('ui-menu-item-wrapper');
            }

        }).data('ui-autocomplete')._renderItem = function (ul, item) {
            ul.addClass("in-item");
            return $('<li></li>')
                    .data("ui-autocomplete-item", item)
                    .append(item.label)
                    .appendTo(ul);
        };
    },
    cache: {},
    searchAutocomplete: function (req, res) {
        var self = autoSearch;
        var term = req.term;
        if (term in self.cache) {
            return res(self.cache[term]);
        } else {
            common.ajax(common.util.getControllerUrl('getAutocomplet', 'product'),
                    {searchText: req.term},
                    function () {
                        // 전송전 데이타 검증
                        return true;
                    },
                    function (response) {

                        if (response.result == "success" && typeof response.data !== "undefined" && response.data.length > 0) {
                            self.cache[term] = response.data;
                            return res(response.data);
                        } else {
                            return res([]);
                        }
                    }
            );
        }
    },
    run: function () {
        var self = this;
        self.initAuotcomplete();
        self.initClick();
    }
}

$(function () {
    autoSearchDetail.run();
});

function removeTag(value){
    var removeValue = value.replace(/(<([^>]+)>)/gi,"");
    var removeValue = removeValue.replace(/alert/gi,"");
    var removeValue = removeValue.replace(/onclick/gi,"");
    $('#devSearchText').val(removeValue);
}

function removeKeyPress(value) {
    var removeValue = value.replace(/(<([^>]+)>)/gi,"");

    if(value == "alert") {
        var removeValue = removeValue.replace(/alert/gi,"");
    }

    if(value == "onclick") {
        var removeValue = removeValue.replace(/onclick/gi,"");
    }

    $('#devSearchText').val(removeValue);
}

function removeKeydown(value) {
    if(event.keyCode == 13) {
        var removeValue = value.replace(/(<([^>]+)>)/gi, "");
        var removeValue = removeValue.replace(/alert/gi, "");
        var removeValue = removeValue.replace(/onclick/gi, "");
        $('#devSearchText').val(removeValue);
    }
}