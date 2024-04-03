"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('write.customer.file.find', "파일찾기");
common.lang.load('write.customer.file.change', "파일변경");
common.lang.load('write.customer.file.confirm.delete', "파일을 삭제하시겠습니까?");
common.lang.load('write.customer.file.type.check', "파일 형식이 올바르지 않습니다. \n다시 첨부해주세요.");
common.lang.load('write.customer.file.size.check', "파일 용량이 최대 30MB를 초과했습니다. \n다시 첨부해주세요.");
common.lang.load('read.user.check.alert', "비밀글은 작성자만 조회할 수 있습니다.");
common.lang.load('write.customer.fail', "다시 입력해 주세요.");
common.lang.load('write.customer.register', "등록하시겠습니까?");
common.lang.load('write.customer.success', "등록되었습니다.");
common.lang.load('bbs.teacher.write.confirm', "신청은 로그인 후 가능 합니다. 로그인 하시겠습니까?.");
common.lang.load('bbs.teacher.deleteComplete.alert', "삭제되었습니다.");
common.lang.load('bbs.teacher.deleteFail.alert', "삭제중 오류가 발생했습니다.");
common.lang.load('bbs.teacher.delete.alert', "삭제 하시겠습니까?");
common.lang.load('bbs.teacher.cancel.confirm', "티처 멤버 작성을 취소하시겠습니까?");


var $form = $('#devBbsForm');
var url = common.util.getControllerUrl('registerTeacherMember', 'customer');
var beforeCallback = function ($form) {
    if (common.validation.check($form)) {
        if (common.noti.confirm(common.lang.get('write.customer.register'))) {
            return true;
        }
    }
    return false;
};
var successCallback = function (response) {
    if (response.result == "success") {
        common.noti.alert(common.lang.get("write.customer.success"));
        location.href = response.data.url;
    } else {
        common.noti.alert(common.lang.get("write.customer.fail"));
    }
};
common.form.init($form, url, beforeCallback, successCallback);

