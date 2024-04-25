"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


$(document).ready(function () {

    $('.back').click(function () {
        $('.br-search-layer').css('display', '');
    });

    $('#icon_search').on('click', function () {
        searchLayerOpen();
    });

    /////////////////////////////////////////////////////////


    //상단검색시
    $('#devHeaderSearchButton').on('click', function () {
		var id = "devHeaderSearchText";
		goSearch(id);
        return false;
    });
    //상단검색시
    $('#devHeaderSearchButtonMenu').on('click', function () {
        goSearch();
        return false;
    });

    //상단검색 엔터처리시
    $("#devHeaderSearchText, #devHeaderSearchTextMenu").keyup(function (e) {
		var id = $(this).data('id');
        $('#devSearchCloseBtn').show();
        if (e.keyCode == 13)
            goSearch(id);
        return false;
    });

    //상단검색어 닫기시
    $('#devSearchCloseBtn').on('click', function () {
        $("#devHeaderSearchText").val('');
        $('#devSearchCloseBtn').hide();
    });

    //최근검색어 건별삭제시
    $('#devRecent .devRecentKeyWordDelete').on('click', function () {
        var delText = $(this).attr('devDelText');
        $(this).closest('[devDelkey]').remove();
        common.ajax(common.util.getControllerUrl('deleteRecentKeyword', 'product'), {searchText: delText}, "", function () {
            if($('#devRecent').children().length == 0){
                $('#tab2').html("<div class=\"empty-content\" style=\"padding:20px 0 0 0\">\n" +
                    "\t\t\t\t\t\t\t최근 검색어가 없습니다.\n" +
                    "\t\t\t\t\t\t</div>");
            }
        });
    });

    //최근검색어 전체삭제시
    $('#devRecentKeyWordDeleteAll').on('click', function () {
        $('#devRecent li').hide();
        /*$('#devRecentKeyWordDeleteAll').hide();
        $('.devRecentEmpty').show();*/
        common.ajax(common.util.getControllerUrl('deleteAllRecentKeyword', 'product'), {}, "", function () {
            $('#tab2').html("<div class=\"empty-content\">\n" +
                "\t\t\t\t\t\t\t최근 검색어가 없습니다.\n" +
                "\t\t\t\t\t\t</div>");
        });
    });

    $(".search-input.after").on("change keyup paste", function () {
        var currentVal = $(this).val();
        if (currentVal == "") {
            $(this).siblings(".search-close.after").hide();
        } else {
            $(this).siblings(".search-close.after").show();
        }
    }).trigger('change');

    $('#devRandomCouponIssue').on('click',function(){
        common.ajax(common.util.getControllerUrl('randomCouponIssue', 'coupon'), '', "", function (result) {
            if (result.result == "success") {
                common.noti.alert('쿠폰 발급이 완료 되었습니다.');
            } else if(result.data.fail_code == "notCoupon"){
                common.noti.alert('발급 가능한 쿠폰 정보가 없습니다.');
            }  else if(result.data.fail_code == "giveCoupon"){
                common.noti.alert('보유중이거나 사용이 중지된 쿠폰입니다.');
            } else {
                common.noti.alert('발급 처리에 실패했습니다.');
            }
            $('#devRandomCouponArea').hide();
        })
    });

});


//검색 후 X표 클릭시
function searchTxtRemove() {
    $(".search-input.after").val("");
    $(".search-close.after").hide();
}

function devRecentKeyWordDelete(val){
    $(this).closest('[devDelkey]').remove();
    common.ajax(common.util.getControllerUrl('deleteRecentKeyword', 'product'), {searchText: delText}, "", function () {
        if($('.ul-recent-search').children().length == 0){
            $('#tab2').html("<div class=\"empty-content\">\n" +
                "\t\t\t\t\t\t\t최근 검색어가 없습니다.\n" +
                "\t\t\t\t\t\t</div>");
        }
    });
}

