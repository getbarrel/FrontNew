"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(".myInquiry__write-notice").click(function(){
    $(this).hide();
    $(".myInquiry__write-area textarea").focus();
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('write.customer.register', "1:1 문의를 등록하시겠습니까?"); // Confirm_04
common.lang.load('write.customer.cancel', "1:1 문의 작성을 취소하시겠습니까?"); // Confirm_03
common.lang.load('write.customer.cancel.inquiry', "1:1 문의내역으로 이동 시 입력중인 내용은 삭제됩니다. 그래도 이동하시겠습니까?"); // Confirm_32

common.lang.load('write.customer.fail', "다시 입력해 주세요.");
common.lang.load('write.customer.fail1', "저장 경로가 올바르지 않습니다. \n다시 입력해 주세요.");
common.lang.load('write.customer.success', "1:1 문의가 등록되었습니다. \n문의 상세 내역은 마이페이지 > 1:1 문의내역에서 확인하실 수 있습니다."); // Alert_77
common.lang.load('write.customer.bbsdev.fail', "분류항목을 선택해 주세요.");
common.lang.load('write.customer.file.find', "파일찾기");
common.lang.load('write.customer.file.change', "파일변경");
common.lang.load('write.customer.file.confirm.delete', "파일을 삭제하시겠습니까?");
common.lang.load('write.customer.file.type.check', "파일 형식이 올바르지 않습니다. \n다시 첨부해주세요.");
common.lang.load('write.customer.file.size.check', "파일 용량이 최대 30MB를 초과했습니다. \n다시 첨부해주세요.");

common.lang.load('write.customer.pageescape.confirm', "1:1 문의하기 페이지 이탈 시 입력중인 내용은 삭제됩니다.\n그래도 이동하시겠습니까?");

common.validation.set($('#devBbsDiv'), {'required': true, 'getValueFunction': 'getBbsDivSelect'});
common.validation.set($('#devBbsEmailId, #devBbsEmailHost'), {
    'required': true,
    'dataFormat': 'email',
    'getValueFunction': 'getBbsEmail'
});
common.validation.set($('#devBbsHp1, #devBbsHp2, #devBbsHp3'), {
    'required': false,
    'dataFormat': 'mobile',
    'getValueFunction': 'getBbsMobile'
});
common.validation.set($('#devBbsSubject'), {'required': true});
common.validation.set($('#devBbsContents'), {'required': true});

common.inputFormat.set($('#devBbsHp2, #devBbsHp3'), {'number': true, 'maxLength': 4});
common.inputFormat.set($('#devBbsFileText1, #devBbsFileText2, #devBbsFileText3'), {
    'fileFormat': 'image',
    'devFileSize': 30
});


// 나의 문의 등록
var $form = $('#devBbsForm');
var chkClick = false;
var url = common.util.getControllerUrl('registerArticle', 'customer');
var beforeCallback = function ($form) {
    if (common.validation.check($form)) {
        if (common.noti.confirm(common.lang.get('write.customer.register'))) {
            return true;
        }
    }
    chkClick = false;
    return false;
};
var successCallback = function (response) {
    if (response.result == "success") {
        common.noti.alert(common.lang.get("write.customer.success"));
        location.href = response.data.url;
    } else if(response.result == "fail1") {
        common.noti.alert(common.lang.get("write.customer.fail1"));
    } else {
        common.noti.alert(common.lang.get("write.customer.fail"));
    }
};
var writeCancel = function () {
    document.location.href = '/customer';
};

common.form.init($form, url, beforeCallback, successCallback);

$('#devBbsEmailHostSelect').change(function (e) {
    var selectValue = $(this).val();
    var $bbsEmailHost = $('#devBbsEmailHost');
    $bbsEmailHost.val(selectValue);
});

function getBbsEmail() {
    return $('#devBbsEmailId').val().trim() + '@' + $('#devBbsEmailHost').val().trim();
}

