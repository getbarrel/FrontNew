"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('write.customer.register', "1:1 문의를 등록하시겠습니까?"); // Confirm_04
common.lang.load('write.customer.cancel', "1:1 문의 작성을 취소하시겠습니까?"); // Confirm_03
common.lang.load('write.customer.cancel.inquiry', "1:1 문의내역으로 이동 시 입력중인 내용은 삭제됩니다. 그래도 이동하시겠습니까?"); // Confirm_32

common.lang.load('write.customer.fail', "다시 입력해 주세요.");
common.lang.load('write.customer.success', "1:1 문의가 등록되었습니다. \n문의 상세 내역은 마이페이지 > 1:1 문의내역에서 확인하실 수 있습니다."); // Alert_77
common.lang.load('write.customer.bbsdev.fail', "분류항목을 선택해 주세요.");
common.lang.load('write.customer.file.find', "파일찾기");
common.lang.load('write.customer.file.change', "파일변경");
common.lang.load('write.customer.file.confirm.delete', "파일을 삭제하시겠습니까?");
common.lang.load('write.customer.file.type.check', "파일 형식이 올바르지 않습니다. \n다시 첨부해주세요.");
common.lang.load('write.customer.file.size.check', "파일 용량이 최대 30MB를 초과했습니다. \n다시 첨부해주세요.");

common.validation.set($('#devBbsDiv'), {'required': true, 'getValueFunction': 'getBbsDivSelect'});
common.validation.set($('#devBbsEmailId, #devBbsEmailHost'), {'required': true, 'dataFormat': 'email', 'getValueFunction': 'getBbsEmail'});
common.validation.set($('#devBbsHp1, #devBbsHp2, #devBbsHp3'), {'required': true, 'dataFormat': 'mobile', 'getValueFunction': 'getBbsMobile'});
common.validation.set($('#devBbsSubject'), {'required': true});
common.validation.set($('#devBbsContents'), {'required': true});
common.inputFormat.set($('#devBbsHp2, #devBbsHp3'), {'number': true, 'maxLength': 4});


// 나의 문의 등록
var $form = $('#devBbsForm');
var url = common.util.getControllerUrl('registerArticle', 'customer');
var beforeCallback = function ($form) {
    if (common.validation.check($form)) {
        if (common.noti.confirm(common.lang.get('write.customer.register'))) {
            return true;
        }
    }
    return false;
};
var successCallback = function (response) {
    if (response.result == "success") {
        common.noti.alert(common.lang.get("write.customer.success"));
        location.href = response.data.url;
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
    if (selectValue != '') {
        $bbsEmailHost.attr('readonly', true);
    } else {
        $bbsEmailHost.attr('readonly', false);
    }
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

$("button[id^='devBbsFileButton']").click(function (e) {
    e.preventDefault();
    var selectBtn = (this.id).split("Button");
    var inputFile = $("#" + selectBtn['0'] + selectBtn['1']);
    inputFile.trigger('click');
});

$("input[id^='devBbsFile']").change(function (e) {
    var sNo = (this.id).split("devBbsFile");
    var fname = $("#devBbsFile" + sNo['1']).val();
    if (fname != "" && fname != "undefined" && sNo['1'] > 0) {
        $('#devBbsFileText' + sNo['1']).val(fname);
        $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.change'));
        $('#devBbsFileDeleteButton' + sNo['1']).show();
    } else {
        $('#devBbsFileText' + sNo['1']).val('')
        $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.find'));
        $('#devBbsFileDeleteButton' + sNo['1']).hide();
    }
});

$("button[id^='devBbsFileDeleteButton']").click(function (e) {
    e.preventDefault();
    var sNo = (this.id).split("devBbsFileDeleteButton");
    if (common.noti.confirm(common.lang.get('write.customer.file.confirm.delete'))) {
        deleteConfirmOk(sNo['1']);
    }else{
        return false;
    }
});

var deleteConfirmOk = function (no) {

    $("#devBbsFile" + no).val('');
    var fname = $("#devBbsFile" + no).val();
    if (fname != "" && fname != "undefined" && no > 0) {
        $('#devBbsFileText' + no).val(fname);
        $('#devBbsFileButton' + no).text(common.lang.get('write.customer.file.change'));
        $('#devBbsFileDeleteButton' + no).show();
    } else {
        $('#devBbsFileText' + no).val('')
        $('#devBbsFileButton' + no).text(common.lang.get('write.customer.file.find'));
        $('#devBbsFileDeleteButton' + no).hide();
    }
};

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

    if($('#devBbsDiv').val() == ''){
        alert('분류를 선택해주세요');
        return false;
    }
    if($('#devBbsEmailId').val() == '' && $('#devBbsEmailHost').val() == ''){
        alert('이메일을 확인해주세요');
        return false;
    }
    if($('#devBbsHp1').val() == '' && $('#devBbsHp2').val() == '' && $('#devBbsHp3').val() == ''){
        alert('휴대폰번호를 확인해주세요');
        return false;
    }
    if($('#devBbsSubject').val() == ''){
        alert('제목을 입력해주세요');
        return false;
    }
    if($('#devBbsContents').val() == ''){
        alert('내용을 입력해주세요');
        return false;
    }

    $form.submit();
});

$('#devBtnOrderQuery').click(function (e) {
    common.util.modal.open('ajax', '주문번호 조회', '/popup/orderList', '');
});

$('#devBtnOrderdel').click(function (e) {
    $("#devOid").val("");
});

$(document).on("click", ".btn-orderlayer-close",function() {
    $(this).parents(".popup-layout").find(".close").trigger("click");
    return false;
});

$('#devModalContent').on('click', '.btn-xs', function () {
    $("#devOid").val($(this).data('oid'));
    $('.popup-layout .close').trigger('click');
});

$("input[id^='devBbsFile']").change(function (e) {
    e.preventDefault();
    var allowExt = ['jpg','jpeg','png','gif'];
    var ckExt = false;
    var ckSize = 1024 * 1024 * 3; //30MB

    //$("input[type=file]").each(function(){
    var filesize = $(this)[0].files[0].size;
    var ext = (this.value).split(".");
    var rs = jQuery.inArray(ext['1'],allowExt);
    if(this.value != '' && rs == -1){
        common.noti.alert(common.lang.get('write.customer.file.type.check'));
        ckExt = false;
        var sNo = (this.id).split("devBbsFile");
        deleteConfirmOk(sNo['1']);
        return false;
    }else if(this.value != '' && filesize > ckSize){
        common.noti.alert(common.lang.get('write.customer.file.size.check'));
        ckExt = false;
        var sNo = (this.id).split("devBbsFile");
        deleteConfirmOk(sNo['1']);
        return false;
    }else{
        var sNo = (this.id).split("devBbsFile");
        var fname = $("#devBbsFile" + sNo['1']).val();
        if (fname != "" && fname != "undefined" && sNo['1'] > 0) {
            $('#devBbsFileText' + sNo['1']).val(fname);
            $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.change'));
            $('#devBbsFileDeleteButton' + sNo['1']).show();
        } else {
            $('#devBbsFileText' + sNo['1']).val('')
            $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.find'));
            $('#devBbsFileDeleteButton' + sNo['1']).hide();
        }
    }
    //});
});