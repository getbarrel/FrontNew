"use strict";

$(document).ready(function () {
    $('.date-pick').datepicker();
});

//radio 기능을 하는 버튼
$(function () {
    $('.jq-radio a').click(function () {
        $(this).addClass('on').siblings().removeClass('on');
    });
});

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
        $(this).addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
});



// pc 모달 팝업

function popupCenter() {
    // 레이어 팝업을 가운데로 띄우기 위해 화면의 높이와 너비의 가운데 값과 스크롤 값을 더하여 변수로 만듭니다.
    var left = ($(window).scrollLeft() + ($(window).width() - $('.popup-layout').width()) / 2);
    var top = (($(window).height() - $('.popup-layout').height() - 80) / 2);

    // css 스타일을 변경합니다.
    $('.popup-layout').css({'left': left, 'top': top, 'position': 'absolute'});
}



function popup_customer() {
    window.oriScroll = $(window).scrollTop();

    // fade 애니메이션 : 1초 동안 검게 됐다가 80%의 불투명으로 변합니다.
    $('.popup-mask').fadeIn(100);
    $('.popup-mask').fadeTo("fast", 0.8);

    popupCenter();

    // 레이어 팝업을 띄웁니다.
    $('.popup-layout').show();
    $('body').css('position', 'fixed');
}


$(document).ready(function () {

    // 닫기(close)를 눌렀을 때 작동합니다.
    $('.popup-layout .close').click(function (e) {
        e.preventDefault();
        $('.popup-mask, .popup-layout').hide();
        $('body').css('position', 'relative');
        $(window).scrollTop(window.oriScroll);
    });

    // 뒤 검은 마스크를 클릭시에도 모두 제거하도록 처리합니다.
    $('.popup-mask').click(function () {
        $(this).hide();
        $('.popup-layout').hide();
        $('body').css('position', 'relative');
        $(window).scrollTop(window.oriScroll);
    });

    $(window).resize(function () {
        popupCenter();
    });
});

function layerClose(){
    event.preventDefault();
    $('.popup-mask, .popup-layout').hide();
    $('body').css('position', 'relative');
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
