"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devProfileObj = {
    basic: {
        //이메일 중복 버튼
        emailDoubleCheckButton: $('#devEmailDoubleCheckButton'),
        //이메일 정규식 규칙 플레그
        isEmailRegExp: true,
        //이메일 중복 체크 플레그
        isEmailDoubleCheck: true,
        getEmail: function () {
            return $('#devEmailId').val().trim() + '@' + $('#devEmailHost').val().trim();
        },
        checkEmail: function () {
            this.isEmailRegExp = false;
            this.isEmailDoubleCheck = false;

            this.emailDoubleCheckButton.attr('disabled', false);

            var result = common.validation.checkElement($('#devEmailId').get(0));
            if (result.success) {
                this.isEmailRegExp = true;
                common.noti.tailMsg('devEmailId', common.lang.get("profile.common.validation.email.doubleCheck"));
            } else {
                common.noti.tailMsg('devEmailId', result.message);
            }
        },
        emailDoubleCheckResponse: function (response) {
            var self = devProfileObj.basic;

            if (response.result == "success") {
                self.isEmailDoubleCheck = true;
                self.emailDoubleCheckButton.attr('disabled', true);
                common.noti.tailMsg('devEmailId', common.lang.get("profile.common.validation.email.success"), 'success');
            } else if (response.result == "fail") {
                common.noti.tailMsg('devEmailId', common.lang.get("profile.common.validation.email.fail"));
            } else {
                common.noti.tailMsg('devEmailId', common.lang.get("profile.common.validation.email.wrong"));
            }
        },
        zipResponse: function (response) {
            $('#devZip').val(response.zipcode);
            $('#devAddress1').val(response.address1);
            $('#devAddress2').val('');
        },
        formInit: function () {
            var self = this;

            // 일반 회원정보 수정폼
            common.form.init(
                $('#devMemberProfileForm'), // Form
                common.util.getControllerUrl('modifyProfile', 'member'), // Controller name
                function (formObj) {
                    var ret = false;

                    //이메일 관련 체크
                    if (self.isEmailRegExp != true || self.isEmailDoubleCheck != true) {
                        common.noti.alert(common.lang.get('profile.common.validation.email.doubleCheck'));
                        return false;
                    }
                    ret = common.validation.check(formObj, 'alert', false);

                    // Form validation
                    return ret && common.noti.confirm(common.lang.get('profile.common.modify.save.confirm'));
                },
                function (res) {
                    if (res.result == 'success') {
                        // 마케팅 동의 확인
                        devProfileObj.maketingChk();

                        location.replace('/mypage');
                    } else {
                        console.log(res);
                        // location.replace('/mypage');
                    }
                }
            );
        },
        init: function () {
            var self = this;

            //담당자 휴대폰 인증
            var isCompanyCertify = false; //담당자 휴대폰 인증 플레그
            //본인 인증
            $('#devCertifyButton').on('click', function () {
                console.log(1);
                common.certify.request('certify');
                return false;
            });
            //본인, 아이핀 인증 응답 공통
            common.certify.setSuccess(function (data) {
                console.log(data);
                isCompanyCertify = true;
                $('#devDi').val(data.di);
                $('#devCi').val(data.ci);
                $('#devUserName').val(data.name);
                $('#devFormatUserName').text(data.name);
                $('#devBirthday').val(data.birthday);
                $('#devFromatBirthday').text(data.birthday);
                $('#devSexDiv').val(data.sexDiv);
                $('#devFormatSexDiv').text(data.sex);
                $('#devPcs').val(data.pcs);
                $('#devFormatPcs').text(data.pcs);
                $('#devCertifyButton').remove();
                $('#devCertifyText').html('본인인증이 완료됐습니다.');
            });
            common.certify.setFail(function (message) {
                isCompanyCertify = false;
                common.noti.alert(message);
            });

            //-----set input format
            common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});
            //-----set validation
            common.validation.set($('#devEmailId,#devEmailHost'), {
                'required': true,
                'dataFormat': 'email',
                'getValueFunction': 'devProfileObj.basic.getEmail'
            });
            common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
            common.validation.set($('#devZip,#devAddress1,#devAddress2'), {'required': true});
            common.validation.set($('#devEmailId,#devEmailHost'), {'required': true});

            common.validation.set($('#devPcs'), {'required': true});
            common.validation.set($('#devCity'), {'required': true});
            common.validation.set($('#devStateText'), {'required': true});
            common.validation.set($('#devZip'), {'required': true});
            common.validation.set($('#devCountry'), {'required': true});

            // Bind event

            //주소 찾기
            $('#devZipPopupButton').click(function (e) {
                e.preventDefault();
                common.util.zipcode.popup(self.zipResponse);
            });

            //이메일 수정 관련 이벤트
            $('#devEmailId,#devEmailHost').on({
                'input': function (e) {
                    self.checkEmail();
                }
            });

            $('#devEmailHostSelect').change(function (e) {

                var selectValue = $(this).val();
                var $emailHost = $('#devEmailHost');

                if(selectValue == 'direct'){
                    $emailHost.val('');
                    $emailHost.attr('readonly', false);
                    $emailHost.focus();
                }else{
                    $emailHost.val(selectValue);
                    $emailHost.attr('readonly', true);
                }

                self.checkEmail();
            });

            //이메일 중복 체크
            self.emailDoubleCheckButton.on(
                'click',
                function (e) {
                    if (self.isEmailRegExp == true) {
                        common.ajax(
                            common.util.getControllerUrl('emailCheck', 'member'),
                            {'email': self.getEmail()},
                            "",
                            self.emailDoubleCheckResponse
                        );
                    }
                }
            );
        }
    },
    company: {
        //이메일 중복 버튼
        emailDoubleCheckButton: $('#devComEmailDoubleCheckButton'),
        //이메일 정규식 규칙 플레그
        isEmailRegExp: true,
        //이메일 중복 체크 플레그
        isEmailDoubleCheck: true,
        //파일업로드 관련
        businessFile: $('#devBusinessFile'),
        businessFileButton: $('#devBusinessFileButton'),
        businessFileDeleteButton: $('#devBusinessFileDeleteButton'),
        businessFileText: $('#devBusinessFileText'),
        businessFileChangeEvnet: function () {
            var self = devProfileObj.company;

            if (self.businessFile.val() != "") {
                self.businessFileText.val(self.businessFile.val());
                self.businessFileButton.text(common.lang.get('profile.company.file.change'));
                self.businessFileDeleteButton.show();
            } else {
                self.businessFileText.val('');
                self.businessFileButton.text(common.lang.get('profile.company.file.find'));
                self.businessFileDeleteButton.hide();
            }
        },
        getEmail: function () {
            return $('#devComEmailId').val().trim() + '@' + $('#devComEmailHost').val().trim();
        },
        checkEmail: function () {
            this.isEmailRegExp = false;
            this.isEmailDoubleCheck = false;

            this.emailDoubleCheckButton.attr('disabled', false);

            var result = common.validation.checkElement($('#devComEmailId').get(0));
            if (result.success) {
                this.isEmailRegExp = true;
                common.noti.tailMsg('devComEmailId', common.lang.get("profile.common.validation.email.doubleCheck"));
            } else {
                common.noti.tailMsg('devComEmailId', result.message);
            }
        },
        emailDoubleCheckResponse: function (response) {
            var self = devProfileObj.company;

            if (response.result == "success") {
                self.isEmailDoubleCheck = true;
                self.emailDoubleCheckButton.attr('disabled', true);
                common.noti.tailMsg('devComEmailId', common.lang.get("profile.common.validation.email.success"), 'success');
            } else if (response.result == "fail") {
                common.noti.tailMsg('devComEmailId', common.lang.get("profile.common.validation.email.fail"));
            } else {
                common.noti.tailMsg('devComEmailId', common.lang.get("profile.common.validation.email.wrong"));
            }
        },
        zipResponse: function (response) {
            $('#devComZip').val(response.zipcode);
            $('#devComAddress1').val(response.address1);
            $('#devComAddress2').val('');
        },
        formInit: function () {
            // devCompanyProfileForm
            var self = this;
            var basic = devProfileObj.basic;

            // 일반 회원정보 수정폼
            common.form.init(
                $('#devCompanyProfileForm'), // Form
                common.util.getControllerUrl('modifyProfile', 'member'), // Controller name
                function (formObj) {
                    var ret = false;

                    // 회사 이메일 관련 체크
                    if (self.isEmailRegExp != true || self.isEmailDoubleCheck != true) {
                        common.noti.alert(common.lang.get('profile.common.validation.email.doubleCheck'));
                        return false;
                    }

                    // 담당자 이메일 관련 체크
                    if (basic.isEmailRegExp != true || basic.isEmailDoubleCheck != true) {
                        common.noti.alert(common.lang.get('profile.common.validation.email.doubleCheck'));
                        return false;
                    }

                    ret = common.validation.check(formObj, 'alert', false);

                    // Form validation
                    return ret && common.noti.confirm(common.lang.get('profile.common.modify.save.confirm'));
                },
                function (res) {
                    if (res.result == 'success') {
                        // 마케팅 동의 확인
                        devProfileObj.maketingChk();
                        // mypage 이동
                        location.replace('/mypage');
                    } else {
                        console.log(res);
                        location.replace('/mypage');
                    }
                }
            );
        },
        init: function () {
            var self = this;

            // Set Lang
            common.lang.load('profile.company.file.confirm.delete', "파일을 삭제하시겠습니까?");
            common.lang.load('profile.company.file.find', "파일찾기");
            common.lang.load('profile.company.file.change', "파일변경");

            //-----set input format
            common.inputFormat.set($('#devComTel2,#devComTel3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devComPcs2,#devComPcs3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devBusinessFile'), {'fileFormat': 'image', 'fileSize': 30});

            //-----set validation
            common.validation.set($('#devComEmailId,#devComEmailHost'), {
                'required': true,
                'dataFormat': 'email',
                'getValueFunction': 'devProfileObj.company.getEmail'
            });
            common.validation.set($('#devComTel2,#devComTel3,#devComZip,#devComAddress1,#devComAddress2'), {'required': true});
            common.validation.set($('#devComEmailId,#devComEmailHost,#devComPcs2,#devComPcs3,#devName'), {'required': true});

            // Form init
            self.formInit();

            //주소 찾기
            $('#devComZipPopupButton').click(function (e) {
                e.preventDefault();
                common.util.zipcode.popup(self.zipResponse);
            });

            //이메일 수정 관련 이벤트
            $('#devComEmailId,#devComEmailHost').on({
                'input': function (e) {
                    self.checkEmail();
                }
            });

            $('#devComEmailHostSelect').change(function (e) {
                var selectValue = $(this).val();
                var $emailHost = $('#devComEmailHost');
                $emailHost.val(selectValue);
                if (selectValue != '') {
                    $emailHost.attr('readonly', true);
                } else {
                    $emailHost.attr('readonly', false);
                }
                self.checkEmail();
            });

            //이메일 중복 체크
            self.emailDoubleCheckButton.on(
                'click',
                function (e) {
                    if (self.isEmailRegExp == true) {
                        common.ajax(
                            common.util.getControllerUrl('companyEmailCheck', 'member'),
                            {'email': self.getEmail()},
                            "",
                            self.emailDoubleCheckResponse
                        );
                    }
                }
            );



            //사업자 등록증 파일 등록
            self.businessFileButton.click(function (e) {
                e.preventDefault();
                self.businessFile.trigger('click');
            });

            self.businessFileDeleteButton.click(function (e) {
                e.preventDefault();
                if (common.noti.confirm(common.lang.get('profile.company.file.confirm.delete'))) {
                    self.businessFile.val('');
                    self.businessFileChangeEvnet();
                }
            });

            self.businessFile.change(function (e) {
                self.businessFileChangeEvnet();
            });
        }
    },
    maketingChk: function () {
        // if ($('#devAgreeTerm').is(':checked')) {
        //     // 수신방법
        //     var selectedRecv = [];
        //
        //     if ($('#devAgreeSms').is(':checked')) {
        //         selectedRecv.push($('#devAgreeSms').attr('title'));
        //     }
        //
        //     if ($('#devAgreeEmail').is(':checked')) {
        //         selectedRecv.push($('#devAgreeEmail').attr('title'));
        //     }
        //
        //     common.noti.alert(common.lang.get('profile.common.policy.agree', {recvType: selectedRecv.join(',')}));
        // } else {
        //     common.noti.alert(common.lang.get('profile.common.policy.notAgree'));
        // }
    },
    run: function () {
        var self = this;

        //-----load language
        common.lang.load('profile.common.validation.email.doubleCheck', "이메일 중복 확인을 해주세요.");
        common.lang.load('profile.common.validation.email.success', "사용 가능한 이메일입니다.");
        common.lang.load('profile.common.validation.email.fail', "이미 사용중인 이메일입니다.");
        common.lang.load('profile.common.validation.email.wrong', "잘못된 이메일 형식입니다.");
        common.lang.load('profile.common.policy.agree', "마케팅 활용에 대한 수신이 동의 처리 되었습니다.{common.lineBreak} 선택채널:{recvType}");
        common.lang.load('profile.common.policy.notAgree', "마케팅 활용에 대한 수신이 거부 처리 되었습니다.");
        common.lang.load('profile.common.modify.save.confirm', "회원정보를 저장하시겠습니까?");
        common.lang.load('profile.common.modify.cancel.confirm', "회원정보 수정을 취소하시겠습니까?");
        common.lang.load('profile.common.validation.password.title', "비밀번호 변경");
        common.lang.load('profile.modal.validation.passwd.change', "비밀번호를 변경하시겠습니까?");
        common.lang.load('profile.modal.validation.passwd.change.success', "비밀번호가 정상적으로 변경되었습니다.");
        common.lang.load('profile.modal.validation.password.fail', "비밀번호 입력 조건에 맞게 입력해 주세요.");
        common.lang.load('profile.modal.validation.password.success', "사용 가능한 비밀번호 입니다.");
        common.lang.load('profile.modal.validation.password.change.equal', "현재 비밀번호와 다르게 입력해 주세요.");
        common.lang.load('profile.modal.validation.password.notequal', "새 비밀번호와 일치하게 입력해 주세요.");

        // 공용회원정보 처리
        self.basic.init();
        // Profile 수정 타입 확인
        if (profileType == 'company') {
            self.company.init();
        } else {
            self.basic.formInit();
        }


        //마케팅 활용 동의 관련
        $('#devAgreeTerm').on('click', function () {
            var isChecked = $(this).is(':checked');

            $('#devAgreeSms').prop('checked', isChecked);
            $('#devAgreeEmail').prop('checked', isChecked);
        });

        // SMS,Email checkbox Evnet
        $('#devAgreeSms,#devAgreeEmail').on('click', function () {
            var term = $('#devAgreeTerm');

            if ($('#devAgreeSms').is(':checked') || $('#devAgreeEmail').is(':checked')) {
                term.prop('checked', true);
            } else {
                term.prop('checked', false);
            }
        });

        // 비밀번호 변경창 오픈
        $('#devChangePassword').click(function () {
            common.util.modal.open('ajax', common.lang.get('profile.common.validation.password.title'), '/mypage/password','',function (){
                // set validation
                common.validation.set($('#devPmPassword'), {'required': true, 'dataFormat': 'userPassword'});
                common.validation.set($('#devPmComparePassword'), {'required': true, 'compare': '#devPmPassword'});
            });
        });

        // 비밀번호 체크
        $('#devModalContent').on('input', '#devPmPassword', function (e) {
            if (common.validation.check($(this))) {
                common.noti.tailMsg(this.id, common.lang.get('profile.modal.validation.password.success'), 'success');
            } else {
                common.noti.tailMsg(this.id, common.lang.get('profile.modal.validation.password.fail'));
            }
        });

        // 비밀번호 확인
        $('#devModalContent').on('input', '#devPmComparePassword', function (e) {
            if($(this).val() != '' && ($(this).val() != $("#devPmPassword").val())){
                common.noti.tailMsg(this.id, common.lang.get('profile.modal.validation.password.notequal'));
            }else{
                common.noti.tailMsg(this.id, '');
            }
        });

        // 비밀번호 변경창 닫기
        $('#devModalContent').on('click', '#devPmCancel', function () {
            common.util.modal.close();
        });

        // 비밀번호 전송
        $('#devModalContent').on('click', '#devPmSubmit', function () {
            common.ajax(
                common.util.getControllerUrl('changePassword', 'member'),
                {pw: $('#devPmPassword').val(), comparePw: $('#devPmComparePassword').val()},
                function () {
                    var ret = false;
                    ret = common.validation.check($('#devPmComparePasswordForm'), 'alert', false);

                    // Form validation
                    return ret && common.noti.confirm(common.lang.get("profile.modal.validation.passwd.change"));
                },
                function (ret) {
                    if (ret.result == 'success') {
                        common.util.modal.close();
                        common.noti.alert(common.lang.get('profile.modal.validation.passwd.change.success'));
                    } else if(ret.result == 'equalCurrentPw'){
                        common.noti.alert(common.lang.get('profile.modal.validation.password.change.equal'));
                    } else {
                        console.log(ret);
                    }
                }
            );
        });

        // 취소 버튼
        $('#devProfileModifyCancel').on('click', function () {
            if (common.noti.confirm(common.lang.get('profile.common.modify.cancel.confirm'))) {
                location.href = '/mypage';
            }
        });

        $('#devStateSelect').on('change',function(){
            $('#devStateText').val($(this).val());
        });

        $('.devNationArea').on('change',function(){
            var country = $(this).children("option:selected").data('nation_code');

            $('.devNationArea').find('[data-nation_code='+country+']').prop('selected','selected');

            if(country == 'US'){
                $('#devStateSelect').show();
                $('#devStateText').hide();
            }else{
                $('#devStateText').show();
                $('#devStateSelect').hide();
            }

        });

    }
};

// Script run
$(function () {
    devProfileObj.run();
});