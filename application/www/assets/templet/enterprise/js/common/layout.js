"use strict";

$(document).ready(function() {
    // $('.header-subbanner.flexslider').flexslider({
    //     animation: "slide",
    //     direction: "vertical",
    //     controlNav: false,
    //     directionNav: true
    // });
    //
    // // 검색레이어영역 제외 클릭 시 검색 레이어 닫기
    // $('body').on('click', function(e){
    //     var container = $(".search-area");
    //
    //     if (!container.is(e.target) && container.has(e.target).length === 0){
    //         searchLayerClose();
    //     }
    // });

    //윈도우 창 resize 시
    /*$(window).on('resize',function(){
        var window_w = $(window).width();
        if ( window_w > 1700){
            $('.search').css("display","none");
            $('.search').find('form').css("display","none");
        }else{
            $('.wrap-search-layer').css("display","none");
        }
    });*/

    $('.header-input-search').on('click', function (e) {
        searchLayerOpen();
    });

    // $('.wrap_right_menu .flexslider').flexslider({
    //     animation: "slide",
    //     controlNav: false,
    //     slideshow: false
    // });

    $("#btnScrollTop").click(function () {
        $("html, body").animate({
            scrollTop: 0
        });
    });

    /////////////////////////////////////////////////////////


    $('#devHeaderSearchButton').on('click', function () {
        var window_w = $(window).width();
        if (window_w <= 1700) {
            $('.search').css("display","block");
            $('.search').find('form').css("display","block");
            goSearch();
            return false;
        } else {
            $('.search').css("display","none");
            $('.search').find('form').css("display","none");
            goSearch();
        }
    });

    //상단검색 엔터처리시
    $("#devHeaderSearchText , .search_input").keyup(function (e) {
        $('#devSearchCloseBtn').show();
        if (e.keyCode == 13)
            goSearch();
    });

    //상단 검색 x버튼 클릭시
    $('.search_close').click(function(){
        $(this).parents('.search').css("display","none");
    });
    $('.search_txt_clear').on('click' , function(){
        $('.search_input').val('');
    });

    //최근검색어 건별삭제시
    $('#devRecent, .devRecentKeyWordDelete').on('click', function () {
        var delText = $(this).attr('devDelText');
        $(this).closest('[devDelkey]').remove();
        common.ajax(common.util.getControllerUrl('deleteRecentKeyword', 'product'), {searchText: delText}, "", function () {
            if($('.ul-recent-search').children().length == 0){
                $('#tab2').html("<div class=\"empty-content\">\n" +
                    "\t\t\t\t\t\t\t최근 검색어가 없습니다.\n" +
                    "\t\t\t\t\t\t</div>");
            }
        });
        return false;
    });

    $('.devSearchKeyWord').on('click',function(){
       var searchText = $(this).data('text');
       location.href='/shop/search/?searchText='+encodeURI(searchText);
    });

    //최근검색어 전체삭제시
    $('#devRecentKeyWordDeleteAll').on('click', function () {
        $('#devRecent li').hide();
        common.ajax(common.util.getControllerUrl('deleteAllRecentKeyword', 'product'), {}, "", function () {
            $('#tab2').html("<div class=\"empty-content\">\n" +
                "\t\t\t\t\t\t\t최근 검색어가 없습니다.\n" +
                "\t\t\t\t\t\t</div>");
        });
    });

    //상단검색어 닫기시
    $('#devSearchCloseBtn').on('click', function () {
        $("#devHeaderSearchText").val('');
        $('#devSearchCloseBtn').hide();
    });

    function goSearch(){
        autoSearch.searchCallBack();
    }

    $('.devLogout').on('click', function(){
        signOut();
        location.href='/member/logout';
    });

    if ($('#devRightRecentViewContent').length > 0) {
        //최근본상품
        var myRecentList = false;

        $('.devRecentView').on('click',function(){

            if(myRecentList === false) {
                myRecentList = common.ajaxList();

                myRecentList.setContainerType('ul')
                    .setRemoveContent(false)
                    .setLoadingTpl('#devRightRecentViewLoading')
                    .setListTpl('#devRightRecentViewList')
                    .setEmptyTpl('#devRightRecentViewEmpty')
                    .setContainer('#devRightRecentViewContent')
                    .setPageNum('#devRightPage')
                    .setForm('#devRightRecentViewForm')
                    .setUseHash(false)
                    .setController('recentView', 'mypage')
                    .init(function (data) {
                        if (data.data.list.length > 0) {
                            $('#devRecentViewSelector').show();
                        } else {
                            $('#devRecentViewSelector').hide();
                        }
                        myRecentList.setContent(data.data.list, data.data.paging);
                        $('#devTotalRecentCnt').text(data.data.total);
                    });
            } else {
                myRecentList.getPage(1);
            }
        });

    }

    $(document).on('click', '.recent__goods__thumb', function(){
        location.href = '/shop/goodsView/'+$(this).parent().data('id');

    });

    //최근본 상품 선택 삭제
    $('#devRightRecentViewContent').on('click','.devRightRecentDel',function(){
        var recentList = [];
        var pid = $(this).data('pid');
        if(pid){
            recentList.push(pid);
            common.ajax(common.util.getControllerUrl('deleteRecentView', 'mypage'), {recentList: recentList}, "", function (result) {
                if (result.result == "success") {
                    myRecentList.getPage(1);
                } else {
                    common.noti.alert('삭제 처리에 실패했습니다.');
                }
            })
        }

    });

    $('#devRandomCouponIssue').on('click',function(){
        var gcIx = $(this).data('gcix');

        common.ajax(common.util.getControllerUrl('randomCouponIssue', 'coupon'), {'gc_ix': gcIx}, "", function (result) {
            if (result.result == "success") {
                common.noti.alert('쿠폰 발급이 완료 되었습니다.');
            } else if(result.data.fail_code == "notCoupon"){
                common.noti.alert('발급 가능한 쿠폰 정보가 없습니다.');
            } else if(result.data.fail_code == "giveCoupon"){
                common.noti.alert('보유중이거나 사용이 중지된 쿠폰입니다.');
            } else {
                common.noti.alert('발급 처리에 실패했습니다.');
            }
            $('#devRandomCouponArea').hide();
        })
    });

	common.ajax(
		common.util.getControllerUrl('getBeforeProductView', 'product'),
		{},
		'',
		function (response) {
		//console.log("getBeforeProductView : " + response.result);
			if(response.result == 'success'){
				if(response.data != null){
					$('#devBeforePrd').css("display","");
					$('#devBeforePrd').attr('src',response.data.image_src);
					$('#devBeforePrd').attr('alt',response.data.pname);[]
				} else {
					$('#devBeforePrd').css("display","none");
				}
			}

		}
	);
});

