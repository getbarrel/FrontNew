"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//약관 전체 동의 클릭시
$('#agree-all').click(function () {
    if ($(this).is(':checked')) {
        $('input[name^=policyIx]:not(:checked)').prop('checked', true);
    } else {
        $('input[name^=policyIx]:checked').prop('checked', false);
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
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('sleep.cancel.confirm', "휴면 계정 해제를 취소하시겠습니까?{common.lineBreak}취소 시 비로그인 상태로 유지됩니다."); //Confirm_28
common.lang.load('sleep.company.noMatchData', '사업자 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요.'); //Alert_12
common.lang.load('sleep.company.success', "인증되었습니다."); //Alert_10
common.lang.load('sleep.required.message', "필수 약관에 모두 동의 후 가입 진행이 가능합니다."); //Alert_03

//-----set input format
common.inputFormat.set($('#devComName'), {'maxLength': 30});
common.inputFormat.set($('#devComNumber1'), {'number': true, 'maxLength': 3});
common.inputFormat.set($('#devComNumber2'), {'number': true, 'maxLength': 2});
common.inputFormat.set($('#devComNumber3'), {'number': true, 'maxLength': 5});

//-----set validation
common.validation.set($('#devComName'), {'required': true});
common.validation.set($('#devComNumber1,#devComNumber2,#devComNumber3'), {
    'required': true,
    'dataFormat': 'companyNumber',
    'getValueFunction': 'getCompanyNumber'
});
var getCompanyNumber = function () {
    return $('#devComNumber1').val() + $('#devComNumber2').val() + $('#devComNumber3').val();
}
common.validation.set($('.devRequired'), {
    'required': true,
    'requiredMessageTag': "sleep.required.message"
});

//----0.공통
var sleepMemberReleasePageReload = function () {
    document.location.reload();
}
//취소
$('#devCancelButton').click(function (e) {
    common.noti.confirm(common.lang.get('sleep.cancel.confirm'), sleepReleaseCancel);
});
var sleepReleaseCancel = function () {
    location.href = '/member/logout';
}

//----1.안내
$('#devNextSleepMemberReleaseAuth').click(function () {
    common.ajax(common.util.getControllerUrl('nextSleepMemberReleaseAuth', 'member'), "", "", sleepMemberReleasePageReload);
});

//----2.인증
//--2.1 일반
//본인 인증
$('#devCertifyButton').click(function (e) {
    e.preventDefault();
    common.certify.request('certify');
});
//아이핀 인증
$('#devIpinButton').click(function (e) {
    e.preventDefault();
    common.certify.request('ipin');
});
//인증 성공시
common.certify.setSuccess(function (data) {
    common.ajax(common.util.getControllerUrl('nextSleepMemberReleasePolicyBasic', 'member'), "", "", sleepMemberReleasePageReload);
});

//--2.2 사업자
var $comform = $('#devCompanyForm');
var comUrl = common.util.getControllerUrl('nextSleepMemberReleasePolicyCompany', 'member');
var comBeforeCallback = function ($form) {
    return common.validation.check($form);
};
var comSuccessCallback = function (response) {
    if (response.result == "success") {
        common.noti.alert(common.lang.get('sleep.company.success'), sleepMemberReleasePageReload);
    } else if (response.result == "noMatchData") {
        common.noti.alert(common.lang.get('sleep.company.noMatchData'));
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($comform, comUrl, comBeforeCallback, comSuccessCallback);
$('#devCompanySubmitButton').click(function (e) {
    e.preventDefault();
    $comform.submit();
});

//--3.약관동의
var $form = $('#devForm');
var url = common.util.getControllerUrl('nextSleepMemberReleaseChangePassword', 'member');
var beforeCallback = function ($form) {
    return common.validation.check($form, 'alert', false);
};
var successCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/password';
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($form, url, beforeCallback, successCallback);

$('#devSubmitButton').click(function (e) {
    e.preventDefault();
    $form.submit();
});

//--4.계정활성화
$('#devSleepMemberReleaseComplete').click(function () {
    // common.ajax(common.util.getControllerUrl('sleepMemberReleaseComplete', 'member'), "", "", locationMain);
    location.replace('/member/login');
});

var locationMain = function () {
    location.href = '/';
}