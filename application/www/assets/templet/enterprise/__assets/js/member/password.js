"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('password.change.success', "비밀번호가 정상적으로 변경되었습니다."); //Alert_18
common.lang.load('password.sleep.cancel.confirm', "휴면 계정 해제를 취소하시겠습니까?{common.lineBreak}취소 시 비로그인 상태로 유지됩니다."); //Confirm_28

//-----set input format

//-----set validation
common.validation.set($('#devUserPassword'), {'required': true, 'dataFormat': 'userPassword'});
common.validation.set($('#devUserComparePassword'), {'required': true, 'compare': '#devUserPassword'});

//-----재알림
var continueBeforeCallback = "";
var continueSuccessCallback = function (response) {
    if (response.result == "success") {
        location.replace('/');
    } else {
        common.noti.alert('system error');
    }
};
$('#devContinueButton').click(function (e) {
    e.preventDefault();
    common.ajax(common.util.getControllerUrl('passwordContinue', 'member'), "", continueBeforeCallback, continueSuccessCallback);
});

//-----변경
var $form = $('#devForm');
var url = common.util.getControllerUrl('changePassword', 'member');
var beforeCallback = function ($form) {
    return common.validation.check($form);
};
var responseUrl = "";
var successCallback = function (response) {
    if (response.result == "success") {
        responseUrl = response.data.url;
        common.noti.alert(common.lang.get("password.change.success"), successLocation);
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($form, url, beforeCallback, successCallback);

$('#devSubmitButton').click(function (e) {
    e.preventDefault();
    $form.submit();
});

var successLocation = function () {
    location.replace(responseUrl);
}

//-----휴면회원 비밀번호 변경 취소시
//취소
$('#devSleepCancelButton').click(function (e) {
    e.preventDefault();
    common.noti.confirm(common.lang.get('password.sleep.cancel.confirm'), sleepReleaseCancel);
});
var sleepReleaseCancel = function () {
    location.href = '/member/logout';
}