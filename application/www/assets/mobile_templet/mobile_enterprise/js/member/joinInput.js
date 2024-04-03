"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//이용약관 팝업
$('.term-content').on("click", function () {
    var term_title = $(this).siblings().find("input").attr("data-title");
    var data_name = $(this).siblings().find("input").attr("data-name");

    $(".term__popup").show();
    $(".term__popup-name").html(term_title);
    $(".term__popup-content").hide();
    $(".term__popup-content"+ "." + data_name).show();
});

$('.term__popup .close').click(function (e) {
    $(".term__popup").hide();
})
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('joinInput.cancel.confirm', "회원 가입을 취소하시겠습니까?"); //Confirm_01
common.lang.load('joinInput.common.validation.userId.doubleCheck', "아이디 중복 확인을 해주세요.");
common.lang.load('joinInput.common.validation.userId.fail', "이미 가입된 아이디입니다. 다른 아이디를 입력하세요.");
common.lang.load('joinInput.common.validation.userId.withdrawn', "탈퇴한 아이디입니다. 다른 아이디를 입력하세요.");
common.lang.load('joinInput.common.validation.userId.success', "사용 가능한 아이디 입니다.");
common.lang.load('joinInput.common.validation.userPassword.fail', "영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 6~20자리로 입력해 주세요.");
common.lang.load('joinInput.common.validation.userPassword.fail1', "아이디와 비밀번호가 동일합니다. 다시 입력해주시기 바랍니다.");
common.lang.load('joinInput.common.validation.userPassword.success', "사용 가능한 비밀번호 입니다.");
common.lang.load('joinInput.common.validation.userComparePassword.fail', "비밀번호 확인을 위해 다시 한번 입력해 주세요.");
common.lang.load('joinInput.common.validation.email.doubleCheck', "이메일 중복 확인을 해주세요.");
common.lang.load('joinInput.common.validation.email.success', "사용 가능한 이메일입니다.");
common.lang.load('joinInput.common.validation.email.fail', "이미 사용중인 이메일입니다. 다른 이메일을 입력하세요.");
common.lang.load('joinInput.common.validation.login.sessionIssue', "오랜 시간 지연으로 회원가입이 실패되었습니다.{common.lineBreak}다시 진행해 주세요."); //Alert_85
common.lang.load('joinInput.common.validation.login.authIssue', "올바르지 않은 본인인증 접근 경로입니다."); //Alert_86
common.lang.load('joinInput.common.validation.login.doubleId', "동일한 아이디가 존재합니다.{common.lineBreak}다른 아이디로 입력해 주세요."); //Alert_87
common.lang.load('joinInput.common.validation.companyCertify.fail', "휴대폰 인증을 해주세요.");
common.lang.load('joinInput.company.file.confirm.delete', "파일을 삭제하시겠습니까?");

//회원가입 타입 지정(단일 가입 스타일 이기때문에 정보입력 단계에서 지정 해줌)
//joinSelectType('B');

//-----일반, 사업자 공통
var isUserIdRegExp = false; //아이디 정규식 규칙 플레그
var isUserIdDoubleCheck = false; //아이디 중복 체크 플레그

var userIdDoubleCheckResponse = function (response) {
    if (response.result == "success") {
        isUserIdDoubleCheck = true;
        common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.success'), 'success');
        $('#devDupMember').hide();
    } else if (response.result == "fail") {
        common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.fail'));
        $('#devDupMember').show();
    } else if (response.result == "withdrawn"){
        common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.withdrawn'));
        $('#devDupMember').hide();
    } else {
        common.noti.alert("system error");
    }
};

//이메일 체크
var isEmailRegExp = false; //이메일 정규식 규칙 플레그
var isEmailDoubleCheck = false; //이메일 중복 체크 플레그
var $emailHost = $('#devEmailHost');
var $emailHostSelect = $('#devEmailHostSelect');
var $directInputEmailCheckBox = $('#devDirectInputEmailCheckBox');
var $emailDoubleCheckButton = $('#devEmailDoubleCheckButton');


