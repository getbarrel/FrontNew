"use strict";

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var $form = $('#devBasicForm');
var checkUnload = true;//페이지 벗어날시 체크값
var url = common.util.getControllerUrl('joinChampionship', 'event');
var beforeCallback = function ($form) {
    if(common.validation.check($form, 'alert', false)){
        return true;
    }
    checkUnload = true;
    return false;
};

var successCallback = function (response) {
    if (response.result == "success") {
        sprintAlert({
            title : "2024 배럴 스프린트 챔피언십 신청서 접수가 완료되었습니다.",
            desc : "다시 한 번 2024 배럴 스프린트 챔피언십의 \n 개최 요강을 확인하시기 바랍니다.",
            callback : function(){
                location.href = '/brand/applicationForm';
            }
        });
    } else if (response.result == "sessionIssue") { //세션 이슈
        common.noti.alert(common.lang.get('joinInput.common.validation.login.sessionIssue'));
    } else {
        //common.noti.alert('system error');
        sprintAlert({
            title : "배럴 스프린트 챔피언십 신청서 접수가 마감되었습니다.",
            //desc : "다시 한 번 2024 배럴 스프린트 챔피언십의 \n 개최 요강을 확인하시기 바랍니다.",
            callback : function(){
                location.href = '/brand/applicationForm';
            }
        });
    }
};

// object
var devJoinInputObj = {
    initFormat: function () {
        //-----set input format
        common.inputFormat.set($('#devBirthday'), {'maxLength': 6});
        common.inputFormat.set($('#devPcs2,#devPcs3,#devUserPassword'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devBusinessFile'), {'fileFormat': 'image', 'fileSize': 30});
    },
    initValidation: function () {
        //-----set validation
        common.validation.set($('#devUserName'), {'required': true});
        common.validation.set($('#devBirthday'), {'required': true});
        common.validation.set($('#devSize'), {'required': true});
        common.validation.set($('#devClass'), {'required': true});
        common.validation.set($('#devImageUrl'), {'required': true});
        common.validation.set($('#devImageUrlPath'), {'required': true});
        common.validation.set($('#devAttendGroup'), {'required': true});
        common.validation.set($('#devAttendEvent1'), {'required': true});
        common.validation.set($('#devPassword'), {'required': true});
        common.validation.set($('#devDepositor'), {'required': true});
        common.validation.set($('#devEmailId,#devEmailHost'), {'required': true});
        if(common.langType=='english'){
            common.validation.set($('#devPcs'), {'required': true});
            common.validation.set($('#devCity'), {'required': true});
            common.validation.set($('#devStateSelect'), {'required': true});
        }else{
            common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
        }

        //common.validation.set($('#devZip,#devAddress1,#devAddress2'), {'required': true});
        common.validation.set($('#devPolicyUse,#devPolicyCollection'), {'required': true});
    },
    initCommonEvent: function () {

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
        });

        //취소
        $('#devCancelButton').click(function (e) {
            e.preventDefault();
            common.noti.confirm(common.lang.get('joinInput.cancel.confirm'), authCancel);
        });

        $('#devBirthday').on('keyup', function() {
            var len =  $(this).val().length;
            if(len == 6) {
                $('#devAttendGroup').attr('disabled', false);
            }else {
                $('#devAttendGroup').val('');
                $('#devAttendGroup').attr('disabled', true);
                $('#devAttendDesc').hide();
            }
        });

        $('#devAttendGroup').on('change', function() {
            var birth = $('#devBirthday').val();
            var id = $(this).val();
            var first = '19';
            var flag = false;

            //0으로 시작시 2000년 이후 생
            if(birth.slice(0,1) == 0) {
                first = '20';
            }
            birth = parseInt(first+birth);
            switch(id){
                case '1' :
                    $('#devAttendDesc').text('1995년 01월 01일 ~ 2006년 12월 31일');
                    if(birth > 20061231 || birth < 19950101) {
                        flag = true;
                    }
                    break;
                case '2' :
                    $('#devAttendDesc').text('1985년 01월 01일 ~ 1994년 12월 31일');
                    if(birth > 19941231 || birth < 19850101) {
                        flag = true;
                    }
                    break;
                case '3' :
                    $('#devAttendDesc').text('1975년 01월 01일 ~ 1984년 12월 31일');
                    if(birth > 19841231 || birth < 19750101) {
                        flag = true;
                    }
                    break;
                case '4' :
                    $('#devAttendDesc').text('1965년 01월 01일 ~ 1974년 12월 31일');
                    if(birth > 19741231 || birth < 19650101) {
                        flag = true;
                    }
                    break;
                case '5' :
                    $('#devAttendDesc').text('1965년 01월 01일 이전 출생자');
                    if(birth >= 19650101) {
                        flag = true;
                    }
                    break;
                case '6' :
                    $('#devAttendDesc').text('1984년 01월 01일 ~ 2006년 12월 31일');
                    if(birth < 19840101 || birth > 20061231) {
                        flag = true;
                    }
                    break;
                case '7' :
                    $('#devAttendDesc').text('1984년 01월 01일 이전 출생자');
                    if(birth >= 19840101) {
                        flag = true;
                    }
                    break;
                default:
                    $('#devAttendDesc').text('');
                    break;
            }

            if(flag) {
                $("#devAttendRedDesc").show();
            }else {
                $("#devAttendRedDesc").hide();
            }

            $('#devAttendDesc').show();
        });
    },
    initMemberEvent: function () {
        //-----일반회원 가입
        $('#devFile').fileupload({
            dataType: 'json',
            done: function (e, data) {
                if(data.result.result == 'success') {
                    $('#devImageUrl').val(data.result.data.name);
                    $('#devImageUrlPath').val(data.result.data.newName);
                }else {
                    alert(data.result.data);
                }
            }
        });

        //주소 찾기
        $('#devZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup(zipResponse);
        });
        
        $(window).on("beforeunload", function(){
            if(checkUnload) return "이 페이지를 벗어나면 작성된 내용은 저장되지 않습니다.";
        });

        $('#devBasicSubmitButton').click(function (e) {
            e.preventDefault();
            checkUnload = false;
            if($('#devAttendRedDesc').css('display') != "none") {
                alert('생년월일과 맞는 그룹을 선택해주세요.');
                $('#devAttendGroup').focus();
                return false;
            }

            $form.submit();
        });

        $('#devAttendEvent1').on('change', function (e) {
            e.preventDefault();
            var option_value = $(this).val();
            $('#devAttendEvent2').val('');
            $('#devAttendEvent2 > option').each(function() {
               if(option_value == $(this).val()) {
                   $(this).hide();
               }else {
                   $(this).show();
               }
            });
        });

        $('#devAttendEvent2').on('click', function (e) {
            e.preventDefault();
            if($('#devAttendEvent1').val() == '') {
                alert('참가종목1 먼저 선택해주세요.');
                return false;
            }
        });

        // 일반회원 가입
        common.form.init($form, url, beforeCallback, successCallback);
    },
    run: function () {
        var self = this;

        self.initFormat();
        self.initValidation();
        self.initCommonEvent();
        self.initMemberEvent();
    }

};

$(function() {
    devJoinInputObj.run();
});

function noSubmit(year, sdate){
    alert(year + "스프린트 챔피언십 신청 접수는\n\n" + sdate + " 부터 신청 가능합니다.");
}