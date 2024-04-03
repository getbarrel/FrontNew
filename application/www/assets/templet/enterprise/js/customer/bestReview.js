/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('product.noMember.coupon.confirm', "쿠폰은 로그인 시에만 다운로드 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.bbsQnaHidden.alert', "비공개 문의입니다.");
common.lang.load('product.pcodeCoyp.alert', "상품번호가 복사되었습니다.");
common.lang.load('product.qnaTitle.popup', "상품문의 작성");
common.lang.load('product.noMember.productQna.confirm', "상품문의 작성은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.noMember.reView.confirm', "댓글 작성은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.noMember.productReview.confirm', "로그인한 상태에서만 선택 가능합니다. {common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.add.confirm.input', "댓글을 등록 하시겠습니까?");

var bestReview = {
    ajaxReviewList: false, //리뷰 ajax
    reviewImgsContents: '', //후기 이미지

    initEvent: function () {
        var self = this;

        $('.devReviewsDiv').on('click', function () { //상품후기 분류 탭(프리미엄/일반/동영상후기)
            var bbsDiv = $(this).data('bbsdiv');
            $('input[name=bbsDiv]').val(bbsDiv);
            self.ajaxReviewList.reload();
        });

        $('.devSort').on('change', function () { //상품후기 정렬
            var orderby = $(this).val();
            var sort = $(this).find(':selected').data('sort')

            $('input[name=orderBy]').val(orderby);
            $('input[name=orderByType]').val(sort);
            self.ajaxReviewList.reload();
            self.getQnaCount();
        });

    },
    initAjaxReviewList: function () { //리뷰 ajax 최초 세팅
        var self = this;
        self.ajaxReviewList = common.ajaxList();

        self.reviewImgsContents = self.ajaxReviewList.compileTpl('#devReviewImgsDetails'); //리뷰 상세 이미지
        $('#devReviewImgsContents').text('{[{imgDetails}]}'); //setContent 에서 템플릿 사용 가능하도록 변경

        self.ajaxReviewList.setContent = function (list, paging) { // setContent 메소드 리매핑
            this.removeContent();
            if (list.length > 0) {
                for (var i = 0; i < list.length; i++) {
                    var row = list[i];
                    var items = [];
                    if (row.anotherImgs.length > 0) { //리뷰 상세 이미지가 있을 경우. 첫번째 이미지는 대표이미지이므로 해당 데이터에는 없음.
                        for (var idx = 0; idx < row.anotherImgs.length; idx++) {
                            var img = new Object();
                            img.img = row.anotherImgs[idx];
                            img.bbsIx = row.bbs_ix;
                            img.index = idx;
                            items.push(self.reviewImgsContents(img));
                        }
                    }
                    row.imgDetails = items.join('');
                    $(this.container).append(this.listTpl(row));
                }

                if (paging) {
                    $(this.pagination).html(common.pagination.getHtml(paging));
                }
            } else {
                $(this.container).append(this.emptyTpl());
            }
        };

        self.ajaxReviewList
                .setUseHash(false)
                .setRemoveContent(false)
                .setLoadingTpl('#devReviewLoading')
                .setListTpl('#devReviewDetail')
                .setEmptyTpl('#devReviewEmpty')
                .setContainerType('ul')
                .setContainer('#devReviewContents')
                .setPagination('#devReviewPageWrap')
                .setPageNum('#devPage')
                .setForm('#devProductReviewForm')
                .setController('bestReviewLists', 'product')
                .init(function (data) {

                    $.each(data.data.list, function (key,obj){
                        obj.nick_name = '{[nick_name]}';
                        obj.comment = '{[{comment}]}';
                        obj.date = '{[date]}';
                        obj.idx = '{[idx]}';
                        obj.modifyBool = '{[modifyBool]}';
                        data.data.list[key] = obj;
                    });

                    self.ajaxReviewList.setContent(data.data.list, data.data.paging);

                    $('.devReviewImgs').click(function () {
                        var bbsIx = $(this).data('bbsix');
                        var index = $(this).data('index');
                        var p_modal_title = '포토/동영상';

                        if(common.langType == 'english') {
                            p_modal_title = 'Photo/Movie';
                        }
                        $('body').addClass('popup--open');
                        common.util.modal.open('ajax', p_modal_title, '/popup/reviewImgList/view/' + bbsIx);
                    })
                    $('.devBestPickDetail').on('click', '', function () {
                        var bbsIx = $(this).data('bbsix');
                        var b_modal_title = 'Best Pick 보기';

                        if(common.langType == 'english') {
                            b_modal_title = 'Best Pick';
                        }
                        common.util.modal.open('ajax', b_modal_title, '/popup/reviewImgList/bestView/' + bbsIx);
                    })

                    $('.devReviewImgList').click(function () {
                        var pid = $(this).attr('data-pid');
                        var p_modal_title = '포토/동영상';

                        if(common.langType == 'english') {
                            p_modal_title = 'Photo/Movie';
                        }
                        $('body').addClass('popup--open');
                        common.util.modal.open('ajax', p_modal_title, '/popup/reviewImgList/list/' + pid );
                    })




                    var openReviewDetail = new Array(); //배열선언
                    $('.devViewVideoReview').on('click',function(){
                        var video_idx = $(this).data('video_idx');
                        if(openReviewDetail[video_idx] != true ){
                            openReviewDetail[video_idx] = false;
                        }

                        if(video_idx){
                            if($('#devDetailView_'+video_idx).css('display') == 'none'){
                                if(openReviewDetail[video_idx] == false){
                                    self.initVideoCommentList(video_idx);
                                    openReviewDetail[video_idx] = true;
                                }
                            }
                        }

                    });

                    $('.devCommentButton').on('click',function(){
                        const $target = $(this).siblings(".review-detail__user-comment");
                        var video_idx = $(this).data('video_idx');

                        if(!$target.hasClass("review-detail__user-comment--show")) {
                            $target.addClass("review-detail__user-comment--show");
                            self.ajaxVideoReviewComment[video_idx].reload();
                            $('#devVideoCommentPageWrap_'+video_idx).show();

                        } else {
                            $target.removeClass("review-detail__user-comment--show");
                            $('#devVideoCommentPageWrap_'+video_idx).hide();
                        }

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
                            }, function () {
                                if (comment.length == 0) {
                                    common.noti.alert('댓글을 입력 해 주세요');
                                    commentSubmitBool = false;
                                    return false;

                                }
                                return true;
                            }, function (res) {

                                //성공일때 처리
                                commentSubmitBool = false;
                                self.ajaxVideoReviewComment[video_idx].reload();
                                $('.devCommentButton em').html(res.data);
                                $('.devComment').val('');
                                $('.devAddCommentButton').removeClass("input-comment__save").addClass("input-comment__save--disabled");
                                $('.devCommentLimit em').html(0);
                            });
                        }
                    });

                    /* [프론트] 글로벌 리뷰영역 스크립트 추가 */
                    if(common.langType != 'korean') {
                        $('[data-avg_pct]').each(function() {
                            $(this).css('width', $(this).attr('data-avg_pct'));
                        });
                    }
                });

        $('#devReviewContents').on('click', '.devReviewDetailContents', function (e) { //클릭시 상세 정보 아래로 슬라이드됨
            if(!!$(e.target).attr("class") && $(e.target).attr("class").indexOf("help-btns--") < 0) slideToggle(this);
        });

        $(document).on('click', '.devViewReviewImg', function () {
            var bbsIx = $(this).data('bbsix');
            var index = $(this).data('index');
            var modal_title = '이미지 보기';

            if(common.langType == 'english') {
                modal_title = 'Review image';
            }
            common.util.modal.open('ajax', modal_title, '/popup/reviewImgView/' + bbsIx + '/' + index);
        })




        $('#devReviewPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxReviewList.getPage($(this).data('page'));
        });



    },

    run: function () {
        var self = this;
        self.initEvent();
        self.initAjaxReviewList();
    },
};




$(function () {
    if(common.langType != 'korean') {
        bestReview.run();
    }

});


