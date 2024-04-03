"use strict";

// $(document).ready(function () {
//     $('.date-pick').datepicker();
// });

//radio 기능을 하는 버튼
// $(function () {
//     $('.jq-radio a').click(function () {
//         $(this).addClass('on').siblings().removeClass('on');
//     });
// });

$(function () {
    $('.toggle').on('click', function () {

        $(this).toggleClass('on');
    });
});

// 마이페이지 all check
$(function () {
    $('#all-check').click(function () {
        var check = $("#all-check").prop("checked");
        $(".item-check").prop("checked", check);

    })

    $('.item-check').click(function () {
        if ($('.item-check').length == $('.item-check:checked').length) {
            $('#all-check').prop('checked', true);
        } else {
            $('#all-check').prop('checked', false);
        }
    });

// 탭
    $('.tab-control .tab-link a').on('click', function (e) {
        var currentAttrValue = jQuery(this).attr('href');
         $('.tab-control ' + currentAttrValue).show().siblings().hide();
        $(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });

    $('.tab-js a').on('click', function (e) {
        var currentAttrValue = $(this).attr('href');
        $('.wrap-tab-cont ' + currentAttrValue).show().siblings().hide();
        $(this).add($(this).parent('li')).addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
});




function popup_customer() {
    window.oriScroll = $(window).scrollTop();
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast", 0.8);

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

}


// pc 모달 팝업

function popupCenter(target) {
    if(!target){
        target = $('.popup-layout');
    }
    /*if(target) {
        target.css({
            "margin-top" : -(target.height() / 2),
            "margin-left" : -(target.width() / 2),
            "top" : "50%",
            "left" : "50%",
        })
    } else {
        console.log('a');   `
        var left = ($(window).scrollLeft() + ($(window).width() - $('.popup-layout').width()) / 2);
        var left = (($(window).width() - $('.popup-layout').width()) / 2);
        var top = (($(window).height() - $('.popup-layout').height()) / 2) + $(window).scrollTop();
        $('.popup-layout').css({'left': left, 'top': top, 'position': 'fixed', 'margin' : 0});
    }*/
    target.css({
        'position':'fixed',
        'top':'50%',
        'left':'50%',
        // 'transform':'translate(-50%,-50%)',
        //"margin-top" : -(target.height() / 2),
        //"margin-left" : -(target.width() / 2),

    })
}


$(document).ready(function () {

    // 닫기(close)를 눌렀을 때 작동합니다.
    $('.popup-layout .close, .popup-mask').click(function (e) {
        e.preventDefault();
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
        // $("[data-visible]").attr("data-visible", "");
        // $("[data-target]").attr("data-target", "");
        return false;
    });

    // 뒤 검은 마스크를 클릭시에도 모두 제거하도록 처리합니다.

    $(window).resize(function () {
        popupCenter();
    });
});

function layerClose(){
    event.preventDefault();
    $('.popup-mask, .popup-layout').hide();
    $('body').css({
        'position': '',
        'margin-top': ''
    });
    $(window).scrollTop(window.oriScroll);
}

// 팝업 끝



//글자 수 체크
function onkeylengthMax(formobj, maxlength, objid) {
    var li_byte = 0;
    var li_len = 0;

    for (var i = 0; i < formobj.value.length; i++) {
        if (escape(formobj.value.charAt(i)).length > 4) {
            li_byte += 2;
        } else {
            li_byte++;
        }

        if (li_byte <= maxlength) {
            li_len = i + 1;
        }
    }
    $('#' + objid).text(li_byte / 2);
    // if (li_byte > maxlength) {
    //     alert('ㅇㅇ');
    //     formobj.value = formobj.value.substr(0, li_len);
    //     onkeylengthMax(formobj, maxlength, objname);
    // }
    formobj.focus();
}
