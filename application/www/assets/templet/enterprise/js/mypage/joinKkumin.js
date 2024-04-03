"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('kkumin.cancel.confirm.change', "교환 신청을 취소하시겠습니까?"); //Confirm_39
common.lang.load('kkumin.cancel.confirm.return', "반품 신청을 취소하시겠습니까?"); //Confirm_41
common.lang.load('common.validation.required.select', "{title}를 선택해 주세요.");
common.lang.load('common.validation.required.text', "{title}를 입력해 주세요."); //Alert_05
common.lang.load('mypage.exchange.confirm', "상품 교환신청을 하시겠습니까?");
common.lang.load('mypage.return.confirm', "상품 반품신청을 하시겠습니까?");

var devOrderKkumin = {
    kkuminApplyFrom: $('#devKkuminApplyForm'),
    formInit: function () {
        var self = this;

        common.form.init(
            this.kkuminApplyFrom,
            common.util.getControllerUrl('joinKkuminMember', 'mypage'),
            function (formObj) {
                if (common.validation.check(formObj, 'alert', false)) {
                    var msg;
                    msg = common.lang.get('kkumin_member.add.confirm');
                    if (confirm(msg)) {
                        self.kkuminApplyFrom.submit();
                        return true;
                    }else{
                        return false;
                    }

                } else {
                    return false;
                }
            },
            function (res) {
                if(res.result=='loginFail') {
                    alert('회원 정보가 누락 되었습니다.');
                }else if(res.result=='fail'){
                    alert('꾸민신청 실패 되었습니다.')
                }else{
                    location.replace('/mypage/joinKkumin/complete');
                }
            }
        );
    },
    run: function () {
        var self = this;

        //-----load language
        common.lang.load('kkumin_member.add.confirm', '꾸민회원 신청을 하시겠습니까?');

        //-----set input format
        common.inputFormat.set($('#devAccountCode'), {'maxLength': 6});
        common.inputFormat.set($('#devAccountBackCode'), {'maxLength': 7});
        common.inputFormat.set($('#devBusinessNumber1'), {'number': true, 'maxLength': 3});
        common.inputFormat.set($('#devBusinessNumber2'), {'number': true, 'maxLength': 2});
        common.inputFormat.set($('#devBusinessNumber3'), {'number': true, 'maxLength': 5});

        //-----set validation
        common.validation.set($('#devAccountHolder,#devBankInfo,#devAccountNumber'), {'required': true});
        common.validation.set($('.devItemInterest'), {'required': true});
        common.validation.set($('#devAccountCode,#account_back_code'), {'required': true});


        $('.devKkminMemType').click(function (){
            if($(this).val() == 'M'){
                common.validation.set($('#devAccountCode,#account_back_code'), {'required': true});
                common.validation.set($('#devBusinessNumber1,#devBusinessNumber2,#devBusinessNumber3,#devBusinessName,#devRepresentativeName'), {'required': false});
                common.validation.set($('#devBusinessLicenseFile,#devPassBookFile,#devFormFile'), {'required': false});
            }else{
                common.validation.set($('#devAccountCode,#account_back_code'), {'required': false});
                common.validation.set($('#devBusinessNumber1,#devBusinessNumber2,#devBusinessNumber3,#devBusinessName,#devRepresentativeName'), {'required': true});
                common.validation.set($('#devBusinessLicenseFile,#devPassBookFile,#devFormFile'), {'required': true});
            }
        });

        //Form init
        self.formInit();
    }
};

var devKkuminAccept = {
    kkuminAcceptFrom: $('#devKkuminAcceptFrom'),
    formInit: function () {
        var self = this;

        common.form.init(
            this.kkuminAcceptFrom,
            common.util.getControllerUrl('joinKkuminMemberAccept', 'mypage'),
            function (formObj) {
                if (common.validation.check(formObj, 'alert', false)) {
                    self.kkuminAcceptFrom.submit();
                    return true;
                } else {
                    return false;
                }
            },
            function (res) {
                if(res.result=='loginFail') {
                    alert('회원 정보가 누락 되었습니다.');
                }else if(res.result=='fail'){
                    alert('실패 되었습니다.')
                }else{
                    location.replace('/mypage/joinKkumin/input');
                }
            }
        );
    },
    run: function () {
        var self = this;
        //-----set validation
        common.validation.set($('.devRequired'), {'required': true});

        //Form init
        self.formInit();
    }
};

$(function () {
    /*switch (devKkuminStep) {
        case 'confirm':
            devOrderKkumin.confirm.run();
            break;
        case 'complete':
            devOrderKkumin.complete.run();
            break;
        default:
            devOrderKkumin.apply.run();
            break;

    }*/

    /**
     * 꾸민회원 신청 진행
     */
    devOrderKkumin.run();
    devKkuminAccept.run();
    // 다음 버튼 이벤트
    $('#devNextBtn').on('click', function () {
        $(".devOdIxCls").each(function () {
            var od_ix = $(this).val();
            if ($(this).is(':checked') !== true) {
                $('#devKkuminCnt' + od_ix).val(0);
            }
        });
        self.form.submit();
    });

    $('#devKkuminComplete').on('click',function(){
        location.href = '/mypage/joinKkumin/result';
    });


});