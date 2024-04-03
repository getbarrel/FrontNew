"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//상세검색열기
$('.btn-search-detail').click(function () {
    window.oriScroll = $(window).scrollTop();
    $('.layer-search-detail').show();
    $('.wrap-search-detail').removeClass('slide-out');
    $('.wrap-search-detail').addClass('slide-in');
    $('body').css('position', 'fixed').css("height", $(window).height()).css("overflow", "hidden");
});

//상세검색 레이어 닫기
function searchDetailClose() {
    $('.wrap-search-detail').removeClass('slide-in');
    $('.wrap-search-detail').addClass('slide-out');
    $('.layer-search-detail').fadeOut();
    $('body').css('position', '').css("height", "auto").css("overflow", "");
    $(window).scrollTop(window.oriScroll);
}


$('.layer-search-detail .dim').click(function () {
    searchDetailClose();
});

$('.wrap-search-detail dl dd').click(function () {
    $(this).toggleClass('on');
    $(this).next().slideToggle('fast');
    $(this).parent('dl').siblings().children('dd').removeClass('on');
    $(this).parent('dl').siblings().children('dt').slideUp('fast');
});


$('.wrap-search-detail .category-list .list-1dep p').click(function () {
    $(this).parent('li').addClass('on');
    $(this).parent('li').siblings().removeClass('on');
    $(this).parent('li').children('.cate-2depth').slideToggle('fast');
    $(this).parent('li').siblings().children('.cate-2depth').slideUp('fast');
    $(this).parent('li').find('.cate-2depth li').removeClass('on');
    $(this).parent('li').siblings().find('.cate-2depth li').removeClass('on');
});

$('.wrap-search-detail .category-list .cate-2depth li').click(function () {
    $(this).addClass("on");
    $(this).siblings().removeClass('on');
    $(this).parents('li').removeClass('on');
});



/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

common.lang.load('product.SearchPriceMinCheck.alert', "최소금액을 입력해주세요.");
common.lang.load('product.SearchPriceMaxCheck.alert', "최대금액을 입력해주세요.");
common.lang.load('product.SearchPriceFail.alert', "최소금액이 최대금액보다 크게 검색할 수 없습니다.");

common.inputFormat.set($('#devSpriceInput,#devEpriceInput'), {'number': true, 'maxLength': 10});

var search = {
    availableTags: [],
    seachAjax: false, //검색리스트 리로드
    selectedCategoryPath: false, //카테고리 경로 영역
    selectedCategorySubContents: false, //카테고리 리스트 영역
    selectedContents: false, //선택 옵션(필터) 영역
    selected: false, //선택 옵션(필터) 템플릿
    init: function () {
        var self = this;
        this.ajaxLoad(); //리스트 세팅        
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
                .setRemoveContent(false)
                .setController('getSearchGoodsList', 'product')
                .init(function (response) {
                    self.seachAjax.setContent(response.data.list, response.data.paging);
//                    $(".devColorCount").remove();                    
//                    $(".devFilterItemColor").each(function (item) {
//                        for (var i in response.data.filter) {
//                            var v = response.data.filter[i];
//                            if (item == v.key) {                                
//                                $(this).next().after('<span class="devColorCount">' + v.value + '</span>');
//                                break;
//                            }
//                        }
//                    });
                    $('#devSearchTotal').html(response.data.total); //검색결과 세팅
                });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.seachAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function () {
        var self = this;

        $('.devSortTab').on('click', function () {
            $('#devSort').val($(this).val());
            self.seachAjax.getPage(1);
        });

        $('#devFilterSubmit').on('click', function () {
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
                var price_type = ($(searchPriceArea).val());
                $('#devPriceType').val(price_type);
                if (sprice == '' && eprice == '') {
                    sprice = $('#devSpriceInput').val();
                    eprice = $('#devEpriceInput').val();
                }

                //체크박스 선택이면
                if ($('input[name=search_price]:checked').val() == 5) {
                    if ($('#devSpriceInput').val()) {
                        sprice = parseInt($('#devSpriceInput').val());
                    }
                    if ($('#devEpriceInput').val()) {
                        eprice = parseInt($('#devEpriceInput').val());
                    }
                }

                //NaN 체크
                if (isNaN(sprice)) {
                    sprice = null;
                }
                if (isNaN(eprice)) {
                    eprice = null;
                }

                if (sprice == null) {
                    common.noti.alert(common.lang.get('product.SearchPriceMinCheck.alert'));
                    $('#devSpriceInput').focus();
                    return false;
                }

                if (!eprice) {
                    common.noti.alert(common.lang.get('product.SearchPriceMaxCheck.alert'));
                    $('#devEpriceInput').focus();
                    return false;
                }

                if (sprice > eprice) {
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    $('#devSpriceInput').val('');
                    $('#devEpriceInput').val('');
                    $('#devSpriceInput').focus();
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            } else {
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
                $('#devPriceType').val('');
            }

            self.seachAjax.getPage(1);
            $('.br__filter-layer').removeClass('br__filter-layer--show');
        });

        // 버튼 이벤트 -> 페이지 로드시 체크 스크립트로 전환
        var filterItem = $('#devListForm #devProductFilter').val();
        var priceSelectType = $('#devListForm #devPriceType').val();
        if (filterItem) {
            filterItem = JSON.parse(decodeURIComponent(filterItem));
            $('.devFilterItem').prop('checked',false);
            //console.log(filterItem);
            $(filterItem).each(function (i, e) {
                var item = e;
                $('.devFilterItem:input[value=' + item + ']').trigger('click');
            })
        }

        if(priceSelectType){
            $('.devPriceType').prop('checked',false);
            $('.devPriceType:input[value=' + priceSelectType + ']').trigger('click');
        }
    },
    run: function () {
        var self = this;
        self.init();
        self.initEvent();
    }
}

$(function () {
    search.run();
});

var autoSearchDetail = {
    inAndSearch: function () {
        var self = search;
        $('input[name=filterInsideText]').val($('.devInsideText').val());
        self.seachAjax.reload();
    },
    initClick: function () {
        var self = autoSearchDetail;
        $(document).on("click", ".in-item .ui-menu-item", function () {
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
    }
}

$(function () {
    autoSearchDetail.run();
});

function productWish(pid){
    if (forbizCsrf.isLogin) {
        if($('#wishCheckBox_'+pid).is(':checked')){
            var gubun = "N";
        }else{
            var gubun = "Y";
        }

        var allData = { "pid": pid, "type": gubun };
        common.ajax(common.util.getControllerUrl('wish', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                //$(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                //$(e).removeClass("active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=';
        }
    }
}