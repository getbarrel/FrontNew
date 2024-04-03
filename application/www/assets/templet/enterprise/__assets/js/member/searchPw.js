"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('searchPw.user.noSearch', '회원가입 이력이 존재하지 않는 정보입니다.'); //Alert_88
common.lang.load('searchPw.user.noMatchData', '아이디 혹은 이름이 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요.'); //Alert_13
common.lang.load('searchPw.company.noSearch', '회원가입 시 입력한 담당자 본인명의의 휴대폰을 통해서만 인증이 가능합니다.'); //Alert_78
common.lang.load('searchPw.company.noMatchData', '아이디 혹은 사업자 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요.'); //Alert_78

//-----set input format
common.inputFormat.set($('#devUserId,#devUserName,#devCompanyUserId'), {'maxLength': 20});
common.inputFormat.set($('#devComName'), {'maxLength': 30});
common.inputFormat.set($('#devComNumber1'), {'number': true, 'maxLength': 3});
common.inputFormat.set($('#devComNumber2'), {'number': true, 'maxLength': 2});
common.inputFormat.set($('#devComNumber3'), {'number': true, 'maxLength': 5});

//-----set validation
common.validation.set($('#devUserId,#devCompanyUserId'), {'required': true, 'dataFormat': 'userId'});
common.validation.set($('#devUserName'), {'required': true});
common.validation.set($('#devComName'), {'required': true});
common.validation.set($('#devComNumber1,#devComNumber2,#devComNumber3'), {
    'required': true,
    'dataFormat': 'companyNumber',
    'getValueFunction': 'getCompanyNumber'
});
var getCompanyNumber = function () {
    return $('#devComNumber1').val() + $('#devComNumber2').val() + $('#devComNumber3').val();
}

//-----공통 인증 성공
var certify = 'basic';
common.certify.setSuccess(function (data) {
    if (certify == 'basic') {
        $form.submit();
    } else if (certify == 'company') {
        $comform.submit();
    }
});

//-----일반 회원
var $form = $('#devBasicForm');
var url = common.util.getControllerUrl('searchUserByCertifyAndUserData', 'member');
var successCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/password';
    } else if (response.result == "noSearchUser") {
        common.noti.alert(common.lang.get('searchPw.user.noSearch'));
    } else if (response.result == "noMatchData") {
        common.noti.alert(common.lang.get('searchPw.user.noMatchData'));
    } else {
        common.noti.alert("system error");
    }
};
common.form.init($form, url, '', successCallback);
//본인 인증
$('#devCertifyButton').click(function (e) {
    e.preventDefault();
    if (checkBasicValidation()) {
        certify = 'basic';
        common.certify.request('certify');
    }
});
//아이핀 인증
$('#devIpinButton').click(function (e) {
    e.preventDefault();
    if (checkBasicValidation()) {
        certify = 'basic';
        common.certify.request('ipin');
    }
});
function checkBasicValidation() {
    return common.validation.check($form);
}

//-----사업자 인증
var $comform = $('#devCompanyForm');
var comUrl = common.util.getControllerUrl('searchCompanyByCertifyAndCompanyData', 'member');
var comBeforeCallback = function ($comform) {
    return common.validation.check($comform);
};
var comSuccessCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/password';
    } else if (response.result == "noSearchUser") {
        common.noti.alert(common.lang.get('searchpw.company.noSearch'));
    } else if (response.result == "noMatchData") {
        common.noti.alert(common.lang.get('searchPw.company.noMatchData'));
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($comform, comUrl, comBeforeCallback, comSuccessCallback);
//본인 인증
$('#devCompanyCertifyButton').click(function (e) {
    e.preventDefault();
    if (common.validation.check($comform)) {
        certify = 'company';
        common.certify.request('certify');
    }
});