function joinSelectType(joinType) {
    common.ajax(common.util.getControllerUrl('joinSelectType', 'member'), {'joinType': joinType}, "", joinSelectResponse);
}

var joinSelectResponse = function (response) {
    if (!response.result == "success") {

        common.noti.alert("system error");
    }
};

function getEmail() {
    return $('#devEmailId').val().trim() + '@' + $('#devEmailHost').val().trim();
}
function checkEmail() {
    isEmailRegExp = false;
    isEmailDoubleCheck = false;

    $emailDoubleCheckButton.attr('disabled', false);

    var result = common.validation.checkElement($('#devEmailId').get(0));
    if (result.success) {
        isEmailRegExp = true;
        common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
    } else {
        common.noti.tailMsg('devEmailId', result.message);
    }
}

var emailDoubleCheckResponse = function (response) {
    if (response.result == "success") {
        isEmailDoubleCheck = true;
        $emailDoubleCheckButton.attr('disabled', true);
        common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.success"), 'success');
    } else if (response.result == "fail") {
        common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.fail"));
    } else {
        common.noti.alert("system error");
    }
};

//-----취소
var authCancel = function () {
    document.location.href = '/';
}

//-----일반회원 가입
var zipResponse = function (response) {
    $('#devZip').val(response.zipcode);
    $('#devAddress1').val(response.address1);
}
//가입
var $form = $('#devBasicForm');
var url = common.util.getControllerUrl('joinInputBasic', 'member');
var beforeCallback = function ($form) {


    if(common.validation.check($form, 'alert', false)){
        //아이디 관련 체크
        if (isUserIdRegExp != true || isUserIdDoubleCheck != true) {
            if ( typeof $('#devUserId').val() != "undefined" ){
                common.noti.alert(common.lang.get('joinInput.common.validation.userId.doubleCheck'));
                $('#devDupMember').hide();
                return false;
            }
        }
        //이메일 관련 체크
        if (isEmailRegExp != true || isEmailDoubleCheck != true) {
            common.noti.alert(common.lang.get('joinInput.common.validation.email.doubleCheck'));
            return false;
        }
        return true;
    }

    return false;
};
var successCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/joinEnd';
    } else if (response.result == "sessionIssue") { //세션 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.sessionIssue'));
    } else if (response.result == "authIssue") { //인증 데이터 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.authIssue', authIssueCallback));
    } else if (response.result == "doubleId") { //중복된 아이디
        common.noti.alert(common.lang.get('joinInput.common.validation.login.doubleId', doubleIdCallback));
    } else {
        common.noti.alert('system error');
    }
};

var authIssueCallback = function () {
    location.href = '/';
}
var doubleIdCallback = function () {
    $('#devUserId').val('');
    common.util.focus($('#devUserId').get(0));
}

//-----사업자회원 가입
var comZipResponse = function (response) {
    $('#devComZip').val(response.zipcode);
    $('#devComAddress1').val(response.address1);
}

var $comEmailHost = $('#devComEmailHost');
var $comEmailHostSelect = $('#devComEmailHostSelect');
var $directInputComEmailCheckBox = $('#devDirectInputComEmailCheckBox');
$comEmailHost.val($comEmailHostSelect.val()); //페이지 로드후 기본적으로 input 에 set

function getComEmail() {
    return $('#devComEmailId').val().trim() + '@' + $('#devComEmailHost').val().trim();
}
function checkComEmail() {
    var result = common.validation.checkElement($('#devComEmailId').get(0));
    if (result.success) {
        common.noti.tailMsg('devComEmailId', '');
    } else {
        common.noti.tailMsg('devComEmailId', result.message);
    }
}
//담당자 휴대폰 인증
var isCompanyCertify = false; //담당자 휴대폰 인증 플레그

