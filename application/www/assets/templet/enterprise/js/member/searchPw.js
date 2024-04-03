"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('searchPw.user.noSearch', '회원가입 이력이 존재하지 않는 정보입니다.'); //Alert_88
common.lang.load('searchPw.user.noMatchData', '아이디 혹은 이름이 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요.'); //Alert_13
common.lang.load('searchPw.company.noSearch', '회원가입 시 입력한 담당자 본인명의의 휴대폰을 통해서만 인증이 가능합니다.'); //Alert_78
common.lang.load('searchPw.company.noMatchData', '아이디 혹은 입력한 정보가 정확하지 않습니다. 다시 입력해 주세요.');
common.lang.load('searchPw.company.noMatchCertNo', '인증번호를 일치하지 않습니다. 다시 입력해 주세요.');
common.lang.load('searchPw.loginType.kakao', '카카오톡 으로 가입한 회원입니다. SNS 간편로그인을 이용해 주세요');
common.lang.load('searchPw.loginType.naver', '네이버 아이디로 가입한 회원입니다. SNS 간편로그인을 이용해 주세요');
common.lang.load('searchPw.loginType.facebook', '페이스북 으로 가입한 회원입니다. SNS 간편로그인을 이용해 주세요');
common.lang.load('searchPw.loginType.google', '구글계정 으로 가입한 회원입니다. SNS 간편로그인을 이용해 주세요');

common.lang.load('searchId.user.validation.certiCheck.alert', "인증번호를 다시 입력해 주세요.");
common.lang.load('searchId.user.validation.certiSend.success', "인증번호를 전송하였습니다.");
common.lang.load('searchId.user.validation.pcsEmpty.alert', "휴대폰번호를 입력해주세요.");
common.lang.load('searchId.user.validation.certiConfirm.success', "휴대폰번호 인증이 완료되었습니다.");
common.lang.load('searchId.user.validation.certiConfirmEmail.success', "이메일 인증이 완료되었습니다.");
common.lang.load('searchId.user.validation.certiEmpty.alert', "인증번호를 입력해주세요.");
common.lang.load('searchId.user.validation.notOk.fail', "등록된 휴대폰번호가 아닙니다.");
common.lang.load('searchId.user.validation.pcsCertify.fail', "인증번호 요청을 진행해 주세요."); // use

common.lang.load('searchId.user.validation.userIdEmpty.alert', "회원가입시 입력한 아이디를 입력해주세요.");
common.lang.load('searchId.user.validation.userNameEmpty.alert', "회원가입시 입력한 이름을 입력해주세요.");
common.lang.load('searchId.user.validation.userEmailEmpty.alert', "회원가입시 입력한 이메일을 입력해주세요.");
common.lang.load('searchId.user.validation.userEmailInvalid.alert', "유효한 이메일을 입력해주세요.");
common.lang.load('searchId.user.validation.userEmailAlready.alert', "인증번호 이메일을 이미 발송하였습니다.");

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
var getPcsNumber = function () {
    return $('#devPcs1').val() +'-'+ $('#devPcs2').val() +'-'+ $('#devPcs3').val();
}
var getEmail = function () {
    return $('#devUserEmail1').val() + '@' + $('#devUserEmail2').val();
}

// *** 이메일 호스트 선택
$("#devEmailHostSelect").change(function (e){
    e.preventDefault();
    $("#devUserEmail2").val(this.value);
});

// *** 패스워드 찾기 > 회원정보 확인
var $form1 = $('#devSearchEmailForm');
var comUrl = common.util.getControllerUrl('checkUserInfo', 'member');

