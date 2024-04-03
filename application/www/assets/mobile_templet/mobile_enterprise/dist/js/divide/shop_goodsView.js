/**
 * Created by forbiz on 2019-07-11.
 */
const shop__goodsView = () => {
    const $window = $(window);
    const $document = $(document);
    //common.util.modal.open('html', '약관보기', $term_popup.html());
    // 메인 슬라이드
    const goodsMainSlide = () => {
        if( $('.goods-thumb__box').length < 2) return ;
        const $container = $('.br__goods-view__thumb .swiper-container')[0];

        const $slider = new Swiper($container, {
            //loop : true,
            speed : 700,
            // autoplay : {
            //     delay: 3000,
            //     disableOnInteraction : false
            // },
            pagination : {
                el : '.swiper-pagination',
                type : 'fraction'
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        $('.swiper-button-next, swiper-button-prev').on('click', function(e) {
           e.stopPropagation();
        });


        const video_fn = () => {
            const $video_target = $("#js__video__target");

            if ($video_target.length < 1) return ;

            let vimeoPlayer;

            const _id = 'js__video__target';
            const _url = $video_target.data("movie");
            const _videoType = _url.indexOf('youtube') !== -1 ? "youtube" : "vimeo";

            if( _videoType === "youtube" ) {
                const tag = document.createElement('script');
                tag.src = "//www.youtube.com/iframe_api";
                const firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                const regexYoutubId = (url) => {
                    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                    const match = url.match(regExp);
                    if ( match && match[7].length === 11 ){
                        return match[7];
                    }else{
                        alert("Could not extract video ID.");
                    }
                };

                window.onYouTubeIframeAPIReady = function() {
                    self.videoPlayer = new YT.Player("js__video__target", {
                        "videoId": regexYoutubId(_url) + '?enablejsapi=1&origin=' + location.href
                    });
                };
            }else if( _videoType === "vimeo" ) {
                const _options = {
                    "url" : _url,
                    "width" : "100%"
                };

                vimeoPlayer = new Vimeo.Player(_id, _options);
            }
        }

        video_fn();

    }

    // 상품상세 tabs
    const detailTabs = () => {
        const $tabArea = $('.goods-tabs');
        const $contArea = $('.goods-tabs__cont');
        // 탭 클릭 이벤트
        const tabEvent = () => {
            $tabArea.on('click', '.goods-tabs__btn', function(e) {
                e.preventDefault();
                const $this = $(this);
                const tab_offset_top = $tabArea.offset().top;
                const _targetClass = $this.attr('href').replace('#','');
                $tabArea.find('.goods-tabs__btn').removeClass('goods-tabs__btn--active');
                $this.addClass('goods-tabs__btn--active');
                $contArea.removeClass('goods-tabs__cont--show')
                    .filter(`.${_targetClass}`).addClass('goods-tabs__cont--show');
                $window.scrollTop(tab_offset_top - $tabArea.height());
            });
        }
        const tab_menu = () => {
            const $target = $(".br__goods-view__tabs");
            const tab_list = [];
            let checkClick = true;

            $(".goods-tabs__btn").each(function(){
                let _href = $(this).attr("href");

                tab_list.push(_href);
            });

            if (checkClick == false){
                const $targetContent = $('.detail__main__tab-content').find('#devTapDetail');
                $targetContent.addClass("view-detail--show");

            }

            $document.on("click", ".goods-tabs__btn", function(){
                if($('html,body').is(':animated')) return;
                checkClick=true;
                const href = $(this).attr("href");
                const $tabmenu = $(".goods-tabs__cont");
                const $targetContent = $tabmenu.find(href);

                $(".goods-tabs__btn").removeClass("goods-tabs__btn--active")
                    .filter(this).addClass("goods-tabs__btn--active");
                const _resultState = $window.scrollTop() > $($targetContent).offset().top ? $('.br__header').outerHeight() : 0;
                $('html,body').stop().animate({
                    scrollTop: $($targetContent).offset().top - _resultState - $(".goods-tabs").height() + 1
                }, 600);

                return false;
            });


            $window.on("scroll",function(){
                if($('html,body').is(':animated')) return;

                tab_list.some(function(idx){
                    let $target = $(idx).closest(".goods-tabs__cont");
                    const sumScrollTop = $target.offset().top + $target.outerHeight() - $('.goods-tabs__list').position().top -$('.goods-tabs__list').outerHeight();

                    if ($window.scrollTop() <= sumScrollTop ) {
                        $("a[href='"+idx+"']").addClass("goods-tabs__btn--active")
                            .parents().siblings().find("a").removeClass("goods-tabs__btn--active");
                        return true;
                    }
                });
            });

        }
        // 탭 상단고정
        const tabFixed =() => {
            const $tabBox = $('.goods-tabs__list');
            let last_scroll_t = $window.scrollTop();
            $window.on('scroll', function(e) {
                const header_h = $('.br__header').height();
                const _win_t = $window.scrollTop();
                const tab_offset_top = $tabArea.offset().top;

                if( $tabBox.hasClass('goods-tabs__list--fixed') ){
                    if( tab_offset_top - header_h + parseInt($('.br__header').css("margin-top")) < _win_t) {
                        $tabBox.addClass('goods-tabs__list--fixed');
                    } else{
                        $tabBox.removeClass('goods-tabs__list--fixed');
                    }
                    if( $('.br__header').hasClass('up')) {
                        $tabBox.css({
                            'top': header_h
                        });
                    }else {
                        $tabBox.css({
                            'top': ''
                        });
                    }
                }else {
                    if( tab_offset_top < _win_t) {
                        $tabBox.addClass('goods-tabs__list--fixed');
                    } else{
                        $tabBox.removeClass('goods-tabs__list--fixed');
                        $tabBox.css({
                            'top': ''
                        });
                    }
                }

                last_scroll_t = _win_t;


            });
        }

        const detailTabs_init = () => {
            //tabEvent();
            tab_menu();
            tabFixed();
        }
        detailTabs_init();
    }



    // 타임세일
    const timesaleLoop = () => {
        const $time = $('.time-sale__countdown span');
        if ($time.text().length < 1) return ;

        const _saleTime = [
            Math.floor($time.text() / 3600),        //시간
            Math.floor($time.text() % 3600 / 60),   //분
            $time.text() % 3600 % 60,   //초
        ];

        // 시간 정제 ( 시간 앞에 '0' )
        const timeScale = arrTime => {
            return arrTime.map((_this, idx, arr) => {
                    if(arr[idx] < 10 ) {
                arr[idx] = '0' + parseInt(arr[idx]);
            }
            return arr[idx];
            });
        }
        // 시간 변화 실행
        const changeTime = (arrTime, state) => {
            arrTime = arrTime.map((_this, idx, arr) => {
                return parseInt(arr[idx]);
                });
            if(state) {
                if(--arrTime[2] < 0) {
                    // 초
                    arrTime[2] = 59;
                    if(--arrTime[1] < 1){
                        // 분
                        if(arrTime[0] <= 0) {
                            arrTime[1] = 0;
                        }else {
                            arrTime[1] = 59;
                        }

                        // 시
                        if(arrTime[0] <= 0) {
                            arrTime[0] = 0;
                        }else {
                            --arrTime[0];
                        }

                    }
                }
            }
            return arrTime;
        }

        let _lastSec = new Date().getSeconds(); // 최초 초 단위 체크
        let initFlag = true;
        // 초 변화 체크 및 입력
        const setInter = setInterval(function() {
            let arrTime;
            if(initFlag) {
                arrTime = _saleTime;
                initFlag = false;
            }else {
                arrTime = $time.html().split(' : ');
            }
            const _currentSec = new Date().getSeconds();    // 현재 초 단위 체크

            // 초 단위 변화 flag
            let _changeSec;
            if(_currentSec < _lastSec) {
                _changeSec = true;
            } else {
                _changeSec = _currentSec > _lastSec ? true : false;
            }
            arrTime = changeTime(arrTime, _changeSec);

            // 00 : 00 : 00 일경우 정지
            if(arrTime[0] == 0 && arrTime[1] == 0 && arrTime[2] == 0) {
                clearTimeout(setInter);
                alert('타임세일이 종료되었습니다.');
                window.location.reload();
            }
            arrTime = timeScale(arrTime);

            _lastSec = _currentSec;
            $time.html(arrTime.join(' : '));

            if(!$time.parent().hasClass('time-sale__countdown--show')) $time.parent().addClass('time-sale__countdown--show');
        }, 500);
    }

    // 입고신청알림
    const goodsAlarm = () => {
        const $body = $('#shop_goodsView');

        // 팝업 커스텀을 위한 콜백
        const goodsAlarmCallback = () => {
            $body.find('.popup-layout').addClass('goods-alarm__layer');
            $body.find('.popup-layout .close, .popup-mask').off('click.removeAlarm')
                .one('click.removeAlarm', function() {
                    $body.find('.popup-layout').removeClass('goods-alarm__layer');
                });
            $('.goods-alarm__phone__check input').trigger('change.changePhone');
        }
        window.goodsAlarmCallback = goodsAlarmCallback;

        // $body.on('click', '.goods-alarm__options__btn', function() {
        //     if($(this).prop('disabled')) return;
        //     $('.goods-alarm__options__btn').removeClass('goods-alarm__options__btn--active');
        //     $(this).addClass('goods-alarm__options__btn--active');
        // });

        $body.on('change.changePhone', '.goods-alarm__phone__check input[type=checkbox]', function() {
            if(!$(this).prop('checked')) {
                $body.find('.goods-alarm__phone__new select,.goods-alarm__phone__new input')
                    .prop('disabled', true)
                    .attr('disabled', true);
            }else {
                $body.find('.goods-alarm__phone__new select,.goods-alarm__phone__new input')
                    .prop('disabled', false)
                    .attr('disabled', false);
            }
        });

    }

    //혜택내역 팝업
    const layerbenefitList = () => {
        common.lang.load('goodsView.bnenfitList.popupTitle', '혜택내역');
        $('.goods-info__benefit-list').on('click', function() {
               //common.util.modal.open("html", common.lang.get('goodsView.bnenfitList.popupTitle'), $('.layer__benefit-list').remove().clone());
        });
    }

    // 매장안내 full layer
    const storeGuide = () => {
        const $body = $('#shop_goodsView');

        // 팝업 커스텀을 위한 콜백
        const storeGuideCallback = () => {
            $body.find('.popup-layout').addClass('popup-layout--full');
            $body.find('.popup-layout .close, .popup-mask').off('click.removeStoreGuide')
                .one('click.removeStoreGuide', function() {
                    $body.find('.popup-layout').removeClass('popup-layout--full');
                });
        }
        window.storeGuideCallback = storeGuideCallback;
    }

    // 상품 Q&A full layer
    const goodsQnaWrite = () => {
        const $body = $('#shop_goodsView');

        // 팝업 커스텀을 위한 콜백
        const goodsQnaCallback = () => {
            $body.find('.popup-layout').addClass('popup-layout--full');
            $body.find('.popup-layout .close, .popup-mask').off('click.removeGoodsQnAWrite')
                .one('click.removeGoodsQnAWrite', function() {
                    $body.find('.popup-layout').removeClass('popup-layout--full');
                });
        }
        window.goodsQnaCallback = goodsQnaCallback;
    }

    // 공유하기
    const goodsShare = () => {
        $('.goods-info__btns__share').on('click', function() {
            common.util.modal.open('html', '', $('.layer-share').html());
        });
    }

    // 교환/반품 탭 팝업
    const goodsClaimPop = () => {
        $('.goods-notice__btn').on('click', function() {
            const name = $(this).attr('class').replace(/.*--/,'');
            $('body').find('.popup-layout').addClass('slide-animation-modal');
            $('.popup-mask').css("background", "transparent")
            common.util.modal.open('html', $(this).text(), $(`#pop-${name}`).clone(), '', window.popupLayerFullSize);
        });
    }

    // 상품상세 토글 모음
    const goodsViewToggle = () => {
        // 아코디언 토글
        const toggleAccodion = () => {
            $('.goods-detail').on('click', '.goods-detail__acco__btn', function() {
                $(this).toggleClass('goods-detail__acco__btn--show');

            }).trigger('click');
        }

        // 상품리뷰 토글
        const reviewAccodion = () => {
            common.lang.load('read.user.check.alert', '비밀글은 작성자만 조회할 수 있습니다.');
            $('.goods-qna').on('click', '.qna-info', function() {
                const $parentBox = $(this).closest('.goods-qna__box');
                if($parentBox.hasClass('goods-qna__box--secret')){
                    $(this).closest('.goods-qna__box').removeClass('goods-qna__box--show');
                    frontAlert.open('',common.lang.get('read.user.check.alert'), false);
                }else {
                    // 오픈 문의, 내 문의
                    $(this).closest('.goods-qna__box').toggleClass('goods-qna__box--show');

                }

            })
        }

        /* 미니카트 스크롤 문제로 보여 주석처리(추후 논의 필요) */
        //미니카트 선택한 옵션있을 때 스크롤 최하단으로 포커싱
        // const minicart_focus = () => {
        //     const $minicart = $('.mini-cart');
        //     $document.on("click", function(e){
        //         if ($minicart.hasClass("devOpened") && $("#devMinicartSelected").length > 0) {
        //             const $scrollArea = $(".br__goods-view__information");
        //             let _scrollBottom = $scrollArea.outerHeight();
        //             $scrollArea.scrollTop(_scrollBottom);
        //         }
        //     })
        // }

        // 미니카트 토글
        const minicartToggle = () => {
            const $wrap = $('.br__goods-view__minicart');
            $('.br__goods-view__minicart--toggle, .br__goods-view__minicart--dimmed')
                .on('click', function(e) {
                    e.stopPropagation();
                    if( $wrap.hasClass('br__goods-view__minicart--show') ) {
                        bodyScroll.release();
                        $wrap.removeClass('br__goods-view__minicart--show');
                    }else {
                        bodyScroll.fix();
                        $wrap.addClass('br__goods-view__minicart--show');
                    }
            });
        }

        const toggle_init = () => {
            toggleAccodion();
            reviewAccodion();
            //minicart_focus();
            //minicartToggle();
        }
        toggle_init();
    }

        //상품후기 별 너비
    const reviewStar = () => {
        const $target = $('.goods-info__review__star--point span');
        $target.css('width', $target.data('widths') + '%' );

        // let _text = Number($('.goods-info__review__star--number').text().replace(/(\[|\]|\s)/g, '')) * 0.1;
        // if(_text < 10) {
        //     _text = _text.toFixed(1);
        // }
        // $('.goods-info__review__star--number').text('[ ' + _text + ' ]');
    }

    const guideTabEvent = () => {
        const toggleCliam = () => {
            $(document).on('click', '.claim__title', function(){
                const $title = $('.claim__title');
                const $cont = $('.claim__content');
                const $nextCont = $(this).next();

                $title.removeClass('active');
                $cont.slideUp();

                if($nextCont.is(':visible')){
                    $nextCont.slideUp();
                    $(this).removeClass('active');
                }else{
                    $nextCont.slideDown();
                    $(this).addClass('active');
                }
            });
        }
        const productPrecautions_category = () => {
            $document.on("click", ".wash__category-link", function() {
                const $this = $(this);

                $(".wash__category-link").removeClass("wash__category-link--active");
                $this.addClass("wash__category-link--active");
                $("section[class^=wash__contents-]").removeClass("wash__contents__category--show");
                $(".wash__contents__category").removeClass("wash__contents__category--show");
                $this.addClass("wash__contents__category--show");
                $(`.wash__contents-${$this.attr("data-target")}`).addClass("wash__contents__category--show");

            });
        };

        const productPrecautions_contents = () => {
            $document.on("click", ".contents__tab-link", function(){
                const $this = $(this);
                $this.parent().find(".contents__tab-link").removeClass("contents__tab-link--active");
                $this.addClass("contents__tab-link--active");
                $this.parents(".wash__contents__category").find(".contents__box-detail").removeClass("contents__box-detail--show");
                $this.parent().next().find(`.contents__box-${$this.attr("data-target")}`).addClass("contents__box-detail--show");
            });
        }

        const guideTabEvent_init = () => {
            toggleCliam();
            productPrecautions_category();
            productPrecautions_contents();
        }

        guideTabEvent_init();
    }

    //추가 옵션상품 탭
    const productOptionList = () => {
        $(".minicart").on("click", '.goods-option__title', function(){
            $(".goods-option").toggleClass("goods-option--active");
        });
    }

    //추가 옵션 상품 있을 경우 미니카트에서 추가옵션 펼쳐 보이기
    const addOption = () => {
        $('.goods-option--add').on('change', 'select', function () {
            if(!!$(this).val()) {
                // 값이 있는 경우
                $('.minicart .goods-option').addClass('goods-option--active');
            }
        });
    }

    // 가이드 버튼
    const goToSizeGuide = () => {
        $('.br__goods-view').on('click', '.goods-info__size__guide', function() {
            //console.log('a');
            const $this = $(this);
            const _productId = $('.crema-fit-product-size-summary').attr('data-product-code');
            const _currentUrl = location.href;
            //console.log()
            if( $this.closest('.br__goods-view__minicart').length > 0 ){
                $('.br__goods-view__minicart--toggle').trigger('click');
            }
            $('html, body').animate({
                scrollTop : $('.goods-crema').offset().top
            });
        });
    }

    const reviewLink = () => {
        const $target = $(".goods-tabs__review").find(".goods-tabs__btn");
        $document.on("click",".goods-info__review__btn",function() {
            //$(".devReviewDetailTabs").trigger("click");
            $(window).scrollTop($("#goods-review").offset().top);
        });
    }

    const btnCart = () => {

        // $document
        //     .on("click", ".btn-lg--cart", function () {
        //         const $cartMsg = $(".cart-msg");
        //
        //         $cartMsg.addClass('cart-msg--show')
        //     });

        $document.on("click", ".devAddCart__layer__close, .devAddCart__layer__btn .btn-dark", function() {
            // $(".devAddCart__layer").removeClass("devAddCart__layer--show");
            window.location.reload();
            return false;
        });

    }

    const qaPlaceholder = () => {
        $(document)
            .off('focus.qaPlaceholder')
            .on('focus.qaPlaceholder', '.write-form__content #devQnaContents', function() {
                $(this).siblings().hide();
        });
        $(document)
            .off('focus.qaPlaceholder')
            .on('blur.qaPlaceholder', '.write-form__content #devQnaContents', function() {
                if(!this.value.length)
                    $(this).siblings().show();
        });
    }

    const shop__goodsView_init = () => {
        goodsMainSlide();
        detailTabs();
        timesaleLoop();
        goodsViewToggle();
        layerbenefitList();
        goodsAlarm();
        storeGuide();
        goodsQnaWrite();
        goodsShare();
        goodsClaimPop();
        reviewStar();
        guideTabEvent();
        productOptionList();
        addOption();
        goToSizeGuide();
        reviewLink();
        btnCart();
        qaPlaceholder();
        // tab_menu();
    }
    shop__goodsView_init();
}


export default shop__goodsView;
