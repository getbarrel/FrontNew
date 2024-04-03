"use strict";

$(document).ready(function() {
    // 검색레이어영역 제외 클릭 시 검색 레이어 닫기
    $('body').on('click', function(e){
        var container = $(".search-area");

        if (!container.is(e.target) && container.has(e.target).length === 0){
            searchLayerClose();
        }
    });

    //윈도우 창 resize 시
    $(window).on('resize',function(){
        var window_w = $(window).width();
        if ( window_w > 1700){
            $('.search').css("display","none");
            $('.search').find('form').css("display","none");
        }else{
            $('.wrap-search-layer').css("display","none");
        }
    });

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

    /*1701이상*/
    //상단검색 엔터처리시
    $("#devHeaderSearchText").keyup(function (e) {
        $('#devSearchCloseBtn').show();
        if (e.keyCode == 13)
            goSearch();
    });

    //최근검색어 건별삭제시
    $('#devRecent #devRecentKeyWordDelete').on('click', function () {
        var delText = $(this).attr('devDelText');
        $(this).closest('[devDelkey]').hide();
        common.ajax(common.util.getControllerUrl('deleteRecentKeyword', 'product'), {searchText: delText}, "", function () {
        });
    });

    //최근검색어 전체삭제시
    $('#devRecentKeyWordDeleteAll').on('click', function () {
        $('#devRecent li').hide();
        common.ajax(common.util.getControllerUrl('deleteAllRecentKeyword', 'product'), {}, "", function () {
        });
    });

    //상단검색어 닫기시
    $('#devSearchCloseBtn').on('click', function () {
        $("#devHeaderSearchText").val('');
        $('#devSearchCloseBtn').hide();
    });

    function goSearch() {	//검색입력 우측 검색이미지 클릭시 검색페이지 호출
        var searchText = $('#devHeaderSearchText').val();
        var pattern = /([^가-힣|a-z|A-Z|0-9|\x20])/i;

        if (searchText == '') {
            if ($('#devHeaderSearchText').attr('devTagUrl')) {
                location.href = $('#devHeaderSearchText').attr('devTagUrl');
            } else {
                alert('검색어는 1글자 이상 입력해 주세요.');
                $("#devHeaderSearchText").focus();
                return false;
            }
        } else if (pattern.test(searchText)) {
            alert('검색어는 단어 기준으로 입력해 주세요.');
            $("#devHeaderSearchText").focus();
            return false;
        } else {
            post_to_url('/shop/search',{'searchText':searchText});
        }
        return false;
    }
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