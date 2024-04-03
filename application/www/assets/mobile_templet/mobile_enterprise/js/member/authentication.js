"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('authentication.cancel.confirm', "회원 가입을 취소하시겠습니까?"); //Confirm_01
common.lang.load('authentication.company.doubleCompanyNumber', "이미 가입된 사업자입니다."); //Alert_09
common.lang.load('authentication.company.success', "인증되었습니다."); //Alert_10

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
    location.href = '/member/joinAgreement';
});

//-----사업자 인증
var $comform = $('#devCompanyForm');
var comUrl = common.util.getControllerUrl('authenticationCompany', 'member');
var comBeforeCallback = function ($form) {
    return common.validation.check($form);
};
var comSuccessCallback = function (response) {
    if (response.result == "success") {
        common.noti.alert(common.lang.get('authentication.company.success'), comSuccess);
    } else if (response.result == "doubleCompanyNumber") {
        common.noti.alert(common.lang.get('authentication.company.doubleCompanyNumber'));
    } else {
        common.noti.alert('system error');
    }
};
var comSuccess = function () {
    document.location.href = location.href = '/member/joinAgreement';
}
common.form.init($comform, comUrl, comBeforeCallback, comSuccessCallback);
$('#devCompanySubmitButton').click(function (e) {
    e.preventDefault();
    $comform.submit();
});

//-----취소
var authCancel = function () {
    document.location.href = '/';
}
$('#devCancelButton').click(function (e) {
    common.noti.confirm(common.lang.get('authentication.cancel.confirm'), authCancel);
});