function searchLayerOpen(){
    $('.wrap-search-layer').show();
}

function searchLayerClose(){
    $('.wrap-search-layer').hide();
}


/////////////////////////////////////////////////////////


function post_to_url(path, params, method) {
    method = method || "get";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", encodeURI(encodeURIComponent(params[key])));
        form.appendChild(hiddenField);
    }
    document.body.appendChild(form);
    form.submit();
}

/**
 * 자동 검색 완성 
 * @type type
 */
common.lang.load('search.alert.empty', '검색어는 1글자 이상 입력해 주세요.');
var autoSearch = {
    searchCallBack: function () {	//검색입력 우측 검색이미지 클릭시 검색페이지 호출
        var searchText = $('#devHeaderSearchText').val();
        var pattern = /([^가-힣|a-z|A-Z|0-9|\x20])/i;

        if (searchText == '') {
            if ($('#devHeaderSearchText').attr('devTagUrl')) {
                location.href = $('#devHeaderSearchText').attr('devTagUrl');
            } else {
                alert(common.lang.get('search.alert.empty'));
                $("#devHeaderSearchText").focus();
                return false;
            }
        } else {
            post_to_url('/shop/search',{'searchText':searchText});
        }
        return false;
    },
    initClick: function (){
        var self = autoSearch;
      $(document).on("click", ".top-item .ui-menu-item", function (){
          self.searchCallBack();
      });
    },
    initAuotcomplete: function () {
        var self = autoSearch;
        $(".devAutoComplete").autocomplete({
            source: self.searchAutocomplete,
            delay: 500,
            open: function () {
                $('.ui-menu-item span').removeClass('ui-menu-item-wrapper');
                $('.ui-menu-item div').removeClass('ui-menu-item-wrapper');
                $('.ui-menu li').css({
                    "padding-top": 20
                });
                $(this).autocomplete("widget").css({
                    "width": $(".wrap-search-layer").width() - 2,
                    "height": $(".wrap-search-layer").height(),
                    "top": $(this).offset().top + 40,
                    "left": $(this).closest(".wrap-header-search").position()
                });
            },
            close: function(){
                $(this).autocomplete("widget").css({
                    "display":"none",
                    "margin-left": "0px",
                    "margin-top": "0px"
                });
            }
            
        }).data('ui-autocomplete')._renderItem = function (ul, item) {                        
            ul.addClass("top-item");
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
    autoSearch.run();
});

function removeHeaderTag(value){
	var removeHeaderValue = value.replace(/(<([^>]+)>)/gi,"");
	var removeHeaderValue = removeHeaderValue.replace(/alert/gi,"");
	var removeHeaderValue = removeHeaderValue.replace(/onclick/gi,"");
	$('#devHeaderSearchText').val(removeHeaderValue);
}

function removeKeyPress(value) {
    var removeHeaderValue = value.replace(/(<([^>]+)>)/gi,"");

    if(value == "alert") {
        var removeHeaderValue = removeHeaderValue.replace(/alert/gi,"");
    }

    if(value == "onclick") {
        var removeHeaderValue = removeHeaderValue.replace(/onclick/gi,"");
    }

    $('#devHeaderSearchText').val(removeHeaderValue);
}

function removeKeydown(value) {
    if(event.keyCode == 13) {
        var removeHeaderValue = value.replace(/(<([^>]+)>)/gi, "");
        var removeHeaderValue = removeHeaderValue.replace(/alert/gi, "");
        var removeHeaderValue = removeHeaderValue.replace(/onclick/gi, "");
        $('#devHeaderSearchText').val(removeHeaderValue);
    }
}