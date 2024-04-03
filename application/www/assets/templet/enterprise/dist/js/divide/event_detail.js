"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
import 'slick-carousel';
const event_detail = () => {
    const $document = $(document);

    const event_stickyMenu = () => {
        $document
            .on("click", '.goodsbox-tab__list', function(){
                const $this = $(this);
                const $first = $('.goodsbox-tab__list:eq(0)');
                $first
                    .addClass("goodsbox-tab__list--active");
                $this
                    .addClass("goodsbox-tab__list--active")
                    .siblings().removeClass("goodsbox-tab__list--active");
                return false;
            })

        window.onscroll = function() {fixedTab()};

        const $tabMenu = document.getElementById("stickytab");
        const $tabMenuClass = $(".goodsbox-tab");
        //const $tabMenu = document.getElementsByClassName("goodsbox-tab");
        //const $tabMenu = $(".sj__event-detail .sj__event-detail__goodsbox .goodsbox-tab");

        const $sticky = $tabMenu.offsetTop;

        function fixedTab() {
            if (window.pageYOffset >= $sticky) {
                $tabMenu.classList.add("goodsbox-tab--sticky");
            } else {
                $tabMenu.classList.remove("goodsbox-tab--sticky");
            }
        }


    }

    const event_review = () => {
        const $write_area = $('.reviews-write__form__comment');
        const $write_btn = $('.reviews-write__form__btn');

        const limit_text = () => {
            $document
                .on("keyup", '.reviews-write__form__comment', function(){
                    const $this = $(this);
                    const $val_count = $(".reviews-write__form__byte span");
                    if ($this.val().length > 300) {
                        $this.val($this.val().substring(0, 300));
                        $val_count.text(300);
                    } else {
                        $val_count.text($this.val().length);
                    }

                    if($this.val().length > 0) {
                        $write_btn.addClass("reviews-write__form__btn--on");
                    } else {
                        $write_btn.removeClass("reviews-write__form__btn--on");
                    }
                })
        }

        const edit_area = () => {
            $document
                .on("click", ".viewbox__list__edit-btn", function(){
                    const $this = $(this);
                    const $edit_area = $this.siblings('.viewbox__list__edit-area');
                    const $ori_comment = $this.siblings(".viewbox__list__cont").text();
                    $this.addClass("viewbox__list__edit-btn--off");
                    $edit_area.addClass("viewbox__list__edit-area--show");
                    $edit_area.find("textarea").html($ori_comment.trim());
                    return false;
                })
                .on("click", ".viewbox__list__edit-area__btns--cancel", function(){
                    const $this = $this;
                    const $edit_area = $('.viewbox__list__edit-area');
                    const $cancel_btn = $('.viewbox__list__edit-btn');
                    $cancel_btn.removeClass("viewbox__list__edit-btn--off");
                    $edit_area.removeClass("viewbox__list__edit-area--show");
                    return false;
                })
                .on("keyup", '.viewbox__list__edit-area__textarea', function(){
                    const $this = $(this);
                    const $write_btn = $('.viewbox__list__edit-area__btns--submit');
                    if ($this.val().length > 300) {
                        $this.val($this.val().substring(0, 300));
                    }
                })
        }

        if (forbizCsrf.isLogin) {
            $write_area.attr('disabled', false);
            $write_btn.attr('disabled', false);
        } else {

        }

        limit_text();
        edit_area();
    }

    const eventDetail_init = () => {
        event_review();
        //event_stickyMenu();
    }

    eventDetail_init();
}

export default event_detail;

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
/*
var devEventDetailObj = {
    ajaxEventDetailList: common.ajaxList(),
    initLang: function () {
        //-----load language
        common.lang.load('eventDetail.common.validation.comment.empty', "댓글을 입력해주세요.");
        common.lang.load('eventDetail.common.validation.comment.fail', "이미 참여하신 이벤트입니다.");
        common.lang.load('eventDetail.common.validation.comment.loginFail', "댓글을 등록하려면 로그인을 해야합니다.");
    },
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.ajaxEventDetailList.getPage(pageNum);
        });

        $('#devBtn').on('click', function () { //댓글 버튼 클릭시
            var event_ix = $("input[name$='event_ix']").val();
            var comment = $("#devInputComment").val();

            if (comment == "") { //댓글 입력 체크
                common.noti.alert(common.lang.get('eventDetail.common.validation.comment.empty'));
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
                        common.noti.alert(common.lang.get('eventDetail.common.validation.comment.loginFail'));
                        var ix = $('input[name=event_ix]').val();
                        document.location.href = '/member/login?url=' + encodeURI('/event/eventDetail/'+ix);
                        return false;
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
    initAjaxEventDetailList: function () {
        var self = this;

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
            .setController('eventCommentList', 'event')
            .init(function (response) {
                $('#devCommentCount').text(response.data.total);
                self.ajaxEventDetailList.setContent(response.data.list, response.data.paging);
            });
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initEvent();
        self.initAjaxEventDetailList();

        if ($('#use_comment').val() == '2') {
            $('.event_comment').hide();
            $('#devPageWrap').hide();
        }
    }
};
$(function () {
    devEventDetailObj.run()
});
    */