//사업자 등록증 파일
var $file = $('#devBusinessFile');
var $fileWrap = $('#devBusinessFileWrap');
var $imageWrap = $('#devBusinessFileImageWrap');
var $image = $('#devBusinessFileImage');
var $fileDeleteButton = $('#devBusinessFileDeleteButton');

var deleteConfirmOk = function () {
    $file.val('');
    businessFileChangeEvnet();
}

function businessFileChangeEvnet() {
    if ($file.val() != "") {
        $fileWrap.hide();
        $imageWrap.show();
        common.util.previewFile($file, $image);
    } else {
        $fileWrap.show();
        $imageWrap.hide();
        $image.attr('src', '');
    }
}
//가입
var $companyform = $('#devCompanyForm');
var companyUrl = common.util.getControllerUrl('joinInputCompany', 'member');
var companyBeforeCallback = function ($companyform) {
    //아이디 관련 체크
    if (isUserIdRegExp != true || isUserIdDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.userId.doubleCheck'));
        return false;
    }
    //이메일 관련 체크
    if (isEmailRegExp != true || isEmailDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.email.doubleCheck'));
        return false;
    }
    //
    if (isCompanyCertify != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.companyCertify.fail'));
        return false;
    }
    return common.validation.check($companyform, 'alert', false);
};
var companySuccessCallback = function (response) {
    console.log(response);
    if (response.result == "success") {
        location.href = '/member/joinEnd';
    } else if (response.result == "sessionIssue") { //세션 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.sessionIssue'));
    } else if (response.result == "authIssue") { //인증 데이터 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.authIssue', companyAuthIssueCallback));
    } else if (response.result == "doubleId") { //중복된 아이디
        common.noti.alert(common.lang.get('joinInput.common.validation.login.doubleId', companyDoubleIdCallback));
    } else {
        common.noti.alert('system error');
    }
};

var companyAuthIssueCallback = function () {
    location.href = '/';
}
var companyDoubleIdCallback = function () {
    $('#devUserId').val('');
    common.util.focus($('#devUserId').get(0));
}

