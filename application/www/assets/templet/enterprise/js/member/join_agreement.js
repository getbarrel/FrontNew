"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//약관 전체 동의 클릭시
$('#agree-all').click(function () {
    if ($(this).is(':checked')) {
        $('input[name^=policyIx]:not(:checked),#agree-term6,#agree-term7').prop('checked', true);
    } else {
        $('input[name^=policyIx]:checked,#agree-term6,#agree-term7').prop('checked', false);
    }
});

//각 항목 클릭시
$('input[name^=policyIx]').click(function () {
    if ($('input[name^=policyIx]').length == $('input[name^=policyIx]:checked').length) {
        $('#agree-all').prop('checked', true);
    } else {
        $('#agree-all').prop('checked', false);
    }
});

//마케팅 활용 동의 선택
$('#agree-term5').click(function () {
    if ($(this).is(':checked')) {
        $('#agree-term6,#agree-term7').prop('checked', true);
    } else {
        $('#agree-term6,#agree-term7').prop('checked', false);
    }
});

//SMS,이메일 수신 클릭시 마케팅 활용 동의 체크수정
$('#agree-term6,#agree-term7').click(function () {
    if (!$('#agree-term6').is(':checked') && !$('#agree-term7').is(':checked')) {
        $('#agree-term5').prop('checked', false);
    } else if ($('#agree-term6').is(':checked') && $('#agree-term7').is(':checked')) {
        $('#agree-term5').prop('checked', true);
    }
});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('joinAgreement.cancel.confirm', "회원 가입을 취소하시겠습니까?"); //Confirm_01
common.lang.load('joinAgreement.required.message', "필수 약관에 모두 동의 후 가입 진행이 가능합니다."); //Alert_03

//-----set input format

//-----set validation
common.validation.set($('.devRequired'), {
    'required': true,
    'requiredMessageTag': "joinAgreement.required.message"
});

//-----약관동의
var $form = $('#devForm');
var url = common.util.getControllerUrl('joinAgreePolicy', 'member');
var beforeCallback = function ($form) {
    return common.validation.check($form, 'alert', false);
};
var successCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/join_input.php';
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($form, url, beforeCallback, successCallback);

$('#devSubmitButton').click(function (e) {
    e.preventDefault();
    $form.submit();
});

//-----취소
var authCancel = function () {
    document.location.href = '/';
}
$('#devCancelButton').click(function (e) {
    e.preventDefault();
    common.noti.confirm(common.lang.get('joinAgreement.cancel.confirm'), authCancel);
});