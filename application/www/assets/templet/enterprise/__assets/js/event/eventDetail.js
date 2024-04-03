"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('eventDetail.common.validation.comment.fail', "이미 참여하신 이벤트입니다.");
common.lang.load('eventDetail.common.validation.comment.loginFail', "댓글을 등록하려면 로그인을 해야합니다.");

var devEventDetailObj = {
    detailCommentForm: false,
    ajaxEventDetailList: common.ajaxList(),
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.ajaxEventDetailList.getPage(pageNum);
        });

        $('#devBtn').on('click', function (e) { //댓글 버튼 클릭시
            e.preventDefault();
            self.detailCommentForm.submit();
        });
    },
    initComment: function () {
        var self = this;

        if ($('#devEventDetailContent').length > 0) {
            // 이벤트 설정
            self.ajaxEventDetailList
                .setUseHash(false)
                .setLoadingTpl('#devEventDetailLoading')
                .setListTpl('#devEventDetailList')
                .setEmptyTpl('#devEventDetailListEmpty')
                .setContainerType('div')
                .setContainer('#devEventDetailContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devEventDetailForm')
                .setController('getCommentList', 'event')
                .init(function (response) {
                    $('#devCommentCount').text(response.data.total);
                    self.ajaxEventDetailList.setContent(response.data.list, response.data.paging);
                });
        }

        if ($('#devEventCommentForm').length > 0) {
            self.detailCommentForm = $('#devEventCommentForm');

            common.form.init(self.detailCommentForm, common.util.getControllerUrl('addCommentByUser', 'event'), function ($form) {
                if(!forbizCsrf.isLogin){
                    common.noti.alert(common.lang.get('eventDetail.common.validation.comment.loginFail'));
                    return false;
                }
                return common.validation.check($form, 'alert');
            }, function (response) {
                if (response.result == 'loginFail') { //댓글작성시 로그인체크
                    common.noti.alert(common.lang.get('eventDetail.common.validation.comment.loginFail'));
                    return false;
                }
                if (response.result == 'preAdd') { //이미 작성한 아이디
                    common.noti.alert(common.lang.get('eventDetail.common.validation.comment.fail'));
                } else {
                    self.ajaxEventDetailList.reload();
                }
                $("#devInputComment").val("");
            });

            common.validation.set($('#devInputComment'), {'required': true});
        }
    },
    run: function () {
        var self = this;

        self.initEvent();
        self.initComment();
    }
};
$(function () {
    devEventDetailObj.run()
});