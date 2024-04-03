"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----일반, 사업자 공통
var isUserIdRegExp = false; //아이디 정규식 규칙 플레그
var isUserIdDoubleCheck = false; //아이디 중복 체크 플레그
var userIdDoubleCheckResponse = function (response) {
    if (response.result == "success") {
        isUserIdDoubleCheck = true;
        $('#devUserIdDoubleCheckButton').attr('disabled', true);

        common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.success'), 'success');
    } else if (response.result == "fail") {
        common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.fail'));
    } else {
        common.noti.alert("system error");
    }
};

var isNicknameRegExp = false; //닉네임 정규식 규칙 플레그
var isNicknameDoubleCheck = false; //닉네임 중복 체크 플레그
var nicknameDoubleCheckResponse = function (response) {
    if (response.result == "success") {
        isNicknameDoubleCheck = true;
        $('#devNicknameDoubleCheckButton').attr('disabled', true);

        common.noti.tailMsg('devNickname', common.lang.get('joinInput.common.validation.nickname.success'), 'success');
    } else if (response.result == "fail") {
        common.noti.tailMsg('devNickname', common.lang.get('joinInput.common.validation.nickname.fail'));
    } else {
        common.noti.alert("system error");
    }
};

//이메일 체크
var isEmailRegExp = false; //이메일 정규식 규칙 플레그
var isEmailDoubleCheck = false; //이메일 중복 체크 플레그
var $emailDoubleCheckButton = $('#devEmailDoubleCheckButton');

