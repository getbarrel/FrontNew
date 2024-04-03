"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('eventDetail.common.validation.comment.fail', "이미 참여하신 이벤트입니다.");
common.lang.load('eventDetail.common.validation.comment.loginFail', "댓글을 등록하려면 로그인을 해야합니다.");
common.lang.load('eventDetail.common.validation.comment.empty', "댓글내용을 입력해주세요.");
common.lang.load('eventDetail.common.validation.comment.over', "댓글내용을 300자 이하로 입력해주세요.");
common.lang.load('event.delete.comment.confirm', "댓글을 삭제 하시겠습니까?.");

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
            var event_ix = $("input[name$='event_ix']").val();
            var comment = $("#devInputComment").val();

            if (forbizCsrf.isLogin) {
                if (comment == "") { //댓글 입력 체크
                    common.noti.alert(common.lang.get('eventDetail.common.validation.comment.empty'));
                    return false;
                }
            }

            if(comment.length > 300){
                common.noti.alert(common.lang.get('eventDetail.common.validation.comment.over'));
                return false;
            }

            common.ajax(
                common.util.getControllerUrl('eventCommentInsert', 'event'),
                {
                    'event_ix': event_ix,
                    'comment': comment
                },
                '',
                function (response) {
                    if (response.result == 'loginFail') { //댓글작성시 로그인체크
                        var ix = $('input[name=event_ix]').val();

                        common.noti.confirm(common.lang.get('eventDetail.common.validation.comment.loginFail', ''), function () {
                            document.location.href = '/member/login?url=' + encodeURI('/event/eventDetail/' + ix);
                            return false;
                        });
                    }

                    if (response.data == 'fail') { //이미 작성한 아이디
                        common.noti.alert(common.lang.get('eventDetail.common.validation.comment.fail'));
                        $("#devInputComment").val("");
                    } else {
                        self.ajaxEventDetailList.reload();
                        $("#devInputComment").val("");
                    }
                }
            );
        });

        $(document).on('click','.devCommentModifyBtn', function (e) { //댓글 수정 등록버튼 클릭시
            e.preventDefault();
            var comment = $(this).parents("form").find("textarea[name='comment']").val();
            var event_ix = $("input[name$='event_ix']").val();
            var ec_ix = $(this).data('ec_ix');

            if (forbizCsrf.isLogin) {
                if (comment == "") { //댓글 입력 체크
                    common.noti.alert(common.lang.get('eventDetail.common.validation.comment.empty'));
                    return false;
                }
            }

            if(comment.length > 300){
                common.noti.alert(common.lang.get('eventDetail.common.validation.comment.over'));
                return false;
            }

            common.ajax(
                common.util.getControllerUrl('commentModify', 'event'),
                {
                    'event_ix': event_ix,
                    'ec_ix': ec_ix,
                    'comment': comment
                },
                '',
                function (response) {
                    if (response.result == 'loginFail') { //댓글작성시 로그인체크
                        var ix = $('input[name=event_ix]').val();

                        common.noti.confirm(common.lang.get('eventDetail.common.validation.comment.loginFail', ''), function () {
                            document.location.href = '/member/login?url=' + encodeURI('/event/eventDetail/' + ix);
                            return false;
                        });
                    }

                    if (response.data == 'fail') { //이미 작성한 아이디
                        common.noti.alert(common.lang.get('eventDetail.common.validation.comment.fail'));
                        $("#devInputComment").val("");
                    } else {
                        self.ajaxEventDetailList.reload();
                        $("#devInputComment").val("");
                    }
                }
            );
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
                .setContainerType('dl')
                .setContainer('#devEventDetailContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devEventDetailForm')
                .setController('eventCommentList', 'event')
                .init(function (response) {
                    $('#devCommentCount').text(response.data.total);
                    self.ajaxEventDetailList.setContent(response.data.list, response.data.paging);
                });
        }

        /*if ($('#devEventCommentForm').length > 0) {
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
         }*/
        $('#devEventDetailContent').on('click','.devModifyComment',function(){
            $(this).parents('div').siblings('.devCommentModifyArea').show();
        });

        $('#devEventDetailContent').on('click','.devCommentModifyCancel',function(){
            $(this).parents('.devCommentModifyArea').hide();
            return false;
        });



        $('#devEventDetailContent').on('click', '.devCommentDeleteBtn', function () { //댓글 삭제 버튼 클릭시
            var ix = $(this).attr('devIx');

            common.noti.confirm(common.lang.get('event.delete.comment.confirm', ''), function () {
                common.ajax(
                    common.util.getControllerUrl('commentDelete', 'event'),
                    {
                        'ec_ix': ix
                    },
                    '',
                    function () {
                        self.ajaxEventDetailList.reload();
                        $("#devInputComment").val("");
                    }
                );
            });
        });
    },
    run: function () {
        var self = this;

        self.initEvent();
        self.initComment();
    }
};
$(function () {
    if(!(typeof imageMapResize == "undefined" || typeof imageMapResize == "null")) $('map').imageMapResize();
    devEventDetailObj.run()
});
//-----load language
// common.lang.load('eventDetail.common.validation.comment.fail', "이미 참여하신 이벤트입니다.");
// common.lang.load('eventDetail.common.validation.comment.loginFail', "댓글을 등록하려면 로그인을 해야합니다.");
//
// var devEventDetailObj = {
//     detailCommentForm: false,
//     ajaxEventDetailList: common.ajaxList(),
//     initEvent: function () {
//         var self = this;
//
//         $('#devPageWrap').on('click', '.devPageBtnCls', function () {
//             var pageNum = $(this).data('page');
//             self.ajaxEventDetailList.getPage(pageNum);
//         });
//
//         $('#devBtn').on('click', function (e) { //댓글 버튼 클릭시
//             e.preventDefault();
//             self.detailCommentForm.submit();
//         });
//
//         //상품 그룹명 변경시
//         $('#devGroupSel').on('change', function () {
//             var epg_ix = $('#devGroupSel option:selected').val();
//
//             if(epg_ix == ''){
//                 $('.devSubText').show();
//                 $('.devProductTab').show();
//             }else {
//                 $('.devSubText').hide();
//                 $('.devProductTab').hide();
//                 $('#subText' + epg_ix).show();
//                 $('#productTab' + epg_ix).show();
//             }
//         });
//     },
//     initComment: function () {
//         var self = this;
//
//         if ($('#devEventDetailContent').length > 0) {
//             // 이벤트 설정
//             self.ajaxEventDetailList
//                 .setUseHash(false)
//                 .setLoadingTpl('#devEventDetailLoading')
//                 .setListTpl('#devEventDetailList')
//                 .setEmptyTpl('#devEventDetailListEmpty')
//                 .setContainerType('div')
//                 .setContainer('#devEventDetailContent')
//                 .setPagination('#devPageWrap')
//                 .setPageNum('#devPage')
//                 .setForm('#devEventDetailForm')
//                 .setController('getCommentList', 'event')
//                 .init(function (response) {
//                     $('#devCommentCount').text(response.data.total);
//                     self.ajaxEventDetailList.setContent(response.data.list, response.data.paging);
//                 });
//         }
//
//         if ($('#devEventCommentForm').length > 0) {
//             self.detailCommentForm = $('#devEventCommentForm');
//
//             common.form.init(self.detailCommentForm, common.util.getControllerUrl('addCommentByUser', 'event'), function ($form) {
//                 if(!forbizCsrf.isLogin){
//                     common.noti.alert(common.lang.get('eventDetail.common.validation.comment.loginFail'));
//                     return false;
//                 }
//                 return common.validation.check($form, 'alert');
//             }, function (response) {
//                 if (response.result == 'loginFail') { //댓글작성시 로그인체크
//                     common.noti.alert(common.lang.get('eventDetail.common.validation.comment.loginFail'));
//                     return false;
//                 }
//                 if (response.result == 'preAdd') { //이미 작성한 아이디
//                     common.noti.alert(common.lang.get('eventDetail.common.validation.comment.fail'));
//                 } else {
//                     self.ajaxEventDetailList.reload();
//                 }
//                 $("#devInputComment").val("");
//             });
//
//             common.validation.set($('#devInputComment'), {'required': true});
//         }
//     },
//     run: function () {
//         var self = this;
//
//         self.initEvent();
//         self.initComment();
//     }
// };
// $(function () {
//     console.log(!(typeof imageMapResize == "undefined" || typeof imageMapResize == "null"))
//     if(!(typeof imageMapResize == "undefined" || typeof imageMapResize == "null")) $('map').imageMapResize();
//     devEventDetailObj.run()
// });