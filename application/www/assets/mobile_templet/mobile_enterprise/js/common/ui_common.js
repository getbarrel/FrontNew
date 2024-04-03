"use strict";


//radio 기능을 하는 버튼
$(function(){
    $('.jq-radio *').click(function(){
        $(this).addClass('on').siblings().removeClass('on');
    });
});


$(function(){
    $('.toggle').on('click', function(){
        $(this).toggleClass('on');
    });
});



//약관 내용 보기
$(".terms-content").hide();
$(".accord-btn").click(function () {
    $(this).toggleClass("on");
    $(this).parents().next('.terms-content').slideToggle(200);
});


$(function() {
    //뒤로가기 버튼
    $('.wrap-title button').on('click',function(){
        parent.history.back(-1);
        return false;
    });

    $('.tab-js a').on('click', function (e) {
        var currentAttrValue = $(this).attr('href');
        $('.wrap-tab-cont ' + currentAttrValue).show().siblings().hide();
        $(this).addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
});


//tab
function tab() {
    var $tabBtn = $(".tabjs a");
    $tabBtn.on('click', function (e) {
        e.preventDefault();
        var $target = $(this).attr("href") || $(this).data("target");
        $(this).addClass("on").siblings().removeClass("on");
        $($target).addClass("on").siblings(".tab-con").removeClass("on");
    });
}


//all check
$(function() {
    $("#all_check").click(function(){
        if($("#all_check").prop("checked")) {
            $("input[type=checkbox]:enabled").prop("checked", true);
        }
        else{
            $("input[type=checkbox]:enabled").prop("checked",false); }
    });

    if($("#all_check").prop("checked")) {
        $("input[type=checkbox]:enabled").prop("checked", true);
    }

});

//top
$(function() {
    var btnTop = $('.btn-top');

    btnTop.hide();

    btnTop.on('click', function(e){
        e.preventDefault();

        $('body, html').stop().animate({
            scrollTop : 0
        });
    });

    $(window).off('scroll.scrollEvt').on('scroll.scrollEvt', function(){

        var header = $('#header');

        if($(this).scrollTop() > header.height()){
            btnTop.stop().fadeIn();
        }
        else{
            btnTop.stop().fadeOut();
        }

    }).trigger('scroll');
});



function popupCenter(){
    // 레이어 팝업을 가운데로 띄우기 위해 화면의 높이와 너비의 가운데 값과 스크롤 값을 더하여 변수로 만듭니다.
    var left = ( $(window).scrollLeft() + ( $(window).width() - $('.popup-layout').width()) / 2 );
    //var top = (  ( $(window).height() - $('.popup-layout').height() - 60 ) / 2 );
    var top = ( $(window).height() / 2 ) - ( $('.popup-layout').height() / 2 );

    // css 스타일을 변경합니다.
    $('.popup-layout').css({'left':left,'top':top, 'position':'fixed'});
}



function popup_customer_m(){
    window.oriScroll = $(window).scrollTop();

    // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast",0.8);

    popupCenter();

    $.each($(".popup-content"), function() {
        var $this = $(this);
        if(!!$this.attr("data-visible")) {
            $this.parent().css({
                "display" : "block",
                "position" : "fixed"
            })
            popupCenter($this.parent());
        }
    });
    $('body').css({
        'position' : 'fixed',
        'margin-top' : -window.oriScroll
    });

    $('.popup-layout').show();
    /*
    // 레이어 팝업을 띄웁니다.
    $('.popup-layout').show();
    window.bodyScroll.fix();
    $('body').css('position' , 'fixed');*/
}

function popup_customer_zipcode_m(){
    window.oriScroll = $(window).scrollTop();

    // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast",0.8);
    popupCenter();

    $('body').css({
        'position' : 'fixed',
        'margin-top' : -window.oriScroll
    });

    $('.popup-layout').show();
    $('#coupon-pop').css('display', 'none');
    $('#coupon-deily-pop').css('display', 'none');
}

function popup_customer_coupon_m(){
    window.oriScroll = $(window).scrollTop();

    // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast",0.8);
    popupCenter();

    $('body').css({
        'position' : 'fixed',
        'margin-top' : -window.oriScroll
    });

    $('.popup-layout').show();
    $('#modalDefault').css('display', 'none');
    $('#modalMaskDefault').css('display', 'none');
    $('#coupon-deily-pop').css('display', 'none');

}


function popup_customer_deily_coupon_m(){
    window.oriScroll = $(window).scrollTop();

    // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast",0.8);
    popupCenter();

    $('body').css({
        'position' : 'fixed',
        'margin-top' : -window.oriScroll
    });

    $('.popup-layout').show();
    $('#modalDefault').css('display', 'none');
    $('#modalMaskDefault').css('display', 'none');
    $('#coupon-pop').css('display', 'none');
}




$(document).ready(function(){

    // 닫기(close)를 눌렀을 때 작동합니다.
    $('.slide-popup-layout').on('click', '.close', function (e) {
        e.preventDefault();

        $('.slide-popup-layout').removeClass('open').slideUp();
        $('body').css({
            'position': '',
            'margin-top': ''
        });
        $(window).scrollTop(window.oriScroll);
    });
    // 닫기(close)를 눌렀을 때 작동합니다.
    $('.popup-layout').on('click', '.close', function (e) {
        e.preventDefault();

        // if($("#devModalTitle").text() == "혜택내역") {
        //     $('.popup-content .layer__benefit-list').remove();
        // }
        //$('.popup-mask, .popup-layout').hide();
        // $('body').css('position' , 'relative');
        // $(window).scrollTop(window.oriScroll);
        //window.bodyScroll.release();

        $('.popup-mask, .popup-layout').css({
            "display" : "none",
            "margin" : 0,
            "top" : 0,
            "left" : 0
        });
        $('body').css({
            'position': '',
            'margin-top': ''
        });
        $(window).scrollTop(window.oriScroll);
    });

    // 뒤 검은 마스크를 클릭시에도 모두 제거하도록 처리합니다.
    $('.popup-mask').click(function () {
        /*$(this).hide();
        $('.popup-layout').hide();
        //$('body').css('position' , 'relative');
        //$(window).scrollTop(window.oriScroll);
        window.bodyScroll.release();*/
        $('.popup-mask, .popup-layout').css({
            "display" : "none",
            "margin" : 0,
            "top" : 0,
            "left" : 0
        });
        $('body').css({
            'position': '',
            'margin-top': ''
        });
        $(window).scrollTop(window.oriScroll);
    });

    $(window).resize(function(){
        popupCenter();
    });
});

// 팝업 끝




// 모바일 팝업-아이프레임용 -패딩버전
function popup_frame(){
    window.oriScroll = $(window).scrollTop();
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    //$('.popup-mask').css({'width':maskWidth,'height':maskHeight});
    //$('.popup-mask').fadeIn(100);
    //$('.popup-mask').fadeTo("fast",0.8);

    $('.popup-frame-layout').css({'left':'0','top':'0', 'position':'fixed'});

    $('.popup-frame-layout').show();
    $('body').css('position' , 'fixed');
}

$(document).ready(function(){
    // $('.popup-mask').click(function(e){
    //     e.preventDefault();
    //     popup_frame();
    // });
    //
    // $('.close').click(function (e) {
    //     e.preventDefault();
    //     $('.popup-mask, .popup-frame-layout').hide();
    // });
    //
    // $('.pub-pop-mask-frame').click(function () {
    //     $(this).hide();
    //     $('.pub-pop-frame').hide();
    // });
    $('.popup-frame-layout .close').click(function (e) {
        e.preventDefault();
        $('.popup-mask, .popup-frame-layout').hide();
        $('body').css('position' , 'relative');
        $(window).scrollTop(window.oriScroll);
    });

    // 뒤 검은 마스크를 클릭시에도 모두 제거하도록 처리합니다.
    // $('.popup-mask').click(function () {
    //     $(this).hide();
    //     $('.popup-layout').hide();
    //     $('body').css('position' , 'relative');
    //     $(window).scrollTop(window.oriScroll);
    // });
});


// 팝업1
function popup_t1() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('.popup-mask').css({'width': maskWidth, 'height': maskHeight});
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast", 0.8);

    var left = ( $(window).scrollLeft() + ( $(window).width() - $('.pub-pop-window-t1').width()) / 2 );
    var top = ( $(window).scrollTop() + ( $(window).height() - $('.pub-pop-window-t1').height()) / 2 );

    $('.pub-pop-window-t1').css({'left': left, 'top': top, 'position': 'absolute'});
    $('.pub-pop-window-t1').show();
}

$(document).ready(function () {
    $('.showMask').click(function (e) {
        e.preventDefault();
        popup_t1();
    });

    $('.pub-pop-window-t1 .close').click(function (e) {
        e.preventDefault();
        $('.popup-mask, .pub-pop-window-t1').hide();
    });

    $('.popup-mask').click(function () {
        $(this).hide();
        $('.pub-pop-window-t1').hide();
    });
});

// 팝업2
function popup_t2() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('.pub-pop-mask-t2').css({'width': maskWidth, 'height': maskHeight});
    $('.pub-pop-mask-t2').fadeIn(100);
    $('.pub-pop-mask-t2').fadeTo("fast", 0.8);

    var left = ( $(window).scrollLeft() + ( $(window).width() - $('.pub-pop-window-t2').width()) / 2 );
    var top = ( $(window).scrollTop() + ( $(window).height() - $('.pub-pop-window-t2').height()) / 2 );
    $('.pub-pop-window-t2').css({'left': left, 'top': top, 'position': 'absolute'});

    $('.pub-pop-window-t2').show();
}

