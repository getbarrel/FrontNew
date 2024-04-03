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
common.lang.load('password.change.notMatch', "비밀번호가 일치하지 않습니다.");
common.lang.load('password.change.equal', "현재 비밀번호와 다르게 입력해 주세요.");
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
        if(response.result == 'equalCurrentPw'){
            common.noti.alert(common.lang.get("password.change.equal"));
        }else{
            common.noti.alert('system error');
        }
    }
};

// *** 패스워드 변경 연장
$('#devContinueButton').click(function (e) {
    e.preventDefault();
    common.ajax(common.util.getControllerUrl('passwordContinue', 'member'), "", continueBeforeCallback, continueSuccessCallback);
});

// *** 비밀번호 변경
var $form = $('#devForm');
var url = common.util.getControllerUrl('changePassword', 'member');
var beforeCallback = function ($form) {
    $('[devTailMsg=notMatched]').html("");

    if(common.validation.check($form, 'alert', false) == false){
        if($("#devUserPassword").val() != $("#devUserComparePassword").val() && $("#devUserPassword").val() != "" && $("#devUserComparePassword").val() != ""){
            $('[devTailMsg=devUserComparePassword]').html(common.lang.get("password.change.notMatch"));
        }
    }else{
        return true;
    }

    return common.validation.check($form);
};

// ***  비밀번호 변경
var successCallback = function (response) {
    if (response.result == "success") {
        location.replace(response.data.url);
    }else if(response.result == 'equalCurrentPw'){
        common.noti.alert(common.lang.get("password.change.equal"));
    } else {
        common.noti.alert('system error');
    }
};

common.form.init($form, url, beforeCallback, successCallback);
$('#devSubmitButton').click(function (e) {
    e.preventDefault();
    $form.submit();
});

/*
var successLocation = function () {
    location.replace(responseUrl);
}
*/

//-----휴면회원 비밀번호 변경 취소시
//취소
$('#devSleepCancelButton').click(function (e) {
    e.preventDefault();
    common.noti.confirm(common.lang.get('password.sleep.cancel.confirm'), sleepReleaseCancel);
});
var sleepReleaseCancel = function () {
    location.href = '/member/logout';
}

// *** 유효성 체크 추가
$("#devUserPassword").focusout(function(){
    var re = common.validation.checkElement(this);
    if (!re.success) {
        common.noti.tailMsg(this.id, re.message);
    } else {
        common.noti.tailMsg(this.id);
    }
});

// *** 유효성 체크 추가
$("#devUserComparePassword").focusout(function(){
    var re = common.validation.checkElement(this);
    if (!re.success) {
        common.noti.tailMsg(this.id, re.message);
    } else {
        common.noti.tailMsg(this.id);
    }
});