// object
var devSearchPwdObj = {

    isPcsRegExp: false, // 휴대폰 정규식 플래그
    isCertiCheckComplete: false, // 휴대폰 인증체크 플래그
    isEmailCertiReq: false, // 이메일 인증체크 플래그

    initFormat: function () {
        common.inputFormat.set($('#devUserId'), {'maxLength': 20});
        common.inputFormat.set($('#devUserName'), {'maxLength': 20});
        common.inputFormat.set($('#devPcs2, #devPcs3'), {'number': true, 'maxLength': 4});
    },

    initValidation: function () {
        common.validation.set($('#devUserId'), {'required': true});
        common.validation.set($('#devUserName'), {'required': true});
        common.validation.set($('#devUserEmail1'), {'required': true});
        common.validation.set($('#devUserEmail2'), {'required': true});
        common.validation.set($('#devPcs1'), {'required': false});
        common.validation.set($('#devPcs2'), {'required': false});
        common.validation.set($('#devPcs3'), {'required': false});
        common.validation.set($('#devCertNo'), {'required': true});
        common.validation.set($('#devUserEmail1,#devUserEmail2'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getEmail'
        });
    },

    initSearchPwdEvent: function () {
        var self = this;

        // 이메일/전화번호 선택
        $("input[name=searchType]").click(function(){

            // 초기화
            $("#devCertNo").val("");
            self.isEmailCertiReq = false;
            self.isPcsRegExp = false;
            $('#devCertiConfirmBtn').attr('disabled', false);
            $('#devCertRequestBtn').attr('disabled', false);
            $('#devCertNo').attr('readonly', false);

            if(this.value == "phone"){
                $(".email_group").hide();
                $(".phone_group").show();
                common.validation.set($('#devPcs1, #devPcs2, #devPcs3'), {
                    'required': true,
                    'dataFormat': 'mobile',
                    'getValueFunction': 'getPcsNumber'
                });
                common.validation.set($('#devUserEmail1,#devUserEmail2'), {
                    'required': false
                });
            }else{
                $(".email_group").show();
                $(".phone_group").hide();
                common.validation.set($('#devPcs1, #devPcs2, #devPcs3'), {
                    'required': false
                });
                common.validation.set($('#devUserEmail1,#devUserEmail2'), {
                    'required': true,
                    'dataFormat': 'email',
                    'getValueFunction': 'getEmail'
                });
            }
        });

        // 인증번호 요청
        $("#devCertRequestBtn").click(function(e){
            // self.certiReq(self)
            var _userid =  $("#devUserId").val();
            var _username = $("#devUserName").val();
            if($("input[name=searchType]:checked").val() == "email"){
                self.certiReqEmail(self);
            }else{
                request_validation(_userid, _username, self.certiReq);
            }
        });

        function request_validation(_userid, _username, callback){
            if ( _userid == "" || _userid == "" && _username == ""){
                common.noti.alert(common.lang.get('searchId.user.validation.userIdEmpty.alert'));

            } else if (_username == "") {
                common.noti.alert(common.lang.get('searchId.user.validation.userNameEmpty.alert'));

            } else {
                return callback(self);
            }
        }
        // 인증번호 확인
        $('#devCertiConfirmBtn').on('click', function (e) {
            e.preventDefault();
            self.certiConfirm(self);
        });

        // 확인
        $('#devUserPwdSearchSubmitButton').click(function (e) {
            e.preventDefault();
            $form1.submit();
        });
        common.form.init($form1, comUrl, self.comBeforeCallback, self.comSuccessCallback);
    },

    comBeforeCallback : function ($form1) {
        if(common.validation.check($form1, 'alert', false)){
            // 인증번호 확인 여부
            if(self.devSearchPwdObj.isCertiCheckComplete){
                return true;    // 인증 완료
            }else{
                common.noti.alert(common.lang.get('searchId.user.validation.pcsCertify.fail')); // 인증 미진행
            }
        }else{
            return false;
        }
    },

    comSuccessCallback : function (response) {

        if (response.result == "success") {
			if($('#keyYN').val() == "R" || $('#keyYN').val() == "N") {
				common.noti.alert(common.lang.get('searchId.user.validation.certiCheck.alert'));
			} else {
				location.href = '/member/password';
			}
        } else if (response.result == "fail" && response.data == "401") {
            common.noti.alert(common.lang.get('searchPw.company.noMatchCertNo'));
        } else {
            common.noti.alert(common.lang.get('searchPw.company.noMatchData'));
        }
    },

    // *** 휴대전화 인정번호 요청
    certiReq: function(self){

        var pcs1 = $('#devPcs1').val();
        var pcs2 = $('#devPcs2').val();
        var pcs3 = $('#devPcs3').val();

        var devUserId =  $("#devUserId").val();
        var devUserName = $("#devUserName").val();

        if (!(self.isCertiCheckComplete) && pcs1 && pcs2 && pcs3) {
            common.ajax(
                common.util.getControllerUrl('certiSearchReq', 'member'),
                {
                    'pcs': pcs1+'-'+pcs2+'-'+pcs3
                    ,'name': devUserName
                    ,'id': devUserId

                },
                '',
                function (response) {
                    console.log(response);
                    if (response.result == "success") {
                        self.isPcsRegExp = true;
                        $('#devCertNo').focus();
                        common.noti.alert(common.lang.get('searchId.user.validation.certiSend.success'));
                    } else {
                        if(response.data){
                            common.noti.alert(common.lang.get('searchPw.loginType.'+response.data));
                        }else{
                            common.noti.alert(common.lang.get('searchId.user.validation.notOk.fail'));
                        }

                    }
                }
            );
        } else {
            common.noti.alert(common.lang.get('searchId.user.validation.pcsEmpty.alert'));
        }
    },


    certiReqEmail: function(self){

        var devUserId = $('#devUserId').val();
        var devUserName = $('#devUserName').val();
        var devUserEmail1 = $('#devUserEmail1').val();
        var devUserEmail2 = $('#devUserEmail2').val();
        var devUserEmail = devUserEmail1 +'@' + devUserEmail2;

        if(devUserId == ''){
            common.noti.alert(common.lang.get('searchId.user.validation.userIdEmpty.alert'));
            $('#devUserId').focus();
        }else if(devUserName == '' && common.langType =='korean'){
            common.noti.alert(common.lang.get('searchId.user.validation.userNameEmpty.alert'));
            $('#devUserName').focus();
        }else if(devUserEmail1 == ''){
            common.noti.alert(common.lang.get('searchId.user.validation.userEmailEmpty.alert'));
            $('#devUserEmail1').focus();
        }else if(devUserEmail2 == ''){
            common.noti.alert(common.lang.get('searchId.user.validation.userEmailEmpty.alert'));
            $('#devUserEmail2').focus();
        }else if (!(self.isEmailCertiReq)) {
            common.ajax(
                common.util.getControllerUrl('certiSearchReqByEmail', 'member'),
                {
                    'userEmail': devUserEmail
                    ,'userId': devUserId
                    ,'userName': devUserName
                },
                '',
                function (response) {
                    if (response.result == "success") {
                        self.isEmailCertiReq = true;
                        $('#devCertNo').focus();
                        common.noti.alert(common.lang.get('searchId.user.validation.certiSend.success'));
                    } else {
                        if(response.data){
                            common.noti.alert(common.lang.get('searchPw.loginType.'+response.data));
                        }else{
                            common.noti.alert(common.lang.get('searchPw.company.noMatchData'));
                        }
                    }
                }
            );
        }else{
            common.noti.alert(common.lang.get('searchId.user.validation.userEmailAlready.alert')) //  이미발송
        }
    },


    certiConfirm: function (self) {

        if($("input[name=searchType]:checked").val() == "email") {
            var ckReq = self.isEmailCertiReq;
        }else{
            var ckReq = self.isPcsRegExp;
        }

        if (ckReq) {
            var certiVal = $('#devCertNo').val();
            if (certiVal) {
                common.ajax(
                    common.util.getControllerUrl('certiConfirm', 'member'),
                    {
                        'certiVal': certiVal
                    },
                    '',
                    function (response) {
                        if (response.result == "success") {
                            self.isCertiCheckComplete = true;   // 인증완료
                            $('#devCertiConfirmBtn').attr('disabled', true);
                            $('#devCertRequestBtn').attr('disabled', true);
                            $('#devCertNo').attr('readonly', true);

                            if($("input[name=searchType]:checked").val() == "email") {
                                common.noti.alert(common.lang.get('searchId.user.validation.certiConfirmEmail.success'));
                            }else{
                                common.noti.alert(common.lang.get('searchId.user.validation.certiConfirm.success'));
                            }
							$('#keyYN').val("Y");
                        } else if (response.result == "notMatched") {
                            $('#devCertifyId').focus();
							$('#keyYN').val("R");
                            common.noti.alert(common.lang.get('searchId.user.validation.certiCheck.alert'));
                        } else {
                            // console.log(response);
                        }
                    }
                );
            } else {
                common.noti.alert(common.lang.get('searchId.user.validation.certiEmpty.alert'));
            }
        } else {
            common.noti.alert(common.lang.get('searchId.user.validation.pcsCertify.fail'));
        }
    },


    run: function () {
        var self = this;
        self.initFormat();
        self.initValidation();
        self.initSearchPwdEvent();
    }
};

$(function () {
    devSearchPwdObj.run();
});



