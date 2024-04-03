"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('searchId.user.noSearch', '회원가입 이력이 존재하지 않는 정보입니다.'); //Alert_88
common.lang.load('searchId.company.noSearch', '사업자 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요.'); //Alert_12
common.lang.load('searchId.company.invalidBizNum', '유효한 사업자 정보가 아닙니다.'); 

//-----set input format
common.inputFormat.set($('#devComName'), {'maxLength': 30});
common.inputFormat.set($('#devComCeo'), {'maxLength': 30});
common.inputFormat.set($('#devComNumber1'), {'number': true, 'maxLength': 3});
common.inputFormat.set($('#devComNumber2'), {'number': true, 'maxLength': 2});
common.inputFormat.set($('#devComNumber3'), {'number': true, 'maxLength': 5});

//-----set validation
common.validation.set($('#devComName'), {'required': true});
common.validation.set($('#devComCeo'), {'required': true});
common.validation.set($('#devComNumber1,#devComNumber2,#devComNumber3'), {
    'required': true,
    'dataFormat': 'companyNumber',
    'getValueFunction': 'getCompanyNumber'
});
var getCompanyNumber = function () {
    return $('#devComNumber1').val() + $('#devComNumber2').val() + $('#devComNumber3').val();
}

//-----본인 인증
$('#devCertifyButton').click(function (e) {
    e.preventDefault();
    common.certify.request('certify');
});

//-----아이핀 인증
$('#devIpinButton').click(function (e) {
    e.preventDefault();
    common.certify.request('ipin');
});

//-----인증 성공시
common.certify.setSuccess(function (data) {
    common.ajax(common.util.getControllerUrl('searchUserByCertify', 'member'), '', '', searchUserByCertifyResponse);
});
var searchUserByCertifyResponse = function (response) {
    if (response.result == "success") {
        location.href = '/member/searchIdResult';
    } else if (response.result == "noSearchUser") {
        common.noti.alert(common.lang.get('searchId.user.noSearch'));
    } else {
        common.noti.alert(common.lang.get('searchId.company.invalidBizNum'));
    }
};

//-----사업자 인증
var $comform = $('#devCompanyForm');
var comUrl = common.util.getControllerUrl('searchCompany', 'member');
var comBeforeCallback = function ($form) {
    return common.validation.check($form);
};
var comSuccessCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/searchIdResult';
    } else if (response.result == "noSearchCompany") {
        common.noti.alert(common.lang.get('searchId.company.noSearch'));
    } else {
        common.noti.alert('system error');
    }
};
common.form.init($comform, comUrl, comBeforeCallback, comSuccessCallback);
$('#devCompanySubmitButton').click(function (e) {
    e.preventDefault();
    $comform.submit();
});