var emailDoubleCheckResponse = function (response) {
    if (response.result == "success") {
        isEmailDoubleCheck = true;
        // $emailDoubleCheckButton.attr('disabled', true);
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

///////////////////////////일반회원
var zipResponse = function (response) {
    $('#devZip').val(response.zipcode);
    $('#devAddress1').val(response.address1);
}
//가입
var $form = $('#devBasicForm');
var url = common.util.getControllerUrl('joinInputBasic', 'member');
var beforeCallback = function ($form) {
    // //이메일 아이디 관련 체크
    if (isEmailRegExp != true || isEmailDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.email.doubleCheck'));
        return false;
    }

    //닉네임 관련 체크
    if (isNicknameRegExp != true || isNicknameDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.nickname.doubleCheck'));
        return false;
    }

    if(!common.validation.check($form, 'alert', false)){
        return false;
    }

    //본인인증 관련 체크
    if (isCompanyCertify != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.companyCertify.fail'));
        return false;
    }

    //피부타입 필수 체크
    var skinCheckBool = false;
    $('input[name=skinType]').each(function(){
        if($(this).is(':checked') == true){
            skinCheckBool = true;
        }
    });
    if(skinCheckBool == false){
        common.noti.alert(common.lang.get('joinInput.common.validation.skinType.fail'));
        return false;
    }

    //피부고민 필수 체크
    var skinTroubleCheckBool = false;
    $('input[name^=skinTrouble]').each(function(){
        if($(this).is(':checked') == true){
            skinTroubleCheckBool = true;
        }
    });
    if(skinTroubleCheckBool == false){
        common.noti.alert(common.lang.get('joinInput.common.validation.skinTrouble.fail'));
        return false;
    }

    //관심항목 필수 체크
    var interestCheckCount = 0;
    $('input[name^=interest]').each(function(){
        if($(this).is(':checked') == true){
            interestCheckCount++;
        }
    });
    if(interestCheckCount < 2){
        common.noti.alert(common.lang.get('joinInput.common.validation.interest.fail'));
        return false;
    }

    return true;
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

function getEmail() {
    return $('#devEmailId').val().trim() + '@' + $('#devEmailHost').val().trim();
}
function checkEmail() {
    isEmailRegExp = false;
    isEmailDoubleCheck = false;
    var id = $('#devEmailId').val()+'@'+$('#devEmailHost').val();
    if($('#devEmailId').val().length > 0 && $('#devEmailHost').val().length > 0){
        $('#devUserIdDoubleCheckButton').attr('disabled', false);
        var result = common.validation.checkElement($('#devEmailId').get(0));
        if (result.success) {
            isEmailRegExp = true;
            common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
        } else {
            common.noti.tailMsg('devEmailId', result.message);
        }
    }
}
///////////////////////////일반회원 끝

//////////////////////////사업자회원
var comZipResponse = function (response) {
    $('#devComZip').val(response.zipcode);
    $('#devComAddress1').val(response.address1);
}
//담당자 휴대폰 인증
var isCompanyCertify = false; //담당자 휴대폰 인증 플레그
//셀러 등록증 파일
var $file = $('#devBusinessFile');
var $fileButton = $('#devBusinessFileButton');
var $fileDeleteButton = $('#devBusinessFileDeleteButton');
var $fileText = $('#devBusinessFileText');
var deleteConfirmOk = function () {
    $file.val('');
    businessFileChangeEvnet();
}

//셀러 통장사본 파일
var $copyAccountFile = $('#devCopyAccountFile');
var $copyAccountFileButton = $('#devCopyAccountFileButton');
var $copyAccountFileDeleteButton = $('#devCopyAccountFileDeleteButton');
var $copyAccountFileText = $('#devCopyAccountFileText');
var deleteCopyAccountFileConfirmOk = function () {
    $copyAccountFile.val('');
    copyAccountFileChangeEvnet();
}

//셀러 통신판매업 파일
var $mailOrderBusinessFile = $('#devMailOrderBusinessFile');
var $mailOrderBusinessFileButton = $('#devMailOrderBusinessFileButton');
var $mailOrderBusinessFileDeleteButton = $('#devMailOrderBusinessFileDeleteButton');
var $mailOrderBusinessFileText = $('#devMailOrderBusinessFileText');
var deleteMailOrderConfirmOk = function () {
    $mailOrderBusinessFile.val('');
    mailOrderFileChangeEvnet();
}



//가입
var $companyform = $('#devCompanyForm');
var companyUrl = common.util.getControllerUrl('joinInputCompany', 'member');
var companyBeforeCallback = function ($companyform) {

   //이메일 관련 체크
    if (isEmailRegExp != true || isEmailDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.email.doubleCheck'));
        return false;
    }

    if(!common.validation.check($companyform, 'alert', false)){
        return false;
    }

    // 본인인증
    if (isCompanyCertify != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.companyCertify.fail'));
        return false;
    }

    //피부타입 필수 체크
    var skinCheckBool = false;
    $('input[name=skinType]').each(function(){
        if($(this).is(':checked') == true){
            skinCheckBool = true;
        }
    });
    if(skinCheckBool == false){
        common.noti.alert(common.lang.get('joinInput.common.validation.skinType.fail'));
        return false;
    }

    //피부고민 필수 체크
    var skinTroubleCheckBool = false;
    $('input[name^=skinTrouble]').each(function(){
        if($(this).is(':checked') == true){
            skinTroubleCheckBool = true;
        }
    });
    if(skinTroubleCheckBool == false){
        common.noti.alert(common.lang.get('joinInput.common.validation.skinTrouble.fail'));
        return false;
    }

    //관심항목 필수 체크
    var interestCheckCount = 0;
    $('input[name^=interest]').each(function(){
        if($(this).is(':checked') == true){
            interestCheckCount++;
        }
    });
    if(interestCheckCount < 2){
        common.noti.alert(common.lang.get('joinInput.common.validation.interest.fail'));
        return false;
    }

    return true;
};
var companySuccessCallback = function (response) {
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
    $('#devEmailId').val('');
    common.util.focus($('#devEmailId').get(0));
}
//////////////////////////사업자회원 끝


//셀러가입
var $sellerform = $('#devSellerForm');
var sellerUrl = common.util.getControllerUrl('joinInputSeller', 'member');
var sellerBeforeCallback = function ($sellerform) {
    //아이디 관련 체크
    if (isUserIdRegExp != true || isUserIdDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.userId.doubleCheck'));
        return false;
    }

    if(!common.validation.check($sellerform, 'alert', false)){
        return false;
    }

    //이메일 관련 체크
    if (isEmailRegExp != true || isEmailDoubleCheck != true) {
        common.noti.alert(common.lang.get('joinInput.common.validation.email.doubleCheck'));
        return false;
    }

    return true;
};
var sellerSuccessCallback = function (response) {
    if (response.result == "success") {
        location.href = '/member/joinEnd';
    } else if (response.result == "sessionIssue") { //세션 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.sessionIssue'));
    } else if (response.result == "authIssue") { //인증 데이터 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.authIssue', sellerAuthIssueCallback));
    } else if (response.result == "doubleId") { //중복된 아이디
        common.noti.alert(common.lang.get('joinInput.common.validation.login.doubleId', sellerDoubleIdCallback));
    } else {
        common.noti.alert('system error');
    }
};
var sellerAuthIssueCallback = function () {
    location.href = '/';
}
var sellerDoubleIdCallback = function () {
    $('#devEmailId').val('');
    common.util.focus($('#devEmailId').get(0));
}
//////////////////////////셀러회원 끝


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
function businessFileChangeEvnet() {
    if ($file.val() != "") {
        $fileText.val($file.val());
        $fileButton.text(common.lang.get('joinInput.company.file.change'));
        $fileDeleteButton.attr('disabled',false);
    } else {
        $fileText.val('')
        $fileButton.text(common.lang.get('joinInput.company.file.find'));
        $fileDeleteButton.attr('disabled',true);
    }
}

function copyAccountFileChangeEvnet() {
    if ($copyAccountFile.val() != "") {
        $copyAccountFileText.val($copyAccountFile.val());
        $copyAccountFileButton.text(common.lang.get('joinInput.company.file.change'));
        $copyAccountFileDeleteButton.attr('disabled',false);
    } else {
        $copyAccountFileText.val('')
        $copyAccountFileButton.text(common.lang.get('joinInput.company.file.find'));
        $copyAccountFileDeleteButton.attr('disabled',true);
    }
}

function mailOrderFileChangeEvnet() {
    if ($mailOrderBusinessFile.val() != "") {
        $mailOrderBusinessFileText.val($mailOrderBusinessFile.val());
        $mailOrderBusinessFileButton.text(common.lang.get('joinInput.company.file.change'));
        $mailOrderBusinessFileDeleteButton.attr('disabled',false);
    } else {
        $mailOrderBusinessFileText.val('')
        $mailOrderBusinessFileButton.text(common.lang.get('joinInput.company.file.find'));
        $mailOrderBusinessFileDeleteButton.attr('disabled',true);
    }
}

common.lang.load('joinInput.cancel.confirm', "회원 가입을 취소하시겠습니까?"); //Confirm_01
common.lang.load('joinInput.common.validation.userId.doubleCheck', "아이디 중복 확인을 해주세요.");
common.lang.load('joinInput.common.validation.userId.fail', "이미 사용중인 아이디 입니다.");
common.lang.load('joinInput.common.validation.userId.success', "사용 가능한 아이디 입니다.");
common.lang.load('joinInput.common.validation.nickname.doubleCheck', "닉네임 중복 확인을 해주세요.");
common.lang.load('joinInput.common.validation.nickname.fail', "이미 사용중인 닉네임 입니다.");
common.lang.load('joinInput.common.validation.nickname.success', "사용 가능한 닉네임 입니다.");
common.lang.load('joinInput.common.validation.userPassword.fail', "영문 대소문자, 숫자, 특수문자 중 3개 이상을 조합하여 8자리 이상 입력해 주세요.");
common.lang.load('joinInput.common.validation.userPassword.success', "사용 가능한 비밀번호 입니다.");
common.lang.load('joinInput.common.validation.userComparePassword.fail', "비밀번호 확인을 위해 다시 한번 입력해 주세요.");
common.lang.load('joinInput.common.validation.email.doubleCheck', "이메일 중복 확인을 해주세요.");
common.lang.load('joinInput.common.validation.email.success', "사용 가능한 이메일입니다.");
common.lang.load('joinInput.common.validation.email.fail', "이미 사용중인 이메일입니다.");
common.lang.load('joinInput.common.validation.login.sessionIssue', "오랜 시간 지연으로 회원가입이 실패되었습니다.{common.lineBreak}다시 진행해 주세요."); //Alert_85
common.lang.load('joinInput.common.validation.login.authIssue', "올바르지 않은 본인인증 접근 경로입니다."); //Alert_86
common.lang.load('joinInput.common.validation.login.doubleId', "동일한 아이디가 존재합니다.{common.lineBreak}다른 아이디로 입력해 주세요."); //Alert_87
common.lang.load('joinInput.common.validation.companyCertify.fail', "휴대폰 인증을 해주세요.");
common.lang.load('joinInput.common.validation.skinType.fail', "피부타입을 선택 해주세요.");
common.lang.load('joinInput.common.validation.skinTrouble.fail', "피부고민을 선택 해주세요.");
common.lang.load('joinInput.common.validation.interest.fail', "관심항목은 2개 이상 선택해 주세요.");

common.lang.load('joinInput.company.file.find', "파일찾기");
common.lang.load('joinInput.company.file.change', "파일변경");
common.lang.load('joinInput.company.file.confirm.delete', "파일을 삭제하시겠습니까?");

common.lang.load('joinInput.common.noti.recommendFriend.noNickname', "가입되지 않은 추천친구입니다. 다시 확인해 주세요.");
common.lang.load('joinInput.common.noti.recommandFriend.success', "친구가 확인되었습니다.");
common.lang.load('joinInput.common.noti.recommandFriend.fail', "등록되지 않은 친구입니다.");

// object
var devJoinInputObj = {
    initFormat: function () {
        //-----set input format
        // common.inputFormat.set($('#devUserId,#devUserPassword,#devCompareUserPassword'), {'maxLength': 20});
        common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#comPhone2,#comPhone3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devComCeo,#devUserName'), {'maxLength': 20});
        common.inputFormat.set($('#devComPcs2,#devComPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devBusinessFile'), {'fileFormat': 'image', 'fileSize': 30});
        common.inputFormat.set($('#devProfile'), {'fileFormat': 'image', 'fileSize': 30});
    },
    initValidation: function () {
        //-----set validation
        common.validation.set($('#devUserId'), {'required': true, 'dataFormat': 'userId'});
        common.validation.set($('#devUserPassword'), {'required': true, 'dataFormat': 'userPassword'});
        common.validation.set($('#devCompareUserPassword'), {'required': true, 'compare': '#devUserPassword'});
        common.validation.set($('#devEmailId, #devEmailHost'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getEmail'
        });
        common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
        // common.validation.set($('#comPhone2,#comPhone3'), {'required': true});
        // common.validation.set($('#devComZip,#devComAddress1,#devComAddress2'), {'required': true});
        common.validation.set($('#devComCeo,#devUserName'), {'required': true});
        common.validation.set($('#devComEmailId,#devComEmailHost'), {
            'required': true,
            'dataFormat': 'email',
            'getValueFunction': 'getComEmail'
        });
        common.validation.set($('#devComPcs2,#devComPcs3'), {'required': true});
        common.validation.set($('#devBusinessFile'), {'required': true});
        common.validation.set($('#devCopyAccountFile'), {'required': true});
        common.validation.set($('#devMailOrderBusinessFile'), {'required': true});

        common.validation.set($('#devDi'), {'required': true});
        common.validation.set($('#devNickname'), {'required': true});

        common.validation.set($('#devBirthYear'), {'required': true});
        common.validation.set($('#devBirthMonth'), {'required': true});
        common.validation.set($('#devBirthDay'), {'required': true});

        common.validation.set($('#devBankOwner'), {'required': true});
        common.validation.set($('#devBasicBank'), {'required': true});
        common.validation.set($('#devBankNum'), {'required': true});
        common.validation.set($('#devComBusinessCategory, #devCombussinessStatus'), {'required': true});

        common.validation.set($('input[name="com_div"]'), {'required': true});
        common.validation.set($('input[name="seller_cid[]"]'), {'required': true});
        common.validation.set($('input:radio[name=skinType]'), {'required': true});

        common.validation.set($('#devComZip'), {'required': true});
        common.validation.set($('#devComAddress1'), {'required': true});
        common.validation.set($('#devComAddress2'), {'required': true});

    },
    initCommonEvent: function () {
        //아이디 입력시 정규식 체크
        $('#devEmailId, #devEmailHost, #devEmailHostSelect').on({
            'input change': function (e) {
                if (!(e.keyCode >=37 && e.keyCode<=40)) {
                    var v = $(this).val();
                    $(this).val(v.replace(/[^a-z0-9._]/gi,''));
                }

                if (isEmailDoubleCheck == true) {
                    $('#devUserIdDoubleCheckButton').attr('disabled', false);
                }
                isEmailRegExp = false;
                isEmailDoubleCheck = false;

                if (common.validation.check($(this))) {

                    isEmailRegExp = true;
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.email.doubleCheck'));
                }

            }
        });
        //아이디 이메일 중복 체크
        $('#devEmailDoubleCheckButton').click(function (e) {
            e.preventDefault();
            var id = $('#devEmailId').val()+'@'+$('#devEmailHost').val();
            if( $('#devEmailId').val().length > 0 && $('#devEmailHost').val().length > 0)
                isEmailRegExp = true;
            else
                isEmailRegExp = false;
            var memType = $('#devMemType').val();
            var chkFun = 'userIdCheck';
            if(memType == 'S'){
                chkFun = 'emailCheck';
            }

            if (isEmailRegExp == true) {
                common.ajax(common.util.getControllerUrl(chkFun , 'member'), {'userId': id}, "", emailDoubleCheckResponse);
            }
        });

        //닉네임 입력시 정규식 체크
        $('#devNickname').on({
            'input': function (e) {

                if (isNicknameDoubleCheck == true) {
                    $('#devNicknameDoubleCheckButton').attr('disabled', false);
                }
                isNicknameRegExp = false;
                isNicknameDoubleCheck = false;

                if (common.validation.check($(this))) {

                    isNicknameRegExp = true;
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.nickname.doubleCheck'));
                }

            }
        });

        //비밀번호 체크
        $('#devUserPassword').on({
            'input': function (e) {
                if (common.validation.check($(this))) {
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userPassword.success'), 'success');
                } else {
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userPassword.fail'));
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
        //이메일 체크
        $('#devEmailId,#devEmailHost').on({
            'input': function (e) {
                checkEmail();
            }
        });
        //이메일 서버 선택
        $('#devEmailHostSelect').change(function (e) {
            var selectValue = $(this).val();
            var $emailHost = $('#devEmailHost');
            $emailHost.val(selectValue);
            if (selectValue != '') {
                $emailHost.attr('readonly', true);
            } else {
                $emailHost.attr('readonly', false);
            }
            checkEmail();
        });
        //닉네임 중복 체크
        $('#devNicknameDoubleCheckButton').click(function (e) {
            e.preventDefault();
            if (isNicknameRegExp == true) {
                common.ajax(common.util.getControllerUrl('nicknameCheck', 'member'), {'nickname': $('#devNickname').val()}, "", nicknameDoubleCheckResponse);
            }
        });
        //취소
        $('#devCancelButton').click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.cancel.confirm'), authCancel);
        });


    },
    initMemberEvent: function () {
        //-----일반회원 가입
        //주소 찾기
        $('#devZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(zipResponse);
        });

        $('#devBasicSubmitButton').on('click',function (e) {
            e.preventDefault();
            $form.submit();
        });

        // 일반회원 가입
        common.form.init($form, url, beforeCallback, successCallback);
    },
    initCompanyMemberEvent: function () {
        //-----사업자회원 가입
        //사업자 주소 찾기
        $('#devComZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(comZipResponse);
        });

        //대표 이메일 체크
        $('#devComEmailId,#devComEmailHost').on({
            'input': function (e) {
                checkComEmail();
            }
        });
        $('#devComEmailHostSelect').change(function (e) {
            var selectValue = $(this).val();
            var $comEmailHost = $('#devComEmailHost');
            $comEmailHost.val(selectValue);
            if (selectValue != '') {
                $comEmailHost.attr('readonly', true);
            } else {
                $comEmailHost.attr('readonly', false);
            }
            checkComEmail();
        });
        //본인 인증
        $('#devCertifyButton').on('click', function (e) {
            e.preventDefault();
            common.certify.request('certify');
        });
        //본인, 아이핀 인증 응답 공통
        common.certify.setSuccess(function (data) {
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

        $('#devNicknameChk').on('click',function (e){
            e.preventDefault();
            var nickname = $('#devRecommandFriend').val();
            if(nickname.length == 0) return false;

            common.ajax(common.util.getControllerUrl('nicknameCheck', 'member'), {'nickname': nickname}, "", function(response){
                if(response.result == "fail"){//가입되어있는 닉네임
                    $('#devConfirmRecFriend').val('ok');
                    $('#devRecommandFriendText').html(common.lang.get('joinInput.common.noti.recommandFriend.success'));
                }else{
                    common.noti.alert(common.lang.get('joinInput.common.noti.recommendFriend.noNickname'));
                    $('#devRecommandFriendText').html(common.lang.get('joinInput.common.noti.recommandFriend.fail'));
                }
            })
        });

        $('#devCompanySubmitButton').click(function (e) {
            e.preventDefault();
            $companyform.submit();
        });
        
        common.form.init($companyform, companyUrl, companyBeforeCallback, companySuccessCallback);
    },
    initSellerMemberEvent: function () {
        //-----셀러회원 가입

        //아이디 입력시 정규식 체크
        $('#devUserId').on({
            'input': function (e) {
                self.isUserIdRegExp = false;
                self.isUserIdDoubleCheck = false;
                $('#devUserIdDoubleCheckButton').attr('disabled', false);
                if (common.validation.check($(this))) {
                    self.isUserIdRegExp = true;
                    common.noti.tailMsg(this.id, common.lang.get('joinInput.common.validation.userId.doubleCheck'));
                }
                if (!(e.keyCode >=37 && e.keyCode<=40)) {
                    var v = $(this).val();
                    $(this).val(v.replace(/[^a-z0-9]/gi,''));
                }
            }
        });
        //아이디 중복 체크
        $('#devUserIdDoubleCheckButton').click(function (e) {
            console.log(isUserIdRegExp);
            e.preventDefault();
            self.isUserIdDoubleCheck = false;
            if (self.isUserIdRegExp == true) {
                common.ajax(
                    common.util.getControllerUrl('userIdCheck', 'member'),
                    {
                        'userId': $('#devUserId').val()
                    },
                    '',
                    function (response) {
                        if (response.result == "success") {
                            self.isUserIdDoubleCheck = true;
                            $('#devUserIdDoubleCheckButton').attr('disabled', true);
                            common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.success'), 'success');
                        } else if (response.result == "fail") {
                            common.noti.tailMsg('devUserId', common.lang.get('joinInput.common.validation.userId.fail'));
                        } else {
                            console.log(response);
                        }
                    }
                );
            }
        });

        //사업자 주소 찾기
        $('#devComZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(comZipResponse);
        });

        //대표 이메일 체크
        $('#devComEmailId,#devComEmailHost').on({
            'input': function (e) {
                checkComEmail();
            }
        });
        $('#devComEmailHostSelect').change(function (e) {
            var selectValue = $(this).val();
            var $comEmailHost = $('#devComEmailHost');
            $comEmailHost.val(selectValue);
            if (selectValue != '') {
                $comEmailHost.attr('readonly', true);
            } else {
                $comEmailHost.attr('readonly', false);
            }
            checkComEmail();
        });


        //파일업로드 버튼 이벤트 정의
        $fileButton.click(function (e) {
            e.preventDefault();
            $file.trigger('click');
        });
        $fileDeleteButton.click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.company.file.confirm.delete'), deleteConfirmOk)
        });
        $file.change(function (e) {
            businessFileChangeEvnet();
        });



        //통장사본 파일업로드 버튼 이벤트 정의
        $copyAccountFileButton.click(function (e) {
            e.preventDefault();
            $copyAccountFile.trigger('click');
        });
        $copyAccountFileDeleteButton.click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.company.file.confirm.delete'), deleteCopyAccountFileConfirmOk)
        });
        $copyAccountFile.change(function (e) {
            copyAccountFileChangeEvnet();
        });



        //통신판매업 파일업로드 버튼 이벤트 정의
        $mailOrderBusinessFileButton.click(function (e) {
            e.preventDefault();
            $mailOrderBusinessFile.trigger('click');
        });
        $mailOrderBusinessFileDeleteButton.click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.company.file.confirm.delete'), deleteMailOrderConfirmOk)
        });
        $mailOrderBusinessFile.change(function (e) {
            mailOrderFileChangeEvnet();
        });



        $('#devSellerSubmitButton').click(function (e) {
            e.preventDefault();
            $sellerform.submit();
        });

        common.form.init($sellerform, sellerUrl, sellerBeforeCallback, sellerSuccessCallback);
    },
    run: function () {
        var self = this;

        self.initFormat();
        self.initValidation();
        self.initCommonEvent();
        self.initMemberEvent();
        self.initCompanyMemberEvent();
        self.initSellerMemberEvent();
    }
};

$(function () {
    devJoinInputObj.run();
});
