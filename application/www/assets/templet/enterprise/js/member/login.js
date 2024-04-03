"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
// $('.btn-join').click(function () {
//     location.href = '/member/join_select.php';
// });

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devObj = {
    memberForm: $('#devLoginForm'),
    nonMemberForm: $('#devNonMemberLoginForm'),
    selectTab:function(){
        if($(this).attr('id') == 'devMemberLoginTab') {
            $('#devMemberLoginTab').addClass('active');
            $('.tab-contents #tab1').addClass('active');
            $('#devNonMemberLoginTab').removeClass('active');
            $('.tab-contents #tab2').removeClass('active');
        } else {
            $('#devMemberLoginTab').removeClass('active');
            $('.tab-contents #tab1').removeClass('active');
            $('#devNonMemberLoginTab').addClass('active');
            $('.tab-contents #tab2').addClass('active');
        }
    },
    initLang: function () {
        //-----load language
        common.lang.load('login.member.fail', "아이디 혹은 비밀번호 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요."); //Alert_01
        common.lang.load('login.member.standby', "관리자로부터 승인대기 상태입니다.{common.lineBreak}승인완료 시 로그인이 가능합니다."); //Alert_62
        common.lang.load('login.member.reject', "회원가입 신청이 승인거부되었습니다.{common.lineBreak}자세한 사항은 고객센터로 문의해 주세요."); //Alert_63
        common.lang.load('login.nonMember.fail', "비회원 주문자 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요."); //Alert_02
        common.lang.load('login.member.fail.snsAccount', "간편 로그인 계정입니다. 간편로그인으로 진행해 주세요.{common.lineBreak}간편로그인이 진행되지 않을 경우 고객센터로 문의해 주세요.");
        common.lang.load('login.member.fail.fail_ig', "5회 이상 실패로 보안문자를 입력해 주세요.");
        common.lang.load('login.member.fail.fail_ig2', "입력하신 보안문자가 일치하지 않습니다.");


    },
    initMemberForm: function () {
        var self = this;

        // 회원폼 검증
        common.validation.set($('#devUserId'), {'required': true});
        common.validation.set($('#devUserPassword'), {'required': true});

		$('#nonMemOrder').hide();
		
		//	ig 켑차 필수값으로 체크
			common.validation.set($('#captcha_text_id'), {'required': true});
		//	//ig 켑차 필수값으로 체크



        //-----회원로그인
        common.form.init(
                self.memberForm,
                    common.util.getControllerUrl('login', 'member'),
                function ($form) {
					return common.validation.check($form);
                },
                function (response) {

                    if (response.result == "success") {
                        location.href = response.data.url;
                    } else if (response.result == "standby") {
                        common.noti.alert(common.lang.get("login.member.standby"));
                    } else if (response.result == "reject") {
                        common.noti.alert(common.lang.get("login.member.reject"));
                    } else if(response.result == "snsAccount"){
                        common.noti.alert(common.lang.get("login.member.fail.snsAccount"));
                    } else if(response.result == "fail_ig"){
						//	ig_캡차
                        common.noti.alert(common.lang.get("login.member.fail.fail_ig"));
						location.href = "/member/login?url=&captcha_use=Y";
                    }else {
                        common.noti.alert(common.lang.get("login.member.fail"));
                    }
                });

    },
    initNonMemberForm: function () {
        var self = this;

        // 비회원 폼검증
        common.validation.set($('#devBuyerName'), {'required': true});
        common.validation.set($('#devOrderId'), {'required': true});
        common.validation.set($('#devOrderPassword'), {'required': true});

        // 비회원 주문조회
        common.form.init(
                self.nonMemberForm,
                common.util.getControllerUrl('nonMemberLogin', 'member'),
                function ($form) {
                    return common.validation.check($form);
                },
                function (response) {
                    if (response.result == "success") {
                        location.href = response.data.url;
                    } else {
                        common.noti.alert(common.lang.get("login.nonMember.fail"));
                    }
                });

    },
    initEvent: function () {
        var self = this;

        // 탭 선택 이벤트
        $('#devMemberLoginTab,#devNonMemberLoginTab').on('click', self.selectTab);
        
        // 회원 데이타 전송 이벤트
        $('#devLoginSubmitButton').click(function (e) {
			e.preventDefault();
						if($('#captcha_use_id').val() == "Y" && $('#captcha_text_id').val() != "") {
							$.ajax({
								type: "GET",   //POST 방식
								url:"../member/captchaaction",
								data:{
									"uid":$('#devUserId').val(),
									"captcha_text":$('#captcha_text_id').val()
								},
								cache: false,	
								async: false,
								success:function(data) {	//HTTP요청이 성공했을 경우 호출되는 함수.
										//console.log(data);
									if(data == "IG_OK") {
										//	캡차 성공
										e.preventDefault();
										self.memberForm.submit();
									} else {
										//	캡차 실패
										alert("입력하신 보안문자가 일치하지 않습니다.");
										return false;
									}
								}
							});
						} else{
							e.preventDefault();
							self.memberForm.submit();
						}

//			self.memberForm.submit();
        });

        // 비회원 데이타 전송 이벤트
        $('#devNonMemberLoginSubmitButton').click(function (e) {
            e.preventDefault();
            self.nonMemberForm.submit();
        });

        if (document.cookie.indexOf("userSaveLoginId") > 0 ){
            var cookieId = document.cookie.split(';');
            for (var i = 0; i < cookieId.length; i++) {
                if(cookieId[i].indexOf("userSaveLoginId") > 0){
                    var cookieIdSplit = cookieId[i].split('=');
                }
            }
            $('#devUserId').val(cookieIdSplit[1]);
            $('#c1').attr('checked', true);
        }
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initMemberForm();
        self.initNonMemberForm();
        self.initEvent();
    }
}

$('.fb__login__nomember').click(function () {
	if ($('#nonMemOrder').css("display") == "block"){
		$('#nonMemOrder').hide();
	}else{
		$('#nonMemOrder').show();
	}
	
});

$(function () {
    devObj.run();
});