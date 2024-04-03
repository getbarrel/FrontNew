/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//상세 슬라이드
function slideToggle(obj) {
    $(obj).next().slideToggle(200);
}

$(function () {
    $('#carousel').flexslider({
        animation: "slide",
        itemWidth: 80,
        controlNav: false
    });


    $('.area-goods-list .goods-list .slider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 160,
        itemMargin: 35,
        slideshow: false,
        controlNav: true,

        start: function (slider) {
            $(".txt-current").text(slider.currentSlide + 1);
            // $(".txt-total").text(slider.count);
            var totalCount = $('.slider .flex-control-paging li').length;
            if (totalCount == 0) {
                totalCount = 1;
            }
            $(".txt-total").text(totalCount);
        },
        before: function (slider) {
            $(".txt-current").text(slider.animatingTo + 1);

        },

    });


    $('.area-goods-list .goods-list-rel .rel-slider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 160,
        itemMargin: 35,
        slideshow: false,
        controlNav: true,
        start: function (slider) {
            $(".txt-current-rel").text(slider.currentSlide + 1);
            //$(".txt-total-rel").text(slider.count);
            var totalCount = $('.rel-slider .flex-control-paging li').length;
            if (totalCount == 0) {
                totalCount = 1;
            }
            $(".txt-total-rel").text(totalCount);
        },
        before: function (slider) {
            $(".txt-current-rel").text(slider.animatingTo + 1);
        },

    });

    //상세보기 zoom
    $('.picZoomer').picZoomer();

    $('#carousel li').on('click', function (event) {
        var $pic = $(this).find('img');
        $('.picZoomer-pic').attr('src', $pic.attr('src'));
    });

    //탭고정
    if ($('.wrap-tab-area').length) {
        var $target = $('.goods-view-tab, .option-area');


        var scrollCon = function () {
            $(window).scroll(function () {
                var starH = $('.wrap-tab-area').offset().top,
                        wst = $(window).scrollTop();
                if (wst > starH) {
                    $target.addClass('sticky');

                } else {
                    $target.removeClass('sticky');
                }
                ;
            });
        };
        scrollCon();
    }

    $('.goods-view-tab a').on('click', function () {
        if ($(this).parent().hasClass('sticky')) {
            console.log('ggggg');
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

        $('#devPromotionSection').on('change', '#devPromotionSelect', function () { //관련 기획전
            top.location.href = '/event/goods_event.php?event_ix=' + $(this).val();
        });

        $('#devCouponDown').on('click', function () { //쿠폰받기
            var pid = $(this).data('pid');
            if (forbizCsrf.isLogin) {
                common.util.modal.open('ajax', '쿠폰 다운로드', '/shop/couponDown/' + pid);
            } else {
                common.noti.confirm(common.lang.get('product.noMember.coupon.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('.devReviewsDiv').on('click', function () { //상품후기 분류 탭(프리미엄/일반)
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

    },
    initMinicart: function () { //옵션 데이터 로드가 완료된 후 미니카트 관련 세팅 시작 
        $.getScript($('#devMinicartScript').data('url'), function () {
            var minicart = devMiniCart(); //상단 옵션 영역
            minicart
                    .setOptionData(devOptionData)
                    .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt)
                    .setContents('#devMinicartArea', '#devMinicartOptions', '#devMinicartAddOption', '#devLonelyOption', '#devLonelyOptionName')
                    .setChoosedContents('#devMinicartSelected', '.devOptionBox')
                    .setControlPrice('#devMinicartTotal', '.devMinicartEachPrice')
                    .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
                    .setBtn('.devMinicartDelete', '.devAddCart', '.devOrderDirect')
                    .init();

            var sildeMinicart = devMiniCart(); //하단 옵션 영역
            sildeMinicart
                    .setOptionData(devOptionData)
                    .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt)
                    .setContents('#devSildeMinicartArea', '#devSildeMinicartOptions', '#devSlideMinicartAddOption', '#devSildeLonelyOption', '#devSildeLonelyOptionName')
                    .setChoosedContents('#devSlideMinicartSelected', '.devOptionBox')
                    .setControlPrice('#devSildeMinicartTotal', '.devMinicartEachPrice')
                    .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
                    .setBtn('.devMinicartDelete', '.devSlideAddCart', '.devSlideOrderDirect')
                    .init();

            //상단, 하단 옵션 영역을 싱크하기 위해 작업
            minicart.sync(sildeMinicart);
            sildeMinicart.sync(minicart);
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
                    self.ajaxReviewList.setContent(data.data.list, data.data.paging);
                });

        $('#devReviewContents').on('click', '.devReviewDetailContents', function () { //클릭시 상세 정보 아래로 슬라이드됨
            slideToggle(this);
        });

        $('#devReviewContents').on('click', '.devReviewImgs', function () {
            var bbsIx = $(this).data('bbsix');
            var index = $(this).data('index');
            common.util.modal.open('ajax', '이미지 보기', '/popup/reviewImgView/' + bbsIx + '/' + index);
        })

        $('#devReviewPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxReviewList.getPage($(this).data('page'));
        });
    },
    initAjaxQnaList: function () { //문의 ajax 최초 세팅
        var self = this;
        var basicClone = $('#devQnaBasicContents').clone();
        self.ajaxQnaList = common.ajaxList();

        self.questionContents = self.ajaxQnaList.compileTpl('#devQnaQuestion'); //문의 질의 영역
        self.responseContents = self.ajaxQnaList.compileTpl('#devQnaResponse'); //문의 답변 영역
        $('#devQnaDetailContents').text('{[{qnaDetails}]}'); //setContent 에서 템플릿 사용 가능하도록 변경

        self.ajaxQnaList.setContent = function (list, paging) { // setContent 메소드 리매핑
            this.removeContent();
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
                    $(this.pagination).html(common.pagination.getHtml(paging));
                }
            } else {
                $(this.container).append(this.emptyTpl());
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

        $('#devQnaPageWrap').on('click', '.devQnaDetailCover', function () {
            if ($(this).hasClass('devNotSameUser')) { //비공개 & 동일 작성자가 아닐 경우 alert 노출
                common.noti.alert(common.lang.get('product.bbsQnaHidden.alert'));
            } else {
                slideToggle(this);
            }
        });

        $('#devQnaPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.ajaxQnaList.getPage($(this).data('page'));
        });
    },
    run: function () {
        var self = this;

        self.initMinicart();
        self.initEvent();
    }
};

$(function () {
    goodsView.run();
});