function checkBbsEmail() {
    var result = common.validation.checkElement($('#devBbsEmailId').get(0));
    if (result.success) {
        common.noti.tailMsg('devBbsEmailId', '');
    } else {
        common.noti.tailMsg('devBbsEmailId', result.message);
    }
}

function getBbsDivSelect() {
    return $('#devBbsDiv').val().trim();
}

function getBbsMobile() {
    return $('#devBbsHp1').val().trim() + '-' + $('#devBbsHp2').val().trim() + '-' + $('#devBbsHp3').val().trim();
}

function getBbsContents() {
    var tmp = $('#devBbsContents').val().trim();
    return tmp;
}

$("#devDirectInputComEmailCheckBox").change(function (e) {

    if ($(this).is(':checked')) {
        $('#devBbsEmailHostSelect').hide();
        $('#devBbsEmailHost').show();
    } else {
        var host = $('#devBbsEmailHostSelect option:selected').text();
        $('#devBbsEmailHost').val(host);
        $('#devBbsEmailHostSelect').show();
        $('#devBbsEmailHost').hide();
    }
});

$("#devBbsForm :input").change(function () {
    $("#devBbsForm").data("changed", true);
});

$('#devGoMyInquiry').click(function (e) {
    if ($("#devBbsForm").data("changed")) {
        if (!common.noti.confirm(common.lang.get('write.customer.cancel.inquiry'))) {
            return false;
        }
    }
    document.location.href = '/mypage/myInquiry';
});

$(document).ready(function () {
    $("#devBbsForm :input").focusout(function () {
        try {
            var re = common.validation.checkElement(this);
            if (!re.success) {
                common.noti.tailMsg(this.id, re.message);
            } else {
                common.noti.tailMsg(this.id, "");
            }
        } catch (e) {
        }
    });
});

$('#devBbsRegCancel').click(function (e) {
    e.preventDefault();
    common.noti.confirm(common.lang.get('write.customer.cancel'), writeCancel);
});

$('#devBbsRegSubmit').click(function (e) {
    e.preventDefault();
    if(!chkClick) {
        chkClick = true;
        $form.submit();
    }
});

common.lang.load('goodsQnaWrite.orderNumberSearch.title', '주문번호 조회');
$('#devBtnOrderQuery').click(function (e) {
    common.util.slideModal.open('ajax', common.lang.get('goodsQnaWrite.orderNumberSearch.title'), '/popup/orderList', '', window.orderListCallback);
});

$('#devSlideModalContent').on('click', '.m_selbtn', function () {
    $("#devOid").val($(this).data('oid'));
    $('.slide-popup-layout .close').trigger('click');
});

