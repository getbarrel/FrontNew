/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//상세 슬라이드
function slideToggle(obj) {
    $(obj).next().slideToggle(200);
}

$(function () {


    //상세보기 zoom
    $('.picZoomer').picZoomer();
    $(window).resize(function(){
        $('.picZoomer').picZoomer();
        //console.log("12345");
    });


    // //탭고정
    // if ($('.wrap-tab-area').length) {
    //     var $target = $('.goods-view-tab, .option-area');
    //
    //
    //     var scrollCon = function () {
    //         $(window).scroll(function () {
    //             var starH = $('.wrap-tab-area').offset().top,
    //                     wst = $(window).scrollTop();
    //             if (wst > starH) {
    //                 $target.addClass('sticky');
    //
    //             } else {
    //                 $target.removeClass('sticky');
    //             }
    //             ;
    //         });
    //     };
    //     scrollCon();
    // }

    $('.goods-view-tab a').on('click', function () {
        if ($(this).parent().hasClass('sticky')) {
            var offset = $('.wrap-tab-area .wrap-tab-cont').offset().top;
            $('html , body').animate({scrollTop: offset - 60}, 400);
        }
        ;
        return false;
    });

    //상품문의 상세
    $('.qna-title').click(function () {
        slideToggle(this);
    });

    //상품정보 제공고시 상세
    $('.wrap-product-noti button').click(function () {
        slideToggle(this);
    });

    $('.open-layer-card').click(function () {
        $('.layer-card').toggle();
    });
    $('.open-layer-delivery').click(function () {
        $('.layer-delivery').toggle();
    });
    $('.btn-layer-close').click(function () {
        $(this).parents('div[class^=layer-]').hide();
    });



});

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
common.lang.load('product.bbsQnaDelete.alert', "문의 내역을 삭제 하시겠습니까?.");
common.lang.load('product.bbsQnaDeleteFail.alert', "삭제가 실패 되었습니다. 다시 시도 바랍니다.");

common.lang.load('coupon.download.fail', '쿠폰 다운로드에 실패하였습니다');
common.lang.load('coupon.download.success', '쿠폰이 정상적으로 다운로드 되었습니다.');

common.lang.load('product.qnaSubmit.confirm', "상품 문의를 등록하시겠습니까?"); //Confirm_01