$(document).ready(function () {
    $('.showMask-t2').click(function (e) {
        e.preventDefault();
        popup_t2();
    });

    $('.pub-pop-window-t2 .close2').click(function (e) {
        e.preventDefault();
        $('.pub-pop-mask-t2, .pub-pop-window-t2').hide();
    });

    $('.pub-pop-mask-t2').click(function () {
        $(this).hide();
        $('.pub-pop-window-t2').hide();
    });
});


// 팝업3
function popup_t3() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('.pub-pop-mask-t3').css({'width': maskWidth, 'height': maskHeight});
    $('.pub-pop-mask-t3').fadeIn(100);
    $('.pub-pop-mask-t3').fadeTo("fast", 0.8);

    var left = ( $(window).scrollLeft() + ( $(window).width() - $('.pub-pop-window-t3').width()) / 2 );
    var top = ( $(window).scrollTop() + ( $(window).height() - $('.pub-pop-window-t3').height()) / 2 );
    $('.pub-pop-window-t3').css({'left': left, 'top': top, 'position': 'absolute'});

    $('.pub-pop-window-t3').show();
}

$(document).ready(function () {
    $('.showMask-t3').click(function (e) {
        e.preventDefault();
        popup - t3();
    });

    $('.pub-pop-window-t3 .close3').click(function (e) {
        e.preventDefault();
        $('.pub-pop-mask-t3, .pub-pop-window-t3').hide();
    });

    $('.pub-pop-mask-t3').click(function () {
        $(this).hide();
        $('.pub-pop-window-t3').hide();
    });
});

