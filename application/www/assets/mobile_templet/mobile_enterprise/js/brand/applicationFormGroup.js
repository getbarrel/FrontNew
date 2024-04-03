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
        common.inputFormat.set($('#devMasterPcs2,#devMasterPcs3,#devPassword'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devBusinessFile'), {'fileFormat': 'image', 'fileSize': 30});
    },
    initValidation: function () {
        //-----set validation
        common.validation.set($('#devGroupName'), {'required': true});
        common.validation.set($('#devGroupMaster'), {'required': true});
        common.validation.set($('#devMasterPcs1'), {'required': true});
        common.validation.set($('#devMasterPcs2'), {'required': true});
        common.validation.set($('#devMasterPcs3'), {'required': true});
        common.validation.set($('#devSize'), {'required': true});
        common.validation.set($('#devMasterFileUrl'), {'required': true});
        common.validation.set($('#devClass'), {'required': true});
        common.validation.set($('#devAttendGroup'), {'required': true});
        common.validation.set($('#devAttendEvent1'), {'required': true});
        common.validation.set($('#devPassword'), {'required': true});
        common.validation.set($('#devDepositor'), {'required': true});
        common.validation.set($('#devMEmailId,#devMEmailHost'), {'required': true});
        if(common.langType=='english'){
            common.validation.set($('#devPcs'), {'required': true});
            common.validation.set($('#devCity'), {'required': true});
            common.validation.set($('#devStateSelect'), {'required': true});
        }else{
            common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
        }

        //common.validation.set($('#devZip,#devAddress1,#devAddress2'), {'required': true});
        common.validation.set($('#devPolicyUse,#devPolicyCollection'), {'required': true});

        common.validation.set($('.devRequire'), {'required': true});
    },
    initCommonEvent: function () {

        //이메일 서버 선택
        $('#devEmailHostSelect').change(function (e) {

            var selectValue = $(this).val();
            var $emailHost = $('#devMEmailHost');
            $emailHost.val(selectValue);
            if (selectValue != '') {
                $emailHost.attr('readonly', true);
            } else {
                $emailHost.attr('readonly', false);
            }
        });

        $(document).on('click', '.devDelete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var self = $(this);
            if(id != '' && typeof id != 'undefined'){
                var cnt = $('#devMemberCnt').val();
                if(confirm('기존 등록된 데이터가 삭제됩니다. 정말 삭제하시겠습니까?')){
                    common.ajax(
                        common.util.getControllerUrl('deleteChampionshipGroup', 'event'),
                        {
                            cm_ix: id,
                            member_cnt: cnt,
                            gp_ix: $('input[name=gp_ix]').val()
                        },
                        '',
                        function (response) {
                            if (response.result == 'success') {
                                deleteMember(self);
                            } else {
                                alert('삭제 실패하였습니다.');
                            }
                        }
                    );
                }
            }else {
                if(confirm('정말 삭제하시겠습니까?')) {
                    deleteMember($(this));
                }
            }
        });

        $(document).on('click', '.devAdd', function(e) {
            e.preventDefault();

            if($('.entry-form__list > .entry-form__sheet').length >= 25) {
                alert('25명 까지 등록이 가능합니다.');
                return false;
            }

            common.ajax(
                common.util.getControllerUrl('checkChampionshipMember', 'event'),
                {

                },
                '',
                function (response) {
                    if (response.result == 'success') {
                        addMember();
                    } else {
                        alert('system error');
                    }
                }
            );
        });

        $('.attendCheckbox').on('click', function() {
            attendCheckboxProcess();
        });

        $('#devMemberCnt').on('keyup', function() {
            setTimeout(function(){
                attendCheckboxProcess();
            }, 1000);
        });

        $(document).on('keyup', '.devBirthday', function() {
            var len =  $(this).val().length;
            var parent = $(this).parents('.entry-form__sheet');

            if(len == 6) {
                parent.find('.devAttendGroup').attr('disabled', false);
            }else {
                parent.find('.devAttendGroup').val('');
                parent.find('.devAttendGroup').attr('disabled', true);
                parent.find('.devAttendDesc').hide();
            }
        });

        $(document).on('change', '.devAttendGroup', function() {
            var parent = $(this).parents('.entry-form__sheet');
            var birth = parent.find('.devBirthday').val();
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
                    parent.find('.devAttendDesc').text('1995년 01월 01일 ~ 2006년 12월 31일');
                    if(birth > 20061231 || birth < 19950101) {
                        flag = true;
                    }
                    break;
                case '2' :
                    parent.find('.devAttendDesc').text('1985년 01월 01일 ~ 1994년 12월 31일');
                    if(birth > 19941231 || birth < 19850101) {
                        flag = true;
                    }
                    break;
                case '3' :
                    parent.find('.devAttendDesc').text('1975년 01월 01일 ~ 1984년 12월 31일');
                    if(birth > 19841231 || birth < 19750101) {
                        flag = true;
                    }
                    break;
                case '4' :
                    parent.find('.devAttendDesc').text('1965년 01월 01일 ~ 1974년 12월 31일');
                    if(birth > 19741231 || birth < 19650101) {
                        flag = true;
                    }
                    break;
                case '5' :
                    parent.find('.devAttendDesc').text('1965년 01월 01일 이전 출생자');
                    if(birth >= 19650101) {
                        flag = true;
                    }
                    break;
                case '6' :
                    parent.find('.devAttendDesc').text('1984년 01월 01일 ~ 2006년 12월 31일');
                    if(birth < 19840101 || birth > 20061231) {
                        flag = true;
                    }
                    break;
                case '7' :
                    parent.find('.devAttendDesc').text('1984년 01월 01일 이전 출생자');
                    if(birth >= 19840101) {
                        flag = true;
                    }
                    break;
                default:
                    parent.find('.devAttendDesc').text('');
                    break;
            }

            if(flag) {
                parent.find(".devAttendRedDesc").show();
            }else {
                parent.find(".devAttendRedDesc").hide();
            }

            parent.find('.devAttendDesc').show();
        });

        //선수 추가 기능
        function addMember() {
            const $numberInput = $(".team-number__input");
            const count = parseInt($numberInput.val());

            var html = '';
            var template = $('#entry-form__template').html();
            html += template.replace(/#num#/gi, count);
            $('.entry-form__list').append(html);

            $(".devFile").fileupload({
                dataType: 'json',
                done: function (e, data) {
                    if(data.result.result == 'success') {
                        $(this).siblings('.devFileUrl').val(data.result.data.name);
                        $(this).siblings('.devImageUrlPath').val(data.result.data.newName);
                    }else {
                        alert(data.result.data);
                    }
                }
            });
            
            common.validation.set($('.devRequire'), {'required': true});
            common.inputFormat.set($('.devBirthday'), {'maxLength': 6});
            common.inputFormat.set($('.devPcs2,.devPcs3'), {'number': true, 'maxLength': 4});

            $numberInput.val(count + 1);

            attendCheckboxProcess();
        }

        //선수 삭제 기능
        function deleteMember(self) {
            const $sheet = self.parents(".entry-form__sheet");
            const $numberInput = $(".team-number__input");
            const count = parseInt($numberInput.val()) - 1;

            $sheet.remove();
            $numberInput.val(count);

            if(count == 0) {
                $('.group-list-wrap').removeClass('group-list-wrap--show');
            }

            attendCheckboxProcess();
        }

        //체크한 단체전 및 가격 계산
        function attendCheckboxProcess() {
            var attend = "";
            var aCnt = 0;
            var total = 0;
            var mCnt = $('#devMemberCnt').val() ? $('#devMemberCnt').val() : 0;

            $('.attendCheckbox').each(function() {
                if($(this).prop('checked') == true) {
                    attend += $(this).val() + ',';
                    aCnt++;
                }
            });
            attend = attend.slice(0, -1);
            $('#groupAttend').val(attend);

            if(mCnt == '') mCnt = 0;

            total = ((mCnt * 40000) + (aCnt * 20000));

            $('#devPrice').text(common.util.numberFormat(total)+'원');
        }
    },
    initMemberEvent: function () {
        //-----일반회원 가입

        $('.devFile').fileupload({
            dataType: 'json',
            done: function (e, data) {
                if(data.result.result == 'success') {
                    $(this).siblings('.devFileUrl').val(data.result.data.name);
                    $(this).siblings('.devImageUrlPath').val(data.result.data.newName);
                }else {
                    alert(data.result.data);
                }
            }
        });

        $('#devMasterFile').fileupload({
            dataType: 'json',
            done: function (e, data) {
                if(data.result.result == 'success') {
                    $('#devMasterFileUrl').val(data.result.data.name);
                    $('#devMasterImageUrlPath').val(data.result.data.newName);
                }else {
                    alert(data.result.data);
                }
            }
        });

        //주소 찾기
        $('#devZipPopupButton').click(function (e) {
            e.preventDefault();
            common.util.zipcode.popup();
        });

        $(window).on("beforeunload", function(){
            if(checkUnload) return "이 페이지를 벗어나면 작성된 내용은 저장되지 않습니다.";
        });

        $('#devBasicSubmitButton').click(function (e) {
            e.preventDefault();
            var b = true;
            checkUnload = false;
            $('.devAttendRedDesc').each(function(){
                if($(this).css('display') != "none") {
                    alert('생년월일과 맞는 그룹을 선택해주세요.');
                    $(this).parents('.entry-form__sheet').find('.devAttendGroup').focus();
                    b = false;
                }
            });
            if(b){
                $form.submit();
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