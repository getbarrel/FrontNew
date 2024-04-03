"use strict";

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var $form = $('#devBasicForm');
var $gform = $('#devGroupForm');

var url = common.util.getControllerUrl('checkChampionship', 'event');
var gurl = common.util.getControllerUrl('checkChampionshipGroup', 'event');

var beforeCallback = function ($form) {
    if(common.validation.check($form, 'alert', false)){
        return true;
    }
    return false;
};

var successCallback = function (response) {
    if (response.result == "success") {
        if(typeof response.data.cm_ix != "undefined") {
            location.href = '/brand/'+response.data.redirect+'/'+response.data.cm_ix;
        }else {
            location.href = '/brand/'+response.data.redirect+'/'+response.data.gp_ix;
        }
    } else if (response.result == "fail") {
        sprintAlert({
            title : "해당 내용과 일치하는 신청서가 없습니다.",
            desc : "작성한 신청서 내용을 다시 확인하시어 <br/>다시 입력해 주시기 바랍니다.",
            callback : function(){

            }
        });
    } else {
        common.noti.alert("system error");
    }
};

// object
var devJoinInputObj = {
    initFormat: function () {
        common.inputFormat.set($('#devBirthday'), {'number': true, 'maxLength': 6});
        common.inputFormat.set($('#devPassword, #devMasterPassword'), {'number': true, 'maxLength': 4});
    },
    initValidation: function () {
        common.validation.set($('#devName,#devBirthday,#devPassword'), {'required': true});
        common.validation.set($('#devGroupName,#devMasterName, #devMasterPassword'), {'required': true});
    },
    initCommonEvent: function () {

        $('#goIndivisual').on('click', function() {
            common.ajax(
                common.util.getControllerUrl('checkChampionshipDay', 'event'),
                {

                },
                '',
                function (response) {
                    if (response.result == 'success') {
                        location.href='/brand/applicationFormIndivisual';
                    } else {
                        sprintAlert({
                            title : "배럴 스프린트 챔피언십 <br> 온라인 신청이 마감되었습니다.",
                            desc : "배럴 스프린트 챔피언십에 모시지 못 하게 되어 대단히 송구스럽습니다.<br>하지만 대회당일 관중석 참관은 무료이오니, 시간이 되시면<br>방문하셔서 대회 현장을 즐겨보세요!",
                            callback : function(){

                            }
                        });
                    }
                }
            );
        });

        $('#goGroup').on('click', function() {
            common.ajax(
                common.util.getControllerUrl('checkChampionshipDay', 'event'),
                {

                },
                '',
                function (response) {
                    if (response.result == 'success') {
                        location.href='/brand/applicationFormGroup';
                    } else {
                        sprintAlert({
                            title : "배럴 스프린트 챔피언십 <br> 온라인 신청이 마감되었습니다.",
                            desc : "배럴 스프린트 챔피언십에 모시지 못 하게 되어 대단히 송구스럽습니다.<br>하지만 대회당일 관중석 참관은 무료이오니, 시간이 되시면<br>방문하셔서 대회 현장을 즐겨보세요!",
                            callback : function(){

                            }
                        });
                    }
                }
            );
        });

        $('#devIndivisual').click(function (e) {
            e.preventDefault();
            $form.submit();
        });

        $('#devGroup').click(function (e) {
            e.preventDefault();
            $gform.submit();
        });

        common.form.init($form, url, beforeCallback, successCallback);
        common.form.init($gform, gurl, beforeCallback, successCallback);
    },
    run: function () {
        var self = this;

        self.initFormat();
        self.initValidation();
        self.initCommonEvent();
    }
};

$(function() {
    devJoinInputObj.run();
});
