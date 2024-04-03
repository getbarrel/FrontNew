/**
 * Created by forbiz on 2019-02-11.
 */
import productPrecautions from './customer_productPrecautions';
import claimGuide from './customer_cliamGuide';

const shop_goodsView = () => {
    const $window = $(window);
    const $document = $(document);

    const view_piz = () => {
        $.fn.picZoomer = function(options){
            var opts = $.extend({}, $.fn.picZoomer.defaults, options),
                $this = this,
                $picBD = $('<div class="picZoomer-pic-wp"></div>').css({'width':opts.picWidth+'px', 'height':opts.picHeight+'px'}).appendTo($this),
                $pic = $this.children('img').addClass('picZoomer-pic').appendTo($picBD),
                $cursor = $('<div class="picZoomer-cursor"><i class="f-is picZoomCursor-ico"></i></div>').appendTo($picBD),
                cursorSizeHalf = {w:$cursor.width()/2 ,h:$cursor.height()/2},
                $zoomWP = $('<div class="picZoomer-zoom-wp"><img src="" alt="" class="picZoomer-zoom-pic"></div>').appendTo($this),
                $zoomPic = $zoomWP.find('.picZoomer-zoom-pic'),
                picBDOffset = {x:$picBD.offset().left,y:$picBD.offset().top};

            opts.zoomWidth = opts.zoomWidth||opts.picWidth;
            opts.zoomHeight = opts.zoomHeight||opts.picHeight;
            var zoomWPSizeHalf = {w:opts.zoomWidth/2 ,h:opts.zoomHeight/2};

            $zoomWP.css({'width':opts.zoomWidth+'px', 'height':opts.zoomHeight+'px'});
            $zoomWP.css(opts.zoomerPosition || {top: 0, left: opts.picWidth+30+'px'});
            $zoomPic.css({
                'width':opts.picWidth*opts.scale+'px'
                //, 'height':opts.picHeight*opts.scale+'px'
            });

            $picBD.on('mouseenter',function(event){
                $cursor.show();
                $zoomWP.show();
                $zoomPic.attr('src',$pic.attr('data-big_img'))
            }).on('mouseleave',function(event){
                $cursor.hide();
                $zoomWP.hide();
            }).on('mousemove', function(event){
                picBDOffset = {x:$picBD.offset().left,y:$picBD.offset().top};
                var x = event.pageX-picBDOffset.x,
                    y = event.pageY-picBDOffset.y;

                $cursor.css({'left':x-cursorSizeHalf.w+'px', 'top':y-cursorSizeHalf.h+'px'});
                $zoomPic.css({'left':-(x*opts.scale-zoomWPSizeHalf.w)+'px', 'top':-(y*opts.scale-zoomWPSizeHalf.h)+'px'});

            });
            return $this;

        };
        $.fn.picZoomer.defaults = {
            picWidth: 520,
            picHeight: 736,
            scale: 2,
            zoomerPosition: {top: '0', left: '520px'} ,
            zoomWidth: 520,
            zoomHeight: 736
        };
    };

    const photo_box = () => {

        const slider = () => {
            const $target = $(".photo__slider");
            if($target.find(".photo__slider__item").length > 5) {
                $target.find(".photo__slider__nav").addClass("photo__slider__nav--show");
                const swiper = new Swiper($target.find('.swiper-container').get(0), {
                    //autoHeight: true,
                    direction : 'vertical',
                    slidesPerView : '5',
                    navigation: {
                        nextEl: '.photo__slider__nav--left',
                        prevEl: '.photo__slider__nav--right',
                    },
                });
                // $target.find(".photo__slider__inner").slick({
                //     infinite: true,
                //     slidesToShow: 5,
                //     slidesToScroll: 1,
                //     prevArrow: $target.find(".photo__slider__nav--left"),
                //     nextArrow: $target.find(".photo__slider__nav--right"),
                // });
            }
        };

        const isPlayer = () => {
            if($('.photo__slider__item--movie').length < 1) return ;

            const thumbVideo = {
                videoPlayer : null,
                type : "",     // "youtube" || "vimeo"
                url : "",
                regexYoutubId(url) {
                    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                    const match = url.match(regExp);
                    if ( match && match[7].length === 11 ){
                        return match[7];
                    }else{
                        alert("Could not extract video ID.");
                    }
                },
                init() {
                    const self = this;
                    this.url = $('#videoPlayer').data("url");   //임시
                    this.type = this.url.indexOf('youtube') != -1 ? "youtube" : "vimeo";

                    if ( this.type === "youtube" ) {
                        const tag = document.createElement('script');
                        tag.src = "//www.youtube.com/iframe_api";
                        const firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        window.onYouTubeIframeAPIReady = function() {
                            self.videoPlayer = new YT.Player("videoPlayer", {
                                "videoId": self.regexYoutubId(self.url)
                            });
                        };
                    } else if (this.type === "vimeo") {
                        self.videoPlayer = new Vimeo.Player('videoPlayer');
                    }
                    return self;
                },
                play() {
                    if ( this.type === "youtube" ) {
                        if(typeof this.videoPlayer.playVideo === 'function') {
                            this.videoPlayer.playVideo();
                        }
                    } else if (this.type === "vimeo") {
                        this.videoPlayer.play();
                    }
                },
                pause() {
                    if ( this.type === "youtube" ) {
                        if(typeof this.videoPlayer.playVideo === 'function') {
                            this.videoPlayer.pauseVideo();
                        }
                    } else if (this.type === "vimeo") {
                        this.videoPlayer.pause();
                    }
                },
                stop() {
                    if ( this.type === "youtube" ) {
                        if(typeof this.videoPlayer.playVideo === 'function') {
                            this.videoPlayer.stopVideo();
                        }
                    } else if (this.type === "vimeo") {
                        this.videoPlayer.stop();
                    }
                },
                run() {
                    this.init();
                    return this;
                }
            };
            window.thumbVideo = thumbVideo.run();

            $('.photo__main__video--player').off('click.videoPlayer')
                .on('click.videoPlayer', function() {
                    $(".photo__main__video").addClass("photo__main__video--show");
                    thumbVideo.play();
                    $(this).hide();
                });

            $document.on("click", ".photo__slider__item a", function(e) {
                e.preventDefault();
                const $this = $(this);
                const $target = $(".fb__goods-view__photo");

                if($this.hasClass('photo__slider__item--movie')) {
                    $(".photo__main__video").addClass("photo__main__video--show");
                    $('.photo__main__video--player').hide();
                    thumbVideo.play();
                }else {
                    // image
                    const $pic = $this.find('img');
                    const _pic_src = $pic.attr('src');

                    $target.find(".photo__main__video").removeClass("photo__main__video--show");
                    thumbVideo.pause();
                    $('.photo__main__video--player').show();

                    $target.find(".photo__main__pic img").attr("src", _pic_src);
                }
            });
        };

        const changeBigImg = () => {
            const $target = $(".photo__main__pic").find("img");

            $document.on("click",".photo__slider__item", function(){

                const $this = $(this);
                const $bigImg = $target.find('.picZoomer-zoom-pic');
                const $siblings = $this.closest('.swiper-slide').siblings().find('.photo__slider__item');
                let _imgAttr = '';

                if ($this.find("img").attr("data-big_img")) {
                    _imgAttr = $this.find("img").attr("data-big_img");

                } else {
                    _imgAttr = $this.find("img").attr("src");

                }

                $target.attr("src", _imgAttr);
                $bigImg.attr("src", _imgAttr);
                $(".picZoomer-pic").attr("data-big_img", _imgAttr);

                $this.addClass("photo__slider__item--active");
                $siblings.removeClass('photo__slider__item--active');

            })
        }

        // const thumbImg = () => {
        //     const $target = $(".photo__slider").find(".swiper-slide");
        //
        //     $document.on("click",$target, function() {
        //         $(this).find(".photo__slider__item").addClass("");
        //     });
        // }

        const photo_box_fn = () => {
            slider();
            isPlayer();
            changeBigImg();
            // thumbImg();
        };

        photo_box_fn();
    };

    const tab_menu = () => {
        // const $target = $(".fb__goods-view__detail detail");
        const tab_list = [];
        let checkClick = true;
        let clickScroll = false;

        $(".detail__main__tab-list").each(function(){
            let _href = $(this).attr("href");

            tab_list.push(_href);
        });

        if (checkClick == false){
            const $targetContent = $('.detail__main__tab-content').find('#devTapDetail');
            $targetContent.addClass("view-detail--show");

        }

        $document.on("click", ".detail__main__tab-list", function(){
            if($('html,body').is(':animated')) return;
            checkClick=true;
            const href = $(this).attr("href");
            const _tabmenuH = $(".detail__main__tab-menu").height();
            const _headerH = $("#navigation").height();
            const _targetH = $('.detail__main__tab-content').find(href).offset().top;

            $("a[href='"+href+"']").addClass("detail__main__tab-list--on")
                .siblings().removeClass("detail__main__tab-list--on");

            clickScroll = true;

            $('html,body').animate({
                scrollTop: _targetH - _tabmenuH - _headerH
            }, 600, function() {
                setTimeout(function() {
                    clickScroll = false;
                }, 100);
            });

            return false;
        });

        $window.on("scroll",function(){
            if($('html,body').is(':animated') || clickScroll) return;
            tab_list.some(function(idx){
                let $thisTab = $(idx);
                const sumScrollTop = $thisTab.offset().top - $("#header").height() -  $(".detail__main__tab-menu").height() + $thisTab.height() -100;

                if ($window.scrollTop() <= sumScrollTop) {
                    $("a[href='"+idx+"']").addClass("detail__main__tab-list--on")
                        .siblings().removeClass("detail__main__tab-list--on");
                    return true;
                }
            });
        });

    };

    const fixed_aside = () => {
        const $targetFix = $('.detail__main__tab-menu--fixed');
        const $detail = $('.fb__goods-view__detail');
        const $header = $('.fb__main_nav');
        const $tabmenu = $('.detail__main__tab-menu');

        $tabmenu.css('height',$('.detail__main__tab-menu--fixed').height()); //fixed 영역만큼 크기 부여

        $('.detail__main__tab-menu').css('height', $('.detail__main__tab-menu--fixed').height()); //fixed 영역만큼 크기 부여

        $window.on("scroll resize load", function(){
            if ($window.scrollTop() > $detail.offset().top - $header.height()){
                $targetFix
                    .addClass("detail__aside--fixed")
                    .css({
                        "top" : $header.height()
                    });

            } else {
                $targetFix
                    .removeClass("detail__aside--fixed")
                    .css({
                        "top" : "",
                    });
            }
        });
    };

    // qna 아코디언
    const list_show = () => {
        const $target = $(".tab-qna__row-detail");
        let slideCheck = "up";
        common.lang.load('read.user.check.alert', '비밀글은 작성자만 조회할 수 있습니다.');
        $document.on("click", ".tab-qna__row", function(){
            const $this = $(this);

            if(!$this.data('issameuser') && $this.data('ishidden')) {
                // 내 글이 아니고 비밀글일 경우
                alert(common.lang.get('read.user.check.alert'));
                return;
            }  else {
                if (slideCheck == "up") {
                    $this.next($target).slideDown("fast");
                    slideCheck = "down";
                } else {
                    $this.next($target).slideUp("fast");
                    slideCheck = "up";
                }
            }
        });

    };

    /* @TODO 사용하는 스크립트 인지 체크 */
    const ifLogin = () => {
        if (forbizCsrf.isLogin) {
            $(".noLogin").css({
                "display" : "none" ,
            });
            $(".isLogin").css({
                "display" : "inline-block",
            });

        } else {
            $(".isLogin").css({
                "display" : "none" ,
            })
            $(".noLogin").css({
                "display" : "inline-block",
            })
        }
    };

    const lazyload = () =>{
        /*
         * {layoutCommon.templetSrc}/images/common/loading.gif 로딩 이미지 샘플
         * attribute : data-src
         * */
        const $target = $('img[data-src]');
        $target.Lazy({
            threshold: 50
        });


    }

    //'다른 고객님이 구매한 상품' 슬라이더
    const recommendSlide = () => {
        const $slider = $('.goods__slider__wrap');
        //if($slider.find('.fb__goods__list').length <= 5) return;
        $slider.each(function(){
            if($slider.find('.goods__swiper__inner').length > 3) {
                const _sliderType = $(this).hasClass('goods__slider__wrap--left') ? "left" : "right";
                const _slide = new Swiper($(this).find('.swiper-container').get(0), {
                    slidesPerView : 3,
                    spaceBetween: 25,
                    navigation: {
                        prevEl: `.goods__slider__wrap--${_sliderType} .swiper-button-prev`,
                        nextEl: `.goods__slider__wrap--${_sliderType} .swiper-button-next`,
                    },
                });
            }
        });
    }

    const main_new = () => {// 메인페이지 슬라이드 복사
        $(".newSlider .mainSlider__page__total").html($(".newSlider .newSlider__list").length);
        const new_swiper = new Swiper('.newSlider__slider', {
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.newSlider .mainSlider__dot',
                clickable: true,
            },
            navigation: {
                nextEl: '.newSlider .mainSlider__arrow--next',
                prevEl: '.newSlider .mainSlider__arrow--prev',
            },
        });

        new_swiper.on('slideChangeTransitionEnd', function () {
            $(".newSlider .mainSlider__page__now").html(new_swiper.realIndex + 1);
        });

        $document.on("click", ".newSlider .mainSlider__auto", function(e) {
            e.preventDefault();
            const $this = $(this);
            if($this.hasClass("mainSlider__auto--play")) {
                $this.removeClass("mainSlider__auto--play");
                new_swiper.autoplay.start();
            } else {
                $this.addClass("mainSlider__auto--play");
                new_swiper.autoplay.stop();
            }
            return false;
        });
        //new_swiper.autoplay.stop();
    };

    const claimTabEvent = () => {
        $('.goods-tabs__box a').on('click', function(e) {
            e.preventDefault();
            const $this = $(this);
            $this.closest('.goods-tabs__box').addClass('goods-tabs__box--active')
                .siblings().removeClass('goods-tabs__box--active');
            $('.goods-tabs').find($this.attr('href')).addClass('goods-tabs__content__box--show')
                .siblings('.goods-tabs__content__box').removeClass('goods-tabs__content__box--show');

            $window.scrollTop($('.detail__main__tab-menu').offset().top);
        });
    }

    // 타임세일
    const timesaleLoop = () => {
        const $time = $('.time-sale__countdown em');
        if ($time.text().length < 1) return ;

        // 테스트 고정값 1분 10초
        //$time.text('70');  
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

    // sns 공유하기
    const showSnsLayer = () => {
        $('.btn-share').on('click', function(e) {
            e.stopPropagation();
            $('.layer-share').addClass('layer-share--show');
        });
        $('.layer-share__close').on('click', function() {
            $('.layer-share').removeClass('layer-share--show');
        });
        $('.layer-share').on('click', function(e) {
            e.stopPropagation();
        });
        $('body').on('click', function() {
            $('.layer-share').removeClass('layer-share--show');
        });
    }

    //사은품 증정
    const goodsGift = () => {
        const giftWrap = $(".goods-detail__acco__wrap");
        $(".goods-detail__acco__btn").on("click", function() {
            if (giftWrap.is(":visible") == false) {
                giftWrap.addClass("goods-detail__acco__wrap--active");
                $(this).removeClass("changed");

            } else {
                giftWrap.removeClass("goods-detail__acco__wrap--active");
                $(this).addClass("changed");
            }
        });
    }

    //세탁 및 주의사항 불러오기
    const customerScript = () => {
        productPrecautions();
    }

    const size_guide = () => {
        $document.on("click",".js__goods-view__size", function(){
            const _size_top = $(".js__size__box").offset().top;
            $window.scrollTop(_size_top);

        });
    }

    //교환 반품안내 불러오기
    const claimScript = () => {
        claimGuide();
    }

    // 상품후기 별
    const reviewStar = () => {
        const $target = $('.goods-info__review__star--point span');
        $target.css('width', $target.data('widths') + '%' );

        // let _text = Number($('.goods-info__review__star--number').text().replace(/(\[|\]|\s)/g, '')) * 0.1;
        // if(_text < 10) {
        //     _text = _text.toFixed(1);
        // }
        // $('.goods-info__review__star--number').text(' ' + _text + ' ');
    }

    const reviewLink = () => {
        const $targetLink = $(".tab-review");
        $(document).on("click", ".info__review__btn", function(e) {
            $targetLink.trigger("click");
            e.preventDefault();
        });
    }

    const benefitPopup = () => {
        const $popupInner = $(".benefit__popup");
        $document.on("click", ".info__benefit", function() {
            $popupInner.show();
        });
        $document.on("click", ".benefit__popup__btn", function() {
            $popupInner.hide();
        });
    }

    // 입고알림 내용 이벤트
    const stockAlarmEvent = () => {
        $(document).on('change', '.goods-alarm__phone__check input[type=checkbox]', function() {
            if($(this).prop('checked')) {
                $('.goods-alarm__phone__new').find('select, input').attr('disabled', false);
            }else {
                $('.goods-alarm__phone__new').find('select, input').attr('disabled', true);
            }
        });
    };

    const minicart_del = () => {
        $document.on("click", ".info__decided__del", function(){

        })
    };

    // 장바구니 버튼 클릭이벤트
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

    const view_init = () => {
        view_piz();
        photo_box();
        //info_popup();
        tab_menu();
        fixed_aside();
        list_show();
        ifLogin();
        lazyload();
        recommendSlide();
        main_new();
        claimTabEvent();
        timesaleLoop();
        showSnsLayer();
        goodsGift();
        // window.imageLayer_slide = imageLayer_slide;
        customerScript();
        size_guide();
        claimScript();
        reviewStar();
        reviewLink();
        benefitPopup();
        recommendSlide();
        stockAlarmEvent();
        minicart_del();
        btnCart();
    };

    view_init();
}

export default shop_goodsView;