// object
var devJoinInputObj = {
    initFormat: function () {
        //-----set input format
        common.inputFormat.set($('#devUserId,#devUserPassword,#devCompareUserPassword'), {'maxLength': 20});
        common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#comPhone2,#comPhone3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devComCeo,#devUserName'), {'maxLength': 20});
        common.inputFormat.set($('#devComPcs2,#devComPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devBusinessFile'), {'fileFormat': 'image', 'fileSize': 30});

        common.inputFormat.set($('#devUnderAge'), {'selected': true});
    },
    initValidation: function () {
        //-----set validation
        common.validation.set($('#devUserId'), {'required': true, 'dataFormat': 'userId'});
        common.validation.set($('#devUserPassword'), {'required': true, 'dataFormat': 'userPassword'});
        common.validation.set($('#devCompareUserPassword'), {'required': true, 'compare': '#devUserPassword'});
        common.validation.set($('#devEmailId,#devEmailHost'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getEmail'
        });
        if(common.langType=='english'){
            common.validation.set($('#devPcs'), {'required': true});
            common.validation.set($('#devCity'), {'required': true});
            common.validation.set($('#devStateText'), {'required': true});
        }else {
            common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
        }
        common.validation.set($('#comPhone2,#comPhone3'), {'required': true});
        common.validation.set($('#devComZip,#devComAddress1,#devComAddress2'), {'required': true});
        common.validation.set($('#devComCeo,#devUserName'), {'required': true});
        common.validation.set($('#devComEmailId,#devComEmailHost'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getComEmail'
        });
        common.validation.set($('#devComPcs2,#devComPcs3'), {'required': true});
        common.validation.set($('#devBusinessFile'), {'required': true});

        //common.validation.set($('#devZip,#devAddress1,#devAddress2'), {'required': true});
        common.validation.set($('#devPolicyUse,#devPolicyCollection'), {'required': true});

        common.validation.set($('#devUnderAge'), {'required': true});
    },
    initCommonEvent: function () {
        //아이디 입력시 정규식 체크
        $('#devUserId').on({
            'input': function (e) {
                isUserIdRegExp = false;
                isUserIdDoubleCheck = false;
                if (common.validation.check($(this))) {
                    isUserIdRegExp = true;
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userId.doubleCheck'));
                }
            }
        });
        //아이디 중복 체크
        $('#devUserIdDoubleCheckButton').click(function (e) {
            e.preventDefault();
            isUserIdDoubleCheck = false;
            if (isUserIdRegExp == true) {
                common.ajax(common.util.getControllerUrl('userIdCheck', 'member'), {'userId': $('#devUserId').val()}, "", userIdDoubleCheckResponse);
            }
        });
        //비밀번호 체크
        $('#devUserPassword').on({
            'input': function (e) {
                if (common.validation.check($(this))) {
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userPassword.success'), 'success');
                } else {
					if ($('#devUserPassword').val() == $('#devUserId').val()) {
						common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userPassword.fail1'));
					} else {
						common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userPassword.fail'));
					}
                }
            }
        });
        //비밀번호 확인 체크
        $('#devCompareUserPassword').on({
            'input': function (e) {
                if (common.validation.check($(this))) {
                    common.noti.tailMsg(this.id, "");
                }
            }
        });
        //이메일

        if($emailHost.val() == '' ){
            if(common.langType == 'korean'){
                $emailHost.val($emailHostSelect.val()); //페이지 로드후 기본적으로 input 에 set
                $emailHost.attr('readonly', true);
            }
        }else{
            checkEmail();
        }

        $emailHostSelect.change(function (e) {
            if($emailHostSelect.val() == 'direct'){
                $emailHost.val('');
                $emailHost.attr('readonly', false);
                $emailHost.focus();
            }else{
                $emailHost.val($emailHostSelect.val());
            }
            checkEmail();
        });
        $directInputEmailCheckBox.change(function (e) {
            if ($directInputEmailCheckBox.is(':checked')) {
                $emailHost.show();
                $emailHostSelect.hide();
                $emailHost.val('');
            } else {
                $emailHost.hide();
                $emailHostSelect.show();
                $emailHost.val($emailHostSelect.val());
            }
            checkEmail();
        });

        $('#devEmailId,#devEmailHost').on({
            'input': function (e) {
                checkEmail();
            }
        });
        //이메일 중복 체크
        $emailDoubleCheckButton.click(function (e) {
            e.preventDefault();
            if (isEmailRegExp == true) {
                common.ajax(common.util.getControllerUrl('emailCheck', 'member'), {'email': getEmail()}, "", emailDoubleCheckResponse);
            }
        });
        //취소
        $('#devCancelButton').click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.cancel.confirm'), authCancel);
        });

        $('#devStateSelect').on('change',function(){
           $('#devStateText').val($(this).val());
        });

        $('.devNationArea').on('change',function(){
            var country = $(this).children("option:selected").data('nation_code');

            $('.devNationArea').find('[data-nation_code='+country+']').prop('selected','selected');

            if(country == 'US'){
                $('#devStateSelect option:eq(0)').prop('selected', true);
                $('#devStateSelect').show();
                $('#devStateText').hide();
                $('#devStateSelect').attr('devvalidation', '{"required":true}');
                $('#devStateText').attr('devvalidation', '{"required":false}');
            }else{
                $('#devStateText').val('');
                $('#devStateText').show();
                $('#devStateSelect').hide();
                $('#devStateText').attr('devvalidation', '{"required":true}');
                $('#devStateSelect').attr('devvalidation', '{"required":false}');
            }

        });
    },
    initMemberEvent: function () {
        //-----일반회원 가입
        //주소 찾기
        $('#devZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(zipResponse);
        });

        $('#devBasicSubmitButton').click(function (e) {
            e.preventDefault();
            if($('input[id="devUnderAge"]:checked').val() == "N"){
                alert("만 14세미만은 회원가입이 불가능 합니다.");
                return false;
            } else {
                if($('#devbirthYear').val() && $('#devbirthMonth').val() && $('#devbirthDay').val()){
                    var date = new Date();
                    var year = date.getFullYear();
                    var month = (date.getMonth() + 1);
                    var day = date.getDate();
                    if (month < 10) month = '0' + month;
                    if (day < 10) day = '0' + day;
                    var monthDay = month + day;

                    var birthdayy = $('#devbirthYear').val();
                    var birthdaymd = $('#devbirthMonth').val()+$('#devbirthDay').val();

                    var age = monthDay < birthdaymd ? year - birthdayy - 1 : year - birthdayy;

                    if(age < 14) {
                        alert("만 14세미만은 회원가입이 불가능 합니다.");
                        return false;
                    }
                }
                $form.submit();
            }
        });

        common.form.init($form, url, beforeCallback, successCallback);
    },
    initCompanyMemberEvent: function () {
        //-----사업자회원 가입
        //사업자 주소 찾기
        $('#devComZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(comZipResponse);
        });

        //대표
        $comEmailHostSelect.change(function (e) {
            $comEmailHost.val($comEmailHostSelect.val());
            checkComEmail();
        });
        $directInputComEmailCheckBox.change(function (e) {
            if ($directInputComEmailCheckBox.is(':checked')) {
                $comEmailHost.show();
                $comEmailHostSelect.hide();
                $comEmailHost.val('');
            } else {
                $comEmailHost.hide();
                $comEmailHostSelect.show();
                $comEmailHost.val($comEmailHostSelect.val());
            }
            checkComEmail();
        });

        $('#devComEmailId,#devComEmailHost').on({
            'input': function (e) {
                checkComEmail();
            }
        });

        //본인 인증
        $('#devCertifyButton').click(function (e) {
            e.preventDefault();
            common.certify.request('certify');
        });
        //본인, 아이핀 인증 응답 공통
        common.certify.setSuccess(function (data) {
            isCompanyCertify = true;
            $('#devCertifyPcsText').text(data.pcs);
            $('#devCertifyButton').remove();
            $('#devCertifyCompleteAreaWrap').show();
        });
        common.certify.setFail(function (message) {
            isCompanyCertify = false;
            common.noti.alert(message);
        });

        //파일업로드 버튼 이벤트 정의
        $fileDeleteButton.click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.company.file.confirm.delete'), deleteConfirmOk)
        });

        $file.change(function (e) {
            businessFileChangeEvnet();
        });

        $('#devCompanySubmitButton').click(function (e) {
            e.preventDefault();
            $companyform.submit();
        });

        common.form.init($companyform, companyUrl, companyBeforeCallback, companySuccessCallback);
    },
    run: function () {
        var self = this;

        self.initFormat();
        self.initValidation();
        self.initCommonEvent();
        self.initMemberEvent();
        self.initCompanyMemberEvent();
    }
};

$(function () {
    devJoinInputObj.run();
    //SNS 구글 연동 페이지 이탈 시 구글 로그아웃
    var type = $('#devSnsType').val();
    if(type == 'google') {
        $(window).on("beforeunload", function () {
            return signOut();
        });
    }
});


$(function () {
    relation_checkbox($('#all_terms_check'), $('.agree-content input[type=checkbox]'));
});

function relation_checkbox($all_checkbox, $target_checkbox) {
    $all_checkbox.click(function () {
        if ($all_checkbox.is(':checked')) {
            $target_checkbox.prop("checked", true);
        } else {
            $target_checkbox.prop("checked", false);
        }
    });

    $target_checkbox.click(function () {
        if ($target_checkbox.length == $target_checkbox.filter(':checked').length) {
            $all_checkbox.prop("checked", true);
        } else {
            $all_checkbox.prop("checked", false);
        }
    });
}