// 팝업4
function popUp() {
    var $popWrap = $(".pub-pop-wrap"),
        $open = $(".pub-btn-open"),
        $close = $(".pub-pop-wrap .close"),
        $mask = $(".pub-mask");

    $open.click(function () {
        $popWrap.addClass("on");
        $mask.addClass("on");
    });

    $close.click(function () {
        $popWrap.removeClass("on");
        $mask.removeClass("on");
    });

}

function popupOpen($target) {
    var $dim = $(".pub-mask");
    $target.stop().faedIn();
    $dim.stop().faedIn();
}
function popupClose($target) {
    var $dim = $(".pub-mask");
    $target.stop().faedOut();
    $dim.stop().faedIn();
}


$(window).on("load", function () {
    popUp();
    tab();

});


/*헤더*/
/* main promotion */
// $(function() {
//     $('.main-promotion .flexslider').flexslider({
//         animation: "slide",
//         controlNav: false,
//         directionNav: false,
//         pausePlay: false,
//         animationLoop: false
//     });
// })

$(function() {
    var navH = $(window).height();
    $('#header .menu').on('click',function() {

        if (!$('#document').is('.menu-open')) {
            $('#document').addClass('menu-open').css({height:navH});
            $('#navigation .dim').show();
        } else {
            $('#document').removeClass('menu-open').css({height:'auto'});
            $('#navigation .dim').hide();
        }
    })
    $('#navigation .pannel').on('click',function() {
        $('#document').removeClass('menu-open').css({height:'auto'});
        $('#navigation .dim').hide();
    });
})

$(function() {
    $('#document .dim, #document .menu-close').click(function(){
        $('#header .menu').click();
    });
})

/* fixed-menu control */
$(function() {
    $('#menu-fixed-bottom .utill-open').on('click',function() {
        var dimmed = $('<div class="dimmed2" />'),
            _this = $(this);
        if (!$($(this).attr('href')).is('.active')) {
            $($(this).attr('href')).addClass('active');
            dimmed.appendTo($('body'));
            _this.addClass('active');
        } else {
            $($(this).attr('href')).removeClass('active');
            $('.dimmed2').remove();
            _this.removeClass('active');
        }
    })
})