function searchLayerOpen() {
    window.oriScroll = $(window).scrollTop();
    $('.br__search').show();
    $("#devHeaderSearchText").show().focus();
    $('.br__floating-btn').hide();
    $('body').css('position', 'fixed');
    $('.clearfix').css('display', 'none');

    var item = $(".late__word").find(".search__list");

    if (item.css("display") == "block") {
        $("#devRecentKeyWordDeleteAll").show();
    } else {
        $("#devRecentKeyWordDeleteAll").hide();
    }
}

function searchLayerClose() {
    $('.br__search').hide();
    $('.br__floating-btn').show();
    $("#devHeaderSearchText").blur().val("");
    $('body').css('position', 'relative');
	$("body").removeClass("scrollNO");
    $(window).scrollTop(window.oriScroll);
}



/////////////////////////////////////////////////////////



function goSearch(id) {
    autoSearch.searchCallBack(id);
}


function post_to_url(path, params, method) {
    method = method || "get";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for (var key in params) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", encodeURI(encodeURIComponent(params[key])));
        form.appendChild(hiddenField);
    }
    document.body.appendChild(form);
    form.submit();
}

function removeHeaderTag(value){
	var removeHeaderValue = value.replace(/(<([^>]+)>)/gi,"");
	var removeHeaderValue = removeHeaderValue.replace(/alert/gi,"");
	var removeHeaderValue = removeHeaderValue.replace(/onclick=/gi,"");
	$('#devHeaderSearchText').val(removeHeaderValue);
}

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('search.alert.empty', '검색어는 1글자 이상 입력해 주세요.');


$(document).ready(function () {
    $('.devLogout').on('click', function () {
        signOut();
        location.href = '/member/logout';
    });
});


const lazyload = () =>{	/* 2024-02-21 lazyload 추가 */
	/*
	 * {layoutCommon.templetSrc}/images/common/loading.gif 로딩 이미지 샘플
	 * attribute : data-src
	 * */
	const $target = $('img[data-src]');
	$target.Lazy({
		threshold: 50
	});

};

/**
 * 자동 검색 완성 
 * @type type
 */
var autoSearch = {
    searchText: false,
    searchCallBack: function (id) {	//검색입력 우측 검색이미지 클릭시 검색페이지 호출
        var self = autoSearch;
        //var searchText = $('#devHeaderSearchText').val();
        var pattern = /([^가-힣|a-z|A-Z|0-9|\x20])/i;
        
        if(!self.searchText){
            self.searchText = $('#' + id).val();
        }

        if (self.searchText == '') {
            alert(common.lang.get('search.alert.empty'));
            $("#" + id).focus();
            return false;
        } else {
            post_to_url('/shop/search', {'searchText': self.searchText});
        }
        return false;

    },
    initClick: function () {
        var self = autoSearch;
        $(document).on("click", ".br__search__layer .auto-complete__list a", function () {
            self.searchText = $(this).text();
            self.searchCallBack();            
            return false;
        });
    },
    initAuotcomplete: function () {
        var self = autoSearch;
		if($(".devAutoComplete").length > 0){		/* 2024-02-21 AutoComplete 있을시만 적용 */
			$(".devAutoComplete").autocomplete({
				source: self.searchAutocomplete,
				delay: 500,
				select: function (event, ui){                
				},
				open: function () {
					$('.ui-menu-item span').removeClass('ui-menu-item-wrapper');
					$('.ui-menu-item div').removeClass('ui-menu-item-wrapper');
				},
				close: function() {
					//$(".br__search__layer").hide();
				},
			}).data('ui-autocomplete')._renderItem = function (ul, item) {
				ul.addClass("top-item");
				$(".br__search__layer").show();
				var li = $('<li style=\'margin:10px\'></li>')
						.data("ui-autocomplete-item", item)
						.append("<a href='/shop/search/?searchText=" + encodeURI(item.value) + "'>" + item.label + "</a><button></button>")
						.appendTo(ul);

				$(".auto-complete__list").append(li);
				return li;
			};
		}
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
                        $(".auto-complete__list > li").remove();
                        return true;
                    },
                    function (response) {

                        if (response.result == "success" && typeof response.data !== "undefined" && response.data.length > 0) {
                            self.cache[term] = response.data;
                            $(".auto-complete__list > li").remove();
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