$(function () {
    $('.devCouponContents').on('click', '[devPublishIx]', function () {
        var self = $(this);
        var publishIx = $(this).attr('devPublishIx');
        common.ajax(common.util.getControllerUrl('downCoupon', 'product'), {publishIx: publishIx}, "", function (result) {
            if (result.result == 'success') {
                self.prop('disabled', true);
                self.html('다운로드 완료');
                common.noti.alert(common.lang.get('coupon.download.success'));
            } else {
                common.noti.alert(common.lang.get('coupon.download.fail'));
            }
        })
    });

    $('#devChangePcs').on('click',function(){
        if($(this).is(':checked') == true){
            common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
            common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
            $('#devPcs1,#devPcs2,#devPcs3').prop('disabled',false);
        }else{
            common.validation.set($('#devPcs2,#devPcs3'), {'required': false});
            $('#devPcs1,#devPcs2,#devPcs3').prop('disabled',true);
        }
    });

    $('#devSumbitBtn').on('click', function () {

        if(!$('#option_id').val()){
            alert("옵션을 선택하시기 바랍니다.");
            return;
        }

        if(!$('#devPcs2').val()){
            alert("전화번호를 입력하시기 바랍니다.");
            return;
        }

        if(!$('#devPcs3').val()){
            alert("전화번호를 입력하시기 바랍니다.");
            return;
        }

        if(confirm("입고알림 신청을 하시겠습니까?")){

            pid         = $('#pid').val();
            option_id   = $('#option_id').val();
            pcs         = $('#devPcs1').val() + "-" +$('#devPcs2').val() + "-" +$('#devPcs3').val();

            var allData = { "pid": pid, "option_id": option_id, "pcs": pcs };

            common.ajax(common.util.getControllerUrl('productReStock', 'product'), allData, "", function (result) {

                if (result.result == "success") {
                    alert("입고알림 신청이 완료 되었습니다.");
                    location.reload();
                } else if (result.result == "overlap") {
                    alert("신청된 정보가 존재합니다.");
                } else if (result.result == "optionIdFail") {
                    alert("옵션을 선택해 주세요.");
                } else {
                    alert('system error');
                }
            })
        }
    });

    $('#devSubmitBtnQna').on('click', function () {
        if(!$('#devQnaDiv').val()){
            alert("문의유형을 선택하시기 바랍니다.");
            return;
        }

        if(!$('#devQnaSubject').val()){
            alert("문의 제목을 입력하시기 바랍니다.");
            return;
        }

        if(!$('#devEmailId').val()){
            alert("메일 주소를 입력하시기 바랍니다.");
            return;
        }

        if(!$('#devEmailHost').val()){
            alert("메일 주소를 입력하시기 바랍니다.");
            return;
        }

        if(!document.goodsQnaFrom.contents.value){
            alert("문의 내용을 입력하시기 바랍니다.");
            return;
        }

        if(common.noti.confirm(common.lang.get('product.qnaSubmit.confirm'))){
            var pid                 = $('#devPid').val();
            var bbsix               = $('#devBbsIx').val();
            var div                 = $('#devQnaDiv').val();
            var subject             = $('#devQnaSubject').val();
            var emailId             = $('#devEmailId').val();
            var emailHost           = $('#devEmailHost').val();
            var bbs_email_return    = $("input[name='bbs_email_return']:checked").val();
            var contents            = document.goodsQnaFrom.contents.value;
            var isHidden            = $("input[name='isHidden']:checked").val();

            var allData = { "pid": pid, "bbs_ix": bbsix, "div": div, "subject": subject, "emailId": emailId, "emailHost": emailHost, "bbs_email_return": bbs_email_return, "contents": contents, "isHidden": isHidden };

            common.ajax(common.util.getControllerUrl('qnaWrite', 'product'), allData, "", function (result) {

                if (result.result == "success") {
                    alert("상품문의가 등록되었습니다.");
                    location.reload();
                } else {
                    alert('system error');
                }
            })
        }
        return false;
    });

    $('#devEmailHostSelect').on('change', function() {
        $('#devEmailHost').val(this.value);
    });
});

