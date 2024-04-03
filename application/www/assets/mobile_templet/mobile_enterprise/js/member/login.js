"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$('.pub-nonmem-order-button').click(function () {
    window.location.hash = 'nonmember';
});
$(window).on('hashchange', function () {
    change_login_wrap();
});
//새로고침 처리
change_login_wrap();
function change_login_wrap() {
    if (window.location.hash == '#nonmember') {
        $('.wrap-member').hide();
        $('.wrap-nonmember').show();
    } else {
        $('.wrap-member').show();
        $('.wrap-nonmember').hide();
    }
}
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('login.member.fail', "아이디 혹은 비밀번호 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요."); //Alert_01
common.lang.load('login.member.standby', "관리자로부터 승인대기 상태입니다.{common.lineBreak}승인완료 시 로그인이 가능합니다."); //Alert_62
common.lang.load('login.member.reject', "회원가입 신청이 승인거부되었습니다.{common.lineBreak}자세한 사항은 고객센터로 문의해 주세요."); //Alert_63
common.lang.load('login.nonMember.fail', "비회원 주문자 정보가 일치하지 않습니다.{common.lineBreak}다시 입력해 주세요."); //Alert_02
common.lang.load('login.member.fail.snsAccount', "간편 로그인 계정입니다. 간편로그인으로 진행해 주세요.{common.lineBreak}간편로그인이 진행되지 않을 경우 고객센터로 문의해 주세요.");
common.lang.load('login.member.fail.fail_ig', "5회 이상 실패로 보안문자를 입력해 주세요.");
common.lang.load('login.member.fail.fail_ig2', "입력하신 보안문자가 일치하지 않습니다.");
//-----set input format

//-----set validation
common.validation.set($('#devUserId'), {'required': true});
common.validation.set($('#devUserPassword'), {'required': true});
common.validation.set($('#devBuyerName'), {'required': true});
common.validation.set($('#devOrderId'), {'required': true});
common.validation.set($('#devOrderId2'), {'required': true});
common.validation.set($('#devOrderPassword'), {'required': true});


		//	ig 켑차 필수값으로 체크
			common.validation.set($('#captcha_text_id'), {'required': true});
		//	//ig 켑차 필수값으로 체크


//-----회원로그인
var $form = $('#devLoginForm');
var url = common.util.getControllerUrl('login', 'member');
var beforeCallback = function ($form) {
    return common.validation.check($form);
};
var successCallback = function (response) {

    if (response.result == "success") {
        var obj = {};
        obj['userCode'] = response.data.userCode;
        obj['cookieInfo'] = response.data.loginCookie;

        if(navigator.userAgent.match(/BarrelAOSApp/i)) {
            window.JavascriptInterface.loginSuccess(JSON.stringify(obj));
        }else if(navigator.userAgent.match(/BarrelIOSApp/i)) {
            window.webkit.messageHandlers.loginSuccess.postMessage(JSON.stringify(obj));
        }
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
		location.href = "/member/login?captcha_use=Y";
    }else {
        common.noti.alert(common.lang.get("login.member.fail"));
    }
};
common.form.init($form, url, beforeCallback, successCallback);

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
								$form.submit();
							} else {
								//	캡차 실패
								alert("입력하신 보안문자가 일치하지 않습니다.");
								return false;
							}
						}
					});
				} else{
					e.preventDefault();
					$form.submit();
				}

//    e.preventDefault();
//    $form.submit();
});

//-----비회원(주문조회)
var $nonMemberForm = $('#devNonMemberLoginForm');
var nonMemberUrl = common.util.getControllerUrl('nonMemberLogin', 'member');
var nonMemberBeforeCallback = function ($form) {
    return common.validation.check($form);
};
var nonMemberSuccessCallback = function (response) {
    if (response.result == "success") {
        location.href = response.data.url;
    } else {
        common.noti.alert(common.lang.get("login.nonMember.fail"));
    }
};
common.form.init($nonMemberForm, nonMemberUrl, nonMemberBeforeCallback, nonMemberSuccessCallback);

$('#devNonMemberLoginSubmitButton').click(function (e) {
    e.preventDefault();
    $nonMemberForm.submit();
});

var setSNSGoogle = function (info) {
    if(navigator.userAgent.match(/BarrelAOSApp/i)){
        location.href = '/controller/member/google?id='+info.sub+'&email='+info.email+'&name='+info.name;
    }else if(navigator.userAgent.match(/BarrelIOSApp/i)) {
        info = JSON.parse(info);
        location.href = '/controller/member/google?id='+info.sub+'&email='+info.email+'&name='+info.name;
    }

}

$(function(){
    $(".devSaveIdCheck").click(function(){
        var id = $('#devUserId').val();

        common.ajax(
            common.util.getControllerUrl('saveId', 'member'),
            {
                'id': id,
            },
            '',
            function (response) {
                if (response.result == 'fail') {
                    console.log('실패');
                } else {
                    console.log('성공');
                    console.log(document.cookie);
                }
            }
        );
    });

    //테스트용
    if ( document.cookie.indexOf("userSaveLoginId") > 0 ){
        var cookieId = document.cookie.split(';');
        for (var i = 0; i < cookieId.length; i++) {
            if(cookieId[i].indexOf("userSaveLoginId") > 0){
                var cookieIdSplit = cookieId[i].split('=');
            }
        }
        $('#devUserId').val(cookieIdSplit[1]);
        $('#c1').attr('checked', true);
    }

    $('.devNonmemberOrder').click(function(){
        location.href = common.util.getParameterByName('url','');
        return false;
    });

    $('#appLoginGoogle').on('click', function() {
        if(navigator.userAgent.match(/BarrelAOSApp/i)){
            window.JavascriptInterface.getSNSGoogle();
        }else if(navigator.userAgent.match(/BarrelIOSApp/i)) {
            window.webkit.messageHandlers.getSNSGoogle.postMessage("");
        }
    });
});