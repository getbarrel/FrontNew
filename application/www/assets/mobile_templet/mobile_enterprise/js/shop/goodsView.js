"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
var detailThumbSwiper = new Swiper('.thumb-area .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 0,
    pagination: {
        el: '.swiper-pagination',
        type: 'fraction',
    }
});

var goodsSwiper = new Swiper('.area-goods .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 30,

});

var goodsRelSwiper = new Swiper('.area-goods-rel .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 30,

});


var detailReviewSwiper = new Swiper('.review-detail .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 20,
    observer: true,
    observeParents: true
});

//상세 슬라이드
function slideToggle(obj) {
    $(obj).next().slideToggle(200);
}

$(function () {
    //탭고정
    if ($('.wrap-tab-area').length) {
        var $target = $('.goods-view-tab');

        var scrollCon = function () {
            $(window).scroll(function () {
                var starH = $('.wrap-tab-area').offset().top - 85,
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
            var offset = $('.wrap-tab-cont').offset();
            $('html , body').animate({scrollTop: offset.top - 85}, 400);
        }
        ;
        return false;
    });

    //상품리뷰 토글 ajax 로 데이터 호출 후 실행하는 것으로 변경함 180921
    //상품문의 상세
    $('.qna-title').click(function () {
        slideToggle(this);
    });

    //상품상세 사은품 상세
    $('.product_gift button').click(function () {
        slideToggle(this);
    });

    $('select[class^=devProductGift]').on('change',function(){
        var pid = $(this).val();
        var selNum = $(this).data('idx');
        $('.devProductGift_'+selNum).val(pid).prop("selected", true);
    });
    //미니카트
    $('.br__goods-view__minicart--toggle, .br__goods-view__minicart--dimmed').click(function () {
        var $minicart = $('.mini-cart');
        if( $minicart.hasClass('devOpened') ){
            $('.br__goods-view__information').scrollTop(0);
            $minicart.removeClass('br__goods-view__minicart--show devOpened frontOpened');
            bodyScroll.release();
        }else {
            $minicart.addClass('br__goods-view__minicart--show devOpened');
            bodyScroll.fix();
            $('.br__goods-view__information').scrollTop(0);
        }
    });
    // $('.mini-cart .btn-closed').click(function () {
    //     $('.mini-cart').slideUp();
    //     $('.mini-cart').removeClass('devOpened'); //개발 추가
    // });

    $('.open-layer-card').click(function () {
        common.util.modal.open('html', '카드혜택', $('.layer-card'));
    });
    $('.open-layer-delivery').click(function () {
        common.util.modal.open('html', '제주, 도서산간 추가 배송비', $('.layer-delivery'));
    });
    $('.open-layer-sns').click(function () {
        common.util.modal.open('html', '공유하기', $('.layer-sns'));
    });
});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('product.noMember.confirm', "로그인이 필요합니다.");
common.lang.load('product.bbsQnaHidden.alert', "비공개 문의입니다.");
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

    $('#devSubmitBtnLayer').on('click', function () {
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
                common.noti.confirm(common.lang.get('product.noMember.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('.devReviewsDiv').on('click', function () { //상품후기 분류 탭(프리미엄/일반)
            var bbsDiv = $(this).data('bbsdiv');
            $('input[name=bbsDiv]').val(bbsDiv);
            self.ajaxReviewList.getPage(1);
        });

        $('.devSort').on('click', function () { //상품후기 정렬
            var orderby = $(this).data('orderby');
            var sort = $(this).data('sort');

            $('input[name=orderBy]').val(orderby);
            $('input[name=orderByType]').val(sort);
            self.ajaxReviewList.getPage(1);
        });

        $('#qnaDivSelectBox').on('change', function () { //상품문의 분류
            $('input[name=qnaDiv]').val($(this).val());
            self.ajaxQnaList.getPage(1);
            self.getQnaCount();
        });

        $('.devQnaSort').on('click', function () { //상품문의 타입(전체/내문의)
            var qnaType = $(this).data('type');
            var pid = $(this).data('pid');

            if (forbizCsrf.isLogin) {
                $('input[name=qnaType]').val(qnaType);
                self.ajaxQnaList.getPage(1);
            } else {
                common.noti.confirm(common.lang.get('product.noMember.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('#devQnaWrite').on('click', function () { //상품문의 작성
            var pid = $(this).data('pid');
            if (forbizCsrf.isLogin) {
               // document.location.href = '/shop/goodsQnaWrite/' + pid;
                var modal_title = '상품 Q&A';

                if(common.langType == 'english') {
                    modal_title = 'Product Q&A';
                }
                common.util.modal.open('ajax', modal_title, '/shop/goodsQnaWrite/' + pid, '', window.goodsQnaCallback);
            } else {
                common.noti.confirm(common.lang.get('product.noMember.confirm', ''), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        });

        $('#devQnaContents').on('click','.devModifyQna',function(){
            var bbs_ix = $(this).data('bbs_ix');
            var pid = $(this).data('pid');
            var modal_title = '상품 Q&A';

            if(common.langType == 'english') {
                modal_title = 'Product Q&A';
            }
            common.util.modal.open('ajax', modal_title, '/shop/goodsQnaWrite/' + pid +'/' +bbs_ix, '', window.goodsQnaCallback);
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


        $('.devDetailTabs').on('click', function () { //상품상세 탭 이벤트(상품정보, 후기, 문의, 교환/반품)
            var content = $(this).data('content');

            if (content == 'devTabReview') { //터치시 ajax 최초 세팅. 2번째부터는 세팅된 ajax 로 로드됨.
                if ($('#devAllReviewEmpty').length == 0) {
                    if ($('#devReviewDetail').length > 0) {
                        self.initAjaxReviewList(); //최초 세팅
                    } else {
                        if(self.ajaxReviewList) {
                            self.ajaxReviewList.reload();
                        }
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
                var modal_title = '세트상품은 온라인 전용상품 입니다.';

                if(common.langType == 'english') {
                    modal_title = 'Set products are online only products';
                }
                alert(modal_title);
            }
        });


        $('#storeGuide_ig').on('click', function(){
            var id = $(this).data('id');
            var type = $(this).data('type');

            if(type != '99') {
                var modal_title = '매장안내';

                if(common.langType == 'english') {
                    modal_title = 'Store guide';
                }
                common.util.modal.open('ajax', modal_title, '/popup/storeGuide/'+id, '', window.storeGuideCallback);
            }else {
                var modal_title = '세트상품은 온라인 전용상품 입니다.';

                if(common.langType == 'english') {
                    modal_title = 'Set products are online only products';
                }
                alert(modal_title);
            }
        });


        $('.goods-info__review__btn').on('click',function () {
            $('.devReviewDetailTabs').trigger('click');
        });


    },
    initMinicart: function () { //옵션 데이터 로드가 완료된 후 미니카트 관련 세팅 시작 
        $.getScript($('#devMinicartScript').data('url'), function () {
           var minicart =  devMiniCart();
            minicart
                    .setOptionData(devOptionData)
                    .setProductState(product_state)
                    .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt,allow_max_cnt,user_buy_cnt)
                    .setContents('#devMinicartArea', '#devMinicartOptions', '#devMinicartAddOption', '#devLonelyOption', '#devLonelyOptionName')
                    .setChoosedContents('#devMinicartSelected', '.devOptionBox')
                    .setControlPrice('#devMinicartTotal', '.devMinicartEachPrice')
                    .setControlPrice_ig('#devMinicartTotal_ig', '.devMinicartEachPrice')
                    .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
                    .setBtn('.devMinicartDelete', '.devAddCart', '.devOrderDirect')
                    .init();

           var centerMinicart = devMiniCart();
            centerMinicart
                .setOptionData(devOptionData)
                .setProductState(product_state)
                .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt,allow_max_cnt,user_buy_cnt)
                .setContents('#devSildeMinicartArea', '#devSildeMinicartOptions', '#devSlideMinicartAddOption', '#devSildeLonelyOption', '#devSildeLonelyOptionName')
                .setChoosedContents('#devSildeMinicartSelected', '.devOptionBox')
                .setControlPrice('#devSildeMinicartTotal', '.devMinicartEachPrice')
                .setControlPrice_ig('#devMinicartTotal_ig', '.devMinicartEachPrice')
                .setControlCntElement('.devControlCntBox', '.devCntPlus', '.devCntMinus', '.devMinicartPrdCnt')
                .setBtn('.devSildeMinicartDelete', '.devAddCart', '.devOrderDirect')
                .init();

            //minicart.sync(centerMinicart);
            centerMinicart.sync(minicart);
        });
    },
    initAjaxReviewList: function () { //리뷰 ajax 최초 세팅
        var self = this;
        self.ajaxReviewList = common.ajaxList();

        self.reviewImgsContents = self.ajaxReviewList.compileTpl('#devReviewImgsDetails'); //리뷰 상세 이미지
        $('#devReviewImgsContents').text('{[{imgDetails}]}'); //setContent 에서 템플릿 사용 가능하도록 변경

        self.ajaxReviewList.setContent = function (list, paging) { // setContent 메소드 리매핑
            //마지막 페이지 또는 page가 1일때 숨김
            if(paging && (paging.cur_page == paging.last_page || paging.page_list.length <= 1)){
                this.hidePagination();
            } else {
                this.sowPagination();
            }
            //삭제옵션, 페이지 검색시 1페이지, paging 정보 없을때
            if (this.remove === true || !paging || paging.cur_page == 1) {
                this.removeContent();
            }
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
                .setController('reviewLists', 'product')
                .init(function (response) {
                    self.ajaxReviewList.setContent(response.data.list, response.data.paging);
                });

        $('#devReviewContents').on('click', '.devReviewDetailContents', function () { //클릭시 상세 정보 아래로 슬라이드됨
            slideToggle(this);
            $(this).toggleClass('on')
        });

        $('#devReviewContents').on('click', '.devReviewImgs', function () {
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
    initAjaxQnaList: function () { //문의 ajax 최초 세팅
        var self = this;
        self.ajaxQnaList = common.ajaxList();

        //self.questionContents = self.ajaxQnaList.compileTpl('#devQnaQuestion'); //문의 질의 영역
        self.responseContents = self.ajaxQnaList.compileTpl('#devQnaResponse'); //문의 답변 영역
        $('#devQnaDetailContents').text('{[{qnaDetails}]}'); //setContent 에서 템플릿 사용 가능하도록 변경


		// 페이지네이션 재정의
		self.ajaxQnaList.setContent = function (list, paging) {
			//this.removeContent();
			if (list.length > 0) {
				for (var i = 0; i < list.length; i++) {
					var row = list[i];
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
                .setRemoveContent(true)
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

		/*
        $('#devQnaPageWrap').on('click', '.devQnaDetailCover', function () {
            if ($(this).hasClass('devNotSameUser')) { //비공개 & 동일 작성자가 아닐 경우 alert 노출
                common.noti.alert(common.lang.get('product.bbsQnaHidden.alert'));
            } else {
                slideToggle(this);
            }
        });

        $('#devQnaPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            if (self.ajaxQnaList.onLoading != $(this).data('page')) {
                self.ajaxQnaList.getPage($(this).data('page'));
            }
        });
		*/

		$('#devQnaPageWrap').on('click', '.devPageBtnCls', function () {
			var pageNum = $(this).data('page');
			self.ajaxQnaList.getPage(pageNum);
		});

    },
    initBeforeProduct: function () { //최근본상품 -1
        var self = this;

        common.ajax(
            common.util.getControllerUrl('getBeforeProductView', 'product'),
            {},
            '',
            function (response) {
                if(response.result == 'success'){
                    if(response.data != null){
                        $('#devBeforePrd').attr('src',response.data.image_src);
                        $('#devBeforePrd').attr('alt',response.data.pname);[]
                    }

                }

            }
        );

        // 추가확인 요망 (임시처리)
        if ($('#devQnaDetail').length > 0) {
            self.initAjaxQnaList(); //최초 세팅
        }

    },
    run: function () {
        var self = this;

        self.initMinicart();
        self.initEvent();
        self.initBeforeProduct();
    }
};

$(function () {
    goodsView.run();
});

function laundryChange(cid) {
	$.ajax({
		type: 'GET',
		url: '/customer/productPrecautions?mode=ajaxMoNew&cid='+cid,
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
        var item = $('#devOptionSelect').val();
    }else {
        var item = $('#devStyleSelect').val();
    }

    var city = $('#devCitySelect').val();

    var allData = { "city": city, "item": item };

    common.ajax(common.util.getControllerUrl('searchStore', 'product'), allData, "", function (result) {
        var data = $.parseJSON(result.data);
        if (data.res_cd == '0000') {
            $('#storeListCount').text(data.stock_list.length);

            $('#storeList').empty();

            var obj_table_text = "";
            for (var i = 0; i < data.stock_list.length; i++) {
                obj_table_text += "<li class='store-result__item'>";
                obj_table_text += "    <a href='/customer/storeInformation/" + data.stock_list[i].shop_cd + "' target='_blank'><div class='title-md'>" + data.stock_list[i].shop_nm + "</div></a>";
                obj_table_text += "    <p>" + data.stock_list[i].shop_addr + "</p>";
                obj_table_text += "</li>";
            }

            var newObj = $(obj_table_text);

            newObj.appendTo($('#storeList'));
        } else {
            alert('매장정보조회 API에 문제가 생겼습니다.');
        }
    })
}

function laundryTwoChange(val){
    var laundryTwoDepthOld =  $("#laundryTwoDepthOld").val();
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
                $(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("active");
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

function productWish(pid){
    if (forbizCsrf.isLogin) {
        if($('#wishCheckBox_'+pid).is(':checked')){
            var gubun = "N";
        }else{
            var gubun = "Y";
        }

        var allData = { "pid": pid, "type": gubun };
        common.ajax(common.util.getControllerUrl('wish', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                //$(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                //$(e).removeClass("active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=';
        }
    }
}

function focusIn(){
    $('#contentsPlace').css('display', 'none');
}

function focusOut(){
    $('#contentsPlace').css('display', '');
}