$(function () {

    var isAjaxList = $("#isAjaxList").val();

    if (isAjaxList == 'undefined' || isAjaxList != 'N') {

        var self = this;
        self.bbsList = common.ajaxList();
        self.bbsList
            .setLoadingTpl('#devBbsLoading')
            .setListTpl('#devBbsList')
            .setEmptyTpl('#devBbsListEmpty')
            .setContainerType('table')
            .setContainer('#devBbsContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devBbsForm')
            .setController('getBbsTeacher', 'customer')
            .init(function (data) {

                if (!(data.data.list).isNull && !(data.data.paging).isNull) {
                    var c = data.data.paging.cur_page;
                    var p = data.data.paging.per_page;
                    var t = data.data.total;
                    var no = t - (p * (c - 1));
                    for (var i = 0; i < (data.data.list).length; i++) {
                        data.data.list[i].idx = no;
                        no--;
                    }
                }

                self.bbsList.setContent(data.data.list, data.data.paging);

            });
    }

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        if($(this).data('issameuser') == true){
            location.href = "/brand/teacherMember/read/" + $(this).attr('devBbsIx');
        }else{
            common.noti.alert(common.lang.get('read.user.check.alert'));
        }

    });

    $('#devBbsWrite').on('click',function(){
        if (forbizCsrf.isLogin) {
            location.href="/brand/teacherMember/write";
        }else{
            common.noti.confirm(common.lang.get('bbs.teacher.write.confirm'), function () {
                document.location.href = '/member/login?url=' + encodeURI('/brand/teacherMember/write');
            });
        }
    });

    $('#devDeleteInquiry').on('click', function(){
        var bType = $('#devBType' ).val();
        var bbsIx = $('#devBbsIx' ).val();
        common.ajax(
            common.util.getControllerUrl('deleteArticle', 'customer'),
            {
                bType: bType , bbsIx:bbsIx
            },
            function () {
                if (confirm(common.lang.get('bbs.teacher.delete.alert'))) {
                    return true;
                } else {
                    return false;
                }
            },
            function (data) {
                if (data.result == 'success') {
                    common.noti.alert(common.lang.get('bbs.teacher.deleteComplete.alert'));
                    location.href = '/brand/teacherMember';
                }else{
                    common.noti.alert(common.lang.get('bbs.teacher.deleteFail.alert'));
                }
            }

        );
    });


    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        self.bbsList.getPage(pageNum);
    });

    $('#devBbsRegCancel').on('click',function(){
        common.noti.confirm(common.lang.get('bbs.teacher.cancel.confirm'), function() {
            document.location.href = '/brand/teacherMember';
        });
        //history.back();
    })


    $("button[id^='devBbsFileButton']").click(function (e) {
        e.preventDefault();
        var selectBtn = (this.id).split("Button");
        var inputFile = $("#" + selectBtn['0'] + selectBtn['1']);
        inputFile.trigger('click');
    });

    /*$("input[id^='devBbsFile']").change(function (e) {
        var sNo = (this.id).split("devBbsFile");
        var fname = $("#devBbsFile" + sNo['1']).val();
        if (fname != "" && fname != "undefined" && sNo['1'] > 0) {
            $('#devBbsFileText' + sNo['1']).val(fname);
            $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.change'));
            $('#devBbsFileDeleteButton' + sNo['1']).show();
        } else {
            $('#devBbsFileText' + sNo['1']).val('');
            $('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.find'));
            $('#devBbsFileDeleteButton' + sNo['1']).hide();
        }
    });*/

	$("input[id^='devBbsFile']").change(function (e) {
		e.preventDefault();
		var allowExt = ['jpg','jpeg','png','gif'];
		var ckExt = false;
		var ckSize = 1024 * 1024 * 3; //30MB

		var filesize = $(this)[0].files[0].size;
		var ext = (this.value).split(".");
		var rs = jQuery.inArray(ext['1'].toLowerCase(),allowExt);
		if(this.value != '' && rs == -1){
			common.noti.alert(common.lang.get('write.customer.file.type.check'));
			ckExt = false;
			var sNo = (this.id).split("devBbsFile");
			deleteConfirmOk(sNo['1']);
			return false;
		}else if(this.value != '' && filesize > ckSize){
			common.noti.alert(common.lang.get('write.customer.file.size.check'));
			ckExt = false;
			var sNo = (this.id).split("devBbsFile");
			deleteConfirmOk(sNo['1']);
			return false;
		}else{
			var sNo = (this.id).split("devBbsFile");
			var fname = $("#devBbsFile" + sNo['1']).val();
			if (fname != "" && fname != "undefined" && sNo['1'] > 0) {
				$('#devBbsFileText' + sNo['1']).val(fname);
				$('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.change'));
				$('#devBbsFileDeleteButton' + sNo['1']).show();
			} else {
				$('#devBbsFileText' + sNo['1']).val('');
				$('#devBbsFileButton' + sNo['1']).text(common.lang.get('write.customer.file.find'));
				$('#devBbsFileDeleteButton' + sNo['1']).hide();
			}
		}
	});	


    $("button[id^='devBbsFileDeleteButton']").click(function (e) {
        e.preventDefault();
        var sNo = (this.id).split("devBbsFileDeleteButton");
        if (common.noti.confirm(common.lang.get('write.customer.file.confirm.delete'))) {
            deleteConfirmOk(sNo['1']);
        }else{
            return false;
        }
    });

    var deleteConfirmOk = function (no) {

        $("#devBbsFile" + no).val('');
        var fname = $("#devBbsFile" + no).val();
        if (fname != "" && fname != "undefined" && no > 0) {
            $('#devBbsFileText' + no).val(fname);
            $('#devBbsFileButton' + no).text(common.lang.get('write.customer.file.change'));
            $('#devBbsFileDeleteButton' + no).show();
        } else {
            $('#devBbsFileText' + no).val('')
            $('#devBbsFileButton' + no).text(common.lang.get('write.customer.file.find'));
            $('#devBbsFileDeleteButton' + no).hide();
        }
    };

    var chkClick = false;
    $('#devBbsRegSubmit').click(function (e) {

        var bbsDivCheck = false;
        $('.devBbsDiv').each(function(){
            if($(this).is(':checked')){
                bbsDivCheck = true;
            }
        });
        if(bbsDivCheck == false){
            alert('분류를 선택해주세요');
            return false;
        }

        if($('#devBbsSubject').val() == ''){
            $('#devBbsSubject').focus();
            alert('제목을 입력해주세요');
            return false;
        }
        if($.trim($('#devBbsContents').val()) == ''){
            $('#devBbsContents').focus();
            alert('내용을 입력해주세요');
            return false;
        }

        if(!chkClick) {
            chkClick = true;
            $form.submit();
        }
    });


});

function removeTag(value){
    var removeValue = value.replace(/(<([^>]+)>)/gi,"");
    var removeValue = removeValue.replace(/alert/gi,"");
    var removeValue = removeValue.replace(/onclick=/gi,"");

    $('#devBbsContents').val(removeValue);
}