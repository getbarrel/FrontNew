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
common.lang.load('searchId.member.invalidNameEmail', '이름 혹은 이메일 정보가 일치하지 않습니다. 다시 확인해 주세요.');
common.lang.load('searchId.member.invalidNamePhone', '이름 혹은 휴대폰번호 정보가 일치하지 않습니다. 다시 확인해 주세요');

$('#devUserSubmitButton').click(function (e) {
    e.preventDefault();

    // *** 이메일로 아이디 찾기
    if($("input[name='idsearch']:checked").val() == "email"){

        var $form1 = $('#devSearchEmailForm');
        var comUrl = common.util.getControllerUrl('searchUserIdByEmail', 'member');
        var comBeforeCallback = function ($form1) {
            return common.validation.check($form1,'alert',false);
        };
        var comSuccessCallback = function (response) {
            location.href = '/member/searchIdResult';
            // if (response.result == "success") {
            //     location.href = '/member/searchIdResult';
            // } else {
            //     common.noti.alert(common.lang.get('searchId.member.invalidNameEmail'));
            // }
        };
        common.form.init($form1, comUrl, comBeforeCallback, comSuccessCallback);
        $form1.submit();

    // *** 전화번호로 아이디 찾기
    }else{

        var $form2 = $('#devSearchPhoneForm');
        var comUrl = common.util.getControllerUrl('searchUserIdByPhone', 'member');
        var comBeforeCallback = function ($form2) {
            return common.validation.check($form2,'alert',false);
        };
        var comSuccessCallback = function (response) {
            location.href = '/member/searchIdResult';
            // if (response.result == "success") {
            //     location.href = '/member/searchIdResult';
            // } else {
            //     common.noti.alert(common.lang.get('searchId.member.invalidNamePhone'));
            // }
        };
        common.form.init($form2, comUrl, comBeforeCallback, comSuccessCallback);
        $form2.submit();
    }

});


// *** 이메일 호스트 선택
$("#devEmailHostSelect").change(function (e){
    e.preventDefault();
    $("#devUserEmail2").val(this.value);
});

var getHpNumber = function () {
    return $('#devHp1').val() +'-'+ $('#devHp2').val() +'-'+ $('#devHp3').val();
}

var getEmail = function () {
    return $('#devUserEmail1').val() + '@' + $('#devUserEmail2').val();
}


// object
var devSearchnputObj = {
    initFormat: function () {
        //-----set input format
        common.inputFormat.set($('#devUserName'), {'maxLength': 20});
        common.inputFormat.set($('#devUser'), {'maxLength': 20});
        common.inputFormat.set($('#devHp2, #devHp3'), {'number': true, 'maxLength': 4});
    },
    initValidation: function () {
        //-----set validation
        common.validation.set($('#devUserName'), {'required': true});
        common.validation.set($('#devUserEmail1'), {'required': true});
        common.validation.set($('#devUserEmail2'), {'required': true});
        common.validation.set($('#devUser'), {'required': true});
        common.validation.set($('#devHp1'), {'required': true});
        common.validation.set($('#devHp2'), {'required': true});
        common.validation.set($('#devHp3'), {'required': true});
        common.validation.set($('#devHp1, #devHp2, #devHp3'), {
            'required': true,
            'dataFormat': 'mobile',
            'getValueFunction': 'getHpNumber'
        });
        common.validation.set($('#devUserEmail1,#devUserEmail2'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getEmail'
        });
    },

    run: function () {
        var self = this;
        self.initFormat();
        self.initValidation();
    }
};
$(function () {
    devSearchnputObj.run();
});
