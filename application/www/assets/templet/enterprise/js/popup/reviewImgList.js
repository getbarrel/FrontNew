"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

common.lang.load('product.noMember.reView.confirm', "댓글 작성은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");

var reviewDetail = {
    goodsReviewAjax: false,
    init: function (){
        var self = this;
        self.goodsReviewAjax = common.ajaxList();
        self.goodsReviewAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getReviewDetail', 'review')
            .init(function (response) {

                $.each(response.data, function (key,obj){
                    obj.nick_name = '{[nick_name]}';
                    obj.comment = '{[{comment}]}';
                    obj.date = '{[date]}';
                    obj.idx = '{[idx]}';
                    obj.modifyBool = '{[modifyBool]}';
                    response.data[key] = obj;
                });

                self.goodsReviewAjax.setContent(response.data);
                popupCenter();
                // lazyload();//퍼블 레이지로드 삽입

                self.initVideoCommentList();

                $('.devCommentButton').on('click',function(){
                    if($(".review-detail__user-comment").css('display') == 'none'){
                        self.ajaxVideoReviewComment.reload();
                        $('#devVideoCommentPageWrap').show();
                    }else{
                        $('#devVideoCommentPageWrap').hide();
                    }
                });

                $('.devLoginCheck').on('click',function(){
                    common.noti.confirm(common.lang.get('product.noMember.reView.confirm'), function () {
                        document.location.href = '/member/login?url=' + encodeURI(window.location.href);
                    });
                });

                var commentSubmitBool = false;
                $('.devAddCommentButton').click(function (e) {
                    e.preventDefault();
                    if(commentSubmitBool){
                        alert('등록중 입니다.');
                    } else {
                        commentSubmitBool = true;

                        var $area = $(this).closest('form');

                        var comment = $area.find('.devComment').val();
                        var video_idx = $(this).data('video_idx');
                        common.ajax(common.util.getControllerUrl('viewTvInputComment', 'Viewtv'), {
                            video_idx: video_idx,
                            comment: comment
                        },  function () {
                            if (comment.length == 0) {
                                common.noti.alert('댓글을 입력 해 주세요');
                                commentSubmitBool = false;
                                return false;

                            }
                            return true;
                        }, function (res) {
                            //성공일때 처리
                            commentSubmitBool = false;
                            self.ajaxVideoReviewComment.reload();
                            $('.devCommentButton em').html(res.data);
                            $('.devComment').val('');
                            $('.devAddCommentButton').removeClass("input-comment__save").addClass("input-comment__save--disabled");
                            $('.devCommentLimit em').html(0);
                        });
                    }
                });

            });





    },
    initVideoCommentList: function(){
        var self = this;
        self.ajaxVideoReviewComment = common.ajaxList();
        self.ajaxVideoReviewComment
            .setContainerType('div')
            .setLoadingTpl('#devVideoCommentLoading')
            .setListTpl('#devVideoCommentList')
            .setEmptyTpl('#devVideoCommentEmpty')
            .setContainer('#devVideoCommentContent')
            .setPagination('#devVideoCommentPageWrap')
            .setPageNum('#devVideoCommentPage')
            .setForm('#devVideoCommentForm')
            .setController('getVideoCommentData', 'video')
            .setUseHash(false)
            .init(function (data) {
                self.ajaxVideoReviewComment.setContent(data.data.list, data.data.paging);
                $('.devVideoCommentModifyBtn[devModify=false]').remove();
            });

        $('#devVideoCommentPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxVideoReviewComment.getPage($(this).data('page'));
        });

        var commentModifyBool = false;
        $('#devVideoCommentContent').on('click','.devCommentModifyBtn',function(e){

            e.preventDefault();
            if(commentModifyBool){
                alert('등록중 입니다.');
            } else {
                commentModifyBool = true;

                var $area = $(this).closest('form');

                var comment = $area.find('.devCommentModify').val();
                var comment_idx = $(this).data('comment-idx');
                var video_idx = $(this).data('video_idx');

                common.ajax(common.util.getControllerUrl('viewTvInputModifyComment', 'Viewtv'), {
                    comment_idx: comment_idx,
                    video_idx: video_idx,
                    comment: comment
                }, '', function () {
                    //성공일때 처리
                    commentModifyBool = false;
                    self.ajaxVideoReviewComment.reload();
                });
            }
        });
    },
    initEvent: function (){
        var self = this;

        $('.devReviewImg').on('click',function(){
            $('#devBbsIx').val($(this).attr('data-bbsIx'));

            $('#devReviewDetail').css('display','block');
            $('#devMediaList').css('display','none');

            if(self.goodsReviewAjax === false){
                self.init();
            }else{
                self.goodsReviewAjax.reload();
            }

        });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.videoCommentList.getPage(pageNum);
        });

        $(document).on('click','#devAllView',function(){
            $('#devReviewDetail').css('display','none');
            $('#devMediaList').css('display','block');
        });
    },
    run: function(){
        var self = this;

        self.initEvent();
        if($('#devBbsIx').val() != '') {
            self.init();
        }
        popupCenter();
    }
}

var iframeAPI = {
    run:function(){
        var Main_iframe = document.getElementById('devVideo');
        var contents = Main_iframe.contentWindow || Main_iframe.contentDocument;
        iframeAPI = new smIframeAPI(contents);
        iframeAPI.onEvent(smIframeEvent.PLAY , function(){
            // 영상 재생 시 실행
            console.log('play1');
        });

        iframeAPI.onEvent(smIframeEvent.PAUSE , function(){
            // 영상 일지정지 이벤트
            console.log('pause1');
        });
        iframeAPI.onEvent (smIframeEvent.COMPLETE, function(){
            // 영상 재생완료 이벤트
            console.log('complete1');
        });

    }
}
$(function(){
    reviewDetail.run();
    iframeAPI.run();
});