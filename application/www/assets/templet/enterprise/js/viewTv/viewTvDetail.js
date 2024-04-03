"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('viewTv.add.confirm.input', "댓글을 등록 하시겠습니까?");
common.lang.load('viewTv.check.confirm.user', "로그인한 상태에서만 선택 가능합니다. 로그인하시겠습니까?");
common.lang.load('product.videoWish.noMember.confirm', "관심영상 등록은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.videoWish.noMember.complete.insert', "해당 영상이 관심 영상 목록에 추가되었습니다.{common.lineBreak}마이페이지 > 관심 뷰티비 에서 확인 가능합니다.");
common.lang.load('viewTv.noMember.reView.confirm', "댓글 작성은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");

var devInputComment = {
    viewTvInputComment: $('#viewTvInputComment'),
    formInit: function () {
        var self = this;

        common.form.init(
            this.viewTvInputComment,
            common.util.getControllerUrl('viewTvInputComment', 'Viewtv'),
            function (formObj) {
                if (common.validation.check(formObj, 'alert', false)) {
                    self.viewTvInputComment.submit();
                    return true;
                } else {
                    return false;
                }
            },
            function (res) {
                if(res.result=='loginFail') {
                    alert('댓글은 로그인한 사용자만 가능합니다.');
                }else if(res.result=='fail'){
                    alert('실패 되었습니다.')
                }else{
                    alert('등록 되었습니다.')
                    location.reload();
                }
            }
        );
    },
    run: function () {
        var self = this;
        //-----set validation
        common.validation.set($('#devComment'), {'required': true});

        //Form init
        self.formInit();
    }
};


var devCommentList = {
    videoCommentList: common.ajaxList(),
    initAjaxList: function () {
        var self = this;

        self.videoCommentList.setContainerType('div')
            .setContainer('#devCommentContent')
            .setEmptyTpl('#devCommentEmpty')
            .setLoadingTpl('#devCommentLoading')
            .setListTpl('#devCommentList')
            .setForm('#devCommentForm')
            .setController('getComment', 'viewtv')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .init(function (response) {
                self.videoCommentList.setContent(response.data.list, response.data.paging);
            });

        var commentModifyBool = false;
        $('#devCommentContent').on('click','.devCommentModifyBtn',function(e){
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
                    self.videoCommentList.reload();
                });
            }
        });
    },
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.videoCommentList.getPage(pageNum);
        });
    },
    run: function () {
        this.initAjaxList();
        this.initEvent();
    }
}

var devLikeControl = {
    target: '',
    setTarget: function ($target) {
        this.target = $target;
        return this;
    },
    run: function (_video_idx) {
        var self = this;
        var video_idx = _video_idx ? _video_idx : $(self.target).attr('data-devLikeControlBtn');
        var like_type = $(self.target).attr('data-devLikeType');
        var btnOnOffClass;

        if(like_type == 'U'){
            btnOnOffClass = "video-info__infobox__mybtns__like--on";
        }else if(like_type == 'D'){
            btnOnOffClass = "video-info__infobox__mybtns__unlike--on";
        }

        common.ajax(common.util.getControllerUrl('videoLikeControl', 'video'), {'video_idx': video_idx,'like_type':like_type}, "", function (result) {

            if (result.result == 'insert') {
                $(self.target).addClass(btnOnOffClass);
            } else if (result.result == 'delete') {
                $(self.target).removeClass(btnOnOffClass);
            }else if(result.result == 'loginFail'){
                common.noti.confirm(common.lang.get('viewTv.check.confirm.user'), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/viewTv/viewTvDetail/'+video_idx);
                });

                return false;
            } else {
                common.noti.alert('error');
            }
            $(self.target).html(result.data);
            return;
        });
    }
};

var wish_video = {
    target: '',
    setTarget: function ($target) {
        this.target = $target;
        return this;
    },
    run: function (_video_idx) {
        var self = this;
        var video_idx = _video_idx ? _video_idx : $(self.target).attr('data-devWishVideoBtn');
        common.ajax(common.util.getControllerUrl('inputWishVideo', 'video'), {'video_idx': video_idx}, "", function (result) {
            if (result.result == 'insert') {
                $(self.target).addClass('video-info__infobox__mybtns__interesting--on');
                common.noti.alert(common.lang.get('product.videoWish.noMember.complete.insert'));
            } else if (result.result == 'delete') {
                $(self.target).removeClass('video-info__infobox__mybtns__interesting--on');
            } else if(result.result == 'loginFail'){
                common.noti.confirm(common.lang.get('product.videoWish.noMember.confirm'), function () {

                    document.location.href = '/member/login?url=' + encodeURI('/viewTv/viewTvDetail/'+video_idx);
                });

                return false;
            }else {
                common.noti.alert('error');
            }
            return;
        });
    }
}
var iframeAPI = {
    run:function(){
        var Main_iframe = document.getElementById('devVideo');
        var contents = Main_iframe.contentWindow || Main_iframe.contentDocument;
        iframeAPI = new smIframeAPI(contents);
        iframeAPI.onEvent (smIframeEvent.READY, function(){
            //크롬 정책으로 음소거되지 않은 영상에 대한 자동재생 불가로 음소거 처리 후 자동 재생 추가
            iframeAPI.setMuted(true);
            iframeAPI.play();
        });

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


var devVideoViewCount = {
    videoViewCountAjax: false,
    initViewCount: function(){
        var self = this;
        $('.devViewCount').each(function(){
            var video_category = $(this).data('video_category');
            if(video_category == 'Y'){
                var youtubeId = $(this).data('token');
                common.ajax(
                    common.util.getControllerUrl('getYoutubeInfoByViewCount', 'video'),
                    {
                        youtube_id: youtubeId
                    },
                    '',
                    function (data) {
                        $('.devTokenId_'+youtubeId+' em').html(data.data);
                    }
                );
            }
        });
    },
    run: function () {
        var self = this;
        self.initViewCount();
    }
}

$(function () {

    /**
     * 댓글 등록 진행
     */
    devInputComment.run();

    /**
     * 댓글 리스트 추출
     */
    devCommentList.run();

    /**
     * 영상재생
     */
    iframeAPI.run();

    /**
     * 조회수 획득
     */
    devVideoViewCount.run();

    $('.devLoginCheck').on('click',function(){
        common.noti.confirm(common.lang.get('viewTv.noMember.reView.confirm'), function () {
            document.location.href = '/member/login?url=' + encodeURI(window.location.href);
        });
    });
});