/**
 * Created by forbiz on 2019-06-26.
 */
const front_layout = () => {
    const $window = $(window);
    const $document = $(document);

    // drawer 메뉴
    const drawer = () => {
        const $drawer = $('.br__drawer');
        const drawer_open = () => {
            $document.on('click','.br__header .inner__menu, .dockbar-list__btn--category', function() {
                $drawer.addClass('br__drawer--show');
                bodyScroll.fix();
            });
        }

        const drawer_close = () => {
            $document.on('click','.br__drawer__close', function() {
                $drawer.removeClass('br__drawer--show');
                bodyScroll.release();
            });
        }

        const drawer_menu = () => {
            const $menu = $('.br__drawer__menu');
            $drawer.on('click', '.br__drawer__menu--resize', function() {
                $menu.toggleClass('br__drawer__menu--folding');
            });
            $drawer.on('change', '.drawer__menu__list--withbarrel select', function() {
                location.href = $(this).val();
            });
        }
        const drawer_global = () => {
            const $select_btn = $('.global-box__select').find('.global-box__select__btn');
            const $select_list = $('.global-box__select').find('.global-box__select__list');
            $drawer.on('click', '.global-box__select__btn', function() {
                $select_btn.toggleClass('global-box__select__btn--show');
                if($select_btn.hasClass('global-box__select__btn--show')) {
                    $select_list.addClass('global-box__select__list--show');
                } else {
                    $select_list.removeClass('global-box__select__list--show');
                }

            });
        }

        const drawer_cate = () => {
            const $menu = $drawer.find('.br__drawer__cate');
            $menu.on('click', '.cate-box__list a', function (e) {
                e.stopPropagation();
            });
            $menu.on('click', '.cate-box--depth1 .cate-box__list', function () {
                var depth = $(this).attr('data-depth');
                var cid = $(this).attr('data-cid');

                $('.cate-box--depth1').removeClass('cate-box--active');
                $('#' + cid).addClass('cate-box--active');
                $('.cate-box--depth2').removeClass('slide-right');
                $('.cate-box--depth2.cate-box--active').addClass('slide-left');
            });

            $menu.on('click', '.cate-box--depth2 .cate-box__list', function () {
                var depth = $(this).attr('data-depth');
                var cid = $(this).attr('data-cid');

                $('.cate-box--depth2').removeClass('cate-box--active');
                $('#' + cid).addClass('cate-box--active');
                $('.cate-box--depth3').removeClass('slide-right');
                $('.cate-box--depth3.cate-box--active').addClass('slide-left');
            });

            $menu.on('click', '.cate-box__go__main', function () {
                $(this).parent().parent().removeClass('cate-box--active');
                $('.cate-box--depth1').addClass('cate-box--active');
            });

            $menu.on('click', '.cate-box__go__cate', function () {
                var cid = $(this).attr('data-cid');

                $(this).parent().parent().removeClass('cate-box--active');
                $('#' + cid).addClass('cate-box--active');
            });

            $menu.on('click', '.cate-box__navi__back', function () {
                var depth = $(this).parent().parent().attr('data-depth');

                if(depth == '0'){
                    $(this).siblings('.cate-box__go__main').click();
                    $('.cate-box').removeClass('slide-left');
                    $('.cate-box--depth1').addClass('slide-right');
                }else{
                    $(this).siblings('.cate-box__go__cate').click();
                    $('.cate-box').removeClass('slide-left');
                    $('.cate-box--depth2').addClass('slide-right');
                }
            });
        }

        const drawer_init = () => {
            drawer_open();
            drawer_close();
            drawer_menu();
            drawer_global();
            drawer_cate();
        }
        drawer_init();
    }

    // 헤더, 푸터 스크롤 이벤트
    const layoutScroll = () => {
        const $header = $('.br__header');
        const $footer = $('.br__dockbar');
        const $floatingMenu = $('.br__floating-btn');
        let lastScrollTop = $window.scrollTop();

        const checkState = _scrollTop => {
            const _gap = $window.height()/3;

            // #6333 스크롤다운 이후 최상단으로 이동했을때 header 노출 안되는 문제 > 'scrollTop'이 0이 아닐때만 내부 조건문 실행되고, 0인 경우에는 header, footer 무조건 노출되도록 처리
            if(window.scrollY !== 0) {

                if(_scrollTop <= _gap) return false;

                const endScroll = $('body').height() - $window.height();

                if(_scrollTop < lastScrollTop || endScroll < _scrollTop) {
                    // UP
                    $header.addClass('up').removeClass('down').css({
                        'margin-top':''
                    });

                    $(".br__header__inner").css({
                        'margin-top': ''
                    });
                    $footer.css({
                        'margin-bottom':''
                    });
                    $floatingMenu.css({
                        'margin-bottom':''
                    });
                    //console.log("Go up");
                    // $("body").prepend("<div>" + $(".br__header__inner").css("marginTop") + "</div>")
                }else {
                    // DOWN
                    $header.addClass('down').removeClass('up').css({
                        'margin-top': - $header.height()
                    });
                    $(".br__header__inner").css({
                        'margin-top': - $(".br__header__inner").outerHeight()
                    });
                    $footer.css({
                        'margin-bottom': - $footer.height()
                    });
                    $floatingMenu.css({
                        'margin-bottom': - $footer.height()
                    });
                    //console.log("Go down");
                    // $("body").prepend("<div>" + $(".br__header__inner").css("marginTop") + "</div>");

                }
            } else {

                $header.addClass('up').removeClass('down').css({
                    'margin-top':''
                });

                $(".br__header__inner").css({
                    'margin-top': '',
                });
                $footer.css({
                    'margin-bottom':''
                });
                $floatingMenu.css({
                    'margin-bottom':''
                });

            }

        }


        const scrollEvent = () => {
            $window.on('scroll.layoutScroll', function() {
                const currentScrollTop = $window.scrollTop();

                checkState(currentScrollTop);

                lastScrollTop = currentScrollTop;


            });

            $window.on("scroll", function() {
                const $headerTop_banner = !!$(".header__banner").height() ? $(".header__banner").height() : 0;
                const _win_t = $window.scrollTop();
                const $target = $(".br__header__inner");
                if(_win_t >= $headerTop_banner) {
                    $target.addClass("br__header__inner--fixed");
                } else {
                    $target.removeClass("br__header__inner--fixed");
                }
            })
        }

        const layoutScroll_init = () => {
            scrollEvent();
        }
        layoutScroll_init();

    }

    //footer
    const footer = () => {
        $('.br__footer .information__btn').on('click', function(e){
            $('.br__footer__info').toggleClass('br__footer__info--toggle');
        });

        $('.br__footer__gdweb a').on('click', function(e) {
            e.preventDefault();

            $('.gdweb__wrap').addClass('gdweb__wrap--show');
            window.bodyScroll.fix();

            $('.gdweb__dimmed, .gdweb__popup__close').one('click', function() {
                $('.gdweb__wrap').removeClass('gdweb__wrap--show');
                $('.gdweb__dimmed, .gdweb__popup__close').off('click');
                window.bodyScroll.release();
            });
        });
    }

    const topBanner = () => {

        // let swiper;
        // const lookbook_slider = () => {
        //     swiper = new Swiper('.lookbook__slider', {
        //         loop: true,
        //         pagination : {
        //             el: '.swiper-pagination',
        //             type : 'fraction',
        //             renderFraction : function (currentClass, totalClass) {
        //                 return `[ <span class="${currentClass}"></span> / <span class="${totalClass}"></span> ]`;
        //             }
        //         },
        //         navigation : {
        //             nextEl: '.swiper-button-next',
        //             prevEl: '.swiper-button-prev'
        //         }
        //     });
        // }
        if($(".header__banner").find(".swiper-slide").length > 1) {
            var topBanner_swiper = new Swiper('.header__banner', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }

        const $banner = $('.header__banner');
        if($banner.length < 1) return;

        // const itemName = 'mobileTopBanner';
        // const _hideDate = localStorage.getItem(itemName) ? localStorage.getItem(itemName) : null;
        //
        // //banner check
        // const checkTopBanner = state => {
        //     const _day = 24 * 60 * 60 * 1000;   // h * m * s * ms
        //     if(_hideDate) {
        //         // has Date
        //         const _currentDate = new Date().getTime();
        //         if(_currentDate - _day > _hideDate) {
        //             localStorage.removeItem(itemName);
        //             $banner.show();
        //             $('body').addClass('has-banner');
        //         }else {
        //             $banner.hide();
        //             $('body').removeClass('has-banner');
        //         }
        //     }else if(state){
        //         // set Date
        //         localStorage.setItem(itemName, new Date().getTime());
        //         $banner.hide();
        //         $('body').removeClass('has-banner');
        //     }else {
        //         $banner.show();
        //         $('body').addClass('has-banner');
        //     }
        // }
        // checkTopBanner();

        function setCookie(name, value, expiredays) {

            var today = new Date();
            today.setDate(today.getDate() + expiredays);

            document.cookie = name + '=' + escape(value) + '; path=/; expires=' + today.toGMTString() + ';'

        };

        function getCookie(name)

        {

            var cName = name + "=";

            var x = 0;

            while ( i <= document.cookie.length )

            {

                var y = (x+cName.length);

                if ( document.cookie.substring( x, y ) == cName )

                {

                    if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )

                        endOfCookie = document.cookie.length;

                    return unescape( document.cookie.substring( y, endOfCookie ) );

                }

                x = document.cookie.indexOf( " ", x ) + 1;

                if ( x == 0 )

                    break;

            }

            return "";

        }

        if(document.cookie.indexOf("notToday=Y") >= 0) {
            $('body').removeClass('has-banner');
            $banner.hide();
        } else {
            $('body').addClass('has-banner');
            $banner.show();
        }


        $banner.find('.header__banner__close').on('click', function() {
            //checkTopBanner(true);
            setCookie('notToday','Y', 1);
            $('body').removeClass('has-banner');
            $banner.hide();

        });


    }

    // 최근본상품 레이어
    const popupRecentView = () => {
        $document.on('click', '.open-layer__recent-view', function() {
            $('body').find('.popup-layout').addClass('slide-animation-modal');

            let _title = $(this).data("title");

            if(typeof _title == 'undefined' || _title == '') {
               _title = '최근본상품';
                // _title = $(this).text();
            }

            setTimeout(function () {
                common.util.modal.open('ajax',_title, '/mypage/recentView', window.popupLayerFullSize);
            }, 1000)

        });
    }

    // full layer callback
    const fullLayer = () => {
        const $body = $('body');

        // 팝업 커스텀을 위한 콜백
        const popupLayerFullSize = () => {
            $body.find('.popup-layout').addClass('popup-layout--full');
            $body.find('.popup-layout .close, .popup-mask').off('click.popup-layout--full')
                .one('click.popup-layout--full', function() {
                    $body.find('.popup-layout').removeClass('popup-layout--full');
                });
        }
        window.popupLayerFullSize = popupLayerFullSize;
    }

    const checkSearchText = () => {
        const $searchInput = $('.search-input').not('.after');
        if($searchInput.length > 0 && $searchInput.val().length > 0) {
            $searchInput.val("");
        }
    }

    const lazyload = () =>{
        /*
         * {layoutCommon.templetSrc}/images/common/loading.gif 로딩 이미지 샘플
         * attribute : data-src
         * */
        const $target = $('img[data-src]');

        $target.Lazy({
            threshold: 50
        });
    };

    const checkHiddenArea = () => {
        if(window.top != window.self) {
            $('#header, #footer, .br__floating-btn').hide();
            $('#container').css('padding-top','2.5rem');
            /*window.top.postMessage({
             cmd: "contentHeight",
             contentHeight : $('#container').outerHeight() + parseInt($('body').css('padding-top')) + 1
             }, '*');*/
        }
        window.addEventListener("message", function(event) {
            const type = event.data.cmd;
            if(type != '' && type == 'scrollTop') {
                $(window).scrollTop(0);
            }
            /*if(type == 'contentHeight') {
             var cmsIframe = $('#cms__iframe');
             if(cmsIframe.length < 1) return ;
             cmsIframe.height(event.data.contentHeight);
             console.log(cmsIframe, event.data.contentHeight);

             }*/
        });
        $('.fb__floating__btn--top').on('click', function() {
            if($(window).find('iframe').length < 1) return ;
            $(window).find('iframe').get(0).constentWindow.window.postMessage({
                cmd: "scrollTop"
            }, '*');
        });
    }

    const layout_init = () => {
        drawer();
        layoutScroll();
        footer();
        popupRecentView();
        fullLayer();
        topBanner();
        checkSearchText();
        checkHiddenArea();
        lazyload();
        window.lazyload = lazyload;
    };

    layout_init();
}


export default front_layout;