var goodsView = {
    ajaxReviewList: false, //리뷰 ajax
    ajaxQnaList: false, //문의 ajax
    responseContents: '', //문의 답변 영역
    questionContents: '', //문의 내용 영역
    reviewImgsContents: '', //후기 이미지
    getQnaCount: function () {
        common.ajax(common.util.getControllerUrl('qnaCount', 'product'), {
            id: $('#devQnaPid').val(),
            qnaDiv: $('#qnaDivSelectBox').val()
        }, false, function (qnaCnt) {
            $('#devQnaTotal').text(qnaCnt.data.all);
            $('#devQnaMine').text(qnaCnt.data.mine);
        }, 'json');
    },
    initEvent: function () {
        var self = this;

        $('#devCopyPcode').on('click', function () {
            var pcode = $(this).data('pcode');
            common.noti.alert(common.lang.get('product.pcodeCoyp.alert'), function () {
                common.util.copyText(pcode);
            });
        });

        $('.devSelectCid').on('change', function () {
            top.document.location.href = '/shop/goodsList/' + $(this).val();
        });

        $('.devSelectCidsub').on('change', function () {
            top.document.location.href = '/shop/subGoodsList/' + $(this).val();
        });

        $('#devPromotionSection').on('change', '#devPromotionSelect', function () { //관련 기획전
            top.location.href = '/event/goods_event.php?event_ix=' + $(this).val();
        });

        $('#devCouponDown').on('click', function () { //쿠폰받기
            var pid = $(this).data('pid');
            if (forbizCsrf.isLogin) {
                var modal_title = '쿠폰 다운로드';

                if(common.langType == 'english') {
                    modal_title = 'Download coupon';
                }
                common.util.modal.open('ajax', modal_title, '/shop/couponDown/' + pid);
            } else {
                common.noti.confirm(common.lang.get('product.noMember.coupon.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

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

        $('#qnaDivSelectBox').on('change', function () { //상품문의 분류
            $('input[name=qnaDiv]').val($(this).val());
            self.ajaxQnaList.reload();
            self.getQnaCount();
        });

        $('.devQnaSort').on('click', function () { //상품문의 타입(전체/내문의)
            var qnaType = $(this).data('type');
            var pid = $(this).data('pid');

            if (forbizCsrf.isLogin) {
                $('#devQnaType').val(qnaType);
                self.ajaxQnaList.reload();
            } else {
                common.noti.confirm(common.lang.get('product.bbsQnaHidden.alert'), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('#devQnaWrite').on('click', function () { //상품문의 작성
            var pid = $(this).data('pid');
            if (forbizCsrf.isLogin) {
                common.util.popup('/shop/goodsQnaWrite/' + pid, 720, 1050, common.lang.get('product.qnaTitle.popup'), true);
            } else {
                common.noti.confirm(common.lang.get('product.noMember.productQna.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('#devQnaContents').on('click','.devModifyQna',function(){
            var bbs_ix = $(this).data('bbs_ix');
            var pid = $(this).data('pid');
            //common.util.modal.open('ajax', '상품 Q&A', '/shop/goodsQnaWrite/' + pid +'/' +bbs_ix, '', window.goodsQnaCallback);
            common.util.popup('/shop/goodsQnaWrite/' + pid +'/'+bbs_ix, 720, 1050, common.lang.get('product.qnaTitle.popup'), true);
        });
        $('#devQnaContents').on('click', '.devDeleteQna',function(){
            var bbs_ix = $(this).data('bbs_ix');

            common.ajax(
                common.util.getControllerUrl('deleteQna', 'mypage'),
                {
                    bbs_ix: bbs_ix
                },
                function () {
                    if (confirm(common.lang.get('product.bbsQnaDelete.alert'))) {
                        return true;
                    } else {
                        return false;
                    }
                },
                function (data) {
                    if (data.result == 'success') {
                        self.ajaxQnaList.getPage(1);
                        self.getQnaCount();
                    }else{
                        common.noti.alert(common.lang.get('product.bbsQnaDeleteFail.alert'));
                        self.ajaxQnaList.getPage(1);
                    }
                }

            );
        });

		 //2022-11-17 kwon 사이즈추천 하단 사이즈표 보러가기 추가
		$('.size_btn').on('click', function(){
			var modal_title = '사이즈 가이드';
			common.util.modal.open('ajax', modal_title, '/shop/goodsPop/', '', window.goodsAlarmCallback);
		});
		 //2022-11-17 kwon 사이즈추천 하단 사이즈표 보러가기 추가

        //탭으로 숨김 처리가 아닌 로드 후 위치 이동이기 떄문에 페이지 로드 시 즉시 QNA 로드 시킴
        self.initAjaxQnaList(); //최초 세팅
        
        $('.devDetailTabs').on('click', function () { //상품상세 탭 이벤트(상품정보, 후기, 문의, 교환/반품)
            var content = $(this).data('content');

            if (content == 'devTabReview') { //터치시 ajax 최초 세팅. 2번째부터는 세팅된 ajax 로 로드됨.
                if ($('#devAllReviewEmpty').length == 0) {
                    if ($('#devReviewDetail').length > 0) {
                        self.initAjaxReviewList(); //최초 세팅
                    } else {
                        self.ajaxReviewList.reload();
                    }
                }
            } else if (content == 'devTabInquiry') { //터치시 ajax 최초 세팅. 2번째부터는 세팅된 ajax 로 로드됨.
                if ($('#devAllQnaEmpty').length == 0) {
                    if ($('#devQnaDetail').length > 0) {
                        self.initAjaxQnaList(); //최초 세팅
                    } else {
                        self.ajaxQnaList.reload();
                    }
                }

            }
        });

        $('#storeGuide').on('click', function(){
            var id = $(this).data('id');
            var type = $(this).data('type');

            if(type != '99') {
                var modal_title = '매장안내';

                if(common.langType == 'english') {
                    modal_title = 'Store guide';
                }
                common.util.modal.open('ajax', modal_title, '/popup/storeGuide/'+id, '', window.storeGuideCallback);
            }else {
                var alert_msg = '세트상품은 온라인 전용상품 입니다.';

                if(common.langType == 'english') {
                    alert_msg = 'Set products are online only products';
                }
                alert(alert_msg);
            }
        });
    },
    initMinicart: function () { //옵션 데이터 로드가 완료된 후 미니카트 관련 세팅 시작 
        $.getScript($('#devMinicartScript').data('url'), function () {
            var minicart = devMiniCart(); //상단 옵션 영역
            minicart
                    .setOptionData(devOptionData)
                    .setProductState(product_state)
                    .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt,allow_max_cnt,user_buy_cnt)
                    .setContents('#devMinicartArea', '#devMinicartOptions', '#devMinicartAddOption', '#devLonelyOption', '#devLonelyOptionName')
                    .setChoosedContents('#devMinicartSelected', '.devOptionBox')
                    .setControlPrice('#devMinicartTotal', '.devMinicartEachPrice')
                    .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
                    .setBtn('.devMinicartDelete', '.devAddCart', '.devOrderDirect')
                    .init();

            // var sildeMinicart = devMiniCart(); //하단 옵션 영역
            // sildeMinicart
            //         .setOptionData(devOptionData)
            //         .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt)
            //         .setContents('#devSildeMinicartArea', '#devSildeMinicartOptions', '#devSlideMinicartAddOption', '#devSildeLonelyOption', '#devSildeLonelyOptionName')
            //         .setChoosedContents('#devSlideMinicartSelected', '.devOptionBox')
            //         .setControlPrice('#devSildeMinicartTotal', '.devMinicartEachPrice')
            //         .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
            //         .setBtn('.devMinicartDelete', '.devSlideAddCart', '.devSlideOrderDirect')
            //         .init();

            //상단, 하단 옵션 영역을 싱크하기 위해 작업
            // minicart.sync(sildeMinicart);
            // sildeMinicart.sync(minicart);
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
                .setLoadingTpl('#devReviewLoading')
                .setListTpl('#devReviewDetail')
                .setEmptyTpl('#devReviewEmpty')
                .setContainerType('ul')
                .setContainer('#devReviewContents')
                .setPagination('#devReviewPageWrap')
                .setPageNum('#devPage')
                .setForm('#devProductReviewForm')
                .setController('reviewLists', 'product')
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
                        $('body').addClass('popup--open');

                        var p_modal_title = '포토/동영상';

                        if(common.langType == 'english') {
                            p_modal_title = 'Photo/Movie';
                        }

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
    ajaxVideoReviewComment: [],
    initVideoCommentList: function(video_idx){

        var self = this;
        self.ajaxVideoReviewComment[video_idx] = common.ajaxList();

        self.ajaxVideoReviewComment[video_idx]
            .setContainerType('div')
            .setLoadingTpl('#devVideoCommentLoading_' + video_idx)
            .setListTpl('#devVideoCommentList_' + video_idx)
            .setEmptyTpl('#devVideoCommentEmpty_' + video_idx)
            .setContainer('#devVideoCommentContent_' + video_idx)
            .setPagination('#devVideoCommentPageWrap_' + video_idx)
            .setPageNum('#devVideoCommentPage_' + video_idx)
            .setForm('#devVideoCommentForm_' + video_idx)
            .setController('getVideoCommentData', 'video')
            .setUseHash(false)
            .init(function (data) {
                self.ajaxVideoReviewComment[video_idx].setContent(data.data.list, data.data.paging);
                $('.devVideoCommentModifyBtn[devModify=false]').remove();
            });

        $('#devVideoCommentPageWrap_'+video_idx).on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxVideoReviewComment[video_idx].getPage($(this).data('page'));
        });


        $('.devLoginCheck').on('click',function(){
            common.noti.confirm(common.lang.get('product.noMember.reView.confirm'), function () {
                document.location.href = '/member/login?url=' + encodeURI(window.location.href);
            });
        });

        var commentModifyBool = false;
        $('#devDetailView_'+video_idx).on('click','.devCommentModifyBtn',function(e){

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
                    self.ajaxVideoReviewComment[video_idx].reload();
                });
            }
        });
    },
    initAjaxQnaList: function () { //문의 ajax 최초 세팅
        var self = this;
        var basicClone = $('#devQnaBasicContents').clone();
        self.ajaxQnaList = common.moreAjaxList();

        self.questionContents = self.ajaxQnaList.compileTpl('#devQnaQuestion'); //문의 질의 영역
        self.responseContents = self.ajaxQnaList.compileTpl('#devQnaResponse'); //문의 답변 영역

        $('#devQnaDetailContents').text('{[{qnaDetails}]}'); //setContent 에서 템플릿 사용 가능하도록 변경


		// 페이지네이션 재정의
		/*
		self.ajaxQnaList.setContent = function (list, paging) {
			console.log(paging.cur_page);
			if(paging.cur_page == 1){
				this.removeContent();
			}
			if (list.length > 0) {
				for (var i = 0; i < list.length; i++) {
					var row = list[i];
					$(this.container).append(this.listTpl(row));
				}
				if (paging) {
					$(this.pagination).html(common.morePagination.getHtml(paging));
				}
			} else {
				$(this.container).append(this.emptyTpl());
			}
		};
		*/
		
        self.ajaxQnaList.setContent = function (list, paging) { // setContent 메소드 리매핑
            $(this.container).append(basicClone);

            if (list && list.length > 0) {
                for (var i = 0; i < list.length; i++) {
                    var row = list[i];
                    if (row.bbs_hidden == 0 || (row.isSameUser == true && row.bbs_hidden == 1)) { //공개 or 비공개 & 동일작성자일 경우 영역 노출
                        var oitems = [];
                        oitems.push(self.questionContents(row));

                        if (row.comments.length > 0) { //답변 있을 경우
                            for (var idx = 0; idx < row.comments.length; idx++) {
                                oitems.push(self.responseContents(row.comments[idx]));
                            }
                        }

                        row.qnaDetails = oitems.join('');
                    }
                    $(this.container).append(this.listTpl(row));
                }

                if (paging) {
					//console.log(common.morePagination.getHtml(paging));
                    $('#devQnaPageWrap').html(common.morePagination.getHtml(paging));
                }
            } else {
                $(this.container).append(this.emptyTpl());
				$('#devQnaPageWrap').hide();
            }
        };
		

        self.ajaxQnaList
                .setUseHash(false)
                .setLoadingTpl('#devQnaLoading')
                .setListTpl('#devQnaDetail')
                .setEmptyTpl('#devQnaEmpty')
                .setContainerType('ul')
                .setContainer('#devQnaContents')
                .setPagination('#devQnaPageWrap')
                .setPageNum('#devQnaPage')
                .setForm('#devProductQnaForm')
                .setController('qnaLists', 'product')
                .init(function (data) {
                    self.ajaxQnaList.setContent(data.data.list, data.data.paging);
                });


		$('#devQnaPageWrap').on('click', '.devPageBtnCls', function () {
			var pageNum = $(this).data('page');
			self.ajaxQnaList.getPage(pageNum);
		});

		
		/*
        $('#devQnaPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxQnaList.getPage($(this).data('page'));
        });
		

		$('#devQnaPageWrap').on('click', '.devPageBtnCls', function () {
			var pageNum = $(this).data('page');
			self.ajaxQnaList.getPage(pageNum);
		});
		*/
    },

    run: function () {
        var self = this;
        self.initMinicart();
        self.initEvent();
    },
};




$(function () {
    goodsView.run();

});

function laundryChange(cid) {
	$.ajax({
		type: 'GET',
		url: '/customer/productPrecautions?mode=ajaxPcNew&cid='+cid,
		success: function(data, textStatus, request) {
			var div_laundry = $("#laundryInfo");
			div_laundry.children().remove();
			div_laundry.append(data);
		},
		error: function(request, textStatus, error) {
			alert('세탁주의관리 항목을 불러올수 없습니다./n관리자에게 문의하세요.');
		}
	});
}

function storeSch(){

    if($('#devOptionSelect').length > 0){
        item = $('#devOptionSelect').val();
    }else {
        item = $('#devStyleSelect').val();
    }

    city = $('#devCitySelect').val();

    var allData = { "city": city, "item": item };

    common.ajax(common.util.getControllerUrl('searchStore', 'product'), allData, "", function (result) {
        var data = $.parseJSON(result.data);
        if (data.res_cd == '0000') {
            $('#storeListCount').text(data.stock_list.length);

            $('#storeList').empty();

            obj_table_text = "";
            for (i = 0; i < data.stock_list.length; i++) {
                obj_table_text += "<li class='store-result__item'>";
                obj_table_text += "    <a href='/customer/storeInformation/" + data.stock_list[i].shop_cd + "' target='_blank'><div class='title-md'>" + data.stock_list[i].shop_nm + "</div></a>";
                obj_table_text += "    <p>" + data.stock_list[i].shop_addr + "</p>";
                obj_table_text += "</li>";
            }

            newObj = $(obj_table_text);

            newObj.appendTo($('#storeList'));
        } else {
            alert('매장정보조회 API에 문제가 생겼습니다.');
        }
    })
}

function laundryTwoChange(val){
    laundryTwoDepthOld =  $("#laundryTwoDepthOld").val();
    $("#oneLaundry-" + laundryTwoDepthOld).css('display', 'none');
    $("#oneLaundry-" + val).css('display', 'block');
    $("#twoLaundry-" + laundryTwoDepthOld).css('display', 'none');
    $("#twoLaundry-" + val).css('display', 'block');
    $("#laundryTwoDepthOld").val(val);
}

function laundryTab(num){
    if(num == 1){
        $('#laundryOneTab').addClass("active");
        $('#laundryOneContent').addClass("active");
        $('#laundryTwoTab').removeClass("active");
        $('#laundryTwoContent').removeClass("active");
    }else if(num == 2){
        $('#laundryOneTab').removeClass("active");
        $('#laundryOneContent').removeClass("active");
        $('#laundryTwoTab').addClass("active");
        $('#laundryTwoContent').addClass("active");
    }
}

function qnaEdit(bbs_ix, pid){
    var allData = { "bbs_ix": bbs_ix };

    common.ajax(common.util.getControllerUrl('selectQna', 'product'), allData, "", function (result) {

        if (result.result == "success") {
            $("#devBbsIx").val(bbs_ix);

            $("#devQnaDiv").val(result.data.bbs_div);
            $("#devQnaSubject").val(result.data.bbs_subject);
            $("#devEmailId").val(result.data.emailId);
            $("#devEmailHost").val(result.data.emailHost);

            document.goodsQnaFrom.contents.value = result.data.bbs_contents;

            if(result.data.bbs_email_return == "1"){
                $("#devEmailReturn_1").prop("checked",true);
                $("#devEmailReturn_0").prop("checked",false);
            }else{
                $("#devEmailReturn_1").prop("checked",false);
                $("#devEmailReturn_0").prop("checked",true);
            }

            if(result.data.bbs_hidden == "1"){
                $("#devIsHidden_1").prop("checked",true);
                $("#devIsHidden_0").prop("checked",false);
            }else{
                $("#devIsHidden_1").prop("checked",false);
                $("#devIsHidden_0").prop("checked",true);
            }

            $('#contentsPlace').css('display', 'none');
        } else {
            alert('system error');
        }
    })
}

function contentWish(pid, ix, type, e){
    if (forbizCsrf.isLogin) {
        var allData = { "con_ix": ix, "type": type };
        common.ajax(common.util.getControllerUrl('content', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                $(e).toggleClass("product-box__heart--active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("product-box__heart--active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
        }
    }
}

function giftImgChange(val){
    $("#giftImg").attr("src", $("#giftImg_"+val).val());
    $("#giftPname").html($("#giftPname_"+val).val());
    $("#giftDate").html($("#giftDate_"+val).val());
    $("#giftPrice").html($("#giftPrice_"+val).val());
}