var devPhoto = {
    appCamera: false,
    appPhoto: false,
    getFile: function () {
        if (devAppType == 'iOS') {
            //아이폰용
            try {
                webkit.messageHandlers.showAuthority.postMessage("");
            } catch (err) {
                console.log(err);
            }
        } else if (devAppType == 'Android') {
            //안드로이드용
        }
    },
    getLoad: function () {
        if (devAppType == 'iOS') {
            //아이폰용
            try {
                webkit.messageHandlers.initStatusAuthority.postMessage("");
            } catch (err) {
                console.log(err);
            }
        } else if (devAppType == 'Android') {
            //안드로이드용
        }
    },
    FileChangeEvent: function ($file, $fileWrap, $imageWrap, $image) {
        if ($file.val() != "") {
            $fileWrap.hide();
            $imageWrap.show();
            common.util.previewFile($file, $image);
        } else {
            $fileWrap.show();
            $imageWrap.hide();
            $image.attr('src', '');
        }
    },
    fileAttachments: function(num) {
        var $file = $('#devBbsFileText'+num);
        var $fileWrap = $('#devBusinessFileWrap'+num);
        var $imageWrap = $('#devBusinessFileImageWrap'+num);
        var $image = $('#devBusinessFileImage'+num);
        //var $fileDeleteButton = $('#devBusinessFileDeleteButton'+num);

        $file.change(function () {
            if (devPhoto.appCamera == 'Y' || devPhoto.appPhoto == 'Y') {
                devPhoto.FileChangeEvent($file, $fileWrap, $imageWrap, $image);
            }
        });
    },
    fileDelete: function(num) {
        var $file = $('#devBbsFileText'+num);
        var $fileWrap = $('#devBusinessFileWrap'+num);
        var $imageWrap = $('#devBusinessFileImageWrap'+num);
        var $image = $('#devBusinessFileImage'+num);

        if (common.noti.confirm(common.lang.get('write.customer.file.confirm.delete'))) {
            $file.val('');
            devPhoto.FileChangeEvent($file, $fileWrap, $imageWrap, $image);
        }
    },
    setShowAuthority: function(camera, photo) {
        devPhoto.appCamera = camera;
        devPhoto.appPhoto = photo;
    },
    iosCheck: function(e){
        if (devPhoto.appCamera == 'N' && devPhoto.appPhoto == 'N') {
            devPhoto.getFile();
        }

        if (devPhoto.appCamera == 'N' && devPhoto.appPhoto == 'N') {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    },
    run: function() {
        devPhoto.getLoad();
    }
};

//최초 로드시 권한 여부를 APP에서 줌.
function getShowAuthority(camera, photo) {
    devPhoto.setShowAuthority(camera, photo);
}

//파일첨부 선택시 권한 여부를 APP에서 줌.
function setShowAuthority(camera, photo) {
    devPhoto.setShowAuthority(camera, photo);
}

$(function () {
    devPhoto.run();
});

$('#devBbsFileText1').click(function (e) {
    var chk = true;

    if (devAppType == 'iOS') {
        chk = devPhoto.iosCheck(e, '1');
    }

    if(chk === true) {
        devPhoto.fileAttachments('1');
    }
});

$('#devBbsFileText2').click(function (e) {
    var chk = true;

    if (devAppType == 'iOS') {
        chk = devPhoto.iosCheck(e, '2');
    }

    if(chk === true) {
        devPhoto.fileAttachments('2');
    }
});

$('#devBbsFileText3').click(function (e) {
    var chk = true;

    if (devAppType == 'iOS') {
        chk = devPhoto.iosCheck(e,'3');
    }

    if(chk === true) {
        devPhoto.fileAttachments('3');
    }
});

$('#devBbsDiv').on('change',function(){
    var bbsDiv = $(this).val();
    common.ajax(
        common.util.getControllerUrl('getBbsInfoText', 'bbs'),
        {bbsDiv: bbsDiv},
        '',
        function (ret) {
            if (ret.result == 'success') {
                $('.devBbsPlaceholder').hide();
                $('#devBbsContents').val(ret.data);
            }else{
                $('.devBbsPlaceholder').show();
                $('#devBbsContents').val('');
            }
        }
    );
});

function removeTag(value){
    var removeValue = value.replace(/(<([^>]+)>)/gi,"");
    var removeValue = removeValue.replace(/alert/gi,"");
    var removeValue = removeValue.replace(/onclick=/gi,"");

	$('#devBbsContents').val(removeValue);
}


// $(".write-upload-box button").on("click", function() {
//     var $this = $(this);
//     var _idx = $this.attr("id").replace("devBusinessFileDeleteButton", "");
//     console.log(confirm("파일을 삭제하시겠습니까?"))
//     if(confirm("파일을 삭제하시겠습니까?")) {
//        devPhoto.fileDelete(_idx);
//     }
//
// });

// $('#devBusinessFileDeleteButton1').click(function () {
//     i
// } else {
//     f(confirm("파일을 삭제하시겠습니까?")==true) {
//
//     }
//     devPhoto.fileDelete('1');
// });
//
// $('#devBusinessFileDeleteButton2').click(function () {
//     devPhoto.fileDelete('2');
// });
//
// $('#devBusinessFileDeleteButton3').click(function () {
//     devPhoto.fileDelete('3');
// });
// $('#devBusinessFileDeleteButton3').click(function () {
//     devPhoto.fileDelete('4');
// });