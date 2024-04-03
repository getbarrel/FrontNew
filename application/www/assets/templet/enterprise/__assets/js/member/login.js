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
    },
    initMemberForm: function () {
        var self = this;

        // 회원폼 검증
        common.validation.set($('#devUserId'), {'required': true});
        common.validation.set($('#devUserPassword'), {'required': true});

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
                    } else {
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
            self.memberForm.submit();
        });

        // 비회원 데이타 전송 이벤트
        $('#devNonMemberLoginSubmitButton').click(function (e) {
            e.preventDefault();
            self.nonMemberForm.submit();
        });
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initMemberForm();
        self.initNonMemberForm();
        self.initEvent();
    }
}

$(function () {
    